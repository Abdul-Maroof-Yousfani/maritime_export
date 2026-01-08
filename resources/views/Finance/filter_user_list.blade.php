<?php
use App\Helpers\CommonHelper;

$counter = 1;
foreach ($Users as $row1) {
?>
<tr>
    <td class="text-center"><?php echo $counter++;?></td>
    <td class="text-center"><?php echo strtoupper($row1->name);?></td>
    <td class="text-center"><?php echo $row1->email;?></td>

    <td class="text-center"><?php echo CommonHelper::getCompanyName($row1->company_id);?></td>
    <td class="text-center"><?php if($row1->status == 1){echo 'Active';} else{ echo 'Inactive';}?></td>
    <td class="text-center hidden-print">
        <?php if($row1->status == 1):?>
        <button type="button" class="btn btn-xs btn-danger" id="BtnInactive<?php echo $row1->id?>" onclick="ActiveInActiveUser('<?php echo $row1->id?>','2')">Inactive</button>
        <?php else:?>
        <button type="button" class="btn btn-xs btn-danger" id="BtnActive<?php echo $row1->id?>" onclick="ActiveInActiveUser('<?php echo $row1->id?>','1')">Active</button>
        <?php endif;?>
        <button type="button" class="btn btn-xs btn-danger" id="BtnActive<?php echo $row1->id?>" onclick="deleteUser('<?php echo $row1->id?>')">Delete</button>
    </td>
</tr>
<?php }?>