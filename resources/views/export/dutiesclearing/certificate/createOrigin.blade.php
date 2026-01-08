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
                                                <form method="POST" action="{{route('OriginStore')}}" >
                                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                  <input type="hidden" name="ex_duities_id" value="{{ $duities_id }}">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Exporter Details:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea class="form-control requiredField" name="exporter_address" id="chemical_treatment" cols="30" rows="5">GARIBSONS (PVT) LTD., C-69/71, 12th COMMERCIAL ST., PHASE –II, EXT, DHA, KARACHI, 75500, PAKISTAN</textarea>
                                                        {{-- <input type="text" name="exporter_name" id="Details" value="" class="form-control requiredField" /> --}}
                                                    </div>
                                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Exporter  Address :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="exporter_address" id="chemical_treatment" value="" class="form-control requiredField" />
                                                    </div> --}}
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Consignee Importer Name :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        {{-- <input type="text" name="importer_name" id="chemical_concentration" value="{{ $exportPakingList->invoice->consigned_deatils }}" class="form-control requiredField" /> --}}
                                                        <textarea type="text" name="importer_address" id="importer_address" class="form-control requiredField" cols="30" rows="5">{{ $exportPakingList->invoice->consigned_deatils }}</textarea>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Particulars of Transport:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea readonly type="text" name="vessel_name" id="certified_by_shipper" class="form-control requiredField" cols="30" rows="4">
                                                            {{  $exportPakingList->invoice->exportOrder->mode_of_transport }} <br><br>
                                                            {{ 'Vessel Name: ' . $exportPakingList->invoice->ship_name }} <br><br>
                                                            {{ 'B/L No. ' . $exportPakingList->invoice->bill_of_loading }} <br><br>
                                                        </textarea>
                                                    </div>
                                                 </div>
                                                 <div class="row">
                                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Consignee Importer Address :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="importer_address" id="name_exporter" value="" class="form-control requiredField" />
                                                    </div> --}}
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Exporter's Membership Number :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input readonly type="text" name="membership_no" id="name_of_consignee" value="9293" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>MARKS & NUMBER:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="marks_no" id="certified_by_shipper" value="{{$exportPakingList->invoice->exportOrder->marking_labeling}}" class="form-control requiredField" />
                                                    </div>
                                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Mode Of Transport :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="mode_of_transport" id="conveyance" value="" class="form-control requiredField" />
                                                    </div> --}}
                                                 </div>
                                                 <div class="row">
                                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>B/L NO. :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="b_l_no" id="Details" value="" class="form-control requiredField" />
                                                    </div> --}}
                                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>VESSEL NAME :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="vessel_name" id="description_of_" value="" class="form-control requiredField" />
                                                    </div> --}}

                                                    
                                                    
                                                 </div>

                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>GROSS WEIGHT :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="gross_weight" id="Details" value="{{ $exportPakingList->packingListData->sum('gross_weight') }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>NETT WEIGHT :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="net_weight" id="description_of_" value="{{ $exportPakingList->packingListData->sum('net_weight') }}" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Other Information:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="country" id="certified_by_shipper" value="WE HEREBY CERTIFY THAT THE GOODS ARE OF PURE PAKISTAN ORIGIN" class="form-control requiredField" />
                                                    </div>
                                                 </div>

                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Name :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="name" id="Details" class="form-control requiredField" value="Fauzi Farooq"/>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>DESIGNATION: </label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="designation" id="description_of_" value="Director" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>COMPANY :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="company" id="certified_by_shipper" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Place :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="place" id="place" value="" class="form-control requiredField" />
                                                    </div>
                                                 </div>
                                                 <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <label>DESCRIPTION OF GOOD  :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea type="text" name="description_of_good_origin" id="description_of_good_origin" class="form-control requiredField">
                                                            {!! $exportPakingList->invoice->exportOrder->quality_remarks !!} <br><br>
                                                            {{ 'PACKED IN ' . $exportPakingList->invoice->invoiceData->exportOrderData->pack_size . ' KG ' . $exportPakingList->invoice->invoiceData->exportOrderData->pack_type }} <br><br>
                                                            {{ 'Port Of Loading ' . $exportPakingList->invoice->exportOrder->port_loading }} <br><br>
                                                            {{ 'Port Of Discharge ' . $exportPakingList->invoice->exportOrder->port_of_discharge }} <br><br>
                                                        </textarea>
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
    CKEDITOR.replace('exporter_address', {
        toolbar: []
    });
    CKEDITOR.replace('importer_address', {
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