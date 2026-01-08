@php
    
    // use App\Helpers\StoreHelper;
    use App\Helpers\CommonHelper;
    // use App\Helpers\ReuseableCode;
@endphp
<style>
    * {
        font-size: 12px !important;
        font-family: Arial;
    }

    .select2 {
        width: 100%;
    }

    label {
        text-transform: capitalize;
    }

    .input-container {
        display: -ms-flexbox;
        /* IE10 */
        display: flex;
        width: 100%;
        margin-bottom: 15px;
    }

    .icon {
        padding: 15px;
        background: #8d9399;
        color: white;
        min-width: 20px;
        text-align: center;
        height: 43px;
    }

    .input-field {
        /* width: 100%;
          padding: 10px; */
        outline: none;
    }

    .input-field:focus {
        border: 2px solid rgb(125, 129, 134);
    }
</style>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row" id="form">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <label for="">Voucher No</label>
            <input type="text" readonly class="form-control requiredField" name=""
                value="{{ CommonHelper::getWGRNVoucherNumber() }}">
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <label for="">Voucher Date</label>
            <input type="date" class="form-control" id="Voucher_date" name="Voucher_date"
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
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <label for="">Attachemnt file</label>
            <div class="input-container">
                <input class="input-field form-control" type="file"
                    name="file[]"><i class="fa fa-plus icon"
                    onclick="add()"></i>
            </div>
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
                            <th class="text-center" style="width: 10%;">Maintenance Job Qty.</th>
                            <th class="text-center" style="width: 10%;">Gate Pass Qty.</th>
                            <th class="text-center" style="width: 10%;">Previous GRN Received.</th>
                            <th class="text-center" style="width: 10%;">Recieve QTY.</th>
                            <th class="text-center" style="width: 10%;">Repair Cost.</th>
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
                                        value="{{ $jobData->qty }}" step="any" name="mj_qty[]"
                                        id="mj_qty{{ $key }}">
                                </td>

                                @php
                                    $gate_pass_qty = CommonHelper::getPreviousReceivedGatePassInQty($jobData->item_id, $jobData->maintenance_job_id, $locationId);
                                    $pre_qty = CommonHelper::getPreviousReceivedGRNQty($jobData->item_id, $jobData->maintenance_job_id);
                                    $actual_qty = $jobData->qty - $pre_qty;
                                @endphp
                                <td>
                                    <input type="number" class="form-control requiredField" min="0" readonly
                                        value="{{ $gate_pass_qty }}" step="any" name="gate_pass_qty[]"
                                        id="gate_pass_qty{{ $key }}">
                                </td>
                                <td>
                                    <input type="number" class="form-control requiredField" min="0" readonly
                                        value="{{ $pre_qty }}" step="any" name="pre_qty[]"
                                        id="pre_qty{{ $key }}">
                                </td>
                                <td>
                                    <input type="number" class="form-control requiredField" min="0"
                                        value="{{ $gate_pass_qty-$pre_qty }}" step="any" name="qty_received[]"
                                        id="qty_received{{ $key }}" onkeyup="calcu({{ $key }})">
                                </td>
                                <td>
                                    <input type="number" class="form-control requiredField" min="0"
                                        value="" step="any" name="repair_cost[]" id="repair_cost{{ $key }}">
                                </td>
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

    var attachCounter = 0;
    function add() {
        attachCounter++;
        var html = ` <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" id="row` + attachCounter +
            `">
                    <label>&nbsp</label>
                <div class="input-container">
                <input class="input-field form-control" type="file" placeholder="Form No " name="file[]"><i class="fa fa-minus icon" onclick="minus(` +
            attachCounter + `)"></i>
            </div>
        </div>`;
        $('#form').append(html);
    }
    function minus(number) {
        $('#row' + number).remove();
        attachCounter--;
    }

    let counter = {{ count($maintenanceJob->jobData) }};

    function calcu(id) {
        let qty = $('#gate_pass_qty' + id).val();
        let pre_qty = $('#pre_qty' + id).val();
        let receiving_qty = parseFloat(qty - pre_qty);
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
