<?php

use App\Helpers\CommonHelper;
use App\Helpers\HrHelper;
use App\Models\MenuPrivileges;
use App\Models\Menu;

$icons = [
    'Finance' => 'fa fa-usd',
    'Purchase' => 'fa fa-money-bill',
    'Inventory' => 'fa fa-list',
    'Store' => 'fa fa-shopping-cart',
    'Sales' => 'fa fa-money',
    'Reports' => 'fa fa-print',
    'Users' => 'glyphicon glyphicon-user',
    'Dashboard' => 'glyphicon glyphicon-home',
    'HR' => 'glyphicon glyphicon-heart',
    'Production' => 'glyphicon glyphicon-cog',
    'Import' => 'glyphicon glyphicon-import',
    'Inventory Reports' => 'fa fa-print',
    'HR Master' => 'glyphicon glyphicon-wrench',
    'Inventory Master' => 'glyphicon glyphicon-wrench',
    'Production Master' => 'glyphicon glyphicon-wrench',
    'Export' => 'glyphicon glyphicon-wrench',
    'Commodities' => 'glyphicon glyphicon-wrench',
    'Workshop' => 'glyphicon glyphicon-wrench',
    'Commodities Purchase' => 'glyphicon glyphicon-wrench',
    'Arrival' => 'glyphicon glyphicon-home',
    'Scrap Declration' => 'glyphicon glyphicon-home',
    'Setup' => 'glyphicon glyphicon-home',
];

$accType = Auth::user()->acc_type;
if ($accType == 'client') {
    $m = $_GET['m'];
} else {
    $m = Auth::user()->company_id;
}

$company_id = Session::get('run_company');
$user_rights = MenuPrivileges::where([['emp_code', '=', Auth::user()->emp_code], ['compnay_id', '=', $company_id]]);
$parent_code = [];
$crud_permission = '';
if ($user_rights->count() > 0):
    $main_modules = explode(',', $user_rights->value('main_modules'));
    $submenu_ids = explode(',', $user_rights->value('submenu_id'));
    $crud_rights = explode(',', $user_rights->value('crud_rights'));
    $companyList = $user_rights->value('company_list');

    foreach ($submenu_ids as $val):
        $parent_code[] = Menu::where([['id', '=', $val], ['status', '=', 1]])->value('m_parent_code');
    endforeach;
else:
    echo 'Account Type:' . $accType;
    echo 'Insufficient Menu Privileges' . '<br>';
    echo "<a href='" . url('/logout') . "'>Logout</a>";
    die();
endif;
?>


<header>

</header>



