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
                                <span class="subHeadingLabelClass">Create Scrap Sale</span>
                            </div>
                        </div> 
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            <form method="post" action="{{ route('scrap_sales.store') }}" id="addSubItemDetail" enctype="multipart/form-data">
                                {{ csrf_field() }}
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label class="sf-label">Select Scrap Declration</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                <select class="form-control requiredField select2" name="sd_id"
                                                    id="sd_id" onchange="GetScrapDeclration()">
                                                    <option value="">Select Scrap Declration</option>
                                                    @foreach ($scrap_declrations as $scrap_declration)
                                                        <option value="{{ $scrap_declration->id }}">{{ strtoupper($scrap_declration->sd_no) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <button type="button"
                                                    onclick="GetScrapDeclration()" class="btn btn-primary" style="margin-top: 33px;">GET</button>
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
                            </form>
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




        let counter = 1;



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

        function GetScrapDeclration() {
            let id = $('#sd_id option:selected').val();

            if(id == ''){
                return false;
            }
            var scrap_id =  $('#scrap_id').val();
            if(scrap_id != undefined && scrap_id == id){
                return false;
            }
            $('#createMaterialFormAjax').html(
                '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div>'
            );
            $.ajax({
                url: '<?php echo url('/'); ?>/purchase/GetScrapDeclration',
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
                    
                }
            });
        }

    </script>
    <script>
        function calc(id) {
            var qty = $('#qty_'+ id).val();
            var rate = $('#rate_'+ id).val();
    
            var total = qty * rate;
    
            if(qty == '' || rate == ''){
                total = 0;
            }
            $('#total_' + id).val(total.toFixed(2))
        }
    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
