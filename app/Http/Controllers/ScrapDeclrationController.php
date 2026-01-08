<?php

namespace App\Http\Controllers;

use App\CompanyLocation;
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
use App\Models\Line;
use App\ScrapDeclration;
use App\ScrapDeclrationData;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ScrapDeclrationController extends Controller
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
            $scrap_declrations = ScrapDeclration::whereStatus(true)
            ->whereIn('company_location_id', $locations)
            ->whereBetween('created_at', [$request->from_date, $request->to_date]);
            if($request->department_id){
                $scrap_declrations = $scrap_declrations->where('department_id',$request->department_id);
            }
            if($request->line_no){
                $scrap_declrations = $scrap_declrations->where('line_no',$request->line_no);
            }
            $scrap_declrations = $scrap_declrations->latest()->get();
            return view('scrap_declrations.ajaxIndex', compact('scrap_declrations'));
        }
        $department_id = ReuseableCode::getUserWiseDepartmentRights();
        $subDepartmentList = DB::table('sub_department')->whereIn('id', $department_id)->select('id','sub_department_name')->get();
        $lines = Line::where('status', 1)->get();
        return view('scrap_declrations.index',  compact('subDepartmentList','lines'));
    }
    
    public function create()
    {
        $company_locations = ReuseableCode::getUserWiseLocationRights();
        $company_locations = CompanyLocation::whereIn('id', $company_locations)->get()->toArray();
        $department_id = ReuseableCode::getUserWiseDepartmentRights();
        $subDepartmentList = DB::table('sub_department')->whereIn('id', $department_id)->select('id','sub_department_name')->get();
         $lines = Line::where('status', 1)->get();
        return view('scrap_declrations.create', compact('company_locations','subDepartmentList','lines'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();

            $location = Input::get('company_location_id');
            $str = ScrapDeclration::where('company_location_id', $location)->orderBy('id', 'desc')->count();
            $arp_no = 'SD-' . CommonHelper::getCompanyLocationPrefix($location) . '-' . sprintf("%'05d", ($str + 1)); // . date('my');
            $request['sd_no'] = strtoupper($arp_no);
            
            $ScrapDeclration = new ScrapDeclration();
            $ScrapDeclration->sd_no = strtoupper($arp_no);
            $ScrapDeclration->requested_by = Auth::user()->name;
            $ScrapDeclration->company_location_id = $request->company_location_id;
            $ScrapDeclration->sd_remarks = $request->sd_remarks;
            $ScrapDeclration->department_id = $request->department_id;
            $ScrapDeclration->line_no = $request->line_no;
            $ScrapDeclration->sd_date = date('d-m-Y',strtotime($request->sd_date));
            $ScrapDeclration->save();

            foreach ($request->item as $key => $value) {
                
                if($value != ''){
                    $item = explode('%',$value);
                    ScrapDeclrationData::create([
                        'scrap_declration_id' => $ScrapDeclration->id,
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
            Session::flash('dataInsert', "Data Successfully Added");
            return Redirect::to('purchase/scrap_declrations?pageType=&&parentCode=243&&m='.session('run_company').'#Garibsons');
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    public function ViewScrapDeclration(Request $request)
    {
        
        $id = $request->id;
        $scrap_declration = ScrapDeclration::where('id' , $id)->where('status', 1)->first();
        return view('scrap_declrations.show' , compact('scrap_declration'));
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

    public function delete_scrap_declration(Request $request)
    {
        $ScrapDeclration = ScrapDeclration::find($request->id)->update(['status' => 0]);
        
        return 'Deleted';
    }

    public function gmApproval(Request $request){
        $scrap = ScrapDeclration::find($request->scrap_id);
        $scrap->gm_approval_status = $request->gm_approval_status;
        $scrap->gm_approval_username = Auth::user()->name;
        $scrap->gm_date_time = Carbon::now()->format('Y-m-d H:i:s');
        $scrap->gm_description = $request->gm_description;
        $scrap->save();
        return "updated";
    }

    public function audApproval(Request $request){
        $scrap = ScrapDeclration::find($request->scrap_id);
        $scrap->aud_approval_status = $request->aud_approval_status;
        $scrap->aud_approval_username = Auth::user()->name;
        $scrap->aud_date_time = now()->format('Y-m-d H:i:s');
        $scrap->aud_description = $request->aud_description;
        $scrap->save();
        return "updated";
    }

    public function approve_scrap_declration(Request $request){
        $scrap = ScrapDeclration::find($request->scrap_id);
        $scrap->scrap_approve = $request->approval_status;
        $scrap->approve_name = Auth::user()->name;
        $scrap->approve_date = now()->format('Y-m-d H:i:s');
        $scrap->save();
        return "updated";
    }

}

