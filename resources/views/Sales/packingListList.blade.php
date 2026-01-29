<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
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

    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well_N">
                <div class="dp_sdw">    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <span class="subHeadingLabelClass">Packing List</span>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                                <a href="{{ url('/export/createPackingList') }}" class="btn btn-success">Create Packing List</a>
                                <?php echo CommonHelper::displayPrintButtonInBlade('PrintPackingListList','','1');?>
                                @if($export == true)
                                    <a id="dlink" style="display:none;"></a>
                                    <button type="button" class="btn btn-warning" onclick="ExportToExcel('xlsx')">Export <b>(xlsx)</b></button>
                                @endif
                            </div>
                        </div>
                    </div>	
                    <hr style="border-color: #ccc">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Packing List No</label>
                            <input type="text" name="packing_list_no" id="packing_list_no" class="form-control" placeholder="Packing List No"  />
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Commercial Invoice No</label>
                            <input type="text" name="commercial_invoice_no" id="commercial_invoice_no" class="form-control" placeholder="Commercial Invoice No"  />
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>From Date</label>
                            <input type="Date" name="from" id="from" value="<?php echo $currentMonthStartDate;?>" class="form-control" min="<?php echo $AccYearFrom?>" max="<?php echo $AccYearTo?>"/>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>To Date</label>
                            <input type="Date" name="to" id="to" max="<?php echo $AccYearTo?>" value="<?php echo $currentMonthEndDate?>" class="form-control" min="<?php echo $AccYearFrom?>"  />
                        </div>
                        <div class="col-lg-2 col-md-2 col-xs-12">
                            <input type="button" value="View Filter Data" class="btn btn-sm btn-danger" onclick="viewPackingListFilter();" style="margin-top: 32px;" />
                        </div>
                    </div>
                    <div class="lineHeight">&nbsp;</div>
                    <div class="panel">
                        <div class="panel-body" id="PrintPackingListList">
                            <?php echo CommonHelper::headerPrintSectionInPrintView($m);?>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Packing List No</th>
                                                    <th>Date</th>
                                                    <th>Commercial Invoice No</th>
                                                    <th>GD NO</th>
                                                    <th>Container No</th>
                                                    <th>Gross Weight (KGS)</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="packingListListAjax">
                                                <!-- Data will be loaded here via AJAX -->
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

<script>
    function viewPackingListFilter() {
        var packing_list_no = $('#packing_list_no').val();
        var commercial_invoice_no = $('#commercial_invoice_no').val();
        var from = $('#from').val();
        var to = $('#to').val();
        var m = '<?php echo $m?>';
        
        $.ajax({
            url: '{{ url("/export/getPackingListFilter") }}',
            type: 'GET',
            data: {
                packing_list_no: packing_list_no,
                commercial_invoice_no: commercial_invoice_no,
                from: from,
                to: to,
                m: m
            },
            success: function(response) {
                $('#packingListListAjax').html(response);
            },
            error: function() {
                alert('Error loading data');
            }
        });
    }
    
    // Load data on page load
    $(document).ready(function() {
        viewPackingListFilter();
    });
</script>

@endsection
