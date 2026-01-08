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
                                        <span class="subHeadingLabelClass">Rice Analysis and Inspection Report (Final)</span>
                                    </div>
                                </div>

                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form action="{{ route('finalinspection.store') }}" method="post"
                                                          id="yourFormId2">




                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">





                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>PO No :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="po_no" id="po_no"
                                                                        class="form-control requiredFieldbkk select2 requiredFieldbkk" onchange="get_second_inspection(this.value,2);">
                                                                    <option value="">Select Po</option>
                                                                    @foreach (CommonHelper::get_all_balance_pos() as $key => $y)
                                                                        <option value="{{ $y->voucher_no }}"
                                                                                {{ old('po_no') == $y->voucher_no ? 'selected' : '' }}>
                                                                            {{ $y->voucher_no }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Inspection No :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="first_ins_no"  id="inspection_no" onchange= " getChecklist(this.value);getProductDescription(this.value);get_Po_Details(this.value);"
                                                                        class="form-control requiredFieldbkk select2 requiredFieldbkk"
                                                                >
                                                                    <option value="">Select Inspection No</option>

                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Date:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" name="date" id="date"
                                                                       value="{{ old('date') ?? date('Y-m-d') }}"
                                                                       class="form-control requiredFieldbkk" />
                                                            </div>
                                                            {{--                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">--}}
                                                            {{--                                                                <label>First Inspection No.</label>--}}
                                                            {{--                                                                <span class="rflabelsteric"><strong>*</strong></span>--}}
                                                            {{--                                                                <input type="text" name="first_ins_no" id="first_ins_no" readonly--}}
                                                            {{--                                                                       value="{{old('first_ins_no')}}"--}}
                                                            {{--                                                                       class="form-control requiredFieldbkk" />--}}
                                                            {{--                                                            </div>--}}
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Gate Pass In No.</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="" id="gate_pass_no" readonly
                                                                       value=""
                                                                       class="form-control requiredFieldbkk" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Weighbridges No.</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="" id="weighbridge_no" readonly
                                                                       value=""
                                                                       class="form-control requiredFieldbkk" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Lot / Truck No.</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="truck_no" id="truck_no" readonly
                                                                       value="{{ old('truck_no')}}"
                                                                       class="form-control requiredFieldbkk" />
                                                            </div>
                                                        </div>
                                                        <div class="row" style="">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Variety/Product Description</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="product_description" readonly id="product_description"
                                                                       value="{{ old('product_description')}}"
                                                                       class="form-control requiredFieldbkk" />
                                                            </div>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Name of Seller/Customer</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="customer_id" id="customer_id"
                                                                        class="form-control requiredFieldbkk select2 requiredFieldbkk"
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
                                                                       value="{{ old('voucher_date') }}" readonly
                                                                       class="form-control requiredFieldbkk" />
                                                            </div>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>PP Bags</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="pp_bags_id" id="pp_bags_id"
                                                                        class="form-control requiredFieldbkk select2 requiredFieldbkk"
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
                                                                <input type="number" name="jute_bags" readonly
                                                                       id="jute_bags"
                                                                       value="{{ old('jute_bags') }}"
                                                                       class="form-control requiredFieldbkk" />
                                                            </div>
                                                            {{--                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">--}}
                                                            {{--                                                                <label>Shipment Origin</label>--}}
                                                            {{--                                                                <span class="rflabelsteric"><strong>*</strong></span>--}}
                                                            {{--                                                                <input type="text" name="shipment_origin" readonly--}}
                                                            {{--                                                                       id="shipment_origin"--}}
                                                            {{--                                                                       value="{{ old('shipment_origin') }}"--}}
                                                            {{--                                                                       class="form-control requiredFieldbkk" />--}}
                                                            {{--                                                            </div>--}}

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Bilty Number</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="bilty_no" readonly
                                                                       id="bilty_no"
                                                                       value="{{ old('bilty_no') }}"
                                                                       class="form-control requiredFieldbkk" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Bilty Date</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" name="bilty_date" id="bilty_date" readonly
                                                                       value="{{ old('bilty_date') ?? date('Y-m-d') }}"
                                                                       class="form-control requiredFieldbkk"  />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Consignee Weight (kg)</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="number" name="consignee_weight"
                                                                       id="consignee_weight" readonly
                                                                       value="{{ old('consignee_weight') }}"
                                                                       class="form-control requiredFieldbkk" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Vehicle Driver’s Name</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="driver_name"
                                                                       id="driver_name" readonly
                                                                       value="{{ old('driver_name') }}"
                                                                       class="form-control requiredFieldbkk" />
                                                            </div>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Transporter Name</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="transporter_name"
                                                                       id="transporter_name" readonly
                                                                       value="{{ old('transporter_name') }}"
                                                                       class="form-control requiredFieldbkk" />
                                                            </div>
                                                        </div>
                                                        <div class="" id="AppnedHtml"></div>
                                                        <div class="" id="AppnedHtml2"></div>




                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Analysed and Inspected By</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="inspect_by"
                                                                       id="inspect_by"
                                                                       required
                                                                       readonly
                                                                       value="{{Auth::user()->name}}"
                                                                       class="form-control requiredFieldbkk" />
                                                            </div>
                                                        </div>
                                                        {{-- <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Overall product status found satisfactory</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <label for="">
                                                                    <input type="radio" name="satisfactory_status"
                                                                           value="1"
                                                                           checked
                                                                           class="form-control requiredFieldbkk" />
                                                                    <span>Yes</span>
                                                                </label>
                                                                <label for="">
                                                                    <input type="radio" name="satisfactory_status"
                                                                           value="0"
                                                                           class="form-control requiredFieldbkk" />
                                                                    <span>No</span>
                                                                </label>
                                                            </div>
                                                        </div> --}}
                                                        {{--                                                        <div class="row">--}}
                                                        {{--                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">--}}
                                                        {{--                                                                <label>Corrective Action (CAR)</label>--}}
                                                        {{--                                                                <span class="rflabelsteric"><strong>*</strong></span><br>--}}
                                                        {{--                                                                <label for="corrective_action_reject">--}}
                                                        {{--                                                                    <input type="radio" name="corrective_action" id="corrective_action_reject"--}}
                                                        {{--                                                                           value="1" checked required class="requiredFieldbkk" />--}}
                                                        {{--                                                                    <span>Reject</span>--}}
                                                        {{--                                                                </label>--}}
                                                        {{--                                                                <label for="corrective_action_use_as_is">--}}
                                                        {{--                                                                    <input type="radio" name="corrective_action" id="corrective_action_use_as_is"--}}
                                                        {{--                                                                           value="0" required class="requiredFieldbkk" />--}}
                                                        {{--                                                                    <span>Use as it is</span>--}}
                                                        {{--                                                                </label>--}}
                                                        {{--                                                            </div>--}}
                                                        {{--                                                        </div>--}}
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <label>Re-work Details / Action Taken</label>
                                                                <textarea type="number" name="justification"
                                                                          id="justification"
                                                                          class="form-control requiredFieldbkk" >{{ old('justification') }}</textarea>
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

        function getProductDescription(id) {
            var po_no = $('#po_no option:selected').val();
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/getProductDescriptionForFinal/' + id,
                type: 'Get',
                data: {
                    po_no: po_no
                },
                success: function(response) {
                    console.log(response);
                    $('#product_description').val(response.name);
                    $('#truck_no').val(response.truck_no);
                    $('#customer_id').val(response.customer_id);
                    $('#customer_id').trigger('change');
                    $('#no_of_bags').val(response.no_of_bags);
                    $('#pp_bags_id').val(response.pp_bags_id);
                    $('#pp_bags_id').trigger('change');
                    $('#jute_bags').val(response.jute_bags);
                    $('#shipment_origin').val(response.shipment_origin);
                    $('#bilty_no').val(response.bilty_no);
                    $('#bilty_date').val(response.bilty_date);
                    $('#consignee_weight').val(response.consignee_weight);
                    $('#driver_name').val(response.driver_name);
                    $('#transporter_name').val(response.transporter_name);
                    $('#inspect_by').val(response.inspect_by);
                    $('#satisfactory_status').val(response.satisfactory_status);
                    $('input[name="corrective_action"]').val(response.corrective_action);
                    $('#justification').val(response.justification);
                    // $('#first_ins_no').val(response.ins_no);
                    $('#gate_pass_no').val(response.gate_pass_no);
                    $('#weighbridge_no').val(response.weighbridge_no);



                }
            });
        }

        function getChecklist(id) {

            var po_no = $('#po_no option:selected').val();
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/getChecklistFinal/' + id,
                type: 'Get',
                data: {
                    po_no: po_no
                },
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
                                class="form-control requiredFieldbkk select2"
                                onchange="getProductSlabsDetail()">
                            </select>
                    </td>
                    <td>
                        <select name="delivery_mode" id="delivery_mode"
                            class="form-control requiredFieldbkk select2">
                            <option value="">Select Delivery Term</option>
                            <option value="1">Trallers</option>
                            <option value="2">Truck</option>
                            <option value="3">Bags</option>
                            <option value="4">Katta</option>
                            <option value="5">KG</option>
                        </select>
                    </td>
                    <td><input type="number"
                            class="form-control requiredFieldbkk " name="qty"
                            id="qty${counter}" onkeyup="calculate(${counter})" value="">
                    </td>
                    <td ><input type="number"
                            class="form-control requiredFieldbkk" name="order_rate"
                            id="rate${counter}" onkeyup="calculate(${counter})" value="">
                    </td>
                    <td ><input type="text"
                            class="form-control requiredFieldbkk" name="po_amount"
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

        function calculate(id) {
            var qty = $('#qty'+ id).val();
            var rate = $('#rate'+ id).val();

            var total = qty * rate;

            if(qty == '' || rate == ''){
                total = 0;
            }
            $('#total' + id).val(total.toFixed(2))
        }

        {{--function get_Po_Details(ins_no){--}}
        {{--    $.ajax({--}}
        {{--        url: '{{ route('get_Po_Details') }}',--}}
        {{--        type: 'Get',--}}
        {{--        data: {--}}
        {{--            ins_no: ins_no--}}
        {{--        },--}}
        {{--        success: function(response) {--}}
        {{--            $('#AppnedHtml2').html(response);--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}
        function get_Po_Details(ins_no) {
            $('#AppnedHtml2').html('');

            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we fetch the details',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: function() {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '{{ route('get_Po_Details') }}',
                type: 'GET',
                data: {
                    ins_no: ins_no
                },
                success: function(response) {
                    $('#AppnedHtml2').html(response);
                    Swal.close();  // Close the Swal loader
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to fetch PO details',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
