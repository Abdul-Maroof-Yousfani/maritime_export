@foreach ($billCheck as $key => $bCheck)
    <tr class="text-center">
        <td>{{++$key}}</td>
        <td>{{$bCheck->bill_no}}</td>
        <td>{{$bCheck->po_no}}</td>
        <td>{{$bCheck->created_at}}</td>
      <td>
            {{-- @if ($view) --}}
            <button
                onclick="showDetailModelOneParamerter('arrival/po_bill_check_view',{{ $bCheck->id }},'View Bill Check Details For {{$bCheck->bill_no}}')"
                type="button" class="btn btn-success btn-xs">View</button>
            {{-- @endif --}}
            {{-- @if ($edit == true) --}}
            {{-- @endif --}}
            {{-- @if ($delete == true) --}}

            {{-- @endif --}}
        </td>
    </tr>
@endforeach