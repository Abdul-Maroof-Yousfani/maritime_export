<?php
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
?>
<table class="table table-bordered table-striped table-condensed tableMargin">

    <tr>
        <th class="text-center">Sr No</th>
        <th class="text-center">Issuance ({{ date('Y') }})</th>
        <th class="text-center">Purchase ({{ date('Y') }})</th>
        <th class="text-center">Issuance ({{ date('Y') - 1 }})</th>
        <th class="text-center">Purchase ({{ date('Y') - 1 }})</th>
        <th class="text-center">Min Stock</th>
        <th class="text-center">Max Stock</th>
    </tr>

    <tbody>
        
        <tr>
            <td class="text-center">{{ '1'}}</td>
            <td class="text-center">{{ CommonHelper::get_qty_from_stock_year_wise(9,$subItem->id,date('Y')) }}</td>
            <td class="text-center">{{ CommonHelper::get_qty_from_stock_year_wise(1,$subItem->id,date('Y')) }}</td>
            <td class="text-center">{{ CommonHelper::get_qty_from_stock_year_wise(9,$subItem->id,date('Y') - 1)}}</td>
            <td class="text-center">{{ CommonHelper::get_qty_from_stock_year_wise(1,$subItem->id,date('Y') - 1) }}</td>
            <td class="text-center">{{ $subItem->min_stock }}</td>
            <td class="text-center">{{ $subItem->max_stock }}</td>
        </tr>
    </tbody>
</table>
<h2 class="text-center">Stock Available In Warehouses</h2>
<table class="table table-bordered table-striped table-condensed tableMargin">

    <tr>
       @foreach (CommonHelper::get_all_warehouse() as $warehouse)
        <th>{{$warehouse->name}}</th>
       @endforeach
    </tr>

    <tbody>
        
        <tr>
            @foreach (CommonHelper::get_all_warehouse() as $warehouse)
                <th>{{ReuseableCode::get_stock($subItem->id, $warehouse->id, 0, 0)}}</th>
            @endforeach
        </tr>
    </tbody>
</table>
{{-- <table class="table table-bordered table-striped table-condensed tableMargin">

    <tr>
        <th class="text-center">Sr No</th>
        <th class="text-center">Voucher No</th>
        <th class="text-center">Voucher Date</th>
        <th class="text-center">Supplier</th>
        <th class="text-center">Quantity</th>
        <th class="text-center">Rate</th>
        <th class="text-center">Amount</th>

    </tr>

    <tbody>
        @php
        $count = 1;
        
        @endphp
        @foreach ($grn_data as $row)
            @php
            $qty = $row->purchase_recived_qty - $row->qc_qty;
            $rate = $row->rate;
            $amount = $qty * $rate;
            @endphp
            <tr>
                <td class="text-center">{{ $count++ }}</td>
                <td class="text-center">{{ strtoupper($row->grn_no) }}</td>
                <td class="text-center">{{ commonHelper::changeDateFormat($row->grn_date) }}</td>
                <td class="text-center">{{ commonHelper::get_supplier_name($row->supplier_id) }}</td>
                <td class="text-center">{{ number_format($qty, 2) }}</td>
                <td class="text-center">{{ number_format($rate) }}</td>
                <td class="text-center">{{ number_format($amount, 2) }}</td>

            </tr>
        @endforeach
    </tbody>
</table> --}}
