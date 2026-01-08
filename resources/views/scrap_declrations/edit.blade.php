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
                                <span class="subHeadingLabelClass">Edit Scrap Declration</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <form method="post" action="{{ route('scrap_declrations.update', $scrap_declration->id) }}" id="addSubItemDetail" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label class="sf-label">Select Company Location</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                <select disabled class="form-control requiredField select2"
                                                    name="company_location_id" id="company_location_id_1">
                                                    <option value="">Select Company Location</option>
                                                    @foreach ($company_locations as $company_location)
                                                        <option value="{{ $company_location['id'] }}"  {{$scrap_declration->company_location_id == $company_location['id'] ? 'selected' : ''}}>
                                                            {{ $company_location['location_name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label>Scrap Declration Date:</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                <input type="text" disabled max="<?php echo date('Y-m-d'); ?>" name="sd_date" id="sd_date"
                                                    value="{{$scrap_declration->sd_date}}"
                                                    class="form-control requiredField" />
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                <label for="">Department</label>
                                                <select class="form-control requiredField select2"
                                                    name="department_id" id="department_id_1">
                                                    <option value="">Select Department</option>
                                                    @foreach ($subDepartmentList as $key => $y2)
                                                        <option value="{{ $y2->id }}" {{$scrap_declration->department_id == $y2->id ? 'selected' : ''}}>{{ $y2->sub_department_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Line</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                <select name="line_no" id="line_id_1" class="form-control select2">
                                                    <option value="">Select Line</option>
                                                    @foreach ($lines as $line)
                                                        <option value="{{ $line->id }}"  {{$scrap_declration->line_no == $line->id ? 'selected' : ''}}>{{ $line->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                           
                                        </div>
                                        <div class="lineHeight">&nbsp;</div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <label for="">Remarks</label>
                                                <textarea class="form-control" name="sd_remarks" id="sd_remarks_1" cols="5" rows="5">{{$scrap_declration->sd_remarks}}</textarea>
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
                                                                    Scrap Category</th>
                                                                <th class="text-center">
                                                                    Item Name</th>
                                                                <th class="text-center">Item Code </th>
                                                                <th class="text-center">Item Description </th>
                                                                <th class="text-center">UOM </th>
                                                                <th class="text-center">Qty # </th>
                                                                <th class="text-center">Reason For Scrapping # </th>
                                                                <th>Remove</th>
                                                            </tr>
                                                        </thead>
                                                      
                                                        <tbody id="AppnedHtml">

                                                            @foreach ($scrap_declration->ScrapData ?? [] as $key => $detail)
                                                                <tr class="cnt" id="removeSection{{$key}}">
                                                                    <td>
                                                                        <select style="width:200px!important;" name="category_id[]" id="category_id_{{$key}}" class="form-control requiredField select2">
                                                                            <option value="">Select Scrap Category</option>
                                                                            <option {{$detail->category_id == 'iron' ? 'selected' : ''}} value="iron">Iron</option>
                                                                            <option {{$detail->category_id == 'plastic' ? 'selected' : ''}} value="plastic">Plastic</option>
                                                                            <option {{$detail->category_id == 'copper' ? 'selected' : ''}} value="copper">Copper</option>
                                                                            <option {{$detail->category_id == 'steel' ? 'selected' : ''}} value="steel">Steel</option>
                                                                            <option {{$detail->category_id == 'paper' ? 'selected' : ''}} value="paper">Paper</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select style="width:200px!important;" onchange="get_item_name({{$key}});get_pr_or_po(this.value,{{$key}})" name="item[]" id="item_id_{{$key}}" class="form-control requiredField select2 item_id">
                                                                            <option value="">Select Item</option>
                                                                            <option value="{{CommonHelper::get_item_name($detail->item_id)}}%{{$detail->uom}}%0%{{$detail->item_id}}%{{$detail->item_code}}" selected>{{CommonHelper::get_item_name($detail->item_id)}}</option>
                                                                        
                                                                        </select>
                                                                    </td>
                                                                    <td><input style="width:200px!important;" type="text"
                                                                        class="form-control " readonly name="item_code[]"
                                                                        id="item_code_{{$key}}"  value="{{$detail->item_code}}">
                                                                    </td>
                                                                    <td><input style="width:200px!important;" type="text"
                                                                        class="form-control " name="item_desc[]"
                                                                        id="item_desc_{{$key}}"  value="{{$detail->item_desc}}">
                                                                    </td>
                                                                    <td><input style="width:200px!important;" type="text"
                                                                            class="form-control " readonly name="uom[]"
                                                                            id="uom_{{$key}}"  value="{{$detail->uom}}">
                                                                    </td>
                                                                
                                                                    <td>
                                                                        <input style="width:200px!important;" type="text" class="form-control requiredField "  name="qty[]" id="qty_{{$key}}"  value="{{$detail->qty}}">
                                                                    </td>
                                                                    <td>
                                                                        <textarea style="width:200px!important;" class="form-control requiredField " name="reason_for_scrapping[]" id="reason_for_scrapping_{{$key}}">{{$detail->reason_for_scrapping}}</textarea>
                                                                    </td>
                                                                    
                                                                
                                                                    <td><span style="cursor:pointer" class="btn btn-danger btn-xs" onClick="removeSection({{$key}})">Remove</span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
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
