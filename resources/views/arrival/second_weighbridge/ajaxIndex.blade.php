<?php
use App\Helpers\CommonHelper;
?>
@foreach ($weighbridges as $key => $weighbridge)
    <tr class="text-center">
        <td>{{++$key}}</td>
        <td>{{$weighbridge->po_no}}</td>
        <td>{{$weighbridge->weighbridge_no}}</td>
        <td>{{$weighbridge->gate_pass_no}}</td>
        <td>{{$weighbridge->inspection_no}}</td>
        <td>{{$weighbridge->vehicle_no}}</td>
        <td>{{date('M-Y', strtotime($weighbridge->date)). ' - ' . date('M-Y', strtotime($weighbridge->date)) }}</td>
        <td>{{$weighbridge->no_of_pkgs}}</td>
        <td>{{$weighbridge->consignee_weight}}</td>
        <td>{{$weighbridge->goods_description}}</td>
        <td>{{$weighbridge->gross_weight}}</td>
        <td>
            {{-- @if ($view) --}}
            <button
                onclick="showDetailModelOneParamerter('arrival/ViewSecondweighbridge',{{ $weighbridge->id }},'View Weight bridge Details')"
                type="button" class="btn btn-success btn-xs">View</button>
            {{-- @endif --}}
            {{-- @if ($edit == true) --}}
            {{-- @endif --}}
            {{-- @if ($delete == true) --}}
            @if ($weighbridge->status == 1)
                <a class="edit-modal btn btn-xs btn-info"
                    href="{{ url('gatepass/editGatepassForm?id=' . $weighbridge->id) }}">Edit</a>
                <button class="delete-modal btn btn-xs btn-danger"
                    onClick="deleteMaintenanceJob({{ $weighbridge->id }})">Delete</button>
            @endif
            {{-- @endif --}}
        </td>
    </tr>
@endforeach