@foreach ($purchaseOrders as $key => $purchaseOrder)
    <tr class="text-center">
        <td>{{++$key}}</td>
        <td>{{$purchaseOrder['voucher_no']}}</td>
        <td>{{$purchaseOrder['voucher_date']}}</td>
        <td>{{$purchaseOrder['category']['name']}}</td>
        <td>{{$purchaseOrder['product']['name']}}</td>
        <td>{{$purchaseOrder['product']['sku_code']}}</td>
        <td>{{$purchaseOrder['cropBased']['name']}}</td>
        {{-- <td>{{$purchaseOrder['name']}}</td> --}}
        {{-- <td>{{$slab->remark}}</td> --}}
    </tr>
@endforeach