<?php
use App\Helpers\CommonHelper;

?>


<div class="">
    <form action="{{ route('inspection.store') }}" method="post" id="accommodiatiesProduct">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>PO No.</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="ins_no" readonly id="ins_no" value="{{ $weightbridge->po_no }}"
                    class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Inspection No:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="ins_no" readonly id="ins_no" value="{{ $weightbridge->inspection_no }}"
                       class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Gate Pass No.</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="truck_no" id="truck_no" readonly value="{{ $weightbridge->gate_pass_no }}"
                       class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Webridge No:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="ins_no" readonly id="ins_no" value="{{ $weightbridge->weighbridge_no }}"
                    class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Date:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="date" name="date" id="date" readonly value="{{ $weightbridge->date }}"
                       class="form-control requiredField" />
            </div>

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Supplier Name:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="text" id="text" readonly value="{{ $weightbridge->customer_name }}"
                       class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Vehicle No:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="text" id="text" readonly value="{{ $weightbridge->vehicle_no }}"
                       class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Consignee weight:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="ins_no" readonly id="ins_no"
                       value="{{ $weightbridge->consignee_weight }}" class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Cosec No:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="text" id="text" readonly value="{{ $weightbridge->cosec_no }}"
                       class="form-control requiredField" />
            </div>

{{--            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">--}}
{{--                <label>Weight Bridge Id:</label>--}}
{{--                <span class="rflabelsteric"><strong>*</strong></span>--}}
{{--                <input type="text" name="ins_no" readonly id="ins_no" value="{{ $weightbridge->id }}"--}}
{{--                    class="form-control requiredField" />--}}
{{--            </div>--}}
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Weight Bridge User:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="ins_no" readonly id="ins_no"
                    value="{{ $weightbridge->weighbridge_userid }}" class="form-control requiredField" />
            </div>



{{--            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">--}}
{{--                <label>Shippment origin:</label>--}}
{{--                <span class="rflabelsteric"><strong>*</strong></span>--}}
{{--                <input type="text" name="text" id="text" readonly--}}
{{--                    value="{{ $weightbridge->shipment_origin }}" class="form-control requiredField" />--}}
{{--            </div>--}}


{{--            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">--}}
{{--                <label> Recived By.</label>--}}
{{--                <span class="rflabelsteric"><strong>*</strong></span>--}}
{{--                <input type="text" name="truck_no" id="truck_no" readonly--}}
{{--                    value="{{ $weightbridge->recieved_by }}" class="form-control requiredField" />--}}
{{--            </div>--}}
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label> Description.</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="truck_no" id="truck_no" readonly value="{{ $weightbridge->description }}"
                       class="form-control requiredField" />
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3>Item Detail</h3>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label> No of Packages.</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="truck_no" id="truck_no" readonly
                    value="{{ $weightbridge->no_of_pkgs }}" class="form-control requiredField" />
            </div>
        
            
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label> Description of Goods.</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="truck_no" id="truck_no" readonly
                    value="{{ $weightbridge->goods_description }}" class="form-control requiredField" />
            </div>
            
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label> First Weight.</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="truck_no" id="truck_no" readonly
                    value="{{ $weightbridge->first_weight }}" class="form-control requiredField" />
            </div>
            
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label> Second Weight.</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="truck_no" id="truck_no" readonly
                    value="{{ $weightbridge->second_weight }}" class="form-control requiredField" />
            </div>
            
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label> Gross Weight.</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="truck_no" id="truck_no" readonly
                    value="{{ $weightbridge->gross_weight }}" class="form-control requiredField" />
            </div>
        </div>
{{--        <div class="row">--}}
{{--            --}}
{{--            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">--}}
{{--                <label> Recived Amount.</label>--}}
{{--                <span class="rflabelsteric"><strong>*</strong></span>--}}
{{--                <input type="text" name="truck_no" id="truck_no" readonly--}}
{{--                    value="{{ $weightbridge->amount_recived }}" class="form-control requiredField" />--}}
{{--            </div>--}}
{{--        </div>--}}
        
        <div class="row">
            @if ($weightbridge->location_id == null)
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"> 
                    <button id="transferButton" onclick="showDetailModelOneParamerter('arrival/weighbridgeTranfer',{{ $weightbridge->id }},' Transfer')" type="button" class="btn btn-success">Transfer</button>  
                </div>
            @else
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label> Location </label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="truck_no" id="truck_no" readonly
                    value="{{$weightbridge->parent_location ??  '--'}}" class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label> Location no.</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="location_no" id="location_no" readonly
                    value="{{$weightbridge->location ??  '--'}}" class="form-control requiredField" />
            </div>
            @endif


            
        </div>

        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="margin-top: 3%;">
                <label>Attachment </label>
                @if(!empty($weightbridge->attachment))
                    <a href="{{ asset('storage/' . $weightbridge->attachment) }}" 
                    class="btn btn-primary" 
                    download="{{ $weightbridge->attachment }}">
                    Download Attachment
                    </a>
                @else
                    <p>No attachment available</p>
                @endif  
            </div>
    </form>
</div>


