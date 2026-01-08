@foreach ($AnalyzingReportDetail as $key => $val)
    <tr>
        <td>{{ ++$key }}</td>
        <td>{{ $val->date }}</td>
        <td>{{ $val->maintenanceRequest->voucher_no }}</td>
        <td>{{ $val->username }}</td>
        <td>
            {{-- @if ($view) --}}
            <a href="{{ url('workshop/viewAnalyzingDetail?id=' . $val->id) }}"
               class="edit-modal btn btn-xs btn-info">View</a>
            {{-- @endif --}}
            {{-- @if ($edit == true) --}}
           
               {{-- <a class="edit-modal btn btn-xs btn-info"
                    href="{{ url('workshop/editMaintenanceRequest?id=' . $val->id) }}">Edit</a>
                --}}
                    <button class="delete-modal btn btn-xs btn-danger"
                    onClick="deleteAnalysingMr({{ $val->id }})">Delete</button>
            
            {{-- @endif --}}
            {{-- @if ($maintenanceRequest->voucher_status == 1)
            @endif --}}
        </td>
    </tr>
@endforeach
