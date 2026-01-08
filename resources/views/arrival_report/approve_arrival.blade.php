<?php 
use App\Helpers\CommonHelper; 
$m = Session::get('run_company');
$currentDate = date('Y-m-d');
?>

<div style="line-height:5px;">&nbsp;</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="printDemandVoucherVoucherDetail">
    <div class="well">

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
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-condensed tableMargin purchase_order">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 20%;">Item Name</th>
                                <th class="text-center">UOM </th>
                                <th class="text-center">Requested Qty</th>
                                <th class="text-center">Recieved Qty</th>
                                <th class="text-center">Accepted Qty</th>
                                <th class="text-center">Rejected Qty</th>
                                <th class="text-center">Accepted / Reject Remarks</th>
                            </tr>
                        </thead>
                        <tbody  id="acknowledge" >
                            @foreach ($Arrival->arrival_report ?? [] as $arrival_report)
                                <tr class="text-center">
                                    <td>{{$arrival_report->item }} </td>
                                    <td>{{$arrival_report->uom }} </td>
                                    <td class="text-center">{{$arrival_report->qty_requested }} </td>
                                    <td class="text-center">{{$arrival_report->qty_approved }} </td>
                                   
                                    <td ><input type="text" value="0" class="form-control" name="accepted_qty[]" id="accepted_qty"> 
                                        <input  type="hidden" value="{{$arrival_report->id}}" class="form-control" name="data_id[]" id="data_id"> 
                                    </td>
                                    <td ><input type="text" value="0" class="form-control" name="rejected_qty[]" id="accepted_qty"> </td>
                                    <td><textarea class="form-control" name="accept_reject_remarks[]" id="accept_reject_remarks" ></textarea> </td>
                                
                                </tr>
                            @endforeach
                        </tbody>
    
                    </table>
                </div>
            </div>
            <div style="line-height:8px;">&nbsp;</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <button onclick="approve({{$Arrival->id}})" id=""
                    class="btn btn-success">Submit</button>
            </div>
        </div>
      
        
    </div>
</div>