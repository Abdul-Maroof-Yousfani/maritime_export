<?php

namespace App\Http\Controllers\Accommodiaties;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Slab;
use App\SlabType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class SlabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $types = SlabType::where('status',1)->get();
        $products = Product::where('table_type',4)->whereStatus(1)->get();
        if ($request->ajax()) {
            $slab_type_id = $request->slab_type_id;
            $product_id = $request->product_id;
            $slabs = Slab::with(['slab_type','product'])->where('status',1)
            ->when($slab_type_id, function($query) use($slab_type_id){
                $query->where('slab_type_id', $slab_type_id);
            })
            ->when($product_id, function($query) use($product_id){
                $query->where('product_id', $product_id);
            })
            ->orderBy('id', 'asc')
            ->get()->toArray();


        

            
            return view('accommodiaties.slabs.ajaxIndex', compact('slabs'));
            
        }

        
        return view('accommodiaties.slabs.index', compact('types', 'products'));
    }
   
    public function createSlabTypeView()
    {
        return view('accommodiaties.slabType.create');
    }
    
    public function addSlabType(Request $request)
    {
        // dd($request->all());
        SlabType::create([
            'name'=> $request->name,
            'username'=> Auth::user()->name,
            'status'=> 1,
            'date'=> date('Y-m-d'),
        ]);
        Session::flash('dataInsert', 'Data Insert successfully..');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = SlabType::where('status',1)->get();
        $product = Product::where('table_type',4)->whereStatus(1)->get();
        return view('accommodiaties.slabs.create', compact('types','product'));
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
        foreach ($request->from as $key => $value) {
            Slab::create([
                'slab_type_id' => $request->slab_type_id,
                'product_id' => $request->product_id,
                'from' => $request->from[$key],
                'to' => $request->to[$key],
                'amount' => $request->amount[$key],
                'remark' => $request->remark[$key],
                'status' => 1,
                'date' => date('Y-m-d'),
                'username' => Auth::user()->name,
            ]);
        }
        Session::flash('dataInsert', 'Data Insert successfully..');
        return redirect()->back();
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
        // Retrieve the slab and its associated data
        $slab = Slab::where('status', 1)->findOrFail($id);
        $types = SlabType::where('status', 1)->get();
        $products = Product::where('table_type', 4)->whereStatus(1)->get();
    
        // Fetch all associated parameters
        $slabParameters = Slab::where('status', 1)->where('id',$id)->get();

                            
                       
    
        return view('accommodiaties.slabs.edit', compact('slab', 'types', 'products', 'slabParameters'));
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
        // Validate the request data
        $request->validate([
            'slab_type_id' => 'required|integer',
            'product_id' => 'required|integer',
            'from' => 'required|array',
            'to' => 'required|array',
            'amount' => 'required|array',
            'remark' => 'nullable|array',
            'id_array' => 'nullable|array', // Ensure id_array is optional
            'id_array.*' => 'integer' // Ensure each item in id_array is an integer
        ]);
    
        // Begin a database transaction
        DB::beginTransaction();
    
        try {
            // Delete existing slabs associated with the IDs provided
            if ($request->has('id_array')) {
                Slab::whereIn('id', $request->id_array)->delete();
            }
    
            // Insert new slabs
            foreach ($request->from as $key => $value) {
                Slab::create([
                    'slab_type_id' => $request->slab_type_id,
                    'product_id' => $request->product_id,
                    'from' => $request->from[$key],
                    'to' => $request->to[$key],
                    'amount' => $request->amount[$key],
                    'remark' => $request->remark[$key] ?? null,
                    'status' => 1,
                    'date' => now()->toDateString(),
                    'username' => Auth::user()->name,
                ]);
            }
    
            // Commit the transaction
            DB::commit();
    
            // Set success message and redirect to the index route
            Session::flash('dataUpdate', 'Data updated successfully.');
            return redirect()->route('slab.index', [
                'pageType' => $request->input('pageType', ''),
                'parentCode' => $request->input('parentCode', 250),
                'm' => $request->input('m', 1)
            ]);
    
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollback();
            Log::error('Error updating slab: ' . $e->getMessage());
            return redirect()->back()->withErrors('An error occurred while updating the slab.');
        }
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
}
