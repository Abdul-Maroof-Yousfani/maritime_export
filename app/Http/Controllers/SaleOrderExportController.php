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
use App\Helpers\FinanceHelper;
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
          dd($request->all());
        DB::Connection('mysql2')->beginTransaction();
        try {
            $sale_order = new SaleOrderExport;
            $sale_order->voucehr_no = $request->voucher_no;
            $sale_order->contract_no = $request->contract_no;
            $sale_order->voucher_date = $request->voucher_date;
            $sale_order->voucher_type = 0;
            $sale_order->buyer_id = $request->buyers_id; //??1;
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
            $sale_order->is_advance = $request->is_advance ?? 0;
            $sale_order->mode_of_production = $request->mode_of_production ?? null;
            $sale_order->currencey_id = $request->rate_conversion;
            $sale_order->currencey_rate = $request->rate_of_conversion;
           
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

        return view('Sales.AjaxPages.viewSalesOrderDetailExport', compact('sales_order', 'sales_order_data', 'attachments'));
    }

    public function updateApprovedStatus(Request $request)
    {

        DB::Connection('mysql2')->beginTransaction();
        try {
            // $str = DB::Connection('mysql2')->selectOne("select max(convert(substr(`contract_no`,7,length(substr(`contract_no`,3))-3),signed integer)) reg
            // from `sale_order_exports` where substr(`contract_no`,3,2) = " . date('y')  . " and substr(`contract_no`,5,2) = " . date('m')  . "")->reg;


            $str = DB::connection('mysql2')->selectOne("select max(convert(substr(`contract_no`,4,length(substr(`contract_no`,4))-4),signed integer)) reg from `sale_order_exports` where substr(`contract_no`,-4,2) = " . date('m') . " and substr(`contract_no`,-2,2) = " . date('y') . "")->reg;
            $contract = 'CON' . ($str + 1) . date('my');

            // $str = $str + 1;
            // dd($str);
            // $str = sprintf("%'03d", $str);
            // $contract = 'CON' . date('y') . date('m') . $str ;

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
        return view('export.sales.saleOrderEdit', compact('exportOrder', 'incoterms', 'printingBags', 'modeofterms', 'modeoftransports', 'conversions', 'banks', 'customers', 'ports', 'origins', 'consignees', 'grades', 'sizes', 'packings'));
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
            $sale_order->due_date = $request->due_date ?? date('Y-m-d');
            $sale_order->incoterm = $request->incoterm ? (int)$request->incoterm : null;
            $sale_order->origin = $request->origin ? (int)$request->origin : null;
            $sale_order->port = $request->port ? (int)$request->port : null;
            $sale_order->grade = $request->grade ? (int)$request->grade : null;
            $sale_order->size = $request->size ? (int)$request->size : null;
            $sale_order->packing = $request->packing ? (int)$request->packing : null;
            $sale_order->bank = $request->beneficiary_bank ?? 1;
            $sale_order->proforma_status = 0;
            $sale_order->is_advance = $request->is_advance ?? 0;
            $sale_order->mode_of_production = $request->mode_of_production ?? null;
            $sale_order->payment_days = $request->payment_days;
            $sale_order->currencey_id = $request->rate_conversion;
            $sale_order->currencey_rate = $request->rate_of_conversion;
           
            $sale_order->consignee = $request->consignee ? (int)$request->consignee : null;
            $sale_order->save();

            ExportOrderNotify::where('export_order_id', $sale_order->id)->delete();      
            foreach ($request->notify_party_details as $key => $notify_party_details) {
                if (!empty($notify_party_details)) {
                    ExportOrderNotify::create([
                        'notify' => $notify_party_details,
                        'export_order_id' => $sale_order->id
                    ]);
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
                $sale_order_data->no_of_container = $request->no_of_container[$key] ?? null;

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
            
            $advance_amount = $request->advance_amount;
            
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
            $transaction_customer->amount = $advance_amount;
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
            $transaction_bank->amount = $advance_amount;
            $transaction_bank->username = Auth::user()->name;
            $transaction_bank->status = 1;
            $transaction_bank->voucher_type = 21; // Export Sale Order voucher type
            $transaction_bank->master_id = $saleOrder->id;
            $transaction_bank->save();
            
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
}
