@php
    
    // use App\Helpers\StoreHelper;
    use App\Helpers\CommonHelper;
    // use App\Helpers\ReuseableCode;
@endphp
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label for="">Voucher No</label>
            <input type="text" readonly class="form-control" name=""
                value="{{ CommonHelper::getGRVoucherNumber() }}">
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label for="">Voucher Date</label>
            <input type="date" class="form-control" id="voucher_date" name="voucher_date"
                value="{{ date('Y-m-d') }}">
        </div>

    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label for="">Date of Return </label>
            <input type="date" name="return_date" class="form-control requiredField " value="">
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label for="">Contact person</label>
            <input type="text" name="contact_person" class="form-control requiredField " value="">
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label for="">Sender name</label>
            <input type="text" name="sender_name" class="form-control requiredField " value="">
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label class="sf-label">From Department</label>
            <span class="rflabelsteric"><strong>*</strong></span>
            <select class="form-control requiredField select2" name="department_id" id="department_id">
                <option value="">Select Department</option>
                @foreach ($departments as $key => $y)
                    <optgroup label="{{ $y->department_name }}" value="{{ $y->id }}">
                        @php
                            $subdepartments = DB::select('select `id`,`sub_department_name` from `sub_department` where `department_id` =' . $y->id . '');
                        @endphp
                        @foreach ($subdepartments as $key2 => $y2)
                            <option value="{{ $y2->id }}">
                                {{ $y2->sub_department_name }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label class="sf-label">Location</label>
            <span class="rflabelsteric"><strong>*</strong></span>
            <select class="form-control requiredField select2" name="location_id" id="location_id">
                <option value="">Select Location</option>
                @foreach (CommonHelper::get_all_warehouse() as $warehouse)
                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="lineHeight">&nbsp;</div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div style="text-align: center" class="table-responsive  text-center" id="">
                <table style="" class="table table-bordered well">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 20%;">Products</th>
                            <th class="text-center" style="width: 5%;">UOM</th>
                            <th class="text-center" style="width: 10%;">type</th>
                            <th class="text-center" style="width: 25%;">Reason</th>
                            <th class="text-center" style="width: 5%;">Issue QTY</th>
                            <th class="text-center" style="width: 5%;">previous Return QTY</th>
                            <th class="text-center" style="width: 10%;">Return QTY</th>
                            <th class="text-center" style="width: 10%;">Rate</th>
                            <th class="text-center" style="width: 10%;">Total</th>
                        </tr>
                    </thead>
                    <tbody id="AppnedHtml">
                        @foreach ($maintenanceJob->jobData as $key => $jobData)
                            @php
                                ++$key;
                            @endphp
                            <tr>
                                <td>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $jobData->subItem->sub_ic }}">
                                    <input type="hidden" class="form-control" name="item_id[]" readonly
                                        value="{{ $jobData->item_id }}">
                                </td>
                                <td>
                                    <input type="text" value="{{ $jobData->subItem->uomData->uom_name }}"
                                        class="form-control" readonly name="uom[]">
                                </td>
                                <td>
                                    <select name="quality_type[]" id="quality_type{{ $key }}"
                                        class="form-control requiredField select2">
                                        <option value="">Select Type</option>
                                        @foreach (CommonHelper::qualityType() as $type)
                                            <option value="{{ $type['id'] }}">
                                                {{ $type['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <textarea name="item_remark[]" id="item_remark{{ $key }}" class="form-control" rows="3"></textarea>
                                </td>
                                <td>
                                    <input type="number" class="form-control requiredField" min="0" readonly
                                        value="{{ $jobData->qty }}" step="any" name="mj_qty[]"
                                        id="mj_qty{{ $key }}">
                                </td>
                                <td>
                                    @php
                                        $pre_qty = CommonHelper::getMaintenanceJobPreviousStock($jobData->item_id, $maintenanceJob->id);
                                    @endphp
                                    <input type="number" class="form-control requiredField" min="0" readonly
                                        value="{{ $pre_qty }}" step="any" name="previous_qty[]"
                                        id="previous_qty{{ $key }}">
                                </td>
                                <td>
                                    <input type="number" class="form-control requiredField" min="0"
                                        value="{{ $jobData->qty - $pre_qty }}" onkeyup="calcu({{ $key }})"
                                        step="any" name="qty[]" id="qty{{ $key }}">
                                </td>
                                <td>
                                    <input type="number" class="form-control requiredField" min="0" readonly
                                        value="{{ $jobData->rate }}" step="any"
                                        onkeyup="calcu({{ $key }})" name="rate[]"
                                        id="rate{{ $key }}">
                                </td>
                                <td>
                                    <input type="number" class="form-control requiredField total" readonly
                                        min="0" value="{{ $jobData->total }}" step="any" name="total[]"
                                        id="total{{ $key }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right" colspan="8">Total</td>
                            <th><input type="number" class="form-control" step="any" name="total_amount"
                                    id="total_amount" /></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label for="">Remarks</label>
            <textarea class="form-control" name="description" id="description" cols="5" rows="5"></textarea>
        </div>
    </div>
    <div class="demandsSection"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}

        </div>
    </div>
</div>

<script type="text/javascript">
    $('.select2').select2();


    let counter = {{ count($maintenanceJob->jobData) }};

    function calcu(id) {
        let qty = $('#qty' + id).val() || 0;
        let rate = $('#rate' + id).val() || 0;

        let amount = qty * rate;
        $('#total' + id).val(amount.toFixed(2));
        let total = $('.total');
        let sum = 0;
        for (let i = 0; i < total.length; i++) {
            sum += parseFloat(total[i].value);
        }
        $('#total_amount').val(sum.toFixed(2));

        let mjQty = $('#mj_qty'+id).val();
        let preQty = $('#previous_qty'+id).val();
        let returnableQty = parseFloat(mjQty - preQty);
        if(returnableQty < qty || qty == ''){
            $('#qty' + id).css('border', '2px solid red'); 
            $('.btn-success').attr('disabled', true); 
        }else{
            $('#qty' + id).css('border', '2px solid #D8D6DE');
            $('.btn-success').attr('disabled', false); 
        }

    }

    $(document).ready(function() {
        for (let i = 1; i <= counter; i++) {
            calcu(i);
        }

        $(".btn-success").click(function(e) {

            //alert();
            var purchaseRequest = new Array();
            var val;
            //$("input[name='demandsSection[]']").each(function(){
            purchaseRequest.push($(this).val());



            //});
            var _token = $("input[name='_token']").val();
            for (val of purchaseRequest) {
                jqueryValidationCustom();
                if (validate == 0) {
                    //alert(response);
                } else {
                    return false;
                }
            }

        });
    });
</script>
<script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
