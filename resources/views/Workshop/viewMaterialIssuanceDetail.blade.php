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
        {{-- @if ($maintenanceRequest->voucher_status == 1 && $approve)
            <a id="approved"href="#"onClick="approved({{ $maintenanceRequest->id }})" class="btn btn-success"
                style="padding: 10px;">Approved</a>
        @endif --}}
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
                        <h3 style="text-align: center;">Material Issuance</h3>
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
                            <td class="text-center">{{ strtoupper($materialIssuance->voucher_no) }}</td>
                        </tr>
                        <tr>
                            <td>Voucher Date</td>
                            <td class="text-center">
                                {{ CommonHelper::changeDateFormat($materialIssuance->voucher_date) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"></div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                <table class="table table-bordered table-striped table-condensed tableMargin">
                    <tbody>
                        <tr>
                            <td>Maintainace Request No</td>
                            <td class="text-center">{{ strtoupper($materialIssuance->maintenanceJob->maintenanceRequest->voucher_no ??'') }}</td>
                        </tr>
                        <tr>
                            <td>Supplier</td>
                            <td class="text-center">{{  $materialIssuance->maintenanceJob->supplier->name??'-'  }}</td>
                        </tr>
                       
                        <tr>
                            <td>Maintainace Job No</td>
                            <td class="text-center">{{ strtoupper($materialIssuance->maintenanceJob->voucher_no ?? '') }}</td>
                        </tr>
                        <tr>
                            <td>Job Type</td>
                            {{-- @php
                                // echo $materialIssuance->maintenanceJob->job_type;
                                echo $materialIssuance->maintenanceJob->gatePassIn()->first()->gate_pass_no;
                            @endphp --}}
                            <td class="text-center">{{ ($materialIssuance->maintenanceJob)?CommonHelper::getMaintenanceJobType()[$materialIssuance->maintenanceJob->job_type - 1]['name'] : '' }}</td>
                        </tr>
                        @if ($materialIssuance->maintenanceJob->job_type == 2)
                        @php
                            // echo $materialIssuance->maintenanceJob->gatePassOut()->first();
                            $get_pas_out = DB::connection('mysql2')->table('gate_passes')->where('maintenance_job_id',$materialIssuance->maintenanceJob->id)->where('gate_pass_type' , 2)->first();
                            $get_pas_in = DB::connection('mysql2')->table('gate_passes')->where('maintenance_job_id',$materialIssuance->maintenanceJob->id)->where('gate_pass_type' , 1)->where('status' , 1)->first()->gate_pass_no;
                            $grn_no = DB::connection('mysql2')->table('workshop_grns')->where('maintenance_job_id',$materialIssuance->maintenanceJob->id)->where('status' , 1)->first()->voucher_no;
                        @endphp
                        <tr>
                            <td>Gate Pass out</td>
                            <td class="text-center">{{ $get_pas_out->gate_pass_no ?? '' }}</td>
                        </tr>
                        <tr> 
                            <td>Gate Pass In</td>
                            <td class="text-center">{{ $get_pas_in ?? '' }}</td>
                        </tr>
                        <tr> 
                            <td>Grn No</td>
                            <td class="text-center">{{ $grn_no ?? '' }}</td>
                        </tr>
                        @else
                        @php
                            $bom_no = DB::connection('mysql2')->table('maintenance_invoices')->where('maintenance_job_id',$materialIssuance->maintenanceJob->id)->first();
                        @endphp
                        <tr> 
                            <td>BOM No</td>
                            <td class="text-center">{{ $bom_no ? $bom_no->voucher_no : '' }}</td>
                        </tr>
                        @endif
                        
                    </tbody>
                </table>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-bordered table-striped table-condensed tableMargin">
                    <tbody>
                        <tr>
                            <td>Remarks</td>
                            <td class="text-center" style="width: 80%;"> {{ $materialIssuance->description }}</td>
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
                            <th>Department</th>
                            <th>Quaantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materialIssuance->itemData as $key => $itemData)
                            <tr>
                                <th>{{ ++$key }}</th>
                                <th>{{ $itemData->subItem->sub_ic }}</th>
                                <th>{{ $itemData->department->sub_department_name }}</th>
                                <th>{{ $itemData->qty }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div style="line-height:8px;">&nbsp;</div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:40px;">
                <div class="container-fluid">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                            <h6>________________________________</h6>
                            <h6>Issued By: </h6>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center"></div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                            <h6>________________________________</h6>
                            <h6>Received By: </h6>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:40px;">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center"></div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center"></div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                            <h6>________________________________</h6>
                            <h6>Approval By HOD:</h6>
                        </div>
                    </div>
                </div>
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
