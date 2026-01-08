@php
    use App\Helpers\ReuseableCode;
    
    $view = ReuseableCode::check_rights(461);
    $createExportDuties = ReuseableCode::check_rights(462);
    $counter = 1;
@endphp

@foreach ($exportpakingList as $item)
    <tr id="{{ $item->id }}">
        <td>{{ $counter }}</td>
        <td>{{ $item->invoice_no }}</td>
        <td>{{ $item->import_no }}</td>
        <td>{{ $item->created_at }}</td>


        <td class="text-center">
            @if ($view)
                <button onclick="showDetailModelOneParamerter('export/viewPaking',{{ $item->id }},'Packing List')"
                    type="button" class="btn btn-success btn-xs">View</button>
            @endif
            @if ($item->duities_clearing_status == 0 && $createExportDuties)
                <a href="{{ route('createDuties', $item->id) }}" type="button" class="btn btn-primary btn-xs"> Create
                    Export Duties
                </a>
            @endif
        </td>
    </tr>
    @php
        $counter++;
    @endphp
@endforeach
