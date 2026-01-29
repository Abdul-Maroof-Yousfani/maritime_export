<div class="modal-header">
    <h4 class="modal-title">View Packing List</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th style="width:30%;border:1px solid;padding:8px;">Invoice No</th>
                    <td style="width:70%;border:1px solid;padding:8px;">{{ $packingList->invoice_no ?? '-' }}</td>
                </tr>
                <tr>
                    <th style="border:1px solid;padding:8px;">Date</th>
                    <td style="border:1px solid;padding:8px;">
                        @if(!empty($packingList->date))
                            @php
                                $date = new DateTime($packingList->date);
                                echo $date->format('d-m-Y');
                            @endphp
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th style="border:1px solid;padding:8px;">GD NO</th>
                    <td style="border:1px solid;padding:8px;">{{ $packingList->gd_no ?? '-' }}</td>
                </tr>
                <tr>
                    <th style="border:1px solid;padding:8px;">Container #</th>
                    <td style="border:1px solid;padding:8px;">{{ $packingList->container_no ?? '-' }}</td>
                </tr>
                <tr>
                    <th style="border:1px solid;padding:8px;">Consignee Name</th>
                    <td style="border:1px solid;padding:8px;">{{ $packingList->consignee_name ?? '-' }}</td>
                </tr>
                <tr>
                    <th style="border:1px solid;padding:8px;">Vessel/Voyage</th>
                    <td style="border:1px solid;padding:8px;">{{ $packingList->vessel_voyage ?? '-' }}</td>
                </tr>
                <tr>
                    <th style="border:1px solid;padding:8px;">From</th>
                    <td style="border:1px solid;padding:8px;">{{ $packingList->port_from ?? '-' }}</td>
                </tr>
                <tr>
                    <th style="border:1px solid;padding:8px;">Payment Term</th>
                    <td style="border:1px solid;padding:8px;">{{ $packingList->payment_term ?? '-' }}</td>
                </tr>
                <tr>
                    <th style="border:1px solid;padding:8px;">Gross Weight (KGS)</th>
                    <td style="border:1px solid;padding:8px;">{{ number_format($packingList->gross_weight ?? 0, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <h4 style="text-align: center; margin-top: 20px; margin-bottom: 15px;"><u><b>PRODUCT DETAILS</b></u></h4>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="border:1px solid;padding:8px;">S.No</th>
                    <th style="border:1px solid;padding:8px;">Descriptions of Product</th>
                    <th style="border:1px solid;padding:8px;">Grade / Size</th>
                    <th style="border:1px solid;padding:8px;">Total Cartons</th>
                    <th style="border:1px solid;padding:8px;">Total Net Kgs</th>
                    <th style="border:1px solid;padding:8px;">Total Gross Kgs</th>
                    <th style="border:1px solid;padding:8px;">Container No</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                    $totalCartons = 0;
                    $totalNetKgs = 0;
                    $totalGrossKgs = 0;
                @endphp
                @foreach($packingList->packingListData as $item)
                    @php
                        $itemContainers = $containersByItem[$item->item_id] ?? [];
                        $containerNos = [];
                        foreach($itemContainers as $container) {
                            if($container->container_no) {
                                $containerNos[] = $container->container_no;
                            }
                        }
                        $containerNoDisplay = count($containerNos) > 0 ? implode(', ', $containerNos) : '-';
                    @endphp
                    <tr>
                        <td style="border:1px solid;padding:8px;">{{ $counter }}</td>
                        <td style="border:1px solid;padding:8px;text-align:left;">{{ $item->description ?? '-' }}</td>
                        <td style="border:1px solid;padding:8px;">{{ $item->grade_size ?? '-' }}</td>
                        <td style="border:1px solid;padding:8px;">{{ $item->total_cartons ?? 0 }}</td>
                        <td style="border:1px solid;padding:8px;">{{ number_format($item->total_net_kgs ?? 0, 2) }}</td>
                        <td style="border:1px solid;padding:8px;">{{ number_format($item->total_gross_kgs ?? 0, 2) }}</td>
                        <td style="border:1px solid;padding:8px;">{{ $containerNoDisplay }}</td>
                    </tr>
                    @php
                        $counter++;
                        $totalCartons += $item->total_cartons ?? 0;
                        $totalNetKgs += $item->total_net_kgs ?? 0;
                        $totalGrossKgs += $item->total_gross_kgs ?? 0;
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="border:1px solid;padding:8px;text-align:right;font-weight:bold;">Grand Total:-</td>
                    <td style="border:1px solid;padding:8px;text-align:center;font-weight:bold;">{{ $totalCartons }}</td>
                    <td style="border:1px solid;padding:8px;text-align:right;font-weight:bold;">{{ number_format($totalNetKgs, 2) }}</td>
                    <td style="border:1px solid;padding:8px;text-align:right;font-weight:bold;">{{ number_format($totalGrossKgs, 2) }}</td>
                    <td style="border:1px solid;padding:8px;"></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label><strong>Total Gross Weight (KGS):</strong></label>
            <p>{{ $packingList->gross_weight ? number_format($packingList->gross_weight, 2) : '-' }}</p>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
