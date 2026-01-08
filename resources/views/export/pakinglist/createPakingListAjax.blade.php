@php
use App\Helpers\ReuseableCode;

$createPacking = ReuseableCode::check_rights(457);
$counter=1;
@endphp

    @foreach($invoices as $invoice)
    <tr id="{{$invoice->id}}">
    <td>{{$counter}}</td>    
    <td>{{$invoice->eo_voucher_no}}</td>  
    <td>{{$invoice->pro_contract_no}}</td>
    <td>{{$invoice->commercial_invoice_no}}</td>   
    <td>{{$invoice->created_at}}</td>   
    <td>{{$invoice->invoice_date?? '-'}}</td>    
    <td>
    @php
    $data = json_decode($invoice->form_no);
    foreach ($data as $key => $value) {
    echo $value.',';
    }
    @endphp
   </td >    
   <td>
    @if($invoice->import_paking_status == 0)
     Pending
    @else
     Created
    @endif
   </td>
    <td class="text-center">  
       @if($invoice->import_paking_status == 0 && $createPacking)
        {{-- <button  onclick="showDetailModelOneParamerter('export/createExportPaking',{{$invoice->id}},'Commercial Invoice Details ')"
          type="button" class="btn btn-primary btn-xs ">Create Packing </button>  --}}
          <a href="{{url('/export/createExportPaking?id='.$invoice->id)}}" class="btn btn-primary">CreatePacking</a>
          @endif 
      </td>  
    </tr>
    @php
    $counter++;
    @endphp
  @endforeach