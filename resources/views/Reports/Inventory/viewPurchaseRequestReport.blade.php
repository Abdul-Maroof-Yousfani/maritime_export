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
                                        <span class="subHeadingLabelClass">Purchase Request Report</span>
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
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="sf-label">Select Company Location</label>
                                        <select class="form-control requiredField select2" name="company_location_id"
                                            id="company_location_id">
                                            <option value="">Select Location</option>
                                            @foreach ($company_locations as $company_location)
                                                <option value="{{$company_location->id}}">{{$company_location->location_name}}</option>
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
                                                                        <th class="text-center">PR NO# </th>
                                                                        <th class="text-center">PR DATE </th>
                                                                        <th class="text-center">ITEM NAME </th>
                                                                        <th class="text-center">REMARKS </th>
                                                                        <th class="text-center">UOM </th>
                                                                        <th class="text-center">QUANTITY </th>
                                                                        <th class="text-center">DEPARTMENT </th>
                                                                        <th class="text-center">MODE TYPE </th>
                                                                        <th class="text-center">LOCATION </th>
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
            GetPurchaseReport();
        });
        function GetPurchaseReport() {
            var FromDate = $('#FromDate').val();
            var ToDate = $('#ToDate').val();
            var company_location_id = $('#company_location_id').val();
            $('#data').html(
                '<tr><td colspan="14"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="loader"></div></div></div></td><tr>'
            );

            $.ajax({
                url: '{{ url('/reports/viewPurchaseRequestReport') }}',
                type: 'Get',
                data: {
                    FromDate: FromDate,
                    ToDate: ToDate,
                    company_location_id: company_location_id,
                },
                success: function(response) {
                    $('#data').html(response);
                }
            });
        }
    </script>
@endsection
