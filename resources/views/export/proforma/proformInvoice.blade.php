<?php
use App\Helpers\CommonHelper;
use App\Helpers\StoreHelper;
use App\Models\IncoTerm;
use App\Models\ModeOfTransport;
$id = $_GET['id'];
$m = Session::get('run_company');
$currentDate = date('Y-m-d');
$total_expense = 0;

?>

<style>
    @media print {
        .printHide{display:none !important;}
        @page {
            margin: 10mm;
        }
    }
    
    .invoice-container {
        font-family: Arial, sans-serif;
        max-width: 210mm;
        margin: 0 auto;
        padding: 15px;
        background: #fff;
    }
    
    .invoice-header {
        border-bottom: 2px solid #000;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }
    
    .company-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }
    
    .company-info {
        flex: 1;
    }
    
    .company-name {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 5px;
        text-transform: uppercase;
    }
    
    .company-tagline {
        font-size: 12px;
        color: #333;
        margin-bottom: 10px;
    }
    
    .certifications {
        display: flex;
        gap: 10px;
        margin-top: 5px;
    }
    
    .cert-badge {
        background: #f0f0f0;
        padding: 3px 8px;
        border-radius: 3px;
        font-size: 10px;
        font-weight: bold;
    }
    
    .logo-area {
        width: 150px;
        text-align: right;
    }
    
    .logo-area img {
        max-width: 100%;
        height: auto;
    }
    
    .invoice-title {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        margin: 15px 0;
        text-transform: uppercase;
    }
    
    .invoice-meta {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        font-size: 12px;
    }
    
    .buyer-section {
        margin-bottom: 20px;
    }
    
    .section-title {
        font-weight: bold;
        font-size: 12px;
        margin-bottom: 5px;
    }
    
    .buyer-info {
        font-size: 11px;
        line-height: 1.4;
    }
    
    .buyer-name {
        font-weight: bold;
        font-size: 12px;
    }
    
    .goods-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 11px;
    }
    
    .goods-table th {
        background-color: #f0f0f0;
        border: 1px solid #000;
        padding: 8px 5px;
        text-align: left;
        font-weight: bold;
        font-size: 10px;
        text-transform: uppercase;
    }
    
    .goods-table td {
        border: 1px solid #000;
        padding: 8px 5px;
        text-align: left;
    }
    
    .goods-table tr:last-child td {
        font-weight: bold;
        background-color: #f9f9f9;
    }
    
    .terms-section {
        margin: 20px 0;
        font-size: 11px;
        line-height: 1.6;
    }
    
    .terms-row {
        margin-bottom: 8px;
    }
    
    .terms-label {
        font-weight: bold;
        display: inline-block;
        min-width: 120px;
    }
    
    .bank-section {
        margin: 20px 0;
        font-size: 11px;
    }
    
    .bank-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    
    .bank-table td {
        border: 1px solid #000;
        padding: 8px;
        vertical-align: top;
    }
    
    .bank-table .label {
        font-weight: bold;
        width: 200px;
        background-color: #f0f0f0;
    }
    
    .signature-section {
        margin-top: 40px;
        display: flex;
        justify-content: space-between;
    }
    
    .signature-box {
        width: 45%;
    }
    
    .signature-line {
        border-top: 1px solid #000;
        margin-top: 60px;
        padding-top: 5px;
        font-size: 11px;
        text-align: center;
    }
    
    .footer-section {
        margin-top: 30px;
        padding-top: 15px;
        border-top: 1px solid #ccc;
        font-size: 10px;
        text-align: center;
        color: #666;
    }
    
    .footer-info {
        line-height: 1.6;
    }
</style>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right printHide">
        <?php CommonHelper::displayPrintButtonInView('printPurchaseRequestVoucherDetail', '', '1'); ?>
    </div>
</div>

