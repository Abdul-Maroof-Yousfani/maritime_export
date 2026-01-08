<?php
use App\Helpers\CommonHelper;
use App\Helpers\StoreHelper;
use App\Helpers\FinanceHelper;
use App\Helpers\ReuseableCode;
$MenuPermission = true;


$accType = Auth::user()->acc_type;
if($accType == 'client'){
    $m = $_GET['m'];
}else{
    $m = Auth::user()->company_id;
}
$current_date = date('Y-m-d');
$currentMonthStartDate = date('Y-m-01');
$currentMonthEndDate   = date('Y-m-t');

if($accType =='user'):
    $user_rights = DB::table('menu_privileges')->where([['emp_code','=',Auth::user()->emp_code],['compnay_id','=',Session::get('run_company')]]);
    $submenu_ids  = explode(",",$user_rights->value('submenu_id'));
    if(in_array(81,$submenu_ids))
    {
        $MenuPermission = true;
    }
    else
    {
        $MenuPermission = false;
    }
endif;

?>

@extends('layouts.default')

@section('content')
    @include('select2')
    @include('modal')
    @include('number_formate')

    <script>
        var counter=1;
    </script>

    <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="well_N">
            <div class="dp_sdw">    
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <span class="subHeadingLabelClass">Create Direct Purchase Order  Form</span>
                        <?php
                        if($MenuPermission == true):?>
								<?php else:?>
                        <span class="subHeadingLabelClass text-danger text-center" style="float: right">Permission Denied <span style='font-size:45px !important;'>&#128546;</span></span>
                        <?php endif;

                        ?>
                    </div>
                </div>
                <?php if($MenuPermission == true):?>
                <div class="lineHeight">&nbsp;</div>


                <?php echo Form::open(array('url' => 'stad/insertDirectPurchaseOrder?m='.$m.'','id'=>'addPurchaseRequestDetail','class'=>'stop'));?>
                <?php


                // $purchaseRequestNo=CommonHelper::get_unique_direct_po_no(2);
                ?>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <input type="hidden" name="pageType" value="<?php echo $_GET['pageType']?>">
                <input type="hidden" name="parentCode" value="<?php echo $_GET['parentCode']?>">
                <div class="panel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">

                                    {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label class="sf-label">PO NO.</label>
                                        <input readonly type="text" class="form-control requiredField" placeholder="" name="po_no" id="po_no" value="{{strtoupper($purchaseRequestNo)}}" />
                                    </div> --}}

                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label class="sf-label">PO DATE.</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <input type="date" class="form-control requiredField" max="<?php echo date('Y-m-d') ?>" name="po_date" id="po_date" value="<?php echo date('Y-m-d') ?>" />
                                    </div>



                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label class="sf-label">Department / Sub Department</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <select class="form-control requiredField select2" name="sub_department_id_1" id="sub_department_id_1">
                                            <option value="">Select Department</option>
                                            @foreach($departments as $key => $y)
                                                <optgroup label="{{ $y->department_name}}" value="{{ $y->id}}">
                                                    <?php
                                                    $subdepartments = DB::select('select `id`,`sub_department_name` from `sub_department` where  `department_id` ='.$y->id.'');
                                                    ?>
                                                    @foreach($subdepartments as $key2 => $y2)
                                                        <option value="{{ $y2->id}}">{{ $y2->sub_department_name}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label class="sf-label">Terms Of Delivery</label>
                                        <input type="text" class="form-control" placeholder="Terms Of Delivery" name="term_of_del" id="term_of_del" value="" />
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label class="sf-label">PO Type</label>
                                        <select onchange="get_po(this.id)" name="po_type" id="po_type" class="form-control">
                                            <option value="1">Purchase Local</option>
                                            <option value="2">Self</option>
                                            <option value="3">International</option>
                                        </select>
                                    </div>

                                </div>


                                <div class="row">


                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="sf-label">Destination</label>
                                        <input style="text-transform: capitalize;"  type="text" class="form-control" placeholder="" name="destination" id="destination" value="" />
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="sf-label"> <a href="#" onclick="showDetailModelOneParamerter('pdc/createSupplierFormAjax');" class="">Vendor</a></label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <select onchange="get_address()" name="supplier_id" id="supplier_id" class="form-control requiredField select2">
                                            <option value="">Select Vendor</option>
                                            <?php
                                            foreach ($supplierList as $row1){

                                            $address= CommonHelper::get_supplier_address($row1->id);
                                            ?>
                                            <option value="<?php echo $row1->id.'@#'.$address.'@#'.$row1->ntn.'@#'.$row1->terms_of_payment?>"><?php echo ucwords($row1->name)?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="sf-label"> <a href="#" onclick="showDetailModelOneParamerter('pdc/createCurrencyTypeForm')" class="">Currency</a></label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <select onchange="claculation(1);get_rate()" name="curren" id="curren" class="form-control select2 requiredField">
                                            <option value="0,1"> PKR</option>

                                            @foreach(CommonHelper::get_all_currency() as $row)
                                                <option value="{{$row->id.','.$row->rate}}">{{$row->curreny}}</option>
                                            @endforeach;

                                        </select>

                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="sf-label"> Currency Rate</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <input class="form-control" type="text" name="currency_rate" id="currency_rate" />

                                    </div>

                                    <input type="hidden" name="curren_rate" id="curren_rate" value="1"/>

                                </div>

                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label class="sf-label">Mode/ Terms Of Payment <span class="rflabelsteric"><strong>*</strong></span></label>
                                        <input onkeyup="calculate_due_date()"  type="number" class="form-control requiredField" placeholder="" name="model_terms_of_payment" id="model_terms_of_payment" value="" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label class="sf-label">Due Date <span class="rflabelsteric"><strong>*</strong></span></label>
                                        <input  type="date" class="form-control" placeholder="" name="due_date" id="due_date" value="" readonly />
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>

                                <div class="row">

                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                        <label class="sf-label">Supplier's Address</label>
                                        <input style="text-transform: capitalize;" readonly type="text" class="form-control" placeholder="" name="address" id="addresss" value="" />
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label class="sf-label">Supplier's NTN</label>
                                        <input readonly type="text" class="form-control" placeholder="Ntn" name="ntn" id="ntn_id" value="" />
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="sf-label">Mode Type</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <select class="form-control requiredField select2" name="mode_type"
                                            id="mode_type">
                                            <option value="">Select Mode</option>
                                            <option value="1">Urgent</option>
                                            <option value="2">Normal</option>
                                            <option value="3">MOST URGENT</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="sf-label">Select Company Location</label>
                                        <select class="form-control requiredField select2" name="company_location_id"
                                            id="company_location_id">
                                            <option value="">Select Location</option>
                                            @foreach (ReuseableCode::getUserWiseLocationRightsData() as $company_location)
                                                <option value="{{$company_location['id']}}">{{$company_location['location_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="sf-label">TRN<span class="rflabelsteric"><strong>*</strong></span></label>
                                        <input type="text" name="trn" id="trn" class="form-control requiredField" placeholder="TRN">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="sf-label">Builty No</label>
                                        <input type="text" name="builty_no" id="builty_no" class="form-control " placeholder="Builty No">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="sf-label">Remarks</label>
                                        <textarea  name="Remarks" id="terms_and_condition" class="form-control" placeholder="Remarks"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12  col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label class="sf-label">Terms & Condition</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                    <textarea  name="main_description" id="main_description" rows="4" cols="50" style="resize:none;font-size: 11px;" class="form-control requiredField">YOUR NTN NUMBER AND VALID INCOME TAX EXEMPTION WILL BE REQUIRED FOR PAYMENT, OTHER WISE INCOME TAX WILL BE DEDUCTED AS PER FOLLOWINGS:
INCOME TAX:
FOR COMPANIES SUPPLIES 4% & SERVICES 8% (FILER) / 12% (NON FILER)
FOR INDIVIUALS OR AOP SUPPLIES 4.5% & SERVICES 10% (FILER) / 15% (NON FILER)
SALES TAX ON SUPPLIES:
A WITHOLDING AGENT SHALL DEDUCT AN AMOUNT AS PER SRO 897 /2013
SALES TAX ON SERVICES:
A WITHOLDING AGENT SHALL DEDUCT AN AMOUNT AS PER SRB WITHHOLDING RULES-2014</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive" >
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr class="text-center">
                                            <th colspan="6" class="text-center">Purchase Order Detail</th>
                                            <th colspan="2" class="text-center">
                                                <input type="button" class="btn btn-sm btn-primary" onclick="AddMoreDetails()" value="Add More Rows" />
                                            </th>
                                            <th class="text-center">
                                                <span class="badge badge-success" id="span">1</span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" style="width: 35%;">Item</th>
                                            <th class="text-center" >Uom<span class="rflabelsteric"><strong>*</strong></span></th>
                                            <th class="text-center" >Actual Qty<span class="rflabelsteric"><strong>*</strong></span></th>
                                            <th class="text-center">Rate<span class="rflabelsteric"><strong>*</strong></span></th>
                                            <th class="text-center">Amount<span class="rflabelsteric"><strong>*</strong></span></th>
                                            <th class="text-center">Discount %<span class="rflabelsteric"><strong>*</strong></span></th>
                                            <th class="text-center">Discount Amount<span class="rflabelsteric"><strong>*</strong></span></th>
                                            <th class="text-center">Net Amount<span class="rflabelsteric"><strong>*</strong></span></th>
                                            <th class="text-center">Delete<span class="rflabelsteric"><strong>*</strong></span></th>
                                        </tr>
                                        </thead>
                                        <tbody id="AppnedHtml">
                                            <tr title="1" class="AutoNo">
                                                <td>
                                                  <input type="hidden" class="form-control requiredField sam_jass" name="sub_ic_des[]" id="item_1" placeholder="ITEM">
                                                    <select class="form-control select2" name="item_id[]" onchange="itemChange(1)" id="sub_1">
                                                        <option value="0">Select Item</option>
                                                        @foreach (App\Models\Subitem::all() as $item)
                                                        @php
                                                            $pack_size = $item->pack_size ? ' - ' . $item->pack_size : '';
                                                        @endphp
                                                        <option value="{{ $item->id }}" data-id="{{ $item->id }}" data-uom="{{$item->uomData->uom_name}}">
                                                            {{ $item->sku_code. ' - '. $item->sub_ic. $pack_size }}
                                                        </option>
                                                        @endforeach

                                                    </select>
                                                    <textarea name="item_remark[]" id="item_remark1" class="form-control" style="margin-top: 8px" rows="5" placeholder="Item Remarks"></textarea>
                                                </td>

                                                <td>
                                                    <input readonly type="text" class="form-control" name="uom_id[]" id="uom_id1" >
                                                </td>
                                                <td>
                                                    <input type="text" onkeyup="claculation('1')" class="form-control requiredField ActualQty" name="actual_qty[]" id="actual_qty1" placeholder="ACTUAL QTY" min="1" value="">
                                                </td>
                                                <td>
                                                    <input type="text" onkeyup="claculation('1')" class="form-control requiredField ActualRate" name="rate[]" id="rate1" placeholder="RATE" min="1" value="">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="amount[]" id="amount1" placeholder="AMOUNT" min="1" value="" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" onkeyup="discount_percent(this.id)" class="form-control requiredField" name="discount_percent[]" id="discount_percent1" placeholder="DISCOUNT" min="1" value="0">
                                                </td>
                                                <td>
                                                    <input type="text" onkeyup="discount_amount(this.id)" class="form-control requiredField" name="discount_amount[]" id="discount_amount1" placeholder="DISCOUNT" min="1" value="0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control net_amount_dis" name="after_dis_amount[]" id="after_dis_amount1" placeholder="NET AMOUNT" min="1" value="0.00" readonly>
                                                </td>
                                                <td style="background-color: #ccc">
                                                    <input onclick="view_history(1)" type="checkbox" id="view_history1">
                                                </td>
                                            </tr>
                                        </tbody>

                                        <tbody>
                                        <tr  style="background-color: darkgrey;font-size:large;font-weight: bold">
                                            <td class="text-center" colspan="7">Total</td>
                                            <td id="" class="text-right" colspan="1"><input readonly class="form-control" type="text" id="net"/> </td>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>



                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="float: right;">
                                <table class="table table-bordered sf-table-list">
                                    <thead>
                                    <th class="text-center" colspan="3">Sales Tax Account Head</th>
                                    <th class="text-center" colspan="3">Sales Tax Amount</th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <select onchange="sales_tax(this.id);open_sales_tax(this.id)"
                                            class="form-control select2" id="sales_taxx" name="sales_taxx">
                                            <option value="0">Select Sales Tax</option>

                                            @foreach (ReuseableCode::get_all_sales_tax() as $row)
                                                <option
                                                    value="{{ $row->percent }}">{{ $row->percent }}</option>
                                            @endforeach
                                        </select>
                                        </td>
                                        <td class="text-right"  colspan="3">
                                            <input onkeyup="tax_by_amount(this.id)" type="text"
                                                        class="form-control" name="sales_amount_td"
                                                        id="sales_amount_td" />
                                        </td>
                                        <input type="hidden" name="sales_amount" id="sales_tax_amount"/>
                                    </tr>


                                    </tbody>

                                    <tbody>
                                    <tr  style="background-color: darkgrey;font-size:large;font-weight: bold">
                                        <td class="text-center" colspan="3">Total Amount After Tax</td>
                                        <td id="" class="text-right" colspan="3"><input readonly class="form-control" type="text" id="net_after_tax"/> </td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <table>
                            <tr>

                                <td style="text-transform: capitalize;" id="rupees"></td>
                                <input type="hidden" value="" name="rupeess" id="rupeess1"/>
                            </tr>
                        </table>
                        <input type="hidden" id="d_t_amount_1"/>

                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                <button type="reset" id="reset" class="btn btn-primary">Clear Form</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <?php echo Form::close();?>
                <?php endif;?>
            </div>

        </div>
    </div>
    </div>
    <script>

        var Counter = 1;

        function AddMoreDetails()
        {
            Counter++;
            $('#AppnedHtml').append('<tr id="RemoveRows'+Counter+'" class="AutoNo">' +
                    '<td class="AutoCounter" title="'+AutoCount+'">' +
                        '<select class="form-control select2" name="item_id[]" onchange="itemChange('+Counter+')" id="sub_'+Counter+'">'+
                        '<option value="0">Select Item</option>'+
                        '@foreach (App\Models\Subitem::all() as $item)'+
                        '<option value="{{ $item->id }}" data-id="{{ $item->id }}" data-uom="{{$item->uomData->uom_name}}">'+
                        '{{ $item->sku_code. " - " . $item->sub_ic }}' + '{{ $item->pack_size ? "-".$item->pack_size : "" }}' +
                        '</option>'+
                        '@endforeach'+
                        '</select>'+
                        '<textarea name="item_remark[]" id="item_remark'+Counter+'" class="form-control" style="margin-top: 8px" rows="5" placeholder="Item Remarks"></textarea>'+
                    '<input type="hidden" class="form-control sam_jass" name="sub_ic_des[]" id="item_'+Counter+'" placeholder="ITEM">' +
                    
                    '</td>' +
                    '<td>' +
                    '<input readonly type="text" class="form-control" name="uom_id[]" id="uom_id'+Counter+'" >' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" onkeyup="claculation('+Counter+')" class="form-control requiredField ActualQty" name="actual_qty[]" id="actual_qty'+Counter+'" placeholder="ACTUAL QTY">' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" onkeyup="claculation('+Counter+')" class="form-control requiredField ActualRate" name="rate[]" id="rate'+Counter+'" placeholder="RATE">' +
                    '</td>' +
                    '<td>' +
                    '<input readonly type="text" class="form-control" name="amount[]" id="amount'+Counter+'" placeholder="AMOUNT">' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" onkeyup="discount_percent(this.id)" class="form-control requiredField" value="0" name="discount_percent[]" id="discount_percent'+Counter+'" placeholder="DISCOUNT">' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" onkeyup="discount_amount(this.id)" class="form-control requiredField" value="0" name="discount_amount[]" id="discount_amount'+Counter+'" placeholder="DISCOUNT">' +
                    '</td>' +
                    '<td>' +
                    '<input readonly type="text" class="form-control net_amount_dis" name="after_dis_amount[]" id="after_dis_amount'+Counter+'" placeholder="NET AMOUNT">' +
                    '</td>' +
                    '<td class="text-center">' +
                    '<input onclick="view_history('+Counter+')" type="checkbox" id="view_history'+Counter+'">&nbsp;'+
                    '<button type="button" class="btn btn-sm btn-danger" id="BtnRemove'+Counter+'" onclick="RemoveSection('+Counter+')"> - </button>' +
                    '</td>' +
                    '</tr>');

            var AutoNo = $(".AutoNo").length;
            $('#span').text(AutoNo);
            $('.select2').select2();

            var AutoCount=1;;
            $(".AutoCounter").each(function(){
                AutoCount++;
                $(this).prop('title', AutoCount);

            });
            $('.sam_jass').bind("enterKey",function(e){


                $('#items').modal('show');


            });
            $('.sam_jass').keyup(function(e){
                if(e.keyCode == 13)
                {
                    selected_id=this.id;
                    $(this).trigger("enterKey");


                }

            });


        }
        function RemoveSection(Row) {
//            alert(Row);
            $('#RemoveRows' + Row).remove();
         //   $(".AutoCounter").html('');
            var AutoCount = 1;
            var AutoCount=1;;
            $(".AutoCounter").each(function() {
                AutoCount++;
                $(this).prop('title', AutoCount);
            });
            var AutoNo = $(".AutoNo").length;
            $('#span').text(AutoNo);
        }

        // function get_po(id)
        // {
        //     var number=$('#'+id).val();

        //     var po=$('#po_no').val();
        //     if (number==1)
        //     {
        //         var res = po.slice(2, 9);
        //         var pl_no='PL'+res;
        //         $('#po_no').val(pl_no);

        //     }
        //     if (number==2)
        //     {
        //         var res = po.slice(2, 9);
        //         var pl_no='PS'+res;
        //         $('#po_no').val(pl_no);

        //     }
        //     if (number==3)
        //     {
        //         var res = po.slice(2, 9);
        //         var pl_no='PI'+res;
        //         $('#po_no').val(pl_no);

        //     }

        // }
    </script>
    <script>
        var x=0;


        $('.sam_jass').bind("enterKey",function(e){


            $('#items').modal('show');


        });
        $('.sam_jass').keyup(function(e){
            if(e.keyCode == 13)
            {
                selected_id=this.id;
                $(this).trigger("enterKey");


            }

        });


        $('.stop').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        function tax_by_amount(id)
        {


            var tax_percentage=$('#sales_taxx').val();



            if (tax_percentage==0)
            {

                $('#'+id).val(0);
            }
            else
            {
                var tax_amount=parseFloat($('#'+id).val());

                // highlight end

                if (isNaN(tax_amount)==true)
                {
                    tax_amount=0;
                }
                var count=1;
                var amount = 0;
                $('.net_amount_dis').each(function () {


                    amount += +$('#after_dis_amountt_' + count).val();
                    count++;
                });
                var total=parseFloat(tax_amount+amount).toFixed(2);
                $('#d_t_amount_1').val(total);


            }
//            toWords(1);



        }

            function net_amount()
            {
                var amount=0;
                $('.net_amount_dis').each(function (i, obj) {

                    amount += +$('#'+obj.id).val();


                });
                amount=parseFloat(amount);
                $('#net').val(amount);
                 var sales_tax  = parseFloat($('#sales_amount_td').val());

                $('#net_after_tax').val(amount+sales_tax);
                $('#d_t_amount_1').val(amount+sales_tax);
                toWords(1);

            }



        function view_history(id)
        {

            var v= $('#sub_'+id).val();


            if ($('#view_history' + id).is(":checked"))
            {
                if (v!=null)
                {
                    showDetailModelOneParamerter('pdc/viewHistoryOfItem_directPo?id='+v);
                }
                else
                {
                    alert('Select Item');
                }

            }





        }





        $(document).ready(function() {

            for(i=1; i<=counter; i++)
            {
                $('#amount_'+i).number(true,2);
                //   $('#rate_'+i).number(true,2);
                $('#purchase_approve_qty_'+i).number(true,2);
          

                $('#after_dis_amountt'+i).number(true,2);
                $('#rate_'+i).number(true,2);
            }

            $('#d_t_amount_1').number(true,2);
            $('#sales_amount_td').number(true,2);

            $(".btn-success").click(function(e){
                //alert();
                var purchaseRequest = new Array();
                var val;
                //$("input[name='demandsSection[]']").each(function(){
                purchaseRequest.push($(this).val());
                //});
                var _token = $("input[name='_token']").val();
                for (val of purchaseRequest) {
                    jqueryValidationCustom();
                    if(validate == 0){
                        //alert(response);
                        vala = 0;
                        var flag = false;
                        $('.ActualQty').each(function(){
                            vala = parseFloat($(this).val());
                            if(vala == 0)
                            {
                                alert('Please Enter Correct Actual Qty....!');
                                $(this).css('border-color','red');
                                flag = true;
                                return false;
                            }
                            else{
                                $(this).css('border-color','#ccc');
                            }
                        });

                        $('.ActualRate').each(function(){
                            vala = parseFloat($(this).val());
                            if(vala == 0)
                            {
                                alert('Please Enter Correct Rate Qty....!');
                                $(this).css('border-color','red');
                                flag = true;
                                return false;
                            }
                            else{
                                $(this).css('border-color','#ccc');
                            }
                        });
                        if(flag == true)
                        {return false;}
                    }else{
                        return false;
                    }
                }

            });


            $(document).keypress("m",function(e) {
                if(e.ctrlKey)
                    AddMoreDetails();
            });

        });
        function removeSeletedPurchaseRequestRows(id,counter){
            var totalCounter = $('#totalCounter').val();
            if(totalCounter == 1){
                alert('Last Row Not Deleted');
            }else{
                var lessCounter = totalCounter - 1;
                var totalCounter = $('#totalCounter').val(lessCounter);
                var elem = document.getElementById('removeSelectedPurchaseRequestRow_'+counter+'');
                elem.parentNode.removeChild(elem);
            }

        }

        $(document).ready(function() {
//            toWords(1);
        });


        function claculation(number)
        {
            var  qty=$('#actual_qty'+number).val();
            var  rate=$('#rate'+number).val();

            var total=parseFloat(qty*rate).toFixed(2);

            $('#amount'+number).val(total);

            var amount = 0;
            count=1;
            $('.net_amount_dis').each(function (i, obj) {

                amount += +$('#'+obj.id).val();

                count++;
            });
            amount=parseFloat(amount);


            sales_tax('sales_taxx');
            discount_percent('discount_percent'+number);
            net_amount();
          //  toWords(1);
        }
        function sales_tax(id)
        {

            var sales_tax_per_value = $('#'+id).val();
            if (sales_tax_per_value!=0)
            {
                var sales_tax_per = $('#' + id + ' :selected').text();
                // alert(sales_tax_per);
                // return;
                // sales_tax_per = sales_tax_per.split('(');
                // sales_tax_per = sales_tax_per[1];
                // sales_tax_per = sales_tax_per.replace('%)', '');

            }

            else
            {
                sales_tax_per=0;
            }

            count=1;
            var amount = 0;
            $('.net_amount_dis').each(function () {


                amount += +$(this).val();
                count++;
            });


            var x = parseFloat(sales_tax_per * amount);
            var s_tax_amount =parseFloat( x / 100).toFixed(2);

            $('#sales_tax_amount').val(s_tax_amount);
            $('#sales_amount_td').val(s_tax_amount);

            var amount = 0;
            count=1;
            $('.net_amount_dis').each(function () {


                amount += +$('#after_dis_amountt_' + count).val();
                count++;
            });
            amount=parseFloat(amount);
            s_tax_amount=parseFloat(s_tax_amount);
            var total_amount=(amount+s_tax_amount).toFixed(2);
            $('.td_amount').text(total_amount);
            $('#d_t_amount_1').val(total_amount);
            net_amount();
         //   toWords(1);



        }


        function get_address()
        {
            var supplier= $('#supplier_id').val();

            supplier=  supplier.split('@#');
            $('#addresss').val(supplier[1]);

            $('#ntn_id').val(supplier[2]);
            $('#model_terms_of_payment').val(supplier[3]);
            calculate_due_date();
        }


        function get_rate()
        {
            var currency_id= $('#curren').val();
            currency_id=currency_id.split(',');
            $('#curren_rate').val(currency_id[1]);
        }
    </script>
    <script>
         function itemChange(id){
            $('#item_'+id).val($('#sub_'+id).find(':selected').data('id'));
            $('#uom_id'+id).val($('#sub_'+id).find(':selected').data('uom'));
        }
        function open_sales_tax(id)
        {

            var dept_name = $('#' + id + ' :selected').text();


            if (dept_name=='Add New')
            {

                showDetailModelOneParamerter('fdc/createAccountFormAjax/sales_taxx')
            }

        }



        function discount_percent(id)
        {
            var  number= id.replace("discount_percent","");
            var amount = $('#amount' + number).val();

            var x = parseFloat($('#'+id).val());

            if (x >100)
            {
                alert('Percentage Cannot Exceed by 100');
                $('#'+id).val(0);
                x=0;
            }

            x=x*amount;
            var discount_amount =parseFloat( x / 100).toFixed(2);
            $('#discount_amount'+number).val(discount_amount);
            var discount_amount=$('#discount_amount'+number).val();

            if (isNaN(discount_amount))
            {

                $('#discount_amount'+number).val(0);
                discount_amount=0;
            }



            var amount_after_discount=amount-discount_amount;

            $('#after_dis_amount'+number).val(amount_after_discount);
            var amount_after_discount=$('#after_dis_amount'+number).val();

            if (amount_after_discount==0)
            {
                $('#after_dis_amount'+number).val(amount);
                $('#net_amounttd_'+number).val(amount);
                $('#net_amount'+number).val(amount_after_discount);
            }

            else
            {

                $('#net_amounttd_'+number).val(amount_after_discount);
                $('#after_dis_amount'+number).val(amount_after_discount);
            }

            $('#cost_center_dept_amount'+number).text(amount_after_discount);
            $('#cost_center_dept_hidden_amount'+number).val(amount_after_discount);


            sales_tax('sales_taxx');
            net_amount();
          //  toWords(1);


        }


        function discount_amount(id)
        {
            var  number= id.replace("discount_amount","");
            var amount=parseFloat($('#amount'+number).val());

            var discount_amount=parseFloat($('#'+id).val());

            if (discount_amount > amount)
            {
                alert('Amount Cannot Exceed by '+amount);
                $('#discount_amount'+number).val(0);
                discount_amount=0;
            }

            if (isNaN(discount_amount))
            {

                $('#discount_amount'+number).val(0);
                discount_amount=0;
            }

            var percent=(discount_amount / amount *100).toFixed(2);
            $('#discount_percent'+number).val(percent);
            var amount_after_discount=amount-discount_amount;
            $('#after_dis_amount'+number).val(amount_after_discount);


              $('#net_amounttd_'+number).val(amount_after_discount);
               $('#net_amount_'+number).val(amount_after_discount);
           sales_tax('sales_taxx');
         //   toWords(1);
            net_amount();


        }


        function get_detail(id,number)
        {
            var item=$('#'+id).val();


            $.ajax({
                url:'{{url('/pdc/get_data')}}',
                data:{item:item},
                type:'GET',
                success:function(response)
                {

                    var data=response.split(',');
                    $('#uom_id'+number).val(data[0]);


                }
            })



        }
        $(".remove").each(function(){

            $(this).html($(this).html().replace(/,/g , ''));
        });

        function calculate_due_date()
        {

//            var days=parseFloat($('#model_terms_of_payment').val());
//
//            var tt = document.getElementById('po_date').value;
//
//
//            var date = new Date(tt);
//            var newdate = new Date(date);
//            newdate.setDate(newdate.getDate() + days);
//            var dd = newdate.getDate();
//
//
//            var dd = ("0" + (newdate.getDate() + 1)).slice(-2);
//
//            var mm = ("0" + (newdate.getMonth() + 1)).slice(-2);
//            var y = newdate.getFullYear();
//            var someFormattedDate =  + y+'-'+ mm +'-'+dd;
//
//            document.getElementById('due_date').value = someFormattedDate;

            var date = new Date($("#po_date").val());
            var days=parseFloat($('#model_terms_of_payment').val());
             days = days;

            if(!isNaN(date.getTime()))
            {
                date.setDate(date.getDate() + days);


                var yyyy = date.getFullYear().toString();
                var mm = (date.getMonth()+1).toString(); // getMonth() is zero-based
                var dd  = date.getDate().toString();
                var new_d= yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]);


             $("#due_date").val(new_d);
            } else
            {
                alert("Invalid Date");
            }


        }
    </script>




    <script type="text/javascript">

        $('.select2').select2();
    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>


@endsection
