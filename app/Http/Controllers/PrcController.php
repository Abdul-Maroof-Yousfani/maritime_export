<?php

namespace App\Http\Controllers;

use App\Models\Prc;
use App\Models\PrcConciliation;
use App\Models\Bank;
use App\Models\ExportInvoice;
use App\Models\ExportInvoiceData;
use DB;
use Illuminate\Http\Request;

class PrcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function prcList()
    {
        return view('export.prc.prcList');
    }
    public function prcListAjax()
    {
        $prcs =  Prc::join('banks','banks.id','prcs.bank_id')->select('prcs.id as prc_id','banks.*','prcs.*')->get();
     
        return view('export.prc.prcListAjax',compact('prcs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPrc()
    {
       $banks =  Bank::all();
     
       return view('export.prc.createPrc',compact('banks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createPrcStore(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
            $str = DB::connection('mysql2')->selectOne("select max(convert(substr(`prc_no`,4,length(substr(`prc_no`,4))-4),signed integer)) reg from `prcs` where substr(`prc_no`,-4,2) = " . date('m') . " and substr(`prc_no`,-2,2) = " . date('y') . "")->reg;
            $prc_no = 'PRC' . ($str + 1) . date('my');

            $prc = new Prc;
            $prc->bank_id = $request->bank_id ;
            $prc->prc_no =$prc_no;
            $prc->date = $request->book_date ;
            $prc->amount = $request->book_amount ;
            $prc->fwd_no = $request->fwd_no ;
            $prc->fwd_typ = $request->fwd_typ ;
            $prc->rate = $request->rate ;
            $prc->start_date = $request->start_date ;
            $prc->maturity = $request->maturity_date ;
            $prc->balance = $request->balance ;
            $prc->fixed_date = $request->fixed ;
            $prc->option_date = $request->option ;
            $prc->status = 1;
            $prc->save();
      DB::Connection('mysql2')->commit();
      return redirect()->route('prcList');
     
  } catch (Exception $ex) {
   
      DB::rollBack();
      dd($ex);
      $ex->getCode();
  }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Prc  $prc
     * @return \Illuminate\Http\Response
     */
    public function prcReconciliation(Request $request)
    {
        $prc = Prc::find($request->id);
        $banks =  Bank::all();
        $export_invoice =  ExportInvoice::where('status',1)->get();
        return view('export.prc.prcReconciliation',compact('prc','banks','export_invoice'));
    }
    public function getInvoice(Request $request)
    {   
     return   ExportInvoiceData::where('export_invoice_datas.export_invoice_id',$request->id)
     ->join('sale_order_data_exports','sale_order_data_exports.id','export_invoice_datas.sale_order_export_data_id')
     ->join('sale_order_exports','sale_order_exports.id','sale_order_data_exports.sale_order_export_id')
     ->leftjoin('currency','currency.id','sale_order_exports.currencey_id')
     ->select(
     'currency.curreny',
     'export_invoice_datas.*',
     'sale_order_data_exports.*','sale_order_exports.currencey_rate')
     ->get();
    }

    public function prcReconciliationStore(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
            $str = DB::connection('mysql2')->selectOne("select max(convert(substr(`conciliation_no`,4,length(substr(`conciliation_no`,4))-4),signed integer)) reg from `prc_conciliations` where substr(`conciliation_no`,-4,2) = " . date('m') . " and substr(`conciliation_no`,-2,2) = " . date('y') . "")->reg;
            $conciliation_no = 'PRC' . ($str + 1) . date('my');

         $prcConciliation = new PrcConciliation;
         $prcConciliation->conciliation_no = $conciliation_no;
         $prcConciliation->prc_id = $request->prc_id;
         $prcConciliation->invoice_id = $request->invoice_id;
         $prcConciliation->invoice_amount = $request->invoice_amount;
         $prcConciliation->booking_amount = $request->book_amount;
         $prcConciliation->total_amount = $request->invoice_amount;
         $prcConciliation->currency_rate = $request->currency_rate;
         $prcConciliation->currency_name = $request->currency_name;
         $prcConciliation->status = 1;
         $prcConciliation->save();

        $final_amount = $request->balance - $request->invoice_amount;

         $export_invoice =  ExportInvoice::find($request->invoice_id);
         $export_invoice->prc_reconciliation_status = 1;
         $export_invoice->save();

         if($final_amount == 0){
                $prc = Prc::find($request->prc_id);
                $prc->conciliation_status = 2;
                $prc->save();
            }else{
                $prc = Prc::find($request->prc_id);
  
                $prc->conciliation_status = 1;
                $prc->balance = $final_amount;
                $prc->save();
            }
         DB::Connection('mysql2')->commit();
         return redirect()->route('prcList');
        
     } catch (Exception $ex) {
      
         DB::rollBack();
         dd($ex);
         $ex->getCode();
     }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Prc  $prc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prc $prc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Prc  $prc
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prc $prc)
    {
        //
    }
}
