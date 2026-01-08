<table style="" class="table table-bordered well">
    <thead>
        
        <tr>
            <th style="width: 30%;">Products</th>
            <th style="width: 10%;">UOM</th>
            <th style="width: 10%;">QTY</th>
            {{-- <th style="width: 10%;" class="amountHide">Maintenance Amount</th>
            <th style="width: 40%;" class="amountHide">Maintenance Description</th> --}}
        </tr>
    </thead>
    <tbody id="AppnedHtml">
        @foreach ($maintenanceRequest->itemData as $key => $itemData)
            <tr>
                <td>
                    <input type="text" class="form-control" readonly name="item_name[]"
                        id="item_name{{ $key }}" value="{{ $itemData->subItem->sub_ic }}">
                    <input type="hidden" class="form-control" readonly name="item_id[]" id="item_id{{ $key }}"
                        value="{{ $itemData->item_id }}">
                </td>
                <td>
                    <input type="text" class="form-control" readonly name="uom[]"
                        value="{{ $itemData->subItem->uomData->uom_name }}" id="uom{{ $key }}">
                </td>
                <td>
                    <input type="number" class="form-control requiredField " readonly min="0" value="{{ $itemData->qty }}"
                        step="any" placeholder="QTY" name="qty[]" id="qty{{ $key }}">
                </td>
                {{-- <td class="amountHide">
                    <input type="number" class="form-control requiredField"  min="0" value="{{ 0 }}"
                        step="any" placeholder="Amount" name="total[]" id="total{{ $key }}">
                </td>
                <td class="amountHide">
                    <textarea name="item_description[]" id="item_description" rows="5" class="form-control"></textarea>
                </td> --}}
            </tr>
        @endforeach
    </tbody>
</table>
