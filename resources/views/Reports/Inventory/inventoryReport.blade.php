<?php use App\Helpers\CommonHelper; ?>
<?php use App\Helpers\PurchaseHelper;
use App\Helpers\ReuseableCode;
$export=ReuseableCode::check_rights(243);

 $financial_year=ReuseableCode::get_account_year_from_to($_GET['m']);

        if (isset($_GET['type'])):
            $type=$_GET['type'];
        else:
        $type=0;
        endif;
?>
@extends('layouts.default')
@section('content')
@include('select2')

<?php




?>

<div class="">
    <div class="well_N">
    <div class="">    
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 dp_sdw">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="subHeadingLabelClass">Inventory Details Report</span>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label for="">PR No</label>
                <input type="text" class="form-control" name="pr_no" id="pr_no">
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label for="">PO No</label>
                <input type="text" class="form-control" name="purchase_no" id="purchase_no">
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label for="">GR No</label>
                <input type="text" class="form-control" name="gr_no" id="gr_no">
            </div>
          
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label for="">Item</label>
               <select name="ItemId" id="item_id" class="form-control">
                <option value="">ALL</option>
                <?php foreach($SubItem as $ItemFil):?>
                    <option value="<?php echo $ItemFil->id?>"><?php echo $ItemFil->sub_ic?></option>
                <?php endforeach;?>
                </select>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label for="">PR Status</label>
               <select name="pr_status" id="pr_status" class="form-control">
                <option value="0">ALL</option>
                <option value="1">Pending</option>
                <option value="2">Approved</option>
                <option value="3">Cancel</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label for="">Department</label>
               <select class="form-control" name="department_id" id="department_id">
                <option value="">Select Department</option>
                    @foreach ($departments as $department)
                        <option value="{{$department->id}}">{{$department->sub_department_name}}</option>
                    @endforeach
               </select>
               <input type="hidden" id="accyearfrom" value="{{$financial_year[0]}}"/>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label class="sf-label">Company Location</label>
                <select class="form-control requiredField select2" name="company_location_id"
                    id="company_location_id">
                    <option value="">Select Location</option>
                    @foreach (ReuseableCode::getUserWiseLocationRightsData() as $company_location)
                        <option value="{{$company_location['id']}}">{{$company_location['location_name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <input type="checkbox" onclick="stockReportItemWise()" name="view_po" id="view_PO" value="1"> View PO</button>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <input type="checkbox" onclick="stockReportItemWise()" name="view_grn" id="view_grn" value="1"> View GRN</button>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <button type="button" class="btn btn-sm btn-primary" onclick="stockReportItemWise()" style="margin: 30px 0px 0px 0px;">Submit</button>
            </div>
        </div>

        <div>&nbsp;</div>

        <div id="printBankReceiptVoucherList">
            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="panel">
                        <div class="panel-body">
                            <?php //echo CommonHelper::headerPrintSectionInPrintView($m);?>
                            <?php echo CommonHelper::displayPrintButtonInBlade('filterBookDayList','HrefHide','1');?>
                                <?php if($export == true):?>
                                <a id="dlink" style="display:none;"></a>
                                <button type="button" class="btn btn-warning" onclick="ExportToExcel('xlsx')">Export <b>(xlsx)</b></button>
                            <?php endif;?>
                            <div id="filterBookDayList"></div>

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
        var elt = document.getElementById('expToExcel');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
                XLSX.writeFile(wb, fn || ('Inventory Detail Report <?php echo date('Y-m-d')?>.' + (type || 'xlsx')));
    }
</script>
    <script>

        $(document).ready(function(){
            $('#item_id').select2();
            $('#department_id').select2();
            stockReportItemWise();
        });
        function stockReportItemWise(){
            var purchase_no =  $('#purchase_no').val();
            var pr_no =  $('#pr_no').val();
            var view_grn =  ($('#view_grn').is(":checked"))? 1:0;
            var view_PO =  ($('#view_PO').is(":checked"))? 1:0;
            var gr_no =  $('#gr_no').val();
            var pr_status =  $('#pr_status').val();
            var item_id =  $("#item_id option:selected").val()
            var department_id  =    $("#department_id option:selected").val()
            
            var company_location_id =  $('#company_location_id').val();
           

            $('#filterBookDayList').html('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="loader"></div></div>');
            $.ajax({
                url: '<?php echo url('/')?>/store/inventoryReportAjax',
                method:'GET',
                data:{
                    pr_status:pr_status, 
                    view_grn:view_grn, 
                    view_PO:view_PO, 
                    purchase_no:purchase_no, 
                    pr_no:pr_no, gr_no:gr_no, 
                    item_id:item_id, 
                    department_id:department_id,
                    company_location_id:company_location_id,
                },
                error: function()
                {
                    alert('error');
                },
                success: function(response){
                    $('#filterBookDayList').html(response);
                }
            });
        }
    </script>
@endsection