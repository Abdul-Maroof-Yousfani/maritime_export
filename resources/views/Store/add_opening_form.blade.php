@extends('layouts.default')
@php
    use App\Helpers\CommonHelper;
@endphp
@section('content')
    @include('modal')

    @include('select2')
    <?php echo Form::open(['url' => 'stad/stockAdjustment', 'id' => 'stockAdjustment', 'class' => 'stop']); ?>
    <div class="container-fluid">
        <div class="well_N">
            <div class="dp_sdw">
                <div class="panel">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-lg-12 col-md-12  col-sm-12 col-xs-12" style="">
                                <h3>Stock Adjustment</h3>
                            </div>
                            <div class="col-lg-4 col-md-4  col-sm-4 col-xs-12" style="">
                                <label class="sf-label">Item</label>
                                <select class="form-control select2 getItemAjaxList" name="item_id" id="item_id">
                                </select>
                                @if ($errors->has('item_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('item_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-4 col-md-4  col-sm-4 col-xs-12" style="">
                                <label class="sf-label">UOM</label>
                                <input type="text" readonly class="form-control requiredField"
                                    placeholder="UOM" name="uom" id="uom" />
                            </div>
                            <div class="col-lg-4 col-md-4  col-sm-4 col-xs-12" style="">
                                <label class="sf-label">Warehouse</label>
                                <select class="form-control select2" name="warehouse_id" id="warehouse_id">
                                    <option value="0">Select Warehouse</option>
                                    @foreach (CommonHelper::get_users_warehouse() as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('warehouse_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('warehouse_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4  col-sm-4 col-xs-12" style="">
                                <label class="sf-label">Type</label>
                                <select class="form-control select2" name="type" id="type">
                                    <option value="1">IN</option>
                                    <option value="0">OUT</option>
                                </select>
                                @if ($errors->has('type'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-4 col-md-4  col-sm-4 col-xs-12" style="">
                                <label class="sf-label">QTY</label>
                                <input type="number" class="form-control requiredField" placeholder="Enter QTY"
                                    name="qty" id="qty" step="0.01" value="0" />
                                    @if ($errors->has('qty'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('qty') }}</strong>
                                        </span>
                                    @endif
                            </div>
                            <div class="col-lg-4 col-md-4  col-sm-4 col-xs-12" style="">
                                <label class="sf-label">Rate</label>
                                <input type="number" class="form-control requiredField" step="0.01"
                                    placeholder="Enter Rate" name="rate" id="rate" value="0" />
                                    @if ($errors->has('rate'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('rate') }}</strong>
                                        </span>
                                    @endif
                            </div>
                            <div class="col-lg-12 col-md-12  col-sm-12 col-xs-12" style="">
                                <label class="sf-label">ReMarks</label>
                                <textarea name="remarks" id="remarks" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="">
                                <button type="submit" class="btn btn-success">SUBMIT</button>
                            </div>
                        </div>
                        <div class="row">
                            <span id="data"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>
    <script>
        $(function() {
            $('select').select2();
            getAjaxItemList('#item_id');
            // $('.getItemAjaxList').select2({
            //     placeholder: 'Select an item',
            //     ajax: {
            //         url: '{{ url('pdc/getAllItems') }}',
            //         dataType: 'json',
            //         delay: 250,
            //         processResults: function(data) {
            //             return {
            //                 results: $.map(data, function(item) {
            //                     return {
            //                         text: item.sku_code + '-' + item.name,
            //                         id: item.id,
            //                         uom: item.uom_name
            //                     }
            //                 })
            //             };
            //         },
            //         cache: true
            //     }
            // });
        });
        $('.getItemAjaxList').on('select2:select', function(e) {
            var data = e.params.data;
            $('#uom').val(data.uom);
            // console.log(data.uom);
        });
    </script>
@endsection
