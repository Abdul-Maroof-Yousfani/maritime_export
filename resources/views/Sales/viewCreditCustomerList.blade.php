<?php
$accType = Auth::user()->acc_type;
if($accType == 'client'){
    $m = $_GET['m'];
}else{
    $m = Auth::user()->company_id;
}
?>
@extends('layouts.default')

@section('content')
    <div class="well_N">
    <div class="dp_sdw">    
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="well">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span class="subHeadingLabelClass">View Credit Customer List
                                        <div class="text-right">
                                            <a class="btn btn-xs btn-primary" href="{{url('/sales/uploadCustomerDetail')}}">Upload Customer</a>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <th class="text-center">S.No</th>
                                                        
                                                            <th class="text-center">Customer Name</th>
                                                            <th class="text-center">Address</th>
                                                            <th class="text-center">Contact Person</th>
                                                            <th class="text-center">Contact No</th>

                                                            <th class="text-center">NTN NO</th>
                                                            <th class="text-center">STRN</th>
                                                            <th class="text-center">Email</th>
                                                            <th class="text-center">Action</th>
                                                            </thead>
                                                            <tbody id="viewCreditCustomerList">
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
    <script type="text/javascript">

        function CreateAccount(AccId,CustomerName,CustomerId)
        {
            $('#Btn'+CustomerId).prop('disabled',true);
            $.ajax({
                url: '<?php echo url('/')?>/sdc/createCustomerAccount',
                type: "GET",
                data:{AccId:AccId,CustomerName:CustomerName,CustomerId:CustomerId},
                success:function(data) {
                    alert(data);
                    $('#ShowHide'+CustomerId).html('Account Created');
                }
            });
        }

        $(document).ready(function() {
            function viewCreditCustomerList(){
                $('#viewCreditCustomerList').html('<tr><td colspan="5"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div></div></div></td><tr>');
                var m = '<?php echo $_GET['m'];?>';
                $.ajax({
                    url: '<?php echo url('/')?>/sdc/viewCreditCustomerList',
                    type: "GET",
                    data:{m:m},
                    success:function(data) {
                        setTimeout(function(){
                            $('#viewCreditCustomerList').html(data);
                        },1000);
                    }
                });
            }
            viewCreditCustomerList();
        });

        function CustomerDelete(id)
        {

            if (confirm('Are you sure you want to delete this customer? This will also delete associated accounts if no transactions exist.')) {
                $.ajax({
                    url: '{{url("/")}}/sdc/customer_delete',
                    type: 'Get',
                    data: {id: id},
                    dataType: 'json',
                    success: function (response)
                    {
                        if (response.success) {
                            alert(response.message || 'Customer deleted successfully');
                            $('#' + response.id).remove();
                        } else {
                            alert(response.message || 'Error deleting customer');
                        }
                    },
                    error: function(xhr) {
                        var errorMsg = 'Error deleting customer';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        alert(errorMsg);
                    }
                });
            }
            else{}
        }
    </script>
@endsection