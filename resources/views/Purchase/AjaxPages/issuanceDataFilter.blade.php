<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;

$view = ReuseableCode::check_rights(470);
$edit = ReuseableCode::check_rights(471);
$delete = ReuseableCode::check_rights(472);
$issuanReturnForm = ReuseableCode::check_rights(473);

$Counter = 1;
$paramurl = "pdc/viewJobOrderDetail?m=".$m;
$paramOne = "stdc/viewIssuanceDetail?m=".$m;
$paramThree = "View Issuance Detail";
$paramFour= url('/store/editIssuanceForm/');

foreach($Issuance as $dataFil):
?>
<tr class="text-center" id="RemoveTr<?php echo $dataFil->id?>">
    <td>{{$Counter++}}</td>
    <td>{{ strtoupper($dataFil->material_no ?? '') }}</td>
    <td>{{ strtoupper($dataFil->iss_no) }}</td>
    <td>{{CommonHelper::changeDateFormat($dataFil->iss_date)}}</td>
    <td>{{$dataFil->receipt_serial_no}}</td>
    <td><?php echo CommonHelper::get_sub_dept_name($dataFil->department_id)?></td>
    <td><?php echo CommonHelper::get_machine_name($dataFil->machine_id)?></td>
    <td><?php echo CommonHelper::get_line_name($dataFil->line_id)?></td>
    <td><?php echo $dataFil->description?></td>
    
    <td>
        @if ($view)
            <button onclick="showDetailModelOneParamerter('<?php echo $paramOne?>','<?php echo $dataFil->iss_no;?>','<?php echo $paramThree?>')" type="button" class="btn btn-success btn-xs">View</button>
        @endif
        
        <?php if($dataFil->issuance_status == 1):?>
        @if ($edit)
            <a id="BtnEdit<?php echo $dataFil->id?>" href='<?php echo  $paramFour.'/'.$dataFil->id.'?m='.$m ?>' type="button" class="btn btn-primary btn-xs">Edit</a>
        @endif
        @if ($delete)
            <button type="button" class="btn btn-xs btn-danger" onclick="delete_issue('<?php echo $dataFil->id?>')" id="BtnDelete<?php echo $dataFil->id?>">Delete</button>
        @endif
        <?php else: ?>
        @if($dataFil->issuance_type == 2 && $dataFil->transfer_status != 1)
        <button type="button" class="btn btn-xs btn-success" onclick="Recieved('<?php echo $dataFil->id?>','<?= $m ?>')" id="recieved<?php echo $dataFil->id?>"> Recieved</button>
        @endif
        <?php endif;?>
        <?php if(Auth::user()->id == 152 || Auth::user()->id == 104 && $dataFil->issuance_status == 2):?>
        <button type="button" class="btn btn-xs btn-danger" onclick="DeleteIssuance('<?php echo $dataFil->id?>')" id="BtnDelete<?php echo $dataFil->id?>">Delete</button>
        <?php endif;?>
        @if ($dataFil->issuance_status == 2 && $issuanReturnForm)
        <a href='{{url('store/createIssuanceReturnForm/'.$dataFil->id)}}' type="button" class="btn btn-warning btn-xs">Issuance Return</a>
        @endif
    </td>

</tr>
<?php endforeach;?>