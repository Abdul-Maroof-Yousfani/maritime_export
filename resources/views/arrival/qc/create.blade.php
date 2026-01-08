<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper; ?>
@extends('layouts.default')
@section('content')
    @include('select2');
    <div class="well_N">
        <div class="dp_sdw">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="well">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <span class="subHeadingLabelClass">Quality Checker</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form method="post"
                                                        action="{{ url('arrival/submit_qc?m=' . $m) }}"
                                                        id="addSubItemDetail">
                                                        {{ csrf_field() }}
                                                        <div class="row">
                                                            
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Quality Checker</label>
                                                                <input type="text" name="name" id="name"
                                                                value="{{ old('name') }}" class="form-control requiredField" />
                                                                @if ($errors->has('name'))
                                                                    <span class="help-block">
                                                                        <strong
                                                                            class="text-danger">{{ $errors->first('name') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="lineHeight">&nbsp;</div>

                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                                            {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                                            <button type="reset" id="reset"
                                                                class="btn btn-primary">Clear Form</button>
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
        $(document).ready(function() {
            $('select').select2();
            $(".btn-success").click(function(e) {
                var subItem = new Array();
                var val;
                //$("input[name='chartofaccountSection[]']").each(function(){
                subItem.push($(this).val());
                //});
                var _token = $("input[name='_token']").val();
                for (val of subItem) {

                    jqueryValidationCustom();
                    if (validate == 0) {
                        $('.btn-success').prop('disabled', true);
                        $("form").submit();
                        //return false;
                    } else {
                        return false;
                    }
                }
            });
        });
    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
