<?php
use App\Helpers\CommonHelper;
use App\Helpers\StoreHelper;
$id = $_GET['id'];
$m = Session::get('run_company');
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

.invoice-title {
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    margin: 20px 0;
    text-transform: uppercase;
}

.invoice-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    font-size: 12px;
}

.invoice-header-left {
    flex: 1;
}

.invoice-header-right {
    flex: 1;
    text-align: right;
}

.consignee-section {
    margin-bottom: 20px;
    border: 1px solid #000;
    padding: 10px;
}

.consignee-title {
    font-weight: bold;
    margin-bottom: 5px;
}

.shipping-section {
    margin-bottom: 20px;
    font-size: 12px;
}

.product-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.product-table th,
.product-table td {
    border: 1px solid #000;
    padding: 8px;
    text-align: left;
    font-size: 11px;
}

.product-table th {
    background-color: #f0f0f0;
    font-weight: bold;
    text-align: center;
}

.product-table td {
    text-align: center;
}

.product-table td:nth-child(2) {
    text-align: left;
}

.product-table td:last-child {
    text-align: right;
}

.grand-total-section {
    margin-top: 20px;
    font-size: 12px;
}

.grand-total-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
}

.grand-total-table td {
    border: 1px solid #000;
    padding: 8px;
}

.grand-total-table td:first-child {
    font-weight: bold;
    width: 50%;
}

.grand-total-table td:last-child {
    text-align: right;
    font-weight: bold;
}

.amount-in-words {
    margin-top: 10px;
    font-size: 11px;
    line-height: 1.6;
}
</style>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right printHide">
        <?php CommonHelper::displayPrintButtonInView('printCommercialInvoice', '', '1'); ?>
    </div>
</div>

