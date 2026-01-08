<?php

$m = Session::get('run_company');
use App\Helpers\PurchaseHelper;
use App\Helpers\CommonHelper;
use App\Helpers\NotificationHelper;
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
            display: -ms-flexbox;
            /* IE10 */
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
    
    $str = DB::Connection('mysql2')->selectOne('select max(convert(substr(`demand_no`,6,length(substr(`demand_no`,6))-4),signed integer)) reg from `demand` where substr(`demand_no`,-4,2) = ' . date('m') . ' and substr(`demand_no`,-2,2) = ' . date('y') . '')->reg;
    
    $demand_no = 'pr-g-' . ($str + 1) . date('my');
    ?>

    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well_N">
                    <div class="dp_sdw">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span class="subHeadingLabelClass">Create Purchase Request Form</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            <?php echo Form::open(['url' => 'pad/addDemandDetail?m=' . $m . '', 'id' => 'cashPaymentVoucherForm', 'class' => 'stop', 'enctype' => 'multipart/form-data']); ?>

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="pageType" value="<?php echo $_GET['pageType']; ?>">
                            <input type="hidden" name="parentCode" value="<?php echo $_GET['parentCode']; ?>">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="hidden" name="demandsSection[]"
                                                    class="form-control requiredField" id="demandsSection" value="1" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="row">

                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 hide">
                                                        <label class="sf-label">PR NO. <span
                                                                class="rflabelsteric"><strong>*</strong></span></label>
                                                        <input readonly type="text" class="form-control requiredField"
                                                            placeholder="" name="pr_no" id="pr_no"
                                                            value="{{ strtoupper($demand_no) }}" />
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class="sf-label">PR Date.</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="date" class="form-control requiredField"
                                                            max="<?php echo date('Y-m-d'); ?>" name="demand_date_1"
                                                            id="demand_date_1" value="<?php echo date('Y-m-d'); ?>" />
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class="sf-label">Ref No. <span class="rflabelsteric"></label>
                                                        <input autofocus type="text" class="form-control"
                                                            placeholder="Ref  No" name="slip_no_1" id="slip_no_1"
                                                            value="" />
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="sf-label">Department / Sub Department</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <select class="form-control requiredField select2"
                                                            name="sub_department_id_1" id="sub_department_id_1">
                                                            <option value="">Select Department</option>
                                                            @foreach ($subDepartmentList as $key => $y2)
                                                                {{-- <optgroup label="{{ $y->department_name }}"
                                                                    value="{{ $y->id }}">
                                                                   
                                                                   // $subdepartments = DB::select('select `id`,`sub_department_name` from `sub_department` where `department_id` =' . $y->id . ' AND where id IN '.[$department_id].'');
                                                                  
                                                                    @foreach ($subdepartments as $key2 => $y2) --}}
                                                                        <option value="{{ $y2->id }}">
                                                                            {{ $y2->sub_department_name }}</option>
                                                                    {{-- @endforeach
                                                                </optgroup> --}}
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="sf-label">Mode Type</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <select class="form-control requiredField select2" name="mode_type"
                                                            id="mode_type">
                                                            <option value="">Select Mode</option>
                                                            <option value="1">Urgent</option>
                                                            <option value="2">Normal</option>
                                                            <option value="3">MOST URGENT</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="demand_type" id="demand_type">
                                                <div class="row" id="form">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="sf-label">Select Company Location</label>
                                                        <select class="form-control requiredField select2"
                                                            name="company_location_id" id="company_location_id">
                                                            <option value="">Select Location</option>
                                                            @foreach ($company_locations as $company_location)
                                                                <option value="{{ $company_location['id'] }}">
                                                                    {{ $company_location['location_name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <label for="">Attachemnt file</label>
                                                        <div class="input-container">
                                                            <input class="input-field form-control" type="file"
                                                                name="file[]"><i class="fa fa-plus icon"
                                                                onclick="add()"></i>
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
                                                            class="form-control requiredField"></textarea>
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
                                                                <th colspan="6" class="text-center">Purchase Request
                                                                    Detail</th>

                                                                <th colspan="2" class="text-center">
                                                                    <span class="badge badge-success"
                                                                        id="span">1</span>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                {{-- <th style="" class="text-center">Category</th> --}}
                                                                <th class="text-center">Item Code</th>
                                                                <th style="width: 250px" class="text-center">Remarks
                                                                </th>
                                                                <th style="width: 100px" class="text-center">UOM<span
                                                                        class="rflabelsteric"><strong>*</strong></span>
                                                                </th>
                                                                <th style="width: 130px" class="text-center">QTY<span
                                                                        class="rflabelsteric"><strong>*</strong></span>
                                                                </th>
                                                                <th style="width: 130px" class="text-center">Closing
                                                                    Stock<span
                                                                        class="rflabelsteric"><strong>*</strong></span>
                                                                </th>
                                                                <th style="width: 130px" class="text-center">Last Rate
                                                                </th>
                                                                <th style="width: 130px" class="text-center">Last Received
                                                                    QTY</th>
                                                                <th style="width: 100px" class="text-center">History</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="AppnedHtml">
                                                            <tr id="" class="AutoNo">
                                                               
                                                                <td>
                                                                    <select onchange="get_item_name(1)" name="item_id[]"
                                                                        id="item_id1" class="form-control select2">
                                                                        <option value="">Select Item</option>
                                                                       
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    {{-- <input readonly type="text" class="form-control"
                                                                        name="item_code[]" id="item_code1"> --}}

                                                                    <textarea name="item_desc[]" id="item_desc1" cols="30" placeholder="remarks" class="form-control"
                                                                        rows="5"></textarea>
                                                                </td>
                                                                <td>
                                                                    <input readonly type="text" class="form-control"
                                                                        name="uom_id[]" id="uom_id1">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        class="form-control requiredField"
                                                                        name="quantity[]" id="quantity1">
                                                                </td>
                                                                <td class="">
                                                                    <input readonly type="text" class="form-control"
                                                                        name="closing_stock[]" id="closing_stock1">
                                                                </td>
                                                                <td class="">
                                                                    <input readonly type="text" class="form-control"
                                                                        name="last_ordered_qty[]" id="last_ordered_qty1">
                                                                </td>
                                                                <td class="">
                                                                    <input readonly type="text" class="form-control"
                                                                        name="last_received_qty[]"
                                                                        id="last_received_qty1">
                                                                </td>
                                                                <td class="text-center" style=""><input
                                                                        onclick="view_history(1)" type="checkbox"
                                                                        id="view_history1"></td>
                                                            </tr>
                                                        </tbody>
                                                        <thead>
                                                            <tr class="text-center">
                                                                <th colspan="6" class="text-center">
                                                                </th>
                                                                <th colspan="2" class="text-center">
                                                                    <input type="button" class="btn btn-sm btn-primary"
                                                                        onclick="AddMoreDetails()"
                                                                        value="Add More Rows" />
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
    </div>

    <script>
        $(function() {
            $('.select2').select2();
            getAjaxItemList('#item_id1');
            
        });
        var Counter = 1;

        function AddMoreDetails() {
            Counter++;
            var category = 'category_id' + Counter;
            $('#AppnedHtml').append(
                '<tr class="RemoveRows' + Counter + '  AutoNo">' +
                '<td>' +
                '<select onchange="get_item_name(' + Counter + ')" name="item_id[]" id="item_id' + Counter +
                '" class="form-control select2">' +
                '<option value="">Select Item</option>' +
               
                '</select>' +
                '</td>' +
                ' <td>' +
                '<textarea name="item_desc[]" id="item_desc' + Counter +
                '" cols="30" class="form-control" placeholder="Remarks" rows="5"></textarea></td>' +
                '<td>' +
                '<input readonly type="text" class="form-control" name="uom_id[]" id="uom_id' + Counter + '">' +
                '</td>' +
                '<td>' +
                '<input type="text" class="form-control requiredField" name="quantity[]" id="quantity' + Counter +
                '">' +
                '</td>' +
                '<td class="">' +
                '<input readonly type="text" class="form-control" name="closing_stock[]" id="closing_stock' + Counter +
                '">' +
                '</td>' +
                '<td class="">' +
                '<input readonly type="text" class="form-control" name="last_ordered_qty[]" id="last_ordered_qty' +
                Counter + '">' +
                '</td>' +
                '<td class="">' +
                '<input readonly type="text" class="form-control" name="last_received_qty[]" id="last_received_qty' +
                Counter + '">' +
                '</td>' +
                '<td  class="text-center" style=""><input onclick="view_history(' + Counter +
                ')" type="checkbox" id="view_history' + Counter + '">' +
                '<button type="button" class="btn btn-xs btn-danger" id="BtnRemove' + Counter +
                '" onclick="RemoveSection(' + Counter + ')">Remove</button>' +
                '</td>' +
                '</tr>' +
                '</tr>' +
                '</tbody>' +
                '</table>');
            var AutoNo = $(".AutoNo").length;
            $('#span').text(AutoNo);


            $('#category_id' + Counter).select2();
            $('#item_id' + Counter).select2();
            getAjaxItemList('#item_id' + Counter);
            var AutoCount = 1;
            $(".AutoCounter").each(function() {
                AutoCount++;
                $(this).html(AutoCount);
            });
        }

        function RemoveSection(Row) {
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



        var counter = 0;

        function add() {


            counter++;
            var html = ` <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" id="row` + counter +
                `">
                            <label>&nbsp</label>
                        <div class="input-container">
                        <input class="input-field form-control" type="file" placeholder="Form No " name="file[]"><i class="fa fa-minus icon" onclick="minus(` +
                counter + `)"></i>
                </div>
            </div>`;

            $('#form').append(html);

        }

        function minus(number) {
            $('#row' + number).remove();
            counter--;
        }


        function get_detail(id, number) {
            // var items=$('#'+id).val();
            console.log(id);
            $.ajax({
                url: '{{ url('/pdc/get_data') }}',
                data: {
                    item: id
                },
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    $('#closing_stock' + number).val(response['avialableStock']);
                    $('#last_ordered_qty' + number).val((response['latestGrnData'] != null) ? response[
                        'latestGrnData']['rate'] : 0);
                    $('#last_received_qty' + number).val((response['latestGrnData'] != null) ? response[
                        'latestGrnData']['qty'] : 0);
                }
            })
        }

        function view_history(id) {
            var v = $('#item_id' + id).val();
            if ($('#view_history' + id).is(":checked")) {
                if (v != 'Select') {
                    showDetailModelOneParamerter('pdc/viewHistoryOfItem?id=' + v);
                }
            }
        }

       


        function get_item_name(index) {

            var item = $('#item_id' + index).val();
            var uom = item.split('%');

            // $('#uom_id' + index).val($('#item_id' + index).find(':selected').data('uom'));
            $('#uom_id' + index).val(uom[1]);
            get_detail($('#item_id' + index).find(':selected').val(), index)
        }
    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
