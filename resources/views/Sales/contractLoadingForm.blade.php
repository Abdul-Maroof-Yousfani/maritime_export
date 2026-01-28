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
    
    .export-order-details {
        display: none;
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
                                    <span class="subHeadingLabelClass">Contract Loading</span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            
                            <form id="contractLoadingForm">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <label>Select Order No <span class="rflabelsteric"><strong>*</strong></span></label>
                                                        <select class="form-control select2" name="order_no" id="order_no" required>
                                                            <option value="">Select Order No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div id="exportOrderDetails" class="export-order-details">
                                                    <div class="lineHeight">&nbsp;</div>
                                                    
                                                    {{-- Master Details Section --}}
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="panel">
                                                                <div class="panel-body">
                                                                    <h4 style="text-align: center; margin-bottom: 15px;"><u><b>MASTER DETAILS</b></u></h4>
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th style="width:25%;border:1px solid;padding:8px;">Loading No</th>
                                                                                    <td style="width:25%;border:1px solid;padding:8px;">
                                                                                        <input type="text" class="form-control" id="master_loading_no" readonly style="background-color: #f5f5f5;" value="{{ strtoupper(SalesHelper::get_unique_loading_no()) }}">
                                                                                    </td>
                                                                                    <th style="width:25%;border:1px solid;padding:8px;">Order No</th>
                                                                                    <td style="width:25%;border:1px solid;padding:8px;">
                                                                                        <input type="text" class="form-control" id="master_order_no" readonly style="background-color: #f5f5f5;">
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th style="width:25%;border:1px solid;padding:8px;">FORME No</th>
                                                                                    <td style="width:25%;border:1px solid;padding:8px;">
                                                                                        <input type="text" class="form-control" id="forme_no" style="background-color: #f5f5f5;">
                                                                                    </td>
                                                                                    <th style="width:25%;border:1px solid;padding:8px;">Buyer Name</th>
                                                                                    <td style="width:25%;border:1px solid;padding:8px;" id="master_buyer_name">-</td>
                                                                                   
                                                                                </tr>
                                                                                <tr>
                                                                                    <th style="width:25%;border:1px solid;padding:8px;">Port</th>
                                                                                    <td style="width:25%;border:1px solid;padding:8px;">
                                                                                        <input type="text" class="form-control" id="master_port" readonly style="background-color: #f5f5f5;">
                                                                                    </td>
                                                                                    <th style="border:1px solid;padding:8px;">Origin</th>
                                                                                    <td style="border:1px solid;padding:8px;" id="master_origin">-</td>
                                                                                   
                                                                                </tr>
                                                                                <tr>
                                                                                    <th style="border:1px solid;padding:8px;">Total Amount</th>
                                                                                    <td style="border:1px solid;padding:8px;">
                                                                                        <input type="text" class="form-control" id="master_total_amount" readonly style="background-color: #f5f5f5; text-align: right;">
                                                                                    </td>
                                                                                    <th style="border:1px solid;padding:8px;">Total Amount in PKR</th>
                                                                                    <td style="border:1px solid;padding:8px;">
                                                                                        <input type="text" class="form-control" id="master_total_amount_pkr" readonly style="background-color: #f5f5f5; text-align: right;">
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="lineHeight">&nbsp;</div>
                                                    
                                                    {{-- Loading Details --}}
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <label>Loading Date <span class="rflabelsteric"><strong>*</strong></span></label>
                                                            <input type="date" class="form-control" name="loading_date" id="loading_date" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="lineHeight">&nbsp;</div>
                                                    
                                                 
                                                    
                                                    <div class="lineHeight">&nbsp;</div>
                                                    
                                                    
                                                    {{-- Items Table --}}
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>S.No</th>
                                                                            <th>Layer</th>
                                                                            <th>Item Name</th>
                                                                            <th>Size</th>
                                                                            <th>Quality</th>
                                                                            <th>Total Qty</th>
                                                                            <th>Previous Sent Qty</th>
                                                                            <th>Final Qty</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="exportOrderItems">
                                                                        <!-- Items will be populated here -->
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- Containers Table --}}
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="panel">
                                                                <div class="panel-body">
                                                                    <h4 style="text-align: center; margin-bottom: 15px;"><u><b>CONTAINERS & VEHICLES DETAIL</b></u></h4>
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered" id="containersTable">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th colspan="6"></th>
                                                                                    <th >
                                                                                         <button type="button" class="btn btn-sm btn-success" onclick="addContainerVehicleRow()" style="margin-top: 10px;">
                                                                                            <i class="fa fa-plus"></i> Add Container & Vehicle
                                                                                        </button>
                                                                                    </th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th style="border:1px solid;padding:8px;">S.No</th>
                                                                                    <th style="border:1px solid;padding:8px;">Item</th>
                                                                                    <th style="border:1px solid;padding:8px;">Container No</th>
                                                                                    <th style="border:1px solid;padding:8px;">Vehicle No</th>
                                                                                    <th style="border:1px solid;padding:8px;">Seal No</th>
                                                                                    <th style="border:1px solid;padding:8px;">Quantity</th>
                                                                                    <th style="border:1px solid;padding:8px;text-align:center;">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="containersTableBody">
                                                                                <!-- Containers will be added here -->
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="lineHeight">&nbsp;</div>
                                                    
                                                    <div class="lineHeight">&nbsp;</div>
                                                    
                                                    {{-- Attachments Section --}}
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <label>Attachments</label>
                                                            <input type="file" class="form-control" name="attachments[]" id="attachments" 
                                                                multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif" />
                                                            <small class="text-muted">You can select multiple files (PDF, DOC, XLS, Images)</small>
                                                            <div id="attachmentPreview" class="mt-2"></div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="lineHeight">&nbsp;</div>
                                                    
                                                    <input type="hidden" name="sale_order_export_id" id="sale_order_export_id">
                                                    
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



