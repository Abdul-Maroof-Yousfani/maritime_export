@php
    use App\Helpers\CommonHelper;

    $demandStatus = ['1' => 'PENDING', '2' => 'APPROVED', '3' => 'APPROVED'];
@endphp
@foreach ($query as $key => $value)
    <tr>
        <td>{{ ++$key }}</td>
        <td>{{ $value->sub_ic }}</td>
        <td>{{ App\Helpers\CommonHelper::get_uom_by_uom_id($value->uom) }}</td>
        <td>{{ $value->demand_no }}</td>
        <td>{{ $value->qty }}</td>
        <td>{{ $demandStatus[$value->demand_status] }}</td>
        <td>{{ $value->voucher_no ?? 'Not Created' }}</td>
        <td>{{ $value->qoutation_qty ?? 'Not Created' }}</td>
        <td>{{ $value->purchase_request_no ?? 'Not Created' }}</td>
        <td>{{ $value->purchase_approve_qty ?? 'Not Created' }}</td>
        <td>{{ $value->grn_no ?? 'Not Created' }}</td>
        <td>{{ $value->purchase_recived_qty ?? 'Not Created' }}</td>
        <td>{{ CommonHelper::getLocationDetail($value->company_location_id)->location_name??'' }}</td>
    </tr>
@endforeach
