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
table th{font-size:.85em;letter-spacing:.1em;text-transform:uppercase;}
.profe{height:auto;margin-bottom:40px;}
.diector{margin-top:20px;}
.profohead{margin-bottom:20px;width:100%;}
/* .flr{display:flex;justify-content:space-between;} */
.gariblogo2 img{width:350px;}
.gafa{text-align:center;}

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


    @media print {
 .profohead{width:500px !important;}
table th{font-size:20px;}
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
    <!-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

    </div> -->
    <div class="col-md-12 ">
        <?php
        if (!empty($ExportPerforma->currencey_id)) {
            $name_currency1 = App\Models\Currency::find($ExportPerforma->currencey_id);
            $name_currency = $name_currency1['curreny'];
        } else {
            $name_currency = '-';
        }
        $total_amount = $sales_order_data->total_amount;
        $a = CommonHelper::AmountInWords($total_amount, $name_currency);
        
        $final_advance = $ExportPerforma->advance_payment ?? 0;
        
        if (!empty($ExportPerforma->bank)) {
            $bank_name = App\Models\Bank::find($ExportPerforma->bank)->bank_name;
            $bank_swift = App\Models\Bank::find($ExportPerforma->bank)->swift_code;
            $bank_ibn = App\Models\Bank::find($ExportPerforma->bank)->IBAN_no;
            $bank_address = App\Models\Bank::find($ExportPerforma->bank)->bank_address;
            $account_title = App\Models\Bank::find($ExportPerforma->bank)->account_title;
        } else {
            $bank_name = '-';
            $bank_swift = '-';
            $bank_ibn = '-';
            $bank_address = '-';
            $account_title = '-';
        }
        ?>
        <div class="par ">
            <div class="profex profe">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <div class="profo">
                                <div class="profohead" style="border:1px solid;">
                                    <h4 style="text-align: center; ">
                                        PROFORMA INVOICE
                                    </h4>
                                </div>
                                <p style="margin-top: 20px;">CONSIGNED TO:</p>
                                <p>BUYER: <strong>{{ $ExportPerforma->name }}</strong></p>
                                <p><strong>{{ $ExportPerforma->address }}</strong></p>
                          
                                <p>CONTRACT NO:{{ '    ' . $ExportPerforma->contract_no . ',   ' }} DATED :
                                    {{ $ExportPerforma->created_at->format('d-m-Y') }}</p>
            
                                <p>PROFORMA NO:{{ '    ' . $ExportPerforma->pro_contract_no . ',   ' }}</p>
                               
                                <input type="hidden" id="d_t_amount_1001001" value="{{ $total_amount }}">
            
                                <p>AMOUNT: {{ $name_currency . ' ' }} {{ number_format($total_amount, 2) }} <span
                                        id="rupees1001001"></span>
                                  
                                    @if($final_advance > 0) PURPOSE: {{ $final_advance }} % ADVANCE PAYMENT @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <div class="gariblogo2">
                                <img src="{{asset('/public/images/garibsons.jpg')}}" alt="">
                            </div>
                        </div>
                    </div>
                 
       
                    <div class="table-responsive tabtop profee">
                        <table class="protabbss table table-bordered sf-table-list proforma_table" id="EmpExitInterviewList">
                            <tbody>
                                <tr>
                                <td data-label="Account">Beneficiary:</td>
                                <td data-label="Due Date">{{ $account_title }}</td>
                                </tr>
                                <tr>
                                    <td scope="row" data-label="Account">Beneficiary address:</td>
                                    <td data-label="Due Date">{{ $bank_address }}</td>
                                </tr>
                                {{-- <tr>
                                    <td scope="row" data-label="Account">Beneficiary account Pak Rupess:</td>
                                    <td data-label="Due Date">{{$bank_swift}}</td>
                                    </tr> --}}
                                <tr>
                                    <td scope="row" data-label="Account">IBAN#:</td>
                                    <td data-label="Due Date">{{ $bank_ibn }}</td>
                                </tr>
                                <tr>
                                    <td scope="row" data-label="Account">Beneficiary bank:</td>
                                    <td data-label="Due Date">{{ $bank_name }}</td>
                                </tr>
                                <tr>
                                    <td scope="row" data-label="Account">Beneficiary bank swift code:</td>
                                    <td data-label="Due Date">{{ $bank_swift }}</td>
                                </tr>
                                {{-- <tr>
                                    <td scope="row" data-label="Account">Beneficiary bank address:</td>
                                    <td data-label="Due Date"></td>
                                    </tr> --}}
                                <tr>
                                    <td scope="row" data-label="Account">Correspondent bank:</td>
                                    <td data-label="Due Date">{{ $ExportPerforma->correspondent_bank }}</td>
                                </tr>
                                <tr>
                                    <td scope="row" data-label="Account">Correspondent bank account USD:</td>
                                    <td data-label="Due Date">{{ $ExportPerforma->correspondent_account_no }}</td>
                                </tr>
                                {{-- <tr>
                                    <td scope="row" data-label="Account">Correspondent bank account Title:</td>
                                    <td data-label="Due Date">{{$ExportPerforma->account_title}}</td>
                                    </tr> --}}
                                <tr>
                                    <td scope="row" data-label="Account">Correspondent bank swift code:</td>
                                    <td data-label="Due Date">{{ $ExportPerforma->correspondent_bank_swift }}</td>
                                </tr>
                                <tr>
                                    <td scope="row" data-label="Account">Details of payment</td>
                                    <td data-label="Due Date">
                                        @if ($ExportPerforma->mode_of_term == 14)
                                            OPEN ACCOUNT
                                        @else
                                            @if ($ExportPerforma->advance_payment > 0)
                                                @php
                                                    $final_advance = 100 - $ExportPerforma->advance_payment;
                                                @endphp
                                                {{ $ExportPerforma->advance_payment . '% Addvance and ' . $final_advance . '% within ' . $ExportPerforma->payment_days . ' Working Days Of BL and Invoice' }}
                                            @else
                                                {{ '100% Within ' . $ExportPerforma->payment_days . ' working days of BL and Invoice.' }}
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                 <br>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="diector">
                        <p>For Garibsons (Pvt) LIMITED</p><br>
                        <br>
                        ___________________________<br>

                        <p><strong>Director</strong></p>
                    </div>
                </div>

                <div class="gafa">
                    <img src="{{ asset('/public/images/gafa.png') }}" alt="">
                </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        toWords('1001001');
    });
</script>
