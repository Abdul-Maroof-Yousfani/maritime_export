<?php
use App\Helpers\CommonHelper;
use App\Helpers\PurchaseHelper;
use App\Helpers\ReuseableCode;
$approve = ReuseableCode::check_rights(474);
$m = Session::get('run_company');
$currentDate = date('Y-m-d');
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        <?php CommonHelper::displayPrintButtonInView('printDemandVoucherVoucherDetail', '', '1'); ?>
        @if ($maintenanceRequest->voucher_status == 1 && $approve)
            <a id="approved"href="#"onClick="approved({{ $maintenanceRequest->id }})" class="btn btn-success"
                style="padding: 10px;">Approved</a>
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
                        <h3 style="text-align: center;">Maintenance Request</h3>
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
                            <td>Voucher No.</td>
                            <td class="text-center">{{ strtoupper($maintenanceRequest->voucher_no) }}</td>
                        </tr>
                        <tr>
                            <td>Voucher Date</td>
                            <td class="text-center">
                                {{ CommonHelper::changeDateFormat($maintenanceRequest->voucher_date) }}</td>
                        </tr>
                        <tr>
                            <td>Submit Date</td>
                            <td class="text-center">
                                {{ CommonHelper::changeDateFormat($maintenanceRequest->submit_date) }}</td>
                        </tr>
                        @if (count($maintenanceRequest->comments) > 0)
                            <tr class="hidden-print">
                                <td>Attachemnt</td>
                                <td>
                                    @foreach ($maintenanceRequest->comments as $attachment)
                                        <a href="{{ asset($attachment->image_src) }}" target="blank"
                                            class="btn btn-primary btn-xs">view</a>
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"></div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                <table class="table table-bordered table-striped table-condensed tableMargin">
                    <tbody>
                        <tr>
                            <td>Department</td>
                            <td class="text-center"> {{ $maintenanceRequest->department->sub_department_name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Machine</td>
                            <td class="text-center">
                                {{ $maintenanceRequest->machine->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Line</td>
                            <td class="text-center">
                                {{ $maintenanceRequest->line->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Warehouse</td>
                            <td class="text-center">
                                {{ $maintenanceRequest->warehouse->name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-bordered table-striped table-condensed tableMargin">
                    <tbody>
                        <tr>
                            <td>Damage Details</td>
                            <td class="text-center" style="width: 80%;"> {{ $maintenanceRequest->description }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-bordered table-striped table-condensed tableMargin">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Items</th>
                            <th>Quaantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($maintenanceRequest->itemData as $key => $itemData)
                            <tr>
                                <th>{{ ++$key }}</th>
                                <th>{{ $itemData->subItem->sub_ic }}</th>
                                <th>{{ $itemData->qty }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div style="line-height:8px;">&nbsp;</div>
        <div class="row text-center" style="margin-top:40px;">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                <b>
                    <p>_________________________</p>
                </b>
                <h6 class="signature_bor">Requested By: </h6>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center"></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                <b>
                    <p>_________________________</p>
                </b>
                <h6 class="signature_bor">Received By:</h6>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function approved(id) {
        $.ajax({
            url: "{{ url('/workshop/approvedMaintenanceRequest') }}",
            data: {
                id: id
            },
            type: 'GET',
            success: function(response) {
                if (response == 'success') {
                    alert('Approv Successfully');
                    $('#approved').remove();
                    getMaintenanceRequestList();
                }
            }
        })
    }
</script>
