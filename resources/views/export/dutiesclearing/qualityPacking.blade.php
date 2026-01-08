

<?php
use App\Helpers\CommonHelper;
use App\Helpers\StoreHelper;
use App\Models\IncoTerm;
use App\Models\ModeOfTransport;
$id = $_GET['id'];
$m = Session::get('run_company');
$currentDate = date('Y-m-d');
$total_expense =0;

?>



<style>
.table-bordered > thead > tr > th,.table-bordered > tbody > tr > th,.table-bordered > tfoot > tr > th,.table-bordered > thead > tr > td,.table-bordered > tbody > tr > td,.table-bordered > tfoot > tr > td{font-size:14px !important;}
textarea{border-style:none;border-color:Transparent;}
.col-lg-12{width:99%;}
table{table-layout:fixed;}
table caption{font-size:1.5em;margin:.5em 0 .75em;}
table tr{padding:0.35em;font-size:14px;}
table th,table td{padding:0.625em;text-align:center;border:1px solid #000;text-align:left;font-weight:bold;}
table td{vertical-align:top !important;}
table th{font-size:.85em;letter-spacing:.1em;text-transform:uppercase;text-align:center;font-weight:bold;}
@media screen and (max-width:600px){table{border:0;}
table caption{font-size:1.3em;}
table thead{border:1px solid #000;clip:rect(0 0 0 0);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute;width:1px;}
}



.mal p{margin-bottom:0;}
.quo1 h5{margin-bottom:0;}
.quo1{display:flex;justify-content:space-between;align-items:baseline;}
.gafa{text-align:center;}


 @media print{.printHide{display:none !important;}
.fa{font-size:small!important;}
.table-bordered{border:1px solid black;}
table.table-bordered > thead > tr > th{border:1px solid blue !important;}
}

</style>
<?php

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        <?php CommonHelper::displayPrintButtonInView('printPurchaseRequestVoucherDetail','','1');?> 
    </div>
</div>
<div style="line-height:5px;">&nbsp;</div>
    <div class="row" id="printPurchaseRequestVoucherDetail">
        


                    <div class="quliform">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <div class="mal">
                                    <p><strong><u>CERTIFICATE OF WEIGHT & QUALITY & PACKING</u></strong></p>
                                </div>
                                <div class="mal">
                                    <p><strong><u>CERTIFICATE NO. {{$qualityPacking->quality_certificate_no}} DATED: {{$qualityPacking->quality_date}}</u></strong></p>
                                </div>
                                <div class="mal">
                                    <p><strong><u>INVOICE NO. {{$exportInvoiceDetail->commercial_invoice_no}} DATED {{$exportInvoiceDetail->invoice_date}}</u></strong></p>
                                </div>
                                <br>

                                <div class="quo1">
                                    <h5><strong>SHIPPER : </strong></h5>
                                    <div class="quien sinmpe">
                                        <p>{!! $qualityPacking->quality_packing_shipper ?? ''!!}</p>
                                    </div>
                                </div>
                                <div class="quo1">
                                    <h5><strong>CONSIGNEE : </strong></h5>
                                    <div class="quien">
                                    <p>{!! $qualityPacking->quality_packing_consignee ?? '' !!}</p>
                                    </div>
                                </div>
                                <div class="quo1">
                                    <h5><strong>DESCRIPTION OF GOODS : </strong></h5>
                                    <div class="quien">
                                        <p>{!! $qualityPacking->quality_packing_description_of_good ?? '' !!}</p>
                                    </div>
                                </div>
                                <div class="quo1">
                                    <h5><strong>PACKING : </strong></h5>
                                    <div class="quien">
                                        <p>{{$qualityPacking->quality_packing_packing ?? ''}}</p>
                                    </div>
                                </div>
                                <div class="quo1">
                                    <h5><strong>ORIGIN : </strong></h5>
                                    <div class="quien">
                                    <p>{{$qualityPacking->quality_packing_origin ?? ''}}</p>
                                    </div>
                                </div>
                                <div class="quo1">
                                    <h5><strong>DECLARED QUANTITY : </strong></h5>
                                    <div class="neas">
                                        <div class="quien">
                                            <p>{{$qualityPacking->quality_packing_declared_quality ?? ''}}</p>
                                            <br>
                                            <div class="asabas">
                                                <p> NUMBER OF BAGS  :500</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="quo1">
                                    <h5><strong>VESSEL : </strong></h5>
                                    <div class="quien">
                                    <p>{{$qualityPacking->quality_packing_vessel ?? ''}}</p>
                                    </div>
                                </div>
                                <div class="quo1">
                                    <h5><strong>PROT OF LOADING : </strong></h5>
                                    <div class="quien">
                                        <p>{{$qualityPacking->quality_packing_port_of_loading ?? ''}}</p>
                                    </div>
                                </div>
                                <div class="quo1">
                                    <h5><strong>PORT OF DISCHARAGE : </strong></h5>
                                    <div class="quien">
                                        <p>{{$qualityPacking->quality_packing_of_discharge ?? ''}}</p>
                                    </div>
                                </div>
                                <div class="quo1">
                                    <h5><strong>B/L NO. : </strong></h5>
                                    <div class="quien">
                                        <p>{{$qualityPacking->quality_packing_Bl_no ?? ''}}</p>
                                    </div>
                                </div>

                      












                                

                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="gariblogo2">
                                        <img src="{{asset('/public/images/garibsons.jpg')}}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- CONTAINER NOS -->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <hr>
                                <div class="quo1 ">
                                    <h5><strong>CONTAINER NOS : </strong></h5>
                                    <div class="quien">
                                        <p>{{$qualityPacking->quality_packing_container_no ?? ''}}</p>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="qus">

                                        <div class="quo1">
                                            <h5><strong><u>RESULTS OF INSPECTION<br>LOT NO : </u></strong></h5>
                                            <div class="quien">
                                                <p class="tew">{{$qualityPacking->quality_packing_lot_no ?? ''}}</p>
                                            </div>
                                        </div>

                                        <div class="quo1">
                                            <h5><strong>WEIGHT : </strong></h5>
                                            <div class="quien">
                                                <p><strong>{{$qualityPacking->quality_packing_weight ?? ''}}</strong></p>
                                            </div>
                                        </div>
                
                                        {{-- <div class="quo1">
                                                <p>TARE WEIGHT:0.115 M.TONS</p>
                                                <p>{{$qualityPacking->quality_packing_container_no}}</p>
                                            </div> --}}
                                    
                                        <div class="quo1">
                                            <h5><strong>PACKING : </strong></h5>
                                            <div class="quien">
                                            <p>BAGS ARE FIT FOR CONTACT WITH CEREALS / FOODSTUFFS</p>
                                            </div>
                                        </div>
                                
                                        <div class="quo1">
                                            <h5><strong>DATE OF PRODUCTION : </strong></h5>
                                            <div class="quien">
                                                <div class="desats"><p>{{$qualityPacking->quality_packing_date_of_production}}</p></div>
                                            </div>
                                        </div>

                                        <div class="quo1">
                                            <h5><strong>QUALITY : </strong></h5>
                                            <div class="quien">
                                                <p>{!! $qualityPacking->quality_packing_quality !!}</p>
                                            </div>
                                        </div>

                                        <hr>

                                        {{-- <div class="">
                                                <p>THIS IS TO CERTIFY THAT THE MERCHANDISE CORRESPONDS TO: WHITE PAKISTANI CHENAB WHITE MILLED BASMATI RICE,WELL MILLED AND DOUBLE (SILKY) POLISHED & 100% COLOUR SORTED-CROP 2022/23 CONTAINING MAX 2% BROKEN</p>
                                            </div> --}}

                                        <div class="">
                                            <p><strong><u>SPECIFICATIONS:</u></strong></p>
                                            <p><strong><u>ANALYSIS RESULTS:</u></strong></p>
                                        </div>

                                        <div class="quo1">
                                            {{-- <p></p> --}}
                                            {{-- <p>{!! $qualityPacking->quality_packing_broken !!}</p> --}}
                                            <p>{!! $qualityPacking->quality_packing_broken !!}</p>
                                        </div>
                    
                                        <br>
                                        {{-- <div class="quo1">
                                                <p>RICE IS MILLED FROM NON0GMO PADDY AND SUITABLE FOR HUMAN CONSUMPTION.</p>
                                            </div>

                                        <div class="quo1">
                                            <p>COMPLY WITH EU REQUIREMENTS.</p>
                                        </div> --}}

                                        <div class="quo1">
                                            <p>{{$qualityPacking->quality_packing_detail}}</p>
                                        </div>

                                        <div class="quo1">
                                            <p>This certificate reflects the findings at time and place of inspection only.</p>    
                                        </div>

                                        <div class="quo1">
                                            <p>SIGNATURE</p>
                                            <p>NAME FARHAN HAMID</p>
                                            <p>SURNAME:GARIB</p>
                                            <p>POSITION IN THE COMPANY:DIRECTOR</p>
                                        </div>


                                </div>

                            </div>
                        </div>

                    </div>
   
        <div class="gafa">
            <img src="{{ asset('/public/images/gafa.png') }}" alt="">
        </div>  
    </div>


    
   