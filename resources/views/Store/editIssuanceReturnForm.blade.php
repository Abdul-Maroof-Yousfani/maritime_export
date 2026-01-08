<?php
$m = Session::get('run_company');
use App\Helpers\StoreHelper;
use App\Helpers\CommonHelper;
use App\Models\Line;
use App\Models\Machinery;
use App\Models\IssuanceReturnData;
use App\Models\Department;

$departments = Department::where([['status', '=', '1'],])->select('id', 'department_name')->orderBy('id')->get();
$lines = Line::where('status', 1)->get();
$machineries = Machinery::where('status', 1)->get();
?>
@extends('layouts.default')

@section('content')
    @include('select2')
    @include('modal')
    @include('number_formate')
    <style>
        * {
            font-size: 12px !important;
            font-family: Arial;
        }
        .select2 {
            width: 100%;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="display: none;">
                {{-- @include('Purchase.'.$accType.'purchaseMenu') --}}
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well_N">
                    <div class="dp_sdw">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span class="subHeadingLabelClass">Edit Issuance Return Form</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            {{ Form::open(['url' => 'stad/updateIssuanceReturnDetail?m=' . $m . '', 'id' => 'cashPaymentVoucherForm', 'class' => 'stop']) }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <input type="hidden" name="issuance_return_id" id="" value="{{$IssuanceReturn->id}}">
                                            <div class="cola-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Voucher No</label>
                                                <input type="text" readonly class="form-control"
                                                    value="{{strtoupper($IssuanceReturn->voucher_no)}}">
                                            </div>

                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Voucher Date</label>
                                                <input type="date" class="form-control" id="voucher_date"
                                                    name="voucher_date" value="{{$IssuanceReturn->voucher_date}}">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label class="sf-label">Department / Sub Department</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                <select class="form-control requiredField select2"
                                                    name="sub_department_id_1" id="sub_department_id_1">
                                                    <option value="">Select Department</option>
                                                    @foreach ($departments as $key => $y)
                                                        <optgroup label="{{ $y->department_name }}"
                                                            value="{{ $y->id }}">
                                                            <?php
                                                            $subdepartments = DB::select('select `id`,`sub_department_name` from `sub_department` where `department_id` =' . $y->id . '');
                                                            ?>
                                                            @foreach ($subdepartments as $key2 => $y2)
                                                                <option value="{{ $y2->id }}" @if($IssuanceReturn->department_id == $y2->id) selected @endif>
                                                                    {{ $y2->sub_department_name }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Machinery</label>
                                                <select name="machinery_id" id="machinery_id"
                                                    class="form-control requiredField select2">
                                                    <option value="">Select Machinery</option>
                                                    @foreach ($machineries as $machinery)
                                                        <option value="{{ $machinery->id }}" @if($IssuanceReturn->machine_id == $machinery->id) selected @endif>{{ $machinery->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                           

                                        </div>
                                        <div class="row">
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="">Line</label>
                                                <select name="line_id" id="line_id"
                                                    class="form-control select2">
                                                    <option value="">Select Line</option>
                                                    @foreach ($lines as $line)
                                                        <option value="{{ $line->id }}" @if($IssuanceReturn->line_id == $line->id) selected @endif>{{ $line->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="">Charge</label>
                                                <input type="text" class="form-control" value="">
                                            </div> --}}
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="">Receipt serial no</label>
                                                <input type="text" name="receipt_serial_no" class="form-control" value="{{$IssuanceReturn->receipt_serial_no}}">
                                            </div>
                                            
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <label for="">Issuance Remarks</label>
                                                <textarea class="form-control" name="issuance_remarks" id="issuance_remarks" cols="5" rows="5">{{$IssuanceReturn->description}}</textarea>
                                            </div>
                                            {{-- <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <label class="sf-label">Description</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                <textarea name="description_1" id="description_1" rows="2" cols="50" style="resize:none;"
                                                    class="form-control requiredField"></textarea>
                                            </div> --}}
                                        </div>
                                        <div class="lineHeight">&nbsp;</div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                {{-- <div class="text-right right">
                                                    <input type="button" class="btn btn-sm btn-primary"
                                                        onclick="AddMoreDetails()" value="Add More Rows" />
                                                </div> --}}
                                                <div style="text-align: center" class="table-responsive  text-center"
                                                    id="">
                                                    <table style="" class="table table-bordered well">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center" style="width: 400px;">Products</th>
                                                                <th class="text-center" style="width: 250px;">UOM</th>
                                                                <th class="text-center" style="width: 250px;">Warehouse</th>
                                                                <th class="text-center" style="width: 250px;">Type</th>
                                                                <th class="text-center" style="width: 250px;">QTY</th>
                                                                <th class="text-center" style="width: 400px;">ItemWise Remarks</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="AppnedHtml">
                                                         
                                                        </tbody>
                                                    </table>
                                                    <div class="text-right right">
                                                        <input type="button" class="btn btn-sm btn-primary"
                                                            onclick="AddMoreDetails()" value="Add More Rows" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="demandsSection"></div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}

                                </div>
                            </div>
                            <?php echo Form::close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $('.select2').select2();
        $(function () {
            // getAjaxItemList('.item_id');
        })
        let a = "<?php echo count($IssuanceReturnData);?>";
        let counter = a;

        function AddMoreDetails(){
            ++counter;
            $("#AppnedHtml").append(''+
            '<tr id="AppnedHtml'+counter+'">'+
            '<td>'+
            '<select name="item_id[]" id="item_id'+counter+'" onchange="itemChange('+counter+')"'+
            'class="form-control requiredField select2">'+
             '<option value="">Select Item</option>'+
            '@foreach (CommonHelper::get_all_subitem() as $subitem)'+
            '<option value="{{ $subitem->id }}"  data-uom="{{ $subitem->uomData->uom_name }}">'+
            '{{ $subitem->item_code . ' - ' . $subitem->sub_ic }}'+
            '</option>'+
            '@endforeach'+
            '</select>'+
            '</td>'+
            '<td>'+
            '<input type="text" class="form-control" readonly name="uom[]" id="uom'+counter+'">'+
            '</td>'+
            '<td>'+
            '<select name="warehouse_id[]" id="warehouse_id'+counter+'"'+
            'class="form-control requiredField select2">'+
            '<option value="">Select Warehouse</option>'+
            '@foreach (CommonHelper::get_users_warehouse() as $line)'+
            '<option value="{{ $line->id }}">{{ $line->name }}'+
            '</option>'+
            '@endforeach'+
            '</select>'+
            '</td>'+
            '<td>'+
            '<select name="quality_type[]" id="quality_type' + counter + '"'+
            'class="form-control requiredField select2">'+
            '<option value="">Select Type</option>'+
            '@foreach (CommonHelper::qualityType() as $type)'+
            '<option value="{{ $type["id"] }}">'+
            '{{ $type["name"] }}'+
            '</option>'+
            '@endforeach'+
            '</select>'+
            '</td>'+
            '<td>'+
            '<input type="number" class="form-control" name="return_qty[]" min="1" step="any" id="qty'+counter+'">'+
            '</td>'+
            '<td>'+
            '<textarea class="form-control" name="item_remarks[]" id="item_remarks'+counter+'" cols="5" rows="5"></textarea>'+
            '</td>'+
            '<td>'+
            '<button class="btn btn-danger btn-xs" onClick="rowRemove('+counter+')">remove</button>'+
            '</td>'+
            '</tr>'+
            '');
            $('.select2').select2();
            // getAjaxItemList('.item_id');
        }
        function itemChange(id){
            $('#uom'+id).val($('#item_id'+id).find(':selected').data('uom'));
        }

        function rowRemove(id){
            $('#AppnedHtml'+id).remove()
        }
    
        $(document).ready(function() {
            var id = "{{$IssuanceReturn->id}}";
            setTimeout(issue_return_detail(id), 5000);
            var arry = "<?php echo count($IssuanceReturnData);?>";
           console.log(arry);
           var i= 1;
           for(i=1; i<=arry; i++)
           {
            itemChange(i);
       
           }
   	$(".btn-success").click(function(e){

   		//alert();
   		var purchaseRequest = new Array();
   		var val;
   		//$("input[name='demandsSection[]']").each(function(){
   		purchaseRequest.push($(this).val());
   
   
   
   		//});
   		var _token = $("input[name='_token']").val();
   		for (val of purchaseRequest) {
   			jqueryValidationCustom();
   			if(validate == 0){
   				//alert(response);
   			}else{
   				return false;
   			}
   		}
   
   	});
   });

   function issue_return_detail(id){
         $.ajax({
                url: '<?php echo url('/') ?>/store/editIssuanceReturnFormDetail',
                type: 'Get',
                data: {id: id},

                success: function (response) {
                    $('#AppnedHtml').html(response);
                }
            });
    }

    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
