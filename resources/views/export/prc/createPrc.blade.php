<?php

    $m =Session::get('run_company');

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
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span class="subHeadingLabelClass">Create PRC </span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            
                                                <form method="POST" action="{{route('createPrcStore')}}" >
                                            <div class="row">
                                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <label>Bank</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <select class="form-control" name="bank_id" id="">
                                                        @foreach ($banks as $bank)
                                                        <option value="{{$bank->id}}">{{$bank->bank_name}}</option>
                                                        @endforeach
                                                      
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <label>Booking Date</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <input type="date" name="book_date" id="name" value="" class="form-control requiredField" />
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <label>Book Amount</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <input type="text" name="book_amount"  id="name" onkeypress="claculation(this.value)" onblur="claculation(this.value)" onkeyup="claculation(this.value)" class="form-control requiredField" />
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <label>FWD NO</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <input type="text" name="fwd_no" id="name" value="" class="form-control requiredField" />
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <label>FWD Type</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                 <select name="fwd_typ" id="" class="form-control">
                                                    <option value="1">FWD Booking</option>
                                                    <option value="2">Ready Rate/Spot</option>
                                                    <option value="3">FE 25</option>
                                                    <option value="4">EFS</option>
                                                 </select>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <label>Rate</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <input type="text" name="rate" id="name" value="" class="form-control requiredField" />
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <label>Start Date</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <input type="date" name="start_date" id="name" value="" class="form-control requiredField" />
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <label>Maturity Date</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <input type="date" name="maturity_date" id="name" value="" class="form-control requiredField" />
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <label>Balance</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <input type="text" name="balance" id="balance" value="" class="form-control requiredField" />
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <label>Fixed</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <input type="date" name="fixed" id="name" value="" class="form-control requiredField" />
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <label>Option</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <input type="date" name="option" id="name" value="" class="form-control requiredField" />
                                                </div>
                                                <div>&nbsp;</div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                                    <button type="reset" id="reset" class="btn btn-danger">Clear Form</button>

                                                    <?php
                                                    //echo Form::submit('Click Me!');
                                                    ?>
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

        function claculation(value)
        {
            $('#balance').val('');
            $('#balance').val(value);
        }
    </script>

    <script type="text/javascript">

        $('.select2').select2();
    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection