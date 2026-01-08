<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\InspectionPurhaseOrderData;
use App\Models\CropBased;
use App\Models\Customer;
use App\Models\PrintingBags;
use App\Models\Product;
use App\ArrivalInspection;
use App\ArrivalStock;
use App\ArrivalSupplier;
use App\InpectionChecklist;
use App\InspectionParameter;
use App\Models\Supplier;
use App\ProductionPurchaseOrder;
use App\QualityChecker;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class InspectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        if($request->ajax()){
            $inspections =  ArrivalInspection::leftJoin('production_purchase_orders','production_purchase_orders.voucher_no','arrival_inspections.po_no')
                ->join('inpection_checklists' , 'inpection_checklists.ins_id' , 'arrival_inspections.id')
                ->leftJoin('customers','customers.id','arrival_inspections.customer_id')
                ->where('arrival_inspections.type',1)
                ->select('arrival_inspections.*','production_purchase_orders.voucher_no','customers.name as customer_name')
//                ->where('inpection_checklists.type' , 1)

                ->groupby('arrival_inspections.id')
                ->get();

            return view('arrival.inspection.ajaxIndex', compact('inspections'));
        }
        return view('arrival.inspection.index');
    }

    public function create()
    {
        $str = ArrivalInspection::count();
        $insno = 'INS-' . sprintf("%'05d", ($str + 1)); // . date('my');
        $data['insno'] = $insno;
        $data['purcahseOrder'] = ProductionPurchaseOrder::select('production_purchase_orders.voucher_no','production_purchase_orders.id' , 'production_purchase_orders.delivery_term')
            // ->leftjoin('arrival_inspections' , 'arrival_inspections.po_id' , 'production_purchase_orders.id')
            // ->leftjoin('inpection_checklists', 'inpection_checklists.ins_id', '=', 'arrival_inspections.id')
            // ->whereNull('arrival_inspections.id')
            // ->where('inpection_checklists.type', '=', 1)
            // ->WhereNull('arrival_inspections.id')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('arrival_inspections')
                    ->whereRaw('arrival_inspections.po_no = production_purchase_orders.voucher_no')
                    ->join('inpection_checklists', 'inpection_checklists.ins_id', '=', 'arrival_inspections.id')
                    ->whereRaw('inpection_checklists.type = 1');
            })
            ->groupBy('production_purchase_orders.id')
            ->get();
        $data['categories'] = Product::where('table_type', 1)->where('status', 1)->where('parent_id', null)->get();
        $data['printingBags']  = PrintingBags::where('status',1)->get();
        $data['customers']  = ArrivalSupplier::get();
        return view('arrival.inspection.create', $data);
    }

//     public function store(Request $request)
//     {
// //        // Validate the request data
// //        $validated = $request->validate([
// //            'po_id' => 'required|integer',
// //            'ins_no' => 'required|string|max:50',
// //            'date' => 'required|date',
// //            'truck_no' => 'required|string|max:20',
// //            'product_description' => 'required|string',
// //            'customer_id' => 'required|integer',
// //            'no_of_bags' => 'required|integer',
// //            'pp_bags_id' => 'required|integer',
// //            'jute_bags' => 'required|integer',
// //            'shipment_origin' => 'required|string',
// //            'bilty_no' => 'required|string|max:50',
// //            'bilty_date' => 'required|date',
// //            'consignee_weight' => 'required|integer',
// //            'driver_name' => 'required|string|max:100',
// //            'transporter_name' => 'required|string|max:100',
// //            'checklist_id' => 'required|array',
// //            'checklist_comment' => 'required|array',
// //        ]);


//         $validator = Validator::make($request->all(), [
//             'po_no' => 'required',
//             'ins_no' => 'required|string|max:50',
//             'date' => 'required|date',
//             'truck_no' => 'required|string|max:20',
//             'product_description' => 'required|string',
//             'customer_id' => 'required',
//             'no_of_bags' => 'required',
//             'pp_bags_id' => 'required',
//             'jute_bags' => 'required',
//             'total_qty' => 'required',
//             'balance_qty' => 'required',
//             'recived_qty' => 'required',
//             'reject_qty' => 'required',
//             'bilty_no' => 'required|string|max:50',
//             'bilty_date' => 'required|date',
//             'consignee_weight' => 'required',
//             'driver_name' => 'required|string|max:100',
//             'transporter_name' => 'required|string|max:100',
//             'checklist_id' => 'required|array',
//             'checklist_comment' => 'required|array',
//             'inspect_by' => 'required',
//             'justification' => 'required',
//         ]);



//         if ($validator->fails()) {
//             return response()->json(['errors' => $validator->errors()], 422);
//         }

// //        if ($validator->fails()) {
// //            return response()->json([
// //                'success' => 'error',
// //                'message' => 'error',
// //                'error' => $validator->errors()
// //            ]);
// //        }




//         // Begin a transaction
//         DB::beginTransaction();

//         try {
// //dd($request);

//             $balance_qty =  $request->recived_qty - $request->reject_qty;
//             if($balance_qty == 0){
//                 $request['overall_rejected'] = 1;
//             }

//             // Insert into arrival_inspections
//             $request['created_by'] = auth()->user()->name;
//             $arrivalInspection = ArrivalInspection::create($request->except(['type','checker_id','checklist_id','checklist_comment']));
// //            dd($arrivalInspection);

//             foreach ($request->checklist_id as $index => $checklistId) {
//                 $comment = isset($request->checklist_comment[$index]) ? $request->checklist_comment[$index] : null;

//                 InpectionChecklist::create([
//                     'type' => 1, // Assuming the type is 1 for first inspection, change as necessary
//                     'ins_id' => $arrivalInspection->id,
//                     'checker_id' => $checklistId,
//                     'comment' => $comment,
//                 ]);
//             }

