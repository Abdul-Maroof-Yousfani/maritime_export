@php
    use App\Helpers\CommonHelper;
    use App\Helpers\ReuseableCode;
    $approve = ReuseableCode::check_rights(492);
    $edit = ReuseableCode::check_rights(493);
    $delete = ReuseableCode::check_rights(494);
    $type = ['OUT', 'IN'];
@endphp
@foreach ($stockAdjusts as $key => $stockAdjust)
    <tr class="text-center">
        <td>{{ ++$key }}</td>
        <td>{{ CommonHelper::get_item_name($stockAdjust->item_id) }}</td>
        <td>{{ CommonHelper::get_uom($stockAdjust->item_id) }}</td>
        <td>{{ CommonHelper::get_name_warehouse($stockAdjust->warehouse_id) }}</td>
        <td>{{ $type[$stockAdjust->type] }}</td>
        <td>{{ $stockAdjust->qty }}</td>
        <td>{{ $stockAdjust->remarks }}</td>
        <td>{{ $stockAdjust->username }}</td>
        <td class="hidden-print">
            @if ($stockAdjust->approve_status == 0)
                @if ($approve)
                    <a class="btn btn-xs btn-success"
                        href="{{ url('store/stockAdjustApprove/' . $stockAdjust->id) }}">Approve</a>
                @endif
                @if ($edit)
                    <a class="btn btn-xs btn-warning"
                        href="{{ url('store/stockAdjustEdit/' . $stockAdjust->id) }}">Edit</a>
                @endif
                @if ($delete)
                    <a class="btn btn-xs btn-danger"
                        href="{{ url('store/stockAdjustDelete/' . $stockAdjust->id) }}">Delete</a>
                @endif
            @endif
        </td>
    </tr>
@endforeach
