@php
use App\Helpers\CommonHelper;
$rowkey = 1;   
@endphp
@foreach($IssuanceReturn->issuence_return_datas as $row) 
<tr id="AppnedHtml{{$rowkey}}">
   <td>
       <select name="item_id[]" id="item_id{{$rowkey}}" onchange="itemChange({{$rowkey}})"
           class="form-control requiredField select2">
           <option value="">Select Item</option>
         
           <option selected value="{{$row->sub_item_id }}">{{CommonHelper::get_item_name($row->sub_item_id)}}</option>
       </select>
   </td>
   <td>
       <input type="text" class="form-control"  readonly name="uom[]" id="uom{{$rowkey}}">
   </td>
   <td>
       <select name="warehouse_id[]" id="warehouse_id{{$rowkey}}"
           class="form-control requiredField select2">
           @foreach (CommonHelper::get_users_warehouse() as $line)
               <option value="{{ $line->id }}" @if($row->warehouse_id == $line->id) selected @endif>{{ $line->name }}
               </option>
           @endforeach
       </select>
   </td>
   <td>
       <select name="quality_type[]" id="quality_type{{$rowkey}}"
           class="form-control requiredField select2">
           <option value="">Select Type</option>
           @foreach (CommonHelper::qualityType() as $type)
               <option value="{{ $type['id'] }}" @if($row->quality_type == $type["id"]) selected @endif>{{ $type['name'] }}
               </option>
           @endforeach
       </select>
   </td>
   <td>
       <input type="number" class="form-control requiredField" min="0" step="any" name="return_qty[]" id="qty{{$rowkey}}" value="{{$row->return_qty}}">
   </td>
   <td>
       <textarea class="form-control" name="item_remarks[]" id="item_remarks{{$rowkey}}" cols="5" rows="5" >{{$row->sub_item_remark}}</textarea>
   </td>
   <td> 
       @if($rowkey>1)
       <button class="btn btn-danger btn-xs" onClick="rowRemove({{$rowkey}})">remove</button>
   @endif
   </td>
</tr>
   @php
   $rowkey++;
   @endphp
@endforeach