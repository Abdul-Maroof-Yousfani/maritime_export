<?php

namespace App\Http\Controllers;

use App\JobOrder;
use Illuminate\Http\Request;

class JobOrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        if($request->ajax()){
            $weighbridges = JobOrder::get();
            return view('arrival.JobOrder.ajaxIndex', compact('weighbridges'));
        }
        return view('arrival.JobOrder.index');
    }
    
    
    public function create(Request $request)
    {
        return view('arrival.JobOrder.create', compact('po_nos'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $request['weighbridge_no'] = CommonHelper::getProductionFormat(ArrivalWeighbridge::class,'WBR-');
            $request['weighbridge_userid'] = Auth::user()->name;
            $request['username'] = Auth::user()->name;
            ArrivalWeighbridge::create($request->all());
            DB::commit();
            Session::flash('dataInsert', "Data Successfully Added");
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }
    public function Viewweighbridge(Request $request)
    {
        // dd('check');
        $id = $request->id;
        $weightbridge = ArrivalWeighbridge::find($id);
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
}

