<?php
use App\Helpers\CommonHelper;
use App\Helpers\StoreHelper;
use App\Helpers\ReuseableCode;

$id = $_GET['id'];

$m = Session::get('run_company');
$approve = ReuseableCode::check_rights(16);

$currentDate = date('Y-m-d');
CommonHelper::companyDatabaseConnection($m);
$purchaseRequestDetail = DB::table('purchase_request')
    ->where('id', '=', $id)
    ->get();
// dd($purchaseRequestDetail);
CommonHelper::reconnectMasterDatabase();

if ($_GET['pageType'] == 'viewlist') {
    $EmailPrintSetting = $_GET['EmailPrintSetting'];
} else {
    $EmailPrintSetting = $_GET['EmailPrintSetting'];
}
?>

<div id="Pdfsetting" <?php if($EmailPrintSetting==2){ ?> style="display: none;" <?php } ?>>
    <button onclick="change()" type="button" class="btn btn-primary btn-xs">Show PKR</button>

    <style>
        textarea {
            border-style: none;
            border-color: Transparent;

        }

        .pGap p {
            margin: 0;
        }
    </style>
    <div style="line-height:5px;">&nbsp;</div>
</div>

<?php
    foreach ($purchaseRequestDetail as $row) {
?>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 printHide">
        {{-- <input type="text" name="email" id="email" value="" class="form-control" placeholder="Enter Email Address"> --}}
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 printHide">
        {{-- <button class="btn btn-primary btn-sm" onclick="EmailSent()"> Email Sent </button> --}}
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <?php
        if ($approve == true):
            echo StoreHelper::displayApproveDeleteRepostButtonPurchaseRequest($m, $row->purchase_request_status, $row->status, $row->id, 'purchase_request_no', 'purchase_request_status', 'status', 'purchase_request', 'purchase_request_data');
        endif;
        ?>
        <?php CommonHelper::displayPrintButtonInView('po_detail', 'LinkHide', '1'); ?>
    </div>
    <div style="line-height:5px;">&nbsp;</div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="po_detail">
        <div class="well">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label style="border-bottom:2px solid #000 !important;">Printed On Date&nbsp;:&nbsp;</label><label
                        style="border-bottom:2px solid #000 !important;"><?php echo CommonHelper::changeDateFormat(date('Y-m-d'));
                        $x = date('Y-m-d');
                        echo ' ' . '(' . date('D', strtotime($x)) . ')'; ?></label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                    <?php echo CommonHelper::get_company_logo(Session::get('run_company')); ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div class="text-danger pGap">
                        <p>{{ CommonHelper::getLocationDetail($row->company_location_id)->location_name }} Unit</p>
                        <p>Delivery Address:
                            {{ CommonHelper::getLocationDetail($row->company_location_id)->location_address }}</p>
                        <p>Contact Person:
                            {{ CommonHelper::getLocationDetail($row->company_location_id)->location_contact_person }}
                        </p>
                        <p>Contact Number:
                            {{ CommonHelper::getLocationDetail($row->company_location_id)->location_contact_no }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h3 style="text-align: center;">
                        <h3 style="text-align: center;">Purchase Order</h3>
                    </h3>
                </div>
            </div>


            <div style="line-height:5px;">&nbsp;</div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div style="width:40%; float:left;">
                        <table class="table table-bordered table-striped table-condensed tableMargin purchase_order">
                            <tbody>
                                <tr>
                                    <td style="width:50%;">PO NO.</td>
                                    <td style="width:50%;"><?php echo strtoupper($row->purchase_request_no); ?></td>
                                </tr>


                                <tr>
                                    <td>PO Date</td>
                                    <td><?php echo CommonHelper::changeDateFormat($row->purchase_request_date); ?></td>
                                </tr>

                                {{-- <tr>
                                    <td>PO Type</td>
                                    <td>{{ CommonHelper::get_po_type($row->po_type) }}</td>
                                </tr> --}}
                                <tr>
                                    <td>Supplier Name</td>
                                    <td><?php echo CommonHelper::get_supplier_name($row->supplier_id); ?></td>
                                </tr>

                                <tr>
                                    <td>NTN</td>
                                    <td><?php echo CommonHelper::get_supplier_ntn($row->supplier_id); ?></td>
                                </tr>
                                <tr>
                                    <td>STRN</td>
                                    <td><?php echo $row->trn; ?></td>
                                </tr>

                                {{-- <tr>
                                    <td>Comparative Statement NO#</td>
                                    <td id="comparativeState"></td>
                                </tr> --}}

                            </tbody>
                        </table>

                    </div>
                    <div style="width:40%; float:right;">
                        <table class="table table-bordered table-striped table-condensed tableMargin  purchase_order">
                            <tbody>
                                <tr>
                                    <td style="width:60%;">Supplier Reference No.</td>
                                    <td style="width:40%;"><?php echo $row->slip_no; ?></td>
                                </tr>
                                <tr>
                                    <td>Department / Sub Department</td>
                                    <td><?php echo CommonHelper::getMasterTableValueById($m, 'sub_department', 'sub_department_name', $row->sub_department_id); ?></td>
                                </tr>
                                <tr>
                                    <td style="width:60%;">Terms Of Delivery</td>
                                    <td style="width:40%;"><?php echo $row->term_of_del; ?></td>
                                </tr>
                                <tr>
                                    <td style="width:60%;">Terms Of Payment</td>
                                    <td style="width:40%;"><?php echo $row->terms_of_paym; ?></td>
                                </tr>

                                <tr>
                                    <td style="width:60%;">Destination</td>
                                    <td style="width:40%;"><?php echo $row->destination; ?></td>
                                </tr>
                                <?php $currency = CommonHelper::get_curreny_name($row->currency_id); ?>

                                <tr>
                                    <td class="showw" style="width:60%;display: none">Currency Rate </td>
                                    <td class="showw" style="width:40%;display: none">{{ $row->currency_rate }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-condensed tableMargin  purchase_order purchase_order2">
                            <thead>
                                <tr>
                                    <th class="text-center">PR NO#</th>
                                    {{-- <th class="text-center">PR NO</th> --}}
                                    {{-- <th style="font-size: 13px;" class="text-center">PR  Date </th> --}}

                                    <th class="text-center">Comparative NO#</th>
                                    <th class="text-center">Item Name</th>
                                    <th class="text-center">Remarks</th>
                                    <th class="text-center">UOM</th>
                                    <th class="text-center">Approved. Qty. <span
                                            class="rflabelsteric"><strong>*</strong></span></th>
                                    <th class="text-center">Rate. <span class="rflabelsteric"><strong>*</strong></span>
                                    </th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Discount%</th>
                                    <th class="text-center">Discount Amount</th>
                                    <th class="text-center">Net Amount</th>
                                    <th class="text-center showw" style="display: none">Amount In PKR</th>
                                    <th class="text-center printHide">Action</th>
                                    <th class="text-center printHide">View</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                            CommonHelper::companyDatabaseConnection($m);
                            $purchaseRequestDataDetail = DB::table('purchase_request_data')->where('master_id','=',$id)->where('sub_item_id','!=',0)->get();
                            CommonHelper::reconnectMasterDatabase();
                            $counter = 1;
                                    $total=0;
                            $total_exchange=0;
                            foreach ($purchaseRequestDataDetail as $row1){
                                $quotationID = App\Models\Quotation::where('group_number', $row1->group_number)->where('status', 1)->first()->id??'';
                            ?>
                                <tr>

                                    <td class="text-center">
                                        @if ($row1->demand_no)
                                            <button onclick="showDetailModelOneParamerter('{{'pdc/viewDemandVoucherDetail?m='.$m}}','{{$row1->demand_no}}','View Purchase Request List')" type="button" class="btn btn-link btn-xs">{{$row1->demand_no}}</button>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if ($row1->group_number)
                                        <button
                                            onclick="showDetailModelOneParamerter('quotation/qutation_summary?m=<?php echo Session::get('run_company') . '&quotation_id=' . $quotationID.'&groupno='.$row1->group_number; ?>',{{$row1->group_number}},'Quotation')"
                                            type="button" class="btn btn-link btn-xs">{{$row1->group_number}}</button>
                                        @endif
                                    </td>
                                    {{-- <td class="text-center">< ?php echo strtoupper($row1->demand_no);?></td> --}}
                                    {{-- <td class="text-center">< ?php echo  CommonHelper::changeDateFormat($row1->demand_date);?></td> --}}
                                    <?php $sub_ic_detail = CommonHelper::get_subitem_detail($row1->sub_item_id);
                                    $sub_ic_detail = explode(',', $sub_ic_detail);
                                    ?>
                                    <td title="item_name={{ CommonHelper::get_item_name($row1->sub_item_id) }}">
                                        <?php $accType = Auth::user()->acc_type;
                                    if($accType == 'client'):
                                    ?>
                                        <a class="LinkHide"
                                            href="<?php echo url('/'); ?>/store/stockReportView?item_id=<?php echo $row1->sub_item_id; ?>&&pageType=&&parentCode=126&&m=1"
                                            target="_blank">
                                            <?php echo $sub_ic_detail[10].' - '.CommonHelper::get_item_name($row1->sub_item_id); //echo CommonHelper::get_item_name($row1->sub_item_id); ?>
                                        </a>
                                        <?php else:?>
                                        <?php echo $sub_ic_detail[10].' - '.CommonHelper::get_item_name($row1->sub_item_id); ?>
                                        <?php endif;?>
                                    </td>


                                   
                                    <td class="text-center"><?php echo $row1->description; ?></td>

                                    <td><?php echo $sub_ic_detail[0]; ?>
                                        <input type="hidden" value="<?php echo $row1->sub_item_id; ?>"
                                            id="sub_<?php echo $counter; ?>">
                                        <input type="hidden" value="{{ $row1->group_number }}" class="group_number">
                                    </td>
                                    <td class="text-center"><?php echo $row1->purchase_approve_qty; ?></td>
                                    <td class="text-center"><?php echo number_format($row1->rate, 2); ?></td>
                                    <td class="text-right"><?php echo number_format($row1->rate * $row1->purchase_approve_qty, 2); ?></td>
                                    <td class="text-right"><?php echo number_format($row1->discount_percent, 2); ?></td>
                                    <td class="text-right"><?php echo number_format($row1->discount_amount, 2); ?></td>
                                    <td class="text-right"><?php echo number_format($row1->net_amount, 2); ?></td>
                                    <td style="display: none" class="text-right showw"><?php echo number_format($row1->net_amount * $row->currency_rate, 2); ?></td>
                                    <td class="text-right printHide">

                                        @if ($row1->status == 401)
                                            <span style="color: red;">Cancelled</span>
                                        @else
                                            @php
                                                $grnQty = App\Models\GRNData::where('po_data_id', $row1->id)
                                                    ->where('status', 1)
                                                    ->sum('purchase_recived_qty');
                                            @endphp
                                            @if ($grnQty > 0)
                                                GRN CREATED
                                            @else
                                                <button type="button" class="btn btn-xs btn-danger" id="cancelPR{{$row1->id}}"
                                                    onclick="cancelPODataItems({{ $row1->id }})">Cancel</button>
                                            @endif
                                        @endif

                                    </td>
                                    <td style="background-color: #ccc" class="printHide">
                                        <input onclick="view_history(<?php echo $counter; ?>)" type="checkbox"
                                            id="view_history<?php echo $counter; ?>">
                                    </td>
                                </tr>
                                <?php

                                    $total+=$row1->net_amount;
                            $total_exchange+=$row1->sub_total*$row->currency_rate;
                            }
                            ?>

                                <tr>

                                    <td style="background-color: darkgray" class="text-center" colspan="8">Total
                                    </td>
                                    <td style="background-color: darkgray" class="text-right" colspan="5">
                                        {{ number_format($total, 2) }}</td>
                                    <td style="background-color: darkgray;display: none" class="text-right showw"
                                        colspan="1">{{ number_format($total_exchange, 2) }}</td>
                                </tr>
                            </tbody>

                            <tr>
                                <td class="text-center" colspan="8">{{ 'Sales Tax :' . $row->sales_tax . ' %' }}
                                </td>
                                <td class="text-right" colspan="6">{{ number_format($row->sales_tax_amount, 2) }}
                                </td>
                            </tr>

                            <tr>

                                <td style="background-color: darkgray" class="text-center" colspan="8">Grand Total
                                </td>
                                <td style="background-color: darkgray" class="text-right" colspan="5">
                                    {{ number_format($total + $row->sales_tax_amount, 2) }}</td>
                                <td style="background-color: darkgray;display: none" class="text-right showw"
                                    colspan="6">{{ number_format($total_exchange + $row->sales_tax_amount, 2) }}
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-condensed tableMargin  purchase_order">
                        <tr>
                            <td style="text-transform: capitalize;">Amount In Words : <?php echo $row->amount_in_words . '('; ?>
                                <?php if ($currency == ''):
                                    echo 'PKR';
                                else:
                                    echo $currency;
                                endif; ?> )</td>
                        </tr>
                    </table>
                </div>

                <div style="line-height:8px;">&nbsp;</div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <textarea style="line-height: 15px;font-size: 11px;resize: none" cols="100" rows="10"><?php echo 'Description:' . ' ' . strtoupper($row->description); ?></textarea>
                        </div>
                    </div>
                    <style>
                        .signature_bor {
                            border-top: solid 1px #CCC;
                            padding-top: 7px;
                        }
                    </style>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:40px;">
                        <div class="container-fluid">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <h6 class="signature_bor">Prepared By: </h6>
                                    <b>
                                        <p><?php echo strtoupper($row->username); ?></p>
                                    </b>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <h6 class="signature_bor">Checked By:</h6>
                                    <b>
                                        <p><?php ?></p>
                                    </b>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <h6 class="signature_bor">Approved By:</h6>
                                    <b>
                                        <p><?php echo strtoupper($row->approve_username); ?></p>
                                    </b>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
    <?php
        }
    ?>
</div>

<script>
    function cancelPODataItems(id) {
        $.ajax({
            url: '<?php echo url('/'); ?>/pdc/cancelPODataItems',
            type: 'get',
            data: {
                id: id,
            },
            success: function(response) {
                $('#cancelPR' + id).attr('disabled', true)
                // alert(response);
            }
        });
    }
    $(function() {
        let groupNum = "";
        var groupNumber = $('.group_number');
        for (let i = 0; i < groupNumber.length; i++) {
            if (groupNum == "") {
                groupNum = groupNumber[i].value;
            } else {
                groupNum = groupNum + "," + groupNumber[i].value;
            }
        }
        $('#comparativeState').text(groupNum);
    })

    function view_history(id) {

        var v = $('#sub_' + id).val();


        if ($('#view_history' + id).is(":checked")) {
            if (v != null) {
                showDetailModelTwoParamerter('pdc/viewHistoryOfItem_directPo?id=' + v);
            } else {
                alert('Select Item');
            }

        }
    }

    function change() {
        if (!$('.showw').is(':visible')) {
            $(".showw").fadeIn();

        } else {
            $(".showw").fadeOut();
        }
    }

    function EmailSent() {
        if (confirm('Are you sure you want to Sent Email to this request')) {
            pageType = "pageType1";
            EmailPrintSetting = "2";
            id = "<?php echo $id; ?>";
            m = "<?php echo $m; ?>";
            email = $("#email").val();
            $.ajax({
                url: '<?php echo url('/'); ?>/stad/Email_Sent',
                type: 'get',
                data: {
                    email: email,
                    id: id,
                    m: m,
                    pageType: pageType,
                    EmailPrintSetting: EmailPrintSetting
                },
                success: function(response) {
                    alert(response);
                }
            });
        } else {
            alert("Email Not Sended");
        }
    }
</script>
