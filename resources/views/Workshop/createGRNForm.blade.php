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
                                <span class="subHeadingLabelClass">Create Goods Receipt Note</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                {{ Form::open(['url' => '/workshop/addWorkshopGRNDetails', 'id' => 'cashPaymentVoucherForm', 'class' => 'stop', 'enctype' => 'multipart/form-data']) }}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="sf-label">Select Location</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <select class="form-control requiredField select2" name="location_id"
                                            id="location_id" onchange="getMJO()">
                                            <option value="">Select Warehouse</option>
                                            @foreach (ReuseableCode::getUserWiseLocationRightsData() as $company_location)
                                                <option value="{{ $company_location['id'] }}">
                                                    {{ $company_location['location_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="sf-label">Select Maintenance Job</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <select class="form-control requiredField select2" name="maintenance_job_id"
                                            id="maintenance_job_id" onchange="getGetPassIn()">
                                            {{-- <option value="">Select Maintenance Job Outsource</option>
                                            @foreach ($maintenanceJobs as $maintenanceJob)
                                                <option value="{{$maintenanceJob->id}}">{{$maintenanceJob->voucher_no}}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="sf-label">Gate Pass (IN)</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <select class="form-control requiredField select2" name="gate_pass_id" id="gate_pass_id"
                                            onchange="getMaintenanceJobDataForGRN()">
                                            <option value="">Select Gate Pass (IN)</option>

                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <button type="button" onclick="getMaintenanceJobDataForGRN()" style="margin-top: 35px;">GET</button>
                                    </div>
                                    <div id="getMaintenanceJobDataForGRN"></div>
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

        function getMJO(){
            let location_id = $('#location_id').val();
            $.ajax({
                url: '{{url("/workshop/getMJOForGrn")}}',
                method: 'GET',
                data: {
                    warehouse_id: location_id,
                },
                error: function() {
                    alert('error');
                },
                success: function(response) {
                    console.log(response);
                    let options = '<option value="">Select Maintenance Job Outsource</option>';
                    if (response.length > 0) {
                        $.each(response, function (indexInArray, valueOfElement) { 
                            options += `<option value="${valueOfElement.id}">${valueOfElement.voucher_no}</option>`;                            
                        });                    
                    } else {
                        getMaintenanceJobDataForGatePass()
                    }
                    $('#maintenance_job_id').html(options); 
                    // $('#getMaintenanceJobDataForGatePass').html(response);
                }
            });
        }


        function getGetPassIn() {
            var gate_pass_type = 2;
            let maintenance_job_id = $('#maintenance_job_id').val();
            let location_id = $('#location_id').val();
            $.ajax({
                url: '{{ route('gatepass.getGetPassIn') }}',
                method: 'GET',
                data: {
                    id: maintenance_job_id,
                    gate_pass_type: gate_pass_type,
                    location_id:location_id
                },
                error: function() {
                    alert('error');
                },
                success: function(response) {
                    console.log(response);
                    if (response.gatepass.length > 0) {
                        $.each(response.gatepass, function (indexInArray, valueOfElement) { 
                            if (valueOfElement.location_id == location_id) {
                                $('#gate_pass_id').append(`
                                    <option value="${valueOfElement.id}">${valueOfElement.gate_pass_no}</option>
                                    `); 
                            }
                        });
                    } else {
                        // getMaintenanceJobDataForGatePass()
                    }
                    // $('#getMaintenanceJobDataForGatePass').html(response);
                }
            });
        }

        function getMaintenanceJobDataForGRN() {
                $('#getMaintenanceJobDataForGRN').html(
                    '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div>'
                );
                let maintenance_job_id = $('#maintenance_job_id').val();
                let location_id = $('#location_id').val();
                $.ajax({
                    url: '{{ url('/workshop/getMaintenanceJobDataForGRN') }}',
                    method: 'GET',
                    data: {id: maintenance_job_id,location_id:location_id},
                    error: function() {
                        alert('error');
                    },
                    success: function(response) {
                        $('#getMaintenanceJobDataForGRN').html(response);
                    }
                });
            }
    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
