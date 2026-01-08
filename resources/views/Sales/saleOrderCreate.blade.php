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
                                <span class="subHeadingLabelClass">Export Order</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            <form action="{{ route('saleOrderStore') }}" method="POST">
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
                                                                    value="{{ strtoupper($so_no) }}" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label class="sf-label">Contract No <span
                                                                        class="rflabelsteric"><strong>*</strong></span></label>
                                                                <input type="text" class="form-control"
                                                                    name="contract_no" id="contract_no" />
                                                            </div>

                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label class="sf-label">Voucher Date <span
                                                                        class="rflabelsteric"><strong>*</strong></span></label>
                                                                <input autofocus type="date" class="form-control"
                                                                    placeholder="" name="voucher_date" id="voucher_date"
                                                                    value="{{ date('Y-m-d') }}" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label class="sf-label">Voucher Heading <span
                                                                        class="rflabelsteric"><strong>*</strong></span></label>
                                                                <input type="text" class="form-control" placeholder=""
                                                                    name="voucher_heading" id="voucher_heading"
                                                                    value="" />
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
                                                                            value="{{ $row->id . '*' . $row->cnic_ntn . '*' . $row->strn . '*' . $row->terms_of_payment }}">
                                                                            {{ $row->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            {{-- <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
	                                    <label class="sf-label">Terms Of Payment <span class="rflabelsteric"><strong>*</strong></span></label>
	                                    <input onkeyup="calculate_due_date()"  type="number" class="form-control requiredField" placeholder="" name="model_terms_of_payment" id="model_terms_of_payment" value="" />
	                                 </div> --}}
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
                                                                <label class="sf-label">Shipment Delivery Date From<span
                                                                        class="rflabelsteric"><strong>*</strong></span></label>
                                                                <input type="month" class="form-control delevery_date_from" placeholder="" onchange="shipmentDelivery(2)"
                                                                    name="due_date" id="due_date" value="" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
                                                                <label class="sf-label">Shipment Delivery Date TO <span
                                                                        class="rflabelsteric"><strong>*</strong></span></label>
                                                                <input type="month" class="form-control delevery_date_to" placeholder=""
                                                                    name="delevery_date_to" id="delevery_date_to" onchange="shipmentDelivery(2)"
                                                                    value="" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
                                                                <label class="sf-label">Marking /Labeling <span
                                                                        class="rflabelsteric"></span></label>
                                                                <input type="text" class="form-control" placeholder=""
                                                                    name="marking_labeling" id="" value="" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <label class="sf-label">Product Details</label>
                                                                <textarea class="form-control" name="quality_remarks" id="quality_remarks"></textarea>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <label class="sf-label">Product Specifications</label>
                                                                <textarea class="form-control" name="product_specification" id="product_specification"></textarea>
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
                                                                                        value="{{ $bank->id . '@' . $bank->account_title . '@' . $bank->bank_name . '@' . $bank->IBAN_no . '@' . $bank->bank_address . '@' . $bank->swift_code . '@' . $bank->account_no }}">
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







                                                        {{-- <div class="row">
							
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									   <label class="sf-label">Base Length</label>
									   <input class="form-control" type="text" name="base_legnth" id=""> </div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									   <label class="sf-label">Broken Grain <span class="rflabelsteric"></span></label>
									<input class="form-control" type="text" name="broken_grain" id=""> 
									</div>
									
								 </div>
								 <div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<label class="sf-label">Moisture Content <span class="rflabelsteric"></span></label>
										<input class="form-control" type="text" name="mosture_content" id="">  </div>
									 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<label class="sf-label">Demand Yellow Grain <span class="rflabelsteric"></span></label>
										<input class="form-control" type="text" name="demand_yellow_grain" id="">  </div>
								 </div>
								 <div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<label class="sf-label">Chalky Grain <span class="rflabelsteric"></span></label>
										<input class="form-control" type="text" name="chalky_grain" id=""> </div>
									 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<label class="sf-label">Foreign Grain<span class="rflabelsteric"></span></label>
										<input class="form-control" type="text" name="foreign_grain" id="">  </div>
								 </div>
								 <div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<label class="sf-label">Paddy Grain<span class="rflabelsteric"></span></label>
										<input class="form-control" type="text" name="paddy_grain" id="">  </div>
									 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<label class="sf-label">Under Milled & Red <span class="rflabelsteric"></span></label>
										<input class="form-control" type="text" name="under_milled" id="">  </div>
								 </div>
								 <div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<label class="sf-label">Well Milled Double Ploish<span class="rflabelsteric"></span></label>
										<input class="form-control" type="text" name="milled_double_polish" id="">  </div>
									 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<label class="sf-label">Whiteness<span class="rflabelsteric"></span></label>
										<input class="form-control" type="text" name="whiteness" id="">  </div>
								 </div> --}}
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
                                                                            {{-- <label for="">Select Bank</label>
                                                                            <select onchange="banksData();"
                                                                                class="form-control" name="bank"
                                                                                id="banks">
                                                                                <option value="">Select</option>
                                                                                @foreach ($banks as $bank)
                                                                                    <option
                                                                                        value="{{ $bank->id . '@' . $bank->account_title . '@' . $bank->bank_name . '@' . $bank->IBAN_no . '@' . $bank->bank_address . '@' . $bank->swift_code . '@' . $bank->account_no }}">
                                                                                        {{ $bank->bank_name }}</option>
                                                                                @endforeach
                                                                            </select> --}}
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
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
                                                                id="addMoreConsigneeField">
                                                                <label class="sf-label">Consignee Details<span
                                                                        class="rflabelsteric"></span></label> <button
                                                                    class="btn btn-xs btn-primary" type="button"
                                                                    onclick="addMoreConsigneeField()">Add More</button>
                                                                <textarea rows="2" class="form-control" placeholder="" name="consignee[]" id="consignee"></textarea>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
                                                                id="addMoreNotifyField">
                                                                <label class="sf-label">Notify Party Details <span
                                                                        class="rflabelsteric"></span></label> <button
                                                                    class="btn btn-xs btn-primary" type="button"
                                                                    onclick="addMoreNotifyField()">Add More</button>
                                                                <input type="text" class="form-control" placeholder=""
                                                                    name="notify_party_details[]"
                                                                    id="notify_party_details" />
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <label class="sf-label">Broker<span
                                                                        class="rflabelsteric"></span></label>
                                                                <input type="text" class="form-control" placeholder=""
                                                                    name="broker" id="broker" />
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <label class="sf-label">Document To Be Provided</label>
                                                                <textarea class="form-control" rows="10" name="document_to_provide" id="document_to_provide">
                                                                    A. SIGNED COMMERCIAL INVOICE - 3 FOLDS <br>
                                                                    B. PACKING LIST IN SELLER'S LETTERHEAD <br>
C. FULL SET 3/3 ORIGINAL CLEAN SHIPPED ON BOARD BILLS OF LADING MARKED "FREIGHT PREPAID" 
   ISSUED TO THE ORDER OF SELLER BANK AND NOTIFY AS PER BUYER'S INSTRUCTION.<br>
D. CERTIFICATE OF ORIGIN ISSUED BY THE LOCAL CHAMBER OF COMMERCE & INDUSTRY.<br>
E. PHYTOSANITARY CERTIFICATE ISSUED BY DEPTT OF PLANT PROTECTION OF THE MINISTRY OF 
   NATIONAL FOOD SECURITY & RESEARCH.<br>
F. CERTIFICATE OF FUMIGATION ISSUED BY APPROVED COMMERCIAL FUMIGATION BY THE 
   GOVERNMENT OF PAKISTAN.<br>
G. CERTIFICATE OF QUALITY & WEIGHT ISSUED BY SGS PAKISTAN.
                                                                </textarea>
                                                            </div>

                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="sf-label">Other Condition<span
                                                                        class="rflabelsteric"></span></label>
                                                                <textarea class="form-control" rows="5" name="other_condition">
A. IF COC REQUIRED, CoC CHARGES WILL BE ON BUYERS ACCOUNT.
									</textarea>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="sf-label">Force Majure<span
                                                                        class="rflabelsteric"></span></label>
                                                                <textarea class="form-control" rows="5" name="force_majure">
SELLER IS NOT RESPONSIBLE FOR THE LATE DELIVERY/NON-DELIVERY CAUSED BY CONTINGENCIES
INTERNATIONALLY ACCEPTED BEYOND ITS CONTROL SUCH AS WAR, FIRE, ACTS OF GOD OR
GOVERNMENTAL REGULATIONS ETC. HOWEVER SELLER'S FAILURE OF RECEIVING EXPORT LICENCE IS
NOT DEEMED AS A FORCE MAJUERE, SELLER SHALL INFORM BUYER IMMEDIATELY BY TELEX OF CABLE 
AND SEND TO BUYER BY REGISTERED MAIL A CERTIFICATE OF THE FORCE MAJEURE, ISSUED BY
CHAMBER OF COMMERCE AT THE PLACE, WHERE THE FORCE MAJEURE OCCURRED.
									</textarea>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="sf-label">Application Law<span
                                                                        class="rflabelsteric"></span></label>
                                                                <textarea class="form-control" rows="5" name="application_law">
DISPUTES IF ANY ARISING OUT OF THIS CONTRACT TO BE SETTLED AMICABLY BETWEEN THE SELLER AND 
THE BUYER, FAILING WHICH ARBITRATION AS PER GAFTA 125 IN LONDON AND ENGLISH LAW TO APPLY.
									</textarea>
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
                                                                        <select class="form-control" name="incoterm"
                                                                            id="">
                                                                            <option value="">Select</option>
                                                                            @foreach ($incoterms as $incoterm)
                                                                                <option value="{{ $incoterm->id }}">
                                                                                    {{ $incoterm->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        {{-- <input type="text" class="form-control"> --}}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Packing Type </td>
                                                                    <td>
                                                                        <select class="form-control requiredField"
                                                                            name="type_of_loading" id="">
                                                                            <option value="">Select</option>
                                                                            <option value="container">IN CONTAINER</option>
                                                                            <option value="Bulk">IN BULK</option>

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
                                                                                <option value="{{ $modeofterm->id }}">
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
                                                                                    value="{{ $modeoftransport->id }}">
                                                                                    {{ $modeoftransport->name }}</option>
                                                                            @endforeach
                                                                        </select>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>ORIGIN</td>
                                                                    <td>

                                                                        <input type="text" class="form-control"
                                                                            name="origin" value="Pakistan">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>PORT OF DISCHARGE</td>
                                                                    <td>

                                                                        <input type="text" class="form-control"
                                                                            name="port_of_discharge">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>PORT LOADING</td>
                                                                    <td>

                                                                        <input type="text" class="form-control"
                                                                            value="PORT QASIM, PAKISTAN"
                                                                            name="port_loading">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>HS CODE</td>
                                                                    <td>
                                                                        <select class="form-control select2"
                                                                            name="hs_code" id="hs_code">
                                                                            <option value="1005.9000">1005.9000</option>
                                                                            <option value="1207.4000">1207.4000</option>
                                                                            <option value="1006.4000">1006.4000</option>
                                                                            <option value="1006.3090">1006.3090</option>
                                                                            <option value="1006.3010">1006.3010</option>
                                                                            <option value="1006.3010">1006.3010</option>
                                                                            <option value="1006.3010">1006.3010</option>
                                                                            <option value="1006.3010">1006.3010</option>
                                                                            <option value="1006.3010">1006.3010</option>
                                                                            <option value="1006.2000">1006.2000</option>
                                                                            <option value="1006.3010">1006.3010</option>
                                                                            <option value="1006.3010">1006.3010</option>
                                                                            <option value="1006.3010">1006.3010</option>
                                                                            <option value="1006.3090">1006.3090</option>
                                                                            <option value="1006.3090">1006.3090</option>
                                                                            <option value="1213.0000">1213.0000</option>
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
                                                                            <option value="0">Yes</option>
                                                                            <option value="1">No</option>
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
                                                                        <select class="form-control transhipment" name="transhipment"
                                                                        onchange="shipmentDelivery(2)"
                                                                            id="">
                                                                            <option value="0">Select</option>
                                                                            <option value="2">SHALL BE PERMITTED
                                                                            </option>
                                                                            <option value="1">SHALL NOT BE PERMITTED
                                                                            </option>
                                                                        </select>
                                                                        {{-- <input type="text" class="form-control"> --}}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Part Shipment</td>
                                                                    <td>
                                                                        <select class="form-control part_shipment" name="part_shipment"
                                                                        onchange="shipmentDelivery(2)"
                                                                            id="part_shipment">
                                                                            <option value="0">Select</option>
                                                                            <option value="2">SHALL BE PERMITTED
                                                                            </option>
                                                                            <option value="1">SHALL NOT BE PERMITTED
                                                                            </option>
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
                                                                            <option value="2">Buyer</option>
                                                                            <option value="1">Supplier</option>
                                                                        </select>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Advance Payment (%)</td>
                                                                    <td>
                                                                        <input type="number" class="form-control"
                                                                            max="100" name="advance_payment">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Payment Days (no of days)</td>
                                                                    <td>
                                                                        <input type="number" class="form-control"
                                                                            name="payment_days">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Currency </td>
                                                                    <td>
                                                                        <select class="form-control" onchange="setRate()"
                                                                            id="select_rate">
                                                                            <option value="">select</option>
                                                                            @foreach ($conversions as $conversion)
                                                                                <option
                                                                                    value="{{ $conversion->id . ',' . $conversion->rate }}">
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
                                                                            name="rate_of_conversion"
                                                                            id="rate_conversion">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <label class="sf-label">SHIPMENT DELIVERY</label>
                                                                        <textarea class="form-control" name="shipment_delivery" id="shipment_delivery">
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
                                                                    <th colspan="8" class="text-center">Sales Order
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
                                                                    <th class="text-center">Uom<span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
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
                                                                <tr class="cnt" title="1">
                                                                    <td>
                                                                        <select onchange="get_uom('{{ 1 }}')"
                                                                            name="sub_ic_des[]"
                                                                            id="sub_ic_des{{ 1 }}"
                                                                            class="form-control select2">
                                                                            <option value="">Select</option>
                                                                            @foreach (CommonHelper::get_item_by_category(81) as $row)
                                                                                <?php
                                                                                $uom = CommonHelper::get_uom($row->id);
                                                                                $pack_uom = CommonHelper::get_uom_name($row->pack_uom);
                                                                                ?>
                                                                                <option
                                                                                    value="{{ $row->id . ',' . $uom . ',' . $row->pack_type . ',' . $row->pack_size . ',' . $pack_uom }}">
                                                                                    {{ $row->sub_ic }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td><input readonly type="text"
                                                                            class="form-control" name="uom_id[]"
                                                                            id="uom_id1"></td>
                                                                    <td>
                                                                        {{-- <input readonly type="text"
                                                                            class="form-control" name="pack_type[]"
                                                                            id="pack_type1"> --}}
                                                                        <select class="form-control" name="pack_type[]"
                                                                            id="pack_type1" onchange="getPackSize('1',1)">
                                                                            <option value="">Select</option>
                                                                            @foreach ($printingBags as $printingBag)
                                                                                <option
                                                                                    value="{{ $printingBag->pack_type }}">
                                                                                    {{ strtoupper($printingBag->pack_type) }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control" name="bag_type[]"
                                                                            id="bag_type1" onchange="getPackSize('1',2)">
                                                                            <option value="">Select</option>
                                                                            {{-- @foreach ($printingBags as $printingBag)
                                                                                <option
                                                                                    value="{{ $printingBag->printing_bags }}">
                                                                                    {{ strtoupper($printingBag->printing_bags) }}
                                                                                </option>
                                                                            @endforeach --}}
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control" name="bag_color[]"
                                                                            id="bag_color1">
                                                                            <option value="">Select</option>
                                                                            <option value="N/A">N/A</option>
                                                                            <option value="Red">Red</option>
                                                                            <option value="Yellow">Yellow</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control" name="pack_size[]"
                                                                            id="pack_size1" onchange="claculation('1')">
                                                                            <option value="">Select</option>
                                                                        </select>
                                                                        {{-- <input type="text" class="form-control"
                                                                            name="pack_size[]" onkeyup="claculation('1')"
                                                                            onblur="claculation('1')" id="pack_size1"> --}}
                                                                    </td>
                                                                    <td><input type="text" class="form-control"
                                                                            name="pack_uom[]" readonly id="pack_uom1">
                                                                    </td>
                                                                    <td><input type="text" onkeyup="claculation('1')"
                                                                            onblur="claculation('1')"
                                                                            class="form-control requiredField zerovalidate"
                                                                            name="actual_qty[]" id="actual_qty1"
                                                                            min="1" value=""></td>
                                                                    <td><input type="text" class="form-control"
                                                                            readonly name="total_qty[]" id="total_qty1">
                                                                    </td>
                                                                    <td><input type="text" class="form-control"
                                                                            name="flc_qty[]" onkeyup="claculation('1')"
                                                                            id="flc_qty1"></td>
                                                                    <td><input type="text" class="form-control"
                                                                            name="flc_size[]" onkeyup="claculation('1')"
                                                                            id="flc_size1"></td>
                                                                    <td><input type="text" class="form-control"
                                                                            name="no_of_container[]"
                                                                            id="no_of_container1"></td>
                                                                    <td rowspan="2" style="background-color: #ccc">
                                                                        <input onclick="view_history(1)" type="checkbox"
                                                                            id="view_history1">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="7"></td>
                                                                    <td> <label for="">QTY
                                                                            Variation(%)</label><input type="text"
                                                                            onkeyup="" onblur=""
                                                                            class="form-control"
                                                                            placeholder="QTY Variation"
                                                                            name="qty_variation[]" id="qty_variation1">
                                                                    </td>
                                                                    <td> <label for="">Rate</label><input
                                                                            type="text" onkeyup="claculation('1')"
                                                                            onblur="claculation('1')"
                                                                            class="form-control rate_of_item"
                                                                            placeholder="Rate" name="rate[]"
                                                                            id="rate1"></td>
                                                                    <td><label for="">Amount</label><input readonly
                                                                            type="text" class="form-control amount"
                                                                            name="amount[]" id="amount1"
                                                                            placeholder="AMOUNT" min="1"
                                                                            value="0.00"></td>
                                                                    <td class="hide" style="width: 110px"><label
                                                                            for="">Sales
                                                                            Tax</label>
                                                                        <select onchange="tax_percent(this.id,1)"
                                                                            class="form-control" name="tax[]"
                                                                            id="tax_percent1">
                                                                            <option value="0,0">Select</option>
                                                                            @foreach (ReuseableCode::invoice_tax() as $row)
                                                                                <option
                                                                                    value='{{ $row->acc_id . ',' . $row->tax_rate }}'>
                                                                                    {{ $row->tax_rate }}</option>
                                                                            @endforeach
                                                                            <input type="hidden" name="tax_rate[]"
                                                                                id="tax_rate1">
                                                                    </td>
                                                                    <td class="hide"> <label for="">Sale Tax
                                                                            Amount</label><input readonly type="text"
                                                                            class="form-control requiredField tax_amount"
                                                                            name="tax_amount[]" id="tax_amount1"
                                                                            min="1" value="0.00"></td>
                                                                    <td class="hide"> <label for="">Amount After
                                                                            Tax</label><input type="text" readonly
                                                                            class="form-control net_amount_dis"
                                                                            name="after_dis_amount[]"
                                                                            id="after_dis_amount1" min="1"
                                                                            value="0.00"></td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr
                                                                    style="background-color: darkgrey;font-size:large;font-weight: bold">
                                                                    <td class="text-center" colspan="8">Total</td>
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
        $(function() {
            CKEDITOR.replace('quality_remarks');
            CKEDITOR.replace('consignee');
            CKEDITOR.replace('product_specification');
            CKEDITOR.replace('shipment_delivery');
            CKEDITOR.replace('document_to_provide');
        })

        let consigneeCounter = 0;

        function addMoreConsigneeField(id) {
            $('#addMoreConsigneeField').append(
                `<div id="removeConsigneeField${++consigneeCounter}">
                    <button type="button" class="btn btn-danger btn-xs" onclick="removeConsigneeField(${consigneeCounter})">Remove</button>
                    <textarea rows="2" class="form-control" placeholder="" name="consignee[]" id="consignee${consigneeCounter}"></textarea>
                </div>`
            );
            CKEDITOR.replace('consignee' + consigneeCounter);
        }

        function removeConsigneeField(id) {
            $('#removeConsigneeField' + id).remove();
        }

        let notifyCounter = 0;

        function addMoreNotifyField(id) {
            $('#addMoreNotifyField').append(
                `<div id="removeNotifyField${++notifyCounter}">
                    <button type="button" class="btn btn-danger btn-xs" onclick="removeNotifyField(${notifyCounter})">Remove</button>
                    <input type="text" class="form-control" placeholder="" name="notify_party_details[]" id="notify_party_details${notifyCounter}" />
                </div>`
            );
        }

        function removeNotifyField(id) {
            $('#removeNotifyField' + id).remove();
        }

        function getPackSize(id, type) {
            let bagType = $('#bag_type' + id).val();
            let packType = $('#pack_type' + id).val();
            // alert(bagType);
            // return
            $.ajax({
                url: '{{ url('/export/getPackSize') }}',
                data: {
                    bagType: bagType,
                    packType: packType,
                    type: type
                },
                type: 'GET',
                success: function(response) {
                    if (type == 2) {
                        let packSizes = "<option value=''>Select</option> ";
                        response.forEach(element => {
                            packSizes +=
                                `<option value="${element.bag_weight}">${element.bag_weight}</option>`
                        });
                        console.log(packSizes);
                        $('#pack_size' + id).html(packSizes);
                    }else{
                        let packSizes = "<option value=''>Select</option> ";
                        response.forEach(element => {
                            packSizes +=
                                `<option value="${element.printing_bags}">${element.printing_bags.toUpperCase()}</option>`
                        });
                        console.log(packSizes);
                        $('#bag_type' + id).html(packSizes);

                    }
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
                '<td><select onchange="get_uom(' + Counter + ')" name="sub_ic_des[]" id="sub_ic_des' + Counter +
                '" class="form-control select2">' +
                '<option value="">Select</option>' +
                '@foreach (CommonHelper::get_finish_goods(2) as $row)' +
                '<?php $uom = CommonHelper::get_uom($row->id);
                $pack_uom = CommonHelper::get_uom_name($row->pack_uom); ?>' +
                '<option value="{{ $row->id . ',' . $uom . ',' . $row->pack_type . ',' . $row->pack_size . ',' . $pack_uom }}">{{ $row->sub_ic }}</option>' +
                '@endforeach' +
                '</select>' +
                '</td>' +
                '<td><input readonly  type="text" class="form-control" name="uom_id[]" id="uom_id' + Counter +
                '" ></td>' +
                '<td>'+
                '<select class="form-control" name="pack_type[]" id="pack_type' + Counter + '" onchange="getPackSize(' +
                Counter + ', 1)">' +
                '<option value="">Select</option>' +
                '@foreach ($printingBags as $printingBag)' +
                '<option value="{{ $printingBag->pack_type }}">{{ strtoupper($printingBag->pack_type) }}</option>' +
                '@endforeach' +
                '</select>' +
                '</td>' +
                '<td>' +
                '<select class="form-control" name="bag_type[]" id="bag_type' + Counter + '" onchange="getPackSize(' +
                Counter + ', 2)">' +
                '<option value="">Select</option>' +
                '</select>' +
                '</td>' +
                '<td>' +
                '<select class="form-control" name="bag_color[]" id="bag_color' + Counter + '" >' +
                '<option value="">Select</option>' +
                '<option value="N/A">N/A</option>' +
                '<option value="Red">Red</option>' +
                '<option value="Yellow">Yellow</option>' +
                '</select>' +
                '</td>' +
                '<td>' +
                '<select class="form-control" name="pack_size[]" id="pack_size' + Counter + '" onchange="claculation(' +
                Counter + ')">' +
                '<option value="">Select</option>' +
                '</select>' +
                '</td>' +

                '<td><input type="text" class="form-control" name="pack_uom[]" readonly id="pack_uom' + Counter +
                '" ></td>' +
                '<td><input type="text" onkeyup="claculation(' + Counter + ')" onblur="claculation(' + Counter +
                ')" class="form-control requiredField zerovalidate" name="actual_qty[]" id="actual_qty' + Counter +
                '"  min="1" value=""></td>' +
                '<td><input type="text" class="form-control" name="total_qty[]" readonly id="total_qty' + Counter +
                '"></td>' +

                '<td><input type="text" class="form-control" onkeyup="claculation(' + Counter +
                ')" name="flc_qty[]" id="flc_qty' + Counter + '"></td>' +
                '<td><input type="text" class="form-control" name="flc_size[]" id="flc_size' + Counter + '"></td>' +
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
                ')" onblur="claculation(' + Counter + ')" class="form-control rate_of_item" name="rate[]" id="rate' +
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

        function applicable() {
            sales_tax();
        }

        function get_uom(id) {
            var sub_ic_data = $('#sub_ic_des' + id).val();
            sub_ic_data = sub_ic_data.split(',');
            $('#uom_id' + id).val(sub_ic_data[1]);
            // $('#pack_type' + id).val(sub_ic_data[2]);
            // $('#pack_size' + id).val(sub_ic_data[3]);
            $('#pack_uom' + id).val(sub_ic_data[4]);

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
            })


        }

        $('.select2').select2();
    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
