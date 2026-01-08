<?php
use App\Helpers\CommonHelper;
use App\Helpers\StoreHelper;
use App\Models\IncoTerm;
use App\Models\ModeOfTransport;
use App\Models\ExportInvoice;
use App\Models\ExportInvoiceData;
$id = $_GET['id'];
$m = Session::get('run_company');
$currentDate = date('Y-m-d');
$total_expense = 0;
$words = [
    1 => 'One',
    2 => 'Two',
    3 => 'Three',
    4 => 'Four',
    5 => 'Five',
    6 => 'Six',
    7 => 'Seven',
    8 => 'Eight',
    9 => 'Nine',
    10 => 'Ten',
   
];

// Test the function
$number = 1;

//print_r($pakinglist);
//die;
?>

<style>
.biilpa{display:flex;justify-content:space-between;align-items:baseline;margin-bottom: -13px;}

.biilpa h5{font-weight:bold;}
.bilextpra{width:65%;}
.gafa{text-align:center;}
.table_respons{margin-top:30px}
.bill_of_landing_head {
    display: none !important;
}

</style>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        <?php CommonHelper::displayPrintButtonInView('printPurchaseRequestVoucherDetail', '', '1'); ?>
    </div>
</div>
<div style="line-height:5px;">&nbsp;</div>
    <div class="row" id="printPurchaseRequestVoucherDetail">
        <div class="billpra">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="bill_of_landing_head">
                        <span class="subHeadingLabelClass">Bill Of Lading List</span>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <div class="biilpa">
                        <h5>"E" Form No.</h5>
                        <div class="bilextpra">
                            <p>
                                @foreach (json_decode($pakinglist->form_no) as $value)
                                    {{ $value }},<br>
                                @endforeach
                            </p>
                        </div>
                    </div>

                    <div class="biilpas">
                        {{--   <p>{{ $pakinglist->ship_name }}</p> --}}
                    </div>

                    <div class="biilpa">
                        <h5>Name of Shipper</h5>
                        <div class="bilextpra">
                            {!! $bol->name_of_shipper !!}
                            {{-- <p>
                                GARIBSONS (PVT.) LTD. <br>
                                C-69/71, 12TH COMMERCIAL ST., PHASE II EXT., DHA <br>
                                KARACHI, 75500, PAKISTAN <br>
                                PH:9221 111427421, FAX: 9221 111427422
                            </p> --}}
                        </div>
                    </div>

                    @foreach ($bol_notify as $key => $notify)
                        <div class="biilpa">
                            <h5>NOTIFY {{ $words[++$key] }}:</h5>
                            <div class="bilextpra">
                                <p>{!! $notify->notify_detail !!}</p>
                            </div>
                        </div>
                    @endforeach

                    <div class="biilpa">
                        <h5>CONSIGNEE:</h5>
                        <div class="bilextpra">
                            <p>{!! $bol->consignee !!}</p>
                        </div>
                    </div>
                    <!-- <div class="biilpa">
                        <h5>Product Details:</h5>
                        <div class="bilextpra">
                            <p>{!! $bol->description !!}</p>
                        </div>
                    </div>             -->
                    <!-- {{-- <div class="biilpa">
                        <h5>BENEFICIARY DETAILS:</h5>
                        <div class="bilextpra">
                            <p>
                                @php
                                    $bankDetail = App\Models\Bank::find($pakinglist->bank);
                                @endphp
                                {{ 'BANK: ' . $bankDetail->bank_name }}<br>
                                {{ 'BANK ADDRESS: ' . $bankDetail->bank_address }}<br>
                                {{ 'SWIFT: ' . $bankDetail->swift_code }}<br>
                                {{ 'A/C TITLE: ' . $bankDetail->account_title }}<br>
                                {{ 'A/C NO: ' . $bankDetail->account_no }}<br>
                                {{ 'IBAN: ' . $bankDetail->IBAN_no }}<br> <br>
                            </p>
                        </div>
                    </div> --}} -->

                    <div class="biilpa">
                        <h5>SHIP NAME /Voy:</h5>
                        <div class="bilextpra">
                            <p>{{ $pakinglist->ship_name }}</p>
                        </div>
                    </div>

                    <div class="biilpa">
                        <h5>PORT PF LOADING</h5>
                        <div class="bilextpra">
                            <p>{{ $pakinglist->port_loading }}</p>
                        </div>
                    </div>

                    <div class="biilpa">
                        <h5>PORT PF DISCHARGE</h5>
                        <div class="bilextpra">
                            <p>{{ $pakinglist->port_of_discharge }}</p>
                        </div>
                    </div>

                    <div class="biilpa">
                        <h5>Bill of Lading No. & Date:</h5>
                        <div class="bilextpra">
                            <p>{{ $pakinglist->bill_of_loading }}</p>
                        </div>
                    </div>
                    <div class="biilpa">
                        <h5>Booking No:</h5>
                        <div class="bilextpra">
                            <p>{{ $bol->booking_no }}</p>
                        </div>
                    </div>
                    <div class="biilpa">
                        <h5>Forwarder:</h5>
                        <div class="bilextpra">
                            <p>{{ $bol->forwarder }}</p>
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
    
        <!-- <table class="" style="border:none !important;width:50%;line-height: 19px;">
            <tbody>
                <tr>
                    <td style="border:none !important"></td>
                    <td style="border:none !important">
                    
                    </td>
                </tr>
                <tr style="border-bottom:solid 1px black">
                    <td style="border:none !important;  vertical-align: top;"></td>
                    <td style="border:none !important">
                    
                    </td>
                    <td style="border:none !important"></td>
                </tr>
            </tbody>
        </table> -->
        <!-- <div class="row">
            <div class="col-md-8">
                <table class="" style="border:none !important;width:50%;line-height: 19px;">
                    <tbody>
                        <tr>
                            <td style="border:none !important"</td>
                            <td style="border:none !important"></td>
                        </tr>
                        <tr style="border-bottom:solid 1px black">
                            <td style="border:none !important"></td>
                            <td style="border:none !important"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> -->
        <!-- <div class="row">
            <div class="col-md-8">
                <table class="" style="border:none !important;width:50%;line-height: 19px;">
                    <tbody>
                        <tr>
                            <td style="border:none !important;  vertical-align: top;"></td>
                            <td style="border:none !important"></td>
                        </tr>
                        <tr style="border-bottom:solid 1px black">
                            <td style="border:none !important; vertical-align: top;"></td>

                            <td style="border:none !important">
                            
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> -->
        <!-- <div class="row">
            <div class="col-md-8">
                <table class="" style="border:none !important;width:50%;line-height: 19px;">
                    <tbody>
                        <tr>
                            <td style="border:none !important"></td>
                            <td style="border:none !important"></td>
                        </tr>
                        <tr>
                            <td style="border:none !important"></td>
                            <td style="border:none !important"></td>
                        </tr>
                        <tr>
                            <td style="border:none !important"></td>
                            <td style="border:none !important"></td>
                        </tr>
                        <tr>
                            <td style="border:none !important"></td>
                            <td style="border:none !important"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> -->

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
            <br/><br/>
            <div class="table-response  ">
                    <table class="ecoverray table table-bordered sf-table-list  commercial_table2  bill_of_landing_form" id="EmpExitInterviewList ">
                    <?php

                    $exportInvoices =  ExportInvoice::where(['export_invoices.status' => 1, 'export_invoices.id' => $pakinglist->id])
                    ->join('sale_order_exports', 'sale_order_exports.id', 'export_invoices.sale_order_export_id')
                    ->join('export_performas', 'export_performas.sale_order_id', 'sale_order_exports.id')
                    ->leftjoin('inco_terms', 'inco_terms.id', 'sale_order_exports.incoterm')
                    ->join('customers', 'customers.id', 'sale_order_exports.buyer_id')
                    ->select('export_performas.*', 'customers.name as customer_name', 'customers.address', 'inco_terms.name as icoterm_name', 'sale_order_exports.*', 'export_invoices.*')
                    ->first();
                    $exportInvoicesData = ExportInvoiceData::where(['export_invoice_datas.status' => 1, 'export_invoice_datas.export_invoice_id' => $pakinglist->id])
                    ->join('sale_order_data_exports', 'sale_order_data_exports.id', 'export_invoice_datas.sale_order_export_data_id')
                    ->join('subitem', 'subitem.id', 'sale_order_data_exports.item_id')
                    ->join('sale_order_exports', 'sale_order_exports.id', 'sale_order_data_exports.sale_order_export_id')

                    ->select('subitem.pack_size as item_size', 'subitem.sub_ic', 'sale_order_exports.*', 'sale_order_data_exports.*', 'export_invoice_datas.*')
                    ->get();    


                    $total_amount = 0;
                    if (!empty($exportInvoices->currencey_id)) {
                        $name_currency1 = App\Models\Currency::find($exportInvoices->currencey_id);
                        $name_currency = $name_currency1['curreny'];
                    } else {
                        $name_currency = '-';
                    }
                    ?>

                    <thead>
                        <tr>
                            <th class="value_brand">MARKS & NOS./ BRAND</th>
                            <th>PACKAGES</th>
                            <th>NET -WEIGHT M ton</th>
                            <th>GROSS WEIGHT M ton</th>
                            <th style="width: 40%;">DESCRIPTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sumBags = 0;
                            $sumNet = 0;
                            $sumGross = 0;
                            $sumunit = 0;
                            $sumtotal = 0;
                        @endphp
                        @foreach ($exportInvoicesData as $value)
                            <tr rowpsan="4">
                                @php
                                    $size = $value->pack_size ?? 1;
                                    if($size == 0){
                                        $bags = $value->issue_qty;
                                    }else {
                                        $bags = ($value->issue_qty / $size) * 1000;
                                    }
                                    $amount = $value->issue_qty * $value->rate;
                                    
                                    $sumBags += $bags;
                                    $sumNet += $value->issue_qty;
                                    $sumGross += $value->gross_weight;
                                    $sumunit += $value->rate;
                                    $sumtotal += $amount;
                                @endphp
                               
                        <td class="dragon_td_no_border2">{{ $value->brand }}</td>
                        <td class="dragon_td_no_border">{{ number_format($bags) }}</td>
                        <td class="dragon_td_no_border">{{ number_format($value->issue_qty, 3) }}</td>
                        <td class="dragon_td_no_border">{{ number_format($value->gross_weight, 3) }}</td>
                        <td class="dragon_td_no_border4">
                        {!! $exportInvoices->description !!}</br/></br/>
                        {{ 'PACKED IN ' . $value->pack_size . ' KG ' . $value->pack_type }} </br/></br/>
                        CONTRACT NO: {{ $exportInvoices->pro_contract_no }} </br/> 
                        DATED: {{ $exportInvoices->invoice_date }}</br/></br/> 
                        HS CODE: {{ $exportInvoices->hs_code }} </br/> </br/>
                        INVOICE NO: {{ $exportInvoices->invoice_no }} </br/> </br/> 
                        <span style="font-weight:bold">21 DAYS COMBINED AT FREE TIME AT PORT OF DISCHARGE</span>
    
                         </td>
                        
                        </tr>
                        
                        <?php
                        $total_amount += $amount;
                        
                        ?>
                        @endforeach
                        <tr>
                            <td class="dragon_td_no_border6"></td>
                            <td class="dragon_td_no_border6">{{ number_format($sumBags) }}</td>
                            <td class="dragon_td_no_border6">{{ number_format($sumNet, 3) }}</td>
                            <td class="dragon_td_no_border6">{{ number_format($sumGross, 3) }}</td>
                            <td class="dragon_td_no_border6"></td>
                            
                           
                        </tr>
                    </tbody>
                </table>
                </div>
                <br/><br/>



                <div class="table_respons">
                    <table class="table-bordered  bill_of_landing_form" style="border:none !important;width:100%;line-height: 19px;">
                        <thead>
                            <tr>
                                <th class="text-center" style="border:1px solid black;" rowspan="2">S/no</th>
                                <th class="text-center" style="border:1px solid black;" rowspan="2">Container</th>
                              
                                <th class="text-center" style="border:1px solid black;"rowspan="2">PACKAGES</th>
                                <th class="text-center" style="border:1px solid black;" colspan="2">Weight</th>
                                <!-- <th class="text-center" style="border:1px solid black; width: 40%;" rowspan="2">DESCRIPTION</th> -->
                            </tr>
                            <tr>
                                <th class="text-center" style="border:1px solid black;"rowspan="2">Net Weight</th>
                                <th class="text-center" style="border:1px solid black;"rowspan="2">Gross Weight</th>
                            </tr>
                        </thead>
                        <?php
                             $i = 1;
                             $total_qty = 0;
                             $total_net = 0;
                             $total_gross = 0;
                        ?>
                        @foreach ($pakinglistdata as $item)
                            <tr>
                                <td class="text-center" style="border:1px solid black;"><?php echo $i++; ?>
                                </td>
                                <td class="text-center" style="border:1px solid black;">{{ $item->container }}</td>
                                
                                <td class="text-center" style="border:1px solid black;">{{ $item->paking_qty }}</td>
                                <td class="text-center" style="border:1px solid black;">{{ number_format($item->net_weight,3) }}</td>
                                <td class="text-center" style="border:1px solid black;">{{ $item->gross_weight }}</td>
                                @if ($loop->first)
                                    {{--<td class="text-center" rowspan="{{ count($pakinglistdata) }}"style="border:1px solid black; vertical-align: top;">
                                        <!-- {!! $pakinglist->quality_remarks !!} -->
                                        {!! $bol->description !!}
                                        <br><br>{{ 'PACKED IN ' . $item->pack_size . ' KG ' . $item->pack_type }}
                                    </td>--}}
                                @endif
                            </tr>
                            <?php
                                  $total_qty += $item->paking_qty;
                                  $total_net += $item->net_weight;
                                  $total_gross += $item->gross_weight;
                            ?>
                        @endforeach
                        <tr>
                        <td class="text-center" style="border:1px solid black;" colspan="2">Total</td>
                        <td class="text-center" style="border:1px solid black;" id="importtd"><?php echo number_format($total_qty, 0); ?>
                            <input type="hidden" name="total_qty" id="import_qty"
                                value="<?php echo number_format($total_qty, 0); ?>">
                        </td>
                        <td class="text-center" style="border:1px solid black;" id="total_netimporttd"><?php echo number_format($total_net, 3); ?>
                            <input type="hidden" name="total_net" id="total_net"
                                value="<?php echo number_format($total_net, 3); ?>">
                        </td>
                        <td class="text-center" style="border:1px solid black;" id="total_grossimporttd"><?php echo number_format($total_gross, 3); ?>
                            <input type="hidden" name="total_gross" id="total_gross"
                                value="<?php echo number_format($total_gross, 3); ?>">
                        </td>
                        {{--<td class="text-center" style="border:1px solid black;" colspan="1"></td>--}}
                    </tr>
                        <tbody></tbody>
                    </table>
                </div>
                        
               

            </div>
        </div>
        <div class="gafa">
            <img src="{{ asset('/public/images/gafa.png') }}" alt="">
        </div>
    </div>
