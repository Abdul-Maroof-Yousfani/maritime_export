@foreach ($slabs as $key => $slab)
    <tr>
        <td>{{++$key}}</td>
        <td>{{$slab['slab_type']['name']}}</td>
        <td>{{$slab['product']['name']??'-'}}</td>
        <td>{{$slab['from']}}</td>
        <td>{{$slab['to']}}</td>
        <td>{{$slab['amount']}}</td>
        <td>{{$slab['remark']}}</td>
        {{-- <td>{{$slab->remark}}</td> --}}
        <td>
        <a class="btn btn-xs btn-info" href="{{ route('slab.edit',$slab['id']) }}">Edit</a>  
                                                                           
                                                                           
                                                                           <button class="delete-modal btn btn-xs btn-danger"
                                                                           onClick="delete_ar({{ $slab['id'] }})">Delete</button>   </td>
</td>
    </tr>
@endforeach