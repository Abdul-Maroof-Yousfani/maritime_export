<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
?>
@extends('layouts.default')
<style>
    /* .row.align-item-center {
        align-items: center;
        display: flex;
    } */
    .fw-bold{
        font-weight: bold;
    }
    .form-control.s-height {
        height: 30px;
    }
    input.form-control {
        margin: 0;
    }
</style>
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
                                        <span class="subHeadingLabelClass">Create Purchase Order</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form action="{{ route('purchase_order.store') }}" method="post"
                                                          id="yourFormId2">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <div class="row align-item-center">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <h4 class="fw-bold">Category</h4>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Category :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="category_id" id="category_id"
                                                                        class="form-control s-height  select2 "
{{--                                                                        getSubVarietyAgainstCategory(this.value);--}}
                                                                        onchange="getSubcategory(this.value);selected_crop();">
                                                                    <option value="">Select Category</option>
                                                                    @foreach ($categories as $key => $y)
                                                                        <option value="{{ $y->id }}"
                                                                                {{ old('category_id') == $y->id ? 'selected' : '' }}>
                                                                            {{ $y->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Select Crop Based:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="crop_based_id" id="crop_based_id"
                                                                    class="form-control  select2 ">
                                                                    <option value="">Select Crop Based</option>
                                                                    @foreach ($cropBased as $key => $y)
                                                                        <option value="{{ $y->id }}"
                                                                            {{ old('crop_based_id') == $y->id ? 'selected' : '' }}>
                                                                            {{ date('M-Y', strtotime($y->date_from)) . ' - ' . date('M-Y', strtotime($y->date_to)) }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row align-item-center">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <h4 class="fw-bold">Sub Category</h4>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Select Sub Category:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="sub_category_id" id="sub_category_id"
                                                                        class="form-control s-height  select2 "
                                                                        onchange="getproduct(this.value)">
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Variety Name:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="product_id" id="product_id"
                                                                        class="form-control s-height  select2"
                                                                        onchange="getVoucherNo(); get_subitem(this.value)">
                                                                    <option value="">Select Variety Name</option>

                                                                </select>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Sub Variety Name:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select onchange="get_item(this.value);" name="subitem_id" id="subitem_id"
                                                                        class="form-control s-height  select2"
                                                                       >
                                                                    <option value="">Select Sub Variety</option>

                                                                </select>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Item Name:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select onchange="getVarietyParams(this.value);" name="item_id" id="item_id"
                                                                        class="form-control s-height  select2"
                                                                       >
                                                                    <option value="">Select Sub Variety</option>

                                                                </select>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>PO No:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="voucher_no" readonly
                                                                       id="voucher_no" value="{{ old('voucher_no') }}"
                                                                       class="form-control s-height " />
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row align-item-center" style="">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <h4 class="fw-bold">Product Detail</h4>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>PO Date:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" min="{{date('Y-m-d')}}" name="voucher_date" id="voucher_date"
                                                                       value="{{ old('voucher_date') ?? date('Y-m-d') }}"
                                                                       class="form-control s-height " />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Start Date:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" min="{{date('Y-m-d')}}" name="req_date" id="req_date"
                                                                       value="{{ old('req_date') }}" class="form-control s-height " />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>End Date:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" min="{{date('Y-m-d')}}" name="promise_date" id="promise_date"
                                                                       value="{{ old('promise_date') }}"
                                                                       class="form-control s-height " />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Select Location:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="location_id" id="location_id"
                                                                        class="form-control s-height  select2">
                                                                    <option value="">Select Location</option>
                                                                    @foreach ($company_locations as $company_location)
                                                                        <option  value="{{ $company_location['id'] }}">
                                                                            {{ $company_location['location_name'] }}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>


                                                        </div>
                                                        <hr>
                                                        <div class="row align-item-center">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <h4 class="fw-bold">Supplier Detail</h4>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Supplier:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="supplier_id" id="supplier_id"
                                                                        class="form-control s-height  select2">
                                                                    <option value="">Select Supplier</option>
                                                                    @foreach ($suppliers as $Supplier)
                                                                        <option value="{{ $Supplier->id }}">
                                                                            {{ $Supplier->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Agent Name:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="agent_id" id="agent_id"
                                                                        class="form-control s-height  select2">
                                                                    <option value="">Select Agent</option>
                                                                    @foreach ($suppliers as $Supplier)
                                                                        <option value="{{ $Supplier->id }}">
                                                                            {{ $Supplier->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Shipment Origin:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" class="form-control s-height  select2" name="shipment_origin" id="shipment_origin"/> --}}
                                                                {{-- <select name="delivery_term" id="delivery_term"
                                                                    class="form-control s-height  select2">
                                                                    <option value="">Select Delivery Detail</option>
                                                                    <option value="FOB">FOB</option>
                                                                    <option value="CNF">CNF</option>
                                                                </select> --}}
                                                            {{-- </div> --}}
                                                            {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Delivery Mode:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="delivery_mode" id="delivery_mode"
                                                                    class="form-control s-height  select2">
                                                                    <option value="">Select Delivery Term</option>
                                                                    <option value="1">Trallers</option>
                                                                    <option value="2">Truck</option>
                                                                    <option value="3">Bags</option>
                                                                    <option value="4">Katta</option>
                                                                    <option value="5">KG</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Select Location:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="location_id" id="location_id"
                                                                    class="form-control s-height  select2">
                                                                    <option value="">Select Warehouse</option>
                                                                    @foreach (CommonHelper::get_users_warehouse() as $warehouse)
                                                                        <option value="{{ $warehouse->id }}">
                                                                            {{ $warehouse->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div> --}}
                                                            {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Rate Per KG:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="rate_per_kg" id="rate_per_kg"
                                                                    value="{{ old('rate_per_kg') }}"
                                                                    class="form-control s-height " />
                                                            </div> --}}
                                                            {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Order Rate:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="order_rate" id="order_rate"
                                                                    value="{{ old('order_rate') }}"
                                                                    class="form-control s-height " />
                                                            </div> --}}
                                                        </div>
                                                        <hr>
                                                        <div class="row align-item-center">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <h4 class="fw-bold">Delivery Detail</h4>

                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Delivery Mode Min:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="min_delivery_mode" onchange="delivery_calculate(2,this.value);" id="delivery_mode2"
                                                                        class="form-control s-height select2">
                                                                    <option value="">Select Delivery Mode</option>
                                                                    <option value="1">Trallers</option>
                                                                    <option value="2">Truck</option>
                                                                    <option value="3">Bags</option>
                                                                    <option value="4">Katta</option>
                                                                    <option value="5">KG</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                                <label>Qty Trallers:</label>
                                                                <input min="0"  type="number" onkeyup="calculate(2,this.value);po_amount_calculate();" name="min_qty_traller" id="qty_traller2"
                                                                       value="{{ old('qty_traller') ?? '0' }}"
                                                                       class="form-control s-height apply2 append_traller"  />
                                                            </div>
                                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                                <label>Qty Truck:</label>
                                                                <input min="0" type="number" onkeyup="calculate(2,this.value);po_amount_calculate();" name="min_qty_truck" id="qty_truck2"
                                                                       value="{{ old('qty_truck') ?? '0' }}"
                                                                       class="form-control s-height apply2 append_katta" />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Qty Bag:</label>
                                                                <input min="0" type="number" onkeyup="calculate(2,this.value);po_amount_calculate();" name="min_qty_bag" id="qty_bag2"
                                                                       value="{{ old('qty_bag') ?? '0' }}"
                                                                       class="form-control s-height apply2 append_bag" />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Qty Katta:</label>
                                                                <input min="0" type="number" onkeyup="calculate(2,this.value);po_amount_calculate();" name="min_qty_katta" id="qty_katta2"
                                                                       value="{{ old('qty_katta') ?? '0' }}"
                                                                       class="form-control s-height apply2 append_katta" />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Qty Kg:</label>
                                                                <input min="0" type="number"  onkeyup="calculate(2,this.value);po_amount_calculate();" name="min_qty_kg" id="qty_kg2"
                                                                       value="{{ old('qty_kg') ?? '0' }}"
                                                                       class="form-control s-height apply2 append_kg" />
                                                            </div>
                                                        </div>

                                                        <hr>
                                                        <div class="row align-item-center">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Delivery Mode Max:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select disabled name="max_delivery_mode" onchange="delivery_calculate(1,this.value)" id="delivery_mode1"
                                                                        class="form-control s-height select2">
                                                                    <option value="">Select Delivery Mode</option>
                                                                    <option value="1">Trallers</option>
                                                                    <option value="2">Truck</option>
                                                                    <option value="3">Bags</option>
                                                                    <option value="4">Katta</option>
                                                                    <option value="5">KG</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                                <label>Qty Trallers:</label>
                                                                <input readonly min="0" type="number" onkeyup="calculate(1,this.value)" name="max_qty_traller" id="qty_traller1"
                                                                       value="{{ old('qty_traller') ?? '0' }}"
                                                                       class="form-control s-height apply1 append_traller"  />
                                                            </div>
                                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                                <label>Qty Truck:</label>
                                                                <input readonly min="0" type="number" onkeyup="calculate(1,this.value)" name="max_qty_truck" id="qty_truck1"
                                                                       value="{{ old('qty_truck') ?? '0' }}"
                                                                       class="form-control s-height apply1 append_truck" />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Qty Bag:</label>
                                                                <input readonly min="0" type="number" onkeyup="calculate(1,this.value)" name="max_qty_bag" id="qty_bag1"
                                                                       value="{{ old('qty_bag') ?? '0' }}"
                                                                       class="form-control s-height apply1 append_bag" />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Qty Katta:</label>
                                                                <input readonly min="0" type="number" onkeyup="calculate(1,this.value)" name="max_qty_katta" id="qty_katta1"
                                                                       value="{{ old('qty_katta') ?? '0' }}"
                                                                       class="form-control s-height apply1 append_katta" />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Qty Kg:</label>
                                                                <input readonly min="0" type="number" onkeyup="calculate(1,this.value)" name="max_qty_kg" id="qty_kg1"
                                                                       value="{{ old('qty_kg') ?? '0' }}"
                                                                       class="form-control s-height apply1 append_kg" />
                                                            </div>

                                                        </div>

                                                        <hr>
                                                        <div class="row align-item-center">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Delivery Term:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="delivery_term" onchange="get_delivery_term(0);po_amount_calculate();" id="delivery_term"
                                                                        class="form-control s-height select2">
                                                                    <option value="">Select Delivery Term</option>
                                                                    <option value="FOB">FOB</option>
                                                                    <option value="C&F">C&F</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Order Rate:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input  type="number" onkeyup="get_delivery_term(this.value);po_amount_calculate();" name="order_rate" id="order_rate"
                                                                       value="{{ old('order_rate') }}"
                                                                       class="form-control s-height " />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Rate Per KG:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input readonly type="number" name="rate_per_kg" id="rate_per_kg"
                                                                       value="{{ old('rate_per_kg') }}"
                                                                       class="form-control s-height " />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Brokery Term:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="brokery_term" id="brokery_term"
                                                                        class="form-control s-height select2">
                                                                    <option value="">Select Brokery Term</option>
                                                                    <option value="immediate">Immediate</option>
                                                                    <option value="delay">Delay</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Replace / Reject:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="is_replaceable" id="is_replaceable"
                                                                        class="form-control s-height select2">
                                                                    <option value="">Select Replacement</option>
                                                                    <option value="1">Replaceable</option>
                                                                    <option value="0">None Replaceable</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                      
                                                        <hr>
                                                        <div class="row align-items-center">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <h4 class="fw-bold">Freight</h4>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Freight Per KG:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input readonly value="0"  onkeyup="po_amount_calculate()" type="number" name="freight_per_traller"
                                                                       id="freight_per_traller"
                                                                       value="{{ old('freight_per_traller') }}"
                                                                       class="form-control s-height " />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Commission Per Bag:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input value="0" onkeyup="po_amount_calculate()" type="number" name="commission_per_bag" id="commission_per_bag"
                                                                       value="{{ old('commission_per_bag') }}"
                                                                       class="form-control s-height " />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Bardana Per Bag:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input readonly value="0" onkeyup="po_amount_calculate()" type="number" name="bardana_per_bag" id="bardana_per_bag"
                                                                       value="{{ old('bardana_per_bag') }}"
                                                                       class="form-control s-height " />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Misc Exp Per Bag:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input readonly value="0"  onkeyup="po_amount_calculate()" type="number" name="misc_exp_per_bag" id="misc_exp_per_bag"
                                                                       value="{{ old('misc_exp_per_bag') }}"
                                                                       class="form-control s-height " />
                                                            </div>
                                                          
                                                        </div>
                                                        <div class="row align-items-center">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label>Select Slab Type:</label>
                                                                <select onchange="getProductSlabsDetail(this.value);" id="type"
                                                                        class="form-control s-height select2">
                                                                    <option value="">Select Slab Type</option>
                                                                    @foreach ($types ?? [] as $type)
                                                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center" style="margin-top: 3%" id="getProductSlabsDetail">

                                                        </div>
                                                        <hr>
                                                        <div class="row align-items-center">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <h4 class="fw-bold">Product Parameter</h4>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Moisture (KG):</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="moisture" id="moisture" value="{{ old('moisture') }}" class="form-control s-height track-change" readonly />
                                                                <button type="button" class="btn btn-sm btn-primary edit-btn" data-field="moisture">Edit</button>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Damage (RS):</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="damage" id="damage" value="{{ old('damage') }}" class="form-control s-height track-change" readonly />
                                                                <button type="button" class="btn btn-sm btn-primary edit-btn" data-field="damage">Edit</button>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Chalky (RS):</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="chalky" id="chalky"
                                                                       value="{{ old('chalky') }}"
                                                                       class="form-control s-height track-change" readonly/>
                                                                <button type="button" class="btn btn-sm btn-primary edit-btn " data-field="chalky">Edit</button>

                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Broken (RS):</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="broken" id="broken"
                                                                       value="{{ old('broken') }}"
                                                                       class="form-control s-height track-change" readonly/>
                                                                <button type="button" class="btn btn-sm btn-primary edit-btn track-change" data-field="broken">Edit</button>

                                                            </div>
                                                        </div>


                                                        <div class="row">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>O.V (RS):</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="o_v" id="o_v"
                                                                       value="{{ old('o_v') }}"
                                                                       class="form-control s-height track-change" readonly/>
                                                                <button type="button" class="btn btn-sm btn-primary edit-btn track-change" data-field="o_v">Edit</button>

                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Look (RS):</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="look" id="look"
                                                                       value="{{ old('look') }}"
                                                                       class="form-control s-height track-change" readonly />
                                                                <button type="button" class="btn btn-sm btn-primary edit-btn track-change" data-field="look">Edit</button>

                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>CHOBBA (RS):</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="chobba" id="chobba"
                                                                       value="{{ old('chobba') }}"
                                                                       class="form-control s-height track-change" readonly/>
                                                                <button type="button" class="btn btn-sm btn-primary edit-btn track-change" data-field="chobba">Edit</button>

                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <h4 class="fw-bold">Amount</h4>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>PO Amount:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input readonly type="text" name="po_amount" id="po_amount"
                                                                       value="{{ old('po_amount') }}"
                                                                       class="form-control s-height " />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Landed Rate Per Kg:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input readonly type="text" name="landed_rate_per_kg" id="landed_rate_per_kg"
                                                                       value="{{ old('landed_rate_per_kg') }}"
                                                                       class="form-control s-height " />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Payment Term:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="payment_term" id="payment_term"
                                                                        class="form-control s-height select2">
                                                                    <option value="">Select Payment Term</option>
                                                                    <option value="3">3 Days</option>
                                                                    <option value="6">6 Days</option>
                                                                    <option value="10">10 Days</option>
                                                                    <option value="15">15 Days</option>
                                                                    <option value="30">30 Days</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <label>Amount In Words:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <textarea rows="2" cols="50" style="resize:none;" class="form-control" disabled type="text" name="rupees" id="rupees"
                                                                       value="{{ old('po_amount') }}"
                                                                       class="form-control s-height " ></textarea>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">

                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <label>Remarks:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <textarea rows="2" class="form-control" type="text" name="remarks" id="remarks"
                                                                       value="{{ old('remarks') }}"
                                                                       class="form-control s-height " ></textarea>
                                                            </div>

                                                        </div>
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
{{--                                                                <div class="table-responsive">--}}
{{--                                                                    <table class="table table-bordered">--}}
{{--                                                                        <thead>--}}
{{--                                                                        <tr class="text-center">--}}
{{--                                                                            <th colspan="3" class="text-center">--}}
{{--                                                                                Item--}}
{{--                                                                                Detail</th>--}}
{{--                                                                            <th colspan="2" class="text-center hide">--}}
{{--                                                                                <input type="button"--}}
{{--                                                                                       class="btn btn-sm btn-primary"--}}
{{--                                                                                       onclick="AddMoreDetails()"--}}
{{--                                                                                       value="Add More Rows" />--}}
{{--                                                                            </th>--}}
{{--                                                                        </tr>--}}
{{--                                                                        <tr>--}}
{{--                                                                            --}}{{-- <th class="text-center"--}}
{{--                                                                                style="width: 2%;">S.NO--}}
{{--                                                                            </th> --}}
{{--                                                                            <th class="text-center"--}}
{{--                                                                                style="width: 20%;">--}}
{{--                                                                                Item Name</th>--}}
{{--                                                                            <th class="text-center">Delivery Mode</th>--}}
{{--                                                                            <th class="text-center">Qty--}}
{{--                                                                            </th>--}}
{{--                                                                            <th class="text-center">Order rate</th>--}}
{{--                                                                            <th class="text-center">--}}
{{--                                                                                Total--}}
{{--                                                                            </th>--}}
{{--                                                                            <th class="text-center">--}}
{{--                                                                                Remove--}}
{{--                                                                            </th>--}}
{{--                                                                        </tr>--}}
{{--                                                                        </thead>--}}

{{--                                                                        <tbody id="AppnedHtml">--}}
{{--                                                                        <tr class="cnt" id="removeSection1">--}}

{{--                                                                            <td>--}}
{{--                                                                                <select name="product_id" id="product_id"--}}
{{--                                                                                        class="form-control s-height  select2"--}}
{{--                                                                                        onchange="getProductSlabsDetail()">--}}
{{--                                                                                </select>--}}
{{--                                                                            </td>--}}
{{--                                                                            <td>--}}
{{--                                                                                <select name="delivery_mode" id="delivery_mode"--}}
{{--                                                                                        class="form-control s-height  select2">--}}
{{--                                                                                    <option value="">Select Delivery Term</option>--}}
{{--                                                                                    <option value="1">Trallers</option>--}}
{{--                                                                                    <option value="2">Truck</option>--}}
{{--                                                                                    <option value="3">Bags</option>--}}
{{--                                                                                    <option value="4">Katta</option>--}}
{{--                                                                                    <option value="5">KG</option>--}}
{{--                                                                                </select>--}}
{{--                                                                            </td>--}}
{{--                                                                            <td><input type="number"--}}
{{--                                                                                       class="form-control s-height  " name="qty"--}}
{{--                                                                                       id="qty1" onkeyup="calculate(1)" value="">--}}
{{--                                                                            </td>--}}
{{--                                                                            <td ><input type="number"--}}
{{--                                                                                        class="form-control s-height " name="order_rate"--}}
{{--                                                                                        id="rate1" onkeyup="calculate(1)" value="">--}}
{{--                                                                            </td>--}}
{{--                                                                            <td ><input type="text"--}}
{{--                                                                                        class="form-control s-height " name="po_amount"--}}
{{--                                                                                        id="total1" readonly value="">--}}
{{--                                                                            </td>--}}
{{--                                                                            <td><button class="btn btn-danger btn-xs" onClick="removeSection(1)">Remove</button>--}}
{{--                                                                            </td>--}}
{{--                                                                        </tr>--}}
{{--                                                                        </tbody>--}}


{{--                                                                    </table>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}

                                                       
                                                        <hr>
                                                        <div class="row">
                                                            <div
                                                                    class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                                                {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                                                <button type="reset" id="reset"
                                                                        class="btn btn-primary">Clear Form</button>
                                                            </div>
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

        $(document).ready(function () {
            // Function to copy all fields from min to max
            function copyMinToMax() {
                // Copy delivery mode
                var deliveryModeMin = $('#delivery_mode2').val();
                $('#delivery_mode1').val(deliveryModeMin).trigger('change'); // Update and trigger change for Select2

                // // Copy quantities
                // $('#qty_traller1').val($('#qty_traller2').val());
                // $('#qty_truck1').val($('#qty_truck2').val());
                // $('#qty_bag1').val($('#qty_bag2').val());
                // $('#qty_katta1').val($('#qty_katta2').val());
                // $('#qty_kg1').val($('#qty_kg2').val());
            }

            // Bind change event to all min fields
            $('#delivery_mode2, #qty_traller2, #qty_truck2, #qty_bag2, #qty_katta2, #qty_kg2').on('keyup change', function() {
                copyMinToMax(); // Call the function to update all max fields
            });
            $('.append_traller').on('keyup', function() {
                var value = $(this).val();                
                $('.append_traller').val(value);
            });
            $('.append_truck').on('keyup', function() {
                var value = $(this).val();                
                $('.append_truck').val(value);
            });
            $('.append_bag').on('keyup', function() {
                var value = $(this).val();                
                $('.append_bag').val(value);
            });
            $('.append_katta').on('keyup', function() {
                var value = $(this).val();                
                $('.append_katta').val(value);
            });
            $('.append_kg').on('keyup', function() {
                var value = $(this).val();                
                $('.append_kg').val(value);
            });
        });



        // Track edited fields
        let editedFields = [];

        // Enable editing when clicking "Edit" button
        $('.edit-btn').on('click', function() {
            let field = $(this).data('field');
            $(`#${field}`).prop('readonly', false); // Make the field editable
            if (!editedFields.includes(field)) {
                editedFields.push(field); // Add to edited fields list if not already there
            }
        });


        function getVarietyParams(id) {
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/getVarietyParams',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    if (!response) {
                        // Show SweetAlert that is completely non-dismissible
                        Swal.fire({
                            title: 'Error',
                            text: 'Variety parameters not found for the selected sub-variety. Please create a parameter for that sub-variety.',
                            icon: 'error',
                            allowOutsideClick: false, // Prevents clicking outside
                            allowEscapeKey: false, // Prevents pressing the Esc key
                            allowEnterKey: false, // Prevents pressing Enter to dismiss
                            showConfirmButton: false, // Hides the confirm button
                            timerProgressBar: true, // Optional: Show a progress bar if you plan to close it programmatically
                            didOpen: () => {
                                Swal.showLoading(); // Shows a loading spinner to indicate it's processing
                            }
                        });
                        return;
                    }

                    // Loop through the response and assign data to input fields
                    $.each(response, function(key, value) {
                        console.log(key, value);
                        if ($(`[name="${key}"]`).length) {
                            $(`[name="${key}"]`).val(value);
                        }
                    });
                }
            });
        }





        $('.select2').select2();

        // $(document).ready(function() {
        //     $(".btn-success").click(function(e) {
        //         var subItem = new Array();
        //         var val;
        //         //$("input[name='chartofaccountSection[]']").each(function(){
        //         subItem.push($(this).val());
        //         //});
        //         var _token = $("input[name='_token']").val();
        //         for (val of subItem) {
        //             jqueryValidationCustom();
        //             if (validate == 0) {
        //                 $('.btn-success').prop('disabled', true);
        //                 $("form").submit();
        //                 //return false;
        //             } else {
        //                 return false;
        //             }
        //         }
        //     });
        // });

        function getSubVarietyAgainstCategory(id) {
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/getSubVarietyAgainstCategory',
                type: 'Get',
                data: {
                    id: id
                },
                success: function(response) {
                    $('#subitem_id').html('');
                    $('#subitem_id').append(new Option('Select Sub Variety', ''))
                    $.each(response, function(index, element) {
                        $('#subitem_id').append(
                            `<option value="${element['id']}" >${element['name']}</option>`
                        )
                    });

                    $('#subitem_id').select2();
                }
            });
        }
 function getSubcategory(id) {
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/getsubcategory/' + id,
                type: 'Get',

                success: function(response) {
                    $('#sub_category_id').html('');
                    $('#sub_category_id').append(new Option('Select Sub Category', ''))
                    $.each(response, function(index, element) {
                        $('#sub_category_id').append(
                            `<option value="${element['id']}" data-cropbased="${element['crop_based']}">${element['name']}</option>`
                        )
                    });

                    $('#sub_category_id').select2();
                }
            });
        }

        function getproduct(id) {
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/getproduct/' + id,
                type: 'Get',
                success: function(response) {
                    $('#product_id').html('');
                    $('#product_id').append(new Option('Select Item Name', ''))
                    $.each(response, function(index, element) {
                        $('#product_id').append(
                            `<option value="${element['id']}" data-cropbased="${element['crop_based']}">${element['name']}</option>`
                        )
                    });
                    $('#product_id').select2();

                }
            });
        }


        function get_subitem(id) {
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/get_subitem/' + id,
                type: 'Get',
                success: function(response) {
                    $('#subitem_id').html('');
                    $('#subitem_id').append(new Option('Select Sub Item', ''))
                    $.each(response, function(index, element) {
                        $('#subitem_id').append(
                            `<option value="${element['id']}" data-cropbased="${element['crop_based']}">${element['name']}</option>`
                        )
                    });
                    $('#subitem_id').select2();

                }
            });
        }

        function get_item(id) {
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/get_item/' + id,
                type: 'Get',
                success: function(response) {
                    $('#item_id').html('');
                    $('#item_id').append(new Option('Select Sub Item', ''))
                    $.each(response, function(index, element) {
                        $('#item_id').append(
                            `<option value="${element['id']}">${element['name']}</option>`
                        )
                    });
                    $('#item_id').select2();

                }
            });
        }

        function getVoucherNo() {
            let product_id = $('#product_id option:selected').text();

            $.ajax({
                url: '{{ url('/') }}' + '/arrival/getVoucherNo',
                type: 'Get',
                data: {
                    product_id: product_id
                },
                success: function(response) {
                    // console.log(response);
                    $('#voucher_no').val(response[0]);
                }
            });
           
        }

        function getProductSlabsDetail(id) {
            let product_id = $('#item_id').val();
            let slab_name = $('#type option:selected').text();
            if (product_id == '') {
                $('#getProductSlabsDetail').html();
                return false;
            }
            $.ajax({
                url: '{{ url('/') }}' + '/commodities/purchase-order/getProductSlabsDetail',
                type: 'Get',
                data: {
                    product_id: product_id,
                    id: id,
                    slab_name: slab_name,
                },
                success: function(response) {
                    // console.log(response);
                    $('#getProductSlabsDetail').html(response);
                }
            });
        };

    

        function update_slab() {
            var slabs = [];
            var hasEmptyField = false;
            let product_id = $('#item_id').val();
            let slab_type_id = $('#type option:selected').val();
            

            // Loop through each row to gather form data
            $("tr[class^='slab_get']").each(function(index, element) {
                var fromValue = $(element).find('input[name="slab_from[]"]').val();
                var toValue = $(element).find('input[name="slab_to[]"]').val();
                var deductionValue = $(element).find('input[name="slab_deduction[]"]').val();
                var remarkValue = $(element).find('textarea[id^="slab_remark"]').val();

                // Check if any value is empty
                if (fromValue === "" || toValue === "" || deductionValue === "") {
                    hasEmptyField = true;
                    return false; // Break the loop
                }

                // Push the values into the slabs array
                slabs.push({
                    from: fromValue,
                    to: toValue,
                    deduction: deductionValue,
                    remark: remarkValue
                });
            });

            if (hasEmptyField) {
                Swal.fire({
                        title: 'Validation Errors',
                        text: 'Some fields are mandatory. Please check and correct the errors.',
                        icon: 'error',
                        confirmButtonColor: '#D95000'
                    });
                    return false
            }

            // Send AJAX request if all fields are filled
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/update_slab',
                method: 'POST',
                data: {
                    slabs: slabs,
                    product_id: product_id,
                    slab_type_id: slab_type_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonColor: '#3085d6'
                    });
                    $('#type').val("").trigger('change'); 
                },
                error: function(xhr) {
                    alert("An error occurred while submitting the data.");
                }
            });
        }



        var counter = 0;
        function AddMoreDetails() {
            counter++;
            // if(counter == 1){
            $('#AppnedHtml').append(
                `<tr class="cnt" id="removeSection${counter}">
                    
                    <td>
                            <select name="product_id" id="product_id"
                                class="form-control s-height  select2"
                                onchange="getProductSlabsDetail()">
                            </select>
                    </td>
                    <td>
                        <select name="delivery_mode" id="delivery_mode"
                            class="form-control s-height  select2">
                            <option value="">Select Delivery Term</option>
                            <option value="1">Trallers</option>
                            <option value="2">Truck</option>
                            <option value="3">Bags</option>
                            <option value="4">Katta</option>
                            <option value="5">KG</option>
                        </select>
                    </td>
                    <td><input type="number"
                            class="form-control s-height  " name="qty"
                            id="qty${counter}" onkeyup="calculate(${counter})" value="">
                    </td>
                    <td ><input type="number"
                            class="form-control s-height " name="order_rate"
                            id="rate${counter}" onkeyup="calculate(${counter})" value="">
                    </td>
                    <td ><input type="text"
                            class="form-control s-height " name="po_amount"
                            id="total${counter}" readonly value="">
                    </td>
                    <td><button class="btn btn-danger btn-xs" onClick="removeSection(${counter})">Remove</button>
                    </td>
                </tr>`
            );
            // }


            var id = $('#sub_category_id').val();
            getproduct(id)

        }

        function removeSection(id) {
            $('#removeSection' + id).remove();
        }

        function selected_crop() {
            var cropBasedData = @json($cropBased);
            let product_crop_id = $('#category_id option:selected').val();
            let $select = $('#crop_based_id');

            $select.empty();
            $select.append(new Option('Select Crop Based', ''))
            // Iterate over the crop-based data and append options
            $.each(cropBasedData, function(index, crop) {
                // Format the date to 'M-Y'
                let optionText = new Date(crop.date_from).toLocaleDateString('en-US', { month: 'short', year: 'numeric' }) + 
                                ' - ' + 
                                new Date(crop.date_to).toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
                
                // Create option element
                let $option = $('<option></option>')
                    .attr('value', crop.id)
                    .text(optionText);
                
                // Check if this option should be selected based on old value
                if (product_crop_id == crop.category_id) { // Replace `oldCropBasedId` with your variable or logic
                    $option.prop('selected', true);
                    $select.append($option);
                }else{
                    $select.append($option);
                }
            });
        }

        function delivery_calculate(id, selectedMode) {
            // Disable all fields initially
            $('#qty_traller' + id + ', #qty_truck' + id + ', #qty_bag' + id + ', #qty_katta' + id + ', #qty_kg' + id).prop('readonly', true);

            // Enable the selected field based on selectedMode
            if(id == 2){
                switch (selectedMode) {
                    case '1':
                        $('#qty_traller' + id).prop('readonly', false);
                        // $('#qty_truck' + id).prop('readonly', false);
                        // $('#qty_bag' + id).prop('readonly', false);
                        // $('#qty_katta' + id).prop('readonly', false);
                        // $('#qty_kg' + id).prop('readonly', false);
                        break;
                    case '2':
                        // $('#qty_traller' + id).prop('readonly', true);
                        $('#qty_truck' + id).prop('readonly', false);
                        // $('#qty_bag' + id).prop('readonly', false);
                        // $('#qty_katta' + id).prop('readonly', false);
                        // $('#qty_kg' + id).prop('readonly', false);
                        break;
                    case '3':
                        // $('#qty_traller' + id).prop('readonly', true);
                        // $('#qty_truck' + id).prop('readonly', true);
                        $('#qty_bag' + id).prop('readonly', false);
                        // $('#qty_katta' + id).prop('readonly', false);
                        // $('#qty_kg' + id).prop('readonly', false);
                        break;
                    case '4':
                        // $('#qty_traller' + id).prop('readonly', true);
                        // $('#qty_truck' + id).prop('readonly', true);
                        // $('#qty_bag' + id).prop('readonly', true);
                        $('#qty_katta' + id).prop('readonly', false);
                        // $('#qty_kg' + id).prop('readonly', false);
                        break;
                    case '5':
                        // $('#qty_traller' + id).prop('readonly', true);
                        // $('#qty_truck' + id).prop('readonly', true);
                        // $('#qty_bag' + id).prop('readonly', true);
                        // $('#qty_katta' + id).prop('readonly', true);
                        $('#qty_kg' + id).prop('readonly', false);
                        break;
                }  
            }
           

        }

        function calculate(id,value) {
            
            var selectedMode = $('#delivery_mode'+id+' option:selected').val();
            var traller = 0;
            var truck = 0;
            var bag = 0;
            var katta = 0;
            var kg = 0;

            if(id == 1){
              
            switch (selectedMode) {
                case '1':
                    truck = parseInt(value) + parseInt(value);
                    kg =  parseInt(value) * 32000;
                    bag =  parseInt(kg) / 100;
                    katta =  parseInt(kg) / 50;
                    $('#qty_truck' + id).val(truck);

                    $('#qty_bag' + id).val(bag);
                    $('#qty_katta' + id).val(katta);
                    $('#qty_kg' + id).val(kg);
                    break;
                case '2':
                    traller = parseInt(value) / 2;
                    kg =  parseInt(traller) * 32000;
                    bag =  parseInt(kg) / 100;
                    katta =  parseInt(kg) / 50;

                    $('#qty_traller' + id).val(traller);
                    $('#qty_bag' + id).val(bag);
                    $('#qty_katta' + id).val(katta);
                    $('#qty_kg' + id).val(kg);
                    break;
                case '3':
                    kg = parseInt(value) * 100;
                    traller =  parseInt(kg) / 32000;
                    truck =  parseInt(traller) + parseInt(traller) ;
                    katta =  parseInt(kg) / 50;

                    $('#qty_traller' + id).val(traller);
                    $('#qty_truck' + id).val(truck);
                    $('#qty_katta' + id).val(katta);
                    $('#qty_kg' + id).val(kg);
                    break;
                case '4':
                    kg = parseInt(value) * 50;
                    traller =  parseInt(kg) / 32000;
                    truck =  parseInt(traller) + parseInt(traller) ;
                    bag =  parseInt(kg) / 100;

                    $('#qty_traller' + id).val(traller);
                    $('#qty_truck' + id).val(truck);
                    $('#qty_bag' + id).val(bag);
                    $('#qty_kg' + id).val(kg);
                    break;
                case '5':
                    traller =  parseInt(value) / 32000;
                    truck =  parseInt(traller) + parseInt(traller) ;
                    bag =  parseInt(value) / 100;
                    katta = parseInt(value) / 50;

                    $('#qty_traller' + id).val(traller);
                    $('#qty_truck' + id).val(truck);
                    $('#qty_bag' + id).val(bag);
                    $('#qty_katta' + id).val(katta);
                    break;
            }

            }else{
                
                switch (selectedMode) {
                case '1':
                    truck = parseInt(value) + parseInt(value);
                    kg =  parseInt(value) * 25000;
                    bag =  parseInt(kg) / 100;
                    katta =  parseInt(kg) / 50;

                    $('#qty_truck' + id).val(truck);
                    $('#qty_bag' + id).val(bag);
                    $('#qty_katta' + id).val(katta);
                    $('#qty_kg' + id).val(kg);
                    calculate(1,value);
                    break;
                case '2':
                    traller = parseInt(value) / 2;
                    kg =  parseInt(traller) * 25000;
                    bag =  parseInt(kg) / 100;
                    katta =  parseInt(kg) / 50;

                    $('#qty_traller' + id).val(traller);
                    $('#qty_bag' + id).val(bag);
                    $('#qty_katta' + id).val(katta);
                    $('#qty_kg' + id).val(kg);
                    calculate(1,value);
                    break;
                case '3':
                    kg = parseInt(value) * 100;
                    traller =  parseInt(kg) / 25000;
                    truck =  parseInt(traller) + parseInt(traller) ;
                    katta =  parseInt(kg) / 50;

                    $('#qty_traller' + id).val(traller);
                    $('#qty_truck' + id).val(truck);
                    $('#qty_katta' + id).val(katta);
                    $('#qty_kg' + id).val(kg);
                    calculate(1,value);
                    break;
                case '4':
                    kg = parseInt(value) * 50;
                    traller =  parseInt(kg) / 25000;
                    truck =  parseInt(traller) + parseInt(traller) ;
                    bag =  parseInt(kg) / 100;

                    $('#qty_traller' + id).val(traller);
                    $('#qty_truck' + id).val(truck);
                    $('#qty_bag' + id).val(bag);
                    $('#qty_kg' + id).val(kg);
                    calculate(1,value);
                    break;
                case '5':
                    traller =  parseInt(value) / 25000;
                    truck =  parseInt(traller) + parseInt(traller) ;
                    bag =  parseInt(value) / 100;
                    katta = parseInt(value) / 50;

                    $('#qty_traller' + id).val(traller);
                    $('#qty_truck' + id).val(truck);
                    $('#qty_bag' + id).val(bag);
                    $('#qty_katta' + id).val(katta);
                    calculate(1,value);
                    break;
            }
            }
           
        }

        function get_delivery_term(value) {

            if(value == 0){

                order_rate = $('#order_rate').val();
                delivery_term = $('#delivery_term option:selected').val();

                if(delivery_term == 'FOB'){
                    $('#freight_per_traller').prop('readonly', false);
                    $('#bardana_per_bag').prop('readonly', false);
                    $('#misc_exp_per_bag').prop('readonly', false);
                }else{
                    $('#freight_per_traller').prop('readonly', true);
                    $('#bardana_per_bag').prop('readonly', true);
                    $('#misc_exp_per_bag').prop('readonly', true);
                }

                if(rate_pr_kg == ''){
                    rate_pr_kg = 0;
                }else{
                    if(delivery_term == 'FOB'){
                        rate_pr_kg = parseInt(order_rate) / 40;
                    }else{
                        rate_pr_kg = parseInt(order_rate) ;
                    }
                }
            }else{
                delivery_term = $('#delivery_term option:selected').val();
                order_rate = $('#order_rate').val();
                var rate_pr_kg = 0;

                if(delivery_term == 'FOB'){
                    rate_pr_kg = parseInt(order_rate) / 40;
                }else{
                    rate_pr_kg = parseInt(order_rate);
                }
            }

            $('#rate_per_kg').val(parseInt(rate_pr_kg));
        }

        function po_amount_calculate() {
            var total_amount = 0;
            var total = 0;
            var rate = 0;
            var qty = 0;
            var comission = 0;
            var total_comission = 0;
            var bardana = 0;
            var total_bardana = 0;
            var misc = 0;
            var total_misc = 0;
            var freight = 0;
            var total_freight = 0;
            var landed_rate_per_kg = 0;

            rate = $('#rate_per_kg').val();
            qty = $('#qty_kg2').val();
            comission = $('#commission_per_bag').val() ?? 0;
            bardana = $('#bardana_per_bag').val() ?? 0;
            misc = $('#misc_exp_per_bag').val() ?? 0;
            freight = $('#freight_per_traller').val() ?? 0;

            total = parseInt(rate) * parseInt(qty);

            if(parseInt(comission) > 0){
                total_comission = parseInt(comission) * parseInt(qty) / 100;
            }

            if(parseInt(bardana) > 0){
                total_bardana = parseInt(bardana) * parseInt(qty) / 100;
            }

            if(parseInt(misc) > 0){
                total_misc = parseInt(misc) * parseInt(qty) / 100;
            }

            if(parseInt(freight) > 0){
                total_freight = parseInt(freight) * parseInt(qty);
            }

            total_amount = parseInt(total) + parseInt(total_comission) + parseInt(total_bardana) + parseInt(total_misc) + parseInt(total_freight);

            $('#po_amount').val(formatCurrency(total_amount));
            amount(total_amount);
            landed_rate_per_kg = parseFloat(total_amount) / parseInt(qty);



            $('#landed_rate_per_kg').val(parseFloat(landed_rate_per_kg).toFixed(2));
            

            

        }

        function formatCurrency(amount) {
            return amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

    </script>
    <script>

        var th = ['','thousand','million', 'billion','trillion'];
        var dg = ['zero','one','two','three','four', 'five','six','seven','eight','nine'];
        var tn = ['ten','eleven','twelve','thirteen', 'fourteen','fifteen','sixteen', 'seventeen','eighteen','nineteen'];
        var tw = ['twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];
    
        function amount(s) {
    
           
            s = s.toString();
            s = s.replace(/[\, ]/g,'');
            if (s != parseFloat(s)) return 'not a number';
            var x = s.indexOf('.');
            if (x == -1)
                x = s.length;
            if (x > 15)
                return 'too big';
            var n = s.split('');
            var str = '';
            var sk = 0;
            for (var i=0;   i < x;  i++) {
                if ((x-i)%3==2) {
                    if (n[i] == '1') {
                        str += tn[Number(n[i+1])] + ' ';
                        i++;
                        sk=1;
                    } else if (n[i]!=0) {
                        str += tw[n[i]-2] + ' ';
                        sk=1;
                    }
                } else if (n[i]!=0) { // 0235
                    str += dg[n[i]] +' ';
                    if ((x-i)%3==0) str += 'hundred ';
                    sk=1;
                }
                if ((x-i)%3==1) {
                    if (sk)
                        str += th[(x-i-1)/3] + ' ';
                    sk=0;
                }
            }
    
            if (x != s.length) {
                var y = s.length;
                str += 'point ';
                for (var i=x+1; i<y; i++)
                    str += dg[n[i]] +' ';
            }
             var v=str.replace(/\s+/g,' ');
            $('#rupees').text(v);
        }
    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
