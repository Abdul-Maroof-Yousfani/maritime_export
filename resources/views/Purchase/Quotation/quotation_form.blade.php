<?php

$m = Session::get('run_company');
use App\Helpers\PurchaseHelper;
use App\Helpers\CommonHelper;
use App\Helpers\FinanceHelper;
use App\Helpers\ReuseableCode;
?>
@extends('layouts.default')

@section('content')
    @include('select2')
    @include('modal')
    @include('number_formate')

    <style>
        * {
            font-size: 12px !important;
            font-family: Arial;
        }

        .select2 {
            width: 100%;
        }
    </style>


    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well_N">
                    <div class="dp_sdw">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span class="subHeadingLabelClass">Create Quotation Form</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            <?php echo Form::open(['url' => url('quotation/insert_quotation') . '?m=' . $m . '', 'id' => 'cashPaymentVoucherForm', 'class' => 'stop']); ?>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="hidden" name="demandsSection[]"
                                                    class="form-control requiredField" id="demandsSection" value="1" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="row">

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="sf-label">Quotation NO. <span
                                                                class="rflabelsteric"><strong>*</strong></span></label>
                                                        <input readonly type="text" class="form-control requiredField"
                                                            placeholder="" name="pr_no" id="pr_no"
                                                            value="{{ strtoupper($voucher_no) }}" />
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="sf-label">Quotation Date.</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="date" class="form-control requiredField"
                                                            max="<?php echo date('Y-m-d'); ?>" name="demand_date_1"
                                                            id="demand_date_1" value="<?php echo date('Y-m-d'); ?>" />
                                                    </div>
                                                    <input type="hidden" name="pr_id" value="{{ $id }}" />

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="sf-label">Ref No. <span
                                                                class="rflabelsteric"><strong>*</strong></span></label>
                                                        <input autofocus type="text" class="form-control requiredField"
                                                            placeholder="Ref  No" name="ref_no" id="slip_no_1"
                                                            value="" />
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="sf-label">Supplier <span
                                                                class="rflabelsteric"><strong>*</strong></span></label> 
                                                                <button type="button" class="btn btn-xs btn-primary" onclick="showDetailModelOneParamerter('pdc/createSupplierFormAjax');">Add Supplier</button>
                                                        <select class="form-control select2 requiredField" name="supplier"
                                                            id="supplier">
                                                            <option value="">Select</option>
                                                            @foreach (CommonHelper::get_all_supplier() as $row)
                                                                <option value="{{ $row->id }}">{{ $row->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>


                                                </div>
                                                <input type="hidden" name="demand_type" id="demand_type">
                                                <div class="row">


                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <label class="sf-label">Description</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea name="description_1" id="description_1" rows="4" cols="50" style="resize:none;"
                                                            class="form-control requiredField"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lineHeight">&nbsp;</div>

                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="table-responsive" id="">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <th colspan="8" class="text-center">Purchase Request
                                                                    Detail</th>
                                                                <th colspan="2" class="text-center">

                                                                </th>
                                                                <th class="text-center">
                                                                    <span class="badge badge-success"
                                                                        id="span">1</span>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-center">SR NO</th>
                                                                <th class="text-center">Item</th>
                                                                <th style="width: 100px" class="text-center">UOM<span
                                                                        class="rflabelsteric"><strong>*</strong></span></th>
                                                                <th style="" class="text-center">QTY<span
                                                                        class="rflabelsteric"><strong>*</strong></span>
                                                                </th>
                                                                <th style="" class="text-center">Last Received
                                                                    Date<span
                                                                        class="rflabelsteric"><strong>*</strong></span>
                                                                </th>
                                                                <th style="" class="text-center">Last Received
                                                                    Rate<span
                                                                        class="rflabelsteric"><strong>*</strong></span>
                                                                </th>
                                                                <th style="" class="text-center">Rate<span
                                                                        class="rflabelsteric"><strong>*</strong></span>
                                                                </th>
                                                                <th style="" class="text-center">Amount</th>
                                                                <th style="" class="text-center">Discount(%)</th>
                                                                <th style="" class="text-center">Discount Amount
                                                                </th>
                                                                <th style="" class="text-center">Net Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="AppnedHtml">
                                                            <?php $count = 1; ?>
                                                            @foreach ($request_data as $row)
                                                                @php
                                                                    $lastRateQty = CommonHelper::get_last_rate_qty($row->sub_item_id);
                                                                @endphp
                                                                <tr class="text-center">
                                                                    <td>{{ $count++ }}</td>
                                                                    <td>{{ CommonHelper::get_item_name($row->sub_item_id) }}</td>
                                                                    <td>{{ CommonHelper::get_uom($row->sub_item_id) }}</td>
                                                                    <td>{{ $row->qty }}</td>
                                                                    <td>{{ $lastRateQty ? $lastRateQty->voucher_date : '-' }}</td>
                                                                    <td>{{ $lastRateQty ? $lastRateQty->rate : 0 }}</td>
                                                                    <td><input
                                                                            onkeyup="calcu('{{ $count }}','{{ $row->qty }}')"
                                                                            onblur="calcu('{{ $count }}','{{ $row->qty }}')"
                                                                            class="form-control requiredField"
                                                                            step="0.01" type="number" name="rate[]"
                                                                            id="rate{{ $count }}" /> </td>
                                                                    <td><input readonly
                                                                            class="form-control requiredField amount"
                                                                            step="0.01" type="number" name="amount[]"
                                                                            id="amount{{ $count }}" /> </td>
                                                                    <td><input
                                                                            class="form-control requiredField " step="0.01"
                                                                            onkeyup="discount_percent('{{ $count }}')"
                                                                            type="number" name="discount_percent[]" value="0"
                                                                            id="discount_percent{{ $count }}" />
                                                                    </td>
                                                                    <td><input
                                                                            class="form-control requiredField "
                                                                            step="0.01" type="number"
                                                                            onkeyup="discount_amount('{{ $count }}')"
                                                                            name="discount_amount[]"
                                                                            id="discount_amount{{ $count }}" value="0"/>
                                                                    </td>
                                                                    <td><input readonly
                                                                            class="form-control requiredField net_amount"
                                                                            step="0.01" type="number"
                                                                            name="net_amount[]"
                                                                            id="net_amount{{ $count }}" /> </td>
                                                                    <input type="hidden" name="pr_data_id[]"
                                                                        value="{{ $row->id }}" />
                                                                </tr>
                                                            @endforeach

                                                        </tbody>

                                                        <tbody>
                                                            <tr
                                                                style="background-color: darkgrey;font-size:large;font-weight: bold">
                                                                <td class="text-center" colspan="10">Total</td>
                                                                <td id="" class="text-right" colspan="1">
                                                                    <input readonly class="form-control" type="text"
                                                                        id="net" /> </td>
                                                                {{-- <td></td> --}}
                                                            </tr>
                                                        </tbody>


                                                    </table>


                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"
                                                            style="float: right;">
                                                            <table class="table table-bordered sf-table-list">
                                                                <thead>
                                                                    <th class="text-center">Sales Tax Account Head</th>
                                                                    <th class="text-center">Sales Tax Amount</th>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <select onchange="sales_tax(this.id)"
                                                                                class="form-control select2"
                                                                                id="sales_taxx" name="sales_taxx">
                                                                                <option value="0">Select Sales Tax
                                                                                </option>

                                                                                @foreach (ReuseableCode::get_all_sales_tax() as $row)
                                                                                    <option value="{{ $row->percent }}" {{($row->percent == "17.000")? 'selected' : ''}}>
                                                                                        {{ $row->percent }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td class="text-right">
                                                                            <input readonly
                                                                                onkeyup="tax_by_amount(this.id)"
                                                                                type="text" class="form-control"
                                                                                name="sales_amount_td"
                                                                                id="sales_amount_td" />
                                                                        </td>
                                                                        <input type="hidden" name="sales_amount"
                                                                            id="sales_tax_amount" />
                                                                    </tr>


                                                                </tbody>

                                                                <tbody>
                                                                    <tr
                                                                        style="background-color: darkgrey;font-size:large;font-weight: bold">
                                                                        <td class="text-center">Total Amount After Tax</td>
                                                                        <td id="" class="text-right"><input
                                                                                readonly class="form-control"
                                                                                type="text" id="net_after_tax" /> </td>
                                                                    </tr>
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
                            <div class="demandsSection"></div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}

                                </div>
                            </div>
                            <?php echo Form::close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script type="text/javascript">
        $('.select2').select2();
        $('#net').number(true, 2);
        $('#net_after_tax').number(true, 2);
        $('#sales_amount_td').number(true, 2);
    </script>

    <script>
        function discount_percent(id) {
            let total = $('#amount' + id).val();
            let discount_percent = parseFloat($('#discount_percent' + id).val()) || 0
            if (discount_percent > 0) {
                let disAmount = (total * discount_percent) / 100
                $('#discount_amount' + id).val(disAmount.toFixed(2))
                total = total - disAmount
                
            }else{
                $('#discount_amount' + id).val(0)
            } 
            $('#net_amount' + id).val(total);
            sales_tax();
        }
        function discount_amount(id) {
            let total = $('#amount' + id).val();
            let discount_amount = parseFloat($('#discount_amount' + id).val()) || 0
            if (discount_amount > 0) {
                let disAmount = ( discount_amount/total ) * 100
                $('#discount_percent' + id).val(disAmount.toFixed(2))
                total = total - discount_amount
                
            }else{
                $('#discount_percent' + id).val(0)
            } 
            $('#net_amount' + id).val(total);
            sales_tax();
        }
        function calcu(count, qty) {

            var qty = parseFloat(qty);
            var rate = parseFloat($('#rate' + count).val());
            var total = (qty * rate).toFixed(2);
            $('#amount' + count).val(total);
            $('#net_amount' + count).val(total);
            discount_percent(count)
            sales_tax();
            total_amount();
        }

        $("form").submit(function(e) {

            var validate = form_validate();
            if (validate == false) {
                e.preventDefault();
                return false;
            }
            if (validate == 1) {
                $('form').submit();

            }
        });


        function sales_tax(id) {
            var sales_tax = 0;
            var sales_tax_per_value = $('#sales_taxx').val();


            if (sales_tax_per_value != '0') {
                var net = $('#net').val();
                var sales_tax = (net / 100) * sales_tax_per_value;

            }

            $('#sales_amount_td').val(sales_tax);

            total_amount();
        }

        function total_amount() {
            var amount = 0;
            $('.net_amount').each(function() {

                amount += +$(this).val();

            });
            $('#net').val(amount);
            var sales_tax = parseFloat($('#sales_amount_td').val());
            $('#net_after_tax').val(amount + sales_tax);

        }
    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
