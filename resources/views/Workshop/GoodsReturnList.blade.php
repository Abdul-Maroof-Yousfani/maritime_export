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
                                        <span class="subHeadingLabelClass">View Workshop Goods Return List</span>
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
                                                                    <th>S.No</th>
                                                                    <th>MR Voucher NO</th>
                                                                    <th>MJ Voucher NO</th>
                                                                    <th>Voucher NO</th>
                                                                    <th>Voucher Date</th>
                                                                    <th>Return Date</th>
                                                                    <th>From Department</th>
                                                                    <th>Warehouse</th>
                                                                    <th>Action</th>
                                                                </thead>
                                                                <tbody id="GoodsReturnList" class="text-center">
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
                getGoodsReturnList();
            });

            function getGoodsReturnList() {
                $('#GoodsReturnList').html(
                    '<tr><td colspan="11"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div></div></div></td><tr>'
                );
                $.ajax({
                    url: '<?php echo url('/'); ?>/workshop/GoodsReturnList',
                    method: 'GET',
                    data: {},
                    error: function() {
                        alert('error');
                    },
                    success: function(response) {
                        $('#GoodsReturnList').html(response);
                    }
                });
            }

            function deleteMaintenanceJob(id) {
                alert("Delete Working");
                // $.ajax({
                //     url: '{{ url('/pdc/approved_stock_issuance') }}',
                //     data: {
                //         item: id
                //     },
                //     type: 'GET',
                //     success: function(response) {
                //         if (response.error == 'error') {
                //             alert('Can not Approved Because the Item is not exist in Record ' + response.message)
                //             return false;
                //         } else if (response.error == 'success') {

                //             alert('Approved Successfully');
                //             $('#approved').remove();
                //             getWordOrderData();
                //         }
                //     }
                // })
            }
        </script>
    @endsection
