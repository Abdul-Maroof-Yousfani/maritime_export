@php
    use App\Helpers\ReuseableCode;
    
    $payAdvance = ReuseableCode::check_rights(451);
    $view = ReuseableCode::check_rights(452);
    $delete = ReuseableCode::check_rights(453);
    $counter = 1;
@endphp
@foreach ($export_performa as $sale_or)
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
            {{-- @if ($sale_or->invoice_status == 0)
    <a href="{{route('createExportInvoice',$sale_or->id)}}"class="btn btn-primary btn-xs">
      Create Invoice
    </a>
    @endif --}}

            @if ($payAdvance)
                @if (($sale_or->advance_payment > 0 && $sale_or->advance_payment_status == 0) || $sale_or->advance_payment_status == 2)
                    <a class="btn btn-primary btn-xs" href="{{ route('addAdvancePayment', $sale_or->id) }}"> Pay
                        Advance</a>
                @endif
            @endif

            @if ($view)
                <button
                    onclick="showDetailModelOneParamerter('export/proformaInvoice',{{ $sale_or->id }},'Proforma Details')"
                    type="button" class="btn btn-success btn-xs">Proforma Invoice</button>
            @endif

            @if ($delete)
                @if ($sale_or->invoice_status == 0)
                    <button onclick="sale_order_delete({{ $sale_or->id }})" type="button"
                        class="btn btn-danger btn-xs">Delete
                    </button>
                @endif
            @endif


        </td>
    </tr>
    @php
        $counter++;
    @endphp
@endforeach
