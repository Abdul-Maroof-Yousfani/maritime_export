<form id="advancePaymentForm" enctype="multipart/form-data">
    <input type="hidden" name="sale_order_id" value="{{ $saleOrder->id }}">
    <input type="hidden" name="voucher_no" value="{{ $saleOrder->voucehr_no }}">
    
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h4>Customer Details</h4>
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Customer Name:</th>
                    <td>{{ $customer->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Address:</th>
                    <td>{{ $customer->address ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Contact:</th>
                    <td>{{ $customer->contact ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{{ $customer->email ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h4>Bank Details</h4>
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Bank Name:</th>
                    <td>{{ $bank->bank_name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Account Title:</th>
                    <td>{{ $bank->account_title ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Account Number:</th>
                    <td>{{ $bank->account_no ?? '-' }}</td>
                </tr>
                <tr>
                    <th>IBAN:</th>
                    <td>{{ $bank->IBAN_no ?? '-' }}</td>
                </tr>
                <tr>
                    <th>SWIFT Code:</th>
                    <td>{{ $bank->swift_code ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label class="form-label">Advance Amount <span class="rflabelsteric">*</span></label>
                <input type="number" class="form-control" name="advance_amount" id="advance_amount" 
                    value="{{ $saleOrder->advance_amount ?? 0 }}" step="0.01" min="0" placeholder="Enter advance payment amount" required readonly />
            </div>
        </div>
    </div>
    
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label class="form-label">Attachments</label>
                <input type="file" class="form-control" name="attachments[]" id="attachments" 
                    multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif" />
                <small class="text-muted">You can select multiple files (PDF, DOC, XLS, Images). Optional field.</small>
                <div id="attachmentPreview" class="mt-2"></div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="submitAdvancePayment()">Submit</button>
        </div>
    </div>
</form>

