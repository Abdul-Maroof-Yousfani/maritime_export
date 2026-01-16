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
.col-lg-12{width:99%;}
.gafa{text-align:center;}
.conlfex{display:flex;margin-bottom:-10px;}
/* .paracotn{width:80%;}
*/
.cont_comt{margin-top:30px;}
.export_head{border:1px solid #000;}
.export_head h4{margin:0;padding:5px 0px;font-weight:bold;}
.cont_comt2 p{margin-bottom:10px;}
.export_th .table tbody tr th{padding-bottom:10px;padding-top:10px;}
.carws{margin-top:20px;}
.export_th.table > thead > tr > th,.export_th.table > tbody > tr > th,.table > tfoot > tr > th,.export_th .export_th.table > thead > tr > td,.export_th.table > tbody > tr > td,.table > tfoot > tr > td{padding:0px;line-height:inherit;vertical-align:inherit;border-top:none;padding-bottom:0px;}
.export_th .export_th.table > thead > tr > td,.export_th.table > tbody > tr > td,.table > tfoot > tr > td{line-height:inherit;vertical-align:inherit;border-top:none;padding-bottom:20px;}


@media print {
    .printHide{display:none !important;}
    .fa{font-size:small;!important;}
    .table-bordered{border:1px solid black;}
    table.table-bordered>thead>tr>th{border:1px solid blue !important;}
}
</style>
<?php
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        <?php CommonHelper::displayPrintButtonInView('printPurchaseRequestVoucherDetail', '', '1'); ?>
    </div>
</div>
<div style="line-height:5px;">&nbsp;</div>
<div class="row" id="printPurchaseRequestVoucherDetail" style="text-transform: uppercase;">
    <!--< ?php  StoreHelper::displayApproveDeleteRepostButtonPurchaseRequest($m,$sales_order->purchase_request_status,$sales_order->status,$row->id,'purchase_request_no','purchase_request_status','status','purchase_request','purchase_request_data');?></div>!-->
    <div style="line-height:5px;">&nbsp;</div>
    <div class="exprord">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <div class="contecpot">
                    <div class="export_head">
                        <h4 style="text-align: center;">
                           {{-- @if ($sales_order->approved_status == 0)
                                Export Order
                            @else
                                Contract
                            @endif--}}
                           {{ $sales_order->voucher_heading }}
                        </h4>
                    </div>
                    {{-- <table style="border:1px solid !important;width:100%" class="text-center"><tr><td colspan="2"><h4>Contract</h4></td></tr></table> --}}
                    <div class="cont_comt">
                        <div class="conlfex">
                            <p> {{ $sales_order->voucher_heading }} NO : </p>
                            <div class="paracotn">
                                <!-- <p>{{ '   ' . $sales_order->voucehr_no }}</></p> -->
                            </div>
                        </div>
                    
                        {{-- @if ($sales_order->approved_status == 1) --}}
                        <div class="conlfex">
                            <!-- <p>CONTRACT NO :</p>  -->
                            <div class="paracotn">
                                <p>{{ '   ' . $sales_order->contract_no }}</p>
                            </div>
                        </div>
                        {{-- @endif --}}

                        <div class="conlfex"> 
                           <p>DATED : </p> 
                            <div class="paracotn">
                                <p> @php
                                    $date = new DateTime($sales_order->voucher_date);
                                    echo ' ' . $date->format('F d, Y');
                                @endphp</p>
                            </div>
                        </div>
                        <div class="conlfex"> 
                           <!-- <p>Buyer Name : </p>  -->
                            <div class="paracotn carws">
                                <p>{{ '   ' . $sales_order->name }}</p>
                            </div>
                        </div>
                
                        <div class="conlfex"> 
                            <!-- <p> Address : </p> -->
                            <div class="paracotn">
                                <p>{{ '   ' . $sales_order->address }}</p>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <div class="gariblogo2">
                    <img src="{{ asset('/public/images/garibsons.jpg') }}" alt="">
                </div>
            </div>
        </div>

        <div class="secpra">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="cont_comt2">
                            <p><u><b>Quality</b></u></p>
                            <p> {{-- <textarea readonly class="form-control" name="quality_remarks">{{$sales_order->quality_remarks}}</textarea> --}}
                            {!! $sales_order->quality_remarks !!}</p>
                            <p></p>
                            <br>
                            @if (!empty($sales_order->product_specification))
                                <p><u><b>Product Specification</b></u></p>
                                <p>  {{-- <textarea readonly class="form-control" name="quality_remarks">{{$sales_order->quality_remarks}}</textarea> --}}
                                {!! $sales_order->product_specification !!}</p>
                            @endif
                            {{-- 
                            @if (!empty($sales_order->quality_remarks))  A)@endif
                            {{$sales_order->quality_remarks}}
                            &nbsp;
                            <p>- &nbsp;</p>
                            <p>BASIS LENGTH</p>
                            <p> {{$sales_order->base_legnth}}</p>
                            <p>- &nbsp;</p>
                            <p>BROKEN GRAIN </p>
                            <p> {{$sales_order->broken_grain}}</p>
                            <p>- &nbsp;</p>
                            <p>MOISTURE CONTENT</p><p>{{$sales_order->mosture_content}}</p>
                            <p>- &nbsp;</p>
                            <p>DAMAGED & YELLOW GRAINS</p>
                            <p>{{$sales_order->demand_yellow_grain}}</p>
                            <p>- &nbsp;</p>
                            <p>CHALKY GRAINS</p>
                            <p>{{$sales_order->chalky_grain}}</p>
                            <p>- &nbsp;</p>
                            <p>FOREIGN GRAINS</p>
                            <p>{{$sales_order->foreign_grain}}</p>
                            <p>- &nbsp;</p>
                            <p>PADDY GRAINS</p>
                            <p>{{$sales_order->paddy_grain}}</p>
                            <p>- &nbsp;</p>
                            <p>UNDERMILLED &  RED</p>
                            <p>{{$sales_order->under_milled}}</p>
                            <p>- &nbsp;</p>
                            <p>WELL MILLED /DOUBLE POLISH(SILKY)</p>
                            <p>{{$sales_order->milled_double_polish}}</p>
                            <p>- &nbsp;</p>
                            <p>WHITTENESS</p>
                            <p>{{$sales_order->whiteness}}</p>
                            --}}
                        </div>   
                    </div>
            </div>
        </div>
    </div>
                      
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-reponsive">
                <table class="export_th table" style="line-height: 1.5;">
    
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <th colspan="3"><u><b>PACKING</b></u></th>
                    </tr>
                    @foreach ($sales_order_data as $keyxs => $sales_orderxs)
                        @php
                            $pack_uom = $sales_orderxs->pack_uom ? CommonHelper::get_uom_name($sales_orderxs->pack_uom) : '-';
                        @endphp
                        {{-- .'    '.$sales_orderxs->uom_id  .'   '.$sales_orderxs->sub_ic --}}
                        
                        @if($sales_order->packing_view=='')
                        <tr>
                            <td>
                                @if ($sales_orderxs->pack_type == "bulk")
                                    IN BULK
                                @else
                                {{ number_format($sales_orderxs->pack_size,0) . '    ' . $pack_uom . '   ' . $sales_orderxs->pack_type }} 
                                {{-- . '   (' . $sales_orderxs->actual_qty . ' ' . $sales_orderxs->uom_id . ') - ' . $sales_orderxs->flc_qty . 'x' . $sales_orderxs->flc_size . ' FCL' --}}
                                @endif
                                @if($sales_orderxs->color != 'N/A')
                                        {{ $sales_orderxs->color }} 
                                @endif
                            </td>
                        </tr>
                        @elseif($keyxs==0)
                        <tr>
                            <td>
                                {!! $sales_order->packing_view !!}
                            </td>
                        </tr>        
                        @endif
                    @endforeach
                    <tr>
                        <th colspan="3"><u><b>QUANTITY</b></u></th>
                    </tr>
                    @foreach ($sales_order_data as $keyxs1 => $sales_orders)
                        @php
                            $variation = $sales_orders->qty_variation ? '+- ' . $sales_orders->qty_variation . '(%) - ' : ' ';
                            $fclQty = ($sales_orders->flc_qty == 0)? 1 : $sales_orders->flc_qty;
                        @endphp
                        @if($sales_order->quantity_view == '')
                        <tr>
                            <td>{{ $sales_orders->actual_qty . '    ' . $sales_orders->uom_id . $variation . $sales_orders->flc_qty . 'x' . $sales_orders->flc_size . ' FCL - ' . number_format($sales_orders->actual_qty / $fclQty, 2) . ' ' . $sales_orders->uom_id . ' PER ' . $sales_orders->flc_size . ' FCL' }}
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td>
                                {!! $sales_order->quantity_view !!}
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    <tr>
                        <th colspan="3"><u><b>MARKING / LABELING </b></u></th>
                    </tr>
                    <tr>
                        <td>{{ $sales_order->marking_labeling ?? '-' }}</td>
                    </tr>
    
                    <tr>
                        <th colspan="3"><u><b>PORT OF LOADING </b></u></th>
                    </tr>
                    <tr>
                        <td>{{ $sales_order->port_loading ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th colspan="3"><u><b>PORT OF DESTINATION </b></u></th>
                    </tr>
                    <tr>
                        <td>{{ $sales_order->port_of_discharge ?? '-' }}</td>
                    </tr>
    
    
    
                    <tr>
                        <th colspan="3"><u><b>UNIT PRICE</b></u></th>
                    </tr>
                    @foreach ($sales_order_data as $key => $value)
                        <tr>
                            <td>
                                <?php
                                if (!empty($sales_order->currencey_id)) {
                                    $name_currency1 = App\Models\Currency::find($sales_order->currencey_id);
                                    $name_currency = $name_currency1['curreny'];
                                } else {
                                    $name_currency = '-';
                                }
                                
                                if (!empty($sales_order->incoterm)) {
                                    $incoterm = App\Models\IncoTerm::find($sales_order->incoterm);
                                    $incoterm_name = $incoterm['name'];
                                } else {
                                    $incoterm_name = '-';
                                }
                                ?>
                                @if($sales_order->unit_price_view == '')
                                    {{ $name_currency . ' ' . $value->rate . ', PER ' . $sales_orders->uom_id }}
                                    NET
                                    @if ($incoterm_name == 'FOB')
                                        {{ $incoterm_name }}
                                    @else
                                        {{ $incoterm_name . '  ' . $sales_order->port_of_discharge . ', In ' . $sales_order->type_of_loading }}
                                    @endif
                                @else
                                    {!! $sales_order->unit_price_view !!}
                                @endif
                                <?php
                                $total_amount_ = $value->rate * $value->actual_qty;
                                // $a = CommonHelper::AmountInWords($total_amount_,$name_currency);
                                // echo '('.$a.').';
                                ?>
                                <input type="hidden" id="d_t_amount_{{ $key }}"
                                    value="{{ $value->rate }}">
                                    @if($sales_order->unit_price_view == '')
                                    <span id="rupees{{ $key }}"></span>
                                    @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="3"><u><b>TOTAL AMOUNT IN WORDS </b></u></th>
                    </tr>
                    <?php
                    $total = 0;
                    ?>
                    @foreach ($sales_order_data as $value1)
                        <?php $total += $value1->rate * $value1->actual_qty; ?>
                    @endforeach
                    <tr>
                        <td>
                            <?php
                            if (!empty($sales_order->currencey_id)) {
                                $name_currency1 = App\Models\Currency::find($sales_order->currencey_id);
                                $name_currency = $name_currency1['curreny'];
                            } else {
                                $name_currency = '-';
                            }
                            if (!empty($sales_order->incoterm)) {
                                $incoterm = App\Models\IncoTerm::find($sales_order->incoterm);
                                $incoterm_name = $incoterm['name'];
                            } else {
                                $incoterm_name = '-';
                            }
                            if($sales_order->total_price_view == ''){
                                echo $name_currency . ' ' . $total . ' NET ' . $incoterm_name . '  ' . $sales_order->port_of_discharge . ', In ' . $sales_order->type_of_loading;
                            }
                            ?>
                            <input type="hidden" id="d_t_amount_1001001" value="{{ $total }}">
                            <?php
                            $hundred = 100;
                            // Handle both old and new format
                            $advancePayment = 0;
                            if (isset($sales_order->is_advance)) {
                                $advancePayment = $sales_order->is_advance == 1 ? 0 : 0; // is_advance is just Yes/No, not percentage
                            } elseif (isset($sales_order->advance_payment)) {
                                $advancePayment = is_numeric($sales_order->advance_payment) ? $sales_order->advance_payment : 0;
                            }
                            $final_advance = $hundred - $advancePayment;
                            // $a = CommonHelper::AmountInWords($total,$name_currency);
                            // echo '('.$a.').';
                            ?>
                            @if($sales_order->total_price_view == '')
                            <span id="rupees1001001"></span>
                            @else
                            {!! $sales_order->total_price_view !!}
                            @endif
                        </td>
                    </tr>
                    @if ($sales_order->insurance_coverd != null)
                        <tr>
                            <th colspan="3"><u><b>INSURANCE</b></u></th>
                        </tr>
                        <tr>
                            <td>TO BE COVERED BY THE @if ($sales_order->insurance_coverd == 2)
                                    BUYER
                                @else
                                    SUPPLIER
                                @endif
                            </td>
                        </tr>
                    @endif
                    @if (!empty($sales_order->due_date))
                        <tr>
                            <th colspan="3"><u><b>SHIPMENT DELIVERY </b></u></th>
                        </tr>
                        @if($sales_order->shipment_delivery=='')
                            <tr>
                                @php
                                    $dateSHIPMENT = new DateTime($sales_order->due_date);
                                    $dateSHIPMENTTO = new DateTime($sales_order->delevery_date_to);
                                @endphp
                                <td>{{ 'DELIVERY DATE: ' . $dateSHIPMENT->format('F, Y') . ' - ' . $dateSHIPMENTTO->format('F, Y') }}
                                </td>
                            </tr>
                            @if ($sales_order->part_shipment != 0)
                                <tr>
                                    <td>PART SHIPMENT:
                                        {{ $sales_order->part_shipment == 2 ? 'SHALL BE PERMITTED' : 'SHALL NOT BE PERMITTED' }}
                                    </td>
                                </tr>
                            @endif
                            @if ($sales_order->transhipment != 0)
                                <tr>
                                    <td>TRANSHIPMENT:
                                        {{ $sales_order->transhipment == 2 ? 'SHALL BE PERMITTED' : 'SHALL NOT BE PERMITTED' }}
                                    </td>
                                </tr>
                            @endif
                        
                        @else
                            <tr>
                                <td>
                                {!! $sales_order->shipment_delivery !!}
                                </td>
                            </tr>

                        @endif
                    @endif
                    <tr>
                        <th colspan="3"><u><b>Payments</b></u></th>
                    </tr>
                    {{-- @if ($sales_order->mode_of_term == 14)
                        <tr>
                            <td>OPEN ACCOUNT</td>
                        </tr>
                    @else --}}
                    @if ($sales_order->mode_of_term)
                        <tr>
                            <td>{{ strtoupper(App\Models\ModeOfTerm::find($sales_order->mode_of_term)->name) }}
                            </td>
                        </tr>
                    @endif
                    @php
                        $isAdvance = 0;
                        if (isset($sales_order->is_advance)) {
                            $isAdvance = $sales_order->is_advance;
                        } elseif (isset($sales_order->advance_payment)) {
                            $isAdvance = ($sales_order->advance_payment == 'Yes' || $sales_order->advance_payment == 1) ? 1 : 0;
                        }
                    @endphp
                    @if ($isAdvance == 1)
                        <tr>
                            <td>{{ 'Advance payment required. Balance within ' . $sales_order->payment_days . ' Working Days Of BL and Invoice' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ '100% Within ' . $sales_order->payment_days . ' working days of BL and Invoice.' }}
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
            <div class="table-reponsive">
                <table class="table" style="width:100%;border:1px solid">
                    @php
                        if (!empty($sales_order->bank)) {
                            $bank_name = App\Models\Bank::find($sales_order->bank)->bank_name;
                            $bank_swift = App\Models\Bank::find($sales_order->bank)->swift_code;
                            $bank_ibn = App\Models\Bank::find($sales_order->bank)->IBAN_no;
                            $bank_account_no = App\Models\Bank::find($sales_order->bank)->account_no;
                            $bank_address = App\Models\Bank::find($sales_order->bank)->bank_address;
                            $account_title = App\Models\Bank::find($sales_order->bank)->account_title;
                        } else {
                            $bank_name = '-';
                            $bank_swift = '-';
                            $bank_ibn = '-';
                            $bank_address = '-';
                            $account_title = '-';
                        }
                    @endphp
                    <tr>
                        <td style="width:50%;border:1px solid">Beneficiary Bank Title:</td>
                        <td style="border:1px solid">{{ $account_title }}</td>
                    </tr>
                    <tr>
                        <td style="width:50%;border:1px solid">Beneficiary Bank:</td>
                        <td style="border:1px solid">{{ $bank_name }}</td>
                    </tr>
                    <tr>
                        <td style="width:50%;border:1px solid">Beneficiary Bank Address:</td
                            style="border:1px solid">
                        <td>{{ $bank_address }}</td>
                    </tr>
                    <tr>
                        <td style="width:50%;border:1px solid">Beneficiary Account No.</td>
                        <td style="border:1px solid">{{ $bank_account_no }}</td>
                    </tr>
                    <tr>
                        <td style="width:50%;border:1px solid">Beneficiary IBAN No:</td>
                        <td style="border:1px solid">{{ $bank_ibn }}</td>
                    </tr>
                </table>
            </div>
            <br>
            <div class="table-reponsive">
                <table class="table" style="width:100%;border:1px solid">

                    <tr>
                        <td style="width:50%;border:1px solid">Correspondent Bank:</td>
                        <td style="border:1px solid">{{ $sales_order->correspondent_bank }}</td>
                    </tr>
                    <tr>
                        <td style="width:50%;border:1px solid">Correspondent Bank Address:</td>
                        <td style="border:1px solid">{{ $sales_order->correspondent_account_address }}</td>
                    </tr>
                    <tr>
                        <td style="width:50%;border:1px solid">Correspondent Bank Account No:</td>
                        <td style="border:1px solid">{{ $sales_order->correspondent_account_no }}</td>
                    </tr>
                    <tr>
                        <td style="width:50%;border:1px solid">Correspondent Bank swift Code</td
                            style="border:1px solid">
                        <td>{{ $sales_order->correspondent_bank_swift }}</td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-c">
            <div class="table-reponsive">
                <table class="export_th table" style="line-height: 1.5;">

                    <tr>
                        <td>
                            <h4><b>Shipment Instruction</b></h4>
                        </td>
                    </tr>
                    @if (count($sales_order->consigneeData) > 0)
                        @foreach ($sales_order->consigneeData as $consignee)
                            <tr>
                                <td colspan="3"><u><b>Consignee</b></u></td>
                            </tr>
                            <tr>
                                <td>{!! $consignee->consignee !!}</td>
                            </tr>
                        @endforeach
                    @endif
                    @if (count($sales_order->notifyData) > 0)
                        @foreach ($sales_order->notifyData as $notify)
                            <tr>
                                <td colspan="3"><u><b>Notify Party</b></u></td>
                            </tr>
                            <tr>
                                <td>{{ $notify->notify }}</td>
                            </tr>
                        @endforeach
                    @endif
                    {{-- @if (!empty($sales_order->notify_party))
                        <tr>
                            <td colspan="3"><u><b>Notify Party</b></u></td>
                        </tr>
                        <tr>
                            <td>{{ $sales_order->notify_party ?? '-' }}</td>
                        </tr>
                    @endif --}}
                </table>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-reponsive">   
                <table class="export_th table" style="line-height: 1.5;">

                    <tr>
                        <th><u><b>Document To be Provided </b></u></th>
                    </tr>

                    <tr>
                        <td>
                            {{-- <textarea class="form-control" style="height: 290px; background-color: transparent; border-color: transparent;">{{ $sales_order->document_to_provided ?? '-' }}</textarea> --}}
                            {!! $sales_order->document_to_provided !!}
                        </td>
                    </tr>

                    <tr>
                        <th colspan="3"><u><b>Other Condition </b></u></th>
                    </tr>
                    <tr>
                        <td>{{ $sales_order->other_condition ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th colspan="3"><u><b>Force Majure </b></u></th>
                    </tr>
                    <tr>
                        <td>{{ $sales_order->force_majure ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th colspan="3"><u><b>Applicable Law </b></u></th>
                    </tr>
                    <tr>
                        <td>{{ $sales_order->application_law ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="table-reponsive">  
                <table class="export_th table" style="line-height: 1.5;">
                    <tr>
                        <th><b><u>SELLER</u> </b><br></th>
                    </tr>
                    <tr>
                        <td>GARIBSONS (PVT) LTD<br>
                            C-69/71,12TH COMMERCIAL ST.,PH-II EXT., DHA <br>
                            KARACHI 75500 (PAKISTAN)
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="table-reponsive"> 
                <table  class="export_th table" style="line-height: 1.5;">
                  
                        <th><b><u>Buyer Name</u> </b><br></th>
                    </tr>
                    <tr>
                        <td>{{ '   ' . $sales_order->name }}<br>
                            {{ '   ' . $sales_order->address }}</td>
                    </tr>
                </table>
            </div>
        </div>
       
    </div>

    <div style="line-height:5px;">&nbsp;</div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:40px;">
        <div class="container-fluid">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                {{-- footer d data --}}
            </div>
        </div>
    </div>
    <!--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right hidden qrCodeDiv">
            <img src="data:image/png;base64, { !! base64_encode(QrCode::format('png')->size(200)->generate('View Purchase Request Voucher Detail (Office Use)'))!!} ">
        </div>
        <!-->
    <div class="gafa">
        <img src="{{ asset('/public/images/gafa.png') }}" alt="">
    </div>
     
</div>


<script>
    $(function() {
        // alert();
        let count = {{ count($sales_order_data) }};
        for (let i = 0; i < count; i++) {
            toWords(i);
        }
        toWords('1001001');
    })
</script>

{{-- <script>

        function view_history(id) {

            var v = $('#sub_' + id).val();


            if ($('#view_history' + id).is(":checked")) {
                if (v != null) {
                    showDetailModelTwoParamerter('pdc/viewHistoryOfItem_directPo?id=' + v);
                }
                else {
                    alert('Select Item');
                }

            }
        }

        function change()

        {


            if(!$('.showw').is(':visible'))
            {
                $(".showw").css("display", "block");

            }
            else
            {
                $(".showw").css("display", "none");

            }

        }


        function show_hide()
        {
            if($('#formats').is(":checked"))
            {
                $("#actual").css("display", "none");
                $("#printable").css("display", "block");
                $("#other_fomrate").css("display", "none");
            }

            else
            {
                $("#actual").css("display", "block");
                $("#printable").css("display", "none");
                $("#other_fomrate").css("display", "none");
            }

            if($('#formatss').is(":checked"))
            {
                $("#actual").css("display", "none");
                $("#printable").css("display", "none");
                $("#other_fomrate").css("display", "block");
            }
        }


        function approve(id)
        {
            $("#appro").attr("disabled", true);
            $.ajax
            ({
                url: '{{ url('sales/approve_so') }}',
                type: 'Get',
                data: {id:id},

                success: function (response)
                 {
                    $('#stat'+id).html(response);
                    $('#showDetailModelOneParamerter').modal('hide');
               
                }
            })
        }
    </script> --}}
