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
                                    <span class="subHeadingLabelClass">Origin Certificate</span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="row">
                                                <form method="POST" action="{{route('updateOrigin')}}" >
                                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                  <input type="hidden" name="ex_duities_id" value="{{ $originCertificate->ex_duities_id }}">
                                                  <input type="hidden" name="id" value="{{ $originCertificate->id }}">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                 <div class="row">
                                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Exporter  Name:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="exporter_name" id="Details" value="{{ $originCertificate->exporter_name }}" class="form-control requiredField" />
                                                    </div> --}}
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Exporter  Details :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea type="text" name="exporter_address" id="chemical_treatment" class="form-control requiredField">{{ $originCertificate->exporter_address }}</textarea>
                                                    </div>
                                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Consignee Importer Name :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="importer_name" id="chemical_concentration" value="{{ $originCertificate->consignee_name }}" class="form-control requiredField" />
                                                    </div> --}}
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Consignee Importer Address :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea type="text" name="importer_address" id="name_exporter" value="" class="form-control requiredField">{{ $originCertificate->importer_address }}</textarea>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>VESSEL NAME :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea type="text" name="vessel_name" id="certified_by_shipper" value="" class="form-control requiredField">{{ $originCertificate->shiper_name }}</textarea>
                                                    </div>
                                                 </div>
                                                 <div class="row">
                                                    
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Exporter's Membership Number :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="membership_no" id="name_of_consignee" value="{{ $originCertificate->exporter_membership_no }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>MARKS & NUMBER:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="marks_no" id="certified_by_shipper" value="{{ $originCertificate->marks_number }}" class="form-control requiredField" />
                                                    </div>
                                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Mode Of Transport :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="mode_of_transport" id="conveyance" value="{{ $originCertificate->mode_transport }}" class="form-control requiredField" />
                                                    </div> --}}
                                                 </div>
                                                 <div class="row">
                                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>B/L NO. :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="b_l_no" id="Details" value="{{ $originCertificate->bl_no_date }}" class="form-control requiredField" />
                                                    </div> --}}
                                                   
                                                    
                                                 </div>

                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>GROSS WEIGHT :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="gross_weight" id="Details" value="{{ $originCertificate->gross_weight }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>NETT WEIGHT :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="net_weight" id="description_of_" value="{{ $originCertificate->neight_weight }}" class="form-control requiredField" />
                                                    </div>
                                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>COUNTRY OF ORIGIN:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="country" id="certified_by_shipper" value="{{ $originCertificate->country_origin }}" class="form-control requiredField" />
                                                    </div> --}}
                                                 </div>

                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Name :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="name" id="Details" value="{{ $originCertificate->name_origin }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>DESIGNATION: </label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="designation" id="description_of_" value="{{ $originCertificate->designation_origin }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>COMPANY :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="company" id="certified_by_shipper" value="{{ $originCertificate->company }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Place :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="place" id="place" value="{{ $originCertificate->place }}" class="form-control requiredField" />
                                                    </div>
                                                 </div>
                                                 <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <label>DESCRIPTION OF GOOD  :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea type="text" name="description_of_good_origin" id="description_of_good_origin" class="form-control requiredField">{{ $originCertificate->description_of_good_origin }}</textarea>
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
    CKEDITOR.replace('description_of_good_origin', {
        toolbar: []
    });
    CKEDITOR.replace('chemical_treatment', {
        toolbar: []
    });
    CKEDITOR.replace('name_exporter', {
        toolbar: []
    });
    CKEDITOR.replace('certified_by_shipper', {
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