<?php
use App\Helpers\CommonHelper;
use App\Helpers\SalesHelper;
$m = Session::get('run_company');
?>
@extends('layouts.default')
@section('content')
@include('select2')

<style>
    .table-responsive {
        max-height: 500px;
        overflow-y: auto;
        overflow-x: auto;
        border: 1px solid #ddd;
        width: 100%;
        margin-top: 20px;
    }
    
    .table-responsive table {
        width: 100%;
        border-collapse: collapse;
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
        z-index: 10;
    }
    
    .table-responsive tbody td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
        font-size: 11px;
    }
    
    .commercial-invoice-details {
        display: none;
    }
    
    .loader-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }
    
    .loader-overlay.active {
        display: flex;
    }
    
    .loader-spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .loader-text {
        color: white;
        margin-top: 20px;
        font-size: 16px;
    }
</style>

<div class="well_N">
    <div class="dp_sdw">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="display: none;">
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="well">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span class="subHeadingLabelClass">Commercial Invoice</span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            
                            <form id="commercialInvoiceForm">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <label>Select Loading No <span class="rflabelsteric"><strong>*</strong></span></label>
                                                        <select class="form-control select2" name="loading_id" id="loading_id" required>
                                                            <option value="">Select Loading No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div id="commercialInvoiceDetails" class="commercial-invoice-details">
                                                    <div class="lineHeight">&nbsp;</div>
                                                    
                                                    {{-- Invoice Details Section --}}
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="panel">
                                                                <div class="panel-body">
                                                                    <h4 style="text-align: center; margin-bottom: 15px;"><u><b>INVOICE DETAILS</b></u></h4>
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th style="width:25%;border:1px solid;padding:8px;">Invoice No</th>
                                                                                    <td style="width:25%;border:1px solid;padding:8px;">
                                                                                        <input type="text" class="form-control" name="invoice_no" id="invoice_no" readonly style="background-color: #f5f5f5;" value="{{ strtoupper(SalesHelper::get_unique_commercial_invoice_no()) }}">
                                                                                    </td>
                                                                                    <th style="width:25%;border:1px solid;padding:8px;">Date</th>
                                                                                    <td style="width:25%;border:1px solid;padding:8px;">
                                                                                        <input type="date" class="form-control" name="invoice_date" id="invoice_date" value="{{ date('Y-m-d') }}" required>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th style="border:1px solid;padding:8px;">GD NO</th>
                                                                                    <td style="border:1px solid;padding:8px;">
                                                                                        <input type="text" class="form-control" name="gd_no" id="gd_no">
                                                                                    </td>
                                                                                    <th style="border:1px solid;padding:8px;">Consignee Name</th>
                                                                                    <td style="border:1px solid;padding:8px;" colspan="3">
                                                                                        <input type="text" class="form-control" name="consignee_name" id="consignee_name" readonly style="background-color: #f5f5f5;">
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                   
                                                                                     <th style="border:1px solid;padding:8px;">Consignee Address</th>
                                                                                    <td style="border:1px solid;padding:8px;" colspan="3">
                                                                                        <textarea class="form-control" name="consignee_address" id="consignee_address" rows="2" readonly style="background-color: #f5f5f5;"></textarea>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                   
                                                                                    <th style="border:1px solid;padding:8px;">From</th>
                                                                                    <td style="border:1px solid;padding:8px;">
                                                                                        <input type="text" class="form-control" name="port_from" id="port_from" readonly style="background-color: #f5f5f5;">
                                                                                    </td>
                                                                                    <th style="border:1px solid;padding:8px;">To</th>
                                                                                    <td style="border:1px solid;padding:8px;">
                                                                                        <input type="text" class="form-control" name="port_to" id="port_to" style="background-color: #f5f5f5;">
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th style="border:1px solid;padding:8px;">Vessel/Voyage</th>
                                                                                    <td style="border:1px solid;padding:8px;">
                                                                                        <input type="text" class="form-control" name="vessel_voyage" id="vessel_voyage">
                                                                                    </td>
                                                                                    <th style="border:1px solid;padding:8px;">Payment Term</th>
                                                                                    <td style="border:1px solid;padding:8px;">
                                                                                        <input type="text" class="form-control" name="payment_term" id="payment_term">
                                                                                    </td>
                                                                                </tr>
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div id="containers_display" style="max-height: 100px; overflow-y: auto;">
                                                                        <h4 style="text-align: center; margin-bottom: 15px;"><u><b>CONTAINERS DETAILS</b></u></h4>
                                                                        <table class="table table-bordered" style="margin-bottom: 0;">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="padding: 5px; font-size: 11px; text-align: center;">S.No</th>
                                                                                    <th style="padding: 5px; font-size: 11px; text-align: center;">Item Name</th>
                                                                                    <th style="padding: 5px; font-size: 11px; text-align: center;">Container No</th>
                                                                                    <th style="padding: 5px; font-size: 11px; text-align: center;">Vehicle No</th>
                                                                                    <th style="padding: 5px; font-size: 11px; text-align: center;">Seal No</th>
                                                                                    <th style="padding: 5px; font-size: 11px; text-align: center;">Quantity</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="containers_table_body">
                                                                                <tr><td colspan="3" style="text-align: center; padding: 5px;">No containers</td></tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <input type="hidden" name="container_no" id="container_no">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    {{-- Product Details Table --}}
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="panel">
                                                                <div class="panel-body">
                                                                    <h4 style="text-align: center; margin-bottom: 15px;"><u><b>PRODUCT DETAILS</b></u></h4>
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered" id="productTable">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="border:1px solid;padding:8px;">S.No</th>
                                                                                    <th style="border:1px solid;padding:8px;">Descriptions of Product</th>
                                                                                    <th style="border:1px solid;padding:8px;">Grade Size</th>
                                                                                    <th style="border:1px solid;padding:8px;">Total Cartons</th>
                                                                                    <th style="border:1px solid;padding:8px;">Total Net Kgs</th>
                                                                                    <th style="border:1px solid;padding:8px;">Rate CFR Per kg</th>
                                                                                    <th style="border:1px solid;padding:8px;">Amount</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="productTableBody">
                                                                                <!-- Products will be populated here -->
                                                                            </tbody>
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <td colspan="3" style="border:1px solid;padding:8px;text-align:right;font-weight:bold;">Grand Total</td>
                                                                                    <td style="border:1px solid;padding:8px;text-align:center;font-weight:bold;" id="total_cartons">0</td>
                                                                                    <td style="border:1px solid;padding:8px;text-align:right;font-weight:bold;" id="total_net_kgs">0.00</td>
                                                                                    <td style="border:1px solid;padding:8px;"></td>
                                                                                    <td style="border:1px solid;padding:8px;text-align:right;font-weight:bold;" id="grand_total">$ 0.00</td>
                                                                                </tr>
                                                                            </tfoot>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    {{-- Advance Payment Section --}}
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="panel">
                                                                <div class="panel-body">
                                                                    <h4 style="text-align: center; margin-bottom: 15px;"><u><b>ADVANCE PAYMENT</b></u></h4>
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th style="width:50%;border:1px solid;padding:8px;">Grand Total:</th>
                                                                                    <td style="width:50%;border:1px solid;padding:8px;text-align:right;font-weight:bold;" id="display_grand_total">$ 0.00</td>
                                                                                </tr>
                                                                               
                                                                                <tr>
                                                                                    <th style="border:1px solid;padding:8px;">ADVANCE:</th>
                                                                                    <td style="border:1px solid;padding:8px;text-align:right;font-weight:bold;" id="display_advance_amount">$ 0.00</td>
                                                                                </tr>
                                                                                
                                                                                <tr>
                                                                                    <th style="border:1px solid;padding:8px;">BALANCE:</th>
                                                                                    <td style="border:1px solid;padding:8px;text-align:right;font-weight:bold;" id="display_balance_amount">$ 0.00</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="lineHeight">&nbsp;</div>
                                                    
                                                    <input type="hidden" name="contract_loading_id" id="contract_loading_id">
                                                    <input type="hidden" name="sale_order_export_id" id="sale_order_export_id">
                                                    <input type="hidden" name="currency_id" id="currency_id">
                                                    <input type="hidden" name="exchange_rate" id="exchange_rate">
                                                    <input type="hidden" name="grand_total_pkr" id="grand_total_pkr_hidden">
                                                    <input type="hidden" name="advance_amount_pkr" id="advance_amount_pkr_hidden">
                                                    <input type="hidden" name="balance_amount_pkr" id="balance_amount_pkr_hidden">
                                                    <input type="hidden" name="grand_total" id="grand_total_hidden">
                                                    <input type="hidden" name="grand_total_pkr" id="grand_total_pkr_hidden">
                                                    <input type="hidden" name="advance_amount" id="advance_amount_hidden">
                                                    <input type="hidden" name="advance_amount_pkr" id="advance_amount_pkr_hidden">
                                                    <input type="hidden" name="balance_amount" id="balance_amount_hidden">
                                                    <input type="hidden" name="balance_amount_pkr" id="balance_amount_pkr_hidden">
                                                    
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <button type="submit" class="btn btn-success">Submit</button>
                                                            <button type="reset" class="btn btn-danger">Clear Form</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

<div class="loader-overlay" id="loaderOverlay">
    <div style="text-align: center;">
        <div class="loader-spinner"></div>
        <div class="loader-text" id="loaderText">Loading...</div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Load loadings
    loadLoadings();
    
    // When loading is selected
    $('#loading_id').on('change', function() {
        var loadingId = $(this).val();
        if (loadingId) {
            loadLoadingDetails(loadingId);
        } else {
            $('#commercialInvoiceDetails').hide();
        }
    });
    
    // Form submission
    $('#commercialInvoiceForm').on('submit', function(e) {
        e.preventDefault();
        submitCommercialInvoice();
    });
});

function loadLoadings() {
    $.ajax({
        url: '{{ url("/export/getLoadingsForCommercialInvoice") }}',
        type: 'GET',
        success: function(response) {
            $('#loading_id').html('<option value="">Select Loading No</option>');
            $.each(response, function(index, loading) {
                $('#loading_id').append(
                    '<option value="' + loading.id + '">' + (loading.loading_no || 'Loading #' + loading.id) + '</option>'
                );
            });
            $('#loading_id').select2();
        },
        error: function() {
            alert('Error loading loadings');
        }
    });
}

function loadLoadingDetails(loadingId) {
    // Show loader and disable submit button
    $('#loaderOverlay').addClass('active');
    $('#loaderText').text('Loading Commercial Invoice Details...');
    $('button[type="submit"]').prop('disabled', true);
    
    $.ajax({
        url: '{{ url("/export/getLoadingDetailsForCommercialInvoice") }}',
        type: 'GET',
        data: { loading_id: loadingId },
        success: function(response) {
            // Hide loader and enable submit button
            $('#loaderOverlay').removeClass('active');
            $('button[type="submit"]').prop('disabled', false);
            if (response.loading && response.sale_order) {
                // Show commercial invoice details section
                $('#commercialInvoiceDetails').show();
                
                // Set IDs
                $('#contract_loading_id').val(response.loading.id);
                $('#sale_order_export_id').val(response.sale_order.id);
                $('#currency_id').val(response.sale_order.currency_id);
                $('#exchange_rate').val(response.sale_order.currencey_rate || 1);
                
                // Populate containers
                var containersHtml = '';
                if (response.containers && response.containers.length > 0) {
                    response.containers.forEach(function(container, index) {
                        containersHtml += '<tr>';
                        containersHtml += '<td style="padding: 5px; text-align: center; font-size: 11px;">' + (index + 1) + '</td>';
                        containersHtml += '<td style="padding: 5px; text-align: center; font-size: 11px;">' + (container.item_id || '-') + '</td>';
                        containersHtml += '<td style="padding: 5px; text-align: center; font-size: 11px;">' + (container.container_no || '-') + '</td>';
                        containersHtml += '<td style="padding: 5px; text-align: center; font-size: 11px;">' + (container.vehicle_no || '-') + '</td>';
                        containersHtml += '<td style="padding: 5px; text-align: center; font-size: 11px;">' + (container.seal_no || '-') + '</td>';
                        containersHtml += '<td style="padding: 5px; text-align: center; font-size: 11px;">' + (container.quantity || '-') + '</td>';
                        containersHtml += '</tr>';
    
                    });
                    $('#containers_table_body').html(containersHtml);
                } else {
                    $('#containers_table_body').html('<tr><td colspan="6" style="text-align: center; padding: 5px;">No containers</td></tr>');
                }
                
                // Populate invoice details
                $('#consignee_name').val(response.sale_order.consignee_name || '');
                $('#payment_term').val(response.sale_order.mode_of_term_name); // Consignees table only has name, not address
                $('#port_from').val(response.sale_order.port_name || '');
                $('#port_to').val(''); // Only one port column exists
                
                // Populate product table
                if (response.sale_order_data && response.sale_order_data.length > 0) {
                    // Pass all relevant amounts including remaining amount and existing invoice info
                    populateProductTable(
                        response.sale_order_data, 
                        response.total_amount, 
                        response.advance_amount,
                        response.balance_amount_pkr,
                        response.sale_order.currency_name || 'USD',
                        response.sale_order.currencey_rate || 1
                    );
                } else {
                    console.error('No sale order data received:', response);
                    alert('No product data found for this loading');
                }
            } else {
                console.error('Invalid response:', response);
                alert('Error loading loading details');
            }
        },
        error: function(xhr, status, error) {
            // Hide loader and enable submit button
            $('#loaderOverlay').removeClass('active');
            $('button[type="submit"]').prop('disabled', false);
            console.error('AJAX Error:', xhr, status, error);
            alert('Error loading loading details: ' + error);
        }
    });
}

function populateProductTable(saleOrderData, totalAmount, advanceAmountPKR, balance_amount_pkr, currencyName, exchangeRate) {
    console.log('populateProductTable called with:', saleOrderData); // Debug
    var tbody = $('#productTableBody');
    tbody.empty();
    
    if (!saleOrderData || saleOrderData.length === 0) {
        console.error('No sale order data provided to populateProductTable');
        tbody.append('<tr><td colspan="7" style="text-align:center;padding:20px;">No products found</td></tr>');
        return;
    }
    
    // Advance amount is already in PKR from transaction table (no conversion needed)
    var advanceAmountPKRNum = parseFloat(advanceAmountPKR) || 0; // Already in PKR

    // Get currency symbol
    var currencyNameStr = currencyName || 'USD';
    var currencySymbol = '$'; // Default
    var currencyCode = currencyNameStr.toUpperCase();
    var currencySymbols = {
        'USD': '$',
        'EUR': '€',
        'GBP': '£',
        'PKR': 'PKR ',
        'AED': 'AED ',
        'SAR': 'SAR ',
    };
    if (currencySymbols[currencyCode]) {
        currencySymbol = currencySymbols[currencyCode];
    } else {
        currencySymbol = currencyCode + ' ';
    }
    
    var totalCartons = 0;
    var totalNetKgs = 0;
    var grandTotal = 0;
    var items = [];
    
    $.each(saleOrderData, function(index, item) {
        // Use description and grade_size from backend if available, otherwise construct them
        var description = item.description || (item.item_name || '-');
        var gradeSize = item.grade_size || ((item.item_size || '') + (item.quality ? '-' + item.quality : ''));
        
        // Use loading_qty (partial qty from loading form) instead of actual_qty
        var loadingQty = parseFloat(item.loading_qty) || parseFloat(item.actual_qty) || 0;
        
        // Calculate cartons: if pack_size is the weight per carton, then cartons = loading_qty / pack_size
        var packSize = parseFloat(item.pack_size) || 1;
        
        // For commercial invoice: Total Net Kgs should be loading_qty (partial qty from loading)
        // Cartons calculation depends on pack_size meaning
        // Assuming pack_size is kgs per carton
        var cartons = packSize > 0 ? Math.ceil(loadingQty / packSize) : 0;
        var netKgs = loadingQty; // loading_qty is the net weight in kgs from loading
        var ratePerKg = parseFloat(item.rate) || 0;
        var amount = parseFloat(item.amount) || (loadingQty * ratePerKg); // Amount based on loading qty
        
        totalCartons += cartons;
        totalNetKgs += netKgs;
       
        
        var row = '<tr>' +
            '<td style="border:1px solid;padding:8px;">' + (index + 1) + '</td>' +
            '<td style="border:1px solid;padding:8px;text-align:left;">' + description + '</td>' +
            '<td style="border:1px solid;padding:8px;">' + gradeSize + '</td>' +
            '<td style="border:1px solid;padding:8px;">' + cartons + '</td>' +
            '<td style="border:1px solid;padding:8px;">' + netKgs.toFixed(2) + '</td>' +
            '<td style="border:1px solid;padding:8px;">' + ratePerKg.toFixed(2) + '</td>' +
            '<td style="border:1px solid;padding:8px;text-align:right;">' + currencySymbol + ' ' + amount.toFixed(2) + '</td>' +
            '</tr>';
        tbody.append(row);
        
        items.push({
            sale_order_data_export_id: item.id,
            item_id: item.item_id,
            description: description,
            grade_size: gradeSize,
            total_cartons: cartons,
            total_net_kgs: netKgs,
            rate_cfr_per_kg: ratePerKg,
            amount_usd: amount
        });
    });
    
    // Get exchange rate
    var exchangeRateNum = parseFloat(exchangeRate) || parseFloat($('#exchange_rate').val()) || 1;
    
    grandTotal = totalAmount;
    // Always show the actual grand total (not remaining amount) for display
    // But use remaining amount for balance calculation if invoice exists
    var grandTotalPKR = grandTotal * exchangeRateNum;
    
    // Convert advance amount from PKR to selected currency
    var advanceAmountInCurrency = exchangeRateNum > 0 ? (advanceAmountPKRNum / exchangeRateNum) : 0;
    
    // Convert balance amount from PKR to selected currency
    var balanceAmountInCurrency = exchangeRateNum > 0 ? (balance_amount_pkr / exchangeRateNum) : 0;
    
    // Update totals - always show actual grand total
    $('#total_cartons').text(totalCartons);
    $('#total_net_kgs').text(totalNetKgs.toFixed(2));
    $('#grand_total').text(currencySymbol + ' ' + grandTotal.toFixed(2));
    $('#display_grand_total').text(currencySymbol + ' ' + grandTotal.toFixed(2));
    
    // Display amounts in selected currency only
    $('#display_advance_amount').text(currencySymbol + ' ' + advanceAmountInCurrency.toFixed(2));
    $('#display_balance_amount').text(currencySymbol + ' ' + balanceAmountInCurrency.toFixed(2));
    
    // Set hidden fields (store PKR amounts for transactions - backend needs PKR)
    // For grand total, use actual grand total (not remaining)
    // For advance, store PKR amount for backend processing
    $('#grand_total_hidden').val(grandTotal);
    $('#grand_total_pkr_hidden').val(grandTotalPKR);
    $('#advance_amount_hidden').val(advanceAmountInCurrency); // Store PKR for backend
    $('#advance_amount_pkr_hidden').val(advanceAmountPKRNum);
    $('#balance_amount_hidden').val(balanceAmountInCurrency); // Store in selected currency
    $('#balance_amount_pkr_hidden').val(balance_amount_pkr); // Store PKR for backend
    
    // Store items for submission
    $('#commercialInvoiceForm').data('items', items);
}

