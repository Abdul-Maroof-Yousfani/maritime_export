<?php

$m = Session::get('run_company');

// $parentCode = $_GET['parentCode'];

use App\Helpers\CommonHelper;
use App\Helpers\SalesHelper;
use App\Helpers\ReuseableCode;

$currentMonthStartDate = date('Y-m-01');
$currentMonthEndDate   = date('Y-m-t');

$export=ReuseableCode::check_rights(438);

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
                                <span class="subHeadingLabelClass">View Export Order List</span>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                                <?php echo CommonHelper::displayPrintButtonInBlade('PrintEmpExitInterviewList','','1');?>
                                @if($export == true)
                                    <a id="dlink" style="display:none;"></a>
                                    <button type="button" class="btn btn-warning" onclick="ExportToExcel('xlsx')">Export <b>(xlsx)</b></button>
                                @endif
                            </div>
                        </div>
                    </div>	
                    <hr style="border-color: #ccc">
                    <div class="row">
                        <span id="ShowHideDate" style="display: none">
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label>From Date</label>
                                    <input type="Date" name="from" id="from"  value="<?php echo $currentMonthStartDate;?>" class="form-control" min="<?php echo $AccYearFrom?>" max="<?php echo $AccYearTo?>"/>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label>To Date</label>
                                    <input type="Date" name="to" id="to" max="<?php echo $AccYearTo?>" value="<?php echo $currentMonthEndDate?>" class="form-control" min="<?php echo $AccYearFrom?>"  />
                                </div>

                                <div style="margin-top: 40px" class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label class="radio-inline"><input value="1" type="radio" name="optradio">Open</label>
                                <label class="radio-inline"><input value="2" type="radio" name="optradio">Partial</label>
                                <label class="radio-inline"><input value="3" type="radio" name="optradio">Complete</label>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-right">
                                    <input type="button" value="View Filter Data" class="btn btn-sm btn-danger" onclick="viewRangeWiseDataFilter();" style="margin-top: 32px;" />
                                </div>
                            </div>
                        </span>
                        <span id="ShowHideSoNo">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <label>Eo No</label>
                                <input type="text" name="EoNo" id="EoNo" class="form-control" placeholder="EO NO"  />
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <label>Contract No</label>
                                <input type="text" name="contract" id="contract" class="form-control" placeholder="contract no"  />
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
                                            <th class="text-center col-sm-1">EO No</th>
                                            <th class="text-center col-sm-1">Contract No</th>
                                            <th class="text-center col-sm-1">EO Date</th>
                                            <th class="text-center col-sm-1">Status</th>
                                            <th class="text-center col-sm-1">Mode / Terms Of Payment</th>
                                            <th class="text-center col-sm-1">Customer</th>
                                            <th class="text-center col-sm-1">Action</th>
                                        
                                           </thead>
                                            <tbody id="data">
                                            </tbody>
                                            <thead>
                                                <tr>
                                                    <td class="text-center" colspan="7" style="background-color: darkgrey;font-size: 20px;">Total</td>
                                                    <td class="text-center" colspan="1" style="background-color: darkgrey;font-size: 20px;"></td>
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
        function sale_order_delete(id,m)
        {
            if (confirm('Are you sure you want to delete this request')) {
                var base_url='<?php echo URL::to('/'); ?>';
                $.ajax({
                    url: base_url+'/export/deleteSalesOrder',
                    type: 'GET',
                    data: {id: id, m:m},
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

            if (confirm('Are you sure you want to Approved this Export order')) {
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
                            viewRangeWiseDataFilter();
                        }
                       


                    }
                });
            }
        }


        function viewRangeWiseDataFilter()
        {

            var from= $('#from').val();
            var to= $('#to').val();
            var EoNo= $('#EoNo').val();
            var BuyerId= $('#BuyerId').val();
            var radio= $('input[name="optradio"]:checked').val();

            var contract=$('#contract').val();

            var m ='<?php echo $m?>';
            var html ='';
            // $('#data').html('<tr><td colspan="13"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="loader"></div></div></div></td><tr>');
                var base_url='<?php echo URL::to('/'); ?>';
            $.ajax({
                url: base_url+'/export/getSalesOrderfilter',
                type: 'Get',
                data: {from: from,to:to,m:m,EoNo:EoNo,contract:contract,BuyerId:BuyerId,radio:radio},
                success: function (response) {
                    $('#data').empty();
                 $('#data').append(response);
                }
            });


        }

        function openReceiveAdvanceModal(saleOrderId) {
            var base_url='<?php echo URL::to('/'); ?>';
            $.ajax({
                url: base_url+'/export/getSaleOrderForAdvance',
                type: 'GET',
                data: {id: saleOrderId},
                success: function (response) {
                    $('#receiveAdvanceModalBody').html(response);
                    $('#receiveAdvanceModal').modal('show');
                },
                error: function() {
                    alert('Error loading sale order details');
                }
            });
        }

        function submitAdvancePayment() {
            var form = $('#advancePaymentForm');
            if (!form[0].checkValidity()) {
                form[0].reportValidity();
                return;
            }

            var formData = form.serialize();
            var base_url='<?php echo URL::to('/'); ?>';
            
            $.ajax({
                url: base_url+'/export/receiveAdvancePayment',
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        alert('Advance payment received successfully');
                        $('#receiveAdvanceModal').modal('hide');
                        viewRangeWiseDataFilter();
                    } else {
                        alert('Error: ' + (response.message || 'Failed to receive advance payment'));
                    }
                },
                error: function(xhr) {
                    var errorMsg = 'Error receiving advance payment';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    alert(errorMsg);
                }
            });
        }
    </script>

    <!-- Receive Advance Payment Modal -->
    <div class="modal fade" id="receiveAdvanceModal" tabindex="-1" role="dialog" aria-labelledby="receiveAdvanceModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="receiveAdvanceModalLabel">Receive Advance Payment</h4>
                </div>
                <div class="modal-body" id="receiveAdvanceModalBody">
                    <div class="text-center">
                        <div class="loader"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection