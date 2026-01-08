@php
use App\Helpers\CommonHelper;
@endphp
@foreach ($demandDatas as $key => $demandData)
    <tr>
        <td>{{++$key}}</td>
        <td>{{strtoupper($demandData->demand_no)}}</td>
        <td>{{date_format(new DateTime($demandData->demand_date),"d-M-Y")}}</td>
        <td>{{($demandData->subItem)? $demandData->subItem->sub_ic : '-'}}</td>
        <td>{{$demandData->sub_ic_desc}}</td>
        <td>{{($demandData->subItem)? $demandData->subItem->uomData->uom_name : '-'}}</td>
        <td>{{$demandData->qty}}</td>
        <td>{{$demandData->demand->department->sub_department_name??''}}</td>
        <td>{{CommonHelper::mode_type()[$demandData->demand->p_type]}}</td>
        <td>{{CommonHelper::getLocationDetail($demandData->company_location_id)->location_name??''}}</td>
    </tr>
@endforeach