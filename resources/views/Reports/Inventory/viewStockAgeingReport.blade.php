<?php
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
$export = ReuseableCode::check_rights(240);
$ItemId = '';
$ItemName = '';
if (isset($_GET['item_id'])) {
    $ItemId = $_GET['item_id'];
    $ItemName = CommonHelper::get_item_name($ItemId);
} else {
    $ItemId = '';
    $ItemName = '';
}
$financial_year=ReuseableCode::get_account_year_from_to($_GET['m']);

if (isset($_GET['type'])):
    $type=$_GET['type'];
else:
$type=1;
endif;
?>
<?php use App\Helpers\PurchaseHelper; ?>
@extends('layouts.default')
@section('content')
    @include('select2')
    @include('modal')

    <style>
        element.style {
            width: 183px;
        }
        .table-responsive {
            scrollbar-width: thin;
            scrollbar-color: #333 #ccc;
            overflow: auto;
        }
    </style>


<div class="well_N">
    <div class="dp_sdw">    
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="well">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <span class="subHeadingLabelClass">Stock Aging Report</span>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                                    {{ CommonHelper::displayPrintButtonInBlade('filterBookDayList', 'HrefHide', '1') }}
                                    @if($export == true)
                                        <a id="dlink" style="display:none;"></a>
                                        <button type="button" class="btn btn-warning" onclick="ExportToExcel('data','StockReport')">Export
                                            <b>(xlsx)</b>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div class="row">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div  @if ($type==1) style="display: none;" @endif class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                    <label for="email">  From Date</label>
                                                    <input id="from_date"  required="required" min="{{$financial_year[0]}}" name="from_date" max="{{$financial_year[1]}}" class="date1 form-control" type="date" value="<?php echo $financial_year[0] ?>" />
                                                </div>
                                    
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <label for="email">  @if ($type==1) As On @else To Date @endif</label>
                                                    <input id="to_date" required="required" min="{{$financial_year[0]}}" max="{{$financial_year[1]}}" name="from_date" class="date1 form-control" type="date" value="{{$financial_year[1]}}" />
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group ">
                                                        <label for="email">Category </label>
                                                        <select onchange="get_sub_item('category_id1')" name="category" id="category_id1"
                                                            class="form-control category select2 normal_width">
                                                            <option value="">Select</option>
                                                            @foreach (CommonHelper::get_all_category() as $category)
                                                                <option value="{{ $category->id }}"> {{ $category->main_ic }} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group ">
                                                        <label for="email">Sub Item <span style="color: red">*</span></label>
                                                        <select name="item_id[]" id="item_id1" class="form-control select2">
                                                            <option value="">Select</option>
                                                            @foreach (CommonHelper::get_all_subitem() as $item)
                                                                <option value="{{$item->id}}">{{$item->sku_code.'-'.$item->sub_ic}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group ">
                                                        <label for="email">Item Type <span style="color: red">*</span></label>
                                                        <select name="demandType" id="demandType" class="form-control select2">
                                                            <option value="">Select</option>
                                                            @foreach (CommonHelper::get_all_demand_type() as $demandType)
                                                                <option value="{{ $demandType->id }}"> {{ $demandType->name }} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <label>Select Location:</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <select name="location" id="location"
                                                        class="form-control select2">
                                                        <option value="">Select Warehouse</option>
                                                        @foreach (CommonHelper::get_users_warehouse() as $warehouse)
                                                            <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                    <div>&nbsp;</div>
                                                    <button type="button" class="btn btn-sm btn-primary" style="margin: 5px 0px 0px px;"
                                                        onclick="viewStockAgeingReportDetail()">Submit</button>
                                                </div>
                                            </div>
                                            <div id="printBankReceiptVoucherList">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div id="tableData" class="table-responsive"></div>
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

    <script !src="">

        var ExportToExcel = (function() {
            var uri = 'data:application/vnd.ms-excel;base64,';
            var template =
                '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>';
            var base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)));
            };
            var format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                });
            };

            return function(table, name) {
                if (!table.nodeType)
                    table = document.getElementById(table);
                var ctx = {
                    worksheet: name || 'Sheet1',
                    table: table.innerHTML
                };
                var link = document.createElement('a');
                link.href = uri + base64(format(template, ctx));
                link.download = name ? name + "{{date('Y-m-d')}}" + '.xls' : 'table.xls';
                link.click();
            };
        })();


        $(document).ready(function() {
            $('.select2').select2();
        });

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

        $(document).ready(function() {
            var ItemId = '<?php echo $ItemId; ?>';
            if (ItemId != "") {
                BookDayList();
            }
        });

        function viewStockAgeingReportDetail() {
            var location = $('#location').val();
            var category = $('#category_id1').val();
            var demandType = $('#demandType').val();

            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            var sub_1 = $('#item_id1').val();
            var item_des = $('#item_des').val();
            var m = '<?php echo $_GET['m']; ?>';
            $('#tableData').html('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="loader"></div></div>');
            $.ajax({
                url: '<?php echo url('/'); ?>/reports/viewStockAgeingReportDetail',
                method: 'GET',
                data: {
                    location: location,
                    category: category,
                    demandType: demandType,
                    m: m,
                    sub_1: sub_1,
                    item_des: item_des,
                    from_date:from_date,
                    to_date:to_date,
                },
                success: function(response) {
                    $('#tableData').html(response);
                },
                error: function() {
                    alert('error');
                }
            });
        }

    </script>
@endsection
