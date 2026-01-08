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
                                        <span class="subHeadingLabelClass">Rice Analysis and Inspection Report</span>
                                    </div>
                                </div>

                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form action="{{ route('inspection.store') }}" method="post"
                                                          id="accommodiatiesProduct">




                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">





                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>PO No.</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select getProductDescription(this.value)" name="po_id" id="po_id"
                                                                        class="form-control requiredField select2 requiredField"
                                                                >
                                                                    <option value="">Select PO</option>
                                                                    @foreach ($purcahseOrder as $key => $y)
                                                                        <option value="{{ $y->id }}"
                                                                                {{ old('po_id') == $y->id ? 'selected' : '' }}>
                                                                            {{ $y->voucher_no }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>


                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Inspection No:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="ins_no" readonly
                                                                       id="ins_no" value="{{ $insno }}"
                                                                       class="form-control requiredField" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Date:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" name="date" id="date"
                                                                       value="{{ old('date') ?? date('Y-m-d') }}"
                                                                       class="form-control requiredField" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Lot / Truck No.</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="truck_no" id="truck_no"
                                                                       value="{{ old('truck_no')}}"
                                                                       class="form-control requiredField" />
                                                            </div>
                                                        </div>
                                                        <div class="row" style="">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Variety/Product Description</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="product_description" readonly id="product_description"
                                                                       value="{{ old('product_description')}}"
                                                                       class="form-control requiredField" />
                                                            </div>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Name of Seller/Customer</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="customer_id" id="customer_id"
                                                                        class="form-control requiredField select2 requiredField"
                                                                >
                                                                    <option value="">Select Customer</option>
                                                                    @foreach ($customers as $key => $y)
                                                                        <option value="{{ $y->id }}"
                                                                                {{ old('customer_id') == $y->id ? 'selected' : '' }}>
                                                                            {{ $y->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>


                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Number of Bags</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="no_of_bags" id="no_of_bags"
                                                                       value="{{ old('voucher_date') }}"
                                                                       class="form-control requiredField" />
                                                            </div>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>PP Bags</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="pp_bags_id" id="pp_bags_id"
                                                                        class="form-control requiredField select2 requiredField"
                                                                >
                                                                    <option value="">Select PP Bags</option>
                                                                    @foreach ($printingBags as $key => $y)
                                                                        <option value="{{ $y->id }}"
                                                                                {{ old('pp_bags_id') == $y->id ? 'selected' : '' }}>
                                                                            {{ $y->printing_bags }} - {{ $y->bag_weight }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Jute Bags 100kg</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="jute_bags"
                                                                       id="jute_bags"
                                                                       value="{{ old('jute_bags') }}"
                                                                       class="form-control requiredField" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Shipment Origin</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="shipment_origin"
                                                                       id="shipment_origin"
                                                                       value="{{ old('shipment_origin') }}"
                                                                       class="form-control requiredField" />
                                                            </div>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Bilty Number</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="bilty_no"
                                                                       id="bilty_no"
                                                                       value="{{ old('bilty_no') }}"
                                                                       class="form-control requiredField" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Bilty Date</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" name="bilty_date" id="bilty_date"
                                                                       value="{{ old('bilty_date') ?? date('Y-m-d') }}"
                                                                       class="form-control requiredField"  />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Consignee Weight (kg)</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="consignee_weight"
                                                                       id="consignee_weight"
                                                                       value="{{ old('consignee_weight') }}"
                                                                       class="form-control requiredField" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Vehicle Driver’s Name</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="driver_name"
                                                                       id="driver_name"
                                                                       value="{{ old('driver_name') }}"
                                                                       class="form-control requiredField" />
                                                            </div>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Transporter Name</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="transporter_name"
                                                                       id="transporter_name"
                                                                       value="{{ old('transporter_name') }}"
                                                                       class="form-control requiredField" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                        <tr class="bg-primary" >
                                                                            <th  class="bg-primary"  >
                                                                                Particulars
                                                                            </th>
                                                                            <th class="bg-primary" >First Report</th>
                                                                            <th class="bg-primary" >Action</th>
                                                                        </tr>
                                                                        </thead>

                                                                        <tbody id="AppnedHtml">
                                                                        <tr>
                                                                            <th colspan="3" style="width: 100%" >
                                                                                <div class="alert alert-warning">
                                                                                    No record found
                                                                                </div>
                                                                            </th>
                                                                        </tr>
                                                                        </tbody>


                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Analysed and Inspected By</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="inspect_by"
                                                                       id="inspect_by"
                                                                       required
                                                                       value="{{ old('inspect_by') }}"
                                                                       class="form-control requiredField" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Overall product status found satisfactory</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <label for="">
                                                                    <input type="radio" name="satisfactory_status"
                                                                           value="1"
                                                                           checked
                                                                           class="form-control requiredField" />
                                                                    <span>Yes</span>
                                                                </label>
                                                                <label for="">
                                                                    <input type="radio" name="satisfactory_status"
                                                                           value="0"
                                                                           class="form-control requiredField" />
                                                                    <span>No</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Corrective Action (CAR)</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span><br>
                                                                <label for="corrective_action_reject">
                                                                    <input type="radio" name="corrective_action" id="corrective_action_reject"
                                                                           value="1" checked required class="requiredField" />
                                                                    <span>Reject</span>
                                                                </label>
                                                                <label for="corrective_action_use_as_is">
                                                                    <input type="radio" name="corrective_action" id="corrective_action_use_as_is"
                                                                           value="0" required class="requiredField" />
                                                                    <span>Use as it is</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <label>Re-work Details / Action Taken</label>
                                                                <textarea type="number" name="justification"
                                                                          id="justification"
                                                                          class="form-control requiredField" >{{ old('justification') }}</textarea>
                                                            </div>
                                                        </div>



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
        $('.select2').select2();

        $(document).ready(function() {
            getChecklist();
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

        function getProductDescription(id) {
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/getProductDescription/' + id,
                type: 'Get',
                success: function(response) {
                    $('#product_description').val(response);

                }
            });
        }

        function getChecklist() {
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/getChecklist',
                type: 'Get',
                success: function(response) {
                    $('#AppnedHtml').html(response);

                }
            });
        }

        function getproduct(id) {
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/getproduct/' + id,
                type: 'Get',
                success: function(response) {
                    $('#product_id').html('');
                    $('#product_id').append(new Option('Select product', ''))
                    $.each(response, function(index, element) {
                        $('#product_id').append(
                            `<option value="${element['id']}" data-cropbased="${element['crop_based']}">${element['name']}</option>`
                        )
                    });
                }
            });
        }

        function getVoucherNo() {
            let sub_category_id = $('#sub_category_id');
            let crop_based_id = $('#crop_based_id');

            // if (sub_category_id.find(':selected').data('cropbased') == 1) {
            //     crop_based_id.select2({
            //         disabled: ''
            //     });
            //     if (crop_based_id.val() == '' || sub_category_id.val() == '') {
            //         // alert(product_id);
            //         $('#voucher_no').val('');
            //         return;
            //     }
            // } else {
            //     crop_based_id.select2({
            //         disabled: 'readonly'
            //     });
            // }
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/getVoucherNo',
                type: 'Get',
                data: {
                    product_id: sub_category_id.val(),
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

        var counter = 0;
        function AddMoreDetails() {
            counter++;
            if(counter == 1){
                $('#AppnedHtml').append(
                    `<tr class="cnt" id="removeSection${counter}">

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
                            <option value="1">Trallers</option>
                            <option value="2">Truck</option>
                            <option value="3">Bags</option>
                            <option value="4">Katta</option>
                            <option value="5">KG</option>
                        </select>
                    </td>
                    <td><input type="number"
                            class="form-control requiredField " name="qty"
                            id="qty${counter}" onkeyup="calculate(${counter})" value="">
                    </td>
                    <td ><input type="number"
                            class="form-control requiredField" name="order_rate"
                            id="rate${counter}" onkeyup="calculate(${counter})" value="">
                    </td>
                    <td ><input type="text"
                            class="form-control requiredField" name="po_amount"
                            id="total${counter}" readonly value="">
                    </td>
                    <td><button class="btn btn-danger btn-xs" onClick="removeSection(${counter})">Remove</button>
                    </td>
                </tr>`
                );
            }


            var id = $('#sub_category_id').val();
            getproduct(id)

        }

        function removeSection(id) {
            $('#removeSection' + id).remove();
            calculate();
        }

    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
