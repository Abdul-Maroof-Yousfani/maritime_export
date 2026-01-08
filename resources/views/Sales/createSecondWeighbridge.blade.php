<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
use App\ArrivalWeighbridge;
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
                                        <span class="subHeadingLabelClass">Create Second Weighbridge</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form enctype="multipart/form-data" action="{{ route('secondweighbridge.store') }}" method="post"
                                                          id="yourFormId2" >
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>PO No :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="po_no" id="po_no"
                                                                        class="form-control requiredFieldbkk select2 requiredFieldbkk"
                                                                        onchange="get_inspection_no(this.value,'arrival_weighbridges','2')"
                                                                >
                                                                    <option value="">Select Po</option>
                                                                    @foreach (CommonHelper::get_all_balance_pos() as $key => $y)
                                                                        <option value="{{ $y->voucher_no }}"
                                                                                data-product_id="{{$y->product_id}}"
                                                                                {{ old('po_no') == $y->voucher_no ? 'selected' : '' }}>
                                                                            {{ $y->voucher_no }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Inspection No :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="inspection_no" id="inspection_no" onchange="get_product(); get_gate_pas();"
                                                                        class="form-control requiredFieldbkk select2 requiredFieldbkk"
                                                                >
                                                                    <option value="">Select Inspection No</option>

                                                                </select>
                                                            </div>


                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Gate Pass In :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="gate_pass_no" id="gate_pass_no"
                                                                        class="form-control requiredFieldbkk select2 requiredFieldbkk" onchange="get_details()">
                                                                    <option value="">Select Gate Pass No</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Weighbridge No:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="weighbridge_no" readonly
                                                                       id="get_pass_no" value="{{ CommonHelper::getProductionFormat(ArrivalWeighbridge::class,'WBR-2-') }}"
                                                                       class="form-control requiredFieldbkk" />
                                                            </div>




                                                        </div>
                                                        <hr>
                                                        <div class="row" style="">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Date:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input readonly type="text" name="date" id="date"
                                                                       value="{{ old('date') ?? date('Y-m-d') }}"
                                                                       class="form-control requiredFieldbkk" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Customer:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input readonly type="text" name="customer_name"
                                                                       id="customer_name" value=""
                                                                       class="form-control requiredFieldbkk" />
                                                            </div>
                                                            <input type="text" class="hide" name="type" value="2">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Vehicle No:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input readonly type="text" name="vehicle_no"
                                                                       id="vehicle_no" value=""
                                                                       class="form-control requiredFieldbkk" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Consignee Weight (kg)</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input readonly type="text" name="consignee_weight"
                                                                       id="consignee_weight" value=""
                                                                       class="form-control requiredFieldbkk" />
                                                            </div>
                                                            {{--                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">--}}
                                                            {{--                                                                <label>Shipment Origin:</label>--}}
                                                            {{--                                                                <span class="rflabelsteric"><strong>*</strong></span>--}}
                                                            {{--                                                                <input readonly type="text" name="shipment_origin" --}}
                                                            {{--                                                                    id="shipment_origin" value=""--}}
                                                            {{--                                                                    class="form-control requiredFieldbkk" />--}}
                                                            {{--                                                            </div>--}}
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Cosec No:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input readonly type="text" name="cosec_no"
                                                                       id="cosec_no" value=""
                                                                       class="form-control requiredFieldbkk" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Cosec No:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                            <select name="location_id" disabled id="location_id" class="form-control requiredFieldbkk select2">
                                                  
                                                                        <!-- Parent option -->
                                                                        <option   value="">Select Location</option>
                                                                        <option  disabled value=""></option>
                                                                      
                                                                  
                                                            </select>
                                                            </div>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Attacmnet</label>
                                                                <input type="file" id="attachment" name="attachment" class="form-control">
                                                            </div>
                                                            {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Location:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span> --}}
                                                                {{--                                                                <select name="inspection_no" id="inspection_no" onchange="get_product(); get_gate_pas();"--}}
                                                                {{--                                                                    class="form-control requiredFieldbkk select2 requiredFieldbkk"--}}
                                                                {{--                                                                    >--}}
                                                                {{--                                                                    <option value="">Select Inspection No</option>--}}

                                                                {{--                                                                </select>--}}
                                                                {{-- <select name="location_id" id="location_id" class="form-control requiredFieldbkk select2">
                                                                  
                                                                </select>
                                                            </div>


                                                        </div> --}}
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Description:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <textarea class="form-control" name="description" id="description" ></textarea>
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
                                                                                No of Pkgs</th>
                                                                            <th  style="width: 20%;" class="text-center">Description Of Goods </th>
                                                                        
                                                                            <th class="text-center">Gross Weight</th>
                                                                            <th class="text-center">Crop Weight</th>
                                                                            <th class="text-center">Net Weight</th>
                                                                            {{--                                                                            <th class="text-center">Recived Rs</th>--}}

                                                                        </tr>
                                                                        </thead>

                                                                        <tbody id="AppnedHtml">
                                                                        <tr class="cnt" id="removeSection1">

                                                                            <td>
                                                                                <input readonly type="number"
                                                                                       class="form-control requiredFieldbkk " name="no_of_pkgs"
                                                                                       id="no_of_pkgs"  value="">
                                                                            </td>
                                                                            <td><textarea readonly type="text"
                                                                                          class="form-control requiredFieldbkk" name="goods_description"
                                                                                          id="goods_description" ></textarea>
                                                                            </td>
                                                                            <td><input readonly type="number"
                                                                                       class="form-control requiredFieldbkk " name="gross_weight"
                                                                                       id="gross_weight" value="">
                                                                            </td>
                                                                            <td><input type="number" onkeyup="net_weight_calc(this.value)"
                                                                                       class="form-control requiredFieldbkk " name="crop_weight"
                                                                                       id="crop_weight" value="">
                                                                            </td>
                                                                            <td><input readonly type="number"
                                                                                       class="form-control requiredFieldbkk " name="net_weight"
                                                                                       id="net_weight" value="">
                                                                            </td>
                                                                            {{--                                                                                <td><input type="number"--}}
                                                                            {{--                                                                                    class="form-control requiredFieldbkk " name="amount_recived"--}}
                                                                            {{--                                                                                    id="first_weight" value="">--}}
                                                                            {{--                                                                                </td>--}}


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
        //     $('#product_id').select2({
        //         disabled : 'readonly'
        //     });
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
        //                 // $('.btn-success').prop('disabled', true);
        //                 $("form").submit();
        //                 //return false;
        //             } else {
        //                 return false;
        //             }
        //         }
        //     });
        // });


        function get_product() {
            var id = $('#inspection_no option:selected').val();
            var po_no = $('#po_no option:selected').val();
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/get_webridge/' + id,
                type: 'Get',
                success: function(response) {
                   
                    $.each(response, function(index, element) {
                    
                        $('#gross_weight').val(element['gross_weight']);
                        $('#no_of_pkgs').val(element['no_of_pkgs']);
                        $('#goods_description').val(element['goods_description']);
                        $('#cosec_no').val(element['cosec_no']);
                        $('#description').val(element['description']);
                        $('#date').val(element['date']);
                        $('#description').text(element['description']);
                        $('#location_id').val(element['location_id']).trigger('change'); // assuming the response has 'location' and 'location_select' is the select's ID


                    });
                }
            });
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/get_po_product/' + id,
                type: 'Get',
                success: function(response) {
                    $('#product_id').html('');
                    $('#product_id').select2({
                        disabled : 'readonly'
                    });
                    $.each(response, function(index, element) {
                        $('#product_id').append(
                            `<option value="${element['id']}" data-cropbased="${element['crop_based']}">${element['name']}</option>`
                        )



                        var qty = $('#inspection_no option:selected').data('qty');
                        var recived_qty = $('#inspection_no option:selected').data('recived_qty');
                        var bilty_no = $('#inspection_no option:selected').data('bilty_no');
                        var driver_name = $('#inspection_no option:selected').data('driver_name');
                        var transporter_name = $('#inspection_no option:selected').data('transporter_name');
                        var ins_no = $('#inspection_no option:selected').data('ins_no');
                        var vehicle_no = $('#inspection_no option:selected').data('vehicle_no');
                        var consignee_weight = $('#inspection_no option:selected').data('consignee_weight');
                        $('#total_qty').val(qty);
                        $('#recived_qty').val(recived_qty);
                        $('#driver_name').val(driver_name);
                        $('#transporter_name').val(transporter_name);
                        $('#builty_no').val(bilty_no);
                        $('#vehicle_no').val(vehicle_no);
                        $('#consignee_weight').val(consignee_weight);

                    });
                }
            });
        }



        function net_weight_calc(val) {



            // var customer_name = $('#gate_pass_no option:selected').data('customer_name');
            // var consignee_weight = $('#gate_pass_no option:selected').data('consignee_weight');
            // var vehicle_no = $('#gate_pass_no option:selected').data('vehicle_no');
            // var shipment_origin = $('#gate_pass_no option:selected').data('shipment_origin');
            // var ins_no = $('#gate_pass_no option:selected').data('ins_no');
            // $('#customer_name').val(customer_name);
            // $('#consignee_weight').val(consignee_weight);
            // $('#vehicle_no').val(vehicle_no);
           var gross = $('#gross_weight').val();
           var net = parseInt(gross) - parseInt(val);
            $('#net_weight').val(net);
        }

        function get_details() {
            var customer_name = $('#gate_pass_no option:selected').data('customer_name');
            var consignee_weight = $('#gate_pass_no option:selected').data('consignee_weight');
            var vehicle_no = $('#gate_pass_no option:selected').data('vehicle_no');
            var shipment_origin = $('#gate_pass_no option:selected').data('shipment_origin');
            var ins_no = $('#gate_pass_no option:selected').data('ins_no');
            $('#customer_name').val(customer_name);
            $('#consignee_weight').val(consignee_weight);
            $('#vehicle_no').val(vehicle_no);
            $('#inspection_no').val(ins_no);
        }

        function get_gate_pas() {
            var id = $('#inspection_no option:selected').val();
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/second_weighbridge/create?id='+id,
                type: 'Get',
                success: function(response) {
                    $('#gate_pass_no').html('');
                    $('#gate_pass_no').append(new Option('Select Gate Pass No', ''))
                    $.each(response.gate_pass, function(index, element) {
                        $('#gate_pass_no').append(
                            `<option value="${element['gate_pass_no']}"  data-ins_no="${element['ins_no']}" data-customer_name="${element['customer_name']}" data-consignee_weight="${element['consignee_weight']}" data-vehicle_no="${element['vehicle_no']}" data-shipment_origin="${element['shipment_origin']}" >${element['gate_pass_no']}</option>`
                        )
                    });
                }
            });
        }








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
    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
