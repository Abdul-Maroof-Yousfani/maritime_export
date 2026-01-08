<?php

use App\Helpers\CommonHelper;
use App\Helpers\PurchaseHelper;

$accType = Auth::user()->acc_type;
if ($accType == 'client') {
    $m = $_GET['m'];
} else {
    $m = Auth::user()->company_id;
}

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
                                        <span class="subHeadingLabelClass">View Pending Issuance List</span>
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
                                                                    <th class="text-center">Material Request NO</th>
                                                                    <th class="text-center">Material Request Date</th>
                                                                    <th class="text-center">Department</th>
                                                                    <th class="text-center">Machinery</th>
                                                                    <th class="text-center">Line Name</th>
                                                                </thead>
                                                                <tbody id="viewProductList">
                                                                    @foreach ($material_requests as $key => $material_request)
                                                                        <tr class="text-center">
                                                                            <td>{{++$key}}</td>
                                                                            <td>{{strtoupper($material_request['mr_no'])}}</td>
                                                                            <td>{{date('d-m-Y', strtotime($material_request['mr_date']))}}</td>
                                                                            <td>{{optional($material_request->department)->sub_department_name}}</td>
                                                                            <td>{{optional($material_request->machine)->name}}</td>
                                                                            <td>{{optional($material_request->line)->name}}</td>
                                                                    
                                                                        </tr>
                                                                    @endforeach
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

    </script>
@endsection
