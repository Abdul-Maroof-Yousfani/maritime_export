@foreach ($gatepasses as $key => $gatepass)
    <tr class="text-center">
        <td>{{++$key}}</td>
        <td>{{$gatepass['gate_pass_no']}}</td>
        <td>{{$gatepass['po_no']}}</td>
        <td>{{$gatepass['inspection_no']}}</td>
        <td>{{$gatepass['date']}}</td>
        <td>{{$gatepass['recived_qty']}}</td>
        <td>{{$gatepass['user_name']}}</td>
      
        <td>
            {{-- @if ($view) --}}
            <button
                onclick="showDetailModelOneParamerter('arrival/Viewgatepass',{{ $gatepass->id }},'View Gate Pass (In)')"
                type="button" class="btn btn-success btn-xs">View</button>
            {{-- @endif --}}
            {{-- @if ($edit == true) --}}
            {{-- @endif --}}
            {{-- @if ($delete == true) --}}
            @if ($gatepass['status'] == 1)
                <a class="edit-modal btn btn-xs btn-info"
                    href="{{ url('gatepass/editGatepassForm?id=' . $gatepass['id']) }}">Edit</a>
                <button class="delete-modal btn btn-xs btn-danger"
                    onClick="deleteMaintenanceJob({{ $gatepass['id'] }})">Delete</button>
            @endif
            {{-- @endif --}}
        </td>
    </tr>
@endforeach