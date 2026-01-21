@php

use App\Helpers\ReuseableCode;
$view=ReuseableCode::check_rights(435);
$edit=ReuseableCode::check_rights(436);
$delete=ReuseableCode::check_rights(437);
$approvedRight=ReuseableCode::check_rights(434);
$counter =  1 ;
@endphp
@foreach ($sale_order as $item)
    

   <tr id="{{ $item->id}}">
    <td>{{$counter }}</td>    
    <td>{{$item->voucehr_no}}</td>  
    <td>{{$item->contract_no?? '-'}}</td>     
    <td>{{ $item->voucher_date}}</td>  
    
    <td>
      @if($item->approved_status == 0)
      EO Created
      @elseif($item->approved_status == 1 )
      Contract Created
      @endif
    </td>
   <?php
  //  dd($item->mode_of_term);
    if(!empty($item->mode_of_term))
    {
    $term = App\Models\ModeOfTerm::find($item->mode_of_term)->name;
   
    }else{
      $term = '-';
    }
    ?>
    <td>{{$term}}</td>    
    <td>{{$item->name}}</td>    
    <td class="text-center">

     {{-- <button onclick="showDetailModelOneParamerter('export/viewSalesOrderDetail',{{ $item->id}},@if($item->approved_status == 0)'View Export Order'@else 'Contract'  @endif)"
    type="button" class="btn btn-success btn-xs">View</button><br><br>
   <button  onclick="showDetailModelOneParamerter('export/viewSaleExportVoucher',{{ $item->id}},@if($item->approved_status == 0)'View Export Order'@else 'Contract'  @endif)"
    type="button" class="btn btn-success btn-xs">Contract Certificate
   </button> --}}
   <!-- Split button -->
   <div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Action <span class="caret"></span>
    </button>
  <ul class="dropdown-menu">
    {{-- <li><a onclick="showDetailModelOneParamerter('export/viewSalesOrderDetail',{{ $item->id}},@if($item->approved_status == 0)'View Export Order'@else 'Contract'  @endif)">View Deatils</a></li> --}}
    @if ($view)
    <li><a onclick="showDetailModelOneParamerter('export/viewSaleExportVoucher',{{ $item->id}},@if($item->approved_status == 0)'View Export Order'@else 'Contract'  @endif)"> View @if($item->approved_status == 0)Export Order @else  Contract @endif</a></li>
    <li><a href="{{url('/export/printSaleOrderItems?id='.$item->id)}}" target="_blank">Print Items</a></li>
    @endif
    @if( $item->approved_status == 0 && $delete)
    <li><a onclick="sale_order_delete({{ $item->id}},{{$m}})">Delete</a></li>
    @endif
    @if( $item->approved_status == 0 && $edit)
    <li><a href="{{url('/export/saleOrderEdit?id='.$item->id)}}">Edit</a></li>
    @endif
    {{-- @if( $item->approved_status == 1 && $item->proforma_status == 0)
    <li><a  href="{{route('proformaCreateForm',$item->id)}}">Create Proforma</a></li>
    @endif  --}}
    @php
        $isAdvance = 0;
        if (isset($item->is_advance)) {
            $isAdvance = $item->is_advance;
        } elseif (isset($item->advance_payment)) {
            // Handle old data: "Yes" = 1, "No" or empty = 0
            $isAdvance = ($item->advance_payment == 'Yes' || $item->advance_payment == 1) ? 1 : 0;
        }
    @endphp
    @if($isAdvance == 1)
    <li><a onclick="openReceiveAdvanceModal({{ $item->id}})">Receive Advance</a></li>
    @endif


    {{-- @if ($edit)
        Edit code write here
    @endif --}}
    
    
    @if( $item->approved_status == 0 && $approvedRight) 
      <li> <a onclick="approved_record({{ $item->id}},{{$m}})">Approved</a></li>
      @endif
  </ul>
</div>
   {{-- @if( $item->approved_status == 0)
     <button onclick="sale_order_delete({{ $item->id}},{{$m}})"
      type="button" class="btn btn-danger btn-xs">Delete</button>
   @endif --}}
   {{-- @if( $item->approved_status == 1)
        <a class="btn btn-primary btn-xs" href="{{route('proformaCreateForm',$item->id)}}">Create Proforma</a>
   @endif --}}
    {{-- <button style="display:{{( $item->approved_status == 0)? '': 'none'}} " onclick="approved_record({{ $item->id}},{{$m}})"
      type="button" class="btn btn-primary btn-xs">Approved</button> --}}
     </td>  
    </tr>
    @php 
    $counter++;
    @endphp
    @endforeach