<?php

namespace App\Http\Controllers;

use App\CompanyLocation;
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
use App\Models\Department;
use App\Models\GatePass;
use App\Models\GatePassData;
use App\Models\MaintenanceJob;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Redirect;

class GatePassController extends Controller
{
    public function viewGatePassList(Request $request)
    {
        $type = 2;
        $company_locations = ReuseableCode::getUserWiseLocationRightsData();
        // dd($company_locations);
        if ($request->ajax()) {
            if ($request->company_location_id) {
                $company_locations = array($request->company_location_id);
            } else {
                $company_locations = ReuseableCode::getUserWiseLocationRights();
            }

            $gatePasses = GatePass::whereIn('location_id', $company_locations)->whereBetween('gate_pass_date', [$request->from_date, $request->last_date])->where('gate_pass_type',$request->gate_pass_type)->where('status', 1)->orderBy('id', 'desc')->get();
            return view('gatepass.viewGatePassListAjax', compact('gatePasses', 'type'));
        }
        return view('gatepass.viewGatePassList', compact('type', 'company_locations'));
    }
    public function viewGatePassDetail(Request $request)
    {
        $gatePass = GatePass::find($request->id);
        //SELECT *  FROM gate_passes as gp left JOIN workshop_grns as wsg on gp.id = wsg.gate_pass_id  WHERE gp.id LIKE 92;
        $gatePassTwo = DB::connection('mysql2')->table('gate_passes as gp')->leftJoin('workshop_grns as wsg','gp.id','=','wsg.gate_pass_id')->where('gp.id',$request->id)->first();
        return view('gatepass.viewGatePassDetail', compact('gatePass','gatePassTwo'));
    }
    public function createGatePassForm()
    {
        // dd('in');
        $gate_pass_type = 2;
        $title = 'Gate Pass Out Form';
        $company_locations = ReuseableCode::getUserWiseLocationRights();
        $company_locations = CompanyLocation::whereIn('id', $company_locations)->get()->toArray();

        $maintenanceJobs = MaintenanceJob::where('status', 1)->where('job_type', 2)->orderBy('id', 'desc')->get();
        // dd($company_locations);
        return view('gatepass.createGatePassForm', compact('maintenanceJobs', 'gate_pass_type', 'title', 'company_locations'));
    }
    public function createGatePassOutForm()
    {
        // dd('in');
        $gate_pass_type = 1;
        $title = 'Gate Pass IN Form';
        $company_locations = ReuseableCode::getUserWiseLocationRights();
        $company_locations = CompanyLocation::whereIn('id', $company_locations)->get()->toArray();
        $maintenanceJobs = MaintenanceJob::whereHas('gatePassOut', function ($q) {
                $q->where('voucher_status', 2);
            })
            ->where('status', 1)->where('job_type', 2)->orderBy('id', 'desc')->get();
        return view('gatepass.createGatePassForm', compact('maintenanceJobs', 'gate_pass_type', 'title', 'company_locations'));
    }


