@foreach ($gatepasses as $key => $gatepass)
    <tr class="text-center">
        <td>{{++$key}}</td>
        <td>{{$gatepass['gatepass_no']}}</td>
        <td>{{$gatepass['gatepass_type'] == 'returnable' ? 'Returnable' : 'None Returnable'}}</td>
        <td>{{date('d-m-Y', strtotime($gatepass['date']))}}</td>
        <td>{{$gatepass['vendor_name']}}</td>
        <td>{{$gatepass['warehouse_name']}}</td>
      
        <td>
            @php

                $type = $gatepass['gatepass_type'] == 'returnable' ? 'Returnable' : 'None Returnable';
                $name = 'View Gate Pass ('. $type . ')';
            @endphp
            @if ($gatepass['status'] == 1)
                <button
                onclick="showDetailModelOneParamerter('purchase/ViewGatepass',{{ $gatepass->id }},'{{$name}}')"
                type="button" class="btn btn-success btn-xs">View</button>
                <a class="edit-modal btn btn-xs btn-info"
                    href="{{ url('purchase/editGatepassForm?id=' . $gatepass['id']) }}">Edit</a>
                <button class="delete-modal btn btn-xs btn-danger"
                    onClick="delete_gactepass({{ $gatepass['id'] }})">Delete</button>
                {{-- @if($gatepass['gatepass_type'] == 'returnable')
                   @if ($gatepass['returnable_recieved'] == '1')
                      <button class="delete-modal btn btn-xs btn-danger" onClick="gatepass_received({{ $gatepass['id'] }})">Returnable Received </button>
                   @else
                      <button class="delete-modal btn-success btn-xs">Returnable Received </button>
                   @endif
                @endif --}}
            @endif
            {{-- @endif --}}
        </td>
    </tr>
@endforeach