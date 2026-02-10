<?php
use App\Helpers\CommonHelper;
use App\Helpers\SalesHelper;
$m = Session::get('run_company');
$isEdit = isset($packingList) && $packingList;
?>
@extends('layouts.default')
@section('content')
@include('select2')

<style>
    .table-responsive {
        max-height: 600px;
        overflow-y: auto;
        overflow-x: auto;
        border: 1px solid #ddd;
        width: 100%;
        margin-top: 20px;
    }
    
    .table-responsive table {
        min-width: 1200px;
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
    
    .packing-list-details {
        display: none;
    }
    
    .form-action-buttons {
        display: none;
    }
    
    .form-section {
        margin-bottom: 25px;
    }
    
    .form-section-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 8px;
    }
    
    .form-group-custom {
        margin-bottom: 20px;
    }
    
    .form-group-custom label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #555;
    }
    
    .rflabelsteric {
        color: red;
    }
    
    .form-control-custom {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }
    
    .form-control-custom:focus {
        border-color: #4CAF50;
        outline: none;
        box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
    }
</style>

<div class="well_N">
    <div class="dp_sdw">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="well">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span class="subHeadingLabelClass">Packing List</span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            
                            <form id="packingListForm">
                                <input type="hidden" name="id" id="packing_list_id" value="{{ $isEdit ? $packingList->id : '' }}">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <label>Select Commercial Invoice No <span class="rflabelsteric"><strong>*</strong></span></label>
                                                        <select class="form-control select2" name="commercial_invoice_id" id="commercial_invoice_id" required {{ $isEdit ? 'disabled' : '' }}>
                                                            <option value="">Select Commercial Invoice No</option>
                                                        </select>
                                                        @if($isEdit)
                                                            <input type="hidden" name="commercial_invoice_id" value="{{ $packingList->commercial_invoice_id }}">
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div id="packingListDetails" class="packing-list-details">
                                                    <div class="lineHeight">&nbsp;</div>
                                                    
                                                    {{-- Packing List Details Section --}}
                                                    <div class="form-section">
                                                        <div class="form-section-title">Packing List Details</div>
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                                <div class="form-group-custom">
                                                                    <label>Invoice No</label>
                                                                    <input type="text" class="form-control form-control-custom" name="invoice_no" id="invoice_no" readonly style="background-color: #f5f5f5;" value="{{ $isEdit ? $packingList->invoice_no : '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                                <div class="form-group-custom">
                                                                    <label>Date <span class="rflabelsteric"><strong>*</strong></span></label>
                                                                    <input type="date" class="form-control form-control-custom" name="date" id="date" value="{{ $isEdit ? $packingList->date : date('Y-m-d') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                                <div class="form-group-custom">
                                                                    <label>GD NO</label>
                                                                    <input type="text" class="form-control form-control-custom" name="gd_no" id="gd_no" value="{{ $isEdit ? $packingList->gd_no : '' }}" placeholder="GD NO" readonly style="background-color: #f5f5f5;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <div class="form-group-custom">
                                                                    <label>Consignee Name</label>
                                                                    <input type="text" class="form-control form-control-custom" name="consignee_name" id="consignee_name" value="{{ $isEdit ? $packingList->consignee_name : '' }}" placeholder="Enter Consignee Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                                <div class="form-group-custom">
                                                                    <label>From</label>
                                                                    <input type="text" class="form-control form-control-custom" name="port_from" id="port_from" value="{{ $isEdit ? $packingList->port_from : '' }}" placeholder="Enter Port From">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                                <div class="form-group-custom">
                                                                    <label>Vessel/Voyage</label>
                                                                    <input type="text" class="form-control form-control-custom" name="vessel_voyage" id="vessel_voyage" value="{{ $isEdit ? $packingList->vessel_voyage : '' }}" placeholder="Enter Vessel/Voyage">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                                <div class="form-group-custom">
                                                                    <label>Payment Term</label>
                                                                    <input type="text" class="form-control form-control-custom" name="payment_term" id="payment_term" value="{{ $isEdit ? $packingList->payment_term : '' }}" placeholder="Enter Payment Term">
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
                                                                                    <th style="border:1px solid;padding:8px;position:sticky;top:0;background:#f0f0f0;z-index:10;">S.No</th>
                                                                                    <th style="border:1px solid;padding:8px;position:sticky;top:0;background:#f0f0f0;z-index:10;">Descriptions of Product</th>
                                                                                    <th style="border:1px solid;padding:8px;position:sticky;top:0;background:#f0f0f0;z-index:10;">Grade / Size</th>
                                                                                    <th style="border:1px solid;padding:8px;position:sticky;top:0;background:#f0f0f0;z-index:10;">Total Cartons</th>
                                                                                    <th style="border:1px solid;padding:8px;position:sticky;top:0;background:#f0f0f0;z-index:10;">Total Net Kgs</th>
                                                                                    <th style="border:1px solid;padding:8px;position:sticky;top:0;background:#f0f0f0;z-index:10;">Total Gross Kgs <span class="rflabelsteric"><strong>*</strong></span></th>
                                                                                    <th style="border:1px solid;padding:8px;position:sticky;top:0;background:#f0f0f0;z-index:10;">Container No</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="productTableBody">
                                                                                <!-- Products will be populated here -->
                                                                            </tbody>
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <td colspan="3" style="border:1px solid;padding:8px;text-align:right;font-weight:bold;">Grand Total:-</td>
                                                                                    <td style="border:1px solid;padding:8px;text-align:center;font-weight:bold;" id="total_cartons">0</td>
                                                                                    <td style="border:1px solid;padding:8px;text-align:right;font-weight:bold;" id="total_net_kgs">0.00</td>
                                                                                    <td style="border:1px solid;padding:8px;text-align:right;font-weight:bold;" id="total_gross_kgs">0.00</td>
                                                                                    <td style="border:1px solid;padding:8px;"></td>
                                                                                </tr>
                                                                            </tfoot>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="lineHeight">&nbsp;</div>
                                                    
                                                    <div class="row form-action-buttons">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <button type="submit" class="btn btn-success">{{ $isEdit ? 'Update' : 'Submit' }}</button>
                                                            <button type="reset" class="btn btn-danger">Clear Form</button>
                                                            <a href="{{ url('/export/packingListList') }}" class="btn btn-info">Back to List</a>
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

