<?php

namespace App\Http\Controllers;

use App\CompanyLocation;
use App\Models\Demand;
use App\Models\DemandData;
use Illuminate\Http\Request;
use App\Helpers\SalesHelper;
use App\Helpers\CommonHelper;
use App\Helpers\PurchaseHelper;
use App\Models\PurchaseVoucher;
use App\Models\PurchaseVoucherData;
use App\Models\Transactions;
use App\Models\DepartmentAllocation1;
use App\Models\SalesTaxDepartmentAllocation;
use App\Models\CostCenterDepartmentAllocation;
use App\Models\DemandType;
use App\Models\Warehouse;
use App\Models\GoodsReceiptNote;
use App\Helpers\FinanceHelper;
use App\Models\JobOrder;
use App\Models\JobOrderData;
use App\Models\SurveyDocument;
use App\Models\JobOrderDocument;
use App\Models\Product;
use App\Models\Survey;
use App\Models\SurveyData;
use App\Models\Subitem;
use App\Models\Attachement;
use App\Models\Estimate;
use App\Models\NewPurchaseVoucher;
use App\Models\NewPurchaseVoucherData;
use App\Helpers\NotificationHelper;
use App\Models\JobTracking;
use App\Models\JobTrackingData;
use App\Helpers\ReuseableCode;
use App\Models\Account;
use App\Models\Category;
use App\Models\PurchaseRequest;
use App\Models\Cities;
use App\Models\Countries;
use App\Models\GRNData;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestData;
use App\Models\Supplier;
use App\Models\TempGrn;
use App\Models\UOM;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;


