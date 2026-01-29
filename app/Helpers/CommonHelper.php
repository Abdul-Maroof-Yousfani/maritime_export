<?php

namespace App\Helpers;

use App\ArrivalInspection;
use App\ArrivalSupplier;
use App\CompanyLocation;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\SupplierInfo;
use App\Models\Subitem;
use App\Models\Employee;
use App\Models\EmployeeExitClearance;
use App\Models\MenuPrivileges;
use App\Models\Menu;
use App\Models\UOM;
use App\Models\PurchaseVoucher;
use App\Models\Account;
use App\Models\FinanceDepartment;
use App\Models\Transactions;
use App\Models\CostCenter;
use App\Models\DepartmentAllocation1;
use App\Models\SalesTaxDepartmentAllocation;
use App\Models\CostCenterDepartmentAllocation;
use App\Models\PurchaseType;
use App\Models\Currency;
use App\Models\GRNData;
use App\Models\DemandType;
use App\Models\Warehouse;
use App\Models\GoodsReceiptNote;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestData;
use App\Models\PurchaseVoucherThroughGrn;
use App\Models\SubItemCharges;
use App\Models\Pvs_data;
use App\Models\Department;
use App\Models\SubDepartment;
use App\Models\Customer;
use App\Models\Product;
use App\Models\CropBased;
use App\Models\Region;
use App\Models\SurveryBy;
use App\Models\Client;
use App\Models\Type;
use App\Models\ProductType;
use App\Models\Cities;
use App\Models\ResourceAssigned;
use App\Models\ClientJob;
use App\Models\IncomeTaxDeduction;
use App\Models\NewPvData;
use App\Models\JobOrder;
use App\Models\JobOrderData;
use App\Models\Estimate;
use App\Models\NewPurchaseVoucherPayment;
use App\Models\NewPurchaseVoucher;
use App\Models\PaidTo;
use App\Models\Branch;
use App\Models\GatePass;
use App\Models\GoodsReturn;
use App\Models\Line;
use App\Models\Machinery;
use App\Models\MaintenanceInvoice;
use App\Models\MaintenanceJob;
use App\Models\MaintenanceRequest;
use App\Models\Quotation;
use App\Models\Quotation_Data;
use App\Models\Regions;
use App\Models\Stock;
use App\Models\WorkshopGrn;
use App\Models\WorkshopMaterialIssuance;
use App\ProductionGatePassIn;
use App\ProductionPurchaseOrder;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CommonHelper
{

    public static function unique_for_system_code($year, $month)
    {
        $variable = 100;
        sprintf("%'03d", $variable);
        $str = DB::Connection('mysql2')->selectOne("select max(convert(substr(`system_code`,7,length(substr(`system_code`,3))-3),signed integer)) reg
         from `temp_grns` where substr(`system_code`,3,2) = " . $year . " and substr(`system_code`,5,2) = " . $month . "")->reg;
        $str = $str + 1;
        $str = sprintf("%'03d", $str);

        $wo = 'TG' . $year . $month . $str;
        return $wo;
    }

    public static function companyDatabaseConnection($param1)
    {
        static::reconnectMasterDatabase();
        $d = DB::selectOne('select `dbName` from `company` where `id` = ' . Session::get('run_company') . '')->dbName;
        Config::set(['database.connections.tenant.database' => $d]);
        // Config::set(['database.connections.tenant.username' => 'inno-sfr-01']);
        Config::set('database.default', 'tenant');
        DB::reconnect('tenant');
    }

    public static function reconnectMasterDatabase()
    {
        Config::set('database.default', 'mysql');
        DB::reconnect('mysql');
    }

    public static function get_all_products()
    {
        $product = new Product();
        $product = $product->SetConnection('mysql2');
        return $product = $product->where('p_status', 1)->get();
    }
    public static function checkStockData($ItemId)
    {
        $Count = DB::Connection('mysql2')->table('stock')->where('status', 1)->whereIn('sub_item_id', array($ItemId))->count();

        return $Count;
    }


    public static function get_company_logo($CompanyId)
    {
        $Cdata = DB::table('company')->where('status', 1)->where('id', $CompanyId)->first();
        $HtmlData = '';
        if ($CompanyId == 1) {
       $HtmlData = '
            <img style="width:9%" src="' . url("/public/cfpl.jpg") . '">

            <p style="font-size: 18px; margin-bottom:0px !important; font-weight:bold;">
                CENTRAL FOREST PRODUCTS LTD.
            </p>

            <p style="font-size: 13px; margin-bottom:0px !important;">
                <strong>Karachi Office:</strong>
                1st Floor Central Chambers Timber Market Ireland Road, Karachi-Pakistan.
            </p>

            <p style="font-size: 13px; margin-bottom:0px !important;">
                <strong>Phone #:</strong>
                021-32730782, 021-32730783, 021-32730786
            </p>

            <p style="font-size: 13px; margin-bottom:0px !important;">
                <strong>Factory:</strong>
                Plot No. 7&8, Sector D, Mouza Pathara, Hub-Balochistan.
                <strong>Phone #:</strong> 0853-364071
            </p>

            <p style="font-size: 13px; margin-bottom:0px !important;">
                <strong>E-mail:</strong> cfplk@yahoo.com
            </p>
            ';
           
        } else{
            $HtmlData = '
                    <img style="width: 14%;" src="' . url("/public/cte.jpg") . '">

                    <p style="font-size: 18px; margin-bottom:0px !important; font-weight:bold;">
                        M/S Central Timber Enterprises
                    </p>

                    <p style="font-size: 13px; margin-bottom:0px !important;">
                        Central Chambers, Timber Market, Near MCB Timber Market Branch Ireland Road, Karachi.
                    </p>

                    <p style="font-size: 13px; margin-bottom:0px !important;">
                        <strong>Phone #:</strong> (021) 32730783 - 84
                        &nbsp;&nbsp;
                        <strong>Mobile #:</strong> 0300-8209383
                        &nbsp;&nbsp;
                        <strong>Fax #:</strong> (92-21) 32730785
                    </p>

                    <p style="font-size: 13px; margin-bottom:0px !important;">
                        <strong>Email #:</strong> aamiraziz76@hotmail.com
                    </p>
                    ';

        }
        // } elseif ($CompanyId == 3) {
        //     $HtmlData = '<img style="float: left; width: 100px;margin:-20px 0px 0px 0px;" src="' . url("/storage/app/uploads/fourth.png") . '">
        //                 <p style="float: left; font-size: 20px;"><strong>BURHANI AQMS INDUSTRIES</strong></p>
        //                 <br>
        //                 <p style="font-size: 13px;margin: 10px !important;">A-516/517, Mehran Town, Sector 6-A, Korangi Industrial Area, Karachi-74900, Pakistan.</p>';
        // } elseif ($CompanyId == 5) {
        //     $HtmlData = '<img style="float: left; width: 100px;margin:-20px 0px 0px 0px;" src="' . url("/storage/app/uploads/third.png") . '">
        //                 <p style="float: left; font-size: 20px;"><strong>AL AQMAR HARDWARE</strong></p>
        //                 <br>
        //                 <p style="font-size: 13px;margin: 10px !important;">Shop-1,2,3 Tawakkal Mansion Bellasis Street Karachi, 74200 Pakistan</p>';
        // }


        return $HtmlData;
    }

    public static function get_company_logo_miniphy($CompanyId)
    {
        $Cdata = DB::table('company')->where('status', 1)->where('id', $CompanyId)->first();
        $HtmlData = '';
        $HtmlData = '<img style="" src="' . url("/public/logo.png") . '">';
        return $HtmlData;
    }

    public static function get_company_name($CompanyId)
    {
        $Cdata = DB::table('company')->where('status', 1)->where('id', $CompanyId)->first();
        $HtmlData = '';
        if ($CompanyId == 1) {
            $HtmlData = '<strong>' . env('APP_NAME') . '</strong>';
        } elseif ($CompanyId == 2) {
            $HtmlData = '<strong>AQMS PIPE SOLUTION</strong>';
        } elseif ($CompanyId == 3) {
            $HtmlData = '<strong>BURHANI AQMS INDUSTRIES</strong>';
        } elseif ($CompanyId == 5) {
            $HtmlData = '<strong>AL AQMAR HARDWARE</strong>';
        }

        return $HtmlData;
    }

    public static function get_company_logo_front($CompanyId)
    {
        $Cdata = DB::table('company')->where('status', 1)->where('id', $CompanyId)->first();
        $HtmlData = '';
        if ($CompanyId == 1 || $CompanyId == 6) {
            $HtmlData = '<img style="float: left; width: 200px" src="' . url("/storage/app/uploads/second.png") . '">';
        } elseif ($CompanyId == 2) {
            $HtmlData = '<img style="float: left; width: 200px;margin: -40px 0px 0px 0px" src="' . url("/storage/app/uploads/second.png") . '">';
        } elseif ($CompanyId == 3) {
            $HtmlData = '<img style="float: left; width: 200px; margin:-45px 0px 0px 0px;" src="' . url("/storage/app/uploads/fourth.png") . '">';
        } elseif ($CompanyId == 5) {
            $HtmlData = '<img style="float: left; width: 188px; margin:-28px 0px 0px 0px;" src="' . url("/storage/app/uploads/third.png") . '">';
        }
        return $HtmlData;
    }

    public static function get_data($item_id)
    {

        $item_data = DB::Connection('mysql2')->table('subitem')->where('id', $item_id)->select('uom');

        if ($item_data->count() > 0) :

            $max_data = DB::Connection('mysql2')->table('grn_data')->where('status', 1)->where('sub_item_id', $item_id);

            $stock = DB::Connection('mysql2')->table('stock')->where('status', 1)->where('sub_item_id', $item_id)->where('voucher_type', 1)->sum('qty');
            $uom_name = static::get_uom_name($item_data->first()->uom);
            return $uom_name . ',' . $max_data->max('purchase_approved_qty') . ',' . $max_data->max('purchase_recived_qty') . ',' . $stock;
        endif;
    }
    public static function get_stock($item_id)
    {
        $in = DB::Connection('mysql2')->table('stock')->where('status', 1)->where('sub_item_id', $item_id)->whereIn('voucher_type', [1, 4, 6, 10, 11, 12])->sum('qty');
        $out = DB::Connection('mysql2')->table('stock')->where('status', 1)->where('sub_item_id', $item_id)->whereIn('voucher_type', [2, 5, 3, 9, 8, 13])->sum('qty');
        $stock = $in - $out;
        return $stock ?? 0;
    }


    public static function only_uom_nam_by_item_id($item_id)
    {
        $item_data = DB::Connection('mysql2')->table('subitem')->where('id', $item_id)->select('uom');
        return $uom_name = static::get_uom_name($item_data->first()->uom);
    }
    public static function get_product_name_by_id($id)
    {
        $product = new Product();
        $product = $product->SetConnection('mysql2');
        return $product = $product->where('id', $id)->first();
    }
    public static function get_delivery_term()
    {
        $data = [
            1 => 'Trallers',
            2 => 'Truck',
            3 => 'Bags',
            4 => 'Katta',
            5 => 'KG',
        ];
        return $data;
    }
    public static function get_crop_basedsdate__by_id($id)
    {
        $product = new CropBased();
        $product = $product->SetConnection('mysql2');
        $product = $product->where('id', $id)->first();
        return date('M-Y', strtotime($product->date_from)) .' - ' . date('M-Y', strtotime($product->date_to));
    }
    public static function get_branch_list($AccountId)
    {
        $Client = new Client();
        $Client = $Client->SetConnection('mysql2')->where('acc_id', $AccountId)->select('id')->first();
        $Branch = new Branch();
        $Branch = $Branch->SetConnection('mysql2')->where('client_id', $Client->id)->where('status', 1)->get();
        return $Branch;
    }

    public static function get_all_branch()
    {
        $Branch = new Branch();
        $Branch = $Branch->SetConnection('mysql2')->where('status', 1)->get();
        return $Branch;
    }

    public static function get_branch($ClientId)
    {

        $Branch = new Branch();
        $Branch = $Branch->SetConnection('mysql2');
        $Branch = $Branch
            ->select('branch.id', 'branch.branch_name', 'branch.acc_id', 'transactions.acc_code', 'transactions.paid_to', 'transactions.paid_to_type')
            ->join('transactions', 'transactions.paid_to', '=', 'branch.id')
            ->where('branch.status', '=', 1)
            ->where('transactions.status', '=', 1)
            ->where('branch.client_id', '=', $ClientId)
            ->groupBy('transactions.paid_to')
            ->get();
        return $Branch;
    }


    public static function getEmpSuppClientPaidTo()
    {
        $Emp = new Employee();
        $Emp = $Emp->SetConnection('mysql2');
        //$MultiTable['Emp']=$Emp->where('status',1)->select('id','emp_name')->get();
        // $MultiTable['Emp']=$Emp->where('status',1)->select(DB::raw('CONCAT(emp_name, "(Employee) ") AS emp_name'), 'id')->get();
        $MultiTable['Emp'] =  DB::Connection('mysql2')->select('select id,emp_name from employee where status=1');


        $Supplier = new Supplier();
        $Supplier = $Supplier->SetConnection('mysql2');
        //$MultiTable['Supp']=$Supplier->where('status',1)->get();
        $MultiTable['Supp'] = $Supplier->where('status', 1)->select(DB::raw('CONCAT(name, "(Supplier) ") AS name'), 'id')->get();


        $Client = new Client();
        $Client = $Client->SetConnection('mysql2');
        //$MultiTable['Client']=$Client->where('status',1)->get();
        $MultiTable['Client'] = $Client->where('status', 1)->select(DB::raw('CONCAT(client_name, "(Client) ") AS client_name'), 'id')->get();

        $PaidTo = new PaidTo();
        $PaidTo = $PaidTo->SetConnection('mysql2');
        //       $MultiTable['PaidTo']=$PaidTo->where('status',1)->get();
        $MultiTable['PaidTo'] = $PaidTo->where('status', 1)->select(DB::raw('CONCAT(name, "(Other) ") AS name'), 'id')->get();

        return $MultiTable;
    }

    public static function showBranchInventoryList($param1)
    {
        static::companyDatabaseConnection($param1);
        $subItemList = DB::table('subitem')->get();
        static::reconnectMasterDatabase();
        ?>
        <datalist id="selectSubItem">
            <?php foreach ($subItemList as $row) { ?>
            <option data-id="<?php echo $row->id; ?>" value="<?php echo $row->sub_ic; ?>">
                <?php } ?>
        </datalist>
        <?php
    }

    public static function reportBranchAndRangeFilterSection($param1)
    {
        $branchList = DB::table('company')->get();
        ?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label>Branches List</label>
                <select class="form-control" name="adminBranchFilter" id="adminBranchFilter" onchange="<?php echo $param1 ?>('<?php echo $param1 ?>',this.value)">
                    <option value="0">All Branch</option>
                    <?php
                    foreach ($branchList as $row) {
                        ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label>Filter Type</label>
                <select class="form-control" name="adminRangeFilter" id="adminRangeFilter" onchange="adminRangeFilter(this.value)">
                    <option value="1">Date Wise</option>
                    <option value="2">Month Wise</option>
                    <option value="3">Year Wise</option>
                </select>
            </div>
        </div>
        <?php
    }

    public static function reportDateMonthAndYearFilterSection($param1, $param2, $param3)
    {
        $currentMonthStartDate = date('Y-m-01');
        $currentMonthEndDate = date('Y-m-t');
        ?>
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="well">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label>Start Date</label>
                                            <input type="date" name="startDate" id="startDate" value="<?php echo $currentMonthStartDate ?>" class="form-control" />
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label>End Date</label>
                                            <input type="date" name="endDate" id="endDate" value="<?php echo $currentMonthEndDate ?>" class="form-control" />
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <input type="button" value="Submit" class="btn btn-xs btn-primary" id="btnDate" onclick="dataFilterDateWise('<?php echo $param1 ?>');" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="well">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label>Start Month</label>
                                            <input type="month" name="startMonth" id="startMonth" value="" class="form-control" />
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label>End Month</label>
                                            <input type="month" name="endMonth" id="endMonth" value="" class="form-control" />
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <input type="button" value="Submit" class="btn btn-xs btn-primary" id="btnMonth" onclick="dataFilterMonthWise('<?php echo $param2 ?>');" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="well">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label>Start Year</label>
                                            <?php
                                            echo '<select name="startYear" id="startYear" class="form-control">';
                                            $cur_year = date('Y');
                                            for ($year = ($cur_year - 10); $year <= ($cur_year + 10); $year++) {
                                                if ($year == $cur_year) {
                                                    echo '<option value="' . $year . '" selected="selected">' . $year . '</option>';
                                                } else {
                                                    echo '<option value="' . $year . '">' . $year . '</option>';
                                                }
                                            }
                                            echo '<select>';
                                            ?>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label>End Year</label>
                                            <?php
                                            echo '<select name="endYear" id="endYear" class="form-control">';
                                            $cur_year = date('Y');
                                            for ($year = ($cur_year - 10); $year <= ($cur_year + 10); $year++) {
                                                if ($year == $cur_year) {
                                                    echo '<option value="' . $year . '" selected="selected">' . $year . '</option>';
                                                } else {
                                                    echo '<option value="' . $year . '">' . $year . '</option>';
                                                }
                                            }
                                            echo '<select>';
                                            ?>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <input type="button" value="Submit" class="btn btn-xs btn-primary" id="btnYear" onclick="dataFilterYearWise('<?php echo $param3 ?>');" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public static function displayExportButton($param1, $param2, $param3)
    {


        ?>
        <button class="btn btn-warning" onclick="exportView('<?php echo $param1 ?>','<?php echo $param2 ?>','<?php echo $param3 ?>')" style="<?php echo $param2; ?>">
            <span class="glyphicon glyphicon-print"></span> &nbsp; Export to CSV
        </button>
        <?php

    }

    public static function displayPrintButtonInView($param1, $param2, $param3)
    {
        ?>
        <button class="btn btn-primary prinn" onclick="remove();printView('<?php echo $param1 ?>','<?php echo $param2 ?>','<?php echo $param3 ?>')" style="<?php echo $param2; ?>">
            <span class="glyphicon glyphicon-print"></span> Print
        </button>
        <?php
    }

    public static function displayPrintButtonInBlade($param1, $param2, $param3)
    {
        $print_permission = static::crudRights();
        //if (in_array('print', $print_permission)):
        ?>
        <button class="btn btn-primary" onclick="printView('<?php echo $param1 ?>','<?php echo $param2 ?>','<?php echo $param3 ?>')" style="<?php echo $param2; ?>">
            <span class="glyphicon glyphicon-print"></span> &nbsp; Print
        </button>
        <?php //endif;
    }

    public static function getCompanyName($param1)
    {
        //echo 'Demo';
        echo $companyName = DB::selectOne('select `name` from `company` where `id` = ' . $param1 . '')->name;
    }

    public static function headerPrintSectionInPrintView($param1)
    {
        $current_date = date('d-m-Y');
        ?>
        <div class="row" style="display: flex; align-items: center;">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                <label style="border-bottom:2px solid #000 !important;">Printed On Date&nbsp;:&nbsp;</label><label style="border-bottom:2px solid #000 !important;"><?php echo static::changeDateFormat($current_date); ?></label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5" style="text-align: center; display: flex; justify-content: center; align-items: center;">
                <div style="font-size: 30px !important; font-style: inherit; font-family: -webkit-body; font-weight: bold; text-align: center; width: 100%;">
                    <?php echo static::getCompanyName(Session::get('run_company')); ?>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                <?php $nameOfDay = date('l', strtotime($current_date)); ?>
                <label style="border-bottom:2px solid #000 !important;">Printed On Day&nbsp;:&nbsp;</label><label style="border-bottom:2px solid #000 !important;"><?php echo '&nbsp;' . $nameOfDay; ?></label>

            </div>
        </div>
        <div style="line-height:5px;">&nbsp;</div>
        <?php
    }

    public static function masterTableButtons($param1, $param2, $param3, $param4, $param5, $param6, $param7, $param8, $param9, $param10, $param11, $param12)
    {
        ?>
        <a onclick="showDetailModelMasterTable('<?php echo $param1 ?>','<?php echo $param9 ?>','<?php echo $param2 ?>','<?php echo $param3; ?>','<?php echo $param4; ?>','<?php echo $param5; ?>','<?php echo $param6; ?>','<?php echo $param10 ?>')" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-eye-open"></span></a>
        <?php if ($param2 == 2) { ?>
        <button class="delete-modal btn btn-xs btn-primary" onclick="repostCompanyMasterTableRecord('<?php echo $param12 ?>','<?php echo $param3 ?>','<?php echo $param6 ?>','<?php echo $param1 ?>','<?php echo $param5 ?>')">
            <span class="glyphicon glyphicon-refresh"> Repost</span>
        </button>

    <?php } else { ?>
        <button class="edit-modal btn btn-xs btn-info" onclick="showMasterTableEditModel('<?php echo $param7 ?>','<?php echo $param3 ?>','<?php echo $param8 ?>','<?php echo $param1 ?>')">
            <span class="glyphicon glyphicon-edit"> Edit</span>
        </button>
        <button class="delete-modal btn btn-xs btn-danger" onclick="deleteCompanyMasterTableRecord('<?php echo $param11 ?>','<?php echo $param3 ?>','<?php echo $param6 ?>','<?php echo $param1 ?>','<?php echo $param5 ?>')">
            <span class="glyphicon glyphicon-trash"> Delete</span>
        </button>
    <?php } ?>

        <?php
    }

    public static function checkMasterTableVoucherDetailStatus($param1)
    {
        if ($param1 == 1) {
            echo 'Active';
        } else if ($param1 == 0) {
            echo 'In-Active';
        }
    }

    public static function voucherStatusSelectList()
    {
        return '<option value="0">All Vouchers</option><option value="1">Pending Vouchers</option><option value="2">Approve Vouchers</option><option value="3">Delete Vouchers</option><option value="4">Invoice Created</option>';
    }

    public static function accountHeadSelectList($param1)
    {
        static::companyDatabaseConnection($param1);
        $accountList = DB::table('accounts')->get();
        static::reconnectMasterDatabase();
        ?>
        <datalist id="selectAccountHead">
            <?php foreach ($accountList as $row) { ?>
            <option data-id="<?php echo $row->id; ?>" value="<?php echo $row->name; ?>">
                <?php } ?>
        </datalist>
        <?php
    }

    public static function branchSelectList()
    {
        $branchList = DB::table('company')->get();
        ?>
        <datalist id="selectBranch">
            <?php foreach ($branchList as $row) { ?>
            <option data-id="<?php echo $row->id; ?>" value="<?php echo $row->name; ?>">
                <?php } ?>
        </datalist>
        <?php
    }

    public static function subDepartmnetSelectList($param1)
    {
        ?>
        <datalist id="selectSubDepartment">
            <?php
            $departmentList = DB::table('department')->where('company_id', '=', $param1)->get();
            foreach ($departmentList as $row) {
                ?>
                <optgroup label="<?php echo $row->department_name; ?>" value="<?php echo $row->id; ?>">
                    <?php
                    $subDepartmentList = DB::table('sub_department')->where('company_id', '=', $param1)->where('department_id', '=', $row->id)->get();
                    foreach ($subDepartmentList as $row1) {
                    ?>
                    <option data-id="<?php echo $row1->id; ?>" value="<?php echo $row1->sub_department_name; ?>">
                        <?php
                        }
                        ?>
                </optgroup>
                <?php
            }
            ?>
        </datalist>
        <?php
    }

    public static function subDepartmentSelectListWithRights($param1)
    {
        $department_id = ReuseableCode::getUserWiseDepartmentRights();
        $subDepartmentList = DB::table('sub_department')
            // ->where('company_id', '=', $param1)
            ->whereIn('id', $department_id)
            ->get();

        // Generate the hidden input value
        $hiddenInputValue = implode(',', $department_id);
        ?>

        <input type="hidden" name="departments" id="departments" value="<?php echo $hiddenInputValue; ?>">
        <select name="department_id" id="department_id" class="form-control select2">
            <option value="">Select Option</option>
            <?php
            $selected = Auth::user()->acc_type == "client" ? '' : 'selected';
            foreach ($subDepartmentList as $row1): ?>
                <option value="<?php echo $row1->id; ?>" <?php echo $selected ?> ><?php echo $row1->sub_department_name; ?></option>
            <?php endforeach; ?>
        </select>

        <?php
    }

    public static function subItemSelectList($param1)
    {
        static::companyDatabaseConnection($param1);
        $subItemList = DB::table('subitem')->get();
        static::reconnectMasterDatabase();
        ?>
        <datalist id="selectSubItem">
            <?php foreach ($subItemList as $row) { ?>
            <option data-id="<?php echo $row->id; ?>" value="<?php echo $row->sub_ic; ?>">
                <?php } ?>
        </datalist>
        <?php
    }


    public static function cashCustomerSelectList($param1)
    {
        static::companyDatabaseConnection($param1);
        $cashCustomersList = DB::table('customers')->where('customer_type', '=', '2')->get();
        static::reconnectMasterDatabase();
        ?>
        <datalist id="selectCustomer">
            <?php foreach ($cashCustomersList as $row) { ?>
            <option data-id="<?php echo $row->id; ?>" value="<?php echo $row->name; ?>">
                <?php } ?>
        </datalist>
        <?php
    }

    public static function creditCustomerSelectList($param1)
    {
        static::companyDatabaseConnection($param1);
        $creditCustomersList = DB::table('customers')->where('customer_type', '=', '3')->get();
        static::reconnectMasterDatabase();
        ?>
        <datalist id="selectCustomer">
            <?php foreach ($creditCustomersList as $row) { ?>
            <option data-id="<?php echo $row->id; ?>" value="<?php echo $row->name; ?>">
                <?php } ?>
        </datalist>
        <?php
    }

    public static function supplierSelectList($param1)
    {
        static::companyDatabaseConnection($param1);
        $suppierList = DB::table('supplier')->get();
        static::reconnectMasterDatabase();
        ?>
        <datalist id="selectSupplier">
            <?php foreach ($suppierList as $row) { ?>
            <option data-id="<?php echo $row->id; ?>" value="<?php echo $row->name; ?>">
                <?php } ?>
        </datalist>
        <?php
    }


    public static function checkItemWiseCurrentBalanceQty($param1, $param2, $param3, $param4, $param5)
    {
        //return $param1.'----'.$param2.'----'.$param3.'<br />';
        static::companyDatabaseConnection($param1);
        $openingBalance = DB::selectOne('select `qty` from `fara` where `action` = 1 and `status` = 1 and `main_ic_id` = ' . $param2 . ' and `sub_ic_id` = ' . $param3 . ' ')->qty;
        //$sendBalance = DB::selectOne('select `qty` from `fara` where `action` = 2 and `status` = 1 and `main_ic_id` = '.$param2.' and `sub_ic_id` = '.$param3.' ');
        $purchaseBalance = DB::table("fara")
            ->select(DB::raw("SUM(qty) as qty"))
            ->where(['main_ic_id' => $param2, 'sub_ic_id' => $param3, 'action' => '3'])
            ->where('date', '<=', $param5)
            ->groupBy(DB::raw("sub_ic_id"))
            ->get();
        $sendBalance = DB::table("fara")
            ->select(DB::raw("SUM(qty) as qty"))
            ->where(['main_ic_id' => $param2, 'sub_ic_id' => $param3, 'action' => '2'])
            ->where('date', '<=', $param5)
            ->groupBy(DB::raw("sub_ic_id"))
            ->get();
        $storeReturnBalance = DB::table("fara")
            ->select(DB::raw("SUM(qty) as qty"))
            ->where(['main_ic_id' => $param2, 'sub_ic_id' => $param3, 'action' => '4'])
            ->where('date', '<=', $param5)
            ->groupBy(DB::raw("sub_ic_id"))
            ->get();
        $cashSaleBalance = DB::table("fara")
            ->select(DB::raw("SUM(qty) as qty"))
            ->where(['main_ic_id' => $param2, 'sub_ic_id' => $param3, 'action' => '5'])
            ->where('date', '<=', $param5)
            ->groupBy(DB::raw("sub_ic_id"))
            ->get();

        $creditSaleBalance = DB::table("fara")
            ->select(DB::raw("SUM(qty) as qty"))
            ->where(['main_ic_id' => $param2, 'sub_ic_id' => $param3, 'action' => '6'])
            ->where('date', '<=', $param5)
            ->groupBy(DB::raw("sub_ic_id"))
            ->get();
        static::reconnectMasterDatabase();
        $totalSendBalance = 0;
        foreach ($sendBalance as $row) {
            $totalSendBalance += $row->qty;
        }
        $totalStoreReturnBalance = 0;
        foreach ($storeReturnBalance as $row) {
            $totalStoreReturnBalance += $row->qty;
        }

        $totalPurchaseBalance = 0;
        foreach ($purchaseBalance as $row) {
            $totalPurchaseBalance += $row->qty;
        }

        $totalCashSaleBalance = 0;
        foreach ($cashSaleBalance as $row) {
            $totalCashSaleBalance += $row->qty;
        }

        $totalCreditSaleBalance = 0;
        foreach ($creditSaleBalance as $row) {
            $totalCreditSaleBalance += $row->qty;
        }
        $currentBalanceInStore = $openingBalance + $totalPurchaseBalance + $totalStoreReturnBalance - $totalSendBalance - $totalCashSaleBalance - $totalCreditSaleBalance;

        return $currentBalanceInStore;
    }

    public static function changeDateFormat($param1)
    {
        if ($param1) {
            $date = date_create($param1);
            return date_format($date, "d-m-Y");
        }
    }

    public static function new_date_formate($param1)
    {
        $date = date_create($param1);
        return date_format($date, "d-M-Y");
    }
    public static function homePageURL()
    {
        return url('/');
    }

    public static function getMasterTableValueById($param1, $param2, $param3, $param4)
    {
        // echo $param1."-".$param2."-".$param3."--".$param4;
        if ($param4 != "") {
            $detailName = DB::table($param2)->select($param3)->where('status', '1')->where('id', $param4)->first();
            // $detailName = DB::selectOne('select  ' . $param3 . ' from ' . $param2 . ' where `status` = 1 and `company_id` = ' . $param1 . ' and id = ' . $param4 . '')->$param3;
            if ($detailName != "") :
                return $detailName->$param3;
            else :
                return "";
            endif;
        } else {
            return '---';
        }
    }

    public static function getMasterTableValueByIdWithoutCompanyId($param1, $param2, $param3)
    {
        return $detailName = DB::selectOne('select  ' . $param2 . ' from ' . $param1 . ' where `status` = 1 and id = ' . $param3 . '')->$param2;
    }


    public static function getCompanyDatabaseTableValueById($param1, $param2, $param3, $param4)
    {

        static::companyDatabaseConnection($param1);
        if ($param4 != "") {
            $detailName = DB::selectOne('select ' . $param3 . ' from `' . $param2 . '` where id = ' . $param4 . '')->$param3;
        } else {
            $detailName = '---';
        }
        static::reconnectMasterDatabase();
        return $detailName;
    }

    public static function categoryList($param1, $param2)
    {
        echo '<option value="">Select Category</option>';
        static::companyDatabaseConnection($param1);
        $categoryList = new Category;
        $categoryList = $categoryList::where([['status', '=', '1'],])->orderBy('id')->get();
        static::reconnectMasterDatabase();
        foreach ($categoryList as $row) {
            ?>
            <option value="<?php echo $row['id']; ?>" <?php if ($param2 == $row['id']) {
                echo 'selected';
            } ?>><?php echo $row['main_ic']; ?></option>
            <?php
        }
    }

    public static function subItemList($param1, $param2, $param3)
    {
        echo '<option value="">Select Item</option>';
        static::companyDatabaseConnection($param1);
        $subItemList = new Subitem;
        $subItemList = $subItemList::where([['status', '=', '1'], ['main_ic_id', '=', $param3],])->orderBy('id')->get();
        static::reconnectMasterDatabase();
        foreach ($subItemList as $row) {
            ?>
            <option value="<?php echo $row['id']; ?>" <?php if ($param2 == $row['id']) {
                echo 'selected';
            } ?>><?php echo $row['sub_ic']; ?></option>
            <?php
        }
    }

    public static function getAccountIdByMasterTable($param1, $param2, $param3)
    {
        static::companyDatabaseConnection($param1);
        $accountId = DB::selectOne('select `acc_id` from `' . $param3 . '` where `id` = ' . $param2 . '')->acc_id;
        static::reconnectMasterDatabase();
        return $accountId;
    }

    public static function getAllPurchaseQtyItemWise($param1, $param2, $param3, $param4, $param5)
    {
        static::companyDatabaseConnection($param1);
        $purchaseBalance = DB::table("fara")
            ->select(DB::raw("SUM(qty) as qty"))
            ->where(['main_ic_id' => $param2, 'sub_ic_id' => $param3, 'action' => '3'])
            ->where('date', '<=', $param5)
            ->groupBy(DB::raw("sub_ic_id"))
            ->get();
        static::reconnectMasterDatabase();
        $totalPurchaseBalance = 0;
        foreach ($purchaseBalance as $row) {
            $totalPurchaseBalance += $row->qty;
        }
        return $totalPurchaseBalance;
    }

    public static function getAllIssueQtyItemWise($param1, $param2, $param3, $param4, $param5)
    {
        static::companyDatabaseConnection($param1);
        $sendBalance = DB::table("fara")
            ->select(DB::raw("SUM(qty) as qty"))
            ->where(['main_ic_id' => $param2, 'sub_ic_id' => $param3, 'action' => '2'])
            ->where('date', '<=', $param5)
            ->groupBy(DB::raw("sub_ic_id"))
            ->get();
        static::reconnectMasterDatabase();
        $totalSendBalance = 0;
        foreach ($sendBalance as $row) {
            $totalSendBalance += $row->qty;
        }
        return $totalSendBalance;
    }

    public static function getAllCashSaleQtyItemWise($param1, $param2, $param3, $param4, $param5)
    {
        static::companyDatabaseConnection($param1);
        $cashSaleBalance = DB::table("fara")
            ->select(DB::raw("SUM(qty) as qty"))
            ->where(['main_ic_id' => $param2, 'sub_ic_id' => $param3, 'action' => '5'])
            ->where('date', '<=', $param5)
            ->groupBy(DB::raw("sub_ic_id"))
            ->get();
        static::reconnectMasterDatabase();
        $totalCashSaleBalance = 0;
        foreach ($cashSaleBalance as $row) {
            $totalCashSaleBalance += $row->qty;
        }
        return $totalCashSaleBalance;
    }

    public static function getAllCreditSaleQtyItemWise($param1, $param2, $param3, $param4, $param5)
    {
        static::companyDatabaseConnection($param1);
        $creditSaleBalance = DB::table("fara")
            ->select(DB::raw("SUM(qty) as qty"))
            ->where(['main_ic_id' => $param2, 'sub_ic_id' => $param3, 'action' => '6'])
            ->where('date', '<=', $param5)
            ->groupBy(DB::raw("sub_ic_id"))
            ->get();
        static::reconnectMasterDatabase();
        $totalCreditSaleBalance = 0;
        foreach ($creditSaleBalance as $row) {
            $totalCreditSaleBalance += $row->qty;
        }
        return $totalCreditSaleBalance;
    }

    public static function getAllStoreChallanReturQtyItemWise($param1, $param2, $param3, $param4, $param5)
    {
        static::companyDatabaseConnection($param1);
        $storeReturnBalance = DB::table("fara")
            ->select(DB::raw("SUM(qty) as qty"))
            ->where(['main_ic_id' => $param2, 'sub_ic_id' => $param3, 'action' => '4'])
            ->where('date', '<=', $param5)
            ->groupBy(DB::raw("sub_ic_id"))
            ->get();
        static::reconnectMasterDatabase();
        $totalStoreReturnBalance = 0;
        foreach ($storeReturnBalance as $row) {
            $totalStoreReturnBalance += $row->qty;
        }
        return $totalStoreReturnBalance;
    }

    public static function getTotalGRNAmountByGRNNo($param1, $param2, $param3, $param4, $param5, $param6)
    {
        static::companyDatabaseConnection($param1);
        $dataRecord = DB::table($param3)
            ->select(DB::raw("SUM($param4) as $param4"))
            ->where([$param5 => $param2, 'status' => '1', $param6 => 2])
            ->groupBy(DB::raw($param5))
            ->get();
        static::reconnectMasterDatabase();
        $totalAmount = 0;
        foreach ($dataRecord as $row) {
            $totalAmount += $row->$param4;
        }
        return $totalAmount;
    }

    public static function getDemandNoByPrNo($param1, $param2, $param3, $param4)
    {
        static::companyDatabaseConnection($param1);
        $dataRecord = DB::table('purchase_request_data')
            ->where(['category_id' => $param3, 'sub_item_id' => $param4, 'purchase_request_no' => $param2, 'status' => 1, 'purchase_request_status' => 2])
            ->first();
        static::reconnectMasterDatabase();
        return $dataRecord->demand_no;
    }

    public static function getDemandDateByPrNo($param1, $param2, $param3, $param4)
    {
        static::companyDatabaseConnection($param1);
        $dataRecord = DB::table('purchase_request_data')
            ->where(['category_id' => $param3, 'sub_item_id' => $param4, 'purchase_request_no' => $param2, 'status' => 1, 'purchase_request_status' => 2])
            ->first();
        static::reconnectMasterDatabase();
        return $dataRecord->demand_date;
    }

    public static function getInvoiceNoByGRNNo($param1, $param2)
    {
        static::companyDatabaseConnection($param1);
        $dataRecord = DB::table('goods_receipt_note')
            ->where(['grn_no' => $param2, 'status' => 1, 'grn_status' => 2])
            ->first();
        static::reconnectMasterDatabase();
        return $dataRecord->invoice_no;
    }

    public static function getTotalInvoiceAmountByInvoiceNo($param1, $param2, $param3, $param4, $param5, $param6)
    {
        static::companyDatabaseConnection($param1);
        $dataRecord = DB::table($param3)
            ->select(DB::raw("SUM($param4) as $param4"))
            ->where([$param5 => $param2, 'status' => '1', $param6 => 2])
            ->groupBy(DB::raw($param5))
            ->get();
        $invoiceDetail = DB::table('invoice')->where('inv_no', '=', $param2)->where('status', '=', 1)->first();
        static::reconnectMasterDatabase();
        $totalAmount = 0;
        foreach ($dataRecord as $row) {
            $totalAmount += $row->$param4;
        }
        $calculatedTotalDiscount = $totalAmount * $invoiceDetail->inv_against_discount / 100;
        $calculatedTotalAmount = $totalAmount - $calculatedTotalDiscount;
        return $calculatedTotalAmount;
    }


    public static function getEmpDataForExitClearance($id, $index)
    {
        $employee = new Employee();
        $employee = $employee->SetConnection('mysql2');
        $employee = $employee->where('status', 1)->where('id', $id)->first(['emp_name', 'emp_code', 'emp_email', 'emp_contact_no', 'emp_cnic']);
        $value[0] = $employee['emp_name'];
        $value[1] = $employee['emp_code'];
        $value[2] = $employee['emp_email'];
        $value[3] = $employee['emp_contact_no'];
        $value[4] = $employee['emp_cnic'];
        return $value[$index];
    }

    public static function getTypeForExitClearance($id)
    {
        $employee_exit = new EmployeeExitClearance();
        $employee_exit = $employee_exit->SetConnection('mysql2');
        $employee_exit = $employee_exit->where('status', 1)->where('emp_id', $id)->first(['leaving_type']);
        $type = $employee_exit['leaving_type'];
        $leaving_type = '';
        if ($type == 1) :
            $leaving_type = 'Resignation';
        endif;

        if ($type == 2) :
            $leaving_type = 'Retirement';
        endif;

        if ($type == 3) :
            $leaving_type = 'Termination';
        endif;

        if ($type == 4) :
            $leaving_type = 'Dismissal';
        endif;

        if ($type == 5) :
            $leaving_type = 'Demise';
        endif;

        return $leaving_type;
    }

    public static function crudRights()
    {
        static::reconnectMasterDatabase();
        $user_rights = MenuPrivileges::where([['user_id', '=', Auth::user()->emp_id]]);
        $crud_permission[] = '';
        if ($user_rights->count() > 0) :
            $crud_rights = explode(",", $user_rights->value('crud_rights'));

            $link = Request::segment(1) . "/" . Request::segment(2);
            $getTitle = $user_rights = Menu::where([['m_controller_name', '=', $link]])->value('m_main_title');

            if (in_array('view_' . $getTitle, $crud_rights)) :
                $crud_permission[] = "view";
            endif;
            if (in_array('edit_' . $getTitle, $crud_rights)) :
                $crud_permission[] = "edit";
            endif;
            if (in_array('repost_' . $getTitle, $crud_rights)) :
                $crud_permission[] = "repost";
            endif;
            if (in_array('delete_' . $getTitle, $crud_rights)) :
                $crud_permission[] = "delete";
            endif;
            if (in_array('print_' . $getTitle, $crud_rights)) :
                $crud_permission[] = "print";
            endif;
            if (in_array('export_' . $getTitle, $crud_rights)) :
                $crud_permission[] = "export";
            endif;
            if (in_array('approve_' . $getTitle, $crud_rights)) :
                $crud_permission[] = "approve";
            endif;
            if (in_array('reject_' . $getTitle, $crud_rights)) :
                $crud_permission[] = "reject";
            endif;

        endif;


        return $crud_permission;
    }

    public static function sub_item_connection()
    {

        $table = new Subitem();
        $table = $table->SetConnection('mysql2');
        return $table;
    }

    public static function uom_connection()
    {

        $table = new UOM();

        return $table;
    }

    public static function get_supplier_name($id)
    {
        if ($id != "") :
            $supplier = new Supplier();
            $supplier = $supplier->SetConnection('mysql2');
            $supplier = $supplier->where('status', 1)->where('id', $id)->select('name')->first();
            if (empty($supplier)) {
                return 'None';
            }
            return $supplier->name;
        else :
            return "---";
        endif;
    }

    public static function get_arrival_supplier_name($id)
    {
        if ($id != "") :
            $supplier = new ArrivalSupplier();
            $supplier = $supplier->SetConnection('mysql2');
            $supplier = $supplier->where('id', $id)->select('name')->first();
            if (empty($supplier)) {
                return 'None';
            }
            return $supplier->name;
        else :
            return "---";
        endif;
    }
    public static function get_supplier_ntn($id)
    {
        if ($id != "") :
            $supplier = new Supplier();
            $supplier = $supplier->SetConnection('mysql2');
            $supplier = $supplier->where('status', 1)->where('id', $id)->select('ntn')->first();
            return $supplier->ntn;
        else :
            return "---";
        endif;
    }

    public static function get_category_name($id)
    {
        if ($id == 'Select') :
            return '';

        endif;
        $Category = new Category();
        $Category = $Category->SetConnection('mysql2');
        $Category = $Category->where('id', $id)->where('status', 1)->select('main_ic', 'status');
        $delete = '';
        $category = '';
        if ($Category->count() > 0) :

            $category = $Category->first()->main_ic;
        endif;
        return strtoupper($category . $delete);
    }

    public static function get_category_row($id)
    {

        $Category = new Category();
        $Category = $Category->SetConnection('mysql2');
        return $Category = $Category->where('id', $id)->where('status', 1)->select('main_ic', 'acc_id');
    }

    public static function get_item_name($id)
    {
        if ($id != 0) :

            $Subitem = new Subitem();
            $Subitem = $Subitem->SetConnection('mysql2');
            $Subitem = $Subitem->where('id', $id)->select('sub_ic', 'sku_code','status')->first();
            $delete = '';
            if ($Subitem->status != 1) :
                $delete = '(Delete)';
            endif;
            return strtoupper($Subitem->sku_code.'-'.$Subitem->sub_ic) . ' ' . $delete;
        else :
            return '';
        endif;
    }

    public static function get_fg_name($id)
    {
        if ($id != 0) :

            $Subitem = new Product();
            $Subitem = $Subitem->SetConnection('mysql2');
            $Subitem = $Subitem->where('id', $id)->select('name', 'sku_code','status')->first();
            $delete = '';
            if ($Subitem->status != 1) :
                $delete = '(Delete)';
            endif;
            return strtoupper($Subitem->sku_code.'-'.$Subitem->name) . ' ' . $delete;
        else :
            return '';
        endif;
    }

    public static function get_item($name)
    {

        $Subitem = new Subitem();
        $Subitem = $Subitem->SetConnection('mysql2');
        $Subitem = $Subitem->where('sub_ic', $name)->select('sub_ic', 'sku_code','status')->first();

        return strtoupper(optional($Subitem)->sku_code.'-'.optional($Subitem)->sub_ic);
    }

    public static function get_item_id($name)
    {

        $Subitem = new Subitem();
        $Subitem = $Subitem->SetConnection('mysql2');
        $Subitem = $Subitem->where('sub_ic', $name)->select('id')->first();
        return optional($Subitem)->id;
    }
    public static function get_item_sku($id)
    {
        if ($id != 0) :

            $Subitem = new Subitem();
            $Subitem = $Subitem->SetConnection('mysql2');
            $Subitem = $Subitem->where('id', $id)->select('sku_code', 'status')->first();
            $delete = '';
            if ($Subitem->status != 1) :
                $delete = '(Delete)';
            endif;
            return strtoupper($Subitem->sku_code) . ' ' . $delete;
        else :
            return '';
        endif;
    }

    public static function get_uom_name($id)
    {
        if ($id != 0) :
            $uom = new UOM();
            $uom = $uom->where('status', 1)->where('id', $id)->select('uom_name')->first();
            return strtoupper($uom->uom_name);
        else :
            return '';
        endif;
    }

    public static function get_supplier_acc_id($id)
    {
        $supplier = new Supplier();
        $supplier = $supplier->SetConnection('mysql2');
        $supplier = $supplier->where('status', 1)->where('id', $id)->select('acc_id')->first();
        return $supplier->acc_id;
    }

    public static function get_supplier_id_from_purchase_voucher($id, $type)
    {

        if ($type == 1) :
            $purchase_voucher = new PurchaseVoucher();
        else :

            $purchase_voucher = new PurchaseVoucherThroughGrn();
        endif;
        $purchase_voucher = $purchase_voucher->SetConnection('mysql2');
        $purchase_voucher = $purchase_voucher->where('status', 1)->where('id', $id)->select('supplier')->first();
        return $purchase_voucher->supplier;
    }

    public static function get_purchase_net_amount($val, $type)
    {
        if ($type == 1) :
            $total_net_amount = DB::connection('mysql2')->selectOne("select sum(total_net_amount)amount from purchase_voucher
          where status=1 and id IN (" . $val . ") ")->amount;
        else :
            $total_net_amount = DB::connection('mysql2')->selectOne("select sum(total_amount)amount from purchase_voucher_through_grn
          where status=1 and id IN (" . $val . ") ")->amount;

        endif;
        return $total_net_amount;
    }

    public static function get_purchase_detail($id, $type)
    {
        if ($type == 1) :

            $purchase_voucher = DB::connection('mysql2')->select('select total_net_amount,slip_no,through_advance,payment_id from purchase_voucher
        where status=1 and id IN (' . $id . ')');

        else :

            $purchase_voucher = DB::connection('mysql2')->select('select total_amount as total_net_amount,slip_no from purchase_voucher_through_grn
        where status=1 and id IN (' . $id . ')');
        endif;
        //  $purchase_voucher=$purchase_voucher->whereIn('id',array($id))->select('total_net_amount','slip_no')->get();
        return $purchase_voucher;
    }


    public static function get_pv_detail_for_outstanding($id)
    {
        $pv_data = new Pvs_data();
        $pv_data = $pv_data->SetConnection('mysql2');
        return $pv_data = $pv_data->where('master_id', $id)->select('acc_id', 'debit_credit', 'amount', 'srb')->OrderBy('debit_credit', 1)->get();
    }

    public static function get_account_name($id)
    {
        if ($id != "") :
            $account = new Account();;
            $account = $account->SetConnection('mysql2');
            $account = $account->where('status', 1)->where('id', $id)->select('name')->first();
            return ucwords($account['name']);
        endif;
    }

    public static function get_account_code($id)
    {
        if ($id != "") :
            $account = new Account();;
            $account = $account->SetConnection('mysql2');
            $account = $account->where('status', 1)->where('id', $id)->select('code')->first();
            return $account['code'];
        endif;
    }
    public static function get_account_name_by_code($code)
    {
        if ($code != "") :
            $account = new Account();;
            $account = $account->SetConnection('mysql2');
            $account = $account->where('status', 1)->where('code', $code)->select('name')->first();
            return ucwords($account['name']);
        endif;
    }

    public static function get_dept_name($id)
    {

        if ($id != 0) :
            $dept = new FinanceDepartment();;
            $dept = $dept->SetConnection('mysql2');
            $dept = $dept->where('status', 1)->where('id', $id)->select('name')->first();
            return strtoupper($dept->name);
        endif;
    }


    public static function get_cost_name($id)
    {

        if ($id != 0) :
            $dept = new CostCenter();;
            $dept = $dept->SetConnection('mysql2');
            $dept = $dept->where('status', 1)->where('id', $id)->select('name')->first();
            return strtoupper($dept->name);
        endif;
    }

    public static function get_item_acc_id($id)
    {

        $item = new Subitem();
        $item = $item->SetConnection('mysql2');
        $item = $item->where('status', 1)->where('id', $id)->select('acc_id')->first();
        return $item->acc_id;
    }

    public static function get_opening_bal($from, $to, $id)
    {

        $transactions = new Transactions();
        $transactions = $transactions->SetConnection('mysql2');
        $transactions = $transactions->where('status', 1)->where('acc_id', $id)->where('opening_bal', 1)->select('amount');

        if ($transactions->count() > 0) :
            return $transactions->first()->amount;
        else :
            return 0;
        endif;
    }

    public static function CheckGrnCount($PoNo)
    {
        $GoodsReceiptNote = new GoodsReceiptNote();
        $GoodsReceiptNote = $GoodsReceiptNote->SetConnection('mysql2');
        $GoodsReceiptNote = $GoodsReceiptNote->where('status', 1)->where('po_no', $PoNo);
        return $GoodsReceiptNote->count();
    }

    public static  function  get_opening_ball($from, $to, $acc_id, $m, $code, $paid_to_clause = null)
    {
        $level = explode('-', $code);
        $level = $level[0];
        $amount = 0;
        $data =  DB::table('company')->where('id', Session::get('run_company'))->first();
        $new_from = $data->accyearfrom;



        $from . '   .....' . $new_from;
        if ($from == $new_from) :


            CommonHelper::companyDatabaseConnection($m);
            $opening_data = DB::table('transactions')->where('opening_bal', 1)->where('acc_id', $acc_id)->where('status', 1)->first();

            CommonHelper::reconnectMasterDatabase();


            if (isset($opening_data->debit_credit)) :
                $opening_data->debit_credit;
                if ($opening_data->debit_credit == 1) :
                    $amount = $opening_data->amount;
                else :
                    $amount = $opening_data->amount;
                    $amount = $amount * -1;
                endif;
            endif;


        else :


            $new_to = date('d-m-Y', strtotime($from . " - 1 day"));



            CommonHelper::companyDatabaseConnection($m);
            $debit =    DB::selectOne('select sum(amount)amount from transactions where status=1  and acc_id="' . $acc_id . '"
		    	and v_date between "' . $new_from . '" and "' . $new_to . '"  and debit_credit=1')->amount;

            $credit =    DB::selectOne('select sum(amount)amount from transactions where status=1  and acc_id="' . $acc_id . '"
			    and v_date between "' . $new_from . '" and "' . $new_to . '"  and debit_credit=0')->amount;






            $amount = $debit - $credit;


            CommonHelper::reconnectMasterDatabase();
            //   endif;
        endif;

        //    CommonHelper::reconnectMasterDatabase();
        return $amount;
    }

    public static function income_statment($from, $to, $id, $m)
    {
        CommonHelper::companyDatabaseConnection($m);
        $debit =    DB::selectOne('select sum(amount)amount from transactions where status=1  and acc_id="' . $id . '"
			and v_date between "' . $from . '" and "' . $to . '" and debit_credit=1 and opening_bal=0')->amount;

        $credit =    DB::selectOne('select sum(amount)amount from transactions where status=1  and acc_id="' . $id . '"
			and v_date between "' . $from . '" and "' . $to . '" and debit_credit=0 and opening_bal=0')->amount;
        CommonHelper::reconnectMasterDatabase();
        return $amount = $debit - $credit;
    }

    public static function EstimateCount($JobOrderId)
    {

        $JobOrderData = new JobOrderData();
        $JobOrderData = $JobOrderData->SetConnection('mysql2');
        $JobOrderData  = $JobOrderData->where('job_order_id', $JobOrderId)->get();

        $MultiCount = 0;

        foreach ($JobOrderData as $DataFil) {
            $JobOrderDataId = $DataFil->job_order_data_id;
            $Estimate = new Estimate();
            $Estimate = $Estimate->SetConnection('mysql2');
            $Estimate  = $Estimate->where('job_order_data_id', $JobOrderId);
            if ($Estimate->count() > 0) {
                $MultiCount += $Estimate->count();
            }
        }
        return $MultiCount;
    }

    public static function get_all_department()
    {

        $dept = new FinanceDepartment();;
        $dept = $dept->SetConnection('mysql2');
        $dept = $dept->where('status', 1)->select('id', 'code', 'name')
            ->orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->get();;
        return $dept;
    }

    public static function get_all_cost_center($level)
    {


        $cost_center = new CostCenter();
        $cost_center = $cost_center->where('status', 1)->where('level1', $level)->select('*')
            ->orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->get();

        // echo '<pre>';
        // print_r($cost_center);
        // die;
        return $cost_center;
    }

    public static function accounts_related_to_category()
    {
        $accounts = new Account;
        $accounts = $accounts->SetConnection('mysql2');
        $accounts = $accounts->where('status', 1)->where('type', 1)->select('id', 'code', 'name')->orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')
            ->get();
        return $accounts;
    }

    public static function category_related_to_accounts($id)
    {
        $Category = new Category();
        $Category = $Category->SetConnection('mysql2');
        $Category = $Category->where('status', 1)->where('head', $id)->select('id', 'main_ic')->get();
        return $Category;
    }

    public static function department_allocation_data($id, $type)
    {
        $d_allocation = new DepartmentAllocation1();
        $d_allocation = $d_allocation->SetConnection('mysql2');
        $d_allocation = $d_allocation->where('master_id', $id)->where('type', $type)->where('status', 1);
        if ($d_allocation->count() > 0) :
            $d_allocation = $d_allocation->get();
        else :

            $d_allocation = [];
        endif;

        return $d_allocation;
    }

    public static function get_item_name_from_dept($id)
    {
        $d_allocation = new DepartmentAllocation1();
        $d_allocation = $d_allocation->SetConnection('mysql2');
        $d_allocation = $d_allocation->where('master_id', $id);
        if ($d_allocation->count() > 0) :
            $name = $d_allocation->select('item')->first();
            $name = $name->item;
        else :

            $name = '';
        endif;

        return $name;
    }

    public static function sales_tax_allocation_data($id, $type)
    {
        $s_allocation = new SalesTaxDepartmentAllocation();
        $s_allocation = $s_allocation->SetConnection('mysql2');
        $s_allocation = $s_allocation->where('master_id', $id)->where('type', $type);
        if ($s_allocation->count() > 0) :
            $s_allocation = $s_allocation->get();
        else :

            $s_allocation = [];
        endif;

        return $s_allocation;
    }

    public static function get_sales_tax_from_sales_dept($id)
    {
        $s_allocation = new SalesTaxDepartmentAllocation();
        $s_allocation = $s_allocation->SetConnection('mysql2');
        $s_allocation = $s_allocation->where('master_id', $id);
        if ($s_allocation->count() > 0) :
            $name = $s_allocation->select('sales_tax')->first();
            $name = $name->sales_tax;
        else :

            $name = '';
        endif;

        return $name;
    }

    public static function cost_center_allocation_data($id, $type)
    {
        $c_allocation = new CostCenterDepartmentAllocation();
        $c_allocation = $c_allocation->SetConnection('mysql2');
        $c_allocation = $c_allocation->where('master_id', $id)->where('type', $type)->where('status', 1);
        if ($c_allocation->count() > 0) :
            $c_allocation = $c_allocation->get();
        else :

            $c_allocation = [];
        endif;

        return $c_allocation;
    }


    public static function get_item_name_from_cost_center($id)
    {
        $c_allocation = new CostCenterDepartmentAllocation();
        $c_allocation = $c_allocation->SetConnection('mysql2');
        $c_allocation = $c_allocation->where('master_id', $id);
        if ($c_allocation->count() > 0) :
            $name = $c_allocation->select('item')->first();
            $name = $name->item;
        else :

            $name = '';
        endif;

        return $name;
    }

    public static function get_all_purchase_type()
    {
        $purchase_type = new PurchaseType();
        $purchase_type = $purchase_type->SetConnection('mysql2');
        $purchase_type = $purchase_type->where('status', 1)->select('id', 'name')->get();
        return $purchase_type;
    }


    public static function item_types_for_items(){
        $item_type = [
            ['id' => 1, 'name' => 'Stores and Spares'],
            ['id' => 2, 'name' => 'Finish Goods'],
        ];
        return collect($item_type);
    }


    public static function get_finish_goods($value)
    {
        return    DB::Connection('mysql2')->table('subitem')->where('status', 1)->where('stockType', $value)->select('id', 'sub_ic', 'uom', 'item_code', 'pack_size', 'pack_type', 'sku_code', 'pack_uom')->get();
    }

    public static function get_mold()
    {
        return DB::Connection('mysql2')->table('production_mold')->where('status', 1)->get();
    }
    public static function get_dai()
    {
        return DB::Connection('mysql2')->table('production_dai')->where('status', 1)->get();
    }
    public static function get_all_currency()
    {
        $currency = new Currency();
        $currency = $currency->SetConnection('mysql2');
        $currency = $currency->where('status', 1)->select('id', 'curreny', 'rate')->get();
        return $currency;
    }

    public static function get_all_subitem()
    {
        $sub_item = new Subitem();
        // $sub_item = $sub_item->SetConnection('mysql2');
        $sub_item = $sub_item->where('status', 1)->select('id', 'sub_ic', 'uom', 'item_code', 'pack_size', 'pack_type', 'sku_code', 'pack_uom')->get();
        return $sub_item;
    }

    public static function get_all_finish_good()
    {
       
        $sub_item = Product::where('status', 1)->where('table_type', 5)->select('id', 'name', 'uom_id',  'sku_code')->get();
        return $sub_item;
    }

    public static function get_limited_subitem()
    {
        $sub_item = new Subitem();
        // $sub_item = $sub_item->SetConnection('mysql2');
        $sub_item = $sub_item->where('status', 1)->select('id', 'sub_ic', 'uom', 'item_code', 'pack_size', 'pack_type', 'sku_code', 'pack_uom')->limit(50)->get();
        return $sub_item;
    }

    public static function get_all_subitem_by_demand_type($type)
    {
        $sub_item = new Subitem();
        $sub_item = $sub_item->SetConnection('mysql2');
        $sub_item = $sub_item->where('status', 1)->where('itemType', $type)->select('id', 'sub_ic')->get();
        return $sub_item;
    }

    public static function get_purchase_type_name($id)
    {
        $purchase_type = new PurchaseType();
        $purchase_type = $purchase_type->SetConnection('mysql2');
        $purchase_type = $purchase_type->where('id', $id);
        if ($purchase_type->count() > 0) :
            $name = $purchase_type->select('name')->first();
            $name = $name->name;
        else :

            $name = '';
        endif;

        return $name;
    }

    public static function get_curreny_name($id)
    {
        $currency = new Currency();
        $currency = $currency->SetConnection('mysql2');
        $currency = $currency->where('id', $id);
        if ($currency->count() > 0) :
            $name = $currency->select('curreny')->first();
            $name = $name->curreny;
        else :

            $name = '';
        endif;

        return $name;
    }

    public static function get_subitem_detail($id)
    {

        if($id != ''){
            $sub_iteme = new Subitem();
            // dd(env('DB_DATABASE'));
            $sub_iteme = $sub_iteme->join(env('DB_DATABASE') . '.uom', 'uom.id', 'subitem.uom');
            $sub_iteme = $sub_iteme->where('subitem.id', $id)->select('subitem.id', 'uom.uom_name as uom', 'subitem.pack_size', 'subitem.rate', 'subitem.description', 'subitem.sub_ic', 'subitem.main_ic_id', 'subitem.item_code', 'subitem.min_stock', 'subitem.max_stock', 'subitem.sku_code')->first();
            $uom = $sub_iteme->uom ?? '';
            $pack_size = $sub_iteme->pack_size ?? '';
            $rate = $sub_iteme->rate ?? '';
            return $uom . ',' .              //  0
                $pack_size . ',' .           //  1
                $rate  . ',' .                //  2
                $sub_iteme->item_code . ',' .              //  3
                $sub_iteme->sub_ic . ',' .                 //  4
                $sub_iteme->main_ic_id . ',' .             //  5
                $sub_iteme->batch_code . ',' .             //  6
                $sub_iteme->min_stock . ',' .              //  7
                $sub_iteme->max_stock . ',' .              //  8
                $sub_iteme->id . ',' .                     //  8
                $sub_iteme->sku_code;                   //  10
        }

    }

    public static function get_item_detail($id)
    {

        if($id != ''){
            $sub_iteme = new Subitem();
            // dd(env('DB_DATABASE'));
            $sub_iteme = $sub_iteme->join(env('DB_DATABASE') . '.uom', 'uom.id', 'subitem.uom');
            $sub_iteme = $sub_iteme->where('subitem.id', $id)->select('subitem.id', 'uom.uom_name as uom', 'subitem.pack_size', 'subitem.rate', 'subitem.description', 'subitem.sub_ic', 'subitem.main_ic_id', 'subitem.item_code', 'subitem.min_stock', 'subitem.max_stock', 'subitem.sku_code')->first();
            return $sub_iteme;
        }

    }


    public static function get_remaining_qty($id)
    {
        $grn_data = new GRNData();
        $grn_data = $grn_data->SetConnection('mysql2');
        $grn_data = $grn_data->where('status', 1)->where('grn_status', 4);
        if ($grn_data->count() > 0):
            $qty = $grn_data->select('sum(purchaseRequestQty)as qty')->first();
        else :
            $qty = 0;
        endif;
        return $qty;
    }

    public static function get_last_rate_qty($id)
    {
        return Stock::where('sub_item_id', $id)->where('transfer_status', 0)->where('voucher_type', 1)->where('opening', 0)->where('status', 1)->orderBy('id', 'desc')->first();
    }

    public static function get_last_rate_qty_on_quotation($id)
    {
        return DB::connection('mysql2')->table('purchase_request AS pr')->join('purchase_request_data AS prd','pr.id','=','prd.master_id')
            ->where([['prd.sub_item_id', '=', $id],['prd.status','=', 1]])
            ->select('prd.*','pr.supplier_id')
            ->orderBy('pr.id', 'desc')->first();
    }

    public static function LastPODetail($id)
    {
        return  PurchaseRequestData::join('purchase_request','purchase_request.id', 'purchase_request_data.master_id')->where('purchase_request.status', 1)->where('purchase_request_data.status', 1)->where('purchase_request_data.sub_item_id', $id)->orderBy('purchase_request_data.id', 'desc')->first();
    }

    public static function get_last_rate_qty_location_wise($item_id, $warehouse_id)
    {
        $stock = Stock::where('sub_item_id', $item_id)->where('warehouse_id', $warehouse_id)->where('transfer_status', 0)->where('voucher_type', 1)->where('opening', 0)->where('status', 1)->orderBy('id', 'desc')->first();
        if($stock){
            $poNo = GoodsReceiptNote::select('po_no')->where('grn_no', $stock->voucher_no)->where('status', 1)->first()->po_no??'-';
        }else{
            $poNo = '';
        }
        // dd($stock);
        return [$stock, $poNo];
    }


    public static function get_supplier_address($id)
    {
        $supplier_info = new SupplierInfo();
        $supplier_info = $supplier_info->SetConnection('mysql2');
        $supplier_info = $supplier_info->where('supp_id', $id)->select('address');
        if ($supplier_info->count() > 0) :

            return $supplier_info->first()->address;
        else :
            return "";
        endif;
    }

    public static function get_all_demand_type()
    {
        $demand_type = new DemandType();
        $demand_type = $demand_type->where('status', 1)->select('name', 'id')->get();
        return $demand_type;
    }

    public static function get_name_demand_type($id)
    {
        $demand_type = new DemandType();
        $demand_type = $demand_type->SetConnection('mysql2');
        $demand_type = $demand_type->where('status', 1)->where('id', $id)->select('name')->first();
        return $demand_type->name;
    }

    public static function get_all_warehouse()
    {
        $warehouse = new Warehouse();
        $warehouse = $warehouse->SetConnection('mysql2');
        $warehouse = $warehouse->where('status', 1)->select('name', 'id')->get();
        return $warehouse;
    }

    public static function get_id_wise_warehouse($ids)
    {
        $warehouse = new Warehouse();
        $warehouse = $warehouse->SetConnection('mysql2');
        $warehouse = $warehouse->whereIn('id', $ids);
        $warehouse = $warehouse->where('status', 1)->select('name', 'id')->get();
        return $warehouse;
    }
    public static function get_users_warehouse()
    {
        $userWarehouses = explode(',', Auth::user()->warehouse);
        $warehouses = Warehouse::whereIn('id', $userWarehouses)->where('status', 1)->get();
        return $warehouses;
    }

    public static function get_privious_approved_quotation_qty($pr_id,$pr_data_id,$sub_item_id){
        return $getDetail = DB::connection('mysql2')->table('quotation_data')->where('pr_id',$pr_id)->where('pr_data_id',$pr_data_id)->where('sub_item_id',$sub_item_id)->whereIn('quotation_status',[1,2])->sum('qty');
    }

    public static function get_name_warehouse($id)
    {
        $warehouse = new Warehouse();
        $warehouse = $warehouse->SetConnection('mysql2');
        $warehouse = $warehouse->where('status', 1)->where('id', $id)->select('name')->first();
        return $warehouse->name;
    }

    public static function get_all_supplier()
    {
        $supplier = new Supplier();
        // $supplier = $supplier->SetConnection('mysql2');
        $supplier = $supplier->where('status', 1)->select('id', 'name', 'address', 'mobile_no', 'work_phone')->get();
        return $supplier;
    }

    public static function get_parent_id($id)
    {

        if ($id != 0) :
            $account = new Account();;
            $account = $account->SetConnection('mysql2');
            $account_parent_id = $account->where('status', 1)->where('id', $id)->select('parent_code')->first();
            $parent_code = $account_parent_id->parent_code;
            $account = $account->where('status', 1)->where('code', $parent_code)->select('id')->first();
            return $account->id;
        endif;
    }

    public static function get_goodreciptnotedata($id, $index)
    {
        // dd($id);

        $goodreciptnote = new GoodsReceiptNote();
        $goodreciptnote = $goodreciptnote->SetConnection('mysql2');
        $goodreciptnote = $goodreciptnote->where('status', 1)->where('po_no', $id)->select('id', 'grn_no', 'grn_date', 'company_location_id', 'supplier_invoice_no', 'supplier_id', 'type', 'po_no', 'bill_date', 'sub_department_id', 'p_type')->first();

        // dd($goodreciptnote);

        $PurchaseRequest = new PurchaseRequest();
        $PurchaseRequest = $PurchaseRequest->SetConnection('mysql2');
        $PurchaseRequest = $PurchaseRequest->where('status', 1)->where('purchase_request_no', $goodreciptnote->po_no)->select('currency_id', 'currency_rate', 'purchase_request_date', 'sales_tax', 'sales_tax_amount', 'terms_of_paym')->first();

        $data[0] = $goodreciptnote;
        $data[1] = $PurchaseRequest;
        return $data[$index];
    }

    public static function get_goodreciptnotedata_pr($id, $index)
    {
        // dd($id);

        $goodreciptnote = new GoodsReceiptNote();
        $goodreciptnote = $goodreciptnote->SetConnection('mysql2');
        $goodreciptnote = $goodreciptnote->where('status', 1)->where('id', $id)->select('id', 'grn_no', 'grn_date', 'company_location_id', 'supplier_invoice_no', 'supplier_id', 'type', 'po_no', 'bill_date', 'sub_department_id', 'p_type')->first();

        // dd($goodreciptnote);

        $PurchaseRequest = new PurchaseRequest();
        $PurchaseRequest = $PurchaseRequest->SetConnection('mysql2');
        $PurchaseRequest = $PurchaseRequest->where('status', 1)->where('purchase_request_no', $goodreciptnote->po_no)->select('currency_id', 'currency_rate', 'purchase_request_date', 'sales_tax', 'sales_tax_amount', 'terms_of_paym')->first();

        $data[0] = $goodreciptnote;
        $data[1] = $PurchaseRequest;
        return $data[$index];
    }


    public static function get_grndata($master_id)
    {
        // dd($master_id);
        $grn_data = new GRNData();
        $grn_data = $grn_data->SetConnection('mysql2');
        $grn_data = $grn_data->whereIn('master_id', $master_id)->where('purchase_recived_qty', '>', 0)->where('grn_status', 2)->select('id', 'grn_no', 'sub_item_id', 'purchase_recived_qty', 'qc_qty', 'po_data_id', 'rate', 'amount', 'discount_percent', 'discount_amount', 'net_amount', 'description')->get();
        // dd($grn_data);
        return $grn_data;
    }

    public static function get_rate($PoDataId)
    {

        $PurchaseRequestData = new PurchaseRequestData();
        $PurchaseRequestData = $PurchaseRequestData->SetConnection('mysql2');
        $Rate = $PurchaseRequestData->where('id', $PoDataId)->select('rate')->first();
        return $Rate;
    }

    public static function get_Po_detail($id)
    {

        $po_data = new PurchaseRequestData();
        $po_data = $po_data->SetConnection('mysql2');
        $po_data = $po_data->where('status', 1)->where('id', $id)->select('rate', 'sub_total', 'discount_percent', 'discount_amount', 'net_amount')->first();
        return $po_data;
    }

    public static function get_sales_tax_data_from_purchase_request($id)
    {
        $purchase_request = new PurchaseRequest();
        $purchase_request = $purchase_request->SetConnection('mysql2');
        $purchase_request = $purchase_request->where('status', 1)->where('purchase_request_no', $id)->select('sales_tax', 'sales_tax_amount')->first();
        return $purchase_request;
    }

    public static function get_supp_income_tax_detail($id)
    {
        $register_no = '';
        $supplier_info = new Supplier();
        $supplier_info = $supplier_info->SetConnection('mysql2');
        $supplier_info = $supplier_info->where('id', $id)->select('resgister_income_tax', 'business_type', 'cnic', 'ntn', 'filer', 'strn', 'register_sales_tax', 'register_pra', 'pra', 'srb', 'register_srb')->first();

        if ($supplier_info->resgister_income_tax == 1) :
            if ($supplier_info->business_type == 1) :

                if ($supplier_info->cnic != '0' && $supplier_info->cnic != '-') :
                    $register_no = $supplier_info->cnic;
                else :
                    if ($supplier_info->ntn != 0) :
                        echo $register_no = $supplier_info->ntn;
                    else :
                        $register_no = '';
                    endif;
                endif;

            else :
                $register_no = $supplier_info->ntn;
            endif;

        else :
            $register_no = "No NTN Found";
        endif;

        return $register_no . ',' . $supplier_info->filer . ',' . $supplier_info->business_type . ',' . $supplier_info->register_sales_tax . ',' . $supplier_info->strn . ',' . $supplier_info->register_pra
            . ',' . $supplier_info->pra . ',' . $supplier_info->srb . ',' . $supplier_info->register_srb;
    }


    public static function  get_income_txt_nature($txt_nature)
    {

        $nature = 'No Define';
        if ($txt_nature == 1) :
            $nature = 'Supplies';
        endif;
        if ($txt_nature == 2) :
            $nature = 'Services';
        endif;

        return $nature;
    }

    public static function purchas_voucher_data_for_income_txt_calculation($master_id, $type)
    {
        // $income_txt_data=DB::Connection('mysql2')
        //   ->table('purchase_voucher_data')
        ///  ->where('master_id',$master_id)
        if ($type == 1) :

            $income_txt_data = DB::Connection('mysql2')->select('select sum(net_amount)amount,income_txt_nature from purchase_voucher_data
    where master_id IN (' . $master_id . ')
    and income_txt_nature!=0
    group by income_txt_nature');
            return $income_txt_data;
        else :
            $income_txt_data = DB::Connection('mysql2')->select('select sum(total_amount)amount,income_txt_nature from purchase_voucher_data_through_grn
    where master_id IN (' . $master_id . ')
    and income_txt_nature!=0
    group by income_txt_nature');
            return $income_txt_data;
        endif;

        //  return $income_txt_data;
    }


    public static function purchas_voucher_data_fbr_srb_pra_calculation($master_id, $type)
    {

        $txt_nature = DB::Connection('mysql2')->selectOne('select sum(net_amount)amount,sum(sales_tax_amount)s_amount from purchase_voucher_data
        where master_id IN (' . $master_id . ')
        and txt_nature!=0
        and txt_nature="' . $type . '"');
        return $txt_nature->amount . ',' . $txt_nature->s_amount;
        //  return $income_txt_data;
    }

    public static function  sales_tax_nature($sales_tax_nature)
    {

        $nature = 'No Define';
        if ($sales_tax_nature == 1) :
            $nature = 'FBR';
        endif;
        if ($sales_tax_nature == 2) :
            $nature = 'SRB';
        endif;
        if ($sales_tax_nature == 3) :
            $nature = 'PRA';
        endif;
        return $nature;
    }


    public static function advance_payment()
    {
        return $advance_data = DB::Connection('mysql2')
            ->table('pvs as p')
            ->where('payment_type', 2)
            ->where('status', 1)
            ->select('p.pv_no', 'p.pv_date', 'p.id')
            ->get();
    }

    public static function getLocationDetail($id)
    {
        return CompanyLocation::find($id);
    }

    public static function getCompanyLocationPrefix($id)
    {
        return CompanyLocation::find($id)->prefix ?? '';
    }

    public static function getComparativeNoByPrId($id)
    {
        return Quotation_Data::join('quotation', 'quotation.id', 'quotation_data.master_id')
            ->select('quotation.group_number')
            ->where('quotation_data.pr_data_id', $id)
            ->where('quotation_data.status', 1)
            ->where('quotation.status', 1)
            ->first();
    }

    public static function getComparativeNoByPrIdTwo($id){
        return Quotation_Data::join('quotation', 'quotation.id', 'quotation_data.master_id')
            ->select('quotation.group_number')
            ->where('quotation_data.voucher_no', $id)
            ->first();
    }



    public static function get_supplier_for_advance_system($id)
    {

        $acc_id = DB::Connection('mysql2')->table('pv_data as d')
            ->join('accounts as a', 'a.id', '=', 'd.acc_id')
            ->join('supplier  as s', 'a.id', '=', 's.acc_id')
            ->select('a.id', 'a.name', 's.name as supp_name', 's.id', 'd.amount', 'a.id as acc_id', 'd.master_id')
            ->where('a.type', 1)
            ->where('d.master_id', $id)
            ->first();

        return $acc_id->supp_name . '*' . $acc_id->id . '*' . $acc_id->amount . '*' . $acc_id->acc_id . '*' . $acc_id->master_id;
    }

    public static function get_po_type($type)
    {
        $po_type = '';
        if ($type == 1) :
            $po_type = 'Purchase';
        endif;
        if ($type == 2) :
            $po_type = 'Self';
        endif;
        if ($type == 3) :
            $po_type = 'International';
        endif;
        return $po_type;
    }
    public static function getMRVoucherNumber()
    {
        $str = MaintenanceRequest::count();
        $voucher_no = 'MR-' . sprintf("%'05d", ($str + 1)); // . date('my');
        return $voucher_no;
    }
    public static function getMJVoucherNumber()
    {
        $latestVoucher = DB::Connection('mysql2')->table('maintenance_jobs')
        ->where('voucher_no', 'like', 'MJ-%')
        ->select(DB::raw('MAX(CAST(SUBSTRING(voucher_no, 5) AS UNSIGNED)) as max_no'))
        ->value('max_no');

        $nextNumber = $latestVoucher ? $latestVoucher + 1 : 1;

        $voucher_no = 'MJ-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        // $str = MaintenanceJob::whereIn('job_type', [1,4])->count();
        // $voucher_no = 'MJ-' . sprintf("%'05d", ($str + 1)); // . date('my');
        return $voucher_no;
    }

    public static function getMIVoucherNumber()
    {
        $str = MaintenanceInvoice::count();
        $voucher_no = 'BOM-' . sprintf("%'05d", ($str + 1)); // . date('my');
        return $voucher_no;
    }
    public static function getWMIVoucherNumber()
    {
        $str = WorkshopMaterialIssuance::count();
        $voucher_no = 'WMI-' . sprintf("%'05d", ($str + 1)); // . date('my');
        return $voucher_no;
    }
    public static function getWGRNVoucherNumber()
    {
        $str = WorkshopGrn::count();
        $voucher_no = 'WGRN-' . sprintf("%'05d", ($str + 1)); // . date('my');
        return $voucher_no;
    }

    public static function getMJOVoucherNumber()
    {
    
        $latestVoucher = DB::Connection('mysql2')->table('maintenance_jobs')
        ->where('voucher_no', 'like', 'MJO-%')
        ->select(DB::raw('MAX(CAST(SUBSTRING(voucher_no, 5) AS UNSIGNED)) as max_no'))
        ->value('max_no');

        $nextNumber = $latestVoucher ? $latestVoucher + 1 : 1;

        $voucher_no = 'MJO-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        // $str = MaintenanceJob::whereIn('job_type', [2,3])->count();
        // $voucher_no = 'MJO-' . sprintf("%'05d", ($str + 1)); // . date('my');
        return $voucher_no;
    }
    public static function getGRVoucherNumber()
    {
        $str = GoodsReturn::count();
        $voucher_no = 'WGR-' . sprintf("%'05d", ($str + 1)); // . date('my');
        return $voucher_no;
    }
    public static function getGatePassINVoucherNumber()
    {
        $str = GatePass::count();
        $voucher_no = 'GPI-' . sprintf("%'05d", ($str + 1)); // . date('my');
        return $voucher_no;
    }
    public static function getGatePassOUTVoucherNumber()
    {
        $str = GatePass::count();
        $voucher_no = 'GPO-' . sprintf("%'05d", ($str + 1)); // . date('my');
        return $voucher_no;
    }
    public static function get_unique_no($year, $month, $type)
    {
        $purchaseRequestNo = '';

        $variable = 100;
        sprintf("%'03d", $variable);
        $str = DB::Connection('mysql2')->selectOne("select max(convert(substr(`purchase_request_no`,7,length(substr(`purchase_request_no`,3))-3),signed integer)) reg
         from `purchase_request` where substr(`purchase_request_no`,3,2) = " . $year . " and substr(`purchase_request_no`,5,2) = " . $month . "
         and po_type='" . $type . "'")->reg;
        $str = $str + 1;
        $str = sprintf("%'03d", $str);
        if ($type == 1) :
            $purchaseRequestNo = 'pl' . $year . $month . $str;
        endif;
        if ($type == 2) :
            $purchaseRequestNo = 'pS' . $year . $month . $str;
        endif;
        if ($type == 3) :
            $purchaseRequestNo = 'pI' . $year . $month . $str;
        endif;
        return $purchaseRequestNo;
    }

    public static function get_unique_direct_po_no($type, $location)
    {

        $str = PurchaseRequest::where([['company_location_id', $location], ['type', $type]])->count();

        $voucher_no = 'sp-' . CommonHelper::getCompanyLocationPrefix($location) . '-' . sprintf("%'05d", ($str + 1)); // . date('my');

        return $voucher_no;

        $id  = DB::Connection('mysql2')->selectOne('SELECT MAX(id) as id  FROM `purchase_request` where `type` =  ' . $type . '')->id;
        if ($id != '') :
            $MaxNo  = DB::Connection('mysql2')->selectOne('SELECT purchase_request_no  FROM `purchase_request` where id =  ' . $id . '')->purchase_request_no;
            $MaxNo = substr($MaxNo, 2);
        else :
            $MaxNo = 0;
        endif;
        $str = $MaxNo + 1;
        $str = sprintf("%'03d", $str);

        // if ($type == 1):
        //     $purchaseRequestNo = 'pl' . $str;
        // endif;
        // if ($type == 2):
        //     $purchaseRequestNo = 'pS' .  $str;
        // endif;
        // if ($type == 3):
        $purchaseRequestNo = 'sp' . $str;
        // endif;
        return $purchaseRequestNo;
    }
    public static function get_unique_po_no($type, $location)
    {

        $str = PurchaseRequest::where([['company_location_id', $location], ['type', $type]])->count();
        $voucher_no = 'pl-' . CommonHelper::getCompanyLocationPrefix($location) . '-' . sprintf("%'05d", ($str + 1)); // . date('my');

        return $voucher_no;
        $id  = DB::Connection('mysql2')->selectOne('SELECT MAX(id) as id  FROM `purchase_request` where `type` =  ' . $type . '')->id;
        if ($id != '') :
            $MaxNo  = DB::Connection('mysql2')->selectOne('SELECT purchase_request_no  FROM `purchase_request` where id =  ' . $id . '')->purchase_request_no;
            $MaxNo = substr($MaxNo, 2);
        else :
            $MaxNo = 0;
        endif;
        $str = $MaxNo + 1;
        $str = sprintf("%'03d", $str);

        if ($type == 1) :
            $purchaseRequestNo = 'pl' . $str;
        endif;
        if ($type == 2) :
            $purchaseRequestNo = 'pS' .  $str;
        endif;
        if ($type == 3) :
            $purchaseRequestNo = 'pI' . $str;
        endif;
        return $purchaseRequestNo;
    }

    public static function get_unique_ev_no()
    {


        $MaxNo = DB::Connection('mysql2')->selectOne('SELECT MAX(substr(ev_no,3)) as ev_no  FROM `expense_voucher`')->ev_no;

        $str = $MaxNo + 1;
        $str = sprintf("%'03d", $str);


        $EvNo = 'ev' . $str;
        return $EvNo;
    }

    public static function get_unique_import_no($year, $month)
    {


        //        $MaxNo = DB::Connection('mysql2')->selectOne('SELECT MAX(voucher_no) as voucher_no  FROM `import_po` where status = 1')->voucher_no;
        //
        //        $str = $MaxNo + 1;
        //        $str = sprintf("%'03d", $str);
        //
        //        return $str;



        $variable = 100;
        $str = DB::Connection('mysql2')->selectOne("SELECT MAX(SUBSTR(voucher_no, 8, 3)) AS ExtractString
        FROM import_po  where substr(`voucher_no`,4,2) = " . $year . " and substr(`voucher_no`,6,2) = " . $month . " ")->ExtractString;

        $str = $str + 1;
        $str = sprintf("%'03d", $str);

        $pv_no = 'IGM' . $year . $month . $str;

        return $pv_no;
    }

    public static function get_last_order_and_recive_qty($id)
    {

        $grn_data = DB::Connection('mysql2')->selectOne('select max(purchase_approved_qty)approve_qty,max(purchase_recived_qty)recived_qty from grn_data where status=1
        and sub_item_id="' . $id . '"');

        return $grn_data->approve_qty . ',' . $grn_data->recived_qty;
    }

    public static function get_po_type_query($po_no)
    {
        $purchase_order = new PurchaseRequest();
        $purchase_order = $purchase_order->SetConnection('mysql2');
        $purchase_order = $purchase_order->where('status', 1)->where('purchase_request_no', $po_no)->select('po_type')->first();
        return $purchase_order->po_type;
    }

    public static function import_costing_exists($id)
    {
        $exists = 0;
        $sub_charge = new SubItemCharges();
        $sub_charge = $sub_charge->SetConnection('mysql2');
        return $sub_charge = $sub_charge->where('grn_data_id', $id);
        //        if ($sub_charge->count() >0):
        //            $exists=1;
        //
        //            endif;
        //        return $exists;
    }

    public static function get_amount_by_po_data_id($id)
    {
        $purchase_request_data = new PurchaseRequestData();
        $purchase_request_data = $purchase_request_data->SetConnection('mysql2');
        $purchase_request_data = $purchase_request_data->where('id', $id)->select('rate', 'purchase_request_no')->first();

        $purchase_request = new PurchaseRequest();
        $purchase_request = $purchase_request->SetConnection('mysql2');
        $purchase_request = $purchase_request->where('purchase_request_no', $purchase_request_data->purchase_request_no)->select('currency_rate')->first();
        return $purchase_request_data->rate . ',' . $purchase_request->currency_rate;
    }

    public static function get_item_by_category($id)
    {

        $Subitem = new Subitem();
        $Subitem = $Subitem->SetConnection('mysql2');
        return $Subitem = $Subitem->where('status', 1)->where('main_ic_id', $id)->get();
    }

    public static function get_all_department_po($m)
    {
        $departments = new Department();
        return $departments = $departments::where([['status', '=', '1'],])->select('id', 'department_name')->orderBy('id')->get();
    }

    public static function get_dept_name_hr($m, $Id)
    {
        //        $departments = new Department();
        //        $departments = $departments::where([['company_id', '=', $m],['id', '=', $Id], ['status', '=', '1']])->select('id','department_name')->first();
        $departments =  DB::table('department')->where('company_id', $m)->where('id', $Id)->first();
        return $departments;
    }

    public static function get_all_hr_department()
    {
        $company_id = Session::get('run_company');
        $department = new Department();
        return $department = $department->where('status', 1)->where('company_id', $company_id)->get();
    }

    public static function get_all_sub_department_by_department($id)
    {
        $company_id = Session::get('run_company');
        $sub_department = new SubDepartment();
        return $sub_department = $sub_department->where('status', 1)->where('department_id', $id)->get();
    }

    public static function get_all_sub_department()
    {

        $sub_department = new SubDepartment();
        return $sub_department = $sub_department->where('status', 1)->get();
    }

    public static function get_sub_dept_name($id)
    {

        $sub_department = new SubDepartment();
        return $sub_department = $sub_department->where('status', 1)->where('id', $id)->value('sub_department_name');
    }
    public static function get_machine_name($id)
    {

        $sub_department = new Machinery();
        return $sub_department = $sub_department->where('status', 1)->where('id', $id)->value('name');
    }
    public static function get_line_name($id)
    {

        $sub_department = new Line();
        return $sub_department = $sub_department->where('status', 1)->where('id', $id)->value('name');
    }

    public static function check_str_replace($value)
    {

        if ($value == '') :
            $value = 0;
        else :
            $value = str_replace(',', '', $value);

        endif;

        return $value;
    }

    public static function byers_name($id)
    {
        $customer = new Customer();
        $customer = $customer->SetConnection('mysql2');
        return $customer = $customer->where('id', $id)->select('name', 'address', 'cnic_ntn', 'strn', 'acc_id')->first();
    }
    public static function client_name($id)
    {
        $client = new Client();
        $client = $client->SetConnection('mysql2');
        return $client = $client->where('id', $id)->select('id', 'client_name', 'address', 'ntn', 'strn')->first();
    }
    public static function get_purchase_amount($id)
    {
        return DB::Connection('mysql2')->selectOne("select sum(`amount`) total from new_purchase_voucher_data  where `master_id` = '" . $id . "'")->total;
    }



    public static function cost_center_counter($id, $type)
    {

        $c_allocation = new CostCenterDepartmentAllocation();
        $c_allocation = $c_allocation->SetConnection('mysql2');
        return $c_allocation = $c_allocation->where('Main_master_id', $id)->where('type', $type)->count();
    }

    public static function dept_center_counter($id, $type)
    {

        $dept_allocation = new DepartmentAllocation1();
        $dept_allocation = $dept_allocation->SetConnection('mysql2');
        return $dept_allocation = $dept_allocation->where('Main_master_id', $id)->where('type', $type)->count();
    }

    public static function get_accounts_for_jvs()
    {
        return $accounts = DB::Connection('mysql2')->table('accounts as  a')
            ->leftJoin('supplier', 'a.id', '=', 'supplier.acc_id')
            ->select('a.id', 'a.code', 'a.name', 'supplier.status as supp_id', 'supplier.id as supplier_id')
            ->where('a.status', 1)
            ->orderBy('a.level1', 'ASC')
            ->orderBy('a.level2', 'ASC')
            ->orderBy('a.level3', 'ASC')
            ->orderBy('a.level4', 'ASC')
            ->orderBy('a.level5', 'ASC')
            ->orderBy('a.level6', 'ASC')
            ->orderBy('a.level7', 'ASC')
            ->get();
    }

    public static function settings()
    {
        //        $UserData['UserId'] = Auth::user()->id;
        //        $UserData['UserName'] = Auth::user()->name;
        //Storage::disk('local')->put('file.txt', "asdfasd");
        Storage::put('file.txt', 'contents is written inside file.txt');
    }

    public static function check_account($id)
    {

        $transactions = new Transactions();
        $transactions = $transactions->SetConnection('mysql2');
        $transactions = $transactions->where('status', 1)->where('acc_id', $id)->select('amount');
        if ($transactions->count() > 0) :
            return 1;
        else :
            return 0;
        endif;
    }

    public static function check_amount_in_ledger($voucher_no, $master_id, $type)
    {
        return   DB::Connection('mysql2')->table('transactions')->where('master_id', $master_id)->where('voucher_no', $voucher_no)->where('voucher_type', $type)->count();
    }

    public static function dayBookQuery($table, $voucher_no, $voucher_date, $date)
    {
        return   DB::Connection('mysql2')->table($table)->where('status', 1)->where($voucher_date, $date)->select("$voucher_no as voucher_no", "$voucher_date as voucher_date", 'slip_no', 'id')->get()->toArray();
    }

    public static function debit_credit_amount($table, $id)
    {

        $d_acc = DB::Connection('mysql2')->selectOne('select accounts.name name from ' . $table . ' as data
		inner join `accounts` on accounts.id = data.acc_id where data.debit_credit = 1 and data.master_id = \'' . $id . '\'')->name;

        $c_acc = DB::Connection('mysql2')->selectOne('select accounts.name name from ' . $table . ' as data
		inner join `accounts` on accounts.id = data.acc_id where data.debit_credit = 0 and data.master_id = \'' . $id . '\'')->name;

        $debit_amount = DB::Connection('mysql2')->selectOne("select sum(`amount`) total from $table  where `debit_credit` = 1 and `master_id` = '" . $id . "'")->total;



        $credit_amount = DB::Connection('mysql2')->selectOne("select sum(`amount`) total from $table where `debit_credit` = 0 and `master_id` = '" . $id . "'")->total;
        return 'Dr = ' . $d_acc . '&nbsp;&nbsp;&nbsp;' . ' ' . ' ' . number_format($debit_amount, 2) . '' . '</br>' . ' Cr = ' . $c_acc . '&nbsp;&nbsp;&nbsp;' . ' ' . ' ' . number_format($credit_amount, 2);
    }

    public static function GetAmount($table, $id)
    {
        $debit_amount = DB::Connection('mysql2')->selectOne("select sum(`amount`) total from $table  where `debit_credit` = 1 and `master_id` = '" . $id . "'")->total;
        return $debit_amount;
    }
    public static function total_amount_for_book_day($table, $id)
    {
        return DB::Connection('mysql2')->selectOne("select sum(`amount`) total from $table where `debit_credit` = 0 and `master_id` = '" . $id . "'")->total;
    }

    public static  function check_status($table, $id)
    {
        $process = 0;
        if ($table == 'jvs') :
            $process =   DB::Connection('mysql2')->table($table)->where('status', 1)->where('id', $id)->select('paid')->first();
            $process =  $process->paid;
        endif;

        return $process;
    }

    public static function check_payment($jv_id)
    {
        return  DB::Connection('mysql2')->selectOne('select sum(amount)amount from breakup_data where jv_id="' . $jv_id . '"
      ')->amount;
    }

    public static function get_breakup_amount($main_id, $debit_credit, $supplier_id)
    {
        return  DB::Connection('mysql2')->selectOne('select sum(amount)amount from breakup_data where main_id="' . $main_id . '"
      and debit_credit="' . $debit_credit . '" and supplier_id="' . $supplier_id . '" and status=1')->amount;
    }

    public static function get_amount_to_be_paid($main_id, $supplier_id)
    {



        $credit =  DB::Connection('mysql2')->selectOne('select sum(amount)amount from breakup_data where main_id="' . $main_id . '"
      and debit_credit=0 and supplier_id="' . $supplier_id . '" and status=1')->amount;

        $debit =  DB::Connection('mysql2')->selectOne('select sum(amount)amount from breakup_data where main_id="' . $main_id . '"
      and debit_credit=1 and supplier_id="' . $supplier_id . '" and status=1')->amount;

        $credit - $debit;
        return $credit - $debit;
    }


    public static function supplier_account_exists($id)
    {
        $return_value = false;
        $count =  DB::Connection('mysql2')->table('supplier')->where('acc_id', $id)->count();
        if ($count > 0) :
            $return_value = true;
        endif;
        return $return_value;
    }

    public static function get_supplier_id_by_account($id)
    {

        return  $supplier =  DB::Connection('mysql2')->table('supplier')->where('acc_id', $id)->select('id')->first();
    }

    public static function get_all_clients()
    {
        $client = new Client();
        $client = $client->SetConnection('mysql2');
        return  $client = $client->where('status', 1)->get();
    }
    public static function get_all_users()
    {
        $user = new User();
        return  $user = $user->where('status', 1)->get();
    }

    public static function get_all_surveryBy()
    {
        $survey = new SurveryBy();
        $survey = $survey->SetConnection('mysql2');
        return  $survey = $survey->where('status', 1)->get();
    }

    public static function get_client_name_by_id($id)
    {
        $client = new Client();
        $client = $client->SetConnection('mysql2');
        $client = $client->where('status', 1)->where('id', $id)->first();
        return $client->client_name;
    }
    public static function get_client_data_by_id($id)
    {
        $client = new Client();
        $client = $client->SetConnection('mysql2');
        return  $client = $client->where('status', 1)->where('id', $id)->first();
    }
    public static function gey_survey_by_name($id)
    {
        $suvey = new SurveryBy();
        $suvey = $suvey->SetConnection('mysql2');
        $suvey = $suvey->where('status', 1)->where('id', $id)->first();
        return $suvey->name;
    }

    public static function get_all_regions()
    {
        $region = new Region();
        $region = $region->SetConnection('mysql2');
        return  $region = $region->where('status', 1)->get();
    }

    public static function get_rgion_name_by_id($id)
    {
        $region = new Region();
        $region = $region->SetConnection('mysql2');
        return  $region = $region->where('status', 1)->where('id', $id)->first();
    }

    public static function get_all_type()
    {
        $type = new Type();
        $type = $type->SetConnection('mysql2');
        return  $type = $type->where('status', 1)->get();
    }

    public static function get_all_product_type()
    {
        $productType = new ProductType();
        $productType = $productType->SetConnection('mysql2');
        return  $productType = $productType->where('status', 1)->get();
    }

    public static function get_all_product_type_byID($id)
    {

        $productType = new ProductType();
        $productType = $productType->SetConnection('mysql2');
        return $productType = $productType->where('status', 1)->where('product_type_id', $id)->first();
    }

    public static function get_all_type_by_id($id)
    {
        $type = new Type();
        $type = $type->SetConnection('mysql2');
        return  $type = $type->where('status', 1)->where('type_id', $id)->select('name')->first();
    }

    public static function get_all_cities()
    {
        $cities = new Cities();
        return $cities = $cities->where('status', 1)->whereIn('state_id', array(2723, 2724, 2725, 2726, 2727, 2728, 2729))->get();
    }

    public static function get_all_cities_by_id($id)
    {
        $cities = new Cities();
        return $cities = $cities->where('status', 1)->where('id', $id)->select('name')->first();
    }

    public static function get_all_account()
    {
        $account = new Account();
        $account = $account->SetConnection('mysql2');
        return $account = $account->where('status', 1)->where('operational', 1)->select('id', 'name', 'code')
            ->orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')
            ->get();
    }

    public  static function get_amount_from_stock($voucher_type, $item, $warehouse, $batch_code = null, $fromDateForStock = null, $toDateForStock = null)
    {
        $dateCondition = '';
        if ($fromDateForStock && $toDateForStock) {
            $dateCondition = "and voucher_date BETWEEN '" . $fromDateForStock . "' AND '" . $toDateForStock . "'";
        }
        $data = $stock = DB::Connection('mysql2')->selectOne('select sum(qty)qty from stock
            where status=1 ' . $dateCondition . '  and voucher_type="' . $voucher_type . '" and sub_item_id="' . $item . '" and warehouse_id="' . $warehouse . '"  group by sub_item_id');

        if (!empty($data->qty)) :

            return $data->qty;
        else :
            return 0;
        endif;
    }
    public  static function get_qty_from_stock_year_wise($voucher_type, $item, $year)
    {
        $data = Stock::select(DB::raw('SUM(qty) as qty'))->where('status', 1)->where('sub_item_id', $item)
            ->whereYear('voucher_date', $year)->where('voucher_type', $voucher_type)
            ->groupBy('sub_item_id')->first();
        if (!empty($data->qty)) :
            return $data->qty;
        else :
            return 0;
        endif;
    }

    public  static function get_value_stock($voucher_type, $item, $warehouse, $from_date = null, $to_date = null)
    {
        $dateCondition = '';
        if ($from_date != null && $to_date != null) {
            $dateCondition = "and voucher_date BETWEEN '" . $from_date . "' AND '" . $to_date . "'";
        }

        $data = $stock = DB::Connection('mysql2')->selectOne('select sum(amount)amount from stock
        where status=1 ' . $dateCondition . '  and voucher_type="' . $voucher_type . '" and sub_item_id="' . $item . '" and warehouse_id="' . $warehouse . '"  group by sub_item_id');
        if (!empty($data->amount)) :

            return $data->amount;
        else :
            return 0;
        endif;
    }

    public  static function get_amount_from_stock_batch_wise($voucher_type, $item, $warehouse, $batch_code)
    {


        $data = $stock = DB::Connection('mysql2')->selectOne('select sum(qty)qty from stock
        where status=1  and voucher_type="' . $voucher_type . '" and sub_item_id="' . $item . '" and warehouse_id="' . $warehouse . '"
          and batch_code="' . $batch_code . '"
          group by sub_item_id');
        if (!empty($data->qty)) :

            return $data->qty;
        else :
            return 0;
        endif;
    }

    public static function get_all_resource()
    {
        $resuor = new ResourceAssigned();
        $resuor = $resuor->SetConnection('mysql2');
        return  $resuor = $resuor->where('status', 1)->get();
    }

    public static function get_all_uom()
    {
        $uom = new UOM();
        return $uom = $uom->where('status', 1)->get();
    }

    public static function get_single_row($TableName, $TableId, $DataId)
    {
        return DB::Connection('mysql2')->table($TableName)->where($TableId, $DataId)->where('status', 1)->first();
    }


    public static function get_single_row_prodcut($TableName, $TableId, $DataId)
    {
        return DB::Connection('mysql2')->table($TableName)->where($TableId, $DataId)->where('p_status', 1)->first();
    }
    public static function get_single_row_uom($TableName, $TableId, $DataId)
    {
        return DB::table($TableName)->where($TableId, $DataId)->where('status', 1)->first();
    }

    public static function get_data_from_survey_tracking($id, $type)
    {
        $client_job = '';
        $contact_person = '';
        $branch_name = '';
        if ($type == 1) :
            $data = DB::Connection('mysql2')->table('quotation')->where('id', $id)->select('tracking_no')->first();
            $tracking_no = $data->tracking_no;
        endif;
        if (!empty($tracking_no)) :
            $client_job = DB::Connection('mysql2')->table('job_tracking')->where('job_tracking_no', $tracking_no)->select('customer_job')->first();
            if (!empty($client_job->customer_job)) :
                $client_job = $client_job->customer_job;
            endif;
            $contact_person_data = DB::Connection('mysql2')->table('survey')->where('tracking_no', $tracking_no)->select('contact_person', 'branch_name')->first();
            $branch_name = $contact_person_data->branch_name;
            $contact_person = $contact_person_data->contact_person;
        endif;

        return $client_job . ',' . $contact_person . ',' . $branch_name;
    }

    public static function get_depth_from_survey($id)
    {
        return  DB::Connection('mysql2')->table('survey_data')->where('survey_data_id', $id)->select('depth')->first()->depth;
    }

    public static function get_complete_stock($item, $region)
    {

        $grn = $stock = DB::Connection('mysql2')->selectOne('select sum(qty)qty from stock
        where region_id="' . $region . '" and voucher_type="1" and sub_item_id="' . $item . '" group by sub_item_id');

        if (!empty($grn->qty)) :
            $grn = $grn->qty;
        endif;

        $return = $stock = DB::Connection('mysql2')->selectOne('select sum(qty)qty from stock
        where region_id="' . $region . '" and voucher_type="3" and sub_item_id="' . $item . '" group by sub_item_id');

        if (!empty($return->qty)) :
            $return = $return->qty;
        endif;

        $grn = $grn + $return;
        $issuence = $stock = DB::Connection('mysql2')->selectOne('select sum(qty)qty from stock
        where region_id="' . $region . '" and voucher_type="2" and sub_item_id="' . $item . '" group by sub_item_id');


        if (!empty($issuence->qty)) :
            $issuence = $issuence->qty;
        endif;
        return   $total = $grn - $issuence;
    }

    public static function check_job_order_data_count($id)
    {
        return  $job_order_data = DB::Connection('mysql2')->table('job_order_data')
            ->where('job_order_id', '=', $id)
            ->count();
    }

    public static function check_created($id)
    {
        $DeliveryCount = 0;
        $SalesTCount = 0;
        $CreditNCount = 0;
        $DeliveryNote = DB::Connection('mysql2')->table('delivery_note')->where('master_id', '=', $id)->where('status', 1)->count();
        $SalesTaxInvoice = DB::Connection('mysql2')->table('sales_tax_invoice')->where('so_id', '=', $id)->where('status', 1)->count();
        $CreditNote = DB::Connection('mysql2')->table('credit_note')->where('so_id', '=', $id)->where('status', 1)->count();
        if ($DeliveryNote > 0) : $DeliveryCount  = $DeliveryNote;
        else : $DeliveryCount = 0;
        endif;
        if ($SalesTaxInvoice > 0) : $SalesTCount  = $SalesTaxInvoice;
        else : $SalesTCount = 0;
        endif;
        if ($CreditNote > 0) : $CreditNCount  = $CreditNote;
        else : $CreditNCount = 0;
        endif;
        return $DeliveryCount . ',' . $SalesTCount . ',' . $CreditNCount;
    }


    public static function get_ids_delivery($id)
    {
        $DeliveryIds = "";
        $DeliveryNote = DB::Connection('mysql2')->table('delivery_note')->where('master_id', '=', $id)->where('status', 1);
        $SalesTaxInvoice = DB::Connection('mysql2')->table('sales_tax_invoice')->where('so_id', '=', $id)->where('status', 1);
        $CreditNote = DB::Connection('mysql2')->table('credit_note')->where('so_id', '=', $id)->where('status', 1);
        foreach ($DeliveryNote->get() as $DFil) {
            $DeliveryIds .= $DFil->id . ',';
        }
        return rtrim($DeliveryIds, ',');
    }


    public static function get_ids_sales_tax_invoice($id)
    {
        $DeliveryIds = "";
        $DeliveryNote = DB::Connection('mysql2')->table('sales_tax_invoice')->where('so_id', '=', $id)->where('status', 1);
        foreach ($DeliveryNote->get() as $DFil) {
            $DeliveryIds .= $DFil->id . ',';
        }
        return rtrim($DeliveryIds, ',');
    }

    public static function get_ids_credit_note($id)
    {
        $DeliveryIds = "";
        $DeliveryNote = DB::Connection('mysql2')->table('credit_note')->where('so_id', '=', $id)->where('status', 1);

        foreach ($DeliveryNote->get() as $DFil) {
            $DeliveryIds .= $DFil->id . ',';
        }
        return rtrim($DeliveryIds, ',');
    }

    public static function job_order()
    {
        $JobOrder = new JobOrder();
        $JobOrder = $JobOrder->SetConnection('mysql2');
        $JobOrder = $JobOrder->where('status', 1)->get();
        foreach ($JobOrder as $row) {
            ?>
            <option value="<?php echo $row['job_order_no']; ?>"> <?php echo $row['job_order_no']; ?> </option>
            <?php
        }
    }

    public static function JobOrderNoData($joborderno)
    {
        $JobOrder = new JobOrder();
        $JobOrder = $JobOrder->SetConnection('mysql2');
        return $JobOrder = $JobOrder->where('status', 1)->where('job_order_no', $joborderno)->value('job_order_id');
    }

    public  static function get_all_employe()
    {
        $employe = new Employee();
        $employe = $employe->SetConnection('mysql2');
        return $employe = $employe->where('status', 1)->get();
    }

    public static function table_counting($table, $column, $colum_val)
    {

        return   DB::Connection('mysql2')->table($table)->where('status', 1)->where($column, $colum_val)->count();
    }
    public static function get_all_client_job()
    {
        $ClientJob = new ClientJob();
        $ClientJob = $ClientJob->SetConnection('mysql2');
        return $ClientJob = $ClientJob->where('status', 1)->get();
    }

    public static function logActivity($voucher_no, $voucher_date, $action_type, $client_id, $table_name)
    {
        //insert=1 Update=2 delete=3
        date_default_timezone_set("Asia/Karachi");

        $data['voucher_no'] = $voucher_no;
        $data['v_date']     = $voucher_date;
        $data['action']     = $action_type;
        $data['table_name'] = $table_name;
        $data['client_id']  = $client_id;
        $data['status']     = 1;
        $data['username']   = Auth::user()->name;
        $data['date']       = date('Y-m-d');
        $data['time']       = date('h:i:sa');
        DB::Connection('mysql2')->table('logactivity')->insert($data);
    }

    public static function uniqe_no_for_pv($year, $month, $type)
    {
        $variable = 100;
        $str = DB::Connection('mysql2')->selectOne("SELECT MAX(SUBSTR(pv_no, 8, 3)) AS ExtractString
        FROM new_pv  where substr(`pv_no`,4,2) = " . $year . " and substr(`pv_no`,6,2) = " . $month . " and payment_type=" . $type . "")->ExtractString;

        $str = $str + 1;
        $str = sprintf("%'03d", $str);
        if ($type == 1) :
            $pv_no = 'bpv' . $year . $month . $str;
        endif;
        if ($type == 2) :
            $pv_no = 'cpv' . $year . $month . $str;
        endif;
        return $pv_no;
    }

    public static function uniqe_no_for_pvv($year, $month)
    {
        $str = DB::Connection('mysql2')->selectOne("select max(convert(substr(`pv_no`,7,length(substr(`pv_no`,3))-3),signed integer)) reg
        from `new_pvv` where substr(`pv_no`,3,2) = " . $year . " and substr(`pv_no`,5,2) = " . $month . "")->reg;
        $str = $str + 1;
        $str = sprintf("%'03d", $str);
        return  $pvno = 'pv' . $year . $month . $str;
    }

    public static function uniqe_no_for_jv($year, $month)
    {
        $purchaseRequestNo = '';

        $variable = 100;
        sprintf("%'03d", $variable);
        $str = DB::Connection('mysql2')->selectOne("select max(convert(substr(`jv_no`,7,length(substr(`jv_no`,3))-3),signed integer)) reg
         from `new_jvs` where substr(`jv_no`,3,2) = " . $year . " and substr(`jv_no`,5,2) = " . $month . "")->reg;
        $str = $str + 1;
        $str = sprintf("%'03d", $str);

        $JvNo = 'jv' . $year . $month . $str;
        return $JvNo;
    }

    public static function uniqe_no_for_purcahseVoucher($year, $month, $location)
    {
        $str = NewPurchaseVoucher::where('company_location_id', $location)->count();

        $voucher_no = 'pi-' . CommonHelper::getCompanyLocationPrefix($location) . '-' . sprintf("%'05d", ($str + 1)); // . date('my');

        return $voucher_no;

        // $str = DB::Connection('mysql2')->selectOne("select max(convert(substr(`pv_no`,7,length(substr(`pv_no`,3))-3),signed integer)) reg
        // from `new_purchase_voucher` where substr(`pv_no`,3,2) = " . $year . " and substr(`pv_no`,5,2) = " . $month . "")->reg;
        // $str = $str + 1;
        // $str = sprintf("%'03d", $str);
        // return  $purchaseRequestNo = 'pi' . $year . $month . $str;
    }

    public static function uniqe_no_for_rvs($year, $month, $type)
    {
        $variable = 100;
        $str = DB::Connection('mysql2')->selectOne("SELECT MAX(SUBSTR(rv_no, 8, 3)) AS ExtractString
        FROM new_rvs  where substr(`rv_no`,4,2) = " . $year . " and substr(`rv_no`,6,2) = " . $month . " and rv_type=" . $type . " ")->ExtractString;

        $str = $str + 1;
        $str = sprintf("%'03d", $str);
        if ($type == 1) :
            $rv_no = 'brv' . $year . $month . $str;
        endif;
        if ($type == 2) :
            $rv_no = 'crv' . $year . $month . $str;
        endif;
        return $rv_no;
    }

    public static function get_accounts_by_parent_code($code)
    {
        if ($code != "") :
            $account = new Account();;
            $account = $account->SetConnection('mysql2');
            return  $account = $account->where('status', 1)->where('parent_code', $code)->get();

        endif;
    }

    public static function payment_voucher_list($type)
    {
        return $acc_id = DB::Connection('mysql2')->table('pvs as p')
            ->join('pv_data as d', 'd.master_id', '=', 'p.id')
            ->select('p.*', DB::raw('SUM(d.amount) as amount'), 'd.acc_id')
            ->where('d.debit_credit', 1)
            ->where('p.status', 1)
            ->take(5)
            ->get();
    }
    public static function income_tax($pv_no)
    {

        $income_tax = new IncomeTaxDeduction();
        $income_tax = $income_tax->SetConnection('mysql2');
        $income_tax = $income_tax->where('pvs_id', $pv_no)->where('status', 1);
        if ($income_tax->count() > 0) :
            return $income_tax->get();
        else :
            return [];
        endif;
    }

    public static function get_nature_name($id)
    {
        $nature = '';
        if ($id == 1) :
            $nature = 'ALL GOODS';
        elseif ($id == 2) :
            $nature = 'IN CASE OF RICE,COTTON,SEED,EDIBLE OIL';
        elseif ($id == 3) :
            $nature = 'DISTRIBUTORS OF FAST MOVING CONSUMER GOODS';
        elseif ($id == 4) :
            $nature = 'SERVICES';
        elseif ($id == 5) :
            $nature = 'TRANSPORT SERVICES';
        elseif ($id == 6) :
            $nature = 'ELECTRONIC AND PRINT MEDIA FOR ADVERTISING';
        elseif ($id == 7) :
            $nature = 'CONTRACTS';
        elseif ($id == 8) :
            $nature = 'SPORT PERSON';
        elseif ($id == 9) :
            $nature = 'Services of Stitching , Dyeing , Printing , Embroidery etc';
        endif;
        return $nature;
    }

    public static function get_filer_and_percentage($id)
    {
        return  DB::Connection('mysql2')->table('income_tax_slab')->where('id', $id)->first();
    }

    public static function fbr_tax($id, $index)
    {
        $new_pv_data = new NewPvData();
        $new_pv_data = $new_pv_data->SetConnection('mysql2');
        $new_pv_data = $new_pv_data->where('tax_nature', 2)->where('master_id', $id);
        if ($new_pv_data->count() > 0) :
            $fbr_slab_id =  $new_pv_data->first()->slab_id;
            $fb_data = DB::Connection('mysql2')->table('sindh_sales_tax_withholding')->where('id', $fbr_slab_id)->first();
            $pv_data = $new_pv_data->first();

            $data[0] = $fb_data;
            $data[1] = $pv_data;

            return $data[$index];

        else :
            return [];
        endif;
    }


    public static function srb_tax($id, $index)
    {
        $new_pv_data = new NewPvData();
        $new_pv_data = $new_pv_data->SetConnection('mysql2');
        $new_pv_data = $new_pv_data->where('tax_nature', 3)->where('master_id', $id);
        if ($new_pv_data->count() > 0) :
            $srb_slab_id =  $new_pv_data->first()->slab_id;
            $srb_data = DB::Connection('mysql2')->table('srb')->where('id', $srb_slab_id)->first();
            $pv_data = $new_pv_data->first();

            $data[0] = $srb_data;
            $data[1] = $pv_data;

            return $data[$index];

        else :
            return [];
        endif;
    }

    public static function PaymentPurchaseAmountCheck($new_purchase_voucher_id)
    {
        return DB::Connection('mysql2')->table('new_purchase_voucher_payment')
            ->select(DB::raw('SUM(amount) as total_amount'))
            ->where('new_purchase_voucher_id', $new_purchase_voucher_id)
            ->where('status', 1)
            ->groupBy('new_purchase_voucher_id')
            ->value('total_amount');
    }

    public static function PaymentDebtorAmountCheck($si_id)
    {
        return DB::Connection('mysql2')->table('received_paymet')
            ->select(DB::raw('SUM(received_amount) as total_amount'))
            ->where('sales_tax_invoice_id', $si_id)
            ->where('status', 1)
            ->groupBy('sales_tax_invoice_id')
            ->value('total_amount');
    }



    public static function PaymentPurchaseAmountCheck_aging($new_purchase_voucher_id, $from, $to)
    {
        return DB::Connection('mysql2')->table('new_purchase_voucher_payment as a')
            ->select(DB::raw('SUM(a.amount) as total_amount'))
            ->join('new_pv as b', 'a.new_pv', '=', 'b.id')
            ->where('a.new_purchase_voucher_id', $new_purchase_voucher_id)
            ->where('a.status', 1)
            ->where('b.status', 1)
            ->where('b.pv_status', 2)
            ->whereBetween('b.pv_date', [$from, $to])
            ->groupBy('a.new_purchase_voucher_id')
            ->value('total_amount');
    }
    public static function PaymentPurchaseAmountCheck_aging_use_for_balance($new_purchase_voucher_id)
    {
        return DB::Connection('mysql2')->table('new_purchase_voucher_payment as a')
            ->select(DB::raw('SUM(a.amount) as total_amount'))
            ->join('new_pv as b', 'a.new_pv', '=', 'b.id')
            ->where('a.new_purchase_voucher_id', $new_purchase_voucher_id)
            ->where('a.status', 1)
            ->where('b.status', 1)
            ->where('b.pv_status', 2)
            ->groupBy('a.new_purchase_voucher_id')
            ->value('total_amount');
    }


    public static function PaymentSalesTaxInvoiceAmountCheck($SalesTaxInvoiceId, $from, $to)
    {
        return DB::Connection('mysql2')->table('received_paymet as a')
            ->select(DB::raw('SUM(a.received_amount) as total_amount'))
            ->join('new_rvs as b', 'a.receipt_id', 'b.id')
            ->where('a.sales_tax_invoice_id', $SalesTaxInvoiceId)
            ->where('a.status', 1)
            ->whereBetween('b.rv_date', [$from, $to])
            ->groupBy('a.sales_tax_invoice_id')
            ->value('total_amount');
    }

    public static function PurchaseAmountCheck($new_purchase_voucher_id)
    {
        return DB::Connection('mysql2')->table('new_purchase_voucher as a')
            ->join('new_purchase_voucher_data as b', 'a.id', 'b.master_id')

            ->select(DB::raw('SUM(b.net_amount) as total_amount'))
            ->where('a.id', $new_purchase_voucher_id)
            ->groupBy('a.id')
            ->value('total_amount');
    }

    public static function PurchaseAmountAndPayment()
    {
        $PurchaseAmountAndPayment = DB::Connection('mysql2')->select(' SELECT a.*, sum(b.amount) as purchase_amount, sum(c.amount) as received_amount from new_purchase_voucher a
            inner JOIN new_purchase_voucher_data b ON a.id=b.master_id
            LEFT JOIN new_purchase_voucher_payment c ON b.pv_no=c.pv_no
            where a.status=1
             GROUP by a.pv_no HAVING sum(b.amount) != COALESCE(sum(c.amount),0) ');
        return $PurchaseAmountAndPayment;
    }

    public static function NewPurchaseVoucherBySupplierId($supplier_id)
    {
        $NewPurchaseVoucher = new NewPurchaseVoucher();
        $NewPurchaseVoucher = $NewPurchaseVoucher->SetConnection('mysql2');
        $NewPurchaseVoucher = $NewPurchaseVoucher->where('status', '=', '1')->where('supplier', '=', $supplier_id)->get();
        return $NewPurchaseVoucher;
    }

    public static function NewPurchaseVoucherBySupplierAndPi($supplier_id,$pi)
    {
        $NewPurchaseVoucher = new NewPurchaseVoucher();
        $NewPurchaseVoucher = $NewPurchaseVoucher->SetConnection('mysql2');
        $NewPurchaseVoucher = $NewPurchaseVoucher
            ->where('status', '=', '1')
            ->where('supplier', '=', $supplier_id)
            ->where('id', '=', $pi)
            ->get();
        return $NewPurchaseVoucher;
    }


    public static function get_paid_to_name($id, $Type)
    {
        if ($id != '') :
            if ($Type == 1) {
                $Emp = new Employee();
                $Emp = $Emp->SetConnection('mysql2');
                $Emp = $Emp->where('id', $id)->first();
                return $Emp->emp_name;
            } else if ($Type == 2) {
                $Supplier = new Supplier();
                $Supplier = $Supplier->SetConnection('mysql2');
                $Supplier = $Supplier->where('id', $id)->where('status', 1)->first();
                return $Supplier->name;
            } else if ($Type == 3) {
                $Client = new Client();
                $Client = $Client->SetConnection('mysql2');
                $Client = $Client->where('id', $id)->where('status', 1)->first();
                return  $Client->client_name;
            } else if ($Type == 4) {
                $PaidTo = new PaidTo();
                $PaidTo = $PaidTo->SetConnection('mysql2');
                $PaidTo = $PaidTo->where('id', $id)->where('status', 1)->first();
                return  $PaidTo->name;
            } else {
                $Branch = new Branch();
                $Branch = $Branch->SetConnection('mysql2');
                $Branch = $Branch->where('id', $id)->where('status', 1)->first();
                return  $Branch->branch_name;
            }
        endif;
    }

    //zamzama income statement
    public static function get_ledger_amount($code, $databse, $nature_of_debit_credit, $nature_of_debit_credit_other, $from, $to)
    {

        static::companyDatabaseConnection($databse);
        $debit = DB::selectOne('select sum(amount)amount from transactions where status=1 and debit_credit="' . $nature_of_debit_credit . '" and acc_code = "' . $code . '"
         and v_date between "' . $from . '" and "' . $to . '"')->amount;
        if (!empty($debit)) :
            $debit = $debit;
        else :
            $debit = 0;
        endif;

        $credit = DB::selectOne('select sum(amount)amount from transactions where status=1 and debit_credit="' . $nature_of_debit_credit_other . '" and acc_code = "' . $code . '"
        and v_date between "' . $from . '" and "' . $to . '"')->amount;
        if (!empty($credit)) :
            $credit = $credit;
        else :
            $credit = 0;
        endif;
        static::reconnectMasterDatabase();
        return $debit - $credit;
    }
    public static function get_client_job_by_id($id)
    {
        if ($id != 0 && $id != '') :
            $client_job = new ClientJob();
            $client_job = $client_job->SetConnection('mysql2');
            $client_job = $client_job->where('id', $id)->select('client_job')->first();
            return $client_job->client_job;
        else :
            return '';
        endif;
    }

    public static function get_parent_amount($m, $from_date, $to_date, $code, $operation)
    {
        $code = $code . '-%';

        $debit = DB::Connection('mysql2')->selectOne(' select sum(amount) as amount from transactions where status=1
			 and  v_date BETWEEN "' . $from_date . '" and "' . $to_date . '" and acc_code like "' . $code . '"
			 and debit_credit=1 ')->amount;

        $credit = DB::Connection('mysql2')->selectOne('select sum(amount) as amount from transactions where status=1
			 and  v_date BETWEEN "' . $from_date . '" and "' . $to_date . '" and acc_code like "' . $code . '"
			 and debit_credit=0 ')->amount;

        return    $total = $debit - $credit;
    }

    public static function get_parent_and_account_amount($m, $from_date, $to_date, $code, $operation, $debit_credit_nature, $debit_credit_nature_)
    {


        $array = explode('-', $code);
        $level = count($array);
        //       echo  'select sum(amount) as amount from transactions where status=1
        //    and  v_date BETWEEN "'.$from_date.'" and "'.$to_date.'" and substring_index(acc_code,"-","'.$level.'") = "'.$code.'"
        //    and debit_credit=1';
        //        echo '</br>';
        $debit = DB::Connection('mysql2')->selectOne('select sum(amount) as amount from transactions where status =1
			 and  v_date BETWEEN "' . $from_date . '" and "' . $to_date . '" and substring_index(acc_code,"-","' . $level . '") = "' . $code . '"
			 and debit_credit="' . $debit_credit_nature . '"')->amount;


        $credit = DB::Connection('mysql2')->selectOne('select sum(amount) as amount from transactions where status=1
			 and  v_date BETWEEN "' . $from_date . '" and "' . $to_date . '" and substring_index(`acc_code`,"-","' . $level . '") = "' . $code . '"
			 and debit_credit="' . $debit_credit_nature_ . '"')->amount;

        return    $total = $debit - $credit;
    }
    public static function get_parent_and_account_amount_copy($m, $from_date, $to_date, $code, $operation, $debit_credit_nature, $debit_credit_nature_)
    {


        $array = explode('-', $code);
        $level = count($array);
        //       echo  'select sum(amount) as amount from transactions where status=1
        //    and  v_date BETWEEN "'.$from_date.'" and "'.$to_date.'" and substring_index(acc_code,"-","'.$level.'") = "'.$code.'"
        //    and debit_credit=1';
        //        echo '</br>';
        $debit = DB::Connection('mysql2')->selectOne('select sum(amount) as amount from transactions where status in (1,1993)
			 and  v_date BETWEEN "' . $from_date . '" and "' . $to_date . '" and substring_index(acc_code,"-","' . $level . '") = "' . $code . '"
			 and debit_credit="' . $debit_credit_nature . '"')->amount;


        $credit = DB::Connection('mysql2')->selectOne('select sum(amount) as amount from transactions where status in (1,1993)
			 and  v_date BETWEEN "' . $from_date . '" and "' . $to_date . '" and substring_index(`acc_code`,"-","' . $level . '") = "' . $code . '"
			 and debit_credit="' . $debit_credit_nature_ . '"')->amount;

        return    $total = $debit - $credit;
    }

    public static function get_debit_credit_amount($code, $nature_of_debit_credit, $nature_of_debit_credit_other, $from, $to)
    {

        $debit = DB::Connection('mysql2')->selectOne('select sum(amount)amount from transactions where status=1 and debit_credit="' . $nature_of_debit_credit . '" and acc_code= "' . $code . '"
            and v_date between "' . $from . '" and "' . $to . '"')->amount;
        if (!empty($debit)) :
            $debit = $debit;
        else :
            $debit = 0;
        endif;

        $credit = DB::Connection('mysql2')->selectOne('select sum(amount)amount from transactions where status=1 and debit_credit="' . $nature_of_debit_credit_other . '" and acc_code = "' . $code . '"
              and v_date between "' . $from . '" and "' . $to . '"')->amount;
        if (!empty($credit)) :
            $credit = $credit;
        else :
            $credit = 0;
        endif;

        return $debit . ',' . $credit;
    }


    public static function get_parent_and_account_amount_flow($m, $from_date, $to_date, $code, $operation, $debit_credit_nature, $debit_credit_nature_)
    {


        $array = explode('-', $code);
        $level = count($array);
        //       echo  'select sum(amount) as amount from transactions where status=1
        //    and  v_date BETWEEN "'.$from_date.'" and "'.$to_date.'" and substring_index(acc_code,"-","'.$level.'") = "'.$code.'"
        //    and debit_credit=1';
        //        echo '</br>';
        $debit = DB::Connection('mysql2')->selectOne('select sum(amount) as amount from transactions where status =1
			 and  v_date BETWEEN "' . $from_date . '" and "' . $to_date . '" and substring_index(acc_code,"-","' . $level . '") = "' . $code . '"
			 and debit_credit="' . $debit_credit_nature . '" and opening_bal=0')->amount;


        $credit = DB::Connection('mysql2')->selectOne('select sum(amount) as amount from transactions where status=1
			 and  v_date BETWEEN "' . $from_date . '" and "' . $to_date . '" and substring_index(`acc_code`,"-","' . $level . '") = "' . $code . '"
			 and debit_credit="' . $debit_credit_nature_ . '" and opening_bal=0')->amount;

        return    $total = $debit - $credit;
    }


    public static function get_advance($id, $nature1, $nature2)
    {

        $debit = DB::Connection('mysql2')->selectOne('select sum(amount)amount from transactions where status=1 and debit_credit="' . $nature1 . '" and acc_id= "' . $id . '"')->amount;
        if (!empty($debit)) :
            $debit = $debit;
        else :
            $debit = 0;
        endif;



        $credit = DB::Connection('mysql2')->selectOne('select sum(amount)amount from transactions where status=1 and debit_credit="' . $nature2 . '" and acc_id = "' . $id . '"
             ')->amount;
        if (!empty($credit)) :
            $credit = $credit;
        else :
            $credit = 0;
        endif;

        return $debit - $credit;
    }


    public static function get_transaction_enry($voucher_no)
    {
        $transaction = new Transactions();
        $transaction = $transaction->SetConnection('mysql2');
        return $transaction = $transaction->where('voucher_no', $voucher_no)->where('status', 1)->count();
    }

    public static  function check_entry_in_transactions($voucher_no, $table, $date, $type, $voucher_txt)
    {


        $check_entry =   static::get_transaction_enry($voucher_no);


        if ($check_entry > 0) :
            DB::Connection('mysql2')->table('transactions')->where('voucher_no', $voucher_no)->delete();
            $detail_data = DB::Connection('mysql2')->select('select * from ' . $table . ' where status=1 and ' . $voucher_txt . '="' . $voucher_no . '"');

            foreach ($detail_data as $row) :

                $trans1 = new Transactions();
                $trans1 = $trans1->SetConnection('mysql2');
                $trans1->acc_id = $row->acc_id;
                $trans1->acc_code = FinanceHelper::getAccountCodeByAccId($row->acc_id, '');
                $trans1->master_id = $row->id;
                $trans1->particulars = $row->description;
                $trans1->opening_bal = 0;
                $trans1->debit_credit = $row->debit_credit;
                $trans1->amount = $row->amount;
                $trans1->paid_to = $row->paid_to_id;
                $trans1->paid_to_type = $row->paid_to_type;
                $trans1->voucher_no = $voucher_no;
                $trans1->voucher_type = $type;
                $trans1->v_date = $date;
                $trans1->date = date('Y-m-d');
                $trans1->action = 1;
                $trans1->username = Auth::user()->name;
                $trans1->save();

            endforeach;
        endif;
    }


    public static function get_ledger_amount_paid_to($code, $databse, $nature_of_debit_credit, $nature_of_debit_credit_other, $from, $to, $paid_to, $type)
    {

        static::companyDatabaseConnection($databse);
        $debit = DB::selectOne('select sum(amount)amount from transactions where status=1 and debit_credit="' . $nature_of_debit_credit . '" and acc_code = "' . $code . '"
         and v_date between "' . $from . '" and "' . $to . '" and paid_to="' . $paid_to . '" and paid_to_type="' . $type . '"')->amount;
        if (!empty($debit)) :
            $debit = $debit;
        else :
            $debit = 0;
        endif;

        $credit = DB::selectOne('select sum(amount)amount from transactions where status=1 and debit_credit="' . $nature_of_debit_credit_other . '" and acc_code = "' . $code . '"
        and v_date between "' . $from . '" and "' . $to . '" and paid_to="' . $paid_to . '" and paid_to_type="' . $type . '"')->amount;
        if (!empty($credit)) :
            $credit = $credit;
        else :
            $credit = 0;
        endif;
        static::reconnectMasterDatabase();
        return $debit - $credit;
    }

    public static function bill_wise_remaining_amount($supplier_id)
    {
        $purchase_amount = DB::Connection('mysql2')->selectOne('select COALESCE(sum(b.amount),0)amount from new_purchase_voucher a
        inner join new_purchase_voucher_data b
        ON
        a.id=b.master_id
        where a.status=1 and a.pv_status=2 and a.supplier="' . $supplier_id . '"')->amount;



        $paid_amount = DB::Connection('mysql2')->selectOne('select COALESCE(sum(a.amount),0)amount from  new_purchase_voucher_payment a
        inner join new_purchase_voucher b
        ON
        a.new_purchase_voucher_id=b.id
        where a.status=1 and b.status=1 and a.supplier_id="' . $supplier_id . '"')->amount;

        $total = $purchase_amount - $paid_amount;
        if ($total == 0) :
            $adjust = DB::Connection('mysql2')->selectOne('select COALESCE(sum(amount),0)amount from  new_purchase_voucher_payment where status=1 and supplier_id="' . $supplier_id . '" and type in (2)')->amount;
            $advance = DB::Connection('mysql2')->selectOne('select COALESCE(sum(amount),0)amount from  new_purchase_voucher_payment where status=1 and supplier_id="' . $supplier_id . '" and type in (3)')->amount;
            $total = $adjust - $advance;
        endif;
        //        $pay_and_direct=DB::Connection('mysql2')->selectOne('select COALESCE(sum(amount),0)amount from  new_purchase_voucher_payment where status=1 and supplier_id="'.$supplier_id.'" and type in (0)')->amount;
        //
        //
        //        $advance=DB::Connection('mysql2')->selectOne('select COALESCE(sum(amount),0)amount from  new_purchase_voucher_payment where status=1 and supplier_id="'.$supplier_id.'" and type in (3)')->amount;
        //        $adjusting=DB::Connection('mysql2')->selectOne('select COALESCE(sum(amount),0)amount from  new_purchase_voucher_payment where status=1 and supplier_id="'.$supplier_id.'" and type in (2)')->amount;
        //
        //        $total=$adjusting-$advance;


        return  $total;
    }

    public static function departmentRights($company_id)
    {
        $department_array = array();
        //        if(Auth::user()->acc_type == 'user'):
        //            $departments = MenuPrivileges::select('department_permission')->where([['emp_code','=',Auth::user()->emp_code]])->get()->toArray();
        //            if(!empty($departments)):
        //                $department_array = (explode(",",$departments[0]['department_permission']));
        //            endif;
        //        else:
        //            $department_array = Department::select('id')->where([['company_id', '=',$company_id], ['status', '=', '1']])->get()->toArray();
        //        endif;
        $department_array = Department::select('id')->where([['company_id', '=', $company_id], ['status', '=', '1']])->get()->toArray();
        return $department_array;
    }

    public static function regionRights($company_id)
    {
        $emp_regions_array = array();
        //        if(Auth::user()->acc_type == 'user'):
        //            $emp_regions = MenuPrivileges::select('regions_permission')->where([['emp_code','=',Auth::user()->emp_code]])->get()->toArray();
        //            if(!empty($emp_regions)):
        //                $emp_regions_array = (explode(",",$emp_regions[0]['regions_permission']));
        //            endif;
        //        else:
        //            $emp_regions_array = Regions::select('id')->where([['company_id', '=',$company_id], ['status', '=', '1']])->get()->toArray();
        //        endif;
        $emp_regions_array = Regions::select('id')->where([['company_id', '=', $company_id], ['status', '=', '1']])->get()->toArray();
        return $emp_regions_array;
    }

    public static function operations_rights()
    {
        if (Auth::user()->acc_type == 'user') :
            static::reconnectMasterDatabase();

            $user_rights = MenuPrivileges::where([['emp_code', '=', Auth::user()->emp_code]]);
            $crud_permission[] = '';
            if ($user_rights->count() > 0) :
                $crud_rights  = explode(",", $user_rights->value('crud_rights'));

                $link = Request::segment(1) . "/" . Request::segment(2);
                $getTitle = $user_rights = Menu::where([['m_controller_name', '=', $link]])->value('m_main_title');

                if (in_array('view_' . $getTitle, $crud_rights)) :
                    $crud_permission[] = "view";
                endif;
                if (in_array('edit_' . $getTitle, $crud_rights)) :
                    $crud_permission[] = "edit";
                endif;
                if (in_array('repost_' . $getTitle, $crud_rights)) :
                    $crud_permission[] = "repost";
                endif;
                if (in_array('delete_' . $getTitle, $crud_rights)) :
                    $crud_permission[] = "delete";
                endif;
                if (in_array('print_' . $getTitle, $crud_rights)) :
                    $crud_permission[] = "print";
                endif;
                if (in_array('export_' . $getTitle, $crud_rights)) :
                    $crud_permission[] = "export";
                endif;
                if (in_array('approve_' . $getTitle, $crud_rights)) :
                    $crud_permission[] = "approve";
                endif;
                if (in_array('reject_' . $getTitle, $crud_rights)) :
                    $crud_permission[] = "reject";
                endif;

            endif;

        else :
            $crud_permission[] = "view";
            $crud_permission[] = "edit";
            $crud_permission[] = "repost";
            $crud_permission[] = "delete";
            $crud_permission[] = "print";
            $crud_permission[] = "export";
            $crud_permission[] = "approve";
            $crud_permission[] = "reject";

        endif;

        return $crud_permission;
    }

    public static function operations_rights_ajax_pages($url)
    {
        if (Auth::user()->acc_type == 'user') :

            $user_rights = MenuPrivileges::where([['emp_code', '=', Auth::user()->emp_code]]);
            $crud_permission[] = '';
            if ($user_rights->count() > 0) :
                $crud_rights  = explode(",", $user_rights->value('crud_rights'));
                $getTitle = $user_rights = Menu::where([['m_controller_name', '=', $url]])->value('m_main_title');

                if (in_array('view_' . $getTitle, $crud_rights)) :
                    $crud_permission[] = "view";
                endif;
                if (in_array('edit_' . $getTitle, $crud_rights)) :
                    $crud_permission[] = "edit";
                endif;
                if (in_array('repost_' . $getTitle, $crud_rights)) :
                    $crud_permission[] = "repost";
                endif;
                if (in_array('delete_' . $getTitle, $crud_rights)) :
                    $crud_permission[] = "delete";
                endif;
                if (in_array('print_' . $getTitle, $crud_rights)) :
                    $crud_permission[] = "print";
                endif;
                if (in_array('export_' . $getTitle, $crud_rights)) :
                    $crud_permission[] = "export";
                endif;
                if (in_array('approve_' . $getTitle, $crud_rights)) :
                    $crud_permission[] = "approve";
                endif;
                if (in_array('reject_' . $getTitle, $crud_rights)) :
                    $crud_permission[] = "reject";
                endif;

            endif;

        else :
            $crud_permission[] = "view";
            $crud_permission[] = "edit";
            $crud_permission[] = "repost";
            $crud_permission[] = "delete";
            $crud_permission[] = "print";
            $crud_permission[] = "export";
            $crud_permission[] = "approve";
            $crud_permission[] = "reject";

        endif;

        return $crud_permission;
    }
    public static function get_advancee_from_outstanding($supplier_id)
    {
        return   $data = DB::Connection('mysql2')->select('select * from  new_purchase_voucher_payment where status=1 and supplier_id="' . $supplier_id . '" group by new_pv_no');
    }

    public static function get_debit_credit_from_outstanding($supplier_id, $pv_no)
    {


        // get credit amount  amount
        $purchase_amount =  DB::Connection('mysql2')->table('new_purchase_voucher_payment')->where('status', 1)->where('supplier_id', $supplier_id)->where('Payment_nature', 0)->where('new_pv_no', $pv_no)->sum('amount');

        // get debit_amount
        $recive_amount =  DB::Connection('mysql2')->table('new_purchase_voucher_payment')->where('status', 1)->where('supplier_id', $supplier_id)->where('Payment_nature', 1)
            ->where('new_pv_no', $pv_no)->sum('amount');

        return $purchase_amount - $recive_amount;
    }
    public static function   check_entry_in_outstanding($pv_no)
    {
        return  DB::Connection('mysql2')->table('new_purchase_voucher_payment')->where('status', 1)->where('new_pv_no', $pv_no)->count();
    }
    public static function update_outstanding($pv_no, $type)
    {
        $count = static::check_entry_in_outstanding($pv_no);
        if ($count > 0) :

            $data = DB::Connection('mysql2')->table('new_purchase_voucher_payment')->where('status', 1)->where('new_pv_no', $pv_no)->where('type', 3)->delete();


            if ($type == 1) :
                $data_purchase_voucher = DB::Connection('mysql2')->table('new_jv_data as a')
                    ->join('new_jvs as b', 'a.jv_no', '=', 'b.jv_no')
                    ->join('accounts as c', 'c.id', '=', 'a.acc_id')
                    ->join('supplier as d', 'd.acc_id', '=', 'c.id')
                    ->select('a.*', 'd.id as supp_id')
                    ->where('a.jv_no', $pv_no)
                    ->get();
                $table = 1;
            elseif ($type == 2) :
                $data_purchase_voucher = DB::Connection('mysql2')->table('new_pv_data as a')
                    ->join('new_pv as b', 'a.pv_no', '=', 'b.pv_no')
                    ->join('accounts as c', 'c.id', '=', 'a.acc_id')
                    ->join('supplier as d', 'd.acc_id', '=', 'c.id')
                    ->select('a.*', 'd.id as supp_id')
                    ->where('a.pv_no', $pv_no)
                    ->where('b.type', 1)
                    ->get();
                $table = 2;

            endif;
            foreach ($data_purchase_voucher as $row1) :


                $amount =  DB::Connection('mysql2')->selectOne('select sum(amount)amount from new_purchase_voucher_payment where status=1 and new_pv_no="' . $pv_no . '" and type=2')->amount;
                $row1->amount;
                if ($amount > $row1->amount) :

                    $updated['status'] = 0;
                    DB::Connection('mysql2')->table('new_purchase_voucher_payment')->where('status', 1)->where('new_pv_no', $pv_no)->where('type', 2)->update($updated);

                endif;

                $breakup = new NewPurchaseVoucherPayment();
                $breakup = $breakup->SetConnection('mysql2');
                $breakup->table = 2;
                $breakup->new_pv_no = $pv_no;
                $breakup->supplier_id = $row1->supp_id;
                $breakup->amount = $row1->amount;
                $breakup->Payment_nature = $row1->debit_credit;
                $breakup->status = 1;
                $breakup->type = $table;
                $breakup->username = Auth::user()->username;
                $breakup->save();

            endforeach;
        endif;
    }

    public static function get_paid_to_type($paid_to, $paiid_to_type)
    {
        $data = '';
        if ($paiid_to_type == 1) :
            $data =  DB::Connection('mysql2')->table('employee')->where('id', $paid_to)->select('emp_name')->first()->emp_name;
        elseif ($paiid_to_type == 3) :
            $data =   DB::Connection('mysql2')->table('client')->where('id', $paid_to)->select('client_name')->first()->client_name;

        elseif ($paiid_to_type == 5) :
            $data =   DB::Connection('mysql2')->table('branch')->where('id', $paid_to)->select('branch_name')->first();

            if (isset($data->branch_name)) :
                $data = $data->branch_name;
            endif;
        endif;

        return $data;
    }

    public static function AllEmployee()
    {
        return $data =  DB::Connection('mysql2')->table('employee')->where('status', 1)->select('id', 'emp_name')->get();
    }


    public static function get_paid_to_type_for_edit($paid_to, $paiid_to_type)
    {

        if ($paiid_to_type == 1) :
            $data =  DB::Connection('mysql2')->table('employee')->where('id', $paid_to)->select('id', 'emp_name')->first();

        elseif ($paiid_to_type == 2) :
            $data =   DB::Connection('mysql2')->table('supplier')->where('id', $paid_to)->select('id', 'name')->first();


        elseif ($paiid_to_type == 3) :
            $data =   DB::Connection('mysql2')->table('client')->where('id', $paid_to)->select('id', 'client_name')->first();


        elseif ($paiid_to_type == 4) :
            $data =   DB::Connection('mysql2')->table('paid_to')->where('id', $paid_to)->select('id', 'name')->first();

        elseif ($paiid_to_type == 5) :
            $data =   DB::Connection('mysql2')->table('branch')->where('id', $paid_to)->select('id', 'branch_name')->first();


        endif;

        return $data;
    }

    public static function get_all_bank_account()
    {
        $account = new Account();
        $account = $account->SetConnection('mysql2');
        return $account = $account->where('status', 1)->select('id', 'name', 'code')->where('code', 'like', '1-2-6-3%')
            ->orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')
            ->get();
    }

    public static function get_all_category()
    {
        $category = new Category();
        return  $category = $category->where('status', 1)->get();
    }

    public static function generic($table, $filter_colum, $select_colum)
    {
        return   DB::COnnection('mysql2')->table($table)->where($filter_colum)->select($select_colum);
    }


    public static function batch_code_edit($warehouse, $item)
    {
        return $in = DB::Connection('mysql2')->table('stock')->where('status', 1)
            ->where('sub_item_id', $item)
            ->where('warehouse_id', $warehouse)
            ->select('batch_code')
            ->groupBy('batch_code')
            ->get();
    }

    public static function in_stock_edit($item, $warehouse, $bacth_code)
    {
        $in = DB::Connection('mysql2')->table('stock')->where('status', 1)
            ->where('voucher_type', 1)
            ->where('sub_item_id', $item)
            ->where('warehouse_id', $warehouse)
            ->where('batch_code', $bacth_code)
            ->select(DB::raw('SUM(qty) As qty'), DB::raw('SUM(amount) As amount'))
            ->first();



        $oout =  DB::Connection('mysql2')->table('stock')->where('status', 1)
            ->whereIn('voucher_type', [2, 3, 5])
            ->where('sub_item_id', $item)
            ->where('warehouse_id', $warehouse)
            ->where('batch_code', $bacth_code)
            ->select(DB::raw('SUM(qty) As qty'), DB::raw('SUM(amount) As amount'))
            ->first();

        $qty = $in->qty - $oout->qty;
        $amount = $in->amount;
        $rate = 0;
        if ($qty > 0) :

            $rate = number_format($amount / $in->qty, 2, '.', '');
            echo $qty;
        else :
            $qty = 0;
            $amount = 0;
            return $qty;
        endif;
    }

    public static function get_sod_qty($id)
    {
        $Sod = DB::Connection('mysql2')->table('sales_order_data')->where('status', 1)->where('id', $id)->first();
        return $Sod->qty;
    }

    public function get_stock_location_wise($request)
    {



        $warehouse = $request->warehouse;
        $item = $request->item;
        $bacth_code = $request->batch_code;


        if ($bacth_code == '') :


            $in = DB::Connection('mysql2')->table('stock')->where('status', 1)
                ->where('sub_item_id', $item)
                ->where('warehouse_id', $warehouse)
                ->select('batch_code')
                ->groupBy('batch_code')
                ->get(); ?>



            <option value="">Select</option>
            <?php foreach ($in as $row) : ?>
            <option value="<?php echo $row->batch_code  ?>"><?php echo $row->batch_code ?></option><?php
        endforeach; ?>
        <?php

        else :
            $in = DB::Connection('mysql2')->table('stock')->where('status', 1)
                ->where('voucher_type', 1)
                ->where('sub_item_id', $item)
                ->where('warehouse_id', $warehouse)
                ->where('batch_code', $bacth_code)
                ->select(DB::raw('SUM(qty) As qty'), DB::raw('SUM(amount) As amount'))
                ->first();



            $oout =  DB::Connection('mysql2')->table('stock')->where('status', 1)
                ->whereIn('voucher_type', [2, 3, 5])
                ->where('sub_item_id', $item)
                ->where('warehouse_id', $warehouse)
                ->where('batch_code', $bacth_code)
                ->select(DB::raw('SUM(qty) As qty'), DB::raw('SUM(amount) As amount'))
                ->first();

            $qty = $in->qty - $oout->qty;
            $amount = $in->amount;
            $rate = 0;
            if ($qty > 0) :

                $rate = number_format($amount / $in->qty, 2, '.', '');
                echo $qty . '/' . $rate;
            else :
                $qty = 0;
                $amount = 0;
                echo $qty . '/' . $rate;
            endif;
        endif;
    }

    public static function get_voucher_type($type, $opening)
    {
        $purchase_type = '';
        if ($type == 1 && $opening == 0) :
            $purchase_type = 'GRN';

        elseif ($type == 1 && $opening == 1) :
            $purchase_type = 'Opening';
        elseif ($type == 2) :
            $purchase_type = 'GRN Return';
        elseif ($type == 5) :
            $purchase_type = 'DN';


        elseif ($type == 6) :
            $purchase_type = 'Sales Return';
        endif;
        return $purchase_type;
    }


    public static  function  get_po($po_no)
    {
        return DB::Connection('mysql2')->table('purchase_request')->where('status', 1)->where('purchase_request_no', $po_no)->first();
    }

    public static function get_all_account_operat()
    {
        $account = new Account();
        $account = $account->SetConnection('mysql2');
        return $account = $account->where('status', 1)->select('id', 'name', 'code')->where('operational', 1)
            ->orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')
            ->get();
    }
    public static    function  inventory_activity($voucher_no, $voucher_date, $amount, $table, $action)
    {

        date_default_timezone_set("Asia/Karachi");
        $data = array(
            'voucher_no' => $voucher_no,
            'voucher_date' => $voucher_date,
            'amount' => $amount,
            'table_name' => $table,
            'action' => $action,
            'action_date' => date('Y-m-d'),
            'username' => Auth::user()->name,
            'action_time' => date('h:i:sa'),
        );

        DB::Connection('mysql2')->table('inventory_activity')->insert($data);
    }

    public static function all_vouchers_amount_app_unapp($AccId, $AppUnApp, $Main, $Detail, $Status, $nature)
    {


        $Amount = DB::Connection('mysql2')->selectOne('select SUM(b.amount) amount from ' . $Main . ' a
        INNER JOIN ' . $Detail . ' b ON b.master_id = a.id
        WHERE a.' . $Status . ' = ' . $AppUnApp . '
        AND b.acc_id = ' . $AccId . '
        AND a.status = 1
        AND b.debit_credit = ' . $nature . '
        ');

        return $Amount;
    }

    public static function bearkup_receievd($SalesTaxInvoiceId, $from, $to)
    {

        $data = DB::Connection('mysql2')->selectOne('select sum(a.received_amount) as total_amount
        from brige_table_sales_receipt a
        inner join
        new_rvs b
        on
        a.rv_id=b.id
        where a.si_id="' . $SalesTaxInvoiceId . '"
        and a.status=1
        and b.status=1
        and b.rv_status=2
        and b.rv_date between "' . $from . '" and "' . $to . '"
        group by a.si_id');

        if (!empty($data->total_amount)) :

            return $data->total_amount;
        else :
            return 0;
        endif;
    }

    public static function bearkup_receievd_approved($SalesTaxInvoiceId, $from, $to)
    {

        $data = DB::Connection('mysql2')->selectOne('select sum(a.received_amount) as total_amount
        from brige_table_sales_receipt a
        inner join
        new_rvs b
        on
        a.rv_id=b.id
        where a.si_id="' . $SalesTaxInvoiceId . '"
        and a.status=1
        and b.status=1
        and b.rv_status=2
        and b.rv_date between "' . $from . '" and "' . $to . '"
        group by a.si_id');

        if (!empty($data->total_amount)) :

            return $data->total_amount;
        else :
            return 0;
        endif;
    }
    public static function bearkup_receievd_use_for_balance($SalesTaxInvoiceId)
    {

        $data = DB::Connection('mysql2')->selectOne('select sum(a.received_amount) as total_amount
        from brige_table_sales_receipt a
        inner join
        new_rvs b
        on
        a.rv_id=b.id
        where a.si_id="' . $SalesTaxInvoiceId . '"
        and a.status=1
        and b.status=1
        group by a.si_id');

        if (!empty($data->total_amount)) :

            return $data->total_amount;
        else :
            return 0;
        endif;
    }

    public static function uniqe_no_for_stp($year, $month, $type)
    {
        $variable = 100;
        $str = DB::Connection('mysql2')->selectOne("SELECT MAX(SUBSTR(pv_no, 8, 3)) AS ExtractString
        FROM new_pvv  where substr(`pv_no`,4,2) = " . $year . " and substr(`pv_no`,6,2) = " . $month . "")->ExtractString;

        $str = $str + 1;
        $str = sprintf("%'03d", $str);

        $pv_no = 'stp' . $year . $month . $str;


        return $pv_no;
    }

    public static function get_uom($id)
    {
        $uom_id = DB::Connection('mysql2')->table('subitem')->where('status', 1)->where('id', $id)->select('uom')->value('uom');
        return $uom_id = DB::table('uom')->where('status', 1)->where('id', $uom_id)->select('uom_name')->value('uom_name');
    }

    public static function get_fg_uom($id)
    {
        $uom_id = DB::Connection('mysql2')->table('product')->where('status', 1)->where('id', $id)->select('uom_id')->value('uom_id');
        return $uom_id = DB::table('uom')->where('status', 1)->where('id', $uom_id)->select('uom_name')->value('uom_name');
    }

    public static function get_uom_by_uom_id($id)
    {
        //    $uom_id= DB::Connection('mysql2')->table('subitem')->where('status',1)->where('id',$id)->select('uom')->value('uom');
        if($id){
            return $uom_id = DB::table('uom')->where('status', 1)->where('id', $id)->select('uom_name')->value('uom_name');
        }
        return '';
    }
    public static function get_location($id)
    {
        return DB::Connection('mysql2')->table('warehouse')->where('status', 1)->where('id', $id)->select('name')->value('name');
    }

    public static function get_make_type($type)
    {
        $data = '';
        if ($type == 1) :
            $data = 'Cutting';
        elseif ($type == 2) :
            $data = 'Welding';
        elseif ($type == 3) :
            $data = 'Machining';
        elseif ($type == 4) :
            $data = 'Thread';
        elseif ($type == 5) :
            $data = 'Jointing';
        elseif ($type == 6) :
            $data = 'APS';
        elseif ($type == 7) :
            $data = 'Galvanise';
        elseif ($type == 8) :
            $data = 'Service & Marking';
        elseif ($type == 9) :
            $data = 'Service';
        elseif ($type == 10) :
            $data = 'Marking';
        endif;


        return $data;
    }

    public static function get_all_agent()
    {
        return  DB::Connection('mysql2')->table('sales_agent')->get();
    }

    public static function  get_item_des($so_data_id)
    {
        return   DB::Connection('mysql2')->table('sales_order_data')->where('id', $so_data_id)->select('desc')->value('desc');
    }

    public static function  internal_consumtion_list()
    {
        return   DB::Connection('mysql2')->table('internal_consumtion')->where('status', 1)->get();
    }

    public static function  internal_consumtion_list_by_id($id)
    {
        return   DB::Connection('mysql2')->table('internal_consumtion')->where('status', 1)->where('id', $id)->get();
    }

    public static function  internal_consumtion_data($id)
    {
        return   DB::Connection('mysql2')->table('internal_consumtion_data')->where('status', 1)->where('master_id', $id)->get();
    }

    public static function get_opening_for_trial($from, $to, $m, $code, $t_nature)
    {
        $amount = 0;
        $data =  DB::table('company')->where('id', $m)->first();
        CommonHelper::companyDatabaseConnection($m);
        $acc_year = $data->accyearfrom;


        $array = explode('-', $code);
        $level = count($array);


        if ($from == $acc_year) :

            $amount = DB::selectOne('select sum(amount) as amount from transactions where status =1
			  and substring_index(acc_code,"-","' . $level . '") = "' . $code . '"
			 and debit_credit="' . $t_nature . '" and opening_bal=1')->amount;

            $amount = DB::selectOne('select sum(amount) as amount from transactions as a
            inner join
            accounts b
            on
            a.acc_id=b.id
            where a.status =1

			and substring_index(a.acc_code,"-","' . $level . '") = "' . $code . '"
			and a.debit_credit="' . $t_nature . '"
			and a.opening_bal=1
			and b.status=1')->amount;



        else :
            $new_to = date('d-m-Y', strtotime($from . " - 1 day"));


            $amount = DB::selectOne('select sum(amount) as amount from transactions as a
            inner join
            accounts b
            on
            a.acc_id=b.id
            where a.status =1
			and  a.v_date BETWEEN "' . $acc_year . '" and "' . $new_to . '"
			and substring_index(a.acc_code,"-","' . $level . '") = "' . $code . '"
			and a.debit_credit="' . $t_nature . '"
			and b.status=1')->amount;





        endif;
        CommonHelper::reconnectMasterDatabase();
        return $amount;
    }

    public static function get_amount($from, $to, $m, $code, $t_nature)
    {
        $amount = 0;
        $data =  DB::table('company')->where('id', $m)->first();
        CommonHelper::companyDatabaseConnection($m);
        $acc_year = $data->accyearfrom;
        $array = explode('-', $code);
        $level = count($array);



        $amount = DB::selectOne('select sum(amount) as amount from transactions as a
            inner join
            accounts b
            on
            a.acc_id=b.id
            where a.status =1
			and  a.v_date BETWEEN "' . $from . '" and "' . $to . '"
			and substring_index(a.acc_code,"-","' . $level . '") = "' . $code . '"
			and a.debit_credit="' . $t_nature . '"
			and a.opening_bal=0
			and b.status=1')->amount;


        CommonHelper::reconnectMasterDatabase();
        return $amount;
    }


    public static function get_acc_name_space_wise($code, $name)
    {
        $array = explode('-', $code);
        $level = count($array);
        if ($level == 1) { ?> <p style="font-size: large;font-weight: bold"><?php echo   $name . '</p>';
        } elseif ($level == 2) { ?>
            <p style="font-size: large;font-weight: 900"><?php echo '&emsp;' . $name . '</p>';
        } elseif ($level == 3) { ?>
            <p style="font-size: large;font-weight: 700"><?php echo '&emsp;&emsp;' . $name . '</p>';
        } elseif ($level == 4) { ?>
            <p><?php echo '&emsp;&emsp;&emsp;' . $name . '</p>';
        } elseif ($level == 5) { ?>
            <p><?php echo '&emsp;&emsp;&emsp;&emsp;' . $name . '</p>';
        } elseif ($level == 6) { ?>
            <p><?php echo '&emsp;&emsp;&emsp;&emsp;&emsp;' . $name . '</p>';
        } elseif ($level == 7) { ?>
            <p><?php echo '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $name . '</p>';
        }
    }


    public static function mode_type()
    {
        return [
            0 => '',
            1 => 'URGENT',
            2 => 'NORMAL',
            3 => 'MOST URGENT',
        ];
    }
    public static function AmountInWords(float $amount, $currencey)
    {
        $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
        // Check if there is any number after decimal
        $amt_hundred = null;
        $count_length = strlen($num);
        $x = 0;
        $string = array();
        $change_words = array(
            0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        );
        $here_digits = array('', 'Hundred', 'Thousand', 'Lakkh', 'Crore', 'Millions');
        while ($x < $count_length) {
            $get_divider = ($x == 2) ? 10 : 100;
            $amount = floor($num % $get_divider);
            $num = floor($num / $get_divider);
            $x += $get_divider == 10 ? 1 : 2;
            if ($amount) {
                $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
                $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
                $string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' 
                                                                            ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' 
                                                                            ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
            } else $string[] = null;
        }
        $implode_to_Rupees = implode('', array_reverse($string));
        $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
                                                                        " . $change_words[$amount_after_decimal % 10]) : '';

        return ($implode_to_Rupees ? $implode_to_Rupees  : '') . $get_paise . ' ' . $currencey;
    }
    public static function numberToWords($number)
    {
        $ones = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine'
        );

        $tens = array(
            10 => 'ten',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety'
        );

        $hundreds = array(
            'hundred',
            'thousand',
            'million',
            'billion',
            'trillion',
            'quadrillion',
            'quintillion',
            'sextillion',
            'septillion',
            'octillion',
            'nonillion',
            'decillion',
            'undecillion',
            'duodecillion',
            'tredecillion',
            'quattuordecillion',
            'quindecillion',
            'sexdecillion',
            'septendecillion',
            'octodecillion',
            'novemdecillion',
            'vigintillion',
            'googol'
        );

        $string = str_replace(',', '', $number);
        $num = (float) $string;

        if ($num < 0) {
            return 'minus ' . self::numberToWords(abs($num));
        }

        if ($num < 10) {
            return $ones[$num];
        }

        if ($num < 20) {
            if ($num % 10 == 0) {
                return $tens[$num];
            }
            return $ones[$num % 10] . 'teen';
        }

        if ($num < 100) {
            if ($num % 10 == 0) {
                return $tens[$num];
            }
            return $tens[(int)($num / 10) * 10] . ' ' . $ones[$num % 10];
        }

        $numStr = (string) $num;
        $numLen = strlen($numStr);
        if ($numLen > 3) {
            $remainingDigits = $numLen % 3;
            if ($remainingDigits == 0) {
                $remainingDigits = 3;
            }
            $part1 = substr($numStr, 0, $remainingDigits);
            $part2 = substr($numStr, $remainingDigits);
            $words = self::numberToWords((int) $part1) . ' ' . $hundreds[$numLen - 1];
            if ($part2 != '000') {
                $words .= ' ' . self::numberToWords((int) $part2);
            }
            return $words;
        }

        return '';
    }


    public static function get_vendor_code()
    {
        $supplier = Supplier::orderBy('id', 'desc')->first();
    
        $nextId = $supplier ? $supplier->id + 1 : 1;
    
        return str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }



    public static function getSupplierAccordingPoWise()
    {
        return PurchaseRequest::join('supplier', 'supplier.id', 'purchase_request.supplier_id')
            ->select('purchase_request.supplier_id', 'supplier.id', 'supplier.name')->where('purchase_request.status', 1)->groupBy('purchase_request.supplier_id')->get();
    }


    public static function addSubItem($uom, $category, $dtype, $subitem, $sku, $volume = null, $code = null)
    {
        $userName = Auth::user()->name;
        $company_id = Session::get('run_company');
        $existUom = new UOM();
        if ($existUom->where('uom_name', 'LIKE', trim($uom))->where('status', 1)->count() > 0) {
            $existUom = $existUom->where('uom_name', 'LIKE', trim($uom))->where('status', 1)->first()->id;
        } else {
            $existUom->uom_name = trim($uom);
            $existUom->status = 1;
            $existUom->username = $userName;
            $existUom->date    = date('Y-m-d');
            $existUom->time    = date('H:i:s');
            $existUom->company_id = $company_id;
            $existUom->save();
            $existUom = $existUom->id;
        }
        $existDT = new DemandType();
        if ($existDT->where('name', 'Like', trim($dtype))->where('status', 1)->count() > 0) {
            $existDT = $existDT->where('name', 'Like', trim($dtype))->where('status', 1)->first()->id;
        } else {
            $existDT->id = (DemandType::orderBy('id', 'desc')->first()) ? DemandType::orderBy('id', 'desc')->first()->id + 1 : 1;
            $existDT->name = trim($dtype);
            $existDT->status = 1;
            $existDT->username = $userName;
            $existDT->date    = date('Y-m-d');
            $existDT->time    = date('H:i:s');
            $existDT->save();
            $existDT = $existDT->id;
        }
        $existCategory = new Category();
        if ($existCategory->where('main_ic', 'like', trim($category))->where('status', 1)->count() > 0) {
            $existCategory = $existCategory->where('main_ic', 'like', trim($category))->where('status', 1)->first()->id;
        } else {
            $existCategory->main_ic = trim($category);
            $existCategory->username = $userName;
            $existCategory->date    = date('Y-m-d');
            $existCategory->time    = date('H:i:s');
            $existCategory->company_id = $company_id;
            $existCategory->action = 0;
            $existCategory->save();
            $existCategory = $existCategory->id;
        }
        // $existLine = new Line();
        // if ($existLine->where('name', 'like', trim($line))->where('status', 1)->count() > 0) {
        //     $existLine = $existLine->where('name', 'like', trim($line))->where('status', 1)->first()->id;
        // } else {
        //     $existLine->name = trim($line);
        //     $existLine->username = $userName;
        //     $existLine->date    = date('Y-m-d');
        //     $existLine->save();
        //     $existLine = $existLine->id;
        // }
        // $existMachine = new Machinery();
        // if ($existMachine->where('name', 'like', trim($machine))->where('status', 1)->count() > 0) {
        //     $existMachine = $existMachine->where('name', 'like', trim($machine))->where('status', 1)->first()->id;
        // } else {
        //     $existMachine->name = trim($machine);
        //     $existMachine->username = $userName;
        //     $existMachine->date    = date('Y-m-d');
        //     $existMachine->save();
        //     $existMachine = $existMachine->id;
        // }
        $subItem = new Subitem();
        // if (!$subItem->where('main_ic_id', $existCategory)->where('uom', $existUom)->where('sub_ic', $subitem)->where('status', 1)->count() > 0) {
        $subItem->main_ic_id = $existCategory;
        $subItem->uom = $existUom;
        $subItem->sub_ic = $subitem;
        $subItem->description = $existUom;
        $subItem->acc_id = 0;
        $subItem->pack_size = $volume;
        $subItem->reorder_level = 0;
        $subItem->date    = date('Y-m-d');
        $subItem->time    = date('H:i:s');
        $subItem->action = 0;
        // $subItem->line_id = $existLine;
        // $subItem->machine_id = $existMachine;
        $subItem->username = $userName;
        $subItem->type = $existDT;
        $subItem->item_code = $code;
        $subItem->sku_code = $sku ?? '';
        $subItem->save();
        return $subItem;
        // }
    }


    public static function getCommodityPOVoucherCodeFormat($code)
    {
        return ['CPO-' . sprintf("%'03d", $code), $code];
    }

    public static function getProductionPOVoucherCodeFormat($val)
    {
        if ($val == 'Irri-6') {
            $text = "RI-23-24-"; // 'irri' is found in the product_id
        } else {
            $text = "RO-24-25-"; // 'irri' is not found in the product_id
        }
        $str = ProductionPurchaseOrder::count();
        $voucher_no = [$text . ($str + 1)];
        return $voucher_no;
    }

    public static function getProductionFormat($table,$str)
    {
        $count = $table::count();
        $voucher_no = $str . sprintf("%'05d", ($count + 1)); // . date('my');
        return $voucher_no;
    }
    public static function get_gatepass_by_ins_no($ins_no)
    {
        $data = DB::connection('mysql2')->table('production_get_pass')->where('inspection_no', $ins_no)->first();

        return $data;
    }
    public static function qualityType()
    {
        return [
            ['id' => 1, 'name' => 'Fresh Stock'],
            ['id' => 2, 'name' => 'Reusable Stock'],
            ['id' => 3, 'name' => 'Damage Stock'],
            ['id' => 4, 'name' => 'Scrap'],
        ];
    }

    public static function getMaintenanceJobType()
    {
        return [
            ['id' => 1, 'name' => 'In-House'],
            ['id' => 2, 'name' => 'Outsource'],
            ['id' => 3, 'name' => 'In-House (another warehouse)'],
            ['id' => 4, 'name' => 'In-House Corrective Maintenace'],
        ];
    }


    public static function getLastPoData($item_id)
    {
        return PurchaseRequestData::where([['status', 1], ['sub_item_id', $item_id]])->orderby('id', 'desc')->first() ?? '';
    }


    public static function stockDemandType()
    {
        $materialData = [
            ['id' => 1, 'name' => 'Dead Stock', 'color' => 'orange', 'short' => 'DS'],
            ['id' => 2, 'name' => 'obsolete stock', 'color' => 'red', 'short' => 'OS'],
        ];
        return collect($materialData);
    }


    public static function getMaintenanceJobPreviousStock($item, $maintenanceJobId)
    {
        return GoodsReturn::join('goods_return_datas', 'goods_return_datas.goods_return_id', 'goods_returns.id')
            ->where('goods_return_datas.item_id', $item)
            ->where('goods_return_datas.status', 1)
            ->where('goods_returns.status', 1)
            ->where('goods_returns.voucher_status', 2)
            ->where('goods_returns.maintenance_job_id', $maintenanceJobId)
            ->sum('qty');
    }

    public static function getPreviousReceivedGatePassInQty($item_id, $maintenance_job_id, $location_id, $gatepass_id = null)
    {
        $gatePassInExist = GatePass::join('gate_pass_datas', 'gate_passes.id', 'gate_pass_datas.gate_pass_id')
            ->where('gate_pass_datas.item_id', $item_id)
            ->where('gate_passes.maintenance_job_id', $maintenance_job_id)
            ->where('gate_passes.location_id', $location_id)
            ->where('gate_passes.gate_pass_type', 1)
            ->where('gate_passes.status', 1)
            ->where('gate_pass_datas.status', 1);
        if ($gatepass_id) {
            $gatePassInExist = $gatePassInExist->where('gate_passes.id', '!=', $gatepass_id);
        }
        $gatePassInExist = $gatePassInExist->sum('gate_pass_datas.qty_received');
        return $gatePassInExist;
    }

    public static function getPreviousReceivedGRNQty($item_id, $maintenance_job_id, $grn_id = null)
    {
        $gatePassInExist = WorkshopGrn::join('workshop_grn_datas', 'workshop_grns.id', 'workshop_grn_datas.workshop_grn_id')
            ->where('workshop_grn_datas.item_id', $item_id)
            ->where('workshop_grns.maintenance_job_id', $maintenance_job_id)
            ->where('workshop_grns.status', 1)
            ->where('workshop_grn_datas.status', 1);
        if($grn_id){
            $gatePassInExist = $gatePassInExist->where('workshop_grns.id', '!=', $grn_id);
        }
        $gatePassInExist = $gatePassInExist->sum('workshop_grn_datas.qty');
        return $gatePassInExist;
    }

    public static function get_all_lines()
    {
        $lines = Line::where('status', 1)->get();

        return $lines ?? [];
    }

    public static function get_all_balance_pos()
    {
        $po_nos = ProductionPurchaseOrder::where('balance_qty', '>', 0)
            ->join('supplier as s','s.id','=','production_purchase_orders.supplier_id')
            ->select('production_purchase_orders.*','s.name as sup_name')
            ->get();

        return $po_nos ?? [];
    }
    public static function getCatergoryyAnditemData($id)
    {
        $po_nos = Product::where('id', '=', $id)->first();
        return $po_nos;
    }

    public static function get_inspection_no($request)
    {

        $nos = ArrivalInspection::where('arrival_inspections.po_no', $request->po_no)
            ->leftjoin('production_purchase_orders','production_purchase_orders.voucher_no','arrival_inspections.po_no');
        if($request->type == 1 && $request->table == 'arrival_weighbridges'){
            $nos =  $nos->join('production_get_pass','production_get_pass.inspection_no','arrival_inspections.ins_no');
        }
        if($request->type == 2 && $request->table == 'arrival_weighbridges'){
            $nos =  $nos->join('arrival_weighbridges','arrival_weighbridges.inspection_no','arrival_inspections.ins_no');
            // ->where('arrival_inspections.type',2);
        }

        if($request->type == 2 && $request->table == 'production_get_pass'){
            $nos =  $nos->join('arrival_weighbridges','arrival_weighbridges.inspection_no','arrival_inspections.ins_no')
            ->where('arrival_inspections.type',1);
        }
        $nos =  $nos->where('arrival_inspections.overall_rejected',0)
            ->whereNotExists(function ($query) use($request) {
                $query->select(DB::raw(1))
                    ->from(DB::raw($request->table . ' as alias_table'))
                    ->whereRaw('alias_table.inspection_no = arrival_inspections.ins_no')
                    ->whereRaw('alias_table.type = '.$request->type);
            });
            if($request->type == 2 && $request->table == 'production_get_pass'){
                $nos =  $nos->groupBy('arrival_inspections.id');
            }
            $nos =  $nos->get();

        return $nos ?? [];
    }

}


?>