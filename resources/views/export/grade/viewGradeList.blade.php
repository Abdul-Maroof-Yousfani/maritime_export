<?php
$m =Session::get('run_company');
?>
@extends('layouts.default')

@section('content')
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
                                    <span class="subHeadingLabelClass">Grade List</span>
                                    <a href="{{route('gradeCreateForm')}}" class="btn btn-success pull-right">Add Grade</a>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <th class="text-center">S.No</th>
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Action</th>
                                                            </thead>
                                                            <tbody id="viewGradeList">
                                                            </tbody>
                                                        </table>
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
    </div>
    </div>
    <script type="text/javascript">
        function viewGradeList(){
            $('#viewGradeList').html('<tr><td colspan="4"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div></div></div></td><tr>');
            var m = '<?php echo $m =Session::get('run_company');?>';
            html ='';
            var counter =1;
            $.ajax({
                url: '<?php echo url('/')?>/export/viewGradeListAjax',
                type: "GET",
                data:{m:m},
                success:function(data) {
                    console.log(data);
                    setTimeout(function(){          
                        $('#viewGradeList').html(data);
                    },1000);
                }
            });
        }
        viewGradeList();
    </script>
@endsection

