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
                                <span class="subHeadingLabelClass">Create Conversion Order</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <form method="post" action="{{ route('scrap_declrations.store') }}" id="addSubItemDetail" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                           
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label>Sale Order No:</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                <input type="text"  name="sale_order_no" id="sale_order_no"
                
                                                    class="form-control requiredField" />
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
                                                                CNV. Date   
                                                                </th>
                                                                <th class="text-center">
                                                                    Timing
                                                                </th>
                                                                <th class="text-center">
                                                                Supervisor    
                                                                </th>
                                                                <th class="text-center">
                                                                    Name of RAW Material Taken
                                                                </th>
                                                                <th class="text-center">
                                                                From Store Location    
                                                                </th>

                                                                <th class="text-center">
                                                                    Product Line#
                                                                </th>
                                                                
                                                                <th class="text-center">
                                                                   Packing(Mannual)
                                                                </th>
                                                                
                                                                <th class="text-center">
                                                                    Received QTY
                                                                </th>
                                                                
                                                                <th class="text-center">
                                                                   UOM
                                                                </th>
                                                        
                                                                <th class="text-center">
                                                                    Auto Conversion in Ton's
                                                                </th>
                                                                <th class="text-center">
                                                                   Produced Item Name
                                                                </th>
                                                                <th class="text-center">
                                                                   Final Produced QTY
                                                                 </th>
                                                                 <th class="text-center">
                                                                    UOM
                                                                 </th>
                                                                 <th class="text-center">
                                                                    Storage Location
                                                                 </th>
                                                                 <th class="text-center">
                                                                    Purpose (Local/Export)
                                                                 </th>
                                                                 <th class="text-center">
                                                                    Remarks
                                                                 </th>
                                                                 <th class="text-center">
                                                                    Attachment
                                                                 </th>
                                                            </tr>
                                                        </thead>
                                                      
                                                        <tbody id="AppnedHtml">
                                                            <tr class="cnt" id="removeSection1">
                                                                <td>
                                                                    <input style="width:200px!important;" type="date"
                                                                    class="form-control " readonly name="conversion_date[]"
                                                                    id="conversion_date_1"  value="">
                                                                </td>
                                                                <td>
                                                                    <input style="width:200px!important;" type="time"
                                                                    class="form-control " readonly name="from_timing[]"
                                                                    id="from_timing_1"  value="">
 =>
                                                                    <input style="width:200px!important;" type="time"
                                                                    class="form-control " readonly name="to_timing[]"
                                                                    id="to_timing_1"  value="">
                                                                </td>
                                                                <td>
                                                                    <select style="width:200px!important;"  name="supervisor[]" id="supervisor_1" class="form-control requiredField select2 supervisor">
                                                                        <option value="">Select Supervisor</option>
                                                                       @foreach($users as $user)
                                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select style="width:200px!important;"  name="raw_material_id[]" id="raw_material_id_1" class="form-control requiredField select2 supervisor">
                                                                        <option value="">Select Raw Material</option>
                                                                        @foreach($raw_m as $material)
                                                                            <option value="{{$material->id}}">{{$material->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select style="width:200px!important;" name="store_location" id="store_location_id"
                                                                            class="form-control  select2">
                                                                        <option value="">Select Location</option>
                                                                        @foreach ($locations as $company_location)
                                                                            <option {{ 1 == $company_location->id ? 'selected' : ''}}  value="{{ $company_location->id }}">
                                                                                {{ $company_location->name }}</option>
                                                                        @endforeach

                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select style="width:200px!important;" name="production_line" id="production_line_id"
                                                                            class="form-control  select2">
                                                                        <option value="">Select Line No</option>
                                                                        @foreach ($lines as $line)
                                                                            <option  value="{{ $line->id }}">
                                                                                {{ $line->name }}</option>
                                                                        @endforeach

                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input style="width:200px!important;" type="text"
                                                                    class="form-control " name="packing[]"
                                                                    id="packing_id"  value="">
                                                                </td>
                                                                <td><input style="width:200px!important;" type="number"
                                                                    class="form-control " name="received_qty[]"
                                                                    id="received_qty_id"  value="">
                                                                </td>
                                                                <td><input style="width:200px!important;" type="text"
                                                                        class="form-control " readonly name="uom[]"
                                                                        id="uom_1"  value="">
                                                                </td>
                                                            
                                                                <td>
                                                                    <input style="width:200px!important;" type="text" class="form-control requiredField "  name="qty[]" id="qty_1"  value="">
                                                                </td>
                                                                <td>
                                                                    <input style="width:200px!important;" type="text" class="form-control requiredField "  name="qty[]" id="qty_1"  value="">
                                                                </td>
                                                                <td>
                                                                    <input style="width:200px!important;" type="text" class="form-control requiredField "  name="qty[]" id="qty_1"  value="">
                                                                </td>
                                                                <td>
                                                                    <input style="width:200px!important;" type="text" class="form-control requiredField "  name="qty[]" id="qty_1"  value="">
                                                                </td>
                                                                <td>
                                                                    <input style="width:200px!important;" type="text" class="form-control requiredField "  name="qty[]" id="qty_1"  value="">
                                                                </td>
                                                                <td>
                                                                    <input style="width:200px!important;" type="text" class="form-control requiredField "  name="qty[]" id="qty_1"  value="">
                                                                </td>
                                                                <td>
                                                                    <input style="width:200px!important;" type="text" class="form-control requiredField "  name="qty[]" id="qty_1"  value="">
                                                                </td>
                                                                <td>
                                                                    <input style="width:200px!important;" type="text" class="form-control requiredField "  name="qty[]" id="qty_1"  value="">
                                                                </td>
                                                                <td>
                                                                    <input style="width:200px!important;" type="text" class="form-control requiredField "  name="qty[]" id="qty_1"  value="">
                                                                </td>

                                                                <td>
                                                                    <textarea style="width:200px!important;" class="form-control requiredField " name="reason_for_scrapping[]" id="reason_for_scrapping_1"></textarea>
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
            $('#item_code_'+id).val(data[4]);
          
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
                        <select style="width:200px!important;" name="category_id[]" id="category_id_${rowId}" class="form-control requiredField select2">
                            <option value="">Select Scrap Category</option>
                            <option value="iron">Iron</option>
                            <option value="plastic">Plastic</option>
                            <option value="copper">Copper</option>
                            <option value="steel">Steel</option>
                            <option value="paper">Paper</option>
                        </select>
                    </td>
                    <td>
                        <select style="width:200px!important;" onchange="get_item_name(${rowId});" name="item[]" id="item_id_${rowId}" class="form-control requiredField select2 item_id">
                            <option value="">Select Item</option>
                            
                        </select>
                    </td>
                     <td><input style="width:200px!important;" type="text"
                        class="form-control " readonly name="item_code[]"
                        id="item_code_${rowId}"  value="">
                    </td>
                    <td><input style="width:200px!important;" type="text"
                        class="form-control " name="item_desc[]"
                        id="item_desc_${rowId}"  value="">
                    </td>
                    <td><input style="width:200px!important;" type="text"
                            class="form-control " readonly name="uom[]"
                            id="uom_${rowId}"  value="">
                    </td>
                  
                     <td>
                        <input style="width:200px!important;" type="text" class="form-control requiredField "  name="qty[]" id="qty_${rowId}"  value="">
                    </td>
                    <td>
                        <textarea style="width:200px!important;" class="form-control requiredField " name="reason_for_scrapping[]" id="reason_for_scrapping_${rowId}"></textarea>
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
    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
