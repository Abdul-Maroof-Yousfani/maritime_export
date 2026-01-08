<?php

use App\Helpers\CommonHelper;
use App\Helpers\PurchaseHelper;

$accType = Auth::user()->acc_type;
if ($accType == 'client') {
    $m = $_GET['m'];
} else {
    $m = Auth::user()->company_id;
}
$current_date = date('Y-m-d');
$from = date('Y-m-01');
$to = date('Y-m-t');
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
                                        <span class="subHeadingLabelClass">View Gate Pass List</span>
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                    <label>From Date</label>
                                                    <input type="Date" name="FromDate" id="FromDate"
                                                        max="<?php echo $current_date; ?>"
                                                        value="<?php echo $from; ?>" class="form-control" />
                                                </div>
    
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                    <label>To Date</label>
                                                    <input type="Date" name="ToDate" id="ToDate"
                                                        max="<?php echo $current_date; ?>"
                                                        value="<?php echo $to ?>" class="form-control" />
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <input type="button" value="Fetch Gate Pass"
                                                        class="btn btn-sm btn-primary"
                                                        onclick="FetchPOList();"
                                                        style="margin-top: 32px;" />
                                                </div>
                                            </div>
                                        </div>
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
                                                                    <th class="text-center">Gate Pass NO</th>
                                                                    <th class="text-center">Gate Pass Type</th>
                                                                    <th class="text-center"> Date</th>
                                                                    <th class="text-center">Vendor Name</th>
                                                                    <th class="text-center">Warehouse</th>
                                                                    <th class="text-center">Action</th>
                                                                </thead>
                                                                <tbody id="viewProductList">
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
    <script src="{{ URL::asset('assets/custom/js/exportToExcelXlsx.js') }}"></script>
    <script>
        $(function() {
            $('select').select2();
            FetchPOList();
        });

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
                XLSX.writeFile(wb, fn || ('Gate Pass.' + (type || 'xlsx')));
        }
        var loading = false;

        function FetchPOList() {
            var from_date = $('#FromDate').val();
            var to_date = $('#ToDate').val();
            $('#viewProductList').html(
                '<tr><td colspan="7"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div></div></div></td><tr>'
            );
            $.ajax({
                url: '{{ url('purchase/gate_pass') }}',
                method: 'GET',
                data: {
                    from_date: from_date,
                    to_date: to_date
                },
                error: function() {
                    alert('error');
                },
                success: function(response) {
                    $('#viewProductList').html(response);
                }
            });
        }

        function delete_gactepass(id) {
                // alert("Delete Working");
            if(confirm('Are u sure you want to delete this?')){
                $.ajax({
                    url: '{{ url('purchase/delete_gatepass') }}',
                    data: {
                        id: id
                    },
                    type: 'GET',
                    success: function(response) {
                        // alert(response);
                        if(response=='Deleted'){
                            FetchPOList();
                        }
                    }
                })
            }
        }

        function gatepass_received(id) {
                // alert("Delete Working");
            if(confirm('Are u sure you want to Recieve this Returnable?')){
                $.ajax({
                    url: '{{ url('purchase/gatepass_received') }}',
                    data: {
                        id: id
                    },
                    type: 'GET',
                    success: function(response) {
                        // alert(response);
                        if(response=='success'){
                            FetchPOList();
                        }
                    }
                })
            }
        }
    </script>
@endsection
