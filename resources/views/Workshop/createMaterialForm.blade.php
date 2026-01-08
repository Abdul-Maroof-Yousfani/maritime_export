<?php
$m = Session::get('run_company');
use App\Helpers\StoreHelper;
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
?>
@extends('layouts.default')

@section('content')
    @include('select2')
    @include('modal')
    @include('number_formate')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well_N">
                    <div class="dp_sdw">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span class="subHeadingLabelClass">Create Material Issuance Form</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                {{ Form::open(['url' => 'workshop/addMaterialIssuanceDetail?m=' . $m . '', 'id' => 'cashPaymentVoucherForm', 'class' => 'stop']) }}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label class="sf-label">Select Maintenance Job</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <select class="form-control requiredField select2" name="maintenance_job_id"
                                            id="maintenance_job_id" onchange="createMaterialFormAjax()">
                                            <option value="">Select Maintenance Job</option>
                                            @foreach ($maintenanceJobs as $maintenanceJob)
                                                <option value="{{ $maintenanceJob->id }}">{{ $maintenanceJob->voucher_no }} &nbsp; ( {{ CommonHelper::getMaintenanceJobType()[$maintenanceJob->job_type - 1]['name'] }} )
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <button type="button"
                                            onclick="createMaterialFormAjax()" style="margin-top: 35px;">GET</button>
                                    </div>
                                    <div id="createMaterialFormAjax"></div>
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

        function createMaterialFormAjax() {
            $('#createMaterialFormAjax').html(
                '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div>'
            );
            let maintenance_job_id = $('#maintenance_job_id').val();
            $.ajax({
                url: '<?php echo url('/'); ?>/workshop/createMaterialFormAjax',
                method: 'GET',
                data: {
                    id: maintenance_job_id
                },
                error: function() {
                    alert('error');
                },
                success: function(response) {
                    $('#createMaterialFormAjax').html(response);
                }
            });
        }
    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
