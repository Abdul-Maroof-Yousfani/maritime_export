
<?php
use App\Helpers\CommonHelper;
use App\Helpers\ProductionHelper;

?>
<style>
    .modalWidth{
        width: 100%;
    }
</style>

    @include('modal')
    <?php

    ?>

    <div class="">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive well">
                    <?php $index=1; ?>
                    @foreach($plan_data as $row)
                    <table  class="table table-bordered sf-table-list">
                        <thead>

                        <h5>Finish Good : {{CommonHelper::get_item_name($row->finish_goods_id)}}</h5>
                        <tr>
                            <th class="text-center" style="width: 30%">Product Name</th>
                            <th class="text-center" style="">Planned Qty </th>
                            <th class="text-center">Requested QTY</th>
                            <th class="text-center">Issue QTY</th>
                            <th class="text-center">UOM</th>
                            <th class="text-center" style="width: 180px;">Location</th>
                            <th class="text-center" style="width: 180px;">Batch Code</th>
                            <th class="text-center">Available</th>
                            <th class="text-center"> Issued</th>

                        </tr>
                        </thead>

                        <tbody>

                            @foreach(ProductionHelper::get_bom_for_direct($row->finish_goods_id) as  $row1)

                            <?php $data_count=ProductionHelper::check_issue_data($row1->bom_data_id,$row->master_id); ?>
                        <tr class="text-center" style="">

                        <input type="hidden" name="item{{$index}}" id="item_id{{$index}}" value="{{$row1->item_id}}"/>

                          <?php $uom_name=CommonHelper::get_uom($row1->item_id); ?>
                        <td><input readonly class="form-control" type="text" name="" id="" value="{{CommonHelper::get_item_name($row1->item_id)}}"/> </td>
                        <td><input readonly class="form-control" type="text" name="" id="" value="{{$row->planned_qty}}"/> </td>
                        <td><input  readonly class="form-control" value="{{$row1->qty_ft*$row->planned_qty}}" name="req_qty[]" id="req_qty{{$index}}"></td>
                        <td>
                            @if($data_count->count()>0) {{$data_count->first()->issue_qty}}
                        @else
                            <input    onblur="issued_qty('{{$index}}')" onkeyup="issued_qty('{{$index}}')" class="form-control" type="form-control" name="issue_qty[]" id="issu_qty{{$index}}" />
                        @endif
                        </td>
                        <td>{{$uom_name}}</td>


                        <td>

                            @if($data_count->count()>0) {{CommonHelper::get_name_warehouse($data_count->first()->warehouse_id)}};
                             @else
                            <select  name="location_id" id="location_id{{$index}}" class="form-control location" onchange="get_detail('item_id{{$index}}','{{$index}}');">
                                <option value="">Select Location</option>
                                <?php foreach(CommonHelper::get_all_warehouse() as $warehouse_data):?>
                                <option
                                 value="<?php echo $warehouse_data->id?>"><?php echo $warehouse_data->name;?></option>
                                <?php endforeach;?>
                            </select>
                                @endif
                        </td>

                        <td>
                            @if($data_count->count()>0) {{$data_count->first()->batch_code}}
                        @else
                            <select  onchange="get_stock_qty(this.id,'{{$index}}');" name="batch_code[]" id="batch_code{{$index}}" class="form-control requiredField"></select>
                            @endif
                        </td>
                        <td><input onblur="issued_qty('{{$index}}')" onkeyup="issued_qty('{{$index}}')" class="form-control" type="number" readonly id="instock_{{$index}}"/></td>
                        <td id="td{{$index}}"><button id="btn{{$index}}" disabled onclick="save('{{$index}}')" type="button" class="btn btn-success">Issue</button></td>
                            <input type="hidden" name="main_id{{$index}}" id="main_id{{$index}}" value="{{$row->main_id}}"/>
                            <input type="hidden" name="master_id{{$index}}" id="master_id{{$index}}" value="{{$row->master_id}}"/>
                            <input type="hidden" name="type{{$index}}" id="type{{$index}}" value="0"/>
                            <input type="hidden" name="bom_data_id{{$index}}" id="bom_data_id{{$index}}" value="{{$row1->bom_data_id}}"/>
                        </tr>
                        <?php $index++; ?>
                           @endforeach




                        @foreach(ProductionHelper::get_bom_for_indirect($row->finish_goods_id) as  $row1)
                            <?php $data_count=ProductionHelper::check_issue_data($row1->bom_data_id,$row->master_id); ?>
                            <?php $uom_name=CommonHelper::get_uom($row1->item_id); ?>

                            <tr class="text-center" style="">
                                <input type="hidden" name="item[]" id="item_id{{$index}}" value="{{$row1->item_id}}"/>
                                <td><input readonly class="form-control" type="text" name="" id="" value="{{CommonHelper::get_item_name($row1->item_id)}}"/> </td>
                                <td><input readonly class="form-control" type="text" name="" id="" value="{{$row->planned_qty}}"/> </td>
                                <td><input readonly class="form-control" value="{{$row1->qty*$row->planned_qty}}" name="req_qty[]" id="req_qty{{$index}}"></td>
                                <td>
                                    @if($data_count->count()>0) {{$data_count->first()->issue_qty}}
                                    @else
                                        <input    onblur="issued_qty('{{$index}}')" onkeyup="issued_qty('{{$index}}')" class="form-control" type="form-control" name="issue_qty[]" id="issu_qty{{$index}}" />
                                    @endif
                                </td>
                                <td>{{$uom_name}}</td>

                                <td>

                                    @if($data_count->count()>0) {{CommonHelper::get_name_warehouse($data_count->first()->warehouse_id)}};
                                    @else
                                        <select  name="location_id" id="location_id{{$index}}" class="form-control location" onchange="get_detail('item_id{{$index}}','{{$index}}');">
                                            <option value="">Select Location</option>
                                            <?php foreach(CommonHelper::get_all_warehouse() as $warehouse_data):?>
                                            <option
                                                    value="<?php echo $warehouse_data->id?>"><?php echo $warehouse_data->name;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    @endif
                                </td>


                                <td>
                                    @if($data_count->count()>0) {{$data_count->first()->batch_code}}
                                @else
                                    <select   onchange="get_stock_qty(this.id,'{{$index}}');" name="batch_code[]" id="batch_code{{$index}}" class="form-control requiredField"></select>
                                    @endif
                                </td>
                                <td><input onblur="issued_qty('{{$index}}')" onkeyup="issued_qty('{{$index}}')"  class="form-control" type="number" readonly id="instock_{{$index}}"/></td>
                                <td id="td{{$index}}"><button id="btn{{$index}}" disabled onclick="save('{{$index}}')" type="button" class="btn btn-success">Issue</button></td>

                                <input type="hidden" name="main_id{{$index}}" value="{{$row->main_id}}" id="main_id{{$index}}"/>
                                <input type="hidden" name="master_id{{$index}}" value="{{$row->master_id}}" id="master_id{{$index}}"/>
                                <input type="hidden" name="type{{$index}}" value="1" id="type{{$index}}"/>
                                <input type="hidden" name="bom_data_id{{$index}}" value="{{$row1->bom_data_id}}" id="bom_data_id{{$index}}"/>

                            </tr>
                            <?php $index++; ?>
                        @endforeach

                        </tbody>
                    </table>
                    @endforeach
                </div>
            </div>

        <?php echo Form::close();?>
    </div>

    <script>
        function get_detail(id,number)
        {
            //alert(number); return false;


           if (number==1)
           {
               var location_id = $('#location_id'+number).val();
               $('.location').val(location_id);

               $('.location').each(function(i, obj) {
                var   number=$(this).attr('id');
                 number=number.replace("location_id", "");


                   var item=$('#item_id'+number).val();
                   var location_id = $('#location_id'+number).val();
                   if (location_id=='')
                   {
                       $('#batch_code'+number).val('');
                       $('#instock_'+number).val(0);

                   }
                   else
                   {
                       $.ajax({
                           url:'{{url('/pdc/get_batch_code')}}',
                           data:{item:item,location_id:location_id},
                           type:'GET',
                           success:function(response)
                           {
                               //var data=response.split(',');
                               $('#batch_code'+number).html(response);
                               issued_qty(number);
                           }
                       });
                   }

               });
           }
        else
           {
               var item=$('#'+id).val();
               var location_id = $('#location_id'+number).val();
               $.ajax({
                   url:'{{url('/pdc/get_batch_code')}}',
                   data:{item:item,location_id:location_id},
                   type:'GET',
                   success:function(response)
                   {
                       //var data=response.split(',');
                       $('#batch_code'+number).html(response);
                       issued_qty(number);
                   }
               });
           }


        }

        function get_stock_qty(warehouse,number)
        {


            var warehouse=$('#location_id'+number).val();
            var item=$('#item_id'+number).val();
            var batch_code=$('#batch_code'+number).val();



            $.ajax({
                url: '<?php echo url('/')?>/pdc/get_stock_location_wise?batch_code='+batch_code,
                type: "GET",
                data: {warehouse:warehouse,item:item},
                success:function(data)
                {

                    data=data.split('/');
                    $('#instock_'+number).val(data[0]);

                    if (data[0]==0)
                    {
                        $("#"+item).css("background-color", "red");
                    }
                    else
                    {
                        $("#"+item).css("background-color", "");
                    }
                    issued_qty(number);
                }
            });

        }

        function issued_qty(number)
        {
          var issue_qty=parseFloat($('#issu_qty'+number).val());
          issue_qty= checkNan(issue_qty);
          var avaiable=parseFloat($('#instock_'+number).val());
           console.log(avaiable);
           avaiable=checkNan(avaiable);
            if (issue_qty >avaiable)
            {
                $('#btn'+number).prop("disabled", true);
                $('#issu_qty'+number).css("background-color",'red');
            }
            else
            {
                $('#btn'+number).prop("disabled", false);
                $('#issu_qty'+number).css("background-color",'');
            }
        }

        function save(number)
        {
            $('#btn'+number).prop("disabled", true);
            var main_id=$('#main_id'+number).val();
           
            var master_id=$('#master_id'+number).val();
            var type=$('#type'+number).val();
            var bom_data_id=$('#bom_data_id'+number).val();
            var issue_qty=$('#issu_qty'+number).val();
            var location_id=$('#location_id'+number).val();
            var batch_code=$('#batch_code'+number).val();
            var item_id=$('#item_id'+number).val();
            var request_qty=$('#req_qty'+number).val();
            $.ajax({
                url:'{{url('/production/save_issue_material')}}',
                data:{main_id:main_id,master_id:master_id,type:type,bom_data_id:bom_data_id,issue_qty:issue_qty,location_id:location_id,batch_code:batch_code,item_id:item_id,request_qty:request_qty},
                type:'GET',
                success:function(response)
                {
                    $('#btn'+number).css("display", 'none');
                    $('#td'+number).html('&#9989;');
                  //  alert('successfully Saved');


                },
                error: function() {
                    $('#td'+number).html('&#x2716;');
                }

            });
        }
    </script>
