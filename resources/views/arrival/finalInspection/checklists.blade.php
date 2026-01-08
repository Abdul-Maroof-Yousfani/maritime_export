<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr class="bg-primary">
                    <th class="bg-primary">
                        Particulars
                    </th>
                    <th class="bg-primary">First Report</th>
                    <th class="bg-primary">Second Report</th>

                    <th class="bg-primary">Action</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $counter = 1;
                @endphp
                @if(count($qcs) != 0)
                    @foreach($qcs as $key => $qc)
                            <?php
                            $checklistsData2 = DB::connection('mysql2')->table('inpection_checklists')

                                // ->where('production_purchase_orders.id' , $id)
                                ->where('inpection_checklists.ins_id' , $ins->id)
                                ->where('inpection_checklists.checker_id' , $qc->id)
                                ->where('inpection_checklists.type' , 2)
                                ->select('inpection_checklists.comment')
                                ->first();
                            ?>
                        @if($checklistsData2)

                            <tr>
                                <th  >
                                    {{ $qc->name}}
                                    <input type="hidden" value="{{$qc->id}}" name="checklist_id[]">
                                </th>
                                @php
                                    // $checklistsData = DB::connection('mysql2')->table('arrival_inspections')
                                    // ->join('arrival_inspections' , 'arrival_inspections.po_no' , 'production_purchase_orders.voucher_no')
                                    // ->join('inpection_checklists' , 'inpection_checklists.ins_id' , 'arrival_inspections.id')
                                    // // ->where('production_purchase_orders.id' , $id)
                                    // ->where('inpection_checklists.checker_id' , $qc->id)
                                    // ->where('inpection_checklists.type' , 1)

                                    // ->select('inpection_checklists.comment')
                                    // ->first();

                                    $checklistsData = DB::connection('mysql2')->table('inpection_checklists')

                                    // ->where('production_purchase_orders.id' , $id)
                                    ->where('inpection_checklists.ins_id' , $firstins->id)
                                    ->where('inpection_checklists.checker_id' , $qc->id)
                                    ->where('inpection_checklists.type' , 1)
                                    ->select('inpection_checklists.comment')
                                    ->first();






                                // $checklistsData2 = DB::connection('mysql2')->table('production_purchase_orders')
                                // ->join('arrival_inspections' , 'arrival_inspections.po_no' , 'production_purchase_orders.voucher_no')
                                // ->join('inpection_checklists' , 'inpection_checklists.ins_id' , 'arrival_inspections.id')
                                // // ->where('production_purchase_orders.id' , $id)
                                // ->where('inpection_checklists.checker_id' , $qc->id)
                                // ->where('inpection_checklists.type' , 2)

                                // ->select('inpection_checklists.comment')
                                // ->first();
                                @endphp
                                <th  class="text-center">
                                    <input readonly type="text" class="form-control requiredField" value="{{$checklistsData->comment ?? ''}}" name="checklist_comment[]">
                                </th>
                                <th  class="text-center">
                                    <input readonly type="text" class="form-control requiredField" value="{{$checklistsData2->comment ?? ''}}" name="checklist_comment[]">
                                </th>
                                {{-- <th   class="text-center">
                                    <input type="text" class="form-control requiredField" required name="second_checklist_comment[]">
                                </th> --}}
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
<script>
    function removeRow(instance)
    {
        $(instance).closest('tr').remove();
    }
</script>