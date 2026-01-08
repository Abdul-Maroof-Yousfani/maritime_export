<?php
use App\Helpers\CommonHelper;
use App\Helpers\FinanceHelper;
use App\Helpers\ReuseableCode;
//        print_r($_GET);die();
$from = $_GET['FromDate'];
$to = $_GET['ToDate'];
$company_location_id = $_GET['company_location_id'];
$condition = '';
if (!empty($company_location_id)) {
    $condition = "and g.company_location_id =$company_location_id";
}

?>



<?php
/*
$supp=$this->db->query('select s.id,s.name from supplier s
      inner join goods_receipt_note d on s.id=d.supplier_id
      where s.status = 1
      and g.grn_date between "'.$from.'" and "'.$to.'"
    group  by s.id')->result_array();
        */

$supp = DB::Connection('mysql2')->select(
    'select s.id,s.name from supplier s
      inner join goods_receipt_note g on s.id=g.supplier_id
      where s.status = 1 ' .
        $condition .
        '
      and g.grn_date between "' .
        $from .
        '" and "' .
        $to .
        '"
    group  by s.id',
);
?>

<?php $main_index = 0;
$alltotal = 0;
$total = 0;
?>
<?php foreach ($supp as $supplier) : ?>
<tr class="text-center">
    <td style="font-size: 25px;" colspan="7"><strong><?php echo 'SUPPLIER' . ' : ' . $supplier->name;
    $cars[$main_index] = $supplier->name; ?></strong></td>
</tr>
<b style="text-transform: uppercase !important;"></b>
<?php
    // $grn_data1 =DB::Connection('mysql2')->select('select g.grn_date as date,g.supplier_invoice_no as no, g.company_location_id, d.* from grn_data as d
    //   inner join goods_receipt_note g on g.grn_no=d.grn_no
    //   where g.supplier_id="'.$supplier->id.'"
    //    and  g.status=1 '. $condition.'
    //    and d.status=1
    //    and d.grn_status in (2)
    //     and g.grn_date between "'.$from.'" and "'.$to.'"');
    $grn_data1 = DB::connection('mysql2')
    ->table('grn_data as d')
    ->join('goods_receipt_note as g', 'g.grn_no', '=', 'd.grn_no')
    ->select('g.grn_date', 'g.supplier_invoice_no as no', 'g.company_location_id', 'd.*')
    ->where('g.supplier_id', $supplier->id)
    ->where('g.status', 1)
    ->where(function($query) use($company_location_id){
        if ($company_location_id)        {
            $query->where('g.company_location_id',$company_location_id);
        }else {
            $query->whereIn('g.company_location_id', ReuseableCode::getUserWiseLocationRights());
        }
    })
    ->where('d.status', 1)
    ->where('d.purchase_recived_qty', '>', 0)
    ->whereIn('d.grn_status', [2])
    ->whereBetween('g.grn_date', [$from, $to])
    ->get();
            /*
    $grn_data1=	$this->db->query('select g.grn_date as date,g.supplier_invoice_no as no,d.* from grn_data as d
      inner join goods_receipt_note g on g.grn_no=d.grn_no
      where d.supplierId="'.$supplier->id.'"
       and  g.status=1
       and d.status=1
       and g.grn_status in (2)
        and g.grn_date between "'.$from.'" and "'.$to.'"')->result_array();
            */

    /*		$grn_data1=$this->db->query('select   g.grn_date,d.item,
    d.expiryDate,
    g.grn_no,
    g.invoice_no,
    d.companyId,
    d.supplierId,
    d.netAmount as amount,
    d.goodReceivedQuantity
     from
    goods_receipt_note g
    inner join
    grn_data d
    ON
    d.grn_no=d.grn_no
    where g.status=1
    and g.grn_date between "'.$from.'" and "'.$to.'"
    ')->result_array();*/

    $count=1;

    foreach ($grn_data1 as $grn_data):?>


<tr>
    <td class="text-center"><?php echo $count; ?></td>

    <td class="text-left"><?php echo CommonHelper::get_item_name($grn_data->sub_item_id); ?></td>

    <td class="text-center"><?php echo CommonHelper::changeDateFormat($grn_data->grn_date); ?></td>

    <td class="text-center"><?php echo strtoupper($grn_data->grn_no); ?></td>

    <td class="text-center"><?php echo $grn_data->no; ?></td>

    <td class="text-center"> <?php echo $grn_data->purchase_recived_qty; ?></td>

    <td class="text-center"> <?php echo $amount = $grn_data->amount; ?></td>
    <td class="text-center"> <?php echo CommonHelper::getLocationDetail($grn_data->company_location_id)->location_name ?? ''; ?></td>
</tr>

<?php
    $alltotal +=$amount;
    $total +=$amount;

    $count++;
    endforeach;?>


<?php ?>
<?php if ($total>0): ?>
<tr style="color: black;" class="sf-table-total">
    <td colspan="6" class="text-center"><b style="font-size: 15px; color: #000;">Total</b></td>

    <?php $total1[] = $total; ?>
    </td>


    <td class="text-center" colspan=""><b style="font-size: 15px; color: #000;"><?php echo $total;
    $total = 0; ?></b></td>
</tr> <?php endif;?>



<?php  $main_index++; endforeach; ?>
