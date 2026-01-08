<?php
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
?>

<h2 style="text-align: center">Stock Summary Report</h2>




<table id="data" class="table table-bordered table-responsive">
    {{-- <h4>{{ $category_heading }}</h4>
    <h4>{{ $item_heading }}</h4>
    <h4>{{ $location_heading }}</h4>
    <h4>{{ $sub_item_heading }}</h4>
    <h4>{{ $sub_item_des_heading }}</h4> --}}
    
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

            <th class="text-center">Opening QTY.</th>
            <th class="text-center">Last Purchased Rate</th>
            <th class="text-center">Purchase QTY.</th>
            <th class="text-center">Produce QTY By Production</th>
            <th class="text-center">Purchase Return.</th>
            <th class="text-center">Transferd QTY.</th>
            <th class="text-center">Consumption  QTY.</th>
            <th class="text-center">Issuence Against Production Plan</th>
            <th class="text-center">Return Against Production Plan</th>
            <th class="text-center">Stock Adjustment (IN)</th>
            <th class="text-center">Stock Adjustment (OUT)</th>
            <th class="text-center">Sales QTY.</th>
            <th class="text-center">Sales Return QTY.</th>

            <th class="text-center">In Stock</th>
        </tr>
    </thead>
    <tbody id="filterDemandVoucherList">
        @foreach ($data as $key => $stock)
            <tr>
                <td>{{++$key}}</td>
                <td>{{$stock->main_ic}}</td>
                <td>
                    <a class="" href='{{url("/store/fullstockReportView?pageType=&&parentCode=97&&m=Session::get('run_company')&&sub_item_id=$stock->sub_item_id&&warehouse_id=$stock->warehouse_id&&from_date=$from_date&&to_date=$to_date")}}' target="_blank">
                        {{ $stock->sub_ic }}
                    </a>
                    {{-- {{$stock->sub_ic}} --}}
                </td>
                <td>{{$stock->sku_code}}</td>
                <td>{{$stock->pack_size}}</td>
                <td>{{$stock->demand_name}}</td>
                <td>{{$stock->uom_name}}</td>
                <td>{{$stock->name}}</td>

                <td class="text-center;">{{number_format($stock->opening,2)}}</td>
                <td class="text-center;">@if(array_key_exists($stock->sub_item_id,$ratesArray)) {{number_format($ratesArray[$stock->sub_item_id],2) }} @endif</td>
                <td class="text-center;">{{number_format($stock->purchase,2)}}</td>
                <td class="text-center;">{{number_format($stock->produce_production,2)}}</td>
                <td class="text-center;">{{number_format($stock->purchase_return,2)}}</td>
                <td class="text-center;">{{number_format($stock->transfer,2)}}</td>
                <td class="text-center;">{{number_format($stock->consumption,2)}}</td>
                <td class="text-center;">{{number_format($stock->issuance,2)}}</td>
                <td class="text-center;">{{number_format($stock->issuance_return,2)}}</td>
                <td class="text-center;">{{number_format($stock->stock_adjustment_in,2)}}</td>
                <td class="text-center;">{{number_format($stock->stock_adjustment_out,2)}}</td>
                <td class="text-center;">{{number_format($stock->sales,2)}}</td>
                <td class="text-center;">{{number_format($stock->sales_return,2)}}</td>

                <td>{{$stock->current_stock}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

