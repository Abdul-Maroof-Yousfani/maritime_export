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
                                        <span class="subHeadingLabelClass">View Workshop GRN List</span>
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
                                            <option value="{{$location->id}}">{{$location->location_name}}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <button type="button" class="btn btn-primary" style="margin-top: 35px;" onclick="getviewGRNList()">Fetch</button>
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
                                                                    <th>MJ Voucher NO</th>
                                                                    <th>GPI Voucher NO</th>
                                                                    <th>Voucher NO</th>
                                                                    <th>Voucher Date</th>
                                                                    <th>Supplier</th>
                                                                    <th>Location</th>
                                                                    <th>Action</th>
                                                                </thead>
                                                                <tbody id="viewGRNList" class="text-center">
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
                getviewGRNList();
            });

            function getviewGRNList() {
                $('#viewGRNList').html(
                    '<tr><td colspan="11"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div></div></div></td><tr>'
                );
                let url = "";
                url = '<?php echo url('/'); ?>/workshop/viewGRNList';

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
                        $('#viewGRNList').html(response);
                    }
                });
            }

            function deleteWorkshopGrn(id) {
                alert("Delete Working");
                $.ajax({
                    url: '{{ url('/workshop/deleteWorkshopGrn') }}',
                    data: {
                        id: id
                    },
                    type: 'GET',
                    success: function(response) {
                       if(response == "deleted"){
                        getviewGRNList();
                       }else{
                        alert('Something went wrong');
                       }
                    }
                })
            }
        </script>
    @endsection
