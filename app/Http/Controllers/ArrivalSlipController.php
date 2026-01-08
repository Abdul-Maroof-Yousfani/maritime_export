<?php

namespace App\Http\Controllers;

use App\ArrivalInspection;
use App\Helpers\CommonHelper;
use App\Models\CropBased;
use App\Models\Product;
use App\ArrivalSlip;
use App\Models\Department;
use App\ProductionPurchaseOrder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ArrivalSlipController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        if($request->ajax()){
            $arrival_slips = ArrivalSlip::join('production_purchase_orders','production_purchase_orders.voucher_no','arrival_slips.po_no')
            ->join('arrival_inspections as ai','ai.po_no','production_purchase_orders.voucher_no')
            ->join('inpection_checklists as inc','inc.ins_id','ai.id')
            ->join('arrival_weighbridges','arrival_weighbridges.po_no','production_purchase_orders.voucher_no')
            ->join('production_get_pass','production_get_pass.po_no','production_purchase_orders.voucher_no')
            
            ->where('production_purchase_orders.status', 1)
            // ->where('inc.type', 2)
            // ->where('ai.ins_status',1)
            ->select('arrival_slips.*','arrival_weighbridges.vehicle_no','arrival_weighbridges.no_of_pkgs','arrival_weighbridges.goods_description','arrival_weighbridges.gross_weight','production_purchase_orders.supplier_id','production_get_pass.inspection_no','production_get_pass.gate_pass_no')
            ->groupBy('production_purchase_orders.id')
            ->get();
            return view('arrival.arrivalslip.ajaxIndex', compact('arrival_slips'));
        }
        return view('arrival.arrivalslip.index');
    }
    
    
    public function create()
    {
        $po_nos = ProductionPurchaseOrder::
        join('arrival_inspections as ai','ai.po_no','production_purchase_orders.voucher_no')
        ->join('inpection_checklists as inc','inc.ins_id','ai.id')
        ->join('arrival_weighbridges','arrival_weighbridges.po_no','production_purchase_orders.voucher_no')
        ->join('production_get_pass','production_get_pass.po_no','production_purchase_orders.voucher_no')
        
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('arrival_slips')
                ->whereRaw('arrival_slips.po_no = production_purchase_orders.voucher_no') ;
        })
        ->where('production_purchase_orders.status', 1)
        ->where('inc.type', 2)
        ->where('ai.ins_status',1)
        // ->where('ai.ins_status',3)
        ->where('production_purchase_orders.voucher_status', '!=', '3')
        ->groupBy('production_purchase_orders.id')
        ->get();
        $departments = Department::where([['status', '=', '1'],])->select('id', 'department_name')->orderBy('id')->get();
        return view('arrival.arrivalslip.create', compact('po_nos','departments'));
    }

    public function get_arrival_inspection_no(Request $request)
    {
        $nos = ArrivalInspection::
                 leftjoin('production_purchase_orders','production_purchase_orders.voucher_no','arrival_inspections.po_no')
                 ->leftjoin('supplier','supplier.id','production_purchase_orders.supplier_id')
                ->join('inpection_checklists', 'inpection_checklists.ins_id', '=', 'arrival_inspections.id')
                ->leftjoin('arrival_weighbridges','arrival_weighbridges.inspection_no','arrival_inspections.ins_no')
                ->leftJoin('arrival_locations as al1', 'al1.id', '=', 'arrival_weighbridges.location_id')
                ->leftJoin('arrival_locations as al2', 'al2.id', '=', 'al1.parent_id')
                ->where('inpection_checklists.type',1)
                ->where('arrival_weighbridges.type',1)
                ->where('arrival_inspections.po_no', $request->po_no)
                ->groupby('arrival_inspections.id')
                ->select('arrival_inspections.*','production_purchase_orders.*','inpection_checklists.*','supplier.name as supplier_name','supplier.address as supplier_address','al2.name as parent_location', 'al1.name as location')
                ->get();

                return $nos ?? [];
    }

//     public function store(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'po_no' => 'required',
//             'inspection_no' => 'required',
// //            'arrival_slip_no' => 'required',
//             'arrival_date' => 'required|date',
//             'bill_date' => 'required|string',
//             'sp_inv_no' => 'required|string',
// //            'builty_no' => 'required|string',
// //            'vehicle_no' => 'required|string',
//             'department_id' => 'required',
// //            'sup_name' => 'required',
// //            'sup_adr' => 'required',
//             'document_mode' => 'required',
//             'recived_type' => 'required',
// //            'transporter_name' => 'required|string|max:100',
//         ]
//         );

//         if ($validator->fails()) {
//             return response()->json(['errors' => $validator->errors()], 422);
//         }



//         // dd($request->all());
//         try {
//             DB::beginTransaction();
//             $request['arrival_slip_no'] = CommonHelper::getProductionFormat(ArrivalSlip::class,'ASP-');
//             ArrivalSlip::create($request->all());
           
