<?php

namespace App\Http\Controllers;

use App\Models\ExportInvoice;
use App\Models\ExportInvoiceData;
use App\Models\ExportPerforma;
use Illuminate\Http\Request;
use App\Models\SaleOrderExport;
use App\Models\SaleOrderDataExport;
use App\Models\ModeOfTerm;
use App\Models\ModeOfTransport;
use App\Models\IncoTerm;
use App\Models\Bank;
use App\Models\ExportPakingList;
use App\Models\ExportPakingListData;
use App\Models\Currency;
use App\Models\ExportAdvancePayment;
use App\Models\ExportCommercialNotifyAddress;
use Exception;
use Illuminate\Support\Facades\DB;

class ExportInvoiceController extends Controller
{

    public function invoiceList()
    {
        return view('export.invoice.invoiceList');
    }

    public function invoiceListAjax(Request $request)
    {
        $query =  ExportInvoice::select('export_invoices.*', 'export_performas.eo_voucher_no', 'export_performas.pro_contract_no', 'export_invoices.created_at')->join('export_performas', 'export_performas.id', 'export_invoices.proforma_id')
            ->where('export_invoices.status', 1);
        if (!empty($request->Eono)) {
            $query->where('export_performas.eo_voucher_no', 'LIKE', '%' . $request->Eono . '%');
        }
        if (!empty($request->commercial)) {
            $query->where('export_invoices.commercial_invoice_no', 'LIKE', '%' . $request->commercial . '%');
        }
        if (!empty($request->proforma)) {
            $query->where('export_performas.pro_contract_no', 'LIKE', '%' . $request->proforma . '%');
        }

        $invoices =   $query->orderBy('id', 'desc')->get();
        return view('export.invoice.invoiceListAjax', compact('invoices'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createExportInvoice($id)
    {

        $sale_order =  SaleOrderExport::select(
            'sale_order_exports.*',
            'customers.name as name',
            'export_performas.id as proforma_id',
            'export_performas.pro_contract_no',
            'export_performas.correspondent_bank',
            'export_performas.account_title',
            'export_performas.correspondent_account_usd',
            'export_performas.correspondent_bank_swift',
            'export_performas.details_of_payment'
        )
            ->join('customers', 'customers.id', 'sale_order_exports.buyer_id')
            ->join('export_performas', 'export_performas.sale_order_id', 'sale_order_exports.id')
            ->where('sale_order_exports.status', 1)
            ->where('approved_status', 1)
            ->where('export_performas.id', $id)
            ->first();

        $sale_order_data = SaleOrderDataExport::leftjoin('export_invoice_datas', 'export_invoice_datas.sale_order_export_data_id', 'sale_order_data_exports.id')
            ->select(
                DB::raw('
                CASE
                    WHEN (COALESCE(sale_order_data_exports.total_qty, 0) = "Infinity") THEN COALESCE(sale_order_data_exports.actual_qty, 0)
                    ELSE COALESCE(sale_order_data_exports.total_qty, 0)
                END AS remaining'
                ),
                // DB::raw('COALESCE(sale_order_data_exports.total_qty,0) - COALESCE(sum(export_invoice_datas.issue_qty),0)as remaining '),
                'sale_order_data_exports.*',
                DB::raw('COALESCE(sum(export_invoice_datas.issue_qty),0)as deleverd_qty')
            )
            ->where('sale_order_data_exports.sale_order_export_id', $sale_order->id)
            ->where('sale_order_data_exports.status', 1)
            ->groupBy('sale_order_data_exports.id')
            ->get();

            // dd($sale_order_data);
        $advance_payment = ExportAdvancePayment::where(['proforma_id' => $sale_order->proforma_id, 'type' => '1'])
            ->select(DB::raw('sum(received_amount) as received_amount'), DB::raw('concat(advance_voucher_no) as advance_voucher_no'))
            ->groupBy('proforma_id')
            ->first();

        $advance_payment_invoice = ExportAdvancePayment::where(['proforma_id' => $sale_order->proforma_id, 'type' => '2'])
            ->select(DB::raw('sum(received_amount) as received_amount'), DB::raw('concat(advance_voucher_no) as advance_voucher_no'))
            ->groupBy('proforma_id')
            ->first();
        $incoterms =  IncoTerm::all();
        $modeofterms =  ModeOfTerm::all();
        $modeoftransports =  ModeOfTransport::all();
        $conversions = Currency::where('status', 1)->get();
        $banks = Bank::where('status', 1)->get();
        return view('export.invoice.createExportInvoice', compact('incoterms', 'modeofterms', 'modeoftransports', 'conversions', 'banks', 'sale_order_data', 'sale_order', 'advance_payment', 'advance_payment_invoice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeExportInvoice(Request $request)
    {
        // dd($request->all());
        DB::Connection('mysql2')->beginTransaction();
        try {
            $final_balnce = 0;
            $exportInvoice = new ExportInvoice;
            $exportInvoice->proforma_id =  $request->proforma_id;
            $exportInvoice->ship_name =  $request->ship_name;
            $exportInvoice->bill_of_loading =  $request->bill_of_loading;
            $exportInvoice->master_bl =  $request->master_bl;
            $exportInvoice->consigned_deatils =  $request->consigned_deatils;
            $exportInvoice->sale_order_export_id =  $request->sale_order_id;
            $exportInvoice->commercial_invoice_no =  $request->commercial_invoice_no;
            $exportInvoice->description =  $request->product_description;
            $exportInvoice->invoice_no =  $request->invoice_no;
            $exportInvoice->invoice_date =  $request->invoice_date;
            $exportInvoice->lc_date_no =  $request->lc_date;
            $exportInvoice->form_no =  json_encode($request->form_no);
            $exportInvoice->status =  1;
            $exportInvoice->save();
            foreach ($request->notify_address ?? [] as $key => $notify_address) {
                if (!empty($notify_address)) {
                    ExportCommercialNotifyAddress::create([
                        'commercial_invoice_id' => $exportInvoice->id,
                        'notify_address' => $notify_address,
                    ]);
                }
            }
            foreach ($request->sub_ic_des as $key => $item) {
                $exportInvoiceData = new ExportInvoiceData;
                $exportInvoiceData->export_invoice_id =  $exportInvoice->id;
                $exportInvoiceData->sale_order_export_data_id = $request->sale_order_data_id[$key];
                $exportInvoiceData->issue_qty = $request->issue_qty[$key];
                $exportInvoiceData->gross_weight = $request->gross_weight[$key];
                $exportInvoiceData->remaing_qty = $request->reamining[$key];
                $exportInvoiceData->brand = $request->brand[$key];
                $exportInvoiceData->status = 1;
                $exportInvoiceData->save();
                // dd( $request->actual_qty[$key] , $request->issue_qty[$key] ,  $request->deleverd_qty[$key]);
                $final_balnce += $request->actual_qty[$key] -  $request->issue_qty[$key] -  $request->deleverd_qty[$key];
            }
            if (!empty($request->advance_payment_settelemnt) || $request->advance_payment_settelemnt != 0) {
                $str = DB::connection('mysql2')->selectOne("select max(convert(substr(`advance_voucher_no`,4,length(substr(`advance_voucher_no`,4))-4),signed integer)) reg from `export_advance_payments` where substr(`advance_voucher_no`,-4,2) = " . date('m') . " and substr(`advance_voucher_no`,-2,2) = " . date('y') . "")->reg;
                $EAPV = 'EAP' . ($str + 1) . date('my');
                // $sales_adv_acc_id = DB::Connection('mysql2')->table('accounts')->where('status', 1)->where('name', 'like', '%' . 'Export Advance Payment' . '%')->select('id')->first()->id;
                $sales_adv_acc_id = DB::Connection('mysql2')->table('customers')->where('status', 1)->where('name', $request->buyers_id)->select('acc_id')->first()->acc_id;
                $response =  new  ExportAdvancePayment;
                $response->advance_voucher_no = $EAPV;
                $response->proforma_id = $request->proforma_id;
                $response->invoice_id = $exportInvoice->id;
                $response->invoice_data_id = 0;
                $response->type = 2;
                $response->cr = $sales_adv_acc_id; //For temprory Time 
                $response->dr = 330;
                $response->advance_percent = 0;
                $response->advance_amount = 0;
                $response->received_amount = $request->advance_payment_settelemnt;
                $response->description = $request->description;
                $response->status = 1;
                $response->save();
            }

            // dd($final_balnce);
            if ($final_balnce == 0) {
                $performa =   ExportPerforma::find($request->proforma_id);
                $performa->invoice_status = 1;
                $performa->save();
            }
            DB::Connection('mysql2')->commit();
            return redirect()->route('invoiceList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }
    public  function viewInvoiceOrderDetail(Request $request)
    {


        $exportInvoice =  ExportInvoice::find($request['id']);

        $sales_order = SaleOrderExport::find($exportInvoice->sale_order_export_id);
        $export_performa =  ExportPerforma::where('sale_order_id', $sales_order->id)->first();
        $sales_order_data = SaleOrderDataExport::leftjoin('export_invoice_datas', 'export_invoice_datas.sale_order_export_data_id', 'sale_order_data_exports.id')
            ->select(
                DB::raw('COALESCE(sale_order_data_exports.total_qty,0) - COALESCE(sum(export_invoice_datas.issue_qty),0)as remaining '),
                'sale_order_data_exports.*',
                DB::raw('COALESCE(sum(export_invoice_datas.issue_qty),0)as deleverd_qty')
            )
            ->where('sale_order_data_exports.sale_order_export_id', $sales_order->id)
            ->where('export_invoice_datas.export_invoice_id', $request['id'])
            ->groupBy('sale_order_data_exports.id')
            ->get();

        //  $AddionalExpense = DB::Connection('mysql2')->table('addional_expense_sales_order')->where('main_id',$id);

        return view('export.invoice.Ajaxpages.viewInvoiceOrderDetail', compact('exportInvoice', 'sales_order', 'sales_order_data', 'export_performa'));
    }

    public function createExportInvoiceList()
    {
        return view('export.invoice.createExportInvoiceList');
    }

    public function createExportInvoiceListAjax(Request $request)
    {
        $query =  ExportPerforma::join('sale_order_exports', 'sale_order_exports.id', 'export_performas.sale_order_id')
            // ->join('sale_order_data_exports','sale_order_data_exports.sale_order_export_id','sale_order_exports.id')
            ->select(
                'export_performas.*',
                'customers.name as name',
                'sale_order_exports.voucehr_no',
                'sale_order_exports.voucher_date',
                'sale_order_exports.mode_of_term',
                'sale_order_exports.contract_no',
                'sale_order_exports.advance_payment',
                'sale_order_exports.advance_payment_status'
            )
            ->join('customers', 'customers.id', 'sale_order_exports.buyer_id')
            ->where('export_performas.status', 1)
            ->where('export_performas.invoice_status', 0);

        if (!empty($request->EoNo)) {
            $query->where('sale_order_exports.voucehr_no', 'LIKE', '%' . $request->EoNo . '%');
        }
        if (!empty($request->contract)) {
            $query->where('sale_order_exports.contract_no', 'LIKE', '%' . $request->contract . '%');
        }
        if (!empty($request->Proforma)) {
            $query->where('export_performas.proforma_no', 'LIKE', '%' . $request->Proforma . '%');
        }

        $export_performa =  $query->orderBy('id', 'desc')->get();
        return view('export.invoice.Ajaxpages.createExportInvoiceListAjax', compact('export_performa'));
    }


    public function  invoiceCertificate(Request $request)
    {

        $exportInvoices =  ExportInvoice::where(['export_invoices.status' => 1, 'export_invoices.id' => $request->id])
            ->join('sale_order_exports', 'sale_order_exports.id', 'export_invoices.sale_order_export_id')
            ->join('export_performas', 'export_performas.sale_order_id', 'sale_order_exports.id')
            ->leftjoin('inco_terms', 'inco_terms.id', 'sale_order_exports.incoterm')
            ->join('customers', 'customers.id', 'sale_order_exports.buyer_id')
            ->select('export_performas.*', 'customers.name as customer_name', 'customers.address', 'inco_terms.name as icoterm_name', 'sale_order_exports.*', 'export_invoices.*')
            ->first();
        $exportInvoicesData = ExportInvoiceData::where(['export_invoice_datas.status' => 1, 'export_invoice_datas.export_invoice_id' => $request->id])
            ->join('sale_order_data_exports', 'sale_order_data_exports.id', 'export_invoice_datas.sale_order_export_data_id')
            ->join('subitem', 'subitem.id', 'sale_order_data_exports.item_id')
            ->join('sale_order_exports', 'sale_order_exports.id', 'sale_order_data_exports.sale_order_export_id')

            ->select('subitem.pack_size as item_size', 'subitem.sub_ic', 'sale_order_exports.*', 'sale_order_data_exports.*', 'export_invoice_datas.*')
            ->get();

        return view('export.invoice.Ajaxpages.invoiceCertificate', compact('exportInvoices', 'exportInvoicesData'));
    }
    public function billOfLoading(Request $request)
    {
        $pakinglist =  ExportPakingList::join('export_invoices', 'export_invoices.id', 'export_paking_lists.invoice_id')
            ->join('sale_order_exports', 'sale_order_exports.id', 'export_invoices.sale_order_export_id')
            ->join('customers', 'customers.id', 'sale_order_exports.buyer_id')
            ->where(['export_paking_lists.id' => $request->id, 'export_paking_lists.status' => 1])->first();

        $pakinglistdata =  ExportPakingListData::where('import_paking_list_id', $request->id)
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
        return view('export.invoice.Ajaxpages.billOfLoading', compact('pakinglist', 'pakinglistdata'));
    }


    public function editExportInvoice($id)
    {
        $exportInvoice = ExportInvoice::find($id);
        $sale_order =  SaleOrderExport::select(
            'sale_order_exports.*',
            'customers.name as name',
            'export_performas.id as proforma_id',
            'export_performas.pro_contract_no',
            'export_performas.correspondent_bank',
            'export_performas.account_title',
            'export_performas.correspondent_account_usd',
            'export_performas.correspondent_bank_swift',
            'export_performas.details_of_payment'
        )
            ->join('customers', 'customers.id', 'sale_order_exports.buyer_id')
            ->join('export_performas', 'export_performas.sale_order_id', 'sale_order_exports.id')
            ->where('sale_order_exports.status', 1)
            ->where('approved_status', 1)
            ->where('export_performas.id', $exportInvoice->proforma_id)
            ->first();

        $sale_order_data = SaleOrderDataExport::leftjoin('export_invoice_datas', 'export_invoice_datas.sale_order_export_data_id', 'sale_order_data_exports.id')
            ->select(
                DB::raw('COALESCE(sale_order_data_exports.total_qty,0) - COALESCE(sum(export_invoice_datas.issue_qty),0)as remaining '),
                'sale_order_data_exports.*',
                DB::raw('COALESCE(sum(export_invoice_datas.issue_qty),0)as deleverd_qty')
            )
            ->where('export_invoice_datas.status', 1)
            ->where('sale_order_data_exports.sale_order_export_id', $sale_order->id)
            ->groupBy('sale_order_data_exports.id')
            ->get();
        $advance_payment = ExportAdvancePayment::where(['proforma_id' => $sale_order->proforma_id, 'type' => '1'])
            ->select(DB::raw('sum(received_amount) as received_amount'), DB::raw('concat(advance_voucher_no) as advance_voucher_no'))
            ->groupBy('proforma_id')
            ->first();

        $advance_payment_invoice = ExportAdvancePayment::where(['proforma_id' => $sale_order->proforma_id, 'type' => '2'])
            ->select(DB::raw('sum(received_amount) as received_amount'), DB::raw('concat(advance_voucher_no) as advance_voucher_no'))
            ->groupBy('proforma_id')
            ->first();
        $incoterms =  IncoTerm::all();
        $modeofterms =  ModeOfTerm::all();
        $modeoftransports =  ModeOfTransport::all();
        $conversions = Currency::where('status', 1)->get();
        $banks = Bank::where('status', 1)->get();
        return view('export.invoice.editExportInvoice', compact('exportInvoice', 'incoterms', 'modeofterms', 'modeoftransports', 'conversions', 'banks', 'sale_order_data', 'sale_order', 'advance_payment', 'advance_payment_invoice'));
    }

    public function exportInvoiceUpdateDetail(Request $request)
    {
        // dd($request->all());
        DB::Connection('mysql2')->beginTransaction();
        try {
            $final_balnce = 0;
            $exportInvoice = ExportInvoice::find($request->id);
            $exportInvoice->proforma_id =  $request->proforma_id;
            $exportInvoice->ship_name =  $request->ship_name;
            $exportInvoice->bill_of_loading =  $request->bill_of_loading;
            $exportInvoice->master_bl =  $request->master_bl;
            $exportInvoice->consigned_deatils =  $request->consigned_deatils;
            $exportInvoice->sale_order_export_id =  $request->sale_order_id;
            $exportInvoice->commercial_invoice_no =  $request->commercial_invoice_no;
            $exportInvoice->description =  $request->product_description;
            $exportInvoice->invoice_no =  $request->invoice_no;
            $exportInvoice->invoice_date =  $request->invoice_date;
            $exportInvoice->lc_date_no =  $request->lc_date;
            $exportInvoice->form_no =  json_encode($request->form_no);
            $exportInvoice->status =  1;
            $exportInvoice->save();
            ExportCommercialNotifyAddress::where('commercial_invoice_id', $request->id)->update(['status' => 0]);
            foreach ($request->notify_address ?? [] as $key => $notify_address) {
                if (!empty($notify_address)) {
                    ExportCommercialNotifyAddress::create([
                        'commercial_invoice_id' => $exportInvoice->id,
                        'notify_address' => $notify_address,
                    ]);
                }
            }
            ExportInvoiceData::where('export_invoice_id', $request->id)->update(['status' => 0]);
            foreach ($request->sub_ic_des as $key => $item) {
                $exportInvoiceData = new ExportInvoiceData;
                $exportInvoiceData->export_invoice_id =  $exportInvoice->id;
                $exportInvoiceData->sale_order_export_data_id = $request->sale_order_data_id[$key];
                $exportInvoiceData->issue_qty = $request->issue_qty[$key];
                $exportInvoiceData->gross_weight = $request->gross_weight[$key];
                $exportInvoiceData->remaing_qty = $request->reamining[$key];
                $exportInvoiceData->brand = $request->brand[$key];
                $exportInvoiceData->status = 1;
                $exportInvoiceData->save();
                $final_balnce += $request->actual_qty[$key] -  $request->issue_qty[$key] -  $request->deleverd_qty[$key];
            }
            ExportAdvancePayment::where('invoice_id', $request->id)->update(['status' => 0]);
            if (!empty($request->advance_payment_settelemnt) || $request->advance_payment_settelemnt != 0) {
                $str = DB::connection('mysql2')->selectOne("select max(convert(substr(`advance_voucher_no`,4,length(substr(`advance_voucher_no`,4))-4),signed integer)) reg from `export_advance_payments` where substr(`advance_voucher_no`,-4,2) = " . date('m') . " and substr(`advance_voucher_no`,-2,2) = " . date('y') . "")->reg;
                $EAPV = 'EAP' . ($str + 1) . date('my');
                // $sales_adv_acc_id = DB::Connection('mysql2')->table('accounts')->where('status', 1)->where('name', 'like', '%' . 'Export Advance Payment' . '%')->select('id')->first()->id;
                $sales_adv_acc_id = DB::Connection('mysql2')->table('customers')->where('status', 1)->where('name', $request->buyers_id)->select('acc_id')->first()->acc_id;
                $response =  new  ExportAdvancePayment;
                $response->advance_voucher_no = $EAPV;
                $response->proforma_id = $request->proforma_id;
                $response->invoice_id = $exportInvoice->id;
                $response->invoice_data_id = 0;
                $response->type = 2;
                $response->cr = $sales_adv_acc_id; //For temprory Time 
                $response->dr = 330;
                $response->advance_percent = 0;
                $response->advance_amount = 0;
                $response->received_amount = $request->advance_payment_settelemnt;
                $response->description = $request->description;
                $response->status = 1;
                $response->save();
            }
            if ($final_balnce == 0) {
                $performa =   ExportPerforma::find($request->proforma_id);
                $performa->invoice_status = 1;
                $performa->save();
            }
            DB::Connection('mysql2')->commit();
            return redirect()->route('invoiceList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }
}
