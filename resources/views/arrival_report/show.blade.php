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
                    <h3 style="text-align: center;">Arrival Report</h3>
                    <h3 style="text-align: center;">{{ optional($Arrival->company_location)->location_name }}</h3>
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
                                <td>Arrival No :</td>
                                <td class="text-center"> {{ strtoupper($Arrival->arrival_no) }}</td>
                            </tr>
                            <tr>
                                <td>Arrival Date</td>
                                <td class="text-center"> {{ date('d-m-Y', strtotime($Arrival->created_at )) }}</td>
                            </tr>
                           
                          
                            <tr>
                                <td>Requested By</td>
                                <td class="text-center"> {{$Arrival->requested_by }}</td>
                            </tr>
                            @if (count($Arrival->attachments) > 0)
                                <tr class="hidden-print">
                                    <td>Attachemnt</td>
                                    <td>
                                        @foreach ($Arrival->attachments as $attachment)
                                            <a href="{{ asset($attachment->image_src) }}" target="_blank"
                                                class="btn btn-primary btn-xs">view</a>
                                        @endforeach
                                    </td>
                                </tr>
                            @endif
                        
                        </tbody>
                    </table>
                </div>
                <div style="width:40%; float:right;">
                    <table class="table table-bordered table-striped table-condensed tableMargin purchase_order">
                        {{-- <tbody>
                            <tr>
                                <td>PR No :</td>
                                <td class="text-center">{{strtoupper($arrival_report->pr_no)}}</td>
                            </tr>
                            <tr>
                                <td>PO No</td>
                                <td class="text-center">{{strtoupper($arrival_report->po_no)}}</td>
                            </tr>  
                            <tr>
                                <td>Department</td>
                                <td class="text-center">{{CommonHelper::get_sub_dept_name($arrival_report->department_id)}}</td>
                            </tr> 
                            <tr>
                                <td>Vendor</td>
                                <td class="text-center">{{CommonHelper::get_supplier_name($arrival_report->vendor_id)}}</td>
                            </tr>             
                        </tbody> --}}
                    </table>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-condensed tableMargin purchase_order">
                        <thead>
                            <tr>
                                <th class="text-center">S No </th>
                                <th class="text-center">IGP No </th>
                                <th class="text-center">DC No </th>
                                <th class="text-center">PR / PO No </th>
                                <th class="text-center" style="width: 20%;">Item Name</th>
                                <th class="text-center">UOM </th>
                                <th class="text-center">Requested Qty</th>
                                <th class="text-center">Recieved Qty</th>
                                @if ($Arrival->arrival_approve)
                                    <th class="text-center">Accepted Qty</th>
                                    <th class="text-center">Rejected Qty</th>
                                    <th class="text-center">Accept/Reject Remarks</th>
                                @endif
                                <th class="text-center">Department</th>
                                <th class="text-center">Vendor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Arrival->arrival_report ?? [] as $key => $arrival_report)
                                <tr class="text-center">
                                    <td>{{++$key }} </td>
                                    <td>{{$arrival_report->igp_no }} </td>
                                    <td>{{$arrival_report->dc_no }} </td>
                                    <td>{{$arrival_report->pr_po_no == 0 ? 'N/A' : strtoupper($arrival_report->pr_po_no)}} </td>
                                    <td>{{$arrival_report->item }} </td>
                                    <td>{{$arrival_report->uom }} </td>
                                    <td class="text-center">{{$arrival_report->qty_requested }} </td>
                                    <td class="text-center">{{$arrival_report->qty_approved }} </td>
                                    @if ($Arrival->arrival_approve == 1)
                                        <td class="text-center">{{$arrival_report->accepted_qty }} </td>
                                        <td class="text-center">{{$arrival_report->rejected_qty ?? "0.00"}} </td>
                                        <td class="text-center">{{$arrival_report->accept_reject_remarks ?? ""}} </td>
                                        
                                    @endif
                                    <td>{{CommonHelper::get_sub_dept_name($arrival_report->department_id)}}</td>
                                    <td>{{CommonHelper::get_supplier_name($arrival_report->vendor_id)}}</td>
                                    
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

                        <span style=";font-size: 11px;resize: none" cols="100" rows="10"><?php echo 'Arrival Remarks :' . ' ' . strtoupper($Arrival->arrival_remarks); ?></span>
                    </div>
                    <style>
                        .signature_bor {
                            border-top: solid 1px #CCC;
                            padding-top: 7px;
                        }
                    </style>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:40px;margin-bottom:40px;">
                        <div class="container-fluid">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center">
                                    <P> {{ strtoupper($Arrival->requested_by) }}</P>
                                    <p>{{ \Carbon\Carbon::parse($Arrival->created_at)->format('d-m-Y h:i:s A') }}</p>
                                    <h5 class="signature_bor">Created By:</h5>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center" style="{{$Arrival->arrival_approve ? '' : 'margin-top: 4%'}}">
                                    @if($Arrival->arrival_approve == 1)
                                      <p>APPROVED BY {{strtoupper($Arrival->approve_name)}}</p>
                                        <p>{{ \Carbon\Carbon::parse($Arrival->approve_date)->format('d-m-Y h:i:s A') }}</p>
                                    @endif
                                    <h5 class="signature_bor">Acknowledged:</h5>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center" style="{{$Arrival->audit_approved ? '' : 'margin-top: 4%'}}">
                                    @if($Arrival->audit_approved == 1)
                                      <p>APPROVED BY {{strtoupper($Arrival->audit_name)}}</p>
                                        <p>{{ \Carbon\Carbon::parse($Arrival->audit_date)->format('d-m-Y h:i:s A') }}</p>
                                    @endif
                                    <h5 class="signature_bor">Auditor Approve:</h5>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center" style="margin-top: 4%">
                                   
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