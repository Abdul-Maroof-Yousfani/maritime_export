@php
    use App\Helpers\CommonHelper;
    use App\Helpers\ReuseableCode;
    $export = ReuseableCode::check_rights(232);
    
    $current_date = date('Y-m-d');
    $currentMonthStartDate = date('Y-m-01');
    $currentMonthEndDate = date('Y-m-t');
    $m = Session::get('run_company');
@endphp

@extends('layouts.default')
@section('content')
    <div class="well_N">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                        {{ CommonHelper::displayPrintButtonInBlade('printDemandVoucherList', '', '1') }}
                        @if ($export == true)
                            {{ CommonHelper::displayExportButton('demandVoucherList', '', '1') }}
                        @endif
                    </div>
                    <div class="lineHeight">&nbsp;</div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="well">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span class="subHeadingLabelClass">View Stock Adjust List</span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <label>From Date</label>
                                    <input type="Date" name="fromDate" id="fromDate" max="{{ $current_date }}"
                                        value="{{ $currentMonthStartDate }}" class="form-control" />
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-center">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type="text" readonly class="form-control text-center" value="Between" />
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <label>To Date</label>
                                    <input type="Date" name="toDate" id="toDate" value="{{ $currentMonthEndDate }}"
                                        class="form-control" />
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <input type="button" value="View Filter Data" class="btn btn-sm btn-primary"
                                        onclick="getStockAdjustList();" style="margin-top: 33px;" />
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div id="printDemandVoucherList">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                {{ CommonHelper::headerPrintSectionInPrintView($m) }}
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered sf-table-list" id="demandVoucherList">
                                                                <thead>
                                                                    <th class="text-center">S.No</th>
                                                                    <th class="text-center">Item Name</th>
                                                                    <th class="text-center">UOM</th>
                                                                    <th class="text-center">Warehouse</th>
                                                                    <th class="text-center">Type</th>
                                                                    <th class="text-center">QTY</th>
                                                                    <th class="text-center">Remarks</th>
                                                                    <th class="text-center">Created BY</th>
                                                                    <th class="text-center hidden-print">Action</th>
                                                                </thead>
                                                                <tbody id="filterStockAdjustList">

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
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            getStockAdjustList();
        })

        function getStockAdjustList() {
            $('#filterStockAdjustList').html('<tr><td colspan="8"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="loader"></div></div></div></td></tr>');
            var fromDate = $('#fromDate').val();
            var toDate = $('#toDate').val();

            console.log(fromDate,toDate);
            $.ajax({
                url: "{{ url('store/stockAdjustList') }}",
                method: 'GET',
                data: {
                    fromDate,toDate,
                    // add more key-value pairs as needed
                },
                success: function(response) {
                    $('#filterStockAdjustList').html(response);
                }
            });
        }
    </script>
@endsection
