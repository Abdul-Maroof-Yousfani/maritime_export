<?php

use App\Helpers\CommonHelper;
use App\Helpers\PurchaseHelper;

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
                                        <span class="subHeadingLabelClass">View BOM Summary Report</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">

                                    <button type="button" class="btn btn-warning" onclick="ExportToExcel('xlsx')">Export
                                        <b>(xlsx)</b></button>

                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <div class="form-group">
                                          <label for="from_date">From Date</label>
                                          <input type="date" class="form-control" name="from_date" id="from_date" aria-describedby="from_date" placeholder="From Date" value="{{date('Y-m-01')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <div class="form-group">
                                          <label for="last_date">To Date</label>
                                          <input type="date" class="form-control" name="last_date" id="last_date" aria-describedby="last_date" placeholder="last Date" value="{{date('Y-m-t')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <div class="form-group">
                                          <label for="company_location_id">Company Location</label>
                                          <select class="form-control form-control-sm" name="company_location_id" id="company_location_id">
                                            <!-- <option value="">Select Location</option> -->
                                            @foreach ($company_locations as $location)
                                            <option value="{{$location->id}}">{{$location->name}}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <button type="button" class="btn btn-primary" style="margin-top: 35px;" onclick="getProcessTrackingSummaryReport()">Fetch</button>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="table-responsive">
                                                            <table id="table" class="table table-bordered sf-table-list">
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="4"></td>
                                                                        <th colspan="4" class="text-center">Maintenance Request Detail</td>
                                                                        <th colspan="4" class="text-center">Maintenance Job Detail</td>
                                                                        <th colspan="11" class="text-center">BOM Detail</td>
                                                                        {{-- <th colspan="3" class="text-center">Gate Pass Out Detail</td>
                                                                        <th colspan="3" class="text-center">Gate Pass In Detail</td>
                                                                        <th colspan="3" class="text-center">Goods Receipt Note Detail</td>
                                                                        <th colspan="3" class="text-center">Material Request Detail</td> --}}
                                                                    <tr>
                                                                    <tr>
                                                                        <th class="text-center">S.No</th>
                                                                        <th class="text-center">Warehouse</th>
                                                                        <th class="text-center">Department</th>
                                                                        <th class="text-center">Line No</th>
                                                                        <th class="text-center">Item Name</th>
                                                                        <th class="text-center">M.R.No.</th>
                                                                        <th class="text-center">M.R.Date</th>
                                                                        <th class="text-center">Qty</th>
                                                                        <th class="text-center">Status</th>
                                                                        <th class="text-center">M.J.No</th>
                                                                        <th class="text-center">M.J.Date</th>
                                                                        <th class="text-center">Job Type</th>
                                                                        <th class="text-center">Status</th>
                                                                        <th class="text-center">BOM.No</th>
                                                                        <th class="text-center">BOM.Date</th>
                                                                        <th class="text-center">Status</th>
                                                                        <th class="text-center">BOM.Item</th>
                                                                        <th class="text-center">BOM.Qty</th>
                                                                        <th class="text-center">BOM.Return Qty</th>
                                                                        <th class="text-center">BOM.Total Qty</th>
                                                                        <th class="text-center">BOM.Rate</th>
                                                                        <th class="text-center">BOM.Total Amount</th>
                                                                        <th class="text-center">Labour Hour</th>
                                                                        <th class="text-center">Labour Wage</th>
                                                                        {{-- <th class="text-center">GPO.No</th>
                                                                        <th class="text-center">GPO.Date</th>
                                                                        <th class="text-center">Status</th>
                                                                        <th class="text-center">GPI.No</th>
                                                                        <th class="text-center">GPI.Date</th>
                                                                        <th class="text-center">Status</th>
                                                                        <th class="text-center">GRN.No</th>
                                                                        <th class="text-center">GRN.Date</th>
                                                                        <th class="text-center">Status</th>
                                                                        <th class="text-center">Material Request No</th>
                                                                        <th class="text-center">Material Request Date</th> --}}
                                                                        {{-- <th class="text-center">Status</th> --}}
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="getProcessTrackingSummaryReport"></tbody>
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
                    XLSX.writeFile(wb, fn || ('maintenance_invoice_summary.' + (type || 'xlsx')));
            }
            //viewSubItemList();
        </script>
        <script>
            var loading = false;
            $(document).ready(function() {
                $('.select2').select2();
                getProcessTrackingSummaryReport();
            });

            function getProcessTrackingSummaryReport() {
                $('#getProcessTrackingSummaryReport').html(
                    '<tr><td colspan="100"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div></div></div></td><tr>'
                );
                let url = "";
                url = '<?php echo url('/'); ?>/workshop/viewMaintenanceInvoiceSummary';
                let from_date = $('#from_date').val();
                let last_date = $('#last_date').val();
                let company_location_id = $('#company_location_id').val();
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: {from_date:from_date, last_date:last_date, company_location_id:company_location_id},
                    error: function() {
                        alert('error');
                    },
                    success: function(response) {
                        $('#getProcessTrackingSummaryReport').html(response);
                    }
                });
            }
        </script>
    @endsection
