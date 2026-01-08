@foreach ($goodsReturns as $key => $goodsReturn)
    <tr>
        <td>{{ ++$key }}</td>
        <td>{{ $goodsReturn->maintenancejob->maintenanceRequest->voucher_no }}</td>
        <td>{{ $goodsReturn->maintenancejob->voucher_no }}</td>
        <td>{{ $goodsReturn->voucher_no }}</td>
        <td>{{ $goodsReturn->voucher_date }}</td>
        <td>{{ $goodsReturn->return_date }}</td>
        <td>{{ $goodsReturn->department->sub_department_name }}</td>
        <td>{{ $goodsReturn->warehouse->name }}</td>
        <td>
            {{-- @if ($view) --}}
            <button
                onclick="showDetailModelOneParamerter('/workshop/viewGoodsReturnDetail',{{ $goodsReturn->id }},'View Workshop Goods Return Details')"
                type="button" class="btn btn-success btn-xs">View</button>
            {{-- @endif --}}
            {{-- @if ($edit == true) --}}
            {{-- <a class="edit-modal btn btn-xs btn-info"
                    href="{{ url('purchase/editSubItemForm?id=' . $row->id) }}">Edit</a> --}}
            {{-- @endif --}}
            @if ($goodsReturn->voucher_status == 1)
                <button class="delete-modal btn btn-xs btn-danger"
                    onClick="deleteGoodsReturn({{ $goodsReturn->id }})">Delete</button>
            @endif
        </td>
    </tr>
@endforeach
