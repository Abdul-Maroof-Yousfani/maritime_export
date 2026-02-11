
<?php

use App\Helpers\CommonHelper;
use App\Helpers\SalesHelper;
echo Form::open(array('url' => 'finance/CreateReceiptVoucherForCommercialInvoice?m='.$m,'id'=>'cashPaymentVoucherForm'));?>
<table class="table table-bordered sf-table-list" id="EmpExitInterviewList">
    <thead>

    <th class="text-center col-sm-1">S.No</th>
    <th class="text-center col-sm-1">Invoice No</th>
    <th class="text-center col-sm-1">Invoice Date</th>
    <th class="text-center col-sm-1">SO No</th>
    <th class="text-center">Terms Of Payment</th>
    <th class="text-center">Customer</th>
    <th class="text-center" style="min-width: 180px;">Invoice Amount</th>
    <th class="text-center" style="min-width: 180px;">Received Amount</th>
    <th class="text-center" style="min-width: 180px;">Remaining Amount</th>
    <th class="text-center">view</th>
    </thead>
    <tbody id="data">
    <?php $counter = 1;
    $total=0;
    $total_pkr=0;
    $received=0;
    $received_pkr=0;
    $remaining=0;
    $remaining_pkr=0;
    ?>

    @foreach($Invoice as $row)
        <?php
        CommonHelper::companyDatabaseConnection($_GET['m']);
        
        // Get currency information
        $currency = DB::Connection('mysql2')->table('currency')->where('id', $row->currency_id)->first();
        $currencyName = $currency->curreny ?? 'USD';
        $currencySymbol = '$'; // Default
        if ($currency) {
            $currencyCode = strtoupper($currencyName);
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
        
        // Get commercial invoice total amount (already in invoice currency)
        $invoice_amount = $row->grand_total ?? 0;
        
        // Convert invoice amount to PKR
        $exchangeRate = $row->exchange_rate ?? 1;
        $invoice_amount_pkr = $invoice_amount * $exchangeRate;
        
        // Get received payment for this commercial invoice (in PKR)
        $rece_pkr = SalesHelper::get_received_payment_commercial_invoice($row->id);
        
        // Convert received amount from PKR to invoice currency
        $rece = $exchangeRate > 0 ? ($rece_pkr / $exchangeRate) : 0;
        
        // Get customer name
        $customer = CommonHelper::byers_name($row->buyer_id);
        CommonHelper::reconnectMasterDatabase();

        // Calculate remaining amount (in invoice currency)
        // Use balance_amount if available (already in invoice currency), otherwise calculate
        $rema = $row->balance_amount ?? ($invoice_amount - $rece);
        
        // Convert remaining amount to PKR
        $rema_pkr = $rema * $exchangeRate;
        if($rema > 0):
        ?>
        <tr  @if($rema==0) style="background-color: #bdefbd" @endif title="{{$row->id}}" id="{{$row->id}}">

            <td class="text-center">
                @if($rema>0)
                <input name="checkbox[]" onclick="check(),supplier_check('',this.id)"
                       class="checkbox1 form-control AllCheckbox AddRemoveClass<?php echo $row->buyer_id?>"
                       id="<?php echo $row->buyer_id?>" type="checkbox" value="{{$row->id}}"
                       onchange="CheckUncheck('<?php echo $counter?>','<?php echo $row->buyer_id?>')" style="height: 30px;">
                    @else<p>Clear</p>
                    @endif
            </td>

            <td title="{{$row->id}}" class="text-center">{{strtoupper($row->invoice_no)}}</td>
            <td class="text-center"> <?php echo CommonHelper::changeDateFormat($row->invoice_date); ?></td>
            <td class="text-center">
                <?php 
                $so = DB::Connection('mysql2')->table('sale_order_exports')->where('id', $row->sale_order_export_id)->first();
                echo $so ? strtoupper($so->voucehr_no ?? '-') : '-';
                ?>
            </td>
            <td class="text-center">{{$row->payment_term ?? '-'}}</td>
            <td class="text-center">{{$customer->name ?? '-'}}</td>

            <?php
            $inv = $invoice_amount;
            $inv_pkr = $invoice_amount_pkr;
            ?>

            <td class="text-right" style="min-width: 180px;">
                <div>{{ $currencySymbol }} {{number_format($inv,2)}}</div>
                <div style="font-size: 11px; color: #666;">(PKR {{number_format($inv_pkr,2)}})</div>
            </td>
            <td class="text-right" style="min-width: 180px;">
                <div>{{ $currencySymbol }} {{number_format($rece,2)}}</div>
                <div style="font-size: 11px; color: #666;">(PKR {{number_format($rece_pkr,2)}})</div>
            </td>
            <td class="text-right" style="min-width: 180px;">
                <div>{{ $currencySymbol }} {{number_format($rema,2)}}</div>
                <div style="font-size: 11px; color: #666;">(PKR {{number_format($rema_pkr,2)}})</div>
            </td>

            <?php

            $total+=$inv;
            $total_pkr+=$inv_pkr;
            $received+=$rece;
            $received_pkr+=$rece_pkr;
            $remaining+=$rema;
            $remaining_pkr+=$rema_pkr;
            ?>
            <td class="text-center"><button
                        onclick="showDetailModelOneParamerter('export/viewCommercialInvoice','<?php echo $row->id ?>','View Commercial Invoice')"
                        type="button" class="btn btn-success btn-xs">View</button></td>




            {{--<td class="text-center"><a href="{{ URL::asset('purchase/editPurchaseVoucherForm/'.$row->id) }}" class="btn btn-success btn-xs">Edit </a></td>--}}
            {{--<td class="text-center"><button onclick="delete_record('{{$row->id}}')" type="button" class="btn btn-danger btn-xs">DELETE</button></td>--}}
        </tr>
        <?php   endif; ?>

    @endforeach


    <tr>
        <td class="text-center" colspan="6" style="background-color: darkgrey;font-size: 20px;">Total (PKR)</td>
        <td class="text-right" colspan="1" style="background-color: darkgrey;font-size: 20px;color: white;min-width: 180px;">PKR {{number_format($total_pkr,2)}}</td>
        <td class="text-right" colspan="1" style="background-color: darkgrey;font-size: 20px;min-width: 180px;">PKR {{number_format($received_pkr,2)}}</td>
        <td class="text-right" colspan="1" style="background-color: darkgrey;font-size: 20px;min-width: 180px;">PKR {{number_format($remaining_pkr,2)}}</td>
    </tr>
    <tr>
        <td colspan="10">
            <input type="submit" value="Create Receipt" class="btn btn-sm btn-primary BtnEnDs BtnSub" id="add">
        </td>
    </tr>
    </tbody>
</table>
<?php Form::close(); ?>
