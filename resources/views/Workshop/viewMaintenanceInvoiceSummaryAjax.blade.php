<?php
    $counter = 1;
    use App\Helpers\CommonHelper;
    foreach($getDetail as $gdRow){
?>
        <tr>
            <td class="text-center"><?php echo $counter++;?></td>
            <td>{{$gdRow->warehouseName}}</td>
            <td>{{CommonHelper::get_sub_dept_name($gdRow->department_id)}}</td>
            <td>{{$gdRow->line_name ?? ''}}</td>
            <td>{{$gdRow->sub_ic}}</td>
            <td class="text-center">{{$gdRow->mrVoucherNo}}</td>
            <td class="text-center">{{$gdRow->mrVoucherDate}}</td>
            <td class="text-center">{{$gdRow->mrdQty}}</td>
            <td class="text-center">{{$gdRow->mrVoucherStatus}}</td>
            <td class="text-center">{{$gdRow->mjVoucherNo}}</td>
            <td class="text-center">{{$gdRow->mjVoucherDate}}</td>
            <td>{{$gdRow->mjJobType}}</td>
            <td>{{$gdRow->mjVoucherStatus}}</td>
            <td class="text-center">{{$gdRow->miVoucherNo}}</td>
            <td class="text-center">{{$gdRow->miVoucherDate}}</td>
            <td>{{$gdRow->miVoucherStatus}}</td>
            <?php 
                $maintenance_invoice_data=DB::connection('mysql2')->table('maintenance_invoice_datas')->where('maintenance_invoice_id',$gdRow->mi_id)->get();
            ?>
            {{-- <td > --}}
                {{-- @foreach($maintenance_invoice_data as $val) --}}
                <td><?php echo CommonHelper::get_item_name($gdRow->miditem_id); ?></td>
                <td><?php echo $gdRow->midqty; ?></td>
                <td><?php echo $gdRow->midreturn_qty; ?></td>
                <td><?php echo number_format($gdRow->midqty - $gdRow->midreturn_qty,2); ?></td>
                <td><?php echo $gdRow->midrate; ?></td>
                <td><?php echo $gdRow->midtotal; ?></td>
                {{-- <div style="border-bottom:1px solid black;">
                <span style="font-weight:bold;">Item: </span>{{ echo CommonHelper::get_item_name($val->item_id);}}</br>
                <span style="font-weight:bold;"> Qty: </span>{{ echo $val->qty;}}</br>
                
                <span style="font-weight:bold;"> Rate: </span>{{ echo $val->rate;}}</br>
                </div> --}}
                {{-- @endforeach --}}
            {{-- </td> --}}
            <td>{{$gdRow->labour_hour}}</td>
            <td>{{$gdRow->labour_wage}}</td>
            {{-- <td>{{$gdRow->gpoGatePassNo}}</td>
            <td>{{$gdRow->gpoGatePassDate}}</td>
            <td>{{$gdRow->gpoVoucherStatus}}</td>
            <td>{{$gdRow->gpiGatePassNo}}</td>
            <td>{{CommonHelper::changeDateFormat($gdRow->gpiGatePassDate)}}</td>
            <td>{{$gdRow->gpiVoucherStatus}}</td>
            <td class="text-center">{{$gdRow->wgVoucherNo}}</td>
            <td class="text-center">{{CommonHelper::changeDateFormat($gdRow->wgVoucherDate)}}</td>
            <td>{{$gdRow->wgVoucherStatus}}</td>
            <td>{{$gdRow->wmiVoucherNo}}</td>
            <td>{{CommonHelper::changeDateFormat($gdRow->wmiVoucherDate)}}</td> --}}
            {{-- <td>{{$gdRow->wmiVoucherStatus}}</td> --}}
        </tr>
<?php
    }
?>