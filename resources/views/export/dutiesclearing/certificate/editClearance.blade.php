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
                                    <span class="subHeadingLabelClass">Clearance Certificate</span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="row">
                                                <form method="POST" action="{{route('updateclearance')}}" >
                                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                  <input type="hidden" name="ex_duities_id" value="{{ $clearance->ex_duities_id }}">
                                                  <input type="hidden" name="id" value="{{ $clearance->id }}">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                 <div class="row">
                                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>INVOICE:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="invoice_no" id="invoice_no" value="{{ $clearance->invoice_no }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>INVOICE DATE :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="date" name="invoice_date" id="chemical_treatment" value="{{ $clearance->invoice_date }}" class="form-control requiredField" />
                                                    </div> --}}
                                                    
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>CERTIFICATE NO :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="clearance_certificate_no" id="chemical_treatment" value="{{ $clearance->clearance_certificate_no }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>CERTIFICATE Date :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="date" name="invoice_date" id="invoice_date" value="{{ $clearance->invoice_date }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>CONTAINER NUMBERS:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="container_no" id="conveyance" value="{{ $clearance->container_no }}" class="form-control requiredField" />
                                                    </div>
                                                 </div>
                                                 <div class="row">
                                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>VESSEL'S NAME</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="vessel_name" id="name_exporter" value="{{ $clearance->vessel_name }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>PORT OF LOADING:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="port_of_loading" id="name_of_consignee" value="{{ $clearance->port_of_loading }}" class="form-control requiredField" />
                                                    </div> --}}
                                                    
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                        <label>HEALTH:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="health" id="certified_by_shipper" value="{{ $clearance->health }}" class="form-control requiredField" />
                                                    </div>
                                                 </div>
                                                 <div class="row">
                                                   
                                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>PORT OF DISCHARGE:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="port_of_discharge" id="Details" value="{{ $clearance->port_of_discharge }}" class="form-control requiredField" />
                                                    </div> --}}
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <label>DESCRIPTION OF GOODS:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea name="description_og_good" id="description_og_good" class="form-control requiredField">{{ $clearance->description_og_good }}</textarea>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <label>CONSIGNEE:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea name="consignee" id="chemical_concentration" class="form-control requiredField">{{ $clearance->consignee }}</textarea>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <label>CONSIGNEE:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea name="specification" id="specification" class="form-control requiredField">{{ $clearance->specification }}</textarea>
                                                    </div>
                                                 </div>

                                                 {{-- <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Lead:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="lead" id="Details" value="{{ $clearance->lead }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Arsenic:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="arsenic" id="description_of_" value="{{ $clearance->arsenic }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Cadmium:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="cadmium" id="certified_by_shipper" value="{{ $clearance->cadmium }}" class="form-control requiredField" />
                                                    </div>
                                                 </div>

                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Mercury:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="mercury" id="Details" value="{{ $clearance->mercury }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Mercury Organic Pesticides:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="mercury_organic_pesticides" id="description_of_" value="{{ $clearance->mercury_organic_pesticides }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Hexachlorocy:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="hexachlorocy" id="certified_by_shipper" value="{{ $clearance->hexachlorocy }}" class="form-control requiredField" />
                                                    </div>
                                                 </div>

                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>4,4'-DDT:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="ddt_4_4" id="Details" value="{{ $clearance->ddt_4_4 }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>2,4-D:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="d_2_4" id="description_of_" value="{{ $clearance->d_2_4 }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>2,4'-DDT:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="ddt_2_4" id="certified_by_shipper" value="{{ $clearance->ddt_2_4 }}" class="form-control requiredField" />
                                                    </div>
                                                 </div>


                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>4,4'-DDE:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="dde_4_4" id="Details" value="{{ $clearance->dde_4_4 }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>2,4'-DDE:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="dde_2_4" id="description_of_" value="{{ $clearance->dde_2_4 }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>4,4'-DDD:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="ddd_4_4" id="certified_by_shipper" value="{{ $clearance->ddd_4_4 }}" class="form-control requiredField" />
                                                    </div>
                                                 </div>


                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Aflatoxin B1:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="aflatoxin_B1" id="Details"  value="{{ $clearance->aflatoxin_B1 }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Aflatoxin B2:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="aflatoxin_B2" id="description_of_" value="{{ $clearance->aflatoxin_B2 }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Aflatoxin G1:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="aflatoxin_G1" id="certified_by_shipper" value="{{ $clearance->aflatoxin_G1 }}" class="form-control requiredField" />
                                                    </div>
                                                 </div>

                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Aflatoxin G2:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="aflatoxin_G2" id="Details" value="{{ $clearance->aflatoxin_G2 }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Orchratoxin A:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="orchratoxin_a" id="description_of_" value="{{ $clearance->orchratoxin_a }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>T-2 Toxins:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="t_2_toxins" id="certified_by_shipper" value="{{ $clearance->t_2_toxins }}" class="form-control requiredField" />
                                                    </div>
                                                 </div> --}}
                                                 <div class="row">
                                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>TOTAL WEIGHT:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="total_weight" id="description_of_" value="{{ $clearance->total_weight }}" class="form-control requiredField" />
                                                    </div>
                                                     --}}
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
        $(document).ready(function() {
            CKEDITOR.replace('description_og_good', {
                toolbar: [],
            });
            CKEDITOR.replace('chemical_concentration', {
                toolbar: [],
            });
            CKEDITOR.replace('specification', {
                // toolbar: [],
                height: 500,
            });
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
        });
    </script>

    <script type="text/javascript">

        $('.select2').select2();
    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection