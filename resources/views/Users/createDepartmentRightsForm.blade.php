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
                                        <span class="subHeadingLabelClass">Department Rights Form</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form method="post"
                                                        action="{{ url('uad/assignUserDepartmentRights?m=' . $m) }}"
                                                        id="addSubItemDetail">
                                                        {{ csrf_field() }}
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>User</label>
                                                                <select class="form-control" onchange="user_department()" id="users" name="user_id">
                                                                <option value="">Select User</option>
                                                                    @foreach ($users as $user)
                                                                        <option value="{{ $user->id }}">
                                                                            {{ $user->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Department</label>
                                                                <select class="form-control requiredField select2" name="department_id[]" id="department_id" multiple>
                                                                    <option value="">Select Department</option>
                                                                    @foreach ($departments as $key => $y)
                                                                        <optgroup label="{{ $y->department_name }}" value="{{ $y->id }}">
                                                                            <?php
                                                                            $subdepartments = DB::select('select `id`,`sub_department_name` from `sub_department` where `department_id` =' . $y->id . '');
                                                                            ?>
                                                                            @foreach ($subdepartments as $key2 => $y2)
                                                                                <option value="{{ $y2->id }}"> {{ $y2->sub_department_name }}</option>
                                                                            @endforeach
                                                                        </optgroup>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row">&nbsp;</div>

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

        function user_department(){
            let id = $('#users option:selected').val();
            $.ajax({
                url: '<?php echo url('/'); ?>/users/UserDepartment',
                method: 'GET',
                data: {id: id},
                error: function() {
                    alert('error');
                },
                success: function(response) {
                    $('#department_id').html(response);
                }
            });
        }
    </script>
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
