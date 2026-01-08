<?php

use App\Helpers\CommonHelper;
use App\Helpers\FinanceHelper;
use App\Helpers\ReuseableCode;
$export = ReuseableCode::check_rights(245);
$accType = Auth::user()->acc_type;
if ($accType == 'client') {
    $m = $_GET['m'];
} else {
    $m = Auth::user()->company_id;
}
$current_date = date('Y-m-d');
$currentMonthStartDate = date('Y-m-01');
$currentMonthEndDate = date('Y-m-t');

$AccYearDate = DB::table('company')
    ->select('accyearfrom', 'accyearto')
    ->where('id', $_GET['m'])
    ->first();
$AccYearFrom = $AccYearDate->accyearfrom;
$AccYearTo = $AccYearDate->accyearto;

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
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <span class="subHeadingLabelClass">Material Issuance Report</span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                                        <?php if($export == true):?>
                                        <a id="dlink" style="display:none;"></a>
                                        <button type="button" class="btn btn-warning"
                                            onclick="ExportToExcel('expToExcel','Material_Issuance_Report')">Export
                                            <b>(xlsx)</b></button>
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>From Date</label>
                                        <input type="Date" name="FromDate" id="FromDate" min="<?php echo $AccYearFrom; ?>"
                                            max="<?php echo $AccYearTo; ?>" value="<?php echo $currentMonthStartDate; ?>" class="form-control" />
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>To Date</label>
                                        <input type="Date" name="ToDate" id="ToDate" min="<?php echo $AccYearFrom; ?>"
                                            max="<?php echo $AccYearTo; ?>" value="<?php echo $currentMonthEndDate; ?>" class="form-control" />
                                    </div>
                                    {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Select Supplier</label>
                                        <select name="supplier" class="form-control select2" id="supplier">
                                            <option value="0">Select supplier</option>
                                            @foreach (CommonHelper::get_all_supplier() as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Select Department</label>
                                        <select name="depart[]" class="form-control select2" id="depart" multiple>
                                            <option value="0">Select Department</option>
                                            @foreach (CommonHelper::get_all_sub_department() as $subDepart)
                                                <option value="{{ $subDepart->id }}">{{ $subDepart->sub_department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Select Category</label>
                                        <select name="category" class="form-control select2"
                                            onchange="get_category_wise_sub_item()" id="category">
                                            <option value="0">Select Category</option>
                                            @foreach (CommonHelper::get_all_category() as $category)
                                                <option value="{{ $category->id }}">{{ $category->main_ic }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Select Item</label>
                                        <select name="item" class="form-control select2" id="item">
                                            <option value="0">Select item</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Select Warehouse</label>
                                        <select name="warehouse_id" class="form-control select2" id="warehouse_id">
                                            <option value="0">Select Warehouse</option>
                                            @foreach (App\Models\Warehouse::all() as $warehouse)
                                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Select Machinery</label>
                                        <select name="machinery_id" class="form-control select2" id="machinery_id">
                                            <option value="0">Select Machinery</option>
                                            @foreach (App\Models\Machinery::all() as $Machinery)
                                                <option value="{{ $Machinery->id }}">{{ $Machinery->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Select Line</label>
                                        <select name="line_id" class="form-control select2" id="line_id">
                                            <option value="0">Select Line</option>
                                            @foreach (App\Models\Line::all() as $Line)
                                                <option value="{{ $Line->id }}">{{ $Line->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label class="sf-label">Company Location</label>
                                        <select class="form-control requiredField select2" name="company_location_id"
                                            id="company_location_id">
                                            <option value="">Select Location</option>
                                            @foreach (ReuseableCode::getUserWiseLocationRightsData() as $company_location)
                                                <option value="{{$company_location['id']}}">{{$company_location['location_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <input type="button" value="Submit" class="btn btn-sm btn-primary"
                                            onclick="GetPurchaseReport();" style="margin-top: 32px;" />
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div id="printBankPaymentVoucherList">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="panel">
                                                <div class="panel-body">
                                                    <?php echo CommonHelper::headerPrintSectionInPrintView($m); ?>

                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="table-responsive">
                                                                <h5 style="text-align: center" id="h3"></h5>
                                                                <table class="table table-bordered sf-table-list"
                                                                    id="expToExcel">
                                                                    <thead>
                                                                        <th class="text-center">SR.NO </th>
                                                                        <th class="text-center">ISSUANCE NO </th>
                                                                        <th class="text-center">ISSUANCE DATE </th>
                                                                        <th class="text-center">SKU </th>
                                                                        <th class="text-center">ITEM NAME </th>
                                                                        <th class="text-center">WAREHOUSE</th>
                                                                        <th class="text-center">Department</th>
                                                                        <th class="text-center">MACHINERY</th>
                                                                        <th class="text-center">LINES</th>
                                                                        <th class="text-center">QTY </th>
                                                                        <th class="text-center">Location </th>

                                                                    </thead>
                                                                    <tbody id="data">
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
        </div>
    </div>
    {{-- <script src="{{ URL::asset('assets/custom/js/exportToExcelXlsx.js') }}"></script> --}}
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
        // function ExportToExcel(type, fn, dl) {
        //     var elt = document.getElementById('expToExcel');
        //     var wb = XLSX.utils.table_to_book(elt, {
        //         sheet: "sheet1"
        //     });
        //     return dl ?
        //         XLSX.write(wb, {
        //             bookType: type,
        //             bookSST: true,
        //             type: 'base64'
        //         }) :
        //         XLSX.writeFile(wb, fn || ('Material_Issuance_Report_<?php echo date('Y-m-d'); ?>.' + (type || 'xlsx')));
        // }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
            GetPurchaseReport();
        });

        function get_category_wise_sub_item() {
            var category = $('#category').val();
            $('#item').html('');
            $.ajax({
                url: '{{ url('/pdc/get_sub_category') }}',
                type: 'Get',
                data: {
                    category: category
                },
                success: function(response) {
                    $('#item').append(new Option('Select', '0'))
                    $.each(response, function(index, element) {
                        $('#item').append(new Option(element['sub_ic'], element['id']))
                    });
                }
            });
        }


        function GetPurchaseReport() {
            var FromDate = $('#FromDate').val();
            var ToDate = $('#ToDate').val();
            var supplier = $('#supplier').val();
            var depart = $('#depart').val();
            var category = $('#category').val();
            var item = $('#item').val();
            var warehouse_id = $('#warehouse_id').val();
            var machinery_id = $('#machinery_id').val();
            var line_id = $('#line_id').val();
            var company_location_id = $('#company_location_id').val();

            var m = '<?php echo $m; ?>';
            $('#data').html(
                '<tr><td colspan="14"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="loader"></div></div></div></td><tr>'
            );
            $.ajax({
                url: '{{ url('/reports/viewMaterialReport') }}',
                type: 'Get',
                data: {
                    FromDate: FromDate,
                    ToDate: ToDate,
                    m: m,
                    ajax: 1,
                    supplier: supplier,
                    depart: depart,
                    category: category,
                    item: item,
                    warehouse_id: warehouse_id,
                    machinery_id: machinery_id,
                    line_id: line_id,
                    company_location_id: company_location_id,
                },
                success: function(response) {
                    $('#data').html(response);
                }
            });
        }
    </script>
@endsection
