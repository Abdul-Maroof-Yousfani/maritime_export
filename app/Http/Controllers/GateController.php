<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Models\CropBased;
use App\Models\Product;
use App\Gate;
use App\ProductionGatePassIn;
use App\ProductionPurchaseOrder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $gatepasses = ProductionGatePassIn::where('type', 1)->get();
            return view('arrival.gatepass.ajaxIndex', compact('gatepasses'));
        }
        return view('arrival.gatepass.index');
    }


    
    public function create()
    {
        return view('arrival.gatepass.create');
    }

    public function get_inspection_no(Request $request)
    {
        return CommonHelper::get_inspection_no($request);
    }

    // public function store(Request $request)
    // {

    //     $validator = Validator::make($request->all(), [
    //         'po_no' => 'required',
    //         'inspection_no' => 'required',
    //         'date' => 'required|date',
    //         'arrival_note' => 'required|string',
    //         'builty_no' => 'required|string',
    //         'vehicle_no' => 'required|string',
    //         'recived_qty' => 'required',
    //         'description' => 'required',
    //         'driver_name' => 'required|string|max:100',
    //         'transporter_name' => 'required|string|max:100',
    //     ],
    //     [
    //         'recived_qty.required'=>'The received qty field is required.'
    //     ]
    //     );

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     try {
    //         DB::beginTransaction();
    //         $request['gate_pass_no'] = CommonHelper::getProductionFormat(ProductionGatePassIn::class,'GIN-');
    //         $request['user_name'] = Auth::user()->name;
    //         ProductionGatePassIn::create($request->all());
    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'url' => url('arrival/getpass') . '?pageType=&parentCode=232&m=' . session('run_company') . '#Garibsons',
    //         ]);

    //         Session::flash('dataInsert', "Data Successfully Added");
    //         return redirect()->back();
    //     } catch (Exception $e) {
    //         DB::rollback();
    //         dd($e->getMessage());
    //     }
    // }

    public function store(Request $request)
{
    // Validation
    $validator = Validator::make($request->all(), [
        'po_no' => 'required',
        'inspection_no' => 'required',
        'date' => 'required|date',
        'arrival_note' => 'required|string',
        'builty_no' => 'required|string',
        'vehicle_no' => 'required|string',
        'recived_qty' => 'required',
        'description' => 'required',
        'driver_name' => 'required|string|max:100',
        'transporter_name' => 'required|string|max:100',
        'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ], [
        'recived_qty.required' => 'The received qty field is required.',
    ]);

    // If validation fails
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    try {
        DB::beginTransaction();

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $uniqueId = uniqid();
            $extension = $file->getClientOriginalExtension();
            $filename = $uniqueId . '.' . $extension;
            $folderPath = 'getpass';

            // Ensure the directory exists
            if (!Storage::disk('public')->exists($folderPath)) {
                Storage::disk('public')->makeDirectory($folderPath);
            }

            // Store the file and get its path
            $filePath = $file->storeAs($folderPath, $filename, 'public');
        }

        // Prepare data for insertion
        $requestData = $request->all();
        $requestData['attachment'] = $filePath;  // Add file path to the request data
        $requestData['gate_pass_no'] = CommonHelper::getProductionFormat(ProductionGatePassIn::class, 'GIN-');
        $requestData['user_name'] = Auth::user()->name;

        // Insert the data
        ProductionGatePassIn::create($requestData);

        DB::commit();

        // Success response
        return response()->json([
            'success' => true,
            'url' => url('arrival/getpass') . '?pageType=&parentCode=232&m=' . session('run_company') . '#Garibsons',
        ]);

    } catch (Exception $e) {
        DB::rollback();
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
}


    public function Viewgatepassin(Request $request)
    {
            $gatepasses = ProductionGatePassIn::leftJoin('production_purchase_orders','production_purchase_orders.voucher_no','production_get_pass.po_no')->find($request->id);
            return view('arrival.gatepass.show', compact('gatepasses'));
    }

    public function getproduct($id)
    {
        return Product::where('id', $id)->get();
    }

    /////////////////////////////------------ gate pass out ------------//////////////////////////


    public function getpass_out(Request $request)
    {
        if($request->ajax()){
            $gatepasses = ProductionGatePassIn::where('type', 2)->get();
            return view('arrival.gatepassout.ajaxIndex', compact('gatepasses'));
        }
        return view('arrival.gatepassout.index');
    }
    


    public function getpass_out_create()
    {
        $po_nos = ProductionPurchaseOrder::
        join('arrival_inspections as ai','ai.po_no','production_purchase_orders.voucher_no')
        ->join('inpection_checklists as inc','inc.ins_id','ai.id')
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('production_get_pass')
                ->whereRaw('production_get_pass.po_no = production_purchase_orders.voucher_no') 
                ->whereRaw('production_get_pass.type = 2');
        })
        ->where('production_purchase_orders.status', 1)
        ->where('inc.type', 2)
        ->where('ai.ins_status',1)
        // ->where('ai.ins_status',3)
        ->where('production_purchase_orders.voucher_status', '!=', '3')
        ->groupBy('production_purchase_orders.id')
        ->get();
        return view('arrival.gatepassout.create', compact('po_nos'));
    }


    // public function getpass_out_store(Request $request)
    // {

    //     $validator = Validator::make($request->all(), [
    //         'po_no' => 'required',
    //         'inspection_no' => 'required',
    //         'date' => 'required|date',
    //         'arrival_note' => 'required|string',
    //         'builty_no' => 'required|string',
    //         'vehicle_no' => 'required|string',
    //         'recived_qty' => 'required',
    //         'description' => 'required',
    //         'driver_name' => 'required|string|max:100',
    //         'transporter_name' => 'required|string|max:100',
    //     ],
    //     [
    //         'recived_qty.required'=>'The received qty field is required.'
    //     ]
    //     );

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }
        
    //     try {
    //         DB::beginTransaction();
    //         $request['gate_pass_no'] = CommonHelper::getProductionFormat(ProductionGatePassIn::class,'GOUT-');
    //         $request['user_name'] = Auth::user()->name;
    //         ProductionGatePassIn::create($request->all());
    //         // var save_qty = 0;
    //         // <input type="text" hidden name="save_qty" id="save_qty">
    //         // save_qty = parseInt(qty) - parseInt(received_qty);
    //         // $('#save_qty').val(save_qty);
    //         // ProductionPurchaseOrder::where('voucher_no',$request->po_no)->update(['balance_qty' => (int) $request->save_qty]);
    //         DB::commit();
    //         return response()->json([
    //             'success' => true,
    //             'url' => url('arrival/getpass_out') . '?pageType=&parentCode=232&m=' . session('run_company') . '#Garibsons',
    //         ]);
    //     } catch (Exception $e) {
    //         DB::rollback();
    //         dd($e->getMessage());
    //     }
    // }



