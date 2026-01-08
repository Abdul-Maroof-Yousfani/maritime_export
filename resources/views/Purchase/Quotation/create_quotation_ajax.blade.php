
<?php use App\Helpers\CommonHelper; ?>

<?php $count=1; $p_type = ['','URGENT','NORMAL']; ?>
@foreach ($data->get() as $row)
<tr class="text-center">
    <td>{{ $count++ }}</td>
    <td>{{ strtoupper($row->demand_no) }}</td>
    <td>{{ CommonHelper::changeDateFormat($row->demand_date) }}</td>
    <td>{{ $row->slip_no }}</td>
    <td>{{ CommonHelper::get_sub_dept_name($row->sub_department_id) }}</td>
    <td>{{ $p_type[$row->p_type] }}</td>
    <td><a href="{{ url('quotation/quotation_form/'.$row->id) }}" type="button" class="btn btn-success">Create Quotation</a></td>
</tr>

@endforeach