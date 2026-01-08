
@php
use App\Helpers\ReuseableCode;


    $m = $_GET['m'];
    $edit=ReuseableCode::check_rights(291);
    $delete=ReuseableCode::check_rights(292);
@endphp
@foreach ($subitems as $key => $row)
<tr title="{{$row->id}}">
    <td class="text-center">{{++$key}}</td>
    <td>{{$row->category->main_ic}}</td>
    {{-- <td>{{$row->item_code}}</td> --}}
    <td>{{$row->sub_ic}}</td>
    <td>{{$row->demand_type->name??''}}</td>
    <td>{{$row->sku_code}}</td>
    <td>{{$row->pack_size}}</td>
    <td>@if ($row->sku_code) {!! DNS1D::getBarcodeSVG($row->sku_code, 'C128',1,40,'black', true) !!} @else SKU Not Given @endif <br><p style="font-size: 8px;">{{ $row->sub_ic }}</p></td>
    <td>{{$row->username}}</td>
    <td class="text-center">
        @if($edit == true)
            <a class="edit-modal btn btn-xs btn-info" href="{{url('purchase/editSubItemForm?id='.$row->id)}}">Edit</a>
        @endif
        @if($delete == true)
            <button class="delete-modal btn btn-xs btn-danger" onclick="deleteCompanyMasterTableRecord('purchase/deleteSubItemRecord','{{ $row->id }}','subitem','{{Session::get('run_company')}}','acc_id')">Delete</button>
            @endif
        <a class="btn btn-xs btn-warning" target="blank" href="{{url('/store/printbarcode?id='.$row->id)}}">Print BarCode</a>
    </td>
    <td class="hide">
        <select name="item[]"><option @if($row['finish_good']==1): selected @endif value="1,{{$row->id}}">Yes</option>
            <option @if($row['finish_good']==0): selected @endif  value="0,{{$row->id}}">No</option></select>
    </td>
</tr>
@endforeach