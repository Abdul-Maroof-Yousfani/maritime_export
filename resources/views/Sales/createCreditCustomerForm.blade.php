<?php
$accType = Auth::user()->acc_type;
$m=Session::get('run_company');
?>
@extends('layouts.default')

@section('content')
    @include('select2')
    <div class="well_N">
    <div class="dp_sdw">    
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="well">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span class="subHeadingLabelClass">Add New Credit Customer</span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="row">
                                                <?php echo Form::open(array('url' => 'sad/addCreditCustomerDetail?m='.$m.'','id'=>'addCreditCustomerForm'));?>
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="pageType" value="<?php echo $_GET['pageType']?>">
                                                <input type="hidden" name="parentCode" value="<?php echo $_GET['parentCode']?>">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <label>Type</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                   <select class="form-control" name="purchaser_type" id="">
                                                    <option value="">Select Type</option>
                                                    <option value="1">Local</option>
                                                    <option value="2" selected>Export </option>
                                                   </select>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display: none;">
                                                    <label>Account Head :</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>


                                                    <select onchange="get_nature_type()" name="account_head" id="account_id" class="form-control requiredField select2">

                                                        @if ($m==5)
                                                            <option value="1-2-3-1">Trade Debtors</option>
                                                            @else
                                                        <option value="">Select Account</option>
                                                        @foreach($accounts as $key => $y)
                                                            <option @if($y->code=='1-2-1-83') selected @endif value="{{ $y->code}}">{{ $y->code .' ---- '. $y->name}}</option>
                                                        @endforeach
                                                            @endif
                                                    </select>
                                                </div>
                                                <input type="hidden" name="account_head" value="1-2-1" id="account_head_hidden">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <label>Customer Name :</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <input type="text" name="customer_name" id="customer_name" value="" class="form-control requiredField" />
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 hide">
                                                    <label>Customer Code :</label>
                                                    <span class="rflabelsteric"><strong>*</strong></span>
                                                    <input type="text" name="customer_code" id="customer_code" value="" class="form-control" />
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
                                                                            <option   value="{{ $y->id}}">{{ $y->name}}</option>
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
                                                                        <option value=""></option>
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
                                                                        <option value=""></option>
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
                                                            <input  type="text" name="contact_person" id="contact_person" value="" class="form-control" />
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                            <label>Contact No :</label>
                                                            <input  type="text" name="contact_no" id="contact_no" value="" class="form-control" />
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 hide">
                                                            <label>Fax :</label>
                                                            <input  type="text" name="fax" id="fax" value="" class="form-control" />
                                                        </div>
                                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                            <label>Address :</label>
                                                            <input  type="text" name="address" id="address" value="" class="form-control" />
                                                        </div>
                                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <button type="button" class="btn btn-xs btn-primary" id="BtnAddMore" onclick="AddMoreRows()" style="margin: 35px 0px 0px 0px; width: 50px; height: 25px;"> + </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>&nbsp;</div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Email :</label>
                                                          
                                                            <input type="email" name="email" id="email" value="" class="form-control " />
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>NTN :</label>
                                                           
                                                            <input type="text" name="ntn" id="strn" value="" class="form-control " />
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>STRN :</label>
                                                          
                                                            <input type="text" name="strn" id="strn" value="" class="form-control " />
                                                        </div>

                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label>Term Of Paymet :</label>
                                                            <input type="number" name="term" id="term" value="" class="form-control" />
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <label for="o_blnc" >Opening Balance :</label>
                                                          
                                                            <input type="number" name="o_blnc" maxlength="15" min="0" id="o_blnc" placeholder="Opening Balance" class="form-control" value="0" autocomplete="off"/>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <label for="o_blnc_trans">Transaction :</label>
                                                            <span class="rflabelsteric"><strong>*</strong></span>
                                                            <select name="o_blnc_trans" id="o_blnc_trans" class="form-control requiredField">
                                                                <option value="">select</option>
                                                                <option value="1"><strong>Debit</strong></option>
                                                                <option value="0"><strong>Credit</strong></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>&nbsp;</div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                                    <button type="reset" id="reset" class="btn btn-danger">Clear Form</button>

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
    </div>
    <script type="text/javascript">

        var MCounter = 0;
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
            // Set account head to 1-1-1 and trigger nature type check
            $('#account_id').val('1-1-1');
            get_nature_type();
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
            // Since account head is always 1-1-1, check the first part
            var accountHead = $('#account_head_hidden').val() || '1-1-1';
            var nature = accountHead.split('-')[0];
            if (nature == 1 || nature == 4)
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