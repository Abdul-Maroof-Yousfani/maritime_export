<?php

use App\Helpers\CommonHelper;
use App\Helpers\FinanceHelper;
use App\Helpers\ReuseableCode;
$export = ReuseableCode::check_rights(245);
$accType = Auth::user()->acc_type;
// if ($accType == 'client') {
//     $m = $_GET['m'];
// } else {
//     $m = Auth::user()->company_id;
// }
$m = Session::get('run_company');
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
                                        <span class="subHeadingLabelClass">Purchase Detail Report</span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                                        <?php if($export == true):?>
                                        <a id="dlink" style="display:none;"></a>
                                        <button type="button" class="btn btn-warning"
                                            onclick="ExportToExcel('xlsx')">Export <b>(xlsx)</b></button>
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
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Select Department</label>
                                        <select name="depart" class="form-control select2" id="depart">
                                            <option value="0">Select Department</option>
                                            @foreach (CommonHelper::get_all_sub_department() as $subDepart)
                                                <option value="{{ $subDepart->id }}">{{ $subDepart->sub_department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div> --}}
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
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Select GRN Received Type</label>
                                        <select name="received_type" id="received_type"
                                            class="form-control requiredField select2 received_type">
                                            <option value="">ALL</option>
                                            <option value="Complete">Complete</option>
                                            <option value="Partial">Partial</option>
                                            <option value="Short">Short</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>PO NO</label>
                                        <input type="text" name="po_no" id="po_no" class="form-control" />
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>GRN NO</label>
                                        <input type="text" name="grn_no" id="grn_no" class="form-control" />
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Store Control No</label>
                                        <input type="text" name="store_control_no" id="store_control_no" class="form-control" />
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="sf-label">Select Company Location</label>
                                        <select class="form-control requiredField select2" name="company_location_id"
                                            id="company_location_id">
                                            <option value="">Select Location</option>
                                            @foreach (ReuseableCode::getUserWiseLocationRightsData() as $company_location)
                                                <option value="{{$company_location->id}}">{{$company_location->location_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                        <input type="button" value="Submit" class="btn btn-sm btn-primary"
                                            onclick="GetPurchaseReport();"/>
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
                                                                        <th class="text-center">ITEM NAME </th>
                                                                        <th class="text-center">Supplier NAME </th>
                                                                        <th class="text-center">PR NO </th>
                                                                        <th class="text-center">Quotation NO </th>
                                                                        <th class="text-center">PO No </th>
                                                                        <th class="text-center">GRN # </th>
                                                                        <th class="text-center">Delivery Challan No</th>
                                                                        <th class="text-center">GRN Date</th>
                                                                        <th class="text-center">GRN Received Type</th>
                                                                        <th class="text-center">PURCHASE QTY </th>
                                                                        <th class="text-center">PURCHASE AMOUNT </th>
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
    <script src="{{ URL::asset('assets/custom/js/exportToExcelXlsx.js') }}"></script>
    <script !src="">
        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('expToExcel');
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: "sheet1"
            });
            return dl ?
                XLSX.write(wb, {
                    bookType: type,
                    bookSST: true,
                    type: 'base64'
                }) :
                XLSX.writeFile(wb, fn || ('Purchase Detail Report <?php echo date('Y-m-d'); ?>.' + (type || 'xlsx')));
        }
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
            var grn_no = $('#grn_no').val();
            var store_control_no = $('#store_control_no').val();
            var item = $('#item').val();
            
            var received_type = $('#received_type').val();
            var po_no = $('#po_no').val();
            var company_location_id = $('#company_location_id').val();
            

            var m = '<?php echo $m; ?>';
            $('#data').html(
                '<tr><td colspan="14"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="loader"></div></div></div></td><tr>'
            );

            $.ajax({
                url: '{{ url('/reports/viewPurchaseReport') }}',
                type: 'Get',
                data: {
                    FromDate: FromDate,
                    ToDate: ToDate,
                    m: m,
                    company_location_id: company_location_id,
                    ajax: 1,
                    grn_no: grn_no,
                    store_control_no: store_control_no,
                    supplier: supplier,
                    depart: depart,
                    category: category,
                    item: item,
                    received_type: received_type,
                    po_no: po_no,
                },
                success: function(response) {
                    $('#data').html(response);
                }
            });
        }
    </script>
@endsection
