<?php
use App\Helpers\CommonHelper;
use App\Helpers\PurchaseHelper;
use App\Helpers\ReuseableCode;
use App\Models\PurchaseRequestData;
use App\Models\Demand; 
use App\Models\DemandData; 
$approved=ReuseableCode::check_rights(8);
$id = $_GET['id'];
$m = $_GET['m'];
$currentDate = date('Y-m-d');
$companyList = DB::table('company')->where('status','=','1')->where('id','!=',$m)->get();
CommonHelper::companyDatabaseConnection($m);
$demandDetail = Demand::where('demand_no','=',$id)->where('status', 1)->get();
CommonHelper::reconnectMasterDatabase();
$gmId=  ReuseableCode::check_rights(547); //[307,230,249];
$audId= ReuseableCode::check_rights(548);//[230,240,249];

foreach ($demandDetail as $row) {
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        <?php if($row->demand_status == 1 && $row->status == 1){?>
        <?php if($approved == true):?>
        @if (Session::get('run_company') == 8 && $row->gm_approval_status == 1)
            {{ Form::button('Approve', ['class' => 'btn btn-success btn-xs btn-abc hidden-print']) }}
        @elseif(Session::get('run_company') != 8)
            {{ Form::button('Approve', ['class' => 'btn btn-success btn-xs btn-abc hidden-print']) }}
        @endif
        <?php endif;?>
        <?php }?>
        <?php CommonHelper::displayPrintButtonInView('printDemandVoucherVoucherDetail', '', '1'); ?>


    </div>
</div>
<div style="line-height:5px;">&nbsp;</div>

<button type="button" id="download-pdf">
    Print Form
 </button>

<div class="row" id="printDemandVoucherVoucherDetail">


    <?php //echo PurchaseHelper::displayApproveDeleteRepostButtonTwoTable($m,$row->demand_status,$row->status,$row->demand_no,'demand_no','demand_status','status','demand','demand_data');
    ?>
    <?php echo Form::open(['url' => 'pad/updateDemandDetailandApprove?m=' . $m . '', 'id' => 'updateDemandDetailandApprove']); ?>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="pageType" value="<?php echo $_GET['pageType']; ?>">
    <input type="hidden" name="parentCode" value="<?php echo $_GET['parentCode']; ?>">
    <input type="hidden" name="demandNo" value="<?php echo $id; ?>">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="well">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label style="border-bottom:2px solid #000 !important;">Printed On
                                Date&nbsp;:&nbsp;</label><label
                                style="border-bottom:2px solid #000 !important;"><?php echo CommonHelper::changeDateFormat(date('Y-m-d'));
                                $x = date('Y-m-d');
                                echo ' ' . '(' . date('D', strtotime($x)) . ')'; ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?php echo CommonHelper::get_company_logo_miniphy(Session::get('run_company')); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="pur">
                                <h3 style="text-align: center;">Purchase Request</h3>
                                <h3 style="text-align: center;">{{ $row->company_location->location_name }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="line-height:5px;">&nbsp;</div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div>
                            <table class="table table-bordered table-striped table-condensed tableMargin purchace_order_tab2">
                                <tbody>
                                    <tr>
                                        <td>PR NO.</td>
                                        <td class="text-center"><?php echo strtoupper($row->demand_no); ?></td>
                                    </tr>
                                    <tr>
                                        <td>PR Date</td>
                                        <td class="text-center"><?php echo CommonHelper::changeDateFormat($row->demand_date); ?></td>
                                    </tr>
                                    <tr>
                                        <td>PR Location</td>
                                        <td class="text-center"><?php echo $row->company_location->location_name; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Ref No.</td>
                                        <td class="text-center"><?php echo $row->slip_no; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Department / Sub Department</td>
                                        <td class="text-center"><?php echo CommonHelper::getMasterTableValueById($m, 'sub_department', 'sub_department_name', $row->sub_department_id); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Document Mode</td>
                                        <td class="text-center"><?php echo CommonHelper::mode_type()[$row->p_type]; ?></td>
                                    </tr>
                                    @if (count($row->comments) > 0)
                                        <tr class="hidden-print">
                                            <td>Attachemnt</td>
                                            <td>
                                                @foreach ($row->comments as $attachment)
                                                    <a href="{{ asset($attachment->image_src) }}" target="blank"
                                                        class="btn btn-primary btn-xs">view</a>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endif

                                    <input type="hidden" name="v_type" id="v_type" value="{{ $row->p_type }}" />


                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-condensed tableMargin purchace_order_tab">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width:50px;">S.No</th>
                                        <th class="text-center" style="width:150px;">Item Codes</th>
                                        <th class="text-center">Item Name</th>

                                        <th class="text-center">UOM</th>
                                        <th class="text-center">Remarks</th>
                                        <th class="text-center" style="width:100px;">Qty.</th>
                                        {{-- <th class="text-center" style="width:100px;">Remaining Qty</th> --}}
                                        <th class="text-center">Last PO Detail</th>
                                        @foreach (CommonHelper::get_id_wise_warehouse([1,2, 3, 8]) as $warehouse)
                                            <th>
                                                {{ strtoupper($warehouse->name) }} Stock
                                            </th>
                                        @endforeach
                                        <th class="text-center hidden-print" style="width:100px;">ACTION</th>
                                        {{-- <th class="text-center" style="width:100px;">Last Rate</th>
                                <th class="text-center" style="width:100px;">Last Received Qty</th> --}}

                                        <!--
                                <?php if($row->demand_status == 1 && $row->status == 1){?>
                                <th class="text-center">Action</th>
                                <?php }else{?>
                                <th class="text-center">Demand Send Type</th>
                                <?php }?>
                                        <!-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                            CommonHelper::companyDatabaseConnection($m);
                            $demandDataDetail = DB::table('demand_data')->where('demand_no','=',$id)->where('status', 1)->get();
                            CommonHelper::reconnectMasterDatabase();
                            $counter = 1;
                            $totalCountRows = count($demandDataDetail);
                            foreach ($demandDataDetail as $row1){
                            ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php echo $counter++; ?>
                                            <input type="hidden" name="rowId[]" id="rowId_<?php $row1->id; ?>"
                                                value="<?php echo $row1->id; ?>">
                                        </td>

                                        <?php $sub_ic_detail = CommonHelper::get_subitem_detail($row1->sub_item_id);
                                        $sub_ic_detail = explode(',', $sub_ic_detail);
                                        ?>


                                        <td>{{ $sub_ic_detail[10] }}</td>

                                        <td title="{{ $row1->sub_item_id }}">
                                            {{CommonHelper::get_item_name($row1->sub_item_id)}} {{--{{$sub_ic_detail[1]??''}}--}}
                                            <input type="hidden" name="subItemId_<?php echo $row1->id; ?>"
                                                id="subItemId_<?php echo $row1->id; ?>" value="<?php echo $row1->sub_item_id; ?>">
                                        </td>

                                        <td> <?php echo $sub_ic_detail[0]; ?></td>
                                        <td> {{ $row1->sub_ic_desc }}</td>

                                        <td class="text-center"><?php echo number_format($row1->qty, 2); ?></td>

                                        {{-- <td class="text-center">{{CommonHelper::get_remaining_qty($row1->sub_item_id)}}</td> --}}
                                        <td class="text-center">
                                            @php
                                                $lastPOData = CommonHelper::LastPODetail($row1->sub_item_id);
                                                // dd($lastPOData);
                                            @endphp
                                            {{ 'PO No: '}}{{$lastPOData->purchase_request_no??'-'}} <br>
                                            {{ 'Rate: ' }}{{ number_format($lastPOData->rate??0, 2) }} <br>
                                            {{ 'Date: '}}{{ ($lastPOData && $lastPOData->purchase_request_date)? date("d-m-Y", strtotime($lastPOData->purchase_request_date)): '' }} <br>
                                            {{ 'Vendor: ' }}{{ CommonHelper::get_supplier_name($lastPOData->supplier_id ?? 0) }}
                                        </td>
                                        @foreach (CommonHelper::get_id_wise_warehouse([1,2, 3, 8]) as $warehouse)
                                            <td>
                                                {{ ReuseableCode::getColorRelatedStockType($row1->sub_item_id, $warehouse->id) }}<br>{{ ReuseableCode::get_stock($row1->sub_item_id, $warehouse->id, 0, 0) }}<br>
                                            </td>
                                        @endforeach
                                        <td class="text-center hidden-print">
                                            @php
                                                $checkItemExistInPO = PurchaseRequestData::where('demand_data_id', $row1->id)
                                                    ->where('status', 1)
                                                    ->first();
                                                $checkItemCancelInPR = DemandData::where('id', $row1->id)
                                                    ->where('status', 1)
                                                    ->first();
                                            @endphp
                                            @if ($checkItemExistInPO)
                                                {{ $checkItemExistInPO->purchase_request_no }}
                                            @else
                                                @if ($checkItemCancelInPR->cancel_status)
                                                    <button type="button" onclick="cancelPRData({{ $row1->id }})"
                                                        id="cancelPR{{ $row1->id }}"
                                                        class="btn btn-danger btn-xs">Cancel</button>
                                                @else
                                                    <span class="text-danger">Cancelled</span>
                                                @endif
                                            @endif
                                        </td>

                                        {{-- @php  ReuseableCode::get_stock($row1->sub_item_id, $warehouse->id, 0, 0)
                                    $lastRateOrQty = CommonHelper::get_last_rate_qty($row1->sub_item_id);
                                @endphp --}}
                                        {{-- <td class="text-center">{{ ($lastRateOrQty)? $lastRateOrQty->rate : 0 }}</td>
                                <td class="text-center">{{ ($lastRateOrQty)? $lastRateOrQty->qty : 0 }}</td> --}}


                                    </tr>
                                    <?php
                            }
                            ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div style="line-height:8px;">&nbsp;</div>
                    {{-- <div class="row"> --}}
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <table class="table table-bordered table-striped table-condensed tableMargin">
                                <tbody>
                                    <tr>
                                        <td>PR NO.</td>
                                        <td class="text-center"><?php echo strtoupper($row->demand_no); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    {{-- </div> --}}
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <h6>Description: <?php echo strtoupper($row->description); ?></h6>
                            </div>
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
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center">
                                        <h6 class="signature_bor">Created By:</h6>
                                        {{ $row->username }}
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center">
                                        <h6 class="signature_bor">Approved By:</h6>
                                        {{ $row->approve_username }}
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center">
                                        <h6 class="signature_bor">HOD: </h6>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center">
                                        @if (Session::get('run_company') == 1)
                                            @if ($row->aud_approval_status)
                                                <p>{{$row->aud_description}}</p>
                                                <p>{{($row->aud_approval_status == 1)? 'APPROVED' : 'REJECTED' }} BY {{strtoupper($row->aud_approval_username)}}</p>
                                                @if ($row->aud_date_time)
                                                    <p>{{ \Carbon\Carbon::parse($row->aud_date_time)->format('d-m-Y h:i:s A') }}</p>
                                                @endif
                                            @else
                                                @if ($audId == true)
                                                    <textarea name="" id="aud_description" class="form-control" rows="3"></textarea>
                                                    <button class="btn btn-xs btn-danger" type="button" onclick="AudApproval({{$row->id}}, 2);">Reject</button> |
                                                    <button class="btn btn-xs btn-primary" type="button" onclick="AudApproval({{$row->id}}, 1);">Approve</button>
                                                @endif
                                            @endif
                                        @endif
                                        
                                        <h6 class="signature_bor">Auditor:</h6>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center">
                                        <h6 class="signature_bor">General Manager Approval:</h6>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center">
                                        {{-- @if (Session::get('run_company') == 8) --}}
                                            @if ($row->gm_approval_status)
                                                <p>{{$row->gm_description}}</p>
                                                <p>{{($row->gm_approval_status == 1)? 'APPROVED' : 'REJECTED' }} BY {{strtoupper($row->gm_approval_username)}}</p>
                                                @if ($row->gm_date_time)
                                                    <p>{{ \Carbon\Carbon::parse($row->gm_date_time)->format('d-m-Y h:i:s A') }}</p>
                                                @endif
                                            @else
                                                @if ($gmId == true)
                                                    <textarea name="" id="gm_description" class="form-control" rows="3"></textarea>
                                                    <button class="btn btn-xs btn-danger" type="button" onclick="gmApproval({{$row->id}}, 2);">Reject</button> |
                                                    <button class="btn btn-xs btn-primary" type="button" onclick="gmApproval({{$row->id}}, 1);">Approve</button>
                                                @endif
                                            @endif
                                        {{-- @endif --}}
                                        @if (Session::get('run_company') == 8)
                                            <h6 class="signature_bor">Technical Head:</h6>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:40px;">
                            <div class="container-fluid">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                        <h6 class="signature_bor">Prepared By: </h6>
                                        <b>   <p> {{strtoupper($row->username)}}</p></b>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                        <h6 class="signature_bor">Checked By:</h6>
                                        <b>   <p></p></b>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                        <h6 class="signature_bor">Approved By:</h6>
                                        <b>  <p> {{strtoupper($row->approve_username)}} </p></b>
                                    </div>

                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <!--
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right hidden qrCodeDiv">
                            <img src="data:image/png;base64, { !! base64_encode(QrCode::format('png')->size(200)->generate('View Demand Voucher Detail'))!!} ">
                        </div>
                    <!-->
                </div>
            </div>
        </div>
        <?php }?>

        <?php echo Form::close(); ?>
    </div>



    <script>
    document.getElementById('download-pdf').addEventListener('click', function () {
        const element = document.querySelector('#printDemandVoucherVoucherDetail'); // Select the div to convert

        if (!element) {
            console.error('Element with class "booking-view" not found.');
            return;
        }

        const opt = {
            margin:       0.5,
            filename:     'booking-details.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        };

        // New Promise-based usage:
        html2pdf().set(opt).from(element).save();
    });
</script>


    <script type="text/javascript">
        $(".btn-abc").click(function(e) {
            var _token = $("input[name='_token']").val();
            jqueryValidationCustom();
            if (validate == 0) {
                //alert(response);
            } else {
                return false;
            }
            formSubmitOne();
        });

        function formSubmitOne(e) {

            var postData = $('#updateDemandDetailandApprove').serializeArray();
            var formURL = $('#updateDemandDetailandApprove').attr("action");
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function(data) {
                    $('#showDetailModelOneParamerter').modal('toggle');
                    //alert(data);
                    filterVoucherList();
                }
            });
        }

        function cancelPRData(dataId) {
            $.ajax({
                url: "{{ url('/pdc/cancelDemandData') }}",
                type: "get",
                data: {
                    id: dataId
                },
                success: function(data) {
                    // console.log(data);
                    $('#cancelPR' + dataId).attr('disabled', true)
                    // $('#showDetailModelOneParamerter').modal('toggle');
                    // //alert(data);
                    filterVoucherList();
                }
            });
        }

        function gmApproval(demand_id, approval_status){
            let gm_description = $('#gm_description').val();
            // let gm_approval_status = approval_status;
            $.ajax({
                url: '{{ url('pad/gmApproval') }}',
                type: 'get',
                data: {gm_description:gm_description, gm_approval_status:approval_status, demand_id:demand_id},
                success: function(response) {
                    if (response == 'updated') {
                        $('#showDetailModelOneParamerter').modal('hide');
                        filterVoucherList();
                        return
                    }
                }
            });
        }

        function AudApproval(demand_id, approval_status){
            let aud_description = $('#aud_description').val();
            // let gm_approval_status = approval_status;
            $.ajax({
                url: '{{ url('pad/audApproval') }}',
                type: 'get',
                data: {aud_description:aud_description, aud_approval_status:approval_status, demand_id:demand_id},
                success: function(response) {
                    if (response == 'updated') {
                        $('#showDetailModelOneParamerter').modal('hide');
                        filterVoucherList();
                        return
                    }
                }
            });
        }
    </script>

    
