@foreach ($products as $key => $product)
    <tr>
        <td>{{++$key}}</td>
        <td>{{$product['category']['name']}}</td>
        <td>{{$product['name']}}</td>
        <td>{{$product['sku_code']}}</td>
        <td>
        <a class="edit-modal btn btn-xs btn-info"
            href="{{ url('commodities/product/' . $product['id'] . '/edit?pageType=&&parentCode=215&&m='.session('run_company').'#Garibsons') }}">Edit</a>        
        <button class="delete-modal btn btn-xs btn-danger"
        onClick="delete_ar({{ $product['id'] }})">Delete</button>   
        </td> 
    </tr>
@endforeach