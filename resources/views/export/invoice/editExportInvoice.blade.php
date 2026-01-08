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

//    if($accType =='user'):
//    $user_rights = DB::table('menu_privileges')->where([['emp_code','=',Auth::user()->emp_code],['compnay_id','=',Session::get('run_company')]]);
//    $submenu_ids  = explode(",",$user_rights->value('submenu_id'));
//    		if(in_array(185,$submenu_ids))
//    		{
//    			$MenuPermission = true;
//    		}
//    		else
//    		{
//    			$MenuPermission = false;
//    		}
//    endif;

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

        /* Set a style for the submit button
    .btn1 {
      background-color: rgb(125, 129, 134);
      color: white;
      padding: 15px 20px;
      border: none;
      cursor: pointer;
      width: 100%;
      opacity: 0.9;
    }

    .btn1:hover {
      opacity: 1;
    } */
    </style>
    <?php $invoice_no = SalesHelper::get_unique_invoice_no(date('y'), date('m')); ?>

    <div class="container-fluid">
        <div class="row" style="display: none;" id="main">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="display: none;">
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well_N">
                    <div class="dp_sdw">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span class="subHeadingLabelClass">Edit Commercial Invoice</span>
                                <?php
	                     if($MenuPermission == true):?>
                                <?php else:?>
                                <span class="subHeadingLabelClass text-danger text-center" style="float: right">Permission
                                    Denied <span style='font-size:45px !important;'>&#128546;</span></span>
                                <?php endif;
	                     ?>
                            </div>
                        </div>
                        <?php if($MenuPermission == true):?>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            <form action="{{ route('exportInvoiceUpdateDetail') }}" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="{{ $exportInvoice->id }}">
                                <input type="hidden" name="sale_order_id" value="{{ $sale_order->id }}">
                                <input type="hidden" name="proforma_id" value="{{ $sale_order->proforma_id }}">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label for="">Commercial invoice No</label>
                                                                <input type="text" class="form-control"
                                                                    name="commercial_invoice_no"
                                                                    value="{{ $exportInvoice->commercial_invoice_no }}"
                                                                    id="">
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label for="">invoice Date</label>
                                                                <input type="date" class="form-control"
                                                                    name="invoice_date"
                                                                    value="{{ $exportInvoice->invoice_date }}">
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label for="">Proform No</label>
                                                                <input readonly type="text" class="form-control"
                                                                    name="invoice_no"
                                                                    value="{{ $sale_order->pro_contract_no }}"
                                                                    id="">
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label for="">Invoice No</label>
                                                                <input readonly type="text" class="form-control"
                                                                    name="invoice_no"
                                                                    value="{{ $exportInvoice->invoice_no }}" id="">
                                                            </div>
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label class="sf-label">EO No <span
                                                                        class="rflabelsteric"><strong>*</strong></span></label>
                                                                <input readonly type="text" class="form-control"
                                                                    name="voucher_no" id="voucher_no"
                                                                    value="{{ $sale_order->voucehr_no }}" />
                                                            </div>



                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-8">
                                                                <label class="sf-label">Buyer's Name <span
                                                                        class="rflabelsteric"><strong>*</strong></span></label>
                                                                <input readonly type="text" class="form-control"
                                                                    placeholder="" name="buyers_id" id="buyers_id"
                                                                    value="{{ CommonHelper::byers_name($sale_order->buyer_id)->name ?? '-' }}" />
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-2 col-sm-2 col-xs-8">
                                                                <label for="">LC NO/ Date</label>
                                                                <input type="text" class="form-control" name="lc_date"
                                                                    id=""
                                                                    value="{{ $exportInvoice->lc_date_no }}">
                                                            </div>
                                                            <div class="col-lg-4 col-md-2 col-sm-2 col-xs-8">
                                                                <label for="">Ship Name</label>
                                                                <input type="text" class="form-control" name="ship_name"
                                                                    id="" value="{{ $exportInvoice->ship_name }}">
                                                            </div>
                                                            <div class="col-lg-4 col-md-2 col-sm-2 col-xs-8">
                                                                <label for="">Bill Of Lading No / Date </label>
                                                                <input type="text" class="form-control"
                                                                    name="bill_of_loading" id=""
                                                                    value="{{ $exportInvoice->bill_of_loading }}">
                                                            </div>
                                                            <div class="col-lg-4 col-md-2 col-sm-2 col-xs-8">
                                                                <label for="">Master B/L </label>
                                                                <input type="text" class="form-control"
                                                                    name="master_bl" id=""
                                                                    value="{{ $exportInvoice->master_bl }}">
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <label for="">Product Details </label>
                                                                <textarea type="text" class="form-control" name="product_description" id="product_description">{{ $exportInvoice->description }}</textarea>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <label for="">Consigned Details </label>
                                                                <textarea type="text" class="form-control" name="consigned_deatils" id="consigned_deatils">{{ $exportInvoice->consigned_deatils }}</textarea>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <button type="button" onclick="notifyMoreField();"
                                                                    class="btn btn-primary btn-xs">Add Notify</button>
                                                            </div>
                                                            <div id="notifyMoreField">
                                                                @foreach ($exportInvoice->notify as $key => $notify)
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
                                                                        id="notifyMoreField{{$key}}">
                                                                        <label for="">Notify <button
                                                                                type="button"
                                                                                onclick="removeNotifyMoreField({{$key}});"
                                                                                class="btn btn-danger btn-xs">Remove</button></label>
                                                                        <textarea type="text" class="form-control" name="notify_address[]" id="notify_address{{$key}}">{{ $notify->notify_address }}</textarea>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="row" id="form">
                                                            @php
                                                                $eformNos = json_decode($exportInvoice->form_no, true);
                                                            @endphp
                                                            @foreach ($eformNos as $key => $eformNo)
                                                                @php
                                                                    ++$key;
                                                                @endphp
                                                                @if ($loop->first)
                                                                    <div class="col-lg-4 col-md-2 col-sm-2 col-xs-8"
                                                                        id="notifyMoreField{{ $key }}">
                                                                        <label for="">E-Form </label>
                                                                        <div class="input-container">
                                                                            <input class="input-field form-control"
                                                                                type="text"
                                                                                value="{{ $eformNo }}"
                                                                                name="form_no[]"><i
                                                                                class="fa fa-plus icon"
                                                                                onclick="add()"></i>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="col-lg-4 col-md-2 col-sm-2 col-xs-8"
                                                                        id="row{{ $key }}">
                                                                        <label>&nbsp</label>
                                                                        <div class="input-container">
                                                                            <input class="input-field form-control"
                                                                                type="text" placeholder="Form No "
                                                                                value="{{ $eformNo }}"
                                                                                name="form_no[]"><i
                                                                                class="fa fa-minus icon"
                                                                                onclick="minus({{ $key }})"></i>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="row">
                                                            <table class="table table-bordered">
                                                                @php
                                                                    if (!empty($sale_order->bank)) {
                                                                        $bank_name = App\Models\Bank::find($sale_order->bank)->bank_name;
                                                                        $bank_swift = App\Models\Bank::find($sale_order->bank)->swift_code;
                                                                        $bank_ibn = App\Models\Bank::find($sale_order->bank)->IBAN_no;
                                                                        $bank_address = App\Models\Bank::find($sale_order->bank)->bank_address;
                                                                        $account_title = App\Models\Bank::find($sale_order->bank)->account_title;
                                                                    } else {
                                                                        $bank_name = '-';
                                                                        $bank_swift = '-';
                                                                        $bank_ibn = '-';
                                                                        $bank_address = '-';
                                                                        $account_title = '-';
                                                                    }
                                                                @endphp
                                                                <tr>
                                                                    <td>
                                                                        <h1><b>Beneficiary</b></h1>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Beneficiary:</label>
                                                                            <input readonly type="text"
                                                                                value="{{ $account_title }}"
                                                                                class="form-control" name=""
                                                                                id="">
                                                                        </div>

                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                                                            <label for="">Beneficiary Bank</label>
                                                                            <input readonly type="text"
                                                                                class="form-control" name=""
                                                                                value="{{ $bank_name }}"
                                                                                id="">
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Beneficiary Bank Swift
                                                                                Code</label>
                                                                            <input readonly type="text"
                                                                                class="form-control"
                                                                                value="{{ $bank_swift }}"
                                                                                name="" id="">
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Beneficiary Bank IBAN
                                                                            </label>
                                                                            <input readonly type="text"
                                                                                class="form-control"
                                                                                value="{{ $bank_ibn }}"
                                                                                name="" id="">
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Beneficiary Bank
                                                                                Address</label>
                                                                            <input readonly type="text"
                                                                                class="form-control" name=""
                                                                                value="{{ $bank_address }}"
                                                                                id="">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="row">
                                                            <table class="table table-bordered">
                                                                <tr>
                                                                    <td>
                                                                        <h1><b>Correspondent</b></h1>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Account Title</label>
                                                                            <input readonly type="text"
                                                                                class="form-control"
                                                                                name="correspondent_bank"
                                                                                value="{{ $sale_order->account_title }}"
                                                                                id="" required>

                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Bank</label>
                                                                            <input readonly type="text"
                                                                                class="form-control"
                                                                                name="correspondent_bank"
                                                                                value="{{ $sale_order->correspondent_bank }}"
                                                                                id="" required>

                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Account Usd</label>
                                                                            <input readonly type="text"
                                                                                class="form-control"
                                                                                name="correspondent_account"
                                                                                value="{{ $sale_order->correspondent_account_usd }}"
                                                                                id="" required>

                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for=""> Bank Swift</label>
                                                                            <input readonly type="text"
                                                                                class="form-control"
                                                                                name="correspondent_swift"
                                                                                value="{{ $sale_order->correspondent_bank_swift }}"
                                                                                id="" required>

                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <label for="">Details Of
                                                                                Payment</label>
                                                                            <input readonly type="text"
                                                                                class="form-control"
                                                                                name="payment_details"
                                                                                value="{{ $sale_order->details_of_payment }}"
                                                                                id="" required>

                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
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
                                                                        <select readonly class="form-control"
                                                                            name="incoterm" id="">
                                                                            <option value="">Select</option>
                                                                            @foreach ($incoterms as $incoterm)
                                                                                @if ($sale_order->incoterm == $incoterm->id)
                                                                                    <option selected
                                                                                        value="{{ $incoterm->id }}">
                                                                                        {{ $incoterm->name }}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        {{-- <input type="text" class="form-control"> --}}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>MODE OF TERM</td>
                                                                    <td>
                                                                        <select readonly class="form-control"
                                                                            name="mode_of_term" id="">
                                                                            <option value="">Select</option>
                                                                            @foreach ($modeofterms as $modeofterm)
                                                                                @if ($sale_order->mode_of_term == $modeofterm->id)
                                                                                    <option selected
                                                                                        value="{{ $modeofterm->id }}">
                                                                                        {{ $modeofterm->name }}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>MODE OF TRANSPORT</td>
                                                                    <td>
                                                                        <select readonly class="form-control"
                                                                            name="mode_transport" id="">
                                                                            <option value="">Select</option>
                                                                            @foreach ($modeoftransports as $modeoftransport)
                                                                                @if ($sale_order->mode_transport == $modeoftransport->id)
                                                                                    <option
                                                                                        value="{{ $modeoftransport->id }}">
                                                                                        {{ $modeoftransport->name }}
                                                                                    </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>ORIGIN</td>
                                                                    <td>

                                                                        <input readonly type="text"
                                                                            class="form-control"
                                                                            value="{{ $sale_order->origin }}"
                                                                            name="origin">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>PORT OF DISCHARGE</td>
                                                                    <td>

                                                                        <input readonly type="text"
                                                                            class="form-control"
                                                                            value="{{ $sale_order->port_of_discharge }}"
                                                                            name="port_of_discharge">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>PORT LOADING</td>
                                                                    <td>

                                                                        <input readonly type="text"
                                                                            class="form-control"
                                                                            value="{{ $sale_order->port_loading }}"
                                                                            name="port_loading">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>HS CODE</td>
                                                                    <td>

                                                                        <input readonly type="text"
                                                                            class="form-control"
                                                                            value="{{ $sale_order->hs_code }}"
                                                                            name="hs_code">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>PARTIAL PAYMENT</td>
                                                                    <td>
                                                                        <select readonly class="form-control"
                                                                            name="partial_payment">
                                                                            <option value="">Select</option>
                                                                            <option
                                                                                @if ($sale_order->partial_payment == 0) selected @endif
                                                                                value="0">Yes</option>
                                                                            <option
                                                                                @if ($sale_order->partial_payment == 1) selected @endif
                                                                                value="1">No</option>
                                                                        </select>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>BANKS</td>
                                                                    <td>
                                                                        <select readonly class="form-control"
                                                                            name="bank" id="">
                                                                            <option value="">Select</option>
                                                                            <option value="">Select</option>
                                                                            @foreach ($banks as $bank)
                                                                                @if ($sale_order->bank == $bank->id)
                                                                                    <option selected
                                                                                        value="{{ $bank->id }}">
                                                                                        {{ $bank->bank_name }}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                {{-- <tr>
										<td>DELEVERY DATE</td><td> 

											<input readonly type="date" value="{{$sale_order->delevery_date}}" class="form-control" name="delevery_date" value="{{date('Y-m-d')}}">
										</td>
									</tr> --}}
                                                                <tr>
                                                                    <td>Transhipment</td>
                                                                    <td>
                                                                        <select readonly class="form-control"
                                                                            name="transhipment" id="">
                                                                            <option value="">Select</option>
                                                                            <option
                                                                                @if ($sale_order->transhipment == 0) selected @endif
                                                                                value="0">Allow</option>
                                                                            <option
                                                                                @if ($sale_order->transhipment == 1) selected @endif
                                                                                value="1">Not Allow</option>
                                                                        </select>
                                                                        {{-- <input type="text" class="form-control"> --}}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Insurance Coverd By</td>
                                                                    <td>
                                                                        <select readonly class="form-control"
                                                                            name="insurance_coverd" id="">
                                                                            <option value="0"
                                                                                @if ($sale_order->insurance_coverd == 0) selected @endif>
                                                                                Select</option>
                                                                            <option
                                                                                @if ($sale_order->insurance_coverd == 2) selected @endif
                                                                                value="0">Buyer</option>
                                                                            <option
                                                                                @if ($sale_order->insurance_coverd == 1) selected @endif
                                                                                value="1">Supplier</option>
                                                                        </select>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Advance Payment (%)</td>
                                                                    <td>
                                                                        <input readonly type="text"
                                                                            value="{{ $sale_order->advance_payment }}"
                                                                            class="form-control" name="advance_payment">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Correncey </td>
                                                                    <td>
                                                                        <select readonly class="form-control"
                                                                            onchange="setRate()" id="select_rate">
                                                                            <option value="">select</option>
                                                                            @foreach ($conversions as $conversion)
                                                                                <option
                                                                                    @if ($sale_order->currencey_id == $conversion->id) selected @endif
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
                                                                        <input readonly type="number"
                                                                            value="{{ $sale_order->currencey_rate }}"
                                                                            class="form-control" name="rate_of_conversion"
                                                                            id="rate_conversion">
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            {{-- This data section of Sale order  --}}
                                            <div class="lineHeight">&nbsp;</div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <span class="subHeadingLabelClass">Commercial Data</span>
                                            </div>
                                            <div class="lineHeight">&nbsp;&nbsp;&nbsp;</div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr class="text-center">
                                                                    <th colspan="9" class="text-center">Sales Order
                                                                        Detail</th>
                                                                    {{-- <th colspan="2" class="text-center">
																		{{-- <input type="button" class="btn btn-sm btn-primary" onclick="AddMoreDetails()" value="Add More Rows" /> 
																	</th> --}}
                                                                    <th class="text-center">

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
                                                                    <th class="text-center">Pack Size<span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                    <th class="text-center">QTY. <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                    <th class="text-center">Total QTY (Bags)<span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                    <th class="text-center">Brand<span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                    <th class="text-center">Issuing Qty <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                    <th class="text-center">Deleverd Qty <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                    <th class="text-center">Remaining Qty <span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                    {{-- <th class="text-center" >FLC Size<span class="rflabelsteric"><strong>*</strong></span></th>
	                                         					 <th class="text-center" >FLC QTY<span class="rflabelsteric"><strong>*</strong></span></th> --}}
                                                                    <th class="text-center">Delete<span
                                                                            class="rflabelsteric"><strong>*</strong></span>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="AppnedHtml">
                                                                @php
                                                                    $total_amount = 0;
                                                                    $total_amount_after = 0;
                                                                    $counter = 1;
                                                                @endphp
                                                                @foreach ($sale_order_data as $key => $sale_order_row)
                                                                    @if ($sale_order_row->remaining != 0)
                                                                        <input type="hidden" name="sale_order_data_id[]"
                                                                            value="{{ $sale_order_row->id }}">
                                                                        <input type="hidden" name="data_id[]"
                                                                            value="{{ $exportInvoice->itemData[$key]->id }}">
                                                                        <tr class="cnt" title="1">
                                                                            <td>
                                                                                <input readonly type="text"
                                                                                    class="form-control"
                                                                                    name="sub_ic_des[]" id="sub_ic_des1"
                                                                                    value="{{ CommonHelper::get_item_name($sale_order_row->item_id) }}">
                                                                            </td>
                                                                            <td><input readonly type="text"
                                                                                    class="form-control" name="uom_id[]"
                                                                                    id="uom_id{{ $counter }}"
                                                                                    value="{{ $sale_order_row->uom_id }}">
                                                                            </td>
                                                                            <td><input readonly type="text"
                                                                                    class="form-control"
                                                                                    name="pack_type[]"
                                                                                    id="pack_type{{ $counter }}"
                                                                                    value="{{ $sale_order_row->pack_type }}">
                                                                            </td>
                                                                            <td><input readonly type="text"
                                                                                    class="form-control"
                                                                                    name="pack_size[]"
                                                                                    id="pack_size{{ $counter }}"
                                                                                    value="{{ $sale_order_row->pack_size }}">
                                                                            </td>
                                                                            <td><input readonly type="text"
                                                                                    onkeyup="claculation({{ $counter }})"
                                                                                    onblur="claculation({{ $counter }})"
                                                                                    value="{{ $sale_order_row->actual_qty }}"class="form-control requiredField zerovalidate"
                                                                                    name="actual_qty[]"
                                                                                    id="actual_qty{{ $counter }}"
                                                                                    min="1" value=""></td>
                                                                            <td><input readonly type="text"
                                                                                    class="form-control"
                                                                                    name="total_qty[]"
                                                                                    id="total_qty{{ $counter }}"
                                                                                    value="{{ $sale_order_row->total_qty }}">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control"
                                                                                    name="brand[]" id=""
                                                                                    value="{{ $exportInvoice->itemData[$key]->brand ?? '' }}">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text"
                                                                                    class="form-control requiredField zerovalidate"
                                                                                    name="issue_qty[]"
                                                                                    onkeypress="validation(this.value,{{ $sale_order_row->actual_qty - $sale_order_row->deleverd_qty }},{{ $counter }}),claculation({{ $counter }})"
                                                                                    onkeyup="validation(this.value,{{ $sale_order_row->actual_qty - $sale_order_row->deleverd_qty }},{{ $counter }}),claculation({{ $counter }})"
                                                                                    value="{{ $exportInvoice->itemData[$key]->issue_qty ?? '' }}"
                                                                                    id="issue_qty{{ $counter }}"
                                                                                    required>

                                                                                <input type="hidden" name="bag_weight"
                                                                                    id="bag_weight{{ $counter }}"
                                                                                    value="{{ App\Models\PrintingBags::where([['printing_bags', $sale_order_row->bag_type], ['bag_weight', $sale_order_row->pack_size], ['status', 1]])->first()->grams ?? 0 }}">
                                                                            </td>

                                                                            <td>
                                                                                <input readonly type="text"
                                                                                    class="form-control"
                                                                                    name="deleverd_qty[]"
                                                                                    value="{{ $sale_order_row->deleverd_qty }}"
                                                                                    id="deleverd_qty{{ $counter }}">
                                                                            </td>
                                                                            <td>
                                                                                <input readonly type="text"
                                                                                    class="form-control"
                                                                                    name="reamining[]"
                                                                                    value="{{ $sale_order_row->actual_qty - $sale_order_row->deleverd_qty }}"
                                                                                    id="reamining{{ $counter }}">
                                                                            </td>

                                                                            <td rowspan="2"
                                                                                style="background-color: #ccc"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2"></td>

                                                                            <td><label for="">Gross
                                                                                    Weight</label><input type="text"
                                                                                    class="form-control"
                                                                                    name="gross_weight[]"
                                                                                    id="gross_weight{{ $counter }}"
                                                                                    value="{{ $exportInvoice->itemData[$key]->gross_weight ?? '' }}">
                                                                            </td>
                                                                            <td><label for="">FlC
                                                                                    Size</label><input readonly
                                                                                    type="text" class="form-control"
                                                                                    name="flc_size[]" id="flc_size1"
                                                                                    value="{{ $sale_order_row->flc_size }}">
                                                                            </td>
                                                                            <td><label for="">FLC Qty</label><input
                                                                                    readonly type="text"
                                                                                    class="form-control" name="flc_qty[]"
                                                                                    id="flc_qty1"
                                                                                    value="{{ $sale_order_row->flc_qty }}">
                                                                            </td>

                                                                            <td> <label for="">Rate</label><input
                                                                                    readonly type="text"
                                                                                    onkeyup="claculation({{ $counter }})"
                                                                                    value="{{ $sale_order_row->rate }}"
                                                                                    onblur="claculation('{{ $counter }}')"
                                                                                    class="form-control rate_of_item"
                                                                                    placeholder="Rate" name="rate[]"
                                                                                    id="rate{{ $counter }}"></td>
                                                                            <td><label for="">Amount</label><input
                                                                                    readonly type="text"
                                                                                    class="form-control amount"
                                                                                    value="" name="amount[]"
                                                                                    id="amount{{ $counter }}"
                                                                                    placeholder="AMOUNT" min="1"
                                                                                    value="0.00"></td>
                                                                            <td style="width: 110px; display: none;"><label
                                                                                    for="">Sales Tax</label>
                                                                                <select
                                                                                    onchange="tax_percent(this.id,{{ $counter }})"
                                                                                    readonly class="form-control"
                                                                                    name="tax[]"
                                                                                    id="tax_percent{{ $counter }}">
                                                                                    <option value="0,0">Select</option>
                                                                                    @foreach (ReuseableCode::invoice_tax() as $row)
                                                                                        <option
                                                                                            @if ($sale_order_row->tax == $row->tax_rate) selected @endif
                                                                                            value='{{ $row->acc_id . ',' . $row->tax_rate }}'>
                                                                                            {{ $row->tax_rate }}</option>
                                                                                    @endforeach
                                                                                    <input type="hidden"
                                                                                        name="tax_rate[]"
                                                                                        id="tax_rate{{ $counter }}">
                                                                            </td>
                                                                            <td style=" display: none;"> <label for="">Sale Tax
                                                                                    Amount</label><input readonly
                                                                                    value="{{ $sale_order_row->tax_amount }}"
                                                                                    type="text"
                                                                                    class="form-control requiredField tax_amount"
                                                                                    name="tax_amount[]"
                                                                                    id="tax_amount{{ $counter }}"
                                                                                    min="1" value="0.00"></td>
                                                                            <td style="display: none;"> <label for="">Amount After
                                                                                    Tax</label><input readonly
                                                                                    type="text"
                                                                                    value="{{ $sale_order_row->after_dis_amount }}"
                                                                                    readonly
                                                                                    class="form-control net_amount_dis"
                                                                                    name="after_dis_amount[]"
                                                                                    id="after_dis_amount{{ $counter }}"
                                                                                    min="1" value="0.00"></td>
                                                                        </tr>
                                                                        @php
                                                                            $counter++;
                                                                            $total_amount += $sale_order_row->amount;
                                                                            $total_amount_after += $sale_order_row->after_dis_amount;
                                                                        @endphp
                                                                    @endif
                                                                @endforeach

                                                            </tbody>
                                                            <tbody>
                                                                <tr
                                                                    style="background-color: darkgrey;font-size:large;font-weight: bold">
                                                                    <td class="text-center" colspan="10">Total</td>

                                                                    {{-- <input readonly class="form-control" type="text" id="net"/> --}}
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group form-inline text-right">
                                                <label for="email">Total Before Tax </label>
                                                <input readonly type="text"
                                                    value="{{ number_format($total_amount, 2) }}" class="form-control"
                                                    id="total">
                                            </div>
                                            <div class="form-group form-inline text-right">
                                                <label for="email">Total After Tax </label>
                                                <input readonly type="text"
                                                    value="{{ number_format($total_amount_after, 2) }}"
                                                    class="form-control" id="total_after_sales_tax">
                                            </div>
                                            {{-- <div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<span class="subHeadingLabelClass">Advance Payment Settlement</span>
								 </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <table class="table table-bordered">
                                        <tr>
										
                                        <th>Amount</th>
										<th>Description</th>
                                        <th>Settlement</th>
                                      
                                        </tr>
                                         @foreach ($advance_payment as $advance)
                                        <tr>
											 <td>     <select    class="form-control requiredField select2" name="account_id" id="account_id">
												<option value="">Select Account</option>
												@foreach (CommonHelper::get_all_account_operat() as $key => $y)
													<option selected   value="{{ $y->id}}">{{ $y->code .' ---- '. $y->name}}</option>
												@endforeach
											</select>
										</td> 
										@php 
										$already_received = $advance_payment_invoice->received_amount??0;
										$advance_rece = $advance_payment->received_amount??0;
										$Received_advance = $advance_rece - $already_received;
										@endphp
                                        <td><input type="text" readonly class="form-control" value="{{$Received_advance}}"></td>
                                      	<td><input type="text" class="form-control" name="description"></td>
										<td><input type="text" class="form-control" name="advance_payment_settelemnt" value=""></td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div> --}}
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
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let notifyCounter = {{ count($exportInvoice->notify) }};
        let dataCounter = {{ count($exportInvoice->itemData) }};

        $(function() {
			for (let index = 0; index < notifyCounter; index++) {
				CKEDITOR.replace("notify_address" + index, {
					toolbar: []
					// allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height];'
				});

			}
			for (let i = 1; i <= dataCounter; i++) {
				claculation(i)
			}
			CKEDITOR.replace('consigned_deatils', {
                toolbar: []
                // allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height];'
            });
            CKEDITOR.replace('product_description', {
                toolbar: []
                // allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height];'
            });
        })





        var Counter = 1

        function notifyMoreField() {
            $('#notifyMoreField').append(`
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="notifyMoreField${++notifyCounter}">
		<label for="">Notify <button type="button" onclick="removeNotifyMoreField(${notifyCounter});" class="btn btn-danger btn-xs">Remove</button></label>
		<textarea type="text" class="form-control" name="notify_address[]" id="notify_address${notifyCounter}"></textarea>
	</div>
	`);
            CKEDITOR.replace("notify_address" + notifyCounter, {
                toolbar: []
                // allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height];'
            });
        }


        function removeNotifyMoreField(Row) {

            $('#notifyMoreField' + Row).remove();
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
        var counter = 0;

        function add() {

            console.log('sss');
            counter++;
            var html = ` <div class="col-lg-4 col-md-2 col-sm-2 col-xs-8" id="row` + counter +
                `">
                            <label>&nbsp</label>
                        <div class="input-container">
                        <input class="input-field form-control" type="text" placeholder="Form No " name="form_no[]"><i class="fa fa-minus icon" onclick="minus(` + counter + `)"></i>
                </div>        
            </div>`;

            $('#form').append(html);

        }

        function minus(number) {
            $('#row' + number).remove();
            counter--;
        }

        function claculation(number) {
            var qty = $('#issue_qty' + number).val();
            var rate = $('#rate' + number).val();
            var total = parseFloat(qty * rate).toFixed(2);
            var pack_size = $('#pack_size' + number).val();
            var total_qty = qty / pack_size;
            // $('#total_qty'+number).val(total_qty);
            $('#amount' + number).val(total);

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

        function validation(issue_qty, remaining_qty, number) {
            var total_qty = $('#actual_qty' + number).val();
            var delevery_qty = $('#deleverd_qty' + number).val();
            var minus_qty = parseFloat(delevery_qty) + parseFloat(issue_qty);
            var final_qty = parseFloat(total_qty) - minus_qty;

            $('#reamining' + number).val(final_qty);

            let bag_weight = parseFloat($('#bag_weight' + number).val());
            $('#gross_weight' + number).val((parseFloat(issue_qty) * bag_weight) + parseFloat(issue_qty));
            if (issue_qty > parseFloat(remaining_qty)) {

                $('#issue_qty' + number)
                    .css("border", "2px solid red");


                return false;
            } else {
                $('#issue_qty' + number).css("border", "none");

            }
        }
    </script>
    <script type="text/javascript">
        $('.select2').select2();
    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
