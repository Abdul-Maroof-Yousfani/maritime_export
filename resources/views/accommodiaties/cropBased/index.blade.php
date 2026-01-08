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
                                        <span class="subHeadingLabelClass">Create Crop Year</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form action="{{ route('cropBased.store') }}" method="post"
                                                        id="cropBased">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>From Date :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" name="date_from" id="date_from"
                                                                    value="{{ old('date_from') }}" class="form-control" />
                                                                @if ($errors->has('date_from'))
                                                                    <span class="help-block">
                                                                        <strong class="text-danger">{{ $errors->first('date_from') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>To Date :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="date" name="date_to" id="date_to"
                                                                    value="{{ old('date_to') }}" class="form-control" />
                                                                @if ($errors->has('date_to'))
                                                                    <span class="help-block">
                                                                        <strong class="text-danger">{{ $errors->first('date_to') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Select Category:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select autofocus name="category_id" id="category_id"
                                                                    class="form-control requiredField select2">
                                                                    <option value="">Select Category</option>
                                                                    @foreach ($categories as $key => $y)
                                                                        <option value="{{ $y->id }}"
                                                                            {{ old('category_id') == $y->id ? 'selected' : '' }}>
                                                                            {{ $y->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div style="margin-top: 7%" class="lineHeight">&nbsp;</div>
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
                                        <span class="subHeadingLabelClass">Crop Year List</span>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                    <button type="button" class="btn btn-warning" onclick="ExportToExcel('xlsx')">Export
                                        <b>(xlsx)</b></button>
                                </div> --}}
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="table-responsive">
                                                            <table id="table" class="table table-bordered">
                                                                <thead>
                                                                    <th class="text-center">S.No</th>
                                                                    <th class="text-center">From Year</th>
                                                                    <th class="text-center">To Year</th>
                                                                    <th class="text-center">Category</th>
                                                                    {{-- <th class="text-center">Action</th> --}}
                                                                </thead>
                                                                <tbody id="viewSlabList" class="text-center">
                                                                    @foreach ($cropYears as $key => $cropYear)
                                                                        <tr>
                                                                            <td>{{++$key}}</td>
                                                                            <td>{{date('M-Y', strtotime($cropYear->date_from))}}</td>
                                                                            <td>{{date('M-Y', strtotime($cropYear->date_to))}}</td>
                                                                            <td>{{ optional($cropYear->category)->name}}</td>
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
