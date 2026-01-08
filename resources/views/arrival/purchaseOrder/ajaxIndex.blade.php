<?php 
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
$m = session('run_company');
$view=ReuseableCode::check_rights(563);
$approve=ReuseableCode::check_rights(563);
$audapprove=ReuseableCode::check_rights(563);
$delete=ReuseableCode::check_rights(563);
$edit=ReuseableCode::check_rights(579);

?>
@foreach ($purchaseOrders as $key => $purchaseOrder)
    <tr class="text-center">
        <td>{{++$key}}</td>
        <td>{{$purchaseOrder['voucher_no']}}</td>
        <td>{{date('Y-m-d', strtotime($purchaseOrder['voucher_date']))}}</td>
        <td>{{$purchaseOrder['category']['name']}}</td>
        <td>{{$purchaseOrder['sub_category']['name']}}</td>
        <td>{{$purchaseOrder['product']['name']}}</td>
        <td>{{$purchaseOrder['product']['sku_code']}}</td>
        <td>
            {{-- @if ($view) --}}
            <button
                onclick="showDetailModelOneParamerter('arrival/ViewPurchaseOrder',{{ $purchaseOrder->id }},'View Purchase Ordere Details')"
                type="button" class="btn btn-success btn-xs">View</button>
            {{-- @endif --}}
            {{-- @if ($edit == true) --}}
            {{-- @endif --}}
            {{-- @if ($delete == true) --}}
            @if ($purchaseOrder['status'] == 1)
               @if ($edit == true)
                    <a class="edit-modal btn btn-xs btn-info"
                        href="{{ url('arrival/purchase_order/' . $purchaseOrder->id . '/edit?pageType=&&parentCode=232&&m='.session('run_company').'#Garibsons') }}">Edit</a>
                @endif
                <button class="delete-modal btn btn-xs btn-danger"
                    onClick="delete_po({{ $purchaseOrder['id'] }})">Delete</button>
            @endif
            {{-- @endif --}}
        </td>
    </tr>
@endforeach