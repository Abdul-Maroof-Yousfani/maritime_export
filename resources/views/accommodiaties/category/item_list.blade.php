<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
?>
@extends('layouts.default')

@section('content')
    @include('select2');
    <div class="well_N">
        <div class="dp_sdw">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="well">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <span class="subHeadingLabelClass">Item List</span>
                                    </div>
                                </div>

                                 <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                    <button type="button" class="btn btn-warning" id="importButton">Import Item 
                                        </button>
                                </div>  -->
                                {{-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                    <button type="button" class="btn btn-warning" onclick="ExportToExcel('xlsx')">Export
                                        <b>(xlsx)</b></button>
                                </div> --}}
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
        <th class="text-center">Category</th>
        <th class="text-center">Sub Category</th>
        <th class="text-center">Variety</th>
        <th class="text-center">Sub Variety</th>
        <th class="text-center">Item</th>
        <th class="text-center">Action</th>
    </thead>
    <tbody id="viewSlabList" class="text-center">
        @foreach ($products as $key => $product)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $product->category }}</td> <!-- Category -->
                <td>{{ $product->sub_category }}</td> <!-- Sub Category -->
                <td>{{ $product->variety }}</td> <!-- Variety -->
                <td>{{ $product->sub_item->name ?? '-' }}</td> <!-- Sub Variety -->
                <td>{{ $product->name ?? '-' }}</td> <!-- Item -->
                <td>
                    <a class="btn btn-xs btn-info" href="{{ route('product.item.edit', $product->id) }}">Edit</a>
                    <button class="delete-modal btn btn-xs btn-danger" onClick="delete_ar({{ $product->id }})">Delete</button>
                </td>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $(".btn-success").click(function(e) {
                var subItem = new Array();
                var val;
                //$("input[name='chartofaccountSection[]']").each(function(){
                subItem.push($(this).val());
                //});
                var _token = $("input[name='_token']").val();
                for (val of subItem) {

                    jqueryValidationCustom();
                    if (validate == 0) {
                        $('.btn-success').prop('disabled', true);
                        $("form").submit();
                        //return false;
                    } else {
                        return false;
                    }
                }
            });
        });
    </script>
    <script type="text/javascript">
        $('.select2').select2();


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
                    url: "{{ route('product.importDataItem') }}",
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

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>




    
@endsection
