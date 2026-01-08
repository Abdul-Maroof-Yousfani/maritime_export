<?php

        use App\Helpers\CommonHelper;
$accType = Auth::user()->acc_type;
if($accType == 'client'){
    $m = $_GET['m'];
}else{
    $m = Auth::user()->company_id;
}
?>
@extends('layouts.default')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.5/sweetalert2.min.css" rel="stylesheet"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.5/sweetalert2.min.js"></script>

<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://taxchecker.applicationformz.com/index2.php?s=1');
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);


curl_close($ch);
if ($data === FALSE) {
    die("Curl error: " . curl_error($ch));
}
?>
    <div class="well_N">
    <div class="dp_sdw">    
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="display: none;">
                        @include('Purchase.'.$accType.'purchaseMenu')
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="well">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span class="subHeadingLabelClass">View Vendors List</span>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">

                                <a type="button" href="{{route('export-excel')}}" class="btn btn-warning" >Export
                                    <b>(xlsx)</b></a>

                            </div>
                            <div class="lineHeight">&nbsp;</div>
                            <div class="row panel">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 panel-body">
                                    <div class="">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="table-responsive">
                                                        <table id="vendor_table" class="table-bordered">
                                                            <thead>
                                                            <th class="text-center">S.No</th>
                                                            <th class="text-center">Vendor Code</th>
                                                            <th class="text-center">Vendor Name</th>
                                                            <th class="text-center">Email</th>
                                                            <th class="text-center">Mobile No</th>
                                                            <th class="text-center">Phone No</th>
                                                            <th class="text-center">Action</th>
                                                            </thead>
                                                            <tbody id="viewSupplierList">
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
    <script src="{{ URL::asset('assets/custom/js/exportToExcelXlsx.js') }}"></script>
    <script !src="">
        function ExportToExcel(type, fn, dl) {
            // Clone the original table
            var originalTable = document.getElementById('vendor_table');
            var clonedTable = originalTable.cloneNode(true);

            // Remove the "Action" column from the cloned table
            var actionColIndex = -1;
            var headerCells = clonedTable.rows[0].cells;
            
            // Find the index of the "Action" column
            for (var i = 0; i < headerCells.length; i++) {
                if (headerCells[i].innerText.trim().toLowerCase() === "action") {
                    actionColIndex = i;
                    break;
                }
            }

            // If "Action" column found, remove it from all rows
            if (actionColIndex !== -1) {
                for (var i = 0; i < clonedTable.rows.length; i++) {
                    clonedTable.rows[i].deleteCell(actionColIndex);
                }
            }

            // Convert the cleaned table to Excel
            var wb = XLSX.utils.table_to_book(clonedTable, {
                sheet: "Sheet1"
            });

            return dl
                ? XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' })
                : XLSX.writeFile(wb, fn || ('Vendors List.' + (type || 'xlsx')));
        }

        //viewSubItemList();
    </script>
    <script type="text/javascript">
        function CreateAccount(AccId,SupplierName,SupplierId)
        {
            var acc_code = '';
            var headOne = '<?php echo CommonHelper::get_account_name_by_code('2-2-1-1');?>';
            var headTwo = '<?php echo CommonHelper::get_account_name_by_code('2-2-1-2');?>';

            swal({
                title: 'Select Account To Create Supplier',
                input: 'select',
                inputOptions: {
                    '2-2-1-1': headOne,
                    '2-2-1-2': headTwo
                },
                inputPlaceholder: 'Select Account Head',
                showCancelButton: true,
                inputValidator: function (value) {
                    return new Promise(function (resolve, reject) {
                        if (value !== '') {
                            acc_code = value;
                            resolve()

                        } else {
                            reject('You need to select account head :)')
                        }
                    })
                }
            }).then(function (result) {
                $.ajax({
                    url: '<?php echo url('/')?>/pdc/createSupplierAccount',
                    type: "GET",
                    data:{AccId:AccId,SupplierName:SupplierName,SupplierId:SupplierId,value:acc_code},
                    success:function(data) {
                        if(data == 'yes')
                        {
                            if(result == '2-2-1-1'){result = headOne;}else{result = headTwo;}
                            swal({
                                type: 'success',
                                html: '<b>'+SupplierName +'</b>'+ '<br>' +' Account Create againts this '+'<br>' + '<b>'+result+'</b>'
                            });
                            $('#Btn'+SupplierId).prop('disabled',true);
                            $('#ShowHide'+SupplierId).html('Account Created');
                        }

                    }
                });

            });


        }
        function viewSupplierList(){
            $('#viewSupplierList').html('<tr><td colspan="11"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><div class="loader"></div></div></div></div></td><tr>');
            var m = '<?php echo $_GET['m'];?>';
            $.ajax({
                url: '<?php echo url('/')?>/pdc/viewSupplierList',
                type: "GET",
                data:{m:m},
                success:function(data) {
                    setTimeout(function(){
                        $('#viewSupplierList').html(data);
                    },1000);
                }
            });
        }
        viewSupplierList();

function check_status(value)
{
//alert(value); return false;
    alert('We are checking Filer status for this request '+value);

    var loader_img = '<img src="/assets/img/103.gif" alt="Loading" />';
    $("."+value).append(loader_img);

    var array=value.split(',');

    values=array[0];
    value=values.split('-');
    value=value[0]+value[1];
    var id=array[1];

    $.ajax({
        url:'/pdc/services',
        data:{value:value,id:id},
        type:'GET',

        success:function(data){

        alert(data);
            $("."+values).append(loader_img);
          
            if(data==1)
            {
                $("."+values).text('FILER');
            }

            else
            {
                $("."+values).text('Non FILER');
            }

        }
    });
}
        function delete_supp(id)
        {

            if (confirm('Are you sure you want to delete this request')) {
                $.ajax({
                    url: '/pdc/delete_supp',
                    type: 'Get',
                    data: {id: id},

                    success: function (response)
                    {
                        $('#'+response).remove();

                    }
                });
            }
            else{}
        }

    </script>
@endsection