//             DB::commit();
//             return response()->json([
//                 'success' => true,
//                 'url' => url('arrival/inspection') . '?pageType=&parentCode=234&m=' . session('run_company') . '#Garibsons',
//             ]);
//         } catch (\Exception $e) {
//             // Rollback the transaction if something goes wrong
//             DB::rollBack();
//             return response()->json(['message' => 'Failed to create inspection', 'error' => $e->getMessage()], 500);
//         }
//     }


public function store(Request $request)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'po_no' => 'required',
        'ins_no' => 'required|string|max:50',
        'date' => 'required|date',
        'truck_no' => 'required|string|max:20',
        'product_description' => 'required|string',
        'customer_id' => 'required',
        'no_of_bags' => 'required',
        'pp_bags_id' => 'required',
        'jute_bags' => 'required',
        'total_qty' => 'required',
        'balance_qty' => 'required',
        'recived_qty' => 'required',
        'reject_qty' => 'required',
        'bilty_no' => 'required|string|max:50',
        'bilty_date' => 'required|date',
        'consignee_weight' => 'required',
        'driver_name' => 'required|string|max:100',
        'transporter_name' => 'required|string|max:100',
        'checklist_id' => 'required|array',
        'checklist_comment' => 'required|array',
        'inspect_by' => 'required',
        'justification' => 'required',
        'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Begin a transaction
    DB::beginTransaction();

    try {
        $balance_qty = $request->recived_qty - $request->reject_qty;
        if ($balance_qty == 0) {
            $request->merge(['overall_rejected' => 1]);
        }

        $filePath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $uniqueId = uniqid();
            $extension = $file->getClientOriginalExtension();
            $filename = $uniqueId . '.' . $extension;
            $folderPath = 'ArrivalInspection';
            if (!Storage::disk('public')->exists($folderPath)) {
                Storage::disk('public')->makeDirectory($folderPath);
            }
            $filePath = $file->storeAs($folderPath, $filename, 'public');
        }

        // Optionally, set the attachment field in the request data
        $requestData = $request->except(['type', 'checker_id', 'checklist_id', 'checklist_comment']);
        $requestData['attachment'] = $filePath;
        $requestData['created_by'] = auth()->user()->name;

        

        // Insert into arrival_inspections
        $arrivalInspection = ArrivalInspection::create($requestData);

        foreach ($request->checklist_id as $index => $checklistId) {
            $comment = $request->checklist_comment[$index] ?? null;

            InpectionChecklist::create([
                'type' => 1, // Assuming the type is 1 for first inspection, change as necessary
                'ins_id' => $arrivalInspection->id,
                'checker_id' => $checklistId,
                'comment' => $comment,
            ]);
        }

        DB::commit();
        return response()->json([
            'success' => true,
            'url' => url('arrival/inspection') . '?pageType=&parentCode=234&m=' . session('run_company') . '#Garibsons',
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['message' => 'Failed to create inspection', 'error' => $e->getMessage()], 500);
    }
}

public function getChecklist(Request $request)
    {
        $purcahseOrder = ProductionPurchaseOrder::where('production_purchase_orders.voucher_no',$request->po)
            ->leftJoin('product','product.id','production_purchase_orders.product_id')
             ->select('product.qc_id','production_purchase_orders.*')
            ->first();


        if($purcahseOrder && $purcahseOrder->qc_id != null){
            $qcs = QualityChecker::whereIn('id',json_decode($purcahseOrder->qc_id))->select('name','id')->get();

        }else{
            $qcs = array();
        }

//        $qcs = QualityChecker::select('name','id')->get();
        return view('arrival.inspection.checklists', compact('qcs','purcahseOrder'));

    }


    public function getProductDescription(Request $request,$id)
    {
        $purcahseOrder = ProductionPurchaseOrder::where('production_purchase_orders.voucher_no',$id)
            ->leftJoin('product','product.id','production_purchase_orders.product_id')
            ->select('product.name')
            ->first();

        return $purcahseOrder->name;

    }

    public function ViewInspection(Request $request)
    {


        $inspections =  ArrivalInspection::where('arrival_inspections.id',$request->id)
            ->leftJoin('production_purchase_orders','production_purchase_orders.voucher_no','arrival_inspections.po_no')
            ->leftJoin('customers','customers.id','arrival_inspections.customer_id')
            ->select('arrival_inspections.*','production_purchase_orders.voucher_no','customers.name as customer_name')
            ->first();

        $checklists = DB::connection('mysql2')->table('inpection_checklists')
            ->leftJoin(DB::connection('mysql')->getDatabaseName() . '.quality_checkers', 'inpection_checklists.checker_id', '=', 'quality_checkers.id')
            ->where('inpection_checklists.ins_id', $request->id)
            ->select('inpection_checklists.*', 'quality_checkers.*')
            ->get();

        return view('arrival.inspection.show', compact('inspections','checklists'));

    }



    public function approveInspection($id)
    {
        // Find the inspection by ID and update the status to approved
        $inspection = ArrivalInspection::find($id);
        if ($inspection) {
            $inspection->ins_status = 1; // Assuming 1 is for approved
            $inspection->save();
            return response()->json(['message' => 'Inspection approved successfully']);
        } else {
            return response()->json(['message' => 'Inspection not found'], 404);
        }
    }

    public function rejectInspection($id)
    {
        // Find the inspection by ID and update the status to rejected
        $inspection = ArrivalInspection::find($id);
        if ($inspection) {
            $inspection->ins_status = 2; // Assuming 2 is for rejected
            $inspection->save();


            return response()->json(['message' => 'Inspection rejected successfully']);
        } else {
            return response()->json(['message' => 'Inspection not found'], 404);
        }
    }



    ///////////////////////////////-------------   Final inspection  -------------------////////////////////////////////////


    public function final_inspection(Request $request)
    {

        if($request->ajax()){
            $inspections =  ArrivalInspection::leftJoin('production_purchase_orders','production_purchase_orders.id','arrival_inspections.po_id')
                ->join('inpection_checklists' , 'inpection_checklists.ins_id' , 'arrival_inspections.id')
                ->leftJoin('customers','customers.id','arrival_inspections.customer_id')
                ->select('arrival_inspections.*','production_purchase_orders.voucher_no','customers.name as customer_name')
                ->where('inpection_checklists.type' , 3)
                ->groupby('arrival_inspections.id')
                ->get();

            return view('arrival.finalInspection.ajaxIndex', compact('inspections'));
        }
        return view('arrival.finalInspection.index');
    }


    public function create_final_inspection(Request $request){
        $str = ArrivalInspection::count();
        $insno = 'SINS-' . sprintf("%'05d", ($str + 1)); // . date('my');
        $data['insno'] = $insno;
        $data['purcahseOrder'] = ProductionPurchaseOrder::join('arrival_inspections' , 'arrival_inspections.po_id' , 'production_purchase_orders.id')
            ->join('production_get_pass' , 'production_get_pass.inspection_no' , 'arrival_inspections.ins_no')
            ->join('arrival_weighbridges' , 'arrival_weighbridges.gate_pass_no' , 'production_get_pass.gate_pass_no')
            // ->where('production_purchase_orders.inspection_status' , 1)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('arrival_inspections')
                    ->whereRaw('arrival_inspections.po_id = production_purchase_orders.id')
                    ->join('inpection_checklists', 'inpection_checklists.ins_id', '=', 'arrival_inspections.id')
                    ->whereRaw('inpection_checklists.type = 3');
            })
            ->groupBy('production_purchase_orders.id')
            ->where('arrival_weighbridges.location_id' , '!=' , null)
            ->select('production_purchase_orders.voucher_no','production_purchase_orders.id')->get();
        $data['categories'] = Product::where('table_type', 1)->where('status', 1)->where('parent_id', null)->get();
        $data['printingBags']  = PrintingBags::where('status',1)->get();
        $data['customers']  = Customer::where('status',1)->select('customers.id','customers.name')->get();
        return view('arrival.finalInspection.create', $data);
    }


    public function getProductDescriptionForFinal(Request $request,$id)
    {
  
        $ins = ArrivalInspection::where('ins_no',$id)->first();

        $purcahseOrder = ProductionPurchaseOrder::where('arrival_inspections.ins_no',$ins->first_ins_no)
            ->join('arrival_inspections' , 'arrival_inspections.po_no' , 'production_purchase_orders.voucher_no')
            ->join('production_get_pass' , 'production_get_pass.inspection_no' , 'arrival_inspections.ins_no')
            ->join('arrival_weighbridges' , 'arrival_weighbridges.inspection_no' , 'arrival_inspections.ins_no')
            ->leftJoin('product','product.id','production_purchase_orders.product_id')
            // ->where('arrival_inspections.type',1)
            ->select('product.name' , 'arrival_inspections.*' ,'production_get_pass.gate_pass_no' , 'arrival_weighbridges.weighbridge_no')
            ->first();

            return $purcahseOrder;

    }


    public function getChecklistFinal(Request $request,$id)
    {

       $ins = ArrivalInspection::where('ins_no',$id)->first();
       $firstins = ArrivalInspection::where('ins_no',$ins->first_ins_no)->first();
        $purcahseOrder = ProductionPurchaseOrder::where('production_purchase_orders.voucher_no',$request->po_no)
            ->leftJoin('product','product.id','production_purchase_orders.product_id')
            ->select('product.qc_id')
            ->first();
//        dd($ins);
        // $checklistsData = ProductionPurchaseOrder::where('arrival_inspections.ins_no',$id)
        //     ->join('arrival_inspections' , 'arrival_inspections.po_id' , 'production_purchase_orders.id')
        //     ->join('inpection_checklists' , 'inpection_checklists.ins_id' , 'arrival_inspections.id')
        //     ->leftJoin('product','product.id','production_purchase_orders.product_id')
        //     // ->select('product.qc_id')
        //     ->select('product.qc_id','inpection_checklists.comment')
        //     // ->where('production_purchase_orders.inspection_status' , 1)
        //     ->get();
        // dd($id , $purcahseOrder , $checklistsData);
        if($purcahseOrder && $purcahseOrder->qc_id != null){
            $qcs = QualityChecker::whereIn('id',json_decode($purcahseOrder->qc_id))->select('name','id')->get();

        }else{
            $qcs = array();
        }
        
        // dd($qcs->toArray());


     
        // $qcs = QualityChecker::select('name','id')->get();

        return view('arrival.finalInspection.checklists', compact('qcs','id','ins','firstins'));

    }

    public function store_final_inspection(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'po_no' => 'required',
            'date' => 'required|date',
            'truck_no' => 'required|string|max:20',
            'product_description' => 'required|string',
            'customer_id' => 'required',
            'no_of_bags' => 'required',
            'pp_bags_id' => 'required',
            'jute_bags' => 'required',
            // 'total_qty' => 'required',
            // 'balance_qty' => 'required',
            // 'recived_qty' => 'required',
            // 'reject_qty' => 'required',
            'bilty_no' => 'required|string|max:50',
            'bilty_date' => 'required|date',
            'consignee_weight' => 'required',
            'driver_name' => 'required|string|max:100',
            'transporter_name' => 'required|string|max:100',
            'checklist_id' => 'required|array',
           'checklist_comment' => 'required|array',
            // 'second_checklist_comment' => 'required|array',
            'inspect_by' => 'required',
            'justification' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }



        // Begin a transaction
        DB::beginTransaction();

        try {
            $str = ArrivalInspection::count();
            $insno = 'INS-3-' . sprintf("%'05d", ($str + 1)); // . date('my');

            $request['type'] = 3;
            $request['ins_no'] = $insno;
            $request['created_by'] = auth()->user()->name;
            $arrivalInspection = ArrivalInspection::create($request->except(['checklist_id','checklist_comment','parameter_id','deduction','total_deduction','total_deduction_update','received_qty']));


            foreach ($request->checklist_id as $index => $checklistId) {
                $comment = isset($request->checklist_comment[$index]) ? $request->checklist_comment[$index] : null;

                InpectionChecklist::create([
                    'type' => 3, // Assuming the type is 1 for first inspection, change as necessary
                    'ins_id' => $arrivalInspection->id,
                    'checker_id' => $checklistId,
                    'comment' => $comment,
                ]);
            }

            foreach ($request->parameter_id as $key1 => $ParamId) {
                $received_qty = isset($request->received_qty[$key1]) ? $request->received_qty[$key1] : 0;
                $deduction = isset($request->deduction[$key1]) ? $request->deduction[$key1] : 0;
                $total_deduction = isset($request->total_deduction[$key1]) ? $request->total_deduction[$key1] : 0;
                $total_deduction_update = isset($request->total_deduction_update[$key1]) ? $request->total_deduction_update[$key1] : 0;

                InspectionParameter::create([
                    'ins_id' => $arrivalInspection->id,
                    'parameter_id' => $ParamId,
                    'received_qty' => $received_qty,
                    'deduction' => $deduction,
                    'total_deduction' => $total_deduction,
                    'total_deduction_update' => $total_deduction_update,
                ]);


            }


            $purcahseOrder = ProductionPurchaseOrder::where('voucher_no',$arrivalInspection->po_no)->first();
            $qtyafterCalc = $arrivalInspection->recived_qty - optional($arrivalInspection->moisture1)->total_deduction_update;
            $costAmount =  $purcahseOrder->landed_rate_per_kg*$qtyafterCalc;
            $totalBags =   $arrivalInspection->recived_qty/100;
            $bardana = $totalBags*$purcahseOrder->bardana_per_bag;
            $commission = $totalBags*$purcahseOrder->commission_per_bag;
            $freight = $arrivalInspection->recived_qty*$purcahseOrder->freight_per_traller;
            $broken =optional($arrivalInspection->broken1)->total_deduction_update;
            $damage =optional($arrivalInspection->damage1)->total_deduction_update;
            $chobba =optional($arrivalInspection->chobba1)->total_deduction_update;
            $o_v =optional($arrivalInspection->o_v1)->total_deduction_update;
            $chalky =optional($arrivalInspection->chalky1)->total_deduction_update;
            $look =optional($arrivalInspection->look1)->total_deduction_update;
//                                                KGssssssssssssssss

            $totalDeductions = $broken+$damage+$chobba+$o_v+$chalky+$look;

            $costTotalAmount = (int)$costAmount+(int)$bardana+(int)$commission+(int)$freight-$totalDeductions;
            

            $stock = ArrivalStock::create([
                'po_no' => $arrivalInspection->po_no,
                'ins_no' => $arrivalInspection->ins_no,
                'supplier_id' => $purcahseOrder->supplier_id,
                'location_id' => $purcahseOrder->location_id,
                'item_id' => $purcahseOrder->item_id,
                'sub_variety_id' => $purcahseOrder->subitem_id,
                'avg_qty' => $qtyafterCalc,
                'avg_rate' => (float)$costTotalAmount / (float)$qtyafterCalc,
                'avg_amount' =>   $costTotalAmount ,
                'type' => 1
            ]);


            DB::commit();
            return response()->json([
                'success' => true,
                'url' => url('arrival/final_inspection') . '?pageType=&parentCode=234&m=' . session('run_company') . '#Garibsons',
            ]);
            Session::flash('dataInsert', "Inspection created successfully");
            return redirect()->back();
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();
            return response()->json(['message' => 'Failed to create inspection', 'error' => $e->getMessage()], 500);
        }
    }

    public function ViewFinalInspection(Request $request)
    {


        $inspections =  ArrivalInspection::where('arrival_inspections.id',$request->id)
            ->leftJoin('production_purchase_orders','production_purchase_orders.id','arrival_inspections.po_id')
            ->leftJoin('customers','customers.id','arrival_inspections.customer_id')
            ->select('arrival_inspections.*','production_purchase_orders.voucher_no','customers.name as customer_name')
            ->first();

        $checklists = DB::connection('mysql2')->table('inpection_checklists')
            ->leftJoin(DB::connection('mysql')->getDatabaseName() . '.quality_checkers', 'inpection_checklists.checker_id', '=', 'quality_checkers.id')
            ->where('inpection_checklists.ins_id', $request->id)
            ->select('inpection_checklists.*', 'quality_checkers.*')
            ->get();

        $id =  ArrivalInspection::where('arrival_inspections.ins_no',$inspections->first_ins_no)->value('id');

        $first_checklists = DB::connection('mysql2')->table('inpection_checklists')
            ->leftJoin(DB::connection('mysql')->getDatabaseName() . '.quality_checkers', 'inpection_checklists.checker_id', '=', 'quality_checkers.id')
            ->where('inpection_checklists.ins_id', $id)
            ->select('inpection_checklists.*', 'quality_checkers.*')
            ->get();
        return view('arrival.finalInspection.show', compact('inspections','first_checklists','checklists'));

    }

    public function rejectFinalInspection($id)
    {
        // Find the inspection by ID and update the status to rejected
        $inspection = ArrivalInspection::find($id);
        if ($inspection) {
            $inspection->ins_status = 2; // Assuming 2 is for rejected
            $inspection->save();

            return response()->json(['message' => 'Inspection rejected successfully']);
        } else {
            return response()->json(['message' => 'Inspection not found'], 404);
        }
    }

    public function approveFinalInspection($id)
    {
        // Find the inspection by ID and update the status to approved
        $inspection = ArrivalInspection::find($id);
        if ($inspection) {
            $inspection->ins_status = 1; // Assuming 1 is for approved
            $inspection->save();
            return response()->json(['message' => 'Inspection approved successfully']);
        } else {
            return response()->json(['message' => 'Inspection not found'], 404);
        }
    }

    public function get_final_insepction(Request $request)
    {
        $nos = ArrivalInspection::
        leftjoin('production_purchase_orders','production_purchase_orders.voucher_no','arrival_inspections.po_no')
            ->join('inpection_checklists', 'inpection_checklists.ins_id', '=', 'arrival_inspections.id')
            // ->where('inpection_checklists.type',3)
            ->where('arrival_inspections.po_no', $request->po_no)
            ->groupby('arrival_inspections.id')
            ->get();

        return $nos ?? [];
    }
    public function get_Po_Details(Request $request)
    {
        $inspection =ArrivalInspection::where('ins_no',$request->ins_no)->first();

       $po = ProductionPurchaseOrder::where('voucher_no',$inspection->po_no)->first();
        $data['received_qty'] = $inspection->recived_qty ?? 0;
        $data['inspection'] = $inspection;

        $damage_remaining = (int)optional($inspection->damage)->comment ?? 0;
        $damage_total_amount = 0;
        $damage_previous_slab_to = 0; 

        $chalky_remaining = (int)optional($inspection->chalky)->comment ?? 0;
        $chalky_total_amount = 0;
        $chalky_previous_slab_to = 0; 

        $broken_remaining = (int)optional($inspection->broken)->comment ?? 0;
        $broken_total_amount = 0;
        $broken_previous_slab_to = 0; 

        $o_v_remaining = (int)optional($inspection->o_v)->comment ?? 0;
        $o_v_total_amount = 0;
        $o_v_previous_slab_to = 0; 

        $chobba_remaining = (int)optional($inspection->chobba)->comment ?? 0;
        $chobba_total_amount = 0;
        $chobba_previous_slab_to = 0; 

        $look_remaining = (int)optional($inspection->look)->comment ?? 0;
        $look_total_amount = 0;
        $look_previous_slab_to = 0; 

        $damages = DB::connection('mysql2')->table('slabs')->select('to', 'amount')->where('product_id', $po->item_id)->where('slab_type_id', 2)->where('from', '<', optional($inspection->damage)->comment)->orderBy('from', 'asc')->get();
        $chalkys = DB::connection('mysql2')->table('slabs')->select('to', 'amount')->where('product_id', $po->item_id)->where('slab_type_id', 3)->where('from', '<', optional($inspection->chalky)->comment)->orderBy('from', 'asc')->get();
        $brokens = DB::connection('mysql2')->table('slabs')->select('to', 'amount')->where('product_id', $po->item_id)->where('slab_type_id', 4)->where('from', '<', optional($inspection->broken)->comment)->orderBy('from', 'asc')->get();
        $o_vs = DB::connection('mysql2')->table('slabs')->select('to', 'amount')->where('product_id', $po->item_id)->where('slab_type_id', 5)->where('from', '<', optional($inspection->o_v)->comment)->orderBy('from', 'asc')->get();
        $chobbas = DB::connection('mysql2')->table('slabs')->select('to', 'amount')->where('product_id', $po->item_id)->where('slab_type_id', 6)->where('from', '<', optional($inspection->chobba)->comment)->orderBy('from', 'asc')->get();
        $looks = DB::connection('mysql2')->table('slabs')->select('to', 'amount')->where('product_id', $po->item_id)->where('slab_type_id', 7)->where('from', '<', optional($inspection->look)->comment)->orderBy('from', 'asc')->get();

        foreach ($damages as $key => $slab) {

            $effective_quantity = $slab->to - $damage_previous_slab_to;

            // If the remaining value is less than the slab range, adjust the effective quantity
            if ($damage_remaining < $effective_quantity) {
                $effective_quantity = $damage_remaining;
            }
            
            $damage_total_amount += ((int)$effective_quantity / 100) * (float)$slab->amount * (int)$inspection->recived_qty;
            $damage_remaining -= $effective_quantity;
            $damage_previous_slab_to = $slab->to;

            if ($damage_remaining <= 0) {
                break;
            }
        }

        foreach ($chalkys as $key => $slab) {

            $effective_quantity = $slab->to - $chalky_previous_slab_to;

            // If the remaining value is less than the slab range, adjust the effective quantity
            if ($chalky_remaining < $effective_quantity) {
                $effective_quantity = $chalky_remaining;
            }
            
            $chalky_total_amount += ((int)$effective_quantity / 100) * (float)$slab->amount * (int)$inspection->recived_qty;
            $chalky_remaining -= $effective_quantity;
            $chalky_previous_slab_to = $slab->to;

            if ($chalky_remaining <= 0) {
                break;
            }
        }

        foreach ($brokens as $key => $slab) {

            $effective_quantity = $slab->to - $broken_previous_slab_to;

            // If the remaining value is less than the slab range, adjust the effective quantity
            if ($broken_remaining < $effective_quantity) {
                $effective_quantity = $broken_remaining;
            }
            
            $broken_total_amount += ((int)$effective_quantity / 100) * (float)$slab->amount * (int)$inspection->recived_qty;
            $broken_remaining -= $effective_quantity;
            $broken_previous_slab_to = $slab->to;

            if ($broken_remaining <= 0) {
                break;
            }
        }

        foreach ($o_vs as $key => $slab) {

            $effective_quantity = $slab->to - $o_v_previous_slab_to;

            // If the remaining value is less than the slab range, adjust the effective quantity
            if ($o_v_remaining < $effective_quantity) {
                $effective_quantity = $o_v_remaining;
            }
            
            $o_v_total_amount += ((int)$effective_quantity / 100) * (float)$slab->amount * (int)$inspection->recived_qty;
            $o_v_remaining -= $effective_quantity;
            $o_v_previous_slab_to = $slab->to;

            if ($o_v_remaining <= 0) {
                break;
            }
        }

        foreach ($chobbas as $key => $slab) {

            $effective_quantity = $slab->to - $chobba_previous_slab_to;

            // If the remaining value is less than the slab range, adjust the effective quantity
            if ($chobba_remaining < $effective_quantity) {
                $effective_quantity = $chobba_remaining;
            }
            
            $chobba_total_amount += ((int)$effective_quantity / 100) * (float)$slab->amount * (int)$inspection->recived_qty;
            $chobba_remaining -= $effective_quantity;
            $chobba_previous_slab_to = $slab->to;

            if ($chobba_remaining <= 0) {
                break;
            }
        }

        foreach ($looks as $key => $slab) {

            $effective_quantity = $slab->to - $look_previous_slab_to;

            // If the remaining value is less than the slab range, adjust the effective quantity
            if ($look_remaining < $effective_quantity) {
                $effective_quantity = $look_remaining;
            }
            
            $look_total_amount += ((int)$effective_quantity / 100) * (float)$slab->amount * (int)$inspection->recived_qty;
            $look_remaining -= $effective_quantity;
            $look_previous_slab_to = $slab->to;

            if ($look_remaining <= 0) {
                break;
            }
        }

        $data['moisture']   =   DB::connection('mysql2')->table('slabs')->select('amount')->where('product_id',$po->item_id)->where('slab_type_id',1)->where('from','<=',optional($inspection->moisture)->comment)->where('to','>=',optional($inspection->moisture)->comment)->value('amount');
        $data['damage'] =   $damage_total_amount;
        $data['chalky'] =   $chalky_total_amount;
        $data['broken'] =   $broken_total_amount;
        $data['o_v'] =   $o_v_total_amount;
        $data['chobba'] =   $chobba_total_amount;
        $data['look'] =   $look_total_amount;
       
       
        return view('arrival.finalInspection.parameter', $data);

    }


    






    ///////////////////////////////-------------   Second inspection  -------------------////////////////////////////////////


    public function second_inspection(Request $request)
    {

        if($request->ajax()){
            $inspections =  ArrivalInspection::leftJoin('production_purchase_orders','production_purchase_orders.voucher_no','arrival_inspections.po_no')
                ->join('inpection_checklists' , 'inpection_checklists.ins_id' , 'arrival_inspections.id')
                ->leftJoin('customers','customers.id','arrival_inspections.customer_id')
                ->select('arrival_inspections.*','production_purchase_orders.voucher_no','customers.name as customer_name')
//                ->where('inpection_checklists.type' , 2)
                ->where('arrival_inspections.type' , 2)
                ->groupby('arrival_inspections.id')
                ->get();

            return view('arrival.secondinspection.ajaxIndex', compact('inspections'));
        }
        return view('arrival.secondinspection.index');
    }


    public function create_second_inspection(Request $request){
        $str = ArrivalInspection::count();
        $insno = 'SINS-' . sprintf("%'05d", ($str + 1)); // . date('my');
        $data['insno'] = $insno;
        $data['purcahseOrder'] = ProductionPurchaseOrder::join('arrival_inspections' , 'arrival_inspections.po_no' , 'production_purchase_orders.voucher_no')
            ->join('production_get_pass' , 'production_get_pass.inspection_no' , 'arrival_inspections.ins_no')
            ->join('arrival_weighbridges' , 'arrival_weighbridges.gate_pass_no' , 'production_get_pass.gate_pass_no')
            // ->where('production_purchase_orders.inspection_status' , 1)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('arrival_inspections')
                    ->whereRaw('arrival_inspections.po_no = production_purchase_orders.voucher_no')
                    ->join('inpection_checklists', 'inpection_checklists.ins_id', '=', 'arrival_inspections.id')
                    ->whereRaw('inpection_checklists.type = 2');
            })
            ->groupBy('production_purchase_orders.id')
            ->where('arrival_weighbridges.location_id' , '!=' , null)
            ->select('production_purchase_orders.voucher_no','production_purchase_orders.id')->get();
        $data['categories'] = Product::where('table_type', 1)->where('status', 1)->where('parent_id', null)->get();
        $data['printingBags']  = PrintingBags::where('status',1)->get();
        $data['customers']  = Customer::where('status',1)->select('customers.id','customers.name')->get();
        return view('arrival.secondinspection.create', $data);
    }


    public function getProductDescriptionForSecond(Request $request,$id)
    {

        $purcahseOrder = ProductionPurchaseOrder::where('arrival_inspections.ins_no',$id)
            ->join('arrival_inspections' , 'arrival_inspections.po_no' , 'production_purchase_orders.voucher_no')
            ->join('production_get_pass' , 'production_get_pass.inspection_no' , 'arrival_inspections.ins_no')
            ->join('arrival_weighbridges' , 'arrival_weighbridges.inspection_no' , 'arrival_inspections.ins_no')
            ->leftJoin('product','product.id','production_purchase_orders.product_id')
            ->select('product.name' , 'arrival_inspections.*' ,'production_get_pass.gate_pass_no' , 'arrival_weighbridges.weighbridge_no')
            ->first();
//dd($purcahseOrder);
        return $purcahseOrder;

    }


    public function getChecklistSecond(Request $request,$id)
    {
        $purcahseOrder = ProductionPurchaseOrder::where('production_purchase_orders.voucher_no',$request->po_no)
            ->leftJoin('product','product.id','production_purchase_orders.product_id')
//            ->select('product.qc_id')
            ->first();
//        dd($purcahseOrder);
        $inspection=  ArrivalInspection::where('ins_no',$id)->first();
//        $checklistsData = ProductionPurchaseOrder::where('arrival_inspections.ins_no',$id)
//        ->join('arrival_inspections' , 'arrival_inspections.po_id' , 'production_purchase_orders.id')
//        ->join('inpection_checklists' , 'inpection_checklists.ins_id' , 'arrival_inspections.id')
//        ->leftJoin('product','product.id','production_purchase_orders.product_id')
//        ->select('product.qc_id')
//        ->select('product.qc_id','inpection_checklists.comment')
//        // ->where('production_purchase_orders.inspection_status' , 1)
//        ->get();
        // dd($id , $purcahseOrder , $checklistsData);
        if($purcahseOrder && $purcahseOrder->qc_id != null){
            $qcs = QualityChecker::whereIn('id',json_decode($purcahseOrder->qc_id))->select('name','id')->get();

        }else{
            $qcs = array();
        }

        $qcs = QualityChecker::select('name','id')->get();

        return view('arrival.secondinspection.checklists', compact('qcs' ,'id','inspection','purcahseOrder'));

    }





//    public function getChecklist(Request $request)
//    {
//        $purcahseOrder = ProductionPurchaseOrder::where('production_purchase_orders.voucher_no',$request->po)
//            ->leftJoin('product','product.id','production_purchase_orders.product_id')
////             ->select('product.qc_id')
//            ->first();
//
//
//        if($purcahseOrder && $purcahseOrder->qc_id != null){
//            $qcs = QualityChecker::whereIn('id',json_decode($purcahseOrder->qc_id))->select('name','id')->get();
//
//        }else{
//            $qcs = array();
//        }
//
////        $qcs = QualityChecker::select('name','id')->get();
//        return view('arrival.inspection.checklists', compact('qcs','purcahseOrder'));
//
//    }

//     public function store_second_inspection(Request $request)
//     {
//         // Validate the request data
//         $validator = Validator::make($request->all(), [
//             'po_no' => 'required',
//             'date' => 'required|date',
//             'truck_no' => 'required|string|max:20',
//             'product_description' => 'required|string',
//             'customer_id' => 'required',
//             'no_of_bags' => 'required',
//             'pp_bags_id' => 'required',
//             'jute_bags' => 'required',
//             'total_qty' => 'required',
//             'balance_qty' => 'required',
//             'recived_qty' => 'required',
//             'reject_qty' => 'required',
//             'bilty_no' => 'required|string|max:50',
//             'bilty_date' => 'required|date',
//             'consignee_weight' => 'required',
//             'driver_name' => 'required|string|max:100',
//             'transporter_name' => 'required|string|max:100',
//             'checklist_id' => 'required|array',
// //            'checklist_comment' => 'required|array',
//             'second_checklist_comment' => 'required|array',
//             'inspect_by' => 'required',
//             'justification' => 'required',
            
