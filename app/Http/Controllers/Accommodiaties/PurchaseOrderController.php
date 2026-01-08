<?php

namespace App\Http\Controllers\Accommodiaties;

use App\Helpers\CommonHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommodityPurchaseOrder;
use App\Models\CropBased;
use App\Models\Product;
use App\Slab;
use App\SlabType;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $purchaseOrders = CommodityPurchaseOrder::where('status', 1)->get();
            return view('accommodiaties.purchaseOrder.ajaxIndex', compact('purchaseOrders'));
        }
        return view('accommodiaties.purchaseOrder.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Product::where('table_type', 1)->where('status', 1)->get();
        $cropBased = CropBased::where('status', 1)->get();
        return view('accommodiaties.purchaseOrder.create', compact('categories','cropBased'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $request['voucher_no'] = $this->getVoucherNo($request)[1];
            CommodityPurchaseOrder::create($request->all());
            DB::commit();
            Session::flash('dataInsert', "Data Successfully Added");
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getProduct($id)
    {
        return Product::where([['status', 1], ['table_type', 2], ['parent_id', $id]])->get()->toArray();
    }

    public function getVoucherNo(Request $request)
    {
        $purchaseOrder = CommodityPurchaseOrder::where([['product_id', $request->product_id], ['crop_based_id', $request->crop_based_id], ['status', 1]])->orderBy('id','desc')->first()->voucher_no??0;
        $purchaseOrder = (int)$purchaseOrder + 1;
        return CommonHelper::getCommodityPOVoucherCodeFormat($purchaseOrder);
    }

    public function getProductSlabsDetail(Request $request)
    {
        $product_id = $request->product_id;
        $slab_type_id = $request->id;
        $slab_name = $request->slab_name;
        
        $slabs = Slab::select('*')->where([['slab_type_id', $slab_type_id], ['product_id', $product_id]])->get();
        return view('accommodiaties.purchaseOrder.getProductSlabsDetail', compact('slabs','slab_name'));
    }
}
