<?php
$m = Session::get('run_company');
use App\Helpers\StoreHelper;
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
?>
@extends('layouts.default')

@section('content')
    @include('select2')
    @include('modal')
    @include('number_formate')


    <style>
        * {
            font-size: 12px !important;
            font-family: Arial;
        }

        .select2 {
            width: 100%;
        }
        .table-responsive .select2-container--default .select2-selection--single {
            width: 200px !important;
        }
    </style>

    <?php
    // $wo = StoreHelper::unique_for_is(date('y'), date('m'));
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="display: none;">
                {{-- @include('Purchase.'.$accType.'purchaseMenu') --}}
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well_N">
                    <div class="dp_sdw">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span class="subHeadingLabelClass">Create Arrival Report</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <form method="post" action="{{ route('arrival_report.store') }}" id="addSubItemDetail" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label class="sf-label">Select Company Location</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                <select class="form-control requiredField select2"
                                                    name="company_location_id" id="company_location_id">
                                                    <option value="">Select Company Location</option>
                                                    @foreach ($company_locations as $company_location)
                                                        <option value="{{ $company_location['id'] }}">
                                                            {{ $company_location['location_name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label>Arrival Report Date:</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                <input type="date" max="<?php echo date('Y-m-d'); ?>" name="arival_date" id="date"
                                                    value="<?php echo date('Y-m-d'); ?>"
                                                    class="form-control requiredField" />
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                <label for="">Attachemnt file</label>
                                                <div class="input-container">
                                                    <input class="input-field form-control requiredField" required
                                                        id="attachment1" type="file" name="file[]">
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="lineHeight">&nbsp;</div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <label for="">Arrival Remarks</label>
                                                <textarea class="form-control" name="arrival_remarks" id="arrival_remarks" cols="5" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="lineHeight">&nbsp;</div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <th colspan="3" class="text-center">
                                                                    Item
                                                                    Detail</th>
                                                                <th colspan="8" class="text-center">
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
                                                                <th class="text-center">
                                                                    Item Name</th>
                                                                <th class="text-center">UOM </th>
                                                                <th class="text-center">IGP # </th>
                                                                <th class="text-center">DC # </th>
                                                                <th  class="text-center">PR / PO No </th>
                                                                <th  class="text-center">Department / Sub Department</th>
                                                                <th class="text-center">Requested Qty </th>
                                                                <th class="text-center">Recieved Qty</th>
                                                                <th class="text-center">Vendor</th>
                                                                <th>Remove</th>
                                                            </tr>
                                                        </thead>
                                                      
                                                        <tbody id="AppnedHtml">
                                                            <tr class="cnt" id="removeSection1">
                                                                <td>
                                                                    <select style="width:200px!important;" onchange="get_item_name(1);get_pr_or_po(this.value,1)" name="item[]" id="item_id_1" class="form-control requiredField select2 item_id">
                                                                        <option value="">Select Item</option>
                                                                       
                                                                    </select>
                                                                </td>
                                                                <td><input style="width:200px!important;" type="text"
                                                                        class="form-control " readonly name="uom[]"
                                                                        id="uom_1"  value="">
                                                                </td>
                                                                <td>
                                                                    <input style="width:200px!important;" type="text" class="form-control requiredField "  name="igp_no[]" id="igp_no_1"  value="">
                                                                </td>
                                                                <td>
                                                                    <input style="width:200px!important;" type="text" class="form-control requiredField "  name="dc_no[]" id="dc_no_1"  value="">
                                                                </td>
                                                                <td>
                                                                    <select style="width:200px!important;" name="pr_no[]" id="pr_no_1"
                                                                        onchange="get_selected_form(1)"
                                                                        class="form-control requiredField select2">
                                                                      
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select style="width:200px!important;"  class="form-control requiredField select2"
                                                                        name="department_id[]" id="department_id_1">
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
                                                                </td>
                                                                <td>
                                                                    <input style="width:200px!important;" type="text" class="form-control requiredField "  name="qty_requested[]" id="qty_requested_1"  value="">
                                                                </td>
                                                                <td>
                                                                    <input style="width:200px!important;" type="text" class="form-control requiredField " name="qty_approved[]" id="qty_approved_1" value="">
                                                                </td>
                                                                <td>
                                                                    <select style="width:200px!important;" name="vendor_id[]" id="vendor_id_1"
                                                                        class="form-control requiredField select2">
                                                                        <option value="">Select Supplier</option>
                                                                            @foreach ($suppliers as $key2 => $supplier)
                                                                                <option value="{{ $supplier->id }}">
                                                                                    {{ $supplier->name }}</option>
                                                                            @endforeach  
                                                                    </select>
                                                                </td>
                                                            
                                                                <td><button disabled class="btn btn-danger btn-xs" onClick="removeSection(this)">Remove</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        
                                                       
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="createMaterialFormAjax"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="demandsSection"></div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                    <button type="reset" id="reset"
                                        class="btn btn-primary">Clear Form</button>
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
        // $(function () {
        //     getAjaxItemList('.item_id');
        // });




        function get_item_name(id) {
            
            var item = $('#item_id_'+id).val();
            data = item.split('%');
            $('#uom_'+id).val(data[1]);
            $('#department_id_'+id).val('').trigger('change')
            $('#vendor_id_'+id).val('').trigger('change')
            
            // $(id).closest('tr').find('input[name="uom[]"]').val(data[1]);
            // $(row).closest('tr').find('input[name="stock_qty[]"]').val(data[2]);
        }

        function removeSection(id) {
            $('#removeSection' + id).remove()
        }

        $(document).ready(function() {
            initializeSelect2($('.item_id'));

            $(".btn-success").click(function(e) {

                //alert();
                var purchaseRequest = new Array();
                var val;
                //$("input[name='demandsSection[]']").each(function(){
                purchaseRequest.push($(this).val());



                //});
                var _token = $("input[name='_token']").val();
                for (val of purchaseRequest) {
                    jqueryValidationCustom();
                    if (validate == 0) {
                        //alert(response);
                    } else {
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
            return option;
        }

        function formatItemSelection(item) {
            return item.text;

        }

        function add_row() {        
            var rowId = $('.cnt').length + 1; // Determine the new row ID
            var html = `
                <tr class="cnt" id="removeSection${rowId}">
                    <td>
                        <select style="width:200px!important;" onchange="get_item_name(${rowId});get_pr_or_po(this.value,${rowId})" name="item[]" id="item_id_${rowId}" class="form-control requiredField select2 item_id">
                            <option value="">Select Item</option>
                            
                        </select>
                    </td>
                    <td><input style="width:200px!important;" type="text"
                            class="form-control " readonly name="uom[]"
                            id="uom_${rowId}"  value="">
                    </td>
                    <td>
                        <input style="width:200px!important;" type="text" class="form-control requiredField "  name="igp_no[]" id="igp_no_${rowId}"  value="">
                    </td>
                    <td>
                        <input style="width:200px!important;" type="text" class="form-control requiredField "  name="dc_no[]" id="dc_no_${rowId}"  value="">
                    </td>
                    <td>
                        <select style="width:200px!important;" name="pr_no[]" id="pr_no_${rowId}"
                            onchange="get_selected_form(${rowId})"
                            class="form-control requiredField select2">
                            
                        </select>
                    </td>
                    <td>
                         <select style="width:200px!important;"  class="form-control requiredField select2"
                            name="department_id[]" id="department_id_${rowId}">
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
                    </td>
                    <td>
                        <input style="width:200px!important;" type="text" class="form-control requiredField "  name="qty_requested[]" id="qty_requested_${rowId}"  value="">
                    </td>
                    <td>
                        <input style="width:200px!important;" type="text" class="form-control requiredField " name="qty_approved[]" id="qty_approved_${rowId}" value="">
                    </td>
                    <td>
                        <select style="width:200px!important;" name="vendor_id[]" id="vendor_id_${rowId}"
                            class="form-control requiredField select2">
                             <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $key2 => $supplier)
                                        <option value="{{ $supplier->id }}">
                                            {{ $supplier->name }}</option>
                                    @endforeach  
                            </select>
                        </select>
                    </td>
                
                    <td><span style="cursor:pointer" class="btn btn-danger btn-xs" onClick="removeSection(${rowId})">Remove</span>
                    </td>
                </tr>
            `;

            // Append the new row to the table body
            $('#AppnedHtml').append(html);

            $('.select2').select2();
            initializeSelect2($('.item_id'));
        }

        function get_pr_or_po(item,row_id) {
            var id = item.split('%');
            id = id[3];
            $.ajax({
                url: '<?php echo url('/'); ?>/purchase/get_itemwise_prpo',
                method: 'GET',
                data: {
                    id: id
                },
                error: function() {
                    alert('error');
                },
                success: function(response) {
                    $('#pr_no_'+row_id).html('').html(response);
                    
                   
                }
            });
        }
        function get_selected_form(row_id) {
            let id = $('#pr_no_'+row_id).val();
            var item = $('#item_id_'+row_id).val();
            var item_id = item.split('%');
            item_id = item_id[3];
            if(id == '' || id == 0){
                $('#qty_approved_'+row_id).val('');
                $('#qty_requested_'+row_id).val('');
                return false;
            }
    
            $.ajax({
                url: '<?php echo url('/'); ?>/purchase/GetArrivalForm',
                method: 'GET',
                data: {
                    id: id,
                    item_id: item_id,
                },
                error: function() {
                    alert('error');
                },
                success: function(response) {
                    $('#department_id_'+row_id).html('').html(response.department);
                    $('#vendor_id_'+row_id).html('').html(response.vendor);
                    $('#qty_approved_'+row_id).val('').val(response.purchase_approve_qty);
                    $('#qty_requested_'+row_id).val('').val(response.purchase_request_qty);
                }
            });
        }

    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
