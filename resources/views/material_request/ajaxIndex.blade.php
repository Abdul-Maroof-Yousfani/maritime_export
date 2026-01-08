<?php 
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
$m = session('run_company');
$view=ReuseableCode::check_rights(549);
$edit=ReuseableCode::check_rights(550);
?>
@foreach ($material_requests as $key => $material_request)
    <tr class="text-center">
        <td>{{++$key}}</td>
        <td>{{strtoupper($material_request['mr_no'])}}</td>
        <td>{{date('d-m-Y', strtotime($material_request['mr_date']))}}</td>
        <td>{{optional($material_request->department)->sub_department_name}}</td>
        <td>{{optional($material_request->machine)->name}}</td>
        <td>{{optional($material_request->line)->name}}</td>
      
        <td>
            @if ($material_request['status'] == 1)
              @if ($view == true)
              <button
              onclick="showDetailModelOneParamerter('purchase/ViewMaterialRequest',{{ $material_request->id }},'View Material Request')"
              type="button" class="btn btn-success btn-xs">View</button>
              @endif
                {{-- <a class="edit-modal btn btn-xs btn-info"
                    href="{{ url('purchase/editMaterialForm?id=' . $material_request['id']) }}">Edit</a> --}}
                @if ($material_request['issuance_status'] == 1)
                   @if ($edit == true)
                    <button class="delete-modal btn btn-xs btn-danger"
                    onClick="delete_mr({{ $material_request['id'] }})">Delete</button>    
                   @endif
                   
                @endif
            @endif
            {{-- @endif --}}
        </td>
    </tr>
@endforeach