    public function getMaintenanceJobDataForGatePass(Request $request)
    {
        $locationId = $request->location_id;
        if (!$request->id) {
            return "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center'><h2 class='text-danger'>Please Select Maintenance Job No..</h2></div>";
        }
        $gate_pass_type = $request->gate_pass_type;
        if ($gate_pass_type == 2) {
            $gate_pass_no = CommonHelper::getGatePassOUTVoucherNumber();
        } else {
            $gate_pass_no = CommonHelper::getGatePassINVoucherNumber();
        }

        $maintenanceJob = MaintenanceJob::find($request->id);
        $departments = Department::where([['status', '=', '1'],])->select('id', 'department_name')->orderBy('id')->get();
        return view('gatepass.getMaintenanceJobDataForGatePass', compact('departments', 'maintenanceJob', 'gate_pass_type', 'gate_pass_no', 'locationId'));
    }
    public function insertGatePassForm(Request $request)
    {
        // dd($request->all());
        
        DB::connection('mysql2')->beginTransaction();
        try {
            $checkCompleteStatus = false;
            $completeltyReceivedItems = 0;
            $gatepass = GatePass::create([
                'maintenance_job_id' => $request->maintenance_job_id,
                'gatepass_id' => $request->gate_pass_id,
                'gate_pass_no' => $request->gate_pass_no,
                'gate_pass_date' => $request->gate_pass_date,
                'gate_pass_type' => $request->gate_pass_type,
                'mo_no' => $request->mo_no,
                'good_taken_by' => $request->good_taken_by,
                'vehicle_no' => $request->vehicle_no,
                'contact_no' => $request->contact_no,
                'location_id' => $request->location_id,
                // 'voucher_status' => 2,
                'created_by' => Auth::user()->name,
            ]);
            $total_items = $request->item_id;
            foreach ($total_items as $key => $item) {
                GatePassData::create([
                    'gate_pass_id' => $gatepass->id,
                    'item_id' => $item,
                    'qty' => $request->qty[$key],
                    'qty_received' => $request->qty_received[$key] ?? 0,
                ]);
                if ($request->gate_pass_type == 1) {
                    $gatePassOut = GatePass::join('gate_pass_datas', 'gate_passes.id', 'gate_pass_datas.gate_pass_id')
                        ->where('gate_pass_datas.item_id', $item)
                        ->where('gate_passes.maintenance_job_id', $request->maintenance_job_id)
                        ->where('gate_passes.location_id', $request->location_id)
                        ->where('gate_passes.gate_pass_type', 2)
                        ->where('gate_passes.status', 1)->sum('qty');
                    $gatePassIn = CommonHelper::getPreviousReceivedGatePassInQty($item, $request->maintenance_job_id, $request->location_id);
                    if ($gatePassIn >= $gatePassOut) {
                        // $checkCompleteStatus = true;
                        $completeltyReceivedItems += 1;
                    }
                    // dd($gatePassOut, $gatePassIn, $completeltyReceivedItems);
                }
            }
            // dd($completeltyReceivedItems, count($total_items));
            if (count($total_items)  == $completeltyReceivedItems) {
                // dd('print');
                // GatePass::find($gatepass->id)->update(['is_complete' => 1]);
                $mjo = MaintenanceJob::find($request->maintenance_job_id);
                if ($mjo->job_type == 3) {
                    GatePass::where('gate_passes.maintenance_job_id', $request->maintenance_job_id)->update(['is_complete' => 1]);
                }else {                
                    GatePass::where('gate_passes.maintenance_job_id', $request->maintenance_job_id)->where('gate_passes.location_id', $request->location_id)->update(['is_complete' => 1]);
                }
            }
            DB::connection('mysql2')->commit();
            // dd('Saved!');
        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            dd($e->getMessage());
        }
        //return redirect(route('gatepass.viewGatePassList'));
        return Redirect::to('gatepass/viewGatePassList/'.$request->gate_pass_type.'');
    }
    public function approvedGatePass(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
            $gatePass = GatePass::find($request->id);
            
            $gatePass->voucher_status = 2;
            $gatePass->save();
            DB::Connection('mysql2')->commit();
            $message = ['error' => 'success'];
            return  $message;
        } catch (Exception $e) {
            DB::Connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e->getMessage());
        }
    }

    public function reverseGatePass(Request $request){
        DB::Connection('mysql2')->beginTransaction();
        try {
            $gatePass = GatePass::find($request->id);
            
            $gatePass->voucher_status = 1;
            $gatePass->save();
            DB::Connection('mysql2')->commit();
            $message = ['error' => 'success'];
            return  $message;
        } catch (Exception $e) {
            DB::Connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e->getMessage());
        }
    }
    public function deleteGatePass(Request $request)
    {
        // dd($request);
        DB::Connection('mysql2')->beginTransaction();
        try {
            $gatePass = GatePass::find($request->item)->delete();
            $gatepassData = GatePassData::where([['gate_pass_id', $request->item], ['status', 1]])->delete();
            DB::Connection('mysql2')->commit();
            $message = ['error' => 'success'];
            return  $message;
        } catch (Exception $e) {
            DB::Connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e->getMessage());
        }
    }


    public function getGetPassIn(Request $request) {
        $gatepass = GatePass::where('status', 1)
            ->where('voucher_status',2)
            ->where('maintenance_job_id', $request->id)
            ->where('gate_pass_type', ($request->gate_pass_type == 1)? 2:1 );
        $mjo = MaintenanceJob::find($request->id);
        // dd($gatepass->count() , $gatepass->get());
        $count = 0;
        if($mjo->job_type == 3){
            $count  = GatePass::where('status', 1)
            ->where('voucher_status',2)
            ->where('maintenance_job_id', $request->id)->count();
            if ($count == 3 || $count == 1) {
                $gatepass->where('location_id', '!=', $request->location_id);
            }
        }
        return ['gatepass'=>$gatepass->get(),'count'=> $count,'mjo' => $mjo]; 
        // return $gatepass->get(); 
    }

    public function checkJobType(Request $request){
        // dd($request);
        $mjo = MaintenanceJob::find($request->id);
        $count = GatePass::where('status', 1)
        ->where('voucher_status',2)
        ->where('maintenance_job_id', $request->id)->count();
        return ["mjo" => $mjo , "count" => $count];
    }
    public function getMJOGatePassOut(Request $request) {
        // dd($request);
        // check gatepass out created or not
        if ($request->type == 2) { 
            // dd($request->warehouse_id);       
            $jobs = MaintenanceJob::doesntHave('gatePassOut')->where('voucher_status', 2)->where(function ($query) use ($request) {
                $query->where('warehouse_id', $request->warehouse_id)
                    ->orWhere('warehouse_id_to', $request->warehouse_id);
            })->where('status', 1)->whereIn('job_type', [2,3])->get();
            // dd($jobs);
        }else{
            $jobs = MaintenanceJob::where('voucher_status', 2)->where('status', 1)->where(function ($query) use ($request) {
                $query->where('warehouse_id', $request->warehouse_id)
                    ->orWhere('warehouse_id_to', $request->warehouse_id);
            })->whereIn('job_type', [2,3])->whereHas('gatePassOutNotComplete')->get();
        }
        return $jobs;
    }

    public function editGatepassForm(Request $request){
        // dd($request->all());
        $gatepass = GatePass::find($request->id);
        return view('gatepass.editGatepassForm', compact('gatepass'));
    }

    public function updateGatePassForm(Request $request)
    {
        // dd($request->all());
        
        DB::connection('mysql2')->beginTransaction();
        try {
            $checkCompleteStatus = false;
            $completeltyReceivedItems = 0;
            $gatepass = GatePass::find($request->id);
            $gatepass->update([
                // 'maintenance_job_id' => $request->maintenance_job_id,
                // 'gatepass_id' => $request->gate_pass_id,
                // 'gate_pass_no' => $request->gate_pass_no,
                'gate_pass_date' => $request->gate_pass_date,
                'gate_pass_type' => $request->gate_pass_type,
                'mo_no' => $request->mo_no,
                'good_taken_by' => $request->good_taken_by,
                'vehicle_no' => $request->vehicle_no,
                'contact_no' => $request->contact_no,
                // 'location_id' => $request->location_id,
                // 'voucher_status' => 2,
                'created_by' => Auth::user()->name,
            ]);
            GatePassData::where('gate_pass_id', $request->id)->update(['status' => 0]);
            $total_items = $request->item_id;
            foreach ($total_items as $key => $item) {
                GatePassData::create([
                    'gate_pass_id' => $gatepass->id,
                    'item_id' => $item,
                    'qty' => $request->qty[$key],
                    'qty_received' => $request->qty_received[$key] ?? 0,
                ]);
                if ($request->gate_pass_type == 1) {
                    $gatePassOut = GatePass::join('gate_pass_datas', 'gate_passes.id', 'gate_pass_datas.gate_pass_id')
                        ->where('gate_pass_datas.item_id', $item)
                        ->where('gate_passes.maintenance_job_id', $request->maintenance_job_id)
                        ->where('gate_passes.location_id', $request->location_id)
                        ->where('gate_passes.gate_pass_type', 2)
                        ->where('gate_passes.status', 1)
                        ->where('gate_pass_datas.status', 1)->sum('qty');
                    $gatePassIn = CommonHelper::getPreviousReceivedGatePassInQty($item, $request->maintenance_job_id, $request->location_id, $request->id);
                    if ($gatePassIn >= $gatePassOut) {
                        // $checkCompleteStatus = true;
                        $completeltyReceivedItems += 1;
                    }
                    // dd($gatePassOut, $gatePassIn, $completeltyReceivedItems);
                }
            }
            // dd($completeltyReceivedItems, count($total_items));
            if (count($total_items)  == $completeltyReceivedItems) {
                // dd('print');
                // GatePass::find($gatepass->id)->update(['is_complete' => 1]);
                $mjo = MaintenanceJob::find($request->maintenance_job_id);
                if ($mjo->job_type == 3) {
                    GatePass::where('gate_passes.maintenance_job_id', $request->maintenance_job_id)->update(['is_complete' => 1]);
                }else {                
                    GatePass::where('gate_passes.maintenance_job_id', $request->maintenance_job_id)->where('gate_passes.location_id', $request->location_id)->update(['is_complete' => 1]);
                }
            }
            DB::connection('mysql2')->commit();
            // dd('Saved!');
        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            dd($e->getLine(), $e->getMessage());
        }
        return Redirect::to('gatepass/viewGatePassList/'.$gatepass->gate_pass_type.'');
        //return redirect(route('gatepass.viewGatePassList'));
    }
}
