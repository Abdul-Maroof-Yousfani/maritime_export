<?php

$m = Session::get('run_company');

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
                                                    <form method="POST" action="{{ route('clearanceStore') }}">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="ex_duities_id"
                                                            value="{{ $duities_id }}">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="row">
                                                                {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>INVOICE:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="invoice_no" id="invoice_no" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>INVOICE DATE :</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="date" name="invoice_date" id="chemical_treatment" value="" class="form-control requiredField" />
                                                    </div> --}}

                                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <label>CERTIFICATE NO :</label>
                                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                                    <input type="text" name="clearance_certificate_no"
                                                                        id="chemical_treatment" value=""
                                                                        class="form-control requiredField" />
                                                                </div>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <label>CERTIFICATE DATE :</label>
                                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                                    <input type="date" name="invoice_date"
                                                                        id="clearance_certificate_date"
                                                                        value="{{ date('Y-m-d') }}"
                                                                        class="form-control requiredField" />
                                                                </div>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <label>CONTAINER NO :</label>
                                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                                    @php
                                                                        $container_nos = '';
                                                                        // dd($exportPakingList->packingListData);
                                                                    @endphp
                                                                    @if (isset($exportPakingList->packingListData))
                                                                        @foreach ($exportPakingList->packingListData as $container)
                                                                            @php
                                                                                $container_nos .= $container->container . ', ';
                                                                            @endphp
                                                                        @endforeach
                                                                    @endif
                                                                    <input type="text" name="container_no"
                                                                        id="container_no" value="{{ $container_nos }}"
                                                                        class="form-control requiredField" />
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>TOTAL WEIGHT:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="total_weight" id="description_of_" value="" class="form-control requiredField" />
                                                    </div> --}}
                                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                                    <label>HEALTH:</label>
                                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                                    <input type="text" name="health" id="health"
                                                                        value="THIS IS TO CERTIFY THAT THE SAMPLE IS FREE FROM SELECTED HEAVY METALS, PESTICIDES, RADIOACTIVITY AND GMO"
                                                                        class="form-control requiredField" />
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>VESSEL'S NAME</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="vessel_name" id="name_exporter" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>PORT OF LOADING:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="port_of_loading" id="name_of_consignee" value="" class="form-control requiredField" />
                                                    </div> --}}
                                                                {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>CONTAINER NUMBERS:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="container_no" id="conveyance" value="" class="form-control requiredField" />
                                                    </div> --}}

                                                            </div>
                                                            <div class="row">
                                                                {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>PORT OF DISCHARGE:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="description_og_good" id="Details" value="" class="form-control requiredField" />
                                                    </div> --}}
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                                    <label>DESCRIPTION OF GOODS:</label>
                                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                                    <textarea type="text" name="description_og_good" id="description_og_good" value=""
                                                                        class="form-control requiredField">{{ $exportPakingList->invoice->exportOrder->quality_remarks }}</textarea>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                                    <label>CONSIGNEE:</label>
                                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                                    <textarea type="text" name="consignee" id="chemical_concentration" value="" class="form-control requiredField">{{ $exportPakingList->invoice->exportOrder->consignee }}</textarea>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                    <label>Specifications:</label>
                                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                                    <textarea type="text" name="specification" id="specification" value="" class="form-control requiredField">
                                                                        <table border="1" cellpadding="1" cellspacing="1" style="width:500px">
                                                            <tbody>
                                                                <tr>
                                                                    <td><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">SPECIFICATION</span></span></strong></td>
                                                                    <td><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">TEST PARAMETERS</span></span></strong></td>
                                                                    <td><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">MAX DETECTION LIMITED</span></span></strong></td>
                                                                    <td><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">UNIT</span></span></strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="1" rowspan="5"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Heavy Metal</span></span></strong></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Lead</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&lt;0,2</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">mg/kg</span></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Arsenic</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&lt;0,2</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">mg/kg</span></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Cadmium</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&lt;0,2</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">mg/kg</span></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Mercury</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&lt;0,2</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">mg/kg</span></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Mercury-organic pesticides</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&lt;0,2</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">mg/kg</span></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="1" rowspan="7"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Pesticides Group</span></span></strong></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Hexachlorocyclohexane (Lindane)</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&lt;0,1</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">mg/kg</span></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">4,4&rsquo;-DDT</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&lt;0,1</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">mg/kg</span></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">2,4-D</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&lt;0,1</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">mg/kg</span></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">2,4&rsquo;-DDT</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&lt;0,1</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">mg/kg</span></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">4,4&rsquo;-DDE</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&lt;0,1</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">mg/kg</span></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">2&rsquo;4&rsquo;-DDE</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&lt;0,1</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">mg/kg</span></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">4,4&rsquo;-DDO</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&lt;0,1</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">mg/kg</span></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="1" rowspan="6"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Mycotoxins</span></span></strong></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Aflatoxin B1</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&lt;2</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">ug/kg</span></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Aflatoxin B2</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&lt;4</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">ug/kg</span></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Aflatoxin G1</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&lt;4</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">ug/kg</span></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Aflatoxin G2</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&lt;4</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">ug/kg</span></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Orchratoxin A</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&lt;3</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">ug/kg</span></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">T-2 Toxins</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&lt;0,005</span></span></td>
                                                                    <td><span style="font-size:12.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">mg/kg</span></span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        
                                                        <p>&nbsp;</p>
                                                        </textarea>
                                                                </div>
                                                            </div>

                                                            {{-- <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Lead:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="lead" id="Details" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Arsenic:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="arsenic" id="description_of_" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Cadmium:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="cadmium" id="certified_by_shipper" value="" class="form-control requiredField" />
                                                    </div>
                                                 </div>

                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Mercury:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="mercury" id="Details" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Mercury Organic Pesticides:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="mercury_organic_pesticides" id="description_of_" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Hexachlorocy:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="hexachlorocy" id="certified_by_shipper" value="" class="form-control requiredField" />
                                                    </div>
                                                 </div>

                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>4,4'-DDT:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="ddt_4_4" id="Details" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>2,4-D:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="d_2_4" id="description_of_" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>2,4'-DDT:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="ddt_2_4" id="certified_by_shipper" value="" class="form-control requiredField" />
                                                    </div>
                                                 </div>


                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>4,4'-DDE:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="dde_4_4" id="Details" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>2,4'-DDE:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="dde_2_4" id="description_of_" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>4,4'-DDD:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="ddd_4_4" id="certified_by_shipper" value="" class="form-control requiredField" />
                                                    </div>
                                                 </div>


                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Aflatoxin B1:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="aflatoxin_B1" id="Details" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Aflatoxin B2:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="aflatoxin_B2" id="description_of_" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Aflatoxin G1:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="aflatoxin_G1" id="certified_by_shipper" value="" class="form-control requiredField" />
                                                    </div>
                                                 </div>

                                                 <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Aflatoxin G2:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="aflatoxin_G2" id="Details" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Orchratoxin A:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="orchratoxin_a" id="description_of_" value="" class="form-control requiredField" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>T-2 Toxins:</label>
                                                        <span class="rflabelsteric"><strong>*</strong></span>
                                                        <input type="text" name="t_2_toxins" id="certified_by_shipper" value="" class="form-control requiredField" />
                                                    </div>
                                                 </div> --}}
                                                        </div>
                                                        <div>&nbsp;</div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                                            <button type="reset" id="reset"
                                                                class="btn btn-danger">Clear Form</button>
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
