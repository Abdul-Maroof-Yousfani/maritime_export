@extends('layouts.default')
@section('content')
    <div class="well_N">
        <div class="dp_sdw">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="well">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <span class="subHeadingLabelClass">Import New Vendors</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <?php echo Form::open(['url' => 'pad/importSupplierDetail', 'id' => '', 'enctype'=>'multipart/form-data']); ?>
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <div class="col-md-6">
                                                        <label for="file">File</label>
                                                        <input type="file" name="file" id="file" class="form-control">
                                                    </div>
                                                    <div>&nbsp;</div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
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
@endsection
