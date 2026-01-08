<?php

namespace App\Http\Controllers;

use App\Models\ExportBillOfLading;
use App\Models\ExportBolNotify;
use App\Models\ExportCommercialNotifyAddress;
use App\Models\ExportInvoice;
use App\Models\ExportPakingList;
use App\Models\ExportPakingListData;
use App\Models\SaleOrderExport;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExportBillOfLadingController extends Controller
{
    function packagingListForCreateBillOfLading()
    {
        return view('export.billoflading.packagingListForCreateBillOfLading');
    }
    function packagingListForCreateBillOfLadingAjax(Request $request)
    {
        $query = ExportPakingList::join('export_invoices', 'export_invoices.id', 'export_paking_lists.invoice_id')
            ->select('export_invoices.commercial_invoice_no', 'export_paking_lists.*')
            ->where('export_paking_lists.status', 1);
        if (!empty($request->packing_list_no)) {
            $query->where('export_paking_lists.import_no', 'LIKE', '%' . $request->packing_list_no . '%');
        }
        if (!empty($request->commercial)) {
            $query->where('export_invoices.commercial_invoice_no', 'LIKE', '%' . $request->commercial . '%');
        }

        $exportpakingList =   $query->orderBy('id', 'desc')->get();

        return view('export.billoflading.packagingListForCreateBillOfLadingAjax', compact('exportpakingList'));
    }

    function createBillOfLading($id)
    {
        $packaging = ExportPakingList::find($id);
        $packagingDataSum =  ExportPakingListData::select(DB::raw('sum(net_weight) as net_weight'), DB::raw('sum(gross_weight) as gross_weight'))->where('import_paking_list_id', $id)->where('status', 1)->first();
        $packagingData = ExportPakingListData::where('import_paking_list_id', $id)->where('status', 1)->get();
        $exportInvoice =  ExportInvoice::find($packaging->invoice_id);
        $invoiceNotify =  ExportCommercialNotifyAddress::where('commercial_invoice_id', $packaging->invoice_id)->where('status', 1)->get();
        // dd($invoiceNotify);
        $sales_order = SaleOrderExport::join('export_performas', 'export_performas.sale_order_id', 'sale_order_exports.id')
            ->select('sale_order_exports.*', 'export_performas.pro_contract_no')
            ->where('sale_order_exports.id', $exportInvoice->sale_order_export_id)->first();
        return view('export.billoflading.createBillOfLading', compact('packaging', 'packagingDataSum', 'exportInvoice', 'packagingData', 'sales_order', 'invoiceNotify'));
    }

    function editBillOfLading($id)
    {
        $bol = ExportBillOfLading::with('bol_notify')->find($id);
        $packaging = ExportPakingList::find($bol->packaging_id);
        $packagingDataSum =  ExportPakingListData::select(DB::raw('sum(net_weight) as net_weight'), DB::raw('sum(gross_weight) as gross_weight'))->where('import_paking_list_id', $id)->where('status', 1)->first();
        $packagingData = ExportPakingListData::where('import_paking_list_id', $bol->packaging_id)->where('status', 1)->get();
        $exportInvoice =  ExportInvoice::find($packaging->invoice_id);
        $invoiceNotify =  ExportCommercialNotifyAddress::where('commercial_invoice_id', $packaging->invoice_id)->where('status', 1)->get();
        // dd($bol);
        $sales_order = SaleOrderExport::join('export_performas', 'export_performas.sale_order_id', 'sale_order_exports.id')
            ->select('sale_order_exports.*', 'export_performas.pro_contract_no')
            ->where('sale_order_exports.id', $exportInvoice->sale_order_export_id)->first();
        return view('export.billoflading.editBillOfLading', compact('bol','packaging', 'packagingDataSum', 'exportInvoice', 'packagingData', 'sales_order', 'invoiceNotify'));
    }

    function storeBillOfLading(Request $request)
    {
        // dd($request->all());
        DB::Connection('mysql2')->beginTransaction();
        try {
            // $bol = bill_
            $bol = new ExportBillOfLading();
            $bol->voucher_no = $request->voucher_no;
            $bol->voucher_date = $request->voucher_date;
            $bol->packaging_id = $request->packaging_id;
            $bol->name_of_shipper = $request->name_of_shipper;
            $bol->description = $request->bol_description;
            $bol->booking_no = $request->booking_no;
            $bol->forwarder = $request->forwarder;
            $bol->consignee = $request->consignee;
            $bol->username = Auth::user()->name;
            $bol->status = 1;
            $bol->save();
            foreach ($request->notify_address ?? [] as $key => $value) {
                if (!empty($value)) {
                    ExportBolNotify::create([
                        'bol_id' => $bol->id,
                        'notify_detail' => $value,
                    ]);
                }
            }
            DB::Connection('mysql2')->commit();
            return redirect()->route('billOfLadingList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }

    function updateBillOfLading(Request $request , $id)
    {
        // dd($id);
        DB::Connection('mysql2')->beginTransaction();
        try {
            // $bol = bill_
            $bol = ExportBillOfLading::find($id);
            // $bol->voucher_no = $request->voucher_no;
            $bol->voucher_date = $request->voucher_date;
            $bol->packaging_id = $request->packaging_id;
            $bol->name_of_shipper = $request->name_of_shipper;
            $bol->description = $request->bol_description;
            $bol->booking_no = $request->booking_no;
            $bol->forwarder = $request->forwarder;
            $bol->consignee = $request->consignee;
            // $bol->username = Auth::user()->name;
            // $bol->status = 1;
            $bol->save();
            ExportBolNotify::where('bol_id' , $id)->delete();
            foreach ($request->notify_address ?? [] as $key => $value) {
                if (!empty($value)) {
                    ExportBolNotify::create([
                        'bol_id' => $id,
                        'notify_detail' => $value,
                    ]);
                }
            }
            DB::Connection('mysql2')->commit();
            return redirect()->route('billOfLadingList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }

    function billOfLadingList()
    {
        return view('export.billoflading.billOfLadingList');
    }

    function billOfLadingListAjax(Request $request)
    {
        $billOfLadings = ExportBillOfLading::join('export_paking_lists', 'export_paking_lists.id', 'export_bill_of_ladings.packaging_id')
            ->join('export_invoices', 'export_invoices.id', 'export_paking_lists.invoice_id')
            ->select('export_bill_of_ladings.*', 'export_invoices.commercial_invoice_no', 'export_paking_lists.import_no')
            ->where('export_bill_of_ladings.status', 1)
            ->orderBy('export_bill_of_ladings.id', 'desc')->get();
        return view('export.billoflading.billOfLadingListAjax', compact('billOfLadings'));
    }

    function viewBillOfLadingDetail(Request $request)
    {
        $bol = ExportBillOfLading::find($request->id);

        // $pakinglist =  ExportPakingList::join('export_invoices', 'export_invoices.id', 'export_paking_lists.invoice_id')
        //     ->join('sale_order_exports', 'sale_order_exports.id', 'export_invoices.sale_order_export_id')
        //     ->join('customers', 'customers.id', 'sale_order_exports.buyer_id')
        //     ->where(['export_paking_lists.id' => $bol->packaging_id, 'export_paking_lists.status' => 1])
        //     ->first();
        $pakinglist = DB::connection('mysql2')->table('export_paking_lists as epl')
            ->join('export_invoices as ei', 'ei.id', 'epl.invoice_id')
            ->join('sale_order_exports as soe', 'soe.id', 'ei.sale_order_export_id')
            ->join('customers', 'customers.id', 'soe.buyer_id')
            ->where(['epl.id' => $bol->packaging_id, 'epl.status' => 1])
            ->first();
        //echo '<pre>'.$pakinglist.'</pre>';
        //die;

        $pakinglistdata =  ExportPakingListData::where('import_paking_list_id', $bol->packaging_id)
            ->join('export_invoice_datas', 'export_invoice_datas.id', 'export_paking_list_datas.invoice_data_id')
            ->join('sale_order_data_exports', 'sale_order_data_exports.id', 'export_invoice_datas.sale_order_export_data_id')
            ->join('subitem', 'subitem.id', 'sale_order_data_exports.item_id')
            ->select(
                'subitem.sub_ic',
                'subitem.pack_size',
                'subitem.pack_type',
                'export_paking_list_datas.net_weight',
                'export_paking_list_datas.gross_weight',
                'export_paking_list_datas.qty as paking_qty',
                'export_paking_list_datas.container',
                'sale_order_data_exports.uom_id',
            )
            ->get();
        //print_r($pakinglist);
        $bol_notify = ExportBolNotify::where('bol_id', $request->id)->get();
        return view('export.invoice.Ajaxpages.billOfLoading', compact('pakinglist', 'pakinglistdata', 'bol_notify', 'bol'));
    }
}
