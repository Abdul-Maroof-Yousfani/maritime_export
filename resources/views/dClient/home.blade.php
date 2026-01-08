<?php
   use App\Helpers\CommonHelper;
         $m = '';
      if(isset($_GET['m']))
      {
         $m = $_GET['m'];
      }
      else
      {
         $m = '';
      }
   $UserId = Auth::user()->id;
   ?>
@extends('layouts.default')
@section('content')
{{--< ?php --}}
{{--//$Companies = DB::table('company')->where('status',1)->get();?>--}}
{{--
<div class="row">
   --}}
   {{--
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well">
      --}}
      {{--
      <div class="panel">
         --}}
         {{--
         <div class="panel-body">
            --}}
            {{--
            <div class="">
               --}}
               {{--< ?php foreach($Companies as $Fil):?>--}}
               {{--&nbsp;--}}
               {{--
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">--}}
                  {{--<a href="#" class="btn btn-lg btn-primary" style="width: 100%; border-radius: 25px;">--}}
                  {{--<i class="fa fa-arrow-right" aria-hidden="true"></i>--}}
                  {{--< ?php echo $Fil->name;?>--}}
                  {{--<i class="fa fa-university" aria-hidden="true" style="float: right;"></i>--}}
                  {{--</a>--}}
                  {{--
               </div>
               --}}
               {{--< ?php endforeach;?>--}}
               {{--
            </div>
            --}}
            {{--
         </div>
         --}}
         {{--
      </div>
      --}}
      {{--
   </div>
   --}}
   {{--
</div>
--}}
{{--< ?php ?>--}}
<?php $count=0;
   if(Auth::user()->id == 104)
   {
   $companiesList = DB::table('company')->select(['name','id','dbName'])->where('status','=','1')->get();
   
   
   }
         else{
   $companiesList = DB::table('company')->select(['name','id','dbName'])->where('id','!=',4)->where('status','=','1')->get();
   
         }
   
   ?>
@if(Session::get('run_company')==''):
<div id="companyListModel" class="modal fade in" role="dialog" aria-hidden="false" style="display: block;">
   <div class="modal-dialog modalWidth dply">
      <!-- Modal content-->
      <div class="model-n modal-content">
         <div class="modal-body">
            <div class="mdel-bx">
               <img class="circle" src="../assets/img/animation/circledot.png">
               <div class="model-logo">
                  <img src="assets/img/logos/logo.png">
                  <h4 class="modal-title">Select Company</h4>
               </div>
               <div class="row">
                  <ul class="ban-list">
               @foreach($companiesList  as $key => $cRow1)
                     <li>
                        <div class="banq-box">
                           <a href="{{url('set_user_db_id?company='.$cRow1->id)}}">
                              <span class="companyLetr theme-bg theme-f-m">G</span>
                              <h3 class="item-model-company theme-f-m">{{ $cRow1->name }}</h3>
                           </a>
                        </div>
                     </li>
                     {{-- <li>
                        <div class="banq-box">
                           <a href="{{url('set_user_db_id?company='.$cRow1->id)}}">
                              <span class="companyLetr theme-bg theme-f-m">D</span>
                              <h3 class="item-model-company theme-f-m">{{ $cRow1->name }}</h3>
                           </a>
                        </div>
                     </li> --}}
                     @endforeach
                  </ul>
               </div>
               <a href="{{url('/logout')}}" class="btn-b">Sign Out</a>
            </div>
         </div>
      </div>
   </div>
   <div class="modal-backdrop fade in"></div>
</div>
@endif
<div class="well_N">
   <div>
      <div class="row" style="display: none;">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel">
               <div class="panel-body">
                  <div class="">
                     <?php $count=0; ?>
                     @foreach($companiesList  as $key => $cRow1)
                     @if($count==0 && $cRow1->id<=5)
                     <h2 style="text-align: center">
                        <p class="">Select Company 
                     </h2>
                     <?php $count++ ?>
                     @elseif($count==1 && $cRow1->id>5)
                     <h2 style="text-align: center">
                        <p class="outset">Financial Year :2022-2023
                     </h2>
                     @endif
                     <a  href="{{url('set_user_db_id?company='.$cRow1->id)}}"  class="">
                        {{--{{ $cRow1->name}}--}}
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 " style="font-size: 20px;">
                           {{--{{ $cRow1->name }}--}}
                           <?php echo CommonHelper::get_company_logo_front($cRow1->id)?> <span id="Loading<?php echo $cRow1->id?>"></span></i>
                        </div>
                     </a>
                     @endforeach
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php if(Session::get('run_company')):?>
      <span style="display: block;">
         <div class="wrapper wrapper-content">
            <div class="row">
               {{--
               <a href="#" onclick="getDashboardInfo(4);">
                  --}}
                  {{--
                  <div class="col-lg-3">
                     --}}
                     {{--
                     <div class="ibox ">
                        --}}
                        {{--
                        <div class="ibox-title">
                           --}}
                           {{--
                           <div class="ibox-tools">--}}
                              {{--<span class="label label-success float-right">Annual</span>--}}
                              {{--
                           </div>
                           --}}
                           {{--
                           <h5 class="fa fa-bar-chart" aria-hidden="true"></h5>
                           --}}
                           {{--
                        </div>
                        --}}
                        {{--
                        <div class="ibox-content">
                           --}}
                           {{--
                           <h1 class="no-margins">Dashboard </h1>
                           --}}
                           {{--
                        </div>
                        --}}
                        {{--
                     </div>
                     --}}
                     {{--
                  </div>
                  --}}
                  {{--
               </a>
               --}}
               <a href="#" onclick="getDashboardInfo(1);">
                  <div class="col-lg-4">
                     <div class="ibox ">
                        <div class="ibox-title">
                           <div class="ibox-tools">
                              <span class="label label-success float-right">Annual</span>
                           </div>
                           <h5 class="fa fa-bar-chart" aria-hidden="true"></h5>
                        </div>
                        <div class="ibox-content">
                           <h1 class="no-margins">INVENTORY </h1>
                        </div>
                        <div id="gained-chart"></div>
                     </div>
                  </div>
               </a>
               <a href="#" onclick="getDashboardInfo(2);">
                  <div class="col-lg-4">
                     <div class="ibox ">
                        <div class="ibox-title">
                           <div class="ibox-tools">
                              <span class="label label-info float-right">Annual</span>
                           </div>
                           <h5><i class="fa fa-credit-card" aria-hidden="true"></i></h5>
                        </div>
                        <div class="ibox-content">
                           <h1 class="no-margins">SALES</h1>
                        </div>
                        <div id="order-chart"></div>
                     </div>
                  </div>
               </a>
               <a href="#" onclick="getDashboardInfo(3);">
                  <div class="col-lg-4">
                     <div class="ibox ">
                        <div class="ibox-title">
                           <div class="ibox-tools">
                              <span class="label label-primary float-right">Annual</span>
                           </div>
                           <h5><i class="fa fa-money" aria-hidden="true"></i></h5>
                        </div>
                        <div class="ibox-content">
                           <h1 class="no-margins">FINANCE</h1>
                        </div>
                        <div id="gained-chartt"></div>
                     </div>
                  </div>
               </a>
               {{--
               <div class="col-lg-3">
                  --}}
                  {{--
                  <div class="ibox ">
                     --}}
                     {{--
                     <div class="ibox-title">
                        --}}
                        {{--
                        <div class="ibox-tools">--}}
                           {{--<span class="label label-danger float-right">Low value</span>--}}
                           {{--
                        </div>
                        --}}
                        {{--
                        <h5>User activity</h5>
                        --}}
                        {{--
                     </div>
                     --}}
                     {{--
                     <div class="ibox-content">
                        --}}
                        {{--
                        <h1 class="no-margins">80,600</h1>
                        --}}
                        {{--
                        <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div>
                        --}}
                        {{--<small>In first month</small>--}}
                        {{--
                     </div>
                     --}}
                     {{--
                  </div>
                  --}}
                  {{--
               </div>
               --}}
            </div>
         </div>
         <div class="well" id="ShowHide">
         </div>
   </div>


   <div class="row">
      <div class="col-md-3">
         <div class="ibox ma1">
            <div class="ibox-content ibox-title">
               <h5><i class="fa fa-money" aria-hidden="true"></i></h5>
               <h4 aria-hidden="true"> <b>Total Sales (Sep 2022)</b><br> Rs. 0 (CR) </h4>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="ibox ma1">
            <div class="ibox-content ibox-title">
               <h5><i class="fa fa-money" aria-hidden="true"></i></h5>
               <h4 aria-hidden="true"> <b>Total Collection (Sep 2022)</b><br> Rs. 0 (CR) </h4>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="ibox ma1">
            <div class="ibox-content ibox-title">
               <h5><i class="fa fa-money" aria-hidden="true"></i></h5>
               <h4 aria-hidden="true"> <b>Total Receivable</b><br> Rs. 0 (CR) </h4>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="ibox ma1">
            <div class="ibox-content ibox-title">
               <h5><i class="fa fa-money" aria-hidden="true"></i></h5>
               <h4 aria-hidden="true"> <b>Total Payable </b><br> Rs. 0 (CR) </h4>
            </div>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-md-3">
         <div class="ibox ma1">
            <div class="ibox-content ibox-title">
               <h5><i class="fa fa-money" aria-hidden="true"></i></h5>
               <h4 aria-hidden="true"> <b>Today's Sales</b><br> Rs. 0 (CR) </h4>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="ibox ma1">
            <div class="ibox-content ibox-title">
               <h5><i class="fa fa-money" aria-hidden="true"></i></h5>
               <h4 aria-hidden="true"> <b>Today's Sale Order</b><br> Rs. 0 (CR) </h4>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="ibox ma1">
            <div class="ibox-content ibox-title">
               <h5><i class="fa fa-money" aria-hidden="true"></i></h5>
               <h4 aria-hidden="true"> <b>Today's Payments Recovery</b><br> Rs. 0 (CR) </h4>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="ibox ma1">
            <div class="ibox-content ibox-title">
               <h5><i class="fa fa-user" aria-hidden="true"></i></h5>
               <h4 aria-hidden="true"> <b>Total Customers</b><br> 0 </h4>
            </div>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-md-3">
         <div class="ibox ma1">
            <div class="ibox-content ibox-title">
               <h5><i class="fa fa-bar-chart" aria-hidden="true"></i></h5>
               <h4 aria-hidden="true"> <b>Today's Return</b><br> Rs. 0 (CR) </h4>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="ibox ma1">
            <div class="ibox-content ibox-title">
               <h5><i class="fa fa-bar-chart" aria-hidden="true"></i></h5>
               <h4 aria-hidden="true"> <b>Today's Purchase</b><br> Rs. 0 (CR) </h4>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="ibox ma1">
            <div class="ibox-content ibox-title">
               <h5><i class="fa fa-bar-chart" aria-hidden="true"></i></h5>
               <h4 aria-hidden="true"> <b>Today's Purchase Order</b><br> Rs. 0 (CR) </h4>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="ibox ma1">
            <div class="ibox-content ibox-title">
               <h5><i class="fa fa-bar-chart" aria-hidden="true"></i></h5>
               <h4 aria-hidden="true"> <b>Total Products</b><br> 0 </h4>
            </div>
         </div>
      </div>
   </div>

   

   <div class="row">
      <div class="col-md-4">
         <div class="ibox ma1">
            <div class="ibox-content">
               <h1 class="no-margins">TOP 3 ITEM TYPES</h1>
               <div id="line-area-chart"></div>
            </div>
            
         </div>
      </div>
      <div class="col-md-4">
         <div class="ibox ma1">
            <div class="ibox-content">
               <h1 class="no-margins">PRODUCT CONTRIBUTION</h1>
               <div id="column-chart"></div>
            </div>
         </div>
      </div>
      <div class="col-md-4">
         <div class="ibox ma1">
            <div class="ibox-content">
               <h1 class="no-margins">STOCK THRESHOLD</h1>
               <div id="bar-chart"></div>
            </div>
            
         </div>
      </div>
   </div>

   <div class="row">
      
      <div class="col-lg-3 col-md-2 col-sm-3 col-xs-12">
         <div class="ibox ma1">
            <div class="ibox-content">
               <h1 class="no-margins">LEAVES BALANCE </h1>
            </div>
            <div class="pad-lr">
               <div id="statistics-order-chart"></div>      
            </div>
         </div>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
         <div class="ibox ma1">
            <div class="ibox-content">
               <h1 class="no-margins">CURRENT CASH POSITION</h1>
            </div>
            <div id="line-chart"></div>
         </div>
      </div>

      <!-- <div class="col-lg-3 col-md-2 col-sm-3 col-xs-12">
         <div class="ibox ma1">
            <div class="ibox-content">
               <h1 class="no-margins">WEEKLY SALES</h1>
            </div>
            <div class="pad-lr">
               <div id="statistics-profit-chart"></div>      
            </div>
         </div>
      </div> -->

      <div class="col-lg-3 col-md-2 col-sm-3 col-xs-12">
         <div class="ibox ma1">
            <div class="ibox-content">
               <h1 class="no-margins">EXPENSE CLAIMS</h1>
               <div id="radialbar-chart"></div>
            </div>
            
         </div>
      </div>
   </div>

   <div class="row" style="margin-bottom: 40px;">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="ibox ma1">
            <div class="ibox-content">
               <h1 class="no-margins">FISCAL YEAR GRAPH</h1>
               <div id="candlestick-chart"></div>
            </div>
         </div>      
      </div>   
   </div>
</div>
      
<script !src="">
   $(document).ready(function() {
   /*
      var formWidth = $('.sliding_form').width();
      $('.sliding_form').css('right', '-' + formWidth + 'px');
      $("#form_trigger").on('click', function() {
   
         if ($('.sliding_form').hasClass('slide_out')) {
            $('.sliding_form').removeClass('slide_out').addClass('slide_in')
            $(".sliding_form").animate({ right: 0 + 'px' });
   
            $('#AjaxDataOnlineUsers').html('<div class="loader"></div>');
            var m = '< ?php echo $m?>';
            $.ajax({
               url: '/pdc/getOnlineUserAjax',
               type: 'Get',
               data: {m:m},
   
               success: function (response)
               {
                  $('#AjaxDataOnlineUsers').html(response);
               }
            });
   
         } else {
            $('.sliding_form').removeClass('slide_in').addClass('slide_out')
            $('.sliding_form').animate({ right: '-' + formWidth + 'px' });
   
         }
   
      });
      */
   });
   
   
   function getDashboardInfo(Type)
   {
      var m = '<?php echo $m?>';
      $('#ShowHide').html('<div class="loader"></div>');
   
      $.ajax({
         url: '<?php echo url('/') ?>/pdc/get_dashboard_info',
         type: 'Get',
         data: {Type: Type,m:m},
   
         success: function (response)
         {
            $('#ShowHide').html(response);
         }
      });
   
   
   }
</script>
</span>
<?php endif;?>
@endsection