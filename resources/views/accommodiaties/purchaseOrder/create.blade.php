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
                                        <span class="subHeadingLabelClass">Create Purchase Order</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form action="{{ route('purchase-order.store') }}" method="post"
                                                        id="accommodiatiesProduct">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Category :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="category_id" id="category_id"
                                                                    class="form-control select2"
                                                                    onchange="getCommodityProduct(this.value)">
                                                                    <option value="">Select Category</option>
                                                                    @foreach ($categories as $key => $y)
                                                                        <option value="{{ $y->id }}"
                                                                            {{ old('category_id') == $y->id ? 'selected' : '' }}>
                                                                            {{ $y->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Select Product:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="product_id" id="product_id"
                                                                    class="form-control select2"
                                                                    onchange="getVoucherNo(); getProductSlabsDetail()">
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Select Crop Based:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="crop_based_id" id="crop_based_id"
                                                                    class="form-control select2" onchange="getVoucherNo()">
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
                                                        <div class="row" style="">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Voucher No:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="voucher_no" readonly
                                                                    id="voucher_no" value="{{ old('voucher_no') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Voucher Date:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" name="voucher_date" id="voucher_date"
                                                                    value="{{ old('voucher_date') ?? date('Y-m-d') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Req Date:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" name="req_date" id="req_date"
                                                                    value="{{ old('req_date') }}" class="form-control" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Promise Date:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" name="promise_date" id="promise_date"
                                                                    value="{{ old('promise_date') }}"
                                                                    class="form-control" />
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Party:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="party_id" id="party_id"
                                                                    class="form-control select2">
                                                                    <option value="">Select Party</option>
                                                                    @foreach (CommonHelper::get_all_supplier() as $Supplier)
                                                                        <option value="{{ $Supplier->id }}">
                                                                            {{ $Supplier->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Delivery Terms:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="delivery_term" id="delivery_term"
                                                                    class="form-control select2">
                                                                    <option value="">Select Delivery Term</option>
                                                                    <option value="FOB">FOB</option>
                                                                    <option value="CNF">CNF</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Delivery Mode:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="delivery_mode" id="delivery_mode"
                                                                    class="form-control select2">
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
                                                                    class="form-control select2">
                                                                    <option value="">Select Warehouse</option>
                                                                    @foreach (CommonHelper::get_users_warehouse() as $warehouse)
                                                                        <option value="{{ $warehouse->id }}">
                                                                            {{ $warehouse->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Rate Per KG:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="rate_per_kg" id="rate_per_kg"
                                                                    value="{{ old('rate_per_kg') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Order Rate:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="order_rate" id="order_rate"
                                                                    value="{{ old('order_rate') }}"
                                                                    class="form-control" />
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                        <label>Qty Trallers:</label>
                                                                        <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                        <input type="number" name="qty_trallers"
                                                                            id="qty_trallers"
                                                                            value="{{ old('qty_trallers') }}"
                                                                            class="form-control" />
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                        <label>Traller From :</label>
                                                                        <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                        <input type="text" name="traller_from"
                                                                            id="traller_from"
                                                                            value="{{ old('traller_from') }}"
                                                                            class="form-control" />
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                        <label>Traller To :</label>
                                                                        <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                        <input type="text" name="traller_to"
                                                                            id="traller_to"
                                                                            value="{{ old('traller_to') }}"
                                                                            class="form-control" />
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                        <label>Qty Trucks:</label>
                                                                        <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                        <input type="number" name="qty_truck"
                                                                            id="qty_truck" value="{{ old('qty_truck') }}"
                                                                            class="form-control" />
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                        <label>Truck From :</label>
                                                                        <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                        <input type="text" name="truck_from"
                                                                            id="truck_from"
                                                                            value="{{ old('truck_from') }}"
                                                                            class="form-control" />
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                        <label>Truck To :</label>
                                                                        <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                        <input type="text" name="truck_to"
                                                                            id="truck_to" value="{{ old('truck_to') }}"
                                                                            class="form-control" />
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                        <label>Qty Bags:</label>
                                                                        <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                        <input type="number" name="qty_bag"
                                                                            id="qty_bag" value="{{ old('qty_bag') }}"
                                                                            class="form-control" />
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                        <label>Bag From :</label>
                                                                        <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                        <input type="text" name="bag_from"
                                                                            id="bag_from" value="{{ old('bag_from') }}"
                                                                            class="form-control" />
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                        <label>Bag To :</label>
                                                                        <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                        <input type="text" name="bag_to"
                                                                            id="bag_to" value="{{ old('bag_to') }}"
                                                                            class="form-control" />
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                        <label>Qty KG:</label>
                                                                        <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                        <input type="number" name="qty_kg"
                                                                            id="qty_kg" value="{{ old('qty_kg') }}"
                                                                            class="form-control" />
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                        <label>KG From :</label>
                                                                        <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                        <input type="text" name="kg_from"
                                                                            id="kg_from" value="{{ old('kg_from') }}"
                                                                            class="form-control" />
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                        <label>KG To :</label>
                                                                        <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                        <input type="text" name="kg_to"
                                                                            id="kg_to" value="{{ old('kg_to') }}"
                                                                            class="form-control" />
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                        <label>Qty Katta:</label>
                                                                        <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                        <input type="number" name="qty_katta"
                                                                            id="qty_katta" value="{{ old('qty_katta') }}"
                                                                            class="form-control" />
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                        <label>Katta From :</label>
                                                                        <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                        <input type="text" name="katta_from"
                                                                            id="katta_from"
                                                                            value="{{ old('katta_from') }}"
                                                                            class="form-control" />
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                        <label>Katta To :</label>
                                                                        <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                        <input type="text" name="katta_to"
                                                                            id="katta_to" value="{{ old('katta_to') }}"
                                                                            class="form-control" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Comm Terms:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="comm_term" id="comm_term"
                                                                    class="form-control select2">
                                                                    <option value="">Select Comm Term</option>
                                                                    <option value="Immidate">Immidate</option>
                                                                    <option value="General">General</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Agent:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="agent_id" id="agent_id"
                                                                    class="form-control select2">
                                                                    <option value="">Select Agent</option>
                                                                    @foreach (CommonHelper::get_all_supplier() as $Supplier)
                                                                        <option value="{{ $Supplier->id }}">
                                                                            {{ $Supplier->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Commision P/Bag:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="commision_per_bag"
                                                                    id="commision_per_bag"
                                                                    value="{{ old('commision_per_bag') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Transporter:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="transporter_id" id="transporter_id"
                                                                    class="form-control select2">
                                                                    <option value="">Select Transporter</option>
                                                                    @foreach (CommonHelper::get_all_supplier() as $Supplier)
                                                                        <option value="{{ $Supplier->id }}">
                                                                            {{ $Supplier->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Freight Per Traller:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="freight_per_traller"
                                                                    id="freight_per_traller"
                                                                    value="{{ old('freight_per_traller') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Bardana P/Bag:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="bardana_per_bag"
                                                                    id="bardana_per_bag"
                                                                    value="{{ old('bardana_per_bag') }}"
                                                                    class="form-control" />
                                                            </div><br>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Landed Rate P/KG</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="landed_rate" id="landed_rate"
                                                                    value="{{ old('landed_rate') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>P.O. Amount:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="po_amount" id="po_amount"
                                                                    value="{{ old('po_amount') }}"
                                                                    class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="row" id="getProductSlabsDetail">

                                                        </div>
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
        $('.select2').select2();

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

        function getCommodityProduct(id) {
            $.ajax({
                url: '{{ url('/') }}' + '/commodities/purchase-order/getProduct/' + id,
                type: 'Get',
                success: function(response) {
                    $('#product_id').html('');
                    $('#product_id').append(new Option('Select Product', ''))
                    $.each(response, function(index, element) {
                        $('#product_id').append(
                            `<option value="${element['id']}" data-cropbased="${element['crop_based']}">${element['sku_code']}-${element['name']}</option>`
                        )
                    });
                }
            });
        }

        function getVoucherNo() {
            let product_id = $('#product_id');
            let crop_based_id = $('#crop_based_id');

            if (product_id.find(':selected').data('cropbased') == 1) {
                crop_based_id.select2({
                    disabled: ''
                });
                if (crop_based_id.val() == '' || product_id.val() == '') {
                    // alert(product_id);
                    $('#voucher_no').val('');
                    return;
                }
            } else {
                crop_based_id.select2({
                    disabled: 'readonly'
                });
            }
            $.ajax({
                url: '{{ url('/') }}' + '/commodities/purchase-order/getVoucherNo',
                type: 'Get',
                data: {
                    product_id: product_id.val(),
                    crop_based_id: crop_based_id.val()
                },
                success: function(response) {
                    // console.log(response);
                    $('#voucher_no').val(response[0]);
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
    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
