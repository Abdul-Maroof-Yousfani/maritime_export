<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
?>
@extends('layouts.default')
<style>
    #getPoDataForBillCheck input.form-control {
        height: 30px !important;
        margin-bottom: 0;
    }
    input.subtract {
        color: #cb0000;
    }
    /*#getPoDataForBillCheck th {*/
    /*    width: 15% !important;*/
    /*}*/


    .sticky-col {
        position: -webkit-sticky;
        position: sticky;
        background-color: white;
        z-index: 1;
        background: #d1d1d1;
    }

    /* Fixed Start Column */
    .first-col {
        left: 0;
        z-index: 2; /* Ensures the first column stays on top */
    }
    .second-col {
        left: 10%;
        z-index: 2; /* Ensures the first column stays on top */
    }

    /* Fixed End Columns */
    .last-col-1 {
        right: 200px; /* Adjust this value based on the width of the last two columns */
        z-index: 2;
    }

    .last-col-2 {
        right: 0;
        z-index: 2;
    }
</style>
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
                                        <span class="subHeadingLabelClass">Rice Analysis and Inspection Report</span>
                                    </div>
                                </div>
                                @include('layouts.error_success')

                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">

                                                    <form  id="yourFormId2" action="{{ route('billcheck.store') }}" method="post">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>PO No.</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select onchange="getPoDataForBillCheck(this.value)" name="po_no" id="po_no"
                                                                        class="form-control requiredFiel select2 requiredFiel"
                                                                >
                                                                    <option value="">Select PO</option>
                                                                    @foreach (CommonHelper::get_all_balance_pos() as $key => $y)
                                                                        <option value="{{ $y->voucher_no }}"
                                                                                {{ old('po_no') == $y->voucher_no ? 'selected' : '' }}>
                                                                            {{ $y->voucher_no }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div id="getPoDataForBillCheck">
                                                        </div>

                                                        <div class="row">
                                                            <div
                                                                    class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                                                <button type="submit" class="btn btn-success">Save</button>
                                                                <button type="reset" id="reset"
                                                                        class="btn btn-primary">Clear Form</button>
                                                            </div>
                                                        </div>
                                                    </form>



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
        $('.select2').select2();

        $(document).ready(function() {
            // getChecklist();
            // $(".btn-success").click(function(e) {
            //     var subItem = new Array();
            //     var val;
            //     //$("input[name='chartofaccountSection[]']").each(function(){
            //     subItem.push($(this).val());
            //     //});
            //     var _token = $("input[name='_token']").val();
            //     for (val of subItem) {
            //         jqueryValidationCustom();
            //         if (validate == 0) {
            //             $('.btn-success').prop('disabled', true);
            //             // $("form").submit();
            //             //return false;
            //         } else {
            //             return false;
            //         }
            //     }
            // });
        });



        function getPoDataForBillCheck(id) {
            $('#getPoDataForBillCheck').html('');

            // Show SweetAlert processing loader
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we fetch the PO data',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: function() {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '{{ url('/') }}' + '/arrival/getPoDataForBillCheck',
                type: 'GET',
                data: {
                    po_no: id
                },
                success: function(response) {
                    $('#getPoDataForBillCheck').html(response);

                    // Close SweetAlert loader on success
                    Swal.close();
                },
                error: function(xhr, status, error) {
                    // Show SweetAlert error message
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while fetching the PO data. Please try again later.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }


        function getVoucherNo() {
            let sub_category_id = $('#sub_category_id');
            let crop_based_id = $('#crop_based_id');

            // if (sub_category_id.find(':selected').data('cropbased') == 1) {
            //     crop_based_id.select2({
            //         disabled: ''
            //     });
            //     if (crop_based_id.val() == '' || sub_category_id.val() == '') {
            //         // alert(product_id);
            //         $('#voucher_no').val('');
            //         return;
            //     }
            // } else {
            //     crop_based_id.select2({
            //         disabled: 'readonly'
            //     });
            // }
            $.ajax({
                url: '{{ url('/') }}' + '/arrival/getVoucherNo',
                type: 'Get',
                data: {
                    product_id: sub_category_id.val(),
                    crop_based_id: crop_based_id.val()
                },
                success: function(response) {
                    // console.log(response);
                    $('#voucher_no').val(response[0]);
                }
            });
        }

        function getProductSlabsDetail() {
            let product_id = $('#product_id').val();
            if (product_id == '') {
                $('#getProductSlabsDetail').html();
                return;
            }
            $.ajax({
                url: '{{ url('/') }}' + '/commodities/purchase-order/getProductSlabsDetail',
                type: 'Get',
                data: {
                    product_id: product_id
                },
                success: function(response) {
                    // console.log(response);
                    $('#getProductSlabsDetail').html(response);
                }
            });
        };

        var counter = 0;
        function AddMoreDetails() {
            counter++;
            if(counter == 1){
                $('#AppnedHtml').append(
                    `<tr class="cnt" id="removeSection${counter}">

                    <td>
                            <select name="product_id" id="product_id"
                                class="form-control requiredFiel select2"
                                onchange="getProductSlabsDetail()">
                            </select>
                    </td>
                    <td>
                        <select name="delivery_mode" id="delivery_mode"
                            class="form-control requiredFiel select2">
                            <option value="">Select Delivery Term</option>
                            <option value="1">Trallers</option>
                            <option value="2">Truck</option>
                            <option value="3">Bags</option>
                            <option value="4">Katta</option>
                            <option value="5">KG</option>
                        </select>
                    </td>
                    <td><input type="number"
                            class="form-control requiredFiel " name="qty"
                            id="qty${counter}" onkeyup="calculate(${counter})" value="">
                    </td>
                    <td ><input type="number"
                            class="form-control requiredFiel" name="order_rate"
                            id="rate${counter}" onkeyup="calculate(${counter})" value="">
                    </td>
                    <td ><input type="text"
                            class="form-control requiredFiel" name="po_amount"
                            id="total${counter}" readonly value="">
                    </td>
                    <td><button class="btn btn-danger btn-xs" onClick="removeSection(${counter})">Remove</button>
                    </td>
                </tr>`
                );
            }


            var id = $('#sub_category_id').val();
            getproduct(id)

        }

        function removeSection(id) {
            $('#removeSection' + id).remove();
            calculate();
        }

        function calculate(id) {
            var qty = $('#qty'+ id).val();
            var rate = $('#rate'+ id).val();

            var total = qty * rate;

            if(qty == '' || rate == ''){
                total = 0;
            }
            $('#total' + id).val(total.toFixed(2))
        }
    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection