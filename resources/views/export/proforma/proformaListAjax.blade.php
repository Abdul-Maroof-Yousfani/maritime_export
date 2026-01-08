@php
use App\Helpers\ReuseableCode;

$createProforma=ReuseableCode::check_rights(449);
$view=ReuseableCode::check_rights(450);
$counter=1;
@endphp

    @foreach($sale_order as $sale_or)
    <tr id="{{$sale_or->id}}">
    <td>{{$counter}}</td>    
    <td>{{$sale_or->voucehr_no}}</td>    
    <?php if(!empty($sale_or->mode_of_term))
    {
    $term = App\Models\ModeOfTerm::find($sale_or->mode_of_term)->name;
   
    }else{
      $term = '-';
    }
    ?>
    
    <td>{{$sale_or->contract_no}}</td> 
    <td>{{$term}}</td> 
    <td>{{$sale_or->voucher_date}}</td>     
    <td>{{$sale_or->name}}</td>    
    <td class="text-center">
      @if($sale_or->proforma_status == 0 && $createProforma)
    <a href="{{route('proformaCreateForm',$sale_or->id)}}" class="btn btn-primary btn-xs">Create</a>
    @endif
    @if ($view)
      <button onclick="showDetailModelOneParamerter('export/viewSaleExportVoucher',{{ $sale_or->id}},@if($sale_or->approved_status == 0)'View Export Order'@else 'Contract'  @endif)"
    type="button" class="btn btn-success btn-xs"> View @if($sale_or->approved_status == 0)Export Order @else  Contract @endif</button>
    @endif
   
    
     {{-- <button onclick="sale_order_delete({{$sale_or->id}},${m})"
      type="button" class="btn btn-danger btn-xs">Delete</button>
    
    <button style="display:{{$sale_or->approved_status == 0? '': 'none'}} " onclick="approved_record({{$sale_or->id}},${m})"
      type="button" class="btn btn-primary btn-xs">Approved</button> --}}
     </td>  
    </tr>
    @php
    $counter++;
    @endphp
  @endforeach