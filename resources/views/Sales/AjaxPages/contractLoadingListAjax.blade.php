@php
use App\Helpers\ReuseableCode;
$view=ReuseableCode::check_rights(435);
$edit=ReuseableCode::check_rights(436);
$delete=ReuseableCode::check_rights(437);
$counter = 1;
@endphp
@foreach ($contract_loadings as $item)
   <tr id="{{ $item->id}}">
    <td>{{$counter }}</td>    
    <td>{{$item->loading_no ?? '-'}}</td>    
    <td>{{$item->contract_no ?? '-'}}</td>  
    <td>{{$item->voucehr_no ?? '-'}}</td>     
    <td>{{ $item->loading_date ?? '-'}}</td>  
    <td>{{ $item->vehicle_no ?? '-'}}</td>  
    <td>{{ $item->name ?? '-'}}</td>  
    <td>{{ $item->container_no ?? '-'}}</td>  
    <td>{{ $item->seal_no ?? '-'}}</td>
    <td style="text-align: right;">{{ number_format($item->total_amount ?? 0, 2) }} {{ $item->currency_name ?? '' }}</td>
    <td style="text-align: right;">{{ number_format($item->total_amount_pkr ?? 0, 2) }} PKR</td>  
    <td class="text-center">
        <div style="display: flex; justify-content: center; gap: 5px; align-items: center;">
            @if ($view)
            <a href="javascript:void(0)" 
               onclick="showDetailModelOneParamerter('export/viewContractLoadingDetail',{{ $item->id}},'View Contract Loading')" 
               title="View" 
               style="display: inline-block; width: 32px; height: 32px; background-color: #28a745; border-radius: 4px; text-align: center; line-height: 32px; cursor: pointer; text-decoration: none;">
                <i class="fa fa-eye" style="color: white; font-size: 14px;"></i>
            </a>
            @endif
            @if($delete)
            <a href="javascript:void(0)" 
               onclick="deleteContractLoading({{ $item->id}},{{$m}})" 
               title="Delete" 
               style="display: inline-block; width: 32px; height: 32px; background-color: #dc3545; border-radius: 4px; text-align: center; line-height: 32px; cursor: pointer; text-decoration: none;">
                <i class="fa fa-trash" style="color: white; font-size: 14px;"></i>
            </a>
            @endif
        </div>
     </td>  
    </tr>
    @php 
    $counter++;
    @endphp
    @endforeach

<script>
function deleteContractLoading(id, m) {
    if (confirm('Are you sure you want to delete this contract loading?')) {
        var base_url='<?php echo URL::to('/'); ?>';
        $.ajax({
            url: base_url+'/export/deleteContractLoading',
            type: 'GET',
            data: {id: id, m: m},
            success: function (response) {
                if (response=='0') {
                    alert('Cannot delete');
                } else {
                    alert('Deleted');
                    $('#' + id).remove();
                }
            }
        });
    }
}
</script>

