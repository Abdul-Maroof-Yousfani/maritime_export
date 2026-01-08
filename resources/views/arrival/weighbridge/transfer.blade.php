<?php
use App\Helpers\CommonHelper;
?>
<div class="">
    <form action="{{ route('weighbridgeTranfer.store') }}" method="post" id="accommodiatiesProduct">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" id="" value="{{$id}}">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Select Location </label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <select name="location_id" id="location_id" class="form-control requiredField">
                    @foreach (CommonHelper::get_all_warehouse() as $value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                </select>
                {{-- <input type="text" name="location_id"  id="location_id" value=""
                    class="form-control requiredField" /> --}}
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Location No.</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="location_no"  id="location_no" value=""
                    class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"> 
                <button id="submitButton" type="submit" class="btn btn-success">Submit</button>  
            </div>
        </div>
    </form>
</div>