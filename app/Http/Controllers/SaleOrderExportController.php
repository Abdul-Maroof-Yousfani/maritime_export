<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\ExportOrderConsignee;
use App\Models\ExportOrderNotify;
use App\Models\IncoTerm;
use App\Models\ModeOfTerm;
use App\Models\ModeOfTransport;
use App\Models\Port;
use App\Models\Origin;
use App\Models\Consignee;
use App\Models\Grade;
use App\Models\Size;
use App\Models\Packing;
use App\Models\PrintingBags;
use App\Models\SaleOrderExport;
use App\Models\SaleOrderDataExport;
use App\Models\SaleOrderExportAttachment;
use App\Models\Transactions;
use App\Models\ContractLoading;
use App\Models\ContractLoadingData;
use App\Models\ContractLoadingAttachment;
use App\Models\ContractLoadingContainer;
use App\Models\ContractLoadingVehicle;
use App\Models\CommercialInvoice;
use App\Models\CommercialInvoiceData;
use App\Models\Subitem;
use App\Helpers\FinanceHelper;
use App\Helpers\CommonHelper;
use App\Helpers\SalesHelper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SaleOrderExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saleOrderList()

    {
        return view('Sales.saleOrderList');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleOrderExport  $saleOrderExport
     * @return \Illuminate\Http\Response
     */
    public function getSalesOrderfilter(Request $request)
    {

        $query =  SaleOrderExport::select('sale_order_exports.*', 'customers.name as name')
            ->join('customers', 'customers.id', 'sale_order_exports.buyer_id')
            ->where('sale_order_exports.status', 1);

        if (!empty($request->EoNo)) {
            $query->where('voucehr_no', 'LIKE', '%' . $request->EoNo . '%');
        }
        if (!empty($request->contract)) {
            $query->where('contract_no', 'LIKE', '%' . $request->contract . '%');
        }
        $sale_order = $query->orderBy('id', 'desc')->get();
        $m = Session::get('run_company');
        return view('Sales.AjaxPages.saleOrderListAjax', compact('sale_order', 'm'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saleOrderStore(Request $request)
    {
        $request['due_date'] = $request['due_date'] . '-01';
        $request['delevery_date_to'] = $request['delevery_date_to'] . '-28';
        DB::Connection('mysql2')->beginTransaction();
        try {
            $sale_order = new SaleOrderExport;
            // Auto-generate export order number in format ST2526-001
            $sale_order->voucehr_no = SalesHelper::get_unique_export_order_no();
            $sale_order->contract_no = $request->contract_no;
            $sale_order->voucher_date = $request->voucher_date;
            $sale_order->voucher_type = 0;
            $sale_order->buyer_id = $request->buyers_id; //??1;
            $sale_order->tolerance_percentage = $request->tolerance_percentage;
            $sale_order->buyers_ntn = $request->buyers_ntn ?? 1;
            $sale_order->mode_of_term = $request->mode_of_term;
            $sale_order->incoterm = $request->incoterm ? (int)$request->incoterm : null;
            $sale_order->origin = $request->origin ? (int)$request->origin : null;
            $sale_order->port = $request->port ? (int)$request->port : null;
            $sale_order->grade = $request->grade ? (int)$request->grade : null;
            $sale_order->size = $request->size ? (int)$request->size : null;
            $sale_order->packing = $request->packing ? (int)$request->packing : null;
            $sale_order->bank = $request->beneficiary_bank ?? 1;
            $sale_order->proforma_status = 0;
            $sale_order->advance_amount = $request->advance_amount ?? 0;
            $sale_order->mode_of_production = $request->mode_of_production ?? null;
            $sale_order->currencey_id = $request->rate_conversion;
            $sale_order->currencey_rate = $request->rate_of_conversion;
            $sale_order->mode_transport = $request->mode_transport ? (int)$request->mode_transport : null;
           
            $sale_order->consignee = $request->consignee ? (int)$request->consignee : null;
            $sale_order->save();

            // Handle attachments (multiple files)
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    if (!$file) {
                        continue;
                    }

                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $size = $file->getSize();

                    $fileName = time() . '_' . uniqid() . '.' . $extension;
                    // Store in public disk under sale_order_export_attachments
                    $path = $file->storeAs('sale_order_export_attachments', $fileName, 'public');

                    SaleOrderExportAttachment::create([
                        'sale_order_export_id' => $sale_order->id,
                        'file_name'            => $fileName,
                        'original_name'        => $originalName,
                        'file_path'            => $path,
                        'file_type'            => $extension,
                        'file_size'            => $size,
                        'description'          => null,
                        'status'               => 1,
                    ]);
                }
            }

            //    dd($request->all());
            foreach ($request->sub_ic_des as $key => $value) {
                $sale_order_data = new SaleOrderDataExport;
                $sale_order_data->sale_order_export_id = $sale_order->id;
                $sale_order_data->item_id = $request->sub_ic_des[$key];
                $sale_order_data->uom_id = $request->uom_id[$key];
                $sale_order_data->item_size = $request->item_size[$key] ?? null;
                $sale_order_data->quality = $request->quality[$key] ?? null;
                $sale_order_data->pack_type = $request->pack_type[$key] ?? null;
                $sale_order_data->bag_type = $request->bag_type[$key] ?? null;
                $sale_order_data->color = $request->bag_color[$key] ?? null;
                $sale_order_data->pack_size = $request->pack_size[$key];
                $sale_order_data->pack_uom = $request->pack_uom[$key] ?? null;

                $sale_order_data->total_qty = $request->total_qty[$key];
                $sale_order_data->actual_qty = $request->actual_qty[$key];
                $sale_order_data->flc_size = 0;//$request->flc_size[$key] ?? null;
                $sale_order_data->flc_qty = 0;//$request->flc_qty[$key] ?? null;
                $sale_order_data->no_of_container = 0;//$request->no_of_container[$key] ?? null;

                $sale_order_data->qty_variation = 0;//$request->qty_variation[$key] ?? null;
                $sale_order_data->rate = $request->rate[$key];
                $sale_order_data->amount = $request->amount[$key];
                $sale_order_data->tax = 0;//$request->tax_rate[$key] ?? null;
                $sale_order_data->tax_amount = 0;//$request->tax_amount[$key] ?? null;
                $sale_order_data->after_dis_amount = $request->after_dis_amount[$key] ?? null;
                $sale_order_data->sales_total = $request->after_dis_amount[$key] ?? null;
                $sale_order_data->save();
            }
            
            DB::Connection('mysql2')->commit();
            return redirect()->route('saleOrderList');

            return $request->id;
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SaleOrderExport  $saleOrderExport
     * @return \Illuminate\Http\Response
     */
    public function edit(SaleOrderExport $saleOrderExport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleOrderExport  $saleOrderExport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleOrderExport $saleOrderExport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleOrderExport  $saleOrderExport
     * @return \Illuminate\Http\Response
     */
    public function deleteSalesOrder(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {

            $data['status'] = 0;
            DB::Connection('mysql2')->table('sale_order_exports')->where('id', $request->id)->update($data);
            DB::Connection('mysql2')->table('sale_order_data_exports')->where('sale_order_export_id', $request->id)->update($data);

            DB::Connection('mysql2')->commit();
            return $request->id;
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }


    public  function viewSalesOrderDetail(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $sales_order = new SaleOrderExport();
        $sales_order = $sales_order->SetConnection('mysql2');
        $sales_order = $sales_order->where('id', $id)->first();


        $sales_order_data = new SaleOrderDataExport();
        $sales_order_data = $sales_order_data->SetConnection('mysql2');
        $sales_order_data =  $sales_order_data->where('sale_order_export_id', $id)->where('status', 1)->get();

        // Load attachments
        $attachments = SaleOrderExportAttachment::where('sale_order_export_id', $id)
            ->where('status', 1)
            ->get();
        
        // Separate advance payment attachments (description = 'Advance Payment Receipt')
        $advanceAttachments = $attachments->filter(function($attachment) {
            return $attachment->description === 'Advance Payment Receipt';
        });
        
        // Regular attachments (excluding advance payment attachments)
        $regularAttachments = $attachments->filter(function($attachment) {
            return $attachment->description !== 'Advance Payment Receipt';
        });

        return view('Sales.AjaxPages.viewSalesOrderDetailExport', compact('sales_order', 'sales_order_data', 'attachments', 'advanceAttachments', 'regularAttachments'));
    }

    public function updateApprovedStatus(Request $request)
    {

        DB::Connection('mysql2')->beginTransaction();
        try {
            

            $data['approved_status'] = 1;
            // $data['contract_no']=$contract;
            DB::Connection('mysql2')->table('sale_order_exports')->where('id', $request->id)->update($data);
            DB::Connection('mysql2')->commit();
            return $request->id;
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }

    public function viewSaleExportVoucher(Request $request)
    {
        $id = $request->id;
        $sales_order = SaleOrderExport::join('customers', 'customers.id', 'sale_order_exports.buyer_id')
            ->select('sale_order_exports.*', 'customers.name', 'customers.address')
            ->where('sale_order_exports.id', $id)
            ->first();


        $sales_order_data = SaleOrderDataExport::where('sale_order_data_exports.sale_order_export_id', $id)
            ->select('sale_order_data_exports.*', 'subitem.sub_ic')
            ->join('subitem', 'subitem.id', 'sale_order_data_exports.item_id')
            ->where('sale_order_data_exports.status', 1)
            ->get();

        // Load attachments for this sale order
        $attachments = SaleOrderExportAttachment::where('sale_order_export_id', $id)
            ->where('status', 1)
            ->get();

        return view('Sales.AjaxPages.viewSaleExportVoucher', compact('sales_order', 'sales_order_data', 'attachments'));
    }


    public function saleOrderEdit(Request $request)
    {
        $exportOrder = SaleOrderExport::find($request->id);
        $exportOrderData = SaleOrderDataExport::where('sale_order_export_id', $request->id)->where('status', 1)->get();
        $incoterms =  IncoTerm::all();
        $modeofterms =  ModeOfTerm::all();
        $modeoftransports =  ModeOfTransport::all();
        $conversions = Currency::where('status', 1)->get();
        $banks = Bank::where('status', 1)->wherenull('beneficiary_id')->get();
        $customers = Customer::where(['status' => 1, 'purchaser_type' => 2])->get();
        $printingBags = PrintingBags::select('printing_bags')->where('status', 1)->groupBy('printing_bags')->get();
        $ports = Port::all();
        $origins = Origin::all();
        $consignees = Consignee::all();
        $grades = Grade::all();
        $sizes = Size::all();
        $packings = Packing::all();
        return view('export.sales.saleOrderEdit', compact('exportOrder', 'exportOrderData', 'incoterms', 'printingBags', 'modeofterms', 'modeoftransports', 'conversions', 'banks', 'customers', 'ports', 'origins', 'consignees', 'grades', 'sizes', 'packings'));
    }


    public function saleOrderUpdateDetail(Request $request)
    {
        $request['due_date'] = $request['due_date'] . '-01';
        $request['delevery_date_to'] = $request['delevery_date_to'] . '-28';
        //   dd($request->all());
        DB::Connection('mysql2')->beginTransaction();
        try {
            $sale_order = SaleOrderExport::find($request->id);
            // $sale_order->voucehr_no = $request->voucher_no;
            $sale_order->contract_no = $request->contract_no;
            $sale_order->voucher_date = $request->voucher_date;
            $sale_order->voucher_type = 0;
            $sale_order->buyer_id = $request->buyers_id; //??1;
            $sale_order->buyers_ntn = $request->buyers_ntn ?? 1;
            $sale_order->mode_of_term = $request->mode_of_term;
            $sale_order->tolerance_percentage = $request->tolerance_percentage;
            $sale_order->due_date = $request->due_date ?? date('Y-m-d');
            $sale_order->incoterm = $request->incoterm ? (int)$request->incoterm : null;
            $sale_order->origin = $request->origin ? (int)$request->origin : null;
            $sale_order->port = $request->port ? (int)$request->port : null;
            $sale_order->grade = null;// $request->grade ? (int)$request->grade : null;
            $sale_order->size = null;// $request->size ? (int)$request->size : null;
            $sale_order->packing = null;// $request->packing ? (int)$request->packing : null;
            $sale_order->bank = $request->beneficiary_bank ?? 1;
            $sale_order->proforma_status = 0;
            $sale_order->advance_amount = $request->advance_amount ?? 0;
            $sale_order->mode_of_production = $request->mode_of_production ?? null;
            $sale_order->payment_days = $request->payment_days;
            $sale_order->currencey_id = $request->rate_conversion;
            $sale_order->currencey_rate = $request->rate_of_conversion;
            $sale_order->mode_transport = $request->mode_transport ? (int)$request->mode_transport : null;
           
            $sale_order->consignee = $request->consignee ? (int)$request->consignee : null;
            $sale_order->save();

            ExportOrderNotify::where('export_order_id', $sale_order->id)->delete();      
            if ($request->has('notify_party_details') && is_array($request->notify_party_details)) {
                foreach ($request->notify_party_details as $key => $notify_party_details) {
                    if (!empty($notify_party_details)) {
                        ExportOrderNotify::create([
                            'notify' => $notify_party_details,
                            'export_order_id' => $sale_order->id
                        ]);
                    }
                }
            }

            SaleOrderDataExport::where('sale_order_export_id', $sale_order->id)->update(['status'=>0]);            
            //    dd($request->all());
            foreach ($request->sub_ic_des as $key => $value) {
                $sale_order_data = new SaleOrderDataExport;
                $sale_order_data->sale_order_export_id = $sale_order->id;
                $sale_order_data->item_id = $request->sub_ic_des[$key];
                $sale_order_data->uom_id = $request->uom_id[$key];
                $sale_order_data->item_size = $request->item_size[$key] ?? null;
                $sale_order_data->quality = $request->quality[$key] ?? null;
                $sale_order_data->pack_type = $request->pack_type[$key] ?? null;
                $sale_order_data->bag_type = $request->bag_type[$key] ?? null;
                $sale_order_data->color = $request->bag_color[$key] ?? null;
                $sale_order_data->pack_size = $request->pack_size[$key];
                $sale_order_data->pack_uom = $request->pack_uom[$key] ?? null;

                $sale_order_data->total_qty = $request->total_qty[$key];
                $sale_order_data->actual_qty = $request->actual_qty[$key];
                $sale_order_data->flc_size = $request->flc_size[$key] ?? null;
                $sale_order_data->flc_qty = $request->flc_qty[$key] ?? null;
                $sale_order_data->no_of_container = 0;//$request->no_of_container[$key] ?? null;

                $sale_order_data->qty_variation = $request->qty_variation[$key] ?? null;
                $sale_order_data->rate = $request->rate[$key];
                $sale_order_data->amount = $request->amount[$key];
                $sale_order_data->tax = $request->tax_rate[$key] ?? null;
                $sale_order_data->tax_amount = $request->tax_amount[$key] ?? null;
                $sale_order_data->after_dis_amount = $request->after_dis_amount[$key] ?? null;
                $sale_order_data->sales_total = $request->after_dis_amount[$key] ?? null;
                $sale_order_data->save();
            }
            DB::Connection('mysql2')->commit();
            return redirect()->route('saleOrderList');

            return $request->id;
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }

    /**
     * Get sale order details for receiving advance payment
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSaleOrderForAdvance(Request $request)
    {
        $saleOrder = SaleOrderExport::find($request->id);
        
        if (!$saleOrder) {
            return response()->json(['error' => 'Sale order not found'], 404);
        }
        
        $customer = Customer::find($saleOrder->buyer_id);
        $bank = Bank::find($saleOrder->bank);
        
        return view('Sales.AjaxPages.receiveAdvancePayment', compact('saleOrder', 'customer', 'bank'));
    }

    /**
     * Receive advance payment and create GL entries
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function receiveAdvancePayment(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
            $saleOrder = SaleOrderExport::find($request->sale_order_id);
            
            if (!$saleOrder) {
                return response()->json(['success' => false, 'message' => 'Sale order not found'], 404);
            }
            
            // Use advance_amount from sale order (stored in form)
            $advance_amount = $saleOrder->advance_amount ?? 0;
            $exchangeRate = $saleOrder->currencey_rate ?? 1;
            $advance_amount_in_base_currency = $advance_amount * $exchangeRate;
            if ($advance_amount <= 0) {
                return response()->json(['success' => false, 'message' => 'Advance amount must be greater than 0'], 400);
            }
            
            // Get customer acc_id and liability_acc_id
            $customer = Customer::find($saleOrder->buyer_id);
            $liability_acc_id = $customer->liability_acc_id ?? null;
            
            // Use liability_acc_id if available, otherwise fall back to customer acc_id
            $credit_acc_id = $liability_acc_id ?? 0;
            
            // Get bank acc_id from banks table
            $bank = Bank::find($saleOrder->bank);
            $bank_acc_id = $bank->acc_id ?? null;
            
            // If bank doesn't have acc_id, try to get from accounts table based on bank name
            
            
            if (!$credit_acc_id) {
                return response()->json(['success' => false, 'message' => 'Customer account ID not found'], 400);
            }
            
            if (!$bank_acc_id) {
                return response()->json(['success' => false, 'message' => 'Bank account ID not found'], 400);
            }
            
            // dd($bank_acc_id, $credit_acc_id);
            // Generate unique voucher number for advance payment
            $advance_voucher_no = $saleOrder->voucehr_no . '-ADV-' . date('YmdHis');
            
            // Liability Account Credit Entry (Customer advance payment liability)
            $transaction_customer = new Transactions();
            $transaction_customer = $transaction_customer->SetConnection('mysql2');
            $transaction_customer->voucher_no = $advance_voucher_no;
            $transaction_customer->v_date = date('Y-m-d');
            $transaction_customer->acc_id = $credit_acc_id;
            $transaction_customer->acc_code = FinanceHelper::getAccountCodeByAccId($credit_acc_id);
            $transaction_customer->particulars = 'Advance Payment Received - ' . $saleOrder->voucehr_no;
            $transaction_customer->opening_bal = 0;
            $transaction_customer->debit_credit = 0; // Credit - customer paying
            $transaction_customer->amount = $advance_amount_in_base_currency;
            $transaction_customer->username = Auth::user()->name;
            $transaction_customer->status = 1;
            $transaction_customer->voucher_type = 21; // Export Sale Order voucher type
            $transaction_customer->master_id = $saleOrder->id;
            $transaction_customer->save();
            
            // Bank Debit Entry (Money coming into bank)
            $transaction_bank = new Transactions();
            $transaction_bank = $transaction_bank->SetConnection('mysql2');
            $transaction_bank->voucher_no = $advance_voucher_no;
            $transaction_bank->v_date = date('Y-m-d');
            $transaction_bank->acc_id = $bank_acc_id;
            $transaction_bank->acc_code = FinanceHelper::getAccountCodeByAccId($bank_acc_id);
            $transaction_bank->particulars = 'Advance Payment Received - ' . $saleOrder->voucehr_no;
            $transaction_bank->opening_bal = 0;
            $transaction_bank->debit_credit = 1; // Debit - money coming in
            $transaction_bank->amount = $advance_amount_in_base_currency;
            $transaction_bank->username = Auth::user()->name;
            $transaction_bank->status = 1;
            $transaction_bank->voucher_type = 21; // Export Sale Order voucher type
            $transaction_bank->master_id = $saleOrder->id;
            $transaction_bank->save();

            $saleOrder->advance_amount = $advance_amount;
            $saleOrder->advance_received_status = 1; // Mark advance as received
            $saleOrder->save();
            
            // Handle attachments (optional, multiple files)
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    if (!$file) {
                        continue;
                    }

                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $size = $file->getSize();

                    $fileName = time() . '_' . uniqid() . '.' . $extension;
                    // Store in public disk under sale_order_export_attachments
                    $path = $file->storeAs('sale_order_export_attachments', $fileName, 'public');

                    SaleOrderExportAttachment::create([
                        'sale_order_export_id' => $saleOrder->id,
                        'file_name'            => $fileName,
                        'original_name'        => $originalName,
                        'file_path'            => $path,
                        'file_type'            => $extension,
                        'file_size'            => $size,
                        'description'          => 'Advance Payment Receipt',
                        'status'               => 1,
                    ]);
                }
            }
            
            DB::Connection('mysql2')->commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Advance payment received successfully',
                'voucher_no' => $advance_voucher_no
            ]);
            
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $ex->getMessage()
            ], 500);
        }
    }

    /**
     * Print sale order items
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function printSaleOrderItems(Request $request)
    {
        $saleOrder = SaleOrderExport::find($request->id);
        
        if (!$saleOrder) {
            return redirect()->back()->with('error', 'Sale order not found');
        }
        
        // Get sale order items with item details
        $saleOrderItems = SaleOrderDataExport::where('sale_order_export_id', $saleOrder->id)
            ->where('status', 1)
            ->with('item')
            ->get();
        
        // Get customer/buyer details
        $customer = Customer::find($saleOrder->buyer_id);
        
        // Get company/factory details
        $m = Session::get('run_company');
        $company = DB::table('company')->where('id', $m)->first();
        
        return view('Sales.printSaleOrderItems', compact('saleOrder', 'saleOrderItems', 'customer', 'company'));
    }

    /**
     * Show contract loading form
     */
    public function contractLoadingForm()
    {
        return view('Sales.contractLoadingForm');
    }

    /**
     * Get approved contracts (approved_status = 1) - by order number
     * Exclude order numbers that have complete loading (all qty loaded)
     * Include order numbers that have partial loading (some qty remaining)
     */
    public function getApprovedContracts(Request $request)
    {
        // Get all approved contracts
        $allContracts = SaleOrderExport::where('approved_status', 1)
            ->where('status', 1)
            ->whereNotNull('voucehr_no')
            ->where('voucehr_no', '!=', '')
            ->select('id', 'contract_no', 'voucehr_no', 'voucher_date', 'advance_amount', 'advance_received_status')
            ->get();

        // Filter contracts: exclude those with complete loading AND exclude those where advance is required but not received
        $contracts = $allContracts->filter(function($contract) {
            // Exclude if advance is required but not received
            $advanceAmount = $contract->advance_amount ?? 0;
            $advanceReceived = $contract->advance_received_status ?? 0;
            
            if ($advanceAmount > 0 && $advanceReceived == 0) {
                return false; // Exclude this contract
            }
            // Get all loadings for this order
            $loadings = ContractLoading::where('sale_order_export_id', $contract->id)
                ->where('status', 1)
                ->get();

            // If no loading exists, include this contract
            if ($loadings->isEmpty()) {
                return true;
            }

            // Get original order qty for each item
            $saleOrderData = SaleOrderDataExport::where('sale_order_export_id', $contract->id)
                ->where('status', 1)
                ->get();

            // Calculate total original qty
            $totalOriginalQty = $saleOrderData->sum(function($item) {
                return $item->total_qty ?? $item->actual_qty ?? 0;
            });

            // Calculate total loaded qty from all loadings
            $totalLoadedQty = 0;
            foreach ($loadings as $loading) {
                $loadingData = ContractLoadingData::where('contract_loading_id', $loading->id)
                    ->where('status', 1)
                    ->get();
                $totalLoadedQty += $loadingData->sum('qty');
            }

            // Include if partial loading (loaded qty < original qty)
            // Use a small tolerance (0.01) to handle floating point comparison
            return $totalLoadedQty < ($totalOriginalQty - 0.01);
        })->values();

        // Sort by order number descending
        $contracts = $contracts->sortByDesc('voucehr_no')->values();

        return response()->json($contracts);
    }

    /**
     * Get export order details by order number
     */
    public function getExportOrderByOrderNo(Request $request)
    {
        $orderNo = $request->order_no;
        
        $saleOrder = SaleOrderExport::join('customers', 'customers.id', 'sale_order_exports.buyer_id')
            ->leftJoin('ports', 'ports.id', 'sale_order_exports.port')
            ->leftJoin('origins', 'origins.id', 'sale_order_exports.origin')
            ->leftJoin('currency', 'currency.id', 'sale_order_exports.currencey_id')
            ->where('sale_order_exports.voucehr_no', $orderNo)
            ->where('sale_order_exports.approved_status', 1)
            ->where('sale_order_exports.status', 1)
            ->select(
                'sale_order_exports.*',
                'customers.name',
                'customers.address',
                'ports.name as port_name',
                'origins.name as origin_name',
                'currency.curreny as currency_name'
            )
            ->first();

        if (!$saleOrder) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $saleOrderData = SaleOrderDataExport::where('sale_order_export_id', $saleOrder->id)
            ->where('status', 1)
            ->get();

        // Get all existing loadings for this order
        $existingLoadings = ContractLoading::where('sale_order_export_id', $saleOrder->id)
            ->where('status', 1)
            ->pluck('id')
            ->toArray();

        // Calculate already loaded qty for each item
        $loadedQtysByItem = [];
        if (!empty($existingLoadings)) {
            $loadingData = ContractLoadingData::whereIn('contract_loading_id', $existingLoadings)
                ->where('status', 1)
                ->get()
                ->groupBy('sale_order_data_export_id');
            
            foreach ($loadingData as $saleOrderDataId => $loadingItems) {
                $loadedQtysByItem[$saleOrderDataId] = $loadingItems->sum('qty');
            }
        }

        // Calculate total amount
        $totalAmount = 0;
        foreach ($saleOrderData as $item) {
            $amount = $item->amount ?? ($item->actual_qty * $item->rate);
            $totalAmount += $amount;
        }

        // Calculate total in PKR
        $totalAmountPKR = $totalAmount * ($saleOrder->currencey_rate ?? 1);

        // Add item names and loaded qty to sale order data
        $saleOrderDataWithNames = $saleOrderData->map(function($item) use ($loadedQtysByItem) {
            $item->item_name = CommonHelper::get_item_name($item->item_id);
            $item->total_qty = $item->total_qty ?? $item->actual_qty ?? 0; // Original order qty
            $item->previous_sent_qty = $loadedQtysByItem[$item->id] ?? 0; // Already loaded qty
            $item->remaining_qty = $item->total_qty - $item->previous_sent_qty; // Remaining qty
            return $item;
        });

        // Check advance status
        $advanceAmount = $saleOrder->advance_amount ?? 0;
        $advanceReceived = $saleOrder->advance_received_status ?? 0;
        
        return response()->json([
            'sale_order' => $saleOrder,
            'sale_order_data' => $saleOrderDataWithNames,
            'total_amount' => $totalAmount,
            'total_amount_pkr' => $totalAmountPKR,
            'advance_amount' => $advanceAmount,
            'advance_received_status' => $advanceReceived
        ]);
    }

    /**
     * Store contract loading
     */
    public function storeContractLoading(Request $request)
    {
        DB::connection('mysql2')->beginTransaction();
        try {
            // Check if advance is required and not received
            $saleOrder = SaleOrderExport::find($request->sale_order_export_id);
            if ($saleOrder) {
                $advanceAmount = $saleOrder->advance_amount ?? 0;
                $advanceReceived = $saleOrder->advance_received_status ?? 0;
                
                // If advance is required (advance_amount > 0) but not received (advance_received_status = 0)
                if ($advanceAmount > 0 && $advanceReceived == 0) {
                    DB::connection('mysql2')->rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot create shipment. Advance payment is required but not yet received. Please receive the advance payment first.'
                    ], 400);
                }
            }
            
            // Create contract loading with auto-generated loading number
            $data = [
                'loading_no' => SalesHelper::get_unique_loading_no(),
                'sale_order_export_id' => $request->sale_order_export_id,
                'contract_no' => $request->contract_no,
                'loading_date' => $request->loading_date,
                'forme_no' => $request->forme_no ?? null,
                'status' => 1
            ];

            $contractLoading = ContractLoading::create($data);

            // Save vehicles (multiple)
         

         
            if ($request->containers) {
                $containers = json_decode($request->containers, true);
                foreach ($containers as $container) {
                    if (!empty($container['container_no']) || !empty($container['seal_no'])) {
                        ContractLoadingContainer::create([
                            'contract_loading_id' => $contractLoading->id,
                            'item_id' => $container['container_item_select'] ?? null,
                            'container_no' => $container['container_no'] ?? null,
                            'vehicle_no' => $container['vehicle_no'] ?? null,
                            'seal_no' => $container['seal_no'] ?? null,
                            'quantity' => $container['quantity'] ?? null,
                        ]);
                    }
                }
            }

            // Save loading data (layers, item_id, qty)
            if ($request->layers) {
                $layers = json_decode($request->layers, true);
                foreach ($layers as $layerData) {
                    ContractLoadingData::create([
                        'contract_loading_id' => $contractLoading->id,
                        'sale_order_data_export_id' => $layerData['sale_order_data_export_id'],
                        'item_id' => $layerData['item_id'],
                        'layer' => $layerData['layer'] ?? null,
                        'qty' => $layerData['qty'] ?? 0,
                        'status' => 1
                    ]);
                }
            }

            // Handle attachments (multiple files)
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    if (!$file) {
                        continue;
                    }

                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $size = $file->getSize();

                    $fileName = time() . '_' . uniqid() . '.' . $extension;
                    // Store in public disk under contract_loading_attachments
                    $path = $file->storeAs('contract_loading_attachments', $fileName, 'public');

                    ContractLoadingAttachment::create([
                        'contract_loading_id' => $contractLoading->id,
                        'file_name'            => $fileName,
                        'original_name'        => $originalName,
                        'file_path'            => $path,
                        'file_type'            => $extension,
                        'file_size'            => $size,
                        'description'          => null,
                        'status'               => 1,
                    ]);
                }
            }

            DB::connection('mysql2')->commit();
            return response()->json(['success' => true, 'message' => 'Contract loading saved successfully']);
        } catch (Exception $ex) {
            DB::connection('mysql2')->rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $ex->getMessage()], 500);
        }
    }

    /**
     * Show contract loading list
     */
    public function contractLoadingList()
    {
        return view('Sales.contractLoadingList');
    }

    /**
     * Get contract loading filter data
     */
    public function getContractLoadingFilter(Request $request)
    {
        $query = ContractLoading::join('sale_order_exports', 'sale_order_exports.id', 'contract_loadings.sale_order_export_id')
            ->leftJoin('currency', 'currency.id', 'sale_order_exports.currencey_id')
            ->where('contract_loadings.status', 1)
            ->select(
                'contract_loadings.*',
                'sale_order_exports.voucehr_no',
                'sale_order_exports.currencey_rate',
                'currency.curreny as currency_name'
            );

        if (!empty($request->contract)) {
            $query->where('contract_loadings.contract_no', 'LIKE', '%' . $request->contract . '%');
        }

        if (!empty($request->from)) {
            $query->where('contract_loadings.loading_date', '>=', $request->from);
        }

        if (!empty($request->to)) {
            $query->where('contract_loadings.loading_date', '<=', $request->to);
        }

        $contract_loadings = $query->orderBy('contract_loadings.id', 'desc')->get();

        // Calculate total amounts for each loading
        $contract_loadings = $contract_loadings->map(function($loading) {
            $saleOrderData = SaleOrderDataExport::where('sale_order_export_id', $loading->sale_order_export_id)
                ->where('status', 1)
                ->get();

            $totalAmount = 0;
            foreach ($saleOrderData as $item) {
                $amount = $item->amount ?? ($item->actual_qty * $item->rate);
                $totalAmount += $amount;
            }

            $loading->total_amount = $totalAmount;
            $loading->total_amount_pkr = $totalAmount * ($loading->currencey_rate ?? 1);

            return $loading;
        });

        $m = Session::get('run_company');

        return view('Sales.AjaxPages.contractLoadingListAjax', compact('contract_loadings', 'm'));
    }

    /**
     * View contract loading detail
     */
    public function viewContractLoadingDetail(Request $request)
    {
        $id = $request->id;
        
        $contract_loading = ContractLoading::with('saleOrderExport')
            ->where('id', $id)
            ->first();

        if (!$contract_loading) {
            return response()->json(['error' => 'Contract loading not found'], 404);
        }

        // Get sale order with currency info
        $saleOrder = SaleOrderExport::leftJoin('currency', 'currency.id', 'sale_order_exports.currencey_id')
            ->where('sale_order_exports.id', $contract_loading->sale_order_export_id)
            ->select('sale_order_exports.*', 'currency.curreny as currency_name', 'sale_order_exports.currencey_rate')
            ->first();

        // Get sale order data
        $sale_order_data = SaleOrderDataExport::where('sale_order_export_id', $contract_loading->sale_order_export_id)
            ->where('status', 1)
            ->get();

        // Calculate total amounts
        $totalAmount = 0;
        foreach ($sale_order_data as $item) {
            $amount = $item->amount ?? ($item->actual_qty * $item->rate);
            $totalAmount += $amount;
        }
        $totalAmountPKR = $totalAmount * ($saleOrder->currencey_rate ?? 1);

        // Get attachments from contract loading
        $attachments = ContractLoadingAttachment::where('contract_loading_id', $contract_loading->id)
            ->where('status', 1)
            ->get();

        return view('Sales.AjaxPages.viewContractLoadingDetail', compact('contract_loading', 'sale_order_data', 'attachments', 'saleOrder', 'totalAmount', 'totalAmountPKR'));
    }

    /**
     * Delete contract loading
     */
    public function deleteContractLoading(Request $request)
    {
        DB::connection('mysql2')->beginTransaction();
        try {
            $contract_loading = ContractLoading::find($request->id);
            if ($contract_loading) {
                $contract_loading->status = 0;
                $contract_loading->save();
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

    /**
     * Show commercial invoice form
     */
    public function createCommercialInvoice()
    {
        return view('Sales.commercialInvoiceForm');
    }

    /**
     * Get loadings for commercial invoice
     */
    public function getLoadingsForCommercialInvoice(Request $request)
    {
        $loadings = ContractLoading::join('sale_order_exports', 'sale_order_exports.id', 'contract_loadings.sale_order_export_id')
            ->leftJoin('currency', 'currency.id', 'sale_order_exports.currencey_id')
            ->where('contract_loadings.status', 1)
            ->whereNotExists(function($query) {
                $query->select(DB::raw(1))
                    ->from('commercial_invoices')
                    ->whereColumn('commercial_invoices.contract_loading_id', 'contract_loadings.id')
                    ->where('commercial_invoices.status', 1);
            })
            ->select(
                'contract_loadings.*',
                'sale_order_exports.voucehr_no',
                'sale_order_exports.contract_no',
                'sale_order_exports.buyer_id',
                'sale_order_exports.currencey_id',
                'sale_order_exports.currencey_rate',
                'currency.curreny as currency_name'
            )
            ->orderBy('contract_loadings.id', 'desc')
            ->get();

        return response()->json($loadings);
    }

    /**
     * Get loading details for commercial invoice
     */
    public function getLoadingDetailsForCommercialInvoice(Request $request)
    {
        $loadingId = $request->loading_id;
        
        $loading = ContractLoading::with(['saleOrderExport', 'containers'])
            ->where('id', $loadingId)
            ->first();

        if (!$loading) {
            return response()->json(['error' => 'Loading not found'], 404);
        }

        $saleOrder = SaleOrderExport::leftJoin('customers', 'customers.id', 'sale_order_exports.buyer_id')
            ->leftJoin('ports', 'ports.id', 'sale_order_exports.port')
            ->leftJoin('currency', 'currency.id', 'sale_order_exports.currencey_id')
            ->leftJoin('consignees', 'consignees.id', 'sale_order_exports.consignee')
            ->leftJoin('mode_of_terms', 'mode_of_terms.id', 'sale_order_exports.mode_of_term')
            ->where('sale_order_exports.id', $loading->sale_order_export_id)
            ->select(
                'sale_order_exports.*',
                'customers.name as buyer_name',
                'customers.address as buyer_address',
                'ports.name as port_name',
                'currency.curreny as currency_name',
                'currency.id as currency_id',
                'sale_order_exports.currencey_rate',
                'consignees.name as consignee_name',
                'mode_of_terms.name as mode_of_term_name'
            )
            ->first();

        // Get loading data (partial qty based on loading)
        $loadingData = ContractLoadingData::where('contract_loading_id', $loading->id)
            ->where('status', 1)
            ->get();

        // Get sale order data items for reference (rate, description, etc.)
        $saleOrderData = SaleOrderDataExport::where('sale_order_export_id', $loading->sale_order_export_id)
            ->where('status', 1)
            ->get()
            ->keyBy('id'); // Key by id for easy lookup

        // Combine loading data with sale order data
        $loadingDataWithNames = $loadingData->map(function($loadingItem) use ($saleOrderData) {
            $saleOrderItem = $saleOrderData->get($loadingItem->sale_order_data_export_id);
            
            if (!$saleOrderItem) {
                return null;
            }
            
            $item = clone $saleOrderItem;
            $item->item_name = CommonHelper::get_item_name($item->item_id);
            $itemName = $item->item_name;
            $scientificName = '';
            if ($item->item_id) {
                $subitem = Subitem::find($item->item_id);
                $scientificName = $subitem->scientific_name ?? '';
            }
            $item->description = $itemName . ($scientificName ? ' (' . $scientificName . ')' : '');
            $item->grade_size = ($item->item_size ?? '') . ($item->quality ? '-' . $item->quality : '');
            
            // Use loading qty instead of sale order qty
            $item->loading_qty = $loadingItem->qty ?? 0;
            $item->layer = $loadingItem->layer ?? '';
            
            // Calculate amount based on loading qty
            $rate = $item->rate ?? 0;
            $item->amount = $item->loading_qty * $rate;
            
            return $item;
        })->filter(); // Remove null items

        // Calculate totals based on loading qty
        $totalAmount = 0;
        foreach ($loadingDataWithNames as $item) {
            $totalAmount += $item->amount;
        }


        // Check if commercial invoice already exists for this sale_order_export_id
        $existingInvoices = CommercialInvoice::where('sale_order_export_id', $loading->sale_order_export_id)
            ->where('status', 1)
            ->get();
        
        $hasExistingInvoice = $existingInvoices->count() > 0;
        
    
        
        // Calculate remaining amount (current loading amount - already invoiced)
        $exchangeRate = $saleOrder->currencey_rate ?? 1;
        
        // Get advance payment from sale_order_exports table (advance_amount column)
        // Advance is received against export order (sale_order_export_id), not against individual loadings
        $advanceAmountPKR = $saleOrder->advance_amount ?? 0; // Advance amount in PKR from sale_order_exports table
        // IMPORTANT: Advance amount should only be deducted ONCE across all commercial invoices
        // for the same sale_order_export_id, even if there are multiple loadings
        // If there's an existing invoice, the advance was already deducted in the first invoice
        // But we still show the advance amount for information (just don't deduct it from balance)
        if ($hasExistingInvoice) {
            // Subsequent invoices: Balance = remaining amount (advance already deducted in first invoice)
            // Don't deduct advance again - it was already considered in the first commercial invoice
            // But still show the advance amount for reference
            $totalAmountPKR = $totalAmount * $exchangeRate;
            $balanceAmountPKR = $totalAmountPKR ;
            // Keep advance amount for display (don't set to 0) - it's shown but not deducted
        } else {
            // First invoice for this export order: Balance = total - advance
            // This is the ONLY invoice that should deduct the advance amount
            $totalAmountPKR = $totalAmount * $exchangeRate;
            $balanceAmountPKR = $totalAmountPKR - $advanceAmountPKR;
        }
        
        // Get containers and vehicles for display
        $containers = $loading->containers ?? collect([]);

        return response()->json([
            'loading' => $loading,
            'sale_order' => $saleOrder,
            'sale_order_data' => $loadingDataWithNames->values()->toArray(), // Use loading data instead of sale order data
            'total_amount' => $totalAmount, // Based on loading qty
            'advance_amount' => $advanceAmountPKR, // Advance amount in PKR from sale_order_exports.advance_amount column
            'balance_amount_pkr' => $balanceAmountPKR, // Calculated balance amount in PKR
            'containers' => $containers->map(function($container) {
                return [
                    'item_id' => CommonHelper::get_item_name($container->item_id ?? ''),
                    'container_no' => $container->container_no ?? '',
                    'vehicle_no' => $container->vehicle_no ?? '',
                    'seal_no' => $container->seal_no ?? '',
                    'quantity' => $container->quantity ?? ''
                ];
            })->toArray(),
            
        ]);
    }

    /**
     * Store commercial invoice
     */
    public function storeCommercialInvoice(Request $request)
    {
        DB::connection('mysql2')->beginTransaction();
        try {
            $commercialInvoice = new CommercialInvoice();
            $commercialInvoice->contract_loading_id = $request->contract_loading_id;
            $commercialInvoice->sale_order_export_id = $request->sale_order_export_id;
            $commercialInvoice->invoice_no = SalesHelper::get_unique_commercial_invoice_no();
            $commercialInvoice->invoice_date = $request->invoice_date;
            $commercialInvoice->gd_no = $request->gd_no;
            $commercialInvoice->container_no = $request->container_no ?? $request->container_no_from_loading;
            $commercialInvoice->consignee_name = $request->consignee_name;
            $commercialInvoice->consignee_address = $request->consignee_address;
            $commercialInvoice->vessel_voyage = $request->vessel_voyage;
            $commercialInvoice->port_from = $request->port_from;
            $commercialInvoice->port_to = $request->port_to;
            $commercialInvoice->payment_term = $request->payment_term;
            $commercialInvoice->grand_total = $request->grand_total;
            
            // Check if this is the first commercial invoice for this sale_order_export_id
            // Advance should only be stored in the FIRST invoice
            $isFirstInvoice = !CommercialInvoice::where('sale_order_export_id', $request->sale_order_export_id)
                ->where('status', 1)
                ->where('id', '!=', $commercialInvoice->id ?? 0)
                ->exists();
            
            // Only store advance amount if this is the first invoice
            $commercialInvoice->advance_amount = $isFirstInvoice ? ($request->advance_amount ?? 0) : 0;
            $commercialInvoice->balance_amount = $request->balance_amount ?? 0;
            $commercialInvoice->currency_id = $request->currency_id;
            $commercialInvoice->exchange_rate = $request->exchange_rate ?? 1;
            $commercialInvoice->status = 1;
            $commercialInvoice->save();

            // Save invoice data items
            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $item) {
                    CommercialInvoiceData::create([
                        'commercial_invoice_id' => $commercialInvoice->id,
                        'sale_order_data_export_id' => $item['sale_order_data_export_id'] ?? null,
                        'item_id' => $item['item_id'] ?? null,
                        'description' => $item['description'] ?? '',
                        'grade_size' => $item['grade_size'] ?? '',
                        'total_cartons' => $item['total_cartons'] ?? 0,
                        'total_net_kgs' => $item['total_net_kgs'] ?? 0,
                        'rate_cfr_per_kg' => $item['rate_cfr_per_kg'] ?? 0,
                        'amount_usd' => $item['amount_usd'] ?? 0,
                        'status' => 1
                    ]);
                }
            }

            // Create transaction entries
            $saleOrder = SaleOrderExport::find($request->sale_order_export_id);
            $customer = Customer::find($saleOrder->buyer_id);
            $bank = Bank::find($saleOrder->bank);

            if ($customer && $bank) {
                $voucher_no = $commercialInvoice->invoice_no;
                $v_date = $commercialInvoice->invoice_date;

                // Get PKR amounts directly from request (already calculated in frontend)
                // The frontend calculates balance_amount_pkr correctly:
                // - First invoice: balance = grand_total_pkr - advance_amount_pkr
                // - Subsequent invoices: balance = remaining_amount_pkr (advance already deducted in first invoice)
                $grandTotalPKR = $request->grand_total_pkr ?? ($commercialInvoice->grand_total * ($commercialInvoice->exchange_rate ?? 1));
                $advanceAmountPKR = $request->advance_amount_pkr ?? 0; // Advance amount in PKR from sale_order_exports.advance_amount (0 if not first invoice)
                $balanceAmountPKR = $request->balance_amount_pkr ?? $grandTotalPKR; // Use balance from request (already calculated correctly)

                // Customer Debit (Receivable) - balance amount in PKR
                $customer_acc_id = $customer->acc_id ?? null;
                if ($customer_acc_id) {
                    $transaction_customer = new Transactions();
                    $transaction_customer = $transaction_customer->SetConnection('mysql2');
                    $transaction_customer->voucher_no = $voucher_no;
                    $transaction_customer->v_date = $v_date;
                    $transaction_customer->acc_id = $customer_acc_id;
                    $transaction_customer->acc_code = FinanceHelper::getAccountCodeByAccId($customer_acc_id);
                    $transaction_customer->particulars = 'Commercial Invoice - ' . $voucher_no;
                    $transaction_customer->opening_bal = 0;
                    $transaction_customer->debit_credit = 1; // Debit - customer owes
                    $transaction_customer->amount = $balanceAmountPKR; // Balance in PKR (no conversion needed)
                    $transaction_customer->username = Auth::user()->name;
                    $transaction_customer->status = 1;
                    $transaction_customer->voucher_type = 22; // Commercial Invoice voucher type
                    $transaction_customer->master_id = $commercialInvoice->id;
                    $transaction_customer->save();
                }


                if($balanceAmountPKR != $grandTotalPKR){
                    // If balance is different from grand total, it means there's an advance component
                    // We need to create a separate transaction for the advance amount (if this is the first invoice)
                    if ($advanceAmountPKR > 0) {
                        // Customer Credit (Advance) - advance amount in PKR
                        if ($customer_acc_id) {
                            $transaction_cr_advance = new Transactions();
                            $transaction_cr_advance = $transaction_cr_advance->SetConnection('mysql2');
                            $transaction_cr_advance->voucher_no = $voucher_no; // Different voucher no for advance
                            $transaction_cr_advance->v_date = $v_date;
                            $transaction_cr_advance->acc_id = $customer_acc_id;
                            $transaction_cr_advance->acc_code = FinanceHelper::getAccountCodeByAccId($customer_acc_id);
                            $transaction_cr_advance->particulars = 'Advance for Commercial Invoice - ' . $voucher_no;
                            $transaction_cr_advance->opening_bal = 0;
                            $transaction_cr_advance->debit_credit = 0; // Credit - advance received
                            $transaction_cr_advance->amount = $advanceAmountPKR; // Advance amount in PKR (no conversion needed)
                            $transaction_cr_advance->username = Auth::user()->name;
                            $transaction_cr_advance->status = 1;
                            $transaction_cr_advance->voucher_type = 22; // Commercial Invoice voucher type
                            $transaction_cr_advance->master_id = $commercialInvoice->id;
                            $transaction_cr_advance->save();

                            $transaction_dr_advance = new Transactions();
                            $transaction_dr_advance = $transaction_dr_advance->SetConnection('mysql2');
                            $transaction_dr_advance->voucher_no = $voucher_no; // Different voucher no for advance
                            $transaction_dr_advance->v_date = $v_date;
                            $transaction_dr_advance->acc_id = $customer->liability_acc_id; // Assuming customer has a liability account for advances
                            $transaction_dr_advance->acc_code = FinanceHelper::getAccountCodeByAccId($customer->liability_acc_id);
                            $transaction_dr_advance->particulars = 'Advance for Commercial Invoice - ' . $voucher_no;
                            $transaction_dr_advance->opening_bal = 0;
                            $transaction_dr_advance->debit_credit = 1; // Debit - advance received
                            $transaction_dr_advance->amount = $advanceAmountPKR; // Advance amount in PKR (no conversion needed)
                            $transaction_dr_advance->username = Auth::user()->name;
                            $transaction_dr_advance->status = 1;
                            $transaction_dr_advance->voucher_type = 22; // Commercial Invoice voucher type
                            $transaction_dr_advance->master_id = $commercialInvoice->id;
                            $transaction_dr_advance->save();


                            $received_paymet=array
                            (
                                'commercial_invoice_id'=>$commercialInvoice->id,
                                'commercial_invoice_no'=>$voucher_no,
                                'receipt_id'=>'',
                                'receipt_no'=>'',
                                'received_amount'=>$advanceAmountPKR,
                                'slip_no'=>'',
                                'status'=>1,
                            );
                            DB::Connection('mysql2')->table('received_paymet')->insert($received_paymet);
                        }
                }

                // Sales Revenue Credit - grand total in PKR
                // Assuming there's a sales revenue account (you may need to adjust this)
                $sales_revenue_acc_id = 5; // Adjust based on your chart of accounts
                $transaction_sales = new Transactions();
                $transaction_sales = $transaction_sales->SetConnection('mysql2');
                $transaction_sales->voucher_no = $voucher_no;
                $transaction_sales->v_date = $v_date;
                $transaction_sales->acc_id = $sales_revenue_acc_id;
                $transaction_sales->acc_code = FinanceHelper::getAccountCodeByAccId($sales_revenue_acc_id);
                $transaction_sales->particulars = 'Commercial Invoice - ' . $voucher_no;
                $transaction_sales->opening_bal = 0;
                $transaction_sales->debit_credit = 0; // Credit - revenue
                $transaction_sales->amount = $balanceAmountPKR; // Grand total in PKR (no conversion needed)
                $transaction_sales->username = Auth::user()->name;
                $transaction_sales->status = 1;
                $transaction_sales->voucher_type = 22;
                $transaction_sales->master_id = $commercialInvoice->id;
                $transaction_sales->save();
            }

            DB::connection('mysql2')->commit();
            return response()->json(['success' => true, 'message' => 'Commercial invoice created successfully', 'invoice_id' => $commercialInvoice->id]);
        } catch (Exception $ex) {
            DB::connection('mysql2')->rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $ex->getMessage()], 500);
        }
    }

    /**
     * View commercial invoice
     */
    public function viewCommercialInvoice(Request $request)
    {
        $id = $request->id;
        
        $commercialInvoice = CommercialInvoice::with(['contractLoading.containers', 'saleOrderExport', 'invoiceData', 'currency'])
            ->where('id', $id)
            ->first();

        if (!$commercialInvoice) {
            return response()->json(['error' => 'Commercial invoice not found'], 404);
        }

        // Get sale order details
        $saleOrder = SaleOrderExport::leftJoin('customers', 'customers.id', 'sale_order_exports.buyer_id')
            ->leftJoin('ports', 'ports.id', 'sale_order_exports.port')
            ->where('sale_order_exports.id', $commercialInvoice->sale_order_export_id)
            ->select(
                'sale_order_exports.*',
                'customers.name as buyer_name',
                'customers.address as buyer_address',
                'ports.name as port_name'
            )
            ->first();

        return view('Sales.AjaxPages.viewCommercialInvoice', compact('commercialInvoice', 'saleOrder'));
    }

    /**
     * Show commercial invoice list
     */
    public function commercialInvoiceList()
    {
        return view('Sales.commercialInvoiceList');
    }

    /**
     * Get commercial invoice filter data
     */
    public function getCommercialInvoiceFilter(Request $request)
    {
        $query = CommercialInvoice::join('contract_loadings', 'contract_loadings.id', 'commercial_invoices.contract_loading_id')
            ->join('sale_order_exports', 'sale_order_exports.id', 'commercial_invoices.sale_order_export_id')
            ->leftJoin('currency', 'currency.id', 'commercial_invoices.currency_id')
            ->where('commercial_invoices.status', 1)
            ->select(
                'commercial_invoices.*',
                'contract_loadings.loading_no',
                'sale_order_exports.voucehr_no',
                'currency.curreny as currency_name'
            );

        if (!empty($request->invoice_no)) {
            $query->where('commercial_invoices.invoice_no', 'LIKE', '%' . $request->invoice_no . '%');
        }

        if (!empty($request->loading_no)) {
            $query->where('contract_loadings.loading_no', 'LIKE', '%' . $request->loading_no . '%');
        }

        if (!empty($request->from)) {
            $query->where('commercial_invoices.invoice_date', '>=', $request->from);
        }

        if (!empty($request->to)) {
            $query->where('commercial_invoices.invoice_date', '<=', $request->to);
        }

        $commercial_invoices = $query->orderBy('commercial_invoices.id', 'desc')->get();
        $m = Session::get('run_company');

        return view('Sales.AjaxPages.commercialInvoiceListAjax', compact('commercial_invoices', 'm'));
    }

    /**
     * Delete commercial invoice
     */
    public function deleteCommercialInvoice(Request $request)
    {
        DB::connection('mysql2')->beginTransaction();
        try {
            $commercialInvoice = CommercialInvoice::find($request->id);
            if ($commercialInvoice) {
                $commercialInvoice->status = 0;
                $commercialInvoice->save();
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
