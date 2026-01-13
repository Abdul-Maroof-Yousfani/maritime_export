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
    .invoice-form-wrapper {
        font-family: Arial, sans-serif;
        max-width: 210mm;
        margin: 0 auto;
        padding: 20px;
        background: #fff;
    }
    
    .invoice-header-form {
        border-bottom: 2px solid #000;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }
    
    .company-header-form {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }
    
    .company-info-form {
        flex: 1;
    }
    
    .company-name-form {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 5px;
        text-transform: uppercase;
    }
    
    .company-tagline-form {
        font-size: 12px;
        color: #333;
        margin-bottom: 10px;
    }
    
    .certifications-form {
        display: flex;
        gap: 10px;
        margin-top: 5px;
    }
    
    .cert-badge-form {
        background: #f0f0f0;
        padding: 3px 8px;
        border-radius: 3px;
        font-size: 10px;
        font-weight: bold;
    }
    
    .logo-area-form {
        width: 150px;
        text-align: right;
    }
    
    .logo-area-form img {
        max-width: 100%;
        height: auto;
    }
    
    .invoice-title-form {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        margin: 15px 0;
        text-transform: uppercase;
    }
    
    .form-row-invoice {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .form-col-half {
        flex: 1;
    }
    
    .form-section-invoice {
        margin-bottom: 20px;
    }
    
    .section-title-invoice {
        font-weight: bold;
        font-size: 12px;
        margin-bottom: 8px;
        text-transform: uppercase;
    }
    
    .form-group-invoice {
        margin-bottom: 12px;
    }
    
    .form-label-invoice {
        font-weight: bold;
        font-size: 11px;
        display: block;
        margin-bottom: 5px;
    }
    
    .form-control-invoice {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 11px;
    }
    
    .form-control-invoice:focus {
        border-color: #007bff;
        outline: none;
    }
    
    .form-control-invoice[readonly] {
        background-color: #f5f5f5;
    }
    
    .bank-table-form {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        border: 1px solid #000;
    }
    
    .bank-table-form td {
        border: 1px solid #000;
        padding: 8px;
        vertical-align: middle;
    }
    
    .bank-table-form .label-cell {
        font-weight: bold;
        width: 200px;
        background-color: #f0f0f0;
        font-size: 11px;
    }
    
    .bank-table-form input,
    .bank-table-form textarea {
        width: 100%;
        border: none;
        padding: 5px;
        font-size: 11px;
        background: transparent;
    }
    
    .bank-table-form textarea {
        resize: vertical;
        min-height: 60px;
    }
    
    .buyer-info-box {
        border: 1px solid #ccc;
        padding: 10px;
        background: #f9f9f9;
        margin-bottom: 15px;
    }
    
    .btn-submit-form {
        background-color: #28a745;
        color: white;
        padding: 12px 40px;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        float: right;
        margin-top: 20px;
    }
    
    .btn-submit-form:hover {
        background-color: #218838;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="well_N">
                <div class="dp_sdw">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <span class="subHeadingLabelClass">Create Proforma Invoice</span>
                            <?php if($MenuPermission != true):?>
                            <span class="subHeadingLabelClass text-danger text-center" style="float: right">Permission Denied</span>
                            <?php endif;?>
                        </div>
                    </div>
                    
                    <?php if($MenuPermission == true):?>
                    <div class="lineHeight">&nbsp;</div>
                    
                    <form action="{{route('proformaStore')}}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{$sale_order->id}}">
                        
                        <div class="invoice-form-wrapper">
                            <!-- Header Section -->
                            <div class="invoice-header-form">
                                <div class="company-header-form">
                                    <div class="company-info-form">
                                        <div class="company-name-form">SUPER STAR ENTERPRISES</div>
                                        <div class="company-tagline-form">Gift from the Sea</div>
                                        <div class="certifications-form">
                                            <span class="cert-badge-form">FDA</span>
                                            <span class="cert-badge-form">ISO</span>
                                        </div>
                                    </div>
                                    <div class="logo-area-form">
                                        <img src="{{asset('/public/images/garibsons.jpg')}}" alt="Company Logo" onerror="this.style.display='none'">
                                    </div>
                                </div>
                                
                                <div class="invoice-title-form">PROFORMA INVOICE</div>
                            </div>
                            
                            <!-- Proforma Invoice Number and Date -->
                            <div class="form-section-invoice">
                                <div class="form-row-invoice">
                                    <div class="form-col-half">
                                        <div class="form-group-invoice">
                                            <label class="form-label-invoice">PROFORMA INVOICE NO <span class="rflabelsteric">*</span></label>
                                            <input type="text" class="form-control-invoice" name="pro_contract_no" id="pro_contract_no" value="" required />
                                        </div>
                                    </div>
                                    <div class="form-col-half">
                                        <div class="form-group-invoice">
                                            <label class="form-label-invoice">DATE</label>
                                            <input type="text" class="form-control-invoice" value="{{ date('d/m/Y') }}" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row-invoice">
                                    <div class="form-col-half">
                                        <div class="form-group-invoice">
                                            <label class="form-label-invoice">CONTRACT NO</label>
                                            <input type="text" class="form-control-invoice" value="{{ $sale_order->contract_no ?? '' }}" readonly />
                                        </div>
                                    </div>
                                    <div class="form-col-half">
                                        <div class="form-group-invoice">
                                            <label class="form-label-invoice">EO NO</label>
                                            <input type="text" class="form-control-invoice" name="voucher_no" value="{{ $sale_order->voucehr_no ?? '' }}" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Buyer Information -->
                            <div class="form-section-invoice">
                                <div class="section-title-invoice">BUYER:</div>
                                <div class="buyer-info-box">
                                    <div style="font-weight: bold; font-size: 12px; margin-bottom: 5px;">{{ strtoupper($sale_order->name ?? '') }}</div>
                                    <div style="font-size: 11px;">{{ strtoupper($sale_order->address ?? '') }}</div>
                                </div>
                            </div>
                            
                            <!-- Bank Account Details -->
                            <div class="form-section-invoice">
                                <div class="section-title-invoice">BANK ACCOUNT DETAILS:</div>
                                @php
                                if(!empty($sale_order->bank)) {
                                    $bank_obj = App\Models\Bank::find($sale_order->bank);
                                    $bank_name = $bank_obj->bank_name ?? '';
                                    $bank_swift = $bank_obj->swift_code ?? '';
                                    $bank_ibn = $bank_obj->IBAN_no ?? '';
                                    $bank_address = $bank_obj->bank_address ?? '';
                                    $account_title = $bank_obj->account_title ?? '';
                                } else {
                                    $bank_name = '';
                                    $bank_swift = '';
                                    $bank_ibn = '';
                                    $bank_address = '';
                                    $account_title = '';
                                }
                                @endphp
                                <table class="bank-table-form">
                                    <tr>
                                        <td class="label-cell">BANK NAME:</td>
                                        <td><input type="text" value="{{ $bank_name }}" readonly /></td>
                                    </tr>
                                    <tr>
                                        <td class="label-cell">ADDRESS:</td>
                                        <td><input type="text" value="{{ $bank_address }}" readonly /></td>
                                    </tr>
                                    <tr>
                                        <td class="label-cell">SWIFT CODE:</td>
                                        <td><input type="text" value="{{ $bank_swift }}" readonly /></td>
                                    </tr>
                                    <tr>
                                        <td class="label-cell">ACCOUNT TITLE:</td>
                                        <td><input type="text" value="{{ $account_title }}" readonly /></td>
                                    </tr>
                                    <tr>
                                        <td class="label-cell">IBAN NO:</td>
                                        <td><input type="text" value="{{ $bank_ibn }}" readonly /></td>
                                    </tr>
                                </table>
                            </div>
                            
                            <!-- Correspondent Bank Details -->
                            <div class="form-section-invoice">
                                <div class="section-title-invoice">CORRESPONDENT BANK DETAILS:</div>
                                <table class="bank-table-form">
                                    <tr>
                                        <td class="label-cell">ACCOUNT TITLE:</td>
                                        <td><input type="text" name="account_title" id="account_title" value="{{ $sale_order->account_title ?? '' }}" /></td>
                                    </tr>
                                    <tr>
                                        <td class="label-cell">BANK:</td>
                                        <td><input type="text" name="correspondent_bank" id="correspondent_bank" value="{{ $sale_order->correspondent_bank ?? '' }}" /></td>
                                    </tr>
                                    <tr>
                                        <td class="label-cell">ACCOUNT NO:</td>
                                        <td><input type="text" name="correspondent_account" id="correspondent_account" value="{{ $sale_order->correspondent_account_no ?? '' }}" /></td>
                                    </tr>
                                    <tr>
                                        <td class="label-cell">SWIFT CODE:</td>
                                        <td><input type="text" name="correspondent_swift" id="correspondent_swift" value="{{ $sale_order->correspondent_bank_swift ?? '' }}" /></td>
                                    </tr>
                                    <tr>
                                        <td class="label-cell">DETAILS OF PAYMENT:</td>
                                        <td>
                                            <textarea name="payment_details" id="payment_details" required>{{ $sale_order->advance_payment ? ($sale_order->advance_payment . '% Advance and ' . (100-$sale_order->advance_payment) . '% within ' . ($sale_order->payment_days ?? 30) . ' Working Days Of BL and Invoice') : ('100% Within ' . ($sale_order->payment_days ?? 30) . ' working days of BL and Invoice.') }}</textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            <button type="submit" class="btn-submit-form">Submit</button>
                            <div style="clear: both;"></div>
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
    $(document).ready(function() {
        // Form validation if needed
    });
</script>

@endsection