//             DB::commit();
//             return response()->json([
//                 'success' => true,
//                 'url' => url('arrival/arrivalslip') . '?pageType=&parentCode=234&m=' . session('run_company') . '#Garibsons',
//             ]);
//             Session::flash('dataInsert', "Data Successfully Added");
//             return redirect()->back();
//         } catch (Exception $e) {
//             DB::rollback();
//             dd($e->getMessage());
//         }
//     }

    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'po_no' => 'required',
            'inspection_no' => 'required',
            'arrival_date' => 'required|date',
            'bill_date' => 'required|string',
            'sp_inv_no' => 'required|string',
            'department_id' => 'required',
            'document_mode' => 'required',
            'recived_type' => 'required',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            // Handle file upload if present
            $filePath = null;
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $uniqueId = uniqid();
                $extension = $file->getClientOriginalExtension();
                $filename = $uniqueId . '.' . $extension;
                $folderPath = 'arrivalslip';

                // Ensure the directory exists
                if (!Storage::disk('public')->exists($folderPath)) {
                    Storage::disk('public')->makeDirectory($folderPath);
                }

                // Store the file and get its path
                $filePath = $file->storeAs($folderPath, $filename, 'public');
            }

            // Prepare data for insertion
            $requestData = $request->all();
            $requestData['attachment'] = $filePath;
            $requestData['arrival_slip_no'] = CommonHelper::getProductionFormat(ArrivalSlip::class, 'ASP-'); // Generated slip number

            // Insert the arrival slip data
            ArrivalSlip::create($requestData);

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'success' => true,
                'url' => url('arrival/arrivalslip') . '?pageType=&parentCode=234&m=' . session('run_company') . '#Garibsons',
            ]);

        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();
            return response()->json(['message' => 'Failed to create arrival slip', 'error' => $e->getMessage()], 500);
        }
    }


    public function edit(Request $request)
    {
        $id = $request->id;
        $arrival_slip = ArrivalSlip::join('production_purchase_orders','production_purchase_orders.voucher_no','arrival_slips.po_no')
        ->join('arrival_inspections as ai','ai.po_no','production_purchase_orders.voucher_no')
        ->join('inpection_checklists as inc','inc.ins_id','ai.id')
        ->join('arrival_weighbridges','arrival_weighbridges.po_no','production_purchase_orders.voucher_no')
        ->join('production_get_pass','arrival_weighbridges.po_no','production_purchase_orders.voucher_no')
        
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('production_get_pass')
                ->whereRaw('production_get_pass.po_no = production_purchase_orders.voucher_no') 
                ->whereRaw('production_get_pass.get_pass_type = 2');
        })
        ->where('production_purchase_orders.status', 1)
        ->where('inc.type', 2)
        ->where('ai.ins_status',2)
        ->where('arrival_slips.id',$id)
        // ->where('ai.ins_status',3)
        ->where('production_purchase_orders.voucher_status', '!=', '3')
        ->groupBy('production_purchase_orders.id')
        ->first();
        $departments = Department::where([['status', '=', '1'],])->select('id', 'department_name')->orderBy('id')->get();
        return view('arrival.arrivalslip.edit', compact('po_nos','departments'));
    }


    public function ViewArrivalSlip(Request $request)
    {
        
        $id = $request->id;
        $arrival_slip = ArrivalSlip::select('arrival_slips','arrival_weighbridges.*','arrival_inspections.*','production_purchase_orders.*','inpection_checklists.*','supplier.name as supplier_name','supplier.address as supplier_address','al2.name as parent_location', 'al1.name as location')
        ->join('production_purchase_orders','production_purchase_orders.voucher_no','arrival_slips.po_no')
        ->join('arrival_inspections as ai','ai.po_no','production_purchase_orders.voucher_no')
        ->leftjoin('supplier','supplier.id','production_purchase_orders.supplier_id')
        ->join('inpection_checklists as inc','inc.ins_id','ai.id')
        ->leftjoin('arrival_weighbridges','arrival_weighbridges.inspection_no','ai.ins_no')
        ->leftJoin('arrival_locations as al1', 'al1.id', '=', 'arrival_weighbridges.location_id')
        ->leftJoin('arrival_locations as al2', 'al2.id', '=', 'al1.parent_id')
        ->join('production_get_pass','production_get_pass.po_no','production_purchase_orders.voucher_no')
    
        ->where('production_purchase_orders.status', 1)
        ->where('inc.type', 2)
        ->where('ai.ins_status',1)
        ->where('arrival_slips.id',$id)
        // ->where('ai.ins_status',3)
        ->where('production_purchase_orders.voucher_status', '!=', '3')
        ->groupBy('production_purchase_orders.id')
        ->first();
        $subdepartments = DB::select('select `id`,`sub_department_name` from `sub_department` where `id` =' . $arrival_slip->department_id . '');
        return view('arrival.arrivalslip.show' , compact('arrival_slip'));
    }   

}
