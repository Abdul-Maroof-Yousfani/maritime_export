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
                                    <span class="subHeadingLabelClass">Quality Declaration Certificate</span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="row">
                                                <form method="POST" action="{{route('qualityDeclearationStore')}}" >
                                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                  <input type="hidden" name="ex_duities_id" value="{{ $duities_id }}">
                                                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                 <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <label>CERTIFICATE NO:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="certificate_no" id="Details" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <label>CERTIFICATE DATE:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="date" name="certificate_date" id="certificate_date" value="{{date('Y-m-d')}}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <label>VESSEL NAME:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="qulity_decleartion_shiper_name" id="Details" value="{{$exportPakingList->ship_name}}" readonly class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <label>BILL OF LADING NO:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="bill_of_lading" id="chemical_treatment" value="{{$billOfLading->voucher_no??''}}" readonly class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <label>SHIPPER:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea name="qulity_decleartion_shipper" id="qulity_decleartion_shipper" class="form-control requiredField">GARIBSONS (PVT) LTD., C-69/71, 12th COMMERCIAL ST., PHASE –II, EXT, DHA, KARACHI, 75500, PAKISTAN</textarea>
                                                    </div>
                                                    {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <label>CONTAINER NUMBERS:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="qulity_decleartion_container_no" id="name_of_consignee" value="" class="form-control requiredField" />
                                                    </div>
                                                    
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <label>NUMBER BAGS:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="qulity_decleartion_number_of_bags" id="Details" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <label>NETT WEIGHT:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="qulity_decleartion_net_weight" id="description_of_" value="" class="form-control requiredField" />
                                                    </div> --}}
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <label>CONSIGNEE:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea type="text" name="qulity_decleartion_consignee" id="qulity_decleartion_consignee" class="form-control requiredField">{!!$exportPakingList->consigned_deatils!!}</textarea>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <label>Description of Goods:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea type="text" name="description_of_goods" id="description_of_goods" class="form-control requiredField">{!!$exportPakingList->quality_remarks!!} <br><br>{!!$exportPakingList->product_specification!!}</textarea>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <label>Other Details:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea type="text" name="other_detail" id="other_detail" class="form-control requiredField">WE CERTIFY THAT THE GOODS ARE FIT FOR HUMAN CONSUMPTION. 
                                                            RICE WERE MILLED ON __________ AND RECOMMEND USE BEST BEFORE. RICE IS PRODUCED WITHIN EU QUALITY SPECIFICATION AND REQUIREMENT.
                                                            </textarea>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <label>Other Details:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea type="text" name="other_detail_2" id="other_detail_2" class="form-control requiredField">WITH REFERENCE TO ABOVE WE HEREBY CONFIRM THAT RICE IS MILLED FROM NON GMO PADDY AND IS FIT FOR IMMEDIATE HUMAN CONSUMPTION WITH BEST BEFORE DATE, IF PROPERLY STORED, TO BE ____________.THE RICE IS LODADED INTO CLEAN, DAY CONTAINER FIT FOR TRANSPORTATION OF RICE.</textarea>
                                                    </div>
                                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>BROKEN KERNELS:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="broken_grain" id="certified_by_shipper" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>CONTRASTING VARIETIES:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="contaating_varieties" id="Details" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>FOREIGN GRAINS:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="foreign_garin" id="description_of_" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>FOREIGN MATTER:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="foreign_matter" id="certified_by_shipper" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>UNDERMILLED/RED STRIPED:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="undermilled_red_striped" id="Details" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>PADDY (GRAIN PER 01KG):</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="paddy_grain" id="description_of_" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>DAMAGED/DISCOLOURED KERNELS:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="damaged_discolour" id="certified_by_shipper" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>CHALKY KERNELS:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="chalky_kernal" id="Details" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>MOISTURE:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="moisture" id="description_of_" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>AVERAGE GRAIN LENGTH:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="averga_origin_length" id="certified_by_shipper" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>CROP:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="crop" id="Details" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>CADMIMUM (cd):</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="cadmimum" id="description_of_" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>WHITENESS :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="whitness" id="certified_by_shipper" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>ARSEN (as):</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="arsen" id="Details" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>ZINC (zn):</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="zinc" id="description_of_" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Hg:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="hg" id="certified_by_shipper" value="" class="form-control requiredField" />
                                                    </div> --}}
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
    <script type="text/javascript">

    $(function(){
        CKEDITOR.replace('qulity_decleartion_consignee',{
            toolbar:[]
        });
        CKEDITOR.replace('description_of_goods',{
            toolbar:[]
        });
        CKEDITOR.replace('other_detail',{
            toolbar:[]
        });
        CKEDITOR.replace('qulity_decleartion_shipper',{
            toolbar:[]
        });
        CKEDITOR.replace('other_detail_2',{
            toolbar:[]
        });
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