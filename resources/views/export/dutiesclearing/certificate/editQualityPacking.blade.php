<?php

    $m =Session::get('run_company');

?>
@extends('layouts.default')

@section('content')
    @include('select2');
    <div class="well_N">
    <div class="dp_sdw">    
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="display: none;">
                      
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="well">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span class="subHeadingLabelClass">Quality Packing Certificate</span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="row">
                                                <form method="POST" action="{{route('updatequalityPacking')}}" >
                                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                  <input type="hidden" name="ex_duities_id" value="{{ $qualityPacking->ex_duities_id }}">
                                                 
                                                  <input type="hidden" name="id" value="{{ $qualityPacking->id }}">
                                                 
                                                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>CERTIFICATE NO. :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="quality_certificate_no" id="quality_certificate_no" value="{{ $qualityPacking->quality_certificate_no ?? '' }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>DATE</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="date" name="quality_date" id="quality_date" value="{{ $qualityPacking->quality_date ?? '' }}" class="form-control requiredField" />
                                                    </div>
                                                </div>
                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label> SHIPPER:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea type="text" name="quality_packing_shipper" class="form-control requiredField">{!! $qualityPacking->quality_packing_shipper !!}</textarea>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>CONSIGNEE :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea type="text" name="quality_packing_consignee" class="form-control requiredField">{!! $qualityPacking->quality_packing_consignee !!}</textarea>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>DESCRIPTION OF GOODS :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea type="text" name="quality_packing_description_of_good"  class="form-control requiredField">{!! $qualityPacking->quality_packing_description_of_good !!}</textarea>
                                                    </div>
                                                 </div>
                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>PACKING :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="quality_packing_packing" value="{{ $qualityPacking->quality_packing_packing }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>ORIGIN :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="quality_packing_origin" value="{{ $qualityPacking->quality_packing_origin }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>DECLARED QUANTITY :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="quality_packing_declared_quality" value="{{ $qualityPacking->quality_packing_declared_quality }}" class="form-control requiredField" />
                                                    </div>
                                                 </div>
                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>VESSEL :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input readonly type="text" name="quality_packing_vessel" value="{{ $qualityPacking->quality_packing_vessel }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>PROT OF LOADING :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input readonly type="text" name="quality_packing_port_of_loading" value="{{ $qualityPacking->quality_packing_port_of_loading }}"  class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>PROT OF LOADING</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input readonly type="text" name="quality_packing_of_discharge" value="{{ $qualityPacking->quality_packing_of_discharge }}" class="form-control requiredField" />
                                                    </div>
                                                 </div>

                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>B/L NO:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="quality_packing_Bl_no" value="{{ $qualityPacking->quality_packing_Bl_no }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>CONTAINER NO :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="quality_packing_container_no" value="{{ $qualityPacking->quality_packing_container_no }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>RESULTS OF INSPECTION
                                                            LOT NO</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="quality_packing_lot_no" value="{{ $qualityPacking->quality_packing_lot_no }}" class="form-control requiredField" />
                                                    </div>
                                                 </div>

                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>WEIGHT:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="quality_packing_weight" value="{{ $qualityPacking->quality_packing_weight }}" class="form-control requiredField" />
                                                    </div>
                                                    
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>DATE OF PRODUCTION</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="date" name="quality_packing_date_of_production" value="{{ $qualityPacking->quality_packing_date_of_production }}" class="form-control requiredField" />
                                                    </div>
                                                 </div>
                                                 <div class="row">
                                                    
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>QUALITY:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea type="text" name="quality_packing_quality" id="quality_packing_quality" class="form-control requiredField">{!! $qualityPacking->quality_packing_quality !!}</textarea>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Production Specification :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea type="text" name="quality_product_specification" id="quality_product_specification" class="form-control requiredField">{!! $qualityPacking->quality_packing_broken !!}</textarea>
                                                    </div>                                                    
                                                 </div>
                                                 <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <label>OTHER DETAILS</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="quality_packing_detail"value="{{ $qualityPacking->quality_packing_detail }}" class="form-control requiredField" />
                                                    </div>

                                                 </div>
                                                </div>
                                                <div>&nbsp;</div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                                    <button type="reset" id="reset" class="btn btn-danger">Clear Form</button>
                                                    <?php
                                                    //echo Form::submit('Click Me!');
                                                    ?>
                                                </div>
                                            </form>
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
    <script src="https://cdn.ckeditor.com/4.8.0/full-all/ckeditor.js"></script>
    <script type="text/javascript">
    CKEDITOR.replace('quality_packing_description_of_good', {
        toolbar: []
    });
    CKEDITOR.replace('quality_packing_consignee', {
        toolbar: []
    });
    CKEDITOR.replace('quality_packing_shipper', {
        toolbar: []
    });
    CKEDITOR.replace('quality_packing_quality', {
        toolbar: []
    });
    CKEDITOR.replace('quality_product_specification', {
        toolbar: []
    });
        // $(document).ready(function() {
        //     $(".btn-success").click(function(e){
        //         var category = new Array();
        //         var val;
        //         //$("input[name='chartofaccountSection[]']").each(function(){
        //         category.push($(this).val());
        //         //});
        //         var _token = $("input[name='_token']").val();
        //         for (val of category) {

        //             jqueryValidationCustom();
        //             if(validate == 0){
        //                 //return false;
        //             }else{
        //                 return false;
        //             }
        //         }
        //     });
        // });
    </script>

    <script type="text/javascript">

        $('.select2').select2();
    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection