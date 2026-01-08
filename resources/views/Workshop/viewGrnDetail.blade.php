<?php
use App\Helpers\CommonHelper;
use App\Helpers\PurchaseHelper;
use App\Helpers\ReuseableCode;
$approve = ReuseableCode::check_rights(534);
$m = Session::get('run_company');
$currentDate = date('Y-m-d');
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        {{ CommonHelper::displayPrintButtonInView('printDemandVoucherVoucherDetail', '', '1') }}
        @if ($grn->voucher_status == 1 && $approve)
            <a id="approved"href="#"onClick="approved({{ $grn->id }})" class="btn btn-success"
                style="padding: 10px;">Approved</a>
        @endif
        @if($grn->voucher_status == 2)
            <a id="approved"href="#"onClick="reverseWorkShopGRN({{ $grn->id }})" class="btn btn-success"
                style="padding: 10px;">Reverse</a>
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
                        <h3 style="text-align: center;">Workshop GRN Detail</h3>
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
                            <td class="text-center">{{ strtoupper($grn->voucher_no) }}</td>
                        </tr>
                        <tr>
                            <td>Voucher Date</td>
                            <td class="text-center">{{ CommonHelper::changeDateFormat($grn->voucher_date) }}
                            </td>
                        </tr>
                        @if (count($grn->comments) > 0)
                            <tr class="hidden-print">
                                <td>Attachemnt</td>
                                <td>
                                    @foreach ($grn->comments as $attachment)
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
                            <td class="text-center"><a href="#"onclick="showDetailModelOneParamerter('/workshop/viewMaintenanceRequestDetail',{{ $grn->maintenanceJob->maintenanceRequest->id }},'View Maintenance Request Details')">{{ strtoupper($grn->maintenanceJob->maintenanceRequest->voucher_no) }}</a></td>
                        </tr>
                        <tr>
                            <td>Supplier</td>
                            <td class="text-center">{{ $grn->maintenanceJob->supplier->name??'-' }}</td>
                        </tr>
                        <tr>
                            <td>Maintainace Job No</td>
                            <td class="text-center">{{ strtoupper($grn->maintenanceJob->voucher_no) }}</td>
                        </tr>
                        <tr>
                            <td>Job Type</td> 
                            <td class="text-center">{{ ($grn->maintenanceJob)?CommonHelper::getMaintenanceJobType()[$grn->maintenanceJob->job_type - 1]['name'] : '' }}</td>
                        </tr>
                        @if ($grn->maintenanceJob->job_type == 2)
                        @php
                            $get_pas_out = DB::connection('mysql2')->table('gate_passes')->where('maintenance_job_id',$grn->maintenanceJob->id)->where('gate_pass_type' , 2)->first();
                            $get_pas_in = DB::connection('mysql2')->table('gate_passes')->where('maintenance_job_id',$grn->maintenanceJob->id)->where('gate_pass_type' , 1)->first()->gate_pass_no;
                        @endphp
                        <tr>
                            <td>Gate Pass out</td>
                            <td class="text-center">{{ $get_pas_out->gate_pass_no ?? '' }}</td>
                        </tr>
                        <tr> 
                            <td>Gate Pass In</td>
                            <td class="text-center">{{ $get_pas_in ?? '' }}</td>
                        </tr>
                        @else
                        @php
                            $bom_no = DB::connection('mysql2')->table('maintenance_invoices')->where('maintenance_job_id',$grn->maintenanceJob->id)->first()->voucher_no;
                        @endphp
                        <tr> 
                            <td>BOM No</td>
                            <td class="text-center">{{ $bom_no ?? '' }}</td>
                        </tr>
                        @endif
                        
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
                        @foreach ($grn->itemData as $key => $itemData)
                            <tr class="text-center">
                                <td class="text-center">{{ ++$key }}</td>
                                <td id="{{ $itemData->id }}" title="{{ $itemData->item_id }}" class="textChanger">
                                    {{ $itemData->subItem->sku_code . ' - ' . $itemData->subItem->sub_ic }}
                                </td>
                                <td>{{ $itemData->subItem->uomData->uom_name }}</td>
                                <td class="text-center">{{ number_format($itemData->qty, 2) }}</td>
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
                        <h6 class="signature_bor">Workshop Incharge:</h6>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center"></div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center">
                        <p>_____________________</p>
                        <h6 class="signature_bor">Received By Department HOD:</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function approved(param) {
        $.ajax({
            url: '{{ url('/workshop/approvedGrn') }}',
            data: {
                id: param
            },
            type: 'GET',
            success: function(response) {
                if (response.error == 'error') {
                    alert('Can not Approved Because the Item is not exist in Record ' + response.message)
                    return false;
                } else if (response.error == 'success') {
                    $('#showDetailModelOneParamerter').modal('toggle');
                    alert('Approve Successfully');
                    $('#approved').remove();
                    getviewGRNList();
                }
            }
        })
    }
    function reverseWorkShopGRN(param){
        $.ajax({
            url: '{{ url('/workshop/reverseWorkShopGRN') }}',
            data: {
                id: param
            },
            type: 'GET',
            success: function(response) {
                $('#showDetailModelOneParamerter').modal('toggle');
                getviewGRNList();
            }
        })
    }
</script>
