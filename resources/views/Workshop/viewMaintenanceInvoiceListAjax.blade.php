@foreach ($maintenanceInvoices as $key => $maintenanceInvoice)
    <tr>
        <td>{{ ++$key }}</td>
        <td>{{ $maintenanceInvoice->voucher_no }}</td>
        <td>{{ $maintenanceInvoice->voucher_date }}</td>
        <td>{{ $maintenanceInvoice->maintenanceJob->voucher_no }}</td>
        <td>{{ $maintenanceInvoice->maintenanceJob->maintenanceRequest->voucher_no }}</td>
        <td>{{ $maintenanceInvoice->username }}</td>
        <td>
            {{-- @if ($view) --}}
            <button
                onclick="showDetailModelOneParamerter('workshop/viewMaintenanceInvoiceDetail',{{ $maintenanceInvoice->id }},'View BOM Details')"
                type="button" class="btn btn-success btn-xs">View</button>
            {{-- @endif --}}
            {{-- @if ($edit == true) --}}
            @if ($maintenanceInvoice->voucher_status == 1)
            <a class="edit-modal btn btn-xs btn-info"
                    href="{{ url('workshop/EditMaintenanceInvoiceForm?id=' . $maintenanceInvoice->id) }}">Edit</a>
            @endif
            {{-- @endif --}}
            @if ($maintenanceInvoice->voucher_status == 1 )
                <button class="delete-modal btn btn-xs btn-danger"
                    onClick="deletemaintenanceInvoice({{ $maintenanceInvoice->id }})">Delete</button>
            @endif
        </td>
    </tr>
@endforeach
