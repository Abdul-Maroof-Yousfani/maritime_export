<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >

        <div class="table-responsive " >
            <table class="table table-bordered">
                <thead>
                <tr class="bg-primary" >
                    <th   class="bg-primary"  >
                        Particulars
                    </th>
                    <th class="bg-primary" >First Report</th>
                    <th class="bg-primary" >Second Report</th>
                    <th class="bg-primary" >Action</th>
                </tr>
                </thead>

                <tbody >
                @php
                    $counter = 1;
                @endphp
                @if(count($qcs) != 0)
                    @foreach($qcs as $key => $qc)
                        @php
                            $checklistsData = DB::connection('mysql2')->table('arrival_inspections')
                            ->where('ins_no',$id)
            //                ->join('arrival_inspections' , 'arrival_inspections.po_no' , 'production_purchase_orders.voucher_no')
                            ->join('inpection_checklists' , 'inpection_checklists.ins_id' , 'arrival_inspections.id')
                            ->where('inpection_checklists.checker_id' , $qc->id)
                            ->select('inpection_checklists.comment')
                            ->first();
            //                dd($checklistsData,$id);
                        @endphp
                        @if($checklistsData)
                        <tr>
                            <th  >
                                {{ $qc->name}}
                                <input type="hidden" value="{{$qc->id}}" name="checklist_id[]">
                            </th>

                            <th  class="text-center">
                                <input disabled type="text" class="form-control requiredField" value="{{$checklistsData->comment ?? ''}}" name="checklist_comment[]">
                            </th>
                            <th   class="text-center">
                                <input type="text" class="form-control requiredField"  name="second_checklist_comment[]">
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
                        @endif
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


    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr class="bg-primary" >
                    <th colspan="4"  >
                        <h4 class="fw-bold">First  Inspection </h4>
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
                        <input type="number" disabled  value="{{$purcahseOrder->min_qty_kg}}" class="form-control">
                    </th>
                    <th>
                        <input type="number" disabled value="{{$purcahseOrder->balance_qty}}"  class="form-control">
                    </th>
                    <th>
                        <input type="number"  disabled value="{{$inspection->recived_qty}}"  class="form-control">
                    </th>
                    <th>
                        <input type="number"   disabled value="{{$inspection->reject_qty}}"  class="form-control">
                    </th>
                </tr>
                <tr class="bg-primary" >
                    <th colspan="4"  >
                        <h4 class="fw-bold">Second Inspection </h4>
                    </th>
                </tr>
                <tr>
                    <th>
                        <input type="number" readonly name="total_qty" value="{{$purcahseOrder->min_qty_kg}}" class="form-control">
                    </th>
                    <th>
                        <input type="number" readonly  name="balance_qty" value="{{$purcahseOrder->balance_qty}}"  class="form-control">
                    </th>
                    <th>
                        <input type="number" name="recived_qty"  value=""  class="form-control">
                    </th>
                    <th>
                        <input type="number"  name="reject_qty"  value="0"  class="form-control">
                    </th>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
    function removeRow(instance)
    {
        $(instance).closest('tr').remove();
    }
</script>