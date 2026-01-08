<?php

$m = Session::get('run_company');
use App\Helpers\PurchaseHelper;
use App\Helpers\CommonHelper;
use App\Helpers\FinanceHelper;
use App\Helpers\ReuseableCode;
use App\Helpers\QuotationHelper;
?>
@extends('layouts.default')

@section('content')
    @include('select2')
    @include('modal')
    @include('number_formate')
    <style>
        * {
            font-size: 12px !important;
            font-family: Arial;
        }
        .select2 {
            width: 100%;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well_N">
                    <div class="dp_sdw">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span class="subHeadingLabelClass">Create Quotation Form</span>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                {{-- <label class="sf-label">PR NO. <span
                                        class="rflabelsteric"><strong>*</strong></span></label> --}}
                                <select name="company_location" class="form-control select2" required
                                    id="company_location" placeholder="Select Company Location" onchange="getPrNoList()">
                                    <option value="">Select any Location</option>
                                    @foreach (ReuseableCode::getUserWiseLocationRightsData() as $company_location)
                                        <option value="{{ $company_location->id }}"> {{ $company_location->location_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                {{-- <label class="sf-label">PR NO. <span
                                        class="rflabelsteric"><strong>*</strong></span></label> --}}
                                <select name="demandno[]" class="form-control select2" required
                                    multiple id="demandno" data-placeholder="Select PR NO">
                                    {{-- @foreach (QuotationHelper::approvedPRForQuotation() as $pr)
                                        <option value="{{ $pr->id }}"> {{ $pr->demand_no }}
                                        </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <button type="button" class="btn btn-primary btn-lg" onclick="getQuotationFormData()">Get Form</button>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="row">
                            <?php echo Form::open(['url' => url('quotation/insert_quotation') . '?m=' . $m . '', 'id' => 'cashPaymentVoucherForm', 'class' => 'stop']); ?>
                            {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">

                                            
                                        </div>
                                        <div id="getNewQuotationForm">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="submitBtn" style="display: none">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                    {{ Form::submit('Submit', ['class' => 'btn btn-success getNewQuotationSubmit']) }}
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script type="text/javascript">
        $('.select2').select2();

        function getPrNoList() {
            let ids = $('#company_location').val();
            if (ids != null) {
                $('#getNewQuotationForm').html('<div class="loading"></div>');
                $.ajax({
                    url: "{{url('/quotation/getPoNoList')}}",
                    type: 'GET',
                    data: {ids: ids},
                    success: function(data){
                        $('#getNewQuotationForm').html('');
                        // console.log(data);
                        $('#demandno').html('');
                        data.forEach(element => {
                            $('#demandno').append(`<option value="${element.id}">${element.demand_no}</option>`);
                        });
                    },
                    error: function(response){
                        $('#getNewQuotationForm').html('');
                        console.log(response.error);
                    }
                });
                return;
            }
            alert('Select Location');
        }

        function getQuotationFormData() {
            let ids = $('#demandno').val();
            if (ids != null) {
                $('#getNewQuotationForm').html('<div class="loading"></div>');
                $.ajax({
                    url: "{{url('/quotation/new_create_quotation_form')}}",
                    type: 'GET',
                    data: {ids: ids},
                    success: function(data){
                        $('#getNewQuotationForm').html(data);
                        $('#submitBtn').css('display','block');
                    },
                    error: function(response){
                        $('#getNewQuotationForm').html('');
                        console.log(response.error);
                    }
                });
                return;
            }
            alert('Select PR NO');
        }
        $("form").submit(function (e) {
        
        e.preventDefault();
        var validate = form_validate();
        if (validate == false) {
            
            return false;
        }
        if (validate == 1) {
            formData = new FormData(this);
            formData.append("company_location_id", $('#company_location').val());
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                //    console.log(response);
                   getQuotationFormData()
                    return false;
                },
                error: function(e) {
                    console.log(e);
                    return false;
                }
            });
            // $('form').submit();

        }
    });
    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
