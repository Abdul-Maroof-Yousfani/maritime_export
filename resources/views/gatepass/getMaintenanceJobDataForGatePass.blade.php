@php
    
    // use App\Helpers\StoreHelper;
    use App\Helpers\CommonHelper;
    // use App\Helpers\ReuseableCode;
@endphp
<input type="hidden" name="gate_pass_type" value="{{ $gate_pass_type }}">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <label for="">Voucher No</label>
            <input type="text" readonly class="form-control requiredField" name="gate_pass_no"
                value="{{ $gate_pass_no }}">
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <label for="">Voucher Date</label>
            <input type="date" class="form-control" id="gate_pass_date" name="gate_pass_date"
                value="{{ date('Y-m-d') }}">
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <label for="">MO No</label>
            <input type="text" readonly class="form-control requiredField" name="mo_no"
                value="{{ $maintenanceJob->voucher_no }}">
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <label for="">Location</label>
            <input type="text" readonly name="warehouse_id" class="form-control "
                value="{{ $maintenanceJob->maintenanceRequest->warehouse->name ?? '' }}">
        </div>
        @if ($maintenanceJob->job_type == 3)
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label for="">Repairing Location from</label>
                <input type="text" readonly name="supplier" class="form-control "
                    value="{{ optional(CommonHelper::getLocationDetail($maintenanceJob->warehouse_id))->location_name }}">
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label for="">Repairing Location To</label>
                <input type="text" readonly name="supplier" class="form-control "
                    value="{{ optional(CommonHelper::getLocationDetail($maintenanceJob->warehouse_id_to))->location_name }}">
            </div>
        @else
            
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label for="">Supplier</label>
                <input type="text" readonly name="supplier" class="form-control "
                    value="{{ $maintenanceJob->supplier->name ?? '' }}">
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label for="">Supplier Addresss</label>
                <input type="text" readonly name="supplier_address" class="form-control "
                    value="{{ $maintenanceJob->supplier->address ?? '' }}">
            </div>
        @endif

    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            @if ($gate_pass_type == 1)
                <label for="">Good Brought By:</label>
            @else
                <label for="">Good Taken By:</label>
            @endif
            <input type="text" name="good_taken_by" class="form-control requiredField" id="good_taken_by" value="">
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <label for="">Vehicle No</label>
            <input type="text" class="form-control requiredField" name="vehicle_no" id="vehicle_no" value="">
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <label for="">Contact No</label>
            <input type="number" class="form-control" name="contact_no" id="contact_no" value="">
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
                            <th class="text-center" style="width: 10%;">QTY.</th>
                            @if ($gate_pass_type == 1)
                                <th class="text-center" style="width: 10%;">Previous Recieve QTY.</th>
                                <th class="text-center" style="width: 10%;">Recieve QTY.</th>
                            @endif
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
                                    <input type="hidden" class="form-control requiredField" name="item_id[]" readonly
                                        value="{{ $jobData->item_id }}">
                                </td>

                                <td>
                                    <input type="number" class="form-control requiredField" min="0" readonly
                                        value="{{ $jobData->qty }}" step="any" name="qty[]"
                                        id="qty{{ $key }}">
                                </td>
                                @if ($gate_pass_type == 1)
                                    @php
                                        $pre_qty = CommonHelper::getPreviousReceivedGatePassInQty($jobData->item_id, $jobData->maintenance_job_id, $locationId);
                                        $actual_qty = $jobData->qty - $pre_qty;
                                    @endphp
                                    <td>
                                        <input type="number" class="form-control requiredField" min="0" readonly
                                            value="{{ $pre_qty }}" step="any" name="pre_qty[]"
                                            id="pre_qty{{ $key }}">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control requiredField" min="0"
                                            value="{{ $actual_qty }}" step="any" name="qty_received[]"
                                            id="qty_received{{ $key }}"
                                            onkeyup="calcu({{ $key }})">
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
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
        let qty = $('#qty' + id).val();
        let pre_qty = $('#pre_qty' + id).val();
        let receiving_qty = parseFloat(qty-pre_qty);
        let qty_received = $('#qty_received' + id).val();
        if (qty_received > receiving_qty) {
            $('.btn-success').attr('disabled', true);
            $('#qty_received' + id).css({
                'border': '1px solid red'
            });;
        } else {
            $('.btn-success').attr('disabled', false);
            $('#qty_received' + id).css({
                'border': '1px solid #D8D6DE'
            });;
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
