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
                                        <span class="subHeadingLabelClass">Locations Form</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form method="post"
                                                        action="{{ url('pad/addCompanyLocationDetail?m=' . $m) }}"
                                                        id="addSubItemDetail">
                                                        {{ csrf_field() }}
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label>Location Name</label>
                                                                <input type="text" class="form-control"
                                                                    name="location_name" value="{{ old('location_name') }}">
                                                                @if ($errors->has('location_name'))
                                                                    <span class="help-block">
                                                                        <strong
                                                                            class="text-danger">{{ $errors->first('location_name') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label>Contact Person</label>
                                                                <input type="text" class="form-control"
                                                                    name="location_contact_person" value="{{ old('location_contact_person') }}">
                                                                @if ($errors->has('location_contact_person'))
                                                                    <span class="help-block">
                                                                        <strong
                                                                            class="text-danger">{{ $errors->first('location_contact_person') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label>Contact NO#</label>
                                                                <input type="text" class="form-control"
                                                                    name="location_contact_no" value="{{ old('location_contact_no') }}">
                                                                @if ($errors->has('location_contact_no'))
                                                                    <span class="help-block">
                                                                        <strong
                                                                            class="text-danger">{{ $errors->first('location_contact_no') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <label>Location Address</label>
                                                                <textarea class="form-control" rows="5"
                                                                    name="location_address">{{old('location_address')}}</textarea>
                                                                @if ($errors->has('location_address'))
                                                                    <span class="help-block">
                                                                        <strong
                                                                            class="text-danger">{{ $errors->first('location_address') }}</strong>
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

        <div class="dp_sdw">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="well">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <span class="subHeadingLabelClass">Company Locations List</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body" id="PrintEmpExitInterviewList">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12col-xs-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered sf-table-list"
                                                                id="EmpExitInterviewList">
                                                                <thead>
                                                                    <th class="text-center">S.No</th>
                                                                    <th class="text-center">Location Name</th>
                                                                    <th class="text-center">Contact Person</th>
                                                                    <th class="text-center">Contact NO#</th>
                                                                    <th class="text-center">Location Address</th>

                                                                </thead>
                                                                <tbody id="data">
                                                                    @foreach ($company_locations as $key => $company_location)
                                                                        <tr>
                                                                            <td class="text-center">{{++$key}}</td>
                                                                            <td class="text-center">{{$company_location->location_name}}</td>
                                                                            <td class="text-center">{{$company_location->location_contact_person}}</td>
                                                                            <td class="text-center">{{$company_location->location_contact_no}}</td>
                                                                            <td class="text-center">{{$company_location->location_address}}</td>
                                                                        </tr>
                                                                    @endforeach
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
        $(document).ready(function() {
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