//         ]);


//         if ($validator->fails()) {
//             return response()->json(['errors' => $validator->errors()], 422);
//         }



//         // Begin a transaction
//         DB::beginTransaction();

//         try {
//             $str = ArrivalInspection::count();
//             $insno = 'INS-2-' . sprintf("%'05d", ($str + 1)); // . date('my');

//             $request['type'] = 2;
//             $request['ins_no'] = $insno;
//             $request['created_by'] = auth()->user()->name;
//             $arrivalInspection = ArrivalInspection::create($request->except(['checklist_id','second_checklist_comment']));


//             foreach ($request->checklist_id as $index => $checklistId) {
//                 $comment = isset($request->second_checklist_comment[$index]) ? $request->second_checklist_comment[$index] : null;

//                 InpectionChecklist::create([
//                     'type' => 2, // Assuming the type is 1 for first inspection, change as necessary
//                     'ins_id' => $arrivalInspection->id,
//                     'checker_id' => $checklistId,
//                     'comment' => $comment,
//                 ]);
//             }
//             DB::commit();
//             return response()->json([
//                 'success' => true,
//                 'url' => url('arrival/second_inspection') . '?pageType=&parentCode=234&m=' . session('run_company') . '#Garibsons',
//             ]);

//             Session::flash('dataInsert', "Inspection created successfully");
//             return redirect()->back();
//         } catch (\Exception $e) {
//             // Rollback the transaction if something goes wrong
//             DB::rollBack();
//             return response()->json(['message' => 'Failed to create inspection', 'error' => $e->getMessage()], 500);
//         }
//     }