<script>
$(document).ready(function() {
    // Load commercial invoices
    loadCommercialInvoices();
    
    @if($isEdit)
        // If editing, populate form with existing data
        setTimeout(function() {
            $('#commercial_invoice_id').val('{{ $packingList->commercial_invoice_id }}').trigger('change');
            $('#packingListDetails').show();
            $('.form-action-buttons').show();
            populateProductTableForEdit(@json($packingList->packingListData));
        }, 500);
    @endif
    
    // When commercial invoice is selected
    $('#commercial_invoice_id').on('change', function() {
        var commercialInvoiceId = $(this).val();
        if (commercialInvoiceId) {
            loadCommercialInvoiceDetails(commercialInvoiceId);
        } else {
            $('#packingListDetails').hide();
            $('#productTableBody').empty();
            $('.form-action-buttons').hide();
        }
    });
    
    // Form submission
    $('#packingListForm').on('submit', function(e) {
        e.preventDefault();
        submitPackingList();
    });

    // Calculate totals when gross weight is entered per item
    $(document).on('input', '.gross-kgs-input', function() {
        calculateTotals();
    });
});

function loadCommercialInvoices() {
    $.ajax({
        url: '{{ url("/export/getCommercialInvoicesForPackingList") }}',
        type: 'GET',
        success: function(response) {
            $('#commercial_invoice_id').html('<option value="">Select Commercial Invoice No</option>');
            $.each(response, function(index, invoice) {
                var dateStr = invoice.invoice_date ? new Date(invoice.invoice_date).toLocaleDateString('en-GB') : '';
                $('#commercial_invoice_id').append(
                    '<option value="' + invoice.id + '">' + invoice.invoice_no + (dateStr ? ' (' + dateStr + ')' : '') + '</option>'
                );
            });
            $('#commercial_invoice_id').select2();
        },
        error: function() {
            alert('Error loading commercial invoices');
        }
    });
}

