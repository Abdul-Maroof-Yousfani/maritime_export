

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
    .col-lg-12 {
    width: 99%;
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
                                    <td class="text-left" style="border:1px solid black;width:60%;">Buyer's Unit</td>
                                    <td class="text-left" style="border:1px solid black;width:40%;"><?php echo $sales_order->buyers_unit;?></td>
                                 </tr>
                                <tr>
                                    <td class="text-left">Buyer's Address</td>
                                    <td class="text-left" style="border:1px solid black;" ><?php echo  ucwords($customer_data->address);?></td>
                                   
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
                                <tr>
                                    <td class="text-left" style="border:1px solid black;">CONTRACT NO</td>
                                    <td class="text-left" style="border:1px solid black;"><?php echo strtoupper($sales_order->contract_no);?></td>
                                </tr>
                                <tr>
                                    <td class="text-left" style="border:1px solid black;width:50%;">PROFORMA NO </td>
                                    <td class="text-left" style="border:1px solid black;width:50%;"><?php echo strtoupper($export_performa->proforma_no);?></td>
                                </tr>

                              
                                <tr>
                                    <td class="text-left" style="border:1px solid black;width:50%;">COMMERCIAL INVOICE NO.</td>
                                    <td class="text-left" style="border:1px solid black;width:50%;"><?php echo strtoupper($exportInvoice->invoice_no);?></td>
                                </tr>
                               
                                </tbody>
                            </table>
                        </div>

                        
                    </div>
                    <div class="row">
                        
                        <div class="col-lg- col-md-4 col-sm-4 col-xs-4">
                            <h3 >Commercial Invoice Details</h3>
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
                                <td style="border:1px solid black;" class="text-left"><?php $incoterm = IncoTerm::find($sales_order->incoterm)->name ?? '-';?>
                                 
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
                                <td style="border:1px solid black;" class="text-left">delevery_date</td>
                                <td style="border:1px solid black;" class="text-left"><?php echo $sales_order->delevery_date ?></td>
                               
                                <td style="border:1px solid black;" class="text-left">Transhipment</td>
                                <td style="border:1px solid black;" class="text-left">@if($sales_order->transhipment == 0) Allow @else Not Allow @endif</td>
                               
                            </tr>
                            <tr>
                                <td style="border:1px solid black;" class="text-left">insurance_coverd</td>
                                <td style="border:1px solid black;" class="text-left">@if($sales_order->insurance_coverd == 0) Buyer @else Supplier @endif</td>
                               
                                <td style="border:1px solid black;" class="text-left">advance_payment</td>
                                <td style="border:1px solid black;" class="text-left"><?php echo  ucwords($sales_order->advance_payment);?></td>
                               
                            </tr>

                            <tr>
                                <td style="border:1px solid black;" class="text-left">Carrency</td>
                                <td style="border:1px solid black;" class="text-left"><?php 
                                if(!empty($sales_order->currencey_id))
                                {
                                echo   $currencey =  App\Models\Currency::find($sales_order->currencey_id)->curreny;
                                }else{
                                    echo $currencey= '-';
                                }
                                ?></td>
                               
                                <td style="border:1px solid black;" class="text-left">Rate</td>
                                <td style="border:1px solid black;" class="text-left"><?php echo  $sales_order->currencey_rate;?></td>
                               
                            </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>

                 <div class="row">
                    <div class="col-lg- col-md-4 col-sm-4 col-xs-4">
                        <h3 >Commercial Invoice Details</h3>
                    </div>
                 </div>
        

                    <div id="actual" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table  id="tablee" class="table " style="border: solid 1px black;">
                                <thead>
                                <tr>
                                    <th class="text-center" style="border:1px solid black;">S.NO</th>
                                    <th class="text-center" style="border:1px solid black;">Item</th>
                                    <th class="text-center" style="border:1px solid black;">Uom</th>
                                    {{-- <th class="text-center" style="border:1px solid black;">QTY. <span class="rflabelsteric"><strong>*</strong></span></th> --}}
                                    <th class="text-center" style="border:1px solid black;">Item (weight)</th>
                                    <th class="text-center" style="border:1px solid black;">Rate</th>
                                    {{-- <th class="text-center" style="border:1px solid black;">Total QTY (Begs)</th> --}}

                                    
                                    <th class="text-center" style="border:1px solid black;">
                                        Total Qty</th>
                                        <th class="text-center" style="border:1px solid black;">
                                            Total Qty (Bags)</th>
                                    {{-- <th class="text-center" style="border:1px solid black;">Remaining QTY (Begs)</th> --}}
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

                                    
                                    ?>    
                                                @foreach ( $sales_order_data as $row )
                                                                                    
                                                <?php 
                                                
                                            
                                                ?>
                                                <tr>
                                                <td style="border:1px solid black;"> {{ $count++ }} </td>    
                                                <td style="border:1px solid black;">{{  CommonHelper::get_item_name($row->item_id) }}</td>    
                                                <td style="border:1px solid black;">{{ CommonHelper::get_uom($row->item_id) }}</td>    
                                                {{-- <td class="text-right" style="border:1px solid black;">{{ $row->actual_qty }}</td>  --}}
                                                <?php 
                                                $amount = ($row->deleverd_qty*$row->rate);
                                                $after_tax = $amount+$row->tax_amount;

                                                $total_before_tax +=  $amount;
                                                $total_tax += $row->tax_amount;
                                                $total_after_tax +=  $after_tax;
                                                ?>   
                                                <td class="text-right" style="border:1px solid black;">{{$row->pack_size}}</td>
                                                <td class="text-right" style="border:1px solid black;">{{ number_format($row->rate,2) }}</td>    
                                                {{-- <td class="text-right" style="border:1px solid black;">{{number_format($row->total_qty,1)}}</td> --}}
                                                <td class="text-right" style="border:1px solid black;">{{number_format($row->deleverd_qty,1)}}</td>  
                                                <td class="text-right" style="border:1px solid black;">{{$row->deleverd_qty/$row->pack_size}}</td> 
                                                {{-- <td class="text-right" style="border:1px solid black;">{{number_format($row->total_qty-$row->deleverd_qty,1)}}</td>    --}}
                                                <td class="text-right" style="border:1px solid black;">{{ number_format($amount,2) }}</td> 
                                                <td class="text-right" style="border:1px solid black;">{{ $row->tax }}</td> 
                                                <td class="text-right" style="border:1px solid black;">{{ number_format($row->tax_amount) }}</td> 
                                                <td class="text-right" style="border:1px solid black;">{{ number_format($after_tax,2) }}</td> 
                                                </tr>     
                                                @endforeach 
                                                <tr style="font-size: large;font-weight: bold">
                                                    <td  colspan="10" style="border:1px solid black;"> Total </td>
                                                   
                                                    <td class="text-right"  style="border:1px solid black;"> {{ number_format($total_after_tax,2) }} </td>
                                                </tr>
                                           
                                                <tr>
                                                    <td colspan="3">
                                                       Amount In words : <?php echo $a = CommonHelper::AmountInWords($total_after_tax,$currencey); ?>
                                                    </td>
                                                </tr>


























                                    {{-- <tr style="font-size: large;font-weight: bold">
                                        <td  colspan="5" style="border:1px solid black;"> Total </td>
                                        <td class="text-right" colspan="1" style="border:1px solid black;"> {{ number_format($total_before_tax) }} </td>
                                        <td></td>
                                        <td class="text-right" colspan="1" style="border:1px solid black;">  {{ number_format($total_tax,2) }} </td>
                                        <td class="text-right" colspan="1" style="border:1px solid black;"> {{ number_format($total_after_tax,2) }} </td>
                                    </tr> --}}
                               
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row text-left">
                            <div style="display: none" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <p><?php echo 'Description:'.' '.strtoupper($sales_order->description); ?></p>
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
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 text-center">
                                        <h6 class="">Prepared By: </h6>
                                        <b>   <p><?php echo strtoupper($sales_order->username);  ?></p></b>
                                    </div>
                                    
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 text-center">
                                        <h6 class="">Approved By:</h6>
                                        <b>  <p><?php echo strtoupper($sales_order->approve_user_1);  ?></p></b>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 text-center">
                                        <h6 class="">Approved By:</h6>
                                        <b>  <p><?php echo strtoupper($sales_order->approve_user_2);  ?></p></b>
                                    </div>


                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 text-center">
                                        <h6 class="">Approved By:</h6>
                                        <b>  <p><?php echo strtoupper($sales_order->approve_user_3);  ?></p></b>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>

       
    </script>

