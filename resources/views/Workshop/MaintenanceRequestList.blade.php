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
                                        <span class="subHeadingLabelClass">View Maintenance Request List</span>
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
                                            <option value="">Select Location</option>
                                            @foreach ($company_locations as $location)
                                            <option value="{{$location->id}}">{{$location->name}}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <button type="button" class="btn btn-primary" style="margin-top: 35px;" onclick="getMaintenanceRequestList()">Fetch</button>
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

                                                            <table id="table" class="table table-bordered">
                                                                <thead>
                                                                    <th>S.No</th>
                                                                    <th>Voucher NO</th>
                                                                    <th>Voucher Date</th>
                                                                    <th>Department</th>
                                                                    <th>Machine</th>
                                                                    <th>Warehouse</th>
                                                                    <th>Created By</th>
                                                                    <th>Action</th>
                                                                </thead>
                                                                <tbody id="maintenanceRequestList" class="text-center">
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
                getMaintenanceRequestList();
            });

            function getMaintenanceRequestList() {
                $('#maintenanceRequestList').html(
                    '<tr><td colspan="11"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div></div></div></td><tr>'
                );

                let from_date = $('#from_date').val();
                let last_date = $('#last_date').val();
                let company_location_id = $('#company_location_id').val();

                $.ajax({
                    url: '<?php echo url('/'); ?>/workshop/MaintenanceRequestList',
                    method: 'GET',
                    data: {from_date:from_date, last_date:last_date, company_location_id:company_location_id},
                    error: function() {
                        alert('error');
                    },
                    success: function(response) {
                        $('#maintenanceRequestList').html(response);
                    }
                });
            }

            function deleteMaintenanceRequest(id) {
                // alert("Delete Working");
                if(confirm('Are u sure want to delete this?')){
                    $.ajax({
                        url: '{{ url('/workshop/deleteMaintenanceRequest') }}',
                        data: {
                            id: id
                        },
                        type: 'GET',
                        success: function(response) {
                            if (response == "Deleted") {
                                alert('Successfully Delete');
                                getMaintenanceRequestList();
                            }else{
                                alert(response);
                            }
                        }
                    })
                }
            }
        </script>
    @endsection
