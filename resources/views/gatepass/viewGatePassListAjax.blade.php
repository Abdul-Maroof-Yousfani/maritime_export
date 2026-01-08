@foreach ($gatePasses as $key => $gatePass)
    <tr id="removeRow{{ $gatePass->id }}">
        <td>{{ ++$key }}</td>
        <td>{{ $gatePass->gate_pass_no }}</td>
        <td>{{ $gatePass->gate_pass_date }}</td>
        <td>{{ $gatePass->mo_no }}</td>
        @if ($gatePass->gate_pass_type == 1)
            <td>IN</td>
        @else
            <td>OUT</td>
        @endif
        <td>{{ $gatePass->created_by }}</td>
        <td>{{ $gatePass->company_location->location_name??'' }}</td>
        <td>
            {{-- @if ($view) --}}
            <button
                onclick="showDetailModelOneParamerter('/gatepass/viewGatePassDetail',{{ $gatePass->id }},'View Gate Pass Details')"
                type="button" class="btn btn-success btn-xs">View</button>
            {{-- @endif --}}
            {{-- @if ($edit == true) --}}
            {{-- @endif --}}
            {{-- @if ($delete == true) --}}
            @if ($gatePass->voucher_status == 1)
                <a class="edit-modal btn btn-xs btn-info"
                    href="{{ url('gatepass/editGatepassForm?id=' . $gatePass->id) }}">Edit</a>
                <button class="delete-modal btn btn-xs btn-danger"
                    onClick="deleteMaintenanceJob({{ $gatePass->id }})">Delete</button>
            @endif
            {{-- @endif --}}
        </td>
    </tr>
@endforeach
