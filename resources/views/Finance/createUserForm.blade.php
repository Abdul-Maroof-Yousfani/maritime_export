<?php
$m = Session::get('run_company');
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

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="well">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span class="subHeadingLabelClass">Add New User</span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="row">
                                            <?php echo Form::open(array('url' => 'users/addUserDetail?m='.$m.'','id'=>'addUserDetail'));?>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <label>Name:</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control" placeholder="Enter Name"/>
                                                    @if ($errors->has('name'))
                                                        <span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <label>Email:</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <input type="text" name="email" id="email" value="{{old('email')}}" class="form-control" placeholder="Enter Email"/>
                                                    @if ($errors->has('email'))
                                                        <span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <label>Company:</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <select name="company_id" id="company_id" class="form-control">
                                                        <option value="">Select Company</option>
                                                        @foreach($companies as $key => $value)
                                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('company_id'))
                                                        <span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('company_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <label>All Rights:</label>
                                                    <br>
                                                    <input type="checkbox" name="type" id="type" {{(old('type') == 1)? "checked" :'' }} value="1"/>
                                                </div>
                                            </div>
                                            <div class="lineHeight">&nbsp;</div>

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                                {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                                <button type="reset" id="reset" class="btn btn-primary">Clear Form</button>
                                            </div>
                                            <?php
                                            echo Form::close();
                                            ?>
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
            $(".btn-success").click(function(e){
                var subItem = new Array();
                var val;
                //$("input[name='chartofaccountSection[]']").each(function(){
                subItem.push($(this).val());
                //});
                var _token = $("input[name='_token']").val();
                for (val of subItem) {

                    jqueryValidationCustom();
                    if(validate == 0){
                        $('.btn-success').prop('disabled',true);
                        $("form").submit();
                        //return false;
                    }else{
                        return false;
                    }
                }
            });
        });
    </script>
@endsection
