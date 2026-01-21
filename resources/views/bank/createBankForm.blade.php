<?php

$m = Session::get('run_company');

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
                                        <span class="subHeadingLabelClass">Add Bank</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form method="POST" action="{{ route('bankFormStore') }}">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <label>Account Title</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <input type="text" name="account_title" id="account_title"
                                                                value="" class="form-control requiredField" />
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <label>Bank Name:</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <input type="text" name="name" id="name"
                                                                value="" class="form-control requiredField" />
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <label>IBAN</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <input type="text" name="ibn" id="ibn"
                                                                value="" class="form-control requiredField" />
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <label>Account NO</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <input type="text" name="account_no" id="account_no"
                                                                value="" class="form-control requiredField" />
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <label>Swift Code:</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <input type="text" name="swift_code" id="swift_code"
                                                                value="" class="form-control requiredField" />
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <label>Bank Address</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <input type="text" name="Address" id="Address"
                                                                value="" class="form-control requiredField" />
                                                        </div>
                                                        <div>&nbsp;</div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                                            <button type="reset" id="reset"
                                                                class="btn btn-danger">Clear Form</button>

                                                            <?php
                                                            //echo Form::submit('Click Me!');
                                                            ?>
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
    </script>

    <script type="text/javascript">
        $('.select2').select2();
    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
