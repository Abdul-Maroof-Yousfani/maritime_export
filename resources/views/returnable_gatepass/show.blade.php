<?php 
use App\Helpers\CommonHelper; 
$m = Session::get('run_company');
$currentDate = date('Y-m-d');
?>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right" style="float: right">
       
        <?php CommonHelper::displayPrintButtonInView('printDemandVoucherVoucherDetail', 'LinkHide', '1'); ?>
    </div>
</div>
<div style="line-height:5px;">&nbsp;</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="printDemandVoucherVoucherDetail">
    <div class="well">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label style="border-bottom:2px solid #000 !important;">Printed On Date&nbsp;:&nbsp;</label><label
                    style="border-bottom:2px solid #000 !important;"><?php echo CommonHelper::changeDateFormat(date('Y-m-d'));
                    $x = date('Y-m-d');
                    echo ' ' . '(' . date('D', strtotime($x)) . ')'; ?></label>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                <?php echo CommonHelper::get_company_logo(Session::get('run_company')); ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 style="text-align: center;">
                    <h3 style="text-align: center;">Gatepass {{$GatePassReturnable->gatepass_type == "returnable" ? '(Returnable)' : '(None Returnable)'}}</h3>
                    <h3 style="text-align: center;">{{ optional($GatePassReturnable->company_location)->location_name }}</h3>
                </h3>
            </div>
        </div>
        <div style="line-height:5px;">&nbsp;</div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div style="width:40%; float:left;">
                    <table class="table table-bordered table-striped table-condensed tableMargin">
                        <tbody>
                            <tr>
                                <td>Gatepass No :</td>
                                <td class="text-center"> {{$GatePassReturnable->gatepass_no }}</td>
                            </tr>
                            <tr>
                                <td>Vendor Name</td>
                                <td class="text-center">{{$GatePassReturnable->vendor_name }}</td>
                            </tr>
                            <tr>
                                <td>Warehouse Name :</td>
                                <td class="text-center"> {{$GatePassReturnable->warehouse_name }}</td>
                            </tr>
                            <tr>
                                <td>Builty No :</td>
                                <td class="text-center">{{$GatePassReturnable->builty_no }}</td>
                            </tr>
                            @if (count($GatePassReturnable->attachments) > 0)
                                <tr class="hidden-print">
                                    <td>Attachemnt</td>
                                    <td>
                                        @foreach ($GatePassReturnable->attachments as $attachment)
                                            <a href="{{ asset($attachment->image_src) }}" target="blank"
                                                class="btn btn-primary btn-xs">view</a>
                                        @endforeach
                                    </td>
                                </tr>
                            @endif
                        
                        </tbody>
                    </table>
                </div>
                <div style="width:40%; float:right;">
                    <table class="table table-bordered table-striped table-condensed tableMargin">
                        <tbody>
                            <tr>
                                <td>Date :</td>
                                <td class="text-center"> {{ date('d-m-Y', strtotime($GatePassReturnable->date )) }}</td>
                            </tr>
                            <tr>
                                <td>Ref / DC No</td>
                                <td class="text-center">{{$GatePassReturnable->ref_no }}</td>
                            </tr>
                            <tr>
                                <td>Ref Date :</td>
                                <td class="text-center"> {{ date('d-m-Y', strtotime($GatePassReturnable->ref_date )) }}</td>
                            </tr>
                            <tr>
                                <td>Vehicle No :</td>
                                <td class="text-center"> {{$GatePassReturnable->vehicle_no }}</td>
                            </tr>
                            <tr>
                                <td>Driver Name</td>
                                <td class="text-center">{{$GatePassReturnable->driver_name }}</td>
                            </tr>            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-condensed tableMargin">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px;">S.No</th>
                                <th class="text-center" style="width: 20%;">Item Name</th>
                                <th class="text-center">UOM </th>
                                <th class="text-center"> Qty</th>
                                <th class="text-center"> Department / Sub Department</th>
                                <th class="text-center"> Line No</th>
                                <th class="text-center">Line Description</th>
                                @if($GatePassReturnable->gatepass_type == 'returnable')
                                    <th class="text-center">Returnable Recieved</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($GatePassReturnable->returnable_data ?? [] as $key => $detail)
                                <tr class="text-center">
                                    <td class="text-center">{{ ++$key }}</td>
                                    <td>{{$detail->item }} </td>
                                    <td>{{$detail->uom }} </td>
                                    <td class="text-center">{{$detail->qty }} </td>
                                    <td class="text-center"> {{ optional($detail->department)->sub_department_name }}</td>
                                    <td>{{$detail->line_no }} </td>
                                    <td>{{$detail->line_description }} </td>
                                    @if($GatePassReturnable->gatepass_type == 'returnable')
                                        <td>
                                            @if ($detail->returnable_recieved)
                                                <p>{{$detail->recieving_user ?? ''}}</p>
                                                <p>{{$detail->recieving_date ?? ''}}</p>
                                            @else
                                               <button class="delete-modal btn btn-xs btn-danger" id="hide{{$detail->id}}" onClick="gatepass_partial_received({{ $detail->id }})">Returnable Received </button>
                                               <p id="name{{$detail->id}}" style="display: none"></p>
                                               <p id="date{{$detail->id}}" style="display: none"></p>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
    
                    </table>
                </div>
            </div>
            <div style="line-height:8px;">&nbsp;</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <span style=";font-size: 11px;resize: none" cols="100" rows="10"><?php echo 'Description:' . ' ' . strtoupper($GatePassReturnable->remarks); ?></span>
                    </div>
                </div>
               


            </div>
        </div>
      
        
    </div>
</div>
<script>
     function gatepass_partial_received(id) {
                // alert("Delete Working");
            if(confirm('Are u sure you want to Recieve this Returnable?')){
                $.ajax({
                    url: '{{ url('purchase/gatepass_partial_received') }}',
                    data: {
                        id: id
                    },
                    type: 'GET',
                    success: function(response) {
                        // alert(response);
                        if(response.status== true){
                            $('#name'+id).text(response.name);
                            $('#date'+id).text(response.date);
                            $('#hide'+id).hide();
                            $('#name'+id).show();
                            $('#date'+id).show();
                        }
                    }
                })
            }
        }
</script>