<div id="mySidenav" class="sidenavnr">
    <div class="logo_wrp">
         @if (Session::get('run_company') == 1)
            <img style="width: 50%;" class="" src="{{ url('/public/cfpl.jpg') }}">
        @else
            <img style="width: 80%;" class="" src="{{ url('/public/cte.jpg') }}">
        @endif
        <div class="o_f">
            <a href="#" class="closebtn theme-f-clr Navclose"><i class="glyphicon glyphicon-align-right"></i></a>
        </div>
    </div>
    @if (Session::get('run_company') != null)

        <?php
        
        $MainMenuTitles = DB::table('main_menu_title')
            ->select(['main_menu_id', 'id'])
            ->where([['status', '=', 1]])
            ->whereIn('id', $main_modules)
            ->groupBy('main_menu_id')
            ->orderBy('menu_type')
            ->orderBy('id')
            ->get();
        
        $counter = 1;
        $count = 1;
        ?>
        @foreach ($main_modules as $row)
            @if (in_array($row, $main_modules))
                <?php
                $main_menu_id = DB::table('main_menu_title')
                    ->select('main_menu_id')
                    ->where([['id', '=', $row]])
                    ->value('main_menu_id');
                ?>
                <ul class="m_list " id="myGroup">
                    <li>
                        <div class="sm-bx">
                            <button class="btn settingListSb theme-bg" data-toggle="collapse"
                                data-target="#masterSetting<?= $counter ?>">
                                <span><i class="<?= $icons[$main_menu_id] ?>" aria-hidden="true"></i></span>
                                <p><?php echo $main_menu_id; ?></p>
                            </button>
                            <div id="masterSetting<?= $counter ?>" class="collapse pmastermnu">
                                <ul class="list-unstyled">
                                    <?php



                        $MainMenuTitlesSub = DB::table('main_menu_title')->select(['main_menu_id','title','title_id','id'])->
                        where([['main_menu_id','=',$main_menu_id],['status','=',1]])->whereIn('id', $parent_code)->orderBy('orderby','ASC')->get();


                        foreach($MainMenuTitlesSub as $row1){
                        ?>
                                    <li class="dd">
                                        <ul class="list-unstyled">
                                            <a href="#" class="settingListSb-subItem" data-toggle="collapsee"
                                                data-target="#masterSetting<?= $counter ?>-<?= $count ?>"><?php echo $row1->title; ?></a>
                                            <div id="masterSetting<?= $counter ?>-<?= $count ?>"
                                                class="collapsee smastermnu">
                                                <ul class="list-unstyled">
                                                    <?php
                                        $InCompany = Session::get('run_company');
                                        //if($InCompany != 1):
                                        $data = DB::table('menu')->select(['m_type','name','m_controller_name','m_main_title','id','m_parent_code'])->where([['m_parent_code','=',$row1->id],['page_type', '=', 1],['status', '=', 1]])->orderBy('order_by', 'ASC')->get();
                                     
                                        //else:
                                        //  $data = DB::table('menu')->select(['m_type','name','m_controller_name','m_main_title','id','m_parent_code'])->whereNotIn('id', [309,310,311])->where([['m_parent_code','=',$row1->id],['page_type', '=', 1],['status', '=', 1]])->orderBy('order_by', 'ASC')->get();
                                        //endif;
                                        foreach($data as $dataValue){
                                       if(in_array($dataValue->id,$submenu_ids)):
                                        $MakeUrl = url(''.$dataValue->m_controller_name.'');?>
                                                    <li>
                                                        <span><i class="fal fa-circle-notch"></i></span>
                                                        <a href="<?php echo url('' . $dataValue->m_controller_name . '?pageType=' . $dataValue->m_type . '&&parentCode=' . $dataValue->m_parent_code . '&&m=' . Session::get('run_company') . '#signsnow'); ?>"> <?php echo $dataValue->name; ?>
                                                        </a>
                                                    </li>
                                                    <?php endif; } ?>
                                                </ul>
                                            </div>
                                        </ul>
                                    </li>
                                    <?php $count++; ?>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
                <?php $counter++; ?>
            @endif
        @endforeach
    @endif
</div>
<div class="container-fluid head-sh">
    <div class="headerwrap">
        <ul class="nav navbar-nav">
            @if (Auth::user()->compact_mode)
                <div class="abs-btn">
                    <button class="btn btn-primary show-side" onclick="activeSideBar()" id="show">Menu</button>
                </div>
            @endif
            <li class="dropdown user-name-drop">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name[0] }}</a>
                <div class="account-information dropdown-menu">
                    <div class="account-inner">
                        <div class="title">
                            <span>{{ Auth::user()->name[0] }}</span>
                        </div>
                        <div class="main-heading">
                            <h5>{{ Auth::user()->name }}</h5>
                            <p>Bridging the Future of Industry.</p>
                            {{-- <ul class="list-unstyled" id="nav">
                                <li>
                                    <a href="#" rel="{{ url('assets/css/color-one.css') }}">
                                        <div class="color-one"></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" rel="{{ url('assets/css/color-two.css') }}">
                                        <div class="color-two"></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" rel="{{ url('assets/css/color-three.css') }}">
                                        <div class="color-three"></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" rel="{{ url('assets/css/color-four.css') }}">
                                        <div class="color-four"></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" rel="{{ url('assets/css/color-five.css') }}">
                                        <div class="color-five"></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" rel="{{ url('assets/css/color-six.css') }}">
                                        <div class="color-six"></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" rel="{{ url('assets/css/color-seven.css') }}">
                                        <div class="color-seven"></div>
                                    </a>
                                </li>
                            </ul> --}}
                        </div>
                    </div>
                    <div class="account-footer">
                        <a href="{{ url('/users/editUserProfile') }}" class="btn link-accounts contact_support">
                            <span class="glyphicon glyphicon-edit"></span>&nbsp;Edit</a>
                        <a href="{{ url('/logout') }}" class="btn link-accounts sign_out">Sign out</a>
                    </div>
                </div>
            </li>
        </ul>
        {{-- <div class="nav navbar-nav">
            <ul class="nav navbar-nav tmenu-list">
                <li>
                    <a href="{{ URL('dClient/?m=') . Input::get('m') }}" class="drpdn"><i
                            class="glyphicon glyphicon-home" aria-hidden="true"></i> Dashboard </a>
                </li>
                <?php if(Session::get('run_company')!=null):?>
                <li>
                    <a href="{{ URL('purchase/inventory_page') }}" class="drpdn"><i class="glyphicon glyphicon-home"
                            aria-hidden="true"></i> Inventory </a>
                </li>
                <li>
                </li>
                <li>
                    <a href="{{ URL('purchase/sales_page') }}" class="drpdn"><i class="glyphicon glyphicon-home"
                            aria-hidden="true"></i> Sales </a>
                </li>
                <li>
                    <a href="{{ URL('production/production_dashboard') }}" class="drpdn"><i
                            class="glyphicon glyphicon-home" aria-hidden="true"></i> Production </a>
                </li>
                <li class="myst">
                    <div class="row">
                        Compact&nbsp;Mode

                        <div class="btn-wrap">
                            <input type="checkbox" name="compact_mode" id="compact_mode"
                                {{ Auth::user()->compact_mode ? 'checked' : '' }} onclick="compactChecked()"
                                value="1">
                        </div>

                    </div>
                </li>
                <?php endif;?>
                </li>
            </ul>
        </div> --}}
    </div>
</div>
<br />

<!--For Demo Only (End Removable) -->
<input type="hidden" id="baseUrl" value="<?php echo url('/'); ?>">
<input type="hidden" id="emp_code" value="<?php echo Auth::user()->emp_code; ?>">


<!-- MENU SECTION END-->