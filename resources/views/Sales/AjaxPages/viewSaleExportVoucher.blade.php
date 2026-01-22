<?php
use App\Helpers\CommonHelper;
use App\Helpers\StoreHelper;
use App\Models\IncoTerm;
use App\Models\ModeOfTransport;
use Illuminate\Support\Facades\Storage;
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
    .page-break{page-break-before: always;}
    .attachments-section{display: block !important;}
}
.attachments-section{display: none;}
</style>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        <?php CommonHelper::displayPrintButtonInView('printPurchaseRequestVoucherDetail', '', '1'); ?>
    </div>
</div>
<div style="line-height:5px;">&nbsp;</div>
<div class="row" id="printPurchaseRequestVoucherDetail" style="text-transform: uppercase;">
    <div style="line-height:5px;">&nbsp;</div>
    <div class="exprord">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <div class="contecpot">
                    <div class="export_head">
                        <h4 style="text-align: center;">{{ $sales_order->voucher_heading ?? 'Export Order' }}</h4>
                    </div>
                    <div class="cont_comt">
                        <div class="conlfex">
                            <p>{{ $sales_order->voucher_heading ?? 'Export Order' }} NO : </p>
                            <div class="paracotn">
                                <p>{{ '   ' . $sales_order->voucehr_no }}</p>
                            </div>
                        </div>
                        @if(!empty($sales_order->contract_no))
                        <div class="conlfex">
                            <p>CONTRACT NO :</p>
                            <div class="paracotn">
                                <p>{{ '   ' . $sales_order->contract_no }}</p>
                            </div>
                        </div>
                        @endif
                        <div class="conlfex"> 
                           <p>DATED : </p> 
                            <div class="paracotn">
                                <p> @php
                                    if(!empty($sales_order->voucher_date)) {
                                        $date = new DateTime($sales_order->voucher_date);
                                        echo ' ' . $date->format('F d, Y');
                                    } else {
                                        echo '-';
                                    }
                                @endphp</p>
                            </div>
                        </div>
                        <div class="conlfex"> 
                            <div class="paracotn carws">
                                <p>{{ '   ' . $sales_order->name }}</p>
                            </div>
                        </div>
                        <div class="conlfex"> 
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
                        <p>{!! $sales_order->quality_remarks ?? '-' !!}</p>
                        <br>
                        @if (!empty($sales_order->product_specification))
                            <p><u><b>Product Specification</b></u></p>
                            <p>{!! $sales_order->product_specification !!}</p>
                        @endif
                    </div>   
                </div>
            </div>
        </div>
    </div>

    {{-- Master Details Table --}}
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h4 style="text-align: center; margin-bottom: 15px;"><u><b>MASTER DETAILS</b></u></h4>
            <div class="table-reponsive">
                <table class="table" style="width:100%;border:1px solid">
                    <tbody>
                        <tr>
                            <th style="width:25%;border:1px solid">Export Order No</th>
                            <td style="width:25%;border:1px solid">{{ $sales_order->voucehr_no ?? '-' }}</td>
                            <th style="width:25%;border:1px solid">Contract No</th>
                            <td style="width:25%;border:1px solid">{{ $sales_order->contract_no ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="border:1px solid">Export Date</th>
                            <td style="border:1px solid">
                                @if(!empty($sales_order->voucher_date))
                                    @php
                                        $voucherDate = new DateTime($sales_order->voucher_date);
                                        echo $voucherDate->format('d-M-Y');
                                    @endphp
                                @else
                                    -
                                @endif
                            </td>
                            <th style="border:1px solid">Customer Name</th>
                            <td style="border:1px solid">{{ $sales_order->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="border:1px solid">Customer Address</th>
                            <td style="border:1px solid" colspan="3">{{ $sales_order->address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="border:1px solid">Currency</th>
                            <td style="border:1px solid">
                                @if(!empty($sales_order->currencey_id))
                                    {{ App\Models\Currency::find($sales_order->currencey_id)->curreny ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <th style="border:1px solid">Exchange Rate</th>
                            <td style="border:1px solid">{{ $sales_order->currencey_rate ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="border:1px solid">Mode of Transport</th>
                            <td style="border:1px solid">
                                @if(!empty($sales_order->mode_transport))
                                    {{ App\Models\ModeOfTransport::find($sales_order->mode_transport)->name ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <th style="border:1px solid">Mode of Payment</th>
                            <td style="border:1px solid">
                                @if(!empty($sales_order->mode_of_term))
                                    {{ App\Models\ModeOfTerm::find($sales_order->mode_of_term)->name ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="border:1px solid">Incoterm</th>
                            <td style="border:1px solid">
                                @if(!empty($sales_order->incoterm))
                                    {{ App\Models\IncoTerm::find($sales_order->incoterm)->name ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <th style="border:1px solid">Origin</th>
                            <td style="border:1px solid">
                                @if(!empty($sales_order->origin))
                                    {{ App\Models\Origin::find($sales_order->origin)->name ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="border:1px solid">Port</th>
                            <td style="border:1px solid">
                                @if(!empty($sales_order->port))
                                    {{ App\Models\Port::find($sales_order->port)->name ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <th style="border:1px solid">Customer NTN</th>
                            <td style="border:1px solid">{{ $sales_order->buyers_ntn ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="border:1px solid">Grade</th>
                            <td style="border:1px solid">
                                @if(!empty($sales_order->grade))
                                    {{ App\Models\Grade::find($sales_order->grade)->name ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <th style="border:1px solid">Size</th>
                            <td style="border:1px solid">
                                @if(!empty($sales_order->size))
                                    {{ App\Models\Size::find($sales_order->size)->name ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="border:1px solid">Packing</th>
                            <td style="border:1px solid">
                                @if(!empty($sales_order->packing))
                                    {{ App\Models\Packing::find($sales_order->packing)->name ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                           
                        </tr>
                        <tr>
                            <th style="border:1px solid">Consignee</th>
                            <td style="border:1px solid">
                                @if(!empty($sales_order->consignee))
                                    {{ App\Models\Consignee::find($sales_order->consignee)->name ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <th style="border:1px solid">Is Advance</th>
                            <td style="border:1px solid">
                                @php
                                    $isAdvance = 0;
                                    if (isset($sales_order->is_advance)) {
                                        $isAdvance = $sales_order->is_advance;
                                    } elseif (isset($sales_order->advance_payment)) {
                                        $isAdvance = ($sales_order->advance_payment == 'Yes' || $sales_order->advance_payment == 1) ? 1 : 0;
                                    }
                                @endphp
                                {{ $isAdvance == 1 ? 'Yes' : 'No' }}
                            </td>
                        </tr>
                        <tr>
                            <th style="border:1px solid">Mode of Production</th>
                            <td style="border:1px solid">{{ $sales_order->mode_of_production ?? '-' }}</td>
                            <th style="border:1px solid">Bank</th>
                            <td style="border:1px solid">
                                @if(!empty($sales_order->bank))
                                    {{ App\Models\Bank::find($sales_order->bank)->bank_name ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Export Order Items Detail Table --}}
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h4 style="text-align: center; margin-bottom: 15px;"><u><b>EXPORT ORDER ITEMS DETAIL</b></u></h4>
            <div class="table-reponsive">
                <table class="table" style="width:100%;border:1px solid">
                    <thead>
                        <tr>
                            <th style="border:1px solid;text-align:center;">S.No</th>
                            <th style="border:1px solid;text-align:center;">Item Name</th>
                            <th style="border:1px solid;text-align:center;">Item Size</th>
                            <th style="border:1px solid;text-align:center;">Quality</th>
                            <th style="border:1px solid;text-align:center;">UOM</th>
                            <th style="border:1px solid;text-align:center;">HS Code</th>
                            <th style="border:1px solid;text-align:center;">Pack UOM</th>
                            <th style="border:1px solid;text-align:center;">Pack Size</th>
                            <th style="border:1px solid;text-align:center;">Quantity</th>
                            <th style="border:1px solid;text-align:center;">Final Weight</th>
                            <th style="border:1px solid;text-align:center;">Unit Rate</th>
                            <th style="border:1px solid;text-align:center;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                            $total_amount = 0;
                        @endphp
                        @foreach($sales_order_data as $row)
                            @php
                                $item_name = CommonHelper::get_item_name($row->item_id);
                                $uom_name = CommonHelper::get_uom($row->item_id);
                                $amount = $row->amount ?? ($row->actual_qty * $row->rate);
                                $total_amount += $amount;
                                // Get HS Code from item
                                $item = App\Models\Subitem::find($row->item_id);
                                $hs_code = $item->hs_code ?? '-';
                                // Get Pack UOM name
                                $pack_uom_name = '-';
                                if($row->pack_uom) {
                                    $pack_uom_name = CommonHelper::get_uom_name($row->pack_uom);
                                }
                            @endphp
                            <tr>
                                <td style="border:1px solid;text-align:center;">{{ $count++ }}</td>
                                <td style="border:1px solid;">{{ $item_name }}</td>
                                <td style="border:1px solid;text-align:center;">{{ $row->item_size ?? '-' }}</td>
                                <td style="border:1px solid;text-align:center;">{{ $row->quality ?? '-' }}</td>
                                <td style="border:1px solid;text-align:center;">{{ $uom_name }}</td>
                                <td style="border:1px solid;text-align:center;">{{ $hs_code }}</td>
                                <td style="border:1px solid;text-align:center;">{{ $pack_uom_name }}</td>
                                <td style="border:1px solid;text-align:right;">{{ number_format($row->pack_size ?? 0, 2) }}</td>
                                <td style="border:1px solid;text-align:right;">{{ number_format($row->actual_qty, 2) }}</td>
                                <td style="border:1px solid;text-align:right;">{{ number_format($row->total_qty ?? 0, 2) }}</td>
                                <td style="border:1px solid;text-align:right;">{{ number_format($row->rate, 2) }}</td>
                                <td style="border:1px solid;text-align:right;">{{ number_format($amount, 2) }}</td>
                            </tr>
                        @endforeach
                        <tr style="font-weight:bold;">
                            <td colspan="11" style="border:1px solid;text-align:right;">TOTAL:</td>
                            <td style="border:1px solid;text-align:right;">{{ number_format($total_amount, 2) }}</td>
                        </tr>
                        @php
                            $total_amount_pkr = $total_amount * ($sales_order->currencey_rate ?? 1);
                        @endphp
                        <tr style="font-weight:bold;">
                            <td colspan="11" style="border:1px solid;text-align:right;">TOTAL AMOUNT IN PKR:</td>
                            <td style="border:1px solid;text-align:right;">{{ number_format($total_amount_pkr, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Attachments Section --}}
    @if(isset($attachments) && $attachments->count() > 0)
    <div class="row attachments-section page-break" id="attachmentsSection" style="margin-top: 20px;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h4 style="text-align: center; margin-bottom: 15px;"><u><b>ATTACHMENTS</b></u></h4>
            <div class="table-reponsive">
                <table class="table" style="width:100%;border:1px solid">
                    <thead>
                        <tr>
                            <th style="width:5%;border:1px solid;text-align:center;">S.No</th>
                            <th style="width:55%;border:1px solid;text-align:center;">File Name</th>
                            <th style="width:15%;border:1px solid;text-align:center;">File Type</th>
                            <th style="width:15%;border:1px solid;text-align:center;">File Size (KB)</th>
                            <th style="width:10%;border:1px solid;text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attachments as $index => $attachment)
                        <tr>
                            <td style="border:1px solid;text-align:center;">{{ $index + 1 }}</td>
                            <td style="border:1px solid;">{{ $attachment->original_name }}</td>
                            <td style="border:1px solid;text-align:center;">{{ strtoupper($attachment->file_type) }}</td>
                            <td style="border:1px solid;text-align:center;">{{ number_format($attachment->file_size / 1024, 2) }}</td>
                            <td style="border:1px solid;text-align:center;" class="printHide">
                                <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" style="color: blue; text-decoration: underline;">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif


    {{-- Seller and Buyer Information --}}
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="table-reponsive">  
                <table class="export_th table" style="line-height: 1.5;">
                    <tr>
                        <th><b><u>SELLER</u></b><br></th>
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
                <table class="export_th table" style="line-height: 1.5;">
                    <tr>
                        <th><b><u>Buyer Name</u></b><br></th>
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
                {{-- footer data --}}
            </div>
        </div>
    </div>
    <div class="gafa">
        <img src="{{ asset('/public/images/gafa.png') }}" alt="">
    </div>
</div>

<script>
    $(function() {
        let count = {{ count($sales_order_data) }};
        for (let i = 0; i < count; i++) {
            if(typeof toWords === 'function') {
                toWords(i);
            }
        }
        if(typeof toWords === 'function') {
            toWords('1001001');
        }
    })
</script>