<div class="row" id="printCommercialInvoice">
    <div class="col-md-12">
        <div class="invoice-container">
            {{-- Title --}}
            <div class="invoice-title">COMMERCIAL INVOICE</div>
            
            {{-- Invoice Header --}}
            <div class="invoice-header">
                <div class="invoice-header-left">
                    <div><strong>CONSIGNEE:</strong></div>
                    <div style="margin-top: 5px;">{{ $commercialInvoice->consignee_name ?? '-' }}</div>
                    <div style="margin-top: 5px;"><strong>ADD:</strong> {{ $commercialInvoice->consignee_address ?? '-' }}</div>
                </div>
                <div class="invoice-header-right">
                    <div><strong>Invoice No.:</strong> {{ $commercialInvoice->invoice_no ?? '-' }}</div>
                    <div><strong>Date:</strong> 
                        @if(!empty($commercialInvoice->invoice_date))
                            @php
                                $date = new DateTime($commercialInvoice->invoice_date);
                                echo $date->format('d-m-Y');
                            @endphp
                        @else
                            -
                        @endif
                    </div>
                    <div><strong>GD NO:</strong> {{ $commercialInvoice->gd_no ?? '-' }}</div>
                    <div><strong>Container #:</strong> 
                        @if(isset($commercialInvoice->contractLoading) && $commercialInvoice->contractLoading->containers && $commercialInvoice->contractLoading->containers->count() > 0)
                            @php
                                $containerNos = $commercialInvoice->contractLoading->containers->pluck('container_no')->filter()->toArray();
                            @endphp
                            {{ !empty($containerNos) ? implode(', ', $containerNos) : ($commercialInvoice->container_no ?? '-') }}
                        @else
                            {{ $commercialInvoice->container_no ?? '-' }}
                        @endif
                    </div>
                </div>
            </div>
            
            {{-- Containers Details --}}
            @if(isset($commercialInvoice->contractLoading) && $commercialInvoice->contractLoading->containers && $commercialInvoice->contractLoading->containers->count() > 0)
            <div class="shipping-section" style="margin-bottom: 20px;">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th style="width: 10%;">S.No</th>
                            <th style="width: 45%;">Container No</th>
                            <th style="width: 45%;">Seal No</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1; @endphp
                        @foreach($commercialInvoice->contractLoading->containers as $container)
                        <tr>
                            <td style="text-align: center;">{{ $count++ }}</td>
                            <td style="text-align: center;">{{ $container->container_no ?? '-' }}</td>
                            <td style="text-align: center;">{{ $container->seal_no ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            
            {{-- Shipping Details --}}
            <div class="shipping-section">
                <div><strong>VESSEL/VOYAGE:</strong> {{ $commercialInvoice->vessel_voyage ?? '-' }}</div>
                <div><strong>FROM:</strong> {{ $commercialInvoice->port_from ?? '-' }}</div>
                <div><strong>TO:</strong> {{ $commercialInvoice->port_to ?? '-' }}</div>
                <div><strong>Payment Term:</strong> {{ $commercialInvoice->payment_term ?? '-' }}</div>
            </div>
            
            {{-- Product Table --}}
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Descriptions of Product</th>
                        <th>Grade Size</th>
                        <th>Total Cartons</th>
                        <th>Total Net Kgs</th>
                        <th>Rate C F R Per kg</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalCartons = 0;
                        $totalNetKgs = 0;
                        $grandTotal = 0;
                        $count = 1;
                        $currencyName = $commercialInvoice->currency ? $commercialInvoice->currency->curreny : 'USD';
                        // Get currency symbol - if not available, use common symbols or currency name
                        $currencySymbol = '$'; // Default
                        if ($commercialInvoice->currency) {
                            $currencyCode = strtoupper($currencyName);
                            // Map common currency codes to symbols
                            $currencySymbols = [
                                'USD' => '$',
                                'EUR' => '€',
                                'GBP' => '£',
                                'PKR' => 'PKR ',
                                'AED' => 'AED ',
                                'SAR' => 'SAR ',
                            ];
                            $currencySymbol = isset($currencySymbols[$currencyCode]) 
                                ? $currencySymbols[$currencyCode] 
                                : ($currencyCode . ' ');
                        }
                    @endphp
                    @foreach($commercialInvoice->invoiceData as $item)
                        @php
                            $totalCartons += $item->total_cartons;
                            $totalNetKgs += $item->total_net_kgs;
                            $grandTotal += $item->amount_usd;
                        @endphp
                        <tr>
                            <td>{{ $item->description ?? '-' }}</td>
                            <td>{{ $item->grade_size ?? '-' }}</td>
                            <td>{{ $item->total_cartons ?? 0 }}</td>
                            <td>{{ number_format($item->total_net_kgs ?? 0, 2) }}</td>
                            <td>{{ number_format($item->rate_cfr_per_kg ?? 0, 2) }}</td>
                            <td>{{ $currencySymbol }} {{ number_format($item->amount_usd ?? 0, 2) }}</td>
                        </tr>
                    @endforeach
                    {{-- Empty rows for additional items --}}
                    @for($i = count($commercialInvoice->invoiceData); $i < 5; $i++)
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    @endfor
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="text-align: right; font-weight: bold;">Grand Total</td>
                        <td style="text-align: center; font-weight: bold;">{{ $totalCartons }}</td>
                        <td style="text-align: center; font-weight: bold;">{{ number_format($totalNetKgs, 2) }}</td>
                        <td>&nbsp;</td>
                        <td style="text-align: right; font-weight: bold;">{{ $currencySymbol }} {{ number_format($grandTotal, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
            
            {{-- Grand Total Section --}}
            <div class="grand-total-section">
                @php
                    // Advance amount is stored in PKR, convert to selected currency
                    $advanceAmount = $commercialInvoice->advance_amount ?? 0;
                    
                    $balanceAmount = $commercialInvoice->balance_amount ?? $grandTotal;
                @endphp
                
                <table class="grand-total-table">
                    <tr>
                        <td><strong>Grand Total:-</strong></td>
                        <td>{{ $currencySymbol }} {{ number_format($grandTotal, 2) }}</td>
                    </tr>
                    @if($advanceAmount > 0)
                    <tr>
                        <td><strong>Advance:-</strong></td>
                        <td>{{ $currencySymbol }} {{ number_format($advanceAmount, 2) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><strong>Balance:-</strong></td>
                        <td>{{ $currencySymbol }} {{ number_format($balanceAmount, 2) }}</td>
                    </tr>
                </table>
                
                <div class="amount-in-words">
                    @if($advanceAmount > 0)
                        <div><strong>ADVANCE IN {{ strtoupper($currencyName) }}:</strong> {{ CommonHelper::AmountInWords($advanceAmount, $currencyName) }}. ({{ $currencySymbol }} {{ number_format($advanceAmount, 2) }})</div>
                    @endif
                    
                    <div><strong>{{ strtoupper($currencyName) }}:</strong> {{ CommonHelper::AmountInWords($balanceAmount, $currencyName) }}. ({{ $currencySymbol }} {{ number_format($balanceAmount, 2) }})</div>
                </div>
            </div>
        </div>
    </div>
</div>

