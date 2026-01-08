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
                                        <span class="subHeadingLabelClass">Packing List Creation</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        @php
                                                            echo Form::open(['url' => 'export/pakingListStore?m=' . $m . '', 'id' => 'addSubItemDetail']);
                                                            $str = DB::connection('mysql2')->selectOne('select max(convert(substr(`import_no`,4,length(substr(`import_no`,4))-4),signed integer)) reg from `export_paking_lists` where substr(`import_no`,-4,2) = ' . date('m') . ' and substr(`import_no`,-2,2) = ' . date('y') . '')->reg;
                                                            $IMP = 'CIPL' . ($str + 1) . date('my');
                                                        @endphp
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="invoice_id"
                                                            value="{{ $exportInvoice->id }}">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label for="">Packaging invoice No</label>
                                                                <input type="text" class="form-control" readonly
                                                                    name="packaging_invoice_no" value="{{ $IMP }}"
                                                                    id="">
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label for="">Packaging invoice Date</label>
                                                                <input type="date" class="form-control"
                                                                    name="packaging_invoice_date"
                                                                    value="{{ date('Y-m-d') }}" id="">
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label for="">Proform No</label>
                                                                <input readonly type="text" class="form-control"
                                                                    name="proforma_invoice_no"
                                                                    value="{{ $sales_order->pro_contract_no }}" id="">
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label for="">Commercial Invoice No</label>
                                                                <input readonly type="text" class="form-control"
                                                                    name="commercial_invoive_no"
                                                                    value="{{ $exportInvoice->commercial_invoice_no }}"
                                                                    id="">
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label class="sf-label">EO No </label>
                                                                <input readonly type="text" class="form-control"
                                                                    name="export_order_invoive_no"
                                                                    id="export_order_invoive_no"
                                                                    value="{{ $sales_order->voucehr_no }}" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label class="sf-label">Buyer's Name </label>
                                                                <input readonly type="text" class="form-control"
                                                                    placeholder="" name="buyers_id" id="buyers_id"
                                                                    value="{{ CommonHelper::byers_name($sales_order->buyer_id)->name ?? '-' }}" />
                                                                {{-- <select readonly style="width: 100%" name="buyers_id" id="ntn" onchange="get_ntn()" class="form-control  requiredField">
                                                                   <option value="">Select</option>
                                                                   @foreach (SalesHelper::get_all_customers() as $row)
                                                                   <option @if ($sales_order->buyer_id == $row->id) selected @endif value="{{$row->acc_id}}">{{$row->name}}</option>
                                                                   @endforeach
                                                                </select> --}}
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label class="sf-label">Ship Name </label>
                                                                <input readonly type="text" class="form-control"
                                                                    placeholder="" name="ship_name" id="ship_name"
                                                                    value="{{ $exportInvoice->ship_name }}" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label class="sf-label">Bill of Lading NO/Date </label>
                                                                <input readonly type="text" class="form-control"
                                                                    placeholder="" name="bill_of_lading" id="bill_of_lading"
                                                                    value="{{ $exportInvoice->bill_of_loading }}" />
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                <label class="sf-label">Net Weight </label>
                                                                <input readonly type="text" class="form-control"
                                                                    placeholder="" name="net_weight_invoice"
                                                                    id="net_weight_invoice"
                                                                    value="{{ $exportInvoiceDataSum->issue_qty }}" />
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                <label class="sf-label">Gross Weight </label>
                                                                <input readonly type="text" class="form-control"
                                                                    placeholder="" name="gross_weight_invoice"
                                                                    id="gross_weight_invoice"
                                                                    value="{{ $exportInvoiceDataSum->gross_weight }}" />
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                                <label class="sf-label">Consignee </label>
                                                                <textarea class="form-control"
                                                                    placeholder="" name="consignee"
                                                                    id="consignee"
                                                                    value="">{{$sales_order->consignee}}</textarea>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                                <label class="sf-label">Notify Detail </label>
                                                                <textarea class="form-control"
                                                                    placeholder="" name="notify"
                                                                    id="notify"
                                                                    value=""></textarea>
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8 hide">
                                                                <label class="sf-label">No.of Bags </label>
                                                                <input readonly type="text" class="form-control"
                                                                    placeholder="" name="no_of_bags" id="no_of_bags"
                                                                    value="{{ $exportOrderDataSum }}" />
                                                            </div>
                                                        </div>
                                                        <div class="lineHeight">&nbsp;&nbsp;&nbsp;</div>
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <form name="excel-import" action="" id="frmFileUpload" method="POST" enctype="multipart/form-data">
                                                          
                                                                <label for="">Upload File</label><br><a download href="{{asset('/public/packingList.xlsx')}}"> Sample File XLSX</a>
                                                                  <input  accept=".xlsx, .xls" required name="file" id="file" type="file" class="form-control">
                                                                  <button type="button" class="btn btn-primary" onclick="submitFormViaAjax()">Proceed</button>
                                                                </form>
                                                                </div>
                                                            
                                                              

                                                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr class="text-center">
                                                                                <th colspan="3" class="text-center">
                                                                                    Packaging
                                                                                    Detail</th>
                                                                                <th colspan="2" class="text-center">
                                                                                    <input type="button"
                                                                                        class="btn btn-sm btn-primary"
                                                                                        onclick="AddMoreDetails()"
                                                                                        value="Add More Rows" />
                                                                                </th>
                                                                            </tr>
                                                                            <tr>
                                                                                {{-- <th class="text-center"
                                                                                    style="width: 2%;">S.NO
                                                                                </th> --}}
                                                                                <th class="text-center"
                                                                                    style="width: 20%;">
                                                                                    Container No’s</th>
                                                                                <th class="text-center">No. of Bags</th>
                                                                                <th class="text-center">Net Weight – M Tons
                                                                                </th>
                                                                                <th class="text-center">Gross Weight – M
                                                                                    Tons</th>
                                                                                <th class="text-center hide"
                                                                                    colspan="2">
                                                                                    Description
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                      
                                                                        <tbody id="AppnedHtml">
                                                                           {{--   <tr class="cnt">
                                                                                <td>
                                                                                    1
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="container[]" id="container"
                                                                                        value="">
                                                                                </td>
                                                                                <td><input type="text"
                                                                                        class="form-control qty"
                                                                                        onkeyup="calculationPackaging()"
                                                                                        name="qty[]" id="qty1"
                                                                                        value="">
                                                                                </td>
                                                                                <td><input type="text"
                                                                                        class="form-control net_weight"
                                                                                        name="net_weight[]"
                                                                                        onkeyup="calculationPackaging()"
                                                                                        id="net_weight1" value="">
                                                                                </td>
                                                                                <td><input type="text"
                                                                                        class="form-control gross_weight"
                                                                                        name="gross_weight[]"
                                                                                        onkeyup="calculationPackaging()"
                                                                                        id="gross_weight1" value="">
                                                                                </td>
                                                                                <td colspan="2" class="hide"><input
                                                                                        type="text"
                                                                                        class="form-control"
                                                                                        name="description[]"
                                                                                        id="description1" value="">
                                                                                </td>

                                                                            </tr>--}}

                                                                        </tbody>
                                                                        
                                                                        <tbody>
                                                                            <tr
                                                                                style="background-color: darkgrey;font-size:large;font-weight: bold">
                                                                                <td class="text-center" colspan="">
                                                                                    Total</td>

                                                                               
                                                                                </td>
                                                                                <td><input readonly class="form-control"
                                                                                        type="text" id="qty_total" />
                                                                                </td>
                                                                                <td><input readonly class="form-control"
                                                                                        type="text"
                                                                                        id="net_weight_total" />
                                                                                </td>
                                                                                <td><input readonly class="form-control"
                                                                                        type="text"
                                                                                        id="gross_weight_total" />
                                                                                </td>
                                                                                <td></td>
                                                                            </tr>
                                                                        </tbody> 
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <label class="sf-label">Description</label>
                                                                <textarea class="form-control " name="description" id="description">
                                                                    {!! $sales_order->quality_remarks !!} <br>
                                                                    
                                                                    {!! 'PACKED IN ' . $sales_order_data[0]->pack_size . ' KG ' . $sales_order_data[0]->pack_type !!} <br> <br>
                                                                  
                                                                    WE CERTIFY THAT THE GOODS ARE OF PAKISTAN ORIGIN
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div
                                                                class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                                                {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                                            </div>
                                                        </div>
                                                        @php
                                                            echo Form::close();
                                                        @endphp
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
    var counter = 1;
            function submitFormViaAjax() {
         
         var formData = new FormData();
         formData.append('file', $('#file')[0].files[0]);
         var csrfToken = $('meta[name="csrf-token"]').attr('content');

         $.ajax({
             url: "{{route('importExcelData')}}", // Specify the URL where you want to submit the form
             type: "POST",
             data: formData,
             processData: false,
             contentType: false,
             headers: {
                 'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the headers
             },
             success: function(response) {
                 console.log("Form submitted successfully:", response);
                 $('#AppnedHtml').empty();
                 $('#AppnedHtml').append(response);
                 var count = $('.cnt').length;
                 counter = count;
       console.log(count);
                 calculationPackaging();
             },
             error: function(xhr, status, error) {
                 console.error("Form submission failed:", error);
             }
             });
         }
        //  <td>
        //     ${counter}
        // </td>
        function AddMoreDetails() {
            counter++;
            $('#AppnedHtml').append(
                `<tr class="cnt" id="removeSection${counter}">
                    
                    <td>
                        <input type="text" class="form-control"
                            name="container[]" id="container${counter}"
                            value="">
                    </td>
                    <td><input type="text"
                            class="form-control qty" name="qty[]"
                            id="qty${counter}" onkeyup="calculationPackaging()" value="">
                    </td>
                    <td><input type="text"
                            class="form-control net_weight" name="net_weight[]"
                            id="net_weight${counter}" onkeyup="calculationPackaging()" value="">
                    </td>
                    <td><input type="text"
                            class="form-control gross_weight" name="gross_weight[]"
                            id="gross_weight${counter}" onkeyup="calculationPackaging()" value="">
                    </td>
                    <td class="hide"><input type="text"
                            class="form-control" name="description[]"
                            id="description${counter}" value="">
                    </td>
                    <td><button class="btn btn-danger btn-xs" onClick="removeSection(${counter})">Remove</button>
                    </td>
                </tr>`
            );

        }

        function removeSection(id) {
            $('#removeSection' + id).remove();
            calculationPackaging();
        }


        function calculationPackaging() {
            // let net_weight = $('.net_weight').val();
            // let gross_weight = $('.gross_weight');
            // let netWeghtSum = 0;
            // let grossWeghtSum = 0;

            // net_weight.forEach(element => {
            //     netWeghtSum += parseFloat(element);
            // });
            // alert(netWeghtSum);
            let commercial_net_weight = parseFloat($('#net_weight_invoice').val() || 0);
            let commercial_gross_weight = parseFloat($('#gross_weight_invoice').val() || 0);
            let no_of_bags = parseFloat($('#no_of_bags').val() || 0);

            let qtyS = document.querySelectorAll('.qty');
            let qtySum = 0;

            qtyS.forEach(element => {
                let qtValue = parseFloat(element.value);
                if (!isNaN(qtValue)) {
                    qtySum += qtValue;
                }
            });
            let netWeights = document.querySelectorAll('.net_weight');
            let netWeightSum = 0;

            netWeights.forEach(element => {
                let netWeightValue = parseFloat(element.value);
                if (!isNaN(netWeightValue)) {
                    netWeightSum += netWeightValue;
                }
            });
            let grossWeights = document.querySelectorAll('.gross_weight');
            let grossWeightSum = 0;

            grossWeights.forEach(element => {
                let grossWeightValue = parseFloat(element.value);
                if (!isNaN(grossWeightValue)) {
                    grossWeightSum += grossWeightValue;
                }
            });

            $('#net_weight_total').val(netWeightSum.toFixed(3));
            $('#gross_weight_total').val(grossWeightSum.toFixed(3));
            $('#qty_total').val(qtySum);
            if (no_of_bags == qtySum) {
                $('#qty_total').css('border-color', '#eee');
            } else {
                $('#qty_total').css('border-color', 'red');
            }
            if (commercial_net_weight == netWeightSum) {
                $('#net_weight_total').css('border-color', '#eee');
            } else {
                $('#net_weight_total').css('border-color', 'red');
            }
            if (Math.trunc(commercial_gross_weight) == Math.trunc(grossWeightSum)) {
                $('#gross_weight_total').css('border-color', '#eee');
            } else {
                $('#gross_weight_total').css('border-color', 'red');
            }
            if (commercial_net_weight == netWeightSum && Math.trunc(commercial_gross_weight) == Math.trunc(grossWeightSum) && no_of_bags ==
                qtySum) {
                $('.btn-success').attr('disabled', false);
            } else {
                $('.btn-success').attr('disabled', true);
            }

        }

        $(document).ready(function() {
            // $('#description').summernote({
            //     height: 300 // Set the height in pixels
            // });

            // $('#description').summernote();
            CKEDITOR.replace('description', {
                // toolbar: []
                // allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height];'
            });
            CKEDITOR.replace('consignee', {
                // toolbar: []
                // allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height];'
            });
            CKEDITOR.replace('notify', {
                // toolbar: []
                // allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height];'
            });



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
        
    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
