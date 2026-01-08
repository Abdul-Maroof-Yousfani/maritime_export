<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
?>
<style>
    /* The switch - the box around the slider */
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

/* Hide the default HTML checkbox */
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

/* The slider */
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: red; /* Initially red for Off */
    transition: 0.4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
}

/* On state (Green background) */
input:checked + .slider {
    background-color: green;
}

/* Move the slider to the right when switched On */
input:checked + .slider:before {
    transform: translateX(26px);
}

</style>
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
                                        <span class="subHeadingLabelClass">Edit Sub Variety</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form action="{{ route('product.ListProductUpdate') }}" method="post"
                                                        id="accommodiatiesProduct">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="table_type" value="3">
                                                        <input type="hidden" name="id" value="{{$product->id}}">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Variety :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select autofocus required name="parent_id" id="parent_id"
                                                                    class="form-control select2">
                                                                    <option value="">Select Variety</option>
                                                                    @foreach ($products_drop as $key => $y)
                                                                        <option value="{{ $y->id }}"
                                                                            {{ $product->parent_id == $y->id ? 'selected' : '' }}>
                                                                            {{ $y->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Sub Variety Name :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input required type="text" name="name" id="name"
                                                                    value="{{ $product->name }}" class="form-control" />
                                                                @if ($errors->has('name'))
                                                                    <span class="help-block">
                                                                        <strong
                                                                            class="text-danger">{{ $errors->first('name') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row" style="margin-top: 7%">
                                                            <div class="col-lg-12">
                                                                <label>Sub Variety Parameters:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                            
                                                                <div id="parameterList">
                                                                    <table class="table table-bordered" id="parameterTable">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Serial No</th>
                                                                                <th>Parameter Name</th>
                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <!-- Assuming this data is dynamically generated in Blade or JavaScript -->
                                                                            @foreach ($types as $key => $parameter)
                                                                            <tr>
                                                                                <td>{{ $key + 1 }}</td>
                                                                                <td>{{ $parameter->name }}</td>
                                                                                <td>
                                                                                    <label class="switch">
                                                                                        <input type="checkbox" {{in_array($parameter->id, $selectedParameters) ? 'checked' : ''}} class="toggle-switch" name="parameter_id[]" value="{{ $parameter->id }}">
                                                                                        <span class="slider round"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div style="margin-top: 8%" class="lineHeight">&nbsp;</div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                                            {{ Form::submit('Update', ['class' => 'btn btn-success']) }}
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
    <script type="text/javascript">
        $('.select2').select2();
    </script>

    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
