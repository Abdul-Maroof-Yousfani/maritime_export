<?php 
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
$m = session('run_company');
$view=ReuseableCode::check_rights(563);
$approve=ReuseableCode::check_rights(563);
$audapprove=ReuseableCode::check_rights(563);
$delete=ReuseableCode::check_rights(563);
$edit=ReuseableCode::check_rights(579);

?>
@foreach ($scrap_declrations as $key => $scrap_declration)
    <tr class="text-center">
        <td>{{++$key}}</td>
        <td>{{strtoupper($scrap_declration['sd_no'])}}</td>
        <td>{{strtoupper(date('d-m-Y',strtotime($scrap_declration['sd_date'])))}}</td>
        <td>{{ optional($scrap_declration->company_location)->location_name }}</td>
        <td class="text-center">{{optional($scrap_declration->department)->sub_department_name}}</td>
        <td class="text-center">{{optional($scrap_declration->line)->name}}</td>   
        <td>{{strtoupper($scrap_declration['requested_by'])}}</td>


       
      
        <td>
            @if ($scrap_declration['status'] == 1)
              @if ($view == true)
              <button
              onclick="showDetailModelOneParamerter('purchase/ViewScrapDeclration',{{ $scrap_declration->id }},'View Scrap Declration')"
              type="button" class="btn btn-success btn-xs">View</button>
              @endif
                @if ($edit == true)
                    <a class="edit-modal btn btn-xs btn-info"
                        href="{{ url('purchase/scrap_declrations/' . $scrap_declration->id . '/edit?pageType=&&parentCode=24&&m='.session('run_company').'#Garibsons') }}">Edit</a>
                @endif
                    
                    
                   @if ($delete == true)
                    <button class="delete-modal btn btn-xs btn-danger"
                    onClick="delete_scrap({{ $scrap_declration['id'] }})">Delete</button>    
                   @endif
            @endif
            {{-- @endif --}}
        </td>
    </tr>
@endforeach