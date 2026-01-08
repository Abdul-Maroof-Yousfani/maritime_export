<?php 
use App\Helpers\CommonHelper; 
$m = Session::get('run_company');
$currentDate = date('Y-m-d');
?>
<style>
     .fw-bold{
        font-weight: bold;
    }
</style>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right" style="float: right">
       
        <?php CommonHelper::displayPrintButtonInView('printDemandVoucherVoucherDetail', 'LinkHide', '1'); ?>
    </div>
</div>
<div style="line-height:5px;">&nbsp;</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="printDemandVoucherVoucherDetail">
    <div class="well">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label style="border-bottom:2px solid #000 !important;">Printed On Date&nbsp;:&nbsp;</label><label
                    style="border-bottom:2px solid #000 !important;"><?php echo CommonHelper::changeDateFormat(date('Y-m-d'));
                    $x = date('Y-m-d');
                    echo ' ' . '(' . date('D', strtotime($x)) . ')'; ?></label>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                <?php echo CommonHelper::get_company_logo(Session::get('run_company')); ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 style="text-align: center;">
                    <h3 style="text-align: center;">Production Purchase Order</h3>
                    <h3 style="text-align: center;">{{ optional($purchaseOrder->company_location)->location_name }}</h3>
                </h3>
            </div>
        </div>
        <div style="line-height:5px;">&nbsp;</div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div style="width:34%; float:left;">
                    <table class="table table-bordered table-striped table-condensed tableMargin purchase_order">
                        <tbody>
                            <tr>
                                <td>PO No :</td>
                                <td class="text-center"> {{ strtoupper($purchaseOrder->voucher_no) }}</td>
                            </tr>
                            <tr>
                                <td>PO Date :</td>
                                <td class="text-center"> {{ date('d-m-Y', strtotime($purchaseOrder->voucher_date )) }}</td>
                            </tr>
                            <tr>
                                <td>Start Date :</td>
                                <td class="text-center"> {{ date('d-m-Y', strtotime($purchaseOrder->req_date )) }}</td>
                            </tr>
                            <tr>
                                <td>End Date :</td>
                                <td class="text-center"> {{ date('d-m-Y', strtotime($purchaseOrder->promise_date )) }}</td>
                            </tr>
                        
                          
                            <tr>
                                <td>Misc Exp Per Bag :</td>
                                <td class="text-center"> {{$purchaseOrder->misc_exp_per_bag }}</td>
                            </tr>
                            {{-- <tr>
                                <td>Requested By :</td>
                                <td class="text-center"> {{$purchaseOrder->username }}</td>
                            </tr> --}}
                            {{-- @if (count($purchaseOrder->attachments) > 0)
                                <tr class="hidden-print">
                                    <td>Attachemnt :</td>
                                    <td>
                                        @foreach ($purchaseOrder->attachments as $attachment)
                                            <a href="{{ asset($attachment->image_src) }}" target="_blank"
                                                class="btn btn-primary btn-xs">view</a>
                                        @endforeach
                                    </td>
                                </tr>
                            @endif --}}
                        
                        </tbody>
                    </table>
                </div>
                <div style="width:33%; float:left;">
                    <table class="table table-bordered table-striped table-condensed tableMargin purchase_order">
                        <tbody>
                            <tr>
                                <td>Supplier :</td>
                                <td class="text-center">{{ CommonHelper::get_arrival_supplier_name($purchaseOrder->supplier_id) }}</td>
                            </tr> 
                            <tr>
                                <td>Order Rate :</td>
                                <td class="text-center"> {{$purchaseOrder->order_rate }}</td>
                            </tr>    
                            <tr>
                                <td>Agent Name :</td>
                                <td class="text-center">{{ CommonHelper::get_arrival_supplier_name($purchaseOrder->agent_id) }}</td>
                            </tr>   
                            <tr>
                                <td>Rate Per Kg :</td>
                                <td class="text-center"> {{$purchaseOrder->rate_per_kg }}</td>
                            </tr>     
                            <tr>
                                <td>Freight Per Traller :</td>
                                <td class="text-center"> {{$purchaseOrder->freight_per_traller }}</td>
                            </tr>      
                        </tbody>
                    </table>
                </div>
                <div style="width:33%; float:right;">
                    <table class="table table-bordered table-striped table-condensed tableMargin purchase_order">
                        <tbody>
                            <tr>
                                <td>Delivery Term :</td>
                                <td class="text-center"> {{$purchaseOrder->delivery_term }}</td>
                            </tr>    
                            <tr>
                                <td>Delivery Mode Min :</td>
                                <td class="text-center">{{ CommonHelper::get_delivery_term()[$purchaseOrder->min_delivery_mode] ?? '' }}</td>
                            </tr>  
                            <tr>
                                <td>Location :</td>
                                <td class="text-center">{{ optional($purchaseOrder->company_location)->location_name }}</td>
                            </tr> 
                            <tr>
                                <td>Min Qty Traller :</td>
                                <td class="text-center"> {{$purchaseOrder->min_qty_traller }}</td>
                            </tr>    
                            <tr>
                                <td>Min Qty Truck :</td>
                                <td class="text-center">{{$purchaseOrder->min_qty_truck }}</td>
                            </tr>   
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="line-height:8px;">&nbsp;</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <h4 class="fw-bold">Item Detail</h4>
                    <table class="table table-bordered table-striped table-condensed tableMargin purchase_order">
                        <thead>
                            <tr>
                                <th class="text-center">Category </th>
                                <th class="text-center">Sub Category </th>
                                <th class="text-center" style="width: 20%;">Product Name</th>
                                <th class="text-center">Min Qty Bags</th>
                                <th class="text-center">Min Qty Kg</th>
                                <th class="text-center">Comission Term</th>
                                <th class="text-center">Comission Per Bag</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Landed Rate Per Kg</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($Arrival->arrival_report ?? [] as $key => $arrival_report) --}}
                                <tr class="text-center">
                                    <td class="text-center">{{ CommonHelper::get_product_name_by_id($purchaseOrder->category_id)->name }}</td>
                                    <td class="text-center">{{ CommonHelper::get_product_name_by_id($purchaseOrder->sub_category_id)->name }}</td>
                                    <td>{{ CommonHelper::get_product_name_by_id($purchaseOrder->product_id)->name }}</td>
                                    <td>{{$purchaseOrder->min_qty_bag }} </td>
                                    <td>{{$purchaseOrder->min_qty_kg }} </td>
                                    <td>{{$purchaseOrder->brokery_term }} </td>
                                    <td>{{$purchaseOrder->commission_per_bag }} </td>
                                    <td>{{$purchaseOrder->po_amount }} </td>
                                    <td>{{$purchaseOrder->landed_rate_per_kg }} </td>
                                </tr>
                            {{-- @endforeach --}}
                        </tbody>
    
                    </table>
                </div>
            </div>
            <div style="line-height:8px;">&nbsp;</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                
                    <style>
                        .signature_bor {
                            border-top: solid 1px #CCC;
                            padding-top: 7px;
                        }
                    </style>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:40px;margin-bottom:40px;">
                        <div class="container-fluid">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <P> {{ strtoupper($purchaseOrder->username ) }}</P>
                                    <p>{{ \Carbon\Carbon::parse($purchaseOrder->created_at)->format('d-m-Y h:i:s A') }}</p>
                                    <h5 class="signature_bor">Created By:</h5>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center" style="margin-top:4%">
                                    <h5 class="signature_bor">Approved By:</h5>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center" style="margin-top:4%">
                                   
                                    <h5 class="signature_bor">HOD Signature:</h5>
                                </div>
                            
                              
                               

                            </div>
                        </div>
                    </div>
                </div>
               


            </div>
        </div>
      
        
    </div>
</div>

