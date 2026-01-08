<?php
$m = Session::get('run_company');
use App\Helpers\CommonHelper;
use App\ProductionGatePassIn;
?>
<div>
    <form action="{{ route('getpass.store') }}" method="post"
    id="accommodiatiesProduct">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label>PO No :</label>
            <span class="rflabelsteric"><strong>*</strong></span>
            <input type="text" name="gate_pass_no" readonly
            id="gate_pass_no" value="{{$gatepasses->po_no}}"
            class="form-control requiredField" />
        </div>
        
        
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label>Gate Pass No:</label>
            <span class="rflabelsteric"><strong>*</strong></span>
            <input type="text" name="gate_pass_no" readonly
                id="gate_pass_no" value="{{$gatepasses->gate_pass_no}}"
                class="form-control requiredField" />
        </div>
        <input type="hidden" name="get_pass_type" value="1">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label>Inspection No:</label>
            <span class="rflabelsteric"><strong>*</strong></span>
            <input type="text" name="inspection_no" readonly
                id="inspection_no" value="{{$gatepasses->inspection_no}}"
                class="form-control requiredField" />
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label>Date:</label>
            <span class="rflabelsteric"><strong>*</strong></span>
            <input disabled type="date" name="date" id="date"
                value="{{$gatepasses->date}}"
                class="form-control requiredField" />
        </div>
       
        
    </div>
    <hr>
    <div class="row" style="">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label>Builty No:</label>
            <span class="rflabelsteric"><strong>*</strong></span>
            <input readonly type="text" name="builty_no" 
                id="builty_no" value="{{$gatepasses->builty_no}}"
                class="form-control requiredField" />
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label>Vehicle No:</label>
            <span class="rflabelsteric"><strong>*</strong></span>
            <input disabled type="text" name="vehicle_no" 
                id="vehicle_no" value="{{$gatepasses->vehicle_no}}"
                class="form-control requiredField" />
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label>Transporter Name:</label>
            <span class="rflabelsteric"><strong>*</strong></span>
            <input readonly type="text" name="transporter_name" 
                id="transporter_name" value="{{$gatepasses->transporter_name}}"
                class="form-control requiredField" />
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label>Driver Name:</label>
            <span class="rflabelsteric"><strong>*</strong></span>
            <input readonly type="text" name="driver_name" 
                id="driver_name" value="{{$gatepasses->driver_name}}"
                class="form-control requiredField" />
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label>Driver Number:</label>
            <span class="rflabelsteric"><strong>*</strong></span>
            <input readonly type="text" name="driver_number" 
                id="driver_number" value="{{$gatepasses->driver_number}}"
                class="form-control requiredField" />
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label>Arrival Note:</label>
            <span class="rflabelsteric"><strong>*</strong></span>
            <input disabled type="text" name="arrival_note" 
                id="driver_name" value="{{$gatepasses->arrival_note}}"
                class="form-control requiredField" />
        </div>
        
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="margin-top: 3%;">
                <label>Attachment </label>
                @if(!empty($gatepasses->attachment))
                    <a href="{{ asset('storage/' . $gatepasses->attachment) }}" 
                    class="btn btn-primary" 
                    download="{{ $gatepasses->attachment }}">
                    Download Attachment
                    </a>
                @else
                    <p>No attachment available</p>
                @endif  
            </div>
     

    </div>
    <hr>
   

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th colspan="3" class="text-center">
                                Item
                                Detail</th>
                            <th colspan="2" class="text-center hide">
                                <input type="button"
                                    class="btn btn-sm btn-primary"
                                    onclick="AddMoreDetails()"
                                    value="Add More Rows" />
                            </th>
                        </tr>
                        <tr>
                            {{-- <th class="text-center"
                                style="width: 2%;">S.NO
                            </th> --}}
                            <th class="text-center"
                                style="width: 20%;">
                                Item Name</th>
                            <th class="text-center">Total Qty </th>
                            <th class="text-center">Recived Qty
                            </th>
                            <th class="text-center">Description</th>
                           
                        </tr>
                    </thead>
                  
                    <tbody id="AppnedHtml">
                        <tr class="cnt" id="removeSection1">

                            <td>
                                <input type=""
                                    class="form-control requiredField " disabled name="total_qty"
                                    id="total_qty"  value="{{ CommonHelper::get_product_name_by_id($gatepasses->product_id)->name }}">
                                  
                            </td>
                            <td><input type="number"
                                    class="form-control requiredField " disabled name="total_qty"
                                    id="total_qty"  value="{{$gatepasses->qty}}">
                            </td>
                            <td><input type="number"
                                    class="form-control requiredField " disabled name="recived_qty"
                                    id="qty1" value="{{$gatepasses->recived_qty}}">
                            </td>
                            <td ><textarea disabled type="text"
                                    class="form-control requiredField" name="description"
                                    id="rate1" >{{$gatepasses->description}}
                            </textarea>
                        
                        </tr>
                    </tbody>
                    
                   
                </table>
            </div>
        </div>
    </div>
   
    <div class="row" id="getProductSlabsDetail">

    </div>
    <hr>
   
</form>
</div>