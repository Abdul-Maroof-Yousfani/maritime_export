@foreach ($products as $key => $product)
    <tr>
        <td class="text-center">{{++$key}}</td>
        <td class="text-center">{{$product['fg_parent']['name']}}</td>
        <td class="text-center">{{$product['name']}}</td>
        <td class="text-center">{{$product['sku_code']}}</td>
        <td class="text-center">
        <a class="edit-modal btn btn-xs btn-info"
            href="{{ url('commodities/ListFinisgGood/' . $product['id'] . '/edit?pageType=&&parentCode=215&&m='.session('run_company').'#Garibsons') }}">Edit</a>        
        <button class="delete-modal btn btn-xs btn-danger"
        onClick="delete_ar({{ $product['id'] }})">Delete</button>   
        </td> 
    </tr>
@endforeach