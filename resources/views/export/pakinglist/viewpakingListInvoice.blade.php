

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
table{border:1px solid #000;border-collapse:collapse;margin:0;padding:0;width:100%;table-layout:fixed;}
table caption{font-size:1.5em;margin:.5em 0 .75em;}
table tr{border:1px solid #000;padding:0.35em;}
table th,table td{padding:0.625em;text-align:center;border:1px solid #000;text-align:left;font-weight:bold;}
table th{font-size:.85em;letter-spacing:.1em;text-transform:uppercase;text-align:center;}
@media screen and (max-width:600px){table{border:0;}
table caption{font-size:1.3em;}
table thead{border:1px solid #000;clip:rect(0 0 0 0);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute;width:1px;}
table tr{border-bottom:3px solid #ddd;display:block;margin-bottom:.625em;}
table td{border-bottom:1px solid #ddd;display:block;font-size:.8em;text-align:right;}
table td::before{/* * aria-label has no advantage,it won't be read inside a table content:attr(aria-label);*/
 content:attr(data-label);float:left;font-weight:bold;text-transform:uppercase;}
table td:last-child{border-bottom:0;}
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


/* new css saquib */
.ordergeincss .table-bordered > thead > tr > th,.ordergeincss .table-bordered > tbody > tr > th,.ordergeincss .table-bordered > tfoot > tr > th,.ordergeincss .table-bordered > thead > tr > td,.ordergeincss .table-bordered > tbody > tr > td,.ordergeincss .table-bordered > tfoot > tr > td{border:none !important;}
.ordergeincss .table-bordered{border:none !important;}


/* Packing lsit */
.profo-apkc{text-align:center !important;}


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
            <!-- <div class="col-md-4"> -->
                <div class="praga">
                    <div class="profo-apkc">
                        <h4>COMMERCIAL INVOICE # {{$pakinglist->invoice_no}}.EXPORT ORDER # {{$pakinglist->voucehr_no}} .DT: {{$pakinglist->created_at}}.</h4>
                        <h4></h4>
                        <br>
                    </div>
                </div>
            <!-- </div> -->
            <!-- <div class="col-md-8"></div> -->
            <!-- <div class="col-md-12"> -->
                <div class="table-responsive">
                    <table class="table table-bordered ordergeincss  sf-table-list paskitaj " id="EmpExitInterviewList " >
                        <colgroup>
                            <col span="1" style="width: 2%;">
                        </colgroup>
                            <thead>
                            <tr>
                                <th style="border:1px solid black;">S.L<br>NO.</th>
                                <th style="border:1px solid black;">CONTAINER<br>NUMBER'S</th>
                                <th style="border:1px solid black;">GROSS WEIGHT</th>
                                <th style="border:1px solid black;">NET WEIGHT</th>
                                <th style="border:1px solid black;">BAGS</th>
                                <th style="border:1px solid black;">VEHICLE<br>NUMBER</th>
                                <th style="border:1px solid black;">DATE OF EMPTY</th>
                                <th style="border:1px solid black;">DATE OF <br>LOADING</th>
                                <th style="border:1px solid black;">LOADING POINT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
               
                            $i = 1;
                            $total = 0;
                            $total_qty =0;
                          
                            
                            foreach ($pakinglistdata as $item) {
                            ?>
                          
                            <tr>          
                                <td class="text-left" style="border:1px solid black;"><?php echo $i; ?> </td>
                                <td class="text-left" style="border:1px solid black;"><?php echo $item->container; ?> </td>
                                <td class="text-center" style="border:1px solid black;"><?php echo number_format($item->gross_weight,2); ?> </td>
                                <td class="text-center" style="border:1px solid black;"><?php echo number_format($item->net_weight,2); ?></td>
                                <td class="text-center"  style="border:1px solid black;"><?php echo number_format($item->qty,2); ?></td>
                                <td class="text-center"  style="border:1px solid black;"><?php echo $item->vechle; ?></td>
                                <td class="text-center"  style="border:1px solid black;"><?php  echo $item->date_of_empty; ?></td>
                                <td class="text-center"  style="border:1px solid black;"><?php echo $item->date_of_loading; ?></td>
                                <td class="text-center"  style="border:1px solid black;"><?php echo $item->loading_port; ?></td>
                            </tr>
                          <?php
                            $total_qty +=  $item->qty;
                          
                          $i++; } ?>

                         
                        
                        </tbody>
                    </table>
                </div>
            <!-- </div> -->
        </div>
    </div>
</div>
    
   