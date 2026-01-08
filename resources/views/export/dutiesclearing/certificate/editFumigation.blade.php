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
                                    <span class="subHeadingLabelClass">Fumigation Certificate</span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="row">
                                                <form method="POST" action="{{route('updateFumigation')}}" >
                                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                  <input type="hidden" name="ex_duities_id" value="{{ $fumigation->ex_duities_id }}">
                                                  <input type="hidden" name="id" value="{{ $fumigation->id }}">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                            <label>No. of Bags </label>
                                                            <input type="text" class="form-control" readonly value="{{$fumigation->no_of_bags}}" name="no_bags" id="">
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                            <label>Date:</label>
                                                            <input type="date" class="form-control" value="{{$fumigation->date}}" name="date" id="">
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                            <label>Fumigation Created By :</label>
                                                            <input type="text" class="form-control" value="{{$fumigation->fumigation_created_by}}" name="fumigation_created_by" id="">
                                                        </div>

                                                    </div>
                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="display: none">
                                                        <label>Details:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea rows="5" name="Details" id="Details" class="form-control requiredField" >{{$fumigation->fumigation_text_area}}</textarea>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Chemical Treatment :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea rows="5" name="chemical_treatment" id="chemical_treatment" class="form-control requiredField">{{$fumigation->chemical_treatment}}</textarea>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Chemical & Concentration :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea rows="5" name="chemical_concentration" id="chemical_concentration" class="form-control requiredField">{{$fumigation->chemical_concentration}}</textarea>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Means of Conveyance :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea readonly rows="5" name="conveyance" id="conveyance" class="form-control requiredField">{{$fumigation->mean_of_conveyance}}</textarea>
                                                    </div>
                                                 
                                                 </div>
                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Name & Address of Exporter :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea rows="5" name="name_exporter" id="name_exporter" class="form-control requiredField">{{$fumigation->name_address_expoter}}</textarea>
                                                    </div>
                                                 
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Distinguishing Marks :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea rows="5" name="distinguishing" id="Details" class="form-control requiredField">{{$fumigation->distinguishing_marks}}</textarea>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Name & Address of Consignee :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea rows="5" name="name_of_consignee" id="name_of_consignee" class="form-control requiredField">{{$fumigation->name_address_consignee}}</textarea>
                                                    </div>
                                                    
                                                 </div>
                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Details 1:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
   
                                                  <textarea rows="5" name="details1" id="certified_by_shipper" class="form-control requiredField">
{{$fumigation->details1}}
                                                            
                                                        </textarea>
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Details 2:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea rows="5" name="details2" id="certified_by_shipper" class="form-control requiredField">
{{$fumigation->details2}}                                                           
                                                            
                                                        </textarea>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Origin as certified by Shippers :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea rows="5" name="certified_by_shipper" id="certified_by_shipper" class="form-control requiredField">{{$fumigation->origin_certificate_shippers}}</textarea>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Number & Description of goods :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea rows="5" name="description" id="description_of_" class="form-control requiredField">{{$fumigation->description_of_good}}</textarea>
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
    <script type="text/javascript">
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
<script>
    $(function() {
      CKEDITOR.replace('name_of_consignee', {
              toolbar: []
              // allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height];'
          });
          CKEDITOR.replace('description_of_', {
                toolbar: []
                // allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height];'
            });
        CKEDITOR.replace('name_exporter', {
                toolbar: []
                // allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height];'
            });
        CKEDITOR.replace('distinguishing', {
                toolbar: []
                // allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height];'
            });
        
      });
</script>
    <script type="text/javascript">

        $('.select2').select2();
    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection