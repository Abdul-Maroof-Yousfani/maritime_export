<?php 
    use App\Helpers\CommonHelper;
    use App\Helpers\PurchaseHelper;
    use App\Helpers\ReuseableCode;
    $export = ReuseableCode::check_rights(243);
    $financial_year = ReuseableCode::get_account_year_from_to($_GET['m']);

    if (isset($_GET['type'])):
        $type = $_GET['type'];
    else:
        $type = 0;
    endif;
?>
@extends('layouts.default')
@section('content')
    @include('select2')
    <div class="">
        <div class="well_N">
            <div class="">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 dp_sdw">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <span class="subHeadingLabelClass">Category Wise Report</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <div class="form-group">
                              <label for="from_date">From Date</label>
                              <input type="date" class="form-control" name="from_date" id="from_date" aria-describedby="from_date" placeholder="From Date" value="{{date('Y-m-01')}}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <div class="form-group">
                              <label for="last_date">To Date</label>
                              <input type="date" class="form-control" name="last_date" id="last_date" aria-describedby="last_date" placeholder="last Date" value="{{date('Y-m-t')}}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">Purchase No</label>
                            <input type="text" class="form-control" name="purchase_no" id="purchase_no">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 hide">
                            <label for="">GR No</label>
                            <input type="text" class="form-control" name="gr_no" id="gr_no">
                        </div>
                    
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">Item</label>
                            <select name="ItemId" id="item_id" class="form-control">
                                <option value="">ALL</option>
                                <?php foreach($SubItem as $ItemFil):?>
                                <option value="<?php echo $ItemFil->id; ?>"><?php echo $ItemFil->sub_ic; ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">PO Type</label>
                            <select name="po_type" id="po_type" class="form-control">
                                {{-- <option value="">ALL</option> --}}
                                <option value="1">Normal Purchase</option>                             
                                <option value="2">Spot Purchase</option>                             
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">Department</label>
                            <select class="form-control select2" multiple name="department_id" id="department_id">
                                <option value="">Select Department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->sub_department_name }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label class="sf-label">Company Location</label>
                            <select class="form-control requiredField select2" name="company_location_id"
                                id="company_location_id">
                                <option value="">Select Location</option>
                                @foreach (ReuseableCode::getUserWiseLocationRightsData() as $company_location)
                                    <option value="{{ $company_location['id'] }}">{{ $company_location['location_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <button type="button" class="btn btn-sm btn-primary" onclick="stockReportItemWise()"
                                style="margin: 30px 0px 0px 0px;">Submit</button>
                        </div>
                        <input type="hidden" id="accyearfrom" value="{{ $financial_year[0] }}" />
                    </div>
                    <div>&nbsp;</div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                            <?php echo CommonHelper::displayPrintButtonInBlade('filterBookDayList', 'HrefHide', '1'); ?>
                            <?php if($export == true):?>
                                <a id="dlink" style="display:none;"></a>
                                <button type="button" class="btn btn-warning"
                                    onclick="ExportToExcel('expToExcel','CategoryWiseReport')">Export
                                    <b>(xlsx)</b></button>
                            <?php endif;?>
                        </div>
                    </div>
                    <div>&nbsp;</div>
                    <div id="printBankReceiptVoucherList">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="filterBookDayList">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ URL::asset('assets/custom/js/exportToExcelXlsx.js') }}"></script>
        <script !src="">
            var ExportToExcel = (function() {
                var uri = 'data:application/vnd.ms-excel;base64,';
                var template =
                    '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>';
                var base64 = function(s) {
                    return window.btoa(unescape(encodeURIComponent(s)));
                };
                var format = function(s, c) {
                    return s.replace(/{(\w+)}/g, function(m, p) {
                        return c[p];
                    });
                };

                return function(table, name) {
                    if (!table.nodeType)
                        table = document.getElementById(table);
                    var ctx = {
                        worksheet: name || 'Sheet1',
                        table: table.innerHTML
                    };
                    var link = document.createElement('a');
                    link.href = uri + base64(format(template, ctx));
                    link.download = name ? name + "{{ date('Y-m-d') }}" + '.xls' : 'table.xls';
                    link.click();
                };
            })();

            // function ExportToExcel(type, fn, dl) {
            //     var elt = document.getElementById('expToExcel');
            //     var wb = XLSX.utils.table_to_book(elt, {
            //         sheet: "sheet1"
            //     });
            //     return dl ?
            //         XLSX.write(wb, {
            //             bookType: type,
            //             bookSST: true,
            //             type: 'base64'
            //         }) :
            //         XLSX.writeFile(wb, fn || ('Category Wise Report <?php echo date('Y-m-d'); ?>.' + (type || 'xlsx')));
            // }
        </script>
        <script>
            $(document).ready(function() {
                $('#item_id').select2();
                $('#department_id').select2();
                //stockReportItemWise();
            });

            function stockReportItemWise() {
                var purchase_no = $('#purchase_no').val();
                var from_date = $('#from_date').val();
                var last_date = $('#last_date').val();
                var gr_no = $('#gr_no').val();
                var item_id = $("#item_id option:selected").val()
                var department_id = $("#department_id").val()
                var po_type = $("#po_type option:selected").val()

                var company_location_id = $('#company_location_id').val();
                $('#filterBookDayList').html('<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="loader"></div></div></div>');
                $.ajax({
                    url: '<?php echo url('/'); ?>/reports/categoryWiseReportAjax',
                    method: 'GET',
                    data: {
                        purchase_no: purchase_no,
                        gr_no: gr_no,
                        from_date: from_date,
                        last_date: last_date,
                        item_id: item_id,
                        department_id: department_id,
                        po_type: po_type,
                        company_location_id: company_location_id,

                    },
                    error: function() {
                        alert('error');
                    },
                    success: function(response) {
                        $('#filterBookDayList').html(response);
                    }
                });
            }
        </script>
    @endsection
