<?php
use App\Helpers\CommonHelper;
use App\Helpers\PurchaseHelper;
use App\Helpers\ReuseableCode;
$approve = ReuseableCode::check_rights(474);
$m = Session::get('run_company');
$currentDate = date('Y-m-d');
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        {{ CommonHelper::displayPrintButtonInView('printDemandVoucherVoucherDetail', '', '1') }}
        @if ($goodsReturns->voucher_status == 1 && $approve)
            <a id="approved"href="#"onClick="approved({{ $goodsReturns->id }})" class="btn btn-success"
                style="padding: 10px;">Approved</a>
        @endif
    </div>
</div>
<div class="row" id="printDemandVoucherVoucherDetail">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                <label style="border-bottom:2px solid #000 !important;">Printed On Date&nbsp;:&nbsp;</label><label
                    style="border-bottom:2px solid #000 !important;">{{ CommonHelper::changeDateFormat($currentDate) }}</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"
                        style="font-size: 30px !important; font-style: inherit;
    								font-family: -webkit-body; font-weight: bold;">
                        {{ CommonHelper::getCompanyName($m) }}
                        <h3 style="text-align: center;">Workshop Goods Return Details</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                <label style="border-bottom:2px solid #000 !important;">Printed On Day&nbsp;:&nbsp;</label><label
                    style="border-bottom:2px solid #000 !important;">{{ '&nbsp;' . date('l', strtotime($currentDate)) }}</label>

            </div>
        </div>
        <div style="line-height:5px;">&nbsp;</div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                <table class="table table-bordered table-striped table-condensed tableMargin">
                    <tbody>
                        <tr>
                            <td>Voucher No.</td>
                            <td class="text-center">{{ strtoupper($goodsReturns->voucher_no) }}</td>
                        </tr>
                        <tr>
                            <td>Voucher Date</td>
                            <td class="text-center">{{ CommonHelper::changeDateFormat($goodsReturns->voucher_date) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Return Date</td>
                            <td class="text-center">{{ $goodsReturns->return_date }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"></div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                <table class="table table-bordered table-striped table-condensed tableMargin">
                    <tbody>
                        <tr>
                            <td>Maintenance Job No.</td>
                            <td class="text-center">{{ strtoupper($goodsReturns->maintenanceJob->voucher_no) }}
                            </td>
                        </tr>
                        <tr>
                            <td>From Department</td>
                            <td class="text-center">
                                {{ $goodsReturns->department->sub_department_name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Warehouse</td>
                            <td class="text-center">
                                {{ $goodsReturns->warehouse->name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed tableMargin">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:50px;">S.No</th>
                            <th class="text-center">Product</th>
                            <th class="text-center">Uom</th>
                            <th class="text-center">Quality Type</th>
                            <th class="text-center">Reason</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Rate</th>
                            <th class="text-center">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($goodsReturns->returnData as $key => $returnData)
                            <tr class="text-center">
                                <td class="text-center">{{ ++$key }}</td>
                                <td id="{{ $returnData->id }}" title="{{ $returnData->item_id }}" class="textChanger">
                                    {{ $returnData->subItem->sku_code . ' - ' . $returnData->subItem->sub_ic }}
                                </td>
                                <td>{{ $returnData->subItem->uomData->uom_name }}</td>
                                <td>{{ CommonHelper::qualityType()[$returnData->quality_type - 1]['name'] }}</td>
                                <td>{{ $returnData->item_remark }}</td>
                                <td class="text-center">{{ number_format($returnData->qty, 2) }}</td>
                                <td class="text-center">{{ number_format($returnData->rate, 2) }}</td>
                                <td class="text-center">{{ number_format($returnData->rate * $returnData->qty, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6"></th>
                            <th>Total</th>
                            <th>
                                @php
                                    $total = $goodsReturns->returnData->sum(function ($item) {
                                        return $item->qty * $item->rate;
                                    });
                                    echo number_format($total, 2);
                                @endphp
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div style="line-height:8px;">&nbsp;</div>
    </div>
</div>
<script type="text/javascript">
    function approved(param) {
        $.ajax({
            url: '{{ url('/workshop/approvedGoodsReturnDetails') }}',
            data: {
                id: param
            },
            type: 'GET',
            success: function(response) {
                if (response.error == 'error') {
                    alert('Can not Approved Because the Item is not exist in Record ' + response.message)
                    return false;
                } else if (response.error == 'success') {

                    alert('Approv Successfully');
                    $('#approved').remove();
                    getMaintenanceJobList();
                }
            }
        })
    }
</script>
