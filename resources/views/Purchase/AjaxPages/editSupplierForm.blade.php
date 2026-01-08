<?php
use App\Helpers\CommonHelper;
use App\Helpers\PurchaseHelper;
//$m = $_GET['m'];

$id =$id;
$supplierDetail = DB::Connection('mysql2')->table('supplier')->where('id', '=', $id)
        ->first(['name', 'id', 'company_name','email','country','province','city','resgister_income_tax',
                'business_type','cnic','ntn','register_sales_tax','strn','register_pra','pra','terms_of_payment'
                ,'register_srb','srb','print_check_as','vendor_type','website','credit_limit',
                'acc_no','bank_name','branch_name','bank_address','swift_code','opening_bal_date']);

$supplier_info=DB::Connection('mysql2')->table('supplier_info')->where('supp_id', '=', $id)->select('*')
        ->get();
?>
@extends('layouts.default')

@section('content')
    @include('number_formate')
    @include('select2')
<div class="well_N">
<div class="dp_sdw">    
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <span class="subHeadingLabelClass">Edit Supplier Detail</span>
        </div>
    </div>
    <div class="lineHeight">&nbsp;</div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <?php $m=1;

                        ?>
                        <?php echo Form::open(array('url' => 'pad/editSupplierDetail?m='.$m.'','id'=>'editSupplierForm'));?>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="supplier_id" value="<?php echo $id?>">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Name :</label>
                            <span class="rflabelsteric"><strong>*</strong></span>
                            <input type="text" name="name" id="name" value="<?php echo $supplierDetail->name; ?>" class="form-control requiredField" />
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Company Name :</label>
                            <span class="rflabelsteric"><strong>*</strong></span>
                            <input type="text" name="company_name" id="company_name" value="<?php echo $supplierDetail->company_name; ?>" class="form-control requiredField" />
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label>Country :</label>
                                            <span class="rflabelsteric"><strong>*</strong></span>
                                            <select name="country" id="country" class="form-control requiredField">
                                                <option value="">Select Country :</option>
                                                @foreach($countries as $key => $y)
                                                    <option @if($supplierDetail->country== $y->id)selected @endif value="{{$y->id}}">{{ $y->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label>State :</label>
                                            <span class="rflabelsteric"><strong>*</strong></span>
                                            <select name="state" id="state" class="form-control requiredField">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label>City :</label>
                                            <span class="rflabelsteric"><strong>*</strong></span>
                                            <select name="city" id="city" class="form-control requiredField">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                            <div>&nbsp;</div>
                            <div class="container-fluid well">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="AppendHtml">
                                <?php $Counter = 1;
                                $ContactPerson = "";
                                $ContactNo= "";
                                $Fax = "";
                                $Address = "";
                                $WorkPhone = "";
                                if(count($supplier_info) > 0):
                                foreach($supplier_info as $fil):

                                    if($fil->contact_person !=""): $ContactPerson = $fil->contact_person; else: $ContactPerson = ''; endif;
                                    if($fil->contact_no !=""): $ContactNo = $fil->contact_no; else: $ContactNo = ''; endif;
                                if($fil->fax !=""): $Fax = $fil->fax; else: $Fax = ''; endif;
                                if($fil->address !=""): $Address = $fil->address; else: $Address = ''; endif;
                                if($fil->work_phone !=""): $WorkPhone = $fil->work_phone; else: $WorkPhone = ''; endif;
                                ?>
                                <div class="row" id="RemoveRows<?php echo $Counter?>">
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Contact Person :</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <input  type="text" name="contact_person[]" id="contact_person<?php echo $Counter?>" value="<?php echo $ContactPerson?>" class="form-control" />
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Contact No :</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <input  type="text" name="contact_no[]" id="contact_no<?php echo $Counter?>" value="<?php echo $ContactNo?>" class="form-control" />
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Fax :</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <input  type="text" name="fax[]" id="fax<?php echo $Counter?>" value="<?php echo $Fax?>" class="form-control" />
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label>Address :</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <input  type="text" name="address[]" id="address<?php echo $Counter?>" value="<?php echo $Address?>" class="form-control" />
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Work Phone:</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <input  type="text" name="work_phone[]" id="work_phone<?php echo $Counter?>" value="<?php echo $WorkPhone?>" class="form-control" />
                                        <?php if($Counter > 1):?>
                                            <button type="button" class="btn btn-xs btn-danger pull-right" id="BtnRemove" onclick="RemoveRows('<?php echo $Counter?>')" style="width: 50px; height: 25px;"> &times; </button>
                                        <?php endif;?>
                                    </div>
                                </div>
                                <?php
                                    $Counter++;
                                    endforeach;
                                        else:
                                    ?>
                                    <div class="row" id="RemoveRows<?php echo $Counter?>">
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <label>Contact Person :</label>
                                            <span class="rflabelsteric"><strong>*</strong></span>
                                            <input  type="text" name="contact_person[]" id="contact_person1" value="" class="form-control" />
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <label>Contact No :</label>
                                            <span class="rflabelsteric"><strong>*</strong></span>
                                            <input  type="text" name="contact_no[]" id="contact_no1" value="" class="form-control" />
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <label>Fax :</label>
                                            <span class="rflabelsteric"><strong>*</strong></span>
                                            <input  type="text" name="fax[]" id="fax1" value="" class="form-control" />
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <label>Address :</label>
                                            <span class="rflabelsteric"><strong>*</strong></span>
                                            <input  type="text" name="address[]" id="address1" value="" class="form-control" />
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <label>Work Phone:</label>
                                            <span class="rflabelsteric"><strong>*</strong></span>
                                            <input  type="text" name="work_phone[]" id="work_phone1" value="" class="form-control" />
                                        </div>
                                    </div>
                                <?php endif;?>
                            </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                    <button type="button" class="btn btn-xs btn-primary" id="BtnAddMore" onclick="AddMoreRows()" style="margin: 35px 0px 0px 0px; width: 50px; height: 25px;"> + </button>
                                </div>
                            </div>

                            <div>&nbsp;</div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 input_fields_wrap">
                                        <label>Print Check As :</label>
                                        <input  type="text" name="print_check_as" id="print_check_as" value="{{$supplierDetail->print_check_as}}" class="form-control" />
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label>Email :</label>

                                        <input type="email" name="email" id="email" value="{{$supplierDetail->email}}" class="form-control" />
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label>Terms Of Payment:</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <input  type="number" name="term" id="term" value="<?php echo $supplierDetail->terms_of_payment?>" class="form-control requiredField" />
                                    </div>

                                    {{--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">--}}
                                        {{--<label>Vendor Type :</label>--}}
                                        {{--<span class="rflabelsteric"><strong>*</strong></span>--}}
                                        {{--<select   name="vendor_type" id="vendor_type"  class="form-control requiredField">--}}

                                            {{--<option value="0">SELECT</option>--}}
                                            {{--<option value="0">{{strtoupper('outside services/professional fees')}}</option>--}}


                                            {{--<option @if($supplierDetail->vendor_type==1)selected @endif value="1">{{strtoupper('advertising/marketing/promotion')}}</option>--}}
                                            {{--<option @if($supplierDetail->vendor_type==2)selected @endif value="2">{{strtoupper('rent and occupancy related')}}</option>--}}
                                            {{--<option @if($supplierDetail->vendor_type==3)selected @endif value="3">{{strtoupper('supplies')}}</option>--}}
                                            {{--<option @if($supplierDetail->vendor_type==4)selected @endif value="4">{{strtoupper('taxes and licenses')}}</option>--}}
                                            {{--<option @if($supplierDetail->vendor_type==5)selected @endif value="5">{{strtoupper('employee fringe benefits')}}</option>--}}
                                            {{--<option @if($supplierDetail->vendor_type==6)selected @endif value="6">{{strtoupper('utilities')}}</option>--}}
                                            {{--<option @if($supplierDetail->vendor_type==7)selected @endif value="7">{{strtoupper('travel and entertainment')}}</option>--}}
                                            {{--<option @if($supplierDetail->vendor_type==8)selected @endif value="8">{{strtoupper('insurance')}}</option>--}}
                                            {{--<option @if($supplierDetail->vendor_type==9)selected @endif value="9">{{strtoupper('security')}}</option>--}}
                                            {{--<option @if($supplierDetail->vendor_type==10)selected @endif value="10">{{strtoupper('auto')}}</option>--}}


                                        {{--</select>--}}

                                    {{--</div>--}}



                                </div>
                            </div>

                            <div>&nbsp;</div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 input_fields_wrap_address">
                                        <label>Website :</label>


                                        <input  type="text" name="website" id="website" value="{{$supplierDetail->website}}" class="form-control" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 input_fields_wrap">
                                        <label>Credit Limit :</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>


                                        <input  type="text" name="credit_limit" id="credit_limit" value="{{$supplierDetail->credit_limit}}" class="form-control requiredField" />
                                    </div>





                                </div>
                            </div>


                            <div>&nbsp;</div>

                            <div class="well">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <span class="subHeadingLabelClass"><input id="bank_detail" type="checkbox"> Bank Details </input>  </span>
                                    </div>

                                    <div id=""  class="col-lg-12 col-md-12 col-sm-12 col-xs-12 banks">
                                        <div class="row">

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 input_fields_wrap_address">
                                                <label>Bank Acc. No :</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>

                                                <input  type="text" name="acc_no" id="acc_no" value="{{$supplierDetail->acc_no}}" class="form-control " />
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 input_fields_wrap">
                                                <label>Bank Name :</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>


                                                <input  type="text" name="bank_name" id="bank_name" value="{{$supplierDetail->bank_name}}" class="form-control " />
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 input_fields_wrap">
                                                <label>Branch  Name :</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>


                                                <input  type="text" name="branch_name" id="branch_name" value="{{$supplierDetail->branch_name}}" class="form-control " />
                                            </div>




                                        </div>
                                    </div>

                                    <div id=""  class="col-lg-12 col-md-12 col-sm-12 col-xs-12 banks">
                                        <div class="row">

                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 input_fields_wrap_address">
                                                <label>Bank Address :</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>

                                                <input  type="text" name="bank_address" id="bank_address" value="{{$supplierDetail->bank_address}}" class="form-control " />
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 input_fields_wrap">
                                                <label>Swift Code :</label>
                                                <span class="rflabelsteric"><strong>*</strong></span>


                                                <input  type="text" name="swift_code" id="swift_code" value="{{$supplierDetail->swift_code}}" class="form-control" />
                                            </div>





                                        </div>
                                    </div>
                                </div>
                            </div>


                        <?php   //register income criteria ?>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 checkbox">
                                    <label>
                                        <input
                                                type="checkbox"
                                                id="regd_in_income_tax"
                                                name="regd_in_income_tax"
                                                value="1"
                                                @if($supplierDetail->resgister_income_tax==1) checked  @endif

                                                />
                                        <input  type="hidden" value="set" name="hidden" />
                                        <b class="smr-text-cgreen"> Registered In Income Tax?</b>
                                    </label>
                                </div>


                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" id="income_tax_div" style="display:none">
                                    <div class="panel panel-primary panel-body well" data-collapsed="0" >
                                        <label class="radio-inline">
                                            <input class="" @if($supplierDetail->business_type==1)  checked="checked" @endif type="radio"   onclick="ntn_cnic('1')"    name="optradiooo" class="income" id="business"   value="1" >Business Individual
                                        </label>
                                        <label class="radio-inline">
                                            <input class="" @if($supplierDetail->business_type==2)  checked="checked" @endif onclick="ntn_cnic('2')" type="radio"   name="optradiooo" class="income" id="company" value="2">Company
                                        </label>
                                        <label class="radio-inline">
                                            <input class="" @if($supplierDetail->business_type==3)  checked="checked" @endif onclick="ntn_cnic('3')" type="radio"   name="optradiooo" class="income" id="aop" value="3">Aop
                                        </label>
                                    </div>
                                </div>




                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div id="amir" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 checkbox">


                                    <input value="{{$supplierDetail->ntn}}" style="display: none;" placeholder="NTN" type="text" name="ntn" class="form-control" id="ntn"/>

                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 checkbox">


                                    <input value="{{$supplierDetail->cnic}}" style="display: none;margin-top: 15px" placeholder="CNIC" type="text" name="cnic" class="form-control" id="cnic"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 checkbox">
                                    <label>
                                        <input @if($supplierDetail->register_sales_tax==1)  checked="checked" @endif type="checkbox" id="regd_in_sales_tax" name="regd_in_sales_tax" value="1" />
                                        <input type="hidden" value="set" name="hidden" />
                                        <b class="smr-text-cgreen">Registered In Sales Tax?</b>
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" id="sales_tax_div" style="display:none">
                                    <div class="panel panel-primary panel-body well" data-collapsed="0">
                                        <label for="strn">STRN </label>
                                        <span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span>
                                        <input type="text"
                                               min="0"
                                               maxlength="15"

                                               placeholder="STRN"
                                               maxlength="18"
                                               min="0"
                                               class="form-control sf-uc-first text-right"
                                               id="strn"
                                               name="strn"
                                               value="{{$supplierDetail->strn}}" />
                                        <?php  ;?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 checkbox">
                                    <label>
                                        <input
                                                @if($supplierDetail->register_srb==1)  checked="checked" @endif
                                        type="checkbox"
                                                id="regd_in_srb"
                                                name="regd_in_srb"
                                                value="1"
                                                />
                                        <input type="hidden" value="set" name="hidden" />
                                        <b class="smr-text-cgreen">Registered In SRB?</b>
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" id="sales_tax_srb" style="display:none">
                                    <div class="panel panel-primary panel-body well" data-collapsed="0">
                                        <label for="strn"> SRB</label>
                                        <span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span>
                                        <input type="text"
                                               min="0"
                                               maxlength="15"

                                               placeholder="SRB"
                                               maxlength="18"
                                               min="0"
                                               class="form-control sf-uc-first text-right"
                                               id="srb"
                                               name="srb"
                                               value="{{$supplierDetail->srb}}" />
                                        <?php  ;?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 checkbox">
                                    <label>
                                        <input
                                                @if($supplierDetail->register_pra==1)  checked="checked" @endif  type="checkbox"
                                                id="regd_in_pra"
                                                name="regd_in_pra"
                                                value="1"
                                                />
                                        <input  type="hidden" value="set" name="hidden" />
                                        <b class="smr-text-cgreen">Registered In PRA?</b>
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" id="sales_tax_pra" style="display:none">
                                    <div class="panel panel-primary panel-body well" data-collapsed="0">
                                        <label for="strn"> PRA</label>
                                        <span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span>
                                        <input type="text"
                                               min="0"
                                               maxlength="15"

                                               placeholder="PRA"
                                               maxlength="18"
                                               min="0"
                                               class="form-control sf-uc-first text-right"
                                               id="pra"
                                               name="pra"
                                               value="{{$supplierDetail->pra}}" />
                                        <?php  ;?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php    ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">

                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 input_fields_wrap_address">
                                    <label>Opening Date :</label>


                                    <input  type="date" name="open_date" id="open_date" value="{{$supplierDetail->opening_bal_date}}" class="form-control" />
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="o_blnc" >Opening Balance :</label>
                                    <span class="rflabelsteric"><strong>*</strong></span>
                                    <input  type="number" name="o_blnc" maxlength="15"  min="0" id="o_blnc" placeholder="Opening Balance" class="form-control requiredField"
                                            value="0" autocomplete="off"/>
                                </div>
                                <!--
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="o_blnc_trans">Transaction :</label>
                                    <span class="rflabelsteric"><strong>*</strong></span>
                                    <select name="o_blnc_trans" id="o_blnc_trans" class="form-control requiredField">
                                        <option value="">select</option>
                                        <option value="1"><strong>Debit</strong></option>
                                        <option value="0"><strong>Credit</strong></option>
                                    </select>
                                </div>
                                  <!-->
                            </div>
                        </div>

                        <div>&nbsp;</div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            {{ Form::button('Submit', ['class' => 'btn btn-success btn-success-edit']) }}
                            

                            <?php
                            //echo Form::submit('Click Me!');
                            ?>
                        </div>
                        <?php
                        echo Form::close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript"> $(document).ready(function() {



        var countryID = $('#country').val();

        if(countryID) {
            $.ajax({
                url: '<?php echo url('/')?>/slal/stateLoadDependentCountryId',
                type: "GET",
                data: { id:countryID},
                success:function(data) {

                    var state='<?php echo $supplierDetail->province ?>';
                    var city='<?php echo $supplierDetail->city ?>';
                    $('select[name="city"]').empty();
                    $('select[name="state"]').empty();

                    $('select[name="state"]').html(data);
                    $('#state').val(state);
                    var stateID = state;
                    if(stateID) {
                        $.ajax({
                            url: '<?php echo url('/')?>/slal/cityLoadDependentStateId',
                            type: "GET",
                            data: { id:stateID},
                            success:function(data) {
                                $('select[name="city"]').empty();
                                $('select[name="city"]').html(data);
                                $('#city').val(city);
                            }
                        });
                    }else{
                        $('select[name="city"]').empty();

                    }


                }
            });
        }else{
            $('select[name="state"]').empty();
            $('select[name="city"]').empty();
        }





        if ($('#regd_in_income_tax').is(':checked'))
        {

            $('.income').prop('checked', false);
            document.getElementById("income_tax_div").style.display = "block";
        } else {

            document.getElementById("income_tax_div").style.display = "none";
            $("#cnic").css("display", "none");
            $("#ntn").css("display", "none");
            $('#ntn').val("");
        }

        var ntn_cnic_param='<?php echo $supplierDetail->business_type; ?>';
        if (ntn_cnic_param!=0)
        {
            ntn_cnic(ntn_cnic_param);
        }


        if ($('#regd_in_sales_tax').is(':checked'))
        {
            document.getElementById("sales_tax_div").style.display = "block";
            $("#strn").addClass("requiredField");
        } else {
            document.getElementById("sales_tax_div").style.display = "none";
            $('#strn').val("");
            $("#strn").removeClass("requiredField");
        }

        if ($('#regd_in_srb').is(':checked'))
        {
            document.getElementById("sales_tax_srb").style.display = "block";
            $("#srb").addClass("requiredField");
        } else {
            document.getElementById("sales_tax_srb").style.display = "none";
            //  $('#srb').val("");
            $("#srb").removeClass("requiredField");
        }




        if ($('#regd_in_pra').is(':checked'))
        {
            document.getElementById("sales_tax_pra").style.display = "block";
            $("#pra").addClass("requiredField");
        } else {
            document.getElementById("sales_tax_pra").style.display = "none";
            $('#pra').val("");
            $("#pra").removeClass("requiredField");
        }


        $(".btn-success-edit").click(function(e){
            var supplier = new Array();
            var val;
            supplier.push($(this).val());
            var _token = $("input[name='_token']").val();
            for (val of supplier) {
                jqueryValidationCustom();
                if(validate == 0){
                    //return false;
                }else{
                    return false;
                }
            }
            $('form').submit();
        });


        function formSubmitOne(e){

            var postData = $('#editSupplierForm').serializeArray();
            var formURL = $('#editSupplierForm').attr("action");

            $.ajax({
                url : formURL,
                type: "POST",
                data : postData,
                success:function(data){
                    $('#showMasterTableEditModel').modal('toggle');
                    viewSupplierList();
                }
            });
        }

        $('select[name="country"]').on('change', function() {
            var countryID = $(this).val();
            if(countryID) {
                $.ajax({
                    url: '<?php echo url('/')?>/slal/stateLoadDependentCountryId',
                    type: "GET",
                    data: { id:countryID},
                    success:function(data) {
                        $('select[name="city"]').empty();
                        $('select[name="state"]').empty();
                        $('select[name="state"]').html(data);
                    }
                });
            }else{
                $('select[name="state"]').empty();
                $('select[name="city"]').empty();
            }
        });

        $('select[name="state"]').on('change', function() {
            var stateID = $(this).val();
            if(stateID) {
                $.ajax({
                    url: '<?php echo url('/')?>/slal/cityLoadDependentStateId',
                    type: "GET",
                    data: { id:stateID},
                    success:function(data) {
                        $('select[name="city"]').empty();
                        $('select[name="city"]').html(data);
                    }
                });
            }else{
                $('select[name="city"]').empty();
            }
        });
    });

    function ntn_cnic(id)
    {
        if(id==1)
        {

            $(this).prop('checked', false);
            $("#ntn").fadeIn(500);
            $("#cnic").fadeIn(500);
            $("#amir").removeClass("col-lg-12 col-md-12 col-sm-12 col-xs-12");
            $("#amir").addClass("col-lg-6 col-md-6 col-sm-6 col-xs-12");
            $("#ntn").addClass("requiredField");
            $("#cnic").addClass("requiredField");
        }

        else
        {

            $("#ntn").fadeIn(500);
            $("#ntn").addClass("requiredField");
            $("#cnic").css("display", "none");
            $("#cnic").removeClass("requiredField");
            $("#amir").removeClass("col-lg-6 col-md-6 col-sm-6 col-xs-12");
            $("#amir").addClass("col-lg-12 col-md-12 col-sm-12 col-xs-12");

        }
    }


    $('#regd_in_income_tax').change(function(){
        if ($(this).is(':checked'))
        {
            var ntn_cnic_param='<?php echo $supplierDetail->business_type; ?>';
            if (ntn_cnic_param!=0) {
                ntn_cnic(ntn_cnic_param);
            }

            $('.income').prop('checked', false);
            document.getElementById("income_tax_div").style.display = "block";
        } else {
            document.getElementById("income_tax_div").style.display = "none";
            $("#cnic").css("display", "none");
            $("#ntn").css("display", "none");
            //  $('#ntn').val("");
        }
    });


    $('#regd_in_sales_tax').change(function(){
        if ($(this).is(':checked'))
        {

            document.getElementById("sales_tax_div").style.display = "block";
            $("#strn").addClass("requiredField");
        } else
        {
            document.getElementById("sales_tax_div").style.display = "none";
            //  $('#strn').val("");
            $("#strn").removeClass("requiredField");
        }
    });

    $('#regd_in_srb').change(function(){
        if ($(this).is(':checked'))
        {
            document.getElementById("sales_tax_srb").style.display = "block";
            $("#srb").addClass("requiredField");
        } else {
            document.getElementById("sales_tax_srb").style.display = "none";
            //  $('#srb').val("");
            $("#srb").removeClass("requiredField");
        }
    });


    $('#regd_in_pra').change(function(){
        if ($(this).is(':checked'))
        {
            document.getElementById("sales_tax_pra").style.display = "block";
            $("#pra").addClass("requiredField");
        } else {
            document.getElementById("sales_tax_pra").style.display = "none";
            //   $('#pra').val("");
            $("#pra").removeClass("requiredField");
        }
    });





    var MCounter = '<?php echo $Counter?>';
    function AddMoreRows()
    {
        MCounter++;
        $('#AppendHtml').append('<div class="row" id="RemoveRows'+MCounter+'">' +
                '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">' +
                '<label>Contact Person :</label>' +
                '<span class="rflabelsteric"><strong>*</strong></span>' +
                '<input  type="text" name="contact_person[]" id="contact_person'+MCounter+'" value="" class="form-control" />' +
                '</div>' +
                '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">' +
                '<label>Contact No :</label>' +
                '<span class="rflabelsteric"><strong>*</strong></span>' +
                '<input  type="text" name="contact_no[]" id="contact_no'+MCounter+'" value="" class="form-control" />' +
                '</div>' +
                '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">' +
                '<label>Fax :</label>' +
                '<span class="rflabelsteric"><strong>*</strong></span>' +
                '<input  type="text" name="fax[]" id="fax'+MCounter+'" value="" class="form-control" />' +
                '</div>' +
                '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">' +
                '<label>Address :</label>' +
                '<span class="rflabelsteric"><strong>*</strong></span>' +
                '<input  type="text" name="address[]" id="address'+MCounter+'" value="" class="form-control" />' +
                '</div>' +
                '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">' +
                '<label>Work Phone:</label>' +
                '<span class="rflabelsteric"><strong>*</strong></span>' +
                '<input  type="text" name="work_phone[]" id="work_phone1" value="" class="form-control" />' +
                '<button type="button" class="btn btn-xs btn-danger pull-right" id="BtnRemove" onclick="RemoveRows('+MCounter+')" style="width: 50px; height: 25px;"> &times; </button>' +
                '</div>' +
                '</div>');
    }

    function RemoveRows(Rows)
    {
        $('#RemoveRows'+Rows).remove();
    }

    $(document).ready(function() {


    });


    $('#bank_detail').change(function(){
        if ($(this).is(':checked'))
        {

            $(".banks").css("display", "block");
            $(".required").addClass("requiredField");

            //   $("#pra").addClass("requiredField");
        } else {
            $(".banks").css("display", "none");
            $(".required").removeClass("requiredField");
            //  $('#pra').val("");
            // $("#pra").removeClass("requiredField");
        }
    });

</script>

    <script type="text/javascript">
        $('#account_head').select2();
        $('#vendor_type').select2();
        $('#country').select2();
        $('#state').select2();
        $('#city').select2();
    </script>
@endsection