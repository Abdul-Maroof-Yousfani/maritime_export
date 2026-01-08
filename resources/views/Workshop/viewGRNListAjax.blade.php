@php
    use App\Helpers\CommonHelper;
@endphp
@foreach ($grns as $key => $grn)
    <tr>
        <td>{{ ++$key }}</td>
        <td>{{ $grn->maintenanceJob->voucher_no }}</td>
        <td>{{ $grn->gate_pass_id ? $grn->gatepass->gate_pass_no : ''}}</td>
        <td>{{ $grn->voucher_no }}</td>
        <td>{{ $grn->voucher_date }}</td>
        <td>{{ $grn->maintenanceJob->supplier->name??'-' }}</td>
        <td>{{ $grn->location->location_name??'-' }}</td>
        <td>
            {{-- @if ($view) --}}
            <button
                onclick="showDetailModelOneParamerter('/workshop/viewGrnDetail',{{ $grn->id }},'View Workshop GRN Details')"
                type="button" class="btn btn-success btn-xs">View</button>
            {{-- @endif --}}
            {{-- @if ($edit == true) --}}
            {{-- @endif --}}
            @if ($grn->voucher_status == 1)
            <a class="edit-modal btn btn-xs btn-info"
                    href="{{ url('/workshop/editWorkshopGrnForm?id=' . $grn->id) }}">Edit</a>
                <button class="delete-modal btn btn-xs btn-danger"
                    onClick="deleteWorkshopGrn({{ $grn->id }})">Delete</button>
            @endif
        </td>
    </tr>
@endforeach
