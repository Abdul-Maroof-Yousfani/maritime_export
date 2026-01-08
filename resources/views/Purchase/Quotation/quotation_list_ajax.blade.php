<?php use App\Helpers\CommonHelper;

use App\Helpers\QuotationHelper;
use App\Helpers\ReuseableCode;

$view = ReuseableCode::check_rights(396);
$edit = ReuseableCode::check_rights(397);
$delete = ReuseableCode::check_rights(398);
$summary = ReuseableCode::check_rights(399);

?>



<?php
$count = 1;
$pr_no = [];
?>
@foreach ($data as $row)
    @php
        $status = 'Pending';
        if ($row->checked_username){
            $status = 'Checked';
        }
        if($row->audited_username){
            $status = 'Audited';
        }
        if ($row->approved_username){
            $status = 'Approved';
        }
        // $pr_ids = json_encode(QuotationHelper::getPrAndPrDataIds($row->id, 'demand_id'));
        // $pr_data_ids = json_encode(QuotationHelper::getPrAndPrDataIds($row->id, 'demand_data_id'));
        // dd($pr_ids,$pr_data_ids)
    @endphp
    @if (!in_array($row->group_number, $pr_no))
        @php $pr_no[] = $row->group_number; @endphp
        <tr class="text-center">
            <td colspan="10" style="font-weight: bold">
                {{ 'Comparative NO#: '.$row->group_number }}
            </td>
            {{-- @php $status =  1 @endphp --}}
        </tr>
    @endif

    <tr class="text-center">
        <td>
            @if ($row->group_number == null)
                <input type="checkbox" id="" name="generateComparative[]" value="{{ $row->voucher_no }}">
            @endif
            {{ $count++ }}
        </td>
        <td>{{ strtoupper($row->voucher_no) }}</td>
        <td>{{ CommonHelper::changeDateFormat($row->voucher_date) }}</td>
        <td>{{ CommonHelper::get_supplier_name($row->vendor_id) }}</td>
        <td>{{ $row->ref_no }}</td>
        <td>{{ number_format($row->net_amount, 3) }}</td>
        <td>{{$status}}</td>

        <td>
            @if ($view == true)
                <button
                    onclick="showDetailModelOneParamerter('quotation/view_quotation?m=<?php echo Session::get('run_company'); ?>','<?php echo $row->id; ?>','Quotation')"
                    type="button" class="btn btn-success">View</button>
            @endif
            @if ($edit == true)
                <a href="{{ url('quotation/edit_quotation/'. $row->id) }}"
                    class="btn btn-success">Edit</a>
            @endif
            @if ($delete == true)
                <button onclick="delete_quotation('{{ $row->id }}')" type="button"
                    class="btn btn-danger">Delete</button>
            @endif
            @if ($summary == true && $row->group_number != null)
                <button
                    onclick="showDetailModelOneParamerter('quotation/qutation_summary?m=<?php echo Session::get('run_company') . '&quotation_id=' . $row->id.'&groupno='.$row->group_number; ?>',{{$row->group_number}},'Quotation')"
                    type="button" class="btn btn-success">Summary</button>
            @endif
        </td>
    </tr>
@endforeach
<script>
    function getCheckedInputForGenerateNumber() {
        var values = [];
        $("input[type=checkbox]:checked").each(function() {
            values.push($(this).val());
        });
        if (values.length == 0) {
            alert('Select quotation first for group')
        }
        $.ajax({
            url: '{{ url('/quotation/generateGroupNumber') }}',
            type: "GET",
            data: {
                id: values
            },
            success: function(data) {
                get_data();
            }
        });
    }
</script>
@if (Session::has('openSummarModal'))
    <script>
        $(function() {
            showDetailModelOneParamerter(
                'quotation/qutation_summary?m=1&quotation_id={{ Session::get("openSummarModal")[0] }}&groupno={{ Session::get("openSummarModal")[1] }}',
                '{{ Session::get("openSummarModal")[1] }}', 'Quotation')
        })
    </script>
@endif
