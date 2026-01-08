<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
use App\ArrivalSlip;
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
                                        <span class="subHeadingLabelClass">Create Arrival Slip</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form enctype="multipart/form-data" action="{{ route('arrivalslip.store') }}" method="post"
                                                          id="yourFormId2" >
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <div class="row">
                                                           
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>PO No :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="po_no" id="po_no"
                                                                    class="form-control  select2 "
                                                                    onchange="get_arrival_inspection_no(this.value)"
                                                                    >
                                                                    <option value="">Select Po</option>
                                                                    @foreach (CommonHelper::get_all_balance_pos() as $key => $y)
                                                                        <option value="{{ $y->voucher_no }}" data-product_id="{{$y->product_id}}"
                                                                            {{ old('po_no') == $y->voucher_no ? 'selected' : '' }}>
                                                                            {{ $y->voucher_no }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Inspection No :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>

                                                                <select name="inspection_no" id="inspection_no" onchange="get_product()"
                                                                    class="form-control select2"

                                                                >
                                                                    <option value="">Select Inspection No</option>
                            
                                                                </select>
                                                            </div>
                                                            
                                                            
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Arrival Slip No:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="arrival_slip_no" disabled
                                                                    id="arrival_slip_no" value="{{CommonHelper::getProductionFormat(ArrivalSlip::class,'ASP-') }}"
                                                                    class="form-control requiredFieldbbbkkk" />
                                                            </div>
                                                           
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Arriavl Date:</label>
                                                                <span  class="rflabelsteric"><strong>*</strong></span>
                                                                <input readonly type="text" name="arrival_date" id="arrival_date"
                                                                    value="{{date('Y-m-d')}}"
                                                                    class="form-control " />
                                                            </div>
                                                           
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>PO Date:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input disabled type="text" name="po_date" id="po_date"
                                                                    value=""
                                                                    class="form-control " />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Bill Date:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input min="{{date('Y-m-d')}}" type="date" name="bill_date" id="bill_date"
                                                                    value=""
                                                                    class="form-control requiredFieldbbbkkk" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Supplier Invoice No:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="sp_inv_no" id="sp_inv_no"
                                                                    value=""
                                                                    class="form-control requiredFieldbbbkkk" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Builty No:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input disabled readonly type="text" name="builty_no" 
                                                                    id="builty_no" value=""
                                                                    class="form-control requiredFieldbbbkkk" />
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        <hr>
                                                        <div class="row" style="">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Vehicle No:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input disabled type="text" name="vehicle_no" 
                                                                    id="vehicle_no" value=""
                                                                    class="form-control requiredFieldbbbkkk" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="sf-label">Department / Sub Department</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select class="form-control requiredFieldbbbkkk select2" name="department_id"
                                                                    id="department_id">
                                                                    <option value="">Select Department</option>
                                                                    @foreach ($departments as $key => $y)
                                                                        <optgroup label="{{ $y->department_name }}"
                                                                            value="{{ $y->id }}">
                                                                            @php
                                                                                $subdepartments = DB::select('select `id`,`sub_department_name` from `sub_department` where `department_id` =' . $y->id . '');
                                                                            @endphp
                                                                            @foreach ($subdepartments as $key2 => $y2)
                                                                                <option value="{{ $y2->id }}">
                                                                                    {{ $y2->sub_department_name }}</option>
                                                                            @endforeach
                                                                        </optgroup>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Supplier Name:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input disabled type="text" name="sup_name" 
                                                                    id="sup_name" value=""
                                                                    class="form-control requiredFieldbbbkkk" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Supplier Address:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input disabled type="text" name="sup_adr" 
                                                                    id="sup_adr" value="-"
                                                                    class="form-control" />
                                                            </div>
                                                          
                                                         
                                    
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Document Mode:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="document_mode" id="document_mode"
                                                                    value=""
                                                                    class="form-control requiredFieldbbbkkk" />
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
                                                                                <th class="text-center">Recived Qty </th>
                                                                                <th class="text-center">Rejected Qty </th>
                                                                                <th class="text-center">Balnace Qty </th>
                                                                                <th class="text-center">Location </th>
                                                                                <th class="text-center">Location No </th>
                                                                                <th style="width: 20%;" class="text-center">Recieved Type</th>
                                                                               
                                                                            </tr>
                                                                        </thead>
                                                                      
                                                                        <tbody id="AppnedHtml">
                                                                            <tr class="cnt" id="removeSection1">
                    
                                                                                <td>
                                                                                        <select disabled name="product_id" id="product_id"
                                                                                            class="form-control requiredFieldbbbkkk select2"
                                                                                            onchange="getProductSlabsDetail()">
                                                                                        </select>
                                                                                </td>
                                                                                <td><input readonly type="number"
                                                                                        class="form-control requiredFieldbbbkkk " disabled name="qty"
                                                                                        id="total_qty"  value="">
                                                                                        
                                                                                </td>
                                                                               
                                                                                <td><input readonly type="number"
                                                                                    class="form-control requiredFieldbbbkkk " name="received_qty"
                                                                                    id="recived_qty" value="">
                                                                                </td>
                                                                                <td><input  type="number"
                                                                                    class="form-control requiredFieldbbbkkk " readonly onchange="get_rejected_val(this.value)" onkeyup="get_rejected_val(this.value)" onkeydown="get_rejected_val(this.value)" name="rejected_qty"
                                                                                    id="rejected_qty" value="">
                                                                                </td>
                                                                                <td><input readonly type="number"
                                                                                    class="form-control requiredFieldbbbkkk " name="bal_qty"
                                                                                    id="bal_qty" value="">
                                                                                </td>
                                                                                <td ><input disabled type="text"
                                                                                    class="form-control requiredFieldbbbkkk " name="location"
                                                                                    id="parent_location" value=""></td>
                                                                                <td ><input disabled type="text"
                                                                                    class="form-control requiredFieldbbbkkk " name="location"
                                                                                    id="location" value=""></td>
                                                                                    <td>
                                                                                        <select name="recived_type" id="recieved_type"
                                                                                            class="form-control requiredFieldbbbkkk select2" >
                                                                                            <option  value="">Please Select Recieved Type</option>
                                                                                            <option  value="1">Partial</option>
                                                                                            <option  value="2">Complete</option>
                                                                                        </select>
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
        //     $('#recieved_type').select2({
        //         placeholder : 'please select recieved type'
        //     });
        //
        //
        //
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

        function get_rejected_val(rejected_qty){
            var recived_qty = parseFloat($('#recived_qty').val());
            if(rejected_qty > recived_qty){
                alert('Rejected qty should not greater then received qty');
                $('#rejected_qty').val(0);
                return false;
            }
            var bal_qty = recived_qty - rejected_qty;
            $('#bal_qty').val(bal_qty);
        }

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
                        var location = $('#inspection_no option:selected').data('location');
                        var recived_qty = $('#inspection_no option:selected').data('recived_qty');
                        var bilty_no = $('#inspection_no option:selected').data('bilty_no');
                        var sup_name = $('#inspection_no option:selected').data('sup_name');
                        var sup_adr = $('#inspection_no option:selected').data('sup_adr');
                        var voucher_date = $('#inspection_no option:selected').data('voucher_date');
                        var vehicle_no = $('#inspection_no option:selected').data('vehicle_no');
                        var arrival_note = $('#inspection_no option:selected').data('arrival_note');
                        var rejected_qty = $('#inspection_no option:selected').data('rejected_qty');
                        var balance_qty = $('#inspection_no option:selected').data('balance_qty');
                        var parent_location = $('#inspection_no option:selected').data('parent_location');
                        var location = $('#inspection_no option:selected').data('location');
                        $('#location').val(location);
                        $('#recived_qty').val(recived_qty);
                        $('#total_qty').val(qty);
                        $('#sup_name').val(sup_name);
                        $('#po_date').val(voucher_date);
                        $('#sup_adr').val(sup_adr);
                        $('#builty_no').val(bilty_no);
                        $('#vehicle_no').val(vehicle_no);
                        $('#rejected_qty').val(rejected_qty);
                        $('#bal_qty').val(parseFloat(balance_qty) - parseFloat(recived_qty)); 
                        $('#parent_location').val(parent_location);
                        $('#location').val(location);
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
                                class="form-control requiredFieldbbbkkk select2"
                                onchange="getProductSlabsDetail()">
                            </select>
                    </td>
                    <td>
                        <select name="delivery_mode" id="delivery_mode"
                            class="form-control requiredFieldbbbkkk select2">
                            <option value="">Select Delivery Term</option>
                            <option value="1">Trallers</option>
                            <option value="2">Truck</option>
                            <option value="3">Bags</option>
                            <option value="4">Katta</option>
                            <option value="5">KG</option>
                        </select>
                    </td>
                    <td><input type="number"
                            class="form-control requiredFieldbbbkkk " name="qty"
                            id="qty${counter}" onkeyup="calculate(${counter})" value="">
                    </td>
                    <td ><input type="number"
                            class="form-control requiredFieldbbbkkk" name="order_rate"
                            id="rate${counter}" onkeyup="calculate(${counter})" value="">
                    </td>
                    <td ><input type="text"
                            class="form-control requiredFieldbbbkkk" name="po_amount"
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

        function get_arrival_inspection_no(po_no) {

            $.ajax({
                url: '{{ route('arrival_inspection_no') }}',
                type: 'Get',
                data: {
                    po_no: po_no
                },
                success: function(response) {
                    $('#inspection_no').html('');
                    $('#inspection_no').append(new Option('Select Inspection', ''))
                    $.each(response, function(index, element) {
                        $('#inspection_no').append(
                            `<option value="${element['ins_no']}" data-location="${element['location']}" data-parent_location="${element['parent_location']}" data-balance_qty="${element['balance_qty']}"  data-voucher_date="${element['voucher_date']}" data-vehicle_no="${element['truck_no']}" data-sup_name="${element['supplier_name']}" data-sup_adr="${element['supplier_address']}" data-location="${element['location_id']}" data-qty="${element['total_qty']}" data-recived_qty="${element['recived_qty']}" data-rejected_qty="${element['reject_qty']}" data-bilty_no="${element['bilty_no']}" data-transporter_name="${element['transporter_name']}" data-driver_name="${element['driver_name']}" data-product_id="${element['product_id']}">${element['ins_no']}</option>`
                        )
                        
                    });
                    $('#inspection_no').select2();
                }
            });
        }
    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
