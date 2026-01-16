<form id="advancePaymentForm">
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
                    <td>{{ $saleOrder->account_title ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Account Number:</th>
                    <td>{{ $saleOrder->correspondent_account_no ?? '-' }}</td>
                </tr>
                <tr>
                    <th>IBAN:</th>
                    <td>{{ $saleOrder->correspondent_account_usd ?? '-' }}</td>
                </tr>
                <tr>
                    <th>SWIFT Code:</th>
                    <td>{{ $saleOrder->correspondent_bank_swift ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label class="form-label">Advance Amount <span class="rflabelsteric">*</span></label>
                <input type="number" class="form-control" name="advance_amount" id="advance_amount" 
                    step="0.01" min="0" placeholder="Enter advance payment amount" required />
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

