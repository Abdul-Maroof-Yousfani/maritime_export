@foreach ($product->parameters ?? [] as $key => $param)
    <tr id="copy_row{{$param->id}}">
        <td class="text-center" data-moisture="{{$param->moisture}}">{{$param->moisture}}</td>
        <td class="text-center" data-damage="{{$param->damage}}">{{$param->damage}}</td>
        <td class="text-center" data-chalky="{{$param->chalky}}">{{$param->chalky}}</td>
        <td class="text-center" data-broken="{{$param->broken}}">{{$param->broken}}</td>
        <td class="text-center" data-o_v="{{$param->o_v}}">{{$param->o_v}}</td>
        <td class="text-center" data-chobba="{{$param->chobba}}">{{$param->chobba}}</td>
        <td class="text-center" data-look="{{$param->look}}">{{$param->look}}</td>
        <td><span class="btn btn-primary" onclick="copyRow({{$param->id}})" style="cursor: pointer">Copy</span></td>
    </tr>
@endforeach
<tr >
    
    <td><input type="text" name="moisture" id="moisture" class="form-control">
        <input hidden type="hidden" name="sub_variety_id" value="{{$product->id}}" class="form-control">
    </td>
    <td><input type="text" name="damage" id="damage"  class="form-control"></td>
    <td><input type="text" name="chalky" id="chalky" class="form-control"></td>
    <td><input type="text" name="broken" id="broken" class="form-control"></td>
    <td><input type="text" name="o_v" id="o_v" class="form-control"></td>
    <td><input type="text" name="chobba" id="chobba"  class="form-control"></td>
    <td><input type="text" name="look" id="look" class="form-control"></td>  
    <td></td>
</tr>