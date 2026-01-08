<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
?>
@extends('layouts.default')

@section('content')
    @include('select2')
    @include('modal')
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


    @include('number_formate')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="display: none;">
                {{-- @include('Purchase.'.$accType.'purchaseMenu') --}}
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well_N">
                    <div class="dp_sdw">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span class="subHeadingLabelClass">Edit Maintenance Request Form</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            {{ Form::open(['url' => 'workshop/maintenanceRequestUpdate?m=' . $m . '', 'id' => 'cashPaymentVoucherForm', 'enctype' => 'multipart/form-data', 'class' => 'stop']) }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Voucher No</label>
                                                <input type="text" readonly class="form-control"
                                                    value="{{ $maintenanceRequest->voucher_no }}">
                                                <input type="hidden" name="id" value="{{ $maintenanceRequest->id }}">
                                            </div>

                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Voucher Date</label>
                                                <input type="date" class="form-control" id="voucher_date"
                                                    name="voucher_date" value="{{ $maintenanceRequest->voucher_date }}">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label class="sf-label">Department / Sub Department</label>
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
                                                                <option value="{{ $y2->id }}" {{($maintenanceRequest->department_id == $y2->id)? 'selected' : ''}}>
                                                                    {{ $y2->sub_department_name }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Machinery</label>
                                                <select name="machine_id" id="machine_id"
                                                    class="form-control requiredField select2">
                                                    <option value="">Select Machinery</option>
                                                    @foreach ($machineries as $machinery)
                                                        <option value="{{ $machinery->id }}" {{($maintenanceRequest->machine_id == $machinery->id)? 'selected' : ''}}>{{ $machinery->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                        </div>
                                        <div class="row" id="form">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Line</label>
                                                <select name="line_id" id="line_id"
                                                    class="form-control select2 requiredField">
                                                    <option value="">Select Line</option>
                                                    @foreach ($lines as $line)
                                                        <option value="{{ $line->id }}" {{($maintenanceRequest->line_id == $line->id)? 'selected' : ''}}>{{ $line->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Analysing Form Required</label>
                                                <select name="analysing_required" id="analysing_required"
                                                    class="form-control select2 requiredField">
                                                    <option value="">Select</option>
                                                    <option {{$maintenanceRequest->analysing_required == 'yes' ? 'selected' : ''}} value="yes">Yes</option>
                                                    <option {{$maintenanceRequest->analysing_required == 'no' ? 'selected' : ''}} value="no">No</option>
                                                    
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Warehouse</label>
                                                <select name="warehouse_id" id="warehouse_id"
                                                    class="form-control select2 requiredField">
                                                    <option value="">Select Warehouse</option>
                                                    @foreach (CommonHelper::get_users_warehouse() as $warehouse)
                                                        <option value="{{ $warehouse->id }}" {{($maintenanceRequest->warehouse_id == $warehouse->id)? 'selected' : ''}}>{{ $warehouse->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Submit Date</label>
                                                <input type="date" class="form-control requiredField"
                                                    name="submit_date" id="submit_date" value="{{$maintenanceRequest->submit_date}}"/>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <label for="">Damage Detail</label>
                                                <textarea class="form-control requiredField" name="description" id="description" cols="5" rows="5">{{$maintenanceRequest->description}}</textarea>
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
                                        <div class="lineHeight">&nbsp;</div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div style="text-align: center" class="table-responsive  text-center"
                                                    id="">
                                                    <table style="" class="table table-bordered well">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="3">
                                                                    <h5>Items Details</h5>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 45%;">Products</th>
                                                                <th style="width: 10%;">QTY</th>
                                                                <th style="width: 5%;"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="AppnedHtml">
                                                            @foreach ($maintenanceRequest->itemData as $key => $data)
                                                            <tr id="AppnedHtml' + counter + '">
                                                                    <td>
                                                                        <select name="item_id[]" id="item_id{{++$key}}"
                                                                            class="form-control requiredField select2">
                                                                            <option value="">Select Item</option>
                                                                            @foreach (CommonHelper::get_all_subitem() as $subitem)
                                                                                <option value="{{ $subitem->id }}" {{ ($data->item_id == $subitem->id)? 'selected' : '' }}>
                                                                                    {{ $subitem->sku_code . ' - ' . $subitem->sub_ic }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input type="number"
                                                                            class="form-control requiredField" min="0"
                                                                            step="any" name="qty[]" id="qty1" value="{{$data->qty}}">
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3" class="text-right">
                                                                    <input type="button" class="btn btn-sm btn-primary"
                                                                        onclick="AddMoreDetails()"
                                                                        value="Add More Rows" />
                                                                </td>
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

        $(document).ready(function() {
            $('.select2').select2();
            $(".btn-success").click(function(e) {
                //alert();
                var purchaseRequest = new Array();
                var val;
                //$("input[name='demandsSection[]']").each(function(){
                purchaseRequest.push($(this).val());
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
        let counter = {{count($maintenanceRequest->itemData)}};

        function AddMoreDetails() {
            ++counter;
            $("#AppnedHtml").append('' +
                '<tr id="AppnedHtml' + counter + '">' +
                '<td>' +
                '<select name="item_id[]" id="item_id' + counter + '" ' +
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
                '<input type="number" class="form-control" min="0" value="0" step="any" name="qty[]" id="qty' +
                counter + '">' +
                '</td>' +
                '<td>' +
                '<button class="btn btn-danger btn-xs" type="button" onClick="rowRemove(' + counter +
                ')">remove</button>' +
                '</td>' +
                '</tr>' +
                '');
            $('.select2').select2();
            // getAjaxItemList('.item_id');
        }

        function rowRemove(id) {
            $('#AppnedHtml' + id).remove()
        }
    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
