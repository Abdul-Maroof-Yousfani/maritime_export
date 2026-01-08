

<?php
use App\Helpers\CommonHelper;
use App\Helpers\StoreHelper;
use App\Models\IncoTerm;
use App\Models\ModeOfTransport;
$id = $_GET['id'];
$m = Session::get('run_company');
$currentDate = date('Y-m-d');
$total_expense =0;

?>




<style>
    textarea {
        border-style: none;
        border-color: Transparent;

    }
    @media print{
        .printHide{
            display:none !important;
        }
        .fa {
            font-size: small;!important;
        }

        .table-bordered{
            border: 1px solid black;
        }
        table.table-bordered > thead > tr > th{
            border:1px solid blue !important;
        }


    }
</style>
<?php

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        <?php CommonHelper::displayPrintButtonInView('printPurchaseRequestVoucherDetail','','1');?>
        
    </div>
</div>
<div style="line-height:5px;">&nbsp;</div>
<div class="row" id="printPurchaseRequestVoucherDetail">
    <div class="">
        <!--
        < ?php  StoreHelper::displayApproveDeleteRepostButtonPurchaseRequest($m,$sales_order->purchase_request_status,$sales_order->status,$row->id,'purchase_request_no','purchase_request_status','status','purchase_request','purchase_request_data');?>
    </div>
    <!-->
        <div style="line-height:5px;">&nbsp;</div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sales_Tax_Invoice">
            <div class="">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php echo CommonHelper::get_company_logo(Session::get('run_company'));?>
                    </div>
                    
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-left">

                        {{--<label style="border-bottom:2px solid #000 !important;">Printed On Date&nbsp;:&nbsp;</label><label style="border-bottom:2px solid #000 !important;">< ?php echo CommonHelper::changeDateFormat($currentDate);?></label>--}}
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <h3 style="text-align: center;">@if($sales_order->proforma_status ==1 )Proforma Details  @else  Contract    @endif</h3>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                        {{--< ?php $nameOfDay = date('l', strtotime($currentDate)); ?>--}}
                        {{--<label style="border-bottom:2px solid #000 !important;">Printed On Day&nbsp;:&nbsp;</label><label style="border-bottom:2px solid #000 !important;">< ?php echo '&nbsp;'.$nameOfDay;?></label>--}}

                    </div>
                </div>


                <div style="line-height:5px;">&nbsp;</div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div style="width:49%; float:left;">
                            <table  class="table " style="border: solid 1px black;">
                                <tbody>

                                <?php $customer_data= CommonHelper::byers_name($sales_order->buyer_id);?>
                                <tr>
                                    <td class="text-left" style="border:1px solid black;">Buyer's Name</td>
                                    <td class="text-left" style="border:1px solid black;"><?php echo ucwords($customer_data->name)?></td>
                                </tr>
                              
                                <tr>
                                    <td class="text-left" style="border:1px solid black;width:60%;">Buyer's Order Date</td>
                                    <td class="text-left" style="border:1px solid black;width:40%;"><?php echo CommonHelper::changeDateFormat($sales_order->order_date);?></td>
                                </tr>
                               
                                <tr>
                                    <td class="text-left">Buyer's Address</td>
                                    <td style="border:1px solid black;font-size: xx-small" class="text-left"><?php echo  ucwords($customer_data->address);?></td>
                                   
                                </tr>

                                </tbody>
                            </table>


                        </div>
                    
                        <div style="width:50%; float:right;">
                            <table  class="table " style="border: solid 1px black;">
                                <tbody>


                                <tr>
                                    <td class="text-left" style="border:1px solid black;width:50%;">EO NO.</td>
                                    <td class="text-left" style="border:1px solid black;width:50%;"><?php echo strtoupper($sales_order->voucehr_no);?></td>
                                </tr>
                                @if($sales_order->proforma_status ==0)
                                <tr>
                                    <td class="text-left" style="border:1px solid black;">Contract Date</td>
                                    <td class="text-left" style="border:1px solid black;"><?php echo CommonHelper::changeDateFormat($sales_order->voucher_date);?></td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="text-left" style="border:1px solid black;">Contract NO.</td>
                                    <td class="text-left" style="border:1px solid black;"><?php echo $sales_order->contract_no;?></td>
                                </tr>
                               
                                @if($sales_order->proforma_status ==1 )
                                <tr>
                                    <td class="text-left" style="border:1px solid black;">Proforma Date</td>
                                    <td class="text-left" style="border:1px solid black;"><?php echo CommonHelper::changeDateFormat($sales_order->voucher_date);?></td>
                                </tr>
                              
                                <tr>
                                    <td class="text-left" style="border:1px solid black;">Proforma NO.</td>
                                    <td class="text-left" style="border:1px solid black;"><?php echo $export->proforma_no??'-';?></td>
                                </tr>
                                
                                @endif
                                </tbody>
                            </table>
                        </div>

                        
                    </div>
                    <div class="row">
                        <div class="col-lg- col-md-4 col-sm-4 col-xs-4">
                        </div>
                        <div class="col-lg- col-md-4 col-sm-4 col-xs-4">
                            <h3 style="text-align: center;">@if($sales_order->proforma_status ==1 ) Proforma Details  @else  Contract     @endif</h3>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div style="width:100%; float:left;">
                        <table  class="table " style="border: solid 1px black;">
                            <tbody>

                            <?php $customer_data= CommonHelper::byers_name($sales_order->buyer_id);?>
                            <tr>
                                <td class="text-left" style="border:1px solid black;">base_legnth</td>
                                <td class="text-left" style="border:1px solid black;"><?php echo ucwords($sales_order->base_legnth)?></td>
                           
                                <td class="text-left" style="border:1px solid black;">chalky_grain</td>
                                <td class="text-left" style="border:1px solid black;"><?php echo ucwords($sales_order->chalky_grain)?></td>
                           
                           
                            </tr>
                          
                            <tr>
                                <td class="text-left" style="border:1px solid black;">broken_grain</td>
                                <td class="text-left" style="border:1px solid black;"><?php echo $sales_order->broken_grain;?></td>
                               
                                <td class="text-left" style="border:1px solid black;">foreign_grain</td>
                                <td class="text-left" style="border:1px solid black;"><?php echo $sales_order->foreign_grain;?></td>
                            </tr>
                            <tr>
                                <td class="text-left" style="border:1px solid black;">mosture_content</td>
                                <td class="text-left" style="border:1px solid black;"><?php echo $sales_order->mosture_content;?></td>
                               
                                <td class="text-left" style="border:1px solid black;">paddy_grain</td>
                                <td class="text-left" style="border:1px solid black;"><?php echo $sales_order->paddy_grain;?></td>
                             </tr>
                            <tr>
                                <td style="border:1px solid black;" class="text-left">demand_yellow_grain</td>
                                <td style="border:1px solid black;" class="text-left"><?php echo  ucwords($sales_order->demand_yellow_grain);?></td>
                               
                                <td style="border:1px solid black;" class="text-left">under_milled</td>
                                <td style="border:1px solid black;" class="text-left"><?php echo  ucwords($sales_order->under_milled);?></td>
                               
                            </tr>

                            <tr>
                                <td style="border:1px solid black;" class="text-left">milled_double_polish</td>
                                <td style="border:1px solid black;" class="text-left"><?php echo  ucwords($sales_order->milled_double_polish);?></td>
                               
                                <td style="border:1px solid black;" class="text-left">whiteness</td>
                                <td style="border:1px solid black;" class="text-left"><?php echo  ucwords($sales_order->whiteness);?></td>
                               
                            </tr>
                            <tr>
                                <td style="border:1px solid black;" class="text-left">incoterm</td>
                                <td style="border:1px solid black;" class="text-left"><?php $incoterm = Incoterm::find($sales_order->incoterm)->name ?? '-';?>
                                 
                                <?php echo $incoterm; ?></td>
                               
                                <td style="border:1px solid black;" class="text-left">mode_transport</td>
                                <td style="border:1px solid black;" class="text-left"><?php $mode_transport =ModeOfTransport::find($sales_order->mode_transport)->name ?? '-';
                                 ?>
                                    
                                   <?php echo $mode_transport; ?></td>
                               
                            </tr>
                            <tr>
                                <td style="border:1px solid black;" class="text-left">origin</td>
                                <td style="border:1px solid black;" class="text-left"><?php echo  ucwords($sales_order->origin);?></td>
                               
                                <td style="border:1px solid black;" class="text-left">port_of_discharge</td>
                                <td style="border:1px solid black;" class="text-left"><?php echo  ucwords($sales_order->port_of_discharge);?></td>
                               
                            </tr>
                            <tr>
                                <td style="border:1px solid black;" class="text-left">port_loading</td>
                                <td style="border:1px solid black;" class="text-left"><?php echo  ucwords($sales_order->port_loading);?></td>
                               
                                <td style="border:1px solid black;" class="text-left">hs_code</td>
                                <td style="border:1px solid black;" class="text-left"><?php echo  ucwords($sales_order->hs_code);?></td>
                               
                            </tr>
                            <tr>
                                <td style="border:1px solid black;" class="text-left">partial_payment</td>
                                <td style="border:1px solid black;" class="text-left">@if($sales_order->partial_payment == 0) Yes @else Not  @endif</td>
                               

                              
                                 <td style="border:1px solid black;" class="text-left">bank</td>
                                 <td style="border:1px solid black;" class="text-left">  @if(!empty($sales_order->bank))
                         
                                    {{ $bank_name  = App\Models\Bank::find($sales_order->bank)->bank_name}}
                                    
                                    @else
                                     {{ $bank_name = '-'}}
                                    @endif</td>

                               
                            </tr>
                            <tr>
                                <td style="border:1px solid black;" class="text-left">advance_payment</td>
                                <td style="border:1px solid black;" class="text-left"><?php echo  ucwords($sales_order->advance_payment);?></td>
                               
                                <td style="border:1px solid black;" class="text-left">delevery_date</td>
                                <td style="border:1px solid black;" class="text-left">{{$sales_order->delevery_date}}</td>
                               
                               
                            </tr>
                            <tr>
                                <td style="border:1px solid black;" class="text-left">Transhipment</td>
                                <td style="border:1px solid black;" class="text-left">@if($sales_order->transhipment == 0) Allow @else Not Allow @endif</td>
                               
                                <td style="border:1px solid black;" class="text-left">insurance_coverd</td>
                                <td style="border:1px solid black;" class="text-left">@if($sales_order->insurance_coverd == 0) Buyer @else Supplier @endif</td>
                               
                               </td>
                               
                            </tr>

                            <tr>
                                <td style="border:1px solid black;" class="text-left">Currency</td>
                                <td style="border:1px solid black;" class="text-left"><?php 
                                if(!empty($sales_order->currencey_id))
                                {
                                echo   $currencey =  App\Models\Currency::find($sales_order->currencey_id)->curreny;
                                }else{
                                    echo $currencey= '-';
                                }
                                ?>
                                <td style="border:1px solid black;" class="text-left">Rate</td>
                                <td style="border:1px solid black;" class="text-left"><?php echo  $sales_order->currencey_rate;?></td>
                               
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
                    @if(isset($export->account_title))
                    @php
                    if(!empty($sales_order->bank))
                    {
                    $bank_name  = App\Models\Bank::find($sales_order->bank)->bank_name;	
                    $bank_swift = App\Models\Bank::find($sales_order->bank)->swift_code;	
                    $bank_ibn  = App\Models\Bank::find($sales_order->bank)->IBAN_no;	
                    $bank_address  = App\Models\Bank::find($sales_order->bank)->bank_address;	
                    $account_title  = App\Models\Bank::find($sales_order->bank)->account_title;	
                    }else{
                    $bank_name  = '-';	
                    $bank_swift = '-';	
                    $bank_ibn  = '-';	
                    $bank_address = '-';
                    $account_title = '-';
                    }
                    @endphp
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div style="width:100%; float:left;">
                            <h4>Beneficiary Details</h4>
                        </div>
                        <table class="table " style="border: solid 1px black;">
                            <tr>
                                <td style="border:1px solid black;" >Beneficiary Account Title</td>
                                <td style="border:1px solid black;" >{{$account_title}}</td>
                                <td style="border:1px solid black;" >Beneficiary Account No</td>
                                <td style="border:1px solid black;" >{{ $bank_ibn}}</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid black;" >Beneficiary Bank</td>
                                <td style="border:1px solid black;" >{{ $bank_name}}</td>
                                <td style="border:1px solid black;" >Beneficiary Swift Code</td>
                                <td style="border:1px solid black;" >{{$bank_swift}}</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid black;" > Beneficiary Address</td>
                                <td style="border:1px solid black;"  colspan="3">{{$bank_address}} </td>
                            </tr>
                        </table>
                    </div>
                 
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div style="width:100%; float:left;">
                            <h4>Corresspoding Details</h4>
                        </div>
                        <table class="table " style="border: solid 1px black;">
                            <tr>
                                <td style="border:1px solid black;" >Account Title</td>
                                <td style="border:1px solid black;" >{{isset($export->account_title)? $export->account_title: '-' }}</td>
                                <td style="border:1px solid black;" >Account No</td>
                                <td style="border:1px solid black;" >{{isset($export->correspondent_account_usd)? $export->correspondent_account_usd: '-'}}</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid black;" >Bank</td>
                                <td style="border:1px solid black;" >{{isset($export->correspondent_bank)?$export->correspondent_bank:'-'}}</td>
                                <td style="border:1px solid black;" >Swift Code</td>
                                <td style="border:1px solid black;" >{{isset($export->correspondent_bank_swift)?$export->correspondent_bank_swift:'-'}}</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid black;" >Details Of Payment</td>
                                <td style="border:1px solid black;"  colspan="3">{{isset($export->details_of_payment)?$export->details_of_payment:'-'}} </td>
                            </tr>
                        </table>
                    </div>

            @endif
                {{-- <div style="text-align: left" class="printHide">
                    <label class="text-left"><input type="checkbox" onclick="show_hide()" id="formats" />Printable Format </label>
                    <label class="text-left"><input type="checkbox" onclick="show_hide()" id="formatss" />Other Format </label>
                    </div> --}}

        

                    <div id="actual" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table  id="tablee" class="table " style="border: solid 1px black;">
                                <thead>
                                <tr>
                                    <th class="text-center" style="border:1px solid black;">S.NO</th>
                                    <th class="text-center" style="border:1px solid black;">Item</th>
                                    <th class="text-center" style="border:1px solid black;">Uom</th>
                                    <th class="text-center" style="border:1px solid black;">QTY. <span class="rflabelsteric"><strong>*</strong></span></th>
                                    <th class="text-center" style="border:1px solid black;">Rate</th>
                                    <th class="text-center" style="border:1px solid black;">Amount</th>
                                    <th class="text-center" style="border:1px solid black;">Tax %</th>
                                    <th class="text-center" style="border:1px solid black;">Tax Amount</th>
                                    <th class="text-center" style="border:1px solid black;">Net Amount</th>
                                    {{-- <th class="text-center printHide" style="border:1px solid black;">View</th> --}}
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     $count=1;
                                     $total_before_tax=0;
                                     $total_tax=0;
                                     $total_after_tax=0;
                                     $total_amount_ =0 ;
                                    ?>    
                                     @foreach ( $sales_order_data as $row )
                                     
                                    <?php 
                                    
                                    $total_before_tax += $row->sub_total;
                                    $total_tax += $row->tax_amount;
                                    $total_after_tax += $row->amount;
                                    ?>
                                    <tr>
                                    <td style="border:1px solid black;"> {{ $count++ }} </td>    
                                    <td style="border:1px solid black;">{{  CommonHelper::get_item_name($row->item_id) }}</td>    
                                    <td style="border:1px solid black;">{{ CommonHelper::get_uom($row->item_id) }}</td>    
                                    <td class="text-right" style="border:1px solid black;">{{ $row->actual_qty }}</td> 
                                    <?php 
                                   $amount = ($row->actual_qty*$row->rate);
                                   $after_tax = $amount+$row->tax_amount;
                                   $total_amount_ +=$after_tax;
                                    ?>   
                                    <td class="text-right" style="border:1px solid black;">{{ number_format($row->rate,2) }}</td>    
                                    <td class="text-right" style="border:1px solid black;">{{ number_format($amount,2) }}</td>    
                                  
                                    <td class="text-right" style="border:1px solid black;">{{ $row->tax }}</td> 
                                    <td class="text-right" style="border:1px solid black;">{{ number_format($row->tax_amount) }}</td> 
                                    <td class="text-right" style="border:1px solid black;">{{ number_format($after_tax,2) }}</td> 
                                    </tr>     
                                    @endforeach 
                                       <tr style="font-size: large;font-weight: bold">
                                        <td  colspan="8" style="border:1px solid black;"> Total </td>
                                       
                                        <td class="text-right"  style="border:1px solid black;"> {{ number_format($total_amount_,2) }} </td>
                                    </tr>
                               
                                    <tr>
                                        <td colspan="2">
                                           Amount In words : <?php echo $a = CommonHelper::AmountInWords($total_amount_,$currencey); ?>
                                        </td>
                                    </tr>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row text-left">
                            <div style="display: none" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                       
                            </div>
                        </div>
                        <style>
                            .signature_bor {
                                border-top:solid 1px #CCC;
                                padding-top:7px;
                            }
                        </style>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:40px;">
                            <div class="container-fluid">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     {{-- footer d data --}}

                                </div>
                            </div>
                        </div>


                    </div>
                    <!--
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right hidden qrCodeDiv">
                        <img src="data:image/png;base64, { !! base64_encode(QrCode::format('png')->size(200)->generate('View Purchase Request Voucher Detail (Office Use)'))!!} ">
                    </div>
                    <!-->
                </div>
            </div>
        </div>

    </div>

    <script>

        function view_history(id) {

            var v = $('#sub_' + id).val();


            if ($('#view_history' + id).is(":checked")) {
                if (v != null) {
                    showDetailModelTwoParamerter('pdc/viewHistoryOfItem_directPo?id=' + v);
                }
                else {
                    alert('Select Item');
                }

            }
        }

        function change()

        {


            if(!$('.showw').is(':visible'))
            {
                $(".showw").css("display", "block");

            }
            else
            {
                $(".showw").css("display", "none");

            }

        }


        function show_hide()
        {
            if($('#formats').is(":checked"))
            {
                $("#actual").css("display", "none");
                $("#printable").css("display", "block");
                $("#other_fomrate").css("display", "none");
            }

            else
            {
                $("#actual").css("display", "block");
                $("#printable").css("display", "none");
                $("#other_fomrate").css("display", "none");
            }

            if($('#formatss').is(":checked"))
            {
                $("#actual").css("display", "none");
                $("#printable").css("display", "none");
                $("#other_fomrate").css("display", "block");
            }
        }


        function approve(id)
        {
            $("#appro").attr("disabled", true);
            $.ajax
            ({
                url: '{{ url('sales/approve_so') }}',
                type: 'Get',
                data: {id:id},

                success: function (response)
                 {
                    $('#stat'+id).html(response);
                    $('#showDetailModelOneParamerter').modal('hide');
               
                }
            })
        }
    </script>

