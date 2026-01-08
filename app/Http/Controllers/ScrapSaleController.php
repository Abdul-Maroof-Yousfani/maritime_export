<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompanyLocation;
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
use App\Models\Line;
use App\ScrapDeclration;
use App\ScrapSale;
use App\ScrapSaleData;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ScrapSaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $company_location = Auth::user()->company_location;
            $locations = explode(',', $company_location);
            $scrap_sales = ScrapSale::whereStatus(true)
            ->whereIn('company_location_id', $locations)
            ->whereBetween('created_at', [$request->from_date, $request->to_date]);
            if($request->department_id){
                $scrap_sales = $scrap_sales->where('department_id',$request->department_id);
            }
            if($request->line_no){
                $scrap_sales = $scrap_sales->where('line_no',$request->line_no);
            }
            $scrap_sales = $scrap_sales->latest()->get();
            return view('scrap_sales.ajaxIndex', compact('scrap_sales'));
        }
        $department_id = ReuseableCode::getUserWiseDepartmentRights();
        $subDepartmentList = DB::table('sub_department')->whereIn('id', $department_id)->select('id','sub_department_name')->get();
        $lines = Line::where('status', 1)->get();
        return view('scrap_sales.index',  compact('subDepartmentList','lines'));
    }
    
    public function create()
    {
        $company_location = Auth::user()->company_location;
        $locations = explode(',', $company_location);
        $scrap_declrations = ScrapDeclration::whereStatus(true)
        ->whereIn('company_location_id', $locations)
        ->where('scrap_sale',0)->where('gm_approval_status',1)
        ->latest()->get();
        return view('scrap_sales.create', compact('scrap_declrations'));
    }

    public function GetScrapDeclration(Request $request)
    {
        $scrap_declration = ScrapDeclration::find($request->id);
        return view('scrap_sales.GetScrapDeclration', compact('scrap_declration'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();

            $location = Input::get('company_location_id');
            $str = ScrapDeclration::where('company_location_id', $location)->orderBy('id', 'desc')->count();
            $arp_no = 'SS-' . CommonHelper::getCompanyLocationPrefix($location) . '-' . sprintf("%'05d", ($str + 1)); // . date('my');
            $request['ss_no'] = strtoupper($arp_no);
            
            $ScrapSale = new ScrapSale();
            $ScrapSale->ss_no = strtoupper($arp_no);
            $ScrapSale->scrap_declration_id = $request->scrap_id;
            $ScrapSale->scrap_declration_no = $request->scrap_no;
            $ScrapSale->requested_by = Auth::user()->name;
            $ScrapSale->company_location_id = $request->company_location_id;
            $ScrapSale->ss_remarks = $request->ss_remarks;
            $ScrapSale->department_id = $request->department_id;
            $ScrapSale->line_no = $request->line_no;
            $ScrapSale->ss_date = date('d-m-Y',strtotime($request->ss_date));
            $ScrapSale->save();

            foreach ($request->item as $key => $value) {
                
                if($value != ''){
                    $item = explode('%',$value);
                    ScrapSaleData::create([
                        'scrap_sale_id' => $ScrapSale->id,
                        'item' => $item[0],
                        'item_id' => $item[3],
                        'uom' => $request->uom[$key],
                        'category_id' => $request->category_id[$key],
                        'item_code' => $request->item_code[$key],
                        'item_desc' => $request->item_desc[$key],
                        'qty' => $request->qty[$key],
                        'balance' => $request->balance[$key],
                        'rate' => $request->rate[$key],
                        'total' => $request->total[$key],
                        // 'reason_for_scrapping' => $request->reason_for_scrapping[$key],        
                    ]);
                }
            }
            $ScrapDeclration = ScrapDeclration::find($request->scrap_id)->update(['scrap_sale' => 1]);


            DB::commit();
            Session::flash('dataInsert', "Data Successfully Added");
            return Redirect::to('purchase/scrap_sales?pageType=&&parentCode=244&&m='.session('run_company').'#Garibsons');
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    public function ViewScrapSale(Request $request)
    {
        
        $id = $request->id;
        $scrap_sale = ScrapSale::where('id' , $id)->where('status', 1)->first();
        return view('scrap_sales.show' , compact('scrap_sale'));
    }  

    public function edit($id)
    {
        $scrap_declration = ScrapDeclration::find($id);
        $company_locations = ReuseableCode::getUserWiseLocationRights();
        $company_locations = CompanyLocation::whereIn('id', $company_locations)->get()->toArray();
        $department_id = ReuseableCode::getUserWiseDepartmentRights();
        $subDepartmentList = DB::table('sub_department')->whereIn('id', $department_id)->select('id','sub_department_name')->get();
         $lines = Line::where('status', 1)->get();
        return view('scrap_declrations.edit', compact('scrap_declration','company_locations','subDepartmentList','lines'));
    }  

    public function update(Request $request,$id)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();

            $scrap_declration = ScrapDeclration::find($id);
            $scrap_declration->sd_remarks = $request->sd_remarks;
            $scrap_declration->department_id = $request->department_id;
            $scrap_declration->line_no = $request->line_no;
            $scrap_declration->save();

    
            $scrap_declration->ScrapData()->delete();

            foreach ($request->item as $key => $value) {
                
                if($value != ''){
                    $item = explode('%',$value);
                    ScrapDeclrationData::create([
                        'scrap_declration_id' => $scrap_declration->id,
                        'item' => $item[0],
                        'item_id' => $item[3],
                        'uom' => $request->uom[$key],
                        'category_id' => $request->category_id[$key],
                        'item_code' => $request->item_code[$key],
                        'item_desc' => $request->item_desc[$key],
                        'qty' => $request->qty[$key],
                        'reason_for_scrapping' => $request->reason_for_scrapping[$key],        
                    ]);
                }
            }

            DB::commit();
            Session::flash('dataInsert', "Data Successfully updated");
            return Redirect::to('purchase/scrap_declrations?pageType=&&parentCode=243&&m='.session('run_company').'#Garibsons');
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    public function delete_scrap_sale(Request $request)
    {
        $ScrapSale = ScrapSale::find($request->id)->update(['status' => 0]);
        
        return 'Deleted';
    }
    
    public function gmApprovalSale(Request $request){
        $scrap = ScrapSale::find($request->scrap_id);
        $scrap->gm_approval_status = $request->gm_approval_status;
        $scrap->gm_approval_username = Auth::user()->name;
        $scrap->gm_date_time = Carbon::now()->format('Y-m-d H:i:s');
        $scrap->gm_description = $request->gm_description;
        $scrap->save();
        return "updated";
    }

    public function audApprovalSale(Request $request){
        $scrap = ScrapSale::find($request->scrap_id);
        $scrap->aud_approval_status = $request->aud_approval_status;
        $scrap->aud_approval_username = Auth::user()->name;
        $scrap->aud_date_time = now()->format('Y-m-d H:i:s');
        $scrap->aud_description = $request->aud_description;
        $scrap->save();
        return "updated";
    }

    public function approve_scrap_sale(Request $request){
        $scrap = ScrapSale::find($request->scrap_id);
        $scrap->scrap_approve = $request->approval_status;
        $scrap->approve_name = Auth::user()->name;
        $scrap->approve_date = now()->format('Y-m-d H:i:s');
        $scrap->save();
        return "updated";
    }

}
