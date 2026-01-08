@php
    use App\Helpers\ReuseableCode;
    
    $view = ReuseableCode::check_rights(456);
    $counter = 1;
@endphp

@foreach ($invoices as $invoice)
    <tr id="{{ $invoice->id }}">
        <td>{{ $counter }}</td>
        <td>{{ $invoice->eo_voucher_no }}</td>
        <td>{{ $invoice->pro_contract_no }}</td>
        <td>{{ $invoice->commercial_invoice_no }}</td>
        <td>{{ $invoice->created_at }}</td>
        <td>{{ $invoice->invoice_date ?? '-' }}</td>
        <td>
            @php
                $data = json_decode($invoice->form_no);
                foreach ($data as $key => $value) {
                    echo $value . ',';
                }
            @endphp
        </td>
        <td>
            @if ($invoice->import_paking_status == 0)
                Pending
            @else
                Created
            @endif
        </td>
        <td class="text-center">
            {{-- <button onclick="showDetailModelOneParamerter('export/viewInvoiceOrderDetail',{{$invoice->id}},'Commercial Invoice Details ')"
        type="button" class="btn btn-success btn-xs">View</button>   --}}
            @if ($view)
                <button
                    onclick="showDetailModelOneParamerter('export/invoiceCertificate',{{ $invoice->id }},'Commercial Invoice Details ')"
                    type="button" class="btn btn-primary btn-xs ">View Commercial Invoice</button>
            @endif
            <a href="{{url('/export/editExportInvoice/'.$invoice->id)}}" class="btn btn-warning">Edit</a>
            {{-- <button  onclick="showDetailModelOneParamerter('export/billOfLoading',{{$invoice->id}},' Invoice Details ')"
          type="button" class="btn btn-primary btn-xs ">Page 4</button>  --}}
        </td>
    </tr>
    @php
        $counter++;
    @endphp
@endforeach
