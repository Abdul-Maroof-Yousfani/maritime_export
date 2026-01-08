<?php
use App\Helpers\ReuseableCode;
$accType = Auth::user()->acc_type;

if($accType == 'client'){
    $m = $_GET['m'];
}else{
    $m = Auth::user()->company_id;
}
$current_date = date('Y-m-d');
$currentMonthStartDate = date('Y-m-01');
$currentMonthEndDate   = date('Y-m-t');
?>

@extends('layouts.default')

@section('content')
    <div class="well">
        <div class="panel">
            <div class="panel-body">
                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="well_N">
                        <div class="dp_sdw">    
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span class="subHeadingLabelClass">Create Purchase Order Form</span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <input type="hidden" name="functionName" id="functionName" value="stdc/filterApproveDemandListandCreatePurchaseRequest" readonly="readonly" class="form-control" />
                            <input type="hidden" name="divId" id="divId" value="filterApproveDemandListandCreatePurchaseRequest" readonly="readonly" class="form-control" />
                            <input type="hidden" name="m" id="m" value="<?php echo $m?>" readonly="readonly" class="form-control" />
                            <input type="hidden" name="baseUrl" id="baseUrl" value="<?php echo url('/')?>" readonly="readonly" class="form-control" />
                            <input type="hidden" name="pageType" id="pageType" value="1" readonly="readonly" class="form-control" />
                            <input type="hidden" name="parentCode" id="parentCode" value="<?php echo $_GET['parentCode'];?>" readonly="readonly" class="form-control" />

                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 hide">
                                    <label class="sf-label">Department / Sub Department</label>
                                    <span class="rflabelsteric"><strong>*</strong></span>
                                    <select class="form-control requiredField" name="paramOne" id="paramOne">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $key => $y)
                                            <optgroup label="{{ $y->department_name}}" value="{{ $y->id}}">
                                                <?php
                                                $subdepartments = DB::select('select `id`,`sub_department_name` from `sub_department` where `company_id` = '.$m.' and `department_id` ='.$y->id.'');
                                                ?>
                                                @foreach($subdepartments as $key2 => $y2)
                                                    <option value="{{ $y2->id}}">{{ $y2->sub_department_name}}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <label>From Date :</label>
                                    <span class="rflabelsteric"><strong>*</strong></span>
                                    <input type="Date" name="fromDate" id="fromDate" max="<?php echo $current_date;?>" value="<?php echo date('2022-07-01');?>" class="form-control" />
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-center"><label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type="text" readonly class="form-control text-center" value="Between" /></div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <label>To Date :</label>
                                    <span class="rflabelsteric"><strong>*</strong></span>
                                    <input type="Date" name="toDate" id="toDate" max="<?php echo $current_date;?>" value="<?php echo $currentMonthEndDate;?>" class="form-control" />
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <label class="sf-label">Company Location<span
                                            class="rflabelsteric"><strong>*</strong></span></label>
                                    <select name="company_location" class="form-control select2" required
                                        id="company_location" placeholder="Select Company Location">
                                        {{-- <option value="">Select any Location</option> --}}
                                        @foreach (ReuseableCode::getUserWiseLocationRightsData() as $company_location)
                                            <option value="{{ $company_location->id }}" @if(Session::get('run_company') == 8 && $company_location->id == 3) selected @endif> {{ $company_location->location_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <label>Comparative NO#</label>
                                    <input type="number" name="group_number" id="group_number" class="form-control" />
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 text-right">
                                    <input type="button" value="Search" class="btn btn-sm btn-danger" onclick="viewDataFilterOneParameter();" style="margin-top: 32px;" />
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div id="filterApproveDemandListandCreatePurchaseRequest"></div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ URL::asset('assets/custom/js/customStoreFunction.js') }}"></script>
@endsection