public function store_second_inspection(Request $request)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'po_no' => 'required',
        'date' => 'required|date',
        'truck_no' => 'required|string|max:20',
        'product_description' => 'required|string',
        'customer_id' => 'required',
        'no_of_bags' => 'required',
        'pp_bags_id' => 'required',
        'jute_bags' => 'required',
        'total_qty' => 'required',
        'balance_qty' => 'required',
        'recived_qty' => 'required',
        'reject_qty' => 'required',
        'bilty_no' => 'required|string|max:50',
        'bilty_date' => 'required|date',
        'consignee_weight' => 'required',
        'driver_name' => 'required|string|max:100',
        'transporter_name' => 'required|string|max:100',
        'checklist_id' => 'required|array',
        'second_checklist_comment' => 'required|array',
        'inspect_by' => 'required',
        'justification' => 'required',
        'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    // If validation fails
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }


    // Begin a transaction
    DB::beginTransaction();

    try {
        // Generate a unique inspection number
        $str = ArrivalInspection::count();
        $insno = 'INS-2-' . sprintf("%'05d", ($str + 1));

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $uniqueId = uniqid();
            $extension = $file->getClientOriginalExtension();
            $filename = $uniqueId . '.' . $extension;
            $folderPath = 'store_second_inspection';

            // Ensure the directory exists
            if (!Storage::disk('public')->exists($folderPath)) {
                Storage::disk('public')->makeDirectory($folderPath);
            }

            // Store the file and get its path
            $filePath = $file->storeAs($folderPath, $filename, 'public');
        }

        // Prepare data for insertion
        $requestData = $request->except(['checklist_id', 'second_checklist_comment']); // Remove arrays from request data
        $requestData['attachment'] = $filePath; // Add file path if uploaded
        $requestData['type'] = 2; // Second inspection
        $requestData['ins_no'] = $insno; // Generated inspection number
        $requestData['created_by'] = auth()->user()->name; // Set the user who created the inspection

        // Insert the inspection data
        $arrivalInspection = ArrivalInspection::create($requestData);

        // Handle the checklist and comments
        foreach ($request->checklist_id as $index => $checklistId) {
            $comment = isset($request->second_checklist_comment[$index]) ? $request->second_checklist_comment[$index] : null;

            InpectionChecklist::create([
                'type' => 2, // Second inspection type
                'ins_id' => $arrivalInspection->id,
                'checker_id' => $checklistId,
                'comment' => $comment,
            ]);
        }

        // Commit the transaction
        DB::commit();

        // Success response
        return response()->json([
            'success' => true,
            'url' => url('arrival/second_inspection') . '?pageType=&parentCode=234&m=' . session('run_company') . '#Garibsons',
        ]);

    } catch (\Exception $e) {
        // Rollback the transaction if something goes wrong
        DB::rollBack();
        return response()->json(['message' => 'Failed to create inspection', 'error' => $e->getMessage()], 500);
    }
}


    public function ViewSecondInspection(Request $request)
    {


        $inspections =  ArrivalInspection::where('arrival_inspections.id',$request->id)
            ->leftJoin('production_purchase_orders','production_purchase_orders.voucher_no','arrival_inspections.po_no')
            ->leftJoin('customers','customers.id','arrival_inspections.customer_id')
            ->select('arrival_inspections.*','production_purchase_orders.voucher_no','customers.name as customer_name')
            ->first();

        $checklists = DB::connection('mysql2')->table('inpection_checklists')
            ->leftJoin(DB::connection('mysql')->getDatabaseName() . '.quality_checkers', 'inpection_checklists.checker_id', '=', 'quality_checkers.id')
            ->where('inpection_checklists.ins_id', $request->id)
            ->select('inpection_checklists.*', 'quality_checkers.*')
            ->get();

        $id =  ArrivalInspection::where('arrival_inspections.ins_no',$inspections->first_ins_no)->value('id');

        $first_checklists = DB::connection('mysql2')->table('inpection_checklists')
            ->leftJoin(DB::connection('mysql')->getDatabaseName() . '.quality_checkers', 'inpection_checklists.checker_id', '=', 'quality_checkers.id')
            ->where('inpection_checklists.ins_id', $id)
            ->select('inpection_checklists.*', 'quality_checkers.*')
            ->get();
        return view('arrival.secondinspection.show', compact('inspections','first_checklists','checklists'));

    }

    public function rejectSecondInspection($id)
    {
        // Find the inspection by ID and update the status to rejected
        $inspection = ArrivalInspection::find($id);
        if ($inspection) {
            $inspection->ins_status = 2; // Assuming 2 is for rejected
            $inspection->save();

            return response()->json(['message' => 'Inspection rejected successfully']);
        } else {
            return response()->json(['message' => 'Inspection not found'], 404);
        }
    }

    public function approveSecondInspection($id)
    {
        // Find the inspection by ID and update the status to approved
        $inspection = ArrivalInspection::find($id);
        if ($inspection) {
            $inspection->ins_status = 1; // Assuming 1 is for approved
            $inspection->save();
            return response()->json(['message' => 'Inspection approved successfully']);
        } else {
            return response()->json(['message' => 'Inspection not found'], 404);
        }
    }

