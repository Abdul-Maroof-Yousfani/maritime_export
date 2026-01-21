<?php
use App\Helpers\CommonHelper;
$m = Session::get('run_company');
?>
<style>
    @media print {
        .printHide{display:none !important;}
        .page-break{page-break-after: always;}
    }
    .item-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
        border: 2px solid #000;
    }
    .item-table th, .item-table td {
        border: 1px solid #000;
        padding: 10px;
        text-align: left;
    }
    .item-table th {
        background-color: #f0f0f0;
        font-weight: bold;
        width: 40%;
    }
    .item-table td {
        width: 60%;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right printHide">
        <button onclick="window.print()" class="btn btn-primary">Print</button>
        <button onclick="window.close()" class="btn btn-default">Close</button>
    </div>
</div>
<div style="line-height:5px;">&nbsp;</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <!-- Static Company Details -->
        <table class="item-table" style="margin-bottom: 20px;">
            <tbody>
                <tr>
                    <th>Factory Name</th>
                    <td>{{ $company->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Registration No</th>
                    <td>{{ $company->registration_no ?? $company->ntn ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Factory Address</th>
                    <td>{{ $company->address ?? $company->company_address ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Importer</th>
                    <td>{{ $customer->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Importer Address</th>
                    <td>{{ $customer->address ?? '-' }}</td>
                </tr>
            </tbody>
        </table>

        @foreach($saleOrderItems as $index => $item)
            <div class="item-section {{ $index > 0 ? 'page-break' : '' }}">
                <!-- Item Details Table -->
                <table class="item-table">
                    <tbody>
                        <tr>
                            <th>Name Of Product (品名)</th>
                            <td>{{ $item->item->sub_ic ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Scientific Name (学名)</th>
                            <td>{{ $item->item->scientific_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>SIZE</th>
                            <td>
                                @php
                                    $size = $item->item_size ?? '';
                                    $quality = $item->quality ?? '';
                                    $sizeQuality = trim($size . ' ' . $quality);
                                @endphp
                                {{ $sizeQuality ?: '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Mode of Production (生产方式)</th>
                            <td>{{ $saleOrder->mode_of_production ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Storage Instruction</th>
                            <td>KEEP FROZEN AT -18°C OR BELOW</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</div>

