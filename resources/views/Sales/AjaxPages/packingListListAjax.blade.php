@php
use App\Helpers\ReuseableCode;
$view=ReuseableCode::check_rights(435);
$edit=ReuseableCode::check_rights(436);
$delete=ReuseableCode::check_rights(437);
$counter = 1;
@endphp
@foreach ($packing_lists as $item)
   <tr id="{{ $item->id}}">
    <td>{{$counter }}</td>    
    <td>{{$item->packing_list_no ?? '-'}}</td>    
    <td>
        @if(!empty($item->date))
            @php
                $date = new DateTime($item->date);
                echo $date->format('d-m-Y');
            @endphp
        @else
            -
        @endif
    </td>
    <td>{{$item->commercial_invoice_no ?? '-'}}</td>  
    <td>{{ $item->gd_no ?? '-'}}</td>  
    <td>{{ $item->container_no ?? '-'}}</td>  
    <td style="text-align: right;">{{ number_format($item->gross_weight ?? 0, 2) }}</td>
    <td class="text-center">
        <div style="display: flex; justify-content: center; gap: 5px; align-items: center;">
            @if ($view)
            <a href="javascript:void(0)" 
               onclick="showDetailModelOneParamerter('export/viewPackingList',{{ $item->id}},'View Packing List')" 
               title="View" 
               style="display: inline-block; width: 32px; height: 32px; background-color: #28a745; border-radius: 4px; text-align: center; line-height: 32px; cursor: pointer; text-decoration: none;">
                <i class="fa fa-eye" style="color: white; font-size: 14px;"></i>
            </a>
            @endif
            @if($edit)
            <a href="javascript:void(0)" 
               onclick="window.location.href='{{ url('/export/editPackingList') }}?id={{ $item->id }}'" 
               title="Edit" 
               style="display: inline-block; width: 32px; height: 32px; background-color: #007bff; border-radius: 4px; text-align: center; line-height: 32px; cursor: pointer; text-decoration: none;">
                <i class="fa fa-edit" style="color: white; font-size: 14px;"></i>
            </a>
            @endif
            @if($delete)
            <a href="javascript:void(0)" 
               onclick="deletePackingList({{ $item->id}},{{$m}})" 
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
function deletePackingList(id, m) {
    if (confirm('Are you sure you want to delete this packing list?')) {
        var base_url='<?php echo URL::to('/'); ?>';
        $.ajax({
            url: base_url+'/export/deletePackingList',
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
