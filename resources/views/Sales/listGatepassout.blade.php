<?php

use App\Helpers\CommonHelper;
use App\Helpers\PurchaseHelper;

$accType = Auth::user()->acc_type;


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
                                        <span class="subHeadingLabelClass">List Gate Pass Out</span>
                                        <div class="row">
                                            {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label>Category:</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                <select autofocus name="category_id" id="category_id"
                                                    class="form-control requiredField select2" onchange="FetchSlabList()">
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $key => $y)
                                                        <option value="{{ $y->id }}"
                                                            {{ old('category_id') == $y->id ? 'selected' : '' }}>
                                                            {{ $y->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}
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
                                                                    <th class="text-center">Voucher NO</th>
                                                                    <th class="text-center">Inspection No</th>
                                                                    <th class="text-center">Date</th>
                                                                    <th class="text-center">Recived Qty</th>
                                                                    <th class="text-center">Created By</th>
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
                XLSX.writeFile(wb, fn || ('Commodities Product List.' + (type || 'xlsx')));
        }
        var loading = false;

        function FetchPOList() {
            // var category_id = $('#category_id').val();
            $('#viewProductList').html(
                '<tr><td colspan="7"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div></div></div></td><tr>'
            );
            $.ajax({
                url: '{{ url('arrival/getpass_out') }}',
                method: 'GET',
                // data: {
                //     category_id: category_id
                // },
                error: function() {
                    alert('error');
                },
                success: function(response) {
                    $('#viewProductList').html(response);
                }
            });
        }
    </script>
@endsection
