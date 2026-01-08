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
                                        <span class="subHeadingLabelClass">Edit Finish Good</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form action="{{ route('product.FG.update', $product->id) }}" method="post"
                                                        id="accommodiatiesProduct">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="table_type" value="5">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Variety :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select autofocus required name="parent_id" id="parent_id"
                                                                    class="form-control select2">
                                                                    <option value="">Select Variety</option>
                                                                    @foreach ($products_drop as $key => $y)
                                                                        <option value="{{ $y->id }}"
                                                                            {{ $product->parent_id == $y->id ? 'selected' : '' }}>
                                                                            {{ $y->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Finish Good Type:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select required autofocus name="variety_type" id="variety_type"
                                                                    class="form-control requiredField select2">
                                                                    <option value="">Select FG Type</option>
                                                                    <option {{ $product->variety_type == '1' ? 'selected' : '' }} value="1">White</option>
                                                                    <option {{ $product->variety_type == '2' ? 'selected' : '' }} value="2">Brown</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>FG Name :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="name" id="name"
                                                                    value="{{ $product->name }}" class="form-control" />
                                                                @if ($errors->has('name'))
                                                                    <span class="help-block">
                                                                        <strong
                                                                            class="text-danger">{{ $errors->first('name') }}</strong>
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
                                                                            {{ $product->uom_id == $i->id ? 'selected' : '' }}>
                                                                            {{ $i->uom_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>SKU Code :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="sku_code" id="sku_code"
                                                                    value="{{ $product->sku_code }}" class="form-control" />
                                                                @if ($errors->has('sku_code'))
                                                                    <span class="help-block">
                                                                        <strong
                                                                            class="text-danger">{{ $errors->first('sku_code') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Type</label>
                                                                <select style="width: 100%" name="type_id" id="type_id"
                                                                    class="form-control requiredField">
                                                                    <option value="">Select </option>
                                                                    @foreach (CommonHelper::get_all_demand_type() as $row)
                                                                        <option value="{{ $row->id }}"
                                                                            {{ $product->type_id == $row->id ? 'selected' : '' }}>
                                                                            {{ ucwords($row->name) }}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                            {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Crop Based</label>
                                                                <select style="width: 100%" name="crop_based"
                                                                    id="crop_based" class="form-control requiredField">
                                                                    <option value="1"
                                                                        {{ old('crop_based') == 1 ? 'selected' : '' }}>YES
                                                                    </option>
                                                                    <option value="0"
                                                                        {{ old('crop_based') == 0 ? 'selected' : '' }}>NO
                                                                    </option>
                                                                </select>
                                                            </div> --}}
                                                            <input type="hidden" name="crop_based" value="0">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Min Stock</label>
                                                                <input type="number" class="form-control" name="min_stock"
                                                                    step="0.01" value="{{ $product->min_stock  }}">
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Max Stock</label>
                                                                <input type="number" class="form-control" name="max_stock"
                                                                    step="0.01" value="{{$product->max_stock  }}">
                                                            </div>
                                                        </div>
                                                        {{-- <div class="row">
                                                           
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 hiddenField">
                                                                <label>Packing Type</label>
                                                                <input type="text" class="form-control" name="packing_type"
                                                                    value="{{ old('packing_type') }}">
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 hiddenField">
                                                                <label>Packing Size</label>
                                                                <input type="number" class="form-control" name="packing_size"
                                                                    value="{{ old('packing_size') }}">
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 hiddenField">
                                                                <label>Brand/Mark:</label>
                                                                <input type="text" class="form-control" name="brand"
                                                                    value="{{ old('brand') }}">
                                                            </div>
                    
                                                        </div> --}}
                                        
                                                        <div class="lineHeight" style="margin-top: 5%;">&nbsp;</div>

                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                                            {{ Form::submit('Update', ['class' => 'btn btn-success']) }}
                                                            <button type="reset" id="reset"
                                                                class="btn btn-primary">Clear Form</button>
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
        function hideShowHddenField(){
            var pro_type = $('#product_type').val();
            if (pro_type == 1) {
                $('.hiddenField').removeClass('hide');
            }else{
                $('.hiddenField').addClass('hide');
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
            hideShowHddenField();

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
