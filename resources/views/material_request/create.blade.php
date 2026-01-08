<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
use App\MaterialRequest;
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
                                        <span class="subHeadingLabelClass">Create Material Request</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form action="{{ route('material_request.store') }}" method="post"
                                                        id="accommodiatiesProduct">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="m" value="{{$_GET['m']}}">
                                                        <input type="hidden" name="parentCode" value="{{$_GET['parentCode']}}">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="sf-label">Select Company Location</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select class="form-control requiredField select2"
                                                                    name="company_location_id" id="company_location_id">
                                                                    @foreach ($company_locations as $company_location)
                                                                        <option value="{{ $company_location['id'] }}">
                                                                            {{ $company_location['location_name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Material Request Date:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" max="<?php echo date('Y-m-d'); ?>" name="mr_date" id="date"
                                                                    value="<?php echo date('Y-m-d'); ?>"
                                                                    class="form-control requiredField" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="sf-label">Department / Sub Department</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select class="form-control requiredField select2"
                                                                    name="department_id" id="sub_department_id_1">
                                                                    <option value="">Select Department</option>
                                                                    @foreach ($subDepartmentList as $key => $y2)
                                                                        {{-- <optgroup label="{{ $y->department_name }}"
                                                                            value="{{ $y->id }}">
                                                                           
                                                                           // $subdepartments = DB::select('select `id`,`sub_department_name` from `sub_department` where `department_id` =' . $y->id . ' AND where id IN '.[$department_id].'');
                                                                          
                                                                            @foreach ($subdepartments as $key2 => $y2) --}}
                                                                                <option value="{{ $y2->id }}">
                                                                                    {{ $y2->sub_department_name }}</option>
                                                                            {{-- @endforeach
                                                                        </optgroup> --}}
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label for="">Machinery</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="machine_id" id="machine_id"
                                                                    class="form-control select2">
                                                                    <option value="">Select Machinery</option>
                                                                    @foreach ($machineries as $machinery)
                                                                        <option value="{{ $machinery->id }}">{{ $machinery->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        
                                                        
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label for="">Line</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select name="line_id" id="line_id" class="form-control select2">
                                                                    <option value="">Select Line</option>
                                                                    @foreach ($lines as $line)
                                                                        <option value="{{ $line->id }}">{{ $line->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <hr>
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
                                                                                <th colspan="2" class="text-center">
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
                                                                                <th class="text-center"  style="width: 15%;">Warehouse</th>
                                                                                <th class="text-center">Available Stock </th>
                                                                                <th class="text-center"> Qty Requested</th>
                                                                                <th class="text-center">Material Description </th>
                                                                                <th>Remove</th>
                                                                            </tr>
                                                                        </thead>
                                                                      
                                                                        <tbody id="AppnedHtml">
                                                                            <tr class="cnt" id="removeSection1">
                    
                                                                                <td>
                                                                                    <select onchange="get_item_name(1)" name="item[]" id="item_id_1" class="form-control requiredField select2 item_id">
                                                                                        <option value="">Select Item</option>
                                                                                       
                                                                                    </select>
                                                                                </td>
                                                                                <td><input type="text"
                                                                                        class="form-control " readonly name="uom[]"
                                                                                        id="uom_1"  value="">
                                                                                </td>
                                                                                <td>
                                                                                    <select name="warehouse_id[]" id="warehouse_id_1"
                                                                                        onchange="getStock(1)"
                                                                                        class="form-control requiredField select2">
                                                                                        <option value="">Select Warehouse</option>
                                                                                        @foreach (CommonHelper::get_users_warehouse() as $warehouse)
                                                                                            <option value="{{ $warehouse->id }}">
                                                                                                {{ $warehouse->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </td>
                                                                                {{-- <td><input type="text"
                                                                                    class="form-control requiredField " name="material_code[]"
                                                                                    id="material_code"  value="">
                                                                                </td> --}}
                                                                                <input type="hidden" name="material_code[]" value="0">
                                                                                <td><input readonly type="number"
                                                                                    class="form-control " name="stock_qty[]"
                                                                                    id="stock_qty_1" value="">
                                                                                </td>
                                                                                <td><input type="text"
                                                                                        class="form-control requiredField " name="qty_requested[]"
                                                                                        id="qty_requested_1" value="">
                                                                                </td>
                                                                                <td ><textarea type="text"
                                                                                        class="form-control " name="material_description[]"
                                                                                        id="material_description_1" >
                                                                                    </textarea>
                                                                                </td>
                                                                                <td><button disabled class="btn btn-danger btn-xs" onClick="removeSection(this)">Remove</button>
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

        $(document).ready(function() {
            $('#product_id').select2({
                disabled : 'readonly'
            });

            initializeSelect2($('.item_id'));

           
            $(".btn-success").click(function(e){
                var category = new Array();
                var val;
                //$("input[name='chartofaccountSection[]']").each(function(){
                category.push($(this).val());
                //});
                var _token = $("input[name='_token']").val();
                for (val of category) {

                    jqueryValidationCustom();
                    if(validate == 0){
                        //return false;
                    }else{
                        return false;
                    }
                }
            });
        });

        function initializeSelect2($element) {
            $element.select2({
                ajax: {
                    url: '<?php echo url('/') ?>/purchase/get-items',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term // search term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.items
                        };
                    },
                    cache: true
                },
                // minimumInputLength: 1,
                templateResult: formatItem,
                templateSelection: formatItemSelection,
                language: {
                    inputTooShort: function() {
                        return 'Please enter 1 or more characters to search items';
                    },
                    searching: function() {
                        return 'Searching…';
                    },
                    noResults: function() {
                        return 'No results found';
                    }
                }
            });
        }

        function formatItem(item) {
            if (item.loading) {
                return item.text;
            }
            var option = $('<option></option>');
            option.text(item.text);
            option.val(item.id+','+item.uom+','+item.stock); // Ensure the value of the option is set
            option.attr('data-uom', item.uom); // Set data-uom attribute
            option.attr('data-stock', item.stock); // Set data-stock attribute
            console.log(option);
            return option;
        }

        function formatItemSelection(item) {
            return item.text;
        }


        function removeSection(row) {
            $(row).closest('tr').remove();
        }

        function get_item_name(id) {
            
            var item = $('#item_id_'+id).val();
            data = item.split('%');
            $('#uom_'+id).val(data[1]);
            $('#stock_qty_'+id).val(data[2]);
            // $(id).closest('tr').find('input[name="uom[]"]').val(data[1]);
            // $(row).closest('tr').find('input[name="stock_qty[]"]').val(data[2]);
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
       
        var rowId = $('.cnt').length + 1; // Determine the new row ID
        var html = `
            <tr class="cnt" id="removeSection${rowId}">
                <td>
                    <select onchange="get_item_name(${rowId})" name="item[]" id="item_id_${rowId}" class="form-control requiredField select2 item_id">
                        <option value="">Select Item</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control" readonly name="uom[]" id="uom_${rowId}" value="">
                </td>
                <td>
                    <select name="warehouse_id[]" id="warehouse_id_${rowId}" onchange="getStock(${rowId})" class="form-control requiredField select2">
                        <option value="">Select Warehouse</option>
                        <!-- You can populate these options dynamically -->
                        @foreach (CommonHelper::get_users_warehouse() as $warehouse)
                            <option value="{{ $warehouse->id }}">
                                {{ $warehouse->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <input type="hidden" name="material_code[]" value="0">
                <td>
                    <input readonly type="number" class="form-control" name="stock_qty[]" id="stock_qty_${rowId}" value="">
                </td>
                <td>
                    <input type="text" class="form-control requiredField" name="qty_requested[]" id="qty_requested_${rowId}" value="">
                </td>
                <td>
                    <textarea class="form-control" name="material_description[]" id=""></textarea>
                </td>
                <td>
                    <span class="btn btn-danger btn-xs" onClick="removeSection(this)">Remove</span>
                </td>
            </tr>
        `;

        // Append the new row to the table body
        $('#AppnedHtml').append(html);

        $('.select2').select2();
        initializeSelect2($('.item_id'));
    }

    function getStock(id) {
        var warehouse =  $('#warehouse_id_'+id).val();
        var item = $('#item_id_'+id).val();
        item = item.split('%');
        var batch_code = 0;
        $.ajax({
            url: '<?php echo url('/'); ?>/pdc/get_stock_location_wise?batch_code=0',
            type: "GET",
            data: {
                warehouse: warehouse,
                item: item[3]
            },
            success: function(data) {
                // $('#batch_code' + number).html('<option  value="0">0</option>');
                data = data.split('/');
                console.log(data);
                $('#stock_qty_'+id).val(data[0]);
                // $(row).closest('tr').find('#stock_qty').val(data[0]);
                // $('#instock' + number).val();
                console.log(data);
                // $("#qty" + number).val(0);
                if (data[0] == 0) {
                    $('#item_id_'+id).css("background-color", "red");
                } else {
                    $('#item_id_'+id).css("background-color", "");
                }
            }
        });


    }
</script>


        

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
