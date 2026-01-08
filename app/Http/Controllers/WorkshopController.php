<?php

namespace App\Http\Controllers;

use App\CompanyLocation;
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
use App\Models\Attachement;
use App\Models\Department;
use App\Models\GoodsReturn;
use App\Models\GoodsReturnData;
use App\Models\Line;
use App\Models\Machinery;
use App\Models\GatePass;
use App\Models\MaintenanceInvoice;
use App\Models\MaintenanceInvoiceData;
use App\Models\MaintenanceJob;
use App\Models\MaintenanceJobData;
use App\Models\MaintenanceReauestData;
use App\Models\MaintenanceRequest;
use App\Models\WorkshopGrn;
use App\Models\AnalyzingReportDetail;
use App\Models\AnalyzingReportDetailData;
use App\Models\WorkshopGrnData;
use App\Models\WorkshopMaterialIssuance;
use App\Models\WorkshopMaterialIssuanceData;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class WorkshopController extends Controller
{
    public function createMaintenanceRequestForm()
    {
        $departments = Department::where([['status', '=', '1'],])->select('id', 'department_name')->orderBy('id')->get();
        $lines = Line::where('status', 1)->get();
        $machineries = Machinery::where('status', 1)->get();
        return view('Workshop.createMaintenanceRequestForm', compact('machineries', 'lines', 'departments'));
    }

    public function addMaintenanceRequestDetail(Request $request)
    {
        DB::connection('mysql2')->beginTransaction();
        try {
            $request['voucher_no'] = CommonHelper::getMRVoucherNumber();
            $request['username'] = Auth::user()->name;
            $request['voucher_status'] = 2;
            // dd($request->all());
            $maintenanceRequest = MaintenanceRequest::create($request->all());
            foreach ($request->item_id as $key => $valueOne) {
                MaintenanceReauestData::create([
                    'maintenance_request_id' => $maintenanceRequest->id,
                    'item_id' => $valueOne,
                    'qty' => $request->qty[$key],
                ]);
            }
            $file = Input::file('file');
            if (isset($file)) {
                foreach ($file as $key => $value) {
                    $d1 =   $value->getClientOriginalName();
                    $d2 =  $value->getClientOriginalExtension();
                    $d3 =  $value->getRealPath();
                    $newfilename = date('dmYHis') . str_replace(" ", "", basename($value->getClientOriginalName()));
                    $value->move(public_path('uploads/attachement'), $newfilename);

                    $attachment =  new Attachement();
                    $attachment->image_src = 'public/uploads/attachement/' . $newfilename;
                    $attachment->status = 1;
                    $maintenanceRequest->comments()->save($attachment);
                }
            }

            DB::connection('mysql2')->commit();
            Session::flash('dataInsert', "Request successfully saved");
            return redirect('/workshop/MaintenanceRequestList');
        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            echo "Error " . $e->getLine();
            dd($e->getMessage());
        }
    }

    public function processTrackingSummaryReport(Request $request){
        $company_locations = ReuseableCode::getUserWiseWarehouseRightsData();
        //dd($company_locations);
        if($request->ajax()){
            $getDetail = DB::Connection('mysql2')->select('SELECT 
                    mrd.item_id,mrd.qty as mrdQty,mr.voucher_no as mrVoucherNo,ls.name as line_name,mr.voucher_date as mrVoucherDate, mr.department_id,mr.line_id,
                    case 
                        when mr.voucher_status = 1 then "Pending"
                        when mr.voucher_status = 2 then "Approved"
                    end mrVoucherStatus,
                    mj.voucher_no as mjVoucherNo,mj.voucher_date as mjVoucherDate,
                    case 
                        when mj.job_type = 1 then "In-House"
                        when mj.job_type = 2 then "Out-Source"
                        when mj.job_type = 3 then "In-House Other Warehouse"
                        when mj.job_type = 4 then "In-House  Corrective Maintenace"
                    end mjJobType,
                    case 
                        when mj.voucher_status = 1 then "Pending"
                        when mj.voucher_status = 2 then "Approved"
                    end mjVoucherStatus,
                    mi.voucher_no as miVoucherNo,mi.voucher_date as miVoucherDate, mi.id as mi_id, mi.labour_hour, mi.labour_wage,
                    case 
                        when mi.voucher_status = 1 then "Pending"
                        when mi.voucher_status = 2 then "Approved"
                    end miVoucherStatus,
                    gpo.gate_pass_no as gpoGatePassNo,gpo.gate_pass_date as gpoGatePassDate,
                    case 
                        when gpo.voucher_status = 1 then "Pending"
                        when gpo.voucher_status = 2 then "Approved"
                    end gpoVoucherStatus,
                    gpi.gate_pass_no as gpiGatePassNo,gpi.gate_pass_date as gpiGatePassDate,
                    case 
                        when gpi.voucher_status = 1 then "Pending"
                        when gpi.voucher_status = 2 then "Approved"
                    end gpiVoucherStatus,
                    wg.voucher_no as wgVoucherNo,wg.voucher_date as wgVoucherDate, wg.id as grn_id,
                    case 
                        when wg.voucher_status = 1 then "Pending"
                        when wg.voucher_status = 2 then "Approved"
                    end wgVoucherStatus,
                    wmi.voucher_no as wmiVoucherNo,wmi.voucher_date as wmiVoucherDate,
                    case 
                        when wmi.voucher_status = 1 then "Pending"
                        when wmi.voucher_status = 2 then "Approved"
                    end wmiVoucherStatus,
                    s.sub_ic,
                    w.name as warehouseName,
                    mj.supplier_id
                FROM maintenance_reauest_datas as mrd 
                INNER JOIN maintenance_requests as mr on mrd.maintenance_request_id = mr.id
                
                INNER JOIN subitem as s on mrd.item_id = s.id
                INNER JOIN `lines` as ls on mr.line_id = ls.id
                INNER JOIN warehouse as w on mr.warehouse_id = w.id
                LEFT JOIN maintenance_jobs as mj on mr.id = mj.maintenance_request_id
                LEFT JOIN maintenance_invoices as mi on mj.id = mi.maintenance_job_id
                LEFT JOIN gate_passes as gpo on mj.id = gpo.maintenance_job_id and gpo.gate_pass_type = 2
                LEFT JOIN gate_passes as gpi on mj.id = gpi.maintenance_job_id and gpi.gate_pass_type = 1
                LEFT JOIN workshop_grns as wg on mj.id = wg.maintenance_job_id and gpi.id = wg.gate_pass_id
                LEFT JOIN workshop_material_issuances as wmi on mj.id = wmi.maintenance_job_id
                -- LEFT JOIN workshop_grns as wg on mj.id = wg.maintenance_job_id
                where mr.voucher_date between "'.$request->from_date.'" and "'.$request->last_date.'" and mr.warehouse_id = '.$request->company_location_id.'
            ');
            return view('Workshop.processTrackingSummaryReportAjax',compact('getDetail'));
        }
        return view('Workshop.processTrackingSummaryReport',compact('company_locations'));
    }

    public function MaintenanceRequestList(Request $request)
    {
        $company_locations = ReuseableCode::getUserWiseWarehouseRightsData();
       
        // dd($company_locations);
        if ($request->ajax()) {
            $edit = ReuseableCode::check_rights(581);
            $view = ReuseableCode::check_rights(582);
            $delete = ReuseableCode::check_rights(583);
            if ($request->company_location_id) {
                $company_locations = array($request->company_location_id);
            } else {
                $company_locations = ReuseableCode::getUserWiseWarehouseRights();
            }
            $maintenanceRequests = MaintenanceRequest::whereBetween('voucher_date', [$request->from_date, $request->last_date])->whereIn('warehouse_id', $company_locations)->where('status', 1)->orderBy('id', 'desc')->get();
            return view('Workshop.MaintenanceRequestListAjax', compact('maintenanceRequests','edit','view','delete'));
        }
        return view('Workshop.MaintenanceRequestList', compact('company_locations'));
    }
    public function viewMaintenanceRequestDetail(Request $request)
    {
        $maintenanceRequest = MaintenanceRequest::find($request->id);
        return view('Workshop.viewMaintenanceRequestDetail', compact('maintenanceRequest'));
    }
    public function approvedMaintenanceRequest(Request $request)
    {
        $maintenanceRequest = MaintenanceRequest::find($request->id);
        $maintenanceRequest->update(['voucher_status' => 2]);
        return "success";
    }

    public function editMaintenanceRequest(Request $request)
    {
        $maintenanceRequest = MaintenanceRequest::find($request->id);
        $departments = Department::where([['status', '=', '1'],])->select('id', 'department_name')->orderBy('id')->get();
        $lines = Line::where('status', 1)->get();
        $machineries = Machinery::where('status', 1)->get();
        return view('Workshop.editMaintenanceRequest', compact('maintenanceRequest', 'departments', 'lines', 'machineries'));
    }

    public function maintenanceRequestUpdate(Request $request)
    {
        // dd($request->all());


        DB::connection('mysql2')->beginTransaction();
        try {
            $maintenanceRequest = MaintenanceRequest::find($request->id);
            $maintenanceRequest->voucher_date = $request->voucher_date;
            $maintenanceRequest->department_id = $request->department_id;
            $maintenanceRequest->machine_id = $request->machine_id;
            $maintenanceRequest->line_id = $request->line_id;
            $maintenanceRequest->warehouse_id = $request->warehouse_id;
            $maintenanceRequest->description = $request->description;
            $maintenanceRequest->analysing_required = $request->analysing_required;
            $maintenanceRequest->submit_date = $request->submit_date;

            $maintenanceRequest->save();
            MaintenanceReauestData::where('maintenance_request_id', $maintenanceRequest->id)->update(['status' => 0]);
            foreach ($request->item_id as $key => $valueOne) {
                MaintenanceReauestData::create([
                    'maintenance_request_id' => $maintenanceRequest->id,
                    'item_id' => $valueOne,
                    'qty' => $request->qty[$key],
                ]);
            }
            $file = Input::file('file');
            if (isset($file)) {
                foreach ($file as $key => $value) {
                    $d1 =   $value->getClientOriginalName();
                    $d2 =  $value->getClientOriginalExtension();
                    $d3 =  $value->getRealPath();
                    $newfilename = date('dmYHis') . str_replace(" ", "", basename($value->getClientOriginalName()));
                    $value->move(public_path('uploads/attachement'), $newfilename);

                    $attachment =  new Attachement();
                    $attachment->image_src = 'public/uploads/attachement/' . $newfilename;
                    $attachment->status = 1;
                    $maintenanceRequest->comments()->save($attachment);
                }
            }

            DB::connection('mysql2')->commit();
            Session::flash('dataInsert', "Request successfully saved");
            return redirect('/workshop/MaintenanceRequestList');
        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            echo "Error " . $e->getLine();
            dd($e->getMessage());
        }
    }

    
    public function deleteMaintenanceJob(Request $request)
    {
        $maintenance_jobs = MaintenanceJob::find($request->item);
        $maintenance_invoices=MaintenanceInvoice::where('status',1)->where('maintenance_job_id',$request->item);
        $grn = WorkshopGrn::where('status',1)->where('maintenance_job_id',$request->item);
        if($maintenance_invoices->count()>0){
            return "Can Not be Deleted, BOM Invoice Created";
        }elseif($grn->count() > 0){
            return "Can Not be Deleted, GRN is Created";
        }
        else{
            $maintenance_jobs->status = 0;
            $maintenance_jobs->save();
            return "Deleted";
        }
        
    }

    public function deleteMaintenanceRequest(Request $request)
    {
        $maintenanceRequest = MaintenanceRequest::find($request->id);
        $maintenance_jobs = MaintenanceJob::where('status',1)->where('maintenance_request_id',$request->id);
        if($maintenance_jobs->count() > 0){
            return "Can not be deleted. Maintainance Job is created";
        }else{
            $maintenanceRequest->status = 0;
            $maintenanceRequest->save();
            return "Deleted";
        }
        
    }

    public function deleteAnalyzingMr(Request $request)
    {
        $AnalyzingReportDetail = AnalyzingReportDetail::find($request->id);
        $AnalyzingReportDetailData = AnalyzingReportDetailData::where('analyzing_mr_id',$request->id)->first();
        $AnalyzingReportDetail->status = 0;
        $AnalyzingReportDetailData->status = 0;
        $AnalyzingReportDetail->save();
        $AnalyzingReportDetailData->save();
        return "Deleted";
        
        
    }
    


    public function getMRItemsData(Request $request)
    {
        $maintenanceRequest = MaintenanceRequest::find($request->id);
        return view('Workshop.getMRItemsData', compact('maintenanceRequest'));
    }



    public function createMaintenanceJobForm()
    {
        $company_locations = ReuseableCode::getUserWiseLocationRights();
        $company_locations = CompanyLocation::whereIn('id', $company_locations)->get()->toArray();

        $departments = Department::where([['status', '=', '1'],])->select('id', 'department_name')->orderBy('id')->get();
        $maintenanceRequest = MaintenanceRequest::doesntHave('maintenanceJob')
                            ->where('status', 1)
                            ->where('voucher_status', 2)
                            ->where(function ($query) {
                                $query->where('maintenance_requests.analysing_required', 'no')
                                    ->orWhere(function ($query) {
                                        $query->where('maintenance_requests.analysing_required', 'yes')
                                                ->whereExists(function ($query) {
                                                    $query->select(DB::raw(1))
                                                        ->from('analyzing_mr')
                                                        ->whereColumn('analyzing_mr.maintenance_request_id', 'maintenance_requests.id');
                                                });
                                    });
                            })->get();
        // $maintenanceRequest = MaintenanceRequest::doesntHave('maintenanceJob')->where([['status', 1],['analysing_required', 'no'], ['voucher_status', 2]])->get();
        return view('Workshop.createMaintenanceJobForm', compact('maintenanceRequest', 'departments',));
    }

    public function addMaintenanceJobDetail(Request $request)
    {

        DB::connection('mysql2')->beginTransaction();
        try {
            $request['username'] = Auth::user()->name;
            if ($request->job_type == 1 || $request->job_type == 4) {
                $request['voucher_no'] = CommonHelper::getMJVoucherNumber();
                $request['supplier_id'] = null;
            } else {
                $request['voucher_no'] = CommonHelper::getMJOVoucherNumber();
            }
            $request['description'] =  $request['description'] ?? '';
            // dd($request->all());
            $MJ = MaintenanceJob::create($request->all());
            foreach ($request->item_id as $key => $value) {
                MaintenanceJobData::create([
                    'maintenance_job_id' => $MJ->id,
                    'item_id' => $value,
                    'qty' => $request->qty[$key],
                    'item_description' =>  $request->item_description[$key] ?? '',
                    'username' => Auth::user()->name,
                ]);
            }
            $file = Input::file('file');
            if (isset($file)) {
                foreach ($file as $key => $value) {
                    $d1 =   $value->getClientOriginalName();
                    $d2 =  $value->getClientOriginalExtension();
                    $d3 =  $value->getRealPath();
                    $newfilename = date('dmYHis') . str_replace(" ", "", basename($value->getClientOriginalName()));
                    $value->move(public_path('uploads/attachement'), $newfilename);

                    $attachment =  new Attachement();
                    $attachment->image_src = 'public/uploads/attachement/' . $newfilename;
                    $attachment->status = 1;
                    $MJ->comments()->save($attachment);
                }
            }
            DB::connection('mysql2')->commit();
            Session::flash('dataInsert', "Request successfully saved");
            return redirect('/workshop/MaintenanceJobList');
        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            echo "Error " . $e->getLine();
            dd($e->getMessage());
        }
    }

    public function editMaintenanceJob(Request $request)
    {
        $maintenanceJob = MaintenanceJob::find($request->id);
        return view('Workshop.editMaintenanceJob', compact('maintenanceJob'));
        // dd($request->all());
    }

    public function analyzingReportForm(){

        $maintenance_requests=MaintenanceRequest::where('status',1)->get();
        return view('Workshop.analyzingReportForm',compact('maintenance_requests'));
    }

    public function analyzingReportFormDetail(Request $request){

        return view('Workshop.analyzingReportFormDetail');
    }

    public function getMaintenanceRequestDataForGoodsReturn(Request $request){
        if (!$request->id) {
            return "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center'><h2 class='text-danger'>Please Select Maintenance Request No..</h2></div>";
        }

        $maintenanceRequest = MaintenanceRequest::find($request->id);
        return view('Workshop.analyzingReportFormDetail',compact('maintenanceRequest'));
    }

    
    public function analyzingReportView(Request $request)
    {
        $AnalyzingReportDetail = AnalyzingReportDetail::where('status',1)->get();
        return view('Workshop.analyzingReportView', compact('AnalyzingReportDetail'));
    }

    public function viewAnalyzingReportDetail(Request $request)
    {
        $AnalyzingReportDetail = AnalyzingReportDetail::whereBetween('date', [$request->from_date, $request->last_date])->where('status', 1)->orderBy('id', 'desc')->get();
        return view('Workshop.viewAnalyzingReportDetail', compact('AnalyzingReportDetail'));
    }

    public function viewAnalyzingDetail(Request $request)
    {
        $AnalyzingReportDetail = AnalyzingReportDetail::with('analyzingReportDetailData','maintenanceRequest')->find($request->id);
        return view('Workshop.viewAnalyzingDetail', compact('AnalyzingReportDetail'));
    }
    
    
    public function addAnalyzingReportDetail(Request $request){
        
        DB::connection('mysql2')->beginTransaction();
        try {
            $data1 = $request->all();

            $fieldsToExclude = ['m','equipment_reference', 'section', 'category','common_issue','staff_intelegence','detail'];
            
            foreach ($fieldsToExclude as $field) {
                if (isset($data1[$field])) {
                    unset($data1[$field]);
                }
            }
            



            $data1['status']=1;
            $data1['username']=auth()->user()->name;
            $data1['date']=date('Y-m-d');
            $data1['time']=date('H-i-s');
            $analyzingReportDetail = new AnalyzingReportDetail();
            $analyzingReportDetail->fill($data1);
            $analyzingReportDetail->save();

            $equipment_reference='';
            $section='';
            $category='';
            $common_issue='';
            $staff_intelegence='';
            foreach($request->equipment_reference as $val){
                $equipment_reference.=$val.'=>';
            }
            foreach($request->section as $val){
                $section.=$val.'=>';
            }
            foreach($request->category as $val){
                $category.=$val.'=>';
            }
            foreach($request->common_issue as $val){
                $common_issue.=$val.'=>';
            }
            foreach($request->staff_intelegence as $val){
                $staff_intelegence.=$val.'=>';
            }

            $analyzingReportDetailData = new AnalyzingReportDetailData();

            $data2['analyzing_mr_id']= $analyzingReportDetail->id;
            $data2['equipment_reference']=$equipment_reference;
            $data2['section']=$section;
            $data2['category']=$category;
            $data2['common_issue']=$common_issue;
            $data2['staff_intelegence']=$staff_intelegence;
            $data2['detail']=$request->detail;
            $data2['status']=1;
            $data2['username']=auth()->user()->name;
            $data2['date']=date('Y-m-d');
            $data2['time']=date('H-i-s');

            $analyzingReportDetailData->fill($data2);
            $analyzingReportDetailData->save();


            DB::connection('mysql2')->commit();
            Session::flash('dataInsert', "Request successfully saved");
            return redirect('/workshop/analyzingReportview');
        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            echo "Error " . $e->getLine();
            dd($e->getMessage());
        }


    }

    public function maintenanceJobUpdate(Request $request)
    {

        // dd($request->all());

        DB::connection('mysql2')->beginTransaction();
        try {
            $request['username'] = Auth::user()->name;
            if ($request->job_type == 1  || $request->job_type == 4) {
                $request['supplier_id'] = null;
            }
            $request['description'] =  $request['description'] ?? '';
            // dd($request->all());
            $MJ = MaintenanceJob::find($request->id);
            $MJ->maintenance_request_id = $request->maintenance_request_id;
            $MJ->voucher_date = $request->voucher_date;
            $MJ->warehouse_id = $request->warehouse_id;
            $MJ->warehouse_id_to = $request->warehouse_id_to;
            $MJ->job_type = $request->job_type;
            $MJ->supplier_id = $request->supplier_id;
            $MJ->description = $request->description;
            $MJ->save();
            MaintenanceJobData::where('maintenance_job_id', $MJ->id)->update(['status' => 0]);
            foreach ($request->item_id as $key => $value) {
                MaintenanceJobData::create([
                    'maintenance_job_id' => $MJ->id,
                    'item_id' => $value,
                    'qty' => $request->qty[$key],
                    'item_description' =>  $request->item_description[$key] ?? '',
                    'username' => Auth::user()->name,
                ]);
            }
            $file = Input::file('file');
            if (isset($file)) {
                foreach ($file as $key => $value) {
                    $d1 =   $value->getClientOriginalName();
                    $d2 =  $value->getClientOriginalExtension();
                    $d3 =  $value->getRealPath();
                    $newfilename = date('dmYHis') . str_replace(" ", "", basename($value->getClientOriginalName()));
                    $value->move(public_path('uploads/attachement'), $newfilename);

                    $attachment =  new Attachement();
                    $attachment->image_src = 'public/uploads/attachement/' . $newfilename;
                    $attachment->status = 1;
                    $MJ->comments()->save($attachment);
                }
            }
            DB::connection('mysql2')->commit();
            Session::flash('dataInsert', "Request successfully saved");
            return redirect('/workshop/MaintenanceJobList');
        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            echo "Error " . $e->getLine();
            dd($e->getMessage());
        }
    }


    public function MaintenanceJobList(Request $request)
    {
        $company_locations = ReuseableCode::getUserWiseLocationRightsData();
        // dd($request->company_location_id);
        if ($request->ajax()) {
            $edit = ReuseableCode::check_rights(581);
            $view = ReuseableCode::check_rights(582);
            $delete = ReuseableCode::check_rights(583);
            if ($request->company_location_id) {
                $company_locations = array($request->company_location_id);
            } else {
                $company_locations = ReuseableCode::getUserWiseLocationRights();
            }
            $maintenanceJobs = MaintenanceJob::whereBetween('voucher_date', [$request->from_date, $request->last_date])->whereIn('warehouse_id', $company_locations)->where('status', 1)->orderBy('id', 'desc')->get();
            return view('Workshop.MaintenanceJobListAjax', compact('maintenanceJobs','edit','view','delete'));
        }
        return view('Workshop.MaintenanceJobList',compact('company_locations'));
    }
    public function viewMaintenanceJobDetail(Request $request)
    {
        $maintenanceJob = MaintenanceJob::find($request->id);
        return view('Workshop.viewMaintenanceJobDetail', compact('maintenanceJob'));
    }
    public function approvedMaintenanceJob(Request $request)
    {
        DB::connection('mysql2')->beginTransaction();
        try {
            $maintenanceJob = MaintenanceJob::find($request->id);
            // $data = MaintenanceJobData::where([['maintenance_job_id', $request->id], ['status', 1]])->get();

            // foreach ($data as $value) {

            //     $valueQty = number_format($value->qty, 2);
            //     $valueQty = str_replace(',', '', $valueQty);
            //     $qty =  floatval(ReuseableCode::get_stock($value->item_id, $maintenanceJob->maintenanceRequest->warehouse_id, 0, 0));
            //     $valueQty = floatval($valueQty);
            //     if ($qty < $valueQty) {
            //         DB::connection('mysql2')->rollback();
            //         $message = ['error' => 'error', 'message' => ""];
            //         return  $message;
            //     }
            //     // ReuseableCode::post_stock($value->item_id, $maintenanceJob->maintenanceRequest->warehouse_id, 0, $request->id, $value->id, $maintenanceJob->voucher_no, $maintenanceJob->voucher_date, $valueQty, 14);
            // }
            $maintenanceJob->voucher_status = 2;
            $maintenanceJob->save();
            DB::connection('mysql2')->commit();
            $message = ['error' => 'success'];
            return  $message;
        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e->getMessage());
        }
    }


    public function createGoodsReturnForm()
    {
        $maintenanceJobs = MaintenanceJob::doesntHave('maintenanceInvoice')->where([['voucher_status', 2],  ['status', 1]])->whereIn('job_type', [1,4])->get();
        return view('Workshop.createGoodsReturnForm', compact('maintenanceJobs'));
    }

    public function getMaintenanceJobDataForGoodsReturn(Request $request)
    {
        if (!$request->id) {
            return "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center'><h2 class='text-danger'>Please Select Maintenance Job No..</h2></div>";
        }

        $maintenanceJob = MaintenanceJob::find($request->id);
        $departments = Department::where([['status', '=', '1'],])->select('id', 'department_name')->orderBy('id')->get();
        return view('Workshop.getMaintenanceJobDataForGoodsReturn', compact('departments', 'maintenanceJob'));
    }


    public function addGoodsReturnDetails(Request $request)
    {
        // dd($request->all());
        $request['voucher_no'] = CommonHelper::getGRVoucherNumber();
        $request['username'] = Auth::user()->name;
        // dd($request->all());
        $GR = GoodsReturn::create($request->all());
        foreach ($request->item_id as $key => $value) {
            GoodsReturnData::create([
                'goods_return_id' => $GR->id,
                'quality_type' => $request->quality_type[$key],
                'item_id' => $value,
                'item_remark' => $request->item_remark[$key] ?? '',
                'qty' => $request->qty[$key],
                'rate' => $request->rate[$key],
                'total' =>  $request->total[$key],
            ]);
        }
        Session::flash('dataInsert', "Request successfully saved");
        return redirect('/workshop/GoodsReturnList');
    }

    public function GoodsReturnList(Request $request)
    {
        if ($request->ajax()) {
            $goodsReturns = GoodsReturn::where('status', 1)->orderBy('id', 'desc')->get();
            return view('Workshop.GoodsReturnListAjax', compact('goodsReturns'));
        }
        return view('Workshop.GoodsReturnList');
    }
    public function viewGoodsReturnDetail(Request $request)
    {
        $goodsReturns = GoodsReturn::find($request->id);
        return view('Workshop.viewGoodsReturnDetail', compact('goodsReturns'));
    }

    public function approvedGoodsReturnDetails(Request $request)
    {
        DB::connection('mysql2')->beginTransaction();
        try {
            $goodsReturn = GoodsReturn::find($request->id);
            // $data = MaintenanceJobData::where([['maintenance_job_id', $request->id], ['status', 1]])->get();

            // foreach ($data as $value) {

            //     $valueQty = number_format($value->qty, 2);
            //     $valueQty = str_replace(',', '', $valueQty);
            //     $qty =  floatval(ReuseableCode::get_stock($value->item_id, $maintenanceJob->maintenanceRequest->warehouse_id, 0, 0));
            //     $valueQty = floatval($valueQty);
            //     if ($qty < $valueQty) {
            //         DB::connection('mysql2')->rollback();
            //         $message = ['error' => 'error', 'message' => ""];
            //         return  $message;
            //     }
            //     // ReuseableCode::post_stock($value->item_id, $maintenanceJob->maintenanceRequest->warehouse_id, 0, $request->id, $value->id, $maintenanceJob->voucher_no, $maintenanceJob->voucher_date, $valueQty, 14);
            // }
            $goodsReturn->voucher_status = 2;
            $goodsReturn->save();
            DB::connection('mysql2')->commit();
            $message = ['error' => 'success'];
            return  $message;
        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e->getMessage());
        }
    }


    public function CreateMaintenanceInvoiceForm(Request $request)
    {
        $maintenanceJobs = MaintenanceJob::doesntHave('maintenanceInvoice')->where([['voucher_status', 2], ['status', 1]])->whereIn('job_type', [1,4])->get();
        return view('Workshop.CreateMaintenanceInvoiceForm', compact('maintenanceJobs'));
    }
    public function EditMaintenanceInvoiceForm(Request $request)
    {
        $maintenanceInvoice = MaintenanceInvoice::with('invoiceData')->findOrFail($_GET['id']);
        $departments = Department::where([['status', '=', '1'],])->select('id', 'department_name')->orderBy('id')->get();
        $maintenanceJob = MaintenanceJob::find($maintenanceInvoice->maintenance_job_id);
        // dd($maintenanceInvoice);
        return view('Workshop.EditMaintenanceInvoiceForm', compact('maintenanceJob', 'departments', 'maintenanceInvoice'));
    }

    public function getMaintenanceJobDataForMaintenanceInvoice(Request $request)
    {
        $departments = Department::where([['status', '=', '1'],])->select('id', 'department_name')->orderBy('id')->get();
        $maintenanceJob = MaintenanceJob::find($request->id);

        $subitems = DB::connection('mysql2')->table('subitem AS s')->join('inno_garibsons_master.uom AS u', 's.uom','=', 'u.id')->where('s.status', 1)->select('s.id','s.sku_code','s.sub_ic','s.item_code','u.uom_name')->get()->toArray();
        
        return view('Workshop.getMaintenanceJobDataForMaintenanceInvoice', compact('maintenanceJob', 'departments','subitems'));
    }

    public function addMaintenanceInvoiceDetail(Request $request)
    {
        DB::connection('mysql2')->beginTransaction();
        try {
            // dd($request);
            $request['voucher_no'] = CommonHelper::getMIVoucherNumber();
            $request['username'] = Auth::user()->name;
            $request['instruct_by'] = $request->instruct_by ?? '';
            $request['completed_by'] = $request->completed_by ?? '';
            // dd($request->all());
            $invoice = MaintenanceInvoice::create($request->all());
            foreach ($request->item_id as $key => $value) {
                MaintenanceInvoiceData::create([
                    'maintenance_invoice_id' => $invoice->id,
                    'item_id' => $value,
                    'qty' => $request->qty[$key],
                    'rate' => $request->rate[$key],
                    'total' => $request->total[$key],
                    'return_qty' => $request->return_qty[$key],
                ]);
            }
            DB::connection('mysql2')->commit();
            Session::flash('dataInsert', "Request successfully saved");
            return redirect('/workshop/viewMaintenanceInvoiceList');
        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            echo "Error " . $e->getLine();
            dd($e->getMessage());
        }
    }

    public function UpdateMaintenanceInvoiceDetail(Request $request)
    {
        DB::connection('mysql2')->beginTransaction();
        try {
            $invoice = MaintenanceInvoice::find($request->invoice_id);

            // $request['voucher_no'] = CommonHelper::getMIVoucherNumber();
            // $request['username'] = Auth::user()->name;
            $request['instruct_by'] = $request->instruct_by ?? '';
            $request['completed_by'] = $request->completed_by ?? '';
            // dd($request->all());
            $invoice->update($request->all());

            MaintenanceInvoiceData::where('maintenance_invoice_id' , $invoice->id)->delete();
            foreach ($request->item_id as $key => $value) {
                MaintenanceInvoiceData::create([
                    'maintenance_invoice_id' => $invoice->id,
                    'item_id' => $value,
                    'qty' => $request->qty[$key],
                    'rate' => $request->rate[$key],
                    'total' => $request->total[$key],
                    'return_qty' => $request->return_qty[$key],
                ]);
            }
            DB::connection('mysql2')->commit();
            Session::flash('dataInsert', "Request successfully Update");
            return redirect('/workshop/viewMaintenanceInvoiceList');
        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            echo "Error " . $e->getLine();
            dd($e->getMessage());
        }
    }

    public function viewMaintenanceInvoiceList(Request $request)
    {
        if ($request->ajax()) {
            $maintenanceInvoices = MaintenanceInvoice::where('status', 1)->orderBy('id', 'desc')->get();
            return view('Workshop.viewMaintenanceInvoiceListAjax', compact('maintenanceInvoices'));
        }
        return view('Workshop.viewMaintenanceInvoiceList');
    }
    public function viewMaintenanceInvoiceDetail(Request $request)
    {

        $maintenanceInvoice = MaintenanceInvoice::find($request->id);
        return view('Workshop.viewMaintenanceInvoiceDetail', compact('maintenanceInvoice'));
    }
    public function viewMaintenanceInvoiceSummary(Request $request)
    {
        $company_locations = ReuseableCode::getUserWiseWarehouseRightsData();
        if ($request->ajax()) {
            $getDetail = DB::Connection('mysql2')->select('SELECT 
                    mrd.item_id,mrd.qty as mrdQty,l.name as line_name,mr.voucher_no as mrVoucherNo, mr.department_id,mr.voucher_date as mrVoucherDate,mid.item_id as miditem_id,mid.qty as midqty,mid.rate as midrate,mid.total as midtotal,mid.return_qty as midreturn_qty,
                    case 
                        when mr.voucher_status = 1 then "Pending"
                        when mr.voucher_status = 2 then "Approved"
                    end mrVoucherStatus,
                    mj.voucher_no as mjVoucherNo,mj.voucher_date as mjVoucherDate,
                    case 
                        when mj.job_type = 1 then "In-House"
                        when mj.job_type = 2 then "Out-Source"
                        when mj.job_type = 3 then "In-House Other Warehouse"
                        when mj.job_type = 4 then "In-House Corrective Maintenace"
                    end mjJobType,
                    case 
                        when mj.voucher_status = 1 then "Pending"
                        when mj.voucher_status = 2 then "Approved"
                    end mjVoucherStatus,
                    mi.voucher_no as miVoucherNo,mi.voucher_date as miVoucherDate, mi.id as mi_id, mi.labour_hour, mi.labour_wage,
                    case 
                        when mi.voucher_status = 1 then "Pending"
                        when mi.voucher_status = 2 then "Approved"
                    end miVoucherStatus,
                    -- gpo.gate_pass_no as gpoGatePassNo,gpo.gate_pass_date as gpoGatePassDate,
                    -- case 
                    --     when gpo.voucher_status = 1 then "Pending"
                    --     when gpo.voucher_status = 2 then "Approved"
                    -- end gpoVoucherStatus,
                    -- gpi.gate_pass_no as gpiGatePassNo,gpi.gate_pass_date as gpiGatePassDate,
                    -- case 
                    --     when gpi.voucher_status = 1 then "Pending"
                    --     when gpi.voucher_status = 2 then "Approved"
                    -- end gpiVoucherStatus,
                    -- wg.voucher_no as wgVoucherNo,wg.voucher_date as wgVoucherDate,
                    -- case 
                    --     when wg.voucher_status = 1 then "Pending"
                    --     when wg.voucher_status = 2 then "Approved"
                    -- end wgVoucherStatus,
                    -- wmi.voucher_no as wmiVoucherNo,wmi.voucher_date as wmiVoucherDate,
                    -- case 
                    --     when wmi.voucher_status = 1 then "Pending"
                    --     when wmi.voucher_status = 2 then "Approved"
                    -- end wmiVoucherStatus,
                    s.sub_ic,
                    w.name as warehouseName
                FROM maintenance_reauest_datas as mrd 
                INNER JOIN maintenance_requests as mr on mrd.maintenance_request_id = mr.id
                
                INNER JOIN subitem as s on mrd.item_id = s.id
                INNER JOIN `lines` as l on mr.line_id = l.id
                INNER JOIN warehouse as w on mr.warehouse_id = w.id
                LEFT JOIN maintenance_jobs as mj on mr.id = mj.maintenance_request_id
                LEFT JOIN maintenance_invoices as mi on mj.id = mi.maintenance_job_id
                LEFT JOIN maintenance_invoice_datas as mid on mi.id = mid.maintenance_invoice_id
                -- LEFT JOIN gate_passes as gpo on mj.id = gpo.maintenance_job_id and gpo.gate_pass_type = 2
                -- LEFT JOIN gate_passes as gpi on mj.id = gpi.maintenance_job_id and gpi.gate_pass_type = 1
                -- LEFT JOIN workshop_grns as wg on mj.id = wg.maintenance_job_id and gpi.id = wg.gate_pass_id
                -- LEFT JOIN workshop_material_issuances as wmi on mj.id = wmi.maintenance_job_id
                -- LEFT JOIN workshop_grns as wg on mj.id = wg.maintenance_job_id
                
                where mr.voucher_date between "'.$request->from_date.'" and "'.$request->last_date.'" and mr.warehouse_id = '.$request->company_location_id.' AND mj.job_type IN (1,4) GROUP BY mid.id, mrd.id,mj.id
            ');
            // $maintenanceInvoices = MaintenanceInvoice::where('status', 1)->orderBy('id', 'desc')->get();
            return view('Workshop.viewMaintenanceInvoiceSummaryAjax', compact('getDetail'));
        }
         
        return view('Workshop.viewMaintenanceInvoiceSummary', compact('company_locations'));
    }
    

    public function approvedMaintenanceInvoice(Request $request)
    {
        DB::connection('mysql2')->beginTransaction();
        try {
            $maintenanceInvoice = MaintenanceInvoice::find($request->id);
            // $data = MaintenanceJobData::where([['maintenance_job_id', $request->id], ['status', 1]])->get();

            // foreach ($data as $value) {

            //     $valueQty = number_format($value->qty, 2);
            //     $valueQty = str_replace(',', '', $valueQty);
            //     $qty =  floatval(ReuseableCode::get_stock($value->item_id, $maintenanceJob->maintenanceRequest->warehouse_id, 0, 0));
            //     $valueQty = floatval($valueQty);
            //     if ($qty < $valueQty) {
            //         DB::connection('mysql2')->rollback();
            //         $message = ['error' => 'error', 'message' => ""];
            //         return  $message;
            //     }
            //     // ReuseableCode::post_stock($value->item_id, $maintenanceJob->maintenanceRequest->warehouse_id, 0, $request->id, $value->id, $maintenanceJob->voucher_no, $maintenanceJob->voucher_date, $valueQty, 14);
            // }
            $maintenanceInvoice->voucher_status = 2;
            $maintenanceInvoice->save();
            DB::connection('mysql2')->commit();
            $message = ['error' => 'success'];
            return  $message;
        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e->getMessage());
        }
    }
    public function createGRNForm()
    {
        $maintenanceJobs = MaintenanceJob::whereHas('gatePassIn', function ($q) {
            $q->where('voucher_status', 2);
        })->doesntHave('grn')->where('status', 1)->where('job_type', 2)->orderBy('id', 'desc')->get();
        return view('Workshop.createGRNForm', compact('maintenanceJobs'));
    }

    public function getMaintenanceJobDataForGRN(Request $request)
    {
        $maintenanceJob = MaintenanceJob::find($request->id);
        $locationId = $request->location_id;
        return view('Workshop.getMaintenanceJobDataForGRN', compact('maintenanceJob', 'locationId'));
    }

    public function addWorkshopGRNDetails(Request $request)
    {
        // dd($request->all());

        DB::connection('mysql2')->beginTransaction();
        try {
            $grn = WorkshopGrn::create([
                'voucher_no' => CommonHelper::getWGRNVoucherNumber(),
                'voucher_date' => $request->Voucher_date,
                'maintenance_job_id' => $request->maintenance_job_id,
                'location_id' => $request->location_id,
                'gate_pass_id' => $request->gate_pass_id,
                'username' => Auth::user()->name,
            ]);
            // dd($grn->voucher_no);
            $file = Input::file('file');
            if (isset($file)) {
                foreach ($file as $key => $value) {
                    // dd($key);
                    // $newfilename = date('dmYHis') . str_replace(" ", "", basename($value->getClientOriginalName()));
                    $newfilename = date('dmYHis') . $grn->voucher_no . $key . $value->getClientOriginalExtension();
                    $value->move(public_path('uploads/attachement'), $newfilename);
                    $attachment =  new Attachement;
                    $attachment->image_src = 'public/uploads/attachement/' . $newfilename;
                    $attachment->status = 1;
                    $grn->comments()->save($attachment);
                }
            }
            foreach ($request->item_id as $key => $item) {
                WorkshopGrnData::create([
                    'workshop_grn_id' => $grn->id,
                    'item_id' => $item,
                    'qty' => $request->qty_received[$key],
                    'repair_cost' => $request->repair_cost[$key],
                ]);
            }
            DB::connection('mysql2')->commit();
            Session::flash('dataInsert', "Request successfully saved");
            return redirect('/workshop/viewGRNList');
        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            echo "Error " . $e->getLine();
            dd($e->getMessage());
        }
    }

    public function viewGRNList(Request $request)
    {
        $company_locations = ReuseableCode::getUserWiseLocationRightsData();
        // dd($company_locations);
        if ($request->ajax()) {
            if ($request->company_location_id) {
                $company_locations = array($request->company_location_id);
            } else {
                $company_locations = ReuseableCode::getUserWiseLocationRights();
            }
            $grns = WorkshopGrn::whereIn('location_id', $company_locations)->whereBetween('voucher_date', [$request->from_date, $request->last_date])->where('status', 1)->orderBy('id', 'desc')->get();
            return view('Workshop.viewGRNListAjax', compact('grns'));
        }
        return view('Workshop.viewGRNList', compact('company_locations'));
    }

    public function viewGrnDetail(Request $request)
    {
        $grn = WorkshopGrn::find($request->id);
        return view('Workshop.viewGrnDetail', compact('grn'));
    }

    public function reverseWorkShopGRN(Request $request){
        $grn = WorkshopGrn::find($request->id);
        $grn->voucher_status = 1;
        $grn->save();
        return 'Done';
    }

    public function approvedGrn(Request $request)
    {
        DB::connection('mysql2')->beginTransaction();
        try {
            $grn = WorkshopGrn::find($request->id);
            // $data = MaintenanceJobData::where([['maintenance_job_id', $request->id], ['status', 1]])->get();

            // foreach ($data as $value) {

            //     $valueQty = number_format($value->qty, 2);
            //     $valueQty = str_replace(',', '', $valueQty);
            //     $qty =  floatval(ReuseableCode::get_stock($value->item_id, $maintenanceJob->maintenanceRequest->warehouse_id, 0, 0));
            //     $valueQty = floatval($valueQty);
            //     if ($qty < $valueQty) {
            //         DB::connection('mysql2')->rollback();
            //         $message = ['error' => 'error', 'message' => ""];
            //         return  $message;
            //     }
            //     // ReuseableCode::post_stock($value->item_id, $maintenanceJob->maintenanceRequest->warehouse_id, 0, $request->id, $value->id, $maintenanceJob->voucher_no, $maintenanceJob->voucher_date, $valueQty, 14);
            // }
            $grn->voucher_status = 2;
            $grn->save();
            DB::connection('mysql2')->commit();
            $message = ['error' => 'success'];
            return  $message;
        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e->getMessage());
        }
    }

    public function editWorkshopGrnForm(Request $request)
    {
        $grn = WorkshopGrn::find($request->id);
        return view('Workshop.editWorkshopGrnForm', compact('grn'));
    }

    public function workshopGrnUpdate(Request $request)
    {
        // dd($request->all());
        DB::connection('mysql2')->beginTransaction();
        try {
            $grn = WorkshopGrn::find($request->grn_id);
            $grn->update([
                'voucher_date' => $request->Voucher_date,
                'username' => Auth::user()->name,
            ]);
            $file = Input::file('file');
            if (isset($file)) {
                foreach ($file as $key => $value) {
                    $newfilename = date('dmYHis') . str_replace(" ", "", basename($value->getClientOriginalName()));
                    $value->move(public_path('uploads/attachement'), $newfilename);
                    $attachment =  new Attachement;
                    $attachment->image_src = 'public/uploads/attachement/' . $newfilename;
                    $attachment->status = 1;
                    $grn->comments()->save($attachment);
                }
            }
            WorkshopGrnData::where('workshop_grn_id', $grn->id)->update(['status' => 0]);
            foreach ($request->item_id as $key => $item) {
                WorkshopGrnData::create([
                    'workshop_grn_id' => $grn->id,
                    'item_id' => $item,
                    'qty' => $request->qty_received[$key],
                    'repair_cost' => $request->repair_cost[$key],
                ]);
            }
            DB::connection('mysql2')->commit();
            Session::flash('dataInsert', "Request successfully saved");
            return redirect('/workshop/viewGRNList');
        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            echo "Error " . $e->getLine();
            dd($e->getMessage());
        }
    }


    public function deleteWorkshopGrn(Request $request)
    {
        // dd($request->id);
        $grn = WorkshopGrn::find($request->id);
        $grn->update(['status' => 0]);
        $grnData = WorkshopGrnData::where('workshop_grn_id', $request->id)->update(['status' => 0]);
        return "deleted";
    }
    public function getMJOForGrn(Request $request)
    {
        // return MaintenanceJob::whereHas('gatePassInWithRequestedLocation')->doesntHave('grn')->where('status', 1)->where('warehouse_id', $request->warehouse_id)->get();
        return MaintenanceJob::whereHas('gatePassInWithRequestedLocation')->where('status', 1)->where('warehouse_id', $request->warehouse_id)->get()
        ->map(function($q){
            $count1 = WorkshopGrn::where('maintenance_job_id' , $q->id)->where('status' , 1)->count();
            $count2 = GatePass::where('maintenance_job_id' , $q->id)->where('status' , 1)->where('gate_pass_type' , 1)->count();
            if ($count2 >= $count1) {
                $q->doesntHave('grn');
            }
            return $q;
        });
    }

    function createMaterialForm()
    {
        $mjoIds = WorkshopGrn::where('status', '=', '1')->where('is_complete', '=', '0')->pluck('maintenance_job_id');
        $maintenanceJobsOther = MaintenanceJob::where('status', '=', '1')->whereIn('id', $mjoIds)->get();
        $maintenanceJobsInhouse = MaintenanceJob::doesntHave('inhouseDontHaveIssuance')->where('status', '=', '1')->whereNotIn('id', $mjoIds)->whereIn('job_type', [1,4])->get();
        $maintenanceJobs = $maintenanceJobsOther->merge($maintenanceJobsInhouse);
        // dd($maintenanceJobs);
        return view('Workshop.createMaterialForm', compact('maintenanceJobs'));
    }

    function createMaterialFormAjax(Request $request)
    {
        // dd($request->all());
        $maintenanceJob = MaintenanceJob::find($request->id);
        $departments = Department::where([['status', '=', '1']])->select('id', 'department_name')->orderBy('id')->get();
        $grns = WorkshopGrn::where('maintenance_job_id', $request->id)->where('status', '=', '1')->where('is_complete', '=', '0')->pluck('id');
        if ($maintenanceJob->job_type == 1 || $maintenanceJob->job_type == 4) {
            $grnData = $maintenanceJob->jobData;
        } else {
            $grnData = WorkshopGrnData::whereIn('workshop_grn_id', $grns)->where('status', '=', '1')->get();
        }
        // $mjoIds = WorkshopGrn::pluck('maintenance_job_id');
        // $maintenanceJobs = MaintenanceJob::whereIn('id', $mjoIds)->get();
        // dd($grnData);
        return view('Workshop.createMaterialFormAjax', compact('grnData', 'departments', 'maintenanceJob'));
    }

    function addMaterialIssuanceDetail(Request $request)
    {
        // dd($request->all());
        DB::connection('mysql2')->beginTransaction();
        try {
            $materialIssuance = WorkshopMaterialIssuance::create([
                'voucher_no' => $request->voucher_no,
                'voucher_date' => $request->Voucher_date,
                'maintenance_job_id' => $request->maintenance_job_id,
                'description' => $request->remarks ?? '',
                'status' => 1,
                'username' => Auth::user()->name,
            ]);
            foreach ($request->department_id as $key => $value) {
                WorkshopMaterialIssuanceData::create([
                    'workshop_material_issuance_id' => $materialIssuance->id,
                    'grn_data_id' => $request->grn_data_id[$key],
                    'item_id' => $request->item_id[$key],
                    'department_id' => $request->department_id[$key],
                    'qty' => $request->item_qty[$key],
                ]);
                if ($request->job_type != 1 && $request->job_type != 4) {
                    WorkshopGrnData::find($request->grn_data_id[$key])->grn->update(['is_complete' => 1]);
                }
            }
            DB::connection('mysql2')->commit();
            Session::flash('dataInsert', "Record successfully saved");
            return redirect('/workshop/viewMaterialIssuanceList');
        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            echo "Error " . $e->getLine();
            dd($e->getMessage());
        }
    }

    function viewMaterialIssuanceList(Request $request)
    {
        return view('Workshop.viewMaterialIssuanceList');
    }

    function viewMaterialIssuanceListAjax(Request $request)
    {
        $materialissuance = WorkshopMaterialIssuance::where('status', 1)->orderBy('id', 'desc')->get();
        return view('Workshop.viewMaterialIssuanceListAjax', compact('materialissuance'));
    }

    function viewMaterialIssuanceDetail(Request $request)
    {
        $materialIssuance = WorkshopMaterialIssuance::find($request->id);
        return view('Workshop.viewMaterialIssuanceDetail', compact('materialIssuance'));
    }
    function editMaterialIssuance(Request $request)
    {
        $materialIssuance = WorkshopMaterialIssuance::find($request->id);
        $departments = Department::where([['status', '=', '1'],])->select('id', 'department_name')->orderBy('id')->get();
        return view('Workshop.editMaterialIssuance', compact('materialIssuance', 'departments'));
    }

    public function updateMaterialIssuanceDetail(Request $request)
    {

        DB::connection('mysql2')->beginTransaction();
        try {
            $materialIssuance = WorkshopMaterialIssuance::find($request->materialIssuanceId);
            $materialIssuance->update([
                'voucher_date' => $request->Voucher_date,
                'description' => $request->remarks ?? '',
            ]);
            WorkshopMaterialIssuanceData::where('workshop_material_issuance_id', $materialIssuance->id)->update(['status' => 0]);
            foreach ($request->department_id as $key => $value) {
                WorkshopMaterialIssuanceData::create([
                    'workshop_material_issuance_id' => $materialIssuance->id,
                    'grn_data_id' => $request->grn_data_id[$key],
                    'item_id' => $request->item_id[$key],
                    'department_id' => $request->department_id[$key],
                    'qty' => $request->item_qty[$key],
                ]);
                WorkshopGrnData::find($request->grn_data_id[$key])->grn->update(['is_complete' => 1]);
            }
            DB::connection('mysql2')->commit();
            Session::flash('dataInsert', "Record successfully saved");
            return redirect('/workshop/viewMaterialIssuanceList');
        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            echo "Error " . $e->getLine();
            dd($e->getMessage());
        }
    }

    public function deleteMaterialIssuance(Request $request)
    {
        // dd($request->all());
        $wmi = WorkshopMaterialIssuance::find($request->id);
        foreach ($wmi->itemData as $key => $itemData) {
            $itemData->grnData->grn->update(['is_complete' => 0]);
            $itemData->update(['status' => 0]);
        }
        $wmi->status = 0;
        $wmi->save();
    }
}
