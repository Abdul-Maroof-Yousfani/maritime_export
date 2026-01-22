<?php
use App\Helpers\CommonHelper;
use Illuminate\Support\Facades\Storage;
$id = $_GET['id'];
$m = Session::get('run_company');
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
</style>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        <?php CommonHelper::displayPrintButtonInView('printContractLoadingDetail', '', '1'); ?>
    </div>
</div>
<div style="line-height:5px;">&nbsp;</div>
<div class="row" id="printContractLoadingDetail" style="text-transform: uppercase;">
    <div style="line-height:5px;">&nbsp;</div>
    
    {{-- Loading Details Table --}}
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h4 style="text-align: center; margin-bottom: 15px;"><u><b>CONTRACT LOADING DETAILS</b></u></h4>
            <div class="table-reponsive">
                <table class="table" style="width:100%;border:1px solid">
                    <tbody>
                        <tr>
                            <th style="width:25%;border:1px solid">Loading No</th>
                            <td style="width:25%;border:1px solid">{{ $contract_loading->loading_no ?? '-' }}</td>
                            <th style="width:25%;border:1px solid">Contract No</th>
                            <td style="width:25%;border:1px solid">{{ $contract_loading->contract_no ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="border:1px solid">Export Order No</th>
                            <td style="border:1px solid">
                                @if($contract_loading->saleOrderExport)
                                    {{ $contract_loading->saleOrderExport->voucehr_no ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <th style="border:1px solid">Loading Date</th>
                            <td style="border:1px solid">
                                @if(!empty($contract_loading->loading_date))
                                    @php
                                        $loadingDate = new DateTime($contract_loading->loading_date);
                                        echo $loadingDate->format('d-M-Y');
                                    @endphp
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

    {{-- Vehicles Table --}}
    @if(isset($contract_loading->vehicles) && $contract_loading->vehicles->count() > 0)
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h4 style="text-align: center; margin-bottom: 15px;"><u><b>VEHICLES</b></u></h4>
            <div class="table-reponsive">
                <table class="table" style="width:100%;border:1px solid">
                    <thead>
                        <tr>
                            <th style="border:1px solid;text-align:center;">S.No</th>
                            <th style="border:1px solid;text-align:center;">Vehicle No</th>
                            <th style="border:1px solid;text-align:center;">Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1; @endphp
                        @foreach($contract_loading->vehicles as $vehicle)
                        <tr>
                            <td style="border:1px solid;text-align:center;">{{ $count++ }}</td>
                            <td style="border:1px solid;">{{ $vehicle->vehicle_no ?? '-' }}</td>
                            <td style="border:1px solid;">{{ $vehicle->name ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Containers Table --}}
    @if(isset($contract_loading->containers) && $contract_loading->containers->count() > 0)
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h4 style="text-align: center; margin-bottom: 15px;"><u><b>CONTAINERS</b></u></h4>
            <div class="table-reponsive">
                <table class="table" style="width:100%;border:1px solid">
                    <thead>
                        <tr>
                            <th style="border:1px solid;text-align:center;">S.No</th>
                            <th style="border:1px solid;text-align:center;">Container No</th>
                            <th style="border:1px solid;text-align:center;">Seal No</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1; @endphp
                        @foreach($contract_loading->containers as $container)
                        <tr>
                            <td style="border:1px solid;text-align:center;">{{ $count++ }}</td>
                            <td style="border:1px solid;">{{ $container->container_no ?? '-' }}</td>
                            <td style="border:1px solid;">{{ $container->seal_no ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Export Order Items Detail Table --}}
    @if(isset($sale_order_data) && $sale_order_data->count() > 0)
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
                            <th style="border:1px solid;text-align:center;">Final Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @foreach($sale_order_data as $row)
                            @php
                                $item_name = CommonHelper::get_item_name($row->item_id);
                            @endphp
                            <tr>
                                <td style="border:1px solid;text-align:center;">{{ $count++ }}</td>
                                <td style="border:1px solid;">{{ $item_name }}</td>
                                <td style="border:1px solid;text-align:center;">{{ $row->item_size ?? '-' }}</td>
                                <td style="border:1px solid;text-align:center;">{{ $row->quality ?? '-' }}</td>
                                <td style="border:1px solid;text-align:right;">{{ number_format($row->total_qty ?? $row->actual_qty ?? 0, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Total Amount Section --}}
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-reponsive">
                <table class="table" style="width:100%;border:1px solid">
                    <tbody>
                        <tr>
                            <th style="border:1px solid">Total Amount</th>
                            <td style="border:1px solid; text-align: right;">
                                {{ number_format($totalAmount ?? 0, 2) }} {{ $saleOrder->currency_name ?? '' }}
                            </td>
                            <th style="border:1px solid">Total Amount in PKR</th>
                            <td style="border:1px solid; text-align: right;">
                                {{ number_format($totalAmountPKR ?? 0, 2) }} PKR
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Attachments Section --}}
    @if(isset($attachments) && $attachments->count() > 0)
    <div class="row attachments-section page-break" style="margin-top: 20px;">
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
</div>

