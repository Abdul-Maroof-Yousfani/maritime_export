<?php
use App\Helpers\CommonHelper;
use App\Helpers\PurchaseHelper;
use App\Helpers\ReuseableCode;
use App\Models\IssuanceReturn;
$approve = ReuseableCode::check_rights(478);
$id = $_GET['id'];
$m = Session::get('run_company');
$currentDate = date('Y-m-d');

$MasterData = IssuanceReturn::where('voucher_no', '=', $id)->get();
$MasterData1 = IssuanceReturn::where('voucher_no', '=', $id)->first();
?>
<style>
    .textBold {
        font-weight: bolder;
        font-size: 18px;
    }
</style>


<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        <?php CommonHelper::displayPrintButtonInView('printDemandVoucherVoucherDetail', '', '1'); ?>
    @if($MasterData1->voucher_status ==  1 && $approve)  
      <a  id="approved"href="#"onClick="approved({{$MasterData1->id}})" class="btn btn-success" style="padding: 10px;">Approved</a>
    @endif
    </div>
   
</div>
@foreach ($MasterData as $row)
<div class="row" id="printDemandVoucherVoucherDetail">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                <label style="border-bottom:2px solid #000 !important;">Printed On Date&nbsp;:&nbsp;</label><label
                    style="border-bottom:2px solid #000 !important;"><?php echo CommonHelper::changeDateFormat($currentDate); ?></label>
            </div>
            
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"
                        style="font-size: 30px !important; font-style: inherit;
    								font-family: -webkit-body; font-weight: bold;">
                        <?php echo CommonHelper::getCompanyName($m); ?>
                        <h3 style="text-align: center;">Issuance Return</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                <?php $nameOfDay = date('l', strtotime($currentDate)); ?>
                <label style="border-bottom:2px solid #000 !important;">Printed On Day&nbsp;:&nbsp;</label><label
                    style="border-bottom:2px solid #000 !important;"><?php echo '&nbsp;' . $nameOfDay; ?></label>

            </div>
        </div>
        <div style="line-height:5px;">&nbsp;</div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                <table class="table table-bordered table-striped table-condensed tableMargin">
                    <tbody>
                        <tr>
                            <td>Issuance No.</td>
                            <td class="text-center">{{ strtoupper($row->voucher_no) }}</td>
                        </tr>
                        <tr>
                            <td>Issuance Date</td>
                            <td class="text-center">{{ CommonHelper::changeDateFormat($row->voucher_date) }}</td>
                        </tr>
                        <tr>
                            <td>Receipt Serial No</td>
                            <td class="text-center">{{ $row->receipt_serial_no }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"></div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                <table class="table table-bordered table-striped table-condensed tableMargin">
                    <tbody>
                        <tr>
                            <td>Department</td>
                            <td class="text-center"> {{ CommonHelper::get_sub_dept_name( $row->department_id) }}</td>
                        </tr>
                        <tr>
                            <td>Machine</td>
                            <td class="text-center"> {{ CommonHelper::getCompanyDatabaseTableValueById($m, 'machineries', 'name', $row->machine_id) }}</td>
                        </tr>
                        <tr>
                            <td>Line</td>
                            <td class="text-center"> {{ CommonHelper::getCompanyDatabaseTableValueById($m, 'lines','name', $row->line_id) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed tableMargin">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:50px;">S.No</th>
                            <th class="text-center">Product</th>
                            <th class="text-center">Uom</th>
                            <th class="text-center">Issuance Quantity</th>
                            <th class="text-center">Return Quantity</th>
                            <th class="text-center">Warehouse </th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Batch Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($row->issuence_return_datas as $key => $row1)
                            <tr class="text-center">
                                <td class="text-center">{{ ++$key }}</td>
                                <td id="{{ $row1->id }}" title="{{ $row1->sub_item_id }}" class="textChanger">
                                    {{ CommonHelper::getCompanyDatabaseTableValueById($m, 'subitem', 'sub_ic', $row1->sub_item_id) }}
                                </td>
                                <td>{{ CommonHelper::get_uom($row1->sub_item_id) }}</td>
                                <td class="text-center">{{ number_format($row1->issuace_qty, 2) }}</td>
                                <td class="text-center">{{ number_format($row1->return_qty, 2) }}</td>

                                <td>
                                    {{ CommonHelper::getCompanyDatabaseTableValueById($m, 'warehouse', 'name', $row1->warehouse_id) }}
                                </td>
                                <td>
                                    {{ CommonHelper::qualityType()[$row1->quality_type - 1]['name'] }}
                                </td>
                                <td>
                                    {{ $row1->batch_code }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div style="line-height:8px;">&nbsp;</div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h6>Remarks: <?php echo strtoupper($row->description); ?></h6>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<script type="text/javascript">
    function ViewVoucher() {
        if ($('#ShowVoucher').is(':checked')) {
            $('.ShowVoucherDetail').css('display', 'block');
        } else {
            $('.ShowVoucherDetail').css('display', 'none');
        }
    }

    function approved(id)
    {        
        $.ajax({
            url:'{{url("/pdc/approved_stock_return_issuance")}}',
            data:{item:id},
            type:'GET',
            success:function(response)
            {  
                if(response.error == 'error')
                {
                    alert('Can not Approved Because the Item is not exist in Record')
                    return false;
                }else if(response.error =='success'){
                    
                    alert('Approved Successfully');
                    $('#approved').remove();
                    getIssuanceReturnData();
                }
            }
        })
    }
</script>
