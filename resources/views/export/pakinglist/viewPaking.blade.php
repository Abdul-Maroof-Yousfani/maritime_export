<?php
use App\Helpers\CommonHelper;
use App\Helpers\StoreHelper;
use App\Models\IncoTerm;
use App\Models\ModeOfTransport;
$id = $_GET['id'];
$m = Session::get('run_company');
$currentDate = date('Y-m-d');
$total_expense = 0;

?>

<style>
textarea{border-style:none;border-color:Transparent;}
.col-lg-12{width:100%;}
.pack_contpack h5{font-weight:bold;text-transform:uppercase;font-size:20px;}
.pack_contpack{margin-bottom:30px;}
.pack_cont{display:flex;align-items:baseline;justify-content:space-between;}
.pack_cont h5{margin:0px;font-size:15px;font-weight:bold;text-transform:uppercase;justify-content:space-between;}
.packflex {
    width: 77%;
}
.pcs h3{font-size:21px;font-weight:600;margin-bottom:30px;}
.gafa{text-align:center;}
.signature_bor{border-top:solid 1px #CCC;padding-top:7px;}
.packing_list_head h5{font-weight:bold !important;}
.packing_list_head{margin-bottom:-9px !important;}
.packing_bags{border-bottom:2px solid #000 !important;}
.packing_bags{margin-bottom:15px !important;}



 @media print{.printHide{display:none !important;}
.fa{font-size:small;!important;}
.table-bordered{border:1px solid black;}
table.table-bordered>thead>tr>th{border:1px solid blue !important;}
}

</style>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        <?php CommonHelper::displayPrintButtonInView('printPurchaseRequestVoucherDetail', '', '1'); ?>
    </div>
</div>
<div style="line-height:5px;">&nbsp;</div>
<div class="row" id="printPurchaseRequestVoucherDetail">
    <!--< ?php  StoreHelper::displayApproveDeleteRepostButtonPurchaseRequest($m,$sales_order->purchase_request_status,$sales_order->status,$row->id,'purchase_request_no','purchase_request_status','status','purchase_request','purchase_request_data');?></div><!-->
    <div style="line-height:5px;">&nbsp;</div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            {{-- {{CommonHelper::get_company_logo(Session::get('run_company'))}} --}}
        </div>
    </div>

    <div class="packlist">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <div class="packs">
                    <div class="pack_contpack">
                        <h5>Packing List</h5>
                    </div>
                    <div class="pack_cont packing_list_head">
                        <h5>No:</h5>
                        <div class="packflex">
                            <p>{{ $exportInvoice->commercial_invoice_no ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="pack_cont packing_list_head">
                        <h5>Date:</h5>
                        <div class="packflex">
                            <p>{{ $pakinglist->import_date ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="pack_cont packing_list_head packing_bags">
                        <h5>no. of bags:</h5>
                        <div class="packflex">
                            <p>{{ $pakinglist->total_qty ?? 0 }}</p>
                        </div>
                    </div>
                    @if (!empty($pakinglist->consignee))
                        <div class="pack_cont packing_list_head">
                            <h5>Consignee:</h5>
                            <div class="packflex">
                                <p>{!! $pakinglist->consignee ?? '-' !!}</p>
                            </div>
                        </div>
                    @endif
                    @if (!empty($pakinglist->notify))
                        <div class="pack_cont packing_list_head">
                            <h5>Notify:</h5>
                            <div class="packflex">
                                <p>{!! $pakinglist->notify ?? '-' !!}</p>
                            </div>
                        </div>
                    @endif

                    <div class="pack_cont packing_list_head">
                        <h5>Ship Name:</h5>
                        <div class="packflex">
                            <p>{{ $exportInvoice->ship_name ?? '-' }}</p>
                        </div>
                    </div>


                    <div class="pack_cont packing_list_head">
                        <h5>Billing Lading:</h5>
                        <div class="packflex">
                            <p>{{ $exportInvoice->bill_of_loading ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="pack_cont packing_list_head">
                        <h5>Net Weight:</h5>
                        <div class="packflex">
                            <p>{{ $pakinglistdata->sum('net_weight') }} {{ $exportOrderData->uom_id }}</p>
                        </div>
                    </div>

                    <div class="pack_cont packing_list_head">
                        <h5>Gross Weight:</h5>
                        <div class="packflex">
                            <p>{{ $pakinglistdata->sum('gross_weight') }} {{ $exportOrderData->uom_id }}</p>
                        </div>
                    </div>
                    <div class="pack_cont packing_list_head">
                        <h5>Date:</h5>
                        <div class="packflex">
                            <p>{{ $pakinglist->import_date }}</p>
                        </div>
                    </div>
                    <div class="pack_cont packing_list_head">
                        <h5>Contract No:</h5>
                        <div class="packflex">
                        <p>{{ $exportInvoice->pro_contract_no }}</p>
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

    {{-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div style="width:49%; float:left;">
                <table>
                    <tbody>

                    <tr>
                        <td class="text-left" >No:</td>
                        <td class="text-left" >{{$exportInvoice->commercial_invoice_no}}</td>
                    </tr>
                
                    <tr>
                        <td class="text-left" >Date:</td>
                        <td class="text-left" >{{ Carbon\Carbon::parse($pakinglist->created_at)->format('d-m-Y')}}</td>
                    </tr>
                    <tr style="border-bottom:1px solid black">
                        <td class="text-left">no. of bags:</td>
                        <td class="text-left">&nbsp;&nbsp;{{$pakinglist->total_qty}}</td>
                    </tr>
                    </tbody>
                </table>

                <table>
                    <tbody>

                    <tr>
                        <td class="text-left" >Ship Name:</td>
                        <td class="text-left" >{{$exportInvoice->ship_name}}</td>
                    </tr>
                    <tr>
                        <td class="text-left" >Billing Lading:</td>
                        <td class="text-left" >{{$exportInvoice->bill_of_loading}}</td>
                    </tr>
                    <tr >
                        <td class="text-left" >Net Weight:</td>
                        <td class="text-left" >{{$pakinglistdata->sum('net_weight')}} </td>
                    </tr>
                    <tr style="border-bottom:1px solid black">
                        <td class="text-left" >Gross Weight:</td>
                        <td class="text-left" >{{$pakinglistdata->sum('gross_weight')}} </td>
                    </tr>
                    </tbody>
                </table>
            </div> 
    </div> --}}

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="pcs">
                <h3>Packing Details</h3>
            </div>
        </div>
    </div>

    <div id="actual">
        <div class="table-responsive packing  packnewlsit">
            <table id="tablee" class="table paktable " style="border: solid 1px black;">
                <thead>
                    <tr>
                        <th class="text-center" style="border:1px solid black;" rowspan="2">S/no</th>
                        <th class="text-center" style="border:1px solid black;" rowspan="2">Container
                        </th>
                        <th class="text-center" style="border:1px solid black;"rowspan="2">Bags</th>
                        <th class="text-center" style="border:1px solid black;" colspan="2">Weight</th>
                        <th class="text-center" style="border:1px solid black; width: 40%;" colspan="1">
                            Description</th>
                    </tr>
                    <tr>
                        <th class="text-center" style="border:1px solid black;"rowspan="2">Net Weight
                        </th>
                        <th class="text-center" style="border:1px solid black;"rowspan="2">Gross Weight
                        </th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php
                    
                    $i = 1;
                    $total = 0;
                    $total_qty = 0;
                    $total_net = 0;
                    $total_gross = 0;
                    ?>

                    @foreach ($pakinglistdata->get() as $item)
                        <tr>
                            <td class="text-center" style="border:1px solid black;"><?php echo $i; ?>
                            </td>
                            <td class="text-center" style="border:1px solid black;"><?php echo $item->container; ?>

                            </td>
                            <td class="text-center" style="border:1px solid black;"><?php echo number_format($item->qty, 0); ?>

                            </td>
                            <td class="text-center" style="border:1px solid black;"><?php echo number_format($item->net_weight, 3); ?>
                                
                            </td>
                            <td class="text-center" style="border:1px solid black;"><?php echo number_format($item->gross_weight, 3); ?>

                            </td>
                            @if ($loop->first)
                                <td class="text-center" rowspan="{{ $pakinglistdata->count() }}"
                                    style="border:1px solid black;">
                                    {!! $pakinglist->packing_description !!}
                                     ({{ $exportInvoice->pro_contract_no }})<br/>
                                     ({{ $pakinglist->import_date }})
                                </td>
                            @endif

                        </tr>
                        <?php
                        $total_qty += $item->qty;
                        $total_net += $item->net_weight;
                        $total_gross += $item->gross_weight;
                        
                        $i++; ?>
                    @endforeach

                    <tr>
                        <td class="text-right" style="border:1px solid black;" colspan="2">Total</td>
                        <td class="text-center" id="importtd"><?php echo number_format($total_qty, 0); ?>
                            <input type="hidden" name="total_qty" id="import_qty"
                                value="<?php echo number_format($total_qty, 0); ?>">
                        </td>
                        <td class="text-center" id="total_netimporttd"><?php echo number_format($total_net, 3); ?>
                            <input type="hidden" name="total_net" id="total_net"
                                value="<?php echo number_format($total_net, 3); ?>">
                        </td>
                        <td class="text-center" id="total_grossimporttd"><?php echo number_format($total_gross, 3); ?>
                            <input type="hidden" name="total_gross" id="total_gross"
                                value="<?php echo number_format($total_gross, 3); ?>">
                        </td>
                        {{-- <td class="text-right" style="border:1px solid black;" colspan="1"></td> --}}
                    </tr>
                    {{-- <tr>
                        <td class="text-right" style="border:1px solid black;">Details</td>
                        <td class="text-right" style="border:1px solid black;" colspan="6"></td>
                    </tr> --}}
                </tbody>
            </table>
        </div>

    </div>

    <!-- <div class="stopsig">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:40px;">
                <div class="container-fluid">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                     <div class="sinssg">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center">
                                    <h6 class="">Prepared By: </h6>
                                    <b>
                                        <p><?php echo strtoupper($pakinglist->username); ?></p>
                                    </b>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center">
                                    <h6 class="">Approved By:</h6>
                                    <b>
                                        <p></p>
                                    </b>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center">
                                    <h6 class="">Approved By:</h6>
                                    <b>
                                        <p></p>
                                    </b>
                                </div>


                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center">
                                    <h6 class="">Approved By:</h6>
                                    <b>
                                        <p></p>
                                    </b>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>-->
            

        </div>

    </div>



    <div class="gafa">
        <img src="{{ asset('/public/images/gafa.png') }}" alt="">
    </div>
</div>



