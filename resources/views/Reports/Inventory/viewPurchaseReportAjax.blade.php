@php
    
use App\Helpers\CommonHelper;
@endphp
@foreach ($grn as $key => $gr)
    <tr>
        <td>{{++$key}}</td>
        <td>{{$gr->subItem->sub_ic}}</td>
        <td>{{$gr->name}}</td>
        <td>{{$gr->pr_no}}</td>
        <td>{{$gr->voucher_no}}</td>
        <td>{{$gr->purchase_request_no}}</td>
        <td>{{$gr->grn_no}}</td>
        <td>{{$gr->challan_no ?? ''}}</td>
        <td>{{date('d-m-Y',strtotime($gr->grn_date))}}</td>
        <td>{{$gr->received_type}}</td>
        <td>{{$gr->purchase_recived_qty}}</td>
        <td>{{$gr->net_amount}}</td>
        <td>{{CommonHelper::getLocationDetail($gr->company_location_id)->location_name??'' }}</td>
    </tr>
@endforeach