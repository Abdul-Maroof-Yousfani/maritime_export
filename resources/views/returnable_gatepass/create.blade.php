<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
use App\GatePassReturnable;
?>
@extends('layouts.default')
<style>
    .input-container {
        display: -ms-flexbox;
        /* IE10 */
        display: flex;
        width: 100%;
        margin-bottom: 15px;
    }

    .icon {
        padding: 15px;
        background: #8d9399;
        color: white;
        min-width: 20px;
        text-align: center;
        height: 43px;
    }

    .input-field {
        /* width: 100%;
          padding: 10px; */
        outline: none;
    }

    .input-field:focus {
        border: 2px solid rgb(125, 129, 134);
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
                                        <span class="subHeadingLabelClass">Create Gate Pass</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form action="{{ route('gate_pass.store') }}" method="post"
                                                        id="accommodiatiesProduct" enctype="multipart/form-data">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Gate Pass Type :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="gatepass_type" id="po_no"
                                                                    class="form-control requiredField select2 requiredField"
                                                                    >
                                                                    <option value="">Select Gatepass Type</option>
                                                                    <option value="returnable">Returnable</option>
                                                                    <option value="none_returnable">None Returnable</option>
                                                                </select>
                                                            </div>
                                                            
                                                            
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="sf-label">Select Company Location</label>
                                                                <select class="form-control requiredField select2"
                                                                    name="company_location_id" id="company_location_id">
                                                                    @foreach ($company_locations as $company_location)
                                                                        <option value="{{ $company_location['id'] }}">
                                                                            {{ $company_location['location_name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Vendor Name:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="vendor_name" id="supplier_id"
                                                                    class="form-control requiredField select2">
                                                                    <option value="">Select Supplier</option>
                                                                    @foreach (CommonHelper::get_all_supplier() as $Supplier)
                                                                        <option value="{{ $Supplier->name }}">
                                                                            {{ $Supplier->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>WareHouse:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="warehouse_name" id="supplier_id"
                                                                    class="form-control requiredField select2">
                                                                    <option value="">Select Warehouse</option>
                                                                    @foreach (CommonHelper::get_users_warehouse() as $warehouse)
                                                                        <option value="{{ $warehouse->name }}">
                                                                            {{ $warehouse->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                           
                                                        </div>
                                                        <hr>
                                                        <div class="row" style="">
                                                            {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Account No:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="account_no"
                                                                    id="inspection_no" value=""
                                                                    class="form-control requiredField" />
                                                            </div> --}}
                                                    
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Builty No:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="builty_no" 
                                                                    id="builty_no" value=""
                                                                    class="form-control requiredField" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Vehicle No:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="vehicle_no" 
                                                                    id="vehicle_no" value=""
                                                                    class="form-control requiredField" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Driver Name:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="driver_name" 
                                                                    id="driver_name" value=""
                                                                    class="form-control requiredField" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Date:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" name="date" id="date"
                                                                    value="{{ old('date') ?? date('Y-m-d') }}"
                                                                    class="form-control requiredField" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Ref / DC No:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="ref_no" 
                                                                    id="driver_name" value=""
                                                                    class="form-control requiredField" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Ref Date:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" name="ref_date" id="ref_date"
                                                                    value="{{ old('date') ?? date('Y-m-d') }}"
                                                                    class="form-control requiredField" />
                                                            </div>
                                                          
                                                        </div>
                                                        <div class="row" id="form">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                <label for="">Attachemnt file</label>
                                                                <div class="input-container">
                                                                    <input class="input-field form-control" type="file"
                                                                        name="file[]"><i class="fa fa-plus icon"
                                                                        onclick="add()"></i>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <label>Remarks:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                 <textarea class="form-control requiredField" name="remarks" id="" cols="30" rows="3"></textarea>
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
                                                                                <th class="text-center"> Department / Sub Department</th>
                                                                                <th  style="width: 20%;" class="text-center"> Line No</th>
                                                                                <th class="text-center">Line Description</th>
                                                                                <th>Remove</th>
                                                                            </tr>
                                                                        </thead>
                                                                      
                                                                        <tbody id="AppnedHtml">
                                                                            <tr class="cnt" id="removeSection1">
                    
                                                                                <td>
                                                                                    <select onchange="get_item_name(this)" name="item[]" id="item_id" class="form-control select2">
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
                                                                                    <select class="form-control requiredField select2" name="department_id[]"
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
                                                                                <td><select type="number" class="form-control requiredField select2" name="line_no[]" id="line_no1" value="">
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
                                                                                <td><button disabled class="btn btn-danger btn-xs" onClick="removeSection(1)">Remove</button>
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

        var attachCounter = 0;
        function add() {
            attachCounter++;
            var html = ` <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" id="row` + attachCounter +
                `">
                        <label>&nbsp</label>
                    <div class="input-container">
                    <input class="input-field form-control" type="file" placeholder="Form No " name="file[]"><i class="fa fa-minus icon" onclick="minus(` +
                attachCounter + `)"></i>
                </div>
            </div>`;
            $('#form').append(html);
        }
        function minus(number) {
            $('#row' + number).remove();
            attachCounter--;
        }

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