//    public function get_second_insepction(Request $request)
//    {
////        dd($request);
//        $nos = ArrivalInspection::leftJoin('production_purchase_orders', 'production_purchase_orders.voucher_no', '=', 'arrival_inspections.po_no');
//        if($request->type == 1){
//            $nos = $nos->join('production_get_pass','production_get_pass.inspection_no','arrival_inspections.ins_no')
//            ->join('arrival_weighbridges','arrival_weighbridges.inspection_no','arrival_inspections.ins_no');
//        }
//
//
////     ->join('inpection_checklists', 'inpection_checklists.ins_id', '=', 'arrival_inspections.id')
////     ->where('inpection_checklists.type', 1)
//           $nos = $nos->where('arrival_inspections.po_no', $request->po_no)
//            ->where('arrival_inspections.type',  $request->type);
//            if($request->type == 1){
//                $nos = $nos->whereNotIn('arrival_inspections.ins_no', function ($query) {
//                            $query->select('first_ins_no')
//                                ->from('arrival_inspections')
//                                ->whereNotNull('first_ins_no'); // Ensure parent_ins_no is not null
//                        });
//            }
//
//            $nos = $nos->groupBy('arrival_inspections.id')
//            ->get();
//
//        return $nos ?? [];
//    }

    public function get_second_insepction(Request $request)
    {
//        dd($request);
        $nos = ArrivalInspection::leftJoin('production_purchase_orders', 'production_purchase_orders.voucher_no', '=', 'arrival_inspections.po_no')
//     ->join('inpection_checklists', 'inpection_checklists.ins_id', '=', 'arrival_inspections.id')
//     ->where('inpection_checklists.type', 1)
            ->where('arrival_inspections.po_no', $request->po_no);
            if($request->type == '2'){
                $nos = $nos->where('arrival_inspections.type', $request->type);
            }
            
//            ->where('arrival_inspections.type', 1)
            $nos = $nos->whereNotIn('arrival_inspections.ins_no', function ($query) {
                $query->select('first_ins_no')
                    ->from('arrival_inspections')
                    ->whereNotNull('first_ins_no'); // Ensure parent_ins_no is not null
            })
            ->groupBy('arrival_inspections.id')
            ->get();

        return $nos ?? [];
    }
}