<script>
$(document).ready(function() {
    // Load approved contracts
    loadApprovedContracts();
    
    // Set today's date as default loading date
    var today = new Date().toISOString().split('T')[0];
    $('#loading_date').val(today);
    
    // When order no is selected
    $('#order_no').on('change', function() {
        var orderNo = $(this).val();
        if (orderNo) {
            loadExportOrderByOrderNo(orderNo);
        } else {
            $('#exportOrderDetails').hide();
        }
    });
    
    // Form submission
    $('#contractLoadingForm').on('submit', function(e) {
        e.preventDefault();
        submitContractLoading();
    });
});

function loadApprovedContracts() {
    $.ajax({
        url: '{{ url("/export/getApprovedContracts") }}',
        type: 'GET',
        success: function(response) {
            $('#order_no').html('<option value="">Select Order No</option>');
            $.each(response, function(index, contract) {
                var displayText = (contract.voucehr_no || '') + (contract.contract_no ? ' - ' + contract.contract_no : '');
                $('#order_no').append(
                    '<option value="' + (contract.voucehr_no || '') + '" data-contract-no="' + (contract.contract_no || '') + '">' + displayText + '</option>'
                );
            });
            $('#order_no').select2();
        },
        error: function() {
            alert('Error loading contracts');
        }
    });
}
let saleOrderItems = [];
function loadExportOrderByOrderNo(orderNo) {
    $.ajax({
        url: '{{ url("/export/getExportOrderByOrderNo") }}',
        type: 'GET',
        data: { order_no: orderNo },
        success: function(response) {
            if (response.sale_order) {
                // Show export order details section
                $('#exportOrderDetails').show();
                
                // Set sale order export ID
                $('#sale_order_export_id').val(response.sale_order.id);
                
                // Populate master details
                $('#master_order_no').val(response.sale_order.voucehr_no || '-');
                $('#master_buyer_name').text(response.sale_order.name || '-');
                $('#master_port').val(response.sale_order.port_name || '-');
                $('#master_origin').text(response.sale_order.origin_name || '-');
                
                // Populate total amounts
                var currencyName = response.sale_order.currency_name || '';
                var totalAmount = parseFloat(response.total_amount || 0);
                var totalAmountPKR = parseFloat(response.total_amount_pkr || 0);
                
                $('#master_total_amount').val(totalAmount.toFixed(2) + ' ' + currencyName);
                $('#master_total_amount_pkr').val(totalAmountPKR.toFixed(2) + ' PKR');
                
                // Populate items table
                var itemsHtml = '';
                if (response.sale_order_data && response.sale_order_data.length > 0) {
                    saleOrderItems = response.sale_order_data || [];
                    addContainerVehicleRow();
                    $.each(response.sale_order_data, function(index, item) {
                        var itemName = item.item_name || '-';
                        var itemSize = item.item_size || '-';
                        var quality = item.quality || '-';
                        var totalQty = parseFloat(item.total_qty) || 0; // Original order qty
                        var previousSentQty = parseFloat(item.previous_sent_qty) || 0; // Already loaded qty
                        var remainingQty = parseFloat(item.remaining_qty) || 0; // Remaining qty (total - previous sent)
                        
                        itemsHtml += '<tr>';
                        itemsHtml += '<td>' + (index + 1) + '</td>';
                        itemsHtml += '<td><input type="text" class="form-control layer-input" name="layer[]" data-item-id="' + (item.item_id || '') + '" data-sale-order-data-id="' + (item.id || '') + '" style="width: 100%; padding: 5px; font-size: 11px;"></td>';
                        itemsHtml += '<td>' + itemName + '</td>';
                        itemsHtml += '<td>' + itemSize + '</td>';
                        itemsHtml += '<td>' + quality + '</td>';
                        itemsHtml += '<td style="text-align: right; padding: 8px; font-weight: bold;">' + totalQty.toFixed(2) + '</td>'; // Total Qty (readonly display)
                        itemsHtml += '<td style="text-align: right; padding: 8px; font-weight: bold; color: #d9534f;">' + previousSentQty.toFixed(2) + '</td>'; // Previous Sent Qty (readonly display)
                        itemsHtml += '<td><input type="number" class="form-control qty-input" name="qty[]" data-item-id="' + (item.item_id || '') + '" data-sale-order-data-id="' + (item.id || '') + '" data-rate="' + (item.rate || 0) + '" data-total-qty="' + totalQty + '" data-previous-sent-qty="' + previousSentQty + '" data-remaining-qty="' + remainingQty + '" value="' + remainingQty.toFixed(2) + '" step="0.01" min="0" max="' + remainingQty.toFixed(2) + '" style="width: 100%; padding: 5px; font-size: 11px; text-align: right; font-weight: bold;"></td>'; // Final Qty (editable, default = remaining qty)
                        itemsHtml += '</tr>';
                    });
                } else {
                    itemsHtml = '<tr><td colspan="8" style="text-align: center;">No items found</td></tr>';
                }
                
                $('#exportOrderItems').html(itemsHtml);
            } else {
                alert('Export order not found for this contract');
            }
        },
        error: function() {
            alert('Error loading export order details');
        }
    });
}





