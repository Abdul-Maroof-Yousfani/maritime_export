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
                                <span class="subHeadingLabelClass">{{ $title }}</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                {{ Form::open(['route' => 'gatepass.insertGatePassForm', 'id' => 'cashPaymentVoucherForm', 'class' => 'stop']) }}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label class="sf-label">Select Location</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <select class="form-control requiredField select2" name="location_id"
                                            id="location_id" onchange="getMJO()">
                                            <option value="">Select Warehouse</option>
                                            @foreach ($company_locations as $company_location)
                                                <option value="{{ $company_location['id'] }}">
                                                    {{ $company_location['location_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label class="sf-label">Select Maintenance Job</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <select class="form-control requiredField select2" name="maintenance_job_id"
                                            id="maintenance_job_id" onchange="getGetPassIn()">
                                            <option value="">Select Maintenance Job Outsource</option>
                                            {{-- @foreach ($maintenanceJobs as $maintenanceJob)
                                                <option value="{{ $maintenanceJob->id }}">{{ $maintenanceJob->voucher_no }}
                                                </option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label class="sf-label">Gate Pass ({{ ($gate_pass_type == 1)? 'OUT':'IN' }})</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <select class="form-control select2" name="gate_pass_id" id="gate_pass_id"
                                            onchange="getMaintenanceJobDataForGatePass()">
                                            <option value="">Select Gate Pass ({{ ($gate_pass_type == 1)? 'OUT':'IN' }})</option>

                                        </select>
                                    </div>
                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <button type="button" onclick="getMaintenanceJobDataForGatePass()">GET</button>
                                    </div> --}}
                                    <div id="getMaintenanceJobDataForGatePass"></div>
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
            let type = {{$gate_pass_type}};
            $.ajax({
                url: '{{ route('gatepass.getMJOGatePassOut') }}',
                method: 'GET',
                data: {
                    warehouse_id: location_id,
                    type: type
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
            var gate_pass_type = {{ $gate_pass_type }}
            var maintenance_job_id = $('#maintenance_job_id').val();
            let location_id = $('#location_id').val();
            $.ajax({
                url: '{{ route('gatepass.getGetPassIn') }}',
                method: 'GET',
                data: {
                    id: maintenance_job_id,
                    gate_pass_type: gate_pass_type,
                    location_id: location_id
                },
                error: function() {
                    alert('error');
                },
                success: function(response) {
                    console.log(response);
                    if (response.gatepass.length > 0) {
                        if (response.mjo.job_type == 3 && response.count ==  3) {
                            if (response.mjo.warehouse_id == location_id) { 
                                $.each(response.gatepass, function (indexInArray, valueOfElement) { 
                                // if (valueOfElement.location_id == location_id) {
                                    $('#gate_pass_id').append(`
                                        <option value="${valueOfElement.id}">${valueOfElement.gate_pass_no}</option>
                                        `); 
                                // }
                            });
                            }
                        }
                        else{
                            $('#gate_pass_id').addClass('requiredField');
                            $.each(response.gatepass, function (indexInArray, valueOfElement) { 
                                // if (valueOfElement.location_id == location_id) {
                                    $('#gate_pass_id').append(`
                                        <option value="${valueOfElement.id}">${valueOfElement.gate_pass_no}</option>
                                        `); 
                                // }
                            });
                        }
                    } else {
                        $('#gate_pass_id').removeClass('requiredField');
                        checkJobType(maintenance_job_id , location_id);
                        // getMaintenanceJobDataForGatePass();
                    }
                    // $('#getMaintenanceJobDataForGatePass').html(response);
                }
            });
        }
        function checkJobType(maintenance_job_id , location_id){
            $.ajax({
                url: '{{ route('gatepass.checkJobType') }}',
                method: 'GET',
                data: {
                    id: maintenance_job_id,
                    // gate_pass_type: gate_pass_type,
                    location_id: location_id
                },
                error: function() {
                    alert('error');
                },
                success: function(response) {
                    // console.log(response);
                    if (response.mjo.job_type == 3 && response.count >= 1) {
                        
                    }
                    else{
                        if (response.mjo.warehouse_id == location_id) {
                            getMaintenanceJobDataForGatePass();
                        }
                    }
                    
                }
            });
        }
        function getMaintenanceJobDataForGatePass() {
            var gate_pass_type = {{ $gate_pass_type }}
            let location_id = $('#location_id').val();
            $('#getMaintenanceJobDataForGatePass').html(
                '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div>'
            );
            let maintenance_job_id = $('#maintenance_job_id').val();
            $.ajax({
                url: '{{ route('gatepass.getMaintenanceJobDataForGatePass') }}',
                method: 'GET',
                data: {
                    id: maintenance_job_id,
                    gate_pass_type: gate_pass_type,
                    location_id: location_id
                },
                error: function() {
                    alert('error');
                },
                success: function(response) {
                    $('#getMaintenanceJobDataForGatePass').html(response);
                }
            });
        }
    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
