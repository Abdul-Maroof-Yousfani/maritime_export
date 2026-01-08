@foreach ($tempGrns as $key => $tempGrn)
    <tr>
        <td>{{++$key}}</td>
        <td>{{$tempGrn->system_code}}</td>
        <td>{{$tempGrn->dc_no}}</td>
        <td>{{$tempGrn->dc_date}}</td>
        {{-- <td></td> --}}
    </tr>
@endforeach