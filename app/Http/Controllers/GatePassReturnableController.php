<?php

namespace App\Http\Controllers;

use App\CompanyLocation;
use App\GatePassReturnable;
use App\GatePassReturnableData;
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
use App\Models\Attachement;
use App\Models\Department;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class GatePassReturnableController extends Controller
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
            $gatepasses = GatePassReturnable::whereStatus(true)
            ->where(function($query) use ($locations) {
                $query->whereIn('company_location_id', $locations)
                      ->orWhereNull('company_location_id');
            })
            ->whereBetween('created_at', [$request->from_date, $request->to_date])->get();
            return view('returnable_gatepass.ajaxIndex', compact('gatepasses'));
        }
        return view('returnable_gatepass.index');
    }
    
    public function create()
    {
        $departments = Department::where([['status', '=', '1'],])->select('id', 'department_name')->orderBy('id')->get();  
        $company_locations = ReuseableCode::getUserWiseLocationRights();
        $company_locations = CompanyLocation::whereIn('id', $company_locations)->get()->toArray(); 
        return view('returnable_gatepass.create', compact('departments','company_locations'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $location = Input::get('company_location_id');
            $str = GatePassReturnable::where('company_location_id', $location)->orderBy('id', 'desc')->count();
            $gatepass_no = 'GP-' . CommonHelper::getCompanyLocationPrefix($location) . '-' . sprintf("%'05d", ($str + 1)); // . date('my');
            $request['gatepass_no'] = strtoupper($gatepass_no);
            $request['requested_by'] = Auth::user()->name;
            $excludedFields = ['item', 'uom', 'qty','file','department_id','line_no','line_description'];
            $data = $request->except($excludedFields);
            
            $gatePassReturnable = GatePassReturnable::create($data);

            $file = $request->file('file');
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
                    $savedAttachment = $gatePassReturnable->attachments()->save($attachment);
                    if ($savedAttachment) {
                        Log::info('Attachment saved: ' . $savedAttachment->id);
                    } else {
                        Log::error('Failed to save attachment for gatepass: ' . $gatePassReturnable->id);
                    }
                }
            }

            foreach ($request->item ?? [] as $key => $value) {
                if($value != ''){
                    GatePassReturnableData::create([
                        'gate_pass_returnables_id' => $gatePassReturnable->id,
                        'item' => $value,
                        'uom' => $request->uom[$key],
                        'qty' => $request->qty[$key],
                        'department_id' => $request->department_id[$key],
                        'line_no' => $request->line_no[$key],
                        'line_description' => $request->line_description[$key],
        
                    ]);
                }
            }
            DB::commit();
            Session::flash('dataInsert', "Data Successfully Added");
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    public function ViewGatepass(Request $request)
    {
        
        $id = $request->id;
        $GatePassReturnable = GatePassReturnable::where('id' , $id)->where('status', 1)->first();
        return view('returnable_gatepass.show' , compact('GatePassReturnable'));
    }  

    public function editGatepassForm(Request $request)
    {
        
        $id = $request->id;
        $GatePassReturnable = GatePassReturnable::where('id' , $id)->where('status', 1)->first();
        $departments = Department::where([['status', '=', '1'],])->select('id', 'department_name')->orderBy('id')->get();   
        return view('returnable_gatepass.edit' , compact('GatePassReturnable','departments'));
    }  

    public function update(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $excludedFields = ['item', 'uom', 'qty','file','department_id','line_no','line_description'];
            $data = $request->except($excludedFields);
            
            $gatePassReturnable = GatePassReturnable::find($request->id);
            $gatePassReturnable->update($data);
            if ($request->hasFile('file')) {
                foreach ($gatePassReturnable->attachments as $attachment){
                $attachment->delete();
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
                        $gatePassReturnable->attachments()->save($attachment);
                    }
                }
            }
            GatePassReturnableData::where('gate_pass_returnables_id',$request->id)->delete();
            foreach ($request->item ?? [] as $key => $value) {
                if($value != ''){
                    GatePassReturnableData::create([
                        'gate_pass_returnables_id' => $request->id,
                        'item' => $value,
                        'uom' => $request->uom[$key],
                        'qty' => $request->qty[$key],
                        'department_id' => $request->department_id[$key],
                        'line_no' => $request->line_no[$key],
                        'line_description' => $request->line_description[$key],
        
                    ]);
                }
            }
            DB::commit();
            Session::flash('dataInsert', "Data Successfully Updated");
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    public function delete_gatepass(Request $request)
    {
        $GatePassReturnable = GatePassReturnable::find($request->id)->update(['status' => 0]);
        $GatePassReturnableData = GatePassReturnableData::where('gate_pass_returnables_id',$request->id)->update(['status' => 0]);
        
        return 'Deleted';
    }

    public function gatepass_received(Request $request)
    {
        GatePassReturnable::find($request->id)->update(
            [
                'returnable_recieved' => 2,
                'recieving_date' => date('d-m-Y h:i:s'),
                'recieving_user' => Auth::user()->name,
            ]
        );
        
        return 'success';
    }

    public function gatepass_partial_received(Request $request)
    {
        $date = date('d-m-Y h:i:s');
        $name = Auth::user()->name;
        GatePassReturnableData::find($request->id)->update(
            [
                'returnable_recieved' => 1,
                'recieving_date' => $date,
                'recieving_user' => $name,
            ]
        );
        
        return response()->json([
            'status' => true,
            'date' => $date,
            'name' => $name,
        ]);
    }
}
