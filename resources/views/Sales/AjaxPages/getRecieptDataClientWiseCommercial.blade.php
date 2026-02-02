
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
    <th class="text-center">Invoice Amount (USD)</th>
    <th class="text-center">Received Amount</th>
    <th class="text-center">Remaining Amount</th>
    <th class="text-center">view</th>
    </thead>
    <tbody id="data">
    <?php $counter = 1;
    $total=0;
    $received=0;
   $remaining=0;
    ?>

    @foreach($Invoice as $row)
        <?php
        CommonHelper::companyDatabaseConnection($_GET['m']);
        // Get commercial invoice total amount
        $invoice_amount = $row->grand_total * ($row->exchange_rate ?? 0);
        // Get received payment for this commercial invoice
        $rece = SalesHelper::get_received_payment_commercial_invoice($row->id);
        // Get customer name
        $customer = CommonHelper::byers_name($row->buyer_id);
        CommonHelper::reconnectMasterDatabase();

        // Calculate remaining amount
        $rema = $invoice_amount - $rece;
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
            ?>

            <td class="text-right"> {{number_format($inv,2)}}</td>
            <?php
            $rema = $invoice_amount - $rece;
            ?>
            <td class="text-right">{{number_format($rece,2)}}</td>
            <td class="text-right">{{number_format($rema,2)}}</td>

            <?php

            $total+=$inv;
            $received+=$rece;
            $remaining+=$rema;
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
        <td class="text-center" colspan="6" style="background-color: darkgrey;font-size: 20px;">Total</td>
        <td class="text-right" colspan="1" style="background-color: darkgrey;font-size: 20px;color: white">$ {{number_format($total,2)}}</td>
        <td class="text-right" colspan="1" style="background-color: darkgrey;font-size: 20px;">{{number_format($received,2)}}</td>
        <td class="text-right" colspan="1" style="background-color: darkgrey;font-size: 20px;">$ {{number_format($remaining,2)}}</td>
    </tr>
    <tr>
        <td colspan="10">
            <input type="submit" value="Create Receipt" class="btn btn-sm btn-primary BtnEnDs BtnSub" id="add">
        </td>
    </tr>
    </tbody>
</table>
<?php Form::close(); ?>
