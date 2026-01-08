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
table{border:1px solid #000;border-collapse:collapse;margin:0;padding:0;width:100%;table-layout:fixed;}
table caption{font-size:1.5em;margin:.5em 0 .75em;}
table tr{border:1px solid #000;padding:0.35em;}
table th,table td{padding:0.625em;text-align:center;border:1px solid #000;text-align:left;font-weight:bold;}
table th{font-size:.85em;letter-spacing:.1em;text-transform:uppercase;text-align:center;}

/* .diector{text-align:right;}
.pt1_com{display:flex;justify-content:space-between;}
.pt1_com h5{font-weight:700;}
.focon{width:61%;}
.sigs{display:flex;justify-content:space-between;}
.gafa{text-align:center;}
.pt1_com.commercial_head{margin-bottom:-18px;}
.focon.commercial_para P{margin-bottom:15px;}
.Commercial_invoice_No{border-bottom:2px solid #000;}
.pt1_com.commercial_head.Commercial_invoice_No{margin-bottom:7px;}
.description_table p{margin:0;}
.focon.commercial_para.CONSIGNED_pargarf p{line-height:5px;}
.focon.commercial_para p{font-size:12px !important;}
.table-bordered > thead > tr > th.value_brand,.table-bordered > tbody > tr > th.value_brand,.table-bordered > tfoot > tr > th.value_brand{width:170px !important;} */



    @media screen and (max-width:600px) {
        table{border:0;}
        table caption{font-size:1.3em;}
        table thead{border:1px solid #000;clip:rect(0 0 0 0);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute;width:1px;}
        table tr{border-bottom:3px solid #ddd;display:block;margin-bottom:.625em;}
        table td{border-bottom:1px solid #ddd;display:block;font-size:.8em;text-align:right;}
        table td::before{/* * aria-label has no advantage,it won't be read inside a table content:attr(aria-label);*/
        content:attr(data-label);float:left;font-weight:bold;text-transform:uppercase;}
        table td:last-child{border-bottom:0;}
    }

    @media (max-width:1680px) {}

    @media (max-width:1024px) {}

    @media (max-width:1366px) {}

    @media print {
    .printHide{display:none !important;}
    .fa{font-size:small !important;}
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
    <div class="par">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <p>Export Registration No : (W) 044554</p>
                <div class="pt1_com commercial_head ">
                    <h5>"E" Form No.</h5>
                    <div class="focon commercial_para">
                        <p>
                            @foreach (json_decode($exportInvoices->form_no) as $item)
                                {{ $item }},
                                <br>
                            @endforeach
                        </p>
                    </div>
                </div>
                <div class="pt1_com commercial_head">
                    <h5>L/C No. & Date</h5>
                    <div class="focon commercial_para">
                        <p>{{ $exportInvoices->lc_date_no ?? '-' }}</p>
                    </div>
                </div>
                <div class="pt1_com commercial_head">
                    <h5>Terms</h5>
                    <div class="focon commercial_para">
                        <p>
                            {{ App\Models\ModeOfTerm::find($exportInvoices->mode_of_term)->name }}
                            {{-- {{ $exportInvoices->advance_payment . '% Addvance and ' }} {{100 - $exportInvoices->advance_payment??0}} {{ '% within five Working Days Of BL and Invoice' }} --}}
                            {{-- {{$exportInvoices->advance_payment.',   '.$exportInvoices->icoterm_name }} --}}
                        </p>
                    </div>
                </div>
                <div class="pt1_com commercial_head Commercial_invoice_No">
                    <h5>Commercial invoice No.</h5>
                    <div class="focon commercial_para">
                        <p>{{ $exportInvoices->commercial_invoice_no }} DATED {{ $exportInvoices->invoice_date }} </p>
                    </div>
                </div>
                @foreach (App\Models\ExportCommercialNotifyAddress::where('commercial_invoice_id', $exportInvoices->id)->get() as $ExportCommercialNotifyAddress)
                <div class="pt1_com commercial_head">
                    <h5>Notify Address:</h5>
                    <div class="focon commercial_para">
                        <p>{!! $ExportCommercialNotifyAddress->notify_address !!}</p>
                        {{-- <p>{{ $exportInvoices->address}}</p> --}}
                    </div>
                </div>
                @endforeach
                <div class="pt1_com commercial_head">
                    <h5>CONSIGNED FOR ACCOUNT <br> AND ENTIRE RISK OF:</h5>
                    <div class="focon commercial_para CONSIGNED_pargarf">
                        <p>{!! $exportInvoices->consigned_deatils !!}</p>
                        {{-- <p>{{ $exportInvoices->address}}</p> --}}
                    </div>
                </div>
                <div class="pt1_com commercial_head">
                    <h5>Ship Name / Voy:</h5>
                    <div class="focon commercial_para">
                        <p>{{ $exportInvoices->ship_name }}</p>
                    </div>
                </div>
                <div class="pt1_com commercial_head">
                    <h5>Port of Loading:</h5>
                    <div class="focon commercial_para">
                        <p>{{ $exportInvoices->port_loading }}</p>
                    </div>
                </div>
                <div class="pt1_com commercial_head">
                    <h5>Port of Discharge:</h5>
                    <div class="focon commercial_para">
                        <p>{{ $exportInvoices->port_of_discharge }}</p>
                    </div>
                </div>
                <div class="pt1_com commercial_head">
                    <h5>Bill of Lading No.& Date:</h5>
                    <div class="focon commercial_para">
                        <p>{{ $exportInvoices->bill_of_loading }}</p>
                    </div>
                </div>
                @if ($exportInvoices->master_bl)
                <div class="pt1_com commercial_head">
                    <h5>Master B/L:</h5>
                    <div class="focon commercial_para">
                        <p>{{ $exportInvoices->master_bl }}</p>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <div class="gariblogo2">
                    <img src="{{asset('/public/images/garibsons.jpg')}}" alt="">
                </div>
            </div> 
        </div>
        <br/> 

        <div class="table-responsivecoverray commercial_table">
            <table class="ecoverray table table-bordered newcommericals  sf-table-list  commercial_table2" id="EmpExitInterviewList ">
                <?php
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
                        <th>PP BAGS</th>
                        <th>NET -WEIGHT M ton</th>
                        <th>GROSS WEIGHT M ton</th>
                        <th style="width: 40%;">DESCRIPTION OF GOODS</th>
                        <th>UNIT PRICE {{ $name_currency }} M ton</th>
                        <th>TOTAL VALUE<br> {{ $name_currency }} <br> {{App\Models\IncoTerm::find($exportInvoices->incoterm)->name}} <br> @if ($exportInvoices->incoterm == 2) {{$exportInvoices->port_loading}} @else {{$exportInvoices->port_of_discharge}} @endif </th>
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
                            @if ($loop->first)
                        <tr>
                            <td colspan="4"></td>
                            <td>
                                <div class="description_table">
                                    {!! $exportInvoices->description !!}
                                    {{$exportInvoices->invoice_date}} - {{ $exportInvoices->pro_contract_no }}

                                </div>
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    @endif
                    <td class="dragon_td_no_border2">{{ $value->brand }}</td>
                    <td class="dragon_td_no_border">{{ number_format($bags) }}</td>
                    <td class="dragon_td_no_border">{{ number_format($value->issue_qty, 3) }}</td>
                    <td class="dragon_td_no_border">{{ number_format($value->gross_weight, 3) }}</td>
                    <td class="dragon_td_no_border4">{{ 'PACKED IN ' . $value->pack_size . ' KG ' . $value->pack_type }} </td>
                    <td class="dragon_td_no_border">{{ $name_currency. '   ' .number_format($value->rate, 2) }}</td>
                    <td class="dragon_td_no_border">{{ $name_currency. '   ' .number_format($amount, 2) }}</td>

                    </tr>
                    @if ($loop->last)
                        @php
                            $advance =
                                App\Models\ExportAdvancePayment::where('invoice_id', $exportInvoices->id)
                                    ->where('status', 1)
                                    ->first()->received_amount ?? 0;
                        @endphp
                        @if ($advance > 0)
                            <tr>
                                <td colspan="4"></td>
                                <td>
                                    LESS ADVANCE PAYMENT RECEIVED
                                </td>
                                <td class="dragon_td_no_border5"></td>
                                @php
                                    $sumtotal = $sumtotal - $advance;
                                @endphp
                                <td class="dragon_td_no_border5">({{ $advance }})</td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="4"></td>
                            <td>
                                <b><u>INTERMEDIARY BANK:</u></b><br>
                                {{ 'BANK NAME: ' . $exportInvoices->correspondent_bank }}<br>
                                {{ 'ACCOUNT NO: ' . $exportInvoices->correspondent_account_no }}<br>
                                {{-- {{ 'ABA NO: ' . $exportInvoices->correspondent_account_usd }}<br> --}}
                                {{ 'SWIFT: ' . $exportInvoices->correspondent_bank_swift }}<br><br>
                                <b><u>BENEFICIARY BANK:</u></b><br>
                                @php
                                    $bankDetail = App\Models\Bank::find($exportInvoices->bank);
                                @endphp
                                {{ 'BANK: ' . $bankDetail->bank_name }}<br>
                                {{ 'BANK ADDRESS: ' . $bankDetail->bank_address }}<br>
                                {{ 'SWIFT: ' . $bankDetail->swift_code }}<br>
                                {{ 'A/C TITLE: ' . $bankDetail->account_title }}<br>
                                {{ 'A/C NO: ' . $bankDetail->account_no }}<br>
                                {{ 'IBAN: ' . $bankDetail->IBAN_no }}<br> <br>
                                WE CERTIFY THAT THE GOODS ARE OF PAKISTAN ORIGIN
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    @endif
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
                        <td class="dragon_td_no_border6"></td>
                        <td class="dragon_td_no_border6">{{ $name_currency }} {{ number_format($sumtotal, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <table class="ecoverray table table-bordered sf-table-list marftab amounts_cartifacate">

                <tr>
                    <input type="hidden" id="d_t_amount_1001001" value="{{ $sumtotal }}">
                    <th class="ht">  
                        <div class="amut">
                            Amount In Words : <span id="rupees1001001"></span>  
                        </div>
                    </th>
                    {{-- {{CommonHelper::AmountInWords($total_amount, $name_currency)}} --}}
                </tr>

            </table>
            {{-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="line-height: 19px;"> 
                            <br> <strong><b>INTERMEDIARY BANK</b></strong>
                                    <br>BANK NAME:{{$exportInvoices->correspondent_bank}}
                                    <br>ACCOUT Title: {{$exportInvoices->account_title}} 
                                    <br>ABA NO: {{$exportInvoices->correspondent_account_usd}}
                                    <br>SWIFT:{{$exportInvoices->correspondent_bank_swift}} <br>
                                    @php
                                    if(!empty($exportInvoices->bank))
                                    {
                                    $bank_name  = App\Models\Bank::find($exportInvoices->bank)->bank_name;	
                                    $bank_swift = App\Models\Bank::find($exportInvoices->bank)->swift_code;	
                                    $bank_ibn  = App\Models\Bank::find($exportInvoices->bank)->IBAN_no;	
                                    $bank_address  = App\Models\Bank::find($exportInvoices->bank)->bank_address;	
                                    $account_title  = App\Models\Bank::find($exportInvoices->bank)->account_title;	
                                    }else{
                                    $bank_name  = '-';	
                                    $bank_swift = '-';	
                                    $bank_ibn  = '-';	
                                    $bank_address = '-';
                                    $account_title = '-';
                                    }
                                    @endphp
                                    <br><strong><b>BENEFICIARY BANK</b></strong>
                                    <br>BANK:{{ $bank_name}}
                                    <br>BANK ADDRESS: {{$bank_address}}
                                    <br>SWIFT: MPBLPKKA030
                                    <br>A/C TILTE: {{$account_title}}
                                    <br>A/C Swift: {{$bank_swift}}
                                    <br>IBAN:{{$bank_ibn}}<br>
                                    <br>WE CERTIFY THAT THE GOODS ARE OF PAKISTAN ORIGIN.
                
                        </div> --}}
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sigs">
                    <div class="esps">
                        <p>E.& O.E</p>
                    </div>
                    <div class="diectors">
                        <p>For Garibsons (Pvt) LIMITED</p>
                        <br>
                        <h5>Director</strong></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="gafa">
            <img src="{{ asset('/public/images/gafa.png') }}" alt="">
        </div>
    </div>
</div>

<script>
    $(function() {
        toWords('1001001');
    })
</script>
