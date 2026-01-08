<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
?>
@extends('layouts.default')

@section('content')
    @include('select2');
    <div class="well_N">
        <div class="dp_sdw">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="well">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <span class="subHeadingLabelClass">Add Item Movement</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form action="{{url('/stad/addItemMovementForm')}}" method="POST">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Select Item:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select autofocus name="item_id[]"
                                                                    class="form-control requiredField select2">
                                                                    <option value="">Select Item</option>
                                                                    @foreach (CommonHelper::get_all_subitem() as $subitem)
                                                                        <option value="{{ $subitem->id }}">
                                                                            {{ $subitem->sku_code . '-' . $subitem->sub_ic }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Select Stock Type:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="type[]" id="type[]"
                                                                    class="form-control requiredField select2">
                                                                    <option value="">Select Type</option>
                                                                    @foreach (CommonHelper::stockDemandType() as $Type)
                                                                        <option value="{{ $Type['id'] }}">
                                                                            {{ $Type['name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Select Warehouse:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="warehouse_id[]" id="warehouse_id[]"
                                                                    class="form-control requiredField select2">
                                                                    <option value="">Select Warehouse</option>
                                                                    @foreach (CommonHelper::get_all_warehouse() as $Warehouse)
                                                                        <option value="{{ $Warehouse->id }}">
                                                                            {{ $Warehouse->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div id="moreRows">

                                                        </div>
                                                        <div class="lineHeight">&nbsp;</div>

                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                                            {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                                            <button type="button" id="reset" class="btn btn-primary"
                                                                onclick="addMoreRows()">Add More</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".btn-success").click(function(e) {
                var subItem = new Array();
                var val;
                //$("input[name='chartofaccountSection[]']").each(function(){
                subItem.push($(this).val());
                //});
                var _token = $("input[name='_token']").val();
                for (val of subItem) {

                    jqueryValidationCustom();
                    if (validate == 0) {
                        $('.btn-success').prop('disabled', true);
                        $("form").submit();
                        //return false;
                    } else {
                        return false;
                    }
                }
            });
        });
        let counters = 1;

        function addMoreRows() {
            $('#moreRows').append(`
                <div class="row" id="rowId${counters}">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label>Select Item:</label>
                        <span class="rflabelsteric"><strong>*</strong></span>
                        <select autofocus name="item_id[]"
                            class="form-control requiredField select2">
                            <option value="">Select Item</option>
                            @foreach (CommonHelper::get_all_subitem() as $subitem)
                                <option value="{{ $subitem->id }}">
                                    {{ $subitem->sku_code . '-' . $subitem->sub_ic }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label>Select Stock Type:</label>
                        <span class="rflabelsteric"><strong>*</strong></span>
                        <select name="type[]" id="type[]"
                            class="form-control requiredField select2">
                            <option value="">Select Type</option>
                            @foreach (CommonHelper::stockDemandType() as $Type)
                                <option value="{{ $Type['id'] }}">
                                    {{ $Type['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label>Select Warehouse:</label>
                        <span class="rflabelsteric"><strong>*</strong></span>
                        <select name="warehouse_id[]" id="warehouse_id[]"
                            class="form-control requiredField select2">
                            <option value="">Select Warehouse</option>
                            @foreach (CommonHelper::get_all_warehouse() as $Warehouse)
                                <option value="{{ $Warehouse->id }}">
                                    {{ $Warehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="margin-top:35px">
                        <button type="button" onclick="removeRow('rowId${counters}')" class="btn btn-danger btn-xs">Remove</button>
                    </div>
                </div>
            `);
            $('.select2').select2();
            counters++;
        }
        function removeRow(id) {
            $('#'+id).remove();
        }
    </script>
    <script type="text/javascript">
        $('.select2').select2();
    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
