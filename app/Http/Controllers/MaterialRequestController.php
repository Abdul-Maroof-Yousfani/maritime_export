<?php

namespace App\Http\Controllers;

use App\CompanyLocation;
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
use App\MaterialRequest;
use App\MaterialRequestData;
use App\Models\Department;
use App\Models\Line;
use App\Models\Machinery;
use App\Models\Subitem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class MaterialRequestController extends Controller
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

            $material_requests = MaterialRequest::where('status', true)
                ->where(function($query) use ($locations) {
                    $query->whereIn('company_location_id', $locations)
                          ->orWhereNull('company_location_id');
                })->whereBetween('mr_date', [$request->from_date, $request->to_date]);
                if($request->department_id){
                    $material_requests = $material_requests->where('department_id',$request->department_id);
                }
                $material_requests = $material_requests->latest()->get();
            return view('material_request.ajaxIndex', compact('material_requests'));
        }
        $departments = Department::where([['status', '=', '1'], ])->select('id','department_name')->orderBy('id')->get();
        $company_locations = ReuseableCode::getUserWiseLocationRights();
        $company_locations = CompanyLocation::whereIn('id', $company_locations)->get()->toArray();
        return view('material_request.index', compact('departments','company_locations'));
    }
    
    public function create()
    {
        // $departments = new Department();
        // $departments = $departments::where([['status', '=', '1'], ])->select('id','department_name')->orderBy('id')->get();
        $lines = Line::where('status', 1)->get();
        $machineries = Machinery::where('status', 1)->get();
        $company_locations = ReuseableCode::getUserWiseLocationRights();
        $company_locations = CompanyLocation::whereIn('id', $company_locations)->get()->toArray();
        $department_id = ReuseableCode::getUserWiseDepartmentRights();
        $subDepartmentList = DB::table('sub_department')
                                ->whereIn('id', $department_id)
                                ->select('id','sub_department_name')
                                ->get();
        return view('material_request.create', compact('subDepartmentList','machineries','lines','company_locations'));
    }

    public function get_items(Request $request)
    {
        $query = $request->input('q');
        $sub_item = new Subitem();
        // $sub_item = $sub_item->SetConnection('mysql2');
        $sub_item = $sub_item->where('status', 1);
        
        if ($query) {
            $sub_item = $sub_item->where(function($subQuery) use ($query) {
                $subQuery->where('sub_ic', 'LIKE', '%' . $query . '%')
                         ->orWhere('sku_code', 'LIKE', '%' . $query . '%');
            });
        }
    
    
        $items = $sub_item->select('id', 'sub_ic', 'uom', 'item_code', 'pack_size', 'pack_type', 'sku_code', 'pack_uom')->limit(50)->get();
        $formattedItems = $items->map(function ($item) {
            $pack_size = $item->pack_size ? ' - ' . $item->pack_size : '';
            $stock = CommonHelper::get_stock($item->id);
            $id = $item->sub_ic."%".$item->uomData->uom_name.'%'. $stock.'%'.$item->id.'%'.$item->sku_code;
            return [
                'id' => $id,
                'text' => $item->sku_code . ' - ' . $item->sub_ic . $pack_size,
                'uom' => $item->uomData->uom_name,
                'stock' => $stock
            ];
        });

        return response()->json(['items' => $formattedItems]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $location = Input::get('company_location_id');
            $str = MaterialRequest::where('company_location_id', $location)->orderBy('id', 'desc')->count();
            $mr_no = 'MR-' . CommonHelper::getCompanyLocationPrefix($location) . '-' . sprintf("%'05d", ($str + 1)); // . date('my');
            $request['mr_no'] = strtoupper($mr_no);
            $request['requested_by'] = Auth::user()->name;
            $excludedFields = ['item', 'uom','material_code', 'qty_requested','stock_qty','warehouse_id','material_description','m','parentCode'];
            $data = $request->except($excludedFields);
            
            $MaterialRequest = MaterialRequest::create($data);

            foreach ($request->item ?? [] as $key => $value) {
                if($value != '' && $request->qty_requested[$key] != ''){
                    $item = explode('%',$value);
                    MaterialRequestData::create([
                        'material_request_id' => $MaterialRequest->id,
                        'item' => $item[0],
                        'item_id' => $item[3],
                        'uom' => $request->uom[$key],
                        'material_code' => $request->material_code[$key],
                        'warehouse_id' => $request->warehouse_id[$key] ?? '',
                        'qty_requested' => $request->qty_requested[$key],
                        'stock_qty' => $request->stock_qty[$key],
                        'material_description' => $request->material_description[$key],
        
                    ]);
                }else{
                    DB::rollback();
                    Session::flash('dataInsert', "Data Not Inserted");
                    return redirect()->back();
                }
            }
            DB::commit();
            Session::flash('dataInsert', "Data Successfully Added");
            return Redirect::to('purchase/material_request?pageType='.'&&parentCode='.Input::get('parentCode').'&&m='.Input::get('m').'#Garibsons');
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    public function ViewMaterialRequest(Request $request)
    {
        
        $id = $request->id;
        $material_request = MaterialRequest::where('id' , $id)->where('status', 1)->first();
        return view('material_request.show' , compact('material_request'));
    }  

    public function editMaterialForm(Request $request)
    {
        
        $id = $request->id;
        $GatePassReturnable = MaterialRequest::where('id' , $id)->where('status', 1)->first();
        return view('material_request.edit' , compact('GatePassReturnable'));
    }  

    public function update(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $excludedFields = ['item', 'uom', 'qty','line_no','line_description'];
            $data = $request->except($excludedFields);
            
            $gatePassReturnable = MaterialRequest::find($request->id)->update($data);
            MaterialRequestData::where('gate_pass_returnables_id',$request->id)->delete();
            foreach ($request->item ?? [] as $key => $value) {
                if($value != ''){
                    MaterialRequestData::create([
                        'gate_pass_returnables_id' => $request->id,
                        'item' => $value,
                        'uom' => $request->uom[$key],
                        'qty' => $request->qty[$key],
                        'stock_qty' => $request->stock_qty[$key],
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

    public function delete_material_request(Request $request)
    {
        $MaterialRequest = MaterialRequest::find($request->id)->update(['status' => 0]);
        $MaterialRequestData = MaterialRequestData::where('material_request_id',$request->id)->update(['status' => 0]);
        
        return 'Deleted';
    }
}
