<?php
use App\Helpers\CommonHelper;
use App\Helpers\PurchaseHelper;
use App\Helpers\ReuseableCode;
if ($gatePass->gate_pass_type == 1) {
    $approve = ReuseableCode::check_rights(532);
} else {
    $approve = ReuseableCode::check_rights(533);
}
$m = Session::get('run_company');
$currentDate = date('Y-m-d');

?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        {{ CommonHelper::displayPrintButtonInView('printDemandVoucherVoucherDetail', '', '1') }}
        @if ($gatePass->voucher_status == 1 && $approve)
            <a id="approved"href="#" onClick="approved({{ $gatePass->id }})" class="btn btn-success"
                style="padding: 10px;">Approved</a>
        @endif
        @if($gatePass->gate_pass_type == 1)
            @if($gatePass->voucher_status == 2)
                @if(empty($gatePassTwo->voucher_no))
                    <a id="reverse" href="#" onClick="reverse({{ $gatePass->id }})" class="btn btn-success"
                        style="padding: 10px;">Reverse After Approval Gate Pass In</a>
                @endif
            @endif
        @endif

        @if($gatePass->gate_pass_type == 2)
            @if($gatePass->voucher_status == 2 && $gatePass->is_complete == 0)
                <a id="reverse" href="#" onClick="reverse({{ $gatePass->id }})" class="btn btn-success"
                    style="padding: 10px;">Reverse After Approval Gate Pass Out</a>
            @endif
        @endif
        
    </div>
</div>
<div class="row" id="printDemandVoucherVoucherDetail">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                <label style="border-bottom:2px solid #000 !important;">Printed On Date&nbsp;:&nbsp;</label><label
                    style="border-bottom:2px solid #000 !important;">{{ CommonHelper::changeDateFormat($currentDate) }}</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"
                        style="font-size: 30px !important; font-style: inherit;
    								font-family: -webkit-body; font-weight: bold;">
                        {{ CommonHelper::getCompanyName($m) }}
                        <h3 style="text-align: center;">Gate Pass (@if ($gatePass->gate_pass_type == 1)
                                IN
                            @else
                                OUT
                            @endif)</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                <label style="border-bottom:2px solid #000 !important;">Printed On Day&nbsp;:&nbsp;</label><label
                    style="border-bottom:2px solid #000 !important;">{{ '&nbsp;' . date('l', strtotime($currentDate)) }}</label>

            </div>
        </div>
        <div style="line-height:5px;">&nbsp;</div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                <table class="table table-bordered table-striped table-condensed tableMargin">
                    <tbody>
                        <tr>
                            <td>Gate Pass No.</td>
                            <td class="text-center">{{ strtoupper($gatePass->gate_pass_no) }}</td>
                        </tr>
                        <tr>
                            <td>Gate Pass Date</td>
                            <td class="text-center">{{ CommonHelper::changeDateFormat($gatePass->gate_pass_date) }}
                            </td>
                        </tr>
                        <tr>
                            <td>MJO No.</td>
                            <td class="text-center">{{ $gatePass->mo_no }}
                            </td>
                        </tr>
                        <tr>
                            <td>MR No.</td>
                            <td class="text-center">{{ $gatePass->maintenanceJob->maintenanceRequest->voucher_no ?? '' }}
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"></div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                <table class="table table-bordered table-striped table-condensed tableMargin">
                    <tbody>
                        <tr>
                            <td>Supplier Name</td>
                            <td class="text-center">
                                {{ $gatePass->maintenanceJob->supplier->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Supplier Address</td>
                            <td class="text-center">
                                {{ $gatePass->maintenanceJob->supplier->address ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Warehouse</td>
                            <td class="text-center">
                                {{ $gatePass->maintenanceJob->maintenanceRequest->warehouse->name ?? '' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed tableMargin">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:50px;">S.No</th>
                            <th class="text-center">Product</th>
                            <th class="text-center">Uom</th>
                            <th class="text-center">Quantity</th>
                            @if ($gatePass->gate_pass_type == 1)
                                <th class="text-center">Received QTY.</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gatePass->gatePassesData as $key => $jobData)
                            <tr class="text-center">
                                <td class="text-center">{{ ++$key }}</td>
                                <td id="{{ $jobData->id }}" title="{{ $jobData->item_id }}" class="textChanger">
                                    {{ $jobData->subItem->sku_code . ' - ' . $jobData->subItem->sub_ic }}
                                </td>
                                <td>{{ $jobData->subItem->uomData->uom_name }}</td>
                                <td class="text-center">{{ number_format($jobData->qty, 2) }}</td>
                                @if ($gatePass->gate_pass_type == 1)
                                    <td class="text-center">{{ number_format($jobData->qty_received, 2) }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>
        <div style="line-height:8px;">&nbsp;</div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:40px;">
            <div class="container-fluid">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center">
                        <p>_____________________</p>
                        <h6 class="signature_bor">Created By:</h6>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center"></div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center">
                        <p>_____________________</p>
                        @if ($gatePass->gate_pass_type == 1)
                            <h6 class="signature_bor">Workshop incharge:</h6>
                        @else
                            <h6 class="signature_bor">Checked in system at security gate:</h6>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function approved(param) {
        $.ajax({
            url: '{{ url('/gatepass/approvedGatePass') }}',
            data: {
                id: param
            },
            type: 'GET',
            success: function(response) {
                if (response.error == 'error') {
                    alert('Can not Approved Because the Item is not exist in Record ' + response.message)
                    return false;
                } else if (response.error == 'success') {

                    alert('Approve Successfully');
                    $('#approved').remove();
                    getMaintenanceJobList();
                }
            }
        })
    }

    function reverse(param) {
        $.ajax({
            url: '{{ url('/gatepass/reverseGatePass') }}',
            data: {
                id: param
            },
            type: 'GET',
            success: function(response) {
                alert('Reverse Successfully');
                $('#reverse').remove();
                getMaintenanceJobList();
            }
        })
    }
</script>
