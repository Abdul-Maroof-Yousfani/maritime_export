

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
 textarea{border-style:none;border-color:Transparent;}
.col-lg-12{width:99%;}
.profopoiyt1{border-bottom:5px solid;}
.profopoiyt3{border-bottom:5px solid;}
.profopoiyt4 p{font-size:14px !important;}
.csa{display:flex;gap:50px}
.csaw{align-items:center;}
.des{text-align:center;}
.csa.csaw2{align-items:end;gap:67px;}
.psasf{text-align:center;}
.csa .csaw3{gap:77px;}
.csa{gap:142px;}
.csass{gap:78px;}
.cs1{gap:145px;}
.cs2{gap:107px;}
.cs3{gap:93px;}
.cs4{gap:81px;}
.cs5{gap:142px;}
.fumgi{display:flex;justify-content:space-between;align-items:baseline;width:100%;}
.fumms{width:73%;}
.brabk p{max-width:33%;}
.ptofsls{display:flex;justify-content:space-between;margin-bottom:20px;width:85%;}
.ptorof{margin-bottom:40px;}
.pro2{margin-bottom:60px;}
.prmd{margin-bottom:20px;}


@media print{
table th{font-size:20px;}
.printHide{display:none !important;}
.fa{font-size:small;!important;}
.table-bordered{border:1px solid black;}
table.table-bordered > thead > tr > th{border:1px solid blue !important;}
}

</style>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        <?php CommonHelper::displayPrintButtonInView('printPurchaseRequestVoucherDetail','','1');?>
        
    </div>
