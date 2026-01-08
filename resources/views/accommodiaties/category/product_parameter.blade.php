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
                                        <span class="subHeadingLabelClass">View Item Parameter</span>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label>Item:</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                <select autofocus name="subitem_id" id="subitem_id"
                                                    class="form-control requiredField select2" onchange="FetchSlabList()">
                                                    <option value="">Select Item</option>
                                                    @foreach ($products as $key => $y)
                                                        <option value="{{ $y->id }}"
                                                            {{ old('subitem_id') == $y->id ? 'selected' : '' }}>
                                                            {{ $y->name }}</option>
                                                    @endforeach
                                                </select>
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
                                                        <form action="{{ route('product.SubmitVariety') }}" method="post"
                                                        id="yourFormId2">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <div class="table-responsive">

                                                            <table id="table" class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">Moisture (KG)</th>
                                                                        <th class="text-center">Damage (RS)</th>
                                                                        <th class="text-center">Chalky (RS)</th>
                                                                        <th class="text-center">Broken (RS)</th>
                                                                        <th class="text-center">O.V (RS)</th>
                                                                        <th class="text-center">CHOBBA (RS)</th>
                                                                        <th class="text-center">Look (RS)</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="viewProductList">
                                                                </tbody>
                                                            </table>


                                                        </div>
                                                        <div style="margin-top: 8%" class="lineHeight">&nbsp;</div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                                            {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                                           
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

        function FetchSlabList() {
            var subitem_id = $('#subitem_id').val();
            $('#viewProductList').html(
                '<tr><td colspan="7"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div></div></div></td><tr>'
            );
            $.ajax({
                url: '{{ route('product.ShowVariety') }}',
                method: 'GET',
                data: {
                    subitem_id: subitem_id
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
                    url: '{{ url('commodities/delete_product') }}',
                    data: {
                        id: id
                    },
                    type: 'GET',
                    success: function(response) {
                        alert(response);
                        if(response=='Deleted'){
                            FetchSlabList();
                        }
                    }
                })
            }
        }

        function copyRow(paramId) {
            // Use jQuery to get the clicked row
            var row = $('#copy_row' + paramId);

            // Extract values using jQuery .data() method
            var moisture = row.find('[data-moisture]').data('moisture');
            var damage = row.find('[data-damage]').data('damage');
            var chalky = row.find('[data-chalky]').data('chalky');
            var broken = row.find('[data-broken]').data('broken');
            var o_v = row.find('[data-o_v]').data('o_v');
            var chobba = row.find('[data-chobba]').data('chobba');
            var look = row.find('[data-look]').data('look');

            // Set values in the input fields below using jQuery
            $('#moisture').val(moisture);
            $('#damage').val(damage);
            $('#chalky').val(chalky);
            $('#broken').val(broken);
            $('#o_v').val(o_v);
            $('#chobba').val(chobba);
            $('#look').val(look);
        }

        // function copyRow(button) {
        //     // Get the current row based on the button clicked
        //     let currentRow = $(button).closest('tr');
            
        //     // Clone the current row
        //     let rowId = currentRow.data('id');
        //     let product_id = currentRow.data('product_id');

        //     $.ajax({
        //         url: '{{ url('commodities/UpdateVariety') }}',
        //         data: {
        //             id: rowId,
        //             product_id: product_id,
        //         },
        //         type: 'GET',
        //         success: function(response) {
        //             currentRow.find('td:nth-child(4)').text('Inactive');
        //             let clonedRow = currentRow.clone();
        //             let tableBody = $('#viewProductList');
        //             let rowCount = tableBody.find('tr').length;
        //             clonedRow.find('td:last').html('<span>Copied</span>');
        //             tableBody.append(clonedRow);
        //         }
        //     });

            
        // }
    </script>
@endsection
