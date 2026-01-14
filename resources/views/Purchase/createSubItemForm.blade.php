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
                                        <span class="subHeadingLabelClass">Add New Sub Item</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <?php echo Form::open(['url' => 'pad/addSubItemDetail?m=' . $m . '', 'id' => 'addSubItemDetail']); ?>
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Item Type</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <select style="width: 100%" name="stockType" id="stockType"
                                                                class="form-control requiredField">
                                                                <option value="">Select Item Type</option>
                                                                @foreach (CommonHelper::item_types_for_items() as $itemTypes)
                                                                    <option value="{{ $itemTypes['id'] }}">
                                                                        {{ $itemTypes['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Category :</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <select name="CategoryId" id="CategoryId"
                                                                class="form-control requiredField select2">
                                                                <option value="">Select Category</option>
                                                                @foreach ($categories as $key => $y)
                                                                    <option value="{{ $y->id }}"
                                                                        {{ old('CategoryId') == $y->id ? 'selected' : '' }}>
                                                                        {{ $y->main_ic }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Sub Item Name :</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <input type="text" name="sub_ic" id="sub_ic"
                                                                value="{{ old('sub_ic') }}" class="form-control" />
                                                            @if ($errors->has('sub_ic'))
                                                                <span class="help-block">
                                                                    <strong
                                                                        class="text-danger">{{ $errors->first('sub_ic') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Scientific Name :</label>
                                                            <input type="text" name="scientific_name" id="scientific_name"
                                                                value="{{ old('scientific_name') }}" class="form-control" 
                                                                placeholder="Enter Scientific Name" />
                                                        </div>


                                                        {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <label>Item Code :</label>
                                                    <input type="text" name="item_code" id="item_code" value="{{old('item_code')}}" class="form-control" />
                                                    @if ($errors->has('item_code'))
                                                        <span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('item_code') }}</strong>
                                                        </span>
                                                    @endif
                                                </div> --}}

                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>SKU Code :</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <input type="text" name="sku_code" id="sku_code"
                                                                value="{{ old('sku_code') }}" class="form-control" />
                                                            @if ($errors->has('sku_code'))
                                                                <span class="help-block">
                                                                    <strong
                                                                        class="text-danger">{{ $errors->first('sku_code') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Unit of Measurement :</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <select name="uom_id" id="uom_id"
                                                                class="form-control requiredField select2">
                                                                <option value="">Select UOM</option>
                                                                @foreach ($uom as $key => $i)
                                                                    <option value="{{ $i->id }}"
                                                                        {{ old('uom_id') == $i->id ? 'selected' : '' }}>
                                                                        {{ $i->uom_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Rate :</label>
                                                            <input step="0.01" class="form-control text-right"
                                                                value="{{ old('rate', 0) }}" type="number" name="rate"
                                                                id="rate">
                                                        </div>

                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Type</label>
                                                            <select style="width: 100%" name="maintain" id="maintain"
                                                                class="form-control requiredField">
                                                                <option value="">Select </option>
                                                                @foreach (CommonHelper::get_all_demand_type() as $row)
                                                                    <option value="{{ $row->id }}"
                                                                        {{ old('maintain') == $row->id ? 'selected' : '' }}>
                                                                        {{ ucwords($row->name) }}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Batch Code</label>
                                                            <select style="width: 100%" name="batch_code" id="batch_code"
                                                                class="form-control requiredField">
                                                                <option value="1"
                                                                    {{ old('batch_code') == 1 ? 'selected' : '' }}>YES
                                                                </option>
                                                                <option value="0"
                                                                    {{ old('batch_code') == 0 ? 'selected' : '' }}>NO
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Packing Type</label>
                                                            <input type="text" class="form-control" name="pack_type"
                                                                value="{{ old('pack_type') }}">
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Packing Size</label>
                                                            <input type="text" class="form-control" name="pack_size"
                                                                value="{{ old('pack_size') }}">
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Pack UOM :</label>
                                                            <select name="pack_uom_id" id="pack_uom_id"
                                                                class="form-control select2">
                                                                <option value="">Select UOM</option>
                                                                @foreach ($uom as $key => $i)
                                                                    <option value="{{ $i->id }}"
                                                                        {{ old('pack_uom_id') == $i->id ? 'selected' : '' }}>
                                                                        {{ $i->uom_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Min Stock</label>
                                                            <input type="number" class="form-control" name="min_stock"
                                                                step="0.01" value="{{ old('min_stock') }}">
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Max Stock</label>
                                                            <input type="number" class="form-control" name="max_stock"
                                                                step="0.01" value="{{ old('max_stock') }}">
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>HS Code</label>
                                                            <input type="text" class="form-control" name="hs_code"
                                                                value="{{ old('hs_code') }}" placeholder="Enter HS Code">
                                                        </div>
                                                    </div>

                                                    <div class="lineHeight">&nbsp;</div>

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                                        {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                                        <button type="reset" id="reset"
                                                            class="btn btn-primary">Clear Form</button>
                                                    </div>
                                                    <?php
                                                    echo Form::close();
                                                    ?>
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
        function get_item_master() {
            var category = $('#CategoryId').val();
            var sub_category = $('#sub_category').val();
            if (category > 0 && sub_category > 0) {
                $.ajax({
                    url: '/pdc/get_item_master',
                    type: 'Get',
                    data: {
                        category: category,
                        sub_category: sub_category
                    },
                    success: function(response) {
                        //alert(response);
                        $('#item_master').html(response);
                    }
                });
            }

        }

        function get_sub_item_code() {
            var category = $('#CategoryId').val();
            var sub_category = $('#sub_category').val();
            var item_master_id = $('#item_master').val();
            if (category > 0 && sub_category > 0 && item_master_id > 0) {
                $.ajax({
                    url: '/pdc/get_sub_item_code',
                    type: 'Get',
                    data: {
                        category: category,
                        sub_category: sub_category,
                        item_master_id: item_master_id
                    },
                    success: function(response) {
                        $('#item_code').val(response);
                    }
                });
            } else {
                $('#item_code').val('');
            }

        }

        $(document).ready(function() {

            $('#bank_detail').change(function() {
                if ($(this).is(':checked')) {

                    $(".banks").css("display", "block");
                    $(".required").addClass("requiredField");

                    //   $("#pra").addClass("requiredField");
                } else {
                    $(".banks").css("display", "none");
                    $(".required").removeClass("requiredField");
                    //  $('#pra').val("");
                    // $("#pra").removeClass("requiredField");
                }
            });


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
    </script>
    <script type="text/javascript">
        $('.select2').select2();
    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
