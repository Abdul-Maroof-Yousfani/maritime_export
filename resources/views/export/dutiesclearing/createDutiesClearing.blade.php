<?php

   use App\Helpers\ReuseableCode;
   use App\Helpers\NotificationHelper;
   $MenuPermission = true;
   
   $m = Session::get('run_company');
   $accType = Auth::user()->acc_type;
   $currentDate = date('Y-m-d');

   
   
   
   
   
   use App\Helpers\PurchaseHelper;
   use App\Helpers\SalesHelper;
   use App\Helpers\CommonHelper;
   
   
   if($accType =='user'):
   $user_rights = DB::table('menu_privileges')->where([['emp_code','=',Auth::user()->emp_code],['compnay_id','=',Session::get('run_company')]]);
   $submenu_ids  = explode(",",$user_rights->value('submenu_id'));
   		if(in_array(185,$submenu_ids))
   		{
   			$MenuPermission = true;
   		}
   		else
   		{
   			$MenuPermission = false;
   		}
   endif;
   
   
   ?>
@extends('layouts.default')
@section('content')
@include('loader')
@include('select2')
@include('bundles_data')
@include('modal')
<style>
   * {
   font-size: 12px!important;
   }
   label {
   text-transform: capitalize;
   }
</style>
<?php $so_no= SalesHelper::get_unique_no_export(date('y'),date('m')); ?>

<div class="container-fluid">
	<div class="row" style="display: none;" id="main">
	   <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="display: none;">
	   </div>
	   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	      <div class="well_N">
	         <div class="dp_sdw">
	            <div class="row">
	               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  <span class="subHeadingLabelClass">Shipment Clearing Charges & Duities</span>
	                  <?php
	                     if($MenuPermission == true):?>
	                  <?php else:?>
	                  <span class="subHeadingLabelClass text-danger text-center" style="float: right">Permission Denied <span style='font-size:45px !important;'>&#128546;</span></span>
	                  <?php endif;
	                     ?>
	               </div>
	            </div>
	            <?php if($MenuPermission == true):?>
	            <div class="lineHeight">&nbsp;</div>
	        <div class="row">
	             <form action="{{route('dutiesClearingStore')}}" method="POST">
	               <input type="hidden" name="_token" value="{{ csrf_token() }}">
     
	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	        <div class="panel">
	            <div class="panel-body">
	        <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <table class="table table-bordered">
                      <input type="hidden" name="export_list_id" id="" value="{{$exportpakingList->export_list_id}}">
                        <tr>
                          <input class="form-control" type="hidden" name="mf_no" id="">
                            <th>Invoice No</th>
                            <td>
                              <input type="hidden" name="invoice_id" id="" value="{{$exportpakingList->invoice_data_id}}">
                              <input readonly class="form-control" type="text" name="invoice_no" value="{{$exportpakingList->invoice_no}}"id=""> </td>
                          </tr>
                          <tr>
                            <th>Shipment Date</th>
                            <td><input readonly class="form-control" type="text" value="{{$exportpakingList->delevery_date}}" name="shippment_date" id=""> </td>
                          </tr>
                    </table>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <table class="table table-bordered">
                      
                        <tr>
                          <th>E-form No.</th>
                          <td><input readonly class="form-control" type="text" value="{{$exportpakingList->form_no}}" name="e-form_no" id=""> </td>
                        </tr>
                        <tr>
                            <th>E-form Date</th>
                            <td><input readonly class="form-control" type="text" value="{{$exportpakingList->invoice_date}}" name="e_form_date" id=""> </td>
                          </tr>
                          <tr>
                            <th>Bank -E Form</th>
                          <?php if(!empty($exportpakingList->bank)){
                         
                                  $bank_name  = App\Models\Bank::find($exportpakingList->bank)->bank_name;
                            }else{
                                   $bank_name = '-';
                            }
                              ?>
                            <td><input readonly class="form-control" type="text" value="{{$bank_name}}" name="bank_e_form" id=""> </td>
                          </tr>
                          
                    </table>
                </div>
				</div>      
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <table class="table table-bordered">
                            <tr><th colspan="4"><p style="font-weight: bolder;"><b>BUYER CREDENTIALS</b></p></th></tr>
                            <tr>
                              <th>Party Name</th>
                              <td><input readonly class="form-control" type="text" value="{{$exportpakingList->name}}" name="party_name" id=""> </td>
                            </tr>
                            <tr>
                              @php
                              if(!empty($exportpakingList->country))
                              {
                            $country =  App\Models\Countries::find($exportpakingList->country)->name;
                              }else{
                                $country = '-';
                              }   

                              @endphp
                                <th>Country</th>
                                <td><input  readonly class="form-control" type="text" name="country" value="{{$country}}" id=""> </td>
                              </tr>
                              <tr>
                                <th>Port Of Loading</th>
                                <td><input readonly class="form-control" type="text" name="port_loading" value="{{$exportpakingList->port_loading}}" id=""> </td>
                              </tr>
                              <tr>
                                <th>Port of Discharge</th>
                                <td><input readonly class="form-control" type="text" name="port_of_discharge" value="{{$exportpakingList->port_of_discharge}}" id=""> </td>
                              </tr>
                        </table>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <table class="table table-bordered">
                          <tr><th colspan="4"><p style="font-weight: bolder;"><b>BILL OF LADING</b></p></th></tr>
                            <tr>
                              <th>BL NO /Date .</th>
                              <td><input readonly class="form-control" type="text" value="{{$exportpakingList->bill_of_loading}}" name="bill_of_loading" id=""> </td>
                            </tr>
                          
                              <tr>
                                <th>HS Code</th>
                                <td><input readonly class="form-control" type="text" value="{{$exportpakingList->hs_code}}" name="hs_code" id=""> </td>
                              </tr>
                              <tr>
                                <th>Vessel Name</th>
                                <td><input readonly class="form-control" value="{{$exportpakingList->ship_name}}" type="text" name="vessel_name" id=""> </td>
                              </tr>
                        </table>
                    </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <table class="table table-bordered">
                                <tr><th colspan="4"><p style="font-weight: bolder;"><b>SHIPPMENT CREDENTIALS</b></p></th></tr>
                                <tr>
                                  <th>Commodity</th>
                                  <td><input readonly class="form-control" type="text" value="{{$exportpakingList->sub_ic}}" name="commodity" id=""> </td>
                                </tr>
                                <tr>
                                    <th>Quality </th>
                                    <td><input readonly class="form-control" type="text" value="{{$exportpakingList->quality_remarks}}"name="quality" id=""> </td>
                                  </tr>
                                  <tr>
                                    <th>Quantity </th>
                                    <td><input readonly class="form-control" value="{{$exportpakingList->qty}}" type="text" name="quantity" id=""> </td>
                                  </tr>
                                  <tr>
                                    <th>Type</th>
                                    <td><input class="form-control" type="text" name="type" id=""> </td>
                                  </tr>
                                  <tr>
                                    <th>Raw Material Cost Per Ton</th>
                                    <td><input class="form-control" type="text" name="raw_material_cost_per_ton" id=""> </td>
                                  </tr>
                                  <tr>
                                    <th>Total Container</th>
                                    <td><input class="form-control" type="text" name="total_container" id=""> </td>
                                  </tr>
                                  <tr>
                                    <th>Cost of Sales </th>
                                    <td><input class="form-control" type="text" name="cost_of_sales" id=""> </td>
                                  </tr>
                                  <tr>
                                    <th>Labour Cost Per Ton</th>
                                    <td><input class="form-control" type="text" name="labour_cost_per_ton" id=""> </td>
                                  </tr>
                                  <tr>
                                    <th>Shipment Labour Cost</th>
                                    <td><input class="form-control" type="text" name="shipment_labour_cost" id=""> </td>
                                  </tr>
                            </table>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <table class="table table-bordered">
                              <tr><th colspan="4"><p style="font-weight: bolder;"><b>SHIPPMENT VALUE</b></p></th></tr>
                                <tr>
                                  <th>Rate Per {{$exportpakingList->uom_id}}</th>
                                  <td><input readonly class="form-control" type="text" value="{{$exportpakingList->rate_qty}}" name="rate_per_ton" id=""> </td>
                                </tr>
                                <tr>
                                    <th>FLC Qty</th>
                                    <td><input readonly class="form-control" type="text" value="{{$exportpakingList->flc_qty}}" name="invoice_value_in_fcy" id=""> </td>
                                  </tr>
                                  <tr>
                                    <th>Exchange Rate</th>
                                    <td><input readonly class="form-control" value="{{$exportpakingList->currencey_rate}}" type="text" name="exchange_rate" id=""> </td>
                                  </tr>
                                  <tr>
                                    <th>Invoice Value in PKR</th>
                                    <td><input readonly class="form-control" type="text" value="{{$exportpakingList->rate_qty*$exportpakingList->qty*$exportpakingList->currencey_rate}}" name="invoice_value_in_pkr" id=""> </td>
                                  </tr>
                                  <tr>
                                    <th>Shipment Terms.</th>
                                    <td><input class="form-control" type="text" name="shipment_term" id=""> </td>
                                  </tr>
                                  <tr>
                                    <th>Income Tax @ 1% - Section - 154</th>
                                    <td><input class="form-control" type="text" name="income_tax" id=""> </td>
                                  </tr>
                                  <tr>
                                    <th>EDS Charges</th>
                                    <td><input class="form-control" type="text" name="eds_charges" id=""> </td>
                                  </tr>
                                  <tr>
                                    <th>PKR Realization (1,2,3,4 & 5)</th>
                                    <td><input class="form-control" type="text" name="pkr_realization" id=""> </td>
                                  </tr>
                                  <tr>
                                    <th>Proceeds Realization in Bank</th>
                                    <td><input class="form-control" type="text" name="proceeds_realization_in_bank" id=""> </td>
                                  </tr>
                            </table>
                        </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <table class="table table-bordered">
                                    <tr><th colspan="4"><p style="font-weight: bolder;"><b>PACKING COST</b></p></th></tr>
                                    <tr>
                                      <th>Packing Type.</th>
                                      <td><input class="form-control" type="text" name="paking_type" id=""> </td>
                                    </tr>
                                    <tr>
                                        <th>Packing Quality</th>
                                        <td><input class="form-control" type="text" name="paking_quality" id=""> </td>
                                      </tr>
                                      <tr>
                                        <th>Quantity in Tons</th>
                                        <td><input class="form-control" type="text" name="quantity_in_ton" id=""> </td>
                                      </tr>
                                      <tr>
                                        <th>No. of Bags</th>
                                        <td><input class="form-control" type="text" name="no_of_begs" id=""> </td>
                                      </tr>
                                      <tr>
                                        <th>Packing Cost Per Ton</th>
                                        <td><input class="form-control" type="text" name="packing_cost_per_ton" id=""> </td>
                                      </tr>
                                      <tr>
                                        <th>Packing Cost</th>
                                        <td><input class="form-control" type="text" name="packing_cost" id=""> </td>
                                      </tr>

                                      <tr style="border:none !important"> <td colspan="2" style="border:none !important"></td></tr>
                                      <tr>
                                        <td colspan="2"> <p style="font-weight: bolder;"><b>FUMIGATION & INSPECTION</b></p></td>
                                      </tr>
                                      <tr>
                                        <th>Fumigation Cost Per Ton</th>
                                        <td><input class="form-control" type="text" name="fumigation_cost_per_ton" id=""> </td>
                                      </tr>
                                      <tr>
                                        <th>Shipment Fumigation Cost</th>
                                        <td><input class="form-control" type="text" name="shipment_fumigation_cost" id=""> </td>
                                      </tr>

                                      <tr>
                                        <th>Inspection Cost Per Ton</th>
                                        <td><input class="form-control" type="text" name="inspection_cost_per_ton" id=""> </td>
                                      </tr>

                                      <tr>
                                        <th>Shipment Inspection Cost</th>
                                        <td><input class="form-control" type="text" name="shipment_inspection_cost" id=""> </td>
                                      </tr>


                                </table>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <table class="table table-bordered">
                                  <tr><th colspan="4"><p style="font-weight: bolder;"><b>SHIPMENT CLEAREANCE</b></p></th></tr>
                                    <tr>
                                      <th>Clearing Agent</th>
                                      <td><input class="form-control" type="text" name="clearing_agent" id=""> </td>
                                    </tr>
                                    <tr>
                                        <th>Terminal</th>
                                        <td><input class="form-control" type="text" name="terminal" id=""> </td>
                                      </tr>
                                      <tr>
                                        <th>Weboc Token Charges</th>
                                        <td><input class="form-control" type="text" name="weboc_token_charges" id=""> </td>
                                      </tr>
                                      <tr>
                                        <th>PSW Fee</th>
                                        <td><input class="form-control" type="text" name="psw_fee" id=""> </td>
                                      </tr>
                                      <tr>
                                        <th>Wharfage</th>
                                        <td><input class="form-control" type="text" name="Wharfage" id=""> </td>
                                      </tr>
                                      <tr>
                                        <th>Terminal Handling Charges</th>
                                        <td><input class="form-control" type="text" name="terminal_handling_charges" id=""> </td>
                                      </tr>
                                      <tr>
                                        <th>Fuel Adjustment Charges</th>
                                        <td><input class="form-control" type="text" name="fuel_adjustment_charges" id=""> </td>
                                      </tr>
                                      <tr>
                                        <th>Documentation Charges</th>
                                        <td><input class="form-control" type="text" name="documentation_charges" id=""> </td>
                                      </tr>
                                      <tr>
                                        <th>Miscellaneous Charges</th>
                                        <td><input class="form-control" type="text" name="miscellaneous_charges" id=""> </td>
                                      </tr>
                                      <tr>
                                        <th>ANF Expenses</th>
                                        <td><input class="form-control" type="text" name="anf_chrages" id=""> </td>
                                      </tr>
                                      <tr>
                                        <th>Agency Charges</th>
                                        <td><input class="form-control" type="text" name="agency_charges" id=""> </td>
                                      </tr>
                                </table>
                            </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <table class="table table-bordered">
                                        <tr><th colspan="4"><p style="font-weight: bolder;"><b>FORWARDING</b></p></th></tr>
                                        <tr>
                                          <th>Freight Forwarder.</th>
                                          <td><input class="form-control" type="text" name="freight_forwarder" id=""> </td>
                                        </tr>
                                        <tr>
                                            <th>House BL No.</th>
                                            <td><input class="form-control" type="text" name="house_bl_no" id=""> </td>
                                          </tr>
                                          <tr>
                                            <th>Shipping Line/Carrier.</th>
                                            <td><input class="form-control" type="text" name="shipping_line" id=""> </td>
                                          </tr>
                                          <tr>
                                            <th>Export Freight in $ Per Ton</th>
                                            <td><input class="form-control" type="text" name="export_freight_in_per_ton" id=""> </td>
                                          </tr>
                                          <tr>
                                            <th>Export Freight in $ </th>
                                            <td><input class="form-control" type="text"  name="export_freight_in_dolar" id=""> </td>
                                          </tr>
                                          <tr>
                                            <th>Export Freight in PKR </th>
                                            <td><input class="form-control" type="text" name="export_freight_in_pkr" id=""> </td>
                                          </tr>
                                          <tr>
                                            <th>Lifting Charges</th>
                                            <td><input class="form-control" type="text" name="lifting_charges" id=""> </td>
                                          </tr>
                                          
                                    </table>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <table class="table table-bordered">
                                      <tr><th colspan="4"><p style="font-weight: bolder;"><b>TRANSPORTATION</b></p></th></tr>
                                        <tr>
                                          <th>Transporter (1,2,3,4 & 5)</th>
                                          <td><input class="form-control" type="text" name="Transporter" id=""> </td>
                                        </tr>
                                        <tr>
                                            <th>Container Cost </th>
                                            <td><input class="form-control" type="text" name="container_cost " id=""> </td>
                                          </tr>
                                          <tr>
                                            <th>Total Transportation Cost</th>
                                            <td><input class="form-control" type="text" name="total_transportation_cost" id=""> </td>
                                          </tr>
                                          <tr>
                                            <th>Craft Ppaer Cost </th>
                                            <td><input class="form-control" type="text" name="craft_papper_cost" id=""> </td>
                                          </tr>
                                      
                                    </table>
                                </div>
                                </div>

							{{-- This data section of Sale order  --}}
	           
	               <div class="demandsSection"></div>
	               <div class="row">
	                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
	                     {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
	                  </div>
	               </div>
				</form>
	            </div>
	            <?php endif;?>
	         </div>
	      </div>
	   </div>
	</div>
</div>	

<script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>
@endsection