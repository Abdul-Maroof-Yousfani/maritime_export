<?php

    $m =Session::get('run_company');
    use App\Helpers\CommonHelper;

?>
@extends('layouts.default')

@section('content')
    @include('select2');
    <div class="well_N">
    <div class="dp_sdw">    
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="display: none;">
                      
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="well">
                            <form method="POST" action="{{route('addvancePaymentStore')}}" >
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span class="subHeadingLabelClass"> Advance Payment</span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                <input readonly type="text" class="form-control" name="proforma_no" value="{{$data->proforma_no}}" id="">
                                                </div>
                                            </div>
                                            <div class="row">
                                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                  <label>Credit</label>
                                                  </div>
                                                  <input type="hidden" name="proforma_id" id="" value="{{$data->proforma_id}}">
                                                  <input type="hidden" name="export_order_id" id="" value="{{$data->id}}">
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                    <label>Buyer: </label>
                                                 
                                            <select readonly name="buyer_id" class="form-control" id="">
                                                <option value="">Select</option>
                                                    @foreach($customer as $cus)
                                                    <option value="{{$cus->acc_id}}" @if($data->buyer_id == $cus->id) selected @endif>{{$cus->name}}</option>
                                                    @endforeach
                                                 </select>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                    <label>Export Order Amount </label>
                                                 <input readonly type="text" name="export_order_amount" value="{{$export_data->total_amount}}" class="form-control
                                                 ">
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                    <label>Export Order Advance % </label>
                                                 <input readonly type="text" name="advance_in_percent" id="advance_in_percent" value="{{$data->advance_payment}}" class="form-control
                                                 ">
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                    <label> Advance Amount </label>
                                                    <input type="hidden" name="hidden_total_amount" id="hidden_total_amount" value="{{$export_data->total_amount}}" />
                                                    <input type="text" name="advance_amount" id="advance_amount" value="{{$export_data->total_amount/100*$data->advance_payment}}" class="form-control
                                                 " onchange="calculatePercentage()">
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <hr>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <label>Debit</label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <label>Account </label>
                                                        <select    class="form-control requiredField select2" name="account_id" id="account_id">
                                                            <option value="">Select Account</option>
                                                            @foreach(CommonHelper::get_all_account_operat() as $key => $y)
                                                                <option value="{{ $y->id}}">{{ $y->code .' ---- '. $y->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <label>Description </label>
                                                    <input type="text" class="form-control" name="description">
                                                    </div>
                                                    
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <label>Already Received </label>
                                                    <input type="text" value="{{$advance_payment->received_amount??0}}" readonly class="form-control" name="already_received">
                                                    </div>
                                                    <?php
                                                      $advance_received =   $advance_payment->received_amount??0;
                                                    ?>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <label>Amount </label>
                                                    <input type="text" name="received_amount" id="received_amount" value="{{$export_data->total_amount/100*$data->advance_payment-$advance_received}}" class="form-control">
                                                    </div>
                                                </div>
                                               
                                                <div>&nbsp;</div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                                    {{-- <button type="reset" id="reset" class="btn btn-danger">Clear Form</button> --}}

                                                    <?php
                                                    //echo Form::submit('Click Me!');
                                                    ?>
                                                </div>
                                           
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script type="text/javascript">
        // $(document).ready(function() {
        //     $(".btn-success").click(function(e){
        //         var category = new Array();
        //         var val;
        //         //$("input[name='chartofaccountSection[]']").each(function(){
        //         category.push($(this).val());
        //         //});
        //         var _token = $("input[name='_token']").val();
        //         for (val of category) {

        //             jqueryValidationCustom();
        //             if(validate == 0){
        //                 //return false;
        //             }else{
        //                 return false;
        //             }
        //         }
        //     });
        // });
        function calculatePercentage(){
            var hidden_total_amount = $('#hidden_total_amount').val();
            var advance_amount = $('#advance_amount').val();

            var calculatePercentage = parseInt(advance_amount) / parseInt(hidden_total_amount) * 100;
            $('#advance_in_percent').val(calculatePercentage.toFixed(0));
            $('#received_amount').val(advance_amount);   
        }
    </script>

    <script type="text/javascript">

        $('.select2').select2();
    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection