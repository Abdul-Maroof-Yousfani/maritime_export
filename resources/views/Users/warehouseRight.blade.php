<?php
use App\Helpers\FinanceHelper;
use App\Helpers\CommonHelper;
$m =Session::get('run_company');
?>
@extends('layouts.default')

@section('content')
    @include('select2')
    <?php echo Form::open(array('url' => 'users/warehouseRightPost?m='.$m,'id'=>'warehouseRightPost'));?>
    <div class="well_N">
    <div class="dp_sdw">    
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="well">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span class="subHeadingLabelClass">Warehouse Rights Screen</span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <select name="users" id="users" onchange="user_location()" class="form-control">
                                                    <option>Select</option>
                                                   @foreach(CommonHelper::get_all_users() as $row)
                                                       <option value="{{$row->id}}">{{$row->name}}</option>
                                                       @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <select name="warehouse[]" id="warehouse" multiple class="form-control">
                                                    <option value="0">Select Company</option>
                                                   
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <button type="submit" class="btn btn-primary" id="BtnRight">Submit</button>
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
    <?php echo Form::close();?>
    <script>
        $(document).ready(function(){
            $('select').select2();
        });

        function user_location(){
            let id = $('#users option:selected').val();
            $.ajax({
                url: '<?php echo url('/'); ?>/users/UserLocation',
                method: 'GET',
                data: {id: id},
                error: function() {
                    alert('error');
                },
                success: function(response) {
                    $('#warehouse').html(response);
                }
            });
        }
    </script>
@endsection