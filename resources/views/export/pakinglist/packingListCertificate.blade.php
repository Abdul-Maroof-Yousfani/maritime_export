

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
        <div class="row"> 
             <div class="col-md-8">
                <?php
                $gross_wt = 0;
                $net_wt = 0;
                $item_name  = '';
                $uom = '';
                $pack_type ='';
                $pack_size = 0;
                $qty = 0 ;
                    foreach ($pakinglistdata as $item) {

                       $net_wt += $item->net_weight;
                       $gross_wt += $item->gross_weight;
                       $item_name  = $item->sub_ic;
                       $uom = $item->uom_id;
                       $pack_type = $item->pack_type;
                       $pack_size = $item->pack_size;
                       $qty +=  $item->paking_qty;
                  }

                ?>
                 <div class="paknsg">

                    <p> {{$pakinglist->created_at}}</p>
                    <div class="pachrad">
                        <p><strong><u>PACKING CERTIFICATE</u></strong></p>
                    </div>
                  
                    <table style="border:none !important;width:80%">
                        <tr>
                            <td style="border:none !important; width:18%"> INVOICE NO:</td>
                            <td style="border:none !important"> {{$pakinglist->invoice_no}}</td>
                        </tr>
                        <tr>
                            <td style="border:none !important;width:18%"> QUANTITY:</td>
                            <td style="border:none !important"> {{$qty}}</td>
                        </tr>
                    </table>
                <table style="border:none !important;width:80%">
                        <tr>
                            <td style="border:none !important;width:1.7%;"> QUALITY:</td>
                            <td style="border:none !important;width:8% !important;  min-width: fit-content; " > {{$pakinglist->quality_remarks}}</td>
                        </tr>
                </table>
                <table style="border:none !important;width:80%">
                        <tr>
                            <td style="border:none !important;width:18%">CONSIGNEE:</td>
                            <td style="border:none !important"> <p>{{$pakinglist->name}}<br>{{$pakinglist->address}}</p></td>
                        </tr>
                        <tr>
                            <td style="border:none !important;width:18%">PACKING:</td>
                            <td style="border:none !important"> <p>{{$item_name. ' '.$uom . ' '.$pack_type.' '.  $pack_size}}</p></td>
                        </tr>
                        <tr>
                            <td style="border:none !important;width:18%">B/L NO:</td>
                            <td style="border:none !important"> <p>{{$pakinglist->bill_of_loading}}</p></td>
                        </tr>
                        <tr>
                            <td style="border:none !important;width:18%">VESSEL NAME:</td>
                            <td style="border:none !important"> {{$pakinglist->ship_name}}</td>
                        </tr>
                       
                    </table>
                    <table style="border:none !important;width: 100%;line-height: 15px;">
                        <tr>
                            <td style="border:none !important;width: 39%;">TARE WEIGHT OF BAGS PER CONTAINER:</td>
                            <td style="border:none !important"> -</td>
                        </tr>
                        <tr>
                            <td style="border:none !important; width: 39%;">NET WEIGHT PER CONTAINER:</td>
                            <td style="border:none !important">{{$net_wt}}</td>
                        </tr>
                        <tr>
                            <td style="border:none !important; width: 39%;"> GROSS WEIGHT PER CONTAINER:</td>
                            <td style="border:none !important">{{  $gross_wt}}</td>
                        </tr>
                    </table>

                </div>
             </div>

             <div class="col-md-4">

             </div>
            </div>
             <br>
            <div class="row">
                <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-bordered sf-table-list packid " style="width:100%">
                        <tbody>
                            <thead>
                                <tr>
                                    <th style="border:1px solid black;"></th>
                                    <th style="border:1px solid black;">CONTAINERS</th>
                                    <th style="border:1px solid black;">NO OF</th>
                                    <th style="border:1px solid black;">NET WT:</th>
                                    <th style="border:1px solid black;">GROSS WT:</th>
                                </tr>
                            </thead>
                            <thead>
                                <tr>
                                    <th style="border:1px solid black;"></th>
                                    <th style="border:1px solid black;"><u>NOS</u></th>
                                    <th style="border:1px solid black;"><u>BAGS</u></th>
                                    <th style="border:1px solid black;">M.TONS</th>
                                    <th style="border:1px solid black;">M.TONS</th>
                                </tr>
                            </thead>
                            <?php
               
                            $i = 1;
                            $total = 0;
                            $total_qty =0;
                            $net_we = 0;
                            $gross_we = 0;
                          
                            
                            foreach ($pakinglistdata as $item) {
                            ?>
                          
                            <tr>          
                                <td class="text-left" style="border:1px solid black;"><?php echo $i; ?> </td>
                                <td class="text-left" style="border:1px solid black;"><?php echo $item->container; ?> </td>
                                <td class="text-center"  style="border:1px solid black;"><?php echo number_format($item->paking_qty,2); ?></td>
                                <td class="text-center" style="border:1px solid black;"><?php echo number_format($item->net_weight,2); ?></td>
                                <td class="text-center" style="border:1px solid black;"><?php echo number_format($item->gross_weight,2); ?> </td>
           
                            </tr>
                          <?php
                            $total_qty +=  $item->paking_qty;
                            $net_we += $item->net_weight;
                            $gross_we += $item->gross_weight;
                            $i++; 
                             } ?>
                            <tr>
                                <td class="text-right" style="padding:4px;border:1px solid black;" colspan="2"> </td>
                                <td class="text-center" style="padding:4px;border:1px solid black;">{{number_format($total_qty,2)}}</td>
                                <td class="text-center" style="padding:4px;border:1px solid black;">{{number_format($net_we,2)}}</td>
                                <td class="text-center" style="padding:4px;border:1px solid black;">{{number_format($gross_we,2)}}</td>
                            </tr>
                            </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                
            </div>
        </div>
                
                
                <p>WITH REFERENCE TO ABOVE, WE HEREBY CONFIRM THAT THE GROSS, NETT AND<br>TARE WEIGHT OF THE CONTAINER IS CORRECT AS MENTIONED ON THE ABOVE B/L<br>AND PACKING LIST.</p>
                <div class="sibs">
                    <p>For GARIBSONS (PVT) LTD</p>
                    <br>
                    <br>
                    <p>DIRECTOR</p>
                </div>
        
    </div>
</div>
    
   