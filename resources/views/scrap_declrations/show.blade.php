<?php 
use App\Helpers\CommonHelper; 
use App\Helpers\ReuseableCode; 
$m = Session::get('run_company');
$currentDate = date('Y-m-d');
$gmId=  ReuseableCode::check_rights(547); //[307,230,249];
$audId= ReuseableCode::check_rights(548);
$Acknowledged= ReuseableCode::check_rights(548);
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
                    <h3 style="text-align: center;">Scrap Declration</h3>
                    <h3 style="text-align: center;">{{ optional($scrap_declration->company_location)->location_name }}</h3>
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
                                <td>Scrap Declration No :</td>
                                <td class="text-center"> {{ strtoupper($scrap_declration->sd_no) }}</td>
                            </tr>
                            <tr>
                                <td>Scrap Declration Date</td>
                                <td class="text-center"> {{ date('d-m-Y', strtotime($scrap_declration->sd_date )) }}</td>
                            </tr>
                           
                          
                            <tr>
                                <td>Requested By</td>
                                <td class="text-center"> {{$scrap_declration->requested_by }}</td>
                            </tr>
                           
                        </tbody>
                    </table>
                </div>
                <div style="width:40%; float:right;">
                    <table class="table table-bordered table-striped table-condensed tableMargin purchase_order">
                        <tbody>
                            <tr>
                                <td>Department :</td>
                                <td class="text-center">{{optional($scrap_declration->department)->sub_department_name}}</td>
                            </tr>  
                            <tr>
                                <td>Line No</td>
                                <td class="text-center">{{optional($scrap_declration->line)->name}}</td>
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
                                <th class="text-center">S.NO</th>
                                <th class="text-center">Scrap Category</th>
                                <th class="text-center">Item Name</th>
                                <th class="text-center">Item Code </th>
                                <th class="text-center">Item Description </th>
                                <th class="text-center">UOM </th>
                                <th class="text-center">Qty # </th>
                                <th class="text-center">Reason For Scrapping # </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($scrap_declration->ScrapData ?? [] as $key => $detail)
                                <tr class="text-center">
                                    <td>{{++$key }} </td>
                                    <td>{{ucwords($detail->category_id) }} </td>
                                    <td>{{$detail->item }} </td>
                                    <td>{{$detail->item_code }} </td>
                                    <td>{{$detail->item_desc }} </td>
                                    <td>{{$detail->uom }} </td>
                                    <td class="text-center">{{$detail->qty }} </td>
                                    <td class="text-center">{{$detail->reason_for_scrapping }} </td>
                                    
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

                        <span style=";font-size: 11px;resize: none" cols="100" rows="10"><?php echo 'Scrap Remarks :' . ' ' . strtoupper($scrap_declration->sd_remarks); ?></span>
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
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center" style="margin-top: 5%">
                                    <P> {{ strtoupper($scrap_declration->requested_by) }}</P>
                                    <p>{{ \Carbon\Carbon::parse($scrap_declration->created_at)->format('d-m-Y h:i:s A') }}</p>
                                    <h5 class="signature_bor">Created By:</h5>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center" style="{{$scrap_declration->approve_name != '' ? 'margin-top: 5%' : 'margin-top: 7%'}}">
                                    @if($scrap_declration->approve_name != '')
                                      <p>APPROVED BY {{strtoupper($scrap_declration->approve_name)}}</p>
                                        <p>{{ \Carbon\Carbon::parse($scrap_declration->approve_date)->format('d-m-Y h:i:s A') }}</p>
                                    @else
                                        @if ($Acknowledged == true)
                                            <button class="btn btn-xs btn-danger" type="button" onclick="AckApproval({{$scrap_declration->id}}, 2);">Reject</button> |
                                            <button class="btn btn-xs btn-primary" type="button" onclick="AckApproval({{$scrap_declration->id}}, 1);">Approve</button>
                                        @endif
                                    @endif
                                    <h5 class="signature_bor">Acknowledged:</h5>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center" style="{{$scrap_declration->aud_approval_status == 1 ? 'margin-top: 2.5%' : ''}}">
                                    @if ($scrap_declration->aud_approval_status)
                                        <p>{{$scrap_declration->aud_description}}</p>
                                        <p>{{($scrap_declration->aud_approval_status == 1)? 'APPROVED' : 'REJECTED' }} BY {{strtoupper($scrap_declration->aud_approval_username)}}</p>
                                        @if ($scrap_declration->aud_date_time)
                                            <p>{{ \Carbon\Carbon::parse($scrap_declration->aud_date_time)->format('d-m-Y h:i:s A') }}</p>
                                        @endif
                                    @else
                                        @if ($audId == true)
                                            <textarea name="" id="aud_description" class="form-control" rows="3"></textarea>
                                            <button class="btn btn-xs btn-danger" type="button" onclick="AudApproval({{$scrap_declration->id}}, 3);">Reject</button> |
                                            <button class="btn btn-xs btn-primary" type="button" onclick="AudApproval({{$scrap_declration->id}}, 1);">Approve</button>
                                        @endif
                                    @endif
                                    <h6 class="signature_bor">Auditor:</h6>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center" style="{{$scrap_declration->gm_approval_status == 1 ? 'margin-top: 2.5%' : ''}}">
                                        @if ($scrap_declration->gm_approval_status)
                                            <p>{{$scrap_declration->gm_description}}</p>
                                            <p>{{($scrap_declration->gm_approval_status == 1)? 'APPROVED' : 'REJECTED' }} BY {{strtoupper($scrap_declration->gm_approval_username)}}</p>
                                            @if ($scrap_declration->gm_date_time)
                                                <p>{{ \Carbon\Carbon::parse($scrap_declration->gm_date_time)->format('d-m-Y h:i:s A') }}</p>
                                            @endif
                                        @else
                                            @if ($gmId == true)
                                                <textarea name="" id="gm_description" class="form-control" rows="3"></textarea>
                                                <button class="btn btn-xs btn-danger" type="button" onclick="gmApproval({{$scrap_declration->id}}, 2);">Reject</button> |
                                                <button class="btn btn-xs btn-primary" type="button" onclick="gmApproval({{$scrap_declration->id}}, 1);">Approve</button>
                                            @endif
                                        @endif
                                    
                                     @if (Session::get('run_company') == 8)
                                        <h6 class="signature_bor">Technical Head:</h6>
                                    @endif
                                </div>
                            
                              
                               

                            </div>
                        </div>
                    </div>
                </div>
               


            </div>
        </div>
      
        
    </div>
