<?php
use App\Helpers\CommonHelper;
use App\Helpers\StoreHelper;
use App\Models\IncoTerm;
use App\Models\ModeOfTransport;
// $id = $_GET['id'];
$m = Session::get('run_company');
$currentDate = date('Y-m-d');
$total_expense =0;
?>




<style>


/* .neatav {
    min-height: 155px;
    font-size: 11px !important;
} */
.col-lg-12{width:99%;}
textarea{border-style:none;border-color:Transparent;}
table{table-layout:fixed;}
table caption{font-size:1.5em;margin:.5em 0 .75em;}
table tr{padding:0.35em;font-size:14px;}
table th,table td{padding:0.625em;text-align:center;border:1px solid #000;text-align:left;font-weight:bold;}
table td{vertical-align:top !important;}
table th{font-size:.85em;letter-spacing:.1em;text-transform:uppercase;text-align:center;font-weight:bold;}
table caption{font-size:1.3em;}
table thead{border:1px solid #000;clip:rect(0 0 0 0);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute;width:1px;}
.table-bordered > thead > tr > th,.table-bordered > tbody > tr > th,.table-bordered > tfoot > tr > th,.table-bordered > thead > tr > td,.table-bordered > tbody > tr > td,.table-bordered > tfoot > tr > td{font-size:14px;}
.orgeuis > thead > tr > th,.orgeuis > tbody > tr > th,.orgeuis > tfoot > tr > th,.orgeuis > thead > tr > td,.orgeuis > tbody > tr > td,.orgeuis > tfoot > tr > td{border:none;text-align:left;vertical-align: middle !important;}
.orgispra{border:none;text-align:left;}
.ssfa{border:none;padding-left:0;margin-bottom:90px;}
.ibs{border-right:none;padding-right:0;}
.ssfa{border-bottom:none;padding-left:22px;}
.pskss{text-align:center;}
.sfa{display:flex;justify-content:space-between;}
.thepara{display:flex;justify-content:space-between;}
.epso{text-align:center;}
.epso p{margin-bottom:30px;}
.epcsi3 p{font-weight:bold ;}
.sons2{border-top:2px solid #000;width:34%;margin-bottom:-10px;font-size:12px;}
.sons2 p{margin-bottom:-6px;}
.gam2 p{margin-bottom:-2px;font-size:12px;}
.sibg2{display:flex;justify-content:space-around;}
th.ht{text-align:left ;}
.kars{font-size:27px;margin-bottom:-24px;}
.coos{text-align:center;font-size:22px;margin-top:50px;}
.safca{text-align:center;margin-top:78px;}
.sae{padding-left:30px;margin-top:9px;}
.otgia{margin-top:-22px;}
.diector{text-align:right;}
.profo-apkc{text-align:center;}
.ex2{text-align:left ;}
.expo{text-align:center;}
.grop{text-align:center;}
@media screen and (max-width:600px){table{border:0;}
}
@media print{
.printHide{display:none !important;}
.fa{font-size:small!important;}
.table-bordered{border:1px solid black !important;}
table.table-bordered > thead > tr > th{border:1px solid blue !important;}
}


/* .pt12{display:flex;width:28%;margin-bottom:-14px;font-size:12px;gap:157px;}
.pt22{display:flex;width:28%;margin-bottom:-14px;font-size:12px;gap:130px;}
.pt32{display:flex;width:44%;margin-bottom:-14px;font-size:12px;gap:234px;}
.pt42{display:flex;width:34%;margin-bottom:-14px;font-size:12px;gap:232px;}
.pt52{display:flex;width:36%;margin-bottom:-28px;font-size:12px;border-top:2px solid #000;gap:88px;width:34%;margin-top:11px;}
.pt62{display:flex;border-top:2px solid #000;padding-top:9px;width:48% !important;margin-bottom:-14px;font-size:12px;gap:128px;}
.pt72{display:flex;width:28%;margin-bottom:-14px;font-size:12px;gap:132px;}
.pt82{display:flex;width:28%;margin-bottom:-14px;font-size:12px;gap:119px;}
.pt92{display:flex;width:28%;margin-bottom:-14px;gap:160px;font-size:12px;} */
/* .ibs{border-right:2px solid #000;padding-right:25px;} */
/* .ibs2{padding-left:25px;} */
/* .epcsi{display:flex;gap:40px;}
.epcsi1{display:flex;gap:141px;}
.epcsi2{display:flex;gap:95px;}
.epcsi3{display:flex;gap:112px;}
.epcsi4{display:flex;gap:43px;}
.epcsi5{display:flex;gap:45px;} */

</style>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        <?php CommonHelper::displayPrintButtonInView('printPurchaseRequestVoucherDetail','','1');?> 
    </div>
</div>
<div style="line-height:5px;">&nbsp;</div>
<div class="row" id="printPurchaseRequestVoucherDetail">
    <div class="col-md-12 " >
        <div class="par">
            <!-- <div class="col-md-4"> -->
                <!-- <div class="praga">
                    <div class="profo-apkc">
                        <h4>INVOICE # 20002. MOMBASA , KENYA. BOOKING NUMBER # LNREXP-00149-1222 .DT: 23-12-2022.</h4>
                        <h4>G.D # KPEX-SB-75631-24-12-2022</h4>
                        <br>
                    </div>
                </div> -->
            <!-- </div> -->
            <!-- <div class="col-md-8"></div> -->
            <!-- <div class="col-md-12"> -->
                <div class="table-responsive orgispra">
                    <table class="table  sf-table-list paskitaj orgeuis " id="EmpExitInterviewList " >
                        <tbody>
                            <tr>
                                <td>
                                    <div class="expo ead">
                                        {{-- Exporter Name :--}} 
                                        {!! $originCertificate->exporter_name !!}
                                        {{-- Exporter Address:--}}  
                                        {!! $originCertificate->exporter_address !!} 
                                        {{-- <th style="text-align:left !important;">REFERENCE NUMBER</th>--}}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="sps addsps"> 
                                        <span>  {{$originCertificate->consignee_name}} </span>
                                        <span>  {!! $originCertificate->consignee_address !!} </span>
                                    </div> 
                                </td>
                                <td  style="border-bottom:none;"> <div class="coos"></div></td>
                            </tr>
                            <tr>
                                <td><div class="epc"> <span></span> {{$originCertificate->exporter_membership_no}}</div></td>
                            </tr>
                            <tr>
                                <td><div class="vbel">{{-- {{$originCertificate->mode_transport}}  B/L NO: {{$originCertificate->bl_no_date}} VESSEL NAME: --}} {!! $originCertificate->shiper_name !!}</div></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table  sf-table-list otgia orgeuis " id="EmpExitInterviewList " style="    vertical-align: middle !important;" >
                        <tbody>
                            <thead>
                            {{--<tr>
                                 <th>Marks & Number</th>
                                    <th>Number and kind of Packages</th>
                                    <th>Description of Goods</th>
                                    <th><div class="grop"> Gross Weight or other Quantity</div></th>
                                    <th>Country of Origin</th>
                                </tr>--}}
                            </thead>
                             <tr>
                             <td class="cutwith2 align-middle "><div class="neatav">  {{$originCertificate->marks_number}}</div></td>
                                <td class="align-middle"><div class="bages_marks"> {{ $totalBags }} BAGS</div></td>
                                <td class="align-middle"><div class="bages_marks decriptions">{!! $originCertificate->description_of_good_origin !!}</div></td>
                                <td class="align-middle"> <div class="grop gross_net">GROSS WEIGHT<br>{{number_format($originCertificate->gross_weight,3)}}<br>METRIC TONS
                                <br><br><br>NET WEIGHT<br>{{number_format($originCertificate->neight_weight,3)}}<br>METRIC TONS    
                                </div>
                            </td>
                                <td class="cutwith2" style="text-align:center;">{{$originCertificate->country_origin}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- <div class="thepara">
                    <div class="ibs">
                        <p>Other information</p>
                        <div class="ssfa">
                            <p><strong>WE HEREBY CERTIFY THAT THE GOODS ARE OF PURE PAKSITAN ORIGIN</strong></p>
                        </div>
                        <p>it is hereby declared that the above mentioned goods originate in:</p>
                        <div class="pskss">
                            <p><strong>(PAKISTAN)</strong></p>
                        </div>
                        <div class="epcsi">
                            <p>Exporter's Signature:</p>
                            <p>________________________</p>
                        </div>
                        <div class="epcsi1">
                            <p>Name:</p>
                            <p>{{$originCertificate->name_origin}}</p>
                        </div>
                        <div class="epcsi2">
                            <p>Designation:</p>
                            <p>{{$originCertificate->designation_origin}}</p>
                        </div>
                        <div class="epcsi3">
                            <p>Company:</p> 
                            <p>{{$originCertificate->company}}  Stamp </p>
                        </div>
                        <div class="epcsi4">
                            <p>Place:</p>
                            <p>{{$originCertificate->place}}</p>
                            <p>{{' Date:______________________'}}</p>
                        </div>
                    </div>
                    <div class="ibs2">
                     <p>It is hereby Certified that to the best of my knowledge and according to the documents produced before me, this declaration appears to be correct.</p>
                     <p>____________________<br>Authorized Signatory</p>
                     <p><strong>Attestation Officer<br> Karachi Chamber of Commerce & Industry</strong></p>
                     <p><u>KARACHI PAKISTAN</u></p>
                        <div class="sfa">
                         <p>Place and date of issue</p>
                        <p><strong>Emboss</strong></p>
                        </div>
                        <p><strong><u>Karachi Chamber of Commerce & Industry</u></strong></p>
                         <p>Certifying Body</p>
                    </div>
                </div> -->
                <div class="thepara">
                    <div class="ibs">
                    {{--  <p>Other information</p>--}}
                        <div class="ssfa heare">
                            <p><strong>WE HEREBY CERTIFY THAT THE GOODS ARE OF PURE PAKSITAN ORIGIN</strong></p>
                        </div>
                        {{--  <p>it is hereby declared that the above mentioned goods originate in:</p>
                        <div class="pskss">
                            <p><strong>(PAKISTAN)</strong></p>
                         </div>--}}
                       {{--  <div class="epcsi">
                            <p>Exporter's Signature:</p>
                            <p>________________________</p>
                        </div>--}}
                        <div class="epso sushss logos_signature">
                            <div class="epcsi1">
                            {{--  <p>Name:</p>--}}
                            {{--  <p>{{$originCertificate->name_origin}}</p>--}}
                                <p>Fauzi Farooq Garib</p>
                            </div>
                            <div class="epcsi2">
                            {{--   <p>Designation:</p>--}}
                                <p>{{$originCertificate->designation_origin}}</p>
                            </div>
                            <div class="epcsi3">
                            {{-- <p>Company:</p> --}}
                                <p>{{$originCertificate->company}} </p>
                            </div>
                            {{--  <div class="epcsi4">
                                <p>Place:</p>
                                <p>{{$originCertificate->place}}</p>
                                <p>{{' Date:______________________'}}</p>
                            </div>--}}
                        </div>
                    </div>
                    {{--   <div class="ibs2">
                     <p>It is hereby Certified that to the best of my knowledge and according to the documents produced before me, this declaration appears to be correct.</p>
                     <p>____________________<br>Authorized Signatory</p>
                     <p><strong>Attestation Officer<br> Karachi Chamber of Commerce & Industry</strong></p>
                     <p><u>KARACHI PAKISTAN</u></p>
                        <div class="sfa">
                         <p>Place and date of issue</p>
                        <p><strong>Emboss</strong></p>
                        </div>
                        <p><strong><u>Karachi Chamber of Commerce & Industry</u></strong></p>
                         <p>Certifying Body</p>
                    </div>--}}
                </div>
            <!-- </div> -->
        </div>
    </div>
</div>
    
   