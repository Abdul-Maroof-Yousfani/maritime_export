<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
use App\ProductionGatePassIn;
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
                                        <span class="subHeadingLabelClass">Create Outward Gate Pass</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form enctype="multipart/form-data" action="{{ route('getpassout.store') }}" method="post"
                                                          id="yourFormId2" >
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                        <div class="row">
                                                            {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>PO No :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="po_no" id="po_no"
                                                                    class="form-control requiredFieldbkbk select2 requiredFieldbkbk"
                                                                    onchange="get_product()"
                                                                    >
                                                                    <option value="">Select Po</option>
                                                                    @foreach ($po_nos as $key => $y)
                                                                    @php
                                                                        $gate_pass = CommonHelper::get_gatepass_by_ins_no($y->first_ins_no);
                                                                        $vehicle_no = $gate_pass->vehicle_no??'--';
                                                                        $arrival_note = $gate_pass->arrival_note??'--';
                                                                    @endphp
                                                                        <option value="{{ $y->voucher_no }}" data-qty="{{$y->qty}}" data-ins_no="{{$y->ins_no}}" data-bilty_no="{{$y->bilty_no}}" data-transporter_name="{{$y->transporter_name}}" data-driver_name="{{$y->driver_name}}" data-product_id="{{$y->product_id}}" data-arrival_note="{{$arrival_note}}" data-vehicle_no="{{$vehicle_no}}"
                                                                            {{ old('po_no') == $y->voucher_no ? 'selected' : '' }}>
                                                                            {{ $y->voucher_no }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div> --}}
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>PO No :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="po_no" id="po_no"
                                                                    class="form-control requiredFieldbkbk select2 requiredFieldbkbk"
                                                                    onchange="get_inspection_no(this.value,'production_get_pass','2')"
                                                                    >
                                                                    <option value="">Select Po</option>
                                                                    @foreach (CommonHelper::get_all_balance_pos() as $key => $y)
                                                                        <option value="{{ $y->voucher_no }}"  data-product_id="{{$y->product_id}}"
                                                                            {{ old('po_no') == $y->voucher_no ? 'selected' : '' }}>
                                                                            {{ $y->voucher_no }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Inspection No :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="inspection_no" id="inspection_no" onchange="get_product()"
                                                                    class="form-control requiredFieldbkbk select2 requiredFieldbkbk"
                                                                    >
                                                                    <option value="">Select Inspection No</option>
                            
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Gate Pass No:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="gate_pass_no" readonly
                                                                    id="gate_pass_no" value="{{CommonHelper::getProductionFormat(ProductionGatePassIn::class,'GOUT-') }}"
                                                                    class="form-control requiredFieldbkbk" />
                                                            </div>
                                                            <input type="hidden" name="type" value="2">
                                                           
                                                            
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Date:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" name="date" id="date"
                                                                    value="{{ old('date') ?? date('Y-m-d') }}"
                                                                    class="form-control requiredFieldbkbk" />
                                                            </div>
                                                           
                                                            
                                                        </div>
                                                        <hr>
                                                        <div class="row" style="">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Builty No:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input readonly type="text" name="builty_no" 
                                                                    id="builty_no" value=""
                                                                    class="form-control requiredFieldbkbk" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Vehicle No:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="vehicle_no" 
                                                                    id="vehicle_no" value=""
                                                                    class="form-control requiredFieldbkbk" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Transporter Name:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input readonly type="text" name="transporter_name" 
                                                                    id="transporter_name" value=""
                                                                    class="form-control requiredFieldbkbk" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Driver Name:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input readonly type="text" name="driver_name" 
                                                                    id="driver_name" value=""
                                                                    class="form-control requiredFieldbkbk" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Driver Number:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input readonly type="text" name="driver_number" 
                                                                    id="driver_number" value=""
                                                                    class="form-control requiredFielbk" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Arrival Note:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="arrival_note" 
                                                                    id="arrival_note" value=""
                                                                    class="form-control requiredFieldbkbk" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Attacmnet</label>
                                                                <input type="file" id="attachment" name="attachment" class="form-control">
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
                                                                                <th class="text-center">Total Qty </th>
                                                                                <th class="text-center">Recived Qty
                                                                                </th>
                                                                                <th class="text-center">Description</th>
                                                                               
                                                                            </tr>
                                                                        </thead>
                                                                      
                                                                        <tbody id="AppnedHtml">
                                                                            <tr class="cnt" id="removeSection1">
                    
                                                                                <td>
                                                                                        <select disabled name="product_id" id="product_id"
                                                                                            class="form-control requiredFieldbkbk select2"
                                                                                            onchange="getProductSlabsDetail()">
                                                                                        </select>
                                                                                </td>
                                                                                <td><input type="number"
                                                                                        class="form-control requiredFieldbkbk " disabled name="total_qty"
                                                                                        id="total_qty"  value="">
                                                                                </td>
                                                                                <td><input readonly type="number"
                                                                                        class="form-control requiredFieldbkbk " name="recived_qty"
                                                                                        id="qty1" value="">
                                                                                </td>
                                                                                <td ><textarea type="text"
                                                                                        class="form-control requiredFieldbkbk" name="description"
                                                                                        id="rate1" ></textarea>
                                                                            
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
        //                 $('.btn-success').prop('disabled', true);
        //                 $("form").submit();
        //                 //return false;
        //             } else {
        //                 return false;
        //             }
        //         }
        //     });
        // });

        function get_product() {
            var id = $('#po_no option:selected').data('product_id');
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
                        var received_qty = $('#inspection_no option:selected').data('recived_qty');
                        var bilty_no = $('#inspection_no option:selected').data('bilty_no');
                        var driver_name = $('#inspection_no option:selected').data('driver_name');
                        var driver_number = $('#inspection_no option:selected').data('driver_number');
                        var transporter_name = $('#inspection_no option:selected').data('transporter_name');
                        var ins_no = $('#inspection_no option:selected').data('ins_no');
                        var vehicle_no = $('#inspection_no option:selected').data('vehicle_no');
                        var arrival_note = $('#inspection_no option:selected').data('arrival_note');
                        $('#total_qty').val(qty);
                        $('#driver_name').val(driver_name);
                        $('#driver_number').val(driver_number);
                        $('#transporter_name').val(transporter_name);
                        $('#qty1').val(received_qty);
                        $('#builty_no').val(bilty_no);
                        // $('#inspection_no').val(ins_no);
                        $('#vehicle_no').val(vehicle_no);
                        $('#arrival_note').val(arrival_note);
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
                                class="form-control requiredFieldbkbk select2"
                                onchange="getProductSlabsDetail()">
                            </select>
                    </td>
                    <td>
                        <select name="delivery_mode" id="delivery_mode"
                            class="form-control requiredFieldbkbk select2">
                            <option value="">Select Delivery Term</option>
                            <option value="1">Trallers</option>
                            <option value="2">Truck</option>
                            <option value="3">Bags</option>
                            <option value="4">Katta</option>
                            <option value="5">KG</option>
                        </select>
                    </td>
                    <td><input type="number"
                            class="form-control requiredFieldbkbk " name="qty"
                            id="qty${counter}" onkeyup="calculate(${counter})" value="">
                    </td>
                    <td ><input type="number"
                            class="form-control requiredFieldbkbk" name="order_rate"
                            id="rate${counter}" onkeyup="calculate(${counter})" value="">
                    </td>
                    <td ><input type="text"
                            class="form-control requiredFieldbkbk" name="po_amount"
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
