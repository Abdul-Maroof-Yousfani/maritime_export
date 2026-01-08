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
                                        <span class="subHeadingLabelClass">Upload Charts Of Accounts</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <?php echo Form::open(['url' => '/uploadCOADetail?m=' . $m . '', 'id' => 'addSubItemDetail','enctype' => 'multipart/form-data']); ?>
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">


                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Attachment :</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <input type="file" name="dataFile" id="dataFile" class="form-control"/>
                                                        </div>
                                                    </div>

                                                    <div class="lineHeight">&nbsp;</div>

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                                        {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                                        <button type="reset" id="reset" class="btn btn-primary">Clear
                                                            Form</button>
                                                    </div>
                                                    <?php echo Form::close(); ?>
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
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
