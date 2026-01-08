<?php

use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
use App\Helpers\StoreHelper;
$m = Session::get('run_company');
$export = ReuseableCode::check_rights(315);
$current_date = date('Y-m-d');
$from = date('Y-m-01');
$to = date('Y-m-t');

?>
@extends('layouts.default')

@section('content')

@include('select2')
    <div class="well_N">
        <div class="dp_sdw">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                            {{ CommonHelper::displayPrintButtonInBlade('printIssuanceVoucherList', '', '1') }}
                            @if ($export == true)
                                {{ CommonHelper::displayExportButton('issuanceVoucherList', '', '1') }}
                            @endif
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="well">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <span class="subHeadingLabelClass">Issuance List</span>
                                    </div>
                                </div>

                                <div class="lineHeight">&nbsp;</div>

                                <div id="printDemandVoucherList">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="panel">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="row">
                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                    <label>From Date</label>
                                                                    <input type="Date" name="FromDate" id="FromDate"
                                                                        max="<?php echo $current_date; ?>"
                                                                        value="<?php echo $from; ?>" class="form-control" />
                                                                </div>

                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                    <label>To Date</label>
                                                                    <input type="Date" name="ToDate" id="ToDate"
                                                                        max="<?php echo $current_date; ?>"
                                                                        value="<?php echo $to ?>" class="form-control" />
                                                                </div>
                                                            
                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                    <label class="sf-label">Select Item</label>
                                                                    <select class="form-control requiredField select2 item_id"
                                                                        name="item_id" id="item_id">
                                                                        <option value="0">Select item</option>
                                                                        {{-- @foreach (App\Models\Machinery::where('status',1)->get() as $key => $machine)
                                                                            <option value="{{ $machine->id }}">
                                                                                {{ $machine->name }}
                                                                            </option>
                                                                        @endforeach --}}
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                    <label class="sf-label">Machine</label>
                                                                    <select class="form-control requiredField select2"
                                                                        name="machine" id="machine">
                                                                        <option value="0">Select Machine</option>
                                                                        @foreach (App\Models\Machinery::where('status',1)->get() as $key => $machine)
                                                                            <option value="{{ $machine->id }}">
                                                                                {{ $machine->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                    <label class="sf-label">Line</label>
                                                                        <select class="form-control requiredField select2"
                                                                        name="line" id="line">
                                                                        <option value="0">Select Line</option>
                                                                        @foreach (App\Models\Line::where('status',1)->get() as $key => $line)
                                                                            <option value="{{ $line->id }}">
                                                                                {{ $line->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                    <label class="sf-label">Issuance Status</label>
                                                                    <select class="form-control requiredField select2" id="issuance_status">
                                                                        <option value="0">ALL</option>
                                                                        <option value="1">Pending</option>
                                                                        <option value="2">Approved</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                    <label class="sf-label">voucher_no</label>
                                                                        <input type="text" class="form-control" name="voucher_no" id="voucher_no">
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                    <label class="sf-label">Receipt Serial NO </label>
                                                                        <input type="text" class="form-control" name="receipt_serial_no" id="receipt_serial_no">
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                    <label class="sf-label">Company Location</label>
                                                                    <select class="form-control requiredField select2" name="company_location_id"
                                                                        id="company_location_id">
                                                                        {{-- <option value="">Select Location</option> --}}
                                                                        @foreach (ReuseableCode::getUserWiseLocationRightsData() as $company_location)
                                                                            <option {{session('run_company') == 8 && $company_location['id'] == 3 ? 'selected' : ''}} value="{{$company_location['id']}}">{{$company_location['location_name']}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <label class="sf-label">Department</label>
                                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                                    <select class="form-control requiredField select2"
                                                                        name="department" id="department">
                                                                        <option value="">Select Department</option>
                                                                        @foreach ($departments as $key => $y)
                                                                            <optgroup label="{{ $y->department_name }}"
                                                                                value="{{ $y->id }}">
                                                                                <?php
                                                                                $subdepartments = DB::select('select `id`,`sub_department_name` from `sub_department` where `department_id` =' . $y->id . '');
                                                                                ?>
                                                                                @foreach ($subdepartments as $key2 => $y2)
                                                                                    <option value="{{ $y2->id }}">
                                                                                        {{ $y2->sub_department_name }}</option>
                                                                                @endforeach
                                                                            </optgroup>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <input type="button" value="Submit"
                                                                        class="btn btn-sm btn-primary"
                                                                        onclick="getWordOrderData();"
                                                                        style="margin-top: 32px;" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="lineHeight">&nbsp;</div>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="data">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered sf-table-list"
                                                                    id="issuanceVoucherList">
                                                                    <thead>
                                                                        <th class="text-center">S.No</th>
                                                                        <th class="text-center">Material Request No</th>
                                                                        <th class="text-center">Voucher No</th>
                                                                        <th class="text-center">Voucher Date</th>
                                                                        <th class="text-center">Receipt Serial NO</th>
                                                                        <th class="text-center">Department</th>
                                                                        <th class="text-center">Machine</th>
                                                                        <th class="text-center">Line</th>
                                                                        <th class="text-center">Remarks</th>
                                                                        <th class="text-center">Action</th>
                                                                    </thead>
                                                                    <tbody id="ShowHide">

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right hidden qrCodeDiv">
                                            <img src="data:image/png;base64, {!! base64_encode(
                                                QrCode::format('png')->size(200)->generate('View Purchase Demand Voucher List'),
                                            ) !!} ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('select').select2();
            getAjaxItemList('.item_id')
            getWordOrderData();

        });

        function getWordOrderData() {
            $('#ShowHide').html('<tr><td class="loader" colspan="7"></td></tr>');
            var FromDate = $('#FromDate').val();
            var ToDate = $('#ToDate').val();
            var department = $('#department').val();
            var item_id = $('#item_id').val();
            var machine = $('#machine').val();
            var line = $('#line').val();
            var company_location_id = $('#company_location_id').val();
            var voucher_no = $('#voucher_no').val();
            var receipt_serial_no = $('#receipt_serial_no').val();
            var issuance_status = $('#issuance_status').val();
            $.ajax({
                url: "{{ url('/pdc/issuanceDataFilter') }}",
                data: {
                    FromDate: FromDate,
                    ToDate: ToDate,
                    department:department,
                    item_id:item_id,
                    issuance_status:issuance_status,
                    machine:machine,
                    line:line,
                    company_location_id:company_location_id,
                    voucher_no:voucher_no,
                    receipt_serial_no:receipt_serial_no,
                },
                success: function(response) {
                    $('#ShowHide').html(response);
                }
            });
        }

        function delete_issue(voucher_no) {
            if (confirm('Are You Sure ? You want to delete this record...!')) {
                $.ajax({
                    url: '{{url("/stdc/delete_issue")}}',
                    type: 'Get',
                    data: {
                        voucher_no: voucher_no
                    },

                    success: function(response) {
                        if (response == 0) {
                            alert('Can not delete');
                            return false;
                        }
                        $('#RemoveTr' + response).remove();
                    }
                });
            } else {}
        }
    </script>
@endsection
