@foreach ($maintenanceRequests as $key => $maintenanceRequest)
    <tr>
        <td>{{ ++$key }}</td>
        <td>{{ $maintenanceRequest->voucher_no }}</td>
        <td>{{ $maintenanceRequest->voucher_date }}</td>
        <td>{{ $maintenanceRequest->department->sub_department_name }}</td>
        <td>{{ $maintenanceRequest->machine->name }}</td>
        <td>{{ $maintenanceRequest->warehouse->name }}</td>
        <td>{{ $maintenanceRequest->username }}</td>
        <td>
            @if ($view == true)
                <button onclick="showDetailModelOneParamerter('/workshop/viewMaintenanceRequestDetail',{{ $maintenanceRequest->id }},'View Maintenance Request Details')"
                    type="button" class="btn btn-success btn-xs">View</button>
            @endif
            @if ($edit == true)
                <a class="edit-modal btn btn-xs btn-info" href="{{ url('workshop/editMaintenanceRequest?id=' . $maintenanceRequest->id) }}">Edit</a>
            @endif
            @if ($delete == true)
                <button class="delete-modal btn btn-xs btn-danger"
                onClick="deleteMaintenanceRequest({{ $maintenanceRequest->id }})">Delete</button>
            @endif
        </td>
    </tr>
@endforeach
