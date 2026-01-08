<?php
use App\Helpers\CommonHelper;

$rowscostTotalAmount = 0;
$rowscostAmount = 0;
$rowsfreight=0;
$rowscommission=0;
$rowsbardana=0;
$rowsbroken=0;
$rowsdamage=0;
$rowschobba=0;
$rowso_v=0;
$rowschalky=0;
$rowslook=0;
$rowsmoisture=0;
$rowsbags=0;

?>


<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel">
            <div class="panel-body">
                <div class="row">

                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Category</label>
                            <span class="rflabelsteric"><strong>*</strong></span>
                            <input type="text"
                                   value="{{CommonHelper::getCatergoryyAnditemData($purcahseOrder->category_id)->name}}"
                                   class="form-control requiredFiel" disabled/>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Sub Category</label>
                            <span class="rflabelsteric"><strong>*</strong></span>
                            <input type="text"
                                   value="{{CommonHelper::getCatergoryyAnditemData($purcahseOrder->sub_category_id)->name}}"
                                   class="form-control requiredFiel" disabled/>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Variety</label>
                            <span class="rflabelsteric"><strong>*</strong></span>
                            <input type="text"
                                   value="{{CommonHelper::getCatergoryyAnditemData($purcahseOrder->product_id)->name}}"
                                   class="form-control requiredFiel" disabled/>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Sub Variety</label>
                            <span class="rflabelsteric"><strong>*</strong></span>
                            <input type="text"
                                   value="{{CommonHelper::getCatergoryyAnditemData($purcahseOrder->subitem_id)->name}}"
                                   class="form-control requiredFiel" disabled/>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Item</label>
                            <span class="rflabelsteric"><strong>*</strong></span>
                            <input type="text"
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
                    <div class="row" style="margin-top: 20px">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive" id="filterBookDayList">
                                <table id="data" class="table table-bordered">
                                    <thead>
                                    <th class="text-center first-col sticky-col ">Date</th>
                                    <th class="text-center second-col sticky-col">Truck </th>
                                    <th class="text-center">Qty Bags</th>

                                    <th class="text-center">Qty Kg</th>
                                    <th class="text-center">Moisture (KG)</th>
                                    <th class="text-center">Remaining Qty</th>


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
                                    @if(count($finalInspection) != 0)
                                    @foreach($finalInspection as $key => $fi)
                                            <?php
                                            $qtyafterCalc = $fi->recived_qty - optional($fi->moisture1)->total_deduction_update;

//                                                $costAmount =  $purcahseOrder->landed_rate_per_kg*$fi->recived_qty;
                                            $costAmount =  $purcahseOrder->landed_rate_per_kg*$qtyafterCalc;
                                            $totalBags =   $fi->recived_qty/100;
                                            $bardana = $totalBags*$purcahseOrder->bardana_per_bag;
                                            $commission = $totalBags*$purcahseOrder->commission_per_bag;
                                            $freight = $fi->recived_qty*$purcahseOrder->freight_per_traller;
                                            $broken =optional($fi->broken1)->total_deduction_update;
                                            $damage =optional($fi->damage1)->total_deduction_update;
                                            $chobba =optional($fi->chobba1)->total_deduction_update;
                                            $o_v =optional($fi->o_v1)->total_deduction_update;
                                            $chalky =optional($fi->chalky1)->total_deduction_update;
                                            $look =optional($fi->look1)->total_deduction_update;
