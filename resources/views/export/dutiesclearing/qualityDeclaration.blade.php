

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
.decl{display:flex;justify-content:space-between;align-items:baseline;}
.decll2{width:79%;}
.gafa{text-align:center;}
.asbs{margin-top:20px;}
.bos{border:2px solid #000;padding:10px 10px;}
.mal{margin-bottom:10px;}
.bos p{line-height:19px !important;}
.botop{margin-top:-26px;}


@media screen and (max-width:600px){table{border:0;}
table caption{font-size:1.3em;}
table thead{border:1px solid #000;clip:rect(0 0 0 0);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute;width:1px;}
}
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
        <div class="quldelpak">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <div class="qulipx">
                        <div class="sda">
                            <p>Certificate no: {{$qualityDeclaration->certificate_no ?? '-'}}</p>
                            <p>Dated: {{$qualityDeclaration->certificate_date ?? '-'}}</p>
                        </div>
                        <p>BASED ON OUR ANALYSE, WE ARE PLEASED TO CONFIRM OUR QUALITY AS FOLLOWS:</p>
                        <div class="decl">
                            <p>VESSEL NAME:</p>
                            <div class="decll2">
                                <p>{{$qualityDeclaration->qulity_decleartion_shiper_name ?? '-'}}</p>
                            </div>
                        </div>
                        <div class="decl">
                            <p>BILL OF LADING NO:</p>
                            <div class="decll2">
                                <p>{{$qualityDeclaration->bill_of_lading ?? '-'}}</p>
                            </div>
                        </div>
                        <div class="decl">
                            <p>CONSIGNEE:</p>
                            <div class="decll2">
                            <p>{!! $qualityDeclaration->qulity_decleartion_consignee ?? '-' !!}</p>
                            </div>
                        </div>
                        <div class="decl">
                            <p>SHIPPER:</p>
                            <div class="decll2">
                            <p>{!! $qualityDeclaration->qulity_decleartion_shipper ?? '-' !!}</p>
                            </div>
                        </div>
                        <div class="decl">
                            <p>CONTAINER NUMBERS:</p>
                            <div class="decll2">
                            <p>{{$qualityDeclaration->qulity_decleartion_container_no ?? '-'}}</p>
                            </div>
                        </div>
                        <div class="decl">
                            <p>NUMBER BAGS:</p>
                            <div class="decll2">
                            <p>{{$qualityDeclaration->qulity_decleartion_number_of_bags ?? '-'}}</p>
                            </div>
                        </div>
                        <div class="decl">
                            <p>NETT WEIGHT:</p>
                            <div class="decll2">
                            <p>{{$qualityDeclaration->qulity_decleartion_net_weight ?? '-'}}</p>
                            </div>
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
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="mal">
                    {{-- <p><u>PAKISTANI CHENAB WHITE MILLED BASMATI RICE, WELL MILLED AND DOUBLE (SILKY) POLISHED & 100% COLOUR SORTED -CROP 2022/23 CONTAINING MAX 2% BROKEN </u></p> --}}
                </div>
                <div class="mal">
                    <p><strong><u>DESCRIPTION OF GOODS:</u></strong></p>
                </div>
                <p>{!! $qualityDeclaration->description_of_goods ?? '-' !!}</p>    
                
                <p>{!! $qualityDeclaration->other_detail ?? '-' !!}</p>
    
            </div>
        </div>
        <div class="asbs">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">

                    <div class="bos">
                        {!! $qualityDeclaration->other_detail_2 ?? '-' !!}<br>
                        <div class="botop">
                            <p><strong>AFLATOXINS NOT FOUND WITHIN DETECTABLE LIMITS;<br>OCHRATOXINS NOT FOUND WITHIN</strong></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-6">
                    <div class="bos2">
                        <p>FOR GARIBSONS (PVT) LTD.,</p>
                        <br>
                        <p>DIRECTOR</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="gafa">
            <img src="{{ asset('/public/images/gafa.png') }}" alt="">
        </div>
    </div>



    
   