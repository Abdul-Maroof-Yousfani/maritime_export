<?php

use App\Helpers\ReuseableCode;
use App\Helpers\NotificationHelper;
$MenuPermission = true;

$m = Session::get('run_company');
$accType = Auth::user()->acc_type;
$currentDate = date('Y-m-d');

use App\Helpers\PurchaseHelper;
use App\Helpers\SalesHelper;
use App\Helpers\CommonHelper;
$exportOrderShipmentDelivery=0;
if($exportOrder->shipment_delivery != ''){
    $exportOrderShipmentDelivery=1;
}
else{
    $exportOrderShipmentDelivery=0;
}
$exportOrderpacking=0;
if($exportOrder->packing_view != ''){
    $exportOrderpacking=1;
}
else{
    $exportOrderpacking=0;
}
$exportOrderQuantity=0;
if($exportOrder->quantity_view != ''){
    $exportOrderQuantity=1;
}
else{
    $exportOrderQuantity=0;
}
$exportUnitQuantity=0;
if($exportOrder->unit_price_view != ''){
    $exportUnitQuantity=1;
}
else{
    $exportUnitQuantity=0;
}
$exportAmountQuantity=0;
if($exportOrder->unit_price_view != ''){
    $exportAmountQuantity=1;
}
else{
    $exportAmountQuantity=0;
}


