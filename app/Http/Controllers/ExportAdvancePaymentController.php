<?php

namespace App\Http\Controllers;

use App\Models\ExportAdvancePayment;
use App\Models\Customer;
use App\Models\ExportPerforma;
use App\Models\ExportPakingList;
use App\Models\SaleOrderDataExport;
use App\Models\ExportPakingListData;
use App\Models\ExportInvoice;
use App\Models\ExportInvoiceData;
use App\Models\SaleOrderExport;
use App\Models\Transactions;
use App\Helpers\FinanceHelper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExportAdvancePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addAdvancePayment($id)
    {
        // dd($id);
       $data =  ExportPerforma::join('sale_order_exports','sale_order_exports.id','export_performas.sale_order_id')
       ->select('sale_order_exports.id as sale_order_export_id','sale_order_exports.*','export_performas.id as proforma_id','export_performas.proforma_no') 
       ->where('export_performas.id',$id)->first();
       $export_data = SaleOrderDataExport::where('sale_order_export_id',$data->sale_order_export_id)->where('status', 1)->select(DB::raw('sum(after_dis_amount) as total_amount'))->first();
       $customer = Customer::where('status',1)->get();
       $advance_payment = ExportAdvancePayment::where('proforma_id',$data->proforma_id)->select(DB::raw('sum(received_amount) as received_amount'))->groupBy('proforma_id')->first();
        
       return view('export.advancepayment.advance_payment',compact('customer','data','export_data','advance_payment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addvancePaymentStore(Request $request)
    {
       
       DB::Connection('mysql2')->beginTransaction();
       try {
        $str = DB::connection('mysql2')->selectOne("select max(convert(substr(`advance_voucher_no`,4,length(substr(`advance_voucher_no`,4))-4),signed integer)) reg from `export_advance_payments` where substr(`advance_voucher_no`,-4,2) = " . date('m') . " and substr(`advance_voucher_no`,-2,2) = " . date('y') . "")->reg;
        $EAPV = 'EAP' . ($str + 1) . date('my');
    
      $response =  new  ExportAdvancePayment;
      $response->advance_voucher_no = $EAPV;
      $response->proforma_id = $request->proforma_id;
      $response->type =1;
      $response->cr = $request->buyer_id;
      $response->dr = $request->account_id;
      $response->advance_percent = $request->advance_in_percent;
      $response->advance_amount = $request->advance_amount;
      $response->received_amount = $request->received_amount;
      $response->description = $request->description;
      $response->status = 1;
      $response->save();
      

        // Buyer Credit Amount Transaction
      $transaction=new Transactions();
      $transaction=$transaction->SetConnection('mysql2');
      $transaction->voucher_no=$EAPV;
      $transaction->v_date= date('Y-m-d');
      $transaction->acc_id= $request->buyer_id;
      $transaction->acc_code=FinanceHelper::getAccountCodeByAccId($request->buyer_id);
      $transaction->particulars=$request->description;
      $transaction->opening_bal=0;
      $transaction->debit_credit=0;
      $transaction->amount=$request->received_amount;
      $transaction->username=Auth::user()->name;
      $transaction->status=1;
      $transaction->voucher_type=20;
      // $transaction->save();


      $transaction=new Transactions();
      $transaction=$transaction->SetConnection('mysql2');
      $transaction->voucher_no=$EAPV;
      $transaction->v_date= date('Y-m-d');
      $transaction->acc_id=$request->account_id;
      $transaction->acc_code=FinanceHelper::getAccountCodeByAccId($request->account_id);
      $transaction->particulars=$request->description;
      $transaction->opening_bal=0;
      $transaction->debit_credit=1;
      $transaction->amount=$request->received_amount;
      $transaction->username=Auth::user()->name;;
      $transaction->status=1;
      $transaction->voucher_type=20;
      // $transaction->save();
      $received_amount =   $request->received_amount + $request->already_received;
      if($received_amount < $request->advance_amount)
      {
        $sale_order = SaleOrderExport::find($request->export_order_id);
        $sale_order->advance_payment_status = 2;
        $sale_order->advance_payment = $request->advance_in_percent;
        $sale_order->save();
        $response->payment_status = 2;
        $response->save();

      
      }else if($received_amount ==  $request->advance_amount)
      {
        $sale_order = SaleOrderExport::find($request->export_order_id);
        $sale_order->advance_payment_status = 1;
        $sale_order->advance_payment = $request->advance_in_percent;
        $sale_order->save();
        $response->payment_status = 1;
        $response->save();

      }

      DB::Connection('mysql2')->commit();
      return redirect()->route('importPakingList');
            } catch (Exception $ex) {
            
                DB::rollBack();
                dd($ex);
                $ex->getCode();
            }
    }



    public function viewSettelment(Request $request)
    {
      $export_packing =   ExportPakingList::find($request->id);

      $export_packing_data = ExportPakingListData::where('import_paking_list_id',$export_packing->id)->first();
      $export_advance = ExportAdvancePayment::where('invoice_data_id',$export_packing_data->invoice_data_id)->first();
      $export_invoice = ExportInvoice::join('sale_order_exports','sale_order_exports.id','export_invoices.sale_order_export_id')
      ->where('export_invoices.id',$export_packing->invoice_id)->first();
      $export_invoice_data = ExportInvoiceData::join('sale_order_data_exports','sale_order_data_exports.id','export_invoice_datas.sale_order_export_data_id')
      ->where('export_invoice_datas.id', $export_packing_data->invoice_data_id)->get();
       return view('export.advancepayment.viewSettelment',compact('export_invoice_data','export_invoice','export_advance','export_packing_data','export_packing'));
     
    }
    public function advanceReconciliation()
    {
        return view('export.advancepayment.advanceReconciliation');
    }
    public function advanceReconciliationAjax(Request $request)
    {
      

    $query =   ExportPerforma::where('status',1);

    if(!empty($request->proforma))
    {
      $proforma = $query->where('proforma_no',$request->proforma)->first();

    }
   $export_advance = ExportAdvancePayment::join('export_performas','export_performas.id','export_advance_payments.proforma_id')->where(['proforma_id'=>$proforma->id,'type'=>'1'])->get();
   $export_advance_concillation = ExportAdvancePayment::join('export_performas','export_performas.id','export_advance_payments.proforma_id')
   ->join('export_invoices','export_invoices.id','export_advance_payments.invoice_id')
   ->where(['export_advance_payments.proforma_id'=>$proforma->id,'type'=>'2'])->get();
   $export_invoice_amount = ExportAdvancePayment::join('export_performas','export_performas.id','export_advance_payments.proforma_id')
   ->join('export_invoices','export_invoices.id','export_advance_payments.invoice_id')
   ->where(['export_advance_payments.proforma_id'=>$proforma->id,'type'=>'3'])->get();
   $data =[
    'export_advance'=>$export_advance,
    'export_advance_concillation'=>$export_advance_concillation,
    'export_invoice_amount'=>$export_invoice_amount
   ];
   return $data;
    }
}
