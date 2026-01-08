@foreach ($inspections as $key => $inspection)
    <tr class="text-center">
        <td>{{++$key}}</td>
        <td>{{$inspection->ins_no}}</td>
        <td>{{$inspection->po_no}}</td>
        <td>{{$inspection->date}}</td>
        <td>{{$inspection->product_description}}</td>
        <td>{{$inspection->truck_no}}</td>
        <td>{{$inspection->customer_name}}</td>
        {{-- <td>
            @if($inspection->ins_status == 0)
                <span  class="text-warning">Pending</span>
            @elseif($inspection->ins_status == 1)
                <span class="text-success">Approved</span>
            @elseif($inspection->ins_status == 2)
                <span  class="text-danger">Reject</span>
            @else
                Unknown
            @endif


        </td> --}}
{{--        <td>{{date('M-Y', strtotime($purchaseOrder['cropBased']['date_from'])). ' - ' . date('M-Y', strtotime($purchaseOrder['cropBased']['date_to'])) }}</td>--}}
        <td>
            {{-- @if ($view) --}}
            <button
                onclick="showDetailModelOneParamerter('arrival/ViewFinalInspection',{{ $inspection->id }},'View Second Inspection Details')"
                type="button" class="btn btn-success btn-xs">View</button>
            {{-- @endif --}}
            {{-- @if ($edit == true) --}}
            {{-- @endif --}}
            {{-- @if ($delete == true) --}}
            @if ($inspection['status'] == 1)
                <a class="edit-modal btn btn-xs btn-info"
                    href="{{ url('gatepass/editGatepassForm?id=' . $inspection['id']) }}">Edit</a>
                <button class="delete-modal btn btn-xs btn-danger"
                    onClick="deleteMaintenanceJob({{ $inspection['id'] }})">Delete</button>
            @endif
            {{-- @endif --}}
        </td>
    </tr>
@endforeach