</div>
<div style="line-height:5px;">&nbsp;</div>
    <div class="row" id="printPurchaseRequestVoucherDetail">
        <div class="col-md-12 ">
            <div class="par flugid_width">
                <div class="praga  flugid_width">
                    <div class="ptofsls">
                        <p>Port of KARACHI / Port Qasim</p>
                            <p><strong> Invoice No : {{$fumigation->fumigation_text_area ?? '-'}}</strong></p>
                        </div>
                    </div>
 
                    <div class="ptorof profopoiyt1 ">
                        <p>This is to certify that Fumigation Disfestation /Disinfection of Consignment of  <b>{{number_format($fumigation->no_of_bags ?? '0')}}</b> Bages
                            was carried out on <b >{{date('d-m-Y',strtotime($fumigation->date ?? '-'))}}</b> as per detsils given below under the supervision of the Technical staff of the 
                            <b>{{$fumigation->fumigation_created_by ?? '-'}}</b>, in accordance with Treatment Schedules and internationally accepted standards.The Consigment has been, to the best of our Knowledge, rendered free from injurious pests and diseases.
                        </p>
                        {{-- <p>{{$fumigation->fumigation_text_area ?? '-'}}</p> --}}
                    </div>

                    <div class="profopoiyt2 pro2 peo2">
                        <div class=" fumgi">
                            <p>Chemical Treatment :</p>
                            <div class="fumms">
                                <p>{{$fumigation->chemical_treatment ?? '-'}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="profopoiyt3 pro2 prmd">
                        <div class=" fumgi">
                            <p>Chemical & Concentration :</p>
                            <div class="fumms">
                            <p>{{$fumigation->chemical_concentration ?? '-'}}</p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="des decs">
                        <p><strong>DESCRIPTION OF CONSIGNMENT</strong></p>
                    </div>
                    <br>

                    <div class="praflu">
                        <div class="profopoiyt4">
                            <div class="  fumgi">
                                <p>Name & Address of Exporter :</p>
                                <div class="fumms">
                                <p>{!!$fumigation->name_address_expoter ?? '-'!!}</p>
                                </div>
                            </div>
                        </div>
    
                        <div class="profopoiyt4">
                            <div class=" fumgi">
                                <p>Name & Address of Consignee :</p>
                                <div class="fumms">
                                <p>{!!$fumigation->name_address_consignee ?? '-'!!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="profopoiyt4">
                            <div class=" fumgi">
                                <p>Means of Conveyance : </p>
                                <div class="fumms">
                                <p>{!! $fumigation->mean_of_conveyance ?? '-' !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="profopoiyt4">
                            <div class=" ">
                                <div class="msa fumgi">
                                    <p>Distinguishing Marks :</p>
                                    <div class="fumms brabk">
                                    <p>{!!$fumigation->distinguishing_marks ?? '-'!!}</p>
                                    </div>
                                </div>
                                <div class="paskc">
                                </div>
                            </div>
                        </div>
                        <div class="profopoiyt4">
                            <div class="">
                                <div class="msa fumgi">
                                    <p>Number & Description of goods :</p>
                                    <div class="fumms">
                                    <p>{!!$fumigation->description_of_good ?? '-'!!}</p>
                                    </div>
                                </div>
                                <div class="paskc">
                                   
                                </div>
                            </div>
                        </div>
                        <div class="profopoiyt4">
                            <div class="">
                                <div class="msa fumgi">
                                    <p>Origin as certified by Shippers :</p>
                                    <div class="fumms pasks">
                                        <div class="paskc">
                                            {{--<div class="psasf">
                                             <p>PAKISTAN</p>
                                            </div> --}}
                                            <p>{{$fumigation->origin_certificate_shippers ?? '-'}}<p>
                                        </div>   
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>

                    </div>
                    <div>
                        <div class="crei">
                            <p> {{$fumigation->details1 ?? '-'}}  </p>
                            <hr class="fulni crifi  profopoiyt1">
                           <p> {{$fumigation->details2 ?? '-'}}  </p>
                        </div>
                    </div>
                    <hr class="fulni">
                </div>
            </div>
            <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-bordered sf-table-list" id="EmpExitInterviewList">
                            <tbody>
                                <tr>
                                <td data-label="Account">Beneficiary:</td>
                                <td data-label="Due Date">GARIBSONS (PVT) LTD</td>
                                </tr>
                                <tr>
                                <td scope="row" data-label="Account">Beneficiary address:</td>
                                <td data-label="Due Date">C69/71, 12TH COMMERCIAL ST., PH-II EXT., DHA, KARACHI 75500 (PAKSITAN)</td>
                                </tr>
                                <tr>
                                <td scope="row" data-label="Account">Beneficiary account Pak Rupess:</td>
                                <td data-label="Due Date">0786-79009464-03</td>
                                </tr>
                                <tr>
                                <td scope="row" data-label="Account">IBAN#:</td>
                                <td data-label="Due Date">PK 89 HABB 0007 8679 0094 6403</td>
                                </tr>
                                <tr>
                                <td scope="row" data-label="Account">Beneficiary bank:</td>
                                <td data-label="Due Date">HABIB BANK LIMITED</td>
                                </tr>
                                <tr>
                                <td scope="row" data-label="Account">Beneficiary bank swift code:</td>
                                <td data-label="Due Date">HABBPKKA786</td>
                                </tr>
                                <tr>
                                <td scope="row" data-label="Account">Beneficiary bank address:</td>
                                <td data-label="Due Date">HABIB BANK LIMITED<br>BRANCH ADDRESS: HEAD OFFICE, TREASURY A/C, HABIB PLAZA BRANCH 0786,KARACHI,PAKSITAN. PHONE:- 531-1953-8, FAX NO: - 531-1959</td>
                                </tr>
                                <tr>
                                <td scope="row" data-label="Account">Correspondent bank:</td>
                                <td data-label="Due Date">CITIBANK NA NEW YORK, USA</td>
                                </tr>
                                <tr>
                                <td scope="row" data-label="Account">Correspondent bank account USD:</td>
                                <td data-label="Due Date">36394582</td>
                                </tr>
                                <tr>
                                <td scope="row" data-label="Account">Correspondent bank swift code:</td>
                                <td data-label="Due Date">HABBPKKATIC</td>
                                </tr>
                                <tr>
                                <td scope="row" data-label="Account">Details of payment</td>
                                <td data-label="Due Date">100% ADV, PAYMENT AGAINST<br> CONTRACT no:5754 DATED 09.11.2022</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="diector">
                        <p>For Garibsons (Pvt) LIMITED</p><br>
                        ___________________________<br>
                        <p><strong>Director</strong></p>
                    </div>
                </div> -->
           
        </div>
    </div>
    
