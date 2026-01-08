<?php

namespace App\Http\Controllers;

use App\ArrivalInspection;
use App\ArrivalStock;
use App\ArrivalSupplier;
use App\BillCheck;
use App\BillCheckData;
use App\CompanyLocation;
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
use App\Models\Attachement;
use App\Models\CropBased;
use App\Models\Product;
use App\ProductionGatePassIn;
use App\ProductionPurchaseOrder;
use App\Slab;
use App\SlabType;
use App\SubVarietyParameter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderProductionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getSubVarietyAgainstCategory(Request $request)
    {

        $subcat = Product::where('table_type',1)->where('parent_id',$request->id)->pluck('id')->toArray();
        $variety = Product::where('table_type',2)->whereIn('parent_id',$subcat)->pluck('id')->toArray();
        $subvariety = Product::where('table_type',3)->whereIn('parent_id',$variety)->select('id','name')->get();
        return $subvariety;
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $purchaseOrders = ProductionPurchaseOrder::where('status', 1)->get();
            return view('arrival.purchaseOrder.ajaxIndex', compact('purchaseOrders'));
        }
        return view('arrival.purchaseOrder.index');
    }

    public function create()
    {
        $categories = Product::whereNull('table_type')->whereStatus(1)->get();
        $cropBased = CropBased::where('status', 1)->get();
        $company_locations = ReuseableCode::getUserWiseLocationRights();
        $company_locations = CompanyLocation::whereIn('id', $company_locations)->get()->toArray();
        $types = SlabType::where('status',1)->get();
        $suppliers = ArrivalSupplier::get();
        return view('arrival.purchaseOrder.create', compact('categories','cropBased','company_locations','types','suppliers'));
    }

    public function update_slab(Request $request)
    {

        $request->validate([
            'slabs.*.from' => 'required|numeric',
            'slabs.*.to' => 'required|numeric',
            'slabs.*.deduction' => 'required|numeric',
            'slabs.*.remark' => 'nullable|string',
        ]);

        $product_id = $request->product_id;
        $slab_type_id = $request->slab_type_id;
        
        $delete_slabs = Slab::where([['slab_type_id', $slab_type_id], ['product_id', $product_id]])->get();
        foreach ($delete_slabs as $key => $value) {
           $value->delete();
        }

        // Loop through the slabs array and save each slab
        foreach ($request->slabs as $slabData) {
            Slab::create([
                'product_id' => $request->product_id,
                'slab_type_id' => $request->slab_type_id,
                'from' => $slabData['from'],
                'to' => $slabData['to'],
                'amount' => $slabData['deduction'],
                'remark' => $slabData['remark'] ?? null,
            ]);
        }

        // Return a response indicating success
        return response()->json(['message' => 'Slabs updated successfully!'], 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer',
            'sub_category_id' => 'required|integer',
            'product_id' => 'required|integer',
            'subitem_id' => 'required|integer',
            'item_id' => 'required|integer',
            'voucher_date' => 'required|date',
            'req_date' => 'required|date',
            'promise_date' => 'required|date',
            'location_id' =>  'required|integer',
            'supplier_id' => 'required|integer',
            'agent_id' => 'required|integer',
            'crop_based_id' => 'required|integer',
            'is_replaceable' => 'required|integer',
            'payment_term' => 'required|integer',
            'freight_per_traller' => 'required',
            'delivery_term' => 'required|string|max:255',
            'min_delivery_mode' => 'required|integer',
            'max_qty_truck' => 'required|numeric|min:1',
            'max_qty_traller' => 'required|numeric|min:1',
            'max_qty_bag' => 'required|numeric|min:1',
            'max_qty_katta' => 'required|numeric|min:1',
            'max_qty_kg' => 'required|numeric|min:1',
            'min_qty_truck' => 'required|numeric|min:1',
            'min_qty_traller' => 'required|numeric|min:1',
            'min_qty_bag' => 'required|numeric|min:1',
            'min_qty_katta' => 'required|numeric|min:1',
            'min_qty_kg' => 'required|numeric|min:1',

            'rate_per_kg' => 'required',
            'order_rate' => 'required|numeric|min:0',
            'brokery_term' => 'required|string|max:255',
            'commission_per_bag' => 'required',
            'bardana_per_bag' => 'required',
            'misc_exp_per_bag' => 'required',
            'moisture' => 'required|numeric|min:0|max:100',
            'damage' => 'required|numeric|min:0|max:100',
            'chalky' => 'required|numeric|min:0|max:100',
            'broken' => 'required|numeric|min:0|max:100',
            'o_v' => 'required|numeric|min:0|max:100',
            'look' => 'required|numeric|min:0|max:100',
            'chobba' => 'required|numeric|min:0|max:100',

            'po_amount' => 'required',
            'landed_rate_per_kg' => 'required',
            'remarks' => 'required',

        ],[
            'req_date.required' => 'Start Date is required',
            'promise_date.required' => 'End Date is required',
            'product_id.required' => 'Variety is required',
            'subitem_id.required' => 'Sub Variety is required',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // dd($request->all());

        try {
            DB::beginTransaction();
            // $location = Input::get('location_id');
            // $str = ProductionPurchaseOrder::where('location_id', $location)->orderBy('id', 'desc')->count();
            $name = Product::select('name')->whereId($request->product_id)->first()->name;
            $voucher_no = CommonHelper::getProductionPOVoucherCodeFormat($name);
            // dd($voucher_no[0]); // . date('my');
            // $request['voucher_no'] = strtoupper($voucher_no);
            $amount = str_replace(',','', $request->po_amount);

            $request['username'] = Auth::user()->name;
            $request['po_amount'] = (float)$amount;
            $request['total_amount'] = (float)$amount;
            $request['balance_qty'] = $request->min_qty_kg;
            $request['voucher_no'] = $voucher_no[0];
            $request['max_delivery_mode'] = $request->min_delivery_mode;
            if(isset($request->editedjustification)){
                $request['editedjustification']=$request->editedjustification;
                $request['is_param_edited']=1;
            }
            $purchase = ProductionPurchaseOrder::create($request->except('slab_from','slab_to','slab_deduction','slab_remark','type'));
            // if ($request->hasFile('file')) {
            //     $files = $request->file('file');

            //     foreach ($files as $file) {
            //         // Get the original name, extension, and real path of the file
            //         $originalName = $file->getClientOriginalName();
            //         $extension = $file->getClientOriginalExtension();
            //         $realPath = $file->getRealPath();

            //         // Create a new filename with a timestamp to avoid conflicts
            //         $newFilename = date('dmYHis') . str_replace(" ", "", basename($originalName));

            //         // Move the file to the public uploads directory
            //         $file->move(public_path('uploads/attachment'), $newFilename);

            //         // Create a new attachment record
            //         $attachment = new Attachement();
            //         $attachment->image_src = 'public/uploads/attachment/' . $newFilename; // Adjust path if needed
            //         $attachment->status = 1;

            //         // Associate the attachment with the purchase order
            //         $purchase->attachments()->save($attachment);
            //     }
            // }
            DB::commit();
            return response()->json([
                'success' => true,
                'url' => url('arrival/purchase_order') . '?pageType=&parentCode=232&m=' . session('run_company') . '#Garibsons',
            ]);


            // Session::flash('dataInsert', "Data Successfully Added");
            // return Redirect::to('arrival/purchase_order?pageType=&&parentCode=232&&m='.session('run_company').'#Garibsons');
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    public function getsubcategory($id)
    {
        return Product::where([['status', 1], ['table_type', 1], ['parent_id', $id]])->get()->toArray();
    }

    public function getproduct($id)
    {
        return Product::where([['status', 1], ['table_type', 2], ['parent_id', $id]])->get()->toArray();
    }
    public function getVarietyParams(Request $request)
    {
        return SubVarietyParameter::where('sub_variety_id',$request->id)->whereStatus(1)->first();
    }

    public function get_subitem($id)
    {
        return Product::where([['status', 1], ['table_type', 3], ['parent_id', $id]])->get()->toArray();
    }

    public function get_item($id)
    {
        return Product::where([['status', 1], ['table_type', 4], ['parent_id', $id]])->get()->toArray();
    }

    public function getVoucherNo(Request $request)
    {
        return CommonHelper::getProductionPOVoucherCodeFormat($request->product_id);
    }


    public function purchase_order_update(Request $request, $id)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer',
            'sub_category_id' => 'required|integer',
            'product_id' => 'required|integer',
            'subitem_id' => 'required|integer',
            'item_id' => 'required|integer',
            'voucher_date' => 'required|date',
            'req_date' => 'required|date',
            'promise_date' => 'required|date',
            'location_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'agent_id' => 'required|integer',
            'crop_based_id' => 'required|integer',
            'is_replaceable' => 'required|integer',
            'payment_term' => 'required|integer',
            'freight_per_traller' => 'required',
            'delivery_term' => 'required|string|max:255',
            'min_delivery_mode' => 'required|integer',
            'max_qty_truck' => 'required|numeric|min:1',
            'max_qty_traller' => 'required|numeric|min:1',
            'max_qty_bag' => 'required|numeric|min:1',
            'max_qty_katta' => 'required|numeric|min:1',
            'max_qty_kg' => 'required|numeric|min:1',
            'min_qty_truck' => 'required|numeric|min:1',
            'min_qty_traller' => 'required|numeric|min:1',
            'min_qty_bag' => 'required|numeric|min:1',
            'min_qty_katta' => 'required|numeric|min:1',
            'min_qty_kg' => 'required|numeric|min:1',
            'rate_per_kg' => 'required',
            'order_rate' => 'required|numeric|min:0',
            'brokery_term' => 'required|string|max:255',
            'commission_per_bag' => 'required',
            'bardana_per_bag' => 'required',
            'misc_exp_per_bag' => 'required',
            'moisture' => 'required|numeric|min:0|max:100',
            'damage' => 'required|numeric|min:0|max:100',
            'chalky' => 'required|numeric|min:0|max:100',
            'broken' => 'required|numeric|min:0|max:100',
            'o_v' => 'required|numeric|min:0|max:100',
            'look' => 'required|numeric|min:0|max:100',
            'chobba' => 'required|numeric|min:0|max:100',
            'po_amount' => 'required|numeric|min:0',
            'landed_rate_per_kg' => 'required',
            'remarks' => 'required',
        ], [
            'req_date.required' => 'Start Date is required',
            'promise_date.required' => 'End Date is required',
            'product_id.required' => 'Variety is required',
            'subitem_id.required' => 'Sub Variety is required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            // Find the existing purchase order
            $purchaseOrder = ProductionPurchaseOrder::find($id);

            if (!$purchaseOrder) {
                return response()->json(['error' => 'Purchase Order not found'], 404);
            }

            // Update fields
            $purchaseOrder->username = Auth::user()->name;
            $purchaseOrder->total_amount = $request->po_amount + $request->freight;
            $purchaseOrder->balance_qty = $request->min_qty_kg;
            $purchaseOrder->category_id = $request->category_id;
            $purchaseOrder->sub_category_id = $request->sub_category_id;
            $purchaseOrder->product_id = $request->product_id;
            $purchaseOrder->subitem_id = $request->subitem_id;
            $purchaseOrder->item_id = $request->item_id;
            $purchaseOrder->voucher_date = $request->voucher_date;
            $purchaseOrder->req_date = $request->req_date;
            $purchaseOrder->promise_date = $request->promise_date;
            $purchaseOrder->location_id = $request->location_id;
            $purchaseOrder->supplier_id = $request->supplier_id;
            $purchaseOrder->agent_id = $request->agent_id;
            $purchaseOrder->crop_based_id = $request->crop_based_id;
            $purchaseOrder->is_replaceable = $request->is_replaceable;
            $purchaseOrder->payment_term = $request->payment_term;
            $purchaseOrder->freight_per_traller = $request->freight_per_traller;
            $purchaseOrder->delivery_term = $request->delivery_term;
            $purchaseOrder->max_delivery_mode = $request->min_delivery_mode;
            $purchaseOrder->min_delivery_mode = $request->min_delivery_mode;
            $purchaseOrder->max_qty_truck = $request->max_qty_truck;
            $purchaseOrder->max_qty_traller = $request->max_qty_traller;
            $purchaseOrder->max_qty_bag = $request->max_qty_bag;
            $purchaseOrder->max_qty_katta = $request->max_qty_katta;
            $purchaseOrder->max_qty_kg = $request->max_qty_kg;
            $purchaseOrder->min_qty_truck = $request->min_qty_truck;
            $purchaseOrder->min_qty_traller = $request->min_qty_traller;
            $purchaseOrder->min_qty_bag = $request->min_qty_bag;
            $purchaseOrder->min_qty_katta = $request->min_qty_katta;
            $purchaseOrder->min_qty_kg = $request->min_qty_kg;
            $purchaseOrder->rate_per_kg = $request->rate_per_kg;
            $purchaseOrder->order_rate = $request->order_rate;
            $purchaseOrder->brokery_term = $request->brokery_term;
            $purchaseOrder->commission_per_bag = $request->commission_per_bag;
            $purchaseOrder->bardana_per_bag = $request->bardana_per_bag;
            $purchaseOrder->misc_exp_per_bag = $request->misc_exp_per_bag;
            $purchaseOrder->moisture = $request->moisture;
            $purchaseOrder->damage = $request->damage;
            $purchaseOrder->chalky = $request->chalky;
            $purchaseOrder->broken = $request->broken;
            $purchaseOrder->o_v = $request->o_v;
            $purchaseOrder->look = $request->look;
            $purchaseOrder->chobba = $request->chobba;
            $purchaseOrder->po_amount = $request->po_amount;
            $purchaseOrder->landed_rate_per_kg = $request->landed_rate_per_kg;
            $purchaseOrder->remarks = $request->remarks;

            // Handle edited justification
            if (isset($request->editedjustification)) {
                $purchaseOrder->editedjustification = $request->editedjustification;
                $purchaseOrder->is_param_edited = 1;
            }

            // Save the updated record
            $purchaseOrder->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'url' => url('arrival/purchase_order') . '?pageType=&parentCode=232&m=' . session('run_company') . '#Garibsons',
            ]);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function ViewPurchaseOrder(Request $request)
    {

        $id = $request->id;
        $purchaseOrder = ProductionPurchaseOrder::where('id' , $id)->where('status', 1)->first();
        return view('arrival.purchaseOrder.show' , compact('purchaseOrder'));
    }

    public function edit(Request $request, $id)
    {
        $categories = Product::whereNull('table_type')->whereStatus(1)->get();
        $cropBased = CropBased::where('status', 1)->get();
        $company_locations = ReuseableCode::getUserWiseLocationRights();
        $company_locations = CompanyLocation::whereIn('id', $company_locations)->get()->toArray();

        $purchaseOrder = ProductionPurchaseOrder::where('id' , $id)->where('status', 1)->first();



        if($purchaseOrder){
            $product_id = Product::where('id',$purchaseOrder->product_id)->whereStatus(1)->first();
        }
        if($purchaseOrder){
            $sub_category_id = Product::where('id',$purchaseOrder->sub_category_id)->whereStatus(1)->first();
        }
        if($purchaseOrder){
            $subitem_id = Product::where('id',$purchaseOrder->subitem_id)->whereStatus(1)->first();
        }
        if($purchaseOrder){
            $item_id = Product::where('id',$purchaseOrder->item_id)->whereStatus(1)->first();
        }
        // dd($purchaseOrder->voucher_date);
        $suppliers = ArrivalSupplier::get();

        return view('arrival.purchaseOrder.update' , compact('item_id','subitem_id','sub_category_id','product_id','purchaseOrder','categories','cropBased','company_locations','suppliers'));
    }

    public function update(Request $request,$id)
    {
        // dd($request->all());
        // Define validation rules
        $rules = [
            'category_id' => 'required|integer',
            'sub_category_id' => 'required|integer',
            'crop_based_id' => 'required|integer',
            'voucher_date' => 'required|date',
            'req_date' => 'required|date',
            'promise_date' => 'required|date',
            'supplier_id' => 'required|integer',
            'agent_id' => 'required|integer',
            'delivery_term' => 'required|string|max:255',
            'freight' => 'required|numeric|min:0',
            'product_id' => 'required|integer',
            'delivery_mode' => 'required|integer',
            'qty' => 'required|numeric|min:1',
            'order_rate' => 'required|numeric|min:0',
            'po_amount' => 'required|numeric|min:0',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $request['username'] = Auth::user()->name;
            $request['total_amount'] = $request->po_amount + $request->freight;
            ProductionPurchaseOrder::find($id)->update($request->all());
            DB::commit();
            Session::flash('dataInsert', "Data Successfully Updated");
            return Redirect::to('arrival/purchase_order?pageType=&&parentCode=232&&m='.session('run_company').'#Garibsons');
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    public function delete_po(Request $request)
    {
        $purchase = ProductionPurchaseOrder::find($request->id)->update(['status' => 0]);

        return 'Deleted';
    }


    public function po_bill_check(Request $request)
    {
        $data=[];
        if($request->ajax()){
            $data['billCheck'] = BillCheck::get();
            return view('arrival.billcheck.ajaxIndex' , $data);

        }
        return view('arrival.billcheck.index' , $data);

    }

    public function po_bill_check_view(Request $request)
    {
        $data=[];
        if($request->ajax()){
           $po = BillCheck::where('id',$request->id)->first();
            $data['purcahseOrder'] = ProductionPurchaseOrder::where('voucher_no',$po->po_no)
                ->leftJoin('supplier','supplier.id','production_purchase_orders.supplier_id')
                ->leftJoin('arrival_locations','arrival_locations.id','production_purchase_orders.location_id')
                ->select('production_purchase_orders.*','supplier.name as SupplierName','arrival_locations.name as ArrivalLocation')
                ->first();
            $data['billcheck'] = BillCheckData::where('billcheck_parent_id',$request->id)
                ->get();
            $data['billcheck_totals'] = BillCheckData::where('billcheck_parent_id', $request->id)
                ->select(
                    DB::raw('SUM(bill_amount) as total_bill_amount'),
                    DB::raw('SUM(cost_amount) as cost_amount'),
                    DB::raw('SUM(bardana) as bardana'),
                    DB::raw('SUM(received_bags) as received_bags'),
                    DB::raw('SUM(freight) as freight'),
                    DB::raw('SUM(commission) as total_commission'),
                    DB::raw('SUM(discount) as total_discount'),
                    DB::raw('SUM(moisture) as moisture')
                )
                ->first();

            return view('arrival.billcheck.show' , $data);

        }
        return view('arrival.billcheck.index' , $data);

    }

    public function po_bill_check_create(Request $request)
    {


        if($request->ajax()){
            if($request->po_no == null){
                return ;
            }
            $data['purcahseOrder'] = ProductionPurchaseOrder::where('voucher_no',$request->po_no)
                ->leftJoin('supplier','supplier.id','production_purchase_orders.supplier_id')
                ->leftJoin('arrival_locations','arrival_locations.id','production_purchase_orders.location_id')
                ->select('production_purchase_orders.*','supplier.name as SupplierName','arrival_locations.name as ArrivalLocation')
                ->first();
          $bC = BillCheck::where('po_no',$request->po_no)->leftJoin('bill_check_datas','bill_check_datas.billcheck_parent_id','bill_checks.id')
            ->select('bill_check_datas.final_ins_no')->pluck('bill_check_datas.final_ins_no')->toArray();
            $data['finalInspection'] = ArrivalInspection::where('po_no',$request->po_no)
                ->where('type',3)
                ->whereNotIn('ins_no', $bC)
                ->get();


            return view('arrival.billcheck.getPoDataForBillCheck' , $data);

        }






        $data['purcahseOrder'] = ProductionPurchaseOrder::select(
            'production_purchase_orders.voucher_no',
            'production_purchase_orders.id',
        )
            ->join('arrival_inspections', 'arrival_inspections.po_no', '=', 'production_purchase_orders.voucher_no')
            ->where('arrival_inspections.type', 3)
            ->groupBy('production_purchase_orders.id')
            ->get();

        return view('arrival.billcheck.create' , $data);

    }


    public function po_bill_check_store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'truck_no' => 'required',
            'received_bags' => 'required',
            'moisture' => 'nullable',
            'received_kg' => 'required',
            'rate_per_kg' => 'required',
            'cost_amount' => 'required',
            'freight' => 'required',
            'commission' => 'required',
            'bardana' => 'required',
            'broken' => 'nullable',
            'damage' => 'nullable',
            'chobba' => 'nullable',
            'chalky' => 'nullable',
            'o_v' => 'nullable',
            'look' => 'nullable',
            'discount' => 'required',
            'bill_amount' => 'required',
            'bill_no.*' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            // Step 2: Autogenerate the bill number
            $lastBillCheckParent = BillCheck::orderBy('id', 'desc')->first();
            if ($lastBillCheckParent) {
                // Extract the numeric part from the last bill_no (assuming format BC-00001)
                $lastBillNumber = (int) str_replace('BC-', '', $lastBillCheckParent->bill_no);
                $newBillNumber = 'BC-' . str_pad($lastBillNumber + 1, 5, '0', STR_PAD_LEFT); // Example: BC-00002
            } else {
                // If no previous record exists, start with BC-00001
                $newBillNumber = 'BC-00001';
            }
            $billcheckParent = BillCheck::create([
                'po_no' => $request->po_no,
                'bill_no' => $newBillNumber,
            ]);


            // Loop through each set of data and create a new BillCheck entry
            foreach ($request->date as $index => $date) {
                $bill_data = BillCheckData::create([
                    'billcheck_parent_id' => $billcheckParent->id,  // Foreign key linking to the parent table
                    'final_ins_no' => $request->final_ins_no[$index],
                    'final_ins_id' => $request->final_ins_id[$index],
                    'date' => $date,
                    'truck_no' => $request->truck_no[$index],
                    'received_bags' => $request->received_bags[$index],
                    'moisture' => $request->moisture[$index],
                    'received_kg' => $request->received_kg[$index],
                    'rate_per_kg' => $request->rate_per_kg[$index],
                    'cost_amount' => $request->cost_amount[$index],
                    'freight' => $request->freight[$index],
                    'commission' => $request->commission[$index],
                    'bardana' => $request->bardana[$index],
                    'broken' => $request->broken[$index],
                    'damage' => $request->damage[$index],
                    'chobba' => $request->chobba[$index],
                    'chalky' => $request->chalky[$index],
                    'o_v' => $request->o_v[$index],
                    'look' => $request->look[$index],
                    'discount' => $request->discount[$index],
                    'bill_amount' => $request->bill_amount[$index],
                    'bill_no' => $request->bill_no[$index],
                ]);

                ArrivalStock::where('ins_no',$bill_data->final_ins_no)->update([
                    'avg_rate' => (float)$bill_data->bill_amount / (float)$request->remaining_qty_afterdeduction[$index],
                    'avg_amount' =>   $bill_data->bill_amount,
                ]);


            }

            DB::commit();

            return response()->json([
                'success' => true,
                'url' => url('arrival/po_bill_check') . '?pageType=&parentCode=232&m=' . session('run_company') . '#Garibsons',
            ]);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getLine()], 500);
        }

//        return redirect()->route('your.route.name')->with('success', 'Data saved successfully.');

    }
}
