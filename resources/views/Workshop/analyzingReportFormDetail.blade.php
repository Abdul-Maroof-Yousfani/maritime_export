
    <style>
        
        /* layout */

   
.slick-list,.slick-slider,.slick-track{position:relative;display:block}.slick-loading .slick-slide,.slick-loading .slick-track{visibility:hidden}.slick-slider{box-sizing:border-box;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;-webkit-touch-callout:none;-khtml-user-select:none;-ms-touch-action:pan-y;touch-action:pan-y;-webkit-tap-highlight-color:transparent}.slick-list{overflow:hidden;margin:0;padding:0}.slick-list:focus{outline:0}.slick-list.dragging{cursor:pointer;cursor:hand}.slick-slider .slick-list,.slick-slider .slick-track{-webkit-transform:translate3d(0,0,0);-moz-transform:translate3d(0,0,0);-ms-transform:translate3d(0,0,0);-o-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}.slick-track{top:0;left:0;margin-left:auto;margin-right:auto}.slick-track:after,.slick-track:before{display:table;content:''}.slick-track:after{clear:both}.slick-slide{display:none;float:left;height:100%;min-height:1px}[dir=rtl] .slick-slide{float:right}.slick-slide img{display:block}.slick-slide.slick-loading img{display:none}.slick-slide.dragging img{pointer-events:none}.slick-initialized .slick-slide{display:block}.slick-vertical .slick-slide{display:block;height:auto;border:1px solid transparent}.slick-arrow.slick-hidden{display:none}



/* Reset Css */

div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video { margin: 0; padding: 0; border: 0; font-size: 100%; font: inherit; vertical-align: baseline; } /* HTML5 display-role reset for older browsers */ article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section { display: block; } ol, ul { list-style: none; } blockquote, q { quotes: none; } blockquote:before, blockquote:after, q:before, q:after { content: ''; content: none; } table { border-collapse: collapse; border-spacing: 0; }


li:focus,
button:focus,
input:focus,
textarea:focus {
    outline: none !important;
    box-shadow: none !important;
}

        /* layout end */
        
        /*scroll*/
::selection{background:#895ffc;color:#fff;text-shadow:none;}
::-webkit-scrollbar{width:10px;background-color:#F5F5F5;}
::-webkit-scrollbar-button:start:decrement,::-webkit-scrollbar-button:end:increment{display:none;}
::-webkit-scrollbar-track-piece{-webkit-box-shadow:inset 0 0 6px rgba(0,0,0,.3);background-color:#dedede;}
::-webkit-scrollbar-thumb:vertical{border-radius:10px;-webkit-box-shadow:inset 0 0 6px rgba(0,0,0,.3);background-image:linear-gradient(#000,#000);}
/*body*/
.overflw{overflow:hidden;}
[class^="box-"]{display:none}
[class^="box-"].showfirst{display:block}
img{max-width:100%;height:auto;}
a:hover{text-decoration:none;-webkit-transition:all 0.4s ease-In-out;-moz-transition:all 0.4s ease-In-out;-o-transition:all 0.4s ease-In-out;transition:all 0.4s ease-In-out;}
p{line-height:1.4;}
body{padding:0;margin:0;overflow-x:hidden;font-family:"Montserrat";}
/*padding*/
.pad0{padding:0;}
.padL{padding-left:0;}
.padR{padding-right:0;}
.pad-top{padding-top:60px;}
.pad-btm{padding-bottom:40px;}
/*botton*/
.btn-a{background-color:#5eba60;border:2px solid #5eba60;border-radius:6px;color:white;padding:20px 40px;text-decoration:none;font-size:16px;font-weight:500;cursor:pointer;display:inline-block;-webkit-transition-duration:0.4s;transition-duration:0.4s;}
.btn-a:hover{background:transparent;color:#222222;}
/*heading*/
.m1-h h5{}
.m2-h h5{}
.m3-h h5{}
.m4-h h5{}
.m5-h h5{}
.m6-h h5{}
/*paragrape*/
.p1 p{}
.p2 p{}
.p3 p{}
.p4 p{}
.p5 p{}
.p6 p{}
/* Hamburger Menu */
.menu-Bar{width:30px;height:20px;cursor:pointer;position:absolute;right:15px;top:0;bottom:0px;margin:auto;z-index:22;display:none;}
.menu-Bar span{display:block;height:4px;width:100%;background:#000;position:absolute;transition:.6s all;border-radius:100px;}
.menu-Bar span:nth-child(1){top:0;}
.menu-Bar span:nth-child(2){top:8px;transform-origin:left;}
.menu-Bar span:nth-child(3){top:16px;}
.menu-Bar.open span{background:#fff;}
.menu-Bar.open span:nth-child(1){transform:rotate(45deg);top:12px;transform-origin:right-center;}
.menu-Bar.open span:nth-child(2){width:0;opacity:0;}
.menu-Bar.open span:nth-child(3){transform:rotate(-45deg);top:12px;transform-origin:right-center;}
/* click search field */
#demo-2 input[type=search]{width:30px;height:30px;color:#000;cursor:pointer;border:1px solid #fff;-webkit-transition-duration:0.4s;transition-duration:0.4s;border-radius:20px;}
#demo-2 input[type=search]{background:#fff url(https://static.tumblr.com/ftv85bp/MIXmud4tx/search-icon.png) no-repeat 9px center;border:solid 1px transparent;padding:9px 10px 9px 32px;width:45px;-webkit-border-radius:10em;-moz-border-radius:10em;border-radius:10em;-webkit-transition:all .5s;-moz-transition:all .5s;transition:all .5s;background-color:transparent;}
form#demo-2{position:absolute;top:-20px;}
.serch{position:relative;}
#demo-2 input[type=search]:focus{width:220px;padding-left:32px;color:#000;background-color:#fff;cursor:auto;border-radius:20px;border:1px solid #f5821f;}
/* sticky header */
header.sticky{background:#fff;box-shadow:0 8px 6px -6px #D3D3D3;-webkit-transition-duration:0.4s;transition-duration:0.4s;}
header{position:fixed;width:100%;background:#fff;background-color:transparent;color:#fff;-webkit-transition:all 0.4s ease;transition:all 0.4s ease;z-index:1;}
/*-----------------------------------------index-page-------------------------------------------------------------------*/
section.main{margin-top:50px;}
.main_head h1{text-align:center;font-size:25px;font-weight:700;margin-bottom:30px;}
.hea h2{font-size:17px;font-weight:400;margin-bottom:20px;}
.dea{text-align:center;margin-top: 10px; margin-bottom: 20px;}
.dea h2{font-weight:bold;font-size:20px;color:#000;}
.blacktab2 td,.blacktab2 th{border:3px solid #000000;height:200px;}
.mainstab{border:3px solid #000 !important;}
.mainstab td,.mainstab th{border:3px solid #000 !important;color:#000;}
.hea h2{font-weight:500;color:#000;}
table.table.blacktab.table-bordered.blacktab2{margin:0;}
.backhead{background:#adaaaa;text-align:center;padding:10px 0px;}
.conhead h2{font-size:25px;color:#000;font-weight:bold;}
.backhead2{background:#e7e6e6;text-align:center;padding:10px 0px;}
.conhead2 h2{font-size:17px;color:#000;font-weight:bold;}
.lb1 label{padding:0px 0px;margin-top:10px;color:#000;font-weight:500;}
.lb1{margin-top:10px;margin-bottom:20px;}
.radif{display:flex;align-items:center;justify-content:center;gap:30px;}
.Maintenance_Analysing_Report{margin-top:50px;}
.lb1.stg{text-align:center;}

@media (max-width:1680px){}
@media (max-width:1440px){}
@media (max-width:1024px){}
@media (max-width:1200px){.menu-Bar{display:block;top:0px;}
.menuWrap.open{display:flex;left:0px;}
.menuWrap{position:fixed;left:-210%;right:0;top:0;bottom:0;margin:auto;background:#175fab;height:100vh;display:flex;align-items:center;justify-content:center;flex-flow:column;transition:all 0.4s ease;z-index:3;width:100vw;}
.menuWrap .menu li{display:block;}
.menuWrap .menu li a{margin-bottom:10px;padding:0;display:block;text-align:center;margin-bottom:15px;padding-right:0px;margin-right:0px;color:#fff;font-size:15px;text-transform:capitalize;}
.container{position:relative;}
header .header-top{display:none;}
header .main-header ul.menu>li{display:block;padding:0px;}
header .main-header ul.menu>li a{color:#fff;padding:0px;text-align:left;}
header .main-header ul.menu>li a:before{display:none;}
}
@media (max-width:980px){}
@media (max-width:768px){}
@media (min-width:440px) and (max-width:740px){}
@media (max-width:425px){}
@media (max-width:700px) and (max-height:450px){}

    </style>    
    <div class="container-fluid">
        
         <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <div class="main_head">
                <br/>
                  <h1>Maintenance Analysing Report</h1>
                  <div class="sub_head">
                        
                     <!-- section-1 -->
                     <div class="sec1">
                        <!-- Maintenance Analysing Report -->
                        <div class="Maintenance_Analysing_Report">
                           {{-- @if($maintenanceRequest->analysing_required == 'yes') --}}
                              <div class="row align-items-center" style="margin-bottom: 2%;">
                                 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <label style="font-weight:bold;">Deparment</label>
                                    <input disabled type="text" value="{{optional($maintenanceRequest->department)->sub_department_name ?? ''}}" class="form-control"/>
                                 </div>
                                 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <label style="font-weight:bold;">Machinery</label>
                                    <input disabled value="{{optional($maintenanceRequest->machine)->name ?? ''}}" type="text" class="form-control"/>
                                 </div>
                                 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <label style="font-weight:bold;">Location</label>
                                    <input disabled value="{{optional($maintenanceRequest->warehouse)->name ?? ''}}" type="text" class="form-control"/>
                                 </div>
                                 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <label style="font-weight:bold;">Line</label>
                                    <input disabled value="{{optional($maintenanceRequest->line)->name ?? ''}}" type="text" class="form-control"/>
                                 </div>
                        
                              </div>
                           {{-- @endif --}}
                        <div class="row align-items-center">
                           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                               <label style="font-weight:bold;">Equipment Refrence &nbsp;&nbsp; <span onclick="addReference(this)" style="cursor:pointer;" class="btn btn-sm btn-success">+<span></label>
                               <input type="text" name="equipment_reference[]" class="form-control"/>
                               <div id="reference-container"></div>
                           </div>
                           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                               <label style="font-weight:bold;">Section &nbsp;&nbsp; <span onclick="addSection(this)" style="cursor:pointer;" class="btn btn-sm btn-success">+<span></label>
                               <input type="text" name="section[]" class="form-control"/>
                               <div id="section-container"></div>
                           </div>
                           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                               <label style="font-weight:bold;">Category &nbsp;&nbsp; <span onclick="addCategory(this)" style="cursor:pointer;" class="btn btn-sm btn-success">+<span></label>
                               <input type="text" name="category[]" class="form-control"/>
                               <div id="category-container"></div>
                           </div>
                           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                               <label style="font-weight:bold;">Cost Head For the Damage Unit (Common Issue) &nbsp;&nbsp; <span onclick="addCommonIssue(this)" style="cursor:pointer;" class="btn btn-sm btn-success">+<span></label>
                               <input type="text" name="common_issue[]" class="form-control"/>
                               <div id="common_issue-container"></div>
                           </div>
                           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                               <label style="font-weight:bold;">Cost Head For the Damage Unit (Staff Intelegence) &nbsp;&nbsp; <span n onclick="addStaffIntelegence(this)" style="cursor:pointer;" class="btn btn-sm btn-success">+<span></label>
                               <input type="text" name="staff_intelegence[]" class="form-control"/>
                               <div id="staff_intelegence-container"></div>
                           </div>
                       </div>
                        <div class="row align-items-center">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label style="font-weight:bold;">Details</label>
                                <textarea name="detail" class="form-control"></textarea>
                            </div>
                        </div>    

                           <div class="row align-items-center">
   
                              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                 <div class="hea">
                                    <h2>MR# :   {{ $maintenanceRequest->voucher_no }}</h2>
                                 </div>
                              </div>
   
                              
                        </div>

                        <!-- --------------------------------------------------1------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>1</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Inspecting Motor and Rotors</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 1 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm">
                                       <p><input type="checkbox" name="check_points_for_inspecting_motor_and_rotors" id="active" value="1"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 1 -->
                        <div class="check1">
                           <div id="active_sub" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Motor Type</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Motor KW/HP</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Motor RPM</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Body broken</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Burn visual sign of winding</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Cooling Fan of motor</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Protection Covers condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Base foot condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Rotor shaft condition for wear out</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Bearing hub bore for wear</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Statar condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Motor Casing</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Rotor shaft run out check on lathe machine</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Connection box condition</label>
                                    </div>  
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="motor_type" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       <input type="text" name="motor_kw_hp" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       <input type="text" name="motor_rpm" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="body_broken" value="1">
                                                Yes
                                             </label>
                                             <label>
                                                <input type="radio" name="body_broken" value="0">
                                                No
                                             </label>
                                          </div>
                                     
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="burn_sign" value="1">
                                                Yes
                                             </label>
                                             <label>
                                                <input type="radio" name="burn_sign" value="0">
                                                No
                                             </label>
                                          </div>
                                      
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="cooling_fan_of_motor" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="cooling_fan_of_motor" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="protection_cover" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="protection_cover" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="base_foot_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="base_foot_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="rotor_shaft_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="rotor_shaft_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_hub_bor" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_hub_bor" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="stater_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="stater_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="motor_casing" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="motor_casing" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="motor_shaft_run_ot_check" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="motor_shaft_run_ot_check" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="connection_box_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="connection_box_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- --------------------------------------------------2------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>2</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Inspecting Shaft</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 2 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm2">
                                       <p><input type="checkbox" name="check_points_for_inspecting_shaft" id="active2" value="2"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 2 -->
                        <div class="check1">
                           <div id="active_sub2" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">shaft size Dia x length (mm)</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical appearance for wear tear</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Bearing size wear out</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Carter condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Shaft physical check for cracks</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="shaft_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio"  name="physical_appearance" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="physical_appearance" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_size" value="1">
                                                Yes
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_size" value="0">
                                                No
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="carter_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="carter_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="shaft_physical" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="shaft_physical" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                      <!-- --------------------------------------------------3------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>3</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Inspecting Rollor</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 3 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm3">
                                       <p><input type="checkbox" name="check_points_for_inspecting_rollor" id="active3" value="3"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 3 -->
                        <div class="check1">
                           <div id="active_sub3" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">size Dia (mm)</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical appearance for wear tear</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual apearance of crack</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="rollor_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="rollor_physical_appearance" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="rollor_physical_appearance" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="rollor_appearance_of_crack" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="rollor_appearance_of_crack" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                      <!-- --------------------------------------------------4------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>4</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Inspecting Sprockets</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 4 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm4">
                                       <p><input type="checkbox" name="check_points_for_inspecting_sprockets" id="active4" value="4"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 4 -->
                        <div class="check1">
                           <div id="active_sub4" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Sprocket size</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical appearance for wear tear of sprockets teeth</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual apearance of crack</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="sprocket_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input name="sprocket_physical_appearance" type="radio" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="sprocket_physical_appearance" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="sprocket_visual_appearance" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="sprocket_visual_appearance" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>


                      <!-- --------------------------------------------------5------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>5</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Inspecting Gears</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 5 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm5">
                                       <p><input type="checkbox" name="check_points_for_inspecting_gears" id="active5" value="5"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 5 -->
                        <div class="check1">
                           <div id="active_sub5" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Gear size</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical appearance for wear of gear teeths</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Run out check on lathe machine</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Surface condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Bore /carter condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Teeths pattern check with pitch size</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="gear_type" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="gear_size" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="gear_size" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="gear_size_physical_appearance" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="gear_size_physical_appearance" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="run_out_check" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="run_out_check" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="surface_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="surface_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bore_carter_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bore_carter_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="teeth_pattern_check" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="teeth_pattern_check" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- section-2 -->
                     <div class="sec2">
                        <!-- Maintenance Analysing Report -->
                        <div class="Maintenance_Analysing_Report">
                           <div class="row align-items-center">
   
                              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                 <div class="hea">
                                    <h2>MR# :   {{ $maintenanceRequest->voucher_no }}</h2>
                                 </div>
                              </div>
   
                              
                        </div>

                        <!-- --------------------------------------------------6------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>6</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for pulley</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 6 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm">
                                       <p><input type="checkbox" name="check_points_for_pulley" id="active6" value="6"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 6 -->
                        <div class="check1">
                           <div id="active_sub6" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Pulley size</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical appearance for wear tear of pulley</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual apearance corrosive / Damage</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Carter pin wear sign</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Internal bore for wear out</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Surface condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Run out on lathe machine</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Grove condition for belts</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" class="form-control" name="pulley_size" placeholder="Mannual Enter">
                                    </div>
                                    
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="pulley_physical_appearance" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="pulley_physical_appearance" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="pulley_visual_appearance" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="pulley_visual_appearance" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="pulley_carter_pin" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="pulley_carter_pin" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="pulley_internal_bore" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="pulley_internal_bore" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="pulley_surface_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="pulley_surface_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="pulley_runout_on_lathe_machine" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="pulley_runout_on_lathe_machine" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="pulley_groove_condition_for_belt" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="pulley_groove_condition_for_belt" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>

                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- --------------------------------------------------7------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>7</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for multi groove pulley</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 7 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm2">
                                       <p><input type="checkbox" name="check_points_for_multi_groove_pulley" id="active7" value="7"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 7 -->
                        <div class="check1">
                           <div id="active_sub7" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Pulley size</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical appearance for wear tear of pulley</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual apearance corrosive / Damage</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Internal bore for wear out</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Carter pin wear out</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Surface condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Run out on lathe machine</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Grove condition for belts</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="multi_groove_pulley_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="multi_groove_pulley_physical_appearance" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="multi_groove_pulley_physical_appearance" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="multi_groove_pulley_visual_appearance" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="multi_groove_pulley_visual_appearance" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="multi_groove_pulley_carter_pin" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="multi_groove_pulley_carter_pin" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="multi_groove_pulley_internal_bore" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="multi_groove_pulley_internal_bore" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="multi_groove_pulley_surface_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="multi_groove_pulley_surface_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="multi_groove_pulley_runout_on_lathe_machine" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="multi_groove_pulley_runout_on_lathe_machine" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="multi_groove_pulley_condition_for_belt" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="multi_groove_pulley_condition_for_belt" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                      <!-- --------------------------------------------------8------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>8</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Metallic Frames</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 8 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm8">
                                       <p><input type="checkbox" name="check_points_for_metallic_frames" id="active8" value="8"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 8 -->
                        <div class="check1">
                           <div id="active_sub8" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Meterial of frame</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical appearance for wear of frame</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual apearance corrosive / Damage</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Welding of frames</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Surface condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical condition for corrosions</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Grove condition for belts</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="material_of_frame" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="metallic_frame_physical_appearance" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="metallic_frame_physical_appearance" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="metallic_frame_visual_appearance" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="metallic_frame_visual_appearance" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="welding_of_frame" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="welding_of_frame" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="metallic_frame_surface_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="metallic_frame_surface_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="metallic_frame_physical_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="metallic_frame_physical_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="metallic_frame_groove_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="metallic_frame_groove_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                      <!-- --------------------------------------------------9------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>9</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Mild steel Rollors</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 9 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm9">
                                       <p><input type="checkbox" name="check_points_for_mild_steel_rollors" id="active9" value="9"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 9 -->
                        <div class="check1">
                           <div id="active_sub9" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Rollor size in diameter</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Surface condition of rollor</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Axle condition for bend</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Internal bore for wear out</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Run out check on lathe machines</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical condition for corrosions</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="rollor_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="surface_condition_of_rollor" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="surface_condition_of_rollor" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="axle_condition_for_band" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="axle_condition_for_band" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="internal_bore_for_rollor" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="internal_bore_for_rollor" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="rollor_runout_check_on_lethe_machine" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="rollor_runout_check_on_lethe_machine" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="rollor_physical_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="rollor_physical_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>


                      <!-- --------------------------------------------------10------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>10</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Rubber Rollors</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 10 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm10">
                                       <p><input type="checkbox" name="check_points_for_rubber_rollors" id="active10" value="10"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 10 -->
                        <div class="check1">
                           <div id="active_sub10" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Rollor size in diameter</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Surface condition of rollor for wear</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Internal bore for wear out</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Axle condition for damage</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Run out check on lathe machines</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="rubber_rollor_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="rubber_rollor_surface_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="rubber_rollor_surface_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       <!-- 
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="" value="1">
                                                Yes
                                             </label>
                                             <label>
                                                <input type="radio" name="" value="0">
                                                No
                                             </label>
                                          </div> -->
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="rubber_rollor_internal_bore" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="rubber_rollor_internal_bore" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="rubber_rollor_axle_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="rubber_rollor_axle_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="rubber_rollor_runout_check" value="1">
                                                Yes
                                             </label>
                                             <label>
                                                <input type="radio" name="rubber_rollor_runout_check" value="0">
                                                No
                                             </label>
                                          </div> 
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- section-3 -->
                     <div class="sec3">
                        <!-- Maintenance Analysing Report -->
                        <div class="Maintenance_Analysing_Report">
                           <div class="row align-items-center">
   
                              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                 <div class="hea">
                                    <h2>MR# :   {{ $maintenanceRequest->voucher_no }}</h2>
                                 </div>
                              </div>
   
                              
                        </div>

                        <!-- --------------------------------------------------11------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>11</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Screw worm conveyor</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 11 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm11">
                                       <p><input type="checkbox" name="check_points_for_screw_worm" id="active11" value="11"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 11 -->
                        <div class="check1">
                           <div id="active_sub11" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Size</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Surface condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Sag</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Condition for damage</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Run out check on lathe machines</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical condition for corrosions</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Bearing size wear out check</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Any damage sign on screw conveyor</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="screw_worm_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="screw_worm_surface_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="screw_worm_surface_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="screw_worm_sag" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="screw_worm_sag" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="screw_worm_damage_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="screw_worm_damage_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="screw_worm_runout_check" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="screw_worm_runout_check" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="screw_worm_physical_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="screw_worm_physical_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="screw_worm_bearing_size" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="screw_worm_bearing_size" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="any_damage_sign_on_screw_conveyor" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="any_damage_sign_on_screw_conveyor" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- --------------------------------------------------12------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>12</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for bucket conveyor</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 12 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm12">
                                       <p><input type="checkbox" name="check_points_for_bucket_conveyor" id="active12" value="12"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 12 -->
                        <div class="check12">
                           <div id="active_sub12" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Size</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Surface condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Drum rollors for wear out</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Sag codition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Condition for damage</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Run out check on lathe machines</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical condition for corrosions</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Bearing size wear out check</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Any damage sign on screw conveyor</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="bucket_conveyor_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input name="bucket_conveyor_surface_condition" type="radio" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bucket_conveyor_surface_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bucket_conveyor_drum_rollars" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bucket_conveyor_drum_rollars" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bucket_conveyor_sag" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bucket_conveyor_sag" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bucket_conveyor_damage_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bucket_conveyor_damage_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bucket_conveyor_runout_check" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bucket_conveyor_runout_check" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bucket_conveyor_physical_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bucket_conveyor_physical_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bucket_conveyor_bearing_size" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bucket_conveyor_bearing_size" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="any_damage_sign_on_bucket_screw_conveyor" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="any_damage_sign_on_bucket_screw_conveyor" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                      <!-- --------------------------------------------------13------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>13</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for couplings</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 13 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm13">
                                       <p><input type="checkbox" name="check_points_for_couplings" id="active13" value="13"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 13 -->
                        <div class="check1">
                           <div id="active_sub13" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Size ID/OD</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Surface condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Condition for damage sign</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Run out check on lathe machines</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical condition for corrosions</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Chuck nut wear out condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Carter pin</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Internal bore wearout size</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="coupling_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="coupling_surface_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="coupling_surface_condition" value="0">
                                                Not
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="coupling_damage_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="coupling_damage_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="coupling_runout_check" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="coupling_runout_check" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="coupling_physical_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="coupling_physical_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="coupling_chuck_nut" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="coupling_chuck_nut" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="coupling_carter_pin" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="coupling_carter_pin" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="coupling_internal_bore" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="coupling_internal_bore" value="0">
                                                Not
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                      <!-- --------------------------------------------------14------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>14</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for flywheels</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 14 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm14">
                                       <p><input type="checkbox" name="check_points_for_flywheels" id="active14" value="14"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 14 -->
                        <div class="check1">
                           <div id="active_sub14" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Size outer dia</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Surface condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Condition for damage sign</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Run out check on lathe machines</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical condition for corrosions</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">carter wear out condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Internal bore condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Bolt tightness </label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Weld and structural integrity</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="flywheels_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="flywheels_surface_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="flywheels_surface_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="flywheels_damage_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="flywheels_damage_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="flywheels_runout_check" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="flywheels_runout_check" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="flywheels_physical_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="flywheels_physical_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="flywheels_carter_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="flywheels_carter_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="flywheels_internal_bore" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="flywheels_internal_bore" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="flywheels_bolt_tightness" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="flywheels_bolt_tightness" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="flywheels_weld_and_structural" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="flywheels_weld_and_structural" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>


                        <!-- Maintenance Analysing Report -->
                        <div class="Maintenance_Analysing_Report">
                           <div class="row align-items-center">
   
                              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                 <div class="hea">
                                    <h2>MR# :   {{ $maintenanceRequest->voucher_no }}</h2>
                                 </div>
                              </div>
   
                              
                        </div>

                      <!-- --------------------------------------------------15------------------------------------------------------------------ -->
                      <div class="backhead">
                           <div class="conhead">
                              <h2>15</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Bearings hub</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 15 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm15">
                                       <p><input type="checkbox" name="check_points_for_bearing_hub" id="active15" value="15"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 15 -->
                        <div class="check1">
                           <div id="active_sub15" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Size outer dia /meterial</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Surface condition visual</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Bearing condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Mounting bolts conditions</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical condition for corrosions</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Internal bore condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Bolt tightness</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Weld and structural integrity</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="bearing_hub_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_hub_surface_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_hub_surface_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_hub_bearing_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_hub_bearing_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_hub_mounting_bolts_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_hub_mounting_bolts_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_hub_physical_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_hub_physical_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_hub_internal_bore" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_hub_internal_bore" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_hub_bolt_tightness" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_hub_bolt_tightness" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_hub_weld_and_structural" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_hub_weld_and_structural" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- section-4 -->
                     <div class="sec4">
                        
                        <!-- --------------------------------------------------16------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>16</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for gear box</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 16 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm16">
                                       <p><input type="checkbox" name="check_points_for_gear_box" id="active16" value="16"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 16 -->
                        <div class="check1">
                           <div id="active_sub16" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Type/Machines</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual condition of gear train</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Bearing condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Mounting bolts conditions</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical condition for corrosions</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Oil level</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">oil leaks</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Gear teath condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Seals conditions</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="gear_box_type" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="gear_box_visual_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="gear_box_visual_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="gear_box_bearing_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="gear_box_bearing_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="gear_box_mounting_bolts" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="gear_box_mounting_bolts" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="gear_box_physical_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="gear_box_physical_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="gear_box_oil_level" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="gear_box_oil_level" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="gear_box_oil_leaks" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="gear_box_oil_leaks" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="gear_box_teath_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="gear_box_teath_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="gear_box_seals_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="gear_box_seals_conditions" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- --------------------------------------------------17------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>17</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Air Blower</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 17 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm17">
                                       <p><input type="checkbox" name="check_points_for_air_blower" id="active17" value="17"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 17 -->
                        <div class="check1">
                           <div id="active_sub17" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Type/Machines</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Bearing condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Mounting bolts conditions</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Impeller condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Shaft condition for wear out</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Run out check on lathe</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Body dented sign</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="air_blower_type" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="air_blower_visual_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="air_blower_visual_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="air_blower_bearing_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="air_blower_bearing_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="air_blower_mounting_bolts" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="air_blower_mounting_bolts" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="air_blower_impellar_condtion" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="air_blower_impellar_condtion" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="air_blower_shaft_condtion" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="air_blower_shaft_condtion" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="air_blower_runout_check" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="air_blower_runout_check" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="air_blower_body_dent_sign" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="air_blower_body_dent_sign" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                      <!-- --------------------------------------------------18------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>18</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Bearings</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 18 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm18">
                                       <p><input type="checkbox" name="check_points_for_bearings" id="active18" value="18"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 18 -->
                        <div class="check1">
                           <div id="active_sub18" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Bearing no</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual condition outer race</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Bearing cage condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual condition inner race</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Jammed during operation</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Body damage sign</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="bearing_no" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_visual_condition_outer_race" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_visual_condition_outer_race" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_cage_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_cage_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_visual_condition_inner_race" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_visual_condition_inner_race" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_jammed_during_operation" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_jammed_during_operation" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_body_damage_sign" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_body_damage_sign" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>


                        <!-- Maintenance Analysing Report -->
                        <div class="Maintenance_Analysing_Report">
                           <div class="row align-items-center">
   
                              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                 <div class="hea">
                                    <h2>MR# :   {{ $maintenanceRequest->voucher_no }}</h2>
                                 </div>
                              </div>
   
                              
                        </div>

                      <!-- --------------------------------------------------19------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>19</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for SS pipes</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 19 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm19">
                                       <p><input type="checkbox" name="check_points_for_ss_pipes" id="active19" value="19"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 19 -->
                        <div class="check1">
                           <div id="active_sub19" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Pipe size diaxlength</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual condition for corrsion</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Pin holes</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="ss_pipe_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="ss_pipe_visual_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="ss_pipe_visual_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="ss_pipe_pin_hole" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="ss_pipe_pin_hole" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>


                      <!-- --------------------------------------------------20------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>20</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for MS pipes</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 20 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm20">
                                       <p><input type="checkbox" name="check_points_for_ms_pipes" id="active20" value="20"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 20 -->
                        <div class="check1">
                           <div id="active_sub20" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Pipe size diaxlength</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual condition for corrsion</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Pin holes</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="ms_pipe_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="ms_pipe_visual_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="ms_pipe_visual_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="ms_pipe_pin_hole" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="ms_pipe_pin_hole" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>


                        <!-- --------------------------------------------------21------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>21</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Hoses (steel braided)</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 21 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm21">
                                       <p><input type="checkbox" name="check_points_for_hoses" id="active21" value="21"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 21 -->
                        <div class="check1">
                           <div id="active_sub21" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Pipe size diaxlength</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual condition for corrsion</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Pin holes</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Clamp leakages</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="hoses_pipe_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="hoses_visual_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="hoses_visual_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="hoses_pin_hole" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="hoses_pin_hole" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="hoses_claim_leakages" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="hoses_claim_leakages" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- --------------------------------------------------22------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>22</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Belt conveyor</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 22 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm22">
                                       <p><input type="checkbox" name="check_points_for_belt_conveyor" id="active22" value="22"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 22 -->
                        <div class="check1">
                           <div id="active_sub22" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">size</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual condition for corrsion</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Pin holes/pealings or damage signs</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Crack damages on jointers</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="belt_conveyor_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="belt_conveyor_visual_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="belt_conveyor_visual_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="belt_conveyor_pin_holes" value="1">
                                                Yes
                                             </label>
                                             <label>
                                                <input type="radio" name="belt_conveyor_pin_holes" value="0">
                                                No
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="belt_conveyor_crack_damages" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="belt_conveyor_crack_damages" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- --------------------------------------------------23------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>23</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for pulley Belt</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 23 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm23">
                                       <p><input type="checkbox" name="check_points_for_pulley_belt" id="active23" value="23"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 23 -->
                        <div class="check1">
                           <div id="active_sub23" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Type</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual condition wear out</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">pealings or damage signs</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual cut/Slip on signs</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="pulley_belt_type" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="pulley_belt_visual_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="pulley_belt_visual_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="pulley_belt_damage_sign" value="1">
                                                Yes
                                             </label>
                                             <label>
                                                <input type="radio" name="pulley_belt_damage_sign" value="0">
                                                No
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="pulley_belt_visual_cut" value="1">
                                                Yes
                                             </label>
                                             <label>
                                                <input type="radio" name="pulley_belt_visual_cut" value="0">
                                                No
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>



                        <!-- --------------------------------------------------24------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>24</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Sieve</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 24 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm24">
                                       <p><input type="checkbox" name="check_points_for_sieve" id="active24" value="24"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 24 -->
                        <div class="check1">
                           <div id="active_sub24" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Type/Machine</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual condition wear out</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Sieve damage signs</label>
                                    </div>

                                    <div class="lb1">
                                       <label for="">Visual cut on sieve</label>
                                    </div>

                                    <div class="lb1">
                                       <label for="">Frame of sieve for corrision</label>
                                    </div>

                                    <div class="lb1">
                                       <label for="">Frame weld condition</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="sieve_type" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="sieve_visual_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="sieve_visual_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="sieve_damage_sign" value="1">
                                                Yes
                                             </label>
                                             <label>
                                                <input type="radio" name="sieve_damage_sign" value="0">
                                                No
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="sieve_visual_cut" value="1">
                                                Yes
                                             </label>
                                             <label>
                                                <input type="radio" name="sieve_visual_cut" value="0">
                                                No
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="sieve_frame" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="sieve_frame" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="sieve_frame_weld_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="sieve_frame_weld_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- --------------------------------------------------25------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>25</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for cutter Blades SS/MS</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 25 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm25">
                                       <p><input type="checkbox" name="check_points_for_blades" id="active25" value="25"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 25 -->
                        <div class="check1">
                           <div id="active_sub25" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Type/size</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual condition wear out on blades</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Damage signs</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Edge sharpness</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Frame of Blade for corrision</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="blades_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="blades_visual_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="blades_visual_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="blades_damage_sign" value="1">
                                                Yes
                                             </label>
                                             <label>
                                                <input type="radio" name="blades_damage_sign" value="0">
                                                No
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="blades_edge_sharpness" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="blades_edge_sharpness" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="blades_frame" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="blades_frame" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- section-5 -->
                     <div class="sec5">
                        <!-- Maintenance Analysing Report -->
                        <div class="Maintenance_Analysing_Report">
                           <div class="row align-items-center">
   
                              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                 <div class="hea">
                                    <h2>MR# :   {{ $maintenanceRequest->voucher_no }}</h2>
                                 </div>
                              </div>
   
                              
                        </div>

                        <!-- --------------------------------------------------26------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>26</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Water pump</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 26 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm26">
                                       <p><input type="checkbox" name="check_points_for_water_pump" id="active26" value="26"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 26 -->
                        <div class="check1">
                           <div id="active_sub26" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Type/size</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Motor abnormality in operation</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual condition of foundation</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Damage signs on body</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Coupling conditions</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Violute casing corrision</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">impeller condition and bore size</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="water_pump_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="water_pump_motor_abnormality" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="water_pump_motor_abnormality" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="water_pump_visual_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="water_pump_visual_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="water_pump_damage_sign" value="1">
                                                Yes
                                             </label>
                                             <label>
                                                <input type="radio" name="water_pump_damage_sign" value="0">
                                                No
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="water_pump_coupling_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="water_pump_coupling_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="water_pump_violute_casing" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="water_pump_violute_casing" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="water_pump_impellar_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="water_pump_impellar_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- --------------------------------------------------27------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>27</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Bearings blocks</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 27 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm27">
                                       <p><input type="checkbox" name="check_points_for_bearing_blocks" id="active27" value="27"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 27 -->
                        <div class="check1">
                           <div id="active_sub27" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Size</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Surface condition visual</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Bearing condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Mounting stud conditions</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical condition for corrosions</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Internal bore condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Bolt tightness</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="bearing_block_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_block_surface_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_block_surface_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_block_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_block_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_block_mounting_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_block_mounting_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_block_physical_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_block_physical_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_block_internal_bore" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_block_internal_bore" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="bearing_block_bolt_tightness" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="bearing_block_bolt_tightness" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                      <!-- --------------------------------------------------28------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>28</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Induced drafts fans</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 28 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm28">
                                       <p><input type="checkbox" name="check_points_for_induced_drafts_fans" id="active28" value="28"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 28 -->
                        <div class="check1">
                           <div id="active_sub28" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Type</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Surface condition visual</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Bearing condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Basement mount</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical condition for corrosions</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Internal bore condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Bolt tightness with carter pin</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="induced_drafts_fans_type" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="induced_drafts_fans_surface_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="induced_drafts_fans_surface_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="induced_drafts_fans_bearing_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="induced_drafts_fans_bearing_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="induced_drafts_fans_basement_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="induced_drafts_fans_basement_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="induced_drafts_fans_physical_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="induced_drafts_fans_physical_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="induced_drafts_fans_internal_bore" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="induced_drafts_fans_internal_bore" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="induced_drafts_fans_bolt_tightness" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="induced_drafts_fans_bolt_tightness" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                      <!-- --------------------------------------------------29------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>29</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Air lock vales</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 29 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm29">
                                       <p><input type="checkbox" name="check_points_for_air_lock_vales" id="active29" value="29"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 29 -->
                        <div class="check1">
                           <div id="active_sub29" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">Size /Type</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Surface condition visual</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Bearing condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Shaft wear condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical condition of bearing size on shaft</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Internal bore condition of air locks</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Bolt tightness with carter pin</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="air_lock_vales_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="air_lock_vales_surface_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="air_lock_vales_surface_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="air_lock_vales_bearing_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="air_lock_vales_bearing_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="air_lock_vales_shaft_wear_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="air_lock_vales_shaft_wear_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="air_lock_vales_physical_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="air_lock_vales_physical_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="air_lock_vales_internal_bore" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="air_lock_vales_internal_bore" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="air_lock_vales_bolt_tightness" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="air_lock_vales_bolt_tightness" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>


                      <!-- --------------------------------------------------30------------------------------------------------------------------ -->
                        <div class="backhead">
                           <div class="conhead">
                              <h2>30</h2>
                           </div>
                        </div>
                        <div class="backhead2">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                 <div class="conhead2">
                                    <h2>Check points for Inspecting Rottor</h2>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                 <!-- Check 30 -->
                                 <div class="fo1">
                                    <div class="demoForm" id="demoForm30">
                                       <p><input type="checkbox" name="check_points_for_inspecting_rottor" id="active30" value="30"></p>    
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Check 30 -->
                        <div class="check1">
                           <div id="active_sub30" style="display:none;">
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="lb1">
                                       <label for="">shaft size Dia x length (mm)</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Physical appearance for wear tear</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Visual apearance of crack</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Body damage sign</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">carter condition</label>
                                    </div>
                                    <div class="lb1">
                                       <label for="">Bearing size with internal bore</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <div class="lb1">
                                       <input type="text" name="inspecting_rottor_size" class="form-control" placeholder="Mannual Enter">
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="inspecting_rottor_physical_appearance" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="inspecting_rottor_physical_appearance" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="inspecting_rottor_visual_appearance" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="inspecting_rottor_visual_appearance" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="inspecting_rottor_body_damage_sign" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="inspecting_rottor_body_damage_sign" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="inspecting_rottor_carter_condition" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="inspecting_rottor_carter_condition" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                    <div class="lb1">
                                       
                                          <div class="radif">
                                             <label>
                                                <input type="radio" name="inspecting_rottor_bearing_size" value="1">
                                                ok
                                             </label>
                                             <label>
                                                <input type="radio" name="inspecting_rottor_bearing_size" value="0">
                                                Not ok
                                             </label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <br/>
                     <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button type="submit" class="btn btn-md btn-success">Submit</button>
                        </div>   
                     </div>   
                     <div class="signature hide">
                        <div class="row">
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                              <div class="lb1 stg">
                                 <label for="">Work Shop Manager</label>
                              </div>   
                              <div class="lb1 stg">
                              <br>
                              <br>
                                 ____________________
                              </div> 
                           </div>


                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div>


                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                              <div class="lb1 stg">
                                 <label for="">HOD</label>
                              </div> 
                              <div class="lb1 stg">
                                 <br>
                                 <br>
                                 ____________________
                              </div>   
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   
<script src="{{ URL::asset('assets/js/select2/js_tabindex.js') }}"></script>


<script>
//     $(document).ready(function() {
//     $("li:first-child").addClass("first");
//     $("li:last-child").addClass("last");
//     $('[href="#"]').attr("href", "javascript:;");
//     $('.menu-Bar').click(function() {
//         $(this).toggleClass('open');
//         $('.menuWrap').toggleClass('open');
//         $('body').toggleClass('ovr-hiddn');
//         $('body').toggleClass('overflw');
//     });

//    $('.index-slider').slick({
//         dots: false,
//         arrows: true,
//         infinite: true,
//         speed: 300,
//         slidesToShow: 1,
//         slidesToScroll: 1,
//         autoplay: true,
//         autoplaySpeed: 2000,
//         responsive: [
//         {
//             breakpoint: 825,
//             settings: {
//                 slidesToShow: 1,
//                 slidesToScroll: 1,
//                 infinite: true,
//                 dots: false,
//                 arrows:false
//             }
//         },
//         ]
//     });


//     $('.m-silder').slick({
//         dots: true,
//         arrows: true,
//         infinite: true,
//         fade: true,
//         speed: 300,
//         slidesToShow: 1,
//         slidesToScroll: 1,
//         autoplay: true,
//         autoplaySpeed: 2000,
//         responsive: [
//         {
//             breakpoint: 825,
//             settings: {
//                 slidesToShow: 1,
//                 slidesToScroll: 1,
//                 infinite: true,
//                 dots: true,
//                 arrows:false
//             }
//         },
//         ]
//     });

//             $('.product-slid').slick({
//         dots: false,
//         arrows: false,
//         infinite: true,
//         speed: 300,
//         slidesToShow: 5,
//         slidesToScroll: 1,
//         autoplay: true,
//         autoplaySpeed: 2000,
//         responsive: [
//         {
//             breakpoint: 825,
//             settings: {
//                 slidesToShow: 1,
//                 slidesToScroll: 1,
//                 infinite: true,
//                 dots: false,
//                 arrows:false
//             }
//         },
//         ]
//     });

//         $('.client-slider').slick({
//         dots: false,
//         arrows: true,
//         infinite: true,
//         speed: 300,
//         slidesToShow: 1,
//         slidesToScroll: 1,
//         autoplay: true,
//         autoplaySpeed: 2000,
//         responsive: [
//         {
//             breakpoint: 825,
//             settings: {
//                 slidesToShow: 1,
//                 slidesToScroll: 1,
//                 infinite: true,
//                 dots: false,
//                 arrows:false
//             }
//         },
//         ]
//     });

//     $('.event-slider').slick({
//         dots: false,
//         arrows: true,
//         speed: 300,
//         slidesToShow: 3,
//         slidesToScroll: 1,
//         autoplay: false,
//         autoplaySpeed: 2000,
//         centerMode: true,
//         responsive: [
//         {
//             breakpoint: 825,
//             settings: {
//                 slidesToShow: 1,
//                 slidesToScroll: 1,
//                 infinite: true,
//                 dots: false,
//                 arrows:false
                
//             }
//         },
//         ]
//     });


// // counter javascript start

// $('.count').each(function () {
//     $(this).prop('Counter',0).animate({
//         Counter: $(this).text()
//     }, {
//         duration: 4000,
//         easing: 'swing',
//         step: function (now) {
//             $(this).text(Math.ceil(now));
//         }
//     });
// });

// // counter javascript end


//     $('ul.faq-ul li.active div').slideDown();
//     $('ul.faq-ul li h4').click(function() {
//         $('ul.faq-ul li').removeClass('active');
//         $(this).parent('li').addClass('active');
//         $('ul.faq-ul li div').slideUp();
//         $(this).parent('li').find('div').slideDown();
//     });
    
//         $('.faq-ul>li').click(function(){
//             $(this).addClass('active');
//             $(this).siblings().removeClass('active');
//         });
    
//         $('.fancybox-media').fancybox({
//             openEffect: 'none',
//             closeEffect: 'none',
//             helpers: {
//                 media: {}
//             }
//         });

//     $('.searchBtn').click(function() {
//         $('.searchWrap').addClass('active');
//         $('.overlay').fadeIn('active');
//         $('.searchWrap input').focus();
//         $('.searchWrap input').focusout(function(e) {
//             $(this).parents().removeClass('active');
//             $('.overlay').fadeOut('active');
//             $('body').removeClass('ovr-hiddn');

//         });
//     });

// });


// $(window).on('load', function() {
//     var currentUrl = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
//     $('ul.menu li a').each(function() {
//         var hrefVal = $(this).attr('href');
//         if (hrefVal == currentUrl) {
//             $(this).removeClass('active');
//             $(this).closest('li').addClass('active')
//             $('ul.menu li.first').removeClass('active');
//         }
//     })

// });

// tabing

//      $('[data-targetit]').on('click', function(e) {
//   $(this).addClass('current');
//   $(this).siblings().removeClass('current');
//   var target = $(this).data('targetit');
//   $('.' + target).siblings('[class^="box-"]').hide();
//   $('.' + target).fadeIn();
// });


     // sticky header

//      $(window).scroll(function() {
//     if ($(this).scrollTop() > 500){  
//         $('').addClass("box-visable");
//     }
//     else{
//         $('').removeClass("box-visable");
//     }
// });


// slider additional js for tabbing
    // $("[data-targetit]").on("click", function (e) {
    //     $(".test").slick("setPosition");
    // });


// Checkbox1
// assign function to onclick property of checkbox
document.getElementById('active').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}
// Checkbox2
// assign function to onclick property of checkbox
document.getElementById('active2').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub2');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox3
// assign function to onclick property of checkbox
document.getElementById('active3').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub3');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox4
// assign function to onclick property of checkbox
document.getElementById('active4').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub4');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox5
// assign function to onclick property of checkbox
document.getElementById('active5').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub5');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox6
// assign function to onclick property of checkbox
document.getElementById('active6').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub6');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox7
// assign function to onclick property of checkbox
document.getElementById('active7').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub7');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox8
// assign function to onclick property of checkbox
document.getElementById('active8').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub8');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox9
// assign function to onclick property of checkbox
document.getElementById('active9').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub9');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox10
// assign function to onclick property of checkbox
document.getElementById('active10').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub10');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox11
// assign function to onclick property of checkbox
document.getElementById('active11').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub11');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}
// Checkbox12
// assign function to onclick property of checkbox
document.getElementById('active12').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub12');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox13
// assign function to onclick property of checkbox
document.getElementById('active13').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub13');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox14
// assign function to onclick property of checkbox
document.getElementById('active14').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub14');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox15
// assign function to onclick property of checkbox
document.getElementById('active15').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub15');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox16
// assign function to onclick property of checkbox
document.getElementById('active16').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub16');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox17
// assign function to onclick property of checkbox
document.getElementById('active17').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub17');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox18
// assign function to onclick property of checkbox
document.getElementById('active18').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub18');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox19
// assign function to onclick property of checkbox
document.getElementById('active19').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub19');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox20
// assign function to onclick property of checkbox
document.getElementById('active20').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub20');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox21
// assign function to onclick property of checkbox
document.getElementById('active21').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub21');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}
// Checkbox22
// assign function to onclick property of checkbox
document.getElementById('active22').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub22');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox23
// assign function to onclick property of checkbox
document.getElementById('active23').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub23');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox24
// assign function to onclick property of checkbox
document.getElementById('active24').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub24');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox25
// assign function to onclick property of checkbox
document.getElementById('active25').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub25');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox26
// assign function to onclick property of checkbox
document.getElementById('active26').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub26');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox27
// assign function to onclick property of checkbox
document.getElementById('active27').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub27');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox28
// assign function to onclick property of checkbox
document.getElementById('active28').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub28');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox29
// assign function to onclick property of checkbox
document.getElementById('active29').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub29');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

// Checkbox30
// assign function to onclick property of checkbox
document.getElementById('active30').onclick = function() {
    // call toggleSub when checkbox clicked
    // toggleSub args: checkbox clicked on (this), id of element to show/hide
    toggleSub(this, 'active_sub30');
};

// called onclick of checkbox
function toggleSub(box, id) {
    // get reference to related content to display/hide
    var el = document.getElementById(id);
    
    if ( box.checked ) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}

function addReference() {
        var referenceContainer = document.getElementById('reference-container');
        var newRow = document.createElement('div');
        newRow.innerHTML = `
           
                <label style="font-weight:bold;">Equipment Reference &nbsp;&nbsp;<span class="btn btn-sm btn-danger" style="cursor:pointer;" onclick="removeReference(this)">-</span></label>
                <input type="text" name="equipment_reference[]" class="form-control"/>
           
        `;
        referenceContainer.appendChild(newRow);
    }

    // Function to remove an existing equipment reference field
    function removeReference(element) {
        var referenceRow = element.parentNode.parentNode;
        referenceRow.parentNode.removeChild(referenceRow);
    }

    function addSection() {
        var referenceContainer = document.getElementById('section-container');
        var newRow = document.createElement('div');
        newRow.innerHTML = `
           
                <label style="font-weight:bold;">Section &nbsp;&nbsp;<span class="btn btn-sm btn-danger" style="cursor:pointer;" onclick="removeSection(this)">-</span></label>
                <input type="text" name="section[]" class="form-control"/>
           
        `;
        referenceContainer.appendChild(newRow);
    }

    // Function to remove an existing equipment reference field
    function removeSection(element) {
        var referenceRow = element.parentNode.parentNode;
        referenceRow.parentNode.removeChild(referenceRow);
    }
    function addCategory() {
        var referenceContainer = document.getElementById('category-container');
        var newRow = document.createElement('div');
        newRow.innerHTML = `
           
                <label style="font-weight:bold;">Category &nbsp;&nbsp;<span class="btn btn-sm btn-danger" style="cursor:pointer;" onclick="removeCategory(this)">-</span></label>
                <input type="text" name="category[]" class="form-control"/>
           
        `;
        referenceContainer.appendChild(newRow);
    }

    // Function to remove an existing equipment reference field
    function removeCategory(element) {
        var referenceRow = element.parentNode.parentNode;
        referenceRow.parentNode.removeChild(referenceRow);
    }    

    function addCommonIssue() {
        var referenceContainer = document.getElementById('common_issue-container');
        var newRow = document.createElement('div');
        newRow.innerHTML = `
           
                <label style="font-weight:bold;">Cost Head For the Damage Unit (Common Issue) &nbsp;&nbsp;<span class="btn btn-sm btn-danger" style="cursor:pointer;" onclick="removeCommonIssue(this)">-</span></label>
                <input type="text" name="common_issue[]" class="form-control"/>
           
        `;
        referenceContainer.appendChild(newRow);
    }

    // Function to remove an existing equipment reference field
    function removeCommonIssue(element) {
        var referenceRow = element.parentNode.parentNode;
        referenceRow.parentNode.removeChild(referenceRow);
    } 

    function addStaffIntelegence() {
        var referenceContainer = document.getElementById('staff_intelegence-container');
        var newRow = document.createElement('div');
        newRow.innerHTML = `
           
                <label style="font-weight:bold;">Cost Head For the Damage Unit (Staff Intelegence) &nbsp;&nbsp;<span class="btn btn-sm btn-danger" style="cursor:pointer;" onclick="removeStaffIntelegence(this)">-</span></label>
                <input type="text" name="staff_intelegence[]" class="form-control"/>
           
        `;
        referenceContainer.appendChild(newRow);
    }

    // Function to remove an existing equipment reference field
    function removeStaffIntelegence(element) {
        var referenceRow = element.parentNode.parentNode;
        referenceRow.parentNode.removeChild(referenceRow);
    } 



 
</script>
<script>
    
	new WOW().init();
</script>
