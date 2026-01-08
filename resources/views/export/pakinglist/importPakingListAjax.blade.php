@php
use App\Helpers\ReuseableCode;

$view = ReuseableCode::check_rights(458);
$listing = ReuseableCode::check_rights(459);
$packingDetail = ReuseableCode::check_rights(460);
$counter=1;
@endphp

    @foreach($exportpakingList as $item)
    <tr id="{{$item->id}}">
    <td>{{$counter}}</td>   
    <td>{{$item->pro_contract_no}}</td> 
    <td>{{$item->commercial_invoice_no}}</td>
    <td>{{$item->import_no}}</td>   
    <td>{{$item->total_qty}}</td>  
    <td>{{$item->created_at}}</td>    
     
      
    <td class="text-center">  
      {{-- <button onclick="showDetailModelOneParamerter('export/viewPaking',{{$item->id}},'Paking List')" type="button" class="btn btn-success btn-xs">View</button>  
        <button onclick="showDetailModelOneParamerter('export/viewpakingListInvoice',{{$item->id}},'Paking List Invoice')" type="button" class="btn btn-success btn-xs"> Listing </button> 
        <button onclick="showDetailModelOneParamerter('export/packingListCertificate',{{$item->id}},'packingListCertificate List Invoice')" type="button" class="btn btn-success btn-xs"> packingListCertificate </button> 
        <button  onclick="showDetailModelOneParamerter('export/billOfLoading',{{$item->id}},' Invoice Details ')"
          type="button" class="btn btn-primary btn-xs ">Page 4</button>  --}}
      
          <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Action <span class="caret"></span>
            </button>
          <ul class="dropdown-menu">
            @if ($view)
            <li> <a onclick="showDetailModelOneParamerter('export/viewPaking',{{$item->id}},'Packing List')" type="button" >View</a> </li>
            @endif
            @if ($listing)
            <li> <a onclick="showDetailModelOneParamerter('export/viewpakingListInvoice',{{$item->id}},'Packing List')" type="button" > Listing </a>  </li>
            @endif
            {{-- @if ($listing) --}}
            <li> <a href="{{url('export/pakingListInvoiceEdit?id='.$item->id)}}"> Edit </a>  </li>
            {{-- <li> <a onclick="showDetailModelOneParamerter('',{{$item->id}},'Packing List')" type="button" > Edit </a>  </li> --}}
            {{-- @endif --}}
            @if ($packingDetail)
            <li> <a onclick="showDetailModelOneParamerter('export/billOfLoading',{{$item->id}},' Packing List Details ')" type="button" >Packing List Details</a>  </li>
            @endif
            {{-- <li><a onclick="showDetailModelOneParamerter('export/viewSaleExportVoucher',{{ $item->id}},@if($item->approved_status == 0)'View Export Order'@else 'Contract'  @endif)"> View @if($item->approved_status == 0)Export Order @else  Contract @endif</a></li> --}}
     
          </ul>
        </div>
        <table class="table table-bordered sf-table-list">
     
          <tr>
            <td class="text-left"><button onclick="showDetailModelOneParamerter('export/fumigationCertificate',{{$item->id}},'Fumigation Certificate')"
              type="button" class="btn btn-success btn-xs">Fumigtaion Certificate</button></td>
            <td> @if($item->fumigation_status == 0)
              <a href="{{route('createCertificate',['id'=>$item->id,'key'=>'Fumigation'])}}" class="btn btn-primary">Create</a> 
              @else
              <a href="{{route('editCertificate',['id'=>$item->id,'key'=>'Fumigation'])}}" class="btn btn-primary">Edit</a> 
             
              @endif</td>
          </tr>
          <tr>
            <td class="text-left"><button onclick="showDetailModelOneParamerter('export/originertificate',{{$item->id}},'Origin Certificate')"
              type="button" class="btn btn-success btn-xs">Origin Certificate</button></td>
            <td>  @if($item->origin_status == 0)<a href="{{route('createCertificate',['id'=>$item->id,'key'=>'origin'])}}" class="btn btn-primary">Create</a>
              
              @else
              <a href="{{route('editCertificate',['id'=>$item->id,'key'=>'origin'])}}" class="btn btn-primary">Edit</a> 
             
              @endif</td>
          </tr>
          <tr>
            <td class="text-left"><button onclick="showDetailModelOneParamerter('export/clearingCertificate',{{$item->id}},'Clearing Certificate')"
              type="button" class="btn btn-success btn-xs">Clearance Certificate</button></td>
            <td>@if($item->clearance_status == 0)<a href="{{route('createCertificate',['id'=>$item->id,'key'=>'clearance'])}}" class="btn btn-primary">Create</a>
              @else
              <a href="{{route('editCertificate',['id'=>$item->id,'key'=>'clearance'])}}" class="btn btn-primary">Edit</a> 
             
              @endif</td>
          </tr>
          <tr>
            <td class="text-left"><button onclick="showDetailModelOneParamerter('export/qualityDeclaration',{{$item->id}},'Quality Declaration Certificate')"
              type="button" class="btn btn-success btn-xs">Quality Declaration Certificate</button></td>
            <td>@if($item->quality_declear_status == 0)<a href="{{route('createCertificate',['id'=>$item->id,'key'=>'qualitydeclaration'])}}" class="btn btn-primary">Create</a>
              
              @else
              <a href="{{route('editCertificate',['id'=>$item->id,'key'=>'qualitydeclaration'])}}" class="btn btn-primary">Edit</a> 
             
              @endif</td>
          </tr>
          <tr>
            <td class="text-left"><button onclick="showDetailModelOneParamerter('export/qualityPacking',{{$item->id}},'Quality Packing Certificate')"
              type="button" class="btn btn-success btn-xs">Quality Packing Certificate</button></td>
            <td>  @if($item->quality_packing_status == 0)<a href="{{route('createCertificate',['id'=>$item->id,'key'=>'qualitypacking'])}}" class="btn btn-primary">Create</a> 
              @else
              <a href="{{route('editCertificate',['id'=>$item->id,'key'=>'qualitypacking'])}}" class="btn btn-primary">Edit</a> 
             
              @endif</td>
          </tr>
         
          {{-- <tr>
            <td class="text-left"><button class="btn btn-success btn-xs" onclick="showDetailModelOneParamerter('export/packingListCertificate',{{$item->id}},'Packing List Certificate')" type="button">Packing List Certificate </button> 
            </td>
            <td><button class="btn btn-primary">Create</button></td>
          </tr> --}}
        </table>
      
        </td>
    </tr>
    @php
    $counter++;
    @endphp
  
  @endforeach