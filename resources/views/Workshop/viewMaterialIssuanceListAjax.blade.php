@php
    use App\Helpers\CommonHelper;
@endphp
@foreach ($materialissuance as $key => $maintenanceInvoice)
    <tr>
        <td>{{ ++$key }}</td>
        <td>{{ $maintenanceInvoice->voucher_no }}</td>
        <td>{{  date('d-m-Y', strtotime($maintenanceInvoice->voucher_date)) }}</td>
        <td>{{ $maintenanceInvoice->maintenanceJob->voucher_no??'' }}</td>
        <td>{{ ($maintenanceInvoice->maintenanceJob)?CommonHelper::getMaintenanceJobType()[$maintenanceInvoice->maintenanceJob->job_type - 1]['name'] : '' }}</td>
        <td>{{ $maintenanceInvoice->maintenanceJob->maintenanceRequest->voucher_no??'' }}</td>
        <td>{{ $maintenanceInvoice->username }}</td>
        <td>
            {{-- @if ($view) --}}
            <button
                onclick="showDetailModelOneParamerter('workshop/viewMaterialIssuanceDetail',{{ $maintenanceInvoice->id }},'View Material Issuance Details')"
                type="button" class="btn btn-success btn-xs">View</button>
            {{-- @endif --}}
            {{-- @if ($edit == true) --}}
            {{-- @endif --}}
            @if ($maintenanceInvoice->voucher_status == 1 )
                <a class="edit-modal btn btn-xs btn-info"
                    href="{{ url('workshop/editMaterialIssuance?id=' . $maintenanceInvoice->id) }}">Edit</a>
                <button class="delete-modal btn btn-xs btn-danger"
                    onClick="deleteMaterialIssuance({{ $maintenanceInvoice->id }})">Delete</button>
            @endif
        </td>
    </tr>
@endforeach
