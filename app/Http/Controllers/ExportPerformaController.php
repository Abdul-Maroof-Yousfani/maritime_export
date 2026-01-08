<?php

namespace App\Http\Controllers;

use App\Models\ExportPerforma;
use Illuminate\Http\Request;
use App\Models\SaleOrderExport;
use App\Models\SaleOrderDataExport;
use App\Models\Subitem;
use App\Models\ModeOfTerm;
use App\Models\ModeOfTransport;
use App\Models\IncoTerm;
use App\Models\Bank;
use App\Models\Currency;
use Illuminate\Support\Facades\Session;
use DB;

class ExportPerformaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function proformaList()
    {
       
       return view('export.proforma.proformaList');
    }

    public function proformaListListAjax(Request $request)
    {
        $query =  SaleOrderExport::select('sale_order_exports.*','customers.name as name')
        ->join('customers','customers.id','sale_order_exports.buyer_id')
        ->where('sale_order_exports.status',1)
        ->where('sale_order_exports.proforma_status',0)
        ->where('sale_order_exports.approved_status',1);

        if(!empty($request->EoNo))
        {
            $query->where('voucehr_no','LIKE','%'.$request->EoNo.'%');
        }
        if(!empty($request->contract))
        {
            $query->where('contract_no','LIKE','%'.$request->contract.'%');
        }
       $sale_order = $query->orderBy('id', 'desc')->get();
        return view('export.proforma.proformaListAjax',compact('sale_order'));
    }

    public function proformaCreateForm(Request $request)
    {
        $sale_order =  SaleOrderExport::select('sale_order_exports.*','customers.name as name')
        ->join('customers','customers.id','sale_order_exports.buyer_id')
        ->where('sale_order_exports.status',1)
        ->where('approved_status',1)
        ->where('sale_order_exports.id',$request->id)
        ->first(); 
        $sale_order_data = SaleOrderDataExport::where('sale_order_export_id',$request->id)->where('status', 1)->get();
            $incoterms =  IncoTerm::all();
            $modeofterms =  ModeOfTerm::all();
            $modeoftransports =  ModeOfTransport::all();
            $conversions = Currency::where('status',1)->get();
            $banks = Bank::where('status',1)->get();
        return view('export.proforma.proformaCreateForm',compact('incoterms','modeofterms','modeoftransports','conversions','banks','sale_order_data','sale_order'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function proformaStore(Request $request)
    {
     
       $str = DB::connection('mysql2')->selectOne("select max(convert(substr(`proforma_no`,4,length(substr(`proforma_no`,4))-4),signed integer)) reg from `export_performas` where substr(`proforma_no`,-4,2) = " . date('m') . " and substr(`proforma_no`,-2,2) = " . date('y') . "")->reg;
      $proforma = 'PRO' . ($str + 1) . date('my');
          
      $response = new ExportPerforma;
      $response->sale_order_id = $request->id;
      $response->proforma_no = $proforma;
      $response->pro_contract_no = $request->pro_contract_no;
      $response->eo_voucher_no = $request->voucher_no;
      $response->account_title = $request->account_title??'';
      $response->correspondent_bank =$request->correspondent_bank ??'';
      $response->correspondent_account_usd = $request->correspondent_account??'';
      $response->correspondent_bank_swift = $request->correspondent_swift??"";
      $response->details_of_payment = $request->payment_details;
      $response->status = 1;
      $sale_order = SaleOrderExport::find($request->id);
      $sale_order->proforma_status =1;
      $sale_order->save();

      if($response->save()){
        Session::flash('dataInsert','successfully saved.');
        return redirect()->route('createdProformaList');
      }else{
        Session::flash('error','data not save');
        return redirect()->route('proformaCreateForm',$request->id);
      }

    }

    
    public function proformaDelete(Request $request)
    {
       
        DB::Connection('mysql2')->beginTransaction();
        try {
        
            $data['status'] = 0;
            DB::Connection('mysql2')->table('export_performas')->where('id', $request->id)->update($data);   
            
            $data1['proforma_status'] = 0;
            $export =  ExportPerforma::find($request->id);
            DB::Connection('mysql2')->table('sale_order_exports')->where('id',$export->sale_order_id)->update($data1);   
            DB::Connection('mysql2')->commit();
            return $request->id;
             } catch (Exception $ex) {
     
                 DB::rollBack();
                 dd($ex);
                 $ex->getCode();
             }
     
       
    }

    public function createdProformaList()
    {
        return view('export.proforma.createdProformaList');
    }

    public function createdProformaAjax(Request $request)
    {
      $query =  ExportPerforma::join('sale_order_exports','sale_order_exports.id','export_performas.sale_order_id')
        // ->join('sale_order_data_exports','sale_order_data_exports.sale_order_export_id','sale_order_exports.id')
        ->select('export_performas.*','customers.name as name','sale_order_exports.voucehr_no','export_performas.created_at','sale_order_exports.mode_of_term','sale_order_exports.contract_no','sale_order_exports.advance_payment','sale_order_exports.advance_payment_status')
        ->join('customers','customers.id','sale_order_exports.buyer_id')
        ->where('export_performas.status',1);
        if(!empty($request->EoNo))
        {
            $query->where('sale_order_exports.voucehr_no','LIKE','%'.$request->EoNo.'%');
        }
        if(!empty($request->contract))
        {
            $query->where('sale_order_exports.contract_no','LIKE','%'.$request->contract.'%');
        }
        if(!empty($request->proforma))
        {
            $query->where('export_performas.proforma','LIKE','%'.$request->proforma.'%');
        }

        $export_performa =  $query->orderBy('id', 'desc')->get();
        return view('export.proforma.createdProformaAjax',compact('export_performa'));
    }

    public  function proformaViewDeatils(Request $request)
    {
        // dd($request->all());
        $id= $request->id;
        $sales_order=new SaleOrderExport();
        $sales_order=$sales_order->SetConnection('mysql2');
        $sales_order=$sales_order->where('id',$id)->first();


        $sales_order_data = new SaleOrderDataExport();
        $sales_order_data = $sales_order_data->SetConnection('mysql2');
        $sales_order_data =  $sales_order_data->where('sale_order_export_id',$id)->get();
        $export = ExportPerforma::where('sale_order_id',$id)->first();
       
        return view('export.proforma.proformaViewDeatils',compact('sales_order','sales_order_data','export'));
    }

    public function proformaInvoice(Request $request)
    {
        // dd($request->all());
      $ExportPerforma =  ExportPerforma::join('sale_order_exports','sale_order_exports.id','export_performas.sale_order_id')
      ->join('customers','customers.id','sale_order_exports.buyer_id')
      ->where(['export_performas.status'=>1,'export_performas.id'=>$request->id])->first();

      $sales_order_data = SaleOrderDataExport::where(['sale_order_export_id'=>$ExportPerforma->sale_order_id,'status'=>1])
      ->select(DB::raw('sum(after_dis_amount) as total_amount'))
      ->groupBy('sale_order_export_id')
      ->first();
    
        return view('export.proforma.proformInvoice', compact('ExportPerforma','sales_order_data'));
    }

}
