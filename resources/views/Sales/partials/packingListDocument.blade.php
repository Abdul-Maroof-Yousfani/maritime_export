@php
    // Prefer packing list stored values; fallback to commercial invoice where helpful
    $ci = $packingList->commercialInvoice ?? null;

    $consigneeName = $packingList->consignee_name ?? ($ci->consignee_name ?? '');
    $consigneeAddress = $packingList->consignee_address ?? ($ci->consignee_address ?? '');

    $invoiceNo = $packingList->invoice_no ?? ($ci->invoice_no ?? '');
    $dateStr = '-';
    if (!empty($packingList->date)) {
        try {
            $dateStr = (new DateTime($packingList->date))->format('d-m-Y');
        } catch (\Exception $e) {
            $dateStr = $packingList->date;
        }
    }

    $gdNo = $packingList->gd_no ?? ($ci->gd_no ?? '');
    $containerNo = $packingList->container_no ?? ($ci->container_no ?? '');
    $vesselVoyage = $packingList->vessel_voyage ?? ($ci->vessel_voyage ?? '');
    $portFrom = $packingList->port_from ?? ($ci->port_from ?? '');
    $portTo = $packingList->port_to ?? ($ci->port_to ?? '');
    $paymentTerm = $packingList->payment_term ?? ($ci->payment_term ?? '');

    $totalCartons = 0;
    $totalNet = 0;
    $totalGross = 0;
    foreach (($packingList->packingListData ?? []) as $r) {
        $totalCartons += (int)($r->total_cartons ?? 0);
        $totalNet += (float)($r->total_net_kgs ?? 0);
        $totalGross += (float)($r->total_gross_kgs ?? 0);
    }
    $grossWeight = $packingList->gross_weight ?? $totalGross;

    $minRows = $minRows ?? 10;
@endphp

<style>
    .pl-doc { font-family: Arial, sans-serif; max-width: 210mm; margin: 0 auto; color: #000; }
    .pl-title { text-align: center; font-weight: 700; font-size: 18px; margin: 10px 0 6px; letter-spacing: .5px; }
    .pl-title span { display: inline-block; border-bottom: 1px solid #000; padding: 0 10px 3px; }

    .pl-box, .pl-table { width: 100%; border-collapse: collapse; }
    .pl-box td, .pl-box th { border: 1px solid #000; padding: 5px 6px; font-size: 11px; vertical-align: top; }
    .pl-label { width: 120px; font-weight: 700; white-space: nowrap; }
    .pl-right-label { width: 90px; font-weight: 700; white-space: nowrap; }
    .pl-right-val { width: 140px; }
    .pl-consignee { line-height: 1.35; }

    .pl-table th, .pl-table td { border: 1px solid #000; padding: 5px 6px; font-size: 11px; }
    .pl-table thead th { text-align: center; font-weight: 700; }
    .pl-table td { text-align: center; }
    .pl-table td.desc { text-align: left; }
    .pl-grand td { font-weight: 700; }
    .pl-gross { border: 1px solid #000; border-top: none; padding: 6px; font-size: 12px; font-weight: 700; }
    .pl-sign { margin-top: 40px; font-size: 12px; }
    .pl-sign .company { font-weight: 700; }
</style>

<div class="pl-doc" id="packingListPrintableDoc">
    <div class="pl-title"><span>PACKING LIST</span></div>

    <table class="pl-box">
        <tr>
            <td rowspan="3" class="pl-consignee">
                <div><strong>CONSIGNEE:</strong></div>
                <div style="margin-top: 4px;">{{ $consigneeName ?: '-' }}</div>
                <div style="margin-top: 4px;"><strong>ADD:</strong> {{ $consigneeAddress ?: '-' }}</div>
            </td>
            <td class="pl-right-label">Invoice No.</td>
            <td class="pl-right-val">{{ $invoiceNo ?: '-' }}</td>
        </tr>
        <tr>
            <td class="pl-right-label">Date:</td>
            <td class="pl-right-val">{{ $dateStr }}</td>
        </tr>
        <tr>
            <td class="pl-right-label">GD NO:</td>
            <td class="pl-right-val">{{ $gdNo ?: '-' }}</td>
        </tr>
        <tr>
            <td>
                <strong>VESSEL/VOYAGE :</strong> {{ $vesselVoyage ?: '-' }}
            </td>
            <td class="pl-right-label">Container #.</td>
            <td class="pl-right-val">{{ $containerNo ?: '-' }}</td>
        </tr>
        <tr>
            <td>
                <strong>FROM,</strong> {{ $portFrom ?: '-' }}
            </td>
            <td class="pl-right-label">TO,</td>
            <td class="pl-right-val">{{ $portTo ?: '-' }}</td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>Payment Term :</strong> {{ $paymentTerm ?: '-' }}
            </td>
        </tr>
    </table>

    <table class="pl-table" style="margin-top: 6px;">
        <thead>
            <tr>
                <th rowspan="2" style="width:45%;">Descriptions<br>of Product</th>
                <th rowspan="2" style="width:15%;">Grade<br>/ Size</th>
                <th colspan="3">Total</th>
            </tr>
            <tr>
                <th style="width:13%;">Cartons</th>
                <th style="width:13%;">Net Kgs</th>
                <th style="width:14%;">Gross Kgs</th>
            </tr>
        </thead>
        <tbody>
            @php $rowCount = 0; @endphp
            @foreach(($packingList->packingListData ?? []) as $item)
                @php $rowCount++; @endphp
                <tr>
                    <td class="desc">{{ $item->description ?? '-' }}</td>
                    <td>{{ $item->grade_size ?? '-' }}</td>
                    <td>{{ $item->total_cartons ?? 0 }}</td>
                    <td>{{ number_format($item->total_net_kgs ?? 0, 2) }}</td>
                    <td>{{ number_format($item->total_gross_kgs ?? 0, 2) }}</td>
                </tr>
            @endforeach

            @for($i = $rowCount; $i < $minRows; $i++)
                <tr>
                    <td class="desc">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            @endfor
        </tbody>
        <tfoot>
            <tr class="pl-grand">
                <td class="desc" style="text-align:left;" colspan="2">Grand Total:-</td>
                <td>{{ $totalCartons }}</td>
                <td>{{ number_format($totalNet, 2) }}</td>
                <td>{{ number_format($totalGross, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="pl-gross">
        GROSS WEIGHT : {{ number_format($grossWeight, 0) }} KGS
    </div>

    <div class="pl-sign">
        <div class="company">{{ strtoupper(config('app.name', '')) }}</div>
        <div style="margin-top: 25px;">__________________________</div>
    </div>
</div>