function loadCommercialInvoiceDetails(commercialInvoiceId) {
    $.ajax({
        url: '{{ url("/export/getCommercialInvoiceDetailsForPackingList") }}',
        type: 'GET',
        data: { commercial_invoice_id: commercialInvoiceId },
        success: function(response) {
            if (response.commercial_invoice && response.invoice_data) {
                // Show packing list details section
                $('#packingListDetails').show();
                
                // Show action buttons
                $('.form-action-buttons').show();
                
                // Populate invoice details
                $('#invoice_no').val(response.commercial_invoice.invoice_no || '');
                $('#gd_no').val(response.commercial_invoice.gd_no || '');
                $('#consignee_name').val(response.commercial_invoice.consignee_name || '');
                $('#vessel_voyage').val(response.commercial_invoice.vessel_voyage || '');
                $('#port_from').val(response.commercial_invoice.port_from || '');
                $('#payment_term').val(response.commercial_invoice.payment_term || '');
                
                // Populate product table with container data
                populateProductTable(response.invoice_data, response.containers_by_item || {});
            } else {
                alert('Error loading commercial invoice details');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', xhr, status, error);
            alert('Error loading commercial invoice details: ' + error);
        }
    });
}

function populateProductTable(invoiceData, containersByItem) {
    var tbody = $('#productTableBody');
    tbody.empty();
    
    if (!invoiceData || invoiceData.length === 0) {
        tbody.append('<tr><td colspan="7" style="text-align:center;padding:20px;">No products found</td></tr>');
        return;
    }
    
    var totalCartons = 0;
    var totalNetKgs = 0;
    var totalGrossKgs = 0;
    var items = [];
    var rowCounter = 0;
    
    $.each(invoiceData, function(index, item) {
        var description = item.description || (item.item_name || '-');
        var gradeSize = item.grade_size || '-';
        var cartons = parseInt(item.total_cartons) || 0;
        var netKgs = parseFloat(item.total_net_kgs) || 0;
        var grossKgs = netKgs; // Default to net kgs, user can edit
        
        totalCartons += cartons;
        totalNetKgs += netKgs;
        totalGrossKgs += grossKgs;
        
        // Get container numbers for this item (combine all container nos)
        // Handle both string and integer item_id matching
        var itemId = item.item_id;
        var itemContainers = containersByItem[itemId] || containersByItem[String(itemId)] || containersByItem[parseInt(itemId)] || [];
        var containerNos = [];
        if (itemContainers && itemContainers.length > 0) {
            $.each(itemContainers, function(containerIndex, container) {
                if (container && container.container_no) {
                    containerNos.push(container.container_no);
                }
            });
        }
        var containerNoDisplay = containerNos.length > 0 ? containerNos.join(', ') : '-';
        
        var row = '<tr>' +
            '<td style="border:1px solid;padding:8px;">' + (index + 1) + '</td>' +
            '<td style="border:1px solid;padding:8px;text-align:left;">' + description + '</td>' +
            '<td style="border:1px solid;padding:8px;">' + gradeSize + '</td>' +
            '<td style="border:1px solid;padding:8px;">' + cartons + '</td>' +
            '<td style="border:1px solid;padding:8px;">' + netKgs.toFixed(2) + '</td>' +
            '<td style="border:1px solid;padding:8px;">' +
                '<input type="number" class="form-control gross-kgs-input" step="0.01" min="0" value="' + grossKgs.toFixed(2) + '" data-index="' + index + '" style="width:100%;" required>' +
            '</td>' +
            '<td style="border:1px solid;padding:8px;">' + containerNoDisplay + '</td>' +
            '</tr>';
        tbody.append(row);
        
        items.push({
            commercial_invoice_data_id: item.id,
            item_id: item.item_id,
            description: description,
            grade_size: gradeSize,
            total_cartons: cartons,
            total_net_kgs: netKgs,
            total_gross_kgs: grossKgs
        });
    });
    
    // Update totals
    $('#total_cartons').text(totalCartons);
    $('#total_net_kgs').text(totalNetKgs.toFixed(2));
    $('#total_gross_kgs').text(totalGrossKgs.toFixed(2));
    
    // Store items for submission
    $('#packingListForm').data('items', items);
}

function populateProductTableForEdit(packingListData) {
    var tbody = $('#productTableBody');
    tbody.empty();
    
    if (!packingListData || packingListData.length === 0) {
        tbody.append('<tr><td colspan="7" style="text-align:center;padding:20px;">No products found</td></tr>');
        return;
    }
    
    var totalCartons = 0;
    var totalNetKgs = 0;
    var totalGrossKgs = 0;
    var items = [];
    
    // Get containers from commercial invoice for edit mode
    var commercialInvoiceId = $('input[name="commercial_invoice_id"]').val() || $('#commercial_invoice_id').val();
    var containersByItem = {};
    
    // Load container data if available
    if (commercialInvoiceId) {
        $.ajax({
            url: '{{ url("/export/getCommercialInvoiceDetailsForPackingList") }}',
            type: 'GET',
            data: { commercial_invoice_id: commercialInvoiceId },
            async: false,
            success: function(response) {
                containersByItem = response.containers_by_item || {};
            }
        });
    }
    
    $.each(packingListData, function(index, item) {
        var description = item.description || '-';
        var gradeSize = item.grade_size || '-';
        var cartons = parseInt(item.total_cartons) || 0;
        var netKgs = parseFloat(item.total_net_kgs) || 0;
        var grossKgs = parseFloat(item.total_gross_kgs) || netKgs;
        
        totalCartons += cartons;
        totalNetKgs += netKgs;
        totalGrossKgs += grossKgs;
        
        // Get container numbers for this item (combine all container nos)
        // Handle both string and integer item_id matching
        var itemId = item.item_id;
        var itemContainers = containersByItem[itemId] || containersByItem[String(itemId)] || containersByItem[parseInt(itemId)] || [];
        var containerNos = [];
        if (itemContainers && itemContainers.length > 0) {
            $.each(itemContainers, function(containerIndex, container) {
                if (container && container.container_no) {
                    containerNos.push(container.container_no);
                }
            });
        }
        var containerNoDisplay = containerNos.length > 0 ? containerNos.join(', ') : '-';
        
        var row = '<tr>' +
            '<td style="border:1px solid;padding:8px;">' + (index + 1) + '</td>' +
            '<td style="border:1px solid;padding:8px;text-align:left;">' + description + '</td>' +
            '<td style="border:1px solid;padding:8px;">' + gradeSize + '</td>' +
            '<td style="border:1px solid;padding:8px;">' + cartons + '</td>' +
            '<td style="border:1px solid;padding:8px;">' + netKgs.toFixed(2) + '</td>' +
            '<td style="border:1px solid;padding:8px;">' +
                '<input type="number" class="form-control gross-kgs-input" step="0.01" min="0" value="' + grossKgs.toFixed(2) + '" data-index="' + index + '" style="width:100%;" required>' +
            '</td>' +
            '<td style="border:1px solid;padding:8px;">' + containerNoDisplay + '</td>' +
            '</tr>';
        tbody.append(row);
        
        items.push({
            commercial_invoice_data_id: item.commercial_invoice_data_id,
            item_id: item.item_id,
            description: description,
            grade_size: gradeSize,
            total_cartons: cartons,
            total_net_kgs: netKgs,
            total_gross_kgs: grossKgs
        });
    });
    
    // Update totals
    $('#total_cartons').text(totalCartons);
    $('#total_net_kgs').text(totalNetKgs.toFixed(2));
    $('#total_gross_kgs').text(totalGrossKgs.toFixed(2));
    
    // Store items for submission
    $('#packingListForm').data('items', items);
}

function calculateTotals() {
    var totalGrossKgs = 0;
    var items = $('#packingListForm').data('items') || [];
    
    $('.gross-kgs-input').each(function() {
        var value = parseFloat($(this).val()) || 0;
        totalGrossKgs += value;
        
        // Update item in array
        var index = $(this).data('index');
        if (items[index]) {
            items[index].total_gross_kgs = value;
        }
    });
    
    $('#total_gross_kgs').text(totalGrossKgs.toFixed(2));
    $('#packingListForm').data('items', items);
}

function submitPackingList() {
    var items = $('#packingListForm').data('items') || [];
    
    // Update items with current gross kgs values
    $('.gross-kgs-input').each(function() {
        var index = $(this).data('index');
        if (items[index]) {
            items[index].total_gross_kgs = parseFloat($(this).val()) || 0;
        }
    });
    
    // Calculate total gross weight from items
    var totalGrossWeight = 0;
    $.each(items, function(index, item) {
        totalGrossWeight += parseFloat(item.total_gross_kgs) || 0;
    });
    
    var formData = {
        id: $('#packing_list_id').val(),
        commercial_invoice_id: $('#commercial_invoice_id').val() || $('input[name="commercial_invoice_id"]').val(),
        invoice_no: $('#invoice_no').val(),
        date: $('#date').val(),
        gd_no: $('#gd_no').val(),
        consignee_name: $('#consignee_name').val(),
        vessel_voyage: $('#vessel_voyage').val(),
        port_from: $('#port_from').val(),
        payment_term: $('#payment_term').val(),
        gross_weight: totalGrossWeight,
        items: items
    };
    
    var url = formData.id ? '{{ url("/export/updatePackingList") }}' : '{{ url("/export/storePackingList") }}';
    
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                alert(formData.id ? 'Packing list updated successfully' : 'Packing list created successfully');
                window.location.href = '{{ url("/export/packingListList") }}';
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr) {
            var errorMsg = 'Error saving packing list';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                var errors = Object.values(xhr.responseJSON.errors).flat();
                errorMsg = errors.join(', ');
            }
            alert(errorMsg);
        }
    });
}
</script>

@endsection
