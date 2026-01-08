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

        label {
            text-transform: capitalize;
        }

        .input-container {
            display: -ms-flexbox;
            /* IE10 */
            display: flex;
            width: 100%;
            margin-bottom: 15px;
        }

        .icon {
            padding: 15px;
            background: #8d9399;
            color: white;
            min-width: 20px;
            text-align: center;
            height: 43px;
        }

        .input-field {
            /* width: 100%;
              padding: 10px; */
            outline: none;
        }

        .input-field:focus {
            border: 2px solid rgb(125, 129, 134);
        }
    </style>


    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well_N">
                    <div class="dp_sdw">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span class="subHeadingLabelClass">Edit Quotation Form</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            <?php echo Form::open(['url' => url('quotation/update_quotation/' . $quotation->id) . '?m=' . $m . '', 'enctype' => 'multipart/form-data', 'id' => 'cashPaymentVoucherForm', 'class' => 'stop']); ?>
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

                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class="sf-label">Quotation NO. <span
                                                                class="rflabelsteric"><strong>*</strong></span></label>
                                                        <input readonly type="text" class="form-control requiredField"
                                                            placeholder="" name="pr_no" id="pr_no"
                                                            value="{{ strtoupper($quotation->voucher_no) }}" />
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class="sf-label">Group Number. <span
                                                                class="rflabelsteric"><strong>*</strong></span></label>
                                                        <input type="text" class="form-control" placeholder=""
                                                            name="group_number" id="group_number"
                                                            value="{{ $quotation->group_number }}" />
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class="sf-label">Quotation Date.</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="date" class="form-control requiredField"
                                                            name="demand_date_1" id="demand_date_1"
                                                            value="{{ $quotation->voucher_date }}" />
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="sf-label">Ref No.</label>
                                                        <input autofocus type="text" class="form-control "
                                                            placeholder="Ref  No" name="ref_no" id="slip_no_1"
                                                            value="{{ $quotation->ref_no }}" />
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="sf-label">Supplier
                                                            <span class="rflabelsteric"><strong>*</strong></span></label>
                                                        <button type="button" class="btn btn-xs btn-primary"
                                                            onclick="showDetailModelOneParamerter('pdc/createSupplierFormAjax');">Add
                                                            Supplier</button>
                                                        <select class="form-control select2 requiredField" name="supplier"
                                                            id="supplier">
                                                            <option value="">Select</option>
                                                            @foreach (CommonHelper::get_all_supplier() as $row)
                                                                <option value="{{ $row->id }}"
                                                                    {{ $row->id == $quotation->vendor_id ? 'selected' : '' }}>
                                                                    {{ $row->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @php
                                                        $attachment = $quotation->comments;
                                                        $c1 = 1;
                                                    @endphp
                                                    @if(!empty($attachment) && count($attachment)>0)
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <th>S/no</th>
                                                                <th>Link </th>
                                                                <th>Action</th>
                                                            </tr>
                                                            @foreach ($attachment as $key=> $item)
                                                                <tr id="r{{$item->id}}">
                                                                    <td>{{$key}}</td>
                                                                    <td>Attachement {{$c1}} </td>
                                                                    <td><a class="btn btn-success" href="{{asset($item->image_src)}}" target="_blank" download>download</a>
                                                                        <a class="btn btn-danger" onclick="status({{$item->id}})" target="_blank">delete</a>
                                                                    </td>
                
                                                                </tr>
                                                                @php
                                                                    $c1++;
                                                                @endphp
                                                            @endforeach
                                                        </table>
                                                    @endif   
                                                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                       <label for="">Attachment file</label>
                                                        <div class="input-container">
                                                           <input class="input-field form-control" type="file"  name="file[]">
                                                  
                                                           <i class="fa fa-plus icon" onclick="add()">
                                                           </i>
                                           
                                                         </div>
                                                   </div>
                                                    <div id="form"></div>
                                                </div>
                                                <input type="hidden" name="demand_type" id="demand_type">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <label class="sf-label">Description</label>
                                                        <textarea name="description_1" id="description_1" rows="4" cols="50" style="resize:none;"
                                                            class="form-control">{{ $quotation->description }}</textarea>
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
                                                                <th colspan="10" class="text-center">Purchase Request
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
                                                                <th style="width: 100px" class="text-center">PR NO#</th>
                                                                <th class="text-center">Item</th>
                                                                <th class="text-center">Item Remarks</th>
                                                                <th style="width: 100px" class="text-center">UOM</th>
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
                                                            @foreach ($quotation->quotationDatas as $row)
                                                                @php
                                                                    $lastRateQty = CommonHelper::get_last_rate_qty($row->demandData->sub_item_id);
                                                                    $priviousApprovedQuotationQty = CommonHelper::get_privious_approved_quotation_qty($row->demandData->master_id,$row->demandData->id,$row->demandData->sub_item_id);
                                                                @endphp
                                                                <tr class="text-center">
                                                                    <td>{{ $count++ }}</td>
                                                                    <td>{{ $row->demandData->demand_no }}</td>
                                                                    <td>{{ CommonHelper::get_item_name($row->demandData->sub_item_id) }}
                                                                    </td>
                                                                    <td>
                                                                        <textarea name="sub_item_desc[]" class="form-control" cols="30" rows="10">{{ $row->sub_item_desc }}</textarea>
                                                                    </td>
                                                                    <td>{{ CommonHelper::get_uom($row->demandData->sub_item_id) }}
                                                                    </td>
                                                                    <td>{{ $row->demandData->qty - $priviousApprovedQuotationQty }}</td>
                                                                    <td>{{ $lastRateQty ? $lastRateQty->voucher_date : '-' }}
                                                                    </td>
                                                                    <td>{{ $lastRateQty ? $lastRateQty->rate : 0 }}</td>
                                                                    <td><input
                                                                            onkeyup="calcu('{{ $count }}','{{ $row->demandData->qty }}')"
                                                                            onblur="calcu('{{ $count }}','{{ $row->demandData->qty }}')"
                                                                            class="form-control requiredField"
                                                                            step="0.01" type="number" name="rate[]"
                                                                            id="rate{{ $count }}"
                                                                            value="{{ $row->rate }}" /> </td>
                                                                    <td><input readonly
                                                                            class="form-control requiredField amount"
                                                                            step="0.01" type="number" name="amount[]"
                                                                            id="amount{{ $count }}"
                                                                            value="{{ $row->amount }}" /> </td>
                                                                    <td><input class="form-control requiredField "
                                                                            step="0.01"
                                                                            onkeyup="discount_percent('{{ $count }}')"
                                                                            type="number" name="discount_percent[]"
                                                                            id="discount_percent{{ $count }}"
                                                                            value="{{ $row->discount_percent }}" />
                                                                    </td>
                                                                    <td><input class="form-control requiredField "
                                                                            step="0.01" type="number"
                                                                            onkeyup="discount_amount('{{ $count }}')"
                                                                            name="discount_amount[]"
                                                                            id="discount_amount{{ $count }}"
                                                                            value="{{ $row->discount_amount }}" />
                                                                    </td>
                                                                    <td><input readonly
                                                                            class="form-control requiredField net_amount"
                                                                            step="0.01" type="number"
                                                                            name="net_amount[]"
                                                                            value="{{ $row->net_amount }}"
                                                                            id="net_amount{{ $count }}" /> </td>
                                                                    <input type="hidden" name="pr_data_id[]"
                                                                        value="{{ $row->demandData->id }}" />
                                                                    <input type="hidden" name="quotation_data_id[]"
                                                                        value="{{ $row->id }}" />
                                                                    <input type="hidden" name="pr_id[]"
                                                                        value="{{ $row->pr_id }}" />
                                                                </tr>
                                                            @endforeach

                                                        </tbody>

                                                        <tbody>
                                                            <tr
                                                                style="background-color: darkgrey;font-size:large;font-weight: bold">
                                                                <td class="text-center" colspan="12">Total</td>
                                                                <td id="" class="text-right" colspan="1">
                                                                    <input readonly class="form-control" type="text"
                                                                        id="net" />
                                                                </td>
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
                                                                                <option value="0"
                                                                                    {{ $quotation->gst == 0 ? 'selected' : '' }}>
                                                                                    Select Sales Tax
                                                                                </option>

                                                                                @foreach (ReuseableCode::get_all_sales_tax() as $row)
                                                                                    <option value="{{ $row->percent }}"
                                                                                        {{ $row->percent == $quotation->gst && $quotation->gst != 0 ? 'selected' : '' }}>
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

        var counter = 0;
        function add() {


counter++;
var html = ` <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" id="row` + counter +
    `">
                <label>&nbsp</label>
            <div class="input-container">
            <input class="input-field form-control" type="file" placeholder="Form No " name="file[]"><i class="fa fa-minus icon" onclick="minus(` +
    counter + `)"></i>
    </div>
</div>`;

$('#form').append(html);

}
function minus(number) {
$('#row' + number).remove();
counter--;
}

        function status(id)
        {
            $.ajax({
                url:'{{url("pdc/delete_attachment")}}',
                data:{id:id},
                type:'GET',
                success:function(response)
                {            
                    console.log(response);
                    console.log(id);
                    if(response == id)
                    {
                    $('#r'+id).remove();
                    }else{
                    alert('This attacment not exist in data base');
                    } 

                }
            })
            e.preventDefault();
            return false;  
        }



        $(function() {
            sales_tax();
        })

        function discount_percent(id) {
            let total = $('#amount' + id).val();
            let discount_percent = parseFloat($('#discount_percent' + id).val()) || 0
            if (discount_percent > 100) {
                alert("Discount Percent must be greater or equal 100");
                $('#discount_percent' + id).val(0)
                $('#discount_amount' + id).val(0)
                $('#net_amount' + id).val(total);
                sales_tax();
                return
            }

            if (discount_percent > 0) {
                let disAmount = (total * discount_percent) / 100
                $('#discount_amount' + id).val(disAmount.toFixed(2))
                total = total - disAmount
            } else {
                $('#discount_amount' + id).val(0)
            }
            $('#net_amount' + id).val(total);
            sales_tax();
        }

        function discount_amount(id) {
            let total = $('#amount' + id).val();
            let discount_amount = parseFloat($('#discount_amount' + id).val()) || 0
            if (discount_amount > 0) {
                let disAmount = (discount_amount / total) * 100
                if (disAmount > 100) {
                    alert("Discount Percent must be greater or equal 100");
                    $('#discount_percent' + id).val(0)
                    $('#discount_amount' + id).val(0)
                    $('#net_amount' + id).val(total);
                    sales_tax();
                    return
                }
                $('#discount_percent' + id).val(disAmount.toFixed(2))
                total = total - discount_amount

            } else {
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
            total_amount();
            var sales_tax = 0;
            var sales_tax_per_value = $('#sales_taxx').val();

            if (sales_tax_per_value != '0' || sales_tax_per_value != 0) {
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
