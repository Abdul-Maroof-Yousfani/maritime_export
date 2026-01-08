<?php
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
?>

<h2 style="text-align: center">Stock Aging Report</h2>

<table id="data" class="table table-bordered table-responsive">
    <thead>
        <tr>
            <th class="text-center">S.No</th>
            <th class="text-center">Category</th>
            <th class="text-center">Item</th>
            <th class="text-center">SKU Code</th>
            <th class="text-center">Pack Size</th>
            <th class="text-center">Item Type</th>
            <th class="text-center">UOM</th>
            <th class="text-center">Location</th>
            <th class="text-center">Last Purchased Rate</th>
            <th class="text-center">Last Purchased Date</th>
            <th class="text-center">Closing Stock</th>
            <th class="text-center">1-30</th>
            <th class="text-center">31-60</th>
            <th class="text-center">61-90</th>
            <th class="text-center">91-120</th>
            <th class="text-center">121-150</th>
            <th class="text-center">151-180</th>
            <th class="text-center">Above 180</th>
        </tr>
    </thead>
    <tbody id="filterDemandVoucherList">
    @foreach ($data as $key => $stock)
    <?php
    $current_stock = $stock->current_stock;
    $days_1_30 = $stock->days_1_30 <= 0 ? '0.00' : $stock->days_1_30;
    $days_31_60 = $stock->days_31_60 <= 0 ? '0.00' : $stock->days_31_60;;
    $days_61_90 = $stock->days_61_90 <= 0 ? '0.00' : $stock->days_61_90;;
    $days_91_120 = $stock->days_91_120 <= 0 ? '0.00' : $stock->days_91_120;;
    $days_121_150 = $stock->days_121_150 <= 0 ? '0.00' : $stock->days_121_150;;
    $days_151_180 = $stock->days_151_180 <= 0 ? '0.00' : $stock->days_151_180;;
    $above_180 = $stock->above_180 <= 0 ? '0.00' : $stock->above_180;;

    // Set aging values to 0 if current stock is 0
    if ($current_stock == 0) {
        $days_1_30 = $days_31_60 = $days_61_90 = $days_91_120 = $days_121_150 = $days_151_180 = $above_180 = '0.00';
    }

    // Calculate the total of all aging buckets
    $total_aging = (int)$days_1_30 + (int)$days_31_60 + (int)$days_61_90 + (int)$days_91_120 + (int)$days_121_150 + (int)$days_151_180;

    // Calculate the actual value for Above 180 based on current stock and other aging buckets
    if ($current_stock > 0) {
        $total_aging;
        $above_180 = number_format($current_stock - $total_aging, 2);
    }
    ?>
    <tr>
        <td>{{ ++$key }}</td>
        <td>{{ $stock->main_ic }}</td>
        <td>
            <a class="" href="{{ url("/store/fullstockReportView?pageType=&&parentCode=97&&m=Session::get('run_company')&&sub_item_id=$stock->sub_item_id&&warehouse_id=$stock->warehouse_id&&from_date=$from_date&&to_date=$to_date") }}" target="_blank">
                {{ $stock->sub_ic }}
            </a>
        </td>
        <td>{{ $stock->sku_code }}</td>
        <td>{{ $stock->pack_size }}</td>
        <td>{{ $stock->demand_name }}</td>
        <td>{{ $stock->uom_name }}</td>
        <td>{{ $stock->name }}</td>
        <td class="text-center;">@if(array_key_exists($stock->sub_item_id,$ratesArray)) {{ number_format($ratesArray[$stock->sub_item_id]->rate,2) }} @endif</td>
        <td class="text-center;">@if(array_key_exists($stock->sub_item_id,$ratesArray)) {{ CommonHelper::changeDateFormat($ratesArray[$stock->sub_item_id]->voucher_date) }} @endif</td>
        <td class="text-center">{{ $current_stock }}</td>
        <td class="text-center">{{ $days_1_30 < 0 ? '0.00' : $days_1_30 }}</td>
        <td class="text-center">{{ $days_31_60 < 0 ? '0.00' : $days_31_60 }}</td>
        <td class="text-center">{{ $days_61_90 < 0 ? '0.00' : $days_61_90 }}</td>
        <td class="text-center">{{ $days_91_120 < 0 ? '0.00' : $days_91_120 }}</td>
        <td class="text-center">{{ $days_121_150 < 0 ? '0.00' : $days_121_150 }}</td>
        <td class="text-center">{{ $days_151_180 < 0 ? '0.00' : $days_151_180 }}</td>
        <td class="text-center">{{ $above_180 < 0 ? '0.00' : $above_180 }}</td>
    </tr>
@endforeach
    </tbody>
</table>