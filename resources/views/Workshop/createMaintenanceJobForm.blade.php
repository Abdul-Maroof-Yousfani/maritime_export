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

    <style>
        .input-container {
            display: -ms-flexbox;
            /* IE10 */
            display: flex;
            width: 100%;
            margin-bottom: 15px;
        }

        .icon {
            padding: 15px;
            background: #8d9399;
            color: white;
            min-width: 20px;
            text-align: center;
            height: 43px;
        }

        .input-field {
            /* width: 100%;
                                      padding: 10px; */
            outline: none;
        }

        .input-field:focus {
            border: 2px solid rgb(125, 129, 134);
        }
    </style>


    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well_N">
                    <div class="dp_sdw">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span class="subHeadingLabelClass">Create Maintenance Job Form</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            {{ Form::open(['url' => 'workshop/addMaintenanceJobDetail?m=' . $m . '', 'id' => 'cashPaymentVoucherForm', 'enctype' => 'multipart/form-data', 'class' => 'stop']) }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="">Select MR Vourcher NO</label>
                                                <select name="maintenance_request_id" id="maintenance_request_id"
                                                    onchange="mrChange()" required class="form-control requiredField select2">
                                                    <option value="">Select MR Voucher NO</option>
                                                    @foreach ($maintenanceRequest as $mr)
                                                        <option value="{{ $mr->id }}"
                                                            data-warehouse="{{ $mr->warehouse->name }}"
                                                            data-department="{{ $mr->department->sub_department_name }}"
                                                            data-submitdate="{{ $mr->submit_date }}"
                                                            data-inhouseexist="{{ $mr->maintenanceJobInhouseExist ? 1 : 0 }}"
                                                            data-outsourceexist="{{ $mr->maintenanceJobOutsourceExist ? 1 : 0 }}"
                                                            data-anotherwarehouse="{{ $mr->anotherwarehouse ? 1 : 0 }}"
                                                            data-machine="{{ $mr->machine->name }}"data-line="{{ $mr->line->name }}">
                                                            {{ $mr->voucher_no }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Select Job Type</label>
                                                <select name="job_type" required id="job_type"
                                                    class="form-control requiredField select2"
                                                    onchange="jobTypeSelection();">
                                                    <option value="">Select Job Type</option>
                                                    <option value="1">In-House</option>
                                                    <option value="2">Outsource</option>
                                                    <option value="3">In-House (another warehouse)</option>
                                                    <option value="4">In-House Corrective Maintenace</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="">Voucher Date</label>
                                                <input type="date" required class="form-control" id="voucher_date"
                                                    name="voucher_date" value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="row hide" id="inhousePortion">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Repairing Location</label>
                                                <select name="warehouse_id" id="warehouse_id" class="form-control select2">
                                                    <option value="">Select Warehouse</option>
                                                    @foreach (ReuseableCode::getUserWiseLocationRightsData() as $warehouse)
                                                        <option value="{{ $warehouse->id }}">
                                                            {{ $warehouse->location_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 hide" id="anotherPortion">
                                                <label for="">Repairing Location To</label>
                                                <select name="warehouse_id_to" id="warehouse_id_to"
                                                    class="form-control select2">
                                                    <option value="">Select Location</option>
                                                    @foreach (ReuseableCode::getUserWiseLocationRightsData() as $warehouse)
                                                        <option value="{{ $warehouse->id }}">
                                                            {{ $warehouse->location_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row hide" id="outsourcePortion">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Select Supplier</label>
                                                <select name="supplier_id" id="supplier_id" class="form-control select2"
                                                    onchange="setSupplierData();">
                                                    <option value="">Select Supplier</option>
                                                    @foreach (CommonHelper::get_all_supplier() as $supplier)
                                                        <option value="{{ $supplier->id }}"
                                                            data-contact="{{ $supplier->mobile_no . '--' . $supplier->work_phone }}"
                                                            data-address="{{ $supplier->address }}">
                                                            {{ $supplier->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Supplier Contact</label>
                                                <input type="text" class="form-control" name="sup_contact"
                                                    id="sup_contact" readonly placeholder="Supplier Contact">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label for="">Supplier Address</label>
                                                <input type="text" class="form-control" name="sup_address"
                                                    id="sup_address" readonly placeholder="Supplier Address">
                                            </div>
                                        </div>
                                        <div class="row" id="form">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">MR Department</label>
                                                <input type="text" id="mr_department" class="form-control requiredField "
                                                    readonly value="">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">MR Warehousue</label>
                                                <input type="text" id="mr_warehouse"
                                                    class="form-control requiredField " readonly value="">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">MR Machine</label>
                                                <input type="text" id="mr_machine" class="form-control requiredField "
                                                    readonly value="">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">MR Line</label>
                                                <input type="text" id="mr_line" class="form-control requiredField "
                                                    readonly value="">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Requested Submit Date</label>
                                                <input type="date" id="mr_sumit_date"
                                                    class="form-control requiredField " readonly value="">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                <label for="">Attachemnt file</label>
                                                <div class="input-container">
                                                    <input class="input-field form-control requiredField" required
                                                        id="attachment1" type="file" name="file[]"><i
                                                        class="fa fa-plus icon" onclick="add()"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <label for="">Remarks</label>
                                                <textarea class="form-control" name="description" id="description" cols="5" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="lineHeight">&nbsp;</div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div style="text-align: center" class="table-responsive  text-center"
                                                    id="mrDataAppend">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="demandsSection"></div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}

                                </div>
                            </div>
                            <?php echo Form::close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $('.select2').select2();

        var attachCounter = 1;

        function add() {
            attachCounter++;
            var html = ` <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" id="row${attachCounter}">
            <label>&nbsp</label>
        <div class="input-container">
        <input class="input-field form-control requiredField" required id="attachment${attachCounter}" type="file" placeholder="Form No " name="file[]">
        <i class="fa fa-minus icon" onclick="minus(${attachCounter})"></i>
            </div>
        </div>`;
            $('#form').append(html);
        }

        function minus(number) {
            $('#row' + number).remove();
            attachCounter--;
        }

        function jobTypeSelection() {
            let mrField = $('#maintenance_request_id').find(':selected');
            if (mrField.val() == "") {
                alert("Please Select Request NO#");
                return
            }
            let JTField = $('#job_type').find(':selected').val();
            if (JTField == 1 || JTField == 4) {
                if (mrField.data('inhouseexist') == 1) {
                    alert('On this request a job already exist!');
                    $('.btn-success').attr('disabled', true);
                    return;
                } else {
                    $('.btn-success').attr('disabled', false);
                }
                $('#outsourcePortion').addClass('hide');
                $('#anotherPortion').addClass('hide');
                $('#inhousePortion').removeClass('hide');

                $('#supplier_id').attr('required', false);
                $('#warehouse_id').attr('required', true);
                $('#warehouse_id_to').attr('required',false);
            } else if (JTField == 2) {
                if (mrField.data('outsourceexist') == 1) {
                    alert('On this request a job already exist!');
                    $('.btn-success').attr('disabled', true);
                    return;
                } else {
                    $('.btn-success').attr('disabled', false);
                }
                $('#anotherPortion').addClass('hide');
                $('#inhousePortion').removeClass('hide');
                $('#outsourcePortion').removeClass('hide');

                $('#supplier_id').attr('required', true);
                $('#warehouse_id').attr('required', true);
                $('#warehouse_id_to').attr('required',false);
            
            } else if (JTField == 3) {
                if (mrField.data('anotherwarehouse') == 1) {
                    alert('On this request a job already exist!');
                    $('.btn-success').attr('disabled', true);
                    return;
                } else {
                    $('.btn-success').attr('disabled', false);
                }
                $('#outsourcePortion').addClass('hide');
                $('#inhousePortion').removeClass('hide');
                $('#anotherPortion').removeClass('hide');
                
                $('#supplier_id').attr('required', false);
                $('#warehouse_id').attr('required', true);
                $('#warehouse_id_to').attr('required',true);
            }
        }

        function setSupplierData() {
            let supField = $('#supplier_id').find(':selected');
            $('#sup_address').val(supField.data('address'));
            $('#sup_contact').val(supField.data('contact'));
        }

        function mrChange() {
            let mrField = $('#maintenance_request_id').find(':selected');
            $('#mr_department').val(mrField.data('department'))
            $('#mr_warehouse').val(mrField.data('warehouse'))
            $('#mr_machine').val(mrField.data('machine'))
            $('#mr_line').val(mrField.data('line'))
            $('#mr_sumit_date').val(mrField.data('submitdate'))

            $.ajax({
                type: "get",
                url: "{{ url('/') }}/workshop/getMRItemsData",
                data: {
                    id: mrField.val()
                },
                success: function(response) {
                    console.log(response);
                    $('#mrDataAppend').html(response);
                }
            });
            jobTypeSelection();
        }
        $(document).ready(function() {
            $(".btn-success").click(function(e) {

                //alert();
                var purchaseRequest = new Array();
                var val;
                //$("input[name='demandsSection[]']").each(function(){
                purchaseRequest.push($(this).val());



                //});
                var _token = $("input[name='_token']").val();
                for (val of purchaseRequest) {
                    jqueryValidationCustom();
                    if (validate == 0) {
                        //alert(response);
                    } else {
                        return false;
                    }
                }

            });
        });
    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
