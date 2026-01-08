<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;

$view = ReuseableCode::check_rights(475);
$edit = ReuseableCode::check_rights(476);
$delete = ReuseableCode::check_rights(477);

$Counter = 1;
$paramurl = "pdc/viewJobOrderDetail?m=".$m;
$paramOne = "stdc/viewIssuanceReturnDetail?m=".$m;
$paramThree = "View Issuance Return Detail";
$paramFour= url('/store/editIssuanceReturnForm/');

foreach($IssuanceReturn as $dataFil):
?>
<tr class="text-center" id="RemoveTr<?php echo $dataFil->id?>">
    <td><?php echo $Counter++;?></td>
    <td><?php echo strtoupper($dataFil->voucher_no)?></td>
    <td><?php echo CommonHelper::changeDateFormat($dataFil->voucher_date)?></td>
    <td><?php echo $dataFil->receipt_serial_no;?></td>
    <td><?php echo CommonHelper::get_sub_dept_name($dataFil->department_id)?></td>
    <td><?php echo CommonHelper::get_machine_name($dataFil->machine_id)?></td>
    <td><?php echo CommonHelper::get_line_name($dataFil->line_id)?></td>
    <td><?php echo $dataFil->description?></td>
    <td>
        @if ($view)
        <button onclick="showDetailModelOneParamerter('<?php echo $paramOne?>','<?php echo $dataFil->voucher_no;?>','<?php echo $paramThree?>')"   type="button" class="btn btn-success btn-xs">View</button>
        @endif
        
        <?php if($dataFil->voucher_status == 1):?>
        @if ($edit)
            <a id="BtnEdit<?php echo $dataFil->id?>" href='<?php echo  $paramFour.'/'.$dataFil->id.'?m='.$m ?>' type="button" target="_blank" class="btn btn-primary btn-xs">Edit</a>
        @endif
        @if ($delete)
            <button type="button" class="btn btn-xs btn-danger" onclick="delete_issue('<?php echo $dataFil->id?>')" id="BtnDelete<?php echo $dataFil->id?>">Delete</button>
        @endif
        <?php else: ?>
        @if($dataFil->issuance_type == 2 && $dataFil->transfer_status != 1)
        <button type="button" class="btn btn-xs btn-success" onclick="Recieved('<?php echo $dataFil->id?>','<?= $m ?>')" id="recieved<?php echo $dataFil->id?>"> Recieved</button>
        @endif
        <?php endif;?>
        <?php if(Auth::user()->id == 152 || Auth::user()->id == 104 && $dataFil->voucher_status == 2):?>
        <button type="button" class="btn btn-xs btn-danger" onclick="delete_issue('<?php echo $dataFil->id?>')" id="BtnDelete<?php echo $dataFil->id?>">Delete</button>
        <?php endif;?>
    </td>

</tr>
<?php endforeach;?>