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
                                        <span class="subHeadingLabelClass">Product Quality Deduction Slab List</span>
                                        <!-- <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                    <button type="button" class="btn btn-warning" id="importButton">Import Item 
                                        </button>
                                </div>  -->
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label>Slab Type :</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                <select autofocus name="slab_type_id" id="slab_type_id"
                                                    class="form-control requiredField select2" onchange="FetchSlabList()">
                                                    <option value="">Select Slab Types</option>
                                                    @foreach ($types as $key => $y)
                                                        <option value="{{ $y->id }}"
                                                            {{ old('slab_type_id') == $y->id ? 'selected' : '' }}>
                                                            {{ $y->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label>Product :</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                <select name="product_id" id="product_id"
                                                    class="form-control requiredField select2" onchange="FetchSlabList()">
                                                    <option value="">Select Product</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}"
                                                            {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                            {{ $product->name }}</option>
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
                                                        <div class="table-responsive">

                                                            <table id="table" class="table table-bordered">
                                                                <thead>
                                                                    <th class="text-center">S.No</th>
                                                                    <th class="text-center">Slab Type</th>
                                                                    <th class="text-center">Product Name</th>
                                                                    <th class="text-center">From</th>
                                                                    <th class="text-center">To</th>
                                                                    <th class="text-center">Deduction</th>
                                                                    <th class="text-center">Remark</th>
                                                                     <th class="text-center">Action</th> 
                                                                </thead>
                                                                <tbody id="viewSlabList">
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
            FetchSlabList();
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
                XLSX.writeFile(wb, fn || ('Sub Item List.' + (type || 'xlsx')));
        }
        var loading = false;

        function FetchSlabList() {
            var slab_type_id = $('#slab_type_id').val();
            var product_id = $('#product_id').val();
            $('#viewSlabList').html(
                '<tr><td colspan="7"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div></div></div></td><tr>'
            );
            $.ajax({
                url: '{{ route('slab.index') }}',
                method: 'GET',
                data: {
                    slab_type_id: slab_type_id,
                    product_id: product_id
                },
                error: function() {
                    alert('error');
                },
                success: function(response) {
                    $('#viewSlabList').html(response);
                }
            });
        }


        function delete_ar(id) {
                // alert("Delete Working");
            if(confirm('Are u sure you want to delete this?')){
                $.ajax({
                    url: '{{ url('commodities/delete_Slab') }}',
                    data: {
                        id: id
                    },
                    type: 'GET',
                    success: function(response) {
                        alert(response);
                        if(response=='Deleted'){
                           location.reload();
                        }
                    }
                })
            }
        }


        $(document).ready(function() {
            $('#importButton').on('click', function() {
               
             

           
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait while the file is being uploaded.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Send AJAX request

                
                $.ajax({
                    url: "{{ route('product.importDataslab') }}",
                    method: 'get',
                   
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Close the loader
                        Swal.close();

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Data imported successfully.'
                        }).then(() => {
                            // Reload the page after the success message is confirmed
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        // Close the loader
                        Swal.close();

                        // Prepare error message
                        let errorMessage = 'An error occurred while importing the data.';
                        if (xhr.responseJSON) {
                            // If there are specific validation errors
                            if (xhr.responseJSON.errors) {
                                errorMessage = '';
                                $.each(xhr.responseJSON.errors, function(key, messages) {
                                    // Combine all error messages into a single string
                                    errorMessage += messages.join(' ') + ' ';
                                });
                            } else if (xhr.responseJSON.message) {
                                // Generic error message
                                errorMessage = xhr.responseJSON.message;
                            }
                        }

                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage.trim()
                        });
                    }
                });
            });
        });
    </script>
@endsection
