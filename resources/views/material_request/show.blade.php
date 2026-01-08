<?php 
use App\Helpers\CommonHelper; 
$m = Session::get('run_company');
$currentDate = date('Y-m-d');
?>
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
                    <h3 style="text-align: center;">Material Request</h3>
                    <h3 style="text-align: center;">{{ optional($material_request->company_location)->location_name }}</h3>
                </h3>
            </div>
        </div>
        <div style="line-height:5px;">&nbsp;</div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div style="width:40%; float:left;">
                    <table class="table table-bordered table-striped table-condensed tableMargin purchase_order">
                        <tbody>
                            <tr>
                                <td>Material Request No :</td>
                                <td class="text-center"> {{ strtoupper($material_request->mr_no) }}</td>
                            </tr>
                            <tr>
                                <td>Materail Request Date</td>
                                <td class="text-center"> {{ date('d-m-Y', strtotime($material_request->mr_date )) }}</td>
                            </tr>
                           
                          
                            <tr>
                                <td>Requested By</td>
                                <td class="text-center"> {{$material_request->requested_by }}</td>
                            </tr>
                        
                        </tbody>
                    </table>
                </div>
                <div style="width:40%; float:right;">
                    <table class="table table-bordered table-striped table-condensed tableMargin purchase_order">
                        <tbody>
                            <tr>
                                <td>Department :</td>
                                <td class="text-center">{{optional($material_request->department)->sub_department_name}}</td>
                            </tr>
                            <tr>
                                <td>Machinery</td>
                                <td class="text-center">{{optional($material_request->machine)->name}}</td>
                            </tr>     
                            <tr>
                                <td>Line No</td>
                                <td class="text-center">{{optional($material_request->line)->name}}</td>
                            </tr>            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-condensed tableMargin purchase_order">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px;">S.No</th>
                                <th class="text-center" style="width: 20%;">Item Name</th>
                                <th class="text-center">UOM </th>
                                <th class="text-center">Warehouse</th>
                                <th class="text-center">Available Stock</th>
                                <th class="text-center"> Qty Requested</th>
                                <th class="text-center">Material Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($material_request->material_request_data ?? [] as $key => $detail)
                                <tr class="text-center">
                                    <td class="text-center">{{ ++$key }}</td>
                                    <td>{{$detail->item }} </td>
                                    <td>{{$detail->uom }} </td>
                                    <td>{{optional($detail->warehouse)->name}}</td>
                                    <td class="text-center">{{$detail->stock_qty }} </td>
                                    <td class="text-center">{{$detail->qty_requested }} </td>
                                    <td>{{$detail->material_description }} </td>
                                
                                </tr>
                            @endforeach
                        </tbody>
    
                    </table>
                </div>
            </div>
            <div style="line-height:8px;">&nbsp;</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <span style=";font-size: 11px;resize: none" cols="100" rows="10"><?php echo 'Description:' . ' ' . strtoupper($material_request->remarks); ?></span>
                    </div>
                    <style>
                        .signature_bor {
                            border-top: solid 1px #CCC;
                            padding-top: 7px;
                        }
                    </style>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:40px;">
                        <div class="container-fluid">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <h6 class="signature_bor">Created By:</h6>
                                    {{ strtoupper($material_request->requested_by) }}
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <h6 class="signature_bor">Approved By:</h6>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <h6 class="signature_bor">Issued By: </h6>
                                </div>
                              
                               

                            </div>
                        </div>
                    </div>
                </div>
               


            </div>
        </div>
      
        
    </div>
</div>