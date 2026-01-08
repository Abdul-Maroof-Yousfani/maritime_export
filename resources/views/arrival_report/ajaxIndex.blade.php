<?php 
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
$m = session('run_company');
$view=ReuseableCode::check_rights(553);
$approve=ReuseableCode::check_rights(554);
$audapprove=ReuseableCode::check_rights(556);
$delete=ReuseableCode::check_rights(555);
$edit=ReuseableCode::check_rights(579);

?>
@foreach ($arrival_reports as $key => $arrival_report)
    <tr class="text-center">
        <td>{{++$key}}</td>
        <td>{{strtoupper($arrival_report['arrival_no'])}}</td>
        <td>{{strtoupper(date('d-m-Y',strtotime($arrival_report['arrival_date'])))}}</td>
        <td>{{ optional($arrival_report->company_location)->location_name }}</td>
        <td>{{strtoupper($arrival_report['requested_by'])}}</td>


       
      
        <td>
            @if ($arrival_report['status'] == 1)
              @if ($view == true)
              <button
              onclick="showDetailModelOneParamerter('purchase/ViewArrivalReport',{{ $arrival_report->id }},'View Arrival Report')"
              type="button" class="btn btn-success btn-xs">View</button>
              @endif
                @if ($edit == true)
                    <a class="edit-modal btn btn-xs btn-info"
                        href="{{ url('purchase/arrival_report/' . $arrival_report->id . '/edit?pageType=&&parentCode=242&&m='.session('run_company').'#Garibsons') }}">Edit</a>
                @endif
                    
                    
                   @if ($delete == true)
                    <button class="delete-modal btn btn-xs btn-danger"
                    onClick="delete_ar({{ $arrival_report['id'] }})">Delete</button>    
                   @endif

                    @if ($approve == true)
                        @if ($arrival_report['arrival_approve'] == 1)
                        <button disabled class="delete-modal btn btn-xs btn-success">Acknowledged</button> 
                        @else 
                            <button
                            onclick="showDetailModelOneParamerter('purchase/AcknowledgedArrivalView',{{ $arrival_report->id }},'View Arrival Report')"
                            type="button" class="btn btn-primary btn-xs">Acknowledged Arrival Report</button>
                        @endif
                    @endif
                    @if($audapprove == true && $arrival_report['arrival_approve'] == 1)
                        @if ($arrival_report['audit_approved'] == 1)
                        <button disabled class="delete-modal btn btn-xs btn-success">Auditor Approve Arrival</button> 
                        @else 
                        <button class="delete-modal btn btn-xs btn-primary" onClick="approve_ar({{ $arrival_report['id'] }})">Auditor Approve Arrival</button> 
                        @endif
                     
                    @endif 
            @endif
            {{-- @endif --}}
        </td>
    </tr>
@endforeach