function submitCommercialInvoice() {
    // Show loader and disable submit button
    $('#loaderOverlay').addClass('active');
    $('#loaderText').text('Submitting Commercial Invoice...');
    $('button[type="submit"]').prop('disabled', true);
    
    var formData = {
        contract_loading_id: $('#contract_loading_id').val(),
        sale_order_export_id: $('#sale_order_export_id').val(),
        invoice_no: $('#invoice_no').val(),
        invoice_date: $('#invoice_date').val(),
        gd_no: $('#gd_no').val(),
        container_no: $('#container_no').val(),
        consignee_name: $('#consignee_name').val(),
        consignee_address: $('#consignee_address').val(),
        vessel_voyage: $('#vessel_voyage').val(),
        port_from: $('#port_from').val(),
        port_to: $('#port_to').val(),
        payment_term: $('#payment_term').val(),
        grand_total: $('#grand_total_hidden').val(),
        grand_total_pkr: $('#grand_total_pkr_hidden').val(),
        advance_amount: $('#advance_amount_hidden').val(),
        advance_amount_pkr: $('#advance_amount_pkr_hidden').val(),
        balance_amount: $('#balance_amount_hidden').val(),
        balance_amount_pkr: $('#balance_amount_pkr_hidden').val(),
        currency_id: $('#currency_id').val(),
        exchange_rate: $('#exchange_rate').val(),
        items: $('#commercialInvoiceForm').data('items') || []
    };
    
    $.ajax({
        url: '{{ url("/export/storeCommercialInvoice") }}',
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // Hide loader and enable submit button
            $('#loaderOverlay').removeClass('active');
            $('button[type="submit"]').prop('disabled', false);
            
            if (response.success) {
                alert('Commercial invoice created successfully');
                $('#commercialInvoiceForm')[0].reset();
                $('#commercialInvoiceDetails').hide();
                $('#loading_id').val('').trigger('change');
                loadLoadings();
                // Update invoice no after successful submission
                $('#invoice_no').val('{{ strtoupper(SalesHelper::get_unique_commercial_invoice_no()) }}');
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr) {
            // Hide loader and enable submit button
            $('#loaderOverlay').removeClass('active');
            $('button[type="submit"]').prop('disabled', false);
            
            var errorMsg = 'Error saving commercial invoice';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            alert(errorMsg);
        }
    });
}
</script>

@endsection

