<?php

namespace App\Http\Controllers;

use App\Models\CommercialInvoice;
use App\Models\CommercialInvoiceData;
use App\Models\PackingList;
use App\Models\PackingListData;
use App\Models\ContractLoadingContainer;
use App\Helpers\CommonHelper;
use App\Helpers\SalesHelper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PackingListController extends Controller
{
    /**
     * Show packing list form
     */
    public function createPackingList()
    {
        return view('Sales.packingListForm');
    }

    /**
     * Get commercial invoices for dropdown
     */
    public function getCommercialInvoicesForPackingList()
    {
        $commercialInvoices = CommercialInvoice::where('status', 1)
            ->orderBy('id', 'desc')
            ->get(['id', 'invoice_no', 'invoice_date']);

        return response()->json($commercialInvoices);
    }

    /**
     * Get commercial invoice details for packing list
     */
    public function getCommercialInvoiceDetailsForPackingList(Request $request)
    {
        $commercialInvoiceId = $request->commercial_invoice_id;

        $commercialInvoice = CommercialInvoice::with(['invoiceData', 'saleOrderExport', 'contractLoading.containers'])
            ->where('id', $commercialInvoiceId)
            ->where('status', 1)
            ->first();

        if (!$commercialInvoice) {
            return response()->json(['error' => 'Commercial invoice not found'], 404);
        }

        // Get invoice data with item names
        $invoiceData = $commercialInvoice->invoiceData->map(function($item) {
            $itemName = CommonHelper::get_item_name($item->item_id);
            $item->item_name = $itemName;
            return $item;
        });

        // Get containers grouped by item_id
        $containersByItem = [];
        if ($commercialInvoice->contractLoading && $commercialInvoice->contractLoading->containers) {
            foreach ($commercialInvoice->contractLoading->containers as $container) {
                $itemId = $container->item_id;
                if (!isset($containersByItem[$itemId])) {
                    $containersByItem[$itemId] = [];
                }
                $containersByItem[$itemId][] = [
                    'container_no' => $container->container_no ?? '',
                    'vehicle_no' => $container->vehicle_no ?? '',
                    'seal_no' => $container->seal_no ?? '',
                    'quantity' => $container->quantity ?? ''
                ];
            }
        }

        return response()->json([
            'commercial_invoice' => $commercialInvoice,
            'invoice_data' => $invoiceData,
            'containers_by_item' => $containersByItem
        ]);
    }

    /**
     * Store packing list
     */
    public function storePackingList(Request $request)
    {
        $request->validate([
            'commercial_invoice_id' => 'required|exists:mysql2.commercial_invoices,id',
            'date' => 'required|date'
        ]);

        DB::connection('mysql2')->beginTransaction();
        try {
            $commercialInvoice = CommercialInvoice::find($request->commercial_invoice_id);

            $packingList = new PackingList();
            $packingList->commercial_invoice_id = $request->commercial_invoice_id;
            $packingList->packing_list_no = SalesHelper::get_unique_packing_list_no();
            $packingList->invoice_no = $commercialInvoice->invoice_no;
            $packingList->date = $request->date;
            // GD No should always come from commercial invoice
            $packingList->gd_no = $commercialInvoice->gd_no ?? $request->gd_no;
            // Container no removed from master - it's now in items detail only
            $packingList->consignee_name = $request->consignee_name ?? $commercialInvoice->consignee_name;
            $packingList->vessel_voyage = $request->vessel_voyage ?? $commercialInvoice->vessel_voyage;
            $packingList->port_from = $request->port_from ?? $commercialInvoice->port_from;
            $packingList->payment_term = $request->payment_term ?? $commercialInvoice->payment_term;
            $packingList->status = 1;
            $packingList->save();

            // Save packing list data items and calculate total gross weight
            $totalGrossWeight = 0;
            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $item) {
                    $itemGrossKgs = $item['total_gross_kgs'] ?? 0;
                    $totalGrossWeight += $itemGrossKgs;
                    
                    PackingListData::create([
                        'packing_list_id' => $packingList->id,
                        'commercial_invoice_data_id' => $item['commercial_invoice_data_id'] ?? null,
                        'item_id' => $item['item_id'] ?? null,
                        'description' => $item['description'] ?? '',
                        'grade_size' => $item['grade_size'] ?? '',
                        'total_cartons' => $item['total_cartons'] ?? 0,
                        'total_net_kgs' => $item['total_net_kgs'] ?? 0,
                        'total_gross_kgs' => $itemGrossKgs,
                        'status' => 1
                    ]);
                }
            }
            
            // Update gross weight from sum of items
            $packingList->gross_weight = $request->gross_weight ?? $totalGrossWeight;
            $packingList->save();

            DB::connection('mysql2')->commit();
            return response()->json(['success' => true, 'message' => 'Packing list created successfully', 'packing_list_id' => $packingList->id]);
        } catch (Exception $ex) {
            DB::connection('mysql2')->rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $ex->getMessage()], 500);
        }
    }

    /**
     * Show packing list list
     */
    public function packingListList()
    {
        return view('Sales.packingListList');
    }

    /**
     * Get packing list filter data
     */
    public function getPackingListFilter(Request $request)
    {
        $query = PackingList::join('commercial_invoices', 'commercial_invoices.id', 'packing_lists.commercial_invoice_id')
            ->where('packing_lists.status', 1)
            ->select(
                'packing_lists.*',
                'commercial_invoices.invoice_no as commercial_invoice_no',
                'commercial_invoices.invoice_date as commercial_invoice_date'
            );

        if (!empty($request->packing_list_no)) {
            $query->where('packing_lists.packing_list_no', 'LIKE', '%' . $request->packing_list_no . '%');
        }

        if (!empty($request->commercial_invoice_no)) {
            $query->where('commercial_invoices.invoice_no', 'LIKE', '%' . $request->commercial_invoice_no . '%');
        }

        if (!empty($request->from)) {
            $query->where('packing_lists.date', '>=', $request->from);
        }

        if (!empty($request->to)) {
            $query->where('packing_lists.date', '<=', $request->to);
        }

        $packing_lists = $query->orderBy('packing_lists.id', 'desc')->get();
        $m = Session::get('run_company');

        return view('Sales.AjaxPages.packingListListAjax', compact('packing_lists', 'm'));
    }

    /**
     * View packing list
     */
    public function viewPackingList(Request $request)
    {
        $id = $request->id;

       
        $packingList = PackingList::with(['commercialInvoice.contractLoading.containers', 'packingListData'])
            ->where('id', $id)
            ->where('status', 1)
            ->first();

        if (!$packingList) {
            return response('<div class="alert alert-danger">Packing list not found</div>', 404);
        }

        // Get containers grouped by item_id
        $containersByItem = [];
        if ($packingList->commercialInvoice && $packingList->commercialInvoice->contractLoading && $packingList->commercialInvoice->contractLoading->containers) {
            foreach ($packingList->commercialInvoice->contractLoading->containers as $container) {
                $itemId = $container->item_id;
                if (!isset($containersByItem[$itemId])) {
                    $containersByItem[$itemId] = [];
                }
                $containersByItem[$itemId][] = $container;
            }
        }

        return view('Sales.AjaxPages.viewPackingList', compact('packingList', 'containersByItem'));
    }

    /**
     * View packing list for printing
     */
    public function viewPackingListPrint(Request $request)
    {
        $id = $request->id;

        if (!$id) {
            return redirect()->route('packingListList')->with('error', 'Packing list ID is required');
        }

        $packingList = PackingList::with(['commercialInvoice.contractLoading.containers', 'packingListData'])
            ->where('id', $id)
            ->where('status', 1)
            ->first();

        if (!$packingList) {
            return redirect()->route('packingListList')->with('error', 'Packing list not found');
        }

        // Get containers grouped by item_id
        $containersByItem = [];
        if ($packingList->commercialInvoice && $packingList->commercialInvoice->contractLoading && $packingList->commercialInvoice->contractLoading->containers) {
            foreach ($packingList->commercialInvoice->contractLoading->containers as $container) {
                $itemId = $container->item_id;
                if (!isset($containersByItem[$itemId])) {
                    $containersByItem[$itemId] = [];
                }
                $containersByItem[$itemId][] = $container;
            }
        }

        return view('Sales.viewPackingListPrint', compact('packingList', 'containersByItem'));
    }

    /**
     * Edit packing list form
     */
    public function editPackingList(Request $request)
    {
        $id = $request->id;

        $packingList = PackingList::with(['commercialInvoice.invoiceData', 'packingListData'])
            ->where('id', $id)
            ->first();

        if (!$packingList) {
            return redirect()->route('packingListList')->with('error', 'Packing list not found');
        }

        return view('Sales.packingListForm', compact('packingList'));
    }

    /**
     * Update packing list
     */
    public function updatePackingList(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:mysql2.packing_lists,id',
            'date' => 'required|date'
        ]);

        DB::connection('mysql2')->beginTransaction();
        try {
            $packingList = PackingList::find($request->id);

            if (!$packingList) {
                return response()->json(['success' => false, 'message' => 'Packing list not found'], 404);
            }

            $packingList->date = $request->date;
            // GD No should always come from commercial invoice
            $commercialInvoice = CommercialInvoice::find($packingList->commercial_invoice_id);
            if ($commercialInvoice) {
                $packingList->gd_no = $commercialInvoice->gd_no ?? $request->gd_no;
            } else {
                $packingList->gd_no = $request->gd_no;
            }
            // Container no removed from master - it's now in items detail only
            $packingList->consignee_name = $request->consignee_name;
            $packingList->vessel_voyage = $request->vessel_voyage;
            $packingList->port_from = $request->port_from;
            $packingList->payment_term = $request->payment_term;
            $packingList->save();

            // Delete existing packing list data (soft delete)
            PackingListData::where('packing_list_id', $packingList->id)->update(['status' => 0]);

            // Save new packing list data items and calculate total gross weight
            $totalGrossWeight = 0;
            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $item) {
                    $itemGrossKgs = $item['total_gross_kgs'] ?? 0;
                    $totalGrossWeight += $itemGrossKgs;
                    
                    PackingListData::create([
                        'packing_list_id' => $packingList->id,
                        'commercial_invoice_data_id' => $item['commercial_invoice_data_id'] ?? null,
                        'item_id' => $item['item_id'] ?? null,
                        'description' => $item['description'] ?? '',
                        'grade_size' => $item['grade_size'] ?? '',
                        'total_cartons' => $item['total_cartons'] ?? 0,
                        'total_net_kgs' => $item['total_net_kgs'] ?? 0,
                        'total_gross_kgs' => $itemGrossKgs,
                        'status' => 1
                    ]);
                }
            }
            
            // Update gross weight from sum of items
            $packingList->gross_weight = $request->gross_weight ?? $totalGrossWeight;
            $packingList->save();

            DB::connection('mysql2')->commit();
            return response()->json(['success' => true, 'message' => 'Packing list updated successfully', 'packing_list_id' => $packingList->id]);
        } catch (Exception $ex) {
            DB::connection('mysql2')->rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $ex->getMessage()], 500);
        }
    }

    /**
     * Delete packing list
     */
    public function deletePackingList(Request $request)
    {
        DB::connection('mysql2')->beginTransaction();
        try {
            $packingList = PackingList::find($request->id);
            if ($packingList) {
                $packingList->status = 0;
                $packingList->save();

                // Also delete related data
                PackingListData::where('packing_list_id', $packingList->id)->update(['status' => 0]);

                DB::connection('mysql2')->commit();
                return $request->id;
            } else {
                DB::connection('mysql2')->rollBack();
                return '0';
            }
        } catch (Exception $ex) {
            DB::connection('mysql2')->rollBack();
            return '0';
        }
    }
}
