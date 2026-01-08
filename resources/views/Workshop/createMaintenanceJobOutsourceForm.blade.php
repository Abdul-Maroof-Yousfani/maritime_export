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
                                <span class="subHeadingLabelClass">Create Maintenance Job (Outsource) Form</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            {{ Form::open(['url' => 'workshop/addMaintenanceJobDetail?m=' . $m . '', 'id' => 'cashPaymentVoucherForm', 'class' => 'stop']) }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="job_type" value="2">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="">Voucher No</label>
                                                <input type="text" readonly class="form-control" name=""
                                                    value="{{ CommonHelper::getMJOVoucherNumber() }}">
                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="">Voucher Date</label>
                                                <input type="date" class="form-control" id="voucher_date"
                                                    name="voucher_date" value="{{ date('Y-m-d') }}">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Select Supplier</label>
                                                <select name="supplier_id" id="supplier_id"
                                                    class="form-control requiredField select2">
                                                    <option value="">Select Supplier</option>
                                                    @foreach (CommonHelper::get_all_supplier() as $supplier)
                                                        <option value="{{ $supplier->id }}">
                                                            {{ $supplier->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="">Select MR Vourcher NO</label>
                                                <select name="maintenance_request_id" id="maintenance_request_id"
                                                    onchange="mrChange()" class="form-control requiredField select2">
                                                    <option value="">Select MR Voucher NO</option>
                                                    @foreach ($maintenanceRequest as $mr)
                                                        <option value="{{ $mr->id }}"
                                                            data-warehouse="{{ $mr->warehouse->name }}"
                                                            data-department="{{ $mr->department->sub_department_name }}"
                                                            data-submitdate="{{ $mr->submit_date }}"
                                                            data-completiondate="{{ $mr->completion_date }}"
                                                            data-machine="{{ $mr->machine->name }}"data-line="{{ $mr->line->name }}">
                                                            {{ $mr->voucher_no }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">MR Department</label>
                                                <input type="text" id="mr_department" class="form-control requiredField "
                                                    readonly value="">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">MR Warehousue</label>
                                                <input type="text" id="mr_warehouse" class="form-control requiredField "
                                                    readonly value="">
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
                                                <input type="date" id="mr_sumit_date" class="form-control requiredField "
                                                    readonly value="">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Requested Completion Date</label>
                                                <input type="date" id="mr_completion_date"
                                                    class="form-control requiredField " readonly value="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Date Of Completion</label>
                                                <input type="date" name="completion_date"
                                                    class="form-control requiredField " value="">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Instruction Taken By</label>
                                                <input type="text" name="instruct_by"
                                                    class="form-control requiredField " value="">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Job Done By</label>
                                                <input type="text" name="completed_by"
                                                    class="form-control requiredField " value="">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label class="sf-label">Job Completed By</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                <select class="form-control requiredField select2" name="department_id"
                                                    id="department_id">
                                                    <option value="">Select Department</option>
                                                    @foreach ($departments as $key => $y)
                                                        <optgroup label="{{ $y->department_name }}"
                                                            value="{{ $y->id }}">
                                                            @php
                                                                $subdepartments = DB::select('select `id`,`sub_department_name` from `sub_department` where `department_id` =' . $y->id . '');
                                                            @endphp
                                                            @foreach ($subdepartments as $key2 => $y2)
                                                                <option value="{{ $y2->id }}">
                                                                    {{ $y2->sub_department_name }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label for="">Labour Description</label>
                                                <input type="text" name="labour_description" id="labour_description"
                                                    class="form-control requiredField " value="">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label for="">Labour Amount</label>
                                                <input type="text" name="labour_amount" id="labour_amount"
                                                    class="form-control requiredField " onkeyup="calcu(1)" value="">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <label for="">Remarks</label>
                                                <textarea class="form-control" name="description" id="description" cols="5" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="lineHeight">&nbsp;</div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div style="text-align: center" class="table-responsive  text-center"
                                                    id="">
                                                    <table style="" class="table table-bordered well">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center" style="width: 45%;">Products</th>
                                                                <th class="text-center" style="width: 10%;">UOM</th>
                                                                <th class="text-center" style="width: 10%;">QTY</th>
                                                                <th class="text-center" style="width: 10%;">Rate</th>
                                                                <th class="text-center" style="width: 10%;">Total</th>
                                                                <th style="width: 5%;"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="AppnedHtml">
                                                            <tr>
                                                                <td>
                                                                    <select name="item_id[]" id="item_id1"
                                                                        onchange="itemChange(1);"
                                                                        class="form-control requiredField select2">
                                                                        <option value="">Select Item</option>
                                                                        @foreach (CommonHelper::get_all_subitem() as $subitem)
                                                                            <option value="{{ $subitem->id }}"
                                                                                data-uom="{{ $subitem->uomData->uom_name }}">
                                                                                {{ $subitem->sku_code . ' - ' . $subitem->sub_ic }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" readonly
                                                                        name="uom[]" id="uom1">
                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        class="form-control requiredField" min="0"
                                                                        onkeyup="calcu(1)" step="any" name="qty[]"
                                                                        id="qty1">
                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        class="form-control requiredField" min="0"
                                                                        step="any" onkeyup="calcu(1)" name="rate[]"
                                                                        id="rate1">
                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        class="form-control requiredField total" readonly
                                                                        min="0" step="any" name="total[]"
                                                                        id="total1">
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td class="text-right" colspan="4">Total</td>
                                                                <th><input type="number" class="form-control"
                                                                        step="any" name="total_amount" readonly
                                                                        id="total_amount" /></th>
                                                                <th>
                                                                    <input type="button" class="btn btn-sm btn-primary"
                                                                        onclick="AddMoreDetails()"
                                                                        value="Add More Rows" />
                                                                </th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
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
        // $(function() {
        //     getAjaxItemList('.item_id');
        // });


        function mrChange() {

            $('#mr_department').val($('#maintenance_request_id').find(':selected').data('department'))
            $('#mr_warehouse').val($('#maintenance_request_id').find(':selected').data('warehouse'))
            $('#mr_machine').val($('#maintenance_request_id').find(':selected').data('machine'))
            $('#mr_line').val($('#maintenance_request_id').find(':selected').data('line'))
            $('#mr_sumit_date').val($('#maintenance_request_id').find(':selected').data('submitdate'))
            $('#mr_completion_date').val($('#maintenance_request_id').find(':selected').data('completiondate'))
        }

        let counter = 1;

        function AddMoreDetails() {
            ++counter;
            $("#AppnedHtml").append('' +
                '<tr id="AppnedHtml' + counter + '">' +
                '<td>' +
                '<select name="item_id[]" id="item_id' + counter + '" onchange="itemChange(' + counter + ');"' +
                'class="form-control requiredField select2">' +
                '<option value="">Select Item</option>' +
                '@foreach (CommonHelper::get_all_subitem() as $subitem)' +
                '<option value="{{ $subitem->id }}"  data-uom="{{ $subitem->uomData->uom_name }}">' +
                '{{ $subitem->item_code . ' - ' . $subitem->sub_ic }}' +
                '</option>' +
                '@endforeach' +
                '</select>' +
                '</td>' +
                '<td>' +
                '<input type="text" class="form-control" readonly name="uom[]" id="uom' + counter + '">' +
                '</td>' +
                '<td>' +
                '<input type="number" class="form-control" min="0" value="0" step="any" onkeyup="calcu(' + counter +
                ')" name="qty[]" id="qty' +
                counter + '">' +
                '</td>' +
                '<td>' +
                '<input type="text" class="form-control" name="rate[]" onkeyup="calcu(' + counter + ')" id="rate' +
                counter + '">' +
                '</td>' +
                '<td>' +
                '<input type="text" class="form-control total" readonly name="total[]" id="total' + counter + '">' +
                '</td>' +
                '<td>' +
                '<button class="btn btn-danger btn-xs"  onClick="rowRemove(' + counter + ')">remove</button>' +
                '</td>' +
                '</tr>' +
                '');
            $('.select2').select2();
            // getAjaxItemList('.item_id');
        }

        function itemChange(id) {
            $('#uom' + id).val($('#item_id' + id).find(':selected').data('uom'));
        }

        function rowRemove(id) {
            $('#AppnedHtml' + id).remove()
        }

        function calcu(id) {
            let qty = $('#qty' + id).val() || 0;
            let rate = $('#rate' + id).val() || 0;

            let amount = qty * rate;
            $('#total' + id).val(amount.toFixed(2));
            let total = $('.total');
            let sum = 0;
            for (let i = 0; i < total.length; i++) {
                sum += parseFloat(total[i].value);
            }
            sum += parseFloat($('#labour_amount').val());
            $('#total_amount').val(sum.toFixed(2));

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
