<?php
$accType = Auth::user()->acc_type;
if($accType == 'client'){
    $m = $_GET['m'];
}else{
    $m = Auth::user()->company_id;
}

$Cusomter = DB::Connection('mysql2')->table('customers')->where('id',$id)->first();
$CustMore = DB::Connection('mysql2')->table('customer_info')->where('cust_id',$id)->get();
$States = DB::table('states')->where('country_id',$Cusomter->country)->get();
$Cities = DB::table('cities')->where('state_id',$Cusomter->province)->get();
?>
@extends('layouts.default')

@section('content')
    @include('select2')
    <div class="well">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="well_N">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span class="subHeadingLabelClass">Edit Credit Customer</span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="row">
                                                <?php echo Form::open(array('url' => 'sad/updateCreditCustomerDetail?m='.$m.'','id'=>'addCreditCustomerForm'));?>
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                {{--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
                                                    {{--<label>Account Head :</label>--}}
                                                    {{--<span class="rflabelsteric"><strong>*</strong></span>--}}
                                                    {{--<select onchange="get_nature_type()" name="account_head" id="account_id" class="form-control requiredField select2">--}}
                                                        {{--<option value="">Select Account</option>--}}
                                                        {{--@foreach($accounts as $key => $y)--}}
                                                            {{--<option value="{{ $y->code}}">{{ $y->code .' ---- '. $y->name}}</option>--}}
                                                        {{--@endforeach--}}
                                                    {{--</select>--}}
                                                {{--</div>--}}
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                    <label>Customer Name :</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <input type="text" name="customer_name" id="customer_name" value="<?php echo $Cusomter->name?>" class="form-control requiredField"  />
                                                    <input type="hidden" name="EditId" value="<?php echo $id?>">
                                                    <input type="hidden" name="AccId" value="<?php echo $Cusomter->acc_id?>">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 hide">
                                                    <label>Customer Code :</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <input type="text" name="customer_code" id="customer_code" value="<?php echo $Cusomter->customer_code?>" class="form-control" />
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                    <label>Country :</label>
                                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                                    <select name="country" id="country" class="form-control">
                                                                        <option value="">Select Country :</option>
                                                                        @foreach($countries as $key => $y)
                                                                            <option value="{{ $y->id}}" <?php if($y->id == $Cusomter->country): echo "selected"; endif;?>>{{ $y->name}}</option>
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
                                                                    <select name="state" id="state" class="form-control">
                                                                        @foreach($States as $key => $y)
                                                                            <option value="{{ $y->id}}" <?php if($y->id == $Cusomter->province): echo "selected"; endif;?>>{{ $y->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                    <label>City :</label>
                                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                                    <select name="city" id="city" class="form-control">
                                                                        @foreach($Cities as $key => $y)
                                                                            <option value="{{ $y->id}}" <?php if($y->id == $Cusomter->city): echo "selected"; endif;?>>{{ $y->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well" id="AppendHtml">
                                                    <div class="row">
                                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                            <label>Contact Person :</label>
                                                            <input  type="text" name="contact_person" id="contact_person" value="<?php echo $Cusomter->contact_person?>" class="form-control" />
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                            <label>Contact No :</label>
                                                            <input  type="text" name="contact_no" id="contact_no" value="<?php echo $Cusomter->contact?>" class="form-control" />
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 hide">
                                                            <label>Fax :</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <input  type="text" name="fax" id="fax" value="<?php echo $Cusomter->fax?>" class="form-control" />
                                                        </div>
                                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                            <label>Address :</label>
                                                            <input  type="text" name="address" id="address" value="<?php echo $Cusomter->address?>" class="form-control" />
                                                        </div>
                                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <button type="button" class="btn btn-xs btn-primary" id="BtnAddMore" onclick="AddMoreRows()" style="margin: 35px 0px 0px 0px; width: 50px; height: 25px;"> + </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $MCounter = 1;
                                                    foreach($CustMore as $CiFil):
                                                    ?>
                                                        <div class="row" id="RemoveRows<?php echo $MCounter?>">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Contact Person :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input  type="text" name="contact_person_more[]" id="contact_person_more<?php echo $MCounter?>" value="<?php echo $CiFil->contact_person?>" class="form-control" />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Contact No :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input  type="text" name="contact_no_more[]" id="contact_no_more<?php echo $MCounter?>" value="<?php echo $CiFil->contact_no?>" class="form-control" />
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Fax :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input  type="text" name="fax_more[]" id="fax_more<?php echo $MCounter?>" value="<?php echo $CiFil->fax?>" class="form-control" />
                                                            </div>
                                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                                <label>Address :</label>
                                                                <span class="rflabelsteric"><strong>*</strong></span>
                                                                <input  type="text" name="address_more[]" id="address_more<?php echo $MCounter?>" value="<?php echo $CiFil->address?>" class="form-control" />
                                                            </div>
                                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                    <button type="button" class="btn btn-xs btn-danger" id="BtnRemove" onclick="RemoveRows('<?php echo $MCounter?>')" style="margin: 35px 0px 0px 0px; width: 50px; height: 25px;"> &times; </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                        $MCounter++;
                                                    endforeach;?>
                                                    </div>

                                                </div>
                                                <div>&nbsp;</div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Email :</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <input type="email" name="email" id="email" value="<?php echo $Cusomter->email?>" class="form-control" />
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>NTN :</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <input type="text" name="ntn" id="ntn" value="<?php echo $Cusomter->cnic_ntn?>" class="form-control" />
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>STRN :</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <input type="text" name="strn" id="strn" value="<?php echo $Cusomter->strn?>" class="form-control" />
                                                        </div>

                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Term Of Paymet :</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <input type="number" name="term" id="term" value="<?php echo $Cusomter->terms_of_payment?>" class="form-control requiredField" />
                                                        </div>
                                                    </div>

                                                </div>

                                                <div>&nbsp;</div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                                    <button type="reset" id="reset" class="btn btn-primary">Clear Form</button>

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
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        var MCounter = '<?php echo $MCounter?>';
        function AddMoreRows()
        {
            MCounter++;
            $('#AppendHtml').append('<div class="row" id="RemoveRows'+MCounter+'">' +
                    '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">' +
                    '<label>Contact Person :</label>' +
                    '<span class="rflabelsteric"><strong>*</strong></span>' +
                    '<input  type="text" name="contact_person_more[]" id="contact_person_more'+MCounter+'" value="" class="form-control" />' +
                    '</div>' +
                    '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">' +
                    '<label>Contact No :</label>' +
                    '<span class="rflabelsteric"><strong>*</strong></span>' +
                    '<input  type="text" name="contact_no_more[]" id="contact_no_more'+MCounter+'" value="" class="form-control" />' +
                    '</div>' +
                    '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 hide">' +
                    '<label>Fax :</label>' +
                    '<span class="rflabelsteric"><strong>*</strong></span>' +
                    '<input  type="text" name="fax_more[]" id="fax_more'+MCounter+'" value="" class="form-control" />' +
                    '</div>' +
                    '<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">' +
                    '<label>Address :</label>' +
                    '<span class="rflabelsteric"><strong>*</strong></span>' +
                    '<input  type="text" name="address_more[]" id="address_more'+MCounter+'" value="" class="form-control" />' +
                    '</div>' +
                    '<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">' +
                    '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">' +
                    '<button type="button" class="btn btn-xs btn-danger" id="BtnRemove" onclick="RemoveRows('+MCounter+')" style="margin: 35px 0px 0px 0px; width: 50px; height: 25px;"> &times; </button>' +
                    '</div>'+
                    '</div>' +
                    '</div>');
        }

        function RemoveRows(Rows)
        {
            $('#RemoveRows'+Rows).remove();
        }
        $(document).ready(function() {
            $('.select2').select2();
            $('#country').select2();
            $('#state').select2();
            $('#city').select2();
            $(".btn-success").click(function(e)
            {
                var cashCustomer = new Array();
                var val;
                //$("input[name='chartofaccountSection[]']").each(function(){
                cashCustomer.push($(this).val());
                //});
                var _token = $("input[name='_token']").val();
                for (val of cashCustomer) {

                jqueryValidationCustom();
                if(validate == 0){
                    //return false;
                }else{
                    return false;
                }
            }
            });

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

        function get_nature_type()
        {
            var nature=  $("#account_id option:selected").text();
            nature=nature.split('-');
            nature=nature[0];
            if (nature==1 ||  nature==4)
            {
                $('#o_blnc_trans').val(1);
            }

            else
            {
                $('#o_blnc_trans').val(0);
            }
        }
    </script>
    <script src="{{URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection