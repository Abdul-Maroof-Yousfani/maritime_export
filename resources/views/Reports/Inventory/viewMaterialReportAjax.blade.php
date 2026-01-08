@php
    use App\Helpers\CommonHelper;
@endphp

@foreach ($data as $key => $row) 
    
    <tr>
        <td> {{ ++$key }}</td>
        <td> {{ $row->iss_no }}</td>
        <td> {{ date_format(new DateTime($row->iss_date),"d-M-Y") }}</td>
        <td> {{ $row->sku_code }}</td>
        <td> {{ $row->sub_ic }}</td>
        <td> {{ $row->warehouse_name }}</td>
        <td> {{ CommonHelper::get_sub_dept_name($row->department_id) }}</td>
        <td> {{ $row->machinery_name }}</td>
        <td> {{ $row->line_name }}</td>
        <td> {{ $row->qty }}</td>
        <td> {{ CommonHelper::getLocationDetail($row->company_location_id)->location_name??'' }}</td>
      
       
    </tr>
@endforeach