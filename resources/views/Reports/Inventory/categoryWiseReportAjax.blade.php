
@php
    use App\Helpers\CommonHelper;
@endphp
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <h5 style="text-align: center" id="h3"></h5>
            <table class="table table-bordered sf-table-list"
                id="expToExcel">
                <thead>
                    <th class="text-center">PR Date</th>
                    <th class="text-center">Category Name</th>
                    <th class="text-center">Department Name </th>
                    <th class="text-center">PR  No </th>
                    <th class="text-center">Item Code</th>
                    <th class="text-center">Item Name</th>
                    <th class="text-center">PR Item Remarks</th>
                    <th class="text-center">Po Item Remarks </th>
                    <th class="text-center">UOM </th>
                    <th class="text-center">PR Qty  </th>
                    <th class="text-center">PO Qty  </th>
                    <th class="text-center">GRN Qty  </th>
                    <th class="text-center">Supplier Name  </th>
                    <th class="text-center">PO Rate </th>
                    <th class="text-center">PO Amount  </th>
                    <th class="text-center">GST Amount  </th>
                    <th class="text-center">Discount obtain  </th>
                    <th class="text-center">Total  Amount  </th>
                    <th class="text-center">Comparative No </th>
                    <th class="text-center">PO No </th>
                    <th class="text-center">PO Date </th>
                    <th class="text-center">GRN No </th>
                    <th class="text-center">GRN Date </th>
                    <th class="text-center">PI No </th>
                    <th class="text-center">PI Date </th>
                    <th class="text-center">Location </th>
                </thead>
                <tbody >
                    @foreach($data  as $value )
                        <tr>
                            <td>{{date_format(new DateTime($value->demand_date),"d-M-Y")}}</td>
                            <td>{{$value->category_name}}</td>
                            <td>{{$value->sub_department_name}}</td>
                            <td>{{$value->demand_no}}</td>
                            <td>{{$value->item_code}}</td>
                            <td>{{$value->sub_ic}}</td>
                            <td>{{$value->description}}</td>
                            <td>{{$value->remarks?? '-'}}</td>
                            <td><?php echo $uom =  CommonHelper::get_uom_by_uom_id($value->uom); ?></td>
                            <td>{{number_format($value->demand_qty,2)}}</td>
                            <td>{{number_format($value->purchase_approve_qty,2)}}</td>
                            <td>{{number_format($value->purchase_recived_qty,2)}}</td>
                            <td>{{$value->name}}</td>
                            <td>{{number_format($value->rate,0)}}</td>
                            <td>{{number_format($value->sub_total,2)}}</td>
                            <td>{{number_format($value->sub_total/100*$value->sales_tax,1)}}</td>
                            <td>{{$value->discount_amount}}</td>
                            <td>{{number_format($value->sub_total/100*$value->sales_tax+$value->sub_total-$value->discount_amount,2)}}</td>
                            <td>{{$value->group_number}}</td> {{-- $value->group_number --}}
                            <td>{{$value->purchase_request_no}}</td>
                            <td>{{ ($value->purchase_request_date)? date_format(new DateTime($value->purchase_request_date),"d-M-Y") : '-'}}</td>
                            <td>{{$value->grn_no}}</td>
                            <td>{{ ($value->grn_date)? date_format(new DateTime($value->grn_date),"d-M-Y") : '-'}}</td>
                            <td>{{$value->pv_no}}</td>
                            <td>{{ ($value->pv_date)? date_format(new DateTime($value->pv_date),"d-M-Y") : '-'}}</td>
                            <td>{{CommonHelper::getLocationDetail($value->company_location_id)->location_name??''}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>