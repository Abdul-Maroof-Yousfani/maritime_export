@php
    use App\Helpers\CommonHelper;
@endphp
@foreach ($maintenanceJobs as $key => $maintenanceJob)
    <tr>
        <td>{{ ++$key }}</td>
        <td>{{ $maintenanceJob->maintenanceRequest->voucher_no }}</td>
        <td>{{ $maintenanceJob->voucher_no }}</td>
        <td>{{ $maintenanceJob->voucher_date }}</td>
        <td>{{ CommonHelper::getMaintenanceJobType()[$maintenanceJob->job_type - 1]['name'] }}</td>
        <td>{{ $maintenanceJob->supplier->name??'-' }}</td>
        <td>{{ $maintenanceJob->companyLocation->location_name??'-' }}</td>
        <td>
            @if ($view == true)
                <button onclick="showDetailModelOneParamerter('/workshop/viewMaintenanceJobDetail',{{ $maintenanceJob->id }},'View Maintenance Job Details')" type="button" class="btn  btn-success btn-xs">View</button>
            @endif
            @if ($edit == true)
                <a class="edit-modal btn btn-xs btn-info" href="{{ url('workshop/editMaintenanceJob?id=' . $maintenanceJob->id) }}">Edit</a>
            @endif
            @if ($delete == true)
                <button  class="delete-modal btn btn-xs btn-danger" onClick="deleteMaintenanceJob({{ $maintenanceJob->id }})">Delete</button>
            @endif
        </td>
    </tr>
@endforeach
