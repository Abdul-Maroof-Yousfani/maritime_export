
@foreach($prcs  as $prc)
<tr>
    <td class="text-center">{{$prc->bank_name}}</td>
    <td class="text-center">{{$prc->date}}</td>
    <td class="text-center">{{$prc->amount}}</td>
    <td class="text-center">{{$prc->fwd_no}}</td>
    <td class="text-center">{{$prc->rate}}</td>
    <td class="text-center">{{$prc->start_date}}</td>
    <td class="text-center">{{$prc->maturity}}</td>
    <td class="text-center">{{$prc->balance}}</td>
    <td class="text-center">{{$prc->fixed_date}}</td>
    <td class="text-center">{{$prc->option_date}}</td>
    <td class="text-center"><a href="{{route('prcReconciliation',$prc->prc_id)}}" class="btn btn-primary">Create PRC Consillation</a></td>
    

</tr>
@endforeach