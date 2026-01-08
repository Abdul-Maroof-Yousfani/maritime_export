<?php

namespace App\Http\Controllers;

use App\ArrivalLocation;
use App\ArrivalWeighbridge;
use App\Helpers\CommonHelper;
use App\Models\CropBased;
use App\Models\Product;
use App\ProductionGatePassIn;
use App\ProductionPurchaseOrder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WeighbridgeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        if($request->ajax()){
            $weighbridges = ArrivalWeighbridge::leftJoin('arrival_locations as al1', 'al1.id', '=', 'arrival_weighbridges.location_id')
                ->leftJoin('arrival_locations as al2', 'al2.id', '=', 'al1.parent_id')
                ->select('arrival_weighbridges.*','al2.name as parent_location', 'al1.name as location')
                ->where('type',1)
                ->get();
            return view('arrival.weighbridge.ajaxIndex', compact('weighbridges'));
        }
        return view('arrival.weighbridge.index');
    }


    public function create(Request $request)
    {
        $po_nos = ProductionPurchaseOrder::
        leftJoin('arrival_inspections','production_purchase_orders.voucher_no','arrival_inspections.po_no')
            ->leftJoin('customers','customers.id','arrival_inspections.customer_id')
            ->join('production_get_pass as pg','pg.po_no','production_purchase_orders.voucher_no')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('arrival_weighbridges')
                    ->whereRaw('arrival_weighbridges.po_no = production_purchase_orders.voucher_no');
            })
            ->where('production_purchase_orders.status', 1)
            ->where('pg.type', 1)
            ->where('arrival_inspections.ins_status', 1)
            ->where('production_purchase_orders.voucher_status', '!=', '3');
        if($request->ajax()){

            $po_nos = ProductionGatePassIn::where('inspection_no',$request->id)
                ->leftJoin('arrival_inspections','production_get_pass.inspection_no','arrival_inspections.ins_no')
                ->leftJoin('customers','customers.id','arrival_inspections.customer_id')
            ->select('arrival_inspections.*','production_get_pass.*','customers.name as customer_name')->get();

//                ->get();
//            $po_nos = $po_nos->where('pg.inspection_no',$request->id)
//            ->select('arrival_inspections.*','pg.*','customers.name as customer_name')->get();
            return response()->json(['gate_pass' => $po_nos]);
        }
        $parentlocations = ArrivalLocation::whereStatus(1)->get();
        $po_nos = $po_nos->select('production_purchase_orders.voucher_no')->get();
        return view('arrival.weighbridge.create', compact('po_nos','parentlocations'));
    }

//     public function store(Request $request)
//     {

//         $validator = Validator::make($request->all(), [
//             'po_no' => 'required',
//             'inspection_no' => 'required',
//             'location_id' => 'required',
//             'date' => 'required|date',
//             'vehicle_no' => 'required|string|max:20',
//             'cosec_no' => 'required',
//             'consignee_weight' => 'required|string',
//             'description' => 'required',
//             'no_of_pkgs' => 'required|string|max:100',
//             'goods_description' => 'required|string|max:100',
// //            'first_weight' => 'required|string|max:100',
// //            'second_weight' => 'required|string|max:100',
//             'gross_weight' => 'required|string|max:100',
//         ],
//             [
//                 'recived_qty.required'=>'The received qty field is required.',
//                 'location_id.required'=>'The Location field is required.'
//             ]
//         );

//         if ($validator->fails()) {
//             return response()->json(['errors' => $validator->errors()], 422);
//         }




//         // dd($request->all());
//         try {
//             DB::beginTransaction();
//             $request['weighbridge_no'] = CommonHelper::getProductionFormat(ArrivalWeighbridge::class,'WBR-');
//             $request['weighbridge_userid'] = Auth::user()->name;
//             $request['username'] = Auth::user()->name;
//             $request['type'] = 1;
//             ArrivalWeighbridge::create($request->all());

