<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
use App\GatePassReturnable;
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
                                        <span class="subHeadingLabelClass">Edit Gate Pass</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form action="{{ route('gate_pass.update_gatepass') }}" enctype="multipart/form-data"  method="post"
                                                    id="accommodiatiesProduct">
                                                    <input type="hidden" name="id" value="{{ $GatePassReturnable->id }}">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Gate Pass Type:</label>
                                                            <select name="gatepass_type" id="po_no"
                                                                class="form-control requiredField select2 requiredField"                    >
                                                                <option {{$GatePassReturnable->gatepass_type == 'returnable' ? 'selected' : ''}} value="returnable">Returnable</option>
                                                                <option {{$GatePassReturnable->gatepass_type == 'none_returnable' ? 'selected' : ''}} value="none_returnable">None Returnable</option>
                                                            </select>
                                                        </div>
                                                        
                                                        
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Gate Pass No:</label>
                                                            <input readonly type="text" name="gatepass_no" 
                                                                id="gate_pass_no" value="{{$GatePassReturnable->gatepass_no }}"
                                                                class="form-control requiredField" />
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Vendor Name:</label>
                                                            <input type="text" name="vendor_name" 
                                                                id="gate_pass_no" value="{{$GatePassReturnable->vendor_name }}"
                                                                class="form-control requiredField" />
                                                            
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>WareHouse:</label>
                                                
                                                            <select name="warehouse_name" id="supplier_id"
                                                                class="form-control requiredField select2">
                                                                <option value="">Select Warehouse</option>
                                                                @foreach (CommonHelper::get_users_warehouse() as $warehouse)
                                                                    <option {{$warehouse->name == $GatePassReturnable->warehouse_name ? 'selected' : ''}} value="{{ $warehouse->name }}">
                                                                        {{ $warehouse->name }}</option>
                                                                @endforeach
                                                            </select>
                                                           
                                                        </div>
                                                       
                                                    </div>
                                                    <hr>
                                                    <div class="row" style="">
                                                        {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Account No:</label>
                                                            
                                                            <input type="text" name="account_no"
                                                                id="inspection_no" 
                                                                class="form-control requiredField" value="{{$GatePassReturnable->account_no }}" />
                                                        </div> --}}
                                                
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Builty No:</label>
                                                            
                                                            <input type="text" name="builty_no" 
                                                                id="builty_no" 
                                                                class="form-control requiredField" value="{{$GatePassReturnable->builty_no }}"/>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Vehicle No:</label>
                                                            
                                                            <input type="text" name="vehicle_no" 
                                                                id="vehicle_no" 
                                                                class="form-control requiredField" value="{{$GatePassReturnable->vehicle_no }}"/>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Driver Name:</label>
                                                            
                                                            <input type="text" name="driver_name" 
                                                                id="driver_name" 
                                                                class="form-control requiredField"  value="{{$GatePassReturnable->driver_name }}"/>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Date:</label>
                                                            
                                                            <input type="date" name="date" id="date"
                                                                value="{{ $GatePassReturnable->date }}"
                                                                class="form-control requiredField" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                       
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Ref / DC No:</label>
                                                            
                                                            <input type="text" name="ref_no" 
                                                                id="driver_name" 
                                                                class="form-control requiredField" value="{{$GatePassReturnable->ref_no }}"/>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Ref Date:</label>
                                                            
                                                            <input type="date" name="ref_date" id="date"
                                                                value="{{ $GatePassReturnable->ref_date }}"
                                                                class="form-control requiredField" />
                                                        </div>
                                                        {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Type:</label>
                                                            
                                                            <input type="text" name="type" 
                                                                id="driver_name" 
                                                                class="form-control requiredField" value="{{$GatePassReturnable->type }}"/>
                                                        </div> --}}
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Attachment file:</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <input type="file" name="file[]" id="dataFile" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <label>Remarks:</label>
                                                            
                                                             <textarea class="form-control requiredField" name="remarks" id="" cols="30" rows="3">{{$GatePassReturnable->remarks }}</textarea>
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
                                                                                Detail
                                                                            </th>
                                                                            <th colspan="3" class="text-center">
                                                                                <input type="button"
                                                                                    class="btn btn-sm btn-primary"
                                                                                    onclick="add_row()"
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
                                                                            <th class="text-center">UOM </th>
                                                                            <th class="text-center"> Qty</th>
                                                                            <th class="text-center">Department / Sub Department</th>
                                                                            <th  style="width: 20%;" class="text-center"> Line No</th>
                                                                            <th class="text-center">Line Description</th>
                                                                            <th>Remove</th>
                                                                        </tr>
                                                                    </thead>
                                                                  
                                                                    <tbody id="AppnedHtml">
                                            
                                                                        @foreach ($GatePassReturnable->returnable_data ?? [] as $detail)
                                                                        <tr class="cnt" id="removeSection1">
                                            
                                                                            <td>
                                                                                <select onchange="get_item_name(this)" name="item[]" id="item_id" class="form-control select2">
                                                                                    <option value="">Select Item</option>
                                                                                    @foreach (CommonHelper::get_all_subitem() as $subitem)
                                                                                        @php
                                                                                            $pack_size = $subitem->pack_size ? ' - ' . $subitem->pack_size : '';
                                                                                        @endphp
                                                                                        <option {{$detail->item == $subitem->sub_ic ? 'selected' : '' }} value="{{ $subitem->sub_ic }}"
                                                                                            data-uom="{{ $subitem->uomData->uom_name }}">
                                                                                            {{ $subitem->sku_code . ' - ' . $subitem->sub_ic . $pack_size }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </td>
                                                                            <td><input readonly type="text"
                                                                                    class="form-control requiredField "  name="uom[]"
                                                                                    id="uom"  value="{{$detail->uom }}"/>
                                                                            </td>
                                                                            <td><input type="number"
                                                                                    class="form-control requiredField " name="qty[]"
                                                                                    id="qty1" value="{{$detail->qty }}"/>
                                                                            </td>
                                                                            <td >
                                                                                <select class="form-control requiredField" name="department_id[]"
                                                                                    id="department_id">
                                                                                    <option value="">Select Department</option>
                                                                                    @foreach ($departments as $key => $y)
                                                                                        <optgroup label="{{ $y->department_name }}"
                                                                                            value="{{ $y->id }}">
                                                                                            @php
                                                                                                $subdepartments = DB::select('select `id`,`sub_department_name` from `sub_department` where `department_id` =' . $y->id . '');
                                                                                            @endphp
                                                                                            @foreach ($subdepartments as $key2 => $y2)
                                                                                                <option {{$y2->id == $detail->department_id ? 'selected' : ''}} value="{{ $y2->id }}">
                                                                                                    {{ $y2->sub_department_name }}</option>
                                                                                            @endforeach
                                                                                        </optgroup>
                                                                                    @endforeach
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <select type="number" class="form-control select2 requiredField " name="line_no[]" id="line_no1" value="">
                                                                                    <option value="">Select Line No</option>
                                                                                     @foreach (CommonHelper::get_all_lines() as $line)
                                                                                        @if ($line->name != 'Flour Mill')
                                                                                            <option {{ $line->name == $detail->line_no ? 'selected' : ''}}  value="{{ $line->name }}">{{ $line->name }}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </td>
                                                                            <td ><textarea type="text"
                                                                                    class="form-control requiredField" name="line_description[]"
                                                                                    id="" >{{$detail->line_description }}
                                                                                </textarea>
                                                                            </td>
                                                                            <td><button class="btn btn-danger btn-xs" onClick="removeSection(this)">Remove</button>
                                                                            </td>
                                                                        </tr>
                                                                        @endforeach
                                                                        
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



<table class="hide">
    <tbody>
        <tr id="cnt111" >
                    
            <td>
                <select onchange="get_item_name(this)" name="item[]" id="item_id" class="form-control ">
                    <option value="">Select Item</option>
                    @foreach (CommonHelper::get_all_subitem() as $subitem)
                        @php
                            $pack_size = $subitem->pack_size ? ' - ' . $subitem->pack_size : '';
                        @endphp
                        <option value="{{ $subitem->sub_ic }}"
                            data-uom="{{ $subitem->uomData->uom_name }}">
                            {{ $subitem->sku_code . ' - ' . $subitem->sub_ic . $pack_size }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td><input type="text"
                    class="form-control requiredField " readonly name="uom[]"
                    id="uom"  value="">
            </td>
            <td><input type="number"
                    class="form-control requiredField " name="qty[]"
                    id="qty1" value="">
            </td>
            <td >
                <select class="form-control requiredField" name="department_id[]"
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
            </td>
            <td><select type="text" class="form-control requiredField select" name="line_no[]" id="line_no1" value="">
                <option value="">Select Line No</option>
                    @foreach (CommonHelper::get_all_lines() as $line)
                        @if ($line->name != 'Flour Mill')
                            <option value="{{ $line->name }}">{{ $line->name }}</option>
                        @endif
                    @endforeach
               </select>
            </td>
            <td ><textarea type="text"
                    class="form-control requiredField" name="line_description[]"
                    id="" >
                </textarea>
            </td>
            <td><span class="btn btn-danger btn-xs" onClick="removeSection(this)">Remove</span>
            </td>
        </tr>
    </tbody>
</table>
    <script type="text/javascript">
        $('.select2').select2();

        $(document).ready(function() {
            $('#product_id').select2({
                disabled : 'readonly'
            });
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





        function removeSection(row) {
            $(row).closest('tr').remove();
        }

        function get_item_name(row) {
            var uom = $(row).find('option:selected').data('uom');
            $(row).closest('tr').find('input[name="uom[]"]').val(uom);
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

<script>
    let counter = 1;

    function add_row() {
        counter++;
        // Clone the first row and remove any user-entered data
        var newRow = $('.hide #cnt111').clone();

        newRow.find('input[type="text"], input[type="number"], textarea').val('');

        // Reset select fields
        newRow.find('select').each(function() {
            $(this).val($(this).find('option:first').val()).trigger('change');
            $(this).addClass('selectttt'+counter);
        });
       

        // Append the new row to the table body
        $('#AppnedHtml').append(newRow);

       
        $(newRow).find('select.selectttt'+counter).select2();
    }
</script>


        

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
