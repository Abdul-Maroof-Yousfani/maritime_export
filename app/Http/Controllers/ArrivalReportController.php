<?php

namespace App\Http\Controllers;

use App\ArrivalReport;
use App\ArrivalReportData;
use App\CompanyLocation;
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
use App\Models\Attachement;
use App\Models\Department;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestData;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ArrivalReportController extends Controller
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
            $arrival_reports = ArrivalReport::whereStatus(true)
            ->whereIn('company_location_id', $locations)
            ->whereBetween('created_at', [$request->from_date.' 00:00:00', $request->to_date.' 23:59:59'])->latest()->get();
            return view('arrival_report.ajaxIndex', compact('arrival_reports'));
        }
        return view('arrival_report.index');
    }
    
    public function create()
    {
        $company_locations = ReuseableCode::getUserWiseLocationRights();
        $company_locations = CompanyLocation::whereIn('id', $company_locations)->get()->toArray();
        $department_id = ReuseableCode::getUserWiseDepartmentRights();
        $subDepartmentList = DB::table('sub_department')
                                ->whereIn('id', $department_id)
                                ->select('id','sub_department_name')
                                ->get();
      //  $departments = Department::where([['status', '=', '1'], ])->select('id','department_name')->orderBy('id')->get();
        $suppliers = Supplier::select('*')->where('status', '=', '1')->get();
        return view('arrival_report.create', compact('company_locations','subDepartmentList','suppliers'));
    }

    public function get_itemwise_prpo(Request $request)
    {
        $data = [];
        // $data[] = DB::Connection('mysql2')->table('quotation_data as a')
        //      ->join('demand_data as b','a.pr_data_id','=','b.id')
        //      ->join('quotation as c','a.master_id','=','c.id')
        //      ->join('demand as d','b.master_id','=','d.id')
        //      ->where('a.status',1)
        //      ->where('b.status',1)
        //      ->where('b.cancel_status',1)
        //      ->where('b.sub_item_id',$request->id)
        //      ->where('a.quotation_status',1)
            
        //      ->select('b.id','d.demand_no as pr_po_no')
        //      ->orderBy('vendor')
        //      ->orderBy('c.group_number')
        //     ->get()->toArray();
        $data[] = DB::Connection('mysql2')->table('demand_data as b')
            ->join('demand as d','b.master_id','=','d.id')
            ->where('b.status',1)
            // ->where('b.demand_status',2)
            ->where('b.cancel_status',1)
            ->where('b.sub_item_id',$request->id)
           
            ->select('b.id','d.demand_no as pr_po_no')
           ->get()->toArray();
           
        $data[] = PurchaseRequest::on('mysql2')
        ->join('purchase_request_data', 'purchase_request.id', '=', 'purchase_request_data.master_id')
        ->where('purchase_request.status', 1)
        ->where('purchase_request.purchase_request_status', 2)
        ->where('purchase_request_data.grn_status', 1)
        ->where('purchase_request_data.sub_item_id', $request->id)
        ->select('purchase_request.id', 'purchase_request.purchase_request_no as pr_po_no')
        ->groupby('purchase_request.purchase_request_no')
        ->get()->toArray();

      
        $data = array_merge($data[0], $data[1]);
        $option = '<option value="">Select No</option>';
        $option .= '<option value="0">N/A</option>';
        foreach ($data ?? [] as $key => $value) {
            $name =  is_array($value) ? $value['pr_po_no'] : $value->pr_po_no;
            $option .= '<option value=\'' . $name . '\'>'.strtoupper($name).'</option>';
        }
        return $option;
    }

    public function GetArrivalForm(Request $request)
    {

        $data = DB::Connection('mysql2')->table('purchase_request as pr')
        ->join('purchase_request_data as prd','pr.id','=','prd.master_id')
        ->where('prd.sub_item_id',$request->item_id)
        ->where('pr.purchase_request_no',$request->id)
        ->select('prd.*','pr.company_location_id','pr.sub_department_id','pr.supplier_id as vendor_id')->first();

        $departments = Department::where([['status', '=', '1'], ])->select('id','department_name')->orderBy('id')->get();
        $supplierList = Supplier::select('*')->where('status', '=', '1')->get();
      
        $purchase_approve_qty = 0;
        $purchase_request_qty = 0;

        if($data){
            $purchase_approve_qty = $data->purchase_approve_qty;
            $purchase_request_qty = $data->purchase_request_qty;
        }else{
            
            $data = DB::Connection('mysql2')->table('quotation_data as a')
            ->join('demand_data as b','a.pr_data_id','=','b.id')
            ->join('quotation as c','a.master_id','=','c.id')
            ->join('demand as d','b.master_id','=','d.id')
            ->where('a.status',1)
            ->where('b.status',1)
            ->where('b.cancel_status',1)
            ->where('b.sub_item_id',$request->item_id)
            ->where('d.demand_no',$request->id)
            ->where('a.quotation_status',1)
           
            ->select('b.*','d.demand_no as pr_po_no','d.company_location_id','d.sub_department_id','c.vendor_id as vendor_id')
            ->orderBy('vendor')
            ->orderBy('c.group_number')
           ->first();
            
           $purchase_request_qty = $data->qty;
        }
        $department = '<option value="">Select Department</option>';
        $vendor = '<option value="">Select Vendor</option>';
       

        foreach ($departments as $key => $y){
            $subdepartments = DB::select('select `id`,`sub_department_name` from `sub_department` where `department_id` =' . $y->id . '');
            foreach ($subdepartments as $key2 => $y2){
                $selected = $y2->id == $data->sub_department_id ? 'selected' : '';
                $department .=  '<option '.$selected.' value="' . $y2->id . '">' . $y2->sub_department_name . '</option>';
            }
        }

        foreach ($supplierList as $key => $row1){
            $selected = $data->vendor_id == $row1->id ? 'selected' : '';
            $vendor .=  '<option '.$selected.' value="' . $row1->id . '">' . $row1->name . '</option>';
        }

        return response()->json(
            [
                'department' => $department,
                'vendor' => $vendor,
                'purchase_approve_qty' => $purchase_approve_qty,
                'purchase_request_qty' => $purchase_request_qty,
            ]
        );

      

       
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();

            $location = Input::get('company_location_id');
            $str = ArrivalReport::where('company_location_id', $location)->orderBy('id', 'desc')->count();
            $arp_no = 'AR-' . CommonHelper::getCompanyLocationPrefix($location) . '-' . sprintf("%'05d", ($str + 1)); // . date('my');
            $request['arrival_no'] = strtoupper($arp_no);
            $request['requested_by'] = Auth::user()->name;
            
            $ArrivalReport = new ArrivalReport();
            $ArrivalReport->arrival_no = strtoupper($arp_no);
            $ArrivalReport->requested_by = Auth::user()->name;
            $ArrivalReport->company_location_id = $request->company_location_id;
            $ArrivalReport->arrival_remarks = $request->arrival_remarks;
            $ArrivalReport->arrival_date = date('d-m-Y',strtotime($request->arival_date));
            $ArrivalReport->save();

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
                    $savedAttachment = $ArrivalReport->attachments()->save($attachment);
                }
            }

            foreach ($request->item as $key => $value) {
                
                if($value != ''){
                    $item = explode('%',$value);
                    ArrivalReportData::create([
                        'arrival_report_id' => $ArrivalReport->id,
                        'item' => $item[0],
                        'item_id' => $item[3],
                        'uom' => $request->uom[$key],
                        'dc_no' => $request->dc_no[$key],
                        'igp_no' => $request->igp_no[$key],
                        'department_id' => $request->department_id[$key],
                        'pr_po_no' => $request->pr_no[$key],
                        'qty_requested' => $request->qty_requested[$key],
                        'qty_approved' => $request->qty_approved[$key],
                        'vendor_id' => $request->vendor_id[$key],
        
                    ]);
                }
            }


            DB::commit();
            Session::flash('dataInsert', "Data Successfully Added");
            return Redirect::to('purchase/arrival_report?pageType=&&parentCode=242&&m='.session('run_company').'#Garibsons');
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    public function ViewArrivalReport(Request $request)
    {
        
        $id = $request->id;
        $Arrival = ArrivalReport::where('id' , $id)->where('status', 1)->first();
        return view('arrival_report.show' , compact('Arrival'));
    }  

    public function AcknowledgedArrivalView(Request $request)
    {
        
        $id = $request->id;
        $Arrival = ArrivalReport::where('id' , $id)->where('status', 1)->first();
        return view('arrival_report.approve_arrival' , compact('Arrival'));
    }  

    public function edit($id)
    {
        $arrival = ArrivalReport::find($id);
        $company_locations = ReuseableCode::getUserWiseLocationRights();
        $company_locations = CompanyLocation::whereIn('id', $company_locations)->get()->toArray();
        $department_id = ReuseableCode::getUserWiseDepartmentRights();
        $subDepartmentList = DB::table('sub_department')
                                ->whereIn('id', $department_id)
                                ->select('id','sub_department_name')
                                ->get();
        $suppliers = Supplier::select('*')->where('status', '=', '1')->get();
        return view('arrival_report.edit' , compact('arrival','company_locations','subDepartmentList','suppliers'));
    }  

    public function update(Request $request,$id)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();

            $arrival = ArrivalReport::find($id);

            if ($request->hasFile('file')) {
                $arrival->attachments()->delete();
                $file = $request->file('file');
                foreach ($file as $key => $value) {
                    $d1 =   $value->getClientOriginalName();
                    $d2 =  $value->getClientOriginalExtension();
                    $d3 =  $value->getRealPath();
                    $newfilename = date('dmYHis') . str_replace(" ", "", basename($value->getClientOriginalName()));
                    $value->move(public_path('uploads/attachement'), $newfilename);

                    $attachment =  new Attachement();
                    $attachment->image_src = 'public/uploads/attachement/' . $newfilename;
                    $attachment->status = 1;
                    $savedAttachment = $arrival->attachments()->save($attachment);
                }
            }
           
            $arrival->arrival_report()->delete();
            foreach ($request->item as $key => $value) {
                
                if($value != ''){
                    $item = explode('%',$value);
                    ArrivalReportData::create([
                        'arrival_report_id' => $arrival->id,
                        'item' => $item[0],
                        'item_id' => $item[3],
                        'uom' => $request->uom[$key],
                        'dc_no' => $request->dc_no[$key],
                        'igp_no' => $request->igp_no[$key],
                        'department_id' => $request->department_id[$key],
                        'pr_po_no' => $request->pr_no[$key],
                        'qty_requested' => $request->qty_requested[$key],
                        'qty_approved' => $request->qty_approved[$key],
                        'vendor_id' => $request->vendor_id[$key],
        
                    ]);
                }
            }


            DB::commit();
            Session::flash('dataInsert', "Data Successfully updated");
            return Redirect::to('purchase/arrival_report?pageType=&&parentCode=242&&m='.session('run_company').'#Garibsons');
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    public function delete_arrival_report(Request $request)
    {
        $ArrivalReport = ArrivalReport::find($request->id)->update(['status' => 0]);
        
        return 'Deleted';
    }

    public function AcknowledgedArrival(Request $request)
    {
        // dd($request->all());

        $ArrivalReport = ArrivalReport::find($request->id)->update(
            [
                'arrival_approve' => 1,
                'approve_date' => date('d-m-Y h:i A'),
                'approve_name' => Auth::user()->name,
            ]
        );
        $message = '';
        foreach ($request->formData ?? [] as $key => $value) {
            if($value['data_id'] != '' ||  $value['data_id'] != null){
                $message = "Approved";
                $ArrivalReportData = ArrivalReportData::find($value['data_id'])->update(
                    [
                        'accepted_qty' => $value['accepted_qty'],
                        'rejected_qty' => $value['rejected_qty'],
                        'accept_reject_remarks' => $value['accept_reject_remarks'],
                    ]
                );
            }
                
        }
        
        return $message;
    }

    public function approve_arrival_report(Request $request)
    {
        $ArrivalReport = ArrivalReport::find($request->id)->update(
            [
                'audit_approved' => 1,
                'audit_date' => date('d-m-Y h:i A'),
                'audit_name' => Auth::user()->name,
            ]
        );
        
        return 'Approved';
    }
}