</div>
<script>
      function gmApproval(scrap_id, approval_status){
            let gm_description = $('#gm_description').val();
            // let gm_approval_status = approval_status;
            $.ajax({
                url: '{{ url('purchase/gmApproval') }}',
                type: 'get',
                data: {gm_description:gm_description, gm_approval_status:approval_status, scrap_id:scrap_id},
                success: function(response) {
                    if (response == 'updated') {
                        $('#showDetailModelOneParamerter').modal('hide');
                        FetchPOList();
                        return
                    }
                }
            });
        }

        function AckApproval(scrap_id, approval_status){
            $.ajax({
                url: '{{ url('purchase/approve_scrap_declration') }}',
                type: 'get',
                data: { approval_status:approval_status, scrap_id:scrap_id},
                success: function(response) {
                    if (response == 'updated') {
                        $('#showDetailModelOneParamerter').modal('hide');
                        FetchPOList();
                        return
                    }
                }
            });
        }

        function AudApproval(scrap_id, approval_status){
            let aud_description = $('#aud_description').val();
            // let gm_approval_status = approval_status;
            $.ajax({
                url: '{{ url('purchase/audApproval') }}',
                type: 'get',
                data: {aud_description:aud_description, aud_approval_status:approval_status, scrap_id:scrap_id},
                success: function(response) {
                    if (response == 'updated') {
                        $('#showDetailModelOneParamerter').modal('hide');
                        FetchPOList();
                        return
                    }
                }
            });
        }
</script>