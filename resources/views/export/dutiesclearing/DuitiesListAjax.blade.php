@php
$counter=1;
@endphp

    @foreach($exportpakingList as $item)
    <tr id="{{$item->id}}">
    <td>{{$counter}}</td>    
    <td>{{$item->invoice_no}}</td>   
    <td>{{$item->mf_no}}</td>   

    <td>{{$item->created_at}}</td>    
     
      
    <td class="text-center">  
      {{-- <button onclick="showDetailModelOneParamerter('export/viewPaking',{{$item->id}},'Paking List')"
        type="button" class="btn btn-success btn-xs">View</button>  
    --}}
    <table class="table table-bordered sf-table-list">
     
      {{-- <tr>
        <td class="text-left"><button onclick="showDetailModelOneParamerter('export/fumigationCertificate',{{$item->id}},'Fumigation Certificat')"
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
        <td class="text-left"><button onclick="showDetailModelOneParamerter('export/qualityDeclaration',{{$item->id}},'qualityDeclaration Certificate')"
          type="button" class="btn btn-success btn-xs">Quality Declaration Certificate</button></td>
        <td>@if($item->quality_declear_status == 0)<a href="{{route('createCertificate',['id'=>$item->id,'key'=>'qualitydeclaration'])}}" class="btn btn-primary">Create</a>
          
          @else
          <a href="{{route('editCertificate',['id'=>$item->id,'key'=>'qualitydeclaration'])}}" class="btn btn-primary">Edit</a> 
         
          @endif</td>
      </tr>
      <tr>
        <td class="text-left"><button onclick="showDetailModelOneParamerter('export/qualityPacking',{{$item->id}},'qualityPacking Certificate')"
          type="button" class="btn btn-success btn-xs">QualityPacking Certificate</button></td>
        <td>  @if($item->quality_packing_status == 0)<a href="{{route('createCertificate',['id'=>$item->id,'key'=>'qualitypacking'])}}" class="btn btn-primary">Create</a> 
          @else
          <a href="{{route('editCertificate',['id'=>$item->id,'key'=>'qualitypacking'])}}" class="btn btn-primary">Edit</a> 
         
          @endif</td>
      </tr> --}}
     
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