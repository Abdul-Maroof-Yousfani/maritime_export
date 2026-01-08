<?php
$m = Session::get('run_company');
use App\Helpers\StoreHelper;
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
?>
@extends('layouts.default')

@section('content')
    @include('select2')
   
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well_N">
                    <div class="dp_sdw">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span class="subHeadingLabelClass">Maintenance Analyzing Form</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                {{ Form::open(['url' => 'workshop/addAnalyzingReportDetail?m=' . $m . '', 'id' => 'cashPaymentVoucherForm', 'class' => 'stop']) }}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label class="sf-label">Select Maintenance Request</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <select class="form-control requiredField select2" name="maintenance_request_id"
                                            id="maintenance_request_id" onchange="getMaintenanceRequestDataForGoodsReturn()">
                                            <option value="">Select Maintenance Request</option>
                                            @foreach ($maintenance_requests as $maintenance_request)
                                                <option value="{{$maintenance_request->id}}">{{$maintenance_request->voucher_no}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <br/>
                                        <button type="button" onclick="getMaintenanceRequestDataForGoodsReturn()">GET</button>
                                    </div>
                                    <div id="getMaintenanceRequestDataForGoodsReturn"></div>
                                </div>
                                <?php echo Form::close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.select2').select2();

        function getMaintenanceRequestDataForGoodsReturn() {
                $('#getMaintenanceRequestDataForGoodsReturn').html(
                    '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div>'
                );
                let maintenance_request_id = $('#maintenance_request_id').val();
                $.ajax({
                    url: '<?php echo url('/'); ?>/workshop/getMaintenanceRequestDataForGoodsReturn',
                    method: 'GET',
                    data: {id: maintenance_request_id},
                    error: function() {
                        alert('error');
                    },
                    success: function(response) {
                        $('#getMaintenanceRequestDataForGoodsReturn').html(response);
                    }
                });
            }
    </script>
@endsection
