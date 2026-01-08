<?php use App\Helpers\CommonHelper; ?>
<div class="row">
    <form action="{{ route('arrivalslip.store') }}" method="post"
        id="accommodiatiesProduct">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>PO No :</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" readonly value="{{$arrival_slip->po_no}}"  class="form-control requiredField" />
            </div>
            <div disabled class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Inspection No :</label>
                <span class="rflabelsteric"><strong>*</strong></span>

                <select name="inspection_no" id="inspection_no" onchange="get_product()"
                    class="form-control select2"

                >
                <option selected data-qty="{{$arrival_slip->min_qty_kg}}" data-bilty_no="{{$arrival_slip->bilty_no}}" data-transporter_name="{{$arrival_slip->transporter_name}}" data-driver_name="{{$arrival_slip->driver_name}}" data-product_id="{{$arrival_slip->product_id}}">{{$arrival_slip->ins_no}}</option>
                </select>
            </div>
            
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Arrival Slip No:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="arrival_slip_no" disabled
                    id="arrival_slip_no" value="{{$arrival_slip->arrival_slip_no }}"
                    class="form-control requiredField" />
            </div>
           
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Arriavl Date:</label>
                <span  class="rflabelsteric"><strong>*</strong></span>
                <input readonly type="text" name="arrival_date" id="arrival_date"
                    value="{{$arrival_slip->arrival_date }}"
                    class="form-control " />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>PO Date:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input disabled type="text" name="po_date" id="po_date"
                    value=""
                    class="form-control " />
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Bill Date:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input readonly type="text" name="bill_date" id="bill_date"
                    value="{{$arrival_slip->bill_date }}"
                    class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Supplier Invoice No:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input readonly type="text" name="sp_inv_no" id="sp_inv_no"
                    value="{{$arrival_slip->sp_inv_no }}"
                    class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Builty No:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input disabled readonly type="text" name="builty_no" 
                    id="builty_no"   value="{{$arrival_slip->builty_no }}"
                    class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Vehicle No:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input disabled type="text" name="vehicle_no" 
                    id="vehicle_no"  value="{{$arrival_slip->vehicle_no }}"
                    class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="margin-top: 3%;">
                <label>Attachment </label>
                @if(!empty($arrival_slip->attachment))
                    <a href="{{ asset('storage/' . $arrival_slip->attachment) }}" 
                    class="btn btn-primary" 
                    download="{{ $arrival_slip->attachment }}">
                    Download Attachment
                    </a>
                @else
                    <p>No attachment available</p>
                @endif  
            </div>
            
        </div>
        <hr>
        <div class="row" style="">
          
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label class="sf-label">Department / Sub Department</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <select disabled class="form-control requiredField select2" name="department_id"
                    id="department_id">
                   
                            @php
                                $subdepartments = DB::select('select `id`,`sub_department_name` from `sub_department` where `id` =' . $arrival_slip->department_id . '');
                            @endphp
                                <option>
                                    {{ $subdepartments[0]->sub_department_name }}</option>
                           
                </select>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Supplier Name:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input disabled type="text" name="sup_name" 
                    id="sup_name" value=""
                    class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Supplier Address:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input disabled type="text" name="sup_adr" 
                    id="sup_adr" value=""
                    class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Document Mode:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input disabled type="text" name="document_mode" id="document_mode"
                   value="{{$arrival_slip->document_mode }}"
                    class="form-control requiredField" />
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
                                <th  class="text-center">Location </th>
                                <th  class="text-center">Location No</th>
                                <th style="width: 20%;" class="text-center">Recieved Type</th>
                               
                            </tr>
                        </thead>
                      
                        <tbody id="AppnedHtml">
                            <tr class="cnt" id="removeSection1">

                                <td>
                                        <select disabled name="product_id" id="product_id"
                                            class="form-control requiredField select2"
                                            onchange="getProductSlabsDetail()">
                                        </select>
                                </td>
                                <td><input readonly type="number"
                                        class="form-control requiredField " disabled name="qty"
                                        id="total_qty"  value="">
                                </td>
                               
                                <td><input readonly type="number"
                                    class="form-control requiredField " name="received_qty"
                                    id="recived_qty" value="">
                                </td>
                                <td><input disabled type="number"
                                    class="form-control requiredField " onchange="get_rejected_val(this.value)" onkeyup="get_rejected_val(this.value)" onkeydown="get_rejected_val(this.value)" name="rejected_qty"
                                    id="rejected_qty"  value="{{$arrival_slip->rejected_qty }}">
                                </td>
                                <td><input readonly type="number"
                                    class="form-control requiredField " name="bal_qty"
                                    id="bal_qty"  value="{{$arrival_slip->bal_qty }}">
                                </td>
                                <td ><input disabled type="text"
                                    class="form-control requiredField " name="location"
                                    id="location" value=""></td>
                                    <td>
                                        <select disabled name="recived_type" id="recieved_type"
                                            class="form-control requiredField select2" >
                                            <option {{$arrival_slip->recived_type == 1 ? "selected" : '' }} value="1">Partial</option>
                                            <option   {{$arrival_slip->recived_type == 2 ? "selected" : '' }} value="2">Complete</option>
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
            
        </div>
        
    </form>
</div>

<script>
 

   
    // Add event listeners to buttons
    $(document).ready(function() {
        get_product();
      
    });

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
                            `<option value="{{['id']}" data-cropbased="{{['crop_based']}">{{['name']}</option>`
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
                        $('#bal_qty').val(balance_qty);
                        $('#parent_location').val(parent_location);
                        $('#location').val(location);
                    });
                }
            });
        }
</script>