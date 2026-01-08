<?php
use App\Helpers\CommonHelper;
use App\Helpers\SalesHelper;
$counter = 1;$total=0;?>

@foreach($sale_order as $row)
    <?php $data=SalesHelper::get_so_amount($row->id); ?>
    <?php $customer=CommonHelper::byers_name($row->buyers_id); ?>
    <tr @if ($row->so_type==1) style="background-color: lightyellow" @endif title="{{$row->id}}" id="{{$row->id}}">
        <td class="text-center">{{$counter++}}</td>
        <td title="{{$row->id}}" class="text-center">@if ($row->so_type==0) {{strtoupper($row->so_no)}} @else {{strtoupper($row->so_no.' ('.$row->description.')')}}@endif</td>
        <td class="text-center"><?php  echo CommonHelper::changeDateFormat($row->so_date);?></td>
        <td class="text-center">{{$row->model_terms_of_payment}}</td>
        <td class="text-center"><?php echo $row->order_no?></td>
        <td class="text-center"><?php  echo CommonHelper::changeDateFormat($row->order_date);?></td>
        <td class="text-center">{{$customer->name}}</td>
        <td class="text-right">{{number_format($data->amount+$data->sales_tax,2)}}<?php $total+=$data->amount?></td>


        <td class="text-center"><button
                    onclick="showDetailModelOneParamerter('sales/viewSalesOrderDetail','<?php echo $row->id ?>','View Sales Order')"
                    type="button" class="btn btn-success btn-xs">View</button></td>

        <td class="text-center"><button
                    onclick="delivery_note('<?php echo $row->id?>','<?php echo $m ?>')"
                    type="button" class="btn btn-primery btn-xs">Create Delivery Note</button></td>
    </tr>


@endforeach


<tr>
    <td class="text-center" colspan="6" style="background-color: darkgrey;font-size: 20px;">Total</td>
    <td class="text-right" colspan="1" style="background-color: darkgrey;font-size: 20px;color: white">{{number_format($total,2)}}</td>
    <td class="text-center" colspan="1" style="background-color: darkgrey;font-size: 20px;"></td>
    <td class="text-center" colspan="1" style="background-color: darkgrey;font-size: 20px;"></td>
</tr>