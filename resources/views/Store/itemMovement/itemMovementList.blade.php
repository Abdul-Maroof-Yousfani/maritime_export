<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;

$delete = ReuseableCode::check_rights(483);
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
                                        <span class="subHeadingLabelClass">Item Movement List</span>
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
                                                                    <th class="text-center">Item</th>
                                                                    <th class="text-center">Type</th>
                                                                    <th class="text-center">Warehouse</th>
                                                                    <th class="text-center">Created By</th>
                                                                    <th class="text-center">Action</th>
                                                                </thead>
                                                                <tbody id="" class="text-center">
                                                                    @foreach ($itemMovements as $key => $itemMovement)
                                                                        <tr>
                                                                            <td>{{ ++$key }}</td>
                                                                            <td>{{ explode(',', CommonHelper::get_subitem_detail($itemMovement->item_id))[4] }}
                                                                            </td>
                                                                            <td>{{ CommonHelper::stockDemandType()->where('id', $itemMovement->type_id)->first()['name'] ?? '-' }}
                                                                            </td>
                                                                            <td>{{ CommonHelper::get_name_warehouse($itemMovement->warehouse_id) }}
                                                                            </td>
                                                                            <td>{{ $itemMovement->username ?? '-' }}</td>
                                                                            <td>
                                                                                @if($delete)
                                                                                    <a href="{{ url('store/deleteItemMovement/' . $itemMovement->id) }}"
                                                                                        class="btn btn-danger btn-xs">Delete</button>
                                                                                @endif
                                                                            </td>
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
    <script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection
