<?php
$accType = Auth::user()->acc_type;
if($accType == 'client'){
    $m = $_GET['m'];
}else{
    $m = Auth::user()->company_id;
}
$parentCode = $_GET['parentCode'];

use App\Helpers\CommonHelper;
use App\Helpers\SalesHelper;
use App\Helpers\ReuseableCode;

$currentMonthStartDate = date('Y-m-01');
$currentMonthEndDate   = date('Y-m-t');

$view=ReuseableCode::check_rights(118);
$edit=ReuseableCode::check_rights(119);
$delete=ReuseableCode::check_rights(120);
$export=ReuseableCode::check_rights(257);


?>
@extends('layouts.default')
@section('content')
    @include('select2')
    <style>
        .table-bordered{
            border: 1px solid black;
        }
        table.table-bordered > thead > tr > th{
            border:1px solid black !important;
        }
        table.table-bordered > tbody > tr > td{
            border:1px solid black !important;
        }
    </style>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well_N">
                <div class="dp_sdw">    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <span class="subHeadingLabelClass">View Sales Tax Invoice List</span>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                                <?php echo CommonHelper::displayPrintButtonInBlade('PrintEmpExitInterviewList','','1');?>
                                    <?php if($export == true):?>
                                    <a id="dlink" style="display:none;"></a>
                                    <button type="button" class="btn btn-warning" onclick="ExportToExcel('xlsx')">Export <b>(xlsx)</b></button>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>

                    <hr style="border-color: #ccc">

                    <div class="row">

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Filters</label>
                            <select id="filters" onchange="FilterSelection()" class="form-control">
                                <option value="0">Select</option>
                                <option value="1">Search By Date</option>
                                <option value="2">Search By Voucher No</option>
                                <option value="3">Search By Buyer</option>
                            </select>
                        </div>

                        {{--<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">--}}
                            {{--<label style="border: solid 1px; border-radius: 10px;">(Search by Date) <input type="radio" class="form-control" name="SelectType" value="1" onclick="FilterSelection()"></label>--}}
                            {{--<label for="">OR</label>--}}
                            {{--<label style="border: solid 1px; border-radius: 10px;">(Search By Voucher No) <input type="radio" class="form-control" name="SelectType" value="2" onclick="FilterSelection()"></label>--}}
                            {{--<label for="">OR</label>--}}
                            {{--<label style="border: solid 1px; border-radius: 10px;">(Search By Buyer) <input type="radio" class="form-control" name="SelectType" value="3" onclick="FilterSelection()"></label>--}}
                        {{--</div>--}}
                        <span id="ShowHideDate" style="display: none">
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label>From Date</label>
                                    <input type="Date" name="from" id="from"  value="<?php echo $currentMonthStartDate;?>" class="form-control" />
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label>To Date</label>
                                    <input type="Date" name="to" id="to" max="<?php ?>" value="<?php echo $currentMonthEndDate;?>" class="form-control" />
                                </div>
                                <div style="margin-top: 40px" class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label class="radio-inline"><input value="1" type="radio" name="optradio">Open</label>
                                    <label class="radio-inline"><input value="2" type="radio" name="optradio">Partial</label>
                                    <label class="radio-inline"><input value="3" type="radio" name="optradio">Complete</label>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <input type="button" value="View Filter Data" class="btn btn-sm btn-danger" onclick="viewRangeWiseDataFilter();" style="margin-top: 32px;" />
                                </div>
                            </div>

                        </span>
                        <span id="ShowHideSoNo" style="display: none">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <label>(SO NO) <input type="radio" class="form-control" name="FilterType" value="1" onclick="RadioChange()"></label>
                                <label for=""> OR </label>
                                <label>(SI NO) <input type="radio" class="form-control" name="FilterType" value="2" onclick="RadioChange()"></label>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <label for="">Search By <span id="ChangeType"></span></label>
                                <input type="text" class="form-control" id="SearchText" name="SearchText" disabled>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <button type="button" class="btn btn-xs btn-primary" style="margin-top: 32px;" id="BtnReset" onclick="ResetFields()">Reset</button>
                                <input type="button" value="View Filter Data" class="btn btn-sm btn-danger" onclick="viewRangeWiseDataFilter();" style="margin-top: 32px;" />
                            </div>
                        </span>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" id="ShowHideBuyer" style="display: none">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Buyer</label>
                                <select name="BuyerId" id="BuyerId" class="form-control">
                                    <option value="">Select Buyer</option>
                                    <?php foreach($Customer as $Fil):?>
                                    <option value="<?php echo $Fil->id?>"><?php echo $Fil->name?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div style="margin-top: 40px" class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label class="radio-inline"><input value="1" type="radio" name="optradio">Open</label>
                                <label class="radio-inline"><input value="2" type="radio" name="optradio">Partial</label>
                                <label class="radio-inline"><input value="3" type="radio" name="optradio">Complete</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 ">
                                <input type="button" value="View Filter Data" class="btn btn-sm btn-danger" onclick="viewRangeWiseDataFilter();" style="margin-top: 32px;" />
                            </div>
                        </div>


                    </div>


                    <div class="lineHeight">&nbsp;</div>
                    <div class="panel">
                        <div class="panel-body" id="PrintEmpExitInterviewList">
                            <?php echo CommonHelper::headerPrintSectionInPrintView($m);?>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered sf-table-list" id="EmpExitInterviewList">
                                            <thead>
                                            <th class="text-center col-sm-1">S.No</th>
                                            <th class="text-center col-sm-1">SO No</th>
                                            <th class="text-center col-sm-1">SI No</th>
                                            <th class="text-center col-sm-1">ST No</th>
                                            <th class="text-center col-sm-1">Buyer's Unit</th>
                                            <th class="text-center col-sm-1">Order No</th>
                                            <th class="text-center col-sm-1">SI Date</th>
                                            <th class="text-center col-sm-1">Model Terms Of Payment</th>
                                            <th class="text-center col-sm-1">Order Date</th>
                                            <th class="text-center">Customer</th>
                                            <th class="text-center">Total Amount</th>
                                            <th class="text-center">SI Status</th>
                                            <th class="text-center">Status</th>

                                            <th class="text-center">Action</th>

                                            {{--<th class="text-center">Delete</th>--}}
                                            </thead>
                                            <tbody id="data">
                                            <?php $counter = 1;$total=0;
                                            $open=0;
                                            $parttial=0;
                                            $complete=0;

                                            ?>

                                            @foreach($sales_tax_invoice as $row)
                                                <?php
                                                $data=SalesHelper::get_total_amount_for_sales_tax_invoice_by_id($row->id);
                                                $fright=SalesHelper::get_freight($row->id);

                                                 $amount=$data->amount+$row->sales_tax+$fright;

                                                $received_amount=SalesHelper::get_received_amount($row->id);
                                                $main_amount=$amount;
                                                $diffrence= $main_amount-$received_amount;

                                                if ($diffrence<0):
                                                $diffrence=0;
                                                endif;



                                                if ($diffrence==$main_amount):
                                                $status='Open';
                                                $open++;
                                                elseif($main_amount!='' && $diffrence!=0):
                                                $status='partial';
                                                $parttial++;
                                                elseif($diffrence==0):
                                                $status='Complete';
                                                $complete++;
                                                endif;


                                                $customer=CommonHelper::byers_name($row->buyers_id);




                                                $BuyersUnit = '';
                                                $BuyerOrderNo = '';
                                                if($row->so_id != 0 ):
                                                $SoData = DB::Connection('mysql2')->table('sales_order')->where('id',$row->so_id)->select('order_no','buyers_unit')->first();
                                                $BuyersUnit = $SoData->buyers_unit;
                                                $BuyerOrderNo = $SoData->order_no;
                                                endif;
                                                ?>
                                                <tr @if($status=='Open') style="background-color: #fdc8c8" @elseif($status=='partial') style="background-color: #c9d6ec" @endif title="{{$row->id}}" id="{{$row->id}}">
                                                    <td class="text-center">{{$counter++}}</td>
                                                    <td title="{{$row->id}}" class="text-center">{{strtoupper($row->so_no)}}</td>
                                                    <td title="{{$row->id}}" class="text-center">{{strtoupper($row->gi_no)}}</td>
                                                    <td>
                                                        <input type="text" id="ScNo<?php echo $row->id?>" class="form-control" value="<?php echo $row->sc_no ?>">
                                                        <button type="button" class=" btn btn-xs btn-success" id="BtnUpdate<?php echo $row->id?>" onclick="UpdateValue('<?php echo $row->id?>')">Update</button>
                                                        <span id="ScNoError<?php echo $row->id?>"></span>
                                                    </td>
                                                    <td class="text-center"><?php echo $BuyersUnit?></td>
                                                    <td class="text-center"><?php echo $BuyerOrderNo?></td>
                                                    <td class="text-center"><?php  echo CommonHelper::changeDateFormat($row->gi_date);?></td>
                                                    <td class="text-center">{{$row['model_terms_of_payment']}}</td>
                                                    <td class="text-center"><?php  echo CommonHelper::changeDateFormat($row->order_date);?></td>
                                                    <td class="text-center">{{$customer->name}}</td>
                                                    <td class="text-right">{{number_format($data->amount+$row->sales_tax+$row->sales_tax_further+$fright,2)}}</td>
                                                    <td>{{$status}}</td>
                                                    <td id="stat{{ $row->id }}" class="text-center"><?php echo SalesHelper::si_status($row->si_status)?></td>
                                                    <?php $total+=$data->amount+$row->sales_tax+$fright; ?>

                                                    <td class="text-center">

                                                        <?php if($view == true):?>
                                                        <button onclick="showDetailModelOneParamerter('sales/viewSalesTaxInvoiceDetail','<?php echo $row->id ?>','View Sales Tax Invoice')"
                                                                type="button" class="btn btn-success btn-xs">View</button>
                                                        <?php endif;?>
                                                        <?php if($edit == true):?>
                                                        {{--<button onclick="sales_tax('< ?php echo $row->id?>','< ?php echo $m ?>')"--}}
                                                                {{--type="button" class="btn btn-primery btn-xs">Edit</button>--}}
                                                            <?php endif;?>
                                                            <?php if($delete == true):?>
                                                        <button onclick="sales_tax_delete('<?php echo $row->id?>','<?php echo $m ?>')"
                                                                type="button" class="btn btn-danger btn-xs">Delete</button>
                                                        <?php endif;?>
                                                            <a target="_blank" class="btn btn-xs btn-info" href="<?php echo url('/')?>/sales/PrintSalesTaxInvoiceDirect?id=<?php echo $row->id?>">Print</a>
                                                    </td>
                                                    {{--<td class="text-center"><a href="{{ URL::asset('purchase/editPurchaseVoucherForm/'.$row->id) }}" class="btn btn-success btn-xs">Edit </a></td>--}}
                                                    {{--<td class="text-center"><button onclick="delete_record('{{$row->id}}')" type="button" class="btn btn-danger btn-xs">DELETE</button></td>--}}
                                                </tr>


                                            @endforeach

                                            <tr>
                                                <td class="text-center" colspan="10" style="background-color: darkgrey;font-size: 20px;">Total</td>
                                                <td class="text-right" colspan="1" style="background-color: darkgrey;font-size: 20px;color: white">{{number_format($total,2)}}</td>
                                                <td class="text-center" colspan="2" style="background-color: darkgrey;font-size: 20px;"></td>

                                            </tr>
                                            <tr>
                                                <td colspan="10"></td>
                                                <td colspan="2" style="font-size: 18px;"><strong>Open</strong></td>
                                                <td style="font-size: 18px;"><strong><?php echo $open?></strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="10"></td>
                                                <td colspan="2" style="font-size: 18px;"><strong>Partial</strong></td>
                                                <td style="font-size: 18px;"><strong><?php echo $parttial?></strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="10"></td>
                                                <td colspan="2" style="font-size: 18px;"><strong>Complete</strong></td>
                                                <td style="font-size: 18px;"><strong><?php echo $complete?></strong></td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ URL::asset('assets/custom/js/exportToExcelXlsx.js') }}"></script>
    <script !src="">
        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('EmpExitInterviewList');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
            return dl ?
                    XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
                    XLSX.writeFile(wb, fn || ('Sales Tax Invoice <?php echo date('Y-m-d')?>.' + (type || 'xlsx')));
        }
    </script>
    <script>

        $(document).ready(function(){
            $('#BuyerId').select2();
            $('.select2-container--default').css('width','100%');
        });

        function UpdateValue(Id)
        {
            var base_url='<?php echo URL::to('/'); ?>';
            var ScNo = $('#ScNo'+Id).val();
            if(ScNo !="")
            {
                $('#ScNoError'+Id).html('');
                $.ajax({
                    url: base_url+'/sdc/updateScNo',
                    type: 'GET',
                    data: {Id: Id,ScNo:ScNo},
                    success: function (response) {
                        alert(response);
                    }
                });
            }
            else
            {
                $('#ScNoError'+Id).html('<p class="text-danger">Enter Sc No</p>');
            }

        }

        function FilterSelection()
        {
            var   radioValue=$('#filters').val();

            if(radioValue == 1)
            {
                $('#ShowHideDate').fadeIn('slow');
                $('#ShowHideSoNo').css('display','none');
                $('#ShowHideBuyer').css('display','none');
            }
            else if(radioValue == 2)
            {
                $('#ShowHideSoNo').fadeIn('slow');
                $('#ShowHideDate').css('display','none');
                $('#ShowHideBuyer').css('display','none');
            }
            else if(radioValue == 3)
            {
                $('#ShowHideBuyer').fadeIn('slow');
                $('#ShowHideSoNo').css('display','none');
                $('#ShowHideDate').css('display','none');
            }
            else
            {
                $('#ShowHideBuyer').css('display','none');
                $('#ShowHideSoNo').css('display','none');
                $('#ShowHideBuyer').css('display','none');
            }
        }

        function sales_tax_delete(id,m)
        {
            if (confirm('Are you sure you want to delete this request')) {
                var base_url='<?php echo URL::to('/'); ?>';
                $.ajax({
                    url: base_url+'/sad/sales_tax_delete',
                    type: 'GET',
                    data: {id: id, m:m},
                    success: function (response) {
                        alert('Deleted');
                       // alert(response);
                        $('#' + id).remove();

                    }
                });
            }
            else{}
        }


        function RadioChange()
        {
            var radioValue = $("input[name='FilterType']:checked").val();

            if(radioValue == 1)
            {
                $('#SearchText').prop('disabled',false);
                $('#ChangeType').html('SO NO');
                $('#SearchText').prop('placeholder','Enter SO NO');
            }
            else if(radioValue == 2)
            {
                $('#SearchText').prop('disabled',false);
                $('#ChangeType').html('SI NO');
                $('#SearchText').prop('placeholder','Enter SI NO');
            }
            else
            {
                $('#ChangeType').html('');
                $('#SearchText').prop('placeholder','');
                $('#SearchText').prop('disabled',true);
            }
        }

        function ResetFields()
        {
            $('input[name="FilterType"]').attr('checked', false);
            $('#ChangeType').html('');
            $('#SearchText').prop('placeholder','');
            $('#SearchText').val('');
            $('#SearchText').prop('disabled',true);
        }

        function viewRangeWiseDataFilter()
        {
            var radioValue = $("input[name='FilterType']:checked").val();
            var FilterType = $('#filters').val();
            var SearchText = $('#SearchText').val();
            var BuyerId = $('#BuyerId').val();
            var from= $('#from').val();
            var to= $('#to').val();
            var m = '<?php echo $m;?>';
            var radio= $('input[name="optradio"]:checked').val();
            $('#data').html('<tr><td colspan="13"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="loader"></div></div></div></td><tr>');

            $.ajax({
                url: '<?php echo url('/') ?>/sdc/getSalesTaxInvoiceeFilterWise',
                type: 'Get',
                data: {from: from,to:to,m:m,radioValue:radioValue,SearchText:SearchText,FilterType:FilterType,BuyerId:BuyerId,radio:radio},

                success: function (response) {

                    $('#data').html(response);


                }
            });

        }

        function sales_tax(sales_order_id,m)
        {
            var base_url='<?php echo URL::to('/'); ?>';
            window.location.href = base_url+'/sales/EditSalesTaxInvoice?sales_order_id='+sales_order_id+'&&'+'m='+m;
        }
    </script>

@endsection
