@extends('layouts.default')

@section('content')
    @include('select2')
    <div class="well_N">
        <div class="dp_sdw">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="well">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <span class="subHeadingLabelClass">Edit Product Quality Deduction Slab</span>
                                    </div>
                                </div>
                                <div class="lineHeight">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form action="{{ route('slab.update', $slab->id) }}" method="post" id="accommodiatiesProduct">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Slab Type :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select autofocus name="slab_type_id" id="slab_type_id" class="form-control requiredField select2">
                                                                    <option value="">Select Slab Types</option>
                                                                    @foreach ($types as $type)
                                                                        <option value="{{ $type->id }}" {{ $slab->slab_type_id == $type->id ? 'selected' : '' }}>
                                                                            {{ $type->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Select Item:</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <select autofocus name="product_id" id="product_id" class="form-control requiredField select2">
                                                                    <option value="">Select Item</option>
                                                                    @foreach ($products as $item)
                                                                        <option value="{{ $item->id }}" {{ $slab->product_id == $item->id ? 'selected' : '' }}>
                                                                            {{ $item->parent->name }} - {{ $item->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div id="slabFields">
                                                            @foreach ($slabParameters as $index => $param)
                                                            <input type="hidden" name="id_array[]" value="{{ $param->id }}">
                                                            <div class="row slab-row{{ $index }}">
                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                    <label>From</label>
                                                                    <input type="number" class="form-control requiredField" name="from[]" step="0.01" value="{{ $param->from }}">
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                    <label>To</label>
                                                                    <input type="number" class="form-control requiredField" name="to[]" step="0.01" value="{{ $param->to }}">
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                    <label>Deduction(%)</label>
                                                                    <input type="number" class="form-control requiredField deduction" name="amount[]" step="0.01" max="100" value="{{ $param->amount }}">
                                                                </div>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                    <label>Remarks</label>
                                                                    <textarea class="form-control" rows="5" name="remark[]">{{ $param->remark }}</textarea>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                    <button type="button" class="btn btn-danger btn-xs" onClick="removeSlabRow({{ $index }})" style="margin-top: 35px;">Remove</button>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <button type="button" class="btn btn-primary btn-xs" onClick="addMoreSlabs()" style="margin-top: 35px;">Add Row</button>
                                                            </div>
                                                        </div>
                                                        <div class="lineHeight">&nbsp;</div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                                            {{ Form::submit('Update', ['class' => 'btn btn-success']) }}
                                                            <button type="reset" id="reset" class="btn btn-primary">Clear Form</button>
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
        let counter = {{ $slabParameters->count() }}; // Start count from existing rows

        function addMoreSlabs() {
            $('#slabFields').append(`
                <div class="row slab-row${++counter}">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label>From</label>
                        <input type="number" class="form-control requiredField" name="from[]" step="0.01" value="">
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label>To</label>
                        <input type="number" class="form-control requiredField" name="to[]" step="0.01" value="">
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label>Deduction(%)</label>
                        <input type="number" class="form-control requiredField deduction" name="amount[]" step="0.01" max="100" value="">
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label>Remarks</label>
                        <textarea class="form-control" rows="5" name="remark[]"></textarea>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <button type="button" class="btn btn-danger btn-xs" onClick="removeSlabRow(${counter})" style="margin-top: 35px;">Remove</button>
                    </div>
                </div>
            `);
        }

        function removeSlabRow(index) {
            $(`.slab-row${index}`).remove();
        }

        $(document).ready(function() {
            $(".select2").select2();
        });
    </script>
@endsection