function submitContractLoading() {
    // Collect layer data
    var layers = [];
    $('.layer-input').each(function() {
        var row = $(this).closest('tr');
        var qtyInput = row.find('.qty-input');
        var qty = parseFloat(qtyInput.val()) || 0;
        layers.push({
            sale_order_data_export_id: $(this).data('sale-order-data-id'),
            item_id: $(this).data('item-id'),
            layer: $(this).val(),
            qty: qty
        });
    });
    
    
    // Collect containers data
    var containers = [];
    $('#containersTableBody tr').each(function() {
        var container_item_select = $(this).find('.container_item_select option:selected').val();
        var containerNo = $(this).find('.container_no').val();
        var vehicleNo = $(this).find('.vehicle_no').val();
        var sealNo = $(this).find('.seal_no').val();
        var containerQuantity = $(this).find('.container_quantity').val();
        if (containerNo || sealNo) {
            containers.push({
                container_item_select: container_item_select,
                container_no: containerNo,
                vehicle_no: vehicleNo,
                seal_no: sealNo,
                quantity: containerQuantity
            });
        }
    });
    
    // Create FormData for file uploads
    var formData = new FormData();
    formData.append('sale_order_export_id', $('#sale_order_export_id').val());
    formData.append('contract_no', $('#order_no').find('option:selected').data('contract-no') || '');
    formData.append('forme_no', $('#forme_no').val());
    formData.append('loading_date', $('#loading_date').val());
    formData.append('containers', JSON.stringify(containers));
    formData.append('layers', JSON.stringify(layers));
    
    // Append attachments
    var attachments = $('#attachments')[0].files;
    for (var i = 0; i < attachments.length; i++) {
        formData.append('attachments[]', attachments[i]);
    }
    
    $.ajax({
        url: '{{ url("/export/storeContractLoading") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                alert('Contract loading saved successfully');
                // Reset form
                $('#contractLoadingForm')[0].reset();
                $('#exportOrderDetails').hide();
                $('#order_no').val('').trigger('change');
                $('#attachmentPreview').html('');
                $('#vehiclesTableBody').empty();
                $('#containersTableBody').empty();
                vehicleRowCounter = 0;
                containerRowCounter = 0;
                loadApprovedContracts();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr) {
            var errorMsg = 'Error saving contract loading';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            alert(errorMsg);
        }
    });
}

// Container & Vehicle Details row counter
let containerVehicleRowCounter = 0;

function addContainerVehicleRow() {
    containerVehicleRowCounter++;
    let optionsHtml = '<option value="">Select Item</option>';

    $.each(saleOrderItems, function (index, item) {
        let itemName = item.item_name || '-';
        optionsHtml += `<option value="${item.item_id}">${itemName}</option>`;
    });
    const row = `
        <tr id="container_vehicle_row_${containerVehicleRowCounter}">
            <td style="border:1px solid;padding:8px;">${containerVehicleRowCounter}</td>
            <td style="border:1px solid;padding:8px;">
                <select class="form-control select2 container_item_select"
                    name="items[${containerVehicleRowCounter}][item]" required>
                    ${optionsHtml}
                </select>
            </td>
            <td style="border:1px solid;padding:8px;">
                <input type="text" class="form-control container_no" name="items[${containerVehicleRowCounter}][container_no]" placeholder="Container No" required>
            </td>
            <td style="border:1px solid;padding:8px;">
                <input type="text" class="form-control vehicle_no" name="items[${containerVehicleRowCounter}][vehicle_no]" placeholder="Vehicle No" required>
            </td>
            <td style="border:1px solid;padding:8px;">
                <input type="text" class="form-control seal_no" name="items[${containerVehicleRowCounter}][seal_no]" placeholder="Seal No" required>
            </td>
            <td style="border:1px solid;padding:8px;">
                <input type="number" class="form-control container_quantity" name="items[${containerVehicleRowCounter}][quantity]" placeholder="Quantity" step="0.01" min="0" required>
            </td>
            <td style="border:1px solid;padding:8px;text-align:center;">
                <button type="button" class="btn btn-sm btn-danger" onclick="removeContainerVehicleRow(${containerVehicleRowCounter})">
                    <i class="fa fa-trash"></i> Remove
                </button>
            </td>
        </tr>
    `;
    $('#containersTableBody').append(row);
    $('.select2').select2();
}

function removeContainerVehicleRow(rowId) {
    $(`#container_vehicle_row_${rowId}`).remove();
    // Renumber rows
    $('#containersTableBody tr').each(function(index) {
        $(this).find('td:first').text(index + 1);
    });
}
</script>

@endsection
