<?php
$m = Session::get('run_company');
use App\Helpers\StoreHelper;
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
?>
<div class="row" style="margin-top: 3%">
    {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label for="">Voucher No</label>
        <input type="text" readonly class="form-control"
            value="{{$wo}}">
    </div> --}}

    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <label for="">Voucher Date</label>
        <input type="date" class="form-control" id="voucher_date"
            name="voucher_date" value="<?php echo date('Y-m-d'); ?>">
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <label for="">Receipt serial no</label>
        <input type="text" name="receipt_serial_no"
            class="form-control requiredField " value="">
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <label class="sf-label">Department / Sub Department</label>
        <span class="rflabelsteric"><strong>*</strong></span>
        <select class="form-control requiredField select2"
            name="sub_department_id_1" id="sub_department_id_1">
            <option value="">Select Department</option>
            @foreach ($departments as $key => $y)
                <optgroup label="{{ $y->department_name }}"
                    value="{{ $y->id }}">
                    <?php
                    $subdepartments = DB::select('select `id`,`sub_department_name` from `sub_department` where `department_id` =' . $y->id . '');
                    ?>
                    @foreach ($subdepartments as $key2 => $y2)
                        <option value="{{ $y2->id }}" {{$material_request->department_id == $y2->id ? 'selected' : ''}} >
                            {{ $y2->sub_department_name }}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
    </div>
</div>
<div class="lineHeight">&nbsp;</div>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <label for="">Line</label>
        <select name="line_id" id="line_id" class="form-control select2">
            <option value="">Select Line</option>
            @foreach ($lines as $line)
                <option {{$material_request->line_id == $line->id ? 'selected' : ''}} value="{{ $line->id }}">{{ $line->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <label for="">Machinery</label>
        <select name="machinery_id" id="machinery_id"
            class="form-control select2">
            <option value="">Select Machinery</option>
            @foreach ($machineries as $machinery)
                <option {{$material_request->machine_id == $machinery->id ? 'selected' : ''}}  value="{{ $machinery->id }}">{{ $machinery->name }}
                </option>
            @endforeach
        </select>
    </div>
    {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <label for="">Charge</label>
        <input type="text" class="form-control" value="">
    </div> --}}
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <label class="sf-label">Company Location</label>
        <select class="form-control requiredField select2"
            name="company_location_id" id="company_location_id">
            <option value="">Select Location</option>
            @foreach (ReuseableCode::getUserWiseLocationRightsData() as $company_location)
                <option value="{{ $company_location['id'] }}"  {{$material_request->company_location_id == $company_location->id ? 'selected' : ''}}>
                    {{ $company_location['location_name'] }}</option>
            @endforeach
        </select>
    </div>
    <input type="hidden" name="material_id" id="material_id" value="{{$material_request->id}}">
    <input type="hidden" name="material_no" id="material_no" value="{{$material_request->mr_no}}">
    {{-- <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
        <label class="sf-label">Description</label>
        <span class="rflabelsteric"><strong>*</strong></span>
        <textarea name="description_1" id="description_1" rows="2" cols="50" style="resize:none;"
            class="form-control requiredField"></textarea>
    </div> --}}
</div>
<div class="lineHeight">&nbsp;</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label for="">Issuance Remarks</label>
        <textarea class="form-control" name="issuance_remarks" id="issuance_remarks" cols="5" rows="5">{{$material_request->remarks ?? ''}}</textarea>
    </div>
</div>
<div class="lineHeight">&nbsp;</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        {{-- <div class="text-right right">
            <input type="button" class="btn btn-sm btn-primary"
                onclick="AddMoreDetails()" value="Add More Rows" />
        </div> --}}
        <div style="text-align: center" class="table-responsive  text-center"
            id="">
            <table style="" class="table table-bordered well">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 400px;">Products
                            <span class="rflabelsteric"><strong>*</strong></span>
                        </th>
                        <th class="text-center" style="width: 250px;">UOM</th>
                        <th class="text-center" style="width: 250px;">Warehouse
                            <span class="rflabelsteric"><strong>*</strong></span>

                        </th>
                        <th class="text-center" style="width: 250px;">Batch Code
                        </th>
                        <th class="text-center" style="width: 250px;">In Stock</th>
                        <th class="text-center" style="width: 250px;">Requested Qty</th>
                        <th class="text-center" style="width: 400px;">Out</th>
                        <th class="text-center" style="width: 250px;">Replacement</th>
                        <th class="text-center" style="width: 400px;">ItemWise
                            Remarks</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="AppnedHtml">

                    @foreach ($material_request_data ?? [] as $key => $data)
                    <tr>
                        <td>
                            <select name="item_id[]" id="item_id{{$key}}"
                                onchange="itemChange({{$key}}); getStock({{$key}});"
                                class="form-control requiredField select2 item_id">
                                <option value="">Select Item</option>
                                  
                                    <option data-uom="{{ $data->uom }}" selected value="{{ $data->item_id }}"
                                       >
                                       {{ $data->item }}
                                    </option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" readonly
                                name="uom[]" value="{{$data->uom}}" id="uom{{$key}}">
                        </td>
                        <td>
                            <select name="warehouse_id[]" id="warehouse_id{{$key}}"
                                onchange="getStock({{$key}})"
                                class="form-control requiredField select2 " required>
                                <option value="">Select Warehouse</option>
                                @foreach (CommonHelper::get_users_warehouse() as $line)
                                    <option value="{{ $line->id }}" {{$line->id == $data->warehouse_id ? 'selected' : ''}}>
                                        {{ $line->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="batch_code[]" id="batch_code1"
                                onchange="get_stock_qty({{$key}})"
                                class="form-control select2">
                                <option value="">Select Batch Code</option>
                            </select>
                        </td>
                        <td>
                            <input type="text"
                                class="form-control requiredField" readonly
                                name="in_stock[]" id="instock{{$key}}" value="{{$data->stock_qty}}">
                        </td>
                        <td>
                            <input disabled type="number"
                                class="form-control requiredField" min="0"
                                step="any" value="{{$data->qty_requested}}" >
                        </td>
                        <td>
                            <input type="number"
                                class="form-control requiredField" min="0"
                                step="any" name="qty[]" id="qty{{$key}}">
                        </td>
                        <td>
                            <input type="number"
                                class="form-control requiredField" min="0"
                                step="any" value="0" name="replace_qty[]" id="replace_qty1">
                        </td>
                        <td>
                            <textarea class="form-control" name="item_remarks[]" id="item_remarks1" cols="5" rows="5">{{$data->material_description ?? ''}}</textarea>
                        </td>
                        <td>
                        </td>
                    </tr>
                    @endforeach
                   
                </tbody>
            </table>
            <div class="text-right right">
                <input type="button" class="btn btn-sm btn-primary hide"
                    onclick="AddMoreDetails()" value="Add More Rows" />
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}

</div>