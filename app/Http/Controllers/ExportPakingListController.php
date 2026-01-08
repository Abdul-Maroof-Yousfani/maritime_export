<?php

namespace App\Http\Controllers;

use App\Models\ExportPakingList;
use App\Models\ExportPakingListData;
use Illuminate\Http\Request;
use App\Models\ExportInvoice;
use App\Models\ExportInvoiceData;
use App\Models\SaleOrderExport;
use App\Models\SaleOrderDataExport;
use App\Helpers\FinanceHelper;
use App\Models\Subitem;
use App\Helpers\ReuseableCode;
use App\Models\ExportAdvancePayment;
use App\Models\Transactions;
use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ExportPakingListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importPakingList()
    {
        return view('export.pakinglist.importPakingList');
    }

    public function importPakingListAjax(Request $request)
    {
       $query = ExportPakingList::join('export_invoices','export_invoices.id','export_paking_lists.invoice_id')
       ->join('export_performas','export_performas.id','export_invoices.proforma_id')
       ->select('export_paking_lists.*','export_invoices.commercial_invoice_no','export_performas.pro_contract_no','export_performas.id as proforma_id','export_invoices.id as invoice_id')
       ->where('export_paking_lists.status',1);
      
       if(!empty($request->export_packing_no))
       {
           $query->where('export_paking_lists.import_no','LIKE','%'.$request->export_packing_no.'%');
       }
       if(!empty($request->commercial))
       {
           $query->where('export_invoices.commercial_invoice_no','LIKE','%'.$request->commercial.'%');
       }
       if(!empty($request->proforma))
       {
           $query->where('export_performas.pro_contract_no','LIKE','%'.$request->proforma.'%');
       }
 
       $exportpakingList =   $query->orderBy('id', 'desc')->get();

        return view('export.pakinglist.importPakingListAjax',compact('exportpakingList'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createExportPaking(Request $request)
    {
        $exportInvoice =  ExportInvoice::find($request['id']);
        $exportInvoiceDataSum =  ExportInvoiceData::select(DB::raw('sum(issue_qty) as issue_qty'), DB::raw('sum(gross_weight) as gross_weight'))->where('export_invoice_id', $request['id'])->where('status', 1)->first();
        $exportInvoiceData = ExportInvoiceData::where('export_invoice_id', $request['id'])->where('status', 1);
        $exportInvoiceDataPluckExportDataId = $exportInvoiceData->pluck('sale_order_export_data_id');
        $exportInvoiceData = $exportInvoiceData->get();

        $exportOrderDataSum = ExportInvoiceData::join('sale_order_data_exports', 'sale_order_data_exports.id', 'export_invoice_datas.sale_order_export_data_id')
        ->where('sale_order_data_exports.status', 1)
        ->where('export_invoice_datas.status', 1)
        ->where('export_invoice_datas.export_invoice_id', $request['id'])
        ->selectRaw('SUM(export_invoice_datas.issue_qty / sale_order_data_exports.pack_size) AS total')
        ->value('total');

        $exportOrderDataSum = $exportOrderDataSum * 1000;
        
        // $exportOrderDataSum =  SaleOrderDataExport::whereIn('id', $exportInvoiceDataPluckExportDataId)->where('status', 1)->sum('total_qty');
        // dd($exportOrderDataSum);
        $sales_order = SaleOrderExport::join('export_performas','export_performas.sale_order_id','sale_order_exports.id')
        ->select('sale_order_exports.*','export_performas.pro_contract_no')
        ->where('sale_order_exports.id',$exportInvoice->sale_order_export_id)->first();
     
        $sales_order_data = SaleOrderDataExport::join('export_invoice_datas','export_invoice_datas.sale_order_export_data_id','sale_order_data_exports.id')
        ->select(
          DB::raw('COALESCE(sale_order_data_exports.total_qty,0) - COALESCE(sum(export_invoice_datas.issue_qty),0)as remaining '),
         'sale_order_data_exports.*','export_invoice_datas.id as export_invoice_data_id','export_invoice_datas.paking_list_upload_status'
         ,DB::raw('COALESCE(sum(export_invoice_datas.issue_qty),0)as deleverd_qty'))
         ->where('sale_order_data_exports.sale_order_export_id',$sales_order->id)
         ->where('export_invoice_datas.export_invoice_id',$request['id'])
         ->groupBy('sale_order_data_exports.id')
         ->get();
         
        $export_advance_amount =   ExportAdvancePayment::where(['invoice_id'=>$exportInvoice->id,'type'=>'2'])
        ->select(DB::raw('sum(received_amount) as received_amount'))
        ->first();

         //  $AddionalExpense = DB::Connection('mysql2')->table('addional_expense_sales_order')->where('main_id',$id);
     
             return view('export.pakinglist.createExportPaking',compact('exportInvoice', 'exportInvoiceDataSum', 'exportInvoiceData', 'exportOrderDataSum', 'sales_order','sales_order_data','export_advance_amount'));
         
    }

    public function viewPaking(Request $request)
    {
       
      $pakinglist =  ExportPakingList::find($request->id);
    //   $exportInvoice =  ExportInvoice::find($pakinglist->invoice_id);
        $exportInvoice = ExportInvoice::join('sale_order_exports', 'sale_order_exports.id', '=', 'export_invoices.sale_order_export_id')
        ->join('export_performas', 'export_performas.sale_order_id', '=', 'sale_order_exports.id')
        ->where('export_invoices.id', $pakinglist->invoice_id)
        ->select('export_invoices.*', 'export_performas.pro_contract_no')
        ->first();
      $pakinglistdata =  ExportPakingListData::where('import_paking_list_id',$pakinglist->id)->where('status', 1);
      $exportOrder =  SaleOrderExport::find($exportInvoice->sale_order_export_id);
      $exportOrderData =  SaleOrderDataExport::where('sale_order_export_id', $exportOrder->id)->where('status', 1)->first();
        return view('export.pakinglist.viewPaking',compact('pakinglist', 'exportOrderData', 'pakinglistdata', 'exportOrder', 'exportInvoice'));
    }


    public function viewpakingListInvoice(Request $request)
    {
        $pakinglist =  ExportPakingList::join('export_invoices','export_invoices.id','export_paking_lists.invoice_id')
        ->join('sale_order_exports','sale_order_exports.id','export_invoices.sale_order_export_id')
        ->where(['export_paking_lists.id'=>$request->id,'export_paking_lists.status'=>1])->first();

        $pakinglistdata =  ExportPakingListData::where('import_paking_list_id',$request->id)->get();
        return view('export.pakinglist.viewpakingListInvoice',compact('pakinglist','pakinglistdata'));
    }
    
    public function pakingListInvoiceEdit(Request $request)
    {
        $pakinglist = ExportPakingList::where(['export_paking_lists.id'=>$request->id,'export_paking_lists.status'=>1])->first();
 
        $pakinglistdata =  ExportPakingListData::where('import_paking_list_id',$request->id)->where('status', 1)->get();

        return view('export.pakinglist.pakingListInvoiceEdit',compact('pakinglist','pakinglistdata'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pakingListUpdate(Request $request)
    {

        
        $request['invoice_data_id'] =  ExportInvoiceData::where('export_invoice_id', $request->invoice_id)->where('status', 1)->first()->id;
        // dd($request->all());
        
        DB::Connection('mysql2')->beginTransaction();
        try {
            $total_amount_with_exchange_rate = 0;
            $tax_amount=0;

            $pakinglist = ExportPakingList::find($request->paking_id);
            // $pakinglist->import_no = $IMP;
            $pakinglist->import_date = $request->packaging_invoice_date;
            $pakinglist->invoice_id = $request->invoice_id;
            $pakinglist->total_qty = $request->no_of_bags;
            $pakinglist->packing_description =  $request->description;
            $pakinglist->consignee =  $request->consignee;
            $pakinglist->notify =  $request->notify;
            $pakinglist->status =  1;
            $pakinglist->username = Auth::user()->name;
            $pakinglist->save();


            $exportInvoice  = ExportInvoice::find($request->invoice_id);
            $sales_order    = SaleOrderExport::find($exportInvoice->sale_order_export_id);
            $revenue        = Customer::find($sales_order->buyer_id);

            ExportPakingListData::where('import_paking_list_id', $request->paking_id)->update(['status' => 0]);
            foreach($request->qty as $key=>$value)
            {
                if(!empty($value)){
                $pakinglistdata = new ExportPakingListData;
                $pakinglistdata->import_paking_list_id = $pakinglist->id;
                $pakinglistdata->container = $request->container[$key];
                $pakinglistdata->invoice_data_id = $request->invoice_data_id;
                $pakinglistdata->gross_weight = $request->gross_weight[$key];
                $pakinglistdata->net_weight = $request->net_weight[$key];
                $pakinglistdata->qty = $request->qty[$key];
            
                $pakinglistdata->status =  1;
                $pakinglistdata->username = Auth::user()->name;
                $pakinglistdata->save();

                $invoice = ExportInvoiceData::find($request->invoice_data_id);
                $invoice->paking_list_upload_status = 1;
                $invoice->save();

            $sales_order_data = SaleOrderDataExport::find($invoice->sale_order_export_data_id);

            $exchange_rate = ($sales_order->currencey_rate <= 0)? 1  : $sales_order->currencey_rate;
                    $total_amount_with_exchange_rate += $request->qty[$key]*$sales_order_data->rate*$exchange_rate;
                    if(!empty($sales_order_data->tax)){
                        $tax_amount +=  $total_amount_with_exchange_rate/100*$sales_order_data->tax;
                    }
                }
            }
            // $export_advance_amount =   ExportAdvancePayment::where('invoice_id',$request->invoice_id)
            // ->select(DB::raw('sum(received_amount) as received_amount'))
            // ->first();
            // if(isset($export_advance_amount) || !empty($export_advance_amount))
            // {
            //     $str = DB::connection('mysql2')->selectOne("select max(convert(substr(`advance_voucher_no`,4,length(substr(`advance_voucher_no`,4))-4),signed integer)) reg from `export_advance_payments` where substr(`advance_voucher_no`,-4,2) = " . date('m') . " and substr(`advance_voucher_no`,-2,2) = " . date('y') . "")->reg;
            //         $EAPV = 'EAP' . ($str + 1) . date('my');
                
            //     $response =  new  ExportAdvancePayment;
            //     $response->advance_voucher_no = $EAPV;
            //     $response->invoice_id = $request->invoice_id;
            //     $response->invoice_data_id = $request->invoice_data_id;
            //     $response->proforma_id = $exportInvoice->proforma_id;
            //     $response->type =3;
            //     $response->cr = $request->acc_id;
            //     $response->dr = $revenue->acc_id;
            //     $response->advance_percent = 0;
            //     $response->advance_amount = 0;
            //     $response->received_amount = $total_amount_with_exchange_rate;
            //     $response->description = 'test';
            //     $response->status = 1;
            //     $response->save();
            //     $advance_payment  = $export_advance_amount->received_amount;
            // }else{
            //     $advance_payment = 0;
            // }
            $invoice = ExportInvoice::find($request->invoice_id);
            $invoice->import_paking_status = 1;
            $invoice->save();
        // }
        DB::Connection('mysql2')->commit();
        return redirect()->route('importPakingList');
        } catch (Exception $ex) {
        
            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }

    }

    public function pakingListStore(Request $request)
    {

        
        $request['invoice_data_id'] =  ExportInvoiceData::where('export_invoice_id', $request->invoice_id)->where('status', 1)->first()->id;
        // dd($request->all());
        
        DB::Connection('mysql2')->beginTransaction();
        try {
            $total_amount_with_exchange_rate =0;
            $tax_amount=0;
            $str = DB::connection('mysql2')->selectOne("select max(convert(substr(`import_no`,4,length(substr(`import_no`,4))-4),signed integer)) reg from `export_paking_lists` where substr(`import_no`,-4,2) = " . date('m') . " and substr(`import_no`,-2,2) = " . date('y') . "")->reg;
            $IMP = 'CIPL' . ($str + 1) . date('my');
                    $pakinglist = new ExportPakingList;
                    $pakinglist->import_no = $IMP;
                    $pakinglist->import_date = $request->packaging_invoice_date;
                    $pakinglist->invoice_id = $request->invoice_id;
                    $pakinglist->total_qty = $request->no_of_bags;
                    $pakinglist->packing_description =  $request->description;
                    $pakinglist->consignee =  $request->consignee;
                    $pakinglist->notify =  $request->notify;
                    $pakinglist->status =  1;
                    $pakinglist->username = Auth::user()->name;
                    $pakinglist->save();


                    $exportInvoice  = ExportInvoice::find($request->invoice_id);
                    $sales_order    = SaleOrderExport::find($exportInvoice->sale_order_export_id);
                    $revenue        = Customer::find($sales_order->buyer_id);

        foreach($request->qty as $key=>$value)
        {
            if(!empty($value)){
            $pakinglistdata = new ExportPakingListData;
            $pakinglistdata->import_paking_list_id = $pakinglist->id;
            $pakinglistdata->container = $request->container[$key];
            $pakinglistdata->invoice_data_id = $request->invoice_data_id;
            $pakinglistdata->gross_weight = $request->gross_weight[$key];
            $pakinglistdata->net_weight = $request->net_weight[$key];
            $pakinglistdata->qty = $request->qty[$key];
            // $pakinglistdata->vechle = $request->vechle[$key];
            // $pakinglistdata->date_of_empty =$request->date_of_empty[$key];
            // $pakinglistdata->date_of_loading = $request->date_of_loading[$key];
            // $pakinglistdata->loading_port = $request->loading_port[$key];
            $pakinglistdata->status =  1;
            $pakinglistdata->username = Auth::user()->name;
            $pakinglistdata->save();

            


            // $item_id = Subitem::where('sub_ic','LIKE',$request->item[$key])->first();
            // ReuseableCode::post_stock($item_id->id, $request->warehouse_id, 0, $pakinglist->id, $pakinglistdata->id, $IMP, date('Y-m-d'), $request->qty[$key],12);
          
            $invoice = ExportInvoiceData::find($request->invoice_data_id);
            $invoice->paking_list_upload_status = 1;
            $invoice->save();

           $sales_order_data = SaleOrderDataExport::find($invoice->sale_order_export_data_id);

           $exchange_rate = ($sales_order->currencey_rate <= 0)? 1  : $sales_order->currencey_rate;
                $total_amount_with_exchange_rate += $request->qty[$key]*$sales_order_data->rate*$exchange_rate;
                if(!empty($sales_order_data->tax)){
                    $tax_amount +=  $total_amount_with_exchange_rate/100*$sales_order_data->tax;
                }
            }
        }
        $export_advance_amount =   ExportAdvancePayment::where('invoice_id',$request->invoice_id)
        ->select(DB::raw('sum(received_amount) as received_amount'))
        ->first();
        if(isset($export_advance_amount) || !empty($export_advance_amount))
        {
            $str = DB::connection('mysql2')->selectOne("select max(convert(substr(`advance_voucher_no`,4,length(substr(`advance_voucher_no`,4))-4),signed integer)) reg from `export_advance_payments` where substr(`advance_voucher_no`,-4,2) = " . date('m') . " and substr(`advance_voucher_no`,-2,2) = " . date('y') . "")->reg;
                $EAPV = 'EAP' . ($str + 1) . date('my');
               
            $response =  new  ExportAdvancePayment;
            $response->advance_voucher_no = $EAPV;
            $response->invoice_id = $request->invoice_id;
            $response->invoice_data_id = $request->invoice_data_id;
            $response->proforma_id = $exportInvoice->proforma_id;
            $response->type =3;
            $response->cr = $request->acc_id;
            $response->dr = $revenue->acc_id;
            $response->advance_percent = 0;
            $response->advance_amount = 0;
            $response->received_amount = $total_amount_with_exchange_rate;
            $response->description = 'test';
            $response->status = 1;
            $response->save();
            //   $sales_adv_acc_id= DB::Connection('mysql2')->table('accounts')->where('status',1)->where('name','like','%' .'EXPORT ADVANCE PAYMENT'. '%')->select('id')->first()->id;
            //   $transaction=new Transactions();
            //   $transaction=$transaction->SetConnection('mysql2');
            //   $transaction->voucher_no=$IMP;
            //   $transaction->v_date= date('Y-m-d');
            //   $transaction->acc_id= $sales_adv_acc_id;
            //   $transaction->acc_code=FinanceHelper::getAccountCodeByAccId($sales_adv_acc_id);
            //   $transaction->particulars="INVOICE SETTELEMENT";
            //   $transaction->opening_bal=0;
            //   $transaction->debit_credit=0;
            //   $transaction->amount=$export_advance_amount->received_amount;
            //   $transaction->username=Auth::user()->name;
            //   $transaction->status=1;
            //   $transaction->voucher_type=20;
            //   $transaction->save();
              $advance_payment  = $export_advance_amount->received_amount;

        }else{
            $advance_payment = 0;
        }

        // $transaction=new Transactions();
        // $transaction=$transaction->SetConnection('mysql2');
        // $transaction->voucher_no=$IMP;
        // $transaction->v_date= date('Y-m-d');
        // $transaction->acc_id= $revenue->acc_id;
        // $transaction->acc_code=FinanceHelper::getAccountCodeByAccId($revenue->acc_id);
        // $transaction->particulars="Export Commercial Invoice Packing list Customer Transaction ";
        // $transaction->opening_bal=0;
        // $transaction->debit_credit=1;
        // $transaction->amount=$total_amount_with_exchange_rate+$tax_amount;
        // $transaction->username=Auth::user()->name;;
        // $transaction->status=1;
        // $transaction->voucher_type=20;
        // $transaction->save();


        // $transaction=new Transactions();
        // $transaction=$transaction->SetConnection('mysql2');
        // $transaction->voucher_no=$IMP;
        // $transaction->v_date= date('Y-m-d');
        // $transaction->acc_id= $request->acc_id;
        // $transaction->acc_code=FinanceHelper::getAccountCodeByAccId($request->acc_id);
        // $transaction->particulars="Export Commercial Invoice Packing list Head ";
        // $transaction->opening_bal=0;
        // $transaction->debit_credit=0;
        // $transaction->amount=$total_amount_with_exchange_rate;
        // $transaction->username=Auth::user()->name;;
        // $transaction->status=1;
        // $transaction->voucher_type=20;
        // $transaction->save();
        
        // Settelement TRANSACTION
        // $transaction=new Transactions();
        // $transaction=$transaction->SetConnection('mysql2');
        // $transaction->voucher_no=$IMP;
        // $transaction->v_date= date('Y-m-d');
        // $transaction->acc_id= $request->acc_id;
        // $transaction->acc_code=FinanceHelper::getAccountCodeByAccId($request->acc_id);
        // $transaction->particulars="Settelment Amount";
        // $transaction->opening_bal=0;
        // $transaction->debit_credit=1;
        // $transaction->amount=$advance_payment;
        // $transaction->username=Auth::user()->name;;
        // $transaction->status=1;
        // $transaction->voucher_type=20;
        // $transaction->save();

        // if ($tax_amount>0){
        //         // $sales_tac_acc_id= DB::Connection('mysql2')->table('accounts')->where('status',1)->where('name','like','%' .'Sales Tax Output FBR'. '%')->select('id')->first()->id;
        //         $transaction=new Transactions();
        //         $transaction=$transaction->SetConnection('mysql2');
        //         $transaction->voucher_no=$IMP;
        //         $transaction->v_date=date('Y-m-d');
        //         $transaction->acc_id=152;
        //         $transaction->acc_code=FinanceHelper::getAccountCodeByAccId(152);
        //         $transaction->particulars="Commercial invoice  sale tax ";
        //         $transaction->opening_bal=0;
        //         $transaction->debit_credit=0;
        //         $transaction->amount=$tax_amount;
        //         $transaction->username=Auth::user()->name;;
        //         $transaction->status=1;
        //         $transaction->voucher_type=20;
        //         $transaction->save();
        // }

        //    $final_validation_status = ExportPakingList::where('invoice_id',$request->invoice_id)
        //    ->select(DB::raw('sum(total_qty)as final_qty'))
        //    ->groupby('invoice_id')
        //    ->first();

        //     $invoice_qty = ExportInvoiceData::where('export_invoice_id',$request->invoice_id)
        //    ->select(DB::raw('sum(issue_qty)as issue_qty'))
        //    ->groupby('export_invoice_id')
        //    ->first();
        //     if( $final_validation_status->final_qty ==  $invoice_qty->issue_qty)
        //     {
            $invoice = ExportInvoice::find($request->invoice_id);
            $invoice->import_paking_status = 1;
            $invoice->save();
        // }
        DB::Connection('mysql2')->commit();
        return redirect()->route('importPakingList');
        } catch (Exception $ex) {
        
            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }

    }

    public function createExportPakingImport(Request $request)
    {
        
        
        if ($request->file('file')) {
            $path = $request->file('file');
            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($path);
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            $spreadsheet = $reader->load($path);
            $paymentVouchers = $spreadsheet->getActiveSheet()->toArray();
?>
  <div class="row">
                        <div class="col-lg- col-md-4 col-sm-4 col-xs-4">
                            <h3 >Import Packing List</h3>
                            <input type="hidden" name="invoice_data_id"  value="<?php echo $request->id_packing;?>">
                            <input type="hidden" name="warehouse_id"  value="<?php echo $request->warehouse_id;?>">
                        </div>
                       
        </div> <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<label class="sf-label">Cr Account<span class="rflabelsteric requiredField"><strong>*</strong></span></label>
								<select class="form-control requiredField" id="acc_id" name="acc_id" >
									<option value="">Select</option>
                                        <?php $accounts=DB::Connection('mysql2')->table('accounts')->where('status',1)->whereIn('id',array(30, 20))->get();
											foreach($accounts as $row){?>
												<option value="<?php echo $row->id; ?>"><?php echo $row->name;?></option>
											<?php }?>
										</select>
									</div>
                                </div>
            <table  id="tablee" class="table " style="border: solid 1px black;">
            <thead>
                
                <tr>
                    <th class="text-center" style="border:1px solid black;">S/no</th>
                    <th class="text-center" style="border:1px solid black;">Item</th>
                    <th class="text-center" style="border:1px solid black;">Container</th>
                    <th class="text-center" style="border:1px solid black;">Gross Weight</th>
                    <th class="text-center" style="border:1px solid black;">Net Weight</th>
                    <th class="text-center" style="border:1px solid black;">QTY</th>
                    <th class="text-center" style="border:1px solid black;">Vechle</th>
                    <th class="text-center" style="border:1px solid black;">Date Of empty</th>
                    <th class="text-center" style="border:1px solid black;">Date Of Loading</th>
                    <th class="text-center" style="border:1px solid black;">Loading Port</th>
                   
                </tr>
            </thead>
            <tbody>
    
        
                <?php
               
                    $i = 1;
                    $total = 0;
                    $total_qty =0;
                    unset($paymentVouchers[0]);
                    
                    foreach ($paymentVouchers as $item) {
                        if ($item[1]== null) {
                            continue;
                        }
                    ?>
                  
                    <tr>          
                        <td class="text-right" style="border:1px solid black;"><?php echo $item[0]; ?> 
                    </td>
                    <td class="text-right" style="border:1px solid black;"><?php echo $item[1]; ?>
                        <input type="hidden" name="item[]" value="<?php echo $item[1]; ?>">
                         <?php $item_id = Subitem::where('sub_ic','LIKE',trim($item[1]))->first();
           ?>
                        <input type="hidden" name="item_id[]" id="item_id<?php echo $request->id_packing;?>" value="<?php echo $item_id['id']??0; ?>">

                    </td>
                        <td class="text-right" style="border:1px solid black;"><?php echo $item[2]; ?>
                        <input type="hidden" name="container[]" value="<?php echo $item[2]; ?>">
                    </td>
                        <td class="text-right" style="border:1px solid black;"><?php echo $item[3]; ?>
                        <input type="hidden" name="gross_weight[]" value="<?php echo $item[3]; ?>"/>
                    </td>
                        <td class="text-right" style="border:1px solid black;"><?php echo $item[4]; ?>
                        <input type="hidden" name="net_weight[]" value="<?php echo $item[4]; ?>"/>
                    </td>
                        <td class="text-right"  style="border:1px solid black;"><?php echo $item[5]; ?>
                        <input type="hidden" name="qty[]" value="<?php echo $item[5]; ?>"/>
                    </td>
                        <td class="text-right" style="border:1px solid black;"><?php echo $item[6]; ?>
                        <input type="hidden" name="vechle[]" value="<?php echo $item[6]; ?>"/>
                    </td>
                        <td class="text-right" style="border:1px solid black;"><?php echo $item[7]; ?>
                        <input type="hidden" name="date_of_empty[]" value="<?php echo $item[7]; ?>"/>
                    </td>
                        <td class="text-right" style="border:1px solid black;"><?php echo $item[8]; ?>
                        <input type="hidden" name="date_of_loading[]" value="<?php echo $item[8]; ?>"/>
                    </td>
                        <td class="text-right" style="border:1px solid black;"><?php echo $item[9]; ?>
                        <input type="hidden" name="loading_port[]" value="<?php echo $item[9]; ?>"/>
                    </td>
                      
                    </tr>
                  <?php
                    $total_qty +=  $item[5];
                  
                  $i++; } ?>

                  <tr>
                    <td class="text-right" style="border:1px solid black;" colspan="5">Total</td>
                    <td class="text-right" id="importtd"><?php echo $total_qty; ?>
                        <input type="hidden"  name="total_qty" id="import_qty<?php echo $request->id_packing;?>" value="<?php echo $total_qty;?>">
                    </td>
                <td class="text-right" style="border:1px solid black;" colspan="4"></td>
                  </tr>
            </tbody>
        </table>
        <button class="btn-primary" onclick="validation(<?php echo $request->id_packing;?>)">Upload Export Paking List</button>
<?php
        } else {
            return redirect()->back()->with('error', 'Some error occured');
        }
        
    }


    public function createPakingList()
    {
        return view('export.pakinglist.createPakingList');
    }

    public function createPakingListAjax(Request $request)
    {
        
      $query =  ExportInvoice::select('export_invoices.*','export_performas.eo_voucher_no','export_performas.pro_contract_no','export_invoices.created_at')->
      join('export_performas','export_performas.id','export_invoices.proforma_id')
      ->where('export_invoices.status',1)
      ->where('export_invoices.import_paking_status',0);
      
      if(!empty($request->EoNo))
      {
          $query->where('export_performas.eo_voucher_no','LIKE','%'.$request->EoNo.'%');
      }
      if(!empty($request->commercial))
      {
          $query->where('export_invoices.commercial_invoice_no','LIKE','%'.$request->commercial.'%');
      }
      if(!empty($request->proforma))
      {
          $query->where('export_performas.pro_contract_no','LIKE','%'.$request->proforma.'%');
      }

      $invoices =   $query->orderBy('id', 'desc')->get();
      return view('export.pakinglist.createPakingListAjax',compact('invoices'));
    }
    public function packingListCertificate(Request $request)
    {
        $pakinglist =  ExportPakingList::join('export_invoices','export_invoices.id','export_paking_lists.invoice_id')
        ->join('sale_order_exports','sale_order_exports.id','export_invoices.sale_order_export_id')
        ->join('customers','customers.id','sale_order_exports.buyer_id')
        ->where(['export_paking_lists.id'=>$request->id,'export_paking_lists.status'=>1])->first();

        $pakinglistdata =  ExportPakingListData::where('import_paking_list_id',$request->id)
        ->join('export_invoice_datas','export_invoice_datas.id','export_paking_list_datas.invoice_data_id')
        ->join('sale_order_data_exports','sale_order_data_exports.id','export_invoice_datas.sale_order_export_data_id')
        ->join('subitem','subitem.id','sale_order_data_exports.item_id')
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
        return view('export.pakinglist.packingListCertificate',compact('pakinglist','pakinglistdata'));
    }

    public function importExcelData(Request $request)
    {
           
            DB::Connection('mysql2')->beginTransaction();
            $errorCheck = "";
           
            try {

                if ($request->file('file')) {
               
                    $file = Excel::toArray([], $request->file('file'));
                    $html ='';
                    $file = $file[0];
                    // dd(  $file);
              
                    $userName = Auth::user()->name;
                        foreach ($file as $key => $value) :
                            if ($key == 0) continue;
                            $errorCheck = "";
                            // <td>
                            // '.$key.'
                            // </td>
                        $html .='  <tr class="cnt">
                       
                        <td>
                            <input type="text"
                                class="form-control"
                                name="container[]" id="container"
                                value="'.$value[0].'">
                        </td>
                        <td><input type="text"
                                class="form-control qty"
                                onkeyup="calculationPackaging()"
                                name="qty[]" id="qty'.$key.'"
                                value="'.$value[1].'">
                        </td>
                        <td><input type="text"
                                class="form-control net_weight"
                                name="net_weight[]"
                                onkeyup="calculationPackaging()"
                                id="net_weight'.$key.'" value="'.$value[2].'">
                        </td>
                        <td><input type="text"
                                class="form-control gross_weight"
                                name="gross_weight[]"
                                onkeyup="calculationPackaging()"
                                id="gross_weight'.$key.'" value="'.$value[3].'">
                        </td>
                        <td colspan="2" class="hide"><input
                                type="text"
                                class="form-control"
                                name="description[]"
                                id="description'.$key.'" value="">
                        </td>

                    </tr>';
                          
                        endforeach;
                    return  $html;
                } else {
                    Session::flash('dataDelete', 'File Not Found!');
                    return redirect()->back();
                }
            } catch (Exception $e) {
                DB::Connection('mysql2')->rollback();
                echo "EROOR "; //die();
                echo $e->getLine(); //die();
                echo "<br>" . $errorCheck; //die();
                dd($e->getMessage(), $e->getTraceAsString());
            }

    }
    
}
