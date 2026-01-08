@php
    use App\Helpers\ReuseableCode;
    
    $createInvoice = ReuseableCode::check_rights(454);
    $view = ReuseableCode::check_rights(455);
    $counter = 1;
@endphp

@foreach ($export_performa as $sale_or)
    @if ($sale_or->advance_payment <= 0 || $sale_or->advance_payment_status == 1)
        <tr id="{{ $sale_or->id }}">
            <td>{{ $counter }}</td>
            <td>{{ $sale_or->eo_voucher_no }}</td>
            <td>{{ $sale_or->contract_no }}</td>
            <td>{{ $sale_or->pro_contract_no }}</td>
            <td>{{ $sale_or->created_at }}</td>
            <?php if (!empty($sale_or->mode_of_term)) {
                $term = App\Models\ModeOfTerm::find($sale_or->mode_of_term)->name;
            } else {
                $term = '-';
            }
            ?>
            <td>{{ $term }}</td>
            <td>{{ $sale_or->name }}</td>
            <td class="text-center">
                @if ($sale_or->invoice_status == 0 && $createInvoice)
                    <a href="{{ route('createExportInvoice', $sale_or->id) }}"class="btn btn-primary btn-xs">
                        Create Invoice
                    </a>
                @endif
                @if ($view)
                    <button
                        onclick="showDetailModelOneParamerter('export/proformaInvoice',{{ $sale_or->id }},'Proforma Details')"
                        type="button" class="btn btn-success btn-xs">View</button>
                @endif
            </td>
        </tr>
        @php
            $counter++;
        @endphp
    @endif
@endforeach
