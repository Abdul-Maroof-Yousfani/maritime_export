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
@foreach ($scrap_sales ?? [] as $key => $scrap_sale)
    <tr class="text-center">
        <td>{{++$key}}</td>
        <td>{{strtoupper($scrap_sale['ss_no'])}}</td>
        <td>{{strtoupper($scrap_sale['scrap_declration_no'])}}</td>
        <td>{{strtoupper(date('d-m-Y',strtotime($scrap_sale['ss_date'])))}}</td>
        <td>{{ optional($scrap_sale->company_location)->location_name }}</td>
        <td class="text-center">{{optional($scrap_sale->department)->sub_department_name}}</td>
        <td class="text-center">{{optional($scrap_sale->line)->name}}</td>   
        <td>{{strtoupper($scrap_sale['requested_by'])}}</td>


       
      
        <td>
            @if ($scrap_sale['status'] == 1)
              @if ($view == true)
              <button
              onclick="showDetailModelOneParamerter('purchase/ViewScrapSale',{{ $scrap_sale->id }},'View Scrap Sale')"
              type="button" class="btn btn-success btn-xs">View</button>
              @endif
                {{-- @if ($edit == true)
                    <a class="edit-modal btn btn-xs btn-info"
                        href="{{ url('purchase/scrap_sales/' . $scrap_sale->id . '/edit?pageType=&&parentCode=24&&m='.session('run_company').'#Garibsons') }}">Edit</a>
                @endif --}}
                    
                    
                   @if ($delete == true)
                    <button class="delete-modal btn btn-xs btn-danger"
                    onClick="delete_scrap({{ $scrap_sale['id'] }})">Delete</button>    
                   @endif
            @endif
            {{-- @endif --}}
        </td>
    </tr>
@endforeach