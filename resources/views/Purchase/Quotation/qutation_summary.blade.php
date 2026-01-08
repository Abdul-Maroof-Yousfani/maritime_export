<?php
    use App\Helpers\CommonHelper;
    use App\Helpers\ProductionHelper;
    use App\Helpers\ReuseableCode;
    use App\Models\PurchaseRequestData;
    use App\Models\DemandData;
    use App\Models\Quotation_Data;
    $summary_approve = ReuseableCode::check_rights(400);
    $ArraySum = [];
    use App\Helpers\SaleHelper;
    use App\Helpers\SalesHelper;
    $vendorIDS = [];
    $m = $_GET['m'];
?>
{{-- Ali Shiwani --}}



<style>
    .modalWidth{width:100%;}
    .bold{font-size:large;font-weight:bold;}
    .modal{overflow:scroll !important;}
    .sale_older_tab > thead > tr > th,.table > tbody > tr > th,.sale_older_tab > tfoot > tr > th,.table > thead > tr > td,.sale_older_tab > tbody > tr > td,.table > tfoot > tr > td{padding:3px 7px !important;}
    .sale_older_tab .form-control[disabled],.sale_older_tab .form-control[readonly],fieldset[disabled] .sale_older_tab .form-control{height:22px !important;}

</style>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        <?php echo CommonHelper::displayPrintButtonInView('printMachineDetail', '', '1'); ?>
        {{-- @if ($quotation->quotation_status == 1)
            <button onclick="approve('{{ $id }}','{{ $quotation->pr_id }}')" type="button"
                class="btn btn-success">Approve</button>
        @endif --}}
    </div>
