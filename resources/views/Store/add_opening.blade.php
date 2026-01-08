@php
    use App\Helpers\CommonHelper;
@endphp
@extends('layouts.default')

@section('content')
    @include('modal')

    {{-- @if (Session::get('run_company') == 3 || Session::get('run_company') == 5) --}}
        <?php echo Form::open(['url' => 'stad/insert_opening_data', 'id' => 'subm','enctype'=>'multipart/form-data']); ?>
        @csrf
    {{-- @endif --}}
    <div class="container-fluid">
        <div class="well_N">
            <div class="dp_sdw">
                <div class="panel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12  col-sm-12 col-xs-12" style="">
                                <a download href="{{asset('/public/openingFile.xlsx')}}"> Sample File XLSX</a>
                            </div>
                            <div class="col-lg-5 col-md-5  col-sm-5 col-xs-12" style="">
                                <label class="sf-label">File</label>
                                <input type="file" class="form-control requiredField"
                                    name="file"/>
                            </div>
                            <div class="col-lg-5 col-md-5  col-sm-5 col-xs-12" style="">
                                <label class="sf-label">Warehouse</label>
                                <select class="form-control requiredField"
                                    name="warehouse_id">
                                    <option value="">Select Warehouse</option>
                                    @foreach(CommonHelper::get_all_warehouse() as $row)
                                        <option value="{{ $row->id }}">{{ ucwords($row->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-2  col-sm-2 col-xs-12" style="">
                                <button style="margin-top:33px" type="submit"
                                    class="btn btn-success">Upload</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php echo Form::close(); ?>
@endsection