//                                                KGssssssssssssssss
                                            $moisture =optional($fi->moisture1)->total_deduction_update;

                                            $totalDeductions = $broken+$damage+$chobba+$o_v+$chalky+$look;

                                            $costTotalAmount = (int)$costAmount+(int)$bardana+(int)$commission+(int)$freight-$totalDeductions;


                                            //Rows Totals
                                            $rowscostAmount += $costAmount;
                                            $rowscostTotalAmount += $costTotalAmount;
                                            $rowsfreight += $freight;
                                            $rowscommission += $commission;
                                            $rowsbardana += $bardana;
                                            $rowsbroken += $broken;
                                            $rowsdamage += $damage;
                                            $rowschobba += $chobba;
                                            $rowso_v += $o_v;
                                            $rowschalky += $chalky;
                                            $rowslook += $look;
                                            $rowsmoisture += $moisture;
                                            $rowsbags += $totalBags;

                                            ?>


                                            <tr>
                                                <td class="text-center first-col sticky-col">
                                                    <input type="hidden" value="{{$fi->id}}" name="final_ins_id[]">
                                                    <input type="hidden" value="{{$fi->ins_no}}" name="final_ins_no[]">
                                                    <input style="width: 120px;" type="text" name="date[]" value="{{ $fi->created_at->format('d-m-Y') }}" readonly  class="form-control" >
                                                </td>
                                                <td class="text-center second-col sticky-col">
                                                    <input style="width: 120px;" name="truck_no[]" type="text" value="{{$fi->truck_no}}" readonly class="form-control">
                                                </td>
                                                <td class="text-center">
                                                    <input style="width: 120px;" name="received_bags[]" type="text" value="{{$totalBags}}" readonly class="form-control">
                                                </td>

                                                <td class="text-center">
                                                    <input style="width: 120px;"  name="received_kg[]" type="text" value="{{$fi->recived_qty}}" readonly class="form-control">
                                                </td>
                                                <td class="text-center">
                                                    <input style="width: 120px;" name="moisture[]" type="text" value="-{{optional($fi->moisture1)->total_deduction_update}}" readonly class="form-control subtract">
                                                </td>
                                                <td class="text-center">
                                                    <input style="width: 120px;"  name="remaining_qty_afterdeduction[]" type="text" value="{{$qtyafterCalc}}" readonly class="form-control">
                                                </td>
                                                <td class="text-center">
                                                    <input style="width: 120px;" name="rate_per_kg[]" type="text" value="{{$purcahseOrder->landed_rate_per_kg}}" readonly class="form-control">
                                                </td>
                                                <td class="text-center">
                                                    <input style="width: 120px;" name="cost_amount[]" type="text" value="{{ $costAmount }}" readonly class="form-control">
                                                </td>
                                                <td class="text-center">
                                                    <input  style="width: 120px;" name="freight[]" type="text" value="{{ $freight}}" readonly class="form-control">
                                                </td>
                                                <td class="text-center">
                                                    <input style="width: 120px;" name="commission[]" type="text" value="{{ number_format($commission,2)}}" readonly class="form-control">
                                                </td>
                                                <td class="text-center">
                                                    <input  style="width: 120px;" name="bardana[]" type="text" value="{{ number_format($bardana,2)}}" readonly class="form-control">
                                                </td>
                                                <td class="text-center">
                                                    <input name="broken[]" style="width: 120px;" type="text" value="-{{optional($fi->broken1)->total_deduction_update}}" readonly class="form-control subtract">
                                                </td>
                                                <td class="text-center">
                                                    <input name="damage[]" style="width: 120px;" type="text" value="-{{optional($fi->damage1)->total_deduction_update}}" readonly class="form-control subtract">
                                                </td>
                                                <td class="text-center">
                                                    <input name="chobba[]" style="width: 120px;" type="text" value="-{{optional($fi->chobba1)->total_deduction_update}}" readonly class="form-control subtract">
                                                </td>
                                                <td class="text-center">
                                                    <input name="chalky[]" style="width: 120px;" type="text" value="-{{optional($fi->chalky1)->total_deduction_update}}" readonly class="form-control subtract">
                                                </td>
                                                <td class="text-center">
                                                    <input name="o_v[]" style="width: 120px;" type="text" value="-{{optional($fi->o_v1)->total_deduction_update}}" readonly class="form-control subtract">
                                                </td>
                                                <td class="text-center">
                                                    <input name="look[]" style="width: 120px;" type="text" value="-{{optional($fi->look1)->total_deduction_update}}" readonly class="form-control subtract">
                                                </td>
                                                <td class="text-center">
                                                    <input min="0" max="{{$costTotalAmount}}" name="discount[]" style="width: 120px;" type="text" value="0"  class="form-control subtract">
                                                </td>

                                                <td class="text-center">
                                                    <input style="width: 120px;" name="bill_amount[]" type="text" value="{{$costTotalAmount}}" readonly class="form-control">
                                                </td>
                                                <td class="text-center">
                                                    <input style="width: 120px;" name="bill_no[]" type="text" value="" class="form-control">
                                                </td>
                                                {{--                                                <td class="text-center">--}}
                                                {{--                                                    <button type="button" class="btn">X</button>--}}
                                                {{--                                                </td>--}}
                                            </tr>
                                            @endforeach

                                            <tr>
                                                <td class="text-center first-col sticky-col">
                                                    <h4 style="font-weight: 700">Total</h4>
                                                </td>
                                                <td class="text-center second-col sticky-col">
                                                </td>

                                                <td>
                                                    <input style="width: 120px;"  type="text" value="{{number_format($rowsbags,2)}}" class="form-control" disabled>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input style="width: 120px;"  type="text" value="{{number_format($rowsmoisture,2)}}" class="form-control subtract" disabled>
                                                </td>
                                                <td></td>
                                                <td></td>

                                                <td>
                                                    <input style="width: 120px;"  type="text" value="{{number_format($rowscostAmount,2)}}" class="form-control" disabled>
                                                </td>
                                                <td>
                                                    <input style="width: 120px;"  type="text" value="{{number_format($rowsfreight,2)}}" disabled class="form-control">
                                                </td>
                                                <td>
                                                    <input style="width: 120px;"  type="text" value="{{number_format($rowscommission,2)}}" disabled class="form-control">
                                                </td>
                                                <td>
                                                    <input style="width: 120px;"  type="text" value="{{number_format($rowsbardana,2)}}" disabled class="form-control ">
                                                </td>
                                                <td>
                                                    <input style="width: 120px;"  type="text" value="{{number_format($rowsbroken,2)}}" disabled class="form-control subtract">
                                                </td>
                                                <td>
                                                    <input style="width: 120px;"  type="text" value="{{number_format($rowsdamage,2)}}" disabled class="form-control subtract">
                                                </td>
                                                <td>
                                                    <input style="width: 120px;"  type="text" value="{{number_format($rowschobba,2)}}" disabled class="form-control subtract">
                                                </td>
                                                <td>
                                                    <input style="width: 120px;"  type="text" value="{{number_format($rowschalky,2)}}" disabled class="form-control subtract">
                                                </td>
                                                <td>
                                                    <input style="width: 120px;"  type="text" value="{{number_format($rowso_v,2)}}" disabled class="form-control subtract">
                                                </td>
                                                <td>
                                                    <input style="width: 120px;"  type="text" value="{{number_format($rowslook,2)}}" disabled class="form-control subtract">
                                                </td>


                                                <td></td>
                                                <td>
                                                    <input style="width: 120px;" name="total_bill_amount_sum"  disabled type="text" value="{{number_format($rowscostTotalAmount,2)}}" class="form-control">
                                                </td>


                                            </tr>
                                    @else
                                        <tr>
                                            <td colspan="20">
                                                No record found
                                                <input type="hidden" name="truck_no">
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>





                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to remove a row
    $('button.btn').on('click', function() {
        $(this).closest('tr').remove();
        updateBillAmount(); // Update totals after removing a row
    });

    // Function to update bill amount when discount is entered
    function updateBillAmount() {
        let totalBillAmount = 0;

        // Loop through each row
        $('tr').each(function() {
            let costTotalAmount = parseFloat($(this).find('input[name="bill_amount[]"]').data('original-amount')) || 0;
            let discount = parseFloat($(this).find('input[name="discount[]"]').val()) || 0;

            // Calculate the new bill amount after applying discount
            let newBillAmount = costTotalAmount - discount;

            // Update the bill amount in the row
            $(this).find('input[name="bill_amount[]"]').val(newBillAmount.toFixed(2));

            // Add to total bill amount
            totalBillAmount += newBillAmount;
        });

        // Update the total row with the recalculated totals
        $('input[name="total_bill_amount_sum"]').val(totalBillAmount.toFixed(2));
    }

    // Attach event listener for changes in the discount field
    $('input[name="discount[]"]').on('input', function() {
        updateBillAmount();
    });

    // Initialize bill amount data attributes for each row
    $('tr').each(function() {
        let costTotalAmount = parseFloat($(this).find('input[name="bill_amount[]"]').val()) || 0;
        $(this).find('input[name="bill_amount[]"]').attr('data-original-amount', costTotalAmount);
    });

    // Call the function initially to set the total
    updateBillAmount();


</script>