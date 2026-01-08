<hr/>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr class="bg-primary" >
            <th colspan="4"  >
                <h4 class="fw-bold">Product Parameter</h4>
            </th>
        </tr>
        <tr class="bg-primary" >
            <th class="bg-primary" >Moisture (%):</th>
            <th class="bg-primary" >Damage (%):</th>
            <th class="bg-primary" >Chalky (%):</th>
            <th class="bg-primary" >Broken (%):</th>
            <th class="bg-primary" >Look (%):</th>
            <th class="bg-primary" >O.V (RS):</th>
            <th class="bg-primary" >CHOBBA (RS):</th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <th >{{$purcahseOrder->moisture}}</th>
            <th >{{$purcahseOrder->damage}}</th>
            <th  >{{$purcahseOrder->chalky}}</th>
            <th >{{$purcahseOrder->broken}}</th>
            <th >{{$purcahseOrder->look}}</th>
            <th >{{$purcahseOrder->o_v}}</th>
            <th >{{$purcahseOrder->chobba}}</th>
        </tr>
        </tbody>
    </table>
</div>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr class="bg-primary" >
            <th  class="bg-primary"  >
                Particulars
            </th>
            <th class="bg-primary" >First Report</th>
            <th class="bg-primary" >Action</th>
        </tr>
        </thead>
        <tbody id="AppnedHtml">
        @php
            $counter = 1;
        @endphp
        @if(count($qcs) != 0)
            @foreach($qcs as $qc)
                <tr>
                    <th >
                        {{ $qc->name}}
                        <input type="hidden" value="{{$qc->id}}" name="checklist_id[]">
                    </th>
                    <th class="text-center">
                        <input type="text" class="form-control requiredField" name="checklist_comment[]">
                    </th>
                    <th>
                        @if ($counter > 1)
                            <button onclick="removeRow(this)" class="btn btn-sm btn-danger">remove</button>
                        @endif
                        @php
                            $counter++;
                        @endphp
                    </th>
                </tr>
            @endforeach
        @else
            <tr>
                <th style="width: 100%" >
                    <div class="alert alert-warning">
                        No record found
                    </div>
                </th>
            </tr>
        @endif
        </tbody>
    </table>
</div>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr class="bg-primary" >
            <th colspan="4"  >
                <h4 class="fw-bold">Product Parameter</h4>
            </th>
        </tr>
        <tr class="bg-primary" >
            <th width="25%" class="bg-primary" >PO Qty:</th>
            <th width="25%"  class="bg-primary" >Balance Qty:</th>
            <th width="25%"  class="bg-primary" >Received:</th>
            <th width="25%"  class="bg-primary" >Rejected:</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>
                <input type="number" readonly name="total_qty" value="{{$purcahseOrder->min_qty_kg}}" class="form-control">
            </th>
            <th>
                <input type="number" readonly name="balance_qty" value="{{$purcahseOrder->balance_qty}}"  class="form-control">
            </th>
            <th>
                <input type="number" name="recived_qty" value=""  class="form-control">
            </th>
            <th>
                <input type="number"  name="reject_qty" value="0"  class="form-control">
            </th>
        </tr>
        </tbody>
    </table>
</div>
<script>
    function removeRow(instance)
    {
        $(instance).closest('tr').remove();
    }
</script>