<?php
$accType = Auth::user()->acc_type;
if ($accType == 'client') {
    $m = Session::get('run_company');
} else {
    $m = Auth::user()->company_id;
}
use App\Helpers\CommonHelper;
?>


@extends('layouts.default')
@section('content')
    @include('select2');
    <div class="well well_N">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="well">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span class="subHeadingLabelClass">Edit New Sub Item</span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="row">
                                                <?php echo Form::open(['url' => 'pad/editSubItemDetail?m=' . $m . '', 'id' => 'addSubItemDetail']); ?>

                                                <div class="row">

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label>Item Type</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <select style="width: 100%" name="stockType" id="stockType"
                                                            class="form-control requiredField">
                                                            <option value="">Select Item Type</option>
                                                            @foreach (CommonHelper::item_types_for_items() as $itemTypes)
                                                                <option value="{{ $itemTypes['id'] }}" {{($sub_item->stockType == $itemTypes['id'])? 'selected' : '' }}>
                                                                    {{ $itemTypes['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label>Category :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <select autofocus name="" id="CategoryId"
                                                            class="form-control select2"
                                                            onchange="get_sub_category(this.id,'sub_category')" disabled>
                                                            <option value="">Select Category</option>
                                                            @foreach ($categories as $key => $y)
                                                                <option value="{{ $y->id }}" <?php if ($sub_item->main_ic_id == $y->id) {
                                                                    echo 'selected';
                                                                } ?>>
                                                                    {{ $y->main_ic }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="CategoryId" value="<?php echo $sub_item->main_ic_id; ?>">
                                                    </div>


                                                    <input type="hidden" name="EditId" value="{{ Request::get('id') }}" />

                                                    {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <label>Item Code :</label>
                                                    <input type="text" name="item_code" id="item_code" value="{{$sub_item->item_code}}" class="form-control" />
                                                    @if ($errors->has('item_code'))
                                                        <span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('item_code') }}</strong>
                                                        </span>
                                                    @endif
                                                </div> --}}
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label>Sub Item Name :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="sub_ic" id="sub_ic"
                                                            value="<?php echo $sub_item->sub_ic; ?>"
                                                            class="form-control requiredField" />
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
                                                            value="<?php echo $sub_item->scientific_name ?? ''; ?>"
                                                            class="form-control" placeholder="Enter Scientific Name" />
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label>SKU Code:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="hidden" name="old_sku_code" id="old_sku_code" value="<?php echo $sub_item->sku_code; ?>" />
                                                        <input type="text" name="sku_code" id="sku_code"
                                                            value="<?php echo $sub_item->sku_code; ?>"
                                                            class="form-control requiredField" />
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
                                                                <option value="{{ $i->id }}" <?php if ($sub_item->uom == $i->id) {
                                                                    echo 'selected';
                                                                } ?>>
                                                                    {{ $i->uom_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label>Rate :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input step="0.01" class="form-control text-right requiredField"
                                                            type="number" name="rate" id="rate"
                                                            value="<?php echo $sub_item->rate ?? 0; ?>">
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label>Type</label>
                                                        <select style="width: 100%" name="maintain" id="maintain"
                                                            class="form-control requiredField">
                                                            <option value="">Select </option>
                                                            @foreach (CommonHelper::get_all_demand_type() as $row)
                                                                <option value="{{ $row->id }}" <?php if ($sub_item->type == $row->id) {
                                                                    echo 'selected';
                                                                } ?>>
                                                                    {{ ucwords($row->name) }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label>Batch Code</label>
                                                        <select style="width: 100%" name="batch_code" id="batch_code"
                                                            class="form-control requiredField">
                                                            <option value="1"
                                                                {{ $sub_item->batch_code == 1 ? 'selected' : '' }}>Yes
                                                            </option>
                                                            <option
                                                                value="0"{{ $sub_item->batch_code == 0 ? 'selected' : '' }}>
                                                                No </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label>Packing Type</label>
                                                        <input type="text" class="form-control" name="pack_type"
                                                            value="{{ $sub_item->pack_type }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label>Packing Size</label>
                                                        <input type="text" class="form-control" name="pack_size"
                                                            value="{{ $sub_item->pack_size }}">
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label>Pack UOM :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <select name="pack_uom_id" id="pack_uom_id" class="form-control select2">
                                                            <option value="">Select UOM</option>
                                                            @foreach($uom as $key => $i)
                                                                <option value="{{ $i->id}}" <?php if($sub_item->pack_uom == $i->id){echo "selected";}?>>{{ $i->uom_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label>Min Stock</label>
                                                        <input type="number" class="form-control" name="min_stock"
                                                            step="0.01" value="{{ $sub_item->min_stock }}">
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label>Mxn Stock</label>
                                                        <input type="number" class="form-control" name="max_stock"
                                                            step="0.01" value="{{ $sub_item->max_stock }}">
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label>HS Code</label>
                                                        <input type="text" class="form-control" name="hs_code"
                                                            value="{{ $sub_item->hs_code ?? '' }}" placeholder="Enter HS Code">
                                                    </div>
                                                </div>





                                                {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"> --}}
                                                {{-- <label>Opening Quantity :</label> --}}
                                                {{-- <span class="rflabelsteric"><strong>*</strong></span> --}}
                                                {{-- --}}
                                                {{-- </div> --}}
                                                {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"> --}}
                                                {{-- <label>Opening Value :</label> --}}
                                                {{-- <span class="rflabelsteric"><strong>*</strong></span> --}}
                                                {{-- </div> --}}


                                                <div>&nbsp;</div>

                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                                    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                                    <button type="reset" id="reset" class="btn btn-primary">Clear
                                                        Form</button>
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
