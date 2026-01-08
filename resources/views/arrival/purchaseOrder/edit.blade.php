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
                                        <span class="subHeadingLabelClass">Edit Purchase Order</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form action="{{ route('purchase_order.update' , $purchaseOrder->id) }}" method="post"
                                                        id="accommodiatiesProduct">
                                                        <input type="hidden" name="_method" value="PUT">
                                                        {{ csrf_field() }}
                                                        @if ($errors->any())
                                                            <div class="alert alert-danger">
                                                                <ul>
                                                                    @foreach ($errors->all() as $error)
                                                                        <li>{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Category :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="category_id" id="category_id"
                                                                    class="form-control requiredField select2 requiredField"
                                                                    onchange="getSubcategory(this.value)">
                                                                    <option value="">Select Category</option>
                                                                    @foreach ($categories as $key => $y)
                                                                        <option value="{{ $y->id }}"
                                                                            {{ $purchaseOrder->category_id == $y->id ? 'selected' : '' }}>
                                                                            {{ $y->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Select Sub Category:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="sub_category_id" id="sub_category_id"
                                                                    class="form-control requiredField select2 requiredField"
                                                                    onchange="getVoucherNo(); getproduct(this.value)">
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Select Crop Based:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="crop_based_id" id="crop_based_id"
                                                                    class="form-control requiredField select2 requiredField" onchange="getVoucherNo()">
                                                                    <option value="">Select Crop Based</option>
                                                                    @foreach ($cropBased as $key => $y)
                                                                        <option value="{{ $y->id }}"
                                                                            {{ $purchaseOrder->crop_based_id == $y->id ? 'selected' : '' }}>
                                                                            {{ date('M-Y', strtotime($y->date_from)) . ' - ' . date('M-Y', strtotime($y->date_to)) }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div disabled class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="sf-label">Select Company Location</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select disabled class="form-control requiredField select2"
                                                                    name="company_location_id" id="company_location_id">
                                                                    <option value="">Select Company Location</option>
                                                                    @foreach ($company_locations as $company_location)
                                                                        <option value="{{ $company_location['id'] }}" {{$purchaseOrder->company_location_id == $company_location['id'] ? 'selected' : ''}}>
                                                                            {{ $company_location['location_name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row" style="">
                                                            
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Voucher Date:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" name="voucher_date" id="voucher_date"
                                                                    value="{{date('Y-m-d', strtotime($purchaseOrder->voucher_date))}}"
                                                                    class="form-control requiredField" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Req Date:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" name="req_date" id="req_date"
                                                                value="{{$purchaseOrder->req_date}}" class="form-control requiredField" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Promise Date:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" name="promise_date" id="promise_date"
                                                                    value="{{$purchaseOrder->promise_date}}"
                                                                    class="form-control requiredField" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Supplier:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="supplier_id" id="supplier_id"
                                                                    class="form-control requiredField select2">
                                                                    <option value="">Select Supplier</option>
                                                                    @foreach (CommonHelper::get_all_supplier() as $Supplier)
                                                                        <option value="{{ $Supplier->id }}" {{ $purchaseOrder->supplier_id == $Supplier->id ? 'selected' : '' }}>
                                                                            {{ $Supplier->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                           
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Agent Name:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="agent_id" id="agent_id"
                                                                    class="form-control requiredField select2">
                                                                    <option value="">Select Agent</option>
                                                                    @foreach (CommonHelper::get_all_supplier() as $Supplier)
                                                                        <option value="{{ $Supplier->id }}"  {{ $purchaseOrder->agent_id == $Supplier->id ? 'selected' : '' }}>
                                                                            {{ $Supplier->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Shipment Origin:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" class="form-control requiredField select2" value="{{$purchaseOrder->delivery_term}}" name="delivery_term" id="delivery_term"/>
                                                                {{-- <select name="delivery_term" id="delivery_term"
                                                                    class="form-control requiredField select2">
                                                                    <option value="">Select Delivery Detail</option>
                                                                    <option value="FOB">FOB</option>
                                                                    <option value="CNF">CNF</option>
                                                                </select> --}}
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Freight Per Traller:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="freight"
                                                                    id="freight_per_traller"
                                                                    value="{{$purchaseOrder->freight}}"
                                                                    class="form-control requiredField" />
                                                            </div>
                                                            {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Delivery Mode:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="delivery_mode" id="delivery_mode"
                                                                    class="form-control requiredField select2">
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
                                                                    class="form-control requiredField select2">
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
                                                                    class="form-control requiredField" />
                                                            </div> --}}
                                                            {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Order Rate:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="order_rate" id="order_rate"
                                                                    value="{{ old('order_rate') }}"
                                                                    class="form-control requiredField" />
                                                            </div> --}}
                                                        </div>

                                                        <div class="lineHeight">&nbsp;</div>
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <label for="">PO Remarks</label>
                                                                <textarea class="form-control" name="remarks" id="remarks" cols="5" rows="5">{{$purchaseOrder->remarks ?? ''}}</textarea>
                                                            </div>
                                                        </div>
                                                        <hr>

                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr class="text-center">
                                                                                <th colspan="3" class="text-center">
                                                                                    Item
                                                                                    Detail</th>
                                                                                <th colspan="2" class="text-center hide">
                                                                                    <input type="button"
                                                                                        class="btn btn-sm btn-primary"
                                                                                        onclick="AddMoreDetails()"
                                                                                        value="Add More Rows" />
                                                                                </th>
                                                                            </tr>
                                                                            <tr>
                                                                                {{-- <th class="text-center"
                                                                                    style="width: 2%;">S.NO
                                                                                </th> --}}
                                                                                <th class="text-center"
                                                                                    style="width: 20%;">
                                                                                    Item Name</th>
                                                                                <th class="text-center">Delivery Mode</th>
                                                                                <th class="text-center">Qty
                                                                                </th>
                                                                                <th class="text-center">Order rate</th>
                                                                                <th class="text-center">
                                                                                   Total
                                                                                </th>
                                                                                <th class="text-center">
                                                                                    Remove
                                                                                 </th>
                                                                            </tr>
                                                                        </thead>
                                                                      
                                                                        <tbody id="AppnedHtml">
                                                                            <tr class="cnt" id="removeSection1">
                    
                                                                                <td>
                                                                                        <select name="product_id" id="product_id"
                                                                                            class="form-control requiredField select2"
                                                                                            onchange="getProductSlabsDetail()">
                                                                                        </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select name="delivery_mode" id="delivery_mode"
                                                                                        class="form-control requiredField select2">
                                                                                        <option value="">Select Delivery Term</option>
                                                                                        <option {{ $purchaseOrder->delivery_mode == '1' ? 'selected' : '' }} value="1">Trallers</option>
                                                                                        <option {{ $purchaseOrder->delivery_mode == '2' ? 'selected' : '' }} value="2">Truck</option>
                                                                                        <option {{ $purchaseOrder->delivery_mode == '3' ? 'selected' : '' }} value="3">Bags</option>
                                                                                        <option {{ $purchaseOrder->delivery_mode == '4' ? 'selected' : '' }} value="4">Katta</option>
                                                                                        <option {{ $purchaseOrder->delivery_mode == '5' ? 'selected' : '' }} value="5">KG</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td><input type="text"
                                                                                        class="form-control requiredField " name="qty"
                                                                                        id="qty1" onkeyup="calculate(1)" value="{{$purchaseOrder->qty}}">
                                                                                </td>
                                                                                <td ><input type="text"
                                                                                        class="form-control requiredField" name="order_rate"
                                                                                        id="rate1" onkeyup="calculate(1)" value="{{$purchaseOrder->order_rate}}">
                                                                                </td>
                                                                                <td ><input type="text"
                                                                                        class="form-control requiredField" name="po_amount"
                                                                                        id="total1" readonly value="{{$purchaseOrder->po_amount}}">
                                                                                </td>
                                                                                <td><span disabled class="btn btn-danger btn-xs" onClick="removeSection({{$key}})">Remove</span>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                        
                                                                       
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="row" id="getProductSlabsDetail">

                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div
                                                                class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                                                {{ Form::submit('Update', ['class' => 'btn btn-success']) }}
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
    <script>
       
        $(document).ready(function() {
            getSubcategory({{$purchaseOrder->category_id}});
            getproduct({{$purchaseOrder->sub_category_id}});
            getProductSlabsDetail();
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


        function getSubcategory(id) {
            var sub_category_id = '{{$purchaseOrder->sub_category_id}}';
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/getsubcategory/' + id,
                type: 'Get',
                success: function(response) {
                    $('#sub_category_id').html('');
                    $('#sub_category_id').append(new Option('Select Sub Category', ''))
                    $.each(response, function(index, element) {
                        var selected =  sub_category_id == element['id'] ? 'selected' : '';
                        $('#sub_category_id').append(
                            `<option value="${element['id']}" ${selected} data-cropbased="${element['crop_based']}">${element['name']}</option>`
                        )
                    });
                }
            });
        }

        function getproduct(id) {
            var product_id = '{{$purchaseOrder->product_id}}';
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/getproduct/' + id,
                type: 'Get',
                success: function(response) {
                    $('#product_id').html('');
                    $('#product_id').append(new Option('Select product', ''))
                    $.each(response, function(index, element) {
                        var selected =  product_id == element['id'] ? 'selected' : '';
                        $('#product_id').append(
                            `<option value="${element['id']}"  ${selected} data-cropbased="${element['crop_based']}">${element['name']}</option>`
                        )
                    });
                }
            });
        }
        

        function getProductSlabsDetail() {
            let product_id = $('#product_id').val();
            if (product_id == '') {
                $('#getProductSlabsDetail').html();
                return;
            }
            $.ajax({
                url: '{{ url('/') }}' + '/commodities/purchase-order/getProductSlabsDetail',
                type: 'Get',
                data: {
                    product_id: product_id
                },
                success: function(response) {
                    // console.log(response);
                    $('#getProductSlabsDetail').html(response);
                }
            });
        };

        function calculate(id) {
           var qty = $('#qty'+ id).val();
           var rate = $('#rate'+ id).val();

           var total = qty * rate;

           if(qty == '' || rate == ''){
             total = 0;
           }
           $('#total' + id).val(total.toFixed(2))
        }
    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
