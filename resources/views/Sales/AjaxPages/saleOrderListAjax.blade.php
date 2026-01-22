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
        <div style="display: flex; justify-content: center; gap: 5px; align-items: center;">
            @if( $item->approved_status == 0 && $edit)
            <a href="{{url('/export/saleOrderEdit?id='.$item->id)}}" 
               title="Edit" 
               style="display: inline-block; width: 32px; height: 32px; background-color: #17a2b8; border-radius: 4px; text-align: center; line-height: 32px; cursor: pointer; text-decoration: none;">
                <i class="fa fa-pencil" style="color: white; font-size: 14px;"></i>
            </a>
            @endif
            @if( $item->approved_status == 0 && $delete)
            <a href="javascript:void(0)" 
               onclick="sale_order_delete({{ $item->id}},{{$m}})" 
               title="Delete" 
               style="display: inline-block; width: 32px; height: 32px; background-color: #dc3545; border-radius: 4px; text-align: center; line-height: 32px; cursor: pointer; text-decoration: none;">
                <i class="fa fa-trash" style="color: white; font-size: 14px;"></i>
            </a>
            @endif
            @if ($view)
            <a href="javascript:void(0)" 
               onclick="showDetailModelOneParamerter('export/viewSaleExportVoucher',{{ $item->id}},@if($item->approved_status == 0)'View Export Order'@else 'Contract'  @endif)" 
               title="View" 
               style="display: inline-block; width: 32px; height: 32px; background-color: #28a745; border-radius: 4px; text-align: center; line-height: 32px; cursor: pointer; text-decoration: none;">
                <i class="fa fa-eye" style="color: white; font-size: 14px;"></i>
            </a>
            <a href="{{url('/export/printSaleOrderItems?id='.$item->id)}}" 
               target="_blank" 
               title="Print Items" 
               style="display: inline-block; width: 32px; height: 32px; background-color: #6c757d; border-radius: 4px; text-align: center; line-height: 32px; cursor: pointer; text-decoration: none;">
                <i class="fa fa-print" style="color: white; font-size: 14px;"></i>
            </a>
            @endif
            @php
                $isAdvance = 0;
                if (isset($item->is_advance)) {
                    $isAdvance = $item->is_advance;
                } elseif (isset($item->advance_payment)) {
                    $isAdvance = ($item->advance_payment == 'Yes' || $item->advance_payment == 1) ? 1 : 0;
                }
            @endphp
            @if($isAdvance == 1)
            <a href="javascript:void(0)" 
               onclick="openReceiveAdvanceModal({{ $item->id}})" 
               title="Receive Advance" 
               style="display: inline-block; width: 32px; height: 32px; background-color: #ffc107; border-radius: 4px; text-align: center; line-height: 32px; cursor: pointer; text-decoration: none;">
                <i class="fa fa-money" style="color: white; font-size: 14px;"></i>
            </a>
            @endif
            @if( $item->approved_status == 0 && $approvedRight) 
            <a href="javascript:void(0)" 
               onclick="approved_record({{ $item->id}},{{$m}})" 
               title="Approve" 
               style="display: inline-block; width: 32px; height: 32px; background-color: #007bff; border-radius: 4px; text-align: center; line-height: 32px; cursor: pointer; text-decoration: none;">
                <i class="fa fa-check" style="color: white; font-size: 14px;"></i>
            </a>
            @endif
        </div>
     </td>  
    </tr>
    @php 
    $counter++;
    @endphp
    @endforeach