?>
@extends('layouts.default')
@section('content')
    @include('loader')
    @include('select2')
    @include('bundles_data')
    @include('modal')
    <style>
        * {
            font-size: 12px !important;
        }

        label {
            text-transform: capitalize;
        }
    </style>
    <?php $so_no = SalesHelper::get_unique_no_export(date('y'), date('m')); ?>

    <div class="container-fluid">
        <div class="row" style="display: none;" id="main">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="display: none;">
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well_N">
                    <div class="dp_sdw">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span class="subHeadingLabelClass">Edit Export Order</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            <form action="{{ url('/export/saleOrderUpdateDetail') }}" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label class="sf-label">voucher No <span
                                                                        class="rflabelsteric"><strong>*</strong></span></label>
                                                                <input readonly type="text" class="form-control"
                                                                    name="voucher_no" id="voucher_no"
                                                                    value="{{ strtoupper($exportOrder->voucehr_no) }}" />
                                                                <input type="hidden"
                                                                    name="id" id="id"
                                                                    value="{{$exportOrder->id}}" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label class="sf-label">Contract No <span
                                                                        class="rflabelsteric"><strong>*</strong></span></label>
                                                                <input type="text" class="form-control"
                                                                    name="contract_no" id="contract_no"
                                                                    value="{{ $exportOrder->contract_no }}" />
                                                            </div>

                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label class="sf-label">Voucher Date <span
                                                                        class="rflabelsteric"><strong>*</strong></span></label>
                                                                <input autofocus type="date" class="form-control"
                                                                    placeholder="" name="voucher_date" id="voucher_date"
                                                                    value="{{ $exportOrder->voucher_date }}" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label class="sf-label">Voucher Heading <span
                                                                        class="rflabelsteric"><strong>*</strong></span></label>
                                                                <input type="text" class="form-control"
                                                                    name="voucher_heading" id="voucher_heading"
                                                                    value="{{ $exportOrder->voucher_heading }}" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="sf-label">Buyer's Name <span
                                                                        class="rflabelsteric"><strong>*</strong></span></label>
                                                                <select style="width: 100%" name="buyers_id" id="ntn"
                                                                    class="form-control select2 requiredField">
                                                                    <option value="">Select</option>
                                                                    @foreach ($customers as $row)
                                                                        <option
                                                                            value="{{ $row->id . '*' . $row->cnic_ntn . '*' . $row->strn . '*' . $row->terms_of_payment }}"
                                                                            {{ $exportOrder->buyer_id == $row->id ? 'selected' : '' }}>
                                                                            {{ $row->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            {{-- <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
	                                    <label class="sf-label">Terms Of Payment <span class="rflabelsteric"><strong>*</strong></span></label>
	                                    <input onkeyup="calculate_due_date()"  type="number" class="form-control requiredField" placeholder="" name="model_terms_of_payment" id="model_terms_of_payment" value="" />
	                                 </div> --}}
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <label class="sf-label">Customer Address</label>
                                                                <input type="text" class="form-control" id="customer_address" readonly value="{{ $exportOrder->buyer ? $exportOrder->buyer->address ?? '' : '' }}" />
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <label class="sf-label">Customer NTN</label>
                                                                <input type="text" class="form-control" id="customer_ntn" readonly value="{{ $exportOrder->buyer ? $exportOrder->buyer->cnic_ntn ?? '' : '' }}" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-2 col-sm-2 col-xs-12">
                                                                @php
                                                                    $due_date = new DateTime($exportOrder->due_date);
                                                                    $delevery_date_to = new DateTime($exportOrder->delevery_date_to);
                                                                    // echo ;
                                                                @endphp
                                                                <label class="sf-label">Shipment Delivery Date From<span
                                                                        class="rflabelsteric"><strong>*</strong></span></label>
                                                                <input onchange="shipmentDelivery(2)" type="month" class="form-control delevery_date_from" placeholder=""
                                                                    name="due_date" id="due_date"
                                                                    value="{{ $due_date->format('Y-m') }}" />
                                                            </div>
                                                            <div class="col-lg-4 col-md-2 col-sm-2 col-xs-12">
                                                                <label class="sf-label">Shipment Delivery Date TO <span
                                                                        class="rflabelsteric"><strong>*</strong></span></label>
                                                                <input onchange="shipmentDelivery(2)" type="month" class="form-control delevery_date_to" placeholder=""
                                                                    name="delevery_date_to" id="delevery_date_to"
                                                                    value="{{ $delevery_date_to->format('Y-m') }}" />
                                                            </div>
                                                            <div class="col-lg-4 col-md-2 col-sm-2 col-xs-12">
                                                                <label class="sf-label">Marking /Labeling <span
                                                                        class="rflabelsteric"></span></label>
                                                                <input type="text" class="form-control" placeholder=""
                                                                    name="marking_labeling" id=""
                                                                    value="{{ $exportOrder->marking_labeling }}" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <label class="sf-label">Product Details</label>
                                                                <textarea class="form-control" name="quality_remarks" id="quality_remarks">{{ $exportOrder->quality_remarks }}</textarea>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <label class="sf-label">Product Specifications</label>
                                                                <textarea class="form-control" name="product_specification" id="product_specification">{{ $exportOrder->product_specification }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <table class="table table-bordered">
                                                                <tr>
                                                                    <td>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <h1><b>Beneficiary</b></h1>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Select Bank</label>
                                                                            <select onchange="banksDataBeneficiary();"
                                                                                class="form-control"
                                                                                name="beneficiary_bank"
                                                                                id="beneficiary_bank">
                                                                                <option value="">Select</option>
                                                                                @foreach ($banks as $bank)
                                                                                    <option
                                                                                        value="{{ $bank->id . '@' . $bank->account_title . '@' . $bank->bank_name . '@' . $bank->IBAN_no . '@' . $bank->bank_address . '@' . $bank->swift_code . '@' . $bank->account_no }}"
                                                                                        {{ $bank->id == $exportOrder->bank ? 'selected' : '' }}>
                                                                                        {{ $bank->bank_name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Account Title</label>
                                                                            <input type="text" class="form-control"
                                                                                name="beneficiary_account_title" readonly
                                                                                id="beneficiary_account_title" required>

                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Bank</label>
                                                                            <input type="text" class="form-control"
                                                                                name="beneficiary_bank_name" readonly
                                                                                id="beneficiary_bank_name" required>

                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">IBAN NO</label>
                                                                            <input type="text" class="form-control"
                                                                                name="beneficiary_iban" readonly
                                                                                id="beneficiary_iban" required>

                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Account No</label>
                                                                            <input type="text" class="form-control"
                                                                                name="beneficiary_account" readonly
                                                                                id="beneficiary_account" required>

                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Swift Code</label>
                                                                            <input type="text" class="form-control"
                                                                                name="beneficiary_swift" readonly
                                                                                id="beneficiary_swift" required>

                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Details Of
                                                                                Payment</label>
                                                                            <textarea type="text" class="form-control requiredField" readonly name="payment_details" id="payment_details"
                                                                                required>-</textarea>

                                                                        </div>
                                                                        <div
                                                                            class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                            <label for="">Address</label>
                                                                            <textarea type="text" class="form-control requiredField" readonly name="beneficiary_address"
                                                                                id="beneficiary_address" required> - </textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="row">
                                                            <table class="table table-bordered">
                                                                <tr>
                                                                    <td>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <h1><b>Correspondent</b></h1>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <input type="hidden" name="bank"
                                                                                id="banks">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Account Title</label>
                                                                            <input type="text" class="form-control"
                                                                                readonly name="account_title"
                                                                                id="account_title" required>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Bank</label>
                                                                            <input type="text" class="form-control"
                                                                                name="correspondent_bank" readonly
                                                                                id="correspondent_bank" required>

                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">IBAN No</label>
                                                                            <input type="text" class="form-control"
                                                                                name="correspondent_iban" readonly
                                                                                id="correspondent_iban" required>

                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Account No</label>
                                                                            <input type="text" class="form-control"
                                                                                name="correspondent_account" readonly
                                                                                id="correspondent_account" required>

                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Swift Code</label>
                                                                            <input type="text" class="form-control"
                                                                                name="correspondent_swift" readonly
                                                                                id="correspondent_swift" required>

                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Details Of
                                                                                Payment</label>
                                                                            <textarea type="text" class="form-control requiredField" name="payment_details" readonly id="payment_details"
                                                                                required>-</textarea>

                                                                        </div>
                                                                        <div
                                                                            class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                            <label for="">Address</label>
                                                                            <textarea type="text" class="form-control requiredField" name="correspondent_address" readonly
                                                                                id="correspondent_address" required>-</textarea>

                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <span class="subHeadingLabelClass">Shipping
                                                                    Instruction</span>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="addMoreConsigneeField">
                                                                <label class="sf-label">Consignee Details<span class="rflabelsteric"></span></label>
                                                                <button class="btn btn-xs btn-primary" type="button" onclick="addMoreConsigneeField()">Add More</button>

                                                                @forelse ($exportOrder->consigneeData as $consigneeCount => $consignee)
                                                                    <div id="removeConsigneeField{{++$consigneeCount}}">
                                                                        <button type="button" class="btn btn-danger btn-xs" onclick="removeConsigneeField({{$consigneeCount}})">Remove</button>
                                                                        <textarea rows="2" class="form-control" placeholder="" name="consignee[]" id="consignee{{$consigneeCount}}">{{$consignee->consignee}}</textarea>
                                                                    </div>
                                                                @empty
                                                                    <textarea rows="2" class="form-control" placeholder="" name="consignee[]" id="consignee"></textarea>
                                                                @endforelse

                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="addMoreNotifyField">
                                                                <label class="sf-label">Notify Party Details <span class="rflabelsteric"></span></label>
                                                                <button class="btn btn-xs btn-primary" type="button" onclick="addMoreNotifyField()">Add More</button>

                                                                @forelse ($exportOrder->notifyData as $notifyCount => $notify)
                                                                    <div id="removeNotifyField{{++$notifyCount}}">
                                                                        <button type="button" class="btn btn-danger btn-xs" onclick="removeNotifyField({{$notifyCount}})">Remove</button>
                                                                        <input type="text" class="form-control" placeholder="" name="notify_party_details[]" id="notify_party_details{{$notifyCount}}" value="{{$notify->notify}}"/>
                                                                    </div>
                                                                @empty
                                                                    <input type="text" class="form-control" placeholder="" name="notify_party_details[]" value="" />
                                                                @endforelse
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <label class="sf-label">Broker</label>
                                                                <input class="form-control" name="broker" id="broker" value="{{$exportOrder->broker}}" />
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <label class="sf-label">Document To Be Provided</label>
                                                                <textarea class="form-control" rows="10" name="document_to_provide" id="document_to_provide">{!! $exportOrder->document_to_provided !!}</textarea>
                                                            </div>

                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="sf-label">Other Condition<span
                                                                        class="rflabelsteric"></span></label>
                                                                <textarea class="form-control" rows="5" name="other_condition">{!! $exportOrder->other_condition !!}</textarea>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="sf-label">Force Majure<span
                                                                        class="rflabelsteric"></span></label>
                                                                <textarea class="form-control" rows="5" name="force_majure">{!! $exportOrder->force_majure !!}</textarea>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="sf-label">Application Law<span
                                                                        class="rflabelsteric"></span></label>
                                                                <textarea class="form-control" rows="5" name="application_law">{!! $exportOrder->application_law !!}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <div class="row">
                                                            <table class="table table-bordered">
                                                                <tr>
                                                                    <td colspan="2" class="text-center"><b>Export</b>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>INCOTERMS</td>
                                                                    <td>
                                                                        <select class="form-control" name="incoterm" onchange="unitPriceView(2); totalPriceView(2);"
                                                                            id="incoterm">
                                                                            <option value="">Select</option>
                                                                            @foreach ($incoterms as $incoterm)
                                                                                <option value="{{ $incoterm->id }}" {{ ($incoterm->id == $exportOrder->incoterm)? 'selected' : '' }}>
                                                                                    {{ $incoterm->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Packing Type </td>
                                                                    <td>
                                                                        <select class="form-control requiredField"
                                                                            name="type_of_loading" id="type_of_loading" onchange="packing1(2); unitPriceView(2); totalPriceView(2);">
                                                                            <option value="">Select</option>
                                                                            <option value="container" {{ ( $exportOrder->type_of_loading== "container")? 'selected' : '' }}>IN CONTAINER</option>
                                                                            <option value="Bulk" {{ ( $exportOrder->type_of_loading== "Bulk")? 'selected' : '' }}>IN BULK</option>

                                                                        </select>
                                                                        {{-- <input type="text" class="form-control"> --}}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>MODE OF TERM</td>
                                                                    <td>
                                                                        <select onchange="duedate(this)"
                                                                            class="form-control" name="mode_of_term"
                                                                            id="mode_of_term">
                                                                            <option value="">Select</option>
                                                                            @foreach ($modeofterms as $modeofterm)
                                                                                <option value="{{ $modeofterm->id }}" {{ ($modeofterm->id == $exportOrder->mode_of_term)? 'selected' : '' }}>
                                                                                    {{ $modeofterm->name }}</option>
                                                                            @endforeach
                                                                        </select>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>MODE OF TRANSPORT</td>
                                                                    <td>
                                                                        <select class="form-control" name="mode_transport"
                                                                            id="">
                                                                            <option value="">Select</option>
                                                                            @foreach ($modeoftransports as $modeoftransport)
                                                                                <option
                                                                                    value="{{ $modeoftransport->id }}" {{ ($modeoftransport->id == $exportOrder->mode_transport)? 'selected' : '' }}>
                                                                                    {{ $modeoftransport->name }}</option>
                                                                            @endforeach
                                                                        </select>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>ORIGIN</td>
                                                                    <td>
                                                                        <select class="form-control select2" name="origin" id="origin">
                                                                            <option value="">Select Origin</option>
                                                                            @foreach ($origins as $origin)
                                                                                <option value="{{ $origin->id }}" {{ ($exportOrder->origin == $origin->id) ? 'selected' : '' }}>{{ $origin->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>PORT</td>
                                                                    <td>
                                                                        <select class="form-control select2" name="port" id="port">
                                                                            <option value="">Select Port</option>
                                                                            @foreach ($ports as $port)
                                                                                <option value="{{ $port->id }}" {{ ($exportOrder->port == $port->id) ? 'selected' : '' }}>{{ $port->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>PORT OF DISCHARGE</td>
                                                                    <td>

                                                                        <input type="text" class="form-control" onkeyup="unitPriceView(2); totalPriceView(2);"
                                                                            name="port_of_discharge" id="port_of_discharge" value="{{$exportOrder->port_of_discharge}}">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>PORT LOADING</td>
                                                                    <td>

                                                                        <input type="text" class="form-control"
                                                                        value="{{$exportOrder->port_loading}}"
                                                                            name="port_loading">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>CONSIGNEE</td>
                                                                    <td>
                                                                        <select class="form-control select2" name="consignee" id="consignee">
                                                                            <option value="">Select Consignee</option>
                                                                            @foreach ($consignees as $consignee)
                                                                                <option value="{{ $consignee->id }}" {{ ($exportOrder->consignee == $consignee->id) ? 'selected' : '' }}>{{ $consignee->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>GRADE</td>
                                                                    <td>
                                                                        <select class="form-control select2" name="grade" id="grade">
                                                                            <option value="">Select Grade</option>
                                                                            @foreach ($grades as $grade)
                                                                                <option value="{{ $grade->id }}" {{ ($exportOrder->grade == $grade->id) ? 'selected' : '' }}>{{ $grade->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>SIZE</td>
                                                                    <td>
                                                                        <select class="form-control select2" name="size" id="size">
                                                                            <option value="">Select Size</option>
                                                                            @foreach ($sizes as $size)
                                                                                <option value="{{ $size->id }}" {{ ($exportOrder->size == $size->id) ? 'selected' : '' }}>{{ $size->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>PACKING</td>
                                                                    <td>
                                                                        <select class="form-control select2" name="packing" id="packing">
                                                                            <option value="">Select Packing</option>
                                                                            @foreach ($packings as $packing)
                                                                                <option value="{{ $packing->id }}" {{ ($exportOrder->packing == $packing->id) ? 'selected' : '' }}>{{ $packing->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>HS CODE</td>
                                                                    <td>
                                                                        <select class="form-control select2"
                                                                            name="hs_code" id="hs_code">
                                                                            <option value="1005.9000" {{ ($exportOrder->hs_code == "1005.9000")? 'selected' : '' }}>1005.9000</option>
                                                                            <option value="1207.4000" {{ ($exportOrder->hs_code == "1207.4000")? 'selected' : '' }}>1207.4000</option>
                                                                            <option value="1006.4000" {{ ($exportOrder->hs_code == "1006.4000")? 'selected' : '' }}>1006.4000</option>
                                                                            <option value="1006.3090" {{ ($exportOrder->hs_code == "1006.3090")? 'selected' : '' }}>1006.3090</option>
                                                                            <option value="1006.3010" {{ ($exportOrder->hs_code == "1006.3010")? 'selected' : '' }}>1006.3010</option>
                                                                            <option value="1006.3010" {{ ($exportOrder->hs_code == "1006.3010")? 'selected' : '' }}>1006.3010</option>
                                                                            <option value="1006.3010" {{ ($exportOrder->hs_code == "1006.3010")? 'selected' : '' }}>1006.3010</option>
                                                                            <option value="1006.3010" {{ ($exportOrder->hs_code == "1006.3010")? 'selected' : '' }}>1006.3010</option>
                                                                            <option value="1006.3010" {{ ($exportOrder->hs_code == "1006.3010")? 'selected' : '' }}>1006.3010</option>
                                                                            <option value="1006.2000" {{ ($exportOrder->hs_code == "1006.2000")? 'selected' : '' }}>1006.2000</option>
                                                                            <option value="1006.3010" {{ ($exportOrder->hs_code == "1006.3010")? 'selected' : '' }}>1006.3010</option>
                                                                            <option value="1006.3010" {{ ($exportOrder->hs_code == "1006.3010")? 'selected' : '' }}>1006.3010</option>
                                                                            <option value="1006.3010" {{ ($exportOrder->hs_code == "1006.3010")? 'selected' : '' }}>1006.3010</option>
                                                                            <option value="1006.3090" {{ ($exportOrder->hs_code == "1006.3090")? 'selected' : '' }}>1006.3090</option>
                                                                            <option value="1006.3090" {{ ($exportOrder->hs_code == "1006.3090")? 'selected' : '' }}>1006.3090</option>
                                                                            <option value="1213.0000" {{ ($exportOrder->hs_code == "1213.0000")? 'selected' : '' }}>1213.0000</option>
                                                                        </select>
                                                                        {{-- <input type="text" class="form-control"
                                                                            name="hs_code"> --}}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>PARTIAL PAYMENT</td>
                                                                    <td>
                                                                        <select class="form-control"
                                                                            name="partial_payment">
                                                                            <option value="">Select</option>
                                                                            <option value="0" {{($exportOrder->partial_payment == 0)? 'selected' : ''}}>Yes</option>
                                                                            <option value="1" {{($exportOrder->partial_payment == 1)? 'selected' : ''}}>No</option>
                                                                        </select>

                                                                    </td>
                                                                </tr>

                                                                {{-- <tr>
                                                                    <td>DELEVERY DATE</td><td> 

                                                                        <input type="date" class="form-control" name="delevery_date" value="{{date('Y-m-d')}}">
                                                                    </td>
                                                                </tr> --}}
                                                                <tr>
                                                                    <td>Transhipment</td>
                                                                    <td>
                                                                        <select class="form-control transhipment" name="transhipment" onchange="shipmentDelivery(2)"
                                                                            id="">
                                                                            <option value="0" {{($exportOrder->transhipment == 0)? 'selected' : ''}}>Select</option>
                                                                            <option value="2" {{($exportOrder->transhipment == 2)? 'selected' : ''}}>SHALL BE PERMITTED</option>
                                                                            <option value="1" {{($exportOrder->transhipment == 1)? 'selected' : ''}}>SHALL NOT BE PERMITTED</option>
                                                                        </select>
                                                                        {{-- <input type="text" class="form-control"> --}}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Part Shipment</td>
                                                                    <td>
                                                                        <select class="form-control part_shipment" name="part_shipment" onchange="shipmentDelivery(2)"
                                                                            id="part_shipment">
                                                                            <option value="0" {{($exportOrder->part_shipment == 0)? 'selected' : ''}}>Select</option>
                                                                            <option value="2" {{($exportOrder->part_shipment == 2)? 'selected' : ''}}>SHALL BE PERMITTED</option>
                                                                            <option value="1" {{($exportOrder->part_shipment == 1)? 'selected' : ''}}>SHALL NOT BE PERMITTED</option>
                                                                        </select>
                                                                        {{-- <input type="text" class="form-control"> --}}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Insurance Coverd By</td>
                                                                    <td>
                                                                        <select class="form-control"
                                                                            name="insurance_coverd" id="">
                                                                            <option value="0">Select</option>
                                                                            <option value="2" {{($exportOrder->insurance_coverd == 2)? 'selected' : ''}}>Buyer</option>
                                                                            <option value="1" {{($exportOrder->insurance_coverd == 1)? 'selected' : ''}}>Supplier</option>
                                                                        </select>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Advance Payment (%)</td>
                                                                    <td>
                                                                        <input type="number" class="form-control"
                                                                            max="100" name="advance_payment" value="{{$exportOrder->advance_payment}}">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Payment Days (no of days)</td>
                                                                    <td>
                                                                        <input type="number" class="form-control"
                                                                            name="payment_days" value="{{$exportOrder->payment_days}}">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Currency </td>
                                                                    <td>
                                                                        <select class="form-control" onchange="setRate(); unitPriceView(2); totalPriceView(2);"
                                                                            id="select_rate">
                                                                            <option value="">select</option>
                                                                            @foreach ($conversions as $conversion)
                                                                                <option
                                                                                    value="{{ $conversion->id . ',' . $conversion->rate }}" {{($conversion->id==$exportOrder->currencey_id)? 'selected' : ''}}>
                                                                                    {{ $conversion->curreny }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <input type="hidden" class="form-control"
                                                                            name="rate_conversion"
                                                                            id="rate_conversion_id">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Rate </td>
                                                                    <td>
                                                                        <input type="number" class="form-control"
                                                                            name="rate_of_conversion" value="{{$exportOrder->currencey_rate}}"
                                                                            id="rate_conversion">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <label class="sf-label">SHIPMENT DELIVERY</label>
                                                                        <textarea class="form-control" name="shipment_delivery" id="shipment_delivery">
                                                                            {{ $exportOrder->shipment_delivery }}
                                                                        </textarea>
                                                                    </div>
                                                                </tr>
                                                                <tr>
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <label class="sf-label">PACKING</label>
                                                                        <textarea class="form-control" name="packing" id="packing">
                                                                            {{ $exportOrder->packing_view }}
                                                                        </textarea>
                                                                    </div>
                                                                </tr>
                                                                <tr>
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <label class="sf-label">Qunatity</label>
                                                                        <textarea class="form-control" name="quantity_view" id="quantity_view">
                                                                            {{ $exportOrder->quantity_view }}
                                                                        </textarea>
                                                                    </div>
                                                                </tr>
                                                                <tr>
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <label class="sf-label">Unit Price</label>
                                                                        <textarea class="form-control" name="unit_price_view" id="unit_price_view">
                                                                            {{ $exportOrder->unit_price_view }}
                                                                        </textarea>
                                                                    </div>
                                                                </tr>
                                                                <tr>
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <label class="sf-label">Total Price</label>
                                                                        <textarea class="form-control" name="total_price_view" id="total_price_view">
                                                                            {{ $exportOrder->total_price_view }}
                                                                        </textarea>
                                                                    </div>
                                                                </tr>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


                                            {{-- This data section of Sale order  --}}
                                            <div class="lineHeight">&nbsp;</div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <span class="subHeadingLabelClass">Export Order Data</span>
                                            </div>
                                            <div class="lineHeight">&nbsp;&nbsp;&nbsp;</div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr class="text-center">
                                                                    <th colspan="10" class="text-center">Sales Order
                                                                        Detail</th>
                                                                    <th colspan="2" class="text-center">
                                                                        <input type="button"
                                                                            class="btn btn-sm btn-primary"
                                                                            onclick="AddMoreDetails()"
                                                                            value="Add More Rows" />
                                                                    </th>
                                                                    <th class="text-center">
                                                                        <span class="badge badge-success"
                                                                            id="span">1</span>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-center" style="width: 20%;">Item</th>
                                                                    <th class="text-center">Item Size</th>
                                                                    <th class="text-center">Quality</th>
                                                                    <th class="text-center">Uom<span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                    <th class="text-center">HS Code</th>
                                                                    <th class="text-center">Pack Type<span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                    <th class="text-center">Bags Type<span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                    <th class="text-center">Bag Color<span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                    <th class="text-center">PackSize<span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                    <th class="text-center">Pack UOM<span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                    <th class="text-center"> Export QTY. <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                    <th class="text-center">Total QTY (Bags)<span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                    <th class="text-center">FCL QTY<span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                    <th class="text-center">FCL Size<span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                    <th class="text-center">NO. of Container<span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                    <th class="text-center">Delete<span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="AppnedHtml">
                                                                @foreach ($exportOrder->exportOrderData as $key => $exportOrderData)
                                                                    <tr class="cnt" title="1">
                                                                        <td>
                                                                            <input type="hidden" value="{{$exportOrderData->id}}" name="data_id[]" >
                                                                            <select onchange="get_uom('{{ ++$key }}')"
                                                                                name="sub_ic_des[]"
                                                                                id="sub_ic_des{{ $key }}"
                                                                                class="form-control select2 sub_ic_des" style="width:100%;">
                                                                                <option value="">Select</option>
                                                                                @foreach (CommonHelper::get_item_by_category(81) as $row)
                                                                                    <?php
                                                                                    $uom = CommonHelper::get_uom($row->id);
                                                                                    $uom_name = CommonHelper::get_uom_name($uom);
                                                                                    $pack_uom = ($row->pack_uom)? CommonHelper::get_uom_name($row->pack_uom) : '';
                                                                                    $hs_code = $row->hs_code ?? '';
                                                                                    ?>
                                                                                    <option
                                                                                        value="{{ $row->id . ',' . $uom . ',' . $uom_name . ',' . $row->pack_type . ',' . $row->pack_size . ',' . $row->pack_uom . ',' . $pack_uom . ',' . $hs_code }}"
                                                                                        {{($exportOrderData->item_id == $row->id)? 'selected' : ''}}>
                                                                                        {{ $row->sub_ic }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select class="form-control select2" name="item_size[]" id="item_size{{ $key }}">
                                                                                <option value="">Select</option>
                                                                                <option value="0-19" {{ ($exportOrderData->item_size == '0-19') ? 'selected' : '' }}>0-19</option>
                                                                                <option value="10-20" {{ ($exportOrderData->item_size == '10-20') ? 'selected' : '' }}>10-20</option>
                                                                                <option value="20-30" {{ ($exportOrderData->item_size == '20-30') ? 'selected' : '' }}>20-30</option>
                                                                                <option value="30-40" {{ ($exportOrderData->item_size == '30-40') ? 'selected' : '' }}>30-40</option>
                                                                                <option value="40-50" {{ ($exportOrderData->item_size == '40-50') ? 'selected' : '' }}>40-50</option>
                                                                                <option value="50-60" {{ ($exportOrderData->item_size == '50-60') ? 'selected' : '' }}>50-60</option>
                                                                                <option value="60-70" {{ ($exportOrderData->item_size == '60-70') ? 'selected' : '' }}>60-70</option>
                                                                                <option value="70-80" {{ ($exportOrderData->item_size == '70-80') ? 'selected' : '' }}>70-80</option>
                                                                                <option value="80-90" {{ ($exportOrderData->item_size == '80-90') ? 'selected' : '' }}>80-90</option>
                                                                                <option value="90-100" {{ ($exportOrderData->item_size == '90-100') ? 'selected' : '' }}>90-100</option>
                                                                                <option value="100+" {{ ($exportOrderData->item_size == '100+') ? 'selected' : '' }}>100+</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select class="form-control select2" name="quality[]" id="quality{{ $key }}">
                                                                                <option value="">Select</option>
                                                                                <option value="A" {{ ($exportOrderData->quality == 'A') ? 'selected' : '' }}>A</option>
                                                                                <option value="A+" {{ ($exportOrderData->quality == 'A+') ? 'selected' : '' }}>A+</option>
                                                                                <option value="B" {{ ($exportOrderData->quality == 'B') ? 'selected' : '' }}>B</option>
                                                                                <option value="B+" {{ ($exportOrderData->quality == 'B+') ? 'selected' : '' }}>B+</option>
                                                                                <option value="C" {{ ($exportOrderData->quality == 'C') ? 'selected' : '' }}>C</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><input readonly type="text"
                                                                                class="form-control" name="uom_id[]"
                                                                                id="uom_id{{ $key }}" value="{{$exportOrderData->uom_id}}"></td>
                                                                        <td><input readonly type="text"
                                                                                class="form-control" name="hs_code_display[]"
                                                                                id="hs_code_display{{ $key }}" value=""></td>
                                                                        <td><input readonly type="text"
                                                                                class="form-control" name="pack_type[]"
                                                                                id="pack_type{{ $key }}" value="{{$exportOrderData->pack_type}}"></td>
                                                                        <td>
                                                                            <select class="form-control" name="bag_type[]"
                                                                                id="bag_type{{ $key }}" onchange="getPackSize({{ $key }})">
                                                                                <option value="">Select</option>
                                                                                @foreach ($printingBags as $printingBag)
                                                                                    <option
                                                                                        value="{{ $printingBag->printing_bags }}"
                                                                                        {{($exportOrderData->bag_type == $printingBag->printing_bags)? 'selected' : ''}}>
                                                                                        {{ strtoupper($printingBag->printing_bags) }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select class="form-control" onchange="packing1(2)" name="bag_color[]"
                                                                                id="bag_color{{ $key }}">
                                                                                <option value="">Select</option>
                                                                                <option
                                                                                        value="N/A"
                                                                                        {{($exportOrderData->bag_color == 'N/A')? 'selected' : ''}}>
                                                                                        N/A
                                                                                 </option>
                                                                                 <option
                                                                                        value="Red"
                                                                                        {{($exportOrderData->bag_color == 'Red')? 'selected' : ''}}>
                                                                                        Red
                                                                                 </option>
                                                                                 <option
                                                                                        value="Yellow"
                                                                                        {{($exportOrderData->bag_color == 'Yellow')? 'selected' : ''}}>
                                                                                        Yellow
                                                                                 </option>
                                                                                
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select class="form-control" name="pack_size[]"
                                                                                id="pack_size{{ $key }}" onchange="claculation({{ $key }}); packing1(2);">
                                                                                <option value="">Select</option>
                                                                                @if ($exportOrderData->pack_size)
                                                                                    <option value="{{$exportOrderData->pack_size}}" selected>{{$exportOrderData->pack_size}}</option>
                                                                                @endif
                                                                            </select>
                                                                            {{-- <input type="text" class="form-control"
                                                                                name="pack_size[]" onkeyup="claculation('1')"
                                                                                onblur="claculation('1')" id="pack_size1"> --}}
                                                                        </td>
                                                                        <td><input type="text" class="form-control" value="{{$exportOrderData->item->packUom->uom_name??''}}"
                                                                                name="pack_uom[]" readonly id="pack_uom{{ $key }}">
                                                                        </td>
                                                                        <td><input type="text" onkeyup="claculation({{ $key }}); quantityView(2);"
                                                                                onblur="claculation({{ $key }}); quantityView(2);"
                                                                                class="form-control requiredField zerovalidate"
                                                                                name="actual_qty[]" id="actual_qty{{ $key }}"
                                                                                min="1" value="{{$exportOrderData->actual_qty}}"></td>
                                                                        <td><input type="text" class="form-control" value="{{number_format($exportOrderData->total_qty, 3)}}"
                                                                                readonly name="total_qty[]" id="total_qty{{ $key }}">
                                                                        </td>
                                                                        <td><input type="text" class="form-control" value="{{$exportOrderData->flc_qty}}"
                                                                                name="flc_qty[]" onkeyup="claculation({{ $key }}); quantityView(2);"
                                                                                id="flc_qty{{ $key }}"></td>
                                                                        <td><input type="text" class="form-control" value="{{$exportOrderData->flc_size}}"
                                                                                name="flc_size[]" onkeyup="claculation({{ $key }}); quantityView(2);"
                                                                                id="flc_size{{ $key }}"></td>
                                                                        <td><input type="text" class="form-control"
                                                                                name="no_of_container[]"  value="{{$exportOrderData->no_of_container}}"
                                                                                id="no_of_container{{ $key }}"></td>
                                                                        <td rowspan="2" style="background-color: #ccc">
                                                                            <input onclick="view_history({{ $key }})" type="checkbox"
                                                                                id="view_history{{ $key }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="9"></td>
                                                                        <td> <label for="">QTY
                                                                                Variation(%)</label><input type="text"
                                                                                onkeyup="" onblur=""
                                                                                class="form-control"  value="{{$exportOrderData->qty_variation}}"
                                                                                placeholder="QTY Variation"
                                                                                name="qty_variation[]" id="qty_variation{{ $key }}">
                                                                        </td>
                                                                        <td> <label for="">Rate</label><input
                                                                                type="text" onkeyup="claculation({{ $key }}); unitPriceView(2); totalPriceView(2);"
                                                                                onblur="claculation({{ $key }}); unitPriceView(2); totalPriceView(2);" value="{{$exportOrderData->rate}}"
                                                                                class="form-control rate_of_item"
                                                                                placeholder="Rate" name="rate[]"
                                                                                id="rate{{ $key }}"></td>
                                                                        <td><label for="">Amount</label><input readonly
                                                                                type="text" class="form-control amount"
                                                                                name="amount[]" id="amount{{ $key }}"
                                                                                placeholder="AMOUNT" min="1"
                                                                                value="0.00"></td>
                                                                        <td class="hide" style="width: 110px"><label
                                                                                for="">Sales
                                                                                Tax</label>
                                                                            <select onchange="tax_percent(this.id,{{ $key }})"
                                                                                class="form-control" name="tax[]"
                                                                                id="tax_percent{{ $key }}">
                                                                                <option value="0,0">Select</option>
                                                                                @foreach (ReuseableCode::invoice_tax() as $row)
                                                                                    <option
                                                                                        value='{{ $row->acc_id . ',' . $row->tax_rate }}'>
                                                                                        {{ $row->tax_rate }}</option>
                                                                                @endforeach
                                                                                <input type="hidden" name="tax_rate[]"
                                                                                    id="tax_rate{{ $key }}">
                                                                        </td>
                                                                        <td class="hide"> <label for="">Sale Tax
                                                                                Amount</label><input readonly type="text"
                                                                                class="form-control requiredField tax_amount"
                                                                                name="tax_amount[]" id="tax_amount{{ $key }}"
                                                                                min="1" value="0.00"></td>
                                                                        <td class="hide"> <label for="">Amount After
                                                                                Tax</label><input type="text" readonly
                                                                                class="form-control net_amount_dis"
                                                                                name="after_dis_amount[]"
                                                                                id="after_dis_amount{{ $key }}" min="1"
                                                                                value="0.00"></td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tbody>
                                                                <tr
                                                                    style="background-color: darkgrey;font-size:large;font-weight: bold">
                                                                    <td class="text-center" colspan="10">Total</td>
                                                                    <td id="" class="text-right" colspan="2">
                                                                        <input readonly class="form-control"
                                                                            type="text" id="net" />
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group hide form-inline text-right">
                                                <label for="email">Total Before Tax </label>
                                                <input readonly type="text" class="form-control" id="total">
                                            </div>
                                            <div class="form-group form-inline text-right">
                                                <label for="email">Total </label>
                                                <input readonly type="text" class="form-control"
                                                    id="total_after_sales_tax">
                                            </div>
                                            <table>
                                                <tr>
                                                    <td style="text-transform: capitalize;" id="rupees"></td>
                                                    <input type="hidden" value="" name="rupeess"
                                                        id="rupeess1" />
                                                </tr>
                                            </table>
                                            <input type="hidden" id="d_t_amount_1">
                                        </div>

                                    </div>
                                </div>
                                <div class="demandsSection"></div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                        {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let counts = {{count($exportOrder->exportOrderData)}}
        let consigneeCounter = {{count($exportOrder->consigneeData)}}
        let notifyCounter = {{count($exportOrder->notifyData)}}
        $(function() {
            // alert(counts);
            // return
            banksDataBeneficiary();
            
            // Populate customer details on page load
            var buyerId = $('#ntn').find(':selected').val();
            if (buyerId) {
                var ntn = buyerId.split('*');
                var customerId = ntn[0];
                if (customerId) {
                    $.ajax({
                        url: '{{ route('getCustomerDetails') }}',
                        data: { id: customerId },
                        type: 'GET',
                        success: function(response) {
                            $('#customer_address').val(response.address || '');
                            $('#customer_ntn').val(response.ntn || '');
                        }
                    });
                }
            }
            
            // Handle buyer selection change
            $('#ntn').on('change', function() {
                var buyerId = $(this).val();
                if (buyerId) {
                    var ntn = buyerId.split('*');
                    var customerId = ntn[0];
                    if (customerId) {
                        $.ajax({
                            url: '{{ route('getCustomerDetails') }}',
                            data: { id: customerId },
                            type: 'GET',
                            success: function(response) {
                                $('#customer_address').val(response.address || '');
                                $('#customer_ntn').val(response.ntn || '');
                            }
                        });
                    }
                }
            });
            
            CKEDITOR.replace('quality_remarks');
            // CKEDITOR.replace('consignee');
            CKEDITOR.replace('product_specification');
            CKEDITOR.replace('shipment_delivery');
            CKEDITOR.replace('packing');
            CKEDITOR.replace('quantity_view');
            CKEDITOR.replace('unit_price_view');
            CKEDITOR.replace('total_price_view');
            
            CKEDITOR.replace('document_to_provide');

            for (let i = 1; i <= counts; i++) {
                claculation(i);
            }
            for (let index = 1; index <= consigneeCounter; index++) {
                CKEDITOR.replace('consignee'+index);
            }
        })


        function addMoreConsigneeField(id){
            $('#addMoreConsigneeField').append(
                `<div id="removeConsigneeField${++consigneeCounter}">
                    <button type="button" class="btn btn-danger btn-xs" onclick="removeConsigneeField(${consigneeCounter})">Remove</button>
                    <textarea rows="2" class="form-control" placeholder="" name="consignee[]" id="consignee${consigneeCounter}"></textarea>
                </div>`
            );
            CKEDITOR.replace('consignee'+consigneeCounter);
        }

        function removeConsigneeField(id) {
            $('#removeConsigneeField'+id).remove();
         }

        function addMoreNotifyField(id){
            $('#addMoreNotifyField').append(
                `<div id="removeNotifyField${++notifyCounter}">
                    <button type="button" class="btn btn-danger btn-xs" onclick="removeNotifyField(${notifyCounter})">Remove</button>
                    <input type="text" class="form-control" placeholder="" name="notify_party_details[]" id="notify_party_details${notifyCounter}" />
                </div>`
            );
        }
        function removeNotifyField(id) {
            $('#removeNotifyField'+id).remove();
        }


        function getPackSize(id) {
            let bagType = $('#bag_type' + id).val();
            // alert(bagType);
            // return
            $.ajax({
                url: '{{ url('/export/getPackSize') }}',
                data: {
                    bagType: bagType
                },
                type: 'GET',
                success: function(response) {
                    let packSizes = "<option value=''>Select</option> ";
                    response.forEach(element => {
                        packSizes +=
                            `<option value="${element.bag_weight}">${element.bag_weight}</option>`
                    });
                    console.log(packSizes);
                    $('#pack_size' + id).html(packSizes);
                }
            })
        }

        var Counter = 1

        function AddMoreDetails() {
            // '<td><input type="text" class="form-control" name="pack_size[]" onkeyup="claculation(' + Counter +
            //     ')" onblur="claculation(' + Counter +
            //     ')" id="pack_size' + Counter + '" ></td>' +

            Counter++;
            $('#AppnedHtml').append('<tr class="cnt" id="RemoveRows' + Counter + '">' +
                '<td><select style="width:100%;" onchange="get_uom(' + Counter + ')" name="sub_ic_des[]" id="sub_ic_des' + Counter +
                '" class="form-control select2 sub_ic_des">' +
                '<option value="">Select</option>' +
                '@foreach (CommonHelper::get_finish_goods(2) as $row)' +
                '<?php $uom = CommonHelper::get_uom($row->id);
                $pack_uom = CommonHelper::get_uom_name($row->pack_uom); ?>' +
                '<option value="{{ $row->id . ',' . $uom . ',' . $row->pack_type . ',' . $row->pack_size . ',' . $pack_uom }}">{{ $row->sub_ic }}</option>' +
                '@endforeach' +
                '</select>' +
                '</td>' +
                '<td>' +
                '<select class="form-control select2" name="item_size[]" id="item_size' + Counter + '">' +
                '<option value="">Select</option>' +
                '<option value="0-19">0-19</option>' +
                '<option value="10-20">10-20</option>' +
                '<option value="20-30">20-30</option>' +
                '<option value="30-40">30-40</option>' +
                '<option value="40-50">40-50</option>' +
                '<option value="50-60">50-60</option>' +
                '<option value="60-70">60-70</option>' +
                '<option value="70-80">70-80</option>' +
                '<option value="80-90">80-90</option>' +
                '<option value="90-100">90-100</option>' +
                '<option value="100+">100+</option>' +
                '</select>' +
                '</td>' +
                '<td>' +
                '<select class="form-control select2" name="quality[]" id="quality' + Counter + '">' +
                '<option value="">Select</option>' +
                '<option value="A">A</option>' +
                '<option value="A+">A+</option>' +
                '<option value="B">B</option>' +
                '<option value="B+">B+</option>' +
                '<option value="C">C</option>' +
                '</select>' +
                '</td>' +
                '<td><input readonly  type="text" class="form-control" name="uom_id[]" id="uom_id' + Counter +
                '" ></td>' +
                '<td><input readonly type="text" class="form-control" name="hs_code_display[]" id="hs_code_display' + Counter +
                '" ></td>' +
                '<td><input readonly type="text" class="form-control" name="pack_type[]" id="pack_type' + Counter +
                '" ></td>' +
                '<td>' +
                '<select class="form-control" name="bag_type[]" id="bag_type' + Counter + '" onchange="getPackSize(' +
                Counter + ')">' +
                '<option value="">Select</option>' +
                '@foreach ($printingBags as $printingBag)' +
                '<option value="{{ $printingBag->printing_bags }}">{{ strtoupper($printingBag->printing_bags) }}</option>' +
                '@endforeach' +
                '</select>' +
                '</td>' +
                '<td>' +
                '<select class="form-control" onchange="packing1(2)" name="bag_color[]" id="bag_color' + Counter + '" ' +
                '<option value="">Select</option>' +
                '<option value="N/A">N/A</option>' +
                '<option value="Red">Red</option>' +
                '<option value="Yellow">Yellow</option>' +
                '</select>' +
                '</td>' +
                '<td>' +
                '<select class="form-control" name="pack_size[]" id="pack_size' + Counter + '" onchange="claculation(' +
                Counter + '); packing1(2);">' +
                '<option value="">Select</option>' +
                '</select>' +
                '</td>' +

                '<td><input type="text" class="form-control" name="pack_uom[]" readonly id="pack_uom' + Counter +
                '" ></td>' +
                '<td><input type="text" onkeyup="claculation(' + Counter + '); quantityView(2);" onblur="claculation(' + Counter +
                '); quantityView(2);" class="form-control requiredField zerovalidate" name="actual_qty[]" id="actual_qty' + Counter +
                '"  min="1" value=""></td>' +
                '<td><input type="text" class="form-control" name="total_qty[]" readonly id="total_qty' + Counter +
                '"></td>' +

                '<td><input type="text" class="form-control" onkeyup="claculation(' + Counter +
                '); quantityView(2);" name="flc_qty[]" id="flc_qty' + Counter + '"></td>' +
                '<td><input type="text" onchange="quantityView(2)" class="form-control" name="flc_size[]" id="flc_size' + Counter + '"></td>' +
                '<td><input type="text" class="form-control" name="no_of_container[]" id="no_of_container' +
                Counter +
                '"></td>' +
                '<td rowspan="2" class="text-center">' +
                '<input onclick="view_history(' + Counter + ')" type="checkbox" id="view_history' + Counter +
                '">&nbsp;&nbsp;' +
                '<button type="button" class="btn btn-sm btn-danger" id="BtnRemove' + Counter +
                '" onclick="RemoveSection(' + Counter + ')"> - </button>' +
                '</td>' +
                '</tr>' +
                '<tr  id="second' + Counter + '">' +
                '<td colspan="7"></td>' +
                '<td><label for="">QTY Variation(%)</label><input type="text" class="form-control" name="qty_variation[]" id="qty_variation' +
                Counter + '" ></td>' +
                '<td><label for="">Rate</label><input type="text" onkeyup="claculation(' + Counter +
                '); unitPriceView(2); totalPriceView(2);" onblur="claculation(' + Counter + '); unitPriceView(2); totalPriceView(2);" class="form-control rate_of_item" name="rate[]" id="rate' +
                Counter + '" ></td>' +
                '<td><label for="">Amount</label><input readonly  type="text" class="form-control amount" name="amount[]" id="amount' +
                Counter + '"></td>' +
                '<td  class="hide" style="width: 110px"><label for="">Sales Tax</label>' +
                '<select onchange="tax_percent(this.id,' + Counter +
                ')"  class="form-control" name="tax[]" id="tax_percent' + Counter + '">' +
                '<option value="0,0">Select</option>' +
                '@foreach (ReuseableCode::invoice_tax() as $row)' +
                '<option value="{{ $row->acc_id . ',' . $row->tax_rate }}">{{ $row->tax_rate }}</option>' +
                '@endforeach' +
                '</select>' +
                '<input type="hidden" name="tax_rate[]" id="tax_rate' + Counter + '">' +
                '</td>' +
                '<td  class="hide"> <label for="">Sale Tax Amount</label><input readonly type="text"  class="form-control requiredField tax_amount" name="tax_amount[]" id="tax_amount' +
                Counter + '"  min="1" value="0.00"></td>' +
                '<td class="hide"><label for="">Amount After Tax</label><input readonly type="text" class="form-control net_amount_dis" name="after_dis_amount[]" id="after_dis_amount' +
                Counter + '"></td>' +
                '</tr>');
            $('.select2').select2();

            var AutoCount = 1;
            $(".AutoCounter").each(function() {
                AutoCount++;
                $(this).prop('title', AutoCount);

            });
            $('.sam_jass').bind("enterKey", function(e) {

                var check = (this.id).split('_');

                if ($('#product_' + check[1]).val() != '') {
                    alert('Bundles Selectd Against This');
                    return false;
                }
                $('#items').modal('show');


            });
            $('.sam_jass').keyup(function(e) {
                if (e.keyCode == 13) {
                    selected_id = this.id;
                    $(this).trigger("enterKey");


                }

            });

            $('.sam_jass').bind("enterKeyy", function(e) {


                $('#budles_dataa').modal('show');


            });

            $('.sam_jass').keyup(function(e) {
                if (e.keyCode == 113) {
                    selected_id = this.id;
                    $(this).trigger("enterKeyy");


                }

            });


            $('.sami').bind("enterKey", function(e) {


                $('#items_searc_for_bundless').modal('show');


            });
            $('.sami').keyup(function(e) {
                if (e.keyCode == 13) {
                    selected_idd = this.id;
                    $(this).trigger("enterKey");


                }

            });
            var itemsCount = $(".cnt").length;

            $('#span').text(itemsCount);
        }

        function RemoveSection(Row) {

            $('#RemoveRows' + Row).remove();
            $('#second' + Row).remove();
            var AutoCount = 1;
            var AutoCount = 1;
            $(".AutoCounter").each(function() {
                AutoCount++;
                $(this).prop('title', AutoCount);
            });
            var itemsCount = $(".cnt").length;

            $('#span').text(itemsCount);
        }

        function duedate(value) {

            let mode_of_term = value.options[value.selectedIndex].text;
            let date = new Date();
            date.setDate(date.getDate() + parseFloat(mode_of_term));

            console.log(date.toISOString().split('T')[0]);
            $('#due_date').val(date.toISOString().split('T')[0]);

        }

        function view_history(id) {
            var v = $('#sub_ic_des' + id).val();
            if ($('#view_history' + id).is(":checked")) {
                if (v != null) {
                    showDetailModelOneParamerter('sdc/sals_history?id=' + v);
                } else {
                    alert('Select Item');
                }
            }
        }

        var x = 0;


        $('.sam_jass').bind("enterKey", function(e) {

            var check = (this.id).split('_');

            if ($('#product_' + check[1]).val() != '') {
                alert('Bundles Selectd Against This');
                return false;
            }
            $('#items').modal('show');


        });
        $('.sam_jass').keyup(function(e) {
            if (e.keyCode == 13) {
                selected_id = this.id;
                $(this).trigger("enterKey");


            }

        });

        $('.sam_jass').bind("enterKeyy", function(e) {


            $('#budles_dataa').modal('show');


        });

        $('.sam_jass').keyup(function(e) {
            if (e.keyCode == 113) {
                selected_id = this.id;
                $(this).trigger("enterKeyy");


            }

        });


        $('.stop').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {

                e.preventDefault();
                return false;
            }
        });




        function net_amount() {
            var amount = 0;
            $('.amount').each(function(i, obj) {

                amount += +$('#' + obj.id).val();
                console.log(obj.id);
            });
            amount = parseFloat(amount).toFixed(3);

            $('#total').val(amount);


            var net_amount = 0;
            $('.net_amount_dis').each(function(i, obj) {

                net_amount += +$('#' + obj.id).val();
            });
            net_amount = parseFloat(net_amount).toFixed(3);
            $('#total_after_sales_tax').val(net_amount);

        }

        $(document).ready(function() {
            shipmentDelivery(1);
            packing1(1);
            quantityView(1);
            unitPriceView(1);
            totalPriceView(1);
            $(".btn-success").click(function(e) {

                //alert();
                var purchaseRequest = new Array();
                var val;
                //$("input[name='demandsSection[]']").each(function(){
                purchaseRequest.push($(this).val());



                //});
                var _token = $("input[name='_token']").val();
                for (val of purchaseRequest) {
                    jqueryValidationCustom();
                    if (validate == 0) {
                        //alert(response);
                    } else {
                        return false;
                    }
                }

            });
        });

        function removeSeletedPurchaseRequestRows(id, counter) {
            var totalCounter = $('#totalCounter').val();
            if (totalCounter == 1) {
                alert('Last Row Not Deleted');
            } else {
                var lessCounter = totalCounter - 1;
                var totalCounter = $('#totalCounter').val(lessCounter);
                var elem = document.getElementById('removeSelectedPurchaseRequestRow_' + counter + '');
                elem.parentNode.removeChild(elem);
            }

        }




        function claculation(number) {
            //packing1(2);
            var qty = $('#actual_qty' + number).val() || 0;
            var rate = $('#rate' + number).val();
            var total = parseFloat(qty * rate).toFixed(2);
            var pack_size = $('#pack_size' + number).val();
            var total_qty = (qty * 1000) / pack_size;



            $('#total_qty' + number).val(total_qty);
            $('#amount' + number).val(total);


            let fclQty = $('#flc_qty' + number).val() || 0;
            console.log(fclQty, qty, fclQty / qty);
            // $('#no_of_container'+ number).val((qty/fclQty).toFixed(2));

            var amount = 0;
            count = 1;
            $('.net_amount_dis').each(function(i, obj) {

                amount += +$('#' + obj.id).val();

                count++;
            });
            amount = parseFloat(amount);


            tax_percent('tax_percent' + number, number);
            net_amount();

            //  toWords(1);
        }

        function tax_percent(id, index_number) {
            var number = id.replace("tax_percent", "");
            var amount = parseFloat($('#amount' + number).val());

            var tax_percent = $('#tax_percent' + index_number).val();

            var final_text = tax_percent.split(',');

            $('#tax_rate' + index_number).val(final_text[1]);

            var x = $('#' + id).val();

            x = x.split(',');
            x = parseFloat(x[1]);


            if (x > 100) {
                alert('Percentage Cannot Exceed by 100');
                $('#' + id).val(0);
                x = 0;
            }

            x = x * amount;
            var tax_amount = parseFloat(x / 100).toFixed(2);
            $('#tax_amount' + number).val(tax_amount);

            var tax_amount = parseFloat($('#tax_amount' + number).val());


            if (isNaN(tax_amount)) {

                $('#tax_amount' + number).val(0);
                tax_amount = 0;
            }



            var amount_after_discount = parseFloat(amount + tax_amount).toFixed(3);



            $('#after_dis_amount' + number).val(amount_after_discount);
            var amount_after_discount = $('#after_dis_amount' + number).val();

            if (amount_after_discount == 0) {
                $('#after_dis_amount' + number).val(amount);
                $('#net_amounttd_' + number).val(amount);
                $('#net_amount' + number).val(amount_after_discount);
            } else {

                $('#net_amounttd_' + number).val(amount_after_discount);
                $('#after_dis_amount' + number).val(amount_after_discount);
            }

            $('#cost_center_dept_amount' + number).text(amount_after_discount);
            $('#cost_center_dept_hidden_amount' + number).val(amount_after_discount);

            net_amount();


        }



        function get_detail(id, number) {
            var item = $('#' + id).val();
            $.ajax({
                url: '{{ url('/pdc/get_data') }}',
                data: {
                    item: item
                },
                type: 'GET',
                success: function(response) {

                    var data = response.split(',');
                    $('#uom_id' + number).val(data[0]);


                }
            })

        }
        $(".remove").each(function() {
            $(this).html($(this).html().replace(/,/g, ''));
        });


        function get_ntn() {
            var ntn = $('#ntn').val();
            ntn = ntn.split('*');
            $('#buyers_ntn').val(ntn[1]);
            $('#buyers_sales').val(ntn[2]);
            
            // Get customer details via AJAX
            var customerId = ntn[0];
            if (customerId) {
                $.ajax({
                    url: '{{ route('getCustomerDetails') }}',
                    data: { id: customerId },
                    type: 'GET',
                    success: function(response) {
                        $('#customer_address').val(response.address || '');
                        $('#customer_ntn').val(response.ntn || '');
                    }
                });
            }
            $('#model_terms_of_payment').val(ntn[3]);
            calculate_due_date();
            sales_tax();
        }

        function setRate() {
            var rate = $('#select_rate').val();
            var rate1 = rate.split(',');
            console.log(rate1);
            $('#rate_conversion').val(rate1[1]);
            $('#rate_conversion_id').val(rate1[0]);
        }


        function calculate_due_date() {

            var days = parseFloat($('#model_terms_of_payment').val()) - 1;
            var tt = document.getElementById('so_date').value;

            var date = new Date(tt);
            var newdate = new Date(date);
            newdate.setDate(newdate.getDate() + days);
            var dd = newdate.getDate();

            var dd = ("0" + (newdate.getDate() + 1)).slice(-2);
            var mm = ("0" + (newdate.getMonth() + 1)).slice(-2);
            var y = newdate.getFullYear();
            var someFormattedDate = +y + '-' + mm + '-' + dd;

            document.getElementById('due_date').value = someFormattedDate;
        }

        function sales_tax() {

            var total = parseFloat($('#net').val());
            if (isNaN(total)) {
                total = 0;
            }

            if ($("#sales_tax_applicable").prop('checked') == false) {
                total = 0;
            }

            var sales_tax_percent = parseFloat($('#sales_percent').val());
            var sales_tax = ((total / 100) * sales_tax_percent).toFixed(2);
            $('#sales_tax').val(sales_tax);


            var strn = $('#buyers_sales').val();
            var total = parseFloat($('#net').val());

            if ($("#sales_tax_further_applicable").prop('checked') == false) {
                total = 0;
            }

            if (strn == '') {
                var sales_tax_percent = parseFloat($('#sales_percent_other').val());
                var sales_tax_further = ((total / 100) * sales_tax_percent).toFixed(2);
                $('#sales_tax_further').val(sales_tax_further);

            } else {
                sales_tax_further = 0;
                $('#sales_tax_further').val(0);
            }

            total_cal();

            toWords(1);
        }


        function total_cal() {
            var sales_tax_amount = parseFloat($('#sales_tax').val());
            var sales_tax_amount_further = parseFloat($('#sales_tax_further').val());
            var total = sales_tax_amount + sales_tax_amount_further;
            $('#sales_total').val(total);

            var before_tax = parseFloat($('#net').val());


            $('#total').val(before_tax);
            var after_tax = parseFloat($('#sales_total').val());
            var total_after = before_tax + after_tax;
            $('#total_after_sales_tax').val(total_after);

            $('#d_t_amount_1').val(total_after);


        }


        function applicable() {
            sales_tax();
        }

        function get_uom(id) {
            packing1(2);
            quantityView(2);
            unitPriceView(2);
            totalPriceView(2);
            var sub_ic_data = $('#sub_ic_des' + id).val();
            sub_ic_data = sub_ic_data.split(',');
            $('#uom_id' + id).val(sub_ic_data[1]);
            $('#pack_type' + id).val(sub_ic_data[3]);
            $('#pack_size' + id).val(sub_ic_data[4]);
            $('#pack_uom' + id).val(sub_ic_data[6]);
            $('#hs_code_display' + id).val(sub_ic_data[7] || '');

        }

        function banksData() {

            var bank_id = $('#banks').find(':selected').val();
            var fina_data = bank_id.split('@');
            $('#account_title').val(fina_data[1]);
            $('#correspondent_bank').val(fina_data[2]);
            $('#correspondent_iban').val(fina_data[3]);
            $('#correspondent_address').val(fina_data[4]);
            $('#correspondent_swift').val(fina_data[5]);
            $('#correspondent_account').val(fina_data[6]);
        }

        function convertDateFormat(inputDate) {
            if (typeof inputDate !== 'string') {
                // Handle cases where inputDate is not a string (e.g., already in desired format)
                return inputDate;
            }
            
            // Parse the input date string into a Date object
            var parts = inputDate.split('-');
            var year = parseInt(parts[0]);
            var month = parseInt(parts[1]);
            var dateObj = new Date(year, month - 1); // Month is zero-based

            // Array of month names
            var monthNames = ["January", "February", "March", "April", "May", "June",
                            "July", "August", "September", "October", "November", "December"];

            // Format the date as "Month YYYY"
            var formattedDate = monthNames[dateObj.getMonth()] + ' ' + year;

            return formattedDate;
        }
        

        function shipmentDelivery(val){
            var delevery_date_from = $('.delevery_date_from').val();
            var delevery_date_to = $('.delevery_date_to').val();
            var transhipment = $('.transhipment').val();
            var part_shipment = $('.part_shipment').val();
            var part_shipment_value= part_shipment == 2 ? 'SHALL BE PERMITTED' : 'SHALL NOT BE PERMITTED';
            var transhipment_value= transhipment == 2 ? 'SHALL BE PERMITTED' : 'SHALL NOT BE PERMITTED';   
            var shipmentDelivery = {{ $exportOrderShipmentDelivery }};
            
            if(shipmentDelivery==0 || val == 2){

                var editor = CKEDITOR.instances['shipment_delivery'];
                if (editor) {
                    var content ='';
                    if (delevery_date_from != '' || delevery_date_to != '') {
                        content += "DELIVERY DATE : " + convertDateFormat(delevery_date_from) + " - " + convertDateFormat(delevery_date_to) + "<br>";
                    }
                    if (part_shipment > 0) {
                        content += "PART SHIPMENT: " + part_shipment_value + "<br>";
                    }

                    if (transhipment > 0) {
                        content += "TRANSHIPMENT: " + transhipment_value + "<br>";
                    }

                    editor.setData(content);
                }
            }
        }

        function packing1(val){
            var shipmentDelivery = {{ $exportOrderpacking }};
            
            if(shipmentDelivery==0 || val == 2){
                var editor = CKEDITOR.instances['packing'];
                var content ='';
                $('.sub_ic_des').each(function(){
                    var id=$(this).attr('id');
                    explode_id = id.split('sub_ic_des');
                    var pack_type=$('#pack_type'+explode_id[1]).val();
                    var uom=$('#uom_id'+explode_id[1]).val();
                    var pack_size=$('#pack_size'+explode_id[1]).val();
                    var pack_uom=$('#pack_uom'+explode_id[1]).val();
                    var color=$('#bag_color'+explode_id[1]).val();
                    var type_of_loading=$('#type_of_loading').val();

                

                        
                        if (editor) {
                            
                            if(type_of_loading=='Bulk'){
                                content += "In Bulk ";
                            }else{
                                content += "" + pack_size + " " + pack_uom + " "+ pack_type+" ";
                            }
                            if (color != '' && color != 'N/A') {
                                content += "" + color;
                            }
                            content += "<br/>";
                            

                            
                        }
                    
                
                })
                editor.setData(content);
            }
    
        }

        function quantityView(val){
            var shipmentDelivery = {{ $exportOrderQuantity }};
            
            if(shipmentDelivery==0 || val == 2){
                var editor = CKEDITOR.instances['quantity_view'];
                var content ='';
                $('.sub_ic_des').each(function(){
                    var id=$(this).attr('id');
                    explode_id = id.split('sub_ic_des');
                    var qty_variation=$('#qty_variation'+explode_id[1]).val();
                    var uom=$('#uom_id'+explode_id[1]).val();
                    var actual_qty=$('#actual_qty'+explode_id[1]).val();
                    var flc_qty=$('#flc_qty'+explode_id[1]).val();
                    var flc_size=$('#flc_size'+explode_id[1]).val();
                   
                    var variation= qty_variation ? '+- ' + qty_variation + '(%) - ' : ' ';
                    var fclQty=(flc_qty == 0) ? 1 : flc_qty;
                   
                    if (editor) {
                        content += actual_qty + '    ' + uom +  variation +  flc_qty + 'x' +  flc_size + ' FCL - ' + Math.round(actual_qty/fclQty,2) + ' ' + uom + ' PER ' + flc_size + ' FCL';
                    }
                    content += "<br/>";
                
                })
                editor.setData(content);
            }
    
        }

        function unitPriceView(val){
            var shipmentDelivery = {{ $exportUnitQuantity }};
            
            if(shipmentDelivery==0 || val == 2){
                var editor = CKEDITOR.instances['unit_price_view'];
                var content ='';
                $('.sub_ic_des').each(function(){
                    var id=$(this).attr('id');
                    explode_id = id.split('sub_ic_des');
                    var name_currency=$('#select_rate').val();
                    if(name_currency){
                        name_currency=$('#select_rate').find('option:selected').text();
                    }
                    var incoterm_name=$('#incoterm').val();
                    if(incoterm_name){
                        incoterm_name=$('#incoterm').find('option:selected').text();
                    }
                    var type_of_loading=$('#type_of_loading').val();
                    
                    var port_of_discharge=$('#port_of_discharge').val();
                    var uom=$('#uom_id'+explode_id[1]).val();
                    var actual_qty=$('#actual_qty'+explode_id[1]).val();
                    var rate=$('#rate'+explode_id[1]).val();
                    
                    name_currency = name_currency !='' ? name_currency : '-'; 
                    incoterm_name = incoterm_name !='' ? incoterm_name : '-';
                    
                    
                    
                   
                    if (editor) {
                        content += name_currency + ' ' + rate + ', PER ' + uom + ' ';
                        content += 'NET ';
                        incoterm_name=incoterm_name.trim();
                        if (incoterm_name == 'FOB'){
                            
                            content += incoterm_name;
                        }else{
                            content += incoterm_name + '  ' + port_of_discharge + ', In ' + type_of_loading;
                        }
                        content += ' ('+convertAmountToWords(rate)+' ONLY)';
                        content += "<br/>";
                    }
                    
                
                })
                editor.setData(content);
            }
    
        }


        function totalPriceView(val){
            var shipmentDelivery = {{ $exportAmountQuantity }};
            
            if(shipmentDelivery==0 || val == 2){
                var editor = CKEDITOR.instances['total_price_view'];
                var content ='';
                var total=0;
                var name_currency='';
                var incoterm_name='';
                var type_of_loading='';
                var port_of_discharge='';
                $('.sub_ic_des').each(function(){
                    var id=$(this).attr('id');
                    explode_id = id.split('sub_ic_des');
                    name_currency=$('#select_rate').val();
                    if(name_currency){
                        name_currency=$('#select_rate').find('option:selected').text();
                    }
                    incoterm_name=$('#incoterm').val();
                    if(incoterm_name){
                        incoterm_name=$('#incoterm').find('option:selected').text();
                    }
                    type_of_loading=$('#type_of_loading').val();
                    
                    port_of_discharge=$('#port_of_discharge').val();
                    var uom=$('#uom_id'+explode_id[1]).val();
                    var actual_qty=$('#actual_qty'+explode_id[1]).val();
                    var rate=$('#rate'+explode_id[1]).val();
                    total+=(rate*actual_qty);
                    name_currency = name_currency !='' ? name_currency : '-'; 
                    incoterm_name = incoterm_name !='' ? incoterm_name : '-';
                    
                })

                if (editor) {
                    
                    content += name_currency + ' ' + total;
                    content += ' NET ';
                    incoterm_name=incoterm_name.trim();
                   
                    content += incoterm_name + '  ' + port_of_discharge + ', In ' + type_of_loading;
                    content += ' ('+convertAmountToWords(total)+' ONLY)';
                    content += "<br/>";
                }
                editor.setData(content);
            }
    
        }
        

        function convertAmountToWords(amount) {
            // Array of words for numbers
            var words = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen"];
            var tens = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];

            // Function to convert less than 1000
            function convertLessThanThousand(num) {
                if (num === 0) return "";
                if (num < 20) return words[num];
                var digit1 = Math.floor(num / 100);
                var digit2 = Math.floor((num % 100) / 10);
                var digit3 = num % 10;
                var result = "";
                if (digit1 !== 0) {
                    result += words[digit1] + " Hundred ";
                }
                if (digit2 >= 2) {
                    result += tens[digit2] + " ";
                    result += words[digit3];
                } else {
                    result += words[(digit2 * 10) + digit3];
                }
                return result;
            }

            // Function to convert
            function convert(amount) {
                if (amount === 0) return "Zero";
                var billion = Math.floor(amount / 1000000000);
                var million = Math.floor((amount % 1000000000) / 1000000);
                var thousand = Math.floor((amount % 1000000) / 1000);
                var remainder = amount % 1000;
                var result = "";
                if (billion !== 0) {
                    result += convertLessThanThousand(billion) + " Billion ";
                }
                if (million !== 0) {
                    result += convertLessThanThousand(million) + " Million ";
                }
                if (thousand !== 0) {
                    result += convertLessThanThousand(thousand) + " Thousand ";
                }
                if (remainder !== 0) {
                    result += convertLessThanThousand(remainder);
                }
                return result.trim();
            }

            return convert(amount);
        }


        function banksDataBeneficiary() {

            var bank_id = $('#beneficiary_bank').find(':selected').val();
            var fina_data = bank_id.split('@');

            $('#beneficiary_account_title').val(fina_data[1]);
            $('#beneficiary_bank_name').val(fina_data[2]);
            $('#beneficiary_iban').val(fina_data[3]);
            $('#beneficiary_address').val(fina_data[4]);
            $('#beneficiary_swift').val(fina_data[5]);
            $('#beneficiary_account').val(fina_data[6]);
            $.ajax({
                url: '{{ route('getCorrespondentBankDetail') }}',
                data: {
                    id: fina_data[0]
                },
                type: 'GET',
                success: function(response) {
                    // console.log(response);
                    if (response == null || response == "") {
                        alert("this Beneficiary doesn't have Correspondent bank");
                        $('#account_title').val('');
                        $('#correspondent_bank').val('');
                        $('#correspondent_iban').val('');
                        $('#correspondent_address').val('');
                        $('#correspondent_swift').val('');
                        $('#correspondent_account').val('');
                        return;
                    }
                    $('#banks').val(response.id);
                    $('#account_title').val(response.account_title);
                    $('#correspondent_bank').val(response.bank_name);
                    $('#correspondent_iban').val(response.IBAN_no);
                    $('#correspondent_address').val(response.bank_address);
                    $('#correspondent_swift').val(response.swift_code);
                    $('#correspondent_account').val(response.account_no);
                    // var data = response.split(',');
                    // $('#uom_id' + number).val(data[0]);


                }
            });
        }
        $('.select2').select2();
    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
