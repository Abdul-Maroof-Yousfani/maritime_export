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
                                        <span class="subHeadingLabelClass">View Arrival Report List</span>
                                        <div class="row" style="margin-top: 2%">
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
                                                <input type="button" value="Fetch Arrival Report"
                                                    class="btn btn-sm btn-primary"
                                                    onclick="FetchPOList();"
                                                    style="margin-top: 32px;" />
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
                                                                 
                                                                    <th class="text-center">Arrival No </th>
                                                                    <th class="text-center">Arrival Date </th>
                                                                    <th class="text-center">Company Location </th>
                                                                    <th class="text-center">Created By </th>
                                                                  
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
                url: '{{ url('purchase/arrival_report') }}?pageType=&&parentCode=242&&m='+{{$m}}+'#Garibsons',
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

        function delete_ar(id) {
                // alert("Delete Working");
            if(confirm('Are u sure you want to delete this?')){
                $.ajax({
                    url: '{{ url('purchase/delete_arrival_report') }}',
                    data: {
                        id: id
                    },
                    type: 'GET',
                    success: function(response) {
                        alert(response);
                        if(response=='Deleted'){
                            FetchPOList();
                        }
                    }
                })
            }
        }

        function approve_ar(id) {
                // alert("Delete Working");
            if(confirm('Are u sure you want to approve this?')){
                $.ajax({
                    url: '{{ url('purchase/approve_arrival_report') }}',
                    data: {
                        id: id
                    },
                    type: 'GET',
                    success: function(response) {
                        alert(response);
                        if(response=='Approved'){
                            FetchPOList();
                        }else{
                            alert(response + 'Data Not Inserted')
                        }
                    }
                })
            }
        }
        function approve(id) {
            let isValid = true;
            let message = 'Please fill in the following fields:\n';
            let formData = [];

            // Iterate over each row in the table
            $('#acknowledge tr').each(function() {
                // Get the values of inputs and textarea in the current row
                let data_id = $(this).find('input[name="data_id[]"]').val();
                let acceptedQty = $(this).find('input[name="accepted_qty[]"]').val();
                let rejectedQty = $(this).find('input[name="rejected_qty[]"]').val();
                let remarks = $(this).find('textarea[name="accept_reject_remarks[]"]').val();

                // Check if any of the fields are empty
                if (acceptedQty === '' || rejectedQty === '' || remarks === '') {
                    isValid = false;
                    message += `Row ${$(this).index() + 1} is incomplete.\n`;
                }

                // Add row data to the formData array
                formData.push({
                    data_id: data_id,
                    accepted_qty: acceptedQty,
                    rejected_qty: rejectedQty,
                    accept_reject_remarks: remarks
                });
            });
            
            // If any field is empty, show an alert
            if (!isValid) {
                alert(message);
                return false;
            }
                $.ajax({
                    url: '{{ url('purchase/AcknowledgedArrival') }}',
                    data: {
                        formData: formData,
                        id: id,
                    },
                    type: 'GET',
                    success: function(response) {
                        if(response=='Approved'){
                            location.reload();
                        }
                    }
                })
            }
    </script>
@endsection
