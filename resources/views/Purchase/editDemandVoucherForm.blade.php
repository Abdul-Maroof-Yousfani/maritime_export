<?php
// $accType = Auth::user()->acc_type;
$currentDate = date('Y-m-d');
$m = Session::get('run_company');
// if($accType == 'client'){
// }else{
//     $m = Auth::user()->company_id;
// }
use App\Helpers\PurchaseHelper;
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
// $subItems = CommonHelper::get_all_subitem();
?>
@extends('layouts.default')

@section('content')
    @include('select2')
    @include('modal')


    <style>
        * {
            font-size: 12px !important;
            font-family: Arial;
        }

        .select2 {
            width: 100%;
        }
        label {
   text-transform: capitalize;
   }
   .input-container {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  width: 100%;
  margin-bottom: 15px;
}

.icon {
    padding: 15px;
    background: #8d9399;
    color: white;
    min-width: 20px;
    text-align: center;
    height: 43px;
}

.input-field {
  /* width: 100%;
  padding: 10px; */
  outline: none;
}

.input-field:focus {
  border: 2px solid rgb(125, 129, 134);
}
    </style>

    <?php
    //   dd('in');
    $demand_no = $demand->demand_no;
    ?>
<div class="container-fluid">    

        <div class="row">
            {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="display: none;">
                @include('Purchase.'.$accType.'purchaseMenu')
            </div> --}}
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well_N">
                    <div class="dp_sdw">                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <span class="subHeadingLabelClass">Edit Purchase Request Form</span>
                        </div>
                    </div>
                    <div class="lineHeight">&nbsp;</div>
                    <div class="row">
                        <?php echo Form::open(['url' => 'pad/updateDemandDetail?m=' . $m . '', 'id' => 'cashPaymentVoucherForm', 'class' => 'stop','enctype'=>'multipart/form-data']); ?>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="pageType" value="<?php //echo $_GET['pageType']
                        ?>">
                        <input type="hidden" name="parentCode" value="<?php //echo $_GET['parentCode']
                        ?>">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <input type="hidden" name="demandsSection[]" class="form-control requiredField"
                                                id="demandsSection" value="1" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="row">

                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <label class="sf-label">PR NO. <span
                                                            class="rflabelsteric"><strong>*</strong></span></label>
                                                    <input readonly type="text" class="form-control requiredField"
                                                        placeholder="" name="pr_no" id="pr_no"
                                                        value="{{ strtoupper($demand_no) }}" />
                                                    <input type="hidden" name="EditId" value="<?php echo $id; ?>">
                                                </div>

                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <label class="sf-label">PR Date.</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <input type="date" class="form-control requiredField"
                                                        max="<?php echo date('Y-m-d'); ?>" name="demand_date_1" id="demand_date_1"
                                                        value="<?php echo $demand->demand_date; ?>" />
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <label class="sf-label">Ref No. <span
                                                            class="rflabelsteric"><strong>*</strong></span></label>
                                                    <input autofocus type="text" class="form-control requiredField"
                                                        placeholder="Ref  No" name="slip_no_1" id="slip_no_1"
                                                        value="<?php echo $demand->slip_no; ?>" />
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <label class="sf-label">Mode Type</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <select class="form-control requiredField select2" name="mode_type"
                                                        id="mode_type">
                                                        <option value="">Select Mode</option>
                                                        <option value="1" {{$demand->p_type == 1? 'selected' : ''}}>Urgent</option>
                                                        <option value="2" {{$demand->p_type == 2? 'selected' : ''}}>Normal</option>
                                                        <option value="3" {{$demand->p_type == 3? 'selected' : ''}}>MOST URGENT</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="hidden" name="demand_type" id="demand_type">
                                            <div class="row" id="form">
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <label class="sf-label">Department / Sub Department</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <select class="form-control requiredField select2"
                                                        name="sub_department_id_1" id="sub_department_id_1">
                                                        <option value="">Select Department</option>
                                                        @foreach ($departments as $y)
                                                            <optgroup label="{{ $y->department_name }}"
                                                                value="{{ $y->id }}">
                                                                <?php
                                                                $subdepartments = DB::select('select `id`,`sub_department_name` from `sub_department` where `department_id` =' . $y->id . '');
                                                                ?>
                                                                @foreach ($subdepartments as $y2)
                                                                    <option value="{{ $y2->id }}" {{($demand->sub_department_id == $y2->id)? 'selected' : ''}}> {{ $y2->sub_department_name }}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
    
    
    
                                                </div>
                                                @php 
                                                 $attachment = $demand->comments;    
                                                //  App\Models\Attachement::where('model_id',$demand->comments)
                                                //  ->where('status',1)
                                                //  ->get();
                                                 $c1 = 1;
                                                @endphp 
                                                <?php if(!empty($attachment) && count($attachment)>0):?>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>S/no</th>
                                                        <th>Link </th>
                                                        <th>Action</th>
                                                    </tr>
                                                    @foreach ($attachment as $key=> $item)
                                                        <tr id="r{{$item->id}}">
                                                            <td>{{$key}}</td>
                                                            <td>Attachement {{$c1}} </td>
                                                            <td><a class="btn btn-success" href="{{asset($item->image_src)}}" target="_blank" download>download</a>
                                                                <a class="btn btn-danger" onclick="status({{$item->id}})" target="_blank">delete</a>
                                                            </td>

                                                        </tr>
                                                        @php
                                                            $c1++;
                                                        @endphp
                                                    @endforeach
                                                </table>
                                            <?php endif ?>
                                                


                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                    <label for="">Attachment file</label>
                                                     <div class="input-container">
                                                        <input class="input-field form-control" type="file"  name="file[]">
                                               
                                                        <i class="fa fa-plus icon" onclick="add()">
                                                        </i>
                                        
                                                      </div>     
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <label class="sf-label">Description</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <textarea name="description_1" id="description_1" rows="4" cols="50" style="resize:none;"
                                                        class="form-control requiredField"><?php echo $demand->description; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="lineHeight">&nbsp;</div>

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="table-responsive" id="">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th colspan="6" class="text-center">Purchase Request Detail
                                                            </th>
                                                            {{-- <th colspan="2" class="text-center">
                                                                {{-- <input type="button" class="btn btn-sm btn-primary"
                                                                    onclick="AddMoreDetails()" value="Add More Rows" /> 
                                                            </th> --}}
                                                            <th colspan="2" class="text-center">
                                                                <span class="badge badge-success"
                                                                    id="span"><?php echo $demand_data->count(); ?></span>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            {{-- <th class="text-center">Category</th> --}}
                                                            <th class="text-center">Item Code</th>
                                                            <th class="text-center" style="width: 200px">Item Name</th>
                                                            <th style="width: 100px" class="text-center">UOM<span
                                                                    class="rflabelsteric"><strong>*</strong></span></th>
                                                            <th style="width: 130px" class="text-center">QTY<span
                                                                    class="rflabelsteric"><strong>*</strong></span></th>
                                                            <th style="width: 130px" class="text-center">Closing
                                                                Stock<span class="rflabelsteric"><strong>*</strong></span>
                                                            </th>
                                                            <th style="width: 130px" class="text-center">Last Order QTY
                                                            </th>
                                                            <th style="width: 130px" class="text-center">Last Received QTY
                                                            </th>
                                                            <th style="width: 100px" class="text-center">History</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="AppnedHtml">
                                                        @php
                                                    $Counter = 0;
                                                    // dd($demand_data );
                                                            foreach($demand_data as $Fil):
                                                            $Counter++;
                                                            $SubItem = CommonHelper::get_single_row('subitem','id',$Fil->sub_item_id);
                                                            $ItemDetail = CommonHelper::get_data($Fil->sub_item_id);
                                                            $ItemDetail = explode(',',$ItemDetail);
                                                            $lastGrnRecord = CommonHelper::get_last_rate_qty($SubItem->id)
                                                            
                                                            // $Acc = CommonHelper::get_single_row('accounts','id',$val->acc_id);
                                                        @endphp
                                                        <tr class="RemoveRows<?php echo $Counter; ?> AutoNo">

                                                            {{-- <td>
                                                                <select onchange="get_sub_item('category_id{{$Counter}}')"
                                                                    name="category" id="category_id{{$Counter}}"
                                                                    class="form-control category select2 normal_width">
                                                                    <option value="">Select</option>
                                                                    @foreach (CommonHelper::get_all_category() as $category)
                                                                        <option value="{{ $category->id }}"
                                                                            {{ $SubItem->main_ic_id == $category->id ? 'selected' : '' }}>
                                                                            {{ $category->main_ic }} </option>
                                                                    @endforeach
                                                                </select>
                                                            </td> --}}
                                                            <td>
                                                                <select name="item_id[]"
                                                                    id="item_id{{$Counter}}" class="form-control select2">
                                                                    <option value="">Select</option>
                                                                    <option value="{{$SubItem->id}}" selected>{{$SubItem->sub_ic}}</option>
                                                                    {{-- @foreach ($subItems as $subitem)
                                                                    <option value="{{ $subitem->id }}" data-uom="{{ $subitem->uomData->uom_name }}" @if($subitem->id == $Fil->sub_item_id) selected @endif>
                                                                    {{ $subitem->sku_code . ' - ' . $subitem->sub_ic }}
                                                                    </option>
                                                                    @endforeach   --}}
                                                                </select><br>
                                                                <button type="button" class="btn btn-xs btn-info" onclick="getSubitem('<?php echo $Counter?>','0')">All</button>
                                                                <button type="button" class="btn btn-xs btn-primary" onclick="getSubitem('<?php echo $Counter?>','<?php echo $SubItem->id?>')">By Default</button>
                                                            </td>
                                                            <td>
                                                                {{-- <input readonly type="text" class="form-control"
                                                                    name="item_code[]" id="item_code{{$Counter}}" value="{{$SubItem->sub_ic}}"> --}}
                                                                    <textarea name="item_desc[]" id="item_desc{{$Counter}}" cols="30" placeholder="remarks" class="form-control" rows="5">{{$Fil->sub_ic_desc}}</textarea>
                                                            </td>
                                                            <td>
                                                                <input readonly type="text" class="form-control"
                                                                    name="uom_id[]" id="uom_id<?php echo $Counter; ?>"
                                                                    value="<?php echo $ItemDetail[0]; ?>">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control requiredField"
                                                                    name="quantity[]" id="quantity<?php echo $Counter; ?>"
                                                                    value="<?php echo $Fil->qty; ?>">
                                                            </td>
                                                            
                                                            <td class="">
                                                                <input readonly type="text" class="form-control"
                                                                    name="closing_stock[]" id="closing_stock{{$Counter}}" value="{{ReuseableCode::get_stock($SubItem->id, '', 0, '')}}">
                                                            </td>
                                                            <td class="">
                                                                <input readonly type="text" class="form-control"
                                                                    name="last_ordered_qty[]" id="last_ordered_qty{{$Counter}}" value="{{($lastGrnRecord)? $lastGrnRecord->rate : '0'}}">
                                                            </td>
                                                            <td class="">
                                                                <input readonly type="text" class="form-control"
                                                                    name="last_received_qty[]"  value="{{($lastGrnRecord)? $lastGrnRecord->qty : '0'}}"
                                                                    id="last_received_qty{{$Counter}}">
                                                            </td>
                                                            <td class="text-center" style="">
                                                                <input
                                                                onclick="view_history(<?php echo $Counter; ?>)" type="checkbox"
                                                                id="view_history<?php echo $Counter; ?>">
                                                                {{-- @if($Counter > 1) --}}
                                                                <button type="button" class="btn btn-xs btn-danger"
                                                                    id="BtnRemove<?php echo $Counter; ?>"
                                                                    onclick="RemoveSection('<?php echo $Counter; ?>')">Remove</button>
                                                                {{-- @endif --}}
                                                            </td>
                                                        </tr>

                                                        <?php
                                                    endforeach;
                                                    ?>
                                                    </tbody>
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th colspan="6" class="text-center">
                                                            </th>
                                                            <th colspan="1" class="text-center">
                                                                <input type="button" class="btn btn-sm btn-primary"
                                                                    onclick="AddMoreDetails()" value="Add More Rows" />
                                                            </th>
                                                            <th class="text-center">
                                                              
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>
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

    <script>
        var Counter = '<?php echo $Counter; ?>';

        function getSubitem(Count,Id)
        {

            if(Id != 0)
            {
                $.ajax({
                    url: '<?php echo url('/')?>/pmfal/get_sub_item_all_ajax',
                    type: "GET",
                    data: {Id:Id},
                    success: function (data) {
                        $('#item_id'+Count ).html(data);
                    }
                });
            }
            else
            {
                $.ajax({
                    url: '<?php echo url('/')?>/pmfal/get_sub_item_all_ajax',
                    type: "GET",
                    data: {Id:Id},
                    success: function (data) {
                        $('#item_id'+Count ).html(data);
                    }
                });
            }
            $('#item_id'+Count ).select2();
        }

        function AddMoreDetails() {
            Counter++;
            // '<td>' +
            // '<input type="text" onchange="get_detail(this.id,' + Counter +
            // ')" class="form-control sam_jass" name="sub_ic_des[]" id="item_' + Counter + '">' +
            // '<input type="hidden" class="requiredField" name="item_id[]" id="sub_' + Counter + '">' +
            // '</td>' +
            $('#AppnedHtml').append(
                '<tr class="RemoveRows' + Counter + ' AutoNo">' +
               ' <td>'+
                '<select onchange="get_item_name('+Counter+')" name="item_id[]" id="item_id'+Counter+'" class="form-control select2">'+
                    '<option value="">Select Item</option>'+
                    '@foreach (CommonHelper::get_all_subitem() as $subitem)'+
                    '<option value="{{ $subitem->id }}" data-uom="{{ $subitem->uomData->uom_name }}">'+
                    '{{ $subitem->item_code . ' - ' . $subitem->sub_ic }}'+
                    '</option>'+
                    '@endforeach'+
                    '</select>'+
               ' </td>'+
               ' <td>'+

               ' <textarea name="item_desc[]" id="item_desc' + Counter + '" cols="30" placeholder="remarks" class="form-control" rows="5"></textarea>'+
               ' </td>'+
                '<td>' +
                '<input readonly type="text" class="form-control" name="uom_id[]" id="uom_id' + Counter + '">' +
                '</td>' +
                '<td>' +
                '<input type="text" class="form-control requiredField" name="quantity[]" id="quantity' + Counter +
                '">' +
                '</td>' +
                '<td>' +
                '<input readonly type="text" class="form-control" name="closing_stock[]" id="closing_stock' + Counter +
                '">' +
                '</td>' +
                '<td>' +
                '<input readonly type="text" class="form-control" name="last_ordered_qty[]" id="last_ordered_qty' +
                Counter + '">' +
                '</td>' +
                '<td>' +
                '<input readonly type="text" class="form-control" name="last_received_qty[]" id="last_received_qty' +
                Counter + '">' +
                '</td>' +
                '<td  class="text-center" style=""><input onclick="view_history('+Counter+')" type="checkbox" id="view_history' +
                Counter + '">' +
                '<button type="button" class="btn btn-xs btn-danger" id="BtnRemove' + Counter +
                '" onclick="RemoveSection(' + Counter + ')">Remove</button>' +
                '</td>' +
                '</tr>' +
                '</tr>' +
                '</tbody>' +
                '</table>');



            $('#category_' + Counter).select2();
            $('#item_id' + Counter).select2();
            var AutoCount = 1;
            $(".AutoCounter").each(function() {
                AutoCount++;
                $(this).html(AutoCount);
            });

            var AutoNo = $(".AutoNo").length;
            $('#span').text(AutoNo);


            $('.sam_jass').bind("enterKey", function(e) {


                $('#items').modal('show');
            });
            $('.sam_jass').keyup(function(e) {
                if (e.keyCode == 13) {
                    selected_id = this.id;
                    $(this).trigger("enterKey");
                }
            });
        }
       
        function RemoveSection(Row) {
            //            alert(Row);
            $('.RemoveRows' + Row).remove();
            $(".AutoCounter").html('');
            var AutoCount = 1;
            $(".AutoCounter").each(function() {
                AutoCount++;
                $(this).html(AutoCount);
            });
            var AutoNo = $(".AutoNo").length;
            $('#span').text(AutoNo);
        }


        function clear_fiel(id) {
            $('#' + id).prop('readonly', false);
            $('#' + id).val('');

        }

        $('.sam_jass').bind("enterKey", function(e) {


            $('#items').modal('show');
            e.preventDefault();

        });
        $('.sam_jass').keyup(function(e) {
            if (e.keyCode == 13) {
                selected_id = this.id;
                $(this).trigger("enterKey");
                e.preventDefault();

            }

        });


        $('.stop').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
        $(function() {



            $(".btn-success").click(function(e) {
                var purchaseRequest = new Array();
                var val;
                //$("input[name='demandsSection[]']").each(function(){
                purchaseRequest.push($(this).val());
                //});
                var _token = $("input[name='_token']").val();
                for (val of purchaseRequest) {
                    jqueryValidationCustom();
                    if (validate == 0) {

                        $('#cashPaymentVoucherForm').submit();
                    } else {
                        return false;
                    }
                }

            });
        });
    </script>


    <script>
        function status(id)
        {
            
            $.ajax({
                url:'{{url("pdc/delete_attachment")}}',
                data:{id:id},
                type:'GET',
                success:function(response)
                {            
                    console.log(response);
                    console.log(id);
                   if(response == id)
                   {
                    $('#r'+id).remove();
                   }else{
                    alert('This attacment not exist in data base');
                   } 

                }
            })
            e.preventDefault();
            return false;  
        }

         function get_item_name(index)
        {
            
            var item=   $('#item_id'+index).val();
         var uom =item.split(','); 

         $('#uom_id'+index).val($('#item_id'+index).find(':selected').data('uom'));
         $('#item_code'+index).val(uom[2]);
         get_detail($('#item_id'+index).find(':selected').data('uom'),index)  
        }
        function get_detail(id,number)
        {
            // var items=$('#'+id).val();
            console.log(id);
            $.ajax({
                url:'{{url("/pdc/get_data")}}',
                data:{item:id},
                type:'GET',
                success:function(response)
                {            
                    console.log(response);    
                    $('#closing_stock'+number).val(response['avialableStock']);
                    $('#last_ordered_qty'+number).val((response['latestGrnData'] != null)? response['latestGrnData']['rate'] : 0);
                    $('#last_received_qty'+number).val((response['latestGrnData'] != null)? response['latestGrnData']['qty'] : 0);
                }
            })
        }
    </script>

    <script>
        function view_history(id) {

            var v= $('#item_id'+id).val();          
            if ($('#view_history' + id).is(":checked"))
            {    
                if (v!='Select')
                {       
                    showDetailModelOneParamerter('pdc/viewHistoryOfItem?id='+v);
                }
            }





        }

        var counter = 1;
  function add()
  {
    counter++;
    var html = ` <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" id="row`+counter+`">
                                <label>&nbsp</label>
                            <div class="input-container">
                            <input class="input-field form-control" type="file" placeholder="Form No " name="file[]"><i class="fa fa-minus icon" onclick="minus(`+counter+`)"></i>
                    </div>        
                </div>`;
         
    $('#form').append(html);

  }
  function minus(number)
  {
    $('#row'+number).remove();
    counter--;
  }

    </script>


    <script type="text/javascript">
        $('.select2').select2();
    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
