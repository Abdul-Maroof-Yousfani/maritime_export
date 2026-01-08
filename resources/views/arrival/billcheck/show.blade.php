<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
?>
<style>
    #getPoDataForBillCheck input.form-control {
        height: 25px !important;
        margin-bottom: 0;
        font-size: 12px;
    }
    input.subtract {
        color: #cb0000;

    }
    /*#getPoDataForBillCheck th {*/
    /*    width: 15% !important;*/
    /*}*/


    .sticky-col {
        position: -webkit-sticky;
        position: sticky;
        background-color: white;
        z-index: 1;
        background: #d1d1d1;
    }

    /* Fixed Start Column */
    .first-col {
        left: 0;
        z-index: 2; /* Ensures the first column stays on top */
    }
    .second-col {
        left: 10%;
        z-index: 2; /* Ensures the first column stays on top */
    }

    /* Fixed End Columns */
    .last-col-1 {
        right: 200px; /* Adjust this value based on the width of the last two columns */
        z-index: 2;
    }

    .last-col-2 {
        right: 0;
        z-index: 2;
    }
</style>
<div id="getPoDataForBillCheck">
<div class="row">
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <label>Category</label>
        <span class="rflabelsteric"><strong>*</strong></span>
        <input type="text" name="truck_no" id="truck_no"
               value="{{CommonHelper::getCatergoryyAnditemData($purcahseOrder->category_id)->name}}"
               class="form-control requiredFiel" disabled/>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <label>Sub Category</label>
        <span class="rflabelsteric"><strong>*</strong></span>
        <input type="text" name="truck_no" id="truck_no"
               value="{{CommonHelper::getCatergoryyAnditemData($purcahseOrder->sub_category_id)->name}}"
               class="form-control requiredFiel" disabled/>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label>Variety</label>
        <span class="rflabelsteric"><strong>*</strong></span>
        <input type="text" name="truck_no" id="truck_no"
               value="{{CommonHelper::getCatergoryyAnditemData($purcahseOrder->product_id)->name}}"
               class="form-control requiredFiel" disabled/>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label>Sub Variety</label>
        <span class="rflabelsteric"><strong>*</strong></span>
        <input type="text" name="truck_no" id="truck_no"
               value="{{CommonHelper::getCatergoryyAnditemData($purcahseOrder->subitem_id)->name}}"
               class="form-control requiredFiel" disabled/>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <label>Item</label>
        <span class="rflabelsteric"><strong>*</strong></span>
        <input type="text" name="truck_no" id="truck_no"
               value="{{CommonHelper::getCatergoryyAnditemData($purcahseOrder->item_id)->name}}"
               class="form-control requiredFiel" disabled/>
    </div>
</div>
<div class="row" style="">
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <label>PO No.</label>
        <span class="rflabelsteric"><strong>*</strong></span>
        <input type="text" name="no_of_bags" id="no_of_bags"
               value="{{$purcahseOrder->voucher_no}}"
               class="form-control requiredFiel" disabled/>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <label>PO Date</label>
        <span class="rflabelsteric"><strong>*</strong></span>
        <input type="text" name="no_of_bags" id="no_of_bags"
               value="{{$purcahseOrder->voucher_date}}"
               class="form-control requiredFiel" disabled/>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label>Required Date</label>
        <span class="rflabelsteric"><strong>*</strong></span>
        <input type="text" name="no_of_bags" id="no_of_bags"
               value="{{$purcahseOrder->req_date}}"
               class="form-control requiredFiel" disabled/>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label>Promise Date</label>
        <span class="rflabelsteric"><strong>*</strong></span>
        <input type="text" name="no_of_bags" id="no_of_bags"
               value="{{$purcahseOrder->promise_date}}"
               class="form-control requiredFiel" disabled/>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <label>Location</label>
        <span class="rflabelsteric"><strong>*</strong></span>
        <input type="text" name="no_of_bags" id="no_of_bags"
               value="{{$purcahseOrder->ArrivalLocation}}"
               class="form-control requiredFiel" disabled/>
    </div>
</div>
<div class="row" style="">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <label>Seller Name</label>
        <input type="text" name="no_of_bags" id="no_of_bags"
               value="{{$purcahseOrder->SupplierName}}"
               class="form-control requiredFiel" disabled/>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label>QTY Bags</label>
        <input type="text" name="no_of_bags" id="no_of_bags"
               value="{{$purcahseOrder->min_qty_bag}}"
               class="form-control requiredFiel" disabled/>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label>QTY KG</label>
        <input type="text" name="no_of_bags" id="no_of_bags"
               value="{{$purcahseOrder->min_qty_kg}}"
               class="form-control requiredFiel" disabled/>
    </div>
</div>
<div class="row"  style="margin-top: 20px">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive" id="filterBookDayList">
            <table id="data" class="table table-bordered">
                <thead>
                <th class="text-center first-col sticky-col ">Date</th>
                <th class="text-center second-col sticky-col">Truck </th>
                <th class="text-center">Qty Bags</th>
                <th class="text-center">Moisture (KG)</th>
                <th class="text-center">Qty Kg</th>
                <th class="text-center">Rate</th>
                <th class="text-center">Cost Amt</th>
                <th class="text-center">Freight</th>
                <th class="text-center">Comm</th>
                <th class="text-center">Bardana</th>

                <th class="text-center">Broken (Rs)</th>
                <th class="text-center">Damage (Rs)</th>
                <th class="text-center">Chobba (Rs)</th>
                <th class="text-center">Chalky (Rs)</th>
                <th class="text-center">O.V (Rs)</th>
                <th class="text-center">Look (Rs)</th>
                <th class="text-center">Discount Amt</th>
                <th class="text-center ">Bill Amt</th>
                <th class="text-center">Bill ID</th>
                </thead>
                <tbody id="viewProductList">
                @foreach($billcheck as $billchecks)
                    <tr>
                        <td class="text-center first-col sticky-col">
{{--                            {{ $billchecks->date->format('d-m-Y') }}--}}
{{--                            <input type="hidden" value="{{$billcheck->id}}" name="final_ins_id[]">--}}
{{--                            <input type="hidden" value="{{$billcheck->final_ins_no}}" name="final_ins_no[]">--}}
                            <input style="width: 120px;" type="text" name="date[]" value="{{ $billchecks->date }}" readonly  class="form-control" >
                        </td>
                        <td class="text-center second-col sticky-col">
                            <input style="width: 120px;" name="truck_no[]" type="text" value="{{$billchecks->truck_no}}" readonly class="form-control">
                        </td>
                        <td class="text-center">

                            <input style="width: 120px;" name="received_bags[]" type="text" value="{{$billchecks->received_bags}}" readonly class="form-control">
                        </td>
                        <td class="text-center">
                            <input style="width: 120px;" name="moisture[]" type="text" value="{{$billchecks->moisture}}" readonly class="form-control subtract">
                        </td>
                        <td class="text-center">
                            <input style="width: 120px;"  name="received_kg[]" type="text" value="{{$billchecks->received_kg}}" readonly class="form-control">
                        </td>
                        <td class="text-center">
                            <input style="width: 120px;" name="rate_per_kg[]" type="text" value="{{$billchecks->rate_per_kg}}" readonly class="form-control">
                        </td>
                        <td class="text-center">
                            <input style="width: 120px;" name="cost_amount[]" type="text" value="{{ $billchecks->cost_amount }}" readonly class="form-control">
                        </td>
                        <td class="text-center">
                            <input  style="width: 120px;" name="freight[]" type="text" value="{{ $billchecks->freight}}" readonly class="form-control">
                        </td>
                        <td class="text-center">
                            <input style="width: 120px;" name="commission[]" type="text" value="{{$billchecks->commission}}" readonly class="form-control">
                        </td>
                        <td class="text-center">
                            <input  style="width: 120px;" name="bardana[]" type="text" value="{{$billchecks->bardana}}" readonly class="form-control">
                        </td>
                        <td class="text-center">
                            <input name="broken[]" style="width: 120px;" type="text" value="{{$billchecks->broken}}" readonly class="form-control subtract">
                        </td>
                        <td class="text-center">
                            <input name="damage[]" style="width: 120px;" type="text" value="{{$billchecks->damage}}" readonly class="form-control subtract">
                        </td>
                        <td class="text-center">
                            <input name="chobba[]" style="width: 120px;" type="text" value="{{$billchecks->chobba}}" readonly class="form-control subtract">
                        </td>
                        <td class="text-center">
                            <input name="chalky[]" style="width: 120px;" type="text" value="{{$billchecks->chalky}}" readonly class="form-control subtract">
                        </td>
                        <td class="text-center">
                            <input name="o_v[]" style="width: 120px;" type="text" value="{{$billchecks->o_v}}" readonly class="form-control subtract">
                        </td>
                        <td class="text-center">
                            <input name="look[]" style="width: 120px;" type="text" value="{{$billchecks->look}}" readonly class="form-control subtract">
                        </td>
                        <td class="text-center">
                            <input min="0" max="" name="discount[]" style="width: 120px;" type="text" readonly value="{{$billchecks->discount}}"  class="form-control subtract">
                        </td>

                        <td class="text-center">
                            <input style="width: 120px;" name="bill_amount[]" type="text" value="{{$billchecks->bill_amount}}" readonly class="form-control">
                        </td>
                        <td class="text-center">
                            <input style="width: 120px;" name="bill_no[]" type="text" value="{{$billchecks->bill_no}}" readonly class="form-control">
                        </td>
                        {{--                                                <td class="text-center">--}}
                        {{--                                                    <button type="button" class="btn">X</button>--}}
                        {{--                                                </td>--}}
                    </tr>
                @endforeach
{{--                <tr>--}}
{{--                    <td class="text-center first-col sticky-col">--}}
{{--                        <h4 style="font-weight: 700">Total</h4>--}}
{{--                    </td>--}}
{{--                    <td class="text-center second-col sticky-col">--}}
{{--                    </td>--}}

