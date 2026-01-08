<?php
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
$export = ReuseableCode::check_rights(234);

$current_date = date('Y-m-d');
$currentMonthStartDate = date('Y-m-01');
$currentMonthEndDate = date('Y-m-t');
$m = Session::get('run_company');
$data = ReuseableCode::get_account_year_from_to($m);
$from = $data[0];
$to = $data[0];
?>

@extends('layouts.default')

@section('content')
    <div class="well_N">
        <div class="dp_sdw">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="well">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <span class="subHeadingLabelClass">Create Temp Grn</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label>System Code</label>
                                        <input type="text" name="systemCode" id="systemCode" readonly class="form-control"
                                            value="{{ CommonHelper::unique_for_system_code(date('y'), date('m')) }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label>DC NO</label>
                                        <input type="text" name="dcNo" id="dcNo" class="form-control" />
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label>DC Date</label>
                                        <input type="date" name="dcDate" id="dcDate" class="form-control" />
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="button" value="Submit" class="btn btn-sm btn-primary"
                                            onclick="addTempGrn();" />
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dp_sdw">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                            <?php echo CommonHelper::displayPrintButtonInBlade('printGoodsReceiptNoteList', '', '1'); ?>
                            <?php if($export == true):?>
                            <a id="dlink" style="display:none;"></a>
                            <input type="button" class="btn btn-warning"
                                onclick="tablesToExcel(array1, 'Sheet1', 'GRN <?php echo date('Y-m-d'); ?>.xls')"
                                value="Export to Excel">
                            <?php endif;?>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="well">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <span class="subHeadingLabelClass">View Temp Grn List</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                {{-- <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <label>GRN No</label>
                                    <input type="text"  name="grn_no" id="grn_no" class="form-control" value="">
                                    <span id="GrnNoError"></span>

                                </div>


                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 text-right">
                                    <input type="button" value="View Filter Data" class="btn btn-sm btn-primary" onclick="get_grn(1);" style="margin-top: 32px;" />
                                </div>
                            </div> --}}
                                <div class="lineHeight">&nbsp;</div>
                                <div id="printGoodsReceiptNoteList">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="panel">
                                                <div class="panel-body">
                                                    <?php echo CommonHelper::headerPrintSectionInPrintView($m); ?>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered sf-table-list"
                                                                    id="export_table_to_excel_1">
                                                                    <thead>
                                                                        <th class="text-center">#</th>
                                                                        <th class="text-center">System Code</th>
                                                                        <th class="text-center">DC NO</th>
                                                                        <th class="text-center">DC Date</th>
                                                                        {{-- <th class="text-center hidden-print">Action</th> --}}
                                                                    </thead>
                                                                    <tbody id="tempGrnAjaxList"></tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right hidden qrCodeDiv">
                                            <img src="data:image/png;base64, {!! base64_encode(
                                                QrCode::format('png')->size(200)->generate('View Goods Receipt Note Voucher List'),
                                            ) !!} ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                get_temp_grn();
            })

            function addTempGrn() {
                var dcNo = $('#dcNo').val();
                var dcDate = $('#dcDate').val();
                var url = "<?php echo url('/'); ?>"
                if (!dcNo || !dcDate) {
                    alert('Fill All Fields');
                    return;
                }
                $.ajax({
                    url: url + '/pad/addTempGrn',
                    type: 'get',
                    data: {
                        dcNo: dcNo,
                        dcDate: dcDate,
                    },
                    success: function(response) {
                        //    console.log(response);

                        get_temp_grn();
                        $('#dcNo').val('');
                        $('#dcDate').val('');
                    }
                });
            }

            function get_temp_grn() {

                var m = '{{ Session::get('run_company') }}';
                var url = '{{ url('/') }}';

                $('#tempGrnAjaxList').html('<tr><td colspan="11" class="loader"></td></tr>')
                $.ajax({
                    url: url + '/purchase/tempGrn',
                    type: 'Get',

                    success: function(response) {
                        // alert(response)
                        $('#tempGrnAjaxList').html(response);
                    }
                });

            }

            // function DeleteGrn(Id)
            // {
            //     if (confirm('Are You Sure ? You want to delete this recored...!')) {
            //         var m = '<?php echo $m; ?>';

            //         //$('#data').html('<tr><td colspan="14"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="loader"></div></div></div></td><tr>');
            //         $.ajax({
            //             url: '/pdc/DeleteGrn',
            //             type: 'Get',
            //             data: {Id: Id,m:m},

            //             success: function (response) {
            //                 //alert(response);
            //                 $('#RemoveTr'+response).remove();
            //             }
            //         });
            //     }
            //     else {}
            //     //*/
            // }
        </script>
        <script src="{{ URL::asset('assets/custom/js/customPurchaseFunction.js') }}"></script>
    @endsection
