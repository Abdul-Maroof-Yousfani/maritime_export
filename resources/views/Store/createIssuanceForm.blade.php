<?php
$m = Session::get('run_company');
use App\Helpers\StoreHelper;
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
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

    <?php
    // $wo = StoreHelper::unique_for_is(date('y'), date('m'));
    ?>
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
                                <span class="subHeadingLabelClass">Create Issuance Form</span>
                            </div>
                        </div> 
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            {{ Form::open(['url' => 'stad/addIssuanceDetail?m=' . $m . '', 'id' => 'cashPaymentVoucherForm', 'class' => 'stop']) }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label class="sf-label">Select Material Request</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                <select class="form-control requiredField select2" name="mr_id"
                                                    id="mr_id" onchange="createMaterialFormAjax()">
                                                    <option value="">Select Material Request</option>
                                                    @foreach ($material_requests as $material_request)
                                                        <option value="{{ $material_request->id }}">{{ strtoupper($material_request->mr_no) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <button type="button"
                                                    onclick="createMaterialFormAjax()" style="margin-top: 35px;">GET</button>
                                            </div>
                                        </div>
                                        <div class="lineHeight">&nbsp;</div>
                                        <div id="createMaterialFormAjax"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="demandsSection"></div>
                            <div class="row">
                               
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
        // $(function () {
        //     getAjaxItemList('.item_id');
        // });




       

        function itemChange(id) {
            // alert($('#item_id'+id).find(':selected').data('uom'));
            // return;
            var item = $('#item_id' + id).find(':selected').text()
            data = item.split('%');
            $('#uom' + id).val(data[1]);
        }

        function rowRemove(id) {
            $('#AppnedHtml' + id).remove()
        }

        function getStock(number) {
            var warehouse = $('#warehouse_id' + number).val();
            var item = $('#item_id' + number).val();

            var batch_code = 0;
            $.ajax({
                url: '<?php echo url('/'); ?>/pdc/get_stock_location_wise?batch_code=0',
                type: "GET",
                data: {
                    warehouse: warehouse,
                    item: item
                },
                success: function(data) {
                    $('#batch_code' + number).html('<option  value="0">0</option>');
                    data = data.split('/');
                    console.log(data);
                    $('#instock' + number).val(data[0]);
                    console.log(data);
                    $("#qty" + number).val(0);
                    if (data[0] == 0) {
                        $("#item_id" + number).css("background-color", "red");
                    } else {
                        $("#item_id" + number).css("background-color", "");
                    }
                }
            });


        }

        function get_stock_qty(number) {
            var warehouse = $('#warehouse_id' + number).val();
            var item = $('#item_id' + number).val();
            var batch_code = $('#batch_code' + number).val();

            $.ajax({
                url: '<?php echo url('/'); ?>/pdc/get_stock_location_wise?batch_code=' + batch_code,
                type: "GET",
                data: {
                    warehouse: warehouse,
                    item: item,
                    batch_code: batch_code
                },
                success: function(data) {
                    data = data.split('/');
                    console.log(data);
                    $('#instock' + number).val(data[0]);
                    console.log(data);
                    $("#qty" + number).val(0);
                    if (data[0] == 0) {
                        $("#item_id" + number).css("background-color", "red");
                    } else {
                        $("#item_id" + number).css("background-color", "");
                    }
                }
            });
        }
        $(document).ready(function() {
            $(".btn-success").click(function(e) {

                //alert();
                var purchaseRequest = new Array();
                var val;
                //$("input[name='demandsSection[]']").each(function(){
                purchaseRequest.push($(this).val());



                //});
                var _token = $("input[name='_token']").val();
                for (val of purchaseRequest) {
                    jqueryValidationCustom();
                    if (validate == 0) {
                        //alert(response);
                    } else {
                        return false;
                    }
                }

            });
        });

        function createMaterialFormAjax() {
            let id = $('#mr_id').val();

            if(id == ''){
                return false;
            }
            var material_id =  $('#material_id').val();
            if(material_id != undefined && material_id == id){
                return false;
            }
            $('#createMaterialFormAjax').html(
                '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div>'
            );
            $.ajax({
                url: '<?php echo url('/'); ?>/store/GetIssuanceForm',
                method: 'GET',
                data: {
                    id: id
                },
                error: function() {
                    alert('error');
                },
                success: function(response) {
                    $('#createMaterialFormAjax').html(response);
                    $('.select2').select2();
                    getAjaxItemList('.item_id');
                    
                }
            });
        }

    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
