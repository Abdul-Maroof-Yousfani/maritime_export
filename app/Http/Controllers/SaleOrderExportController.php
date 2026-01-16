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
        //   dd($request->all());
        DB::Connection('mysql2')->beginTransaction();
        try {
            $sale_order = new SaleOrderExport;
            $sale_order->voucehr_no = $request->voucher_no;
            $sale_order->contract_no = $request->contract_no;
            $sale_order->voucher_date = $request->voucher_date;
            $sale_order->voucher_heading = $request->voucher_heading;
            $sale_order->voucher_type = 0;
            $sale_order->buyer_id = $request->buyers_id; //??1;
            $sale_order->quality_remarks = $request->quality_remarks;
            $sale_order->product_specification = $request->product_specification;
            $sale_order->shipment_delivery = $request->shipment_delivery;
            // $sale_order->packing_view = $request->packing;
            
            $sale_order->buyers_ntn = $request->buyers_ntn ?? 1;
            $sale_order->model_terms_of_payment = $request->model_terms_of_payment;
            $sale_order->mode_of_term = $request->mode_of_term;
            $sale_order->due_date = $request->due_date ?? date('Y-m-d');
            $sale_order->delevery_date_to = $request->delevery_date_to ?? date('Y-m-d');
            $sale_order->base_legnth = $request->base_legnth;
            $sale_order->broken_grain = $request->broken_grain;
            $sale_order->mosture_content = $request->mosture_content;
            $sale_order->demand_yellow_grain = $request->demand_yellow_grain;
            $sale_order->chalky_grain = $request->chalky_grain;
            $sale_order->foreign_grain = $request->foreign_grain;
            $sale_order->paddy_grain = $request->paddy_grain;
            $sale_order->under_milled = $request->under_milled;
            $sale_order->milled_double_polish = $request->milled_double_polish;
            $sale_order->whiteness = $request->whiteness;
            $sale_order->incoterm = $request->incoterm ? (int)$request->incoterm : null;
            $sale_order->mode_transport = $request->mode_transport;
            $sale_order->origin = $request->origin ? (int)$request->origin : null;
            $sale_order->port = $request->port ? (int)$request->port : null;
            $sale_order->port_of_discharge = $request->port_of_discharge;
            $sale_order->port_loading = $request->port_loading;
            $sale_order->grade = $request->grade ? (int)$request->grade : null;
            $sale_order->size = $request->size ? (int)$request->size : null;
            $sale_order->packing = $request->packing ? (int)$request->packing : null;
            $sale_order->hs_code = $request->hs_code;
            $sale_order->partial_payment = $request->partial_payment;
            $sale_order->bank = $request->beneficiary_bank ?? 1;
            $sale_order->proforma_status = 0;
            //    $sale_order->delevery_date =$request->delevery_date;
            $sale_order->transhipment = $request->transhipment;
            $sale_order->part_shipment = $request->part_shipment;
            $sale_order->insurance_coverd = $request->insurance_coverd;
            $sale_order->is_advance = $request->is_advance ?? 0;
            $sale_order->payment_days = $request->payment_days;
            $sale_order->currencey_id = $request->rate_conversion;
            $sale_order->currencey_rate = $request->rate_of_conversion;

            $sale_order->correspondent_bank = $request->correspondent_bank;
            $sale_order->account_title = $request->account_title;
            $sale_order->correspondent_account_usd = $request->correspondent_iban;
            $sale_order->correspondent_account_no = $request->correspondent_account;
            $sale_order->correspondent_bank_id = $request->bank;
            $sale_order->correspondent_account_address = $request->correspondent_address;
            $sale_order->correspondent_bank_swift = $request->correspondent_swift;
            $sale_order->details_of_payment = $request->payment_details;


            $sale_order->marking_labeling = $request->marking_labeling;
            $sale_order->consignee = $request->consignee ? (int)$request->consignee : null;
            // $sale_order->notify_party = $request->notify_party_details;
            $sale_order->broker = $request->broker;
            $sale_order->document_to_provided = $request->document_to_provide;
            $sale_order->other_condition = $request->other_condition;
            $sale_order->application_law = $request->application_law;
            $sale_order->force_majure = $request->force_majure;
            $sale_order->type_of_loading = $request->type_of_loading;
            $sale_order->save();

            // Handle consignee details (for display purposes) - check if it's array (old format) or single value (new format)
            if (isset($request->consignee_details) && is_array($request->consignee_details)) {
                foreach ($request->consignee_details as $key => $consignee_detail) {
                    if (!empty($consignee_detail)) {
                        ExportOrderConsignee::create([
                            'consignee' => $consignee_detail,
                            'export_order_id' => $sale_order->id
                        ]);
                    }
                }
            } elseif (isset($request->consignee_details) && !empty($request->consignee_details)) {
                ExportOrderConsignee::create([
                    'consignee' => $request->consignee_details,
                    'export_order_id' => $sale_order->id
                ]);
            }
            foreach ($request->notify_party_details as $key => $notify_party_details) {
                if (!empty($notify_party_details)) {
                    ExportOrderNotify::create([
                        'notify' => $notify_party_details,
                        'export_order_id' => $sale_order->id
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
        $sales_order_data =  $sales_order_data->where('sale_order_export_id', $id)->get();


        return view('Sales.AjaxPages.viewSalesOrderDetailExport', compact('sales_order', 'sales_order_data'));
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
            ->select('sale_order_data_exports.*', 'subitem.sub_ic', 'subitem.pack_uom')
            ->join('subitem', 'subitem.id', 'sale_order_data_exports.item_id')
            ->where('sale_order_data_exports.status', 1)
            ->get();
        //    dd($sales_order_data);
        return view('Sales.AjaxPages.viewSaleExportVoucher', compact('sales_order', 'sales_order_data'));
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
            $sale_order->voucher_heading = $request->voucher_heading;
            $sale_order->voucher_type = 0;
            $sale_order->buyer_id = $request->buyers_id; //??1;
            $sale_order->quality_remarks = $request->quality_remarks;
            $sale_order->product_specification = $request->product_specification;
            $sale_order->shipment_delivery = $request->shipment_delivery;
            $sale_order->quantity_view = $request->quantity_view;
            $sale_order->packing_view = $request->packing;
            $sale_order->unit_price_view = $request->unit_price_view;
            $sale_order->total_price_view = $request->total_price_view;
            $sale_order->buyers_ntn = $request->buyers_ntn ?? 1;
            $sale_order->model_terms_of_payment = $request->model_terms_of_payment;
            $sale_order->mode_of_term = $request->mode_of_term;
            $sale_order->due_date = $request->due_date ?? date('Y-m-d');
            $sale_order->delevery_date_to = $request->delevery_date_to ?? date('Y-m-d');
            $sale_order->base_legnth = $request->base_legnth;
            $sale_order->broken_grain = $request->broken_grain;
            $sale_order->mosture_content = $request->mosture_content;
            $sale_order->demand_yellow_grain = $request->demand_yellow_grain;
            $sale_order->chalky_grain = $request->chalky_grain;
            $sale_order->foreign_grain = $request->foreign_grain;
            $sale_order->paddy_grain = $request->paddy_grain;
            $sale_order->under_milled = $request->under_milled;
            $sale_order->milled_double_polish = $request->milled_double_polish;
            $sale_order->whiteness = $request->whiteness;
            $sale_order->incoterm = $request->incoterm ? (int)$request->incoterm : null;
            $sale_order->mode_transport = $request->mode_transport;
            $sale_order->origin = $request->origin ? (int)$request->origin : null;
            $sale_order->port = $request->port ? (int)$request->port : null;
            $sale_order->port_of_discharge = $request->port_of_discharge;
            $sale_order->port_loading = $request->port_loading;
            $sale_order->grade = $request->grade ? (int)$request->grade : null;
            $sale_order->size = $request->size ? (int)$request->size : null;
            $sale_order->packing = $request->packing ? (int)$request->packing : null;
            $sale_order->hs_code = $request->hs_code;
            $sale_order->partial_payment = $request->partial_payment;
            $sale_order->bank = $request->beneficiary_bank ?? 1;
            $sale_order->proforma_status = 0;
            //    $sale_order->delevery_date =$request->delevery_date;
            $sale_order->transhipment = $request->transhipment;
            $sale_order->part_shipment = $request->part_shipment;
            $sale_order->insurance_coverd = $request->insurance_coverd;
            $sale_order->is_advance = $request->is_advance ?? 0;
            $sale_order->payment_days = $request->payment_days;
            $sale_order->currencey_id = $request->rate_conversion;
            $sale_order->currencey_rate = $request->rate_of_conversion;

            $sale_order->correspondent_bank = $request->correspondent_bank;
            $sale_order->account_title = $request->account_title;;
            $sale_order->correspondent_account_usd = $request->correspondent_iban;
            $sale_order->correspondent_account_no = $request->correspondent_account;
            $sale_order->correspondent_bank_id = $request->bank;
            $sale_order->correspondent_account_address = $request->correspondent_address;
            $sale_order->correspondent_bank_swift = $request->correspondent_swift;
            $sale_order->details_of_payment = $request->payment_details;


            $sale_order->marking_labeling = $request->marking_labeling;
            $sale_order->consignee = $request->consignee ? (int)$request->consignee : null;
            // $sale_order->notify_party = $request->notify_party_details;
            $sale_order->broker = $request->broker;
            $sale_order->document_to_provided = $request->document_to_provide;
            $sale_order->other_condition = $request->other_condition;
            $sale_order->application_law = $request->application_law;
            $sale_order->force_majure = $request->force_majure;
            $sale_order->type_of_loading = $request->type_of_loading;
            $sale_order->save();

            ExportOrderConsignee::where('export_order_id', $sale_order->id)->delete();
            // Handle consignee - check if it's array (old format) or single value (new format)
            if (is_array($request->consignee)) {
                foreach ($request->consignee as $key => $consignee) {
                    if (!empty($consignee)) {
                        ExportOrderConsignee::create([
                            'consignee' => $consignee,
                            'export_order_id' => $sale_order->id
                        ]);
                    }
                }
            } elseif (!empty($request->consignee)) {
                ExportOrderConsignee::create([
                    'consignee' => $request->consignee,
                    'export_order_id' => $sale_order->id
                ]);
            }
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
            
            // Get customer acc_id
            $customer = Customer::find($saleOrder->buyer_id);
            $customer_acc_id = $customer->acc_id ?? null;
            
            // Get bank acc_id from banks table
            $bank = Bank::find($saleOrder->bank);
            $bank_acc_id = $bank->acc_id ?? null;
            
            // If bank doesn't have acc_id, try to get from accounts table based on bank name
            if (!$bank_acc_id && $bank) {
                $bank_account = DB::connection('mysql2')->table('accounts')
                    ->where('name', 'like', '%' . $bank->bank_name . '%')
                    ->where('status', 1)
                    ->where('code', 'like', '1-2-6-3%') // Bank account code pattern
                    ->first();
                $bank_acc_id = $bank_account->id ?? null;
            }
            
            if (!$customer_acc_id) {
                return response()->json(['success' => false, 'message' => 'Customer account ID not found'], 400);
            }
            
            if (!$bank_acc_id) {
                return response()->json(['success' => false, 'message' => 'Bank account ID not found'], 400);
            }
            
            // Generate unique voucher number for advance payment
            $advance_voucher_no = $saleOrder->voucehr_no . '-ADV-' . date('YmdHis');
            
            // Customer Credit Entry (Customer is paying us)
            $transaction_customer = new Transactions();
            $transaction_customer = $transaction_customer->SetConnection('mysql2');
            $transaction_customer->voucher_no = $advance_voucher_no;
            $transaction_customer->v_date = date('Y-m-d');
            $transaction_customer->acc_id = $customer_acc_id;
            $transaction_customer->acc_code = FinanceHelper::getAccountCodeByAccId($customer_acc_id);
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
}