class PurchaseAddDetailControler extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function importSupplierDetail(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
            if ($request->file('file')) {
                $file = Excel::toArray([], $request->file('file'));
                $file = $file[0];
                $userName = Auth::user()->name;
                $company_id = Session::get('run_company');
                // dd($file);
                if ($file[0][1] == trim('Vendor') && $file[0][4] == trim('Address') && $file[0][5] == trim('City, Country') && $file[0][6] == trim('Phone') && $file[0][7] == trim('Mobile') && $file[0][8] == trim('Email') && $file[0][9] == trim('NTN') && $file[0][10] == trim('STN')) {
                    foreach ($file as $key => $value) :
                        if ($key == 0) continue;

                        $country_name = ($value[5] != '-' && $value[5] != "") ? explode(',', $value[5])[1] : '0';
                        $city_name = ($value[5] != '-' && $value[5] != "") ? explode(',', $value[5])[0] : '0';
                        $countryName = Countries::where('name', 'LIKE', "%" . trim($country_name) . "%")->first();
                        $cityName = Cities::where('name', 'LIKE', "%" . trim($city_name) . "%")->first();
                        // echo Supplier::UniqueNo()."<br>";
                        Supplier::create([
                            'vendor_code'   => Supplier::UniqueNo(),
                            'name'          => trim($value[1]),
                            'company_name'  => '-',
                            'address'       => trim($value[4]),
                            'contact_person' => '-',
                            'mobile_no'     => trim($value[7]),
                            'work_phone'    => trim($value[6]),
                            'country'       => $countryName,
                            'city'          => $cityName,
                            'email'         => trim($value[8]),
                            'ntn'           => trim($value[9]),
                            'strn'          => trim($value[10]),
                            'username'      => trim($userName),
                            'date'          => date('Y-m-d'),
                        ]);
                    endforeach;
                    DB::Connection('mysql2')->commit();
                    Session::flash('dataInsert', 'Successfully Upload!');
                    return Redirect::to('purchase/viewSupplierList?m=' . Session::get('run_company'));
                } else {
                    Session::flash('dataDelete', 'Please Upload with the given format!');
                    return redirect()->back();
                }
            } else {
                Session::flash('dataDelete', 'File Not Found!');
                return redirect()->back();
            }
        } catch (Exception $th) {
            DB::Connection('mysql2')->rollback();
            dd($th);
        }
    }

    public function addSupplierDetail()
    {
        $vendor_code =   Input::get('vendor_code');
        $name =   Input::get('name');
        $company_name = Input::get('company_name');
        $country = Input::get('country');
        $state = Input::get('state');
        $city = Input::get('city');
        $email = Input::get('email');
        $o_blnc_trans = Input::get('o_blnc_trans');
        $register_income_tax = Input::get('regd_in_income_tax');
        $business_type = Input::get('optradio');
        $ntn = Input::get('ntn');
        $cnic = Input::get('cnic');
        $regd_in_sales_tax = Input::get('regd_in_sales_tax');
        $strn = Input::get('strn');
        $regd_in_srb = Input::get('regd_in_srb');
        $srb = Input::get('srb');
        $regd_in_pra = Input::get('regd_in_pra');
        $pra = Input::get('pra');

        $print_check_as = Input::get('print_check_as');
        $term = Input::get('term');
        $vendor_type = Input::get('vendor_type');
        $website = Input::get('website');
        $credit_limit = Input::get('credit_limit');
        $acc_no = Input::get('acc_no');
        $bank_name = Input::get('bank_name');
        $bank_address = Input::get('bank_address');
        $branch_name = Input::get('branch_name');
        $swift_code = Input::get('swift_code');
        $open_date = Input::get('open_date');


        $address[] = Input::get('address');
        $o_blnc = Input::get('o_blnc');
        $operational = '1';
        $sent_code =   Input::get('account_head');
        $account_head = Input::get('account_head');


        // if (Auth::user()->name == 'Talha') :

        //     $max_id = DB::Connection('mysql2')->selectOne('SELECT max(`id`) as id  FROM `accounts` WHERE `parent_code` LIKE \'' . $account_head . '\'')->id;;
        //     if ($max_id == '') {
        //         $code = $sent_code . '-1';
        //     } else {
        //         $max_code2 = DB::Connection('mysql2')->selectOne('SELECT `code`  FROM `accounts` WHERE `id` LIKE \'' . $max_id . '\'')->code;
        //         $max_code2;
        //         $max = explode('-', $max_code2);
        //         $code = $sent_code . '-' . (end($max) + 1);
        //     }

        //     $level_array = explode('-', $code);
        //     $counter = 1;
        //     foreach ($level_array as $level) :
        //         $data1['level' . $counter] = strip_tags($level);
        //         $counter++;
        //     endforeach;
        //     $data1['code'] = strip_tags($code);
        //     $data1['name'] = strip_tags($name);
        //     $data1['parent_code'] = strip_tags($account_head);
        //     $data1['username'] = Auth::user()->name;
        //     $data1['date'] = date("d-m-Y");
        //     $data1['time'] = date("H:i:s");
        //     $data1['action'] = 'create';
        //     $data1['type'] = 1;
        //     $data1['operational'] = strip_tags($operational);
        //     $acc_id = DB::Connection('mysql2')->table('accounts')->insertGetId($data1);
        // else :
        $acc_id = 0;
        // endif;

        $data2['acc_id'] = strip_tags($acc_id);

        $data2['resgister_income_tax'] = strip_tags($register_income_tax);
        $data2['business_type'] = strip_tags($business_type);
        $data2['cnic'] = strip_tags($cnic);
        $data2['ntn'] = strip_tags($ntn);
        $data2['register_sales_tax'] = strip_tags($regd_in_sales_tax);
        $data2['strn'] = strip_tags($strn);
        $data2['register_srb'] = strip_tags($regd_in_srb);
        $data2['srb'] = strip_tags($srb);
        $data2['register_pra'] = strip_tags($regd_in_pra);
        $data2['pra'] = strip_tags($pra);
        $data2['vendor_code'] = strip_tags($vendor_code);
        $data2['name'] = strip_tags($name);
        $data2['company_name'] = strip_tags($company_name);
        $data2['country'] = strip_tags($country);
        $data2['province'] = strip_tags($state);
        $data2['city'] = strip_tags($city);
        $data2['email'] = strip_tags($email);
        $data2['username'] = Auth::user()->name;
        $data2['date'] = date("d-m-Y");
        $data2['time'] = date("H:i:s");
        $data2['action'] = 'create';
        $data2['company_id'] = $_GET['m'];
        $data2['print_check_as'] = $print_check_as;
        $data2['vendor_type'] = $vendor_type;
        $data2['website'] = $website;
        $data2['credit_limit'] = $credit_limit;
        $data2['acc_no'] = $acc_no;
        $data2['bank_name'] = $bank_name;
        $data2['bank_address'] = $bank_address;
        $data2['swift_code'] = $swift_code;
        $data2['branch_name'] = $branch_name;
        $data2['terms_of_payment'] = $term;
        $data2['opening_bal_date'] = $open_date;


        $lastInsertedID = DB::Connection('mysql2')->table('supplier')->InsertGetId($data2);
        $contact_person = Input::get('contact_person');
        $contact_no  = Input::get('contact_no');
        $fax  = Input::get('fax');
        $address  = Input::get('address');
        $work_phone  = Input::get('work_phone');

        foreach ($contact_person as $key => $row) {
            if ($contact_person[$key] != "" || $contact_no[$key] != "" || $fax[$key] != "" || $address[$key] != "") {
                $InfoData['supp_id'] = $lastInsertedID;
                $InfoData['contact_person'] = $contact_person[$key];
                $InfoData['contact_no'] = $contact_no[$key];
                $InfoData['fax'] = $fax[$key];
                $InfoData['address'] = $address[$key];
                $InfoData['work_phone'] = $work_phone[$key];
                DB::Connection('mysql2')->table('supplier_info')->insert($InfoData);
            }
        }

        if (Input::get('addtype') == "ajax") {
            return ['id' => $lastInsertedID, 'name' => $name];
        }

        return Redirect::to('purchase/viewSupplierList?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . $_GET['m'] . '#SFR');
    }

    public function addCategoryDetail(Request $request)
    {


        $acc_id = ReuseableCode::make_account($request->account_head, $request->category_name, 1);
        $data2['main_ic'] = $request->category_name;
        $data2['type'] = 2;
        $data2['acc_id'] = $acc_id;
        $data2['username'] = Auth::user()->name;
        $data2['date'] = date("d-m-Y");
        $data2['time'] = date("H:i:s");
        $data2['action'] = 'create';
        $m_id = DB::connection('mysql2')->table('category')->insertGetId($data2);


        return Redirect::to('purchase/viewCategoryList?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . $_GET['m'] . '#SFR');
    }

    //ABDUL
    public function addSubCategoryDetail()
    {
        $m = $_GET['m'];
        $CategoryId = Input::get('CategoryId');
        $SubCategoryName = Input::get('SubCategoryName');

        $SubCategoryInsert['category_id'] = $CategoryId;
        $SubCategoryInsert['sub_category_name'] = $SubCategoryName;



        $SubCategoryInsert['status'] = 1;
        $SubCategoryInsert['username'] = Auth::user()->name;
        $SubCategoryInsert['created_date'] = date("d-m-Y");

        CommonHelper::reconnectMasterDatabase();
        $Count = DB::Connection('mysql2')->selectOne('SELECT COUNT(sub_category_name) as data_count FROM sub_category
        WHERE category_id = ' . $CategoryId . ' AND sub_category_name collate latin1_swedish_ci = "' . $SubCategoryName . '"')->data_count;
        //echo  $Count; die();
        if ($Count > 0) {
            Session::flash('dataDelete', $SubCategoryName . ' ' . 'Already Exists.');
            return Redirect::to('purchase/createSubCategoryForm?pageType=&&parentCode=143&&m=1#SFR');
        } else {
            DB::connection('mysql2')->table('sub_category')->insert($SubCategoryInsert);
            return Redirect::to('purchase/viewSubCategoryList?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . $_GET['m'] . '#SFR');
        }
    }
    //ABDUL

    public function addRegionDetail()
    {
        $m = $_GET['m'];
        $RegionCode = Input::get('region_code');
        $RegionName = Input::get('region_name');
        $ClusterId = Input::get('cluster_id');



        $data2['region_code'] = strip_tags($RegionCode);
        $data2['region_name'] = strip_tags($RegionName);
        $data2['cluster_id'] = $ClusterId;


        $data2['status'] = 1;

        $data2['created_date'] = date("d-m-Y");
        $data2['created_time'] = date("H:i:s");
        $data2['username'] = Auth::user()->name;


        DB::connection('mysql2')->table('region')->insert($data2);

        CommonHelper::reconnectMasterDatabase();
        return Redirect::to('purchase/regionList?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . $_GET['m'] . '#SFR');
        die;
    }

    public function insertCluster()
    {
        $m = $_GET['m'];
        $ClusterName = Input::get('cluster_name');
        $ClusterData['cluster_name'] = strip_tags($ClusterName);
        $ClusterData['status'] = 1;
        $ClusterData['username'] = Auth::user()->name;
        $ClusterData['created_date'] = date("d-m-Y");
        $ClusterData['created_time'] = date("H:i:s");
        DB::connection('mysql2')->table('cluster')->insert($ClusterData);
        CommonHelper::reconnectMasterDatabase();
        return Redirect::to('purchase/clusterList?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . $_GET['m'] . '#SFR');
    }






    public function uploadSubItemDetail(Request $request)
    {

        DB::Connection('mysql2')->beginTransaction();
        try {
            if ($request->file('dataFile')) {
                $file = Excel::toArray([], $request->file('dataFile'));
                $file = $file[0];
                //dd($file);
                $userName = Auth::user()->name;
                $company_id = Session::get('run_company');
                if (trim($file[0][0]) == 'SKU' && trim($file[0][1]) == 'Item' && trim($file[0][2]) == 'Unit' && trim($file[0][3]) == 'Category' && trim($file[0][4]) == 'Item Type') {
                    foreach ($file as $key => $value) :
                        if ($key <= 0) continue;
                        //dd($value);
                        // dd($value);
                        $existUom = new UOM();
                        if ($existUom->where('uom_name', trim($value[2]))->where('status', 1)->count() > 0) {
                            $existUom = $existUom->where('uom_name', trim($value[2]))->where('status', 1)->first()->id;
                        } else {
                            $existUom->uom_name = trim($value[2]);
                            $existUom->status = 1;
                            $existUom->username = $userName;
                            $existUom->date    = date('Y-m-d');
                            $existUom->time    = date('H:i:s');
                            $existUom->company_id = $company_id;
                            $existUom->save();
                            $existUom = $existUom->id;
                        }
                        $existCategory = new Category();
                        if ($existCategory->where('main_ic', trim($value[3]))->where('status', 1)->count() > 0) {
                            $existCategory = $existCategory->where('main_ic', trim($value[3]))->where('status', 1)->first()->id;
                        } else {
                            $existCategory->main_ic = trim($value[3]);
                            $existCategory->username = $userName;
                            $existCategory->date    = date('Y-m-d');
                            $existCategory->time    = date('H:i:s');
                            $existCategory->company_id = $company_id;
                            $existCategory->action = 0;
                            $existCategory->save();
                            $existCategory = $existCategory->id;
                        }
                        $existDT = new DemandType();
                        if ($existDT->where('name', 'Like', trim($value[4]))->where('status', 1)->count() > 0) {
                            $existDT = $existDT->where('name', 'Like', trim($value[4]))->where('status', 1)->first()->id;
                        } else {
                            $existDT->id = (DemandType::orderBy('id', 'desc')->first()) ? DemandType::orderBy('id', 'desc')->first()->id + 1 : 1;
                            $existDT->name = trim($value[4]);
                            $existDT->status = 1;
                            $existDT->username = $userName;
                            $existDT->date    = date('Y-m-d');
                            $existDT->time    = date('H:i:s');
                            $existDT->save();
                            $existDT = $existDT->id;
                        }
                        $subItem = new Subitem();
                        if (!$subItem->where('main_ic_id', $existCategory)->where('uom', $existUom)->where('sub_ic', trim($value[1]))->where('status', 1)->count() > 0) {
                            $subItem->main_ic_id = $existCategory;
                            $subItem->uom = $existUom;
                            $subItem->sub_ic = trim($value[1]);
                            $subItem->description = trim($value[1]);
                            $subItem->acc_id = 0;
                            $subItem->type = $existDT;
                            $subItem->reorder_level = 0;
                            $subItem->date    = date('Y-m-d');
                            $subItem->time    = date('H:i:s');
                            $subItem->action = 0;
                            $subItem->username = $userName;
                            $subItem->type = 1;
                            $subItem->item_code = $value[0];
                            $subItem->sku_code = $value[0]??'';
                            $subItem->save();
                        }
                    endforeach;
                    DB::Connection('mysql2')->commit();
                    Session::flash('dataInsert', 'Successfully Upload!');
                    return Redirect::to('purchase/viewSubItemList?m=' . Session::get('run_company'));
                } else {
                    Session::flash('dataDelete', 'Please Upload with the given format!');
                    return Redirect::to('purchase/uploadSubItemForm?m=' . Session::get('run_company'));
                }
            } else {
                Session::flash('dataDelete', 'File Not Found!');
                return Redirect::to('purchase/uploadSubItemForm?m=' . Session::get('run_company'));
            }
        } catch (Exception $th) {
            //throw $th;
            DB::Connection('mysql2')->rollback();
            dd($th);
        }
    }
    public function addSubItemDetail(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'sub_ic' => 'required|string|unique:mysql2.subitem',
            'sku_code' => 'nullable|string|unique:mysql2.subitem',
            // 'item_code' => 'unique:mysql2.subitem'
        ]);
       
        $sub_item = new Subitem();
        $sub_item = $sub_item->SetConnection('mysql2');
        $sub_item->main_ic_id = $request->CategoryId;
        $sub_item->sub_ic = $request->sub_ic;
        $sub_item->scientific_name = $request->scientific_name;
        $sub_item->sku_code = $request->sku_code??'';
        $sub_item->item_code = $request->sku_code ?? '';
        $sub_item->uom = $request->uom_id;
        $sub_item->rate = $request->rate ?? 0;
        $sub_item->batch_code = 0;//$request->batch_code;
        $sub_item->min_stock = 0;//$request->min_stock ?? 0;
        $sub_item->max_stock = 0;//$request->max_stock ?? 0;
        $sub_item->type = '';//$request->maintain;
        $sub_item->pack_size ='';// $request->pack_size;
        $sub_item->pack_uom ='';// $request->pack_uom_id;
        $sub_item->pack_type ='';// $request->pack_type;
        $sub_item->hs_code =$request->hs_code;
        $sub_item->stockType ='';// $request->stockType??1;
        $sub_item->acc_id ='';// $account->id ?? 0;
        $sub_item->username = Auth::user()->name;
        $sub_item->date = date('Y-m-d');
        $sub_item->save();
        Session::flash('dataInsert', "SubItem Successfully Inserted");
        return redirect('purchase/createSubItemForm');
    }

    public function addUOMDetail()
    {
        $uomName = Input::get('uom_name');
        $data1['uom_name'] = strip_tags($uomName);
        $data1['username'] = Auth::user()->name;
        $data1['company_id'] = $_GET['m'];
        $data1['date'] = date("d-m-Y");
        $data1['time'] = date("H:i:s");

        DB::table('uom')->insert($data1);
        return Redirect::to('purchase/viewUOMList?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . $_GET['m'] . '#SFR');
    }

    public function addDemandDetail(Request $request)
    {
        // dd(explode('%',$request->item_id[0])[0]);
        $demandDataSection = Input::get('sub_ic_des');
        DB::Connection('mysql2')->beginTransaction();
        // dd(Input::get());
        try {
            $m = $_GET['m'];
            CommonHelper::companyDatabaseConnection($_GET['m']);
            $demand_date = strip_tags(Input::get('demand_date_1'));
            $slip_no = strip_tags(Input::get('slip_no_1'));
            $description = strip_tags(Input::get('description_1'));
            $sub_department_id = strip_tags(Input::get('sub_department_id_1'));
            $mode_type = strip_tags(Input::get('mode_type'));
            $location = Input::get('company_location_id');


            // $str = DB::Connection('mysql2')->selectOne('select max(convert(substr(`demand_no`,6,length(substr(`demand_no`,6))-4),signed integer)) reg from
            //  `demand` where substr(`demand_no`,-4,2) = ' . date('m') . ' and substr(`demand_no`,-2,2) = ' . date('y') . '
            //  and company_location_id='.$location.'')->reg;

            $str = Demand::where('company_location_id', $location)->orderBy('id', 'desc')->count();
            $demand_no = 'pr-' . CommonHelper::getCompanyLocationPrefix($location) . '-' . sprintf("%'05d", ($str + 1)); // . date('my');
            $Demand = new Demand();
            $Demand = $Demand->SetConnection('mysql2');
            $Demand->demand_no = $demand_no;
            $Demand->slip_no = $slip_no;
            $Demand->demand_date = $demand_date;
            $Demand->description = $description;
            $Demand->company_location_id = Input::get('company_location_id');
            $Demand->sub_department_id = $sub_department_id;
            $Demand->date = date("d-m-Y");
            $Demand->time = date("H:i:s");
            $Demand->username = Auth::user()->name;
            $Demand->status = 1;
            $Demand->demand_status = 1;
            $Demand->p_type = $mode_type;
            $Demand->save();
            $MasterId = $Demand->id;

            $file = Input::file('file');
            if (isset($file)) {
                foreach ($file as $key => $value) {
                    $d1 =   $value->getClientOriginalName();
                    $d2 =  $value->getClientOriginalExtension();
                    $d3 =  $value->getRealPath();
                    $newfilename = date('dmYHis') . preg_replace("/[^a-z0-9\_\-\.]/i", "", basename($value->getClientOriginalName()));
                    $value->move(public_path('uploads/attachement'), $newfilename);

                    $attachment =  new Attachement;
                    $attachment->image_src = 'public/uploads/attachement/' . $newfilename;
                    $attachment->status = 1;
                    $Demand->comments()->save($attachment);
                }
            }



            $demandDataSection = Input::get('item_id');

            $qty = Input::get('quantity');
            foreach ($demandDataSection as $key => $row2) {
                $DemandData = new DemandData();
                $DemandData = $DemandData->SetConnection('mysql2');

                $DemandData->demand_no = $demand_no;
                $DemandData->master_id = $MasterId;
                $DemandData->demand_date = $demand_date;
                $DemandData->sub_ic_desc = Input::get('item_desc')[$key];

                $item_id = explode('%', $row2);
                $item_id = $item_id[0];
                $DemandData->sub_item_id = $item_id;
                if(isset(Input::get('material_request_id')[$key])){
                    $DemandData->material_request_id = Input::get('material_request_id')[$key];
                }
                $DemandData->qty = $qty[$key];
                $DemandData->date = date("d-m-Y");
                $DemandData->time = date("H:i:s");
                $DemandData->username = Auth::user()->name;
                $DemandData->status = 1;
                $DemandData->save();
                if(isset(Input::get('material_request_id')[$key]) && Input::get('qty_balance')[$key] == 0){
                    MaterialRequestData::find(Input::get('material_request_id')[$key])->update(['is_complete'=> 1]);
                    // dd(isset(Input::get('material_request_id')[$key]));
                }
            }
            // dd('heeloo');


            CommonHelper::reconnectMasterDatabase();
            CommonHelper::inventory_activity($demand_no, $demand_date, 0, 1, 'Insert');


            $subject = 'Purchase Request ' . $demand_no;
            // NotificationHelper::send_email('Purchase Request', 'Create', $sub_department_id, $demand_no, $subject, $mode_type);

            DB::Connection('mysql2')->commit();
        } catch (\Exception $e) {
            DB::Connection('mysql2')->rollback();
            echo "ERROR "; //die();

            echo   $e->getMessage();
            dd($e->getline(), $e->getTraceAsString());
        }
        Session::flash('dataInsert', 'Purchase Request Successfully Saved.');

        return Redirect::to('purchase/viewDemandList?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . $_GET['m'] . '#SFR');
    }

    public function updateDemandDetail()
    {

        $EditId = Input::get('EditId');
        // $demandDataSection = Input::get('sub_ic_des');
        //prin


        DB::Connection('mysql2')->beginTransaction();
        try {
            CommonHelper::companyDatabaseConnection($_GET['m']);
            $demand_date = strip_tags(Input::get('demand_date_1'));
            $slip_no = strip_tags(Input::get('slip_no_1'));
            $description = strip_tags(Input::get('description_1'));
            $sub_department_id = strip_tags(Input::get('sub_department_id_1'));

            $demand_no = strip_tags(Input::get('pr_no'));


            $Demand = new Demand();
            $Demand = $Demand->SetConnection('mysql2');
            $Demand = $Demand->find($EditId);
            //$btach->save();
            $Demand->demand_no = $demand_no;
            $Demand->slip_no = $slip_no;

            $Demand->demand_date = $demand_date;
            $Demand->p_type = strip_tags(Input::get('mode_type'));
            $Demand->description = $description;
            $Demand->sub_department_id = $sub_department_id;
            $Demand->date = date("d-m-Y");
            $Demand->time = date("H:i:s");
            $Demand->username = Auth::user()->name;
            $Demand->status = 1;
            $Demand->demand_status = 1;
            $Demand->save();

            $file = Input::file('file');
            if (isset($file)) {
                foreach ($file as $key => $value) {
                    $d1 =   $value->getClientOriginalName();
                    $d2 =  $value->getClientOriginalExtension();
                    $d3 =  $value->getRealPath();
                    $newfilename = date('dmYHis') . str_replace(" ", "", basename($value->getClientOriginalName()));
                    $value->move(public_path('uploads/attachement'), $newfilename);

                    $attachment =  new Attachement;
                    $attachment->image_src = 'public/uploads/attachement/' . $newfilename;
                    $attachment->status = 1;
                    $Demand->comments()->save($attachment);
                }
            }


            DB::table('demand_data')->where('master_id', $EditId)->delete();

            $demandDataSection = Input::get('item_id');
            $sub_item_id = Input::get('item_id');
            $qty = Input::get('quantity');
            foreach ($demandDataSection as $key => $row2) {
                $item_iddd=explode('@', $row2)[0];
                if($item_iddd == 250000 || $item_iddd == 0){
                    continue;
                }
                $DemandData = new DemandData();
                $DemandData = $DemandData->SetConnection('mysql2');

                $DemandData->demand_no = $demand_no;
                $DemandData->master_id = $EditId;
                $DemandData->demand_date = $demand_date;
                $DemandData->sub_ic_desc = Input::get('item_desc')[$key];
                $DemandData->sub_item_id = explode('@', $row2)[0];
                $DemandData->qty = $qty[$key];
                $DemandData->date = date("d-m-Y");
                $DemandData->time = date("H:i:s");
                $DemandData->username = Auth::user()->name;
                $DemandData->status = 1;
                $DemandData->save();
            }


            CommonHelper::reconnectMasterDatabase();
            CommonHelper::inventory_activity($demand_no, $demand_date, 0, 1, 'Update');
            DB::Connection('mysql2')->commit();
        } catch (\Exception $e) {
            DB::Connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e->getMessage());
        }
        Session::flash('dataInsert', 'Purchase Request Successfully Saved.');

        return Redirect::to('purchase/viewDemandList?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . $_GET['m'] . '#SFR');
    }
    public function addIssuanceDetail()
    {
        //print_r($_POST); die;
        DB::Connection('mysql2')->beginTransaction();
        try {
            $m = $_GET['m'];
            CommonHelper::companyDatabaseConnection($_GET['m']);
            $issuanceSection = Input::get('issuanceSection');

            foreach ($issuanceSection as $row) {
                $slip_no = strip_tags(Input::get('slip_no_' . $row . ''));
                $iss_date = strip_tags(Input::get('iss_date_' . $row . ''));
                $description = strip_tags(Input::get('description_' . $row . ''));
                $issuanceDataSection = Input::get('issuanceDataSection_' . $row . '');

                $str = DB::Connection('mysql2')->selectOne("select max(convert(substr(`iss_no`,3,length(substr(`iss_no`,3))-4),signed integer)) reg from `issuance` where substr(`iss_no`,-4,2) = " . date('m') . " and substr(`iss_no`,-2,2) = " . date('y') . "")->reg;
                $is_no = 'is' . ($str + 1) . date('my');

                $data1['iss_no'] = $is_no;
                $data1['iss_date'] = $iss_date;
                $data1['description'] = $description;
                $data1['status'] = 1;
                $data1['issuance_status'] = 1;
                $data1['created_date'] = date("d-m-Y");
                $data1['created_time'] = date("H:i:s");
                $data1['username'] = Auth::user()->name;
                if (Input::get('IssuanceType') == 1) {
                    $data1['region'] = Input::get('region');
                    $data1['joborder'] = Input::get('joborder');
                    $data1['issuance_type'] = Input::get('IssuanceType');
                } elseif (Input::get('IssuanceType') == 2) {
                    $data1['region'] = Input::get('region');
                    $data1['region_to'] = Input::get('region_to');
                    $data1['issuance_type'] = Input::get('IssuanceType');
                } elseif (Input::get('IssuanceType') == 3) {
                    $data1['region'] = Input::get('region');
                    $data1['issuance_type'] = Input::get('IssuanceType');
                } elseif (Input::get('IssuanceType') == 4) {
                    $data1['region'] = Input::get('region');
                    $data1['issuance_type'] = Input::get('IssuanceType');
                } elseif (Input::get('IssuanceType') == 5) {
                    $data1['region'] = Input::get('region');
                    $data1['region_to'] = Input::get('region_to');
                    $data1['issuance_type'] = Input::get('IssuanceType');
                }

                $master_id = DB::table('issuance')->insertGetId($data1);

                foreach ($issuanceDataSection as $row2) {
                    $category_id = strip_tags(Input::get('category_id_' . $row . '_' . $row2 . ''));
                    $sub_item_id = strip_tags(Input::get('sub_item_id_' . $row . '_' . $row2 . ''));
                    $joborder_id = strip_tags(Input::get('joborder_id_' . $row . '_' . $row2 . ''));
                    $qty = strip_tags(Input::get('qty_' . $row . '_' . $row2 . ''));

                    $data2['master_id'] = $master_id;
                    $data2['iss_no'] = $is_no;
                    $data2['category_id'] = $category_id;
                    $data2['sub_item_id'] = $sub_item_id;
                    $data2['joborder_id'] = $joborder_id;
                    $data2['qty'] = $qty;
                    $data2['status'] = 1;
                    $data2['issuance_status'] = 1;
                    $data2['created_date'] = date("d-m-Y");
                    $data2['created_time'] = date("H:i:s");
                    $data2['username'] = Auth::user()->name;
                    $issuance_data_id = DB::table('issuance_data')->insertGetId($data2);

                    //                $data3['main_id']       = $master_id;
                    //                $data3['master_id']     = $issuance_data_id;
                    //                $data3['voucher_no']    = $is_no;
                    //                $data3['voucher_date']  = date("d-m-Y");
                    //                $data3['voucher_type']  = 2;
                    //                $data3['category_id']   = $category_id;
                    //                $data3['sub_item_id']   = $sub_item_id;
                    //                $data3['region_id']     = Input::get('region');
                    //                $data3['joborder']     = Input::get('joborder');
                    //                $data3['qty']           = $qty;
                    //                $data3['status']        = 1;
                    //                $data3['created_date']  = date("d-m-Y");
                    //                $data3['username']      = Auth::user()->name;
                    //                DB::table('stock')->insert($data3);

                }
            }
            CommonHelper::reconnectMasterDatabase();
            DB::Connection('mysql2')->commit();
        } catch (\Exception $e) {
            DB::Connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e->getMessage());
        }

        return Redirect::to('purchase/goodIssuanceList?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . $_GET['m'] . '#Garibsons');
    }

    public function updateIssuanceDetail()
    {
        //        echo "<pre>";
        //        print_r($_POST); die;
        DB::Connection('mysql2')->beginTransaction();
        try {

            $m = $_GET['m'];
            $UpdateId = Input::get('UpdateId');

            $IssuanceType = Input::get('IssuanceType');
            if ($IssuanceType == 1) {
                $data1['region'] = Input::get('region');
                $data1['joborder'] = Input::get('joborder');
                $data1['issuance_type'] = Input::get('IssuanceType');
            } elseif ($IssuanceType == 2) {
                $data1['region'] = Input::get('region');
                $data1['region_to'] = Input::get('region_to');
                $data1['issuance_type'] = Input::get('IssuanceType');
            } elseif ($IssuanceType == 3) {
                $data1['region'] = Input::get('region');
                $data1['issuance_type'] = Input::get('IssuanceType');
            } elseif ($IssuanceType == 4) {
                $data1['region'] = Input::get('region');
                $data1['issuance_type'] = Input::get('IssuanceType');
            } elseif ($IssuanceType == 5) {
                $data1['region'] = Input::get('region');
                $data1['region_to'] = Input::get('region_to');
                $data1['issuance_type'] = Input::get('IssuanceType');
            }

            CommonHelper::companyDatabaseConnection($_GET['m']);
            $issuanceSection = Input::get('issuanceSection');
            foreach ($issuanceSection as $row) {
                $slip_no = strip_tags(Input::get('slip_no_' . $row . ''));
                $iss_date = strip_tags(Input::get('iss_date_' . $row . ''));
                $description = strip_tags(Input::get('description_' . $row . ''));
                $issuanceDataSection = Input::get('issuanceDataSection_' . $row . '');
                $is_no = Input::get('is_no');

                $data1['iss_no'] = strtolower($is_no);
                $data1['iss_date'] = $iss_date;
                $data1['description'] = $description;
                $data1['status'] = 1;
                $data1['issuance_status'] = 1;
                $data1['created_date'] = date("d-m-Y");
                $data1['created_time'] = date("H:i:s");
                $data1['username'] = Auth::user()->name;
                $master_id = DB::table('issuance')->where('id', $UpdateId)->update($data1);
                DB::table('issuance_data')->where('master_id', $UpdateId)->delete();


                foreach ($issuanceDataSection as $row2) {
                    $category_id = strip_tags(Input::get('category_id_' . $row . '_' . $row2 . ''));
                    $sub_item_id = strip_tags(Input::get('sub_item_id_' . $row . '_' . $row2 . ''));
                    //$joborder_id = strip_tags(Input::get('joborder_id_' . $row . '_' . $row2 . ''));
                    $qty = strip_tags(Input::get('qty_' . $row . '_' . $row2 . ''));

                    $data2['master_id'] = $UpdateId;
                    $data2['iss_no'] = $is_no;
                    $data2['category_id'] = $category_id;
                    $data2['sub_item_id'] = $sub_item_id;
                    //$data2['joborder_id'] = $joborder_id;
                    $data2['qty'] = $qty;
                    $data2['status'] = 1;
                    $data2['issuance_status'] = 1;
                    $data2['created_date'] = date("d-m-Y");
                    $data2['created_time'] = date("H:i:s");
                    $data2['username'] = Auth::user()->name;
                    $issuance_data_id = DB::table('issuance_data')->insert($data2);
                }
            }
            CommonHelper::reconnectMasterDatabase();
            DB::Connection('mysql2')->commit();
        } catch (\Exception $e) {
            DB::Connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e->getMessage());
        }
        return Redirect::to('purchase/goodIssuanceList?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . $_GET['m'] . '#SFR');
    }

    public function UpdateStockReturnDetail()
    {
        //echo "<pre>";
        //print_r($_POST); die;

        $m = $_GET['m'];
        $UpdateId = Input::get('UpdateId');

        $IssuanceType = Input::get('IssuanceType');
        if ($IssuanceType == 1) {
            $data1['region'] = Input::get('region');
            $data1['joborder'] = Input::get('joborder');
            $data1['issuance_type'] = $IssuanceType;
        } else {
            $data1['issuance_type'] = $IssuanceType;
        }

        CommonHelper::companyDatabaseConnection($_GET['m']);
        $issuanceSection = Input::get('issuanceSection');
        foreach ($issuanceSection as $row) {
            $iss_date = strip_tags(Input::get('iss_date_' . $row . ''));
            $description = strip_tags(Input::get('description_' . $row . ''));
            $issuanceDataSection = Input::get('issuanceDataSection_' . $row . '');
            $is_no = Input::get('is_no');

            $data1['issuance_no'] = $is_no;
            $data1['issuance_date'] = $iss_date;
            $data1['description'] = $description;
            $data1['status'] = 1;
            $data1['return_status'] = 1;
            $data1['date'] = date("d-m-Y");
            $data1['username'] = Auth::user()->name;
            $master_id = DB::table('stock_return')->where('stock_return_id', $UpdateId)->update($data1);
            DB::table('stock_return_data')->where('stock_return_id', $UpdateId)->delete();


            foreach ($issuanceDataSection as $row2) {
                $category_id = strip_tags(Input::get('category_id_' . $row . '_' . $row2 . ''));
                $sub_item_id = strip_tags(Input::get('sub_item_id_' . $row . '_' . $row2 . ''));
                //$joborder_id = strip_tags(Input::get('joborder_id_' . $row . '_' . $row2 . ''));
                $qty = strip_tags(Input::get('qty_' . $row . '_' . $row2 . ''));

                $data2['stock_return_id'] = $UpdateId;
                $data2['issuance_no'] = $is_no;
                $data2['category'] = $category_id;
                $data2['subitem'] = $sub_item_id;
                $data2['qty'] = $qty;
                $data2['status'] = 1;
                $data2['return_status'] = 1;
                $data2['date'] = date("d-m-Y");
                $data2['username'] = Auth::user()->name;
                $issuance_data_id = DB::table('stock_return_data')->insert($data2);
            }
        }
        CommonHelper::reconnectMasterDatabase();
        return Redirect::to('purchase/stockreturnlist?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . $_GET['m'] . '#SFR');
    }


    public function updateRegionDetail()
    {

        $CompanyId = Input::get('CompanyId');
        $UpdateId = Input::get('edit_id');
        $RegionCode = Input::get('region_code');
        $RegionName = Input::get('region_name');
        $ClusterId = Input::get('cluster_id');
        $UpdateData['region_code'] = $RegionCode;
        $UpdateData['region_name'] = $RegionName;
        $UpdateData['cluster_id'] = $ClusterId;

        DB::Connection('mysql2')->table('region')->where('id', $UpdateId)->update($UpdateData);
        return Redirect::to('purchase/regionList?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . $CompanyId . '#SFR');
    }

    public function addGoodsReceiptNoteDetail(Request $request)
    {
        // dd($request->all());
        DB::Connection('mysql2')->beginTransaction();
        try {
            $m = $_GET['m'];
            CommonHelper::companyDatabaseConnection($_GET['m']);
            
            // $seletedPurchaseRequestRow = Input::get('seletedPurchaseRequestRow');
            // foreach ($seletedPurchaseRequestRow as $row1) {
            //     $balance_qty_recived = strip_tags(Input::get('balqty_' . $row1 . ''));
            //     if($balance_qty_recived < 0){
            //         DB::Connection('mysql2')->rollback();
           
            //         Session::flash('dataDelete', 'Balance Qty should not be in negative.');
            //         return Redirect::to('purchase/createGoodsReceiptNoteForm?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . $_GET['m'] . '#SFR');
            //     }
            // }
            

            // $str = DB::selectOne("select max(convert(substr(`grn_no`,4,length(substr(`grn_no`,4))-4),signed integer)) reg from `goods_receipt_note` where substr(`grn_no`,-4,2) = " . date('m') . " and substr(`grn_no`,-2,2) = " . date('y') . "")->reg;
            // $grn_no = 'grn' . ($str + 1) . date('my');
            $str = GoodsReceiptNote::where('company_location_id', Input::get('company_location_id'))->count();
            $voucher_no = 'grn-' . CommonHelper::getCompanyLocationPrefix(Input::get('company_location_id')) . '-' . sprintf("%'05d", ($str + 1)); // . date('my');

            $grn_no = $voucher_no;

            $prNo = strip_tags(Input::get('prNo'));
            $prDate = strip_tags(Input::get('prDate'));
            $subDepartmentId = strip_tags(Input::get('subDepartmentId'));
            $supplierId = strip_tags(Input::get('supplierId'));
            $invoice_no = strip_tags(Input::get('invoice_no'));
            $grn_date = strip_tags(Input::get('grn_date'));
            $bill_date = strip_tags(Input::get('bill_date'));
            $main_description = strip_tags(Input::get('main_description'));
            $delivery_challan_no = strip_tags(Input::get('del_chal_no'));
            $delivery_vehicale = strip_tags(Input::get('del_detail'));

            $data1['grn_no'] = $grn_no;
            $data1['grn_date'] = $grn_date;
            $data1['po_no'] = $prNo;
            $data1['po_date'] = $prDate;

            $data1['sub_department_id'] = $subDepartmentId;
            $data1['supplier_id'] = $supplierId;
            $data1['bill_date'] = $bill_date;
            $data1['main_description'] = $main_description;
            $data1['supplier_invoice_no'] = $invoice_no;
            $data1['delivery_challan_no'] = $delivery_challan_no;
            $data1['delivery_detail'] = $delivery_vehicale;
            $data1['p_type'] = Input::get('p_type_id');
            $data1['company_location_id'] = Input::get('company_location_id');
            $data1['store_control_no'] = Input::get('store_control_no');
            $data1['temp_grn_id'] = Input::get('tempGrn_id');
            $data1['date'] = date("d-m-Y");
            $data1['time'] = date("H:i:s");
            $data1['username'] = Auth::user()->name;
            $goodsReceiptNote = GoodsReceiptNote::create($data1);
            $master_id = $goodsReceiptNote->id;
            $file = Input::file('file');
            if (isset($file)) {
                foreach ($file as $key => $value) {
                    $d1 =   $value->getClientOriginalName();
                    $d2 =  $value->getClientOriginalExtension();
                    $d3 =  $value->getRealPath();
                    $newfilename = date('dmYHis') . preg_replace("/[^a-z0-9\_\-\.]/i", "", basename($value->getClientOriginalName()));
                    $value->move(public_path('uploads/attachement'), $newfilename);

                    $attachment =  new Attachement;
                    $attachment->image_src = 'public/uploads/attachement/' . $newfilename;
                    $attachment->status = 1;
                    $goodsReceiptNote->attachments()->save($attachment);
                }
            }
            
            $seletedPurchaseRequestRow = Input::get('seletedPurchaseRequestRow');
            $TotAmount = 0;
            $grn_data_id_push = [];
            foreach ($seletedPurchaseRequestRow as $row1) {
                $variableCheck = 0;
                $sub_item_id = strip_tags(Input::get('subItemId_' . $row1 . ''));
                $batch_code = strip_tags(Input::get('batch_code' . $row1 . ''));
                $purchase_approved_qty = strip_tags(Input::get('approved_qty_' . $row1 . ''));
                $purchase_recived_qty = strip_tags(Input::get('rec_qty_' . $row1 . ''));

                $discount_percent = strip_tags(Input::get('discount_percent' . $row1 . ''));
                $discount_amount = strip_tags(Input::get('discount_amount' . $row1 . ''));
                $after_discount_amount = strip_tags(Input::get('after_discount_amount' . $row1 . ''));
                $reject_qty_recived = strip_tags(Input::get('rejectqty_' . $row1 . ''));
                $balance_qty_recived = strip_tags(Input::get('balqty_' . $row1 . ''));
                $warehouse_id = strip_tags(Input::get('warehouse_id_' . $row1 . ''));
                $received_type = strip_tags(Input::get('received_type_' . $row1 . ''));
                // dd(Input::get());
                $po_data_id = strip_tags(Input::get('po_data_id' . $row1 . ''));


                $purchase_request_data_check = DB::Connection('mysql2')->table('purchase_request_data')->where('status', 1)->where('id', $row1)->first();
                $purchase_approve_qty_check = $purchase_request_data_check->purchase_approve_qty;

                $grn_data = DB::Connection('mysql2')->table('grn_data')->select(DB::raw('SUM(purchase_recived_qty) as purchase_recived_qty'))->where('po_data_id', $row1)->groupBy('po_data_id');
                if ($grn_data->count() > 0) {
                    $grn_data = $grn_data->first();
                    $grn_purchase_recived_qty = $grn_data->purchase_recived_qty;
                } else {
                    $grn_purchase_recived_qty = 0;
                }

                $total_recieved_qty = $grn_purchase_recived_qty + $purchase_recived_qty;

                if ($total_recieved_qty < $purchase_approve_qty_check) {
                    $variableCheck = 1;
                }

                $rate = $purchase_request_data_check->rate;

                $amount = $rate * $purchase_recived_qty;
                $data2['master_id'] = $master_id;
                $data2['po_data_id'] = $po_data_id;
                $data2['grn_no'] = $grn_no;
                $data2['grn_date'] = $grn_date;
                $data2['sub_item_id'] = $sub_item_id;
                $data2['batch_code'] = $batch_code;
                $data2['purchase_approved_qty'] = $purchase_approved_qty;
                $data2['purchase_recived_qty'] = $purchase_recived_qty;
                $data2['rate'] = $rate;
                $data2['amount'] = $amount;
                $data2['discount_percent'] = $discount_percent;
                $data2['discount_amount'] = $discount_amount;
                $data2['net_amount'] = $after_discount_amount;
                $TotAmount += $after_discount_amount;
                $data2['reject_qty'] = $reject_qty_recived;
                $data2['bal_reciable'] = $balance_qty_recived;

                // if($balance_qty_recived < 0){
                //     DB::Connection('mysql2')->rollback();
           
                //     Session::flash('dataDelete', 'Balance Qty should not be in negative.');
                //     return Redirect::to('purchase/createGoodsReceiptNoteForm?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . $_GET['m'] . '#SFR');
                // }

                $data2['warehouse_id'] = $warehouse_id;
                $data2['received_type'] = $received_type;
                $data2['store_control_no'] = Input::get('store_control_no');
                $data2['description'] = Input::get('des' . $row1 . '');
                $data2['expiry_date'] = Input::get('expiry_date' . $row1 . '');


                $data2['date'] = date("d-m-Y");
                $data2['time'] = date("H:i:s");
                $data2['username'] = Auth::user()->name;
                $grn_data_id = DB::table('grn_data')->insertGetId($data2);
                array_push($grn_data_id_push, $grn_data_id);

                if ($variableCheck == 1) {
                } else {
                    $data4 = array(
                        'grn_status' => 2,
                        'purchase_request_status' => 3
                    );
    
                    DB::table('purchase_request_data')
                        ->where('id',$po_data_id)
                        ->where('status', 1)
                        ->update($data4);
                }
            }

            $Loop = Input::get('account_id');

            if ($Loop != "") {
                $Counta = 0;
                foreach ($Loop as $LoopFil) {
                    $ExpData['voucher_no'] = $grn_no;
                    $ExpData['main_id'] = $master_id;
                    $ExpData['acc_id'] = Input::get('account_id')[$Counta];
                    $ExpData['amount'] = Input::get('expense_amount')[$Counta];
                    $TotAmount += Input::get('expense_amount')[$Counta];
                    $ExpData['created_date'] = date('Y-m-d');
                    $ExpData['username'] = Auth::user()->name;
                    $Counta++;
                    DB::table('addional_expense')->insert($ExpData);
                }
            }

            //            echo "<pre>";
            //            print_r($ExpData);
            //            die();

            
            $countRemainingPendingRecord = DB::Connection('mysql2')->table('purchase_request_data')
                ->where('purchase_request_no', $prNo)
                ->where('status', 1)
                ->where('purchase_request_status', '!=', 3)
                ->where('grn_status', '!=',2)
                ->get();
            //dd($countRemainingPendingRecord);
            if(count($countRemainingPendingRecord) == 0){
                $prData = array(
                    'purchase_request_status' => 3
                );
                DB::Connection('mysql2')->table('purchase_request')
                    ->where('purchase_request_no', $prNo)
                    ->where('status', 1)
                    ->update($prData);
            }

            CommonHelper::reconnectMasterDatabase();

            CommonHelper::inventory_activity($grn_no, $grn_date, $TotAmount, 3, 'Insert');
            $request['grn_id'] = $master_id;
            $request['grn_data_id'] = $grn_data_id_push;
            $demand_no = DB::Connection('mysql2')->table('purchase_request_data')->where('purchase_request_no', $prNo)
                ->where('status', 1)->value('demand_no');

            $voucher_no = $grn_no;
            $subject = 'Goods Receipt Note Created For ' . $demand_no;
            // NotificationHelper::send_email('Goods Receipt Note', 'Create', $subDepartmentId, $voucher_no, $subject, Input::get('p_type_id'));



            DB::Connection('mysql2')->commit();



            (new PurchaseDataCallController)->qc_submit($request);
        } catch (Exception $e) {
            DB::Connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e);
        }


        Session::flash('dataInsert', 'Goods Receipt Note Successfully Saved.');
        return Redirect::to('purchase/viewGoodsReceiptNoteList?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . $_GET['m'] . '#SFR');
    }

    public function createStoreChallanandApproveGoodsReceiptNote()
    {
        $m = $_GET['m'];
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $pageType = Input::get('pageType');
        $parentCode = Input::get('parentCode');
        $grnNo = Input::get('grnNo');
        $grnDate = Input::get('grnDate');
        $prNo = Input::get('prNo');
        $prDate = Input::get('prDate');
        $supplier_id = Input::get('supplier_id');


        $updateDetails = array(
            'grn_status' => 2,
            'approve_username' => Auth::user()->name
        );

        DB::table('goods_receipt_note')
            ->where('grn_no', $grnNo)
            ->update($updateDetails);

        DB::table('grn_data')
            ->where('grn_no', $grnNo)
            ->update($updateDetails);


        $secondTableRecord = DB::table('grn_data')->where('grn_no', '=', $grnNo)->get();
        foreach ($secondTableRecord as $row) {
            $action = '3';
            $qty = $row->receivedQty;
            $value = $row->subTotal;
            $tableThree = 'fara';

            $data['grn_no'] = $grnNo;
            $data['grn_date'] = $grnDate;
            $data['pr_no'] = $prNo;
            $data['pr_date'] = $prDate;
            $data['supp_id'] = $supplier_id;
            $data['main_ic_id'] = $row->category_id;
            $data['sub_ic_id'] = $row->sub_item_id;
            $data['demand_type'] = $row->demand_type;
            $data['demand_send_type'] = $row->demand_send_type;
            $data['main_ic_id'] = $row->category_id;
            $data['sub_ic_id'] = $row->sub_item_id;
            $data['qty'] = $qty;
            $data['value'] = $value;
            $data['action'] = $action;
            $data['status'] = 1;
            $data['username'] = Auth::user()->name;
            $data['date'] = date("d-m-Y");
            $data['time'] = date("H:i:s");
            $data['company_id'] = $m;
            DB::table($tableThree)->insert($data);
        }


        $str = DB::selectOne("select max(convert(substr(`store_challan_no`,3,length(substr(`store_challan_no`,3))-4),signed integer)) reg from `store_challan` where substr(`store_challan_no`,-4,2) = " . date('m') . " and substr(`store_challan_no`,-2,2) = " . date('y') . "")->reg;
        $storeChallanNo = 'sc' . ($str + 1) . date('my');
        $slip_no = Input::get('slip_no');
        $departmentId = Input::get('sub_deparment_id');
        $main_description = Input::get('description');

        $data1['slip_no'] = $slip_no;
        $data1['store_challan_no'] = $storeChallanNo;
        $data1['store_challan_date'] = date("d-m-Y");
        $data1['sub_department_id'] = $departmentId;
        $data1['description'] = $main_description;
        $data1['username'] = Auth::user()->name;
        $data1['approve_username'] = Auth::user()->name;
        $data1['date'] = date("d-m-Y");
        $data1['time'] = date("H:i:s");
        $data1['store_challan_status'] = 2;

        DB::table('store_challan')->insert($data1);

        $rowId = Input::get('rowId');
        foreach ($rowId as $row1) {
            $demandNo = Input::get('demandNo_' . $row1 . '');
            $demandDate = Input::get('demandDate_' . $row1 . '');
            $demandType = Input::get('demandType_' . $row1 . '');
            $demandSendType = Input::get('demandSendType_' . $row1 . '');
            $categoryId = Input::get('categoryId_' . $row1 . '');
            $subItemId = Input::get('subItemId_' . $row1 . '');
            $issue_qty = Input::get('issue_qty_' . $row1 . '');
            $demandAndRemainingQty = Input::get('demandAndRemainingQty_' . $row1 . '');
            if ($demandType == 2) {
            } else {
                $data2['store_challan_no'] = $storeChallanNo;
                $data2['store_challan_date'] = date("d-m-Y");
                $data2['demand_no'] = $demandNo;
                $data2['demand_date'] = $demandDate;
                $data2['category_id'] = $categoryId;
                $data2['sub_item_id'] = $subItemId;
                $data2['issue_qty'] = $issue_qty;
                $data2['username'] = Auth::user()->name;
                $data2['approve_username'] = Auth::user()->name;
                $data2['date'] = date("d-m-Y");
                $data2['time'] = date("H:i:s");
                $data2['store_challan_status'] = 2;

                DB::table('store_challan_data')->insert($data2);

                if ($issue_qty == $demandAndRemainingQty) {
                    DB::table('demand_data')
                        ->where('category_id', $categoryId)
                        ->where('sub_item_id', $subItemId)
                        ->where('demand_no', $demandNo)
                        ->update(['store_challan_status' => "2"]);
                }
                $data3['sc_no'] = $storeChallanNo;
                $data3['sc_date'] = date("d-m-Y");
                $data3['demand_no'] = $demandNo;
                $data3['demand_date'] = $demandDate;
                $data3['main_ic_id'] = $categoryId;
                $data3['sub_ic_id'] = $subItemId;
                $data3['qty'] = $issue_qty;
                $data3['value'] = 0;
                $data3['username'] = Auth::user()->name;
                $data3['date'] = date("d-m-Y");
                $data3['time'] = date("H:i:s");
                $data3['action'] = 2;
                $data3['status'] = 1;
                $data3['company_id'] = $m;
                DB::table('fara')->insert($data3);
            }
        }


        CommonHelper::reconnectMasterDatabase();
        return Redirect::to('purchase/viewGoodsReceiptNoteList?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . $_GET['m'] . '#SFR');
    }


    function addProduct(Request $request)
    {
        $product = new Product();
        $product = $product->SetConnection('mysql2');
        $product->p_name        = $request->product_name;
        $product->acc_id        = $request->acc_id;
        $product->type_id        = $request->type_id;
        $product->p_status           = 1;
        $product->p_username         = Auth::user()->name;
        $product->p_date             = date('Y-m-d');
        $product->save();
        $product_id = $product->product_id;
        $account_head = $request->acc_id;
        $PName = str_replace('"', "'", $request->product_name);;
        $max_id = DB::Connection('mysql2')->selectOne('SELECT max(`id`) as id  FROM `accounts` WHERE `parent_code` LIKE \'' . $account_head . '\'')->id;
        if ($max_id == '') {
            $code = $account_head . '-1';
        } else {
            $max_code2 = DB::Connection('mysql2')->selectOne('SELECT `code`  FROM `accounts` WHERE `id` LIKE \'' . $max_id . '\'')->code;
            $max_code2;
            $max = explode('-', $max_code2);
            $code = $account_head . '-' . (end($max) + 1);
        }

        $level_array = explode('-', $code);
        $counter = 1;
        foreach ($level_array as $level) :
            $data1['level' . $counter] = strip_tags($level);
            $counter++;
        endforeach;
        $data1['code'] = strip_tags($code);
        $data1['name'] = strip_tags($PName);
        $data1['parent_code'] = strip_tags($account_head);
        $data1['username'] = Auth::user()->name;
        $data1['date'] = date("d-m-Y");
        $data1['time'] = date("H:i:s");
        $data1['action'] = 'create';
        $data1['type'] = 4;
        $data1['operational'] = 1;
        $acc_id = DB::Connection('mysql2')->table('accounts')->insertGetId($data1);


        $data5['acc_id'] = $acc_id;
        $data5['acc_head'] = $account_head;
        DB::Connection('mysql2')->table('product')->where('product_id', $product_id)->update($data5);

        $data3['acc_id'] = strip_tags($acc_id);
        $data3['acc_code'] = strip_tags($code);
        $data3['debit_credit'] = 0;
        $data3['amount'] = 0;
        $data3['opening_bal'] = 1;
        $data3['username'] = Auth::user()->name;
        $data3['date'] = date("d-m-Y");
        $data3['v_date'] = date("d-m-Y");

        $data3['action'] = 'create';
        DB::Connection('mysql2')->table('transactions')->insert($data3);
        return Redirect::to('purchase/viewProduct?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . Input::get('m') . '#SFR');
    }

    function addSurveyDetail(Request $request)
    {
        $max_tracking_no = DB::Connection('mysql2')->table('survey')->select('tracking_no')->max('tracking_no');
        $max_tracking_no = $max_tracking_no + 1;
        $max_tracking_no = sprintf("%'03d", $max_tracking_no);
        //print_r($_POST);
        $survey = new Survey();
        $survey = $survey->SetConnection('mysql2');
        $survey->branch_name      = $request->branchName;
        $survey->contact_person   = $request->contactPerson;
        $survey->contact_number   = $request->contactNumber;
        $survey->survey_date      = $request->surveyDate;
        $survey->status           = 1;
        $survey->tracking_no           = $max_tracking_no;
        $survey->client_id           = $request->client;
        $survey->survery_by_id           = $request->surveryby;
        $survey->surveyor_name           = $request->surveyor_name;
        $survey->branch_name           = $request->branch;
        $survey->branch_id           = $request->BranchId;
        $survey->region_id        = $request->region_id;
        $survey->city_id          = $request->city_id;
        $survey->username         = Auth::user()->name;
        $survey->date             = date('Y-m-d');
        $survey->save();
        $survey_id = $survey->survey_id;

        $demandDataSection = $request->demandDataSection_1;
        $count = 1;
        foreach ($demandDataSection as $row) :
            $MultiConditions = '';
            $surveydata = new SurveyData();
            $surveydata = $surveydata->SetConnection('mysql2');
            $surveydata->product        = $request->input('product_' . $count);
            $surveydata->type_id        = $request->input('type_' . $count);
            $surveydata->qty        = $request->input('qty_' . $count);
            $surveydata->height         = $request->input('height_' . $count);
            $surveydata->width          = $request->input('width_' . $count);
            $surveydata->depth          = $request->input('depth_' . $count);
            foreach ($request->input('condition_' . $count) as $value) {
                $MultiConditions .= $value . '@#';
            }
            $MultiConditions = rtrim($MultiConditions, '@#');
            $surveydata->condition_id   = $MultiConditions;
            $surveydata->remarks        = $request->input('remarks_' . $count);
            $surveydata->survey_id      = $survey_id;
            $surveydata->status         = 1;
            $surveydata->username       = Auth::user()->name;
            $surveydata->date           = date('Y-m-d');
            $surveydata->save();

            $count++;
        endforeach;
        $ImageCounter = $request->ImageCounter;
        foreach ($ImageCounter as $row) :
            if ($request->file('input_img_' . $row)) :
                $file_name = $survey_id . '' . $row . 'survey' . time() . '.' . $request->file('input_img_' . $row)->extension();
                $path = $request->file('input_img_' . $row)->storeAs('uploads/products', $file_name);
                $surveydocumnet = new SurveyDocument();
                $surveydocumnet = $surveydocumnet->SetConnection('mysql2');
                $surveydocumnet->image_file   = $path;
                $surveydocumnet->survey_id = $survey_id;
                $surveydocumnet->status       = 1;
                $surveydocumnet->save();
            else :
                $path = '';

            endif;


        endforeach;

        $voucher_no     = $max_tracking_no;
        $voucher_date   = $request->surveyDate;
        $action_type    = 1;
        $client_id      = $request->client;
        $table_name     = "survey";

        CommonHelper::logActivity($voucher_no, $voucher_date, $action_type, $client_id, $table_name);

        return Redirect::to('sales/surveylist?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . Input::get('m') . '#SFR');
    }

    function updateSurveyDetail(Request $request)
    {
        $EditId = $request->EditId;
        //print_r($_POST);
        $survey = new Survey();
        $survey = $survey->SetConnection('mysql2');
        //$SurveyUpdate['']
        $SurveyUpdate['branch_name']      = $request->branchName;
        $SurveyUpdate['contact_person']   = $request->contactPerson;
        $SurveyUpdate['contact_number']   = $request->contactNumber;
        $SurveyUpdate['survey_date']      = $request->surveyDate;
        $SurveyUpdate['status']           = 1;
        $SurveyUpdate['client_id']           = $request->client;
        $SurveyUpdate['survery_by_id']           = $request->surveryby;
        $SurveyUpdate['surveyor_name']           = $request->surveyor_name;
        $SurveyUpdate['branch_name']           = $request->branch;
        $SurveyUpdate['branch_id']           = $request->BranchId;
        $SurveyUpdate['region_id']        = $request->region_id;
        $SurveyUpdate['city_id']          = $request->city_id;
        $SurveyUpdate['username']         = Auth::user()->name;



        DB::Connection('mysql2')->table('survey')->where('survey_id', $EditId)->update($SurveyUpdate);
        DB::Connection('mysql2')->table('survey_data')->where('survey_id', $EditId)->delete();


        $demandDataSection = $request->demandDataSection_1;
        $count = 1;
        foreach ($demandDataSection as $row) :
            $MultiConditions = '';
            $surveydata = new SurveyData();
            $surveydata = $surveydata->SetConnection('mysql2');
            $surveydata->product        = $request->input('product_' . $count);
            $surveydata->type_id        = $request->input('type_' . $count);
            $surveydata->qty        = $request->input('qty_' . $count);
            $surveydata->height         = $request->input('height_' . $count);
            $surveydata->width          = $request->input('width_' . $count);
            $surveydata->depth          = $request->input('depth_' . $count);
            foreach ($request->input('condition_' . $count) as $value) {
                $MultiConditions .= $value . '@#';
            }
            $MultiConditions = rtrim($MultiConditions, '@#');
            $surveydata->condition_id   = $MultiConditions;
            $surveydata->remarks        = $request->input('remarks_' . $count);
            $surveydata->survey_id      = $EditId;
            $surveydata->status         = 1;
            $surveydata->username       = Auth::user()->name;
            $surveydata->date           = date('Y-m-d');
            $surveydata->save();

            $count++;
        endforeach;
        DB::Connection('mysql2')->table('survey_document')->where('survey_id', $EditId)->delete();
        $ImageCounter = $request->ImageCounter;
        foreach ($ImageCounter as $row) :
            if ($request->file('input_img_' . $row)) :
                $file_name = $EditId . '' . $row . 'SK' . rand(11111, 99999) . '' . $request->file('input_img_' . $row)->getClientOriginalName();
                $path = $request->file('input_img_' . $row)->storeAs('uploads/products', $file_name);
            else :
                if ($request->post('exist_img_' . $row)) {
                    $path = 'uploads/products/' . $request->post('exist_img_' . $row);
                } else {
                    $path = "null";
                }
            endif;
            if ($path == 'null') {
                //echo $row;
            } else {
                $surveydocumnet = new SurveyDocument();
                $surveydocumnet = $surveydocumnet->SetConnection('mysql2');
                $surveydocumnet->image_file = $path;
                $surveydocumnet->survey_id = $EditId;
                $surveydocumnet->status = 1;
                $surveydocumnet->save();
            }

        endforeach;

        $voucher_no     = $request->tracking_no;
        $voucher_date   = $request->surveyDate;
        $action_type    = 2;
        $client_id      = $request->client;
        $table_name     = "survey";

        CommonHelper::logActivity($voucher_no, $voucher_date, $action_type, $client_id, $table_name);

        return Redirect::to('sales/surveylist?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . Input::get('m') . '#SFR');
    }

    function addJobOrder(Request $request)
    {

        $skip = $request->estimate;
        $job_order_no = SalesHelper::get_unique_no_job_order(date('y'), date('m'));
        $joborder = new JobOrder();
        $joborder = $joborder->SetConnection('mysql2');
        $joborder->date_ordered = $request->date_ordered;
        $joborder->approval_date = $request->approval_date;
        $joborder->due_date = $request->due_date;
        $joborder->completion_date = $request->completion_date;
        $joborder->job_order_no = $job_order_no;

        $joborder->invoice_no       = $request->invoice_no;
        $joborder->invoice_date     = $request->invoice_date;
        $joborder->ordered_by       = $request->ordered_by;
        $joborder->client_name      = $request->client_name;
        $joborder->branch_id      = $request->BranchId;
        $joborder->client_address   = $request->client_address;
        $joborder->client_job       = $request->client_job;
        $joborder->job_description  = $request->job_description;
        $joborder->job_location     = $request->job_location;
        $joborder->address          = $request->address;
        $joborder->contact_person   = $request->contact_person;
        $joborder->contact_no       = $request->contact_no;
        $joborder->quotation_id     = $request->main_id;
        $joborder->region_id        = $request->region_id;
        $joborder->status           = 1;
        $joborder->type             = $request->type;
        $joborder->username         = Auth::user()->name;
        $joborder->date             = date('Y-m-d');
        $joborder->installed        = $request->installed;
        //        $joborder->prepared         = $request->prepared;
        //        $joborder->checked          = $request->checked;
        //        $joborder->approved         = $request->approved;
        $joborder->save();
        $master_id = $joborder->job_order_id;

        $job_order_dataa = $request->demandDataSection_1;


        //  $count = 1;
        foreach ($job_order_dataa as  $row) :

            $joborderdata = new JobOrderData();
            $joborderdata = $joborderdata->SetConnection('mysql2');
            $joborderdata->job_order_no = $job_order_no;
            $joborderdata->product      = $request->input('product_1_' . $row);
            $joborderdata->type_id      = $request->input('type_1_' . $row);
            $joborderdata->uom_id      = $request->input('uom_1_' . $row);
            $joborderdata->width        = $request->input('width_1_' . $row);
            $joborderdata->height       = $request->input('height_1_' . $row);
            $joborderdata->depth        = $request->input('depth_1_' . $row);
            $joborderdata->quantity     = $request->input('qty_1_' . $row);
            $joborderdata->description  = $request->input('description_1_' . $row);

            $joborderdata->quotation_data_id  = $request->input('q_data_id_1_' . $row);
            $joborderdata->survery_data_id  = $request->input('survery_data_id_1_' . $row);


            $joborderdata->job_order_id = $master_id;
            $joborderdata->status       = 1;
            $joborderdata->username     = Auth::user()->name;
            $joborderdata->date         = date('Y-m-d');
            $joborderdata->save();

        //   $count++;
        endforeach;
        //Upload Document
        $ImageCounter = $request->ImageCounter;
        foreach ($ImageCounter as $row) :
            if ($request->file('input_img_' . $row)) :
                $file_name = $master_id . '' . $row . 'JobOrder' . time() . '.' . $request->file('input_img_' . $row)->extension();
                $path = $request->file('input_img_' . $row)->storeAs('uploads/job_order_document', $file_name);
            else :
                $path = '';
            endif;

            $jobOrderDocument = new JobOrderDocument();
            $jobOrderDocument = $jobOrderDocument->SetConnection('mysql2');
            $jobOrderDocument->image_file   = $path;
            $jobOrderDocument->job_order_id = $master_id;
            $jobOrderDocument->status       = 1;
            $jobOrderDocument->save();
        endforeach;
        //Upload Document
        $m = $request->CompanyId;
        $type = 0;
        //   return view('Purchase.AjaxPages.job_order_next_step', compact('master_id','m','type'));

        $voucher_no     = $job_order_no;
        $voucher_date   = $request->date_ordered;
        $action_type    = 1;
        $client_id      = $request->client_name;
        $table_name     = "job_order";
        CommonHelper::logActivity($voucher_no, $voucher_date, $action_type, $client_id, $table_name);


        $region_id = $request->region_id;
        if ($skip == '') :
            return Redirect::to('purchase/job_order_next_step?master_id=' . $master_id . '&&region_id=' . $region_id . '&&m=' . $m . '');
        else :
            return Redirect::to('purchase/viewJobOrder?pageType=view&&parentCode=00&&m=1');
        endif;
    }

    function updateJobOrderDetail(Request $request)
    {

        //        echo "<pre>";
        //        print_r($_POST); die;

        //$skip= $request->estimate;
        //$job_order_no = SalesHelper::get_unique_no_job_order(date('y'),date('m'));
        $joborder = new JobOrder();
        $joborder = $joborder->SetConnection('mysql2');

        $JoUpdate['date_ordered'] = $request->date_ordered;
        $JoUpdate['approval_date'] = $request->approval_date;
        $JoUpdate['due_date'] = $request->due_date;
        $JoUpdate['completion_date'] = $request->completion_date;

        $JoUpdate['invoice_no']       = $request->invoice_no;
        $JoUpdate['invoice_date']     = $request->invoice_date;
        $JoUpdate['ordered_by']       = $request->ordered_by;
        $JoUpdate['client_name']    = $request->client_name;
        $JoUpdate['branch_id']    = $request->BranchId;
        $JoUpdate['client_address'] = $request->client_address;
        $JoUpdate['client_job']     = $request->client_job;
        $JoUpdate['job_description']  = $request->job_description;
        $JoUpdate['job_location']     = $request->job_location;
        $JoUpdate['address']          = $request->address;
        $JoUpdate['contact_person']   = $request->contact_person;
        $JoUpdate['contact_no']       = $request->contact_no;
        $JoUpdate['quotation_id']       = $request->main_id;
        $JoUpdate['region_id']       = $request->region_id;
        $JoUpdate['status']           = 1;
        $JoUpdate['type']             = $request->type;
        $JoUpdate['username']         = Auth::user()->name;
        $JoUpdate['updated_date']     = date('Y-m-d');
        DB::Connection('mysql2')->table('job_order')->where('job_order_id', $request->EditId)->update($JoUpdate);

        $master_id = $request->EditId;

        $job_order_dataa = $request->demandDataSection_1;
        $count = 1;
        foreach ($job_order_dataa as $row) :
            $job_order_data_id = $request->input('job_order_data_id_' . $row);

            $joborderdata = new JobOrderData();
            $joborderdata = $joborderdata->SetConnection('mysql2');
            if ($job_order_data_id != "") {
                $joborderdata = $joborderdata->find($job_order_data_id);
            } else {
            }


            $joborderdata->product      = $request->input('product_1_' . $row);
            $joborderdata->job_order_no      = $request->job_order_no;
            $joborderdata->type_id      = $request->input('type_1_' . $row);
            $joborderdata->uom_id      = $request->input('uom_1_' . $row);
            $joborderdata->width        = $request->input('width_1_' . $row);
            $joborderdata->height       = $request->input('height_1_' . $row);
            $joborderdata->depth        = $request->input('depth_1_' . $row);
            $joborderdata->quantity     = $request->input('qty_1_' . $row);
            $joborderdata->description  = $request->input('description_1_' . $row);
            $joborderdata->quotation_data_id  = $request->input('q_data_id_1_' . $row);
            $joborderdata->survery_data_id  = $request->input('survery_data_id_1_' . $row);
            $joborderdata->job_order_id = $master_id;
            $joborderdata->status       = 1;
            $joborderdata->username     = Auth::user()->name;
            $joborderdata->date         = date('Y-m-d');
            $joborderdata->save();

            $job_order_data_id = "";
            $count++;
        endforeach;

        DB::Connection('mysql2')->table('job_order_document')->where('job_order_id', $master_id)->delete();
        $ImageCounter = $request->ImageCounter;
        if (!empty($ImageCounter)) :
            foreach ($ImageCounter as $row) :
                if ($request->file('input_img_' . $row)) :
                    $file_name = $master_id . '' . $row . 'Amir' . rand(11111, 99999) . '' . $request->file('input_img_' . $row)->getClientOriginalName();
                    $path = $request->file('input_img_' . $row)->storeAs('uploads/job_order_document', $file_name);
                else :
                    if ($request->post('exist_img_' . $row)) {
                        $path = $request->post('exist_img_' . $row);
                    } else {
                        $path = "null";
                    }
                endif;
                if ($path == 'null') {
                    //echo $row;
                } else {
                    $jobOrderDocument = new JobOrderDocument();
                    $jobOrderDocument = $jobOrderDocument->SetConnection('mysql2');
                    $jobOrderDocument->image_file   = $path;
                    $jobOrderDocument->job_order_id = $master_id;
                    $jobOrderDocument->status       = 1;
                    $jobOrderDocument->save();
                }

            endforeach;
        endif;

        //Upload Document
        $m = $request->CompanyId;
        $type = 0;
        //   return view('Purchase.AjaxPages.job_order_next_step', compact('master_id','m','type'));

        $voucher_no     = $request->job_order_no;
        $voucher_date   = $request->date_ordered;
        $action_type    = 2;
        $client_id      = $request->client_name;
        $table_name     = "job_order";

        CommonHelper::logActivity($voucher_no, $voucher_date, $action_type, $client_id, $table_name);


        $region_id = $request->region_id;
        //if ($skip==''):
        //  return Redirect::to('purchase/job_order_next_step_edit?master_id='.$master_id.'&&region_id='.$region_id.'&&m='.$m.'');
        //else:
        return Redirect::to('purchase/viewJobOrder?pageType=view&&parentCode=00&&m=1');
        //endif;
    }

    function addJobOrderNextStepUpdate(Request $request)
    {
        //echo "<pre>";
        //print_r($_POST); die;
        $counters = $request->counter;
        foreach ($counters as $counter) {
            $job_order_data_id = $request->input('job_order_data_id' . $counter);
            $item = $request->input('item_' . $counter);
            DB::Connection('mysql2')->table('estimate')->where('job_order_data_id', $job_order_data_id)->delete();
            foreach ($item as $key => $row) {
                $Estimate = new Estimate();
                $Estimate = $Estimate->SetConnection('mysql2');
                $Estimate->item             = $request->input('item_' . $counter)[$key];
                $Estimate->qty              = $request->input('qty_' . $counter)[$key];
                $Estimate->uom              = 1; //$request->input('uom_'.$counter)[$key];
                $Estimate->stock_value      = 1; //$request->input('stock_value_'.$counter)[$key];
                $Estimate->job_order_data_id = $job_order_data_id;
                $Estimate->region_id =  $request->region_id;
                $Estimate->status           = 1;
                $Estimate->username         = Auth::user()->name;
                $Estimate->date             = date('Y-m-d');
                $Estimate->save();
            }
        }
        return Redirect::to('purchase/viewJobOrder?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . Input::get('m') . '#SFR');
    }

    function addJobOrderNextStep(Request $request)
    {
        //        echo "<pre>";
        //        print_r($_POST);
        $counters = $request->counter;
        foreach ($counters as $counter) {
            $job_order_data_id = $request->input('job_order_data_id' . $counter);
            $item = $request->input('item_' . $counter);

            foreach ($item as $key => $row) {

                $Estimate = new Estimate();
                $Estimate = $Estimate->SetConnection('mysql2');
                $Estimate->item             = $request->input('item_' . $counter)[$key];
                $Estimate->qty              = $request->input('qty_' . $counter)[$key];
                $Estimate->uom              = 1; //$request->input('uom_'.$counter)[$key];
                $Estimate->stock_value      = 1; //$request->input('stock_value_'.$counter)[$key];
                $Estimate->job_order_data_id = $job_order_data_id;
                $Estimate->region_id =  $request->region_id;
                $Estimate->status           = 1;
                $Estimate->username         = Auth::user()->name;
                $Estimate->date             = date('Y-m-d');
                $Estimate->save();
            }
        }
        return Redirect::to('purchase/viewJobOrder?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . Input::get('m') . '#SFR');
    }

    function createPurchaseVoucher(Request $request)
    {
        $cn = DB::connection('mysql2');
        $cn->beginTransaction();
        $str = DB::connection('mysql2')->selectOne("select count(id)id from purchase_voucher where status=1 and purchase_date='" . Input::get('purchase_date') . "'")->id;
        $pv_no = 'pv' . ($str + 1);
        $total_salesTax = str_replace('%', '', $request->total_salesTax);
        $purchase_voucher = new PurchaseVoucher();
        $purchase_voucher = $purchase_voucher->SetConnection('mysql2');
        $purchase_voucher->pv_no = $pv_no;
        $purchase_voucher->slip_no = $request->slip_no;
        $purchase_voucher->purchase_date = $request->purchase_date;
        $purchase_voucher->bill_date = $request->bill_date;
        $purchase_voucher->purchase_type = $request->p_type;
        $purchase_voucher->current_amount = $request->current_amount;
        $purchase_voucher->amount_in_words = $request->rupeess;
        $purchase_voucher->due_date = $request->due_date;
        $purchase_voucher->supplier = $request->supplier;
        $purchase_voucher->total_qty = $request->total_qty;
        $purchase_voucher->total_rate = $request->total_rate;
        $purchase_voucher->total_amount = $request->total_amount;

        $purchase_voucher->total_salesTax_amount = $request->total_salesTax_amount;
        $purchase_voucher->total_net_amount = $request->total_net_amount;
        $purchase_voucher->username = Auth::user()->name;
        $purchase_voucher->date = date('Y-m-d');
        $purchase_voucher->description = $request->description;
        $purchase_voucher->pv_date = $request->purchase_date;
        $purchase_voucher->pv_no = $pv_no;
        $currency = $request->curren;
        $purchase_voucher->payment_id = $request->payment_id;
        $currency = explode(',', $currency);
        $purchase_voucher->currency = $currency[0];
        $payment_advnavce = $request->payment_id;
        $payment_advnavce = explode(',', $payment_advnavce);
        $payment_advnavce = $payment_advnavce[0];
        $purchase_voucher->payment_id = $payment_advnavce;

        if ($payment_advnavce != 0) :
            $purchase_voucher->through_advance = 1;

            $adv_amount = $request->adv_amount;
            $total_net_amount = $request->total_net_amount;
            $adv_amount =    str_replace(',', '', $adv_amount);
            if ($adv_amount == $total_net_amount) :
                $purchase_voucher->pv_status = 3;
            endif;

        endif;
        $purchase_voucher->save();
        $master_id = $purchase_voucher->id;



        if ($payment_advnavce != 0) :
            $data['advance_paid'] = 2;
            $data['purchase_id'] = $master_id;
            DB::Connection('mysql2')->table('pvs')->where('id', $payment_advnavce)->update($data);
        endif;

        $purchase_voucher_dataa = $request->demandDataSection_1;

        $count = 1;
        foreach ($purchase_voucher_dataa as $row) :

            $purchase_voucher_data = new PurchaseVoucherData();
            $purchase_voucher_data = $purchase_voucher_data->SetConnection('mysql2');
            $request->input('sales_tax_amount_1_' . $count);
            $purchase_voucher_data->master_id = $master_id;
            $purchase_voucher_data->pv_no = $pv_no;
            $purchase_voucher_data->category_id = $request->input('category_id_1_' . $count);;
            $purchase_voucher_data->sub_item = $request->input('sub_item_id_1_' . $count);;

            $purchase_voucher_data->uom = $request->input('uom_id_1_' . $count);;
            $purchase_voucher_data->qty = $request->input('qty_1_' . $count);;
            $purchase_voucher_data->rate = $request->input('rate_1_' . $count);;
            $purchase_voucher_data->amount = str_replace(',', '', $request->input('amount_1_' . $count));
            $purchase_voucher_data->sales_tax_per = $request->input('accounts_1_' . $count);
            $purchase_voucher_data->sales_tax_amount = $request->input('sales_tax_amount_1_' . $count);
            $purchase_voucher_data->net_amount = $request->input('net_amount_1_' . $count);;

            $purchase_voucher_data->txt_nature = $request->input('txt_nature_1_' . $count);;
            $purchase_voucher_data->income_txt_nature = $request->input('income_txt_nature_1_' . $count);;

            $purchase_voucher_data->username = Auth::user()->name;
            $purchase_voucher_data->date = date('Y-m-d');
            $purchase_voucher->pv_no = $pv_no;
            $purchase_voucher_data->save();
            $other_id = $purchase_voucher_data->id;


            $trans = new Transactions();
            $trans = $trans->SetConnection('mysql2');
            $account = $request->input('category_id_1_' . $count);
            //    $account=CommonHelper::get_item_acc_id($sub_ic_id);

            $trans->acc_id = $account;
            $trans->acc_code = FinanceHelper::getAccountCodeByAccId($account, '');;
            $trans->master_id = $master_id;
            $trans->particulars = $request->description;
            $trans->opening_bal = 0;
            $trans->debit_credit = 1;
            $trans->amount = str_replace(',', '', $request->input('amount_1_' . $count));;
            $trans->voucher_no = $pv_no;
            $trans->voucher_type = 4;
            $trans->v_date = $request->purchase_date;
            $trans->date = date('Y-m-d');
            $trans->action = 1;
            $trans->username = Auth::user()->name;
            $trans->save();

            // for tax
            if ($request->input('accounts_1_' . $count) != 0) :
                $trans1 = new Transactions();
                $trans1 = $trans1->SetConnection('mysql2');
                $account = $request->input('accounts_1_' . $count);
                $trans1->acc_id = $account;
                $trans1->acc_code = FinanceHelper::getAccountCodeByAccId($account, '');;
                $trans1->master_id = $master_id;
                $trans1->particulars = $request->description;
                $trans1->opening_bal = 0;
                $trans1->debit_credit = 1;
                $trans1->amount = str_replace(',', '', $request->input('sales_tax_amount_1_' . $count));;
                $trans1->voucher_no = $pv_no;
                $trans1->voucher_type = 4;
                $trans1->v_date = $request->purchase_date;
                $trans1->date = date('Y-m-d');
                $trans1->action = 1;
                $trans1->username = Auth::user()->name;
                $trans1->save();
            endif;
            // end for tax

            // for department

            $allow_null = $request->input('dept_check_box' . $count);
            if ($allow_null == 0) :
                $department1 = $request->input('department' . $count);
                $counter = 0;
                foreach ($department1 as $row1) :
                    $dept_allocation1 = new DepartmentAllocation1();
                    $dept_allocation1 = $dept_allocation1->SetConnection('mysql2');
                    $dept_allocation1->Main_master_id = $master_id;
                    $dept_allocation1->master_id = $other_id;
                    $dept_allocation1->pv_no = $pv_no;
                    $dept_allocation1->dept_id = $row1;
                    $perccent = $request->input('percent' . $count);
                    $dept_allocation1->percent = $perccent[$counter];
                    $amount = $request->input('department_amount' . $count);
                    $amount = str_replace(",", "", $amount);
                    $dept_allocation1->amount = $amount[$counter];
                    $dept_allocation1->item = $request->input('sub_item_id_1_' . $count);
                    $dept_allocation1->save();
                    $counter++;

                endforeach;
            endif;

            // end for department


            // for sales tax department

            $allow_null = $request->input('sales_tax_check_box' . $count);
            if ($allow_null == 0) :
                $sales_tax_department = $request->input('sales_tax_department' . $count);
                $counter = 0;
                foreach ($sales_tax_department as $row2) :
                    if ($row2 != 0) :
                        $salestaxdepartment = new SalesTaxDepartmentAllocation();
                        $salestaxdepartment = $salestaxdepartment->SetConnection('mysql2');
                        $salestaxdepartment->Main_master_id = $master_id;
                        $salestaxdepartment->master_id = $other_id;
                        $salestaxdepartment->pv_no = $pv_no;
                        $salestaxdepartment->dept_id = $row2;
                        $perccent = $request->input('sales_tax_percent' . $count);
                        $salestaxdepartment->percent = $perccent[$counter];
                        $amount = $request->input('sales_tax_department_amount' . $count);
                        $amount = str_replace(",", "", $amount);
                        $salestaxdepartment->amount = $amount[$counter];
                        $salestaxdepartment->sales_tax = $request->input('accounts_1_' . $count);

                        $salestaxdepartment->save();
                    endif;
                    $counter++;

                endforeach;
            endif;

            // End for sales tax department


            // for Cost center department

            $allow_null = $request->input('cost_center_check_box' . $count);
            if ($allow_null == 0) :
                $sales_tax_department = $request->input('cost_center_department' . $count);
                $counter = 0;
                foreach ($sales_tax_department as $row3) :
                    $costcenter = new CostCenterDepartmentAllocation();
                    $costcenter = $costcenter->SetConnection('mysql2');
                    $costcenter->Main_master_id = $master_id;
                    $costcenter->master_id = $other_id;
                    $costcenter->pv_no = $pv_no;
                    $costcenter->dept_id = $row3;
                    $perccent = $request->input('cost_center_percent' . $count);
                    $costcenter->percent = $perccent[$counter];
                    $amount = $request->input('cost_center_department_amount' . $count);
                    $amount = str_replace(",", "", $amount);
                    if ($amount[$counter] != '') :
                        $costcenter->amount = $amount[$counter];
                    endif;
                    $costcenter->item = $request->input('sub_item_id_1_' . $count);
                    $costcenter->save();
                    $counter++;

                endforeach;
            endif;

            // End for Cost center department


            $count++;
        endforeach;


        $trans2 = new Transactions();
        $trans2 = $trans2->SetConnection('mysql2');
        $account = CommonHelper::get_supplier_acc_id($request->supplier);
        $trans2->acc_id = $account;
        $trans2->acc_code = FinanceHelper::getAccountCodeByAccId($account, '');;
        $trans2->master_id = $master_id;
        $trans2->particulars = $request->description;
        $trans2->opening_bal = 0;
        $trans2->debit_credit = 0;
        $trans2->amount = $request->total_net_amount;
        $trans2->voucher_no = $pv_no;
        $trans2->voucher_type = 4;
        $trans2->v_date = $request->purchase_date;
        $trans2->date = date('Y-m-d');
        $trans2->action = 1;
        $trans2->username = Auth::user()->name;

        $trans2->save();

        $cn->rollBack();
        //  return Redirect::to('purchase/createPurchaseVoucherForm?pageType=add&&parentCode=80&&m=1');
        return Redirect::to('pdc/viewPurchaseVoucherDetailAfterSubmit/' . $master_id);
    }


    public function addDemandTypeDetail(Request $request)
    {
        $name = $request->demand_type;
        $demand_type = new DemandType();
        $demand_type = $demand_type->SetConnection('mysql2');
        $demand_type_count = $demand_type->where('status', 1)->where('name', $name)->count();
        if ($demand_type_count > 0) :
            Session::flash('dataDelete', $name . ' ' . 'Already Exists.');
            return Redirect::to('purchase/createDemandTypeForm?pageType=add&&parentCode=82&&m=1#SFR');
        else :

            $demand_type->name = $name;
            $demand_type->username = Auth::user()->name;
            $demand_type->date = date('Y-m-d');
            $demand_type->save();
            Session::flash('dataInsert', 'successfully saved.');
            return Redirect::to('purchase/createDemandTypeForm?pageType=add&&parentCode=82&&m=1#SFR');
        endif;
    }

    public function addWareHouseDetail(Request $request)
    {
        $name = $request->warehouse;
        $warehouse = new Warehouse();
        $warehouse = $warehouse->SetConnection('mysql2');
        $warehouse_count = $warehouse->where('status', 1)->where('name', $name)->count();
        if ($warehouse_count > 0) :
            Session::flash('dataDelete', $name . ' ' . 'Already Exists.');
            return Redirect::to('purchase/createWarehouseForm?pageType=add&&parentCode=82&&m=1#SFR');
        else :

            $warehouse->name = $name;
            $warehouse->username = Auth::user()->name;
            $warehouse->date = date('Y-m-d');
            $warehouse->save();
            Session::flash('dataInsert', 'successfully saved.');
            return Redirect::to('purchase/createWarehouseForm?pageType=add&&parentCode=82&&m=1#SFR');
        endif;
    }

    public function addDirectGrnForm()
    {
        //        echo "<pre>";
        //        print_r($_POST); die;
        $m = $_GET['m'];
        CommonHelper::companyDatabaseConnection($_GET['m']);

        $str = DB::selectOne("select max(convert(substr(`grn_no`,4,length(substr(`grn_no`,4))-4),signed integer)) reg from `goods_receipt_note` where substr(`grn_no`,-4,2) = " . date('m') . " and substr(`grn_no`,-2,2) = " . date('y') . "")->reg;
        $grn_no = 'grn' . ($str + 1) . date('my');

        $subDepartmentId = strip_tags(Input::get('subDepartmentId'));
        $supplierId = strip_tags(Input::get('supplier_id'));
        $invoice_no = strip_tags(Input::get('invoice_no'));
        $grn_date = strip_tags(Input::get('grn_date'));
        $bill_date = strip_tags(Input::get('bill_date'));
        $main_description = strip_tags(Input::get('main_description'));
        $delivery_challan_no = strip_tags(Input::get('del_chal_no'));
        $delivery_vehicale = strip_tags(Input::get('del_detail'));
        $warehouse = strip_tags(Input::get('warehouse_id'));

        $data1['grn_no'] = $grn_no;
        $data1['grn_date'] = $grn_date;
        $data1['bill_date'] = $bill_date;

        $data1['sub_department_id'] = $subDepartmentId;
        $data1['supplier_id'] = $supplierId;
        $data1['main_description'] = $main_description;
        $data1['supplier_invoice_no'] = $invoice_no;
        $data1['delivery_challan_no'] = $delivery_challan_no;
        $data1['delivery_detail'] = $delivery_vehicale;
        $data1['warehouse'] = $warehouse;
        $data1['date'] = date("d-m-Y");
        $data1['time'] = date("H:i:s");
        $data1['type'] = 2;
        $data1['username'] = Auth::user()->name;

        $master_id = DB::table('goods_receipt_note')->insertGetId($data1);

        $seletedPurchaseRequestRow = Input::get('demandDataSection_1');
        foreach ($seletedPurchaseRequestRow as $i) {
            $demandSendType = strip_tags(Input::get('demand_type_id_1_' . $i . ''));
            $category_id = strip_tags(Input::get('category_id_1_' . $i . ''));
            $sub_item_id = strip_tags(Input::get('sub_item_id_1_' . $i . ''));
            $purchase_recived_qty = str_replace(',', '', Input::get('qty_1_' . $i));
            $rate = str_replace(',', '', Input::get('rate_1_' . $i));
            $amount = str_replace(',', '', Input::get('amount_1_' . $i));

            $remarks = strip_tags(Input::get('description_1_' . $i . ''));
            $manufac_date = strip_tags(Input::get('maufac_date_1_' . $i . ''));
            $expiry_date = strip_tags(Input::get('expiry_date_1_' . $i . ''));
            $batch_no = strip_tags(Input::get('batch_no_1_' . $i . ''));
            $no_pack = strip_tags(Input::get('no_pack_per_item_1_' . $i . ''));
            $gross = strip_tags(Input::get('gross_1_' . $i . ''));
            $net = strip_tags(Input::get('net_1_' . $i . ''));
            $subTotal = strip_tags(Input::get('purchase_request_sub_total_' . $i . ''));
            $receivedQty = strip_tags(Input::get('received_qty_' . $i . ''));
            $region = strip_tags(Input::get('region_1_' . $i . ''));

            $data2['demand_send_type'] = $demandSendType;
            $data2['master_id'] = $master_id;
            $data2['grn_no'] = $grn_no;
            $data2['grn_date'] = $grn_date;
            $data2['category_id'] = $category_id;
            $data2['sub_item_id'] = $sub_item_id;
            //$data2['purchase_approved_qty'] = $purchase_approved_qty;
            $data2['purchase_recived_qty'] = $purchase_recived_qty;
            $data2['rate'] = $rate;
            $data2['amount'] = $amount;
            //   $data2['bal_reciable'] = $balance_qty_recived;
            $data2['remarks'] = $remarks;
            $data2['manufac_date'] = $manufac_date;
            $data2['expiry_date'] = $expiry_date;
            $data2['batch_no'] = $batch_no;
            $data2['no_pkg_item'] = $no_pack;
            $data2['net_item'] = $net;
            $data2['gross_item'] = $gross;
            // $data2['rate'] = $rate;
            //    $data2['rate'] = $rate;
            //   $data2['subTotal'] = $subTotal;
            // $data2['receivedQty'] = $receivedQty;
            $data2['date'] = date("d-m-Y");
            $data2['time'] = date("H:i:s");
            $data2['username'] = Auth::user()->name;
            $data2['region'] = $region;

            DB::table('grn_data')->insert($data2);
        }
        return Redirect::to('purchase/viewGoodsReceiptNoteList?pageType=viewlist&&parentCode=82&&m=1#SFR');
    }

    public function UpdateDirectGrnForm()
    {
        //        echo "<pre>";
        //        print_r($_POST); die;

        $m = $_GET['m'];
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $grn_id = strip_tags(Input::get('grn_id'));
        $grn_no = strtolower(strip_tags(Input::get('grn_no')));
        $grn_date = strip_tags(Input::get('grn_date'));
        $bill_date = strip_tags(Input::get('bill_date'));
        $invoice_no = strip_tags(Input::get('invoice_no'));
        $delivery_challan_no = strip_tags(Input::get('del_chal_no'));
        $delivery_vehicale = strip_tags(Input::get('del_detail'));
        $warehouse = strip_tags(Input::get('warehouse_id'));
        $subDepartmentId = strip_tags(Input::get('subDepartmentId'));
        $supplierId = strip_tags(Input::get('supplier_id'));
        $main_description = strip_tags(Input::get('main_description'));

        $data1['grn_date'] = $grn_date;
        $data1['bill_date'] = $bill_date;
        $data1['sub_department_id'] = $subDepartmentId;
        $data1['supplier_id'] = $supplierId;
        $data1['main_description'] = $main_description;
        $data1['supplier_invoice_no'] = $invoice_no;
        $data1['delivery_challan_no'] = $delivery_challan_no;
        $data1['delivery_detail'] = $delivery_vehicale;
        $data1['warehouse'] = $warehouse;
        $data1['date'] = date("d-m-Y");
        $data1['time'] = date("H:i:s");
        $data1['type'] = 2;
        $data1['username'] = Auth::user()->name;
        DB::table('goods_receipt_note')->where('id', $grn_id)->update($data1);

        DB::table('grn_data')->where('master_id', '=', $grn_id)->delete();

        $seletedPurchaseRequestRow = Input::get('demandDataSection_1');
        foreach ($seletedPurchaseRequestRow as $row) :
            $demandSendType = strip_tags(Input::get('demand_type_id_1_' . $row . ''));
            $region = strip_tags(Input::get('region_1_' . $row . ''));
            $category_id = strip_tags(Input::get('category_id_1_' . $row . ''));
            $sub_item_id = strip_tags(Input::get('sub_item_id_1_' . $row . ''));
            $purchase_recived_qty = str_replace(',', '', Input::get('qty_1_' . $row));
            $rate = str_replace(',', '', Input::get('rate_1_' . $row));
            $amount = str_replace(',', '', Input::get('amount_1_' . $row));
            $remarks = strip_tags(Input::get('description_1_' . $row . ''));
            $manufac_date = strip_tags(Input::get('maufac_date_1_' . $row . ''));
            $expiry_date = strip_tags(Input::get('expiry_date_1_' . $row . ''));
            $batch_no = strip_tags(Input::get('batch_no_1_' . $row . ''));
            $no_pack = strip_tags(Input::get('no_pack_per_item_1_' . $row . ''));
            $gross = strip_tags(Input::get('gross_1_' . $row . ''));
            $net = strip_tags(Input::get('net_1_' . $row . ''));
            $subTotal = strip_tags(Input::get('purchase_request_sub_total_' . $row . ''));
            $receivedQty = strip_tags(Input::get('received_qty_' . $row . ''));

            $data2['demand_send_type'] = $demandSendType;
            $data2['master_id'] = $grn_id;
            $data2['grn_no'] = $grn_no;
            $data2['grn_date'] = $grn_date;
            $data2['category_id'] = $category_id;
            $data2['sub_item_id'] = $sub_item_id;
            $data2['purchase_recived_qty'] = $purchase_recived_qty;
            $data2['rate'] = $rate;
            $data2['amount'] = $amount;
            $data2['remarks'] = $remarks;
            $data2['manufac_date'] = $manufac_date;
            $data2['expiry_date'] = $expiry_date;
            $data2['batch_no'] = $batch_no;
            $data2['no_pkg_item'] = $no_pack;
            $data2['net_item'] = $net;
            $data2['gross_item'] = $gross;
            $data2['date'] = date("d-m-Y");
            $data2['time'] = date("H:i:s");
            $data2['username'] = Auth::user()->name;
            $data2['region'] = $region;
            DB::table('grn_data')->insert($data2);

        endforeach;

        return Redirect::to('purchase/viewGoodsReceiptNoteList?pageType=viewlist&&parentCode=82&&m=1#SFR');
    }

    function addPurchaseVoucherThorughGrn(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
            $demandsSection = $request->demandsSection;
            $SalesTaxAccId = 0;
            $SalesTaxAmount = 0;

            foreach ($demandsSection  as $i) :

                $grnMasterId = explode(',',$request->input('grn_id' . $i));
                // echo "<pre>";
                // print_r(); die;
     
                $dept_id = $request->input('dept_id' . $i);
                $p_type = $request->input('p_type_id' . $i);
                // $good_recipt_not = new GoodsReceiptNote();
                // $good_recipt_not = $good_recipt_not->SetConnection('mysql2');
                // $good_recipt_not = $good_recipt_not->whereIn('id', $grnMasterId)->update(['grn_status'=> 3]); //->get();
                // $po_no = $good_recipt_not->po_no;
                // $good_recipt_not->grn_status = 3;
                // $good_recipt_not->save();

                $supp_acc_id = CommonHelper::get_supplier_acc_id($request->input('supplier_id' . $i));

                $purchase_date = $request->input('purchase_date' . $i);
                $pv_no = CommonHelper::uniqe_no_for_purcahseVoucher(date('y'), date('m'), $request->input('company_location_id' . $i));

                $NewPurchaseVoucher = new NewPurchaseVoucher();
                $NewPurchaseVoucher = $NewPurchaseVoucher->SetConnection('mysql2');
                $NewPurchaseVoucher->pv_no      = $pv_no;
                $NewPurchaseVoucher->pv_date    = $purchase_date;
                $NewPurchaseVoucher->grn_no     = $request->input('grn_no' . $i);
                $NewPurchaseVoucher->grn_id     = $request->input('grn_id' . $i);
                $NewPurchaseVoucher->slip_no    = $request->input('slip_no' . $i);
                $NewPurchaseVoucher->bill_date  = $request->input('bill_date' . $i);
                $NewPurchaseVoucher->due_date   = $request->input('due_date' . $i);
                $NewPurchaseVoucher->purchase_type  = $request->input('p_type' . $i);
                $NewPurchaseVoucher->po_no_date  = $request->input('po_no_date' . $i);
                $NewPurchaseVoucher->company_location_id    = $request->input('company_location_id' . $i);
                $NewPurchaseVoucher->supplier    = $request->input('supplier_id' . $i);
                $bolen = false;

                if ($request->input('SalesTaxesAccId' . $i) != "") {
                    $SalesTaxAccId = $request->input('SalesTaxesAccId' . $i);
                    $SalesTaxPercent = $request->input('SalesTaxPercent' . $i);
                    $SalesTaxAmount = $request->input('SalesTaxAmount' . $i);
                    $bolen = true;
                } else {
                    $SalesTaxAccId = 0;
                    $SalesTaxAccId = 0;
                    $SalesTaxPercent = 0;
                }
                $NewPurchaseVoucher->sales_tax_acc_id = $SalesTaxAccId;
                $NewPurchaseVoucher->sales_tax_percent = $SalesTaxPercent;
                $NewPurchaseVoucher->sales_tax_amount = $SalesTaxAmount;

                $NewPurchaseVoucher->description = $request->input('description' . $i);
                $NewPurchaseVoucher->username    = Auth::user()->name;
                $NewPurchaseVoucher->approved_user  = Auth::user()->name;
                $NewPurchaseVoucher->status      = 1;
                $NewPurchaseVoucher->pv_status   = 1;
                $NewPurchaseVoucher->date        = date('Y-m-d');
                $NewPurchaseVoucher->save();
                $master_id = $NewPurchaseVoucher->id;

                $purchase_voucher_data = $request->input('demandDataSection_' . $i);
                $TotAmount = 0;
                foreach ($purchase_voucher_data as $row) :
                    $NewPurchaseVoucherData = new NewPurchaseVoucherData();
                    $NewPurchaseVoucherData = $NewPurchaseVoucherData->SetConnection('mysql2');
                    $NewPurchaseVoucherData->master_id      = $master_id;
                    $NewPurchaseVoucherData->pv_no          = $pv_no;
                    $NewPurchaseVoucherData->grn_data_id    = $request->input('grn_data_id_1_' . $row);
                    $NewPurchaseVoucherData->category_id    = $request->input('category_id_1_' . $row);
                    $NewPurchaseVoucherData->sub_item       = $request->input('sub_item_id_1_' . $row);
                    $NewPurchaseVoucherData->uom            = $request->input('uom_id_1_' . $row);
                    $NewPurchaseVoucherData->qty            = $request->input('qty_1_' . $row);
                    $NewPurchaseVoucherData->rate           = $request->input('rate_1_' . $row);
                    $NewPurchaseVoucherData->amount         = $request->input('amount' . $row);
                    $NewPurchaseVoucherData->discount_amount         = $request->input('discount_amount' . $row);
                    $NewPurchaseVoucherData->net_amount         = $request->input('net_amount' . $row);
                    $TotAmount += $request->input('net_amount' . $row);
                    $NewPurchaseVoucherData->staus          = 1;
                    $NewPurchaseVoucherData->pv_status      = 2;
                    $NewPurchaseVoucherData->username       = Auth::user()->name;
                    $NewPurchaseVoucherData->date           = date('Y-m-d');
                    $NewPurchaseVoucherData->save();
                    $grnData = GRNData::find($request->input('grn_data_id_1_' . $row));
                    $grnData->grn_status = 3;
                    $grnData->save();
                    
                    $checkGrnStatusCount = DB::Connection('mysql2')->table('grn_data')
                    ->join('goods_receipt_note', 'goods_receipt_note.id', 'grn_data.master_id')
                    ->where('grn_data.grn_status', 2)
                    ->where('grn_data.status', 1)
                    ->where('goods_receipt_note.status', 1)
                    ->where('goods_receipt_note.id', $grnData->master_id)->count();

                    if($checkGrnStatusCount == 0){
                        $good_recipt_not = GoodsReceiptNote::find($grnData->master_id);
                        $good_recipt_not->grn_status = 3;
                        $good_recipt_not->save();
                    }
                endforeach;
                $PvInsertedData = DB::Connection('mysql2')->table('new_purchase_voucher_data')->where('master_id', $master_id)->get();
                foreach ($PvInsertedData as $PvFil) {
                    if ($PvFil->sub_item != 0) :
                        $InsertData['main_id'] = $PvFil->master_id;
                        $InsertData['master_id'] = $PvFil->id;
                        $InsertData['voucher_no'] = $PvFil->pv_no;
                        $InsertData['item_id'] = $PvFil->sub_item;
                        $InsertData['qty'] = $PvFil->qty;
                        $InsertData['amount'] = $PvFil->net_amount;
                        $InsertData['opening'] = 0;
                        $InsertData['status'] = 1;
                        $InsertData['username'] = $PvFil->username;
                        $InsertData['voucher_type'] = 1;
                        DB::Connection('mysql2')->table('transaction_supply_chain')->insert($InsertData);
                    endif;
                }

                $additional_data = $request->input('expense_amount_' . $i);
                if (isset($additional_data)) :

                    foreach ($additional_data  as $key => $row) :


                        $purchase_voucher_data = new NewPurchaseVoucherData();
                        $purchase_voucher_data = $purchase_voucher_data->SetConnection('mysql2');
                        $purchase_voucher_data->master_id      = $master_id;
                        $purchase_voucher_data->category_id = $request->input('acc_id_' . $i)[$key];
                        $purchase_voucher_data->net_amount = $row;
                        $TotAmount += $row;
                        $purchase_voucher_data->additional_exp = 1;
                        $purchase_voucher_data->staus          = 1;
                        $purchase_voucher_data->pv_status      = 2;
                        $purchase_voucher_data->username       = Auth::user()->name;
                        $purchase_voucher_data->save();
                    endforeach;
                endif;


                // $pr_no = DB::Connection('mysql2')->table('purchase_request_data')->where('status', 1)->where('purchase_request_no', $po_no)->value('demand_no');
                // $voucher_no = $pv_no;
                // $subject = 'Purchase Invoice Created For ' . $pr_no;
                // NotificationHelper::send_email('Purchase Invoice', 'Create', $dept_id, $voucher_no, $subject, $p_type);
                ReuseableCode::approvedPVDetail($master_id);
            endforeach;
            CommonHelper::inventory_activity($pv_no, $purchase_date, $TotAmount, 5, 'Insert');
            DB::Connection('mysql2')->commit();
        } catch (\Exception $e) {
            DB::Connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e->getLine(), $e->getMessage(), $e->getTraceAsString());
        }

        return Redirect::to('purchase/viewPurchaseVoucherListThroughGrn?pageType=viewlist&&parentCode=82&&m=1#SFR');
    }

    function addJobTrackingDetails(Request $request)
    {
        //print_r($_POST); die;
        if ($_POST['FormCondition'] == 'Create') {
            $action_type = 1;
            DB::Connection('mysql2')->beginTransaction();
            try {
                $jobtracking = new JobTracking();
                $jobtracking = $jobtracking->SetConnection('mysql2');
                $jobtracking->where('status', 1)->where('job_tracking_no', $_POST['tracking_no'])->delete();
                $jobtrackingdata = new JobTrackingData();
                $jobtrackingdata = $jobtrackingdata->SetConnection('mysql2');
                $jobtrackingdata->where('status', 1)->where('job_tracking_no', $_POST['tracking_no'])->delete();

                $jobtracking = new JobTracking();
                $jobtracking = $jobtracking->SetConnection('mysql2');
                $jobtracking->customer          = $_POST['ClientId'];
                $jobtracking->branch_id          = $_POST['branch_id'];
                $jobtracking->customer_job      = $_POST['customer_job'];
                $jobtracking->region            = $_POST['RegionId'];
                $jobtracking->job_description   = $_POST['job_desc'];
                $jobtracking->job_tracking_no   = $_POST['tracking_no'];
                $jobtracking->job_tracking_date = $_POST['job_tracking_date'];
                $jobtracking->city              = $_POST['CityId'];
                $jobtracking->status            = 1;
                $jobtracking->username          = Auth::user()->name;
                $jobtracking->date              = date('Y-m-d');
                $jobtracking->type              = $_POST['x'];
                $jobtracking->save();
                $jobtracking_id = $jobtracking->job_tracking_id;

                for ($i = 1; $i <= 17; $i++) :
                    $jobtrackingdata = new JobTrackingData();
                    $jobtrackingdata = $jobtrackingdata->SetConnection('mysql2');
                    $jobtrackingdata->job_tracking_no      = $_POST['tracking_no'];
                    $jobtrackingdata->task                  = $request->input('task_' . $i);
                    $jobtrackingdata->task_assigned         = $request->input('taskAssigned_' . $i);
                    $jobtrackingdata->task_target_date      = $request->input('taskTarget_' . $i);
                    $jobtrackingdata->task_completed_date   = $request->input('taskCompeleted_' . $i);
                    $jobtrackingdata->resource              = $request->input('resourcAssign_' . $i);
                    $jobtrackingdata->remarks               = $request->input('remarks_' . $i);
                    $jobtrackingdata->job_tracking_id       = $jobtracking_id;
                    $jobtrackingdata->status                = 1;
                    $jobtrackingdata->username              = Auth::user()->name;
                    $jobtrackingdata->date                  = date('Y-m-d');
                    $jobtrackingdata->save();
                endfor;
                DB::Connection('mysql2')->commit();
            } catch (\Exception $e) {
                DB::Connection('mysql2')->rollback();
                echo "EROOR"; //die();
                dd($e->getMessage());
            }
        } else {
            $action_type = 2;
            DB::Connection('mysql2')->beginTransaction();
            try {
                $jobtracking = new JobTracking();
                $jobtracking =  $jobtracking->SetConnection('mysql2');
                $jobtracking->where('status', 1)->where('job_tracking_no', $_POST['tracking_no'])->delete();

                $jobtracking = new JobTracking();
                $jobtracking =  $jobtracking->SetConnection('mysql2');
                $jobtracking->customer          = $_POST['ClientId'];
                $jobtracking->branch_id          = $_POST['branch_id'];
                $jobtracking->customer_job      = $_POST['customer_job'];
                $jobtracking->region            = $_POST['RegionId'];
                $jobtracking->job_description   = $_POST['job_desc'];
                $jobtracking->job_tracking_no      = $_POST['tracking_no'];
                $jobtracking->job_tracking_date = $_POST['job_tracking_date'];
                $jobtracking->city              = $_POST['CityId'];
                $jobtracking->status            = 1;
                $jobtracking->username          = Auth::user()->name;
                $jobtracking->date              = date('Y-m-d');
                $jobtracking->type              = $_POST['x'];
                $jobtracking->save();
                $jobtracking_id = $jobtracking->job_tracking_id;

                $jobtrackingdata = new JobTrackingData();
                $jobtrackingdata = $jobtrackingdata->SetConnection('mysql2');
                $jobtrackingdata->where('status', 1)->where('job_tracking_no', $_POST['tracking_no'])->delete();

                for ($i = 1; $i <= 17; $i++) :
                    $jobtrackingdata = new JobTrackingData();
                    $jobtrackingdata = $jobtrackingdata->SetConnection('mysql2');
                    $jobtrackingdata->job_tracking_no      = $_POST['tracking_no'];
                    $jobtrackingdata->task                  = $request->input('task_' . $i);
                    $jobtrackingdata->task_assigned         = $request->input('taskAssigned_' . $i);
                    $jobtrackingdata->task_target_date      = $request->input('taskTarget_' . $i);
                    $jobtrackingdata->task_completed_date   = $request->input('taskCompeleted_' . $i);
                    $jobtrackingdata->resource              = $request->input('resourcAssign_' . $i);
                    $jobtrackingdata->remarks               = $request->input('remarks_' . $i);
                    $jobtrackingdata->job_tracking_id       = $jobtracking_id;
                    $jobtrackingdata->status                = 1;
                    $jobtrackingdata->username              = Auth::user()->name;
                    $jobtrackingdata->date                  = date('Y-m-d');
                    $jobtrackingdata->save();
                endfor;
                DB::Connection('mysql2')->commit();
            } catch (\Exception $e) {
                DB::Connection('mysql2')->rollback();
                echo "EROOR"; //die();
                dd($e->getMessage());
            }
        }

        $voucher_no     = $_POST['tracking_no'];
        $voucher_date   = $_POST['job_tracking_date'];
        $client_id      = $_POST['ClientId'];
        $table_name     = "job_tracking";
        CommonHelper::logActivity($voucher_no, $voucher_date, $action_type, $client_id, $table_name);

        //return redirect('sales/jobtrackinglist?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . $_GET['m'] . '#SFR');
    }

    public function addStockReturnDetail()
    {
        //        echo "<pre>";
        //        print_r($_POST); die;
        DB::Connection('mysql2')->beginTransaction();
        try {
            $m = $_GET['m'];
            CommonHelper::companyDatabaseConnection($_GET['m']);

            $IssuanceType = Input::get('IssuanceType');
            if ($IssuanceType == 1) {
                $data1['joborder'] = Input::get('joborder');
                $data1['issuance_type'] = $IssuanceType;
                $data3['joborder'] = Input::get('joborder');
            } else {
                $data1['issuance_type'] = $IssuanceType;
            }

            $issuanceSection = Input::get('issuanceSection');
            foreach ($issuanceSection as $row) {

                $iss_date = strip_tags(Input::get('iss_date_' . $row . ''));
                $description = strip_tags(Input::get('description_' . $row . ''));
                $issuanceDataSection = Input::get('issuanceDataSection_' . $row . '');

                $str = DB::Connection('mysql2')->selectOne("select max(convert(substr(`issuance_no`,3,length(substr(`issuance_no`,3))-4),signed integer)) reg from `stock_return` where substr(`issuance_no`,-4,2) = " . date('m') . " and substr(`issuance_no`,-2,2) = " . date('y') . "")->reg;
                $is_no = 'sr' . ($str + 1) . date('my');

                $data1['issuance_no']   = $is_no;
                $data1['issuance_date'] = $iss_date;
                $data1['region']        = Input::get('region');
                $data1['description']   = $description;
                $data1['status']        = 1;
                $data1['date']          = date("d-m-Y");
                $data1['username']      = Auth::user()->name;
                $stock_return_id = DB::table('stock_return')->insertGetId($data1);

                foreach ($issuanceDataSection as $row2) {
                    $category_id = strip_tags(Input::get('category_id_' . $row . '_' . $row2 . ''));
                    $sub_item_id = strip_tags(Input::get('sub_item_id_' . $row . '_' . $row2 . ''));
                    $qty = strip_tags(Input::get('qty_' . $row . '_' . $row2 . ''));

                    $data2['stock_return_id'] = $stock_return_id;
                    $data2['issuance_no'] = $is_no;
                    $data2['category'] = $category_id;
                    $data2['subitem'] = $sub_item_id;
                    $data2['qty'] = $qty;
                    $data2['status'] = 1;
                    $data2['date'] = date("d-m-Y");
                    $data2['username'] = Auth::user()->name;
                    $stock_return_data_id = DB::table('stock_return_data')->insertGetId($data2);

                    //                $data3['main_id']       = $stock_return_id;
                    //                $data3['master_id']     = $stock_return_data_id;
                    //                $data3['voucher_no']    = $is_no;
                    //                $data3['voucher_date']  = date("d-m-Y");
                    //                $data3['voucher_type']  = 3;
                    //                $data3['category_id']   = $category_id;
                    //                $data3['sub_item_id']   = $sub_item_id;
                    //                $data3['region_id']     = Input::get('region');
                    //                $data3['qty']           = $qty;
                    //                $data3['status']        = 1;
                    //                $data3['created_date']  = date("d-m-Y");
                    //                $data3['username']      = Auth::user()->name;
                    //                DB::table('stock')->insert($data3);

                }
            }
            CommonHelper::reconnectMasterDatabase();

            DB::Connection('mysql2')->commit();
        } catch (\Exception $e) {
            DB::Connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e->getMessage());
        }
        return Redirect::to('purchase/stockreturnlist?pageType=' . Input::get('pageType') . '&&parentCode=' . Input::get('parentCode') . '&&m=' . $_GET['m'] . '#SFR');
    }


    public function inser_item_master(Request $request)
    {
        $data = array(
            'category_id' => $request->CategoryId,
            'sub_category_id' => $request->sub_category,
            'item_master_code' => $request->code,
            'status' => 1,
            'username' => Auth::user()->name,
            'created_date' => date('Y-m-d'),
        );

        $Count = DB::Connection('mysql2')->selectOne('SELECT COUNT(item_master_code) as data_count FROM item_master
        WHERE category_id = ' . $request->CategoryId . ' AND sub_category_id = ' . $request->sub_category . ' AND item_master_code collate latin1_swedish_ci = "' . $request->code . '"')->data_count;
        //echo  $Count; die();
        if ($Count > 0) {
            Session::flash('dataDelete', $request->code . ' ' . 'Already Exists.');
            return Redirect::to('purchase/add_item_master?pageType=&&parentCode=144&&m=1#SFR');
        } else {
            DB::Connection('mysql2')->table('item_master')->insert($data);
            return redirect()->back()->withInput()->with('message', 'Successfully Submit');
        }
    }

    public function update_item_master(Request $request)
    {
        $EditId = $request->EditId;
        $data = array(
            'category_id' => $request->CategoryId,
            'sub_category_id' => $request->sub_category,
            'item_master_code' => $request->code,
            'status' => 1,
            'username' => Auth::user()->name,
            'created_date' => date('Y-m-d'),
        );

        $Count = DB::Connection('mysql2')->selectOne('SELECT COUNT(item_master_code) as data_count FROM item_master
        WHERE category_id = ' . $request->CategoryId . ' AND sub_category_id = ' . $request->sub_category . ' AND item_master_code collate latin1_swedish_ci = "' . $request->code . '" and id != ' . $EditId . '')->data_count;
        //echo  $Count; die();
        if ($Count > 0) {
            Session::flash('dataDelete', $request->code . ' ' . 'Already Exists.');
            return Redirect::to('purchase/editItemMaster/' . $EditId . '?pageType=&&parentCode=144&&m=1#SFR');
        } else {
            DB::Connection('mysql2')->table('item_master')->where('id', $EditId)->update($data);
            return redirect()->back()->withInput()->with('message', 'Successfully Submit');
        }
    }




    public function addPurchaseReturnDetail(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
            $str = DB::Connection('mysql2')->selectOne("select max(convert(substr(`pr_no`,3,length(substr(`pr_no`,3))-4),signed integer)) reg from `purchase_return` where substr(`pr_no`,-4,2) = " . date('m') . " and substr(`pr_no`,-2,2) = " . date('y') . "")->reg;
            $PurchaseReturnNo = 'dr' . ($str + 1) . date('my');
            $PurchaseReturnDate = $request->PurchaseReturnDate;
            $SupplierId = $request->supplier;
            $supp_id =  CommonHelper::get_supplier_acc_id($SupplierId);
            $GrnId = $request->GrnId;
            $GrnNo = $request->GrnNo;
            $GrnDate = $request->GrnDate;
            $Remarks = $request->Remarks;
            $PurchaseReturnInsert['grn_id'] = $GrnId;
            $PurchaseReturnInsert['pr_no'] = $PurchaseReturnNo;
            $PurchaseReturnInsert['pr_date'] = $PurchaseReturnDate;
            $PurchaseReturnInsert['supplier_id'] = $SupplierId;
            $PurchaseReturnInsert['grn_no'] = $GrnNo;
            $PurchaseReturnInsert['grn_date'] = $GrnDate;
            $PurchaseReturnInsert['remarks'] = $Remarks;
            $PurchaseReturnInsert['created_date'] = date('Y-m-d');
            $PurchaseReturnInsert['status'] = 1;
            $PurchaseReturnInsert['username'] = Auth::user()->name;

            $count_invoice =   DB::Connection('mysql2')->table('new_purchase_voucher')->where('grn_id', $GrnId)->count();
            if ($count_invoice > 0) :
                $PurchaseReturnInsert['type'] = 2;
            else :
                $PurchaseReturnInsert['type'] = 1;
            endif;
            $master_id = DB::Connection('mysql2')->table('purchase_return')->insertGetId($PurchaseReturnInsert);

            $data = $request->enable_disable;

            foreach ($data as $key => $row) :


                $amount = $request->input('Rate')[$row] * $request->input('ReturnQty')[$row];
                $dicount_percent = $request->input('discount_percent')[$row];
                $dicount_amount = ($amount / 100) * $dicount_percent;
                $total = 0;
                $dataa = array(
                    'master_id' => $master_id,
                    'pr_no' => $PurchaseReturnNo,
                    'grn_data_id' => $request->input('grn_data_id')[$row],
                    'sub_item_id' => $request->input('SubItemId')[$row],
                    'description' => $request->input('item_desc')[$row],
                    'warehouse_id' => $request->input('WarehouseId')[$row],
                    'batch_code' => $request->input('BatchCode')[$row],
                    'recived_qty' => $request->input('PurchaseRecQty')[$row],
                    'rate' => $request->input('Rate')[$row],
                    'amount' => $amount,
                    'discount_percent' => $dicount_percent,
                    'discount_amount' => $dicount_amount,
                    'net_amount' => $amount - $dicount_amount,
                    'return_qty' => $request->input('ReturnQty')[$row],
                );
                $net_amount = $amount - $dicount_amount;
                $total += $net_amount;
                $master_data_id = DB::Connection('mysql2')->table('purchase_return_data')->insertGetId($dataa);
                $delete_row = DB::Connection('mysql2')->table('grn_data')->where('id' , $request->input('grn_data_id')[$row])->update(['status' => 0]);

                $whare_hosue = CommonHelper::generic('grn_data', array('id' => $request->input('grn_data_id')[$row]), array('warehouse_id', 'description'))->first();

                $stock = array(
                    'main_id' => $master_id,
                    'master_id' => $master_data_id,
                    'voucher_no' => $PurchaseReturnNo,
                    'voucher_date' => $request->PurchaseReturnDate,
                    'supplier_id' => $SupplierId,
                    'voucher_type' => 2,
                    'rate' => $request->input('Rate')[$row],
                    'sub_item_id' => $request->input('SubItemId')[$row],
                    'batch_code' => $request->input('BatchCode')[$row],
                    'qty' => $request->input('ReturnQty')[$row],
                    'amount_before_discount' => $amount,

                    'discount_percent' => $dicount_percent,
                    'discount_amount' => $dicount_amount,
                    'amount' => $amount - $dicount_amount,

                    'status' => 1,
                    'warehouse_id' => $whare_hosue->warehouse_id,
                    'description' => $whare_hosue->description,
                    'username' => Auth::user()->username,
                    'created_date' => date('Y-m-d'),
                    'created_date' => date('Y-m-d'),
                    'opening' => 0,
                );


                DB::Connection('mysql2')->table('stock')->insert($stock);
            //endif;

            endforeach;
            $PRInsertedData = DB::Connection('mysql2')->select('select b.* from purchase_return a
                                            inner join purchase_return_data b on b.master_id = a.id
                                            where a.id = ' . $master_id . '
                                            and a.type = 2');

            foreach ($PRInsertedData as $PRFil) {

                $InsertData['main_id'] = $PRFil->master_id;
                $InsertData['master_id'] = $PRFil->id;
                $InsertData['voucher_no'] = $PRFil->pr_no;
                $InsertData['item_id'] = $PRFil->sub_item_id;
                $InsertData['qty'] = $PRFil->return_qty;
                $InsertData['amount'] = $PRFil->net_amount;
                $InsertData['opening'] = 0;
                $InsertData['status'] = 1;
                $InsertData['username'] = Auth::user()->name;
                $InsertData['voucher_type'] = 2;
                DB::Connection('mysql2')->table('transaction_supply_chain')->insert($InsertData);
            }

            $count_invoice =   DB::Connection('mysql2')->table('new_purchase_voucher')->where('grn_id', $GrnId)->count();
            if ($count_invoice > 0) :

                $dataa = DB::Connection('mysql2')->select('select sum(a.net_amount)net_amount,sup.acc_id as category_id from  purchase_return_data a
                inner join
                purchase_return pr
                on
                pr.id=a.master_id
                inner join
                supplier sup
                on
                pr.supplier_id=sup.id
                inner join
                new_purchase_voucher_data b
                on
                a.grn_data_id=b.grn_data_id
                where a.master_id="' . $master_id . '"
                group by b.category_id');
                $debit_amount = 0;
                // dd($dataa);
                foreach ($dataa as $cr_note) :

                    $transaction = new Transactions();
                    $transaction = $transaction->SetConnection('mysql2');
                    $transaction->voucher_no = $PurchaseReturnNo;
                    $transaction->v_date = $PurchaseReturnDate;
                    $transaction->acc_id = $cr_note->category_id??'';
                    $transaction->acc_code = FinanceHelper::getAccountCodeByAccId($cr_note->category_id);
                    $transaction->particulars = $Remarks;
                    $transaction->opening_bal = 0;
                    $transaction->debit_credit = 0;
                    $transaction->amount = $cr_note->net_amount;
                    $transaction->username = Auth::user()->name;
                    $transaction->status = 1;
                    $transaction->voucher_type = 5;
                    $transaction->save();
                    $debit_amount += $cr_note->net_amount;
                endforeach;

                $po_data = CommonHelper::get_goodreciptnotedata_pr($GrnId, 1);

                $sales_tax_amount = $po_data->sales_tax_amount;


                if ($sales_tax_amount > 0) :
                    $sales_tax_amount = ($total / 100) * 17;
                    $transaction = new Transactions();
                    $transaction = $transaction->SetConnection('mysql2');
                    $transaction->voucher_no = $PurchaseReturnNo;
                    $transaction->v_date = $PurchaseReturnDate;
                    $transaction->acc_id = $po_data->sales_tax;
                    $transaction->acc_code = FinanceHelper::getAccountCodeByAccId($po_data->sales_tax);
                    $transaction->particulars = $Remarks;
                    $transaction->opening_bal = 0;
                    $transaction->debit_credit = 0;
                    $transaction->amount = $sales_tax_amount;
                    $transaction->username = Auth::user()->name;;
                    $transaction->status = 1;
                    $transaction->voucher_type = 5;
                    $transaction->save();
                    $debit_amount += $sales_tax_amount;
                endif;

                $transaction = new Transactions();
                $transaction = $transaction->SetConnection('mysql2');
                $transaction->voucher_no = $PurchaseReturnNo;
                $transaction->v_date = $PurchaseReturnDate;
                $transaction->acc_id = $supp_id;
                $transaction->acc_code = FinanceHelper::getAccountCodeByAccId($supp_id);
                $transaction->particulars = $Remarks;
                $transaction->opening_bal = 0;
                $transaction->debit_credit = 1;
                $transaction->amount = $debit_amount;
                $transaction->username = Auth::user()->name;;
                $transaction->status = 1;
                $transaction->voucher_type = 5;
                $transaction->save();

            endif;


            CommonHelper::inventory_activity($PurchaseReturnNo, $PurchaseReturnDate, $total, 4, 'Insert');

            DB::Connection('mysql2')->commit();
        } catch (\Exception $e) {
            DB::Connection('mysql2')->rollback();
            dd($e->getLine(), $e->getMessage(), $e->getTrace());
        }
        Session::flash('dataInsert', 'Purchase Return Successfully Saved.');

        return Redirect::to('purchase/purchaseReturnList?pageType=view&&parentCode=95&&m=' . $_GET['m'] . '#murtazaCorporation');
    }

    public function updatePurchaseReturnDetail(Request $request)
    {
        //        echo "<pre>";
        //        print_r(Input::get());
        //        die();


        DB::Connection('mysql2')->beginTransaction();
        try {

            $PurchaseReturnNo = $request->PrNo;
            $PurchaseReturnDate = $request->PurchaseReturnDate;
            $EditId = $request->EditId;
            $SupplierId = $request->supplier;
            $supp_id =  CommonHelper::get_supplier_acc_id($SupplierId);
            $GrnId = $request->GrnId;
            $GrnNo = $request->GrnNo;
            $GrnDate = $request->GrnDate;
            $Remarks = $request->Remarks;
            $PurchaseReturnInsert['grn_id'] = $GrnId;
            $PurchaseReturnInsert['pr_no'] = $PurchaseReturnNo;
            $PurchaseReturnInsert['pr_date'] = $PurchaseReturnDate;
            $PurchaseReturnInsert['supplier_id'] = $SupplierId;
            $PurchaseReturnInsert['grn_no'] = $GrnNo;
            $PurchaseReturnInsert['grn_date'] = $GrnDate;
            $PurchaseReturnInsert['remarks'] = $Remarks;
            $PurchaseReturnInsert['created_date'] = date('Y-m-d');
            $PurchaseReturnInsert['status'] = 1;
            $PurchaseReturnInsert['username'] = Auth::user()->name;
            DB::Connection('mysql2')->table('purchase_return')->where('id', $EditId)->update($PurchaseReturnInsert);
            DB::Connection('mysql2')->table('purchase_return_data')->where('master_id', $EditId)->delete();
            DB::Connection('mysql2')->table('stock')->where('main_id', $EditId)->where('voucher_no', $PurchaseReturnNo)->delete();


            $data = $request->LoopVal;
            //            print_r($data);
            //            die();
            $total = 0;
            foreach ($data as $key => $row) :


                $amount = $request->input('Rate')[$row] * $request->input('ReturnQty')[$row];
                $dicount_percent = $request->input('discount_percent')[$row];
                $dicount_amount = ($amount / 100) * $dicount_percent;


                $PurchaseReturnData = array(
                    'master_id' => $EditId,
                    'pr_no' => $PurchaseReturnNo,
                    'grn_data_id' => $request->input('grn_data_id')[$row],
                    'sub_item_id' => $request->input('SubItemId')[$row],
                    'description' => $request->input('item_desc')[$row],
                    'warehouse_id' => $request->input('WarehouseId')[$row],
                    'batch_code' => $request->input('BatchCode')[$row],
                    'recived_qty' => $request->input('PurchaseRecQty')[$row],
                    'rate' => $request->input('Rate')[$row],
                    'amount' => $amount,


                    'discount_percent' => $dicount_percent,
                    'discount_amount' => $dicount_amount,
                    'net_amount' => $amount - $dicount_amount,


                    'return_qty' => $request->input('ReturnQty')[$row]
                );

                $net_amount = $amount - $dicount_amount;
                $total += $net_amount;
                //print_r($PurchaseReturnData);
                $master_data_id = DB::Connection('mysql2')->table('purchase_return_data')->insertGetId($PurchaseReturnData);


                $whare_hosue = CommonHelper::generic('grn_data', array('id' => $request->input('grn_data_id')[$row]), array('warehouse_id', 'description'))->first();

                $stock = array(
                    'main_id' => $EditId,
                    'master_id' => $master_data_id,
                    'voucher_no' => $PurchaseReturnNo,
                    'voucher_date' => $request->PurchaseReturnDate,
                    'supplier_id' => $SupplierId,
                    'voucher_type' => 2,
                    'rate' => $request->input('Rate')[$row],
                    'sub_item_id' => $request->input('SubItemId')[$row],
                    'batch_code' => $request->input('BatchCode')[$row],
                    'qty' => $request->input('ReturnQty')[$row],


                    'amount_before_discount' => $amount,
                    'discount_percent' => $dicount_percent,
                    'discount_amount' => $dicount_amount,
                    'amount' => $amount - $dicount_amount,


                    'status' => 1,
                    'warehouse_id' => $whare_hosue->warehouse_id,
                    'description' => $whare_hosue->description,
                    'username' => Auth::user()->username,
                    'created_date' => date('Y-m-d'),
                    'created_date' => date('Y-m-d'),
                    'opening' => 0,
                );
                DB::Connection('mysql2')->table('stock')->insert($stock);
            //endif;

            endforeach;
            DB::Connection('mysql2')->table('transaction_supply_chain')->where('main_id', $EditId)->where('voucher_no', $PurchaseReturnNo)->delete();

            $PRInsertedData = DB::Connection('mysql2')->select('select b.* from purchase_return a
                                            inner join purchase_return_data b on b.master_id = a.id
                                            where a.id = ' . $EditId . '
                                            and a.type = 2');

            foreach ($PRInsertedData as $PRFil) {

                $InsertData['main_id'] = $PRFil->master_id;
                $InsertData['master_id'] = $PRFil->id;
                $InsertData['voucher_no'] = $PRFil->pr_no;
                $InsertData['item_id'] = $PRFil->sub_item_id;
                $InsertData['qty'] = $PRFil->return_qty;
                $InsertData['amount'] = $PRFil->net_amount;
                $InsertData['opening'] = 0;
                $InsertData['status'] = 1;
                $InsertData['username'] = Auth::user()->name;
                $InsertData['voucher_type'] = 2;
                DB::Connection('mysql2')->table('transaction_supply_chain')->insert($InsertData);
            }


            $count_invoice =   DB::Connection('mysql2')->table('transactions')->where('voucher_no', $PurchaseReturnNo)->count();
            if ($count_invoice > 0) :

                $data_delete['status'] = 0;
                $count_invoice =   DB::Connection('mysql2')->table('transactions')->where('voucher_no', $PurchaseReturnNo)->update($data_delete);
                $dataa = DB::Connection('mysql2')->select('select sum(a.net_amount)net_amount,b.category_id from  purchase_return_data a
                inner join
                new_purchase_voucher_data b
                on
                a.grn_data_id=b.grn_data_id
                where a.master_id="' . $EditId . '"
                and a.status=1
                group by b.category_id');
                $debit_amount = 0;
                foreach ($dataa as $cr_note) :

                    $transaction = new Transactions();
                    $transaction = $transaction->SetConnection('mysql2');
                    $transaction->voucher_no = $PurchaseReturnNo;
                    $transaction->v_date = $PurchaseReturnDate;
                    $transaction->acc_id = $cr_note->category_id;
                    $transaction->acc_code = FinanceHelper::getAccountCodeByAccId($cr_note->category_id);
                    $transaction->particulars = $Remarks;
                    $transaction->opening_bal = 0;
                    $transaction->debit_credit = 0;
                    $transaction->amount = $cr_note->net_amount;
                    $transaction->username = Auth::user()->name;
                    $transaction->status = 1;
                    $transaction->voucher_type = 5;
                    $transaction->save();
                    $debit_amount += $cr_note->net_amount;
                endforeach;

                $po_data = CommonHelper::get_goodreciptnotedata($GrnId, 1);

                $sales_tax_amount = $po_data->sales_tax_amount;


                if ($sales_tax_amount > 0) :
                    $sales_tax_amount = ($total / 100) * 17;
                    $transaction = new Transactions();
                    $transaction = $transaction->SetConnection('mysql2');
                    $transaction->voucher_no = $PurchaseReturnNo;
                    $transaction->v_date = $PurchaseReturnDate;
                    $transaction->acc_id = $po_data->sales_tax;
                    $transaction->acc_code = FinanceHelper::getAccountCodeByAccId($po_data->sales_tax);
                    $transaction->particulars = $Remarks;
                    $transaction->opening_bal = 0;
                    $transaction->debit_credit = 0;
                    $transaction->amount = $sales_tax_amount;
                    $transaction->username = Auth::user()->name;;
                    $transaction->status = 1;
                    $transaction->voucher_type = 5;
                    $transaction->save();
                    $debit_amount += $sales_tax_amount;
                endif;

                $transaction = new Transactions();
                $transaction = $transaction->SetConnection('mysql2');
                $transaction->voucher_no = $PurchaseReturnNo;
                $transaction->v_date = $PurchaseReturnDate;
                $transaction->acc_id = $supp_id;
                $transaction->acc_code = FinanceHelper::getAccountCodeByAccId($supp_id);
                $transaction->particulars = $Remarks;
                $transaction->opening_bal = 0;
                $transaction->debit_credit = 1;
                $transaction->amount = $debit_amount;
                $transaction->username = Auth::user()->name;;
                $transaction->status = 1;
                $transaction->voucher_type = 5;
                $transaction->save();

            endif;






            //die();


            CommonHelper::inventory_activity($PurchaseReturnNo, $PurchaseReturnDate, $total, 4, 'Update');
            DB::Connection('mysql2')->commit();
        } catch (\Exception $e) {
            DB::Connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e->getMessage());
        }
        Session::flash('dataInsert', 'Purchase Return Successfully Saved.');

        return Redirect::to('purchase/purchaseReturnList?pageType=view&&parentCode=95&&m=' . $_GET['m'] . '#murtazaCorporation');
    }



    public function addStockTransfer(Request $request)
    {

        DB::Connection('mysql2')->beginTransaction();
        $uniq = PurchaseHelper::get_unique_no_transfer(date('y'), date('m'));
        try {

            $data = array(
                'tr_no' => $uniq,
                'tr_date' => $request->tr_date,
                'description' => $request->description,
                'status' => 1,
                'date' => $request->tr_date,
                'username' => Auth::user()->name,
            );
            $master_id = DB::Connection('mysql2')->table('stock_transfer')->insertGetId($data);

            $data1 = $request->item_id;
            $TotAmount = 0;
            foreach ($data1 as $key => $row) :





                $data2 = array(
                    'master_id' => $master_id,
                    'tr_no' => $uniq,
                    'item_id' => $row,
                    'warehouse_from' => $request->input('warehouse_from')[$key],
                    'warehouse_to' => $request->input('warehouse_to')[$key],
                    'qty' => $request->input('qty')[$key],
                    'rate' => $request->input('rate')[$key],
                    'amount' => $request->input('amount')[$key],
                    'batch_code' => $request->input('batch_code')[$key],
                    'desc' => $request->input('des')[$key],
                    'status' => 1,
                );

                $TotAmount += $request->input('amount')[$key];


                $master_data_id = DB::Connection('mysql2')->table('stock_transfer_data')->insertGetId($data2);

                $stock = array(
                    'main_id' => $master_id,
                    'master_id' => $master_data_id,
                    'voucher_no' => $uniq,
                    'voucher_date' => $request->tr_date,
                    'supplier_id' => 0,
                    'voucher_type' => 3,
                    'rate' => $request->input('rate')[$key],
                    'sub_item_id' => $row,
                    'qty' => $request->input('qty')[$key],
                    'amount' => $request->input('amount')[$key],
                    'status' => 1,
                    'warehouse_id' => $request->input('warehouse_from')[$key],
                    'warehouse_id_from' => $request->input('warehouse_from')[$key],
                    'warehouse_id_to' => $request->input('warehouse_to')[$key],
                    'batch_code' => $request->input('batch_code')[$key],
                    'transfer_status' => 1,
                    'description' => 'Transfer',
                    'username' => Auth::user()->username,
                    'created_date' => date('Y-m-d'),
                    'created_date' => date('Y-m-d'),
                    'opening' => 0,
                );
                // DB::Connection('mysql2')->table('stock')->insert($stock);


                $stock1 = array(
                    'main_id' => $master_id,
                    'master_id' => $master_data_id,
                    'voucher_no' => $uniq,
                    'voucher_date' => $request->tr_date,
                    'supplier_id' => 0,
                    'voucher_type' => 1,
                    'rate' => $request->input('rate')[$key],
                    'sub_item_id' => $row,
                    'qty' => $request->input('qty')[$key],
                    'amount' => $request->input('amount')[$key],
                    'status' => 1,
                    'warehouse_id' => $request->input('warehouse_to')[$key],
                    'warehouse_id_from' => $request->input('warehouse_from')[$key],
                    'warehouse_id_to' => $request->input('warehouse_to')[$key],
                    'transfer_status' => 1,
                    'description' => 'Transfer',
                    'username' => Auth::user()->username,
                    'created_date' => date('Y-m-d'),
                    'created_date' => date('Y-m-d'),
                    'opening' => 0,
                );
            //    DB::Connection('mysql2')->table('stock')->insert($stock1);


            endforeach;

            CommonHelper::inventory_activity($uniq, $request->tr_date, $TotAmount, 6, 'Insert');


            DB::Connection('mysql2')->commit();
        } catch (\Exception $e) {
            DB::Connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e->getMessage());
        }

        Session::flash('dataInsert', 'Stock Transfer Successfully Saved.');

        return Redirect::to('store/stock_transfer_list?pageType=view&&parentCode=95&&m=' . $_GET['m'] . '#murtazaCorporation');
    }



    public function add_internal_consum(Request $request)
    {

        DB::Connection('mysql2')->beginTransaction();
        $uniq = PurchaseHelper::get_unique_no_internal_consumtion(date('y'), date('m'));
        try {

            $data = array(
                'voucher_no' => $uniq,
                'voucher_date' => $request->tr_date,
                'description' => $request->description,
                'status' => 1,
                'date' => $request->tr_date,
                'username' => Auth::user()->name,
            );
            $master_id = DB::Connection('mysql2')->table('internal_consumtion')->insertGetId($data);

            $data1 = $request->item_id;
            $TotAmount = 0;
            foreach ($data1 as $key => $row) :





                $data2 = array(
                    'master_id' => $master_id,
                    'voucher_no' => $uniq,
                    'item_id' => $row,
                    'warehouse_from' => $request->input('warehouse_from')[$key],
                    'acc_id' => $request->input('warehouse_to')[$key],
                    'qty' => $request->input('qty')[$key],
                    'rate' => $request->input('rate')[$key],
                    'amount' => $request->input('amount')[$key],
                    'batch_code' => $request->input('batch_code')[$key],
                    'desc' => $request->input('des')[$key],
                    'status' => 1,
                );

                $TotAmount += $request->input('amount')[$key];
                $master_data_id = DB::Connection('mysql2')->table('internal_consumtion_data')->insertGetId($data2);


            endforeach;

            CommonHelper::inventory_activity($uniq, $request->tr_date, $TotAmount, 10, 'Insert');


            DB::Connection('mysql2')->commit();
        } catch (\Exception $e) {
            DB::Connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e->getMessage());
        }

        Session::flash('dataInsert', 'Stock Transfer Successfully Saved.');

        return Redirect::to('store/internal_consumtion_list?pageType=view&&parentCode=95&&m=' . Session::get('run_company') . '#murtazaCorporation');
    }

    public function updateStockTransfer(Request $request)
    {

        DB::Connection('mysql2')->beginTransaction();
        $uniq = $request->tr_no;
        $EditId = $request->EditId;

        try {

            $data = array(
                'tr_no' => $uniq,
                'tr_date' => $request->tr_date,
                'description' => $request->description,
                'status' => 1,
                'date' => date('Y-m-d'),
                'username' => Auth::user()->name,
            );
            DB::Connection('mysql2')->table('stock_transfer')->where('id', $EditId)->update($data);
            DB::Connection('mysql2')->table('stock_transfer_data')->where('master_id', $EditId)->delete();

            $data1 = $request->item_id;
            $TotAmount = 0;
            foreach ($data1 as $key => $row) :

                $data2 = array(
                    'master_id' => $EditId,
                    'tr_no' => $uniq,
                    'item_id' => $row,
                    'warehouse_from' => $request->input('warehouse_from')[$key],
                    'batch_code' => $request->input('batch_code')[$key],
                    'warehouse_to' => $request->input('warehouse_to')[$key],
                    'qty' => $request->input('qty')[$key],
                    'rate' => $request->input('rate')[$key],
                    'amount' => $request->input('amount')[$key],
                    'status' => 1,
                );
                $TotAmount += $request->input('amount')[$key];
                $master_data_id = DB::Connection('mysql2')->table('stock_transfer_data')->insertGetId($data2);
            endforeach;

            CommonHelper::inventory_activity($uniq, $request->tr_date, $TotAmount, 6, 'Update');

            DB::Connection('mysql2')->commit();
        } catch (\Exception $e) {
            DB::Connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e->getMessage());
        }

        Session::flash('dataInsert', 'Stock Transfer Successfully Saved.');

        return Redirect::to('store/stock_transfer_list?pageType=view&&parentCode=95&&m=' . $_GET['m'] . '#murtazaCorporation');
    }

    public function edit_sub(Request $request)
    {
        $id = $request->id;
        $data['sub_category_name'] = $request->SubCategoryName;

        DB::Connection('mysql2')->table('sub_category')->where('id', $id)->update($data);
        return Redirect::to('purchase/viewSubCategoryList?pageType=view&&parentCode=95&&m=' . Session::get('run_company') . '#murtazaCorporation');
    }

    public function insertDirectPurchaseInvoice(Request $request)
    {
        // dd($request->all());
        DB::Connection('mysql2')->beginTransaction();
        try {

            $supplier_id = explode('@#', $request->input('supplier_id'))[0];
            $supp_acc_id = CommonHelper::get_supplier_acc_id($supplier_id);
            $purchase_date = $request->input('pv_date');
            $pv_no = CommonHelper::uniqe_no_for_purcahseVoucher(date('y'), date('m'), $request->input('company_location_id') ?? 1);

            $NewPurchaseVoucher = new NewPurchaseVoucher();
            $NewPurchaseVoucher = $NewPurchaseVoucher->SetConnection('mysql2');
            $NewPurchaseVoucher->pv_no      = $pv_no;
            $NewPurchaseVoucher->pv_date    = $purchase_date;
            $NewPurchaseVoucher->grn_no     = 0;
            $NewPurchaseVoucher->grn_id     = 0;
            $NewPurchaseVoucher->slip_no    = $request->input('slip_no');
            $NewPurchaseVoucher->bill_date  = $request->input('bill_date');
            $NewPurchaseVoucher->due_date   = $request->input('due_date');
            $NewPurchaseVoucher->purchase_type  = 0;
            $NewPurchaseVoucher->po_no_date  = 0;
            $NewPurchaseVoucher->supplier    = $supplier_id;
            $bolen = false;
            $salesTaxx = explode('@', $request->input('sales_taxx'));
            if ($salesTaxx[1] != "") {
                $SalesTaxAccId = $salesTaxx[1];
                $SalesTaxAmount = $request->input('sales_amount_td');
                $bolen = true;
            } else {
                $SalesTaxAccId = 0;
                $SalesTaxAmount = 0;
            }
            $NewPurchaseVoucher->sales_tax_acc_id = $SalesTaxAccId;
            $NewPurchaseVoucher->sales_tax_amount = $SalesTaxAmount;

            $NewPurchaseVoucher->description = $request->input('main_description');
            $NewPurchaseVoucher->username    = Auth::user()->name;
            $NewPurchaseVoucher->approved_user  = Auth::user()->name;
            $NewPurchaseVoucher->status      = 1;
            $NewPurchaseVoucher->pv_status   = 1;
            $NewPurchaseVoucher->date        = date('Y-m-d');
            $NewPurchaseVoucher->save();
            $master_id = $NewPurchaseVoucher->id;

            $TotAmount = 0;
            foreach ($request->item_id as $key => $row) :
                $NewPurchaseVoucherData = new NewPurchaseVoucherData();
                $NewPurchaseVoucherData = $NewPurchaseVoucherData->SetConnection('mysql2');
                $NewPurchaseVoucherData->master_id      = $master_id;
                $NewPurchaseVoucherData->pv_no          = $pv_no;
                $NewPurchaseVoucherData->grn_data_id    = 0;
                $NewPurchaseVoucherData->category_id    = 0;
                $NewPurchaseVoucherData->sub_item       = $row;
                $NewPurchaseVoucherData->uom            = $request->input('uom_id')[$key];
                $NewPurchaseVoucherData->qty            = $request->input('actual_qty')[$key];
                $NewPurchaseVoucherData->rate           = $request->input('rate')[$key];
                $NewPurchaseVoucherData->amount         = $request->input('amount')[$key];
                $NewPurchaseVoucherData->discount_amount         = $request->input('discount_amount')[$key];
                $NewPurchaseVoucherData->net_amount         = $request->input('after_dis_amount')[$key];
                $TotAmount += $request->input('after_dis_amount')[$key];
                $NewPurchaseVoucherData->staus          = 1;
                $NewPurchaseVoucherData->pv_status      = 2;
                $NewPurchaseVoucherData->username       = Auth::user()->name;
                $NewPurchaseVoucherData->date           = date('Y-m-d');
                $NewPurchaseVoucherData->save();
            endforeach;
            // NotificationHelper::send_email('Purchase Invoice', 'Create', $dept_id, $voucher_no, $subject, $p_type);
            // ReuseableCode::approvedPVDetail($master_id);
            // CommonHelper::inventory_activity($pv_no, $purchase_date, $TotAmount, 5, 'Insert');
            DB::Connection('mysql2')->commit();
        } catch (\Exception $e) {
            DB::Connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e->getMessage());
        }

        return Redirect::to('purchase/viewPurchaseVoucherListThroughGrn?pageType=viewlist&&parentCode=82&&m=1#SFR');
    }

    public function addTempGrn(Request $request)
    {
        $tempGrn = new TempGrn();
        $tempGrn->system_code = CommonHelper::unique_for_system_code(date('y'), date('m'));
        $tempGrn->dc_no = $request->dcNo;
        $tempGrn->dc_date = $request->dcDate;
        $tempGrn->save();
    }


    public function addCompanyLocationDetail(Request $request)
    {
        $request->validate([
            'location_name' => 'required|unique:company_locations,location_name',
            'location_contact_person' => 'required',
            'location_contact_no' => 'required|unique:company_locations,location_contact_no|numeric',
            'location_address' => 'required',
        ]);

        $locations = new CompanyLocation();
        $locations->location_name = $request->location_name;
        $locations->location_contact_person = $request->location_contact_person;
        $locations->location_contact_no = $request->location_contact_no;
        $locations->location_address = $request->location_address;
        $locations->save();
        Session::flash('dataInsert', "Location Add Successfully");
        return redirect()->back();
        // dump($request->all());
    }

    public function assignUserCompanyRights(Request $request)
    {
        // dd($request->all());
        if ($request->user_id && $request->location_ids) {
            $location_ids = implode(",", $request->location_ids);
            User::find($request->user_id)->update([
                'company_location' => $location_ids
            ]);
            Session::flash('dataInsert', "Company Location Rightd Successfully Assigned");
        } else {
            Session::flash('dataDelete', "All fields are required");
        }
        return redirect()->back();
    }

    public function gmApproval(Request $request){
        $demand = Demand::find($request->demand_id);
        $demand->gm_approval_status = $request->gm_approval_status;
        $demand->gm_approval_username = Auth::user()->name;
        $demand->gm_date_time = Carbon::now()->format('Y-m-d H:i:s');
        $demand->gm_description = $request->gm_description;
        $demand->save();
        return "updated";
    }

    public function audApproval(Request $request){
        $demand = Demand::find($request->demand_id);
        $demand->aud_approval_status = $request->aud_approval_status;
        $demand->aud_approval_username = Auth::user()->name;
        $demand->aud_date_time = now()->format('Y-m-d H:i:s');
        $demand->aud_description = $request->aud_description;
        $demand->save();
        return "updated";
    }

}
