@php 
use App\Helpers\CommonHelper;
$counter = 1;
$accType = Auth::user()->acc_type;
if($accType == 'client'){
    $m = $_GET['m'];
}else{
    $m = Auth::user()->company_id;
}
@endphp
@foreach ($stocks as $stock)
    <tr>
        <td>{{$counter++}}</td>
        <td>{{CommonHelper::get_item_name($stock->item_id)}}</td>
        <td>{{CommonHelper::getCompanyDatabaseTableValueById($m,'warehouse','name',$stock->warehouse_from)}}</td>
        <td>{{CommonHelper::getCompanyDatabaseTableValueById($m,'warehouse','name',$stock->warehouse_to)}}</td>
        <td>{{$stock->qty}}</td>
        <td>{{$stock->tr_status == 1 ? "Pending" : "Approve"}}</td>
    </tr>
@endforeach