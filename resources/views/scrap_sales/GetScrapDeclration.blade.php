<?php
$m = Session::get('run_company');
use App\Helpers\StoreHelper;
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
?>
<style>
    <style>
        * {
            font-size: 12px !important;
            font-family: Arial;
        }

        .select2 {
            width: 100%;
        }
        .table-responsive .select2-container--default .select2-selection--single {
            width: 200px !important;
        }
    </style>
</style>
<div class="row" style="margin-top: 3%">
  
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label for="">Scrap Sale Date</label>
        <input type="date" class="form-control" id="voucher_date"
            name="ss_date" value="<?php echo date('Y-m-d'); ?>">
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label class="sf-label">Department / Sub Department</label>
        <span class="rflabelsteric"><strong>*</strong></span>
        <input type="hidden" name="department_id" id="department_id" value="{{$scrap_declration->department_id}}">
        <input disabled class="form-control"  value="{{optional($scrap_declration->department)->sub_department_name}}">
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label for="">Line</label>
        <input type="hidden" name="line_no" id="line_no" value="{{$scrap_declration->line_no}}">
        <input disabled class="form-control"  value="{{optional($scrap_declration->line)->name}}">
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label class="sf-label">Company Location</label>
        <input type="hidden" name="company_location_id" id="company_location_id" value="{{$scrap_declration->company_location_id}}">
        <input disabled class="form-control"  value="{{ optional($scrap_declration->company_location)->location_name }}">
    </div>
    <input type="hidden" name="scrap_id" id="scrap_id" value="{{$scrap_declration->id}}">
    <input type="hidden" name="scrap_no" id="scrap_no" value="{{$scrap_declration->sd_no}}">
</div>

<div class="lineHeight">&nbsp;</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label for="">Scrap Sale Remarks</label>
        <textarea class="form-control" name="ss_remarks" id="ss_remarks" cols="5" rows="5"></textarea>
    </div>
</div>
<div class="lineHeight">&nbsp;</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th colspan="3" class="text-center">
                            Item
                            Detail</th>
                        <th colspan="8" class="text-center hide">
                            <input type="button"
                                class="btn btn-sm btn-primary"
                                onclick="add_row()"
                                value="Add More Rows" />
                        </th>
                    </tr>
                    <tr>
                        {{-- <th class="text-center"
                            style="width: 2%;">S.NO
                        </th> --}}
                        <th class="text-center">
                            Scrap Category</th>
                        <th class="text-center">
                            Item Name</th>
                        <th class="text-center">Item Code </th>
                        <th class="text-center">Item Description </th>
                        <th class="text-center">UOM </th>
                        <th class="text-center">Qty # </th>
                        <th class="text-center">Balance # </th>
                        <th class="text-center">Unit Price # </th>
                        <th class="text-center">Total Price # </th>
                        <th class="text-center">Reason For Scrapping # </th>
                        <th>Remove</th>
                    </tr>
                </thead>
              
                <tbody id="AppnedHtml">

                    @foreach ($scrap_declration->ScrapData ?? [] as $key => $detail)
                        <tr class="cnt" id="removeSection{{$key}}">
                            <td>
                                <select style="width:200px !important;" name="category_id[]" id="category_id_{{$key}}" class="form-control requiredField select2">
                                    <option value="">Select Scrap Category</option>
                                    <option {{$detail->category_id == 'iron' ? 'selected' : ''}} value="iron">Iron</option>
                                    <option {{$detail->category_id == 'plastic' ? 'selected' : ''}} value="plastic">Plastic</option>
                                    <option {{$detail->category_id == 'copper' ? 'selected' : ''}} value="copper">Copper</option>
                                    <option {{$detail->category_id == 'steel' ? 'selected' : ''}} value="steel">Steel</option>
                                    <option {{$detail->category_id == 'paper' ? 'selected' : ''}} value="paper">Paper</option>
                                </select>
                            </td>
                            <td>
                                <select style="width:200px !important;" onchange="get_item_name({{$key}});" name="item[]" id="item_id_{{$key}}" class="form-control requiredField select2 item_id">
                                    <option value="">Select Item</option>
                                    <option value="{{CommonHelper::get_item_name($detail->item_id)}}%{{$detail->uom}}%0%{{$detail->item_id}}%{{$detail->item_code}}" selected>{{CommonHelper::get_item_name($detail->item_id)}}</option>
                                
                                </select>
                            </td>
                            <td><input style="width:200px!important;" type="text"
                                class="form-control " readonly name="item_code[]"
                                id="item_code_{{$key}}"  value="{{$detail->item_code}}">
                            </td>
                            <td><input style="width:200px!important;" type="text"
                                class="form-control " readonly name="item_desc[]"
                                id="item_desc_{{$key}}"  value="{{$detail->item_desc}}">
                            </td>
                            <td><input style="width:200px!important;" type="text"
                                    class="form-control " readonly name="uom[]"
                                    id="uom_{{$key}}"  value="{{$detail->uom}}">
                            </td>
                        
                            <td>
                                <input style="width:200px!important;" type="text" class="form-control requiredField " onkeyup="calc({{$key}})" name="qty[]" id="qty_{{$key}}"  value="">
                            </td>
                            <td>
                                <input style="width:200px!important;" readonly type="text" class="form-control requiredField "  name="balance[]" id="balance_{{$key}}"  value="{{$detail->qty}}">
                            </td>
                            <td>
                                <input style="width:200px!important;" type="text" class="form-control requiredField " onkeyup="calc({{$key}})"  name="rate[]" id="rate_{{$key}}"  value="">
                            </td>
                            <td>
                                <input style="width:200px!important;" readonly type="text" class="form-control requiredField "  name="total[]" id="total_{{$key}}"  value="">
                            </td>
                            <td>
                                <textarea style="width:200px!important;" class="form-control requiredField " name="reason_for_scrapping[]" id="reason_for_scrapping_{{$key}}">{{$detail->reason_for_scrapping}}</textarea>
                            </td>
                            
                        
                            <td><span style="cursor:pointer" disabled class="btn btn-danger btn-xs" onClick="removeSection({{$key}})">Remove</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                
               
            </table>
        </div>
    </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}

</div>
