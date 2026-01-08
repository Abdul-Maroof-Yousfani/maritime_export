<?php
$m = Session::get('run_company');
use App\Helpers\StoreHelper;
use App\Helpers\ReuseableCode;
use App\Helpers\CommonHelper;
?>
@extends('layouts.default')

@section('content')
    @include('select2')
    @include('modal')
    @include('number_formate')


    <style>
        * {
            font-size: 12px !important;
            font-family: Arial;
        }

        .select2 {
            width: 100%;
        }
    </style>

    <?php
    // $wo = StoreHelper::unique_for_isr(date('y'), date('m'));
    ?>
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
                                <span class="subHeadingLabelClass">Create Issuance Return Form</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            {{ Form::open(['url' => 'stad/addIssuanceReturnDetail?m=' . $m . '', 'id' => 'cashPaymentVoucherForm', 'class' => 'stop']) }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Voucher No</label>
                                                <input type="text" readonly class="form-control"
                                                    value="{{$wo}}" name="voucher_no">
                                            </div> --}}

                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Voucher Date</label>
                                                <input type="date" class="form-control" id="voucher_date"
                                                    name="voucher_date" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Issuance Voucher No</label>
                                                <input type="text" readonly class="form-control"
                                                    value="{{ $issuence->iss_no }}" name="issuance_id">
                                                <input type="hidden" readonly class="form-control"
                                                    value="{{ $issuence->id }}" name="issuance_no">
                                            </div>

                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Issuance Voucher Date</label>
                                                <input type="date" class="form-control" id="issuance_date"
                                                    name="issuance_date" readonly value="{{ $issuence->iss_date }}">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label class="sf-label">Department / Sub Department</label>
                                                <input type="text" class="form-control" readonly id="department_name"
                                                    name="department_name"
                                                    value="{{ $issuence->department->sub_department_name ?? '' }}">
                                                <input type="hidden" class="form-control" id="department_id"
                                                    name="department_id" value="{{ $issuence->department_id }}">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Machinery</label>
                                                <input type="text" class="form-control" id="machinery_name"
                                                    name="machinery_name" readonly value="{{ $issuence->machine->name }}">
                                                <input type="hidden" class="form-control" id="machinery_id"
                                                    name="machinery_id" value="{{ $issuence->machine_id }}">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Line</label>
                                                <input type="text" class="form-control" id="line_name" name="line_name"
                                                    readonly value="{{ $issuence->line->name ?? '' }}">
                                                <input type="hidden" class="form-control" id="line_id" name="line_id"
                                                    value="{{ $issuence->line_id }}">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Receipt serial no</label>
                                                <input type="text" readonly name="receipt_serial_no" class="form-control"
                                                    value="{{ $issuence->receipt_serial_no }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label class="sf-label">Company Location</label>
                                                <select class="form-control requiredField select2" name="company_location_id"
                                                    id="company_location_id">
                                                    <option value="">Select Location</option>
                                                    @foreach (ReuseableCode::getUserWiseLocationRightsData() as $company_location)
                                                        <option value="{{$company_location['id']}}" {{($issuence->company_location_id == $company_location['id'])? 'selected' : ''}}>{{$company_location['location_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <label for="">Issuance Remarks</label>
                                                <textarea class="form-control" name="issuance_remarks" id="issuance_remarks" cols="5" rows="5">{{ $issuence->description }}</textarea>
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
                                                                <th class="text-center" style="width: 400px;">Products
                                                                </th>
                                                                <th class="text-center" style="width: 250px;">UOM</th>
                                                                <th class="text-center" style="width: 250px;">Warehouse
                                                                </th>
                                                                {{-- <th class="text-center" style="width: 250px;">Batch Code
                                                                </th> --}}
                                                                <th class="text-center" style="width: 250px;">Issuance QTY
                                                                </th>
                                                                <th class="text-center" style="width: 250px;">Previous Return
                                                                </th>
                                                                <th class="text-center" style="width: 250px;">Return QTY</th>
                                                                <th class="text-center" style="width: 400px;">ItemWise
                                                                    Remarks</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="AppnedHtml">
                                                            @foreach ($issuence->issuence_datas as $key => $issance_data)
                                                                <tr>
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            id="item_name{{$key}}" readonly name="item_name[]"
                                                                            value="{{$issance_data->subItem->sub_ic}}">
                                                                        <input type="hidden" class="form-control"
                                                                            id="item_id{{$key}}" name="item_id[]"
                                                                            value="{{$issance_data->subItem->id}}">
                                                                        <input type="hidden" class="form-control"
                                                                            id="issuance_data_id{{$key}}" name="issuance_data_id[]"
                                                                            value="{{$issance_data->id}}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            readonly name="uom[]" id="uom1" value="{{$issance_data->subItem->uomData->uom_name}}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            id="warehouse_name{{$key}}" name="warehouse_name[]"
                                                                            value="{{$issance_data->warehouse->name}}">
                                                                        <input type="hidden" class="form-control"
                                                                            id="warehouse_id{{$key}}" name="warehouse_id[]"
                                                                            value="{{$issance_data->warehouse->id}}">
                                                                    </td>
                                                                    {{-- <td>
                                                                        <input type="text" id="batch_code"
                                                                            name="batch_code[]" value="">
                                                                    </td> --}}
                                                                    <td>
                                                                        <input type="text"
                                                                            class="form-control requiredField iss_qty" readonly
                                                                            name="issuance_qty[]" id="issuance_qty{{$key}}" value="{{$issance_data->qty}}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text"
                                                                            class="form-control requiredField pre_qty" readonly
                                                                            name="previous_return[]" id="previous_return{{$key}}" value="{{StoreHelper::getPreviousReturnQty($issance_data->id, $issance_data->subItem->id)}}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="number"
                                                                            class="form-control requiredField re_qty" step="0.01" name="return_qty[]"
                                                                            id="return_qty{{$key}}" value="0">
                                                                    </td>
                                                                    <td>
                                                                        <textarea class="form-control" name="item_remarks[]" id="item_remarks1" cols="5" rows="5">{{$issance_data->sub_ic_desc}}</textarea>
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
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
        $(document).ready(function() {
            $(".btn-success").click(function(e) {

                var purchaseRequest = new Array();
                var val;

                purchaseRequest.push($(this).val());
                var _token = $("input[name='_token']").val();
                for (val of purchaseRequest) {
                    jqueryValidationCustom();
                    if (validate == 0) {
                        
                        var iss_qty = $('.iss_qty');
                        var re_qty = $('.re_qty');
                        var pre_qty = $('.pre_qty');
                        for (let i = 0; i < iss_qty.length; i++) {
                            if (re_qty[i].value > (iss_qty[i].value - pre_qty[i].value)) {
                                alert("Return qty must not be greater than issuance qty!");
                                return false;
                            }
                        }
                        

                    } else {
                        return false;
                    }
                }

            });
        });
    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
