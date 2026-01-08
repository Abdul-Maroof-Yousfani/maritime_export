<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
$words = [
    1 => 'One',
    2 => 'Two',
    3 => 'Three',
    4 => 'Four',
    5 => 'Five',
    6 => 'Six',
    7 => 'Seven',
    8 => 'Eight',
    9 => 'Nine',
    10 => 'Ten',
   
];
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
                                        <span class="subHeadingLabelClass">Bill Of Lading Creation Form</span>
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
                                                            echo Form::open(['url' => 'export/storeBillOfLading?m=' . $m . '', 'id' => 'addSubItemDetail']);
                                                            $str = DB::connection('mysql2')->selectOne('select max(convert(substr(`voucher_no`,4,length(substr(`voucher_no`,4))-4),signed integer)) reg from `export_bill_of_ladings` where substr(`voucher_no`,-4,2) = ' . date('m') . ' and substr(`voucher_no`,-2,2) = ' . date('y') . '')->reg;
                                                            $IMP = 'BOL' . ($str + 1) . date('my');
                                                        @endphp
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="packaging_id"
                                                            value="{{ $packaging->id }}">

                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label for="">Voucher No</label>
                                                                <input type="text" class="form-control" readonly
                                                                    name="voucher_no" value="{{ $IMP }}"
                                                                    id="">
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label for="">Voucher Date</label>
                                                                <input type="date" class="form-control"
                                                                    name="voucher_date" value="{{ date('Y-m-d') }}"
                                                                    id="">
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label for="">Packaging invoice No</label>
                                                                <input type="text" class="form-control" readonly
                                                                    name="packaging_invoice_no"
                                                                    value="{{ $packaging->import_no }}" id="">
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label for="">Proform No</label>
                                                                <input readonly type="text" class="form-control"
                                                                    name="proforma_invoice_no"
                                                                    value="{{ $sales_order->pro_contract_no }}"
                                                                    id="">
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
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-8">
                                                                <label class="sf-label">Net Weight </label>
                                                                <input readonly type="text" class="form-control"
                                                                    placeholder="" name="net_weight_invoice"
                                                                    id="net_weight_invoice"
                                                                    value="{{ $packagingDataSum->net_weight }}" />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-8">
                                                                <label class="sf-label">Gross Weight </label>
                                                                <input readonly type="text" class="form-control"
                                                                    placeholder="" name="gross_weight_invoice"
                                                                    id="gross_weight_invoice"
                                                                    value="{{ $packagingDataSum->gross_weight }}" />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-8">
                                                                <label class="sf-label">Booking No.</label>
                                                                <input  type="text" class="form-control"
                                                                    placeholder="" name="booking_no"
                                                                    id="booking_no"
                                                                    value="" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label class="sf-label">Forwarder</label>
                                                                <input  type="text" class="form-control"
                                                                    placeholder="" name="forwarder"
                                                                    id="forwarder"
                                                                    value="" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8 hide">
                                                                <label class="sf-label">No.of Bags </label>
                                                                <input readonly type="text" class="form-control"
                                                                    placeholder="" name="no_of_bags" id="no_of_bags"
                                                                    value="{{ $packaging->total_qty }}" />
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8">
                                                                <label class="sf-label">Name of Shipper</label>
                                                                <textarea name="name_of_shipper" id="name_of_shipper" cols="30" rows="10">
                                                                    GARIBSONS (PVT.) LTD. <br>
                                                                    C-69/71, 12TH COMMERCIAL ST., PHASE II EXT., DHA <br>
                                                                    KARACHI, 75500, PAKISTAN <br>
                                                                    PH:9221 111427421, FAX: 9221 111427422 <br>    
                                                                </textarea>
                                                                {{-- <div style="height: 150px; background-color: #eee; padding: 10px;">
                                                                    {!! $sales_order->consignee !!}
                                                                </div> --}}
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8">
                                                                <label class="sf-label">Consignee Details </label>
                                                                <textarea name="consignee" id="consignee" cols="30" rows="10">{{ $sales_order->consignee }}</textarea>
                                                                {{-- <div style="height: 150px; background-color: #eee; padding: 10px;">
                                                                    {!! $sales_order->consignee !!}
                                                                </div> --}}
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <button type="button" onclick="notifyMoreField();"
                                                                    class="btn btn-primary btn-xs">Add Notify</button>
                                                            </div>

                                                            <div id="notifyMoreField">
                                                               
                                                                @foreach ($invoiceNotify as $key => $invoiceNoti)
                                                              
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"
                                                                        id="notifyMoreField{{ ++$key }}">
                                                                        <label for="">Notify {{ $words[$key] }} <button
                                                                                type="button"
                                                                                onclick="removeNotifyMoreField({{ $key }});"
                                                                                class="btn btn-danger btn-xs">Remove</button></label>
                                                                        <textarea type="text" class="form-control" name="notify_address[]" id="notify_address{{ $key }}">{{ $invoiceNoti->notify_address }}</textarea>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <label class="sf-label">Product Details </label>
                                                                <textarea name="bol_description" id="bol_description" cols="30" rows="10">{{ $exportInvoice->description }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="lineHeight">&nbsp;&nbsp;&nbsp;</div>
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr class="text-center">
                                                                                <th colspan="5" class="text-center">
                                                                                    Packaging
                                                                                    Detail</th>
                                                                                {{-- <th colspan="2" class="text-center">
                                                                                    <input type="button"
                                                                                        class="btn btn-sm btn-primary"
                                                                                        onclick="AddMoreDetails()"
                                                                                        value="Add More Rows" />
                                                                                </th> --}}
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="text-center"
                                                                                    style="width: 2%;">S.NO
                                                                                </th>
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
                                                                            @foreach ($packagingData as $key => $data)
                                                                                <tr class="cnt">
                                                                                    <td>
                                                                                        {{ ++$key }}
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            name="container[]" readonly
                                                                                            id="container"
                                                                                            value="{{ $data->container }}">
                                                                                    </td>
                                                                                    <td><input type="text"
                                                                                            class="form-control qty"
                                                                                            onkeyup="calculationPackaging()"
                                                                                            name="qty[]" id="qty1"
                                                                                            readonly
                                                                                            value="{{ $data->qty }}">
                                                                                    </td>
                                                                                    <td><input type="text"
                                                                                            class="form-control net_weight"
                                                                                            name="net_weight[]" readonly
                                                                                            onkeyup="calculationPackaging()"
                                                                                            id="net_weight1"
                                                                                            value="{{ $data->net_weight }}">
                                                                                    </td>
                                                                                    <td><input type="text"
                                                                                            class="form-control gross_weight"
                                                                                            name="gross_weight[]" readonly
                                                                                            onkeyup="calculationPackaging()"
                                                                                            id="gross_weight1"
                                                                                            value="{{ $data->gross_weight }}">
                                                                                    </td>
                                                                                    <td colspan="2" class="hide">
                                                                                        <input type="text" readonly
                                                                                            class="form-control"
                                                                                            name="description[]"
                                                                                            id="description1"
                                                                                            value="">
                                                                                    </td>

                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                        <tbody>
                                                                            <tr
                                                                                style="background-color: darkgrey;font-size:large;font-weight: bold">
                                                                                <td class="text-center" colspan="2">
                                                                                    Total</td>

                                                                                {{-- <input readonly class="form-control" type="text" id="net"/> --}}
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
                                                                                {{-- <td></td> --}}
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
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
        var Counter = {{ count($invoiceNotify) }}
        $(function() {
            for (let i = 1; i <= Counter; i++) {
                CKEDITOR.replace("notify_address" + i, {
                    // toolbar: []
                    // allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height];'
                });
            }
            CKEDITOR.replace("bol_description" , {
                // toolbar: []
                // allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height];'
            });
            CKEDITOR.replace("name_of_shipper" , {
                // toolbar: []
                // allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height];'
            });
        })

        var words = {
            1: 'One',
            2: 'Two',
            3: 'Three',
            4: 'Four',
            5: 'Five',
            6: 'Six',
            7: 'Seven',
            8: 'Eight',
            9: 'Nine',
            10: 'Ten'
            // Add more mappings as needed
        };

        function notifyMoreField() {
            $('#notifyMoreField').append(`
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="notifyMoreField${++Counter}">
                    <label for="">Notify ${words[Counter]}  <button type="button" onclick="removeNotifyMoreField(${Counter});" class="btn btn-danger btn-xs">Remove</button></label>
                    <textarea type="text" class="form-control" name="notify_address[]" id="notify_address${Counter}"></textarea>
                </div>
            `);
            CKEDITOR.replace("notify_address" + Counter, {
                // toolbar: []
                // allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height];'
            });
        }

        function removeNotifyMoreField(Row) {
            $('#notifyMoreField' + Row).remove();
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

            $('#net_weight_total').val(netWeightSum);
            $('#gross_weight_total').val(grossWeightSum);
            $('#qty_total').val(qtySum);
            // if (no_of_bags == qtySum) {
            //     $('#qty_total').css('border-color', '#eee');
            // } else {
            //     $('#qty_total').css('border-color', 'red');
            // }
            // if (commercial_net_weight == netWeightSum) {
            //     $('#net_weight_total').css('border-color', '#eee');
            // } else {
            //     $('#net_weight_total').css('border-color', 'red');
            // }
            // if (commercial_gross_weight == grossWeightSum) {
            //     $('#gross_weight_total').css('border-color', '#eee');
            // } else {
            //     $('#gross_weight_total').css('border-color', 'red');
            // }
            // if (commercial_net_weight == netWeightSum && commercial_gross_weight == grossWeightSum && no_of_bags ==
            //     qtySum) {
            //     $('.btn-success').attr('disabled', false);
            // } else {
            //     $('.btn-success').attr('disabled', true);
            // }

        }

        $(document).ready(function() {
            calculationPackaging()
            CKEDITOR.replace('consignee', {
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