<div class="row" id="printPurchaseRequestVoucherDetail">
    <div class="col-md-12">
        <div class="invoice-container">
            <?php
            if (!empty($ExportPerforma->currencey_id)) {
                $name_currency1 = App\Models\Currency::find($ExportPerforma->currencey_id);
                $name_currency = $name_currency1['curreny'];
            } else {
                $name_currency = 'USD';
            }
            $total_amount = $sales_order_data->total_amount ?? 0;
            
            if (!empty($ExportPerforma->bank)) {
                $bank_obj = App\Models\Bank::find($ExportPerforma->bank);
                $bank_name = $bank_obj->bank_name ?? '-';
                $bank_swift = $bank_obj->swift_code ?? '-';
                $bank_ibn = $bank_obj->IBAN_no ?? '-';
                $bank_address = $bank_obj->bank_address ?? '-';
                $account_title = $bank_obj->account_title ?? '-';
            } else {
                $bank_name = '-';
                $bank_swift = '-';
                $bank_ibn = '-';
                $bank_address = '-';
                $account_title = '-';
            }
            
            // Calculate totals
            $total_quantity = 0;
            $total_net_weight = 0;
            $total_amount_calc = 0;
            
            if(isset($sales_order_data_items) && $sales_order_data_items) {
                foreach($sales_order_data_items as $item) {
                    $total_quantity += $item->actual_qty ?? 0;
                    $total_net_weight += ($item->pack_size ?? 1) * ($item->actual_qty ?? 0);
                    $total_amount_calc += $item->after_dis_amount ?? 0;
                }
            }
            ?>
            
            <!-- Header Section -->
            <div class="invoice-header">
                <div class="company-header">
                    <div class="company-info">
                        <div class="company-name">SUPER STAR ENTERPRISES</div>
                        <div class="company-tagline">Gift from the Sea</div>
                        <div class="certifications">
                            <span class="cert-badge">FDA</span>
                            <span class="cert-badge">ISO</span>
                        </div>
                    </div>
                    <div class="logo-area">
                        <img src="{{asset('/public/images/garibsons.jpg')}}" alt="Company Logo" onerror="this.style.display='none'">
                    </div>
                </div>
                
                <div class="invoice-title">PROFORMA INVOICE</div>
                
                <div class="invoice-meta">
                    <div><strong>PROFORMA INVOICE NO:</strong> {{ $ExportPerforma->pro_contract_no ?? 'PI-' . $ExportPerforma->id }}</div>
                    <div><strong>DATE:</strong> {{ $ExportPerforma->created_at->format('d/m/Y') }}</div>
                </div>
            </div>
            
            <!-- Buyer Section -->
            <div class="buyer-section">
                <div class="section-title">BUYER:</div>
                <div class="buyer-info">
                    <div class="buyer-name">{{ strtoupper($ExportPerforma->name ?? '') }}</div>
                    <div>{{ strtoupper($ExportPerforma->address ?? '') }}</div>
                </div>
            </div>
            
            <!-- Description of Goods Table -->
            <table class="goods-table">
                <thead>
                    <tr>
                        <th style="width: 35%;">DETAILED SPECIFICATIONS</th>
                        <th style="width: 12%;">SIZE (G/PC)</th>
                        <th style="width: 10%;">QUANTITY</th>
                        <th style="width: 12%;">NET WEIGHT KGS</th>
                        <th style="width: 15%;">UNIT</th>
                        <th style="width: 16%;">TOTAL AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $grand_total_qty = 0;
                    $grand_total_weight = 0;
                    $grand_total_amount = 0;
                    @endphp
                    
                    @if(isset($sales_order_data_items) && count($sales_order_data_items) > 0)
                        @foreach($sales_order_data_items as $item)
                            @php
                            $item_name = CommonHelper::get_item_name($item->item_id);
                            $net_weight = ($item->pack_size ?? 1) * ($item->actual_qty ?? 0);
                            $unit_price = $item->rate ?? 0;
                            $item_total = $item->after_dis_amount ?? ($item->amount ?? 0);
                            
                            $grand_total_qty += $item->actual_qty ?? 0;
                            $grand_total_weight += $net_weight;
                            $grand_total_amount += $item_total;
                            @endphp
                            <tr>
                                <td>{{ $item_name }}</td>
                                <td>{{ $item->pack_size ?? '-' }}</td>
                                <td style="text-align: right;">{{ number_format($item->actual_qty ?? 0, 0) }}</td>
                                <td style="text-align: right;">{{ number_format($net_weight, 2) }}</td>
                                <td>{{ $name_currency }}/KG</td>
                                <td style="text-align: right;">{{ $name_currency }} {{ number_format($item_total, 2) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 20px;">No items found</td>
                        </tr>
                    @endif
                    
                    <!-- Total Row -->
                    <tr>
                        <td><strong>TOTAL</strong></td>
                        <td></td>
                        <td style="text-align: right;"><strong>{{ number_format($grand_total_qty, 0) }}</strong></td>
                        <td style="text-align: right;"><strong>{{ number_format($grand_total_weight, 2) }}</strong></td>
                        <td></td>
                        <td style="text-align: right;"><strong>{{ $name_currency }} {{ number_format($grand_total_amount, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
            
            <!-- Terms and Conditions -->
            <div class="terms-section">
                <div class="terms-row">
                    <span class="terms-label">TOTAL VALUE:</span>
                    <span><strong>{{ $name_currency }} {{ number_format($total_amount, 2) }}</strong></span>
                </div>
                <div class="terms-row">
                    <span class="terms-label">SHIPMENT:</span>
                    <span>{{ $ExportPerforma->port_loading ?? 'KARACHI' }} TO {{ $ExportPerforma->port_of_discharge ?? 'PORT' }}</span>
                </div>
                <div class="terms-row">
                    <span class="terms-label">SHIPMENT DELIVERY:</span>
                    <span>PROMPT</span>
                </div>
                <div class="terms-row">
                    <span class="terms-label">PAYMENT TERM:</span>
                    <span>
                        @if ($ExportPerforma->advance_payment > 0)
                            {{ $ExportPerforma->advance_payment }}% ADVANCE, BALANCE WITHIN {{ $ExportPerforma->payment_days ?? 30 }} DAYS
                        @else
                            {{ $ExportPerforma->payment_days ?? 30 }} DAYS AFTER BL DATE
                        @endif
                    </span>
                </div>
                <div class="terms-row">
                    <span class="terms-label">TOLERANCE:</span>
                    <span>10% PLUS/MINUS ALLOWED IN AMOUNT AND QUANTITY</span>
                </div>
                <div class="terms-row">
                    <span class="terms-label">INSURANCE:</span>
                    <span>COVERED BY BUYER</span>
                </div>
            </div>
            
            <!-- Bank Account Details -->
            <div class="bank-section">
                <div class="section-title">BANK ACCOUNT DETAILS:</div>
                <table class="bank-table">
                    <tr>
                        <td class="label">BANK NAME:</td>
                        <td>{{ $bank_name }}</td>
                    </tr>
                    <tr>
                        <td class="label">ADDRESS:</td>
                        <td>{{ $bank_address }}</td>
                    </tr>
                    <tr>
                        <td class="label">SWIFT CODE:</td>
                        <td>{{ $bank_swift }}</td>
                    </tr>
                    <tr>
                        <td class="label">ACCOUNT TITLE:</td>
                        <td>{{ $account_title }}</td>
                    </tr>
                    <tr>
                        <td class="label">IBAN NO:</td>
                        <td>{{ $bank_ibn }}</td>
                    </tr>
                </table>
            </div>
            
            <!-- Signature Section -->
            <div class="signature-section">
                <div class="signature-box">
                    <div class="section-title">SELLER:</div>
                    <div style="margin-top: 10px;">FOR SUPER STAR ENTERPRISES</div>
                    <div class="signature-line">
                        <strong>AUTHORIZED SIGNATURE</strong>
                    </div>
                </div>
                <div class="signature-box">
                    <div class="section-title">BUYER:</div>
                    <div style="margin-top: 10px;">{{ strtoupper($ExportPerforma->name ?? '') }}</div>
                    <div class="signature-line">
                        <strong>AUTHORIZED SIGNATURE</strong>
                    </div>
                </div>
            </div>
            
            <!-- Footer Section -->
            <div class="footer-section">
                <div class="footer-info">
                    <div><strong>C1, C2, Fish Harbour West Wharf, Karachi-Pakistan</strong></div>
                    <div>Phone: +92 21 32202415, +92 21 32315408</div>
                    <div>Email: info@superstarenterprises.com.pk</div>
                    <div>Website: www.superstarenterprises.com.pk</div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
    $(function() {
        // Print functionality if needed
    });
</script>
