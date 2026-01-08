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
                                <span class="subHeadingLabelClass">Create Bill Of Lading</span>
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
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <label>Commercial invoice No</label>
                                <input type="text" name="contract" id="commercial" class="form-control" placeholder="Commercial invoice "  />
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <label>Packing List No</label>
                                <input type="text" name="packing_list_no" id="packing_list_no" class="form-control" placeholder="Packing List No"  />
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
                                            <th class="text-center col-sm-1">Commercial Invoice No</th>
                                            <th class="text-center col-sm-1">Packing List NO</th>
                                            <th class="text-center col-sm-1">Packing List Date </th>
                                            <th class="text-center col-sm-1">Action</th>
                                        
                                           </thead>
                                            <tbody id="data">
                                            </tbody>
                                            <thead>
                                                <tr>
                                                    <td class="text-center" colspan="5" style="background-color: darkgrey;font-size: 20px;">Total</td>
                                                   
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
            viewRangeWiseDataFilter();
        });
        
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


      



        function viewRangeWiseDataFilter()
        {

            var commercial= $('#commercial').val();
            var packing_list_no=$('#packing_list_no').val();

            var m ='<?php echo $m?>';
            var html ='';
            // $('#data').html('<tr><td colspan="13"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="loader"></div></div></div></td><tr>');
                var base_url='<?php echo URL::to('/'); ?>';
            $.ajax({
                url: base_url+'/export/packagingListForCreateBillOfLadingAjax',
                type: 'Get',
                data: {commercial:commercial,m:m,packing_list_no:packing_list_no},

                success: function (response) {
                    $('#data').empty();
                 $('#data').append(response);
                }
            });


        }
    </script>

@endsection