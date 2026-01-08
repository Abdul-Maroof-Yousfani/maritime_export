<?php

use App\Helpers\CommonHelper;
use App\Helpers\PurchaseHelper;
$details='';
$equipment_ref_count=0;
$section_count=0;
$colspan=0;
?>
@extends('layouts.default')
<style>
    td{
        border:3px solid black !important;
        font-weight:bold;
        /* width:50%; */
    }
    th{
        width:430px;
    }
</style>
@section('content')
    @include('select2')
    <div class="well_N">
        <div class="dp_sdw">
        <?php echo CommonHelper::displayPrintButtonInBlade('PrintEmpExitInterviewList','','1');?>
            <div class="panel">
                <div class="panel-body" id="PrintEmpExitInterviewList">
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="text-center" style="font-wieght:bold;"><h3>Maintenance Analysing Report</h3></div>    
                        <br/>
                        <table class="table">
                            <thead>
                            <tr>
                                <th >MR #</th>
                                <td>{{ $AnalyzingReportDetail->maintenanceRequest->voucher_no }}</td>
                            </tr>
                            <tr><th ></th></tr>
                            @foreach($AnalyzingReportDetail->analyzingReportDetailData as $detailData)
                                @if($detailData->equipment_reference != '')
                                    @php 
                                    $equipment_ref_count=count(explode('=>',$detailData->equipment_reference));
                                    @endphp
                                    <tr>
                                    <th >Equipment Refrence</th>
                                    @foreach(explode('=>',$detailData->equipment_reference) as $val)
                                        @if($val != '')
                                            <td>{{ $val }}</td>
                                        @endif
                                    @endforeach
                                    </tr>
                                @endif
                            @endforeach
                            <tr><th ></th></tr>
                            @foreach($AnalyzingReportDetail->analyzingReportDetailData as $detailData)
                                @if($detailData->section != '')
                                @php 
                                    $section_count=count(explode('=>',$detailData->section));
                                @endphp
                                    <tr>
                                    <th >Section</th>
                                    @foreach(explode('=>',$detailData->section) as $val)
                                        @if($val != '')
                                            <td>{{ $val }}</td>
                                        @endif
                                    @endforeach
                                    </tr>
                                @endif
                            @endforeach
                            <tr><th ></th></tr>
                            @foreach($AnalyzingReportDetail->analyzingReportDetailData as $detailData)
                                @if($detailData->category != '')
                                    <tr>
                                    <th >Category</th>
                                    @foreach(explode('=>',$detailData->category) as $val)
                                        @if($val != '')
                                            <td>{{ $val }}</td>
                                        @endif
                                    @endforeach
                                    </tr>
                                @endif
                            @endforeach
                            <tr><th ></th></tr>
                            @php 
                                if($section_count >= $equipment_ref_count){
                                    $colspan=$section_count;
                                }elseif($equipment_ref_count >= $section_count){
                                    $colspan=$equipment_ref_count;
                                }
                            @endphp
                            @foreach($AnalyzingReportDetail->analyzingReportDetailData as $detailData)
                                
                                    <tr>
                                    <td>Cost Head For the Damage Unit</td>
                                    <td>{{ DB::connection('mysql')->table('company')->select('name')->where('id',Session::get('run_company'))->value('name') }}</td>
                                    <td>Concern Department</td>
                                    </tr>
                                    <tr>
                                    <th ></th>
                                    <td>COMMON ISSUE</td>
                                    <td>STAFF INTELEGENCE</td>
                                    </tr>
                                    
                                    @php
                                        $details=$detailData->detail;
                                        $explode_common_issue=explode('=>',$detailData->common_issue);
                                        $explode_staff_intelegence=explode('=>',$detailData->staff_intelegence);
                                        $length=0; 
                                        if(count($explode_common_issue) >= count($explode_staff_intelegence)){
                                            $length=count($explode_common_issue);
                                        }elseif(count($explode_staff_intelegence) >= count($explode_common_issue)){
                                            $length=count($explode_staff_intelegence);
                                        }  
                                    @endphp
                                    @for($i=0;$i<($length-1);$i++)
                                        <tr>
                                            <th ></th>
                                            <td>
                                                @if(isset($explode_common_issue[$i]))
                                                    <?php echo ($i+1).". ".$explode_common_issue[$i]; ?>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($explode_staff_intelegence[$i]))
                                                    <?php echo ($i+1).". ".$explode_staff_intelegence[$i]; ?>
                                                @endif
                                            </td>
                                        </tr>
                                    @endfor
                                    
                            @endforeach
                            <tr><th ></th></tr>
                            <tr>
                                <th colspan="{{ $colspan }}">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="container-fluid">
                                            <h5 style="font-weight:bold;" class="text-center">Details</h5>
                                            <div style="border:3px solid black;height:170px;">{{ $details }}</div>
                                        </div>
                                    </div>
                                </div>
                                </th>
                            </tr>
                            <tr><th ></th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">1</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check Points For Inspecting Motor And Rotors</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Motor Type</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->motor_type }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Motor KW/HP</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->motor_kw_hp }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Motor RPM</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->motor_rpm }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Body Broken</th>
                                    <td style="@if($AnalyzingReportDetail->body_broken===1) background:#afaaaa; @endif">Yes</td>
                                    <td style="@if($AnalyzingReportDetail->body_broken===0) background:#afaaaa; @endif">No</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Burn visual sign of winding</th>
                                    <td style="@if($AnalyzingReportDetail->burn_sign===1) background:#afaaaa; @endif">Yes</td>
                                    <td style="@if($AnalyzingReportDetail->burn_sign===0) background:#afaaaa; @endif">No</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Cooling Fan of motor </th>
                                    <td style="@if($AnalyzingReportDetail->cooling_fan_of_motor===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->cooling_fan_of_motor===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Protection Covers condition</th>
                                      <td style="@if($AnalyzingReportDetail->protection_cover===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->protection_cover===0)background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Base foot condition</th>
                                      <td style="@if($AnalyzingReportDetail->base_foot_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->base_foot_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Rotor shaft condition for wear out</th>
                                      <td style="@if($AnalyzingReportDetail->rotor_shaft_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->rotor_shaft_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bearing hub bore for wear</th>
                                      <td style="@if($AnalyzingReportDetail->bearing_hub_bor===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_hub_bor===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Statar condition</th>
                                      <td style="@if($AnalyzingReportDetail->stater_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->stater_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Motor Casing</th>
                                      <td style="@if($AnalyzingReportDetail->motor_casing===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->motor_casing===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Rotor shaft run out check on lathe machine</th>
                                      <td style="@if($AnalyzingReportDetail->motor_shaft_run_ot_check===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->motor_shaft_run_ot_check===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Connection box condition</th>
                                      <td style="@if($AnalyzingReportDetail->connection_box_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->connection_box_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">2</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Inspecting Shaft</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">shaft size Dia x length (mm) </th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->shaft_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical appearance for wear tear</th>
                                    <td style="@if($AnalyzingReportDetail->physical_appearance===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->physical_appearance===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bearing size wear out</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_size===1) background:#afaaaa; @endif">Yes</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_size===0) background:#afaaaa; @endif">No</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Carter condition</th>
                                    <td style="@if($AnalyzingReportDetail->carter_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->carter_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Shaft physical check for cracks</th>
                                    <td style="@if($AnalyzingReportDetail->shaft_physical===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->shaft_physical===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>

                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">3</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Inspecting Rollor</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">size Dia (mm)</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->rollor_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical appearance for wear tear</th>
                                    <td style="@if($AnalyzingReportDetail->rollor_physical_appearance===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->rollor_physical_appearance===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual apearance of crack</th>
                                    <td style="@if($AnalyzingReportDetail->rollor_appearance_of_crack===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->rollor_appearance_of_crack===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">4</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Inspecting Sprockets</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Sprocket size</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->sprocket_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical appearance for wear tear of sprockets teeth</th>
                                    <td style="@if($AnalyzingReportDetail->sprocket_physical_appearance===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->sprocket_physical_appearance===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual apearance of crack</th>
                                    <td style="@if($AnalyzingReportDetail->sprocket_visual_appearance===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->sprocket_visual_appearance===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">5</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Inspecting Gears</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Gear size</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->gear_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical appearance for wear of gear teeths</th>
                                    <td style="@if($AnalyzingReportDetail->gear_size_physical_appearance===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->gear_size_physical_appearance===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual apearance of crack</th>
                                    <td style="@if($AnalyzingReportDetail->run_out_check===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->run_out_check===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Run out check on lathe machine</th>
                                    <td style="@if($AnalyzingReportDetail->run_out_check===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->run_out_check===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Surface condition</th>
                                    <td style="@if($AnalyzingReportDetail->surface_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->surface_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bore /carter condition</th>
                                    <td style="@if($AnalyzingReportDetail->bore_carter_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bore_carter_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Teeths pattern check with pitch size</th>
                                    <td style="@if($AnalyzingReportDetail->teeth_pattern_check===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->teeth_pattern_check===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">6</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for pulley</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Pulley size</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->pulley_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical appearance for wear tear of pulley</th>
                                    <td style="@if($AnalyzingReportDetail->pulley_physical_appearance===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->pulley_physical_appearance===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual apearance corrosive / Damage</th>
                                    <td style="@if($AnalyzingReportDetail->pulley_visual_appearance===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->pulley_visual_appearance===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Carter pin wear sign</th>
                                    <td style="@if($AnalyzingReportDetail->pulley_carter_pin===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->pulley_carter_pin===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Internal bore for wear out</th>
                                    <td style="@if($AnalyzingReportDetail->pulley_internal_bore===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->pulley_internal_bore===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Surface condition</th>
                                    <td style="@if($AnalyzingReportDetail->pulley_surface_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->pulley_surface_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Run out on lathe machine</th>
                                    <td style="@if($AnalyzingReportDetail->pulley_runout_on_lathe_machine===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->pulley_runout_on_lathe_machine===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Grove condition for belts</th>
                                    <td style="@if($AnalyzingReportDetail->pulley_groove_condition_for_belt===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->pulley_groove_condition_for_belt===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                
                                
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">7</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for multi groove pulley</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Pulley size</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->multi_groove_pulley_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical appearance for wear tear of pulley</th>
                                    <td style="@if($AnalyzingReportDetail->multi_groove_pulley_physical_appearance===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->multi_groove_pulley_physical_appearance===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual apearance corrosive / Damage</th>
                                    <td style="@if($AnalyzingReportDetail->multi_groove_pulley_visual_appearance===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->multi_groove_pulley_visual_appearance===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Internal bore for wear out</th>
                                    <td style="@if($AnalyzingReportDetail->multi_groove_pulley_internal_bore===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->multi_groove_pulley_internal_bore===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Carter pin wear out</th>
                                    <td style="@if($AnalyzingReportDetail->multi_groove_pulley_carter_pin===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->multi_groove_pulley_carter_pin===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Surface condition</th>
                                    <td style="@if($AnalyzingReportDetail->multi_groove_pulley_surface_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->multi_groove_pulley_surface_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Run out on lathe machine</th>
                                    <td style="@if($AnalyzingReportDetail->multi_groove_pulley_runout_on_lathe_machine===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->multi_groove_pulley_runout_on_lathe_machine===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Grove condition for belts</th>
                                    <td style="@if($AnalyzingReportDetail->multi_groove_pulley_condition_for_belt===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->multi_groove_pulley_condition_for_belt===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">8</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Metallic Frames</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Meterial of frame</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->material_of_frame }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical appearance for wear of frame</th>
                                    <td style="@if($AnalyzingReportDetail->metallic_frame_physical_appearance===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->metallic_frame_physical_appearance===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual apearance corrosive / Damage</th>
                                    <td style="@if($AnalyzingReportDetail->metallic_frame_visual_appearance===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->metallic_frame_visual_appearance===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Welding of frames</th>
                                    <td style="@if($AnalyzingReportDetail->welding_of_frame===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->welding_of_frame===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Surface condition</th>
                                    <td style="@if($AnalyzingReportDetail->metallic_frame_surface_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->metallic_frame_surface_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Surface condition</th>
                                    <td style="@if($AnalyzingReportDetail->multi_groove_pulley_surface_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->multi_groove_pulley_surface_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical condition for corrosions</th>
                                    <td style="@if($AnalyzingReportDetail->metallic_frame_physical_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->metallic_frame_physical_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Grove condition for belts</th>
                                    <td style="@if($AnalyzingReportDetail->metallic_frame_groove_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->metallic_frame_groove_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">9</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Mild steel Rollors</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Rollor size in diameter</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->rollor_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Surface condition of rollor</th>
                                    <td style="@if($AnalyzingReportDetail->surface_condition_of_rollor===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->surface_condition_of_rollor===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Axle condition for bend</th>
                                    <td style="@if($AnalyzingReportDetail->axle_condition_for_band===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->axle_condition_for_band===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Internal bore for wear out</th>
                                    <td style="@if($AnalyzingReportDetail->internal_bore_for_rollor===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->internal_bore_for_rollor===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Run out check on lathe machines</th>
                                    <td style="@if($AnalyzingReportDetail->rollor_runout_check_on_lethe_machine===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->rollor_runout_check_on_lethe_machine===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical condition for corrosions</th>
                                    <td style="@if($AnalyzingReportDetail->rollor_physical_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->rollor_physical_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>



                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">10</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Rubber Rollors</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Rollor size in diameter</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->rubber_rollor_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Surface condition of rollor for wear</th>
                                    <td style="@if($AnalyzingReportDetail->rubber_rollor_surface_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->rubber_rollor_surface_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                               
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Internal bore for wear out</th>
                                    <td style="@if($AnalyzingReportDetail->rubber_rollor_internal_bore===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->rubber_rollor_internal_bore===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Axle condition for damage</th>
                                    <td style="@if($AnalyzingReportDetail->rubber_rollor_axle_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->rubber_rollor_axle_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Run out check on lathe machines</th>
                                    <td style="@if($AnalyzingReportDetail->rubber_rollor_runout_check===1) background:#afaaaa; @endif">Yes</td>
                                    <td style="@if($AnalyzingReportDetail->rubber_rollor_runout_check===0) background:#afaaaa; @endif">No</td>
                                </tr>


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">11</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Screw worm conveyor</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Size</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->screw_worm_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Surface condition</th>
                                    <td style="@if($AnalyzingReportDetail->screw_worm_surface_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->screw_worm_surface_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                               
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Sag</th>
                                    <td style="@if($AnalyzingReportDetail->screw_worm_sag===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->screw_worm_sag===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Condition for damage</th>
                                    <td style="@if($AnalyzingReportDetail->screw_worm_damage_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->screw_worm_damage_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Run out check on lathe machines</th>
                                    <td style="@if($AnalyzingReportDetail->screw_worm_runout_check===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->screw_worm_runout_check===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical condition for corrosions</th>
                                    <td style="@if($AnalyzingReportDetail->screw_worm_physical_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->screw_worm_physical_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bearing size wear out check</th>
                                    <td style="@if($AnalyzingReportDetail->screw_worm_bearing_size===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->screw_worm_bearing_size===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Any damage sign on screw conveyor</th>
                                    <td style="@if($AnalyzingReportDetail->any_damage_sign_on_screw_conveyor===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->any_damage_sign_on_screw_conveyor===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>



                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">12</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Inspecting Rollor</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Size</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->bucket_conveyor_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Surface condition</th>
                                    <td style="@if($AnalyzingReportDetail->bucket_conveyor_surface_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bucket_conveyor_surface_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Drum rollors for wear out</th>
                                    <td style="@if($AnalyzingReportDetail->bucket_conveyor_drum_rollars===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bucket_conveyor_drum_rollars===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                 
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Sag condition</th>
                                    <td style="@if($AnalyzingReportDetail->bucket_conveyor_sag===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bucket_conveyor_sag===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Condition for damage</th>
                                    <td style="@if($AnalyzingReportDetail->bucket_conveyor_damage_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bucket_conveyor_damage_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Run out check on lathe machines</th>
                                    <td style="@if($AnalyzingReportDetail->bucket_conveyor_runout_check===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bucket_conveyor_runout_check===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical condition for corrosions</th>
                                    <td style="@if($AnalyzingReportDetail->bucket_conveyor_physical_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bucket_conveyor_physical_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bearing size wear out check</th>
                                    <td style="@if($AnalyzingReportDetail->bucket_conveyor_bearing_size===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bucket_conveyor_bearing_size===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Any damage sign on screw conveyor</th>
                                    <td style="@if($AnalyzingReportDetail->any_damage_sign_on_bucket_screw_conveyor===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->any_damage_sign_on_bucket_screw_conveyor===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">13</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for couplings</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Size ID/OD</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->coupling_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Surface condition</th>
                                    <td style="@if($AnalyzingReportDetail->coupling_surface_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->coupling_surface_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Condition for damage sign</th>
                                    <td style="@if($AnalyzingReportDetail->coupling_damage_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->coupling_damage_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                 
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Run out check on lathe machines</th>
                                    <td style="@if($AnalyzingReportDetail->coupling_runout_check===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->coupling_runout_check===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical condition for corrosions</th>
                                    <td style="@if($AnalyzingReportDetail->coupling_physical_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->coupling_physical_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Chuck nut wear out condition</th>
                                    <td style="@if($AnalyzingReportDetail->coupling_chuck_nut===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->coupling_chuck_nut===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Carter pin</th>
                                    <td style="@if($AnalyzingReportDetail->coupling_carter_pin===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->coupling_carter_pin===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Internal bore wearout size</th>
                                    <td style="@if($AnalyzingReportDetail->coupling_internal_bore===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->coupling_internal_bore===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                               


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">14</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for flywheels</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Size outer dia</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->flywheels_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Surface condition</th>
                                    <td style="@if($AnalyzingReportDetail->flywheels_surface_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->flywheels_surface_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Condition for damage sign</th>
                                    <td style="@if($AnalyzingReportDetail->flywheels_damage_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->flywheels_damage_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                 
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Run out check on lathe machines</th>
                                    <td style="@if($AnalyzingReportDetail->flywheels_runout_check===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->flywheels_runout_check===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical condition for corrosions</th>
                                    <td style="@if($AnalyzingReportDetail->flywheels_physical_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->flywheels_physical_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">carter wear out condition</th>
                                    <td style="@if($AnalyzingReportDetail->flywheels_carter_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->flywheels_carter_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                               
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Internal bore condition</th>
                                    <td style="@if($AnalyzingReportDetail->flywheels_internal_bore===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->flywheels_internal_bore===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bolt tightness</th>
                                    <td style="@if($AnalyzingReportDetail->flywheels_bolt_tightness===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->flywheels_bolt_tightness===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Weld and structural integrity</th>
                                    <td style="@if($AnalyzingReportDetail->flywheels_weld_and_structural===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->flywheels_weld_and_structural===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">15</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Bearings hub</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Size outer dia /meterial</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->bearing_hub_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Surface condition visual</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_hub_surface_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_hub_surface_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bearing condition</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_hub_bearing_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_hub_bearing_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                 
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Mounting bolts conditions</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_hub_mounting_bolts_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_hub_mounting_bolts_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical condition for corrosions</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_hub_physical_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_hub_physical_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Internal bore condition</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_hub_internal_bore===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_hub_internal_bore===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                               
                               
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bolt tightness</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_hub_bolt_tightness===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_hub_bolt_tightness===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Weld and structural integrity</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_hub_weld_and_structural===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_hub_weld_and_structural===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>



                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">16</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for gear box</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Type/Machines</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->gear_box_type }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual condition of gear train</th>
                                    <td style="@if($AnalyzingReportDetail->gear_box_visual_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->gear_box_visual_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bearing condition</th>
                                    <td style="@if($AnalyzingReportDetail->gear_box_bearing_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->gear_box_bearing_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                 
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Mounting bolts conditions</th>
                                    <td style="@if($AnalyzingReportDetail->gear_box_mounting_bolts===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->gear_box_mounting_bolts===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical condition for corrosions</th>
                                    <td style="@if($AnalyzingReportDetail->gear_box_physical_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->gear_box_physical_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Oil level</th>
                                    <td style="@if($AnalyzingReportDetail->gear_box_oil_level===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->gear_box_oil_level===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">oil leaks</th>
                                    <td style="@if($AnalyzingReportDetail->gear_box_oil_leaks===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->gear_box_oil_leaks===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                               
                               
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Gear teath condition</th>
                                    <td style="@if($AnalyzingReportDetail->gear_box_teath_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->gear_box_teath_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Seals conditions</th>
                                    <td style="@if($AnalyzingReportDetail->gear_box_seals_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->gear_box_seals_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">17</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Air Blower</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Type/Machines</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->air_blower_type }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual condition</th>
                                    <td style="@if($AnalyzingReportDetail->air_blower_visual_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->air_blower_visual_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bearing condition</th>
                                    <td style="@if($AnalyzingReportDetail->air_blower_bearing_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->air_blower_bearing_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                 
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Mounting bolts conditions</th>
                                    <td style="@if($AnalyzingReportDetail->air_blower_mounting_bolts===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->air_blower_mounting_bolts===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Impeller condition</th>
                                    <td style="@if($AnalyzingReportDetail->air_blower_impellar_condtion===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->air_blower_impellar_condtion===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Shaft condition for wear out</th>
                                    <td style="@if($AnalyzingReportDetail->air_blower_shaft_condtion===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->air_blower_shaft_condtion===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                               
                               
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Run out check on lathe</th>
                                    <td style="@if($AnalyzingReportDetail->air_blower_runout_check===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->air_blower_runout_check===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Body dented sign</th>
                                    <td style="@if($AnalyzingReportDetail->air_blower_body_dent_sign===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->air_blower_body_dent_sign===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">18</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Bearings</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bearing no</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->bearing_no }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual condition outer race</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_visual_condition_outer_race===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_visual_condition_outer_race===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bearing cage condition</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_cage_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_cage_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual condition inner race</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_visual_condition_inner_race===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_visual_condition_inner_race===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Jammed during operation</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_jammed_during_operation===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_jammed_during_operation===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Body damage sign</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_body_damage_sign===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_body_damage_sign===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">19</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for SS pipes</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Pipe size diaxlength</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->ss_pipe_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual condition for corrsion</th>
                                    <td style="@if($AnalyzingReportDetail->ss_pipe_visual_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->ss_pipe_visual_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Pin holes</th>
                                    <td style="@if($AnalyzingReportDetail->ss_pipe_pin_hole===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->ss_pipe_pin_hole===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">20</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for MS pipes</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Pipe size diaxlength</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->ms_pipe_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual condition for corrsion</th>
                                    <td style="@if($AnalyzingReportDetail->ms_pipe_visual_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->ms_pipe_visual_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Pin holes</th>
                                    <td style="@if($AnalyzingReportDetail->ms_pipe_pin_hole===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->ms_pipe_pin_hole===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>

                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">21</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Hoses (steel braided)</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Pipe size diaxlength</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->hoses_pipe_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual condition for corrsion</th>
                                    <td style="@if($AnalyzingReportDetail->hoses_visual_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->hoses_visual_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Pin holes</th>
                                    <td style="@if($AnalyzingReportDetail->hoses_pin_hole===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->hoses_pin_hole===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Clamp leakages</th>
                                    <td style="@if($AnalyzingReportDetail->hoses_claim_leakages===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->hoses_claim_leakages===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">22</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Belt conveyor </th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Size</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->belt_conveyor_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual condition for corrsion</th>
                                    <td style="@if($AnalyzingReportDetail->belt_conveyor_visual_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->belt_conveyor_visual_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Pin holes/pealings or damage signs </th>
                                    <td style="@if($AnalyzingReportDetail->belt_conveyor_pin_holes===1) background:#afaaaa; @endif">Yes</td>
                                    <td style="@if($AnalyzingReportDetail->belt_conveyor_pin_holes===0) background:#afaaaa; @endif">No</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Crack damages on jointers</th>
                                    <td style="@if($AnalyzingReportDetail->belt_conveyor_crack_damages===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->belt_conveyor_crack_damages===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>

                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">23</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for pulley Belt</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Type</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->pulley_belt_type }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual condition wear out</th>
                                    <td style="@if($AnalyzingReportDetail->pulley_belt_visual_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->pulley_belt_visual_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">pealings or damage signs</th>
                                    <td style="@if($AnalyzingReportDetail->pulley_belt_damage_sign===1) background:#afaaaa; @endif">Yes</td>
                                    <td style="@if($AnalyzingReportDetail->pulley_belt_damage_sign===0) background:#afaaaa; @endif">No</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual cut/Slip on signs</th>
                                    <td style="@if($AnalyzingReportDetail->pulley_belt_visual_cut===1) background:#afaaaa; @endif">Yes</td>
                                    <td style="@if($AnalyzingReportDetail->pulley_belt_visual_cut===0) background:#afaaaa; @endif">No</td>
                                </tr>


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">24</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Sieve</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Type/Machine</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->sieve_type }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual condition wear out</th>
                                    <td style="@if($AnalyzingReportDetail->sieve_visual_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->sieve_visual_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Sieve damage signs</th>
                                    <td style="@if($AnalyzingReportDetail->sieve_damage_sign===1) background:#afaaaa; @endif">Yes</td>
                                    <td style="@if($AnalyzingReportDetail->sieve_damage_sign===0) background:#afaaaa; @endif">No</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual cut on sieve</th>
                                    <td style="@if($AnalyzingReportDetail->sieve_visual_cut===1) background:#afaaaa; @endif">Yes</td>
                                    <td style="@if($AnalyzingReportDetail->sieve_visual_cut===0) background:#afaaaa; @endif">No</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Frame of sieve for corrision</th>
                                    <td style="@if($AnalyzingReportDetail->sieve_frame===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->sieve_frame===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Frame weld condition</th>
                                    <td style="@if($AnalyzingReportDetail->sieve_frame_weld_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->sieve_frame_weld_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>

                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">25</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for cutter Blades SS/MS</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Type/size</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->blades_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual condition wear out on blades</th>
                                    <td style="@if($AnalyzingReportDetail->blades_visual_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->blades_visual_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Damage signs</th>
                                    <td style="@if($AnalyzingReportDetail->blades_damage_sign===1) background:#afaaaa; @endif">Yes</td>
                                    <td style="@if($AnalyzingReportDetail->blades_damage_sign===0) background:#afaaaa; @endif">No</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Edge sharpness</th>
                                    <td style="@if($AnalyzingReportDetail->blades_edge_sharpness===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->blades_edge_sharpness===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Frame of Blade for corrision </th>
                                    <td style="@if($AnalyzingReportDetail->blades_frame===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->blades_frame===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                               


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">26</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Water pump</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Type/size</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->water_pump_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Motor abnormality in operation</th>
                                    <td style="@if($AnalyzingReportDetail->water_pump_motor_abnormality===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->water_pump_motor_abnormality===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual condition of foundation</th>
                                    <td style="@if($AnalyzingReportDetail->water_pump_visual_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->water_pump_visual_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Damage signs on body</th>
                                    <td style="@if($AnalyzingReportDetail->water_pump_damage_sign===1) background:#afaaaa; @endif">Yes</td>
                                    <td style="@if($AnalyzingReportDetail->water_pump_damage_sign===0) background:#afaaaa; @endif">No</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Coupling conditions</th>
                                    <td style="@if($AnalyzingReportDetail->water_pump_coupling_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->water_pump_coupling_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Violute casing corrision</th>
                                    <td style="@if($AnalyzingReportDetail->water_pump_violute_casing===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->water_pump_violute_casing===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>

                                <tr>
                                    <th colspan="{{ $colspan-2 }}">impeller condition and bore size</th>
                                    <td style="@if($AnalyzingReportDetail->water_pump_impellar_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->water_pump_impellar_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">27</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Bearings blocks</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Size</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->bearing_block_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Surface condition visual</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_block_surface_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_block_surface_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bearing condition</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_block_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_block_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Mounting stud conditions</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_block_mounting_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_block_mounting_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical condition for corrosions</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_block_physical_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_block_physical_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Internal bore condition</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_block_internal_bore===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_block_internal_bore===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bolt tightness</th>
                                    <td style="@if($AnalyzingReportDetail->bearing_block_bolt_tightness===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->bearing_block_bolt_tightness===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">28</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Induced drafts fans</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Size</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->induced_drafts_fans_type }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Surface condition visual</th>
                                    <td style="@if($AnalyzingReportDetail->induced_drafts_fans_surface_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->induced_drafts_fans_surface_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bearing condition</th>
                                    <td style="@if($AnalyzingReportDetail->induced_drafts_fans_bearing_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->induced_drafts_fans_bearing_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Basement mount</th>
                                    <td style="@if($AnalyzingReportDetail->induced_drafts_fans_basement_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->induced_drafts_fans_basement_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical condition for corrosions</th>
                                    <td style="@if($AnalyzingReportDetail->induced_drafts_fans_physical_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->induced_drafts_fans_physical_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Internal bore condition</th>
                                    <td style="@if($AnalyzingReportDetail->induced_drafts_fans_internal_bore===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->induced_drafts_fans_internal_bore===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bolt tightness with carter pin</th>
                                    <td style="@if($AnalyzingReportDetail->induced_drafts_fans_bolt_tightness===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->induced_drafts_fans_bolt_tightness===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>

                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">29</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Air lock vales</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Size /Type</th>
                                    <td  class="text-center" colspan="2">{{ $AnalyzingReportDetail->air_lock_vales_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Surface condition visual</th>
                                    <td style="@if($AnalyzingReportDetail->air_lock_vales_surface_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->air_lock_vales_surface_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bearing condition</th>
                                    <td style="@if($AnalyzingReportDetail->air_lock_vales_bearing_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->air_lock_vales_bearing_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Shaft wear condition</th>
                                    <td style="@if($AnalyzingReportDetail->air_lock_vales_shaft_wear_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->air_lock_vales_shaft_wear_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical condition of bearing size on shaft</th>
                                    <td style="@if($AnalyzingReportDetail->air_lock_vales_physical_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->air_lock_vales_physical_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">nternal bore condition of air locks</th>
                                    <td style="@if($AnalyzingReportDetail->air_lock_vales_internal_bore===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->air_lock_vales_internal_bore===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bolt tightness with carter pin</th>
                                    <td style="@if($AnalyzingReportDetail->air_lock_vales_bolt_tightness===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->air_lock_vales_bolt_tightness===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>


                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#afaaaa !important;">30</th>
                                </tr>
                                <tr>
                                <th colspan="{{ $colspan }}" style="text-align:center;background:#e7e6e6 !important;">Check points for Inspecting Rottor</th>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">shaft size Dia x length (mm)</th>
                                    <td class="text-center" colspan="2">{{ $AnalyzingReportDetail->inspecting_rottor_size }}</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Physical appearance for wear tear </th>
                                    <td style="@if($AnalyzingReportDetail->inspecting_rottor_physical_appearance===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->inspecting_rottor_physical_appearance===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Visual apearance of crack</th>
                                    <td style="@if($AnalyzingReportDetail->inspecting_rottor_visual_appearance===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->inspecting_rottor_visual_appearance===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Body damage sign</th>
                                    <td style="@if($AnalyzingReportDetail->inspecting_rottor_body_damage_sign===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->inspecting_rottor_body_damage_sign===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">carter condition </th>
                                    <td style="@if($AnalyzingReportDetail->inspecting_rottor_carter_condition===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->inspecting_rottor_carter_condition===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr>
                                    <th colspan="{{ $colspan-2 }}">Bearing size with internal bore</th>
                                    <td style="@if($AnalyzingReportDetail->inspecting_rottor_bearing_size===1) background:#afaaaa; @endif">Ok</td>
                                    <td style="@if($AnalyzingReportDetail->inspecting_rottor_bearing_size===0) background:#afaaaa; @endif">Not Ok</td>
                                </tr>
                                <tr><th style="border-top:none !important;"></th></tr>
                                <tr><th style="border-top:none !important;"></th></tr>
                                <tr>
                                    <th colspan="{{ $colspan }}">
                                    <div class="signature">
                                        <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <div class="lb1 stg">
                                                <label for="">Work Shop Manager</label>
                                            </div>   
                                            <div class="lb1 stg">
                                            <br>
                                            <br>
                                                ____________________
                                            </div> 
                                        </div>


                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div>


                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <div class="lb1 stg">
                                                <label for="">HOD</label>
                                            </div> 
                                            <div class="lb1 stg">
                                                <br>
                                                <br>
                                                ____________________
                                            </div>   
                                        </div>
                                        </div>
                                    </th>
                                </tr>
                               
                            </tbody>    
                        </table>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
        
@endsection