public function getpass_out_store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'po_no' => 'required',
        'inspection_no' => 'required',
        'date' => 'required|date',
        'arrival_note' => 'required|string',
        'builty_no' => 'required|string',
        'vehicle_no' => 'required|string',
        'recived_qty' => 'required',
        'description' => 'required',
        'driver_name' => 'required|string|max:100',
        'transporter_name' => 'required|string|max:100',
        'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ], [
        'recived_qty.required' => 'The received qty field is required.',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    try {
        DB::beginTransaction();

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $uniqueId = uniqid();
            $extension = $file->getClientOriginalExtension();
            $filename = $uniqueId . '.' . $extension;
            $folderPath = 'getpass_out_store';

            // Ensure the directory exists
            if (!Storage::disk('public')->exists($folderPath)) {
                Storage::disk('public')->makeDirectory($folderPath);
            }

            // Store the file and get its path
            $filePath = $file->storeAs($folderPath, $filename, 'public');
        }
        $requestData = $request->all();
        $requestData = $request->except('attachment');
        $requestData['attachment'] = $filePath;
        $requestData['gate_pass_no'] = CommonHelper::getProductionFormat(ProductionGatePassIn::class, 'GOUT-');
        $requestData['user_name'] = Auth::user()->name;

        // Create the gate pass entry
        ProductionGatePassIn::create($requestData);

        // Optionally, update the balance_qty
        // $save_qty = $request->input('qty') - $request->input('recived_qty');
        // ProductionPurchaseOrder::where('voucher_no', $request->po_no)->update(['balance_qty' => $save_qty]);

        DB::commit();

        return response()->json([
            'success' => true,
            'url' => url('arrival/getpass_out') . '?pageType=&parentCode=232&m=' . session('run_company') . '#Garibsons',
        ]);
    } catch (Exception $e) {
        DB::rollback();
        // Log the error message for debugging
        Log::error('Failed to store gate pass out: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to store gate pass out.'], 500);
    }
}


    
    public function Viewgatepassout(Request $request)
    {
            $gatepasses = ProductionGatePassIn::leftJoin('production_purchase_orders','production_purchase_orders.voucher_no','production_get_pass.po_no')->find($request->id);
            return view('arrival.gatepassout.show', compact('gatepasses'));
    }




}
