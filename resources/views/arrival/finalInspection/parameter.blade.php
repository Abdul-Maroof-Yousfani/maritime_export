<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <input type="text" class="form-control" name="recived_qty" value="{{$received_qty}}" readonly>

        <div class="table-responsive">
            <table class="table table-bordered">
    <thead>
        <tr>
            <td class="bg-primary">
                Name 
            </td>
            <td class="bg-primary">
                Received Qty 
            </td>
            {{-- <td class="bg-primary">
                 Deduction 
            </td>
           --}}
            <td class="bg-primary">
                Deduction Total
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                Moisture (KG)
            </td>
            <td>
                <input type="text" class="form-control" name="received_qty[]" value="{{$received_qty}}" readonly>
                <input type="hidden" class="form-control" name="parameter_id[]" value="{{optional($inspection->moisture)->checker_id}}" readonly>
            </td>
            {{-- <td>
                <input type="text" class="form-control" name="deduction[]" value="{{$moisture ?? 0}}" readonly>
            </td> --}}
            <td>
                <input type="hidden" class="form-control" name="deduction[]" value="0" readonly>
                <input type="text" class="form-control" name="total_deduction[]" value="{{(float)$received_qty/100 * (float)$moisture}}" readonly>
            </td>
            <td>
                <input type="text" class="form-control" name="total_deduction_update[]" value="{{(float)$received_qty/100 * (float)$moisture}}" readonly>
            </td>
        </tr>
        <tr>
            <td>
                Broken (Rs.)
            </td>
            <td>
                <input type="text" class="form-control" name="received_qty[]" value="{{$received_qty}}" readonly>
                <input type="hidden" class="form-control" name="parameter_id[]" value="{{optional($inspection->broken)->checker_id}}" readonly>
            </td>
            <td>
                <input type="hidden" class="form-control" name="deduction[]" value="0" readonly>
                <input type="text" class="form-control" name="total_deduction[]" value="{{$broken ?? 0}}" readonly>
            </td>
            <td>
                <input type="text" class="form-control" name="total_deduction_update[]" value="{{$broken ?? 0}}" >
            </td>
            {{-- <td>
                <input type="text" class="form-control" name="total_deduction[]" value="{{ ((float)optional($inspection->broken)->comment / 100) * (float)$broken * (float)$received_qty }}" readonly>
            </td> --}}
        </tr>
        <tr>
            <td>
                Damage (KG)
            </td>
            <td>
                <input type="text" class="form-control" name="received_qty[]" value="{{$received_qty}}" readonly>
                <input type="hidden" class="form-control" name="parameter_id[]" value="{{optional($inspection->damage)->checker_id}}" readonly>
            </td>
            <td>
                <input type="hidden" class="form-control" name="deduction[]" value="0" readonly>
                <input type="text" class="form-control" name="total_deduction[]" value="{{$damage ?? 0}}" readonly>
            </td>
            <td>
                <input type="text" class="form-control" name="total_deduction_update[]" value="{{$damage ?? 0}}" >
            </td>
            {{-- <td>
                <input type="text" class="form-control" name="total_deduction[]" value="{{ ((float)optional($inspection->damage)->comment / 100) * (float)$damage * (float)$received_qty }}" readonly>
            </td> --}}
        </tr>
        <tr>
            <td>
                Chobba (KG)
            </td>
            <td>
                <input type="text" class="form-control" name="received_qty[]" value="{{$received_qty}}" readonly>
                <input type="hidden" class="form-control" name="parameter_id[]" value="{{optional($inspection->chobba)->checker_id}}" readonly>
            </td>
            <td>
                <input type="hidden" class="form-control" name="deduction[]" value="0" readonly>
                <input type="text" class="form-control" name="total_deduction[]" value="{{$chobba ?? 0}}" readonly>
            </td>
            <td>
                <input type="text" class="form-control" name="total_deduction_update[]" value="{{$chobba ?? 0}}" >
            </td>
            {{-- <td>
                <input type="text" class="form-control" name="total_deduction[]" value="{{ ((float)optional($inspection->chobba)->comment / 100) * (float)$chobba * (float)$received_qty }}" readonly>
            </td> --}}
        </tr>
        <tr>
            <td>
                Look (KG)
            </td>
            <td>
                <input type="text" class="form-control" name="received_qty[]" value="{{$received_qty}}" readonly>
                <input type="hidden" class="form-control" name="parameter_id[]" value="{{optional($inspection->look)->checker_id}}" readonly>
            </td>
            <td>
                <input type="hidden" class="form-control" name="deduction[]" value="0" readonly>
                <input type="text" class="form-control" name="total_deduction[]" value="{{$look ?? 0}}" readonly>
            </td>
            <td>
                <input type="text" class="form-control" name="total_deduction_update[]" value="{{$look ?? 0}}" >
            </td>
            {{-- <td>
                <input type="text" class="form-control" name="total_deduction[]" value="{{ ((float)optional($inspection->look)->comment / 100) * (float)$look * (float)$received_qty }}" >
            </td> --}}
        </tr>
        <tr>
            <td>
                O.V (KG)
            </td>
            <td>
                <input type="text" class="form-control" name="received_qty[]" value="{{$received_qty}}" readonly>
                <input type="hidden" class="form-control" name="parameter_id[]" value="{{optional($inspection->o_v)->checker_id}}" readonly>
            </td>
            <td>
                <input type="hidden" class="form-control" name="deduction[]" value="0" readonly>
                <input type="text" class="form-control" name="total_deduction[]" value="{{$o_v ?? 0}}" readonly>
            </td>
            <td>
                <input type="text" class="form-control" name="total_deduction_update[]" value="{{$o_v ?? 0}}">
            </td>
            {{-- <td>
                <input type="text" class="form-control" name="total_deduction[]" value="{{ ((float)optional($inspection->o_v)->comment / 100) * (float)$o_v * (float)$received_qty }}" readonly>
            </td> --}}
        </tr>
        <tr>
            <td>
                Chalky (KG)
            </td>
            <td>
                <input type="text" class="form-control" name="received_qty[]" value="{{$received_qty}}" readonly>
                <input type="hidden" class="form-control" name="parameter_id[]" value="{{optional($inspection->chalky)->checker_id}}" readonly>
            </td>
            <td>
                <input type="hidden" class="form-control" name="deduction[]" value="0" readonly>
                <input type="text" class="form-control" name="total_deduction[]" value="{{$chalky ?? 0}}" readonly>
            </td>
            <td>
                <input type="text" class="form-control" name="total_deduction_update[]" value="{{$chalky ?? 0}}" >
            </td>
            {{-- <td>
                <input type="text" class="form-control" name="total_deduction[]" value="{{ ((float)optional($inspection->chalky)->comment / 100) * (float)$chalky * (float)$received_qty }}" readonly>
            </td> --}}
        </tr>
    </tbody>
    
    
</table>
        </div>
    </div>
</div>