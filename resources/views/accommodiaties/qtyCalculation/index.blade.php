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
                                        <span class="subHeadingLabelClass">Truckig Calculation</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form action="{{ route('qtyCalculation.store') }}" method="post"
                                                        id="accommodiatiesProduct" enctype="multipart/form-data">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <div class="row">

                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <label>Traller :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="traller" id="traller"
                                                                    value="{{ $qtyCalculation->traller ?? old('traller') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Traller From :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="traller_from" id="traller_from"
                                                                    value="{{ $qtyCalculation->traller_from ?? old('traller_from') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Traller To :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="traller_to" id="traller_to"
                                                                    value="{{ $qtyCalculation->traller_to ?? old('traller_to') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <label>Truck :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="truck" id="truck"
                                                                    value="{{ $qtyCalculation->truck ?? old('truck') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Truck From :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="truck_from" id="truck_from"
                                                                    value="{{ $qtyCalculation->truck_from ?? old('truck_from') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Truck To :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="truck_to" id="truck_to"
                                                                    value="{{ $qtyCalculation->truck_to ?? old('truck_to') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <label>Bag :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="bag" id="bag"
                                                                    value="{{ $qtyCalculation->bag ?? old('bag') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Bag From :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="bag_from" id="bag_from"
                                                                    value="{{ $qtyCalculation->bag_from ?? old('bag_from') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Bag To :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="bag_to" id="bag_to"
                                                                    value="{{ $qtyCalculation->bag_to ?? old('bag_to') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <label>KG :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="kg" id="kg"
                                                                    value="{{ $qtyCalculation->kg ?? old('kg') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>KG From :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="kg_from" id="kg_from"
                                                                    value="{{ $qtyCalculation->kg_from ?? old('kg_from') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>KG To :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="kg_to" id="kg_to"
                                                                    value="{{ $qtyCalculation->kg_to ?? old('kg_to') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <label>Katta :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="katta" id="katta"
                                                                    value="{{ $qtyCalculation->katta ?? old('katta') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Katta From :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="katta_from" id="katta_from"
                                                                    value="{{ $qtyCalculation->katta_from ?? old('katta_from') }}"
                                                                    class="form-control" />
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Katta To :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input type="text" name="katta_to" id="katta_to"
                                                                    value="{{ $qtyCalculation->katta_to ?? old('katta_to') }}"
                                                                    class="form-control" />
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
