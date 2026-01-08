<?php

$m = Session::get('run_company');

// $parentCode = $_GET['parentCode'];

use App\Helpers\CommonHelper;
use App\Helpers\SalesHelper;
use App\Helpers\ReuseableCode;

$currentMonthStartDate = date('Y-m-01');
$currentMonthEndDate   = date('Y-m-t');

$export=ReuseableCode::check_rights(231);


$view=ReuseableCode::check_rights(104);
$edit=ReuseableCode::check_rights(105);
$delete=ReuseableCode::check_rights(106);
$AccYearDate = DB::table('company')->select('accyearfrom','accyearto')->where('id',$m)->first();
$AccYearFrom = $AccYearDate->accyearfrom;
$AccYearTo = $AccYearDate->accyearto;

?>
@extends('layouts.default')
@section('content')
    @include('select2')

    <?php
    $data=DB::Connection('mysql2')->select('select username,COUNT(username)countt from sales_order where status=1 GROUP by username order by countt desc');

    ?>
    <div class="lineHeight">&nbsp;</div>
    <div class="row container-fluid">

        <?php  foreach($data as $row): ?>
        {{--<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center" style="border: solid 1px #ccc">--}}
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center" style="border: solid 1px #ccc">
            <p>{{strtoupper($row->username)}} <span class="badge badge-primary">&nbsp;{{' '.$row->countt}}</span></p>
        </div>
        <?php endforeach;?>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well_N">
                <div class="dp_sdw">    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <span class="subHeadingLabelClass">View Proforma  List</span>
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
                    
                            <span id="ShowHideSoNo">
                                {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <label>Eo No</label>
                                    <input type="text" name="EoNo" id="EoNo" class="form-control" placeholder="EO NO"  />
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <label>Contract No</label>
                                    <input type="text" name="contract" id="contract" class="form-control" placeholder="contract no"  />
                                </div> --}}
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <label>Proforma No</label>
                                    <input type="text" name="proforma" id="proforma" class="form-control" placeholder="Proforma no"  />
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 ">
                                    <input type="button" value="View Filter Data" class="btn btn-sm btn-danger" onclick="viewRangeWiseDataFilter();" style="margin-top: 32px;" />
                                </div>
                            </span>
                



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
                                            <th class="text-center col-sm-1">Proforma No</th>
                                            <th class="text-center col-sm-1">Commercial Invoice No</th>
                                            <th class="text-center col-sm-1">Advance Voucehr</th>
                                            <th class="text-center col-sm-1">Addvance Received</th>
                                            <th class="text-center col-sm-1">Received Concillation</th>
                                            <th class="text-center col-sm-1">Invoice Amount</th>
                                            <th class="text-center col-sm-1">Proforma Date</th>

                                            <th class="text-center col-sm-1"></th>
                                          
                                        
                                           </thead>
                                            <tbody id="data">
                                            </tbody>
                                            <thead>
                                                <tr>
                                                    <td class="text-center" colspan="8" style="background-color: darkgrey;font-size: 20px;">Total</td>
                                                   <td style="background-color: darkgrey;font-size: 20px;"></td>
                                                </tr>
                                            </thead>
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
                    XLSX.writeFile(wb, fn || ('Sales Order <?php echo date('Y-m-d')?>.' + (type || 'xlsx')));
        }
    </script>
    <script>

        $(document).ready(function(){
            $('#BuyerId').select2();
            $('.select2-container--default').css('width','100%');
            viewRangeWiseDataFilter();
        });
        function RadioChange()
        {
         //   var radioValue = $("input[name='FilterType']:checked").val();
              var   radioValue=$('#filters').val();



            if(radioValue == 1)
            {
                $('#ShowHideDate').fadeIn('slow');
                $('#ShowHideSoNo').css('display','none');
                $('#ShowHideBuyer').css('display','none');
                $("input:radio").removeAttr("checked");
            }
            else if(radioValue == 2)
            {
                $('#ShowHideSoNo').fadeIn('slow');
                $('#ShowHideDate').css('display','none');
                $('#ShowHideBuyer').css('display','none');
                $("input:radio").removeAttr("checked");
            }
            else if(radioValue == 3)
            {
                $('#ShowHideBuyer').fadeIn('slow');
                $('#ShowHideSoNo').css('display','none');
                $('#ShowHideDate').css('display','none');
                $("input:radio").removeAttr("checked");
            }
            else if (radioValue == 0)
            {

                $('#ShowHideDate').css('display','none');
                $('#ShowHideSoNo').css('display','none');
                $('#ShowHideBuyer').css('display','none');
                $("input:radio").removeAttr("checked");
            }
        }
        function sale_order_delete(id)
        {
            if (confirm('Are you sure you want to delete this request')) {
                var base_url='<?php echo URL::to('/'); ?>';
                $.ajax({
                    url: base_url+'/export/proformaDelete',
                    type: 'GET',
                    data: {id: id},
                    success: function (response) {

                        if (response=='0')
                        {
                            alert('Can not Deleted')
                        }

                        else {
                            alert('Deleted');
                            $('#' + id).remove();
                        }



                    }
                });
            }
            else{}
        }


        function delete_record(id)
        {

            if (confirm('Are you sure you want to delete this request')) {
                $.ajax({
                    url: '/pdc/deletepurchasevoucher',
                    type: 'Get',
                    data: {id: id},

                    success: function (response) {


                    }
                });
            }
            else{}
        }

        function approved_record(id,m)
        {

            if (confirm('Are you sure you want to Approved this Sale order')) {
                var base_url='<?php echo URL::to('/'); ?>';
                $.ajax({
                    url: base_url+'/export/updateApprovedStatus',
                    type: 'GET',
                    data: {id: id, m:m},
                    success: function (response) {
                        if (response=='0')
                        {
                            alert('Can not Approved')
                        }

                        else {
                            alert('Updated');
                           
                        }
                       


                    }
                });
            }
        }


        function viewRangeWiseDataFilter()
        {

           
            var Eono= $('#EoNo').val();
            var contract= $('#contract').val();
            var proforma=$('#proforma').val();

            var m ='<?php echo $m?>';
            
            // $('#data').html('<tr><td colspan="13"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="loader"></div></div></div></td><tr>');
                var base_url='<?php echo URL::to('/'); ?>';
            $.ajax({
                url: base_url+'/export/advanceReconciliationAjax',
                type: 'Get',
                data: {Eono: Eono,contract:contract,m:m,proforma:proforma},

                success: function (response) {
                $('#data').empty();
              
                var row1 ='<tr><td class="text-left" style="background-color: darkgrey;color:white;" colspan="9"> <h5>Advance Payment Received </h5></td></tr>';
                 
                $.each(response.export_advance,function(key,value){
                    row1 +=`<tr> <td>${key} </td><td>${value.proforma_no}</td><td> - </td><td>${value.advance_voucher_no}</td> <td>${value.received_amount}</td><td>-</td><td>-</td><td>${value.created_at}</td><td></td></tr>`;
                });
                   $('#data').append(row1);
                   var row2 ='<tr><td class="text-left" style="background-color: darkgrey;color:white;" colspan="9"> <h5>Advance Payment Concillation On Invoice </h5></td></tr>';
             
                $.each(response.export_advance_concillation,function(key,value){
                    row2 +=`<tr> <td>${key} </td><td>${value.proforma_no}</td><td> ${value.invoice_no} </td><td>-</td> <td>-</td><td>${value.received_amount}</td><td>-</td><td>${value.created_at}</td><td></td></tr>`;
                });
                $('#data').append(row2);

                var row3 ='<tr><td class="text-left" style="background-color: darkgrey;color:white;" colspan="9"> <h5>Advance Payment Received </h5></td></tr>';
             
                $.each(response.export_invoice_amount,function(key,value){
                    row3 +=`<tr> <td>${key} </td><td>${value.proforma_no}</td><td> ${value.invoice_no} </td><td>-</td> <td>-</td><td>-</td><td>${value.received_amount}</td><td>${value.created_at}</td><td></td></tr>`;
                });
                $('#data').append(row3);
            
                }
            });


        }
    </script>

@endsection