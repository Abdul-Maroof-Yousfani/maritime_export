<?php

    $m =Session::get('run_company');
    use App\Models\ModeOfTransport;

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
                                    <span class="subHeadingLabelClass">Fumigation Certificate </span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel">

                                        <div class="panel-body">
                                            <div class="row">
                                                <form method="POST" action="{{route('createFumigationStore')}}" >
                                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                  <input type="hidden" name="ex_duities_id" value="{{ $duities_id }}">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                            <label>No. of Bags </label>
                                                            <input type="text" class="form-control" readonly value="{{$export_order_data->total_qty}}" name="no_bags" id="">
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                            <label>Date:</label>
                                                            <input type="date" class="form-control" value="" name="date" id="">
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                            <label>Fumigation By :</label>
                                                            <input type="text" class="form-control" value="" name="fumigation_created_by" id="">
                                                        </div>

                                                    </div>
                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style=" display:none">
                                                        <label>Details:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text"  name="Details" id="Details" value="{{$export_order_data->commercial_invoice_no}}" class="form-control requiredField">
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Chemical Treatment :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea rows="5" name="chemical_treatment" id="chemical_treatment" class="form-control requiredField">TREATMENT AGAINST INSECTS & PESTS
                                                        </textarea>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Chemical & Concentration :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea rows="5" name="chemical_concentration" id="chemical_concentration" class="form-control requiredField">3 TABLETS PER M3 OF ALUMINIUM PHOSPHIDE</textarea>
                                                    </div>
                                                    
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Means of Conveyance :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea readonly rows="5" name="conveyance" id="conveyance" class="form-control requiredField">
By
@if(!empty($export_order_data->mode_transport))
{{ModeOfTransport::find($export_order_data->mode_transport)->name}} <br>
@endif 
Vessel Name : {{$export_order_data->ship_name}} <br>
BL No  :{{$export_order_data->bill_of_loading}} 
                                                      
                                                        </textarea>
                                                    </div>
                                                    
                                                 </div>
                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Name & Address of Exporter :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea rows="5" name="name_exporter" id="name_exporter" class="form-control requiredField">GARIBSONS (PVT) LTD C-69/71, 12TH COMMERCIAL ST.PH-II, EXT DHA KARACHI 755500, PAKISTAN PH: 9221-111427421 FAX: 9221-111427422
                                                        </textarea>
                                                    </div>
                                                
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Distinguishing Marks :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea rows="5" name="distinguishing" id="distinguishing" class="form-control requiredField">
                                                            {{$export_order_data->marking_labeling}}
                                                            <br>
Port Of Loading : {{$export_order_data->port_loading}}
<br>
Post Of Discharge : {{$export_order_data->port_of_discharge}}
                                                        </textarea>
                                                    </div>
                                                    <div   class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Name & Address of Consignee :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea  rows="5" name="name_of_consignee" id="name_of_consignee" class="form-control requiredField">
                                                            {{$export_order_data->consignee}}
                                                        </textarea>
                                                    </div>
                                                 </div>
                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Details 1:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea rows="5" name="details1" id="certified_by_shipper" class="form-control requiredField">THIS IS TO CERTIFY THAT THE GOODS AND PACKING ARE FREE FROM INSECTS AND PESTS.
                                                            
                                                        </textarea>
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Details 2:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea rows="5" name="details2" id="certified_by_shipper" class="form-control requiredField">This certificate applies only to injurious insects/diseases which are readily capable of detection at the time of Shipment. No Liability shall attach to the________________ or any representative with respect of this CERTIFICATE. 
                                                            
                                                            
                                                        </textarea>
                                                    </div>
                                                 
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Origin as certified by Shippers :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea rows="5" name="certified_by_shipper" id="certified_by_shipper" class="form-control requiredField">Pakistan
                                                        </textarea>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Number & Description of goods :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <textarea rows="5" name="description" id="description_of_" class="form-control requiredField">
{{$export_order_data->total_qty.' Bags, '.$exportPakingList->packingListData->where('status', 1)->sum('net_weight').' M.Ton'}} <br>
{{$export_order_data->quality_remarks}}
{{-- {{$export_order_data->product_specification}} --}}
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

    <script type="text/javascript">

        $('.select2').select2();
    </script>
<script>
      $(function() {
        CKEDITOR.replace('name_of_consignee', {
                toolbar: []
                // allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height];'
            });
        CKEDITOR.replace('conveyance', {
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
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection