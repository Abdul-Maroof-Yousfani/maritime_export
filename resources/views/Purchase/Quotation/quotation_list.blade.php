<?php
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;

$m = Session::get('run_company');
$current_date = date('Y-m-d');
$currentMonthStartDate = date('Y-m-01');
$currentMonthEndDate = date('Y-m-t');

?>

<link href="{{ URL::asset('assets/css/printTwo.css') }}" rel="stylesheet" />
@extends('layouts.default')

@section('content')
    <div class="well_N">
        <div class="dp_sdw">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                            <?php echo CommonHelper::displayPrintButtonInBlade('printDemandVoucherList', '', '1'); ?>

                            <?php echo CommonHelper::displayExportButton('demandVoucherList', '', '1'); ?>

                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="well">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <span class="subHeadingLabelClass">Quotation List</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>

                                <div class="row">

                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>From Date</label>
                                        <input type="Date" name="fromDate" id="fromDate" max="<?php echo $current_date; ?>"
                                            value="<?php echo $currentMonthStartDate; ?>" class="form-control" />
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-center">
                                        <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <input type="text" readonly class="form-control text-center" value="Between" />
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>To Date</label>
                                        <input type="Date" name="toDate" id="toDate" max="<?php echo $current_date; ?>"
                                            value="<?php echo $currentMonthEndDate; ?>" class="form-control" />
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label class="sf-label">Company Location</label>
                                        <select class="form-control requiredField select2" name="company_location_id"
                                            id="company_location_id">
                                            {{-- <option value="">Select Location</option> --}}
                                            @foreach (ReuseableCode::getUserWiseLocationRightsData() as $company_location)
                                                <option value="{{$company_location['id']}}" @if(Session::get('run_company') == 8 && $company_location['id'] == 3) selected @endif>{{$company_location['location_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label class="sf-label">Status</label>
                                        <select class="form-control  select2" name=""
                                            id="status">
                                            <option value="">All</option>
                                            <option value="pending">Pending</option>
                                            <option value="not_checked">Not Checked</option>
                                            <option value="checked">Checked</option>
                                            <option value="checked_but_not_audited">Checked But Not Audited</option>
                                            <option value="audited">Audited</option>
                                            <option value="audited_but_not_approved">Audited But Not Approved</option>
                                            <option value="approved">Approved</option>
                                            
                                        </select>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-right">
                                        <input type="button" value="View Filter Data" class="btn btn-primary"
                                            onclick="get_data();" style="margin-top: 32px;" />
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div id="printDemandVoucherList">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="panel">
                                                <div class="panel-body">
                                                    <?php echo CommonHelper::headerPrintSectionInPrintView($m); ?>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered sf-table-list"
                                                                    id="demandVoucherList">
                                                                    <thead>
                                                                        <tr>
                                                                            <th colspan="7"><button type="button" class="btn btn-primary" onclick="getCheckedInputForGenerateNumber()">Approve quotation</button></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <thead>
                                                                        <th class="text-center">S.No</th>

                                                                        <th class="text-center">Quotation No</th>
                                                                        <th class="text-center">Quotation Date</th>
                                                                        <th class="text-center">Vendor</th>
                                                                        <th class="text-center">Ref No</th>
                                                                        <th class="text-center">Total Amount</th>
                                                                        <th class="text-center">Status</th>
                                                                        <th class="text-center hidden-print">Action</th>
                                                                    </thead>
                                                                    <tbody id="data"></tbody>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            get_data();
        });

        function get_data() {
            var from = $('#fromDate').val();
            var to = $('#toDate').val();
            var company_location_id = $('#company_location_id').val();
            var status = $('#status').val();
            $('#data').html('<tr class="loader"></tr>');

            $.ajax({
                url: '{{ url('/quotation/quotation_list_ajax') }}',
                type: "GET",
                data: {from: from,to:to,company_location_id:company_location_id,status:status
                },
                success: function(data) {

                    $("#data").html(data);

                }
            });
        }

        function delete_quotation(id) {
            if (confirm('Are you sure you want to delete this request')) {
                $.ajax({
                    url: '{{ url('/quotation/delete_quotation') }}',
                    type: "GET",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        if (data.status == "error") {
                            alert(data.message);
                        } else if (data.status == "Success") {
                            alert(data.message);
                            get_data()
                        } else {
                            alert(data)
                        }
                    }
                });
            }
        }
    </script>
    <script src="{{ URL::asset('assets/custom/js/customPurchaseFunction.js') }}"></script>
@endsection
