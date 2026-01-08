<?php

use App\Helpers\CommonHelper;
use App\Helpers\PurchaseHelper;

$accType = Auth::user()->acc_type;
if ($accType == 'client') {
    $m = $_GET['m'];
} else {
    $m = Auth::user()->company_id;
}

?>
@extends('layouts.default')

@section('content')
    @include('select2')
    <div class="well_N">
        <div class="dp_sdw">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="well">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-group ">
                                                    <label for="email">Category</label>
                                                    <select name="category_id" id="category_id"
                                                        onchange="get_category_wise_sub_category()"
                                                        class="form-control  select2">
                                                        <?php echo PurchaseHelper::categoryList($_GET['m'], '0'); ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-group ">
                                                    <label for="email">Item</label>
                                                    <select name="item_id" id="item_id"
                                                        class="form-control  select2" width="183px;">
                                                        <option value="">Select Item</option>
                                                        @foreach (CommonHelper::get_all_subitem() as $item)
                                                            <option value="{{$item->id}}">{{$item->sku_code.'-'.$item->sub_ic}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-top: 31px">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-success"
                                                        onclick="BookDayList();">Submit</button>
                                                </div>
                                            </div>

                                        </div>
                                        <span class="subHeadingLabelClass">View Sub Item List</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">

                                    <button type="button" class="btn btn-warning" onclick="ExportToExcel('xlsx')">Export
                                        <b>(xlsx)</b></button>

                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="table-responsive">

                                                            <table id="table" class="table table-bordered">
                                                                <thead>
                                                                    <th class="text-center">S.No</th>
                                                                    <th class="text-center">Category Name</th>
                                                                    {{-- <th class="text-center">Item  Code</th> --}}
                                                                    <th class="text-center">Sub Item Name</th>
                                                                    <th class="text-center">Item Type</th>
                                                                    <th class="text-center">SKU Code</th>
                                                                    <th class="text-center">Pack Size</th>
                                                                    <th class="text-center">BarCode</th>
                                                                    <th class="text-center">Created By</th>
                                                                    <th class="text-center">Action</th>
                                                                </thead>
                                                                <tbody id="viewSubItemList" class="text-center">
                                                                </tbody>
                                                            </table>


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
        </div>
        <script src="{{ URL::asset('assets/custom/js/exportToExcelXlsx.js') }}"></script>
        <script !src="">
            function ExportToExcel(type, fn, dl) {
                var elt = document.getElementById('table');
                var wb = XLSX.utils.table_to_book(elt, {
                    sheet: "sheet1"
                });
                return dl ?
                    XLSX.write(wb, {
                        bookType: type,
                        bookSST: true,
                        type: 'base64'
                    }) :
                    XLSX.writeFile(wb, fn || ('Sub Item List.' + (type || 'xlsx')));
            }
            //viewSubItemList();
        </script>
        <script>
            var loading = false;
            $(document).ready(function() {
                $('.select2').select2();
            });

            function get_category_wise_sub_category() {
                var category_id = $('#category_id').val();
                if (category_id > 0) {
                    $.ajax({
                        url: '<?php echo url('/'); ?>/pmfal/get_category_wise_sub_category',
                        type: "GET",
                        data: {
                            category_id: category_id
                        },
                        success: function(data) {
                            $('#sub_category_id').html(data);
                        }
                    });
                } else {
                    $('#sub_category_id').html('');
                }

            }

            function subItemListLoadDepandentCategoryId(id, value) {
                //alert(id+' --- '+value);
                var arr = id.split('_');
                var m = '<?php echo $_GET['m']; ?>';
                $.ajax({
                    url: '<?php echo url('/'); ?>/pmfal/subItemListLoadDepandentCategoryId',
                    type: "GET",
                    data: {
                        id: id,
                        m: m,
                        value: value
                    },
                    success: function(data) {
                        $('#sub_item_id_' + arr[2] + '_' + arr[3] + '').html(data);
                    }
                });
            }

            function BookDayList() {
                //if (loading == false) {
                var category = $('#category_id').val();
                // var sub_category = $('#sub_category_id').val();
                var item_id = $('#item_id').val();
                var m = '<?php echo $_GET['m']; ?>';
                // if (category != "" || item_id != "") {
                    $('#viewSubItemList').html(
                        '<tr><td colspan="8"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div></div></div></td><tr>'
                    );
                    $.ajax({
                        url: '<?php echo url('/'); ?>/pdc/viewSubItemListAjax',
                        method: 'GET',
                        data: {
                            category: category,
                            item_id: item_id,
                            m: m
                        },
                        error: function() {
                            alert('error');
                        },
                        success: function(response) {
                            $('#viewSubItemList').html(response);
                        }
                    });
                // } else {
                //     //loading = true;
                // }
            }


            
        </script>



        {{-- <script type="text/javascript">
            function viewSubItemList() {
                if (loading == false) {
                    loading = true;
                    $('#viewSubItemList').html(
                        '<tr><td colspan="7"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div></div></div></td><tr>'
                        );
                    var m = '{{$_GET['m']}}';
                    $.ajax({
                        url: '{{url('/')}}/pdc/viewSubItemList',
                        type: "GET",
                        data: {
                            m: m
                        },
                        success: function(data) {
                            setTimeout(function() {
                                $('#viewSubItemList').html(data);
                            }, 1000);
                            loading = false;
                        }
                    });
                } else {
                    alert("Wait Loading");
                }
            }
        </script> --}}
    @endsection
