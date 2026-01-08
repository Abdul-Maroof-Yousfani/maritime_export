<?php
    $counter = 1;
    use App\Helpers\CommonHelper;
    use App\Models\SubDepartment;
    foreach($getDetail as $gdRow) {
        $subdepartment = SubDepartment::where('id', $gdRow->department_id)->select('sub_department_name')->value('sub_department_name');
    ?>
        <tr>
            <td class="text-center"><?php echo $counter++;?></td>
            <td>{{$gdRow->warehouseName}}</td>
            <td>{{ $subdepartment }}</td>
            <td>{{$gdRow->line_name ?? ''}}</td>
            <td>{{$gdRow->sub_ic}}</td>
            <td class="text-center">{{$gdRow->mrVoucherNo}}</td>
            <td class="text-center">{{$gdRow->mrVoucherDate ? date('Y-m-d', strtotime($gdRow->mrVoucherDate)) : ''}}</td>
            <td class="text-center">{{$gdRow->mrdQty}}</td>
            <td class="text-center">{{$gdRow->mrVoucherStatus}}</td>
            <td class="text-center">{{$gdRow->mjVoucherNo}}</td>
            <td class="text-center">{{$gdRow->mjVoucherDate ? date('Y-m-d', strtotime($gdRow->mjVoucherDate)) : ''}}</td>
            <td>{{CommonHelper::get_supplier_name($gdRow->supplier_id)}}</td>
            <td>{{$gdRow->mjJobType}}</td>
            <td>{{$gdRow->mjVoucherStatus}}</td>
            <td class="text-center">{{$gdRow->miVoucherNo}}</td>
            <td class="text-center">{{$gdRow->miVoucherDate ? date('Y-m-d', strtotime($gdRow->miVoucherDate)) : ''}}</td>
            <td>{{$gdRow->miVoucherStatus}}</td>
            <?php 
                $maintenance_invoice_data=DB::connection('mysql2')->table('maintenance_invoice_datas')->where('maintenance_invoice_id',$gdRow->mi_id)->get();
            ?>
            <td >
                @foreach($maintenance_invoice_data as $val)
                <div style="border-bottom:1px solid black;white-space:nowrap;">
                <?php echo CommonHelper::get_item_name($val->item_id); ?></br>
              
                </div>
                @endforeach
            </td>
            <td >
                @foreach($maintenance_invoice_data as $val)
                <div style="border-bottom:1px solid black;">
               
                <?php echo $val->qty; ?></br>
               
                </div>
                @endforeach
            </td>
            <td >
                @foreach($maintenance_invoice_data as $val)
                <div style="border-bottom:1px solid black;">
               
                <?php echo $val->return_qty ?? 0; ?></br>
               
                </div>
                @endforeach
            </td>
            <td >
                @foreach($maintenance_invoice_data as $val)
                <div style="border-bottom:1px solid black;">
               
                <?php echo $val->rate; ?></br>
                </div>
                @endforeach
            </td>
            <td>{{$gdRow->labour_hour}}</td>
            <td>{{$gdRow->labour_wage}}</td>
            <td>{{$gdRow->gpoGatePassNo}}</td>
            <td>{{$gdRow->gpoGatePassDate ? date('Y-m-d', strtotime($gdRow->gpoGatePassDate)) : ''}}</td>
            <td>{{$gdRow->gpoVoucherStatus}}</td>
            <td>{{$gdRow->gpiGatePassNo}}</td>
            <td>{{$gdRow->gpiGatePassDate ? date('Y-m-d', strtotime($gdRow->gpiGatePassDate)) : ''}}</td>
            <td>{{$gdRow->gpiVoucherStatus}}</td>
            <td class="text-center">{{$gdRow->wgVoucherNo}}</td>
            <td class="text-center">{{$gdRow->wgVoucherDate ? date('Y-m-d', strtotime($gdRow->wgVoucherDate)) : ''}}</td>
            <td class="text-center">{{DB::connection('mysql2')->table('workshop_grn_datas')->where('status',1)->where('workshop_grn_id',$gdRow->grn_id)->sum('repair_cost') }}</td>
            
            <td>{{$gdRow->wgVoucherStatus}}</td>
            <td>{{$gdRow->wmiVoucherNo}}</td>
            <td>{{$gdRow->wmiVoucherDate ? date('Y-m-d', strtotime($gdRow->wmiVoucherDate)) : ''}}</td>
            {{-- <td>{{$gdRow->wmiVoucherStatus}}</td> --}}
        </tr>
<?php
    }
?>