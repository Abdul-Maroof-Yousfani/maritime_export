<?php
use App\Helpers\ReuseableCode;
use App\Helpers\NotificationHelper;
use App\Models\Subitem;
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
    .form-container {
        max-width: 1400px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
    }
    
    .form-header {
        border-bottom: 2px solid #000;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }
    
    .form-row {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }
    
    .form-group {
        flex: 1;
        min-width: 200px;
    }
    
    .form-label {
        font-weight: bold;
        font-size: 12px;
        display: block;
        margin-bottom: 5px;
    }
    
    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 12px;
    }
    
    .form-control:focus {
        border-color: #007bff;
        outline: none;
    }
    
    .form-control[readonly] {
        background-color: #f5f5f5;
    }
    
    .table-responsive {
        max-height: 500px;
        overflow-y: auto;
        overflow-x: auto;
        border: 1px solid #ddd;
        width: 100%;
    }
    
    .table-responsive table {
        min-width: 1400px;
    }
    
    .table-responsive table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 0;
    }
    
    .table-responsive thead th {
        background-color: #f0f0f0;
        border: 1px solid #000;
        padding: 10px;
        text-align: center;
        font-weight: bold;
        font-size: 11px;
        position: sticky;
        top: 0;
        background-color: #f0f0f0;
        z-index: 10;
    }
    
    .table-responsive tbody td {
        border: 1px solid #000;
        padding: 8px;
        vertical-align: middle;
        text-align: center;
    }
    
    .table-responsive input,
    .table-responsive select {
        width: 100%;
        border: none;
        padding: 5px;
        font-size: 11px;
        background: transparent;
    }
    
    .table-responsive input:focus,
    .table-responsive select:focus {
        outline: 1px solid #007bff;
    }
    
    .table-responsive input[readonly] {
        background-color: #f5f5f5;
    }
    
    .table-responsive .select2-container {
        width: 100% !important;
    }
    
    .btn-add-row {
        background-color: #28a745;
        color: white;
        padding: 8px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        margin-top: 10px;
    }
    
    .btn-add-row:hover {
        background-color: #218838;
    }
    
    .btn-remove-row {
        background-color: #dc3545;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        font-size: 11px;
    }
    
    .btn-remove-row:hover {
        background-color: #c82333;
    }
    
    .btn-submit {
        background-color: #007bff;
        color: white;
        padding: 12px 40px;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        margin-top: 20px;
        float: right;
    }
    
    .btn-submit:hover {
        background-color: #0056b3;
    }
    
    .text-right {
        text-align: right;
    }
    
    .attachments-container {
        margin-top: 10px;
    }
    
    .attachment-preview {
        margin-top: 10px;
        padding: 10px;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .attachment-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 5px;
        margin: 5px 0;
        background: white;
        border: 1px solid #ccc;
        border-radius: 3px;
    }
    
    .attachment-item span {
        font-size: 11px;
        flex: 1;
    }
    
    .attachment-remove-btn {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 3px 8px;
        border-radius: 3px;
        cursor: pointer;
        font-size: 10px;
        margin-left: 10px;
    }
    
    .attachment-remove-btn:hover {
        background-color: #c82333;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="well_N">
                <div class="dp_sdw">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <span class="subHeadingLabelClass">Edit Export Order</span>
                        </div>
                    </div>
                    
                    <?php if($MenuPermission == true):?>
                    <div class="lineHeight">&nbsp;</div>
                    
                    <form action="{{route('saleOrderUpdateDetail')}}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="id" value="{{ $exportOrder->id }}" />
                        
                        <div class="form-container">
                            <div class="form-header">
                                <h3>Export Order Form</h3>
                            </div>
                            
                            <!-- Basic Information -->
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Export Order No <span class="rflabelsteric">*</span></label>
                                    <input type="text" class="form-control" name="voucher_no" id="voucher_no" 
                                        value="{{ strtoupper($exportOrder->voucehr_no) }}" readonly />
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Contract No</label>
                                    <input type="text" class="form-control" name="contract_no" id="contract_no" 
                                        value="{{ $exportOrder->contract_no ?? '' }}" placeholder="Enter Contract Number" />
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Export Date <span class="rflabelsteric">*</span></label>
                                    <input type="date" class="form-control" name="voucher_date" id="voucher_date" 
                                        value="{{ $exportOrder->voucher_date ?? date('Y-m-d') }}" required />
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Customer <span class="rflabelsteric">*</span></label>
                                    <select class="form-control select2" name="buyers_id" id="buyers_id" onchange="loadCustomerDetails()" required>
                                        <option value="">Select Customer</option>
                                        @foreach ($customers as $row)
                                            <option value="{{ $row->id }}" {{ $exportOrder->buyer_id == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Customer Details (Readonly) -->
                            <div class="form-row" id="customerDetailsRow">
                                <div class="form-group">
                                    <label class="form-label">Customer Address</label>
                                    <input type="text" class="form-control" id="customer_address" readonly />
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Customer NTN</label>
                                    <input type="text" class="form-control" id="customer_ntn" readonly />
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Currency <span class="rflabelsteric">*</span></label>
                                    <select class="form-control select2" name="currency_id" id="currency_id" onchange="updateCurrencyInfo()" required>
                                        <option value="">Select Currency</option>
                                        @foreach ($conversions as $conversion)
                                            <option value="{{ $conversion->id }}" data-rate="{{ $conversion->rate }}" data-name="{{ $conversion->curreny }}" {{ $exportOrder->currencey_id == $conversion->id ? 'selected' : '' }}>{{ $conversion->curreny }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="currency_rate" value="{{ $exportOrder->currencey_rate ?? 1 }}" />
                                    <input type="hidden" id="currency_name" value="" />
                                </div>
                                <div class="form-group" id="exchangeRateGroup" style="display: none;">
                                    <label class="form-label">Exchange Rate (PKR) <span class="rflabelsteric">*</span></label>
                                    <input type="number" class="form-control" name="exchange_rate" id="exchange_rate" 
                                        step="0.01" min="0" onchange="updateExchangeRate()" onkeyup="updateExchangeRate()" 
                                        value="{{ $exportOrder->currencey_rate ?? 1 }}" placeholder="Enter exchange rate" required />
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Mode of Transport <span class="rflabelsteric">*</span></label>
                                    <select class="form-control select2" name="mode_transport" id="mode_transport" required>
                                        <option value="">Select Mode of Transport</option>
                                        @foreach ($modeoftransports as $modeoftransport)
                                            <option value="{{ $modeoftransport->id }}" {{ $exportOrder->mode_transport == $modeoftransport->id ? 'selected' : '' }}>{{ $modeoftransport->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Payment Term<span class="rflabelsteric">*</span></label>
                                    <select class="form-control select2" name="mode_of_term" id="mode_of_term" required>
                                        <option value="">Select Payment Term</option>
                                        @foreach ($modeofterms as $modeofterm)
                                            <option value="{{ $modeofterm->id }}" {{ $exportOrder->mode_of_term == $modeofterm->id ? 'selected' : '' }}>{{ $modeofterm->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Bank <span class="rflabelsteric">*</span></label>
                                    <select class="form-control select2" name="beneficiary_bank" id="beneficiary_bank" onchange="loadBankDetails()" required>
                                        <option value="">Select Bank</option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank->id }}" {{ $exportOrder->bank == $bank->id ? 'selected' : '' }}>{{ $bank->bank_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Is Advance</label>
                                    <select class="form-control" name="is_advance" id="is_advance">
                                        <option value="0" {{ ($exportOrder->is_advance ?? 0) == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ ($exportOrder->is_advance ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Mode of Production</label>
                                    <input type="text" class="form-control" name="mode_of_production" id="mode_of_production" 
                                        value="{{ $exportOrder->mode_of_production ?? '' }}" placeholder="Enter mode of production">
                                </div>
                            </div>
                            
                            <!-- Bank Details (Readonly) -->
                            <div class="form-row" id="bankDetailsRow">
                                <div class="form-group">
                                    <label class="form-label">Bank Name</label>
                                    <input type="text" class="form-control" id="bank_account_name" readonly />
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Account Title</label>
                                    <input type="text" class="form-control" id="bank_account_title" readonly />
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Account No</label>
                                    <input type="text" class="form-control" id="bank_account_no" readonly />
                                </div>
                            </div>
                            
                            <div class="form-row" id="bankDetailsRow2">
                                <div class="form-group">
                                    <label class="form-label">SWIFT Code</label>
                                    <input type="text" class="form-control" id="bank_swift_code" readonly />
                                </div>
                                <div class="form-group">
                                    <label class="form-label">IBAN No</label>
                                    <input type="text" class="form-control" id="bank_iban_no" readonly />
                                </div>
                            </div>
                            
                            <div class="form-row" id="bankDetailsRow3">
                                <div class="form-group" style="flex: 1 1 100%;">
                                    <label class="form-label">Bank Address</label>
                                    <input type="text" class="form-control" id="bank_address" readonly />
                                </div>
                            </div>
                            
                            <!-- New Dropdown Fields -->
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Incoterm</label>
                                    <select class="form-control select2" name="incoterm" id="incoterm">
                                        <option value="">Select Incoterm</option>
                                        @foreach ($incoterms as $incoterm)
                                            <option value="{{ $incoterm->id }}" {{ $exportOrder->incoterm == $incoterm->id ? 'selected' : '' }}>{{ $incoterm->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Port</label>
                                    <select class="form-control select2" name="port" id="port">
                                        <option value="">Select Port</option>
                                        @foreach ($ports as $port)
                                            <option value="{{ $port->id }}" {{ $exportOrder->port == $port->id ? 'selected' : '' }}>{{ $port->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Origin</label>
                                    <select class="form-control select2" name="origin" id="origin">
                                        <option value="">Select Origin</option>
                                        @foreach ($origins as $origin)
                                            <option value="{{ $origin->id }}" {{ $exportOrder->origin == $origin->id ? 'selected' : '' }}>{{ $origin->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Consignee</label>
                                    <select class="form-control select2" name="consignee" id="consignee">
                                        <option value="">Select Consignee</option>
                                        @foreach ($consignees as $consignee)
                                            <option value="{{ $consignee->id }}" {{ $exportOrder->consignee == $consignee->id ? 'selected' : '' }}>{{ $consignee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tolerance percentage(%)</label>
                                    <input type="text" class="form-control" id="tolerance_percentage" name="tolerance_percentage" value="{{ $exportOrder->tolerance_percentage }}" />
                                </div>
                            </div>
                            
                           
                            
                            <!-- Attachments Section -->
                            <div class="form-row">
                                <div class="form-group" style="flex: 1 1 100%;">
                                    <label class="form-label">Attachments</label>
                                    <div class="attachments-container">
                                        <input type="file" class="form-control" name="attachments[]" id="attachments" 
                                            multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif" />
                                        <small class="text-muted">You can select multiple files (PDF, DOC, XLS, Images)</small>
                                        <div id="attachmentPreview" class="mt-2"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hidden fields for backend compatibility -->
                            <input type="hidden" name="voucher_heading" value="Export Order" />
                            <input type="hidden" name="currencey_id" id="currencey_id" />
                            <input type="hidden" name="rate_conversion" id="rate_conversion" />
                            <input type="hidden" name="rate_of_conversion" id="rate_of_conversion" />
                            
                            <!-- Items Table -->
                            <div class="form-row">
                                <div class="form-group" style="flex: 1 1 100%;">
                                    <div class="lineHeight">&nbsp;</div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <span class="subHeadingLabelClass">Export Order Data</span>
                                    </div>
                                    <div class="lineHeight">&nbsp;&nbsp;&nbsp;</div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th colspan="10" class="text-center">Sales Order Detail</th>
                                                    <th colspan="2" class="text-center">
                                                        <input type="button" class="btn btn-sm btn-danger" style="background: blueviolet" onclick="addRow()" value="Add More Rows" />
                                                    </th>
                                                    <th class="text-center">
                                                        <span class="badge badge-success" id="rowCounter">{{ count($exportOrderData) > 0 ? count($exportOrderData) : 1 }}</span>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center" style="width: 25%; min-width: 250px;">Item Name</th>
                                                    <th class="text-center" style="width: 12%; min-width: 120px;">Item Size</th>
                                                    <th class="text-center" style="width: 10%; min-width: 100px;">Grades</th>
                                                    <th class="text-center" style="width: 10%; min-width: 100px;">UOM</th>
                                                    <th class="text-center" style="width: 10%; min-width: 100px;">HS Code</th>
                                                    <th class="text-center" style="width: 10%; min-width: 100px;">Pack UOM</th>
                                                    <th class="text-center" style="width: 10%; min-width: 100px;">Pack Size</th>
                                                    <th class="text-center" style="width: 10%; min-width: 100px;">Quantity</th>
                                                    <th class="text-center" style="width: 10%; min-width: 120px;">Final Weight</th>
                                                    <th class="text-center" style="width: 10%; min-width: 100px;">Unit Rate</th>
                                                    <th class="text-center" style="width: 12%; min-width: 120px;">Amount</th>
                                                    <th class="text-center" style="width: 6%; min-width: 80px;">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody id="itemsTableBody">
                                                @if(count($exportOrderData) > 0)
                                                    @foreach($exportOrderData as $index => $item)
                                                        @php
                                                            $rowNum = $index + 1;
                                                            $subitemModel = new Subitem();
                                                            $subitemModel = $subitemModel->SetConnection('mysql2');
                                                            $itemRow = $subitemModel->where('id', $item->item_id)->first();
                                                            $uom_name = $itemRow ? CommonHelper::get_uom_name($itemRow->uom ?? '') : '';
                                                            $pack_uom = $itemRow && $itemRow->pack_uom ? CommonHelper::get_uom_name($itemRow->pack_uom) : '';
                                                            $hs_code = $itemRow ? ($itemRow->hs_code ?? '') : '';
                                                            $itemValue = $item->item_id . ',' . ($item->uom_id ?? '') . ',' . $uom_name . ',' . ($itemRow->pack_type ?? '') . ',' . ($item->pack_size ?? '') . ',' . ($item->pack_uom ?? '') . ',' . $pack_uom . ',' . $hs_code;
                                                        @endphp
                                                        <tr class="item-row" data-row="{{ $rowNum }}">
                                                            <td>
                                                                <select name="sub_ic_des[]" class="form-control select2 item-select" onchange="getItemUOM({{ $rowNum }})" required>
                                                                    <option value="">Select Item</option>
                                                                    @foreach (CommonHelper::get_item_by_category(1) as $row)
                                                                        @php
                                                                            $opt_uom_name = CommonHelper::get_uom_name($row->uom);
                                                                            $opt_pack_uom = CommonHelper::get_uom_name($row->pack_uom);
                                                                            $opt_hs_code = $row->hs_code ?? '';
                                                                            $optValue = $row->id . ',' . $opt_uom_name . ',' . $opt_uom_name . ',' . $row->pack_type . ',' . $row->pack_size . ',' . $row->pack_uom . ',' . $opt_pack_uom . ',' . $opt_hs_code;
                                                                        @endphp
                                                                        <option value="{{ $optValue }}" {{ $item->item_id == $row->id ? 'selected' : '' }}>{{ $row->sub_ic }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="hidden" name="uom_id[]" class="uom-id-hidden" value="{{ $item->uom_id ?? '' }}" />
                                                            </td>
                                                            <td>
                                                                <select name="item_size[]" class="form-control select2 item-size" required>
                                                                    <option value="">Select</option>
                                                                    <option value="0-19" {{ $item->item_size == '0-19' ? 'selected' : '' }}>0-19</option>
                                                                    <option value="10-20" {{ $item->item_size == '10-20' ? 'selected' : '' }}>10-20</option>
                                                                    <option value="20-30" {{ $item->item_size == '20-30' ? 'selected' : '' }}>20-30</option>
                                                                    <option value="30-40" {{ $item->item_size == '30-40' ? 'selected' : '' }}>30-40</option>
                                                                    <option value="40-50" {{ $item->item_size == '40-50' ? 'selected' : '' }}>40-50</option>
                                                                    <option value="50-60" {{ $item->item_size == '50-60' ? 'selected' : '' }}>50-60</option>
                                                                    <option value="60-70" {{ $item->item_size == '60-70' ? 'selected' : '' }}>60-70</option>
                                                                    <option value="70-80" {{ $item->item_size == '70-80' ? 'selected' : '' }}>70-80</option>
                                                                    <option value="80-90" {{ $item->item_size == '80-90' ? 'selected' : '' }}>80-90</option>
                                                                    <option value="90-100" {{ $item->item_size == '90-100' ? 'selected' : '' }}>90-100</option>
                                                                    <option value="100+" {{ $item->item_size == '100+' ? 'selected' : '' }}>100+</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="quality[]" class="form-control select2 quality-select" required>
                                                                    <option value="">Select</option>
                                                                    <option value="A" {{ $item->quality == 'A' ? 'selected' : '' }}>A</option>
                                                                    <option value="A+" {{ $item->quality == 'A+' ? 'selected' : '' }}>A+</option>
                                                                    <option value="B" {{ $item->quality == 'B' ? 'selected' : '' }}>B</option>
                                                                    <option value="B+" {{ $item->quality == 'B+' ? 'selected' : '' }}>B+</option>
                                                                    <option value="C" {{ $item->quality == 'C' ? 'selected' : '' }}>C</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="uom_display[]" class="form-control uom-display" value="{{ $uom_name }}" readonly />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="hs_code_display[]" class="form-control hs-code-display" value="{{ $hs_code }}" readonly />
                                                            </td>
                                                            <td>
                                                                <select name="pack_uom[]" class="form-control select2 pack-uom-select" onchange="calculateRow({{ $rowNum }})" required>
                                                                    <option value="">Select</option>
                                                                    @foreach (CommonHelper::get_all_uom() as $uom)
                                                                        <option value="{{ $uom->id }}" data-uom-name="{{ strtolower($uom->uom_name) }}" {{ $item->pack_uom == $uom->id ? 'selected' : '' }}>{{ $uom->uom_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="number" name="pack_size[]" class="form-control pack-size" 
                                                                    step="0.01" min="0" onkeyup="calculateRow({{ $rowNum }})" onblur="calculateRow({{ $rowNum }})" 
                                                                    value="{{ $item->pack_size ?? 0 }}" required />
                                                            </td>
                                                            <td>
                                                                <input type="number" name="actual_qty[]" class="form-control quantity" 
                                                                    step="0.01" min="0" onkeyup="calculateRow({{ $rowNum }})" onblur="calculateRow({{ $rowNum }})" 
                                                                    value="{{ $item->actual_qty ?? 0 }}" required />
                                                            </td>
                                                            <td>
                                                                <input type="number" name="total_qty[]" class="form-control total-quantity" 
                                                                    step="0.01" min="0" value="{{ $item->total_qty ?? 0 }}" readonly />
                                                            </td>
                                                            <td>
                                                                <input type="number" name="rate[]" class="form-control unit-rate" 
                                                                    step="0.01" min="0" onkeyup="calculateRow({{ $rowNum }})" onblur="calculateRow({{ $rowNum }})" 
                                                                    value="{{ $item->rate ?? 0 }}" required />
                                                            </td>
                                                            <td>
                                                                <input type="number" name="amount[]" class="form-control amount" 
                                                                    step="0.01" min="0" value="{{ $item->amount ?? 0 }}" readonly />
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn-remove-row" onclick="removeRow({{ $rowNum }})" {{ count($exportOrderData) > 1 ? '' : 'style="display:none;"' }}>Remove</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr class="item-row" data-row="1">
                                                        <td>
                                                            <select name="sub_ic_des[]" class="form-control select2 item-select" onchange="getItemUOM(1)" required>
                                                                <option value="">Select Item</option>
                                                                @foreach (CommonHelper::get_item_by_category(1) as $row)
                                                                    <?php
                                                                    $uom_name = CommonHelper::get_uom_name($row->uom);
                                                                    $pack_uom = CommonHelper::get_uom_name($row->pack_uom);
                                                                    $hs_code = $row->hs_code ?? '';
                                                                    ?>
                                                                    <option value="{{ $row->id . ',' . $uom_name . ',' . $uom_name . ',' . $row->pack_type . ',' . $row->pack_size . ',' . $row->pack_uom . ',' . $pack_uom . ',' . $hs_code }}">{{ $row->sub_ic }}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" name="uom_id[]" class="uom-id-hidden" />
                                                        </td>
                                                        <td>
                                                            <select name="item_size[]" class="form-control select2 item-size" required>
                                                                <option value="">Select</option>
                                                                <option value="0-19">0-19</option>
                                                                <option value="10-20">10-20</option>
                                                                <option value="20-30">20-30</option>
                                                                <option value="30-40">30-40</option>
                                                                <option value="40-50">40-50</option>
                                                                <option value="50-60">50-60</option>
                                                                <option value="60-70">60-70</option>
                                                                <option value="70-80">70-80</option>
                                                                <option value="80-90">80-90</option>
                                                                <option value="90-100">90-100</option>
                                                                <option value="100+">100+</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="quality[]" class="form-control select2 quality-select" required>
                                                                <option value="">Select</option>
                                                                <option value="A">A</option>
                                                                <option value="A+">A+</option>
                                                                <option value="B">B</option>
                                                                <option value="B+">B+</option>
                                                                <option value="C">C</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="uom_display[]" class="form-control uom-display" readonly />
                                                        </td>
                                                        <td>
                                                            <input type="text" name="hs_code_display[]" class="form-control hs-code-display" readonly />
                                                        </td>
                                                        <td>
                                                            <select name="pack_uom[]" class="form-control select2 pack-uom-select" onchange="calculateRow(1)" required>
                                                                <option value="">Select</option>
                                                                @foreach (CommonHelper::get_all_uom() as $uom)
                                                                    <option value="{{ $uom->id }}" data-uom-name="{{ strtolower($uom->uom_name) }}">{{ $uom->uom_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="pack_size[]" class="form-control pack-size" 
                                                                step="0.01" min="0" onkeyup="calculateRow(1)" onblur="calculateRow(1)" required />
                                                        </td>
                                                        <td>
                                                            <input type="number" name="actual_qty[]" class="form-control quantity" 
                                                                step="0.01" min="0" onkeyup="calculateRow(1)" onblur="calculateRow(1)" required />
                                                        </td>
                                                        <td>
                                                            <input type="number" name="total_qty[]" class="form-control total-quantity" 
                                                                step="0.01" min="0" readonly />
                                                        </td>
                                                        <td>
                                                            <input type="number" name="rate[]" class="form-control unit-rate" 
                                                                step="0.01" min="0" onkeyup="calculateRow(1)" onblur="calculateRow(1)" required />
                                                        </td>
                                                        <td>
                                                            <input type="number" name="amount[]" class="form-control amount" 
                                                                step="0.01" min="0" readonly />
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn-remove-row" onclick="removeRow(1)" style="display:none;">Remove</button>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Total Amount -->
                            <div class="form-row">
                                <div class="form-group" style="flex: 1 1 50%; padding-right: 10px;">
                                    <label class="form-label" style="font-size: 16px;">Total Amount</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="total_amount" id="total_amount" value="0.00" readonly style="text-align: right; font-weight: bold;" />
                                        <span class="input-group-addon" id="currencySymbolWrapper">
                                            <span id="currencySymbol"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group" style="flex: 1 1 50%; padding-left: 10px;">
                                    <label class="form-label" style="font-size: 16px;">Total Amount in PKR</label>
                                    <input type="text" class="form-control" name="total_amount_pkr" id="total_amount_pkr" value="0.00" readonly style="text-align: right; font-weight: bold;" />
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="form-row">
                                <div class="form-group" style="flex: 1 1 100%;">
                                    <button type="submit" class="btn-submit">Update</button>
                                    <div style="clear: both;"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <?php else:?>
                    <div class="text-center text-danger" style="padding: 20px;">
                        Permission Denied
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let rowCounter = {{ count($exportOrderData) > 0 ? count($exportOrderData) : 1 }};
    
    // Store currency data
    const currencyData = {
        @foreach ($conversions as $conversion)
        {{ $conversion->id }}: {
            name: '{{ $conversion->curreny }}',
            rate: {{ $conversion->rate ?? 1 }}
        },
        @endforeach
    };
    
    function updateCurrencyInfo() {
        const currencyId = $('#currency_id').val();
        const selectedOption = $('#currency_id option:selected');
        const currencyRate = selectedOption.data('rate') || 1;
        const currencyName = selectedOption.data('name') || '';
        
        if (currencyId && currencyId !== '') {
            // Show exchange rate field
            $('#exchangeRateGroup').show();
            if (!$('#exchange_rate').val() || $('#exchange_rate').val() == '') {
                $('#exchange_rate').val(currencyRate);
            }
            $('#exchange_rate').prop('required', true);
        } else {
            // Hide exchange rate field
            $('#exchangeRateGroup').hide();
            $('#exchange_rate').val('');
            $('#exchange_rate').prop('required', false);
        }
        
        updateExchangeRate();
    }
    
    function updateExchangeRate() {
        const currencyId = $('#currency_id').val();
        const selectedOption = $('#currency_id option:selected');
        const currencyName = selectedOption.data('name') || '';
        const exchangeRate = parseFloat($('#exchange_rate').val()) || 1;
        
        $('#currencey_id').val(currencyId);
        $('#rate_conversion').val(currencyId);
        $('#rate_of_conversion').val(exchangeRate);
        $('#currency_rate').val(exchangeRate);
        $('#currency_name').val(currencyName);
        $('#currencySymbol').text(currencyName);

        // Recalculate totals whenever exchange rate or currency changes
        calculateTotal();
    }
    
    $(document).ready(function() {
        $('.select2').select2();
        
        // Initialize existing data
        @if($exportOrder->buyer_id)
            loadCustomerDetails();
        @endif
        
        @if($exportOrder->bank)
            loadBankDetails();
        @endif
        
        // Set currency info if currency is selected
        @if($exportOrder->currencey_id)
            updateCurrencyInfo();
        @endif
        
        // Initialize total amount fields
        calculateTotal();
        
        // Set currency ID when currency is selected
        $('#currency_id').on('change', function() {
            updateCurrencyInfo();
        });
        
        // Handle attachment preview
        $('#attachments').on('change', function() {
            previewAttachments(this);
        });
        
        // Show remove button if more than one row
        updateRemoveButtons();
        
        // Trigger getItemUOM for existing rows to populate UOM and HS Code
        @if(count($exportOrderData) > 0)
            @foreach($exportOrderData as $index => $item)
                getItemUOM({{ $index + 1 }});
            @endforeach
        @endif
    });
    
    function loadCustomerDetails() {
        const customerId = $('#buyers_id').val();
        if (customerId) {
            $.ajax({
                url: '{{ route("getCustomerDetails") }}',
                type: 'GET',
                data: { id: customerId },
                success: function(response) {
                    if (response.success) {
                        $('#customer_address').val(response.address);
                        $('#customer_ntn').val(response.ntn);
                    } else {
                        $('#customer_address').val('');
                        $('#customer_ntn').val('');
                    }
                },
                error: function() {
                    $('#customer_address').val('');
                    $('#customer_ntn').val('');
                    $('#customerDetailsRow').hide();
                }
            });
        } else {
            $('#customer_address').val('');
            $('#customer_ntn').val('');
        }
    }
    
    function loadBankDetails() {
        const bankId = $('#beneficiary_bank').val();
        if (bankId) {
            $.ajax({
                url: '{{ route("getBankDetails") }}',
                type: 'GET',
                data: { id: bankId },
                success: function(response) {
                    if (response.success) {
                        $('#bank_account_name').val(response.bank_name);
                        $('#bank_account_title').val(response.account_title);
                        $('#bank_account_no').val(response.account_no || '');
                        $('#bank_swift_code').val(response.swift_code);
                        $('#bank_iban_no').val(response.iban_no);
                        $('#bank_address').val(response.bank_address);
                    } else {
                        clearBankDetails();
                    }
                },
                error: function() {
                    clearBankDetails();
                }
            });
        } else {
            clearBankDetails();
        }
    }
    
    function clearBankDetails() {
        $('#bank_account_name').val('');
        $('#bank_account_title').val('');
        $('#bank_account_no').val('');
        $('#bank_swift_code').val('');
        $('#bank_iban_no').val('');
        $('#bank_address').val('');
    }
    
    let selectedFiles = [];
    
    function previewAttachments(input) {
        const preview = $('#attachmentPreview');
        preview.html('');
        selectedFiles = [];
        
        if (input.files && input.files.length > 0) {
            preview.append('<div class="attachment-preview"><strong>Selected Files:</strong></div>');
            Array.from(input.files).forEach(function(file, index) {
                selectedFiles.push(file);
                const fileSize = (file.size / 1024).toFixed(2) + ' KB';
                preview.append(`
                    <div class="attachment-item" data-file-index="${index}">
                        <span>${file.name} (${fileSize})</span>
                        <button type="button" class="attachment-remove-btn" onclick="removeAttachment(${index})">Remove</button>
                    </div>
                `);
            });
        }
    }
    
    function removeAttachment(index) {
        // Remove from selectedFiles array
        selectedFiles.splice(index, 1);
        
        // Create new FileList
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(function(file) {
            dataTransfer.items.add(file);
        });
        
        // Update the input files
        const input = document.getElementById('attachments');
        input.files = dataTransfer.files;
        
        // Refresh preview
        previewAttachments(input);
    }
    
    function addRow() {
        rowCounter++;
        const newRow = `
            <tr class="item-row" data-row="${rowCounter}">
                <td>
                    <select name="sub_ic_des[]" class="form-control select2 item-select" onchange="getItemUOM(${rowCounter})" required>
                        <option value="">Select Item</option>
                        @foreach (CommonHelper::get_item_by_category(81) as $row)
                            <?php
                            $uom = CommonHelper::get_uom($row->id);
                            $uom_name = CommonHelper::get_uom_name($uom);
                            $pack_uom = CommonHelper::get_uom_name($row->pack_uom);
                            $hs_code = $row->hs_code ?? '';
                            ?>
                            <option value="{{ $row->id . ',' . $uom . ',' . $uom_name . ',' . $row->pack_type . ',' . $row->pack_size . ',' . $row->pack_uom . ',' . $pack_uom . ',' . $hs_code }}">{{ $row->sub_ic }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="uom_id[]" class="uom-id-hidden" />
                </td>
                <td>
                    <select name="item_size[]" class="form-control select2 item-size" required>
                        <option value="">Select</option>
                        <option value="0-19">0-19</option>
                        <option value="10-20">10-20</option>
                        <option value="20-30">20-30</option>
                        <option value="30-40">30-40</option>
                        <option value="40-50">40-50</option>
                        <option value="50-60">50-60</option>
                        <option value="60-70">60-70</option>
                        <option value="70-80">70-80</option>
                        <option value="80-90">80-90</option>
                        <option value="90-100">90-100</option>
                        <option value="100+">100+</option>
                    </select>
                </td>
                <td>
                    <select name="quality[]" class="form-control select2 quality-select" required>
                        <option value="">Select</option>
                        <option value="A">A</option>
                        <option value="A+">A+</option>
                        <option value="B">B</option>
                        <option value="B+">B+</option>
                        <option value="C">C</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="uom_display[]" class="form-control uom-display" readonly />
                </td>
                <td>
                    <input type="text" name="hs_code_display[]" class="form-control hs-code-display" readonly />
                </td>
                <td>
                    <select name="pack_uom[]" class="form-control select2 pack-uom-select" onchange="calculateRow(${rowCounter})" required>
                        <option value="">Select</option>
                        @foreach (CommonHelper::get_all_uom() as $uom)
                            <option value="{{ $uom->id }}" data-uom-name="{{ strtolower($uom->uom_name) }}">{{ $uom->uom_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="pack_size[]" class="form-control pack-size" 
                        step="0.01" min="0" onkeyup="calculateRow(${rowCounter})" onblur="calculateRow(${rowCounter})" required />
                </td>
                <td>
                    <input type="number" name="actual_qty[]" class="form-control quantity" 
                        step="0.01" min="0" onkeyup="calculateRow(${rowCounter})" onblur="calculateRow(${rowCounter})" required />
                </td>
                <td>
                    <input type="number" name="total_qty[]" class="form-control total-quantity" 
                        step="0.01" min="0" readonly />
                </td>
                <td>
                    <input type="number" name="rate[]" class="form-control unit-rate" 
                        step="0.01" min="0" onkeyup="calculateRow(${rowCounter})" onblur="calculateRow(${rowCounter})" required />
                </td>
                <td>
                    <input type="number" name="amount[]" class="form-control amount" 
                        step="0.01" min="0" readonly />
                </td>
                <td>
                    <button type="button" class="btn-remove-row" onclick="removeRow(${rowCounter})">Remove</button>
                </td>
            </tr>
        `;
        
        $('#itemsTableBody').append(newRow);
        // Reinitialize select2 for new row
        $(`tr[data-row="${rowCounter}"] .select2`).select2();
        updateRemoveButtons();
        updateRowCounter();
    }
    
    function removeRow(rowNum) {
        $(`tr[data-row="${rowNum}"]`).remove();
        updateRemoveButtons();
        updateRowCounter();
        calculateTotal();
    }
    
    function updateRemoveButtons() {
        const rowCount = $('.item-row').length;
        $('.btn-remove-row').each(function() {
            if (rowCount > 1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
    
    function updateRowCounter() {
        const rowCount = $('.item-row').length;
        $('#rowCounter').text(rowCount);
    }
    
    function getItemUOM(rowNum) {
        const row = $(`tr[data-row="${rowNum}"]`);
        const itemSelect = row.find('.item-select');
        const selectedValue = itemSelect.val();
        
        if (selectedValue) {
            const parts = selectedValue.split(',');
            if (parts.length >= 8) {
                // parts[0] = item_id
                // parts[1] = uom_id
                // parts[2] = uom_name
                // parts[3] = pack_type
                // parts[4] = pack_size
                // parts[5] = pack_uom_id
                // parts[6] = pack_uom_name
                // parts[7] = hs_code
                
                row.find('.uom-id-hidden').val(parts[1]); // UOM ID (hidden field)
                row.find('.uom-display').val(parts[2]); // UOM Name (display)
                row.find('.hs-code-display').val(parts[7] || ''); // HS Code (display)
                
                // Set Pack UOM dropdown
                row.find('.pack-uom-select').val(parts[5]).trigger('change');
                
                // Set Pack Size if available and not already set
                if (parts[4] && parts[4] != '' && !row.find('.pack-size').val()) {
                    row.find('.pack-size').val(parts[4]);
                }
            } else if (parts.length >= 7) {
                // Backward compatibility for old format
                row.find('.uom-id-hidden').val(parts[1]);
                row.find('.uom-display').val(parts[2]);
                row.find('.hs-code-display').val('');
                row.find('.pack-uom-select').val(parts[5]).trigger('change');
                if (parts[4] && parts[4] != '' && !row.find('.pack-size').val()) {
                    row.find('.pack-size').val(parts[4]);
                }
            }
        } else {
            row.find('.uom-id-hidden').val('');
            row.find('.uom-display').val('');
            row.find('.hs-code-display').val('');
            row.find('.pack-uom-select').val('').trigger('change');
        }
    }
    
    function calculateRow(rowNum) {
        const row = $(`tr[data-row="${rowNum}"]`);
        const packSize = parseFloat(row.find('.pack-size').val()) || 0;
        const quantity = parseFloat(row.find('.quantity').val()) || 0;
        const unitRate = parseFloat(row.find('.unit-rate').val()) || 0;
        
        // Get pack UOM name
        const packUomSelect = row.find('.pack-uom-select');
        const packUomId = packUomSelect.val();
        const packUomText = packUomSelect.find('option:selected').text().toLowerCase().trim();
        
        let totalQuantity = 0;
        
        // Calculate total quantity based on pack UOM
        if (packUomText === 'kg' || packUomText === 'kilogram' || packUomText === 'liter' || packUomText === 'litre' || packUomText === 'l') {
            // For kg or liter: pack_size * quantity
            totalQuantity = packSize * quantity;
        } else if (packUomText === 'gram' || packUomText === 'g' || packUomText === 'grams') {
            // For gram: pack_size * quantity (in grams), convert to kg for display
            totalQuantity = (packSize * quantity) / 1000; // Convert grams to kg
        } else if (packUomText === 'box' || packUomText === 'boxes') {
            // For box: pack_size represents kg per box, so pack_size * quantity
            totalQuantity = packSize * quantity;
        } else {
            // Default: pack_size * quantity
            totalQuantity = packSize * quantity;
        }
        
        row.find('.total-quantity').val(totalQuantity.toFixed(2));
        
        // Calculate amount (total_quantity * unit_rate)
        const amount = totalQuantity * unitRate;
        row.find('.amount').val(amount.toFixed(2));
        
        // Force update the display
        row.find('.amount').trigger('input');
        
        calculateTotal();
    }
    
    function calculateTotal() {
        let total = 0;
        $('.amount').each(function() {
            const amountValue = parseFloat($(this).val()) || 0;
            total += amountValue;
        });

        // Set total amount in selected currency
        const formattedTotal = parseFloat(total.toFixed(2));
        const formattedTotalStr = formattedTotal.toFixed(2);
        
        // Update total amount field
        const totalAmountField = $('#total_amount');
        totalAmountField.val(formattedTotalStr);
        
        // Force update display by triggering events
        totalAmountField.trigger('input').trigger('change');
        
        // Ensure visibility
        if (totalAmountField.is(':visible')) {
            totalAmountField.focus().blur(); // Force repaint
        }

        // Calculate PKR amount using exchange rate (for any currency)
        const currencyRate = parseFloat($('#currency_rate').val()) || 1;
        const totalPKR = total * currencyRate;
        const formattedPKR = totalPKR.toFixed(2);
        $('#total_amount_pkr').val(formattedPKR);
        
        // Debug: log to console (can be removed later)
        console.log('Total Amount:', formattedTotalStr, 'Currency Rate:', currencyRate, 'Total PKR:', formattedPKR);
    }
</script>

@endsection
