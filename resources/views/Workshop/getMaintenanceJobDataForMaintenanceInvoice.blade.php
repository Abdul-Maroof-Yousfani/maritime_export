@php
    use App\Helpers\CommonHelper;
@endphp

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        @if ($maintenanceJob->job_type == 1)
           <input type="hidden" name="job_type" value="1">
        @else
            <input type="hidden" name="job_type" value="4">
        @endif
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">Voucher No</label>
                            <input type="text" readonly class="form-control" name=""
                                value="{{ CommonHelper::getMIVoucherNumber() }}">
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">Voucher Date</label>
                            <input type="date" class="form-control" id="voucher_date" name="voucher_date"
                                value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">MR Voucher NO</label>
                            <input type="text" class="form-control" readonly id="mr_voucher_no" name="mr_voucher_no"
                                value="{{ $maintenanceJob->maintenanceRequest->voucher_no }}">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">MR Department</label>
                            <input type="text" id="mr_department" class="form-control requiredField " readonly
                                value="{{ $maintenanceJob->maintenanceRequest->department->sub_department_name }}">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">MR Warehousue</label>
                            <input type="text" id="mr_warehouse" class="form-control requiredField " readonly
                                value="{{ $maintenanceJob->maintenanceRequest->warehouse->name }}">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">MR Machine</label>
                            <input type="text" id="mr_machine" class="form-control requiredField " readonly
                                value="{{ $maintenanceJob->maintenanceRequest->machine->name }}">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">MR Line</label>
                            <input type="text" id="mr_line" class="form-control requiredField " readonly
                                value="{{ $maintenanceJob->maintenanceRequest->line->name }}">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">Requested Submit Date</label>
                            <input type="date" id="mr_sumit_date" class="form-control requiredField " readonly
                                value="{{ $maintenanceJob->maintenanceRequest->submit_date }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">MJ Voucher NO</label>
                            <input type="text" class="form-control" readonly id="mj_voucher_no" name="mj_voucher_no"
                                value="{{ $maintenanceJob->voucher_no }}">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">MJ Repairing Warehouse</label>
                            <input type="text" class="form-control" readonly id="mj_warehouse" name="mj_warehouse"
                                value="{{ $maintenanceJob->companyLocation->location_name }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">Date Of Completion</label>
                            <input type="date" name="completion_date" id="completion_date" class="form-control requiredField "
                                value="">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">Instruction Taken By</label>
                            <input type="text" name="instruct_by" id="instruct_by" class="form-control requiredField " value="">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">Job Done By</label>
                            <input type="text" name="completed_by" id="completed_by" class="form-control requiredField" value="">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label class="sf-label">Department / Sub Department</label>
                            <span class="rflabelsteric"><strong>*</strong></span>
                            <select class="form-control requiredField select2" name="department_id"
                                id="department_id">
                                <option value="">Select Department</option>
                                @foreach ($departments as $key => $y)
                                    <optgroup label="{{ $y->department_name }}" value="{{ $y->id }}">
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
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Demange Details</label>
                            <textarea class="form-control" name="description" readonly id="description" cols="5" rows="5">{{ $maintenanceJob->maintenanceRequest->description }}</textarea>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">MJ Remarks</label>
                            <textarea class="form-control" name="mj_description" readonly id="mj_description" cols="5" rows="5">{{ $maintenanceJob->description }}</textarea>
                        </div>
                    </div>
                    <div class="lineHeight">&nbsp;</div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div style="text-align: center" class="table-responsive  text-center" id="">
                                <table style="" class="table table-bordered well">
                                    <thead>
                                        <tr>
                                            <th colspan="5">
                                                <h5>Items Details</h5>
                                            </th>
                                            <th>
                                                <input type="button" class="btn btn-sm btn-primary"
                                                    onclick="AddMoreDetails()" value="Add More Rows" />
                                            </th>
                                        </tr>
                                        <tr>
                                            <th style="width: 45%;">Products</th>
                                            <th style="width: 10%;">UOM</th>
                                            <th style="width: 10%;">Issue QTY</th>
                                            <th style="width: 10%;">Return QTY</th>
                                            <th style="width: 10%;">Rate</th>
                                            <th style="width: 10%;">Total</th>
                                            <th style="width: 5%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="AppnedHtml">
                                        <tr>
                                            <td>
                                                <select name="item_id[]" id="item_id1" onchange="itemChange(1);"
                                                    class="form-control requiredField select2">
                                                    <option value="">Select Item</option>
                                                    @foreach ($subitems as $subitem)
                                                        <option value="{{ $subitem->id }}"
                                                            data-uom="{{ $subitem->uom_name }}">
                                                            {{ $subitem->sku_code . ' - ' . $subitem->sub_ic }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" readonly name="uom[]"
                                                    id="uom1">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control requiredField"
                                                    min="0" onkeyup="calcu(1)" step="any"
                                                    placeholder="QTY" name="qty[]" id="qty1">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control requiredField"
                                                    min="0" onkeyup="" step="any"
                                                    placeholder="Return QTY" name="return_qty[]" id="return_qty1">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control requiredField"
                                                    min="0" step="any" onkeyup="calcu(1)"
                                                    placeholder="Rate" name="rate[]" id="rate1">
                                            </td>
                                            <td>
                                                <input type="number" readonly
                                                    class="form-control requiredField total" min="0"
                                                    step="any" name="total[]" id="total1"
                                                    placeholder="Sub Total">
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Labour Description</th>
                                            <th>Hours</th>
                                            <th><input type="number" class="form-control" onkeyup="calcu(1)"
                                                    step="any" name="labour_hour" placeholder="Hours"
                                                    id="labour_hours" /></th>
                                            <th><input type="number" class="form-control" step="any"
                                                    onkeyup="calcu(1)" name="labour_wage" placeholder="wage"
                                                    id="labour_wage" /></th>
                                            <th></th>
                                            <th><input type="number" class="form-control" readonly step="any"
                                                    placeholder="Total" id="labour_total" /></th>
                                        </tr>
                                        <tr>
                                            <td class="text-right" colspan="5">Total</td>
                                            <th><input type="number" class="form-control" step="any" readonly
                                                    name="total_amount" placeholder="Total" id="total_amount" /></th>
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
    </div>
</div>

<script>
    $('.select2').select2();
    let counter = 1;
    function AddMoreDetails() {
        ++counter;
        $("#AppnedHtml").append('' +
            '<tr id="AppnedHtml' + counter + '">' +
            '<td>' +
            '<select name="item_id[]" id="item_id' + counter + '" onchange="itemChange(' + counter + ');"' +
            'class="form-control requiredField select2">' +
            '<option value="">Select Item</option>' +
            '@foreach ($subitems as $subitem)' +
            '<option value="{{ $subitem->id }}"  data-uom="{{ $subitem->uom_name }}">' +
            '{{ $subitem->item_code . ' - ' . $subitem->sub_ic }}' +
            '</option>' +
            '@endforeach' +
            '</select>' +
            '</td>' +
            '<td>' +
            '<input type="text" class="form-control" readonly name="uom[]" id="uom' + counter + '">' +
            '</td>' +
            '<td>' +
            '<input type="number" class="form-control requiredField" min="0" value="0" step="any" onkeyup="calcu(' +
            counter +
            ')" name="qty[]" id="qty' +
            counter + '">' +
            '</td>' +
            '<td>' +
            '<input type="number" class="form-control requiredField" min="0" value="0" step="any"'+
            'name="return_qty[]" id="return_qty' +
            counter + '">' +
            '</td>' +
            '<td>' +
            '<input type="text" class="form-control requiredField" name="rate[]"  onkeyup="calcu(' + counter +
            ')" id="rate' +
            counter + '">' +
            '</td>' +
            '<td>' +
            '<input type="text" class="form-control total" name="total[]" id="total' + counter + '">' +
            '</td>' +
            '<td>' +
            '<button class="btn btn-danger btn-xs" onClick="rowRemove(' + counter + ')">remove</button>' +
            '</td>' +
            '</tr>' +
            '');
        $('.select2').select2();
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
        let labour_hours = $('#labour_hours').val();
        let labour_wage = $('#labour_wage').val();
        if (labour_hours > 0 && labour_wage > 0) {
            let labourAddition = labour_hours * labour_wage;
            $('#labour_total').val(labourAddition);
            sum += parseFloat(labourAddition);
        }

        $('#total_amount').val(sum)
    }
</script>
