<?php
use App\Helpers\SalesHelper;
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
use App\Models\CommercialInvoice;

?>

@extends('layouts.default')
@section('content')
 @include('select2')
 @include('number_formate')
<style>
    .heading
    {
        font-size: large;
        font-weight: bold;
    }
    .receipt-voucher-title-wrapper {
        width: 100%;
        overflow: visible !important;
        position: relative;
        margin-bottom: 15px;
        padding: 0;
        box-sizing: border-box;
    }
    .receipt-voucher-title-wrapper h2 {
        font-size: large !important;
        font-weight: bold !important;
        text-decoration: underline !important;
        width: 100% !important;
        overflow: visible !important;
        word-wrap: break-word !important;
        white-space: normal !important;
        margin: 0 !important;
        padding: 0 !important;
        position: relative !important;
        left: 0 !important;
        right: 0 !important;
        display: block !important;
        box-sizing: border-box !important;
    }
</style>

<div class="receipt-voucher-title-wrapper">
    <h2>Receipt Voucher (Commercial Invoice)</h2>
</div>

<?php

$WhereIn = implode(',',$val);
// Get commercial invoices and their customer info
$Colll = DB::Connection('mysql2')->select('
    SELECT ci.invoice_no, so.buyer_id 
    FROM commercial_invoices ci
    LEFT JOIN sale_order_exports so ON so.id = ci.sale_order_export_id
    WHERE ci.id IN('.$WhereIn.') 
    GROUP BY so.buyer_id
');

?>

 <?php echo Form::open(array('url' => 'fad/addCommercialInvoiceReceipt?m='.$_GET['m'].'','id'=>'createCommercialInvoiceReceipt','class'=>'stop'));?>
<div class="well_N">
        <div class="well">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                     <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label for="email">Voucher Date</label>
                       <input type="date" value="{{date('Y-m-d')}}" class="form-control" id="v_date" name="v_date">
                       </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label for="pwd">Payment Mode</label>
                        <select id="pay_mode" name="pay_mode" onchange="hide_unhide()" class="form-control">
                            <option value="1,1">Cheque</option>
                            <option selected value="2,2">Cash </option>
                        </select>
                    </div>

                    <div  class="col-lg-3 col-md-3 col-sm-3 col-xs-12 hidee" style="display:none;">
                        <label for="pwd"> Banks </label>
                        <?php $bank=DB::Connection('mysql2')->table('bank_detail')->get(); ?>
                        <select name="bank" class="form-control">
                            @foreach($bank as $row)
                            <option value="{{$row->id}}">{{$row->bank_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 hidee" style="display:none;">
                        <label for="pwd">Cheque No:</label>
                        <input type="text" class="form-control" id="cheque" name="cheque">
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 hidee" style="display:none;">
                        <label for="pwd">Cheque Date:</label>
                        <input value="{{date('Y-m-d')}}" class="form-control" name="cheque_date" type="date" >
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="dr_account_div" >
                        <label for="pwd">Dr Account</label>
                        <select name="acc_id" id="acc_id" class="form-control select2">
                            <option value="">Select</option>
                            @foreach(CommonHelper::get_all_account() as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label for="comment">Remarks:</label>
                    <textarea name="desc" class="form-control" rows="3" id="comment"><?php foreach($Colll as $cc):if(isset($cc->buyer_id) && $cc->buyer_id):echo CommonHelper::byers_name($cc->buyer_id)->name;endif;endforeach;?></textarea>
                </div>
            </div>
            
        </div>
    </div>


        <input type="hidden" name="ref_bill_no" value="" />
    <div>&nbsp;</div>

    <table id="" class="table table-bordered" >


        <thead>
        <tr>
            <th  class="text-center">SI No</th>
            <th  class="text-center">Invoice No</th>
            <th  class="text-center">Invoice Date</th>
            <th  class="text-center">Invoice Amount (PKR)</th>
            <th  class="text-center">Previous Received Amount</th>
            <th  class="text-center">Received  Amount</th>
            <th  class="text-center">Net Amount</th>

        </tr>
        </thead>

        <tbody>
            <?php $counter=1;
            $invoice_no=[];?>
            @foreach($val as $row)

              <?php
              // Get commercial invoice details
              $commercialInvoice = CommercialInvoice::where('id', $row)->first();
              
              if (!$commercialInvoice) {
                  continue;
              }

              // Calculate invoice amount in PKR (grand_total * exchange_rate)
              $invoice_amount = $commercialInvoice->grand_total * ($commercialInvoice->exchange_rate ?? 1);
              
              // Get received payment for this commercial invoice
              CommonHelper::companyDatabaseConnection($_GET['m']);
              $received_amount = SalesHelper::get_received_payment_commercial_invoice($row);
              CommonHelper::reconnectMasterDatabase();

              if ($received_amount==null):
              $received_amount = 0;
              endif;

              // Commercial invoices don't have return amounts
              $return_amount = 0;

              $invoice_no[]=$commercialInvoice->invoice_no;
              ?>
              <input type="hidden" name="commercial_invoice_id[]" value="{{$row}}"/>
              <input type="hidden" name="commercial_invoice_no[]" value="{{$commercialInvoice->invoice_no}}"/>

            <tr title="{{'commercial_invoice_id='.$row}}">
            <td class="text-center">{{strtoupper($commercialInvoice->invoice_no)}}</td>
            <td class="text-center">{{strtoupper($commercialInvoice->invoice_no)}}</td>
            <td class="text-center">{{$commercialInvoice->invoice_date ? date('d-m-Y', strtotime($commercialInvoice->invoice_date)) : '-'}}</td>
            <td class="text-center">{{number_format($invoice_amount,2)}}</td>

            <td class="text-center">{{number_format($received_amount,2)}}</td>

            <td><input class="form-control receive_amount" onkeyup="calc('{{$invoice_amount}}','{{$received_amount}}','{{$counter}}','{{$return_amount}}',1)"
             onblur="calc('{{$invoice_amount}}','{{$received_amount}}','{{$counter}}','{{$return_amount}}',1)" type="text" name="receive_amount[]" id="receive_amount{{$counter}}"
                      value="{{$invoice_amount-$received_amount-$return_amount}}"
                        ></td>

            <input type="hidden" name="percent[]" id="percent{{$counter}}" value="0">
            <input type="hidden" name="tax_amount[]" id="tax_amount{{$counter}}" value="0">
            <input type="hidden" name="discount[]" id="discount_amount{{$counter}}" value="0">

            <td><input class="form-control net_amount comma_seprated" type="text" readonly value="{{$invoice_amount-$received_amount-$return_amount}}" name="net_amount[]" id="net_amount{{$counter}}"></td>


              </tr>



              <input type="hidden"  id="inv_amount{{$counter}}" value="{{$invoice_amount}}"/>
              <input type="hidden"  id="rec_amount{{$counter}}" value="{{$received_amount}}"/>
              <input type="hidden"  id="ret_amount{{$counter}}" value="{{$return_amount}}"/>


         <?php $counter++; $invoice_nos=implode(',',$invoice_no);?>  @endforeach
            <input type="hidden" name="count" id="count" value="{{$counter-1}}"/>
            <input type="hidden" name="ref_bill_no" value="{{$invoice_nos}}" />
        <tr class="heading" style="background-color: darkgrey">
        <td class="text-center" colspan="6">Total</td>
        <td  id=""><input readonly type="text" id="net_total" class="form-control comma_seprated"/> </td>
        </tr>
        <input type="hidden" id="tax_total" value="0"/>
        <input type="hidden" id="discount_total" value="0"/>

        </tbody>
    </table>
    <input type="hidden" id="SavePrintVal" name="SavePrintVal" value="0">
    <div class="text-center">
    <button   type="submit" class="btn btn-success" onclick="SetValue(0)">Submit</button>
    <button type="submit" id="BtnSaveAndPrint" class="btn btn-info BtnSaveAndPrint" onclick="SetValue(1)">Save & Print</button>
    </div>
</div>
{{Form::close()}}
    <script>

        function SetValue(v)
        {
            $('#SavePrintVal').val(v);
        }
        function calc(invoice_amount,previous_amount,counter,return_amount,type)
        {

          //  alert(invoice_amount+' '+previous_amount+' '+counter+' '+return_amount);
            var invoice_amount=parseFloat(invoice_amount);
            var previous_amount=parseFloat(previous_amount);
            var return_amount=parseFloat(return_amount);

            if (isNaN(return_amount))
            {
                return_amount=0;
            }

            if (isNaN(previous_amount))
            {
                previous_amount=0;
            }
            var actual_amount=invoice_amount-previous_amount-return_amount;


            var receive_amount=parseFloat($('#receive_amount'+counter).val());

            if (isNaN(receive_amount))
            {
                receive_amount=0;
            }

            if (receive_amount>actual_amount)
            {
                alert('Amount Can not greater them '+actual_amount);
                $('#receive_amount'+counter).val(0);
                return false;
            }

            if (type==0)
            {
                var tax_percent=parseFloat($('#percent'+counter).val());
                var tax_amount=((receive_amount/100)*tax_percent).toFixed(2);
                $('#tax_amount'+counter).val(tax_amount);
            }

            else
            {
                var tax_amount=parseFloat($('#tax_amount'+counter).val());
                if (isNaN(tax_amount))
                {
                    tax_amount=0;
                }
            }



            var discount_amount=parseFloat($('#discount_amount'+counter).val());
            if (isNaN(discount_amount))
            {
                discount_amount=0;
            }

            // For commercial invoices, net amount equals receive amount (no tax/discount)
            var net_amount=receive_amount;
            $('#net_amount'+counter).val(net_amount);


            var amount=0;

            $('.net_amount').each(function (i, obj) {

                amount += +$('#'+obj.id).val();
            });
            amount=parseFloat(amount);
            $('#net_total').val(amount);


            // Tax and discount are always 0 for commercial invoices
            $('#tax_total').val(0);
            $('#discount_total').val(0);

        }

        $(document).ready(function() {
            $('.select2').select2();
            $('.comma_seprated').number(true,2);
        });




        $( "form" ).submit(function( event )
        {
            var validate=validatee();

            if (validate==true)
            {

            }
            else
            {
                return false;
            }

        });
        function validatee()
        {
            var validate=true;
            $( ".receive_amount" ).each(function() {
                var id=this.id;



                    var amount=$('#'+id).val();

                    if (amount <= 0 || amount=='')
                    {
                        $('#'+id).css('border', '3px solid red');

                        validate=false;
                    }
                    else
                    {
                        $('#'+id).css('border', '');

                        var pay_mode = $('#pay_mode').val();
                        if (pay_mode=='1,1') // Cheque
                        {
                            if ($('#cheque').val()=='')
                            {
                                $('#cheque').css('border', '3px solid red');
                                validate=false;
                            }
                        }
                        else if (pay_mode=='2,2') // Cash
                        {
                            if ($('#acc_id').val()=='')
                            {
                               alert('pls select Debit Account');
                                validate=false;
                                return false;
                            }
                        }
                    }

            });
            return validate;
        }

        $("#percent1").change(function(){
//          var  percent=$('#'+this.id).val();
//           var count=$('#count').val();
//            $('.tex_p').val(percent);
//            for (i=2; i<=count; i++)
//            {
//
//                var inv_amount=$('#inv_amount'+i).val();
//                var rec_amount=$('#rec_amount'+i).val();
//                var ret_amount=$('#ret_amount'+i).val();
//                calc(inv_amount,rec_amount,i,ret_amount);
//            }


        });

        function hide_unhide()
        {
           var pay_mode= $('#pay_mode').val();
            if (pay_mode=='2,2') // Cash
            {
                $(".hidee").css("display", "none");
                $('#cheque').val('-');
                $('#dr_account_div').show(); // Show DR account for Cash
            }
            else if (pay_mode=='1,1') // Cheque
            {
                $(".hidee").css("display", "block");
                $('#dr_account_div').hide(); // Hide DR account for Cheque
            }
        }
        
        // Call on page load to set initial state
        $(document).ready(function() {
            hide_unhide();
        });
    </script>
    @endsection
