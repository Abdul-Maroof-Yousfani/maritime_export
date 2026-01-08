<?php
$m = Session::get('run_company');
use App\Helpers\StoreHelper;
use App\Helpers\CommonHelper;
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
                                <span class="subHeadingLabelClass">Edit Issuance Form</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            {{ Form::open(['url' => 'stad/updateIssuanceDetail?m=' . $m . '', 'id' => 'cashPaymentVoucherForm', 'class' => 'stop']) }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <input type="hidden" name="issuance_id" id="" value="{{$Issuance->id}}">
                                            <div class="cola-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Voucher No</label>
                                                <input type="text" readonly class="form-control"
                                                    value="{{$Issuance->iss_no}}">
                                            </div>

                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Voucher Date</label>
                                                <input type="date" class="form-control" id="voucher_date"
                                                    name="voucher_date" value="{{$Issuance->iss_date}}">
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
                                                                <option value="{{ $y2->id }}" @if($Issuance->department_id == $y2->id) selected @endif>
                                                                    {{ $y2->sub_department_name }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label for="">Machinery</label>
                                                <select name="machinery_id" id="machinery_id"
                                                    class="form-control select2">
                                                    <option value="">Select Machinery</option>
                                                    @foreach ($machineries as $machinery)
                                                        <option value="{{ $machinery->id }}" @if($Issuance->machine_id == $machinery->id) selected @endif>{{ $machinery->name }}
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
                                                        <option value="{{ $line->id }}" @if($Issuance->line_id == $line->id) selected @endif>{{ $line->name }}
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
                                                <input type="text" name="receipt_serial_no" class="form-control" value="{{$Issuance->receipt_serial_no}}">
                                            </div>
                                            
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <label for="">Issuance Remarks</label>
                                                <textarea class="form-control" name="issuance_remarks" id="issuance_remarks" cols="5" rows="5">{{$Issuance->description}}</textarea>
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
                                                                <th class="text-center" style="width: 250px;">Batch Code</th>
                                                                <th class="text-center" style="width: 250px;">In Stock</th>
                                                                <th class="text-center" style="width: 250px;">Out</th>
                                                                <th class="text-center" style="width: 250px;">Replacement</th>
                                                                <th class="text-center" style="width: 400px;">ItemWise Remarks</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="AppnedHtml">
                                                            @php
                                                             $rowkey = 1;   
                                                            @endphp
                                                            @foreach($IssuanceData as $row) 
                                                            <tr id="AppnedHtml{{$rowkey}}">
                                                                <td>
                                                                    <select name="item_id[]" id="item_id{{$rowkey}}" onchange="itemChange({{$rowkey}})"
                                                                        class="form-control requiredField select2 item_id">
                                                                        <option value="">Select Item</option>
                                                                        {{-- @foreach (CommonHelper::get_all_subitem() as $subitem) --}}
                                                                        @php
                                                                            $selectedItem = CommonHelper::get_subitem_detail($row->sub_item_id);
                                                                            $selectedItem = explode(',',$selectedItem);
                                                                        @endphp
                                                                            <option value="{{ $selectedItem[9] }}" selected data-uom="{{ $selectedItem[0] }}">
                                                                                {{ $selectedItem[10] . ' - ' . $selectedItem[4] }}
                                                                            </option>
                                                                        {{-- @endforeach --}}
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"  readonly name="uom[]" id="uom{{$rowkey}}">
                                                                </td>
                                                                <td>
                                                                    <select name="warehouse_id[]" id="warehouse_id{{$rowkey}}" onchange="getStock(1)"
                                                                        class="form-control requiredField select2">
                                                                        @foreach (CommonHelper::get_users_warehouse() as $line)
                                                                            <option value="{{ $line->id }}" @if($row->warehouse_id == $line->id) selected @endif>{{ $line->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="batch_code[]" id="batch_code{{$rowkey}}" onchange="get_stock_qty(1)"
                                                                        class="form-control select2">
                                                                        <option value="">Select Batch Code</option>
                                                                        <option value="0" selected>0</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control requiredField" readonly name="in_stock[]" id="instock{{$rowkey}}">
                                                                </td>
                                                                <td>
                                                                    <input type="number" class="form-control requiredField" min="0" step="any" name="qty[]" id="qty{{$rowkey}}" value="{{$row->qty}}">
                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        class="form-control requiredField" min="0"
                                                                        step="any" value="0" name="replace_qty[]" id="replace_qty{{$rowkey}}" value="{{$row->replace_qty}}">
                                                                </td>
                                                                <td>
                                                                    <textarea class="form-control" name="item_remarks[]" id="item_remarks{{$rowkey}}" cols="5" rows="5" >{{$row->sub_ic_desc}}</textarea>
                                                                </td>
                                                                <td> 
                                                                    @if($rowkey>1)
                                                                    <button class="btn btn-danger btn-xs" onClick="rowRemove({{$rowkey}})">remove</button>
                                                                @endif
                                                                </td>
                                                            </tr>
                                                                @php
                                                                $rowkey++;
                                                                @endphp
                                                            @endforeach
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
            getAjaxItemList('.item_id');
        })
        let a = "<?php echo count($IssuanceData);?>";
        let counter = a;

        // '<option value="">Select Item</option>'+
        //     '@foreach (CommonHelper::get_all_subitem() as $subitem)'+
        //     '<option value="{{ $subitem->id }}"  data-uom="{{ $subitem->uomData->uom_name }}">'+
        //     '{{ $subitem->item_code . ' - ' . $subitem->sub_ic }}'+
        //     '</option>'+
        //     '@endforeach'+

        function AddMoreDetails(){
            ++counter;
            $("#AppnedHtml").append(''+
            '<tr id="AppnedHtml'+counter+'">'+
            '<td>'+
            '<select name="item_id[]" id="item_id'+counter+'" onchange="itemChange('+counter+')"'+
            'class="form-control requiredField select2 item_id">'+
            '</select>'+
            '</td>'+
            '<td>'+
            '<input type="text" class="form-control" readonly name="uom[]" id="uom'+counter+'">'+
            '</td>'+
            '<td>'+
            '<select name="warehouse_id[]" id="warehouse_id'+counter+'"  onchange="getStock('+counter+')"'+
            'class="form-control requiredField select2">'+
            '<option value="">Select Warehouse</option>'+
            '@foreach (CommonHelper::get_users_warehouse() as $line)'+
            '<option value="{{ $line->id }}">{{ $line->name }}'+
            '</option>'+
            '@endforeach'+
            '</select>'+
            '</td>'+
            '<td>'+
            '<select name="batch_code[]" id="batch_code'+counter+'" onchange="get_stock_qty('+counter+')"'+
            'class="form-control requiredField select2">'+
            '<option value="">Select Batch Code</option>'+
            '</select>'+
            '</td>'+
            '</td>'+
            '<td>'+
            '<input type="text" class="form-control" readonly name="in_stock[]" id="instock'+counter+'">'+
            '</td>'+
            '<td>'+
            '<input type="number" class="form-control" name="qty[]" min="0" step="any" id="qty'+counter+'">'+
            '</td>'+
            '<td>' +
            '<input type="number" class="form-control" min="0" value="0" step="any" name="replace_qty[]" value="0" id="replace_qty' +
            counter + '">' +
            '</td>' +
            '<td>'+
            '<textarea class="form-control" name="item_remarks[]" id="item_remarks'+counter+'" cols="5" rows="5"></textarea>'+
            '</td>'+
            '<td>'+
            '<button class="btn btn-danger btn-xs" onClick="rowRemove('+counter+')">remove</button>'+
            '</td>'+
            '</tr>'+
            '');
            $('.select2').select2();
            getAjaxItemList('.item_id');
        }
        function itemChange(id){
            $('#uom'+id).val($('#item_id'+id).find(':selected').data('uom'));
        }

        function rowRemove(id){
            $('#AppnedHtml'+id).remove()
        }
        function getStock(number)
        {
            var warehouse=$('#warehouse_id'+number).val();
            var item=$('#item_id'+number).val();
            
            var batch_code=0;
            $.ajax({
                url: '<?php echo url('/')?>/pdc/get_stock_location_wise?batch_code=0',
                type: "GET",
                data: {warehouse:warehouse,item:item},
                success:function(data)
                {
                    $('#batch_code'+number).html('<option  value="0">0</option>');
                    data=data.split('/');
					console.log(data);
                    $('#instock'+number).val(data[0]);
                    console.log(data);
                    // $("#qty"+number).val(0);
                    if (data[0]==0){
                        $("#item_id"+number).css("background-color", "red");                    
                    }else{
                        $("#item_id"+number).css("background-color", "");
                    }
                }
            });
			
	
        }
        function get_stock_qty(number)
        {
            var warehouse=$('#warehouse_id'+number).val();
            var item=$('#item_id'+number).val();
            var batch_code=$('#batch_code'+number).val();

            $.ajax({
                url: '<?php echo url('/')?>/pdc/get_stock_location_wise?batch_code='+batch_code,
                type: "GET",
                data: {warehouse:warehouse,item:item, batch_code:batch_code},
                success:function(data)
                {
                    data=data.split('/');
					console.log(data);
                    $('#instock'+number).val(data[0]);
                    console.log(data);
                    // $("#qty"+number).val(0);
                    if (data[0]==0){
                        $("#item_id"+number).css("background-color", "red");                    
                    }else{
                        $("#item_id"+number).css("background-color", "");
                    }
                }
            });
        }
    
        $(document).ready(function() {
            var arry = "<?php echo count($IssuanceData);?>";
           console.log(arry);
           var i= 1;
           for(i=1; i<=arry; i++)
           {
            itemChange(i);
            getStock(i);
            get_stock_qty(i);
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

    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