//             DB::commit();
//             return response()->json([
//                 'success' => true,
//                 'url' => url('arrival/weighbridge') . '?pageType=&parentCode=234&m=' . session('run_company') . '#Garibsons',
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
    // Validation rules
    $validator = Validator::make($request->all(), [
        'po_no' => 'required',
        'inspection_no' => 'required',
        'location_id' => 'required',
        'date' => 'required|date',
        'vehicle_no' => 'required|string|max:20',
        'cosec_no' => 'required',
        'consignee_weight' => 'required|string',
        'description' => 'required',
        'no_of_pkgs' => 'required|string|max:100',
        'goods_description' => 'required|string|max:100',
        'gross_weight' => 'required|string|max:100',
        'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ], [
        'recived_qty.required' => 'The received qty field is required.',
        'location_id.required' => 'The Location field is required.',
    ]);

    // Check if validation fails
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
            $folderPath = 'weighbridge';

            // Ensure the directory exists
            if (!Storage::disk('public')->exists($folderPath)) {
                Storage::disk('public')->makeDirectory($folderPath);
            }

            // Store the file and get its path
            $filePath = $file->storeAs($folderPath, $filename, 'public');
        }

        // Prepare request data and add custom fields
        $requestData = $request->all(); // Get all form data
        $requestData['attachment'] = $filePath; // Add file path to the data
        $requestData['weighbridge_no'] = CommonHelper::getProductionFormat(ArrivalWeighbridge::class, 'WBR-');
        $requestData['weighbridge_userid'] = Auth::user()->name;
        $requestData['username'] = Auth::user()->name;
        $requestData['type'] = 1; // Custom field for 'type'

        // Insert data into the database
        ArrivalWeighbridge::create($requestData);

        DB::commit();

        // Return success response
        return response()->json([
            'success' => true,
            'url' => url('arrival/weighbridge') . '?pageType=&parentCode=234&m=' . session('run_company') . '#Garibsons',
        ]);
    } catch (Exception $e) {
        DB::rollback();
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
}



    public function Viewweighbridge(Request $request)
    {
        $id = $request->id;
        $weightbridge = ArrivalWeighbridge::leftJoin('arrival_locations as al1', 'al1.id', '=', 'arrival_weighbridges.location_id')
            ->leftJoin('arrival_locations as al2', 'al2.id', '=', 'al1.parent_id')
            ->select('arrival_weighbridges.*','al2.name as parent_location', 'al1.name as location')->find($id);
        return view('arrival.weighbridge.show', compact('weightbridge'));
    }
    public function weighbridgeTranfer(Request $request)
    {
        $id = $request->id;
        return view('arrival.weighbridge.transfer', compact('id'));
    }


    public function storeweighbridgeTranfer(Request $request)
    {

        try {
            DB::beginTransaction();

            $id = $request->id;
            $weightbridge = ArrivalWeighbridge::find($id);
            $weightbridge->location_id = $request->location_id;
            $weightbridge->location_no = $request->location_no;
            $weightbridge->save();

            DB::commit();
            Session::flash('dataInsert', "Data Successfully Added");
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }

    }


    public function second_weighbridge(Request $request)
    {
        if($request->ajax()){
            $weighbridges = ArrivalWeighbridge::
                 leftJoin('arrival_locations as al1', 'al1.id', '=', 'arrival_weighbridges.location_id')
                ->leftJoin('arrival_locations as al2', 'al2.id', '=', 'al1.parent_id')
                ->select('arrival_weighbridges.*','al2.name as parent_location', 'al1.name as location')
                ->where('arrival_weighbridges.type',2)
                ->get();
            return view('arrival.second_weighbridge.ajaxIndex', compact('weighbridges'));
        }
        return view('arrival.second_weighbridge.index');
    }


    public function create_second_weighbridge(Request $request)
    {
        $po_nos = ProductionPurchaseOrder::
        leftJoin('arrival_inspections','production_purchase_orders.voucher_no','arrival_inspections.po_no')
            ->leftJoin('customers','customers.id','arrival_inspections.customer_id')
            ->join('production_get_pass as pg','pg.po_no','production_purchase_orders.voucher_no')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('arrival_weighbridges')
                    ->whereRaw('arrival_weighbridges.po_no = production_purchase_orders.voucher_no');
            })
            ->where('production_purchase_orders.status', 1)
            ->where('pg.type', 1)
            ->where('arrival_inspections.ins_status', 1)
            ->where('production_purchase_orders.voucher_status', '!=', '3');
        if($request->ajax()){

            $po_nos = ProductionGatePassIn::where('inspection_no',$request->id)
                ->leftJoin('arrival_inspections','production_get_pass.inspection_no','arrival_inspections.ins_no')
                ->leftJoin('customers','customers.id','arrival_inspections.customer_id')
                ->where('production_get_pass.type', 1)
            ->select('arrival_inspections.*','production_get_pass.*','customers.name as customer_name')->get();

//                ->get();
//            $po_nos = $po_nos->where('pg.inspection_no',$request->id)
//            ->select('arrival_inspections.*','pg.*','customers.name as customer_name')->get();
            return response()->json(['gate_pass' => $po_nos]);
        }
        $parentlocations = ArrivalLocation::whereStatus(1)->get();
        $po_nos = $po_nos->select('production_purchase_orders.voucher_no')->get();
        return view('arrival.second_weighbridge.create', compact('po_nos','parentlocations'));
    }

    public function get_webridge($id)
    {
        return ArrivalWeighbridge::where('inspection_no', $id)->get();
    }

    // public function store_second_weighbridge(Request $request)
    // {

    //     $validator = Validator::make($request->all(), [
    //         'po_no' => 'required',
    //         'date' => 'required|date',
    //         'vehicle_no' => 'required|string|max:20',
    //         'cosec_no' => 'required',
    //         'consignee_weight' => 'required|string',
    //         'description' => 'required',
    //         'no_of_pkgs' => 'required|string|max:100',
    //         'goods_description' => 'required|string|max:100',
    //         'gross_weight' => 'required|string|max:100',
    //     ],
    //         [
    //             'recived_qty.required'=>'The received qty field is required.',
    //         ]
    //     );

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }




    //     // dd($request->all());
    //     try {
    //         DB::beginTransaction();
    //         $request['weighbridge_no'] = CommonHelper::getProductionFormat(ArrivalWeighbridge::class,'WBR-');
    //         $request['weighbridge_userid'] = Auth::user()->name;
    //         $request['username'] = Auth::user()->name;
    //         $request['type'] = 2;
    //         ArrivalWeighbridge::create($request->all());

    //         DB::commit();
    //         return response()->json([
    //             'success' => true,
    //             'url' => url('arrival/second_weighbridge') . '?pageType=&parentCode=234&m=' . session('run_company') . '#Garibsons',
    //         ]);
    //     } catch (Exception $e) {
    //         DB::rollback();
    //         dd($e->getMessage());
    //     }
    // }

    public function store_second_weighbridge(Request $request)
{
    $validator = Validator::make($request->all(), [
        'po_no' => 'required',
        'date' => 'required|date',
        'vehicle_no' => 'required|string|max:20',
        'cosec_no' => 'required',
        'consignee_weight' => 'required|string',
        'description' => 'required|string',
        'no_of_pkgs' => 'required|string|max:100',
        'goods_description' => 'required|string|max:100',
        'gross_weight' => 'required|string|max:100',
        'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    try {
        DB::beginTransaction();

        $filePath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $uniqueId = uniqid();
            $extension = $file->getClientOriginalExtension();
            $filename = $uniqueId . '.' . $extension;
            $folderPath = 'second_weighbridge';

            // Ensure the directory exists
            if (!Storage::disk('public')->exists($folderPath)) {
                Storage::disk('public')->makeDirectory($folderPath);
            }

            // Store the file and get its path
            $filePath = $file->storeAs($folderPath, $filename, 'public');
        }

        // Prepare data to be inserted
        $data = [
            'po_no' => $request->input('po_no'),
            'date' => $request->input('date'),
            'vehicle_no' => $request->input('vehicle_no'),
            'cosec_no' => $request->input('cosec_no'),
            'consignee_weight' => $request->input('consignee_weight'),
            'description' => $request->input('description'),
            'no_of_pkgs' => $request->input('no_of_pkgs'),
            'goods_description' => $request->input('goods_description'),
            'gross_weight' => $request->input('gross_weight'),
            'attachment' => $filePath,  // store file path
            'weighbridge_no' => CommonHelper::getProductionFormat(ArrivalWeighbridge::class, 'WBR-'),
            'weighbridge_userid' => Auth::user()->name,
            'username' => Auth::user()->name,
            'type' => 2
        ];

        // Save the data into the database
        ArrivalWeighbridge::create($data);

        DB::commit();

        return response()->json([
            'success' => true,
            'url' => url('arrival/second_weighbridge') . '?pageType=&parentCode=234&m=' . session('run_company') . '#Garibsons',
        ]);

    } catch (Exception $e) {
        DB::rollback();
        // Log error for debugging and return a readable message
        Log::error('Error storing second weighbridge data: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred while processing the request. Please try again later.'], 500);
    }
}

    public function ViewSecondweighbridge(Request $request)
    {
        // dd('check');
        $id = $request->id;
        $weightbridge = ArrivalWeighbridge::leftJoin('arrival_locations as al1', 'al1.id', '=', 'arrival_weighbridges.location_id')
            ->leftJoin('arrival_locations as al2', 'al2.id', '=', 'al1.parent_id')
            ->select('arrival_weighbridges.*','al2.name as parent_location', 'al1.name as location')->find($id);
//       dd($weightbridge);
        return view('arrival.second_weighbridge.show', compact('weightbridge'));
    }
}
