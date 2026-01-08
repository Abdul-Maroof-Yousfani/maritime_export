<?php
$m = Session::get('run_company');
use App\Helpers\StoreHelper;
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
?>
@extends('layouts.default')

@section('content')
    @include('select2')
    @include('modal')
    @include('number_formate')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well_N">
                    <div class="dp_sdw">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span class="subHeadingLabelClass">Edit Material Issuance Form</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                {{ Form::open(['url' => 'workshop/updateMaterialIssuanceDetail?m=' . $m . '', 'id' => 'cashPaymentVoucherForm', 'class' => 'stop']) }}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label class="sf-label">Select Maintenance Job</label>
                                        <input type="hidden" class="form-control" name="materialIssuanceId" value="{{$materialIssuance->id}}">
                                        <input type="hidden" class="form-control" name="maintenance_job_id" value="{{$materialIssuance->maintenanceJob->id}}">
                                        <input type="text" readonly class="form-control" name="maintenance_job_voucher_no" value="{{$materialIssuance->maintenanceJob->voucher_no}}">
                                        {{-- <span class="rflabelsteric"><strong>*</strong></span>
                                        <select class="form-control requiredField select2" name="maintenance_job_id"
                                            id="maintenance_job_id" onchange="createMaterialFormAjax()">
                                            <option value="">Select Maintenance Job</option>
                                            @foreach ($maintenanceJobs as $maintenanceJob)
                                                <option value="{{ $maintenanceJob->id }}">{{ $maintenanceJob->voucher_no }}
                                                </option>
                                            @endforeach
                                        </select> --}}
                                    </div>
                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <button type="button" onclick="createMaterialFormAjax()"
                                            style="margin-top: 35px;">GET</button>
                                    </div> --}}
                                    <div id="createMaterialFormAjax">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                    <label for="">Voucher No</label>
                                                    <input type="text" readonly class="form-control requiredField"
                                                        name="voucher_no" value="{{ $materialIssuance->voucher_no }}">
                                                    {{-- value="{{ CommonHelper::getWMIVoucherNumber() }}"> --}}
                                                </div>

                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                    <label for="">Voucher Date</label>
                                                    <input type="date" class="form-control" id="Voucher_date"
                                                        name="Voucher_date" value="{{ $materialIssuance->voucher_date }}">
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <label for="">Remarks</label>
                                                    <textarea class="form-control" rows="5" id="remarks" name="remarks">{{$materialIssuance->description}}</textarea>
                                                </div>
                                            </div>
                                            <div class="lineHeight">&nbsp;</div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div style="text-align: center" class="table-responsive  text-center"
                                                        id="">
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr class="">
                                                                    <th class="text-center">SR No</th>
                                                                    <th class="text-center">Item</th>
                                                                    <th class="text-center">UOM</th>
                                                                    <th class="text-center">Department</th>
                                                                    <th class="text-center">QTy</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($materialIssuance->itemData as $key => $row)
                                                                    @php
                                                                        $item_name = $row->subItem->sub_ic;
                                                                    @endphp
                                                                    <tr class="text-center">
                                                                        <td>{{ ++$key }}</td>
                                                                        <td>{{ $item_name }}</td>
                                                                        <input type="hidden" name="item_id[]"
                                                                            value="{{ $row->item_id . ',0,' . $row->id }}" />
                                                                        <input type="hidden" name="grn_data_id[]"
                                                                            value="{{ $row->id }}" />
                                                                        <td>{{ $row->subItem->uomData->uom_name }}</td>
                                                                        <td><select
                                                                                class="form-control requiredField select2"
                                                                                name="department_id[]" id="department_id">
                                                                                <option value="">Select Department
                                                                                </option>
                                                                                @foreach ($departments as $key => $y)
                                                                                    <optgroup
                                                                                        label="{{ $y->department_name }}"
                                                                                        value="{{ $y->id }}">
                                                                                        @foreach (DB::select('select `id`,`sub_department_name` from `sub_department` where `department_id` =' . $y->id . '') as $key2 => $y2)
                                                                                            <option
                                                                                                value="{{ $y2->id }}"  {{ ($y2->id == $row->department_id)? 'selected' : '' }}>
                                                                                                {{ $y2->sub_department_name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </optgroup>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td><input type="text"
                                                                                value="{{ $row->qty }}"
                                                                                name="item_qty[]" readonly
                                                                                class="form-control">
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="demandsSection"></div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                                    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}

                                                </div>
                                            </div>
                                        </div>

                                        <script type="text/javascript"></script>
                                    </div>
                                </div>
                                <?php echo Form::close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $('.select2').select2();
        $(document).ready(function() {
            $('select').select2();

            $(".btn-success").click(function(e) {

                //alert();
                var purchaseRequest = new Array();
                var val;
                //$("input[name='demandsSection[]']").each(function(){
                purchaseRequest.push($(this).val());
                //});
                var _token = $("input[name='_token']").val();
                for (val of purchaseRequest) {
                    jqueryValidationCustom();
                    if (validate == 0) {
                        //alert(response);
                    } else {
                        return false;
                    }
                }

            });
        });
    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