{{--                    <td>--}}
{{--                        <input style="width: 120px;"  type="text" value="{{number_format($billcheck_totals->received_bags,2)}}" class="form-control" disabled>--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input style="width: 120px;"  type="text" value="{{number_format($billcheck_totals->moisture,2)}}" class="form-control subtract" disabled>--}}
{{--                    </td>--}}
{{--                    <td></td>--}}
{{--                    <td></td>--}}

{{--                    <td>--}}
{{--                        <input style="width: 120px;"  type="text" value="{{$billcheck_totals->cost_amount}}" class="form-control" disabled>--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input style="width: 120px;"  type="text" value="{{number_format($billcheck_totals->freight,2)}}" disabled class="form-control">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input style="width: 120px;"  type="text" value="{{number_format($billcheck_totals->total_bill_amount,2)}}" disabled class="form-control">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input style="width: 120px;"  type="text" value="{{number_format($billcheck_totals->total_bill_amount,2)}}" disabled class="form-control ">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input style="width: 120px;"  type="text" value="{{number_format($billcheck_totals->total_bill_amount,2)}}" disabled class="form-control subtract">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input style="width: 120px;"  type="text" value="{{number_format($billcheck_totals->total_bill_amount,2)}}" disabled class="form-control subtract">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input style="width: 120px;"  type="text" value="{{number_format($billcheck_totals->total_bill_amount,2)}}" disabled class="form-control subtract">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input style="width: 120px;"  type="text" value="{{number_format($billcheck_totals->total_bill_amount,2)}}" disabled class="form-control subtract">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input style="width: 120px;"  type="text" value="{{number_format($billcheck_totals->total_bill_amount,2)}}" disabled class="form-control subtract">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input style="width: 120px;"  type="text" value="{{number_format($billcheck_totals->total_bill_amount,2)}}" disabled class="form-control subtract">--}}
{{--                    </td>--}}


{{--                    <td></td>--}}
{{--                    <td>--}}
{{--                        <input style="width: 120px;" name="total_bill_amount_sum"  disabled type="text" value="{{number_format($billcheck_totals->total_bill_amount,2)}}" class="form-control">--}}
{{--                    </td>--}}


{{--                </tr>--}}
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>