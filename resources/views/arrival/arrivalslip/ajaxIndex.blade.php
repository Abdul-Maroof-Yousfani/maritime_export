<?php use App\Helpers\CommonHelper; ?>
@foreach ($arrival_slips as $key => $arrival_slip)
    <tr class="text-center">
        <td>{{++$key}}</td>
        <td>{{$arrival_slip['po_no']}}</td>
        <td>{{$arrival_slip['gate_pass_no']}}</td>
        <td>{{$arrival_slip['inspection_no']}}</td>
        <td>{{$arrival_slip['arrival_slip_no']}}</td>
        <td>{{$arrival_slip['vehicle_no']}}</td>
        <td>{{ CommonHelper::get_supplier_name($arrival_slip['supplier_id'])}}</td>
        <td>{{$arrival_slip['arrival_date']}}</td>
        <td>{{$arrival_slip['no_of_pkgs']}}</td>
        <td>{{$arrival_slip['goods_description']}}</td>
        <td>{{$arrival_slip['gross_weight']}}</td>
       
        <td>
            {{-- @if ($view) --}}
            <button
                onclick="showDetailModelOneParamerter('arrival/Viewarrivalslip',{{ $arrival_slip->id }},'View Arrival Slip Details')"
                type="button" class="btn btn-success btn-xs">View</button>
            {{-- @endif --}}
            {{-- @if ($edit == true) --}}
            {{-- @endif --}}
            {{-- @if ($delete == true) --}}
                {{-- <a class="edit-modal btn btn-xs btn-info"
                    href="{{route('arrivalslip.edit',$arrival_slip->id)}}">Edit</a> --}}
                {{-- <button class="delete-modal btn btn-xs btn-danger"
                    onClick="deleteMaintenanceJob({{ $arrival_slip['id'] }})">Delete</button> --}}
            {{-- @endif --}}
        </td>
    </tr>
@endforeach