</div>
<div style="line-height:5px;">&nbsp;</div>
<div class="row" id="printMachineDetail">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well print-page">
        <div class="">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label style="border-bottom:2px solid #000 !important;">Printed On
                                Date&nbsp;:&nbsp;</label><label
                                style="border-bottom:2px solid #000 !important;"><?php echo CommonHelper::changeDateFormat(date('Y-m-d'));
                                $x = date('Y-m-d');
                                echo ' ' . '(' . date('D', strtotime($x)) . ')'; ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?php echo CommonHelper::get_company_logo_miniphy(Session::get('run_company')); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="prots">
                                <h2 style="text-align: center">
                                    {{ ReuseableCode::getCompanyLocation($company_location) . ' Unit' }} </h2>
                                <h3 style="text-align: center;">Comparative Statement
                                    <br>
                                    Comparison #
                                    {{ $groupNumber }}
                                    <input type="hidden" name="groupNumber" id="groupNumber" value="{{ $groupNumber }}">
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="line-height:5px;">&nbsp;</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <!-- <table class="quito_marg table table-bordered table-striped table-condensed tableMargin"> -->
                    <table  class="table sale_older_tab quito_marg">
                        <thead>
                            <tr>
                                <th class="text-center">S.NO#</th>
                                <th class="text-center" style="width:50px;">Approved Vendors</th>
                                <th class="text-center">Department</th>
                                <th class="text-center">PR NO#</th>
                                <th class="text-center">Item</th>
                                <th class="text-center">UOM</th>
                                <th class="text-center" style="width:200px;">Qty</th>
                                <th class="text-center hidden">Purchase Request Item Status</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Last Purchase Date</th>
                                <th class="text-center">Last PO NO</th>
                                <th class="text-center">Last Purchase Rate</th>
                                <th class="text-center">Last Purchase Supplier</th>
                                <th class="text-center">Last Purchase Remarks</th>


                                @foreach ($vendor as $row)
                                    @php
                                        array_push($vendorIDS, $row->vendor_id);
                                        $attachmentQuotation = App\Models\Quotation::find($row->id);
                                        $attachmentQuotation = $attachmentQuotation->comments->first()->image_src??'';
                                    @endphp 
                                    <th class="text-center"><a href="{{ ($attachmentQuotation)? asset($attachmentQuotation) : '#' }}"
                                            target="blank">{{ $row->name }}</a></th>
                                @endforeach
                                <th></th>
                            </tr>
                        </thead>
                        {{-- <input type="hidden" id="dept_id" value="{{ $row->dept_id }}" />
                        <input type="hidden" id="pr_no" value="{{ $row->demand_no }}" />
                        <input type="hidden" id="p_type" value="{{ $row->p_type }}" /> --}}
                        <tbody>
                            @php
                                $counter = 1;
                                $validate = false;
                            @endphp

                            @foreach ($demand_data as $key => $row1)
                                @php
                                    $lastRateQty = CommonHelper::get_last_rate_qty_on_quotation($row1->sub_item_id);
                                    $is_approve_check = DB::Connection('mysql2')
                                        ->table('quotation as a')
                                        ->join('quotation_data as b', 'a.id', '=', 'b.master_id')
                                        ->select('b.vendor', 'b.qty', 'b.description', 'b.sub_item_desc')
                                        ->where('b.vendor', '!=', 0)
                                        ->where('a.group_number', $groupNumber)
                                        ->where('b.pr_data_id', $row1->id)
                                        ->first();
                                    
                                    //    $sub_item_desc = DB::Connection('mysql2')->table('quotation_data')
                                    //     ->join('quotation','quotation.id','quotation_data.master_id')
                                    //     ->whereIn('quotation.vendor_id',$vendorIDS)
                                    //     ->where('quotation_data.pr_data_id',$row1->id)
                                    //     ->pluck('quotation_data.sub_item_desc')->toArray();
                                    //     $sub_item_desc = array_filter($sub_item_desc, function($a) {
                                    //         return trim($a) !== "";
                                    //     });
                                    
                                    // dd($sub_item_desc);
                                    $priviousApprovedQuotationQty = CommonHelper::get_privious_approved_quotation_qty($row1->master_id,$row1->id,$row1->sub_item_id);
                                    $last_purchase_data = DB::Connection('mysql2')->table('last_purchase_data')->where([['quotation_id','=', $row1->quotation_master_id],['quotation_data_id','=',$row1->quotation_id],['status','=', 1]])->orderBy('id','desc')->first();

                                    
                                @endphp
                                <tr id="tr{{ $row1->id }}" class="tex-center">
                                    <td class="text-center">
                                        {{ $counter++ }}
                                        @if (PurchaseRequestData::where('demand_data_id', $row1->id)->where('quotation_data_id',$row1->quotation_id)->where('status', 1)->first())
                                        @else
                                            @if ($is_approve_check)
                                                <input name="quotationRow_id[]" id="quotationRow_id{{ $key }}" type="checkbox" value="{{ $row1->quotation_id . ',' . $row1->id . ',' . $row1->master_id.','.$key }}" />
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($is_approve_check)
                                            <p style="font-size: 11px">
                                                {{ CommonHelper::get_supplier_name($is_approve_check->vendor) }}</p>
                                            <input name="quotation[]" id="quotation_id{{ $key }}"
                                                type="checkbox" class="hide"
                                                value="{{ $row1->quotation_id . ',' . $row1->id . ',' . $row1->master_id }}" />
                                        @else
                                            <input name="quotation[]" id="quotation_id{{ $key }}"
                                                type="checkbox"
                                                value="{{ $row1->quotation_id . ',' . $row1->id . ',' . $row1->master_id }}" />
                                    </td>
                                    @php
                                        $validate = true;
                                    @endphp
                            @endif
                            <td class="text-center">{{ CommonHelper::get_sub_dept_name($row1->sub_department_id) }}
                            </td>

                            <td class="text-center"
                            @php
                                $prAttachment = App\Models\Demand::find($row1->demand_id);
                                $paramOne = "pdc/viewDemandVoucherDetail?m=".$m;
                                $paramTwo =  $row1->demand_no ;
                                $paramThree = "View Purchase Request List";
                            @endphp>
                                <a href="javascript:void(0);" 
                                    onclick="showDetailModelTwoParamerter('{{ $paramOne }}', '{{ $paramTwo }}', '{{ $paramThree }}')">
                                    {{$row1->demand_no}}
                                </a>
                             <br>
                                <a href="{{asset($prAttachment->comments->first()->image_src??'#')}}"  target="blank">Open Attachment</a>
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0);" 
                                    onclick="showDetailModelTwoParamerter('pdc/viewHistoryOfItem?id={{ $row1->sub_item_id }}')">
                                    {{ $row1->sku_code . ' - ' . $row1->sub_ic }}
                                </a>
                             
                            </td>
                            <td class="text-center"><?php echo App\Models\Subitem::find($row1->sub_item_id)->uomData->uom_name ?? ''; ?></td>
                            {{-- <td class="text-center">{{ $row1->demand_no }}</td> --}}
                            <td class="text-center">
                                @if ($is_approve_check)
                                    {{ $is_approve_check->qty }}
                                @else
                                    <!-- {{$row1->approve_qty}} -->
                                    <input type="hidden" name="remaining_qty{{ $key }}" class="form-control"
                                        id="remaining_qty{{ $key }}" onkeyup="calculate({{ $key }})"
                                        step="0.01" value="{{ $row1->qty - $priviousApprovedQuotationQty }}">
                                    <input type="hidden" class="form-control row_count" id="row_count{{ $key }}" value="0">
                                    <input type="text" name="demand_qty{{ $key }}" class="form-control"
                                        id="demand_qty{{ $key }}" onkeyup="calculate({{ $key }})"
                                        step="0.01" value="{{ $row1->qty - $priviousApprovedQuotationQty }}" onchange="checkQuotationQty({{$key}})">
                                @endif
                                <input type="hidden" name="quotation_master_id" id="quotation_master_id"
                                    value="{{ $row1->quotation_master_id }}">
                                {{-- <input type="hidden" name="sub_item_id{{ $key }}" id="sub_item_id{{ $key }}" value="{{ $row1->sub_item_id }}"> --}}

                            </td>
                            <td class="hidden">
                                <select class="form-control" name="demand_complete_status_type{{$key}}" id="demand_complete_status_type{{$key}}">
                                    <option value="1">Open Purchase Request</option>
                                    <option value="2">Close Purchase Request</option>
                                </select>
                            </td>
                            <td class="text-center" id="descRow">{{ $is_approve_check ? $is_approve_check->description : $row1->description }}</td>
                            @if(!isset($last_purchase_data))
                                <td class="text-center">{{ $lastRateQty ? CommonHelper::changeDateFormat($lastRateQty->purchase_request_date) : '-' }}</td>
                                <td>
                                    @php
                                        $po = CommonHelper::getLastPoData($row1->sub_item_id);
                                    @endphp
                                    <a href="javascript:void(0);" 
                                        onclick="showDetailModelTwoParamerter('stdc/viewPurchaseRequestVoucherDetail','{{optional($po)->master_id}}','View Purchase Order Detail')">
                                        {{strtoupper(optional($po)->purchase_request_no)}}
                                    </a>
                                </td>
                                <td class="text-right">{{ $lastRateQty ? number_format($lastRateQty->rate, 2) : 0 }}</td>
                                <td class="text-center">
                                    {{ $lastRateQty ? CommonHelper::get_supplier_name($lastRateQty->supplier_id) : '-' }}
                                </td>
                                <td class="text-center">
                                    @php
                                        $grn = App\Models\GRNData::where('sub_item_id', $row1->sub_item_id)
                                            ->orderBy('id', 'desc')
                                            ->first();
                                    @endphp

                                    {{ isset($grn->description) ? $grn->description : '-' }}
                                </td>
                            @else
                                <td class="text-center">{{ CommonHelper::changeDateFormat($last_purchase_data->last_purchase_date) }}</td>
                                <td class="text-center">
                                    <a href="javascript:void(0);" 
                                        onclick="showDetailModelTwoParamerter('stdc/viewPurchaseRequestVoucherDetail','{{optional($last_purchase_data)->last_purchase_request_id}}','View Purchase Order Detail')">
                                        {{strtoupper(optional($last_purchase_data)->last_purchase_request_no)}}
                                    </a>
                                </td>
                                <td class="text-right">{{ number_format($last_purchase_data->last_purchase_rate, 2) }}</td>
                                <td class="text-center">{{ $last_purchase_data->last_supplier_name }}</td>
                                <td class="text-center">{{ $last_purchase_data->last_item_description }}</td>
                            @endif

                            @foreach ($vendor as $keyForAmount => $row)
                                <?php
                                    $amount = ReuseableCode::get_quotation_amount_supp_wise($row1->id, $groupNumber, $row->vendor_id);
                                    $rate = ReuseableCode::get_quotation_amount_supp_wise_two($row1->id, $groupNumber, $row->vendor_id);
                                    if($row1->approve_qty == 0){
                                        $abcQty = $row1->demand_qty;
                                    }else{
                                        $abcQty = $row1->approve_qty;
                                    }

                                    $ratee = $rate;
                                        
                                    
                                
                                ?>
                                <td class="text-center">
                                    <span class="amount{{ $key }}"
                                        id="supp_rate{{ $keyForAmount . '-' . $key }}">{{ number_format($ratee, 2) }}</span>
                                    <br>
                                    <p id="total_supp_rate{{ $keyForAmount . '-' . $key }}" @if(isset($is_approve_check) && $is_approve_check->vendor == $row->vendor_id) style="background-color: #6aff9d !important" @endif>
                                        @php
                                            $amountSum = $is_approve_check ? $is_approve_check->qty * $ratee : $ratee * $row1->qty;
                                            if (isset($ArraySum[$keyForAmount])) {
                                                $ArraySum[$keyForAmount] = $ArraySum[$keyForAmount] + $amountSum;
                                            } else {
                                                $ArraySum[$keyForAmount] = $amountSum;
                                            }
                                            echo number_format($amountSum, 2);
                                        @endphp
                                    </p>
                                    <p>
                                        {{ SalesHelper::getQuotationItemWiseRemarks($row->vendor_id, $row1->id) }}<br>
                                    </p>
                                </td>
                            @endforeach
                            <td>
                                @if (PurchaseRequestData::where('demand_data_id', $row1->id)->where('quotation_data_id',$row1->quotation_id)->where('status', 1)->first())
                                    Purchase Order Create
                                @else
                                    @if ($is_approve_check)
                                        <input type="hidden" name="damand_data_id"
                                            id="damand_data_id{{ $key }}" value="{{ $row1->id }}">
                                        <input type="hidden" name="quotation_data_vendor"
                                            id="quotation_data_vendor{{ $key }}"
                                            value="{{ $is_approve_check->vendor }}">
                                        <input type="hidden" name="quotation_data_id"
                                            id="quotation_data_id{{ $key }}"
                                            value="{{ $row1->quotation_id }}">
                                        <input type="hidden" name="group_no" id="group_no{{ $key }}"
                                            value="{{ $groupNumber }}">
                                        <button type="button" class="btn btn-danger printHide" id="rever{{ $key }}" onclick="reverseBtn({{ $key }})">Reverse</button>
                                    @endif
                                @endif
                            </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="text-center" colspan="13">
                                    Total
                                </td>
                                @foreach ($vendor as $keyForAmount => $row)
                                    <td class="text-center">
                                        {{ number_format($ArraySum[$keyForAmount], 2) }}
                                    </td>
                                @endforeach
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="20">
                                    <button type="button" class="btn btn-danger printHide" onclick="multipleReverse()">Reverse Multiple Records</button>
                                </td>
                            </tr>
                        </tbody>
                        @if ($validate == true && $summary_approve == true)
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <select class="form-control" id="vendor">
                                        <option value="">Select</option>
                                        @foreach ($vendor as $row)
                                            <option value="{{ $row->vendor_id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="group_number" id="group_number"
                                        value="{{ $groupNumber }}">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <textarea id="desc" name="desc" style="width: 417px; height: 44px;" placeholder="Narration"> </textarea>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <button onclick="save()" type="submit" class="btn btn-success" id="approvedBtn">Approved</button>
                                </div>
                            </div>
                        @endif
                    </table>
                    <table class="table sale_older_tab quito_marg">
                        <thead>
                            <tr>
                                <th class="text-center">Supplier Name</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">GST Amount (%)</th>
                                <th class="text-center">Amount With GST</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $suppAmountTotal = 0;
                                $gstTotal = 0;
                            @endphp
                            {{-- @php  dd($vendor); @endphp --}}
                            @foreach ($vendor as $keyForAmount => $row)
                                @php
                                    $suppAmounr = ReuseableCode::get_quotation_total_amount_approve_supp_wise($groupNumber, $row->vendor_id);
                                    $suppAmountTotal += $suppAmounr;
                                @endphp
                                @if ($suppAmounr != 0)
                                    <tr>
                                        <td class="text-center">
                                            {{ $row->name . ' - ' . SalesHelper::getSupplierTermsOfPayment($row->vendor_id) }}
                                        </td>
                                        <td class="text-center">
                                            {{ number_format($suppAmounr, 2) }}
                                        </td>
                                        <td class="text-center">
                                            0
                                        </td>
                                        <td class="text-center">{{ number_format($suppAmounr, 2) }}</td>
                                    </tr>
                                @endif
                                @php
                                    $suppAmounr = ReuseableCode::get_quotation_total_amount_approve_supp_wise_with_gst($groupNumber, $row->vendor_id);
                                    $suppAmountTotal += $suppAmounr;
                                @endphp
                                @if ($suppAmounr != 0)
                                    <tr>
                                        <td class="text-center">
                                            {{ $row->name . ' - TOP: ' . SalesHelper::getSupplierTermsOfPayment($row->vendor_id) }}
                                        </td>
                                        <td class="text-center">
                                            {{ number_format($suppAmounr, 2) }}
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $taxAmount = ($suppAmounr / 100) * $row->gst;
                                                $gstTotal += $taxAmount;
                                                echo number_format($taxAmount, 2);
                                            @endphp
                                            (@php
                                                echo number_format($row->gst, 2);
                                            @endphp %)
                                        </td>
                                        <td class="text-center">{{ number_format($suppAmounr + $taxAmount, 2) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            <tr>
                                <td class="text-center">Total</td>
                                <td class="text-center">{{ number_format($suppAmountTotal, 2) }}</td>
                                <td class="text-center">{{ number_format($gstTotal, 2) }}</td>
                                <td class="text-center">{{ number_format($suppAmountTotal + $gstTotal, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:150px;">
                <div class="container-fluid">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center">
                            <div id="quotationprepare">
                                {{-- @if ($quotation->prepare_username)
                                {{$quotation->prepare_remark}} <br> --}}
                                    <p>{{$quotation->username}}</p>
                                    @if ($quotation->prepare_date)
                                        <p>{{ \Carbon\Carbon::parse($quotation->prepare_date)->format('d-m-Y h:i:s A') }}</p>
                                    @endif
                                {{-- @else
                                <textarea name="prepare_remark" class="form-control printHide" id="prepare_remark" rows="3"></textarea>
                                <button type="button" class="btn btn-xs btn-primary printHide" onclick="quotationprepare('prepare_remark')">Prepare</button>
                                @endif --}}
                            </div>
                            <h6 class="signature_bor">Prepared By: </h6>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center">
                            <div>
                                @if ($quotation->checked_username)
                                    <p>{{$quotation->checked_remark}}</p>
                                    <p>{{$quotation->checked_username}}</p>
                                    @if ($quotation->checked_date)
                                        <p>{{ \Carbon\Carbon::parse($quotation->checked_date)->format('d-m-Y h:i:s A') }}</p>
                                    @endif
                                @else
                                <textarea name="checked_remark" class="form-control printHide" id="checked_remark" rows="3"></textarea>
                                <button type="button" class="btn btn-xs btn-primary printHide" onclick="quotationprepare('checked_remark')">Checked</button>
                                @endif
                            </div>
                            <h6 class="signature_bor">Checked By:</h6>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center">
                            <div>
                                @if ($quotation->audited_username)
                                    <p>{{$quotation->audited_remark}}</p>
                                    <p>{{$quotation->audited_username}}</p>
                                    @if ($quotation->audited_date)
                                        <p>{{ \Carbon\Carbon::parse($quotation->audited_date)->format('d-m-Y h:i:s A') }}</p>
                                    @endif
                                @else
                                <textarea name="audited_remark" class="form-control printHide" id="audited_remark" rows="3"></textarea>
                                <button type="button" class="btn btn-xs btn-primary printHide" onclick="quotationprepare('audited_remark')">Audited</button>
                                @endif
                            </div>
                            <h6 class="signature_bor">Audited By:</h6>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center">
                            <div>
                                @if ($quotation->approved_username)
                                  <p> {{$quotation->approved_remark}}</p>
                                    <a href="{{asset(($quotation->approved_username)? $quotation->approved_attachment : '#')}}" target="blank">{{$quotation->approved_username}}<br>
                                        @if ($quotation->approved_date)
                                            <p>{{ \Carbon\Carbon::parse($quotation->approved_date)->format('d-m-Y h:i:s A') }}</p>
                                        @endif
                                    </a>
                                @else
                                <textarea name="approved_remark" class="form-control printHide" id="approved_remark" rows="3"></textarea>
                                <input type="file" name="approved_attachment" id="approved_attachment" class="printHide">
                                <button type="button" class="btn btn-xs btn-primary printHide" onclick="quotationprepare('approved_remark')">Approved</button>
                                @endif
                            </div>
                            <h6 class="signature_bor">Approved By:</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    function quotationprepare(type){
        let groupNumber = $('#groupNumber').val();
        let description = $('#'+type).val();
        let approved_attachment = $('#approved_attachment')[0].files[0] || null;
        console.log(approved_attachment);
        // return;
        var formData = new FormData();
        formData.append('approved_attachment', approved_attachment);
        formData.append('description', description);
        formData.append('groupNumber', groupNumber);
        formData.append('type', type);
        $.ajax({
            url: '{{ url('quotation/quotationApproval') }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token in the headers
            },
            success: function(response) {
                if (response == 'updated') {
                    $('#showDetailModelOneParamerter').modal('hide');
                    return
                }
                alert(response);
                
            }
        });
    }

    function calculate(id) {
        let vendorCount = "{{ count($vendor) }}";
        let demand_qty = parseFloat($('#demand_qty' + id).val()) || 0;
        for (let i = 0; i < vendorCount; i++) {
            let supp_rate = parseFloat($('#supp_rate' + i + '-' + id).text()) || 0;
            console.log(supp_rate);
            $('#total_supp_rate' + i + '-' + id).text(demand_qty * supp_rate);
        }
    }

    var dataCount = {{ count($demand_data) }}
    $(function() {
        for (let xyz = 0; xyz < dataCount; xyz++) {
            let varAmountArray = [];
            let varAmount = $('.amount' + xyz);
            varAmount.map((index, number) => {
                if (number.innerHTML.trim() == 0) {
                    number = "999999999";
                } else {
                    number = number.innerHTML.trim()
                }
                number = number.replace(',', '');
                varAmountArray.push(parseFloat(number));
            });
            let varAmountIndex = varAmountArray.indexOf(Math.min(...varAmountArray));
            varAmount[varAmountIndex].style.setProperty('background-color', 'yellow', 'important');;
        }
    })

    function approve(id, pr_id) {
        $.ajax({
            url: '{{ url('quotation/approve') }}',
            type: 'GET',
            data: {
                id: id,
                id,
                pr_id: pr_id,
                dept_id: dept_id,
                pr_no: pr_no
            },
            success: function(response) {

                if (response == 'no') {
                    alert('Quotation Againts This PR Alreday Approved');
                    return false;
                }
                $('#' + id).html('Approved');
                $('#showDetailModelOneParamerter').modal('hide');
            },
            err: function(err) {
                $('#data').html(err);
            }
        })

    }

    var array = [];
    var qtyDemand = [];
    var SubItem = [];
    var qtyRemaining = [];
    var reverseArray = [];
    var group_no_array = [];
    var damand_data_id_array = [];
    var quotation_data_vendor_array = [];
    var quotation_data_id_array = [];
    //var demandCompleteStatusType = [];

    function set_values() {
        qtyDemand = [];
        qtyRemaining = [];
        SubItem = [];
        demandCompleteStatusType = [];
        $("input[name='quotation[]']").each(function(index, obj) {
            if ($("#" + obj.id).is(":checked")) {
                if (jQuery.inArray(obj.value, array) === -1) {
                    array.push(obj.value);
                }
                qtyDemand.push($('#demand_qty' + index).val());
                qtyRemaining.push($('#remaining_qty' + index).val());
                //demandCompleteStatusType.push($('#demand_complete_status_type'+index).val())
                // SubItem.push($('#sub_item_id' + index).val())
            } else {
                array = $.grep(array, function(n) {
                    return n != obj.value;
                });
            }
        });
    }


    function set_value_reverse(){
        group_no_array = [];
        damand_data_id_array = [];
        quotation_data_vendor_array = [];
        quotation_data_id_array = [];
        $("input[name='quotationRow_id[]']").each(function(index, obj) {
            if ($("#" + obj.id).is(":checked")) {
                if (jQuery.inArray(obj.value, reverseArray) === -1) {
                    reverseArray.push(obj.value);
                }
                const myArray = obj.value.split(',');
                group_no_array.push($('#group_no'+myArray[3]).val());
                damand_data_id_array.push($('#damand_data_id'+myArray[3]).val());
                quotation_data_vendor_array.push($('#quotation_data_vendor'+myArray[3]).val());
                quotation_data_id_array.push($('#quotation_data_id'+myArray[3]).val());
            } else {
                reverseArray = $.grep(reverseArray, function(n) {
                    return n != obj.value;
                });
            }
        });
    }

    function multipleReverse(){
        set_value_reverse();
        if(reverseArray.length == 0){
            alert('Something went Wrong! Please atleast select one row for reverse.....');
            return false;
        }else{
            $.ajax({
                url: '{{ url('quotation/multipleReverse') }}',
                type: 'GET',
                data: {
                    reverseArray: reverseArray,
                    group_no_array:group_no_array,
                    damand_data_id_array:damand_data_id_array,
                    quotation_data_vendor_array:quotation_data_vendor_array,
                    quotation_data_id_array:quotation_data_id_array
                },
                success: function(response) {
                    $('#showDetailModelOneParamerter').modal('hide');
                    get_data();
                },
                err: function(err) {
                    //$('#data').html(err);
                }
            })
        }
        
    }

    

    function reverseBtn(id) {
        var group_no = $('#group_no' + id).val();
        var damand_data_id = $('#damand_data_id' + id).val();
        var quotation_data_vendor = $('#quotation_data_vendor' + id).val();
        var quotation_data_id = $('#quotation_data_id' + id).val();
        // alert(damand_data_id)
        $.ajax({
            url: '{{ url('quotation/reverseQuotation') }}',
            type: 'GET',
            data: {
                damand_data_id: damand_data_id,
                quotation_data_vendor: quotation_data_vendor,
                quotation_data_id: quotation_data_id,
                group_no: group_no
            },
            success: function(response) {
                //    $('#'+id).html('Approved');
                // $('#rever' + id).hide();
                $('#showDetailModelOneParamerter').modal('hide');
                get_data();
            },
            err: function(err) {
                $('#data').html(err);
            }
        })
    }


    function save() {

        set_values();
        // console.log(qtyDemand);
        // return;
        var group_number = $('#group_number').val();
        var vendor = $('#vendor').val();
        var desc = $('#desc').val();
        var quotation_master_id = $('#quotation_master_id').val();

        if (vendor == '' || array.length == 0) {
            alert('Required All Fields');
            return false;
        }
        $.ajax({


            url: '{{ url('quotation/approved_quotation_summary') }}',
            type: 'GET',
            data: {
                array: array,
                vendor: vendor,
                desc: desc,
                quotation_master_id: quotation_master_id,
                qtyDemand: qtyDemand,
                qtyRemaining: qtyRemaining,
                SubItem: SubItem,
                group_number: group_number
            },
            success: function(response) {
                //    $('#'+id).html('Approved');
                $('#showDetailModelOneParamerter').modal('hide');
                get_data();
            },
            err: function(err) {
                $('#data').html(err);
            }
        })
    }
    function checkQuotationQty(param){
        // let exceed_value_count = 0;
        // var remaining_qty = $('#remaining_qty'+param+'').val();
        // var demand_qty = $('#demand_qty'+param+'').val();
        // if(parseInt(demand_qty) <= parseInt(remaining_qty)){
        //     $('#row_count'+param+'').val(0);
        // }else{
        //     alert('Something went wrong! This item Quotation Qty is greater than Remaining Qty....\n Remaining Qty is: '+remaining_qty+'');
        //     $('#row_count'+param+'').val(1);
        // }

        // $('.row_count').each(function(){
        //     exceed_value_count += parseInt(exceed_value_count) + parseInt(this.value);
        // });
        
        // $('#exceed_value_count').val(exceed_value_count);
        // if(exceed_value_count == 0){
        //     $('#approvedBtn').attr('disabled' , false);
        // }else{
        //     $('#approvedBtn').attr('disabled' , true);
        // }
    }
</script>




{{-- Ali Shiwani --}}
