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
                                        <span class="subHeadingLabelClass">Product Quality Deduction Slab Form</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form action="{{ route('slab.store') }}" method="post"
                                                        id="accommodiatiesProduct">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Slab Type :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select autofocus name="slab_type_id" id="slab_type_id"
                                                                    class="form-control requiredField select2">
                                                                    <option value="">Select Slab Types</option>
                                                                    @foreach ($types as $key => $y)
                                                                        <option value="{{ $y->id }}"
                                                                            {{ old('slab_type_id') == $y->id ? 'selected' : '' }}>
                                                                            {{ $y->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Select Item:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select autofocus name="product_id" id="product_id"
                                                                    class="form-control requiredField select2">
                                                                    <option value="">Select Item</option>
                                                                    @foreach ($product as $key => $y)
                                                                        <option value="{{ $y->id }}"
                                                                            {{ old('product_id') == $y->id ? 'selected' : '' }}>
                                                                            {{ $y->parent->name }} - {{ $y->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>From</label>
                                                                <input type="number" class="form-control requiredField" id="from1" name="from[]"
                                                                    step="0.01" value="">
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>To</label>
                                                                <input type="number" class="form-control requiredField" id="to1" name="to[]"
                                                                    step="0.01" value="">
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Deduction(%)</label>
                                                                <input type="number" class="form-control requiredField deduction" id="amount1" name="amount[]"
                                                                    step="0.01" max="100" value="">
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label>Remarks</label>
                                                                <textarea class="form-control" rows="5" id="remark1" name="remark[]"></textarea>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <button type="button" class="btn btn-primary btn xs" onClick="addMoreSlabs()" style="margin-top: 35px;">Add Row</button>
                                                            </div>
                                                        </div>
                                                        <div id="addMoreSlabs"></div>
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
        let counter = 0;
        function addMoreSlabs(){
            $('#addMoreSlabs').append(`
            <div class="row row${++counter}">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <label>From</label>
                    <input type="number" class="form-control requiredField" id="from${counter}" name="from[]"
                        step="0.01" value="">
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <label>To</label>
                    <input type="number" class="form-control requiredField" id="to${counter}" name="to[]"
                        step="0.01" value="">
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <label>Deduction(%)</label>
                    <input type="number" class="form-control requiredField deduction" id="amount${counter}" name="amount[]"
                        step="0.01" max="100" value="">
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label>Remarks</label>
                    <textarea class="form-control" rows="5" id="remark${counter}" name="remark[]"></textarea>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <button type="button" class="btn btn-danger btn xs" onClick="removeSlabRow(${counter})" style="margin-top: 35px;">Remove</button>
                </div>
            </div>
            `);
        }

        function removeSlabRow(params) {
            $('.row'+params).remove();
        }

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
                        // $('.btn-success').prop('disabled', true);
                        // $("form").submit();
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
