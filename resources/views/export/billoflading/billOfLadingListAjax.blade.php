@php
    use App\Helpers\ReuseableCode;
    
    $view = ReuseableCode::check_rights(461);
    $createExportDuties = ReuseableCode::check_rights(462);
    $counter = 1;
@endphp

@foreach ($billOfLadings as $item)
    <tr id="{{ $item->id }}">
        <td>{{ $counter }}</td>
        <td>{{ $item->commercial_invoice_no }}</td>
        <td>{{ $item->import_no }}</td>
        <td>{{ $item->voucher_no }}</td>
        <td>{{ Carbon\Carbon::parse($item->voucher_date)->format('d-m-Y') }}</td>


        <td class="text-center">
            {{-- @if ($view) --}}
            <button onclick="showDetailModelOneParamerter('export/viewBillOfLadingDetail',{{ $item->id }},'Bill Of Lading')"
                type="button" class="btn btn-success btn-xs">View</button>
            {{-- @endif --}}
            {{-- @if ($item->duities_clearing_status == 0 && $createExportDuties) --}}
            <a href="{{ route('editBillOfLading', $item->id) }}" class="btn btn-primary btn-xs"> Edit
            </a>
            {{-- @endif --}}
        </td>
    </tr>
    @php
        $counter++;
    @endphp
@endforeach
