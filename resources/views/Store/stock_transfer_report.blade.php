<?php

use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
$accType = Auth::user()->acc_type;
if($accType == 'client'){
    $m = $_GET['m'];
}else{
    $m = Auth::user()->company_id;
}
$current_date = date('Y-m-d');
$currentMonthStartDate = date('Y-m-01');
$currentMonthEndDate   = date('Y-m-t');

$view=ReuseableCode::check_rights(42);
$edit=ReuseableCode::check_rights(43);
$delete=ReuseableCode::check_rights(44);
$export=ReuseableCode::check_rights(237);

$AccYearDate = DB::table('company')->select('accyearfrom','accyearto')->where('id',$_GET['m'])->first();
$AccYearFrom = $AccYearDate->accyearfrom;
$AccYearTo = $AccYearDate->accyearto;
?>

@extends('layouts.default')

@section('content')
@include('select2')
    <div class="well_N">
    <div class="dp_sdw">    
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                            <?php if($export == true):?>
                        <?php echo CommonHelper::displayExportButton('issuanceVoucherList','','1')?>
                        <button class="btn btn-primary" onclick="GenratePdf('issuanceVoucherList','Internal Stock Transfer Report')" style="width: 100px">
                            <i class="fas fa-file-pdf"></i> PDF
                        </button>
                        <?php endif;?>
                    </div>
                    <div class="lineHeight">&nbsp;</div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="well">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span class="subHeadingLabelClass">Internal Stock Transfer Report</span>
                                </div>
                            </div>

                            <div class="lineHeight">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label>Location</label>
                                    <select name="item_id" class="form-control select2" id="location_id">
                                        <option value="0">Select Location</option>
                                        @foreach (CommonHelper::get_users_warehouse() as $warehouse)
                                            <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <label>From Date</label>
                                    <input type="Date" name="FromDate" id="FromDate" min="<?php echo $AccYearFrom?>" max="<?php echo $AccYearTo;?>" value="<?php echo $currentMonthStartDate;?>" class="form-control" />
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <label>To Date</label>
                                    <input type="Date" name="ToDate" id="ToDate" min="<?php echo $AccYearFrom?>" max="<?php echo $AccYearTo;?>" value="<?php echo $currentMonthEndDate;?>" class="form-control" />
                                </div>
                               
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-right">
                                    <input type="button" value="Fetch Internal Transfer Report" class="btn btn-sm btn-primary" onclick="fetch_transfer_report();" style="margin-top: 41px;" />
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>

                            <div id="printDemandVoucherList">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <?php echo CommonHelper::headerPrintSectionInPrintView($m);?>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="data">
                                                        <div class="table-responsive" >
                                                            <table class="table table-bordered sf-table-list" id="issuanceVoucherList">
                                                                <thead>
                                                                <th class="text-center">S.No</th>
                                                                <th class="text-center">Item</th>
                                                                <th class="text-center">Location From</th>
                                                                <th class="text-center">Location To</th>
                                                                <th class="text-center">Qty</th>
                                                                <th class="text-center">Status</th>
                                                                </thead>

                                                                <tbody id="ShowHide">

                                                                
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right hidden qrCodeDiv">
                                        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate('View Purchase Demand Voucher List'))!!} ">
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
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
    <script>
          $(document).ready(function(){
            $('select').select2();
        });
    </script>
    <script !src="">
        //issuanceDataFilter();

        function fetch_transfer_report()
        {
            var FromDate = $('#FromDate').val();
            var ToDate = $('#ToDate').val();
            var location_id = $('#location_id').val();
            var m = '<?php echo $m?>';
            $('#ShowHide').html('<tr><td colspan="14"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="loader"></div></div></div></td><tr>');

            $.ajax({
                url: '<?php echo url('/') ?>/stdc/getStockTransferReportDataAjax',
                type: 'Get',
                data: {location_id: location_id,FromDate: FromDate,ToDate:ToDate,m:m},

                success: function (response) {
                    $('#ShowHide').html(response);
                }
            });
        }
    </script>

@endsection