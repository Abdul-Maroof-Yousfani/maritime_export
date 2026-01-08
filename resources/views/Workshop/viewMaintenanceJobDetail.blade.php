<?php
use App\Helpers\CommonHelper;
use App\Helpers\PurchaseHelper;
use App\Helpers\ReuseableCode;
$approve = ReuseableCode::check_rights(526);
$m = Session::get('run_company');
$currentDate = date('Y-m-d');
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        {{ CommonHelper::displayPrintButtonInView('printDemandVoucherVoucherDetail', '', '1') }}
        @if ($maintenanceJob->voucher_status == 1 && $approve)
            <a id="approved"href="#"onClick="approved({{ $maintenanceJob->id }})" class="btn btn-success"
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
                        <h3 style="text-align: center;">Maintenance Job {{{CommonHelper::getMaintenanceJobType()[$maintenanceJob->job_type-1]['name']}}} </h3>
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
                            <td class="text-center">{{ strtoupper($maintenanceJob->voucher_no) }}</td>
                        </tr>
                        <tr>
                            <td>Voucher Date</td>
                            <td class="text-center">{{ CommonHelper::changeDateFormat($maintenanceJob->voucher_date) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Repairing Location</td>
                            <td class="text-center">{{ $maintenanceJob->companyLocation->location_name }}</td>
                        </tr>
                        @if ($maintenanceJob->job_type == 2)
                            <tr>
                                <td>Supplier</td>
                                <td class="text-center">{{ $maintenanceJob->supplier->name??'-' }}</td>
                            </tr>
                        @else
                        <tr>
                            <td>Repairing Location To</td>
                            <td class="text-center">{{ $maintenanceJob->companyLocationTo->location_name??'-' }}</td>
                        </tr>
                        @endif
                        @if (count($maintenanceJob->comments) > 0)
                        <tr class="hidden-print">
                            <td>Attachemnt</td>
                            <td>
                                @foreach ($maintenanceJob->comments as $attachment)
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
                            <td>Maintenance Request No.</td>
                            <td class="text-center">{{ strtoupper($maintenanceJob->maintenanceRequest->voucher_no) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Department</td>
                            <td class="text-center">
                                {{ $maintenanceJob->maintenanceRequest->department->sub_department_name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Machine</td>
                            <td class="text-center">
                                {{ $maintenanceJob->maintenanceRequest->machine->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Line</td>
                            <td class="text-center">
                                {{ $maintenanceJob->maintenanceRequest->line->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Warehouse</td>
                            <td class="text-center">
                                {{ $maintenanceJob->maintenanceRequest->warehouse->name }}
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
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($maintenanceJob->jobData as $key => $jobData)
                            <tr class="text-center">
                                <td class="text-center">{{ ++$key }}</td>
                                <td id="{{ $jobData->id }}" title="{{ $jobData->item_id }}" class="textChanger">
                                    {{ $jobData->subItem->sku_code . ' - ' . $jobData->subItem->sub_ic }}
                                </td>
                                <td>{{ $jobData->subItem->uomData->uom_name }}</td>
                                <td class="text-center">{{ number_format($jobData->qty, 2) }}</td>
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
                <h6 class="signature_bor">Workshop Incharge: </h6>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center"></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                <b>
                    <p>_________________________</p>
                </b>
                <h6 class="signature_bor">Store HOD:</h6>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function approved(param) {
        $.ajax({
            url: '{{ url('/workshop/approvedMaintenanceJob') }}',
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
</script>
