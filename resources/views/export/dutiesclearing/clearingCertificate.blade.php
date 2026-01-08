

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
.specification-table > table{width: 100% !important;}
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
.diector{text-align:right;}
.pt12{display:flex;width:28%;margin-bottom:-14px;font-size:12px;gap:157px;}
.pt22{display:flex;width:28%;margin-bottom:-14px;font-size:12px;gap:130px;}
.pt32{display:flex;width:44%;margin-bottom:-14px;font-size:12px;gap:234px;}
.pt42{display:flex;width:34%;margin-bottom:-14px;font-size:12px;gap:232px;}
.pt52{display:flex;width:36%;margin-bottom:-28px;font-size:12px;border-top:2px solid #000;gap:88px;width:34%;margin-top:11px;}
.pt62{display:flex;border-top:2px solid #000;padding-top:9px;width:48% !important;margin-bottom:-14px;font-size:12px;gap:128px;}
.pt72{display:flex;width:28%;margin-bottom:-14px;font-size:12px;gap:132px;}
.pt82{display:flex;width:28%;margin-bottom:-14px;font-size:12px;gap:119px;}
.pt92{display:flex;width:28%;margin-bottom:-14px;gap:160px;font-size:12px;}
.sons2{border-top:2px solid #000;width:34% !important;margin-bottom:-10px;font-size:12px;}
.sons2 p{margin-bottom:-6px;}
.gam2 p{margin-bottom:-2px;font-size:12px;}
.sibg2{display:flex;justify-content:space-around;}
th.ht{text-align:left !important;}
.kars{font-size:27px;margin-bottom:-24px;}
.coos{text-align:center;font-size:22px;margin-top:50px;}
.safca{text-align:center;margin-top:78px;}
.sae{padding-left:30px;margin-top:9px;}
.otgia{margin-top:-22px;}

/* Packing lsit */
.profo-apkc{text-align:center !important;}

/* packing */
.pachrad{text-align:center;}
.patc1{display:flex;gap:60px;}
.patc2{display:flex;gap:75px;}
.patc3{display:flex;gap:87px;}
.patc4{display:flex;gap:62px;}
.patc5{display:flex;gap:81px;}
.patc6{display:flex;gap:97px;}
.patc7{display:flex;gap:44px;}
.sibs{text-align:right;}


.heag{text-align:center;}
.stapsa{text-align:left;}



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
    <div class="col-md-12 ">
        <div class="par">
             <div class="col-md-8">
                 <div class="paknsg">
                    <p><strong>HEAVY METAL, PESTICIDES GROUP, MYCOTOXINS CERTIFICATE</strong></p>
                    <p>Date: {{$clearingCertificate->invoice_date ?? '-'}}</p>
                </div>
             </div>
             <br>
   
                <div class="table-responsive">
                
                <table class="table table-bordered sf-table-list packid " id="EmpExitInterviewList " style="    vertical-align: middle !important;" >
                      <tbody>
                          <tr>
                              <td style="padding:4px;">INVOICE</td>
                              <td style="padding:4px;">{{$exportPakingList->invoice->commercial_invoice_no}} DATED {{$exportPakingList->invoice->invoice_date ?? '-'}}</td>
                          </tr>
                          <tr>
                              <td style="padding:4px;">CERTIFICATE NO:</td>
                              <td style="padding:4px;">{{$clearingCertificate->clearance_certificate_no??'-'}}</td>
                          </tr>
                          <tr>
                              <td style="padding:4px;">CONSIGNEE:</td>
                              <td style="padding:4px;">{!! $clearingCertificate->consignee??'-' !!}</td>
                          </tr>
                          <tr>
                              <td style="padding:4px;">VESSEL'S NAME</td>
                              <td style="padding:4px;">{{$exportPakingList->invoice->ship_name}}</td>
                          </tr>
                          <tr>
                              <td style="padding:4px;">PORT OF LOADING:</td>
                              <td style="padding:4px;">{{$exportPakingList->invoice->exportOrder->port_loading }}</td>
                          </tr>
                          <tr>
                              <td style="padding:4px;">CONTAINER NUMBERS:</td>
                              <td style="padding:4px;">{{$clearingCertificate->container_no??'-'}}</td>
                          </tr>
                          <tr>
                              <td style="padding:4px;">PORT OF DISCHARGE:</td>
                              <td style="padding:4px;">{{$exportPakingList->invoice->exportOrder->port_of_discharge }}</td>
                          </tr>
                          <tr>
                              <td style="padding:4px;">DESCRIPTION OF GOODS:</td>
                              <td style="padding:4px;">{!! $clearingCertificate->description_og_good??'-' !!}</td>
                          </tr>
                          
                          <tr>
                              <td style="padding:4px;">TOTAL WEIGHT:</td>
                              <td style="padding:4px;">Net Weight: {{ $exportPakingList->packingListData->sum('net_weight') }}, Gross Weight: {{ $exportPakingList->packingListData->sum('gross_weight') }}</td>
                          </tr>
                         
                          <tr>
                              <td style="padding:4px;">HEALTH:</td>
                              <td style="padding:4px;">{{$clearingCertificate->health??'-'}}</td>
                          </tr>
                          </tbody>
                  </table>
                  <p>WE CONFIRM THET THE PRODUCT IS FIT FOR HUMAN CONSUMPTION:</p>
                  <div class="heag">
                    <p><strong>TEST RESULTS</strong></p>
                </div>
                <div class="specification-table">
                    {!! $clearingCertificate->specification ?? '-' !!}
                </div>
                    {{-- <table class="table table-bordered sf-table-list packid " id="EmpExitInterviewList " style="    vertical-align: middle !important;" >
                        <tbody>
                            <thead>
                                <tr>
                                    <th>SPECIFICATION</th>
                                    <th>TEST PARAMETERS</th>
                                    <th>MAX DETECTION LIMITED</th>
                                    <th>UNIT</th>
                                </tr>
                            </thead>
                            <tr>
                                <td rowspan="6" style="padding:4px;">Heavy metal</td>
                            </tr>

                            <tr>
                                <td  style="padding:4px;">Lead</td>
                                <td style="padding:4px;text-align:center;">< 0,2</td>
                                <td style="padding:4px;text-align:center;">{{$clearingCertificate->lead??'-'}}</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">Arsenic</td>
                                <td style="padding:4px;text-align:center;">< 0,2</td>
                                <td style="padding:4px;text-align:center;">{{$clearingCertificate->arsenic??'-'}}</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">Cadmium</td>
                                <td style="padding:4px;text-align:center;">< 0,2</td>
                                <td style="padding:4px;text-align:center;">{{$clearingCertificate->cadmium??'-'}}</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">Mercury</td>
                                <td style="padding:4px;text-align:center;">< 0,2</td>
                                <td style="padding:4px;text-align:center;">{{$clearingCertificate->mercury??'-'}}</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">Mercury-organic pesticides</td>
                                <td style="padding:4px;text-align:center;">< 0,2</td>
                                <td style="padding:4px;text-align:center;">{{$clearingCertificate->mercury_organic_pesticides??'-'}}</td>
                            </tr>
                            <tr>
                                <td rowspan="8" style="padding:4px;">Pesticides Group</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">Hexachlorocy</td>
                                <td style="padding:4px;text-align:center;">< 0,01</td>
                                <td style="padding:4px;text-align:center;">{{$clearingCertificate->hexachlorocy??'-'}}</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">4,4'-DDT</td>
                                <td style="padding:4px;text-align:center;">< 0,01</td>
                                <td style="padding:4px;text-align:center;">{{$clearingCertificate->ddt_4_4??'-'}}</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">2,4-D</td>
                                <td style="padding:4px;text-align:center;">< 0,01</td>
                                <td style="padding:4px;text-align:center;">{{$clearingCertificate->ddt_4_4??'-'}}</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">2,4'-DDT</td>
                                <td style="padding:4px;text-align:center;">< 0,01</td>
                                <td style="padding:4px;text-align:center;">{{$clearingCertificate->ddt_2_4??'-'}}</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">4,4'-DDE</td>
                                <td style="padding:4px;text-align:center;">< 0,01</td>
                                <td style="padding:4px;text-align:center;">{{$clearingCertificate->dde_4_4??'-'}}</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">2,4'-DDE</td>
                                <td style="padding:4px;text-align:center;">< 0,01</td>
                                <td style="padding:4px;text-align:center;">{{$clearingCertificate->dde_2_4??'-'}}</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">4,4'-DDD</td>
                                <td style="padding:4px;text-align:center;">< 0,01</td>
                                <td style="padding:4px;text-align:center;">{{$clearingCertificate->ddd_4_4??'-'}}</td>
                            </tr>
                            <tr>
                                <td rowspan="7" style="padding:4px;">Mycotoxins</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">Aflatoxin B1</td>
                                <td style="padding:4px;text-align:center;">< 2</td>
                                <td style="padding:4px;text-align:center;">{{$clearingCertificate->aflatoxin_B1??'-'}}</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">Aflatoxin B2</td>
                                <td style="padding:4px;text-align:center;">< 4</td>
                                <td style="padding:4px;text-align:center;">{{$clearingCertificate->aflatoxin_B2??'-'}}</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">Aflatoxin G1</td>
                                <td style="padding:4px;text-align:center;">< 4</td>
                                <td style="padding:4px;text-align:center;">{{$clearingCertificate->aflatoxin_G1??'-'}}</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">Aflatoxin G2</td>
                                <td style="padding:4px;text-align:center;">< 4</td>
                                <td style="padding:4px;text-align:center;">{{$clearingCertificate->aflatoxin_G2??'-'}}</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">Orchratoxin A</td>
                                <td style="padding:4px;text-align:center;">< 3</td>
                                <td style="padding:4px;text-align:center;">{{$clearingCertificate->orchratoxin_a??'-'}}</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">T-2 Toxins</td>
                                <td style="padding:4px;text-align:center;">< 0,005</td>
                                <td style="padding:4px;text-align:center;">{{$clearingCertificate->t_2_toxins??'-'}}</td>
                            </tr>
                            </tbody>
                    </table> --}}
                </div>
                <p>By signing this document you confirm that product parameters mentioned does not exceed the established normsin EU,listed in colum,, MAX DETECTION LIMITED"</p>
                <div class="stapsa">
                    <p>___________________</p>
                    <p>Seller Stamp and signature</p>
                </div>
        </div>
    </div>
</div>




    
   