<?php

namespace App\Http\Controllers\Accommodiaties;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\UOM;
use App\QualityChecker;
use App\SlabType;
use App\Slab;
use App\SubVarietyParameter;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Product::where('table_type', 1)->where('status', 1)->get();
        if ($request->ajax()) {
            $category_id = $request->category_id;
            $products = Product::with('category')->where('table_type', 2)->where('status', 1)
            ->when($category_id, function($query) use($category_id){
                $query->where('parent_id', $category_id);
            })
            ->get()->toArray();
            return view('accommodiaties.product.ajaxIndex', compact('products'));
        }
        return view('accommodiaties.product.index', compact('categories'));
    }

    public function createCategoryView()
    {

        return view('accommodiaties.category.create');
    }

// app/Http/Controllers/YourController.php

public function ListCategoryedit($id)
{
    // Fetch the product category by ID
    $category = Product::whereNull('table_type')->whereStatus(1)->findOrFail($id);

   
    return view('accommodiaties.category.edit', compact('category'));
}
public function ListCategoryupdate(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);


    $category = Product::findOrFail($id);


    $category->name = $request->input('name');
    $category->status = 1; 
    $category->date = date('Y-m-d'); 
    $category->username = Auth::user()->username; 

    
    $category->save();

  
    return redirect()->route('product.ListCategoryView')->with('success', 'Category updated successfully.');
}



    public function ListCategoryView()
    {
        $categories = Product::whereNull('table_type')->whereStatus(1)->get();
        return view('accommodiaties.category.list_category', compact('categories'));
    }

    public function createSubCategoryView()
    {
        $categories = Product::whereNull('table_type')->whereStatus(1)->get();
        return view('accommodiaties.category.subcatcreate', compact('categories'));
    }

    public function ListSubCategoryView()
    {
        $subcategories = Product::where('table_type',1)->whereStatus(1)->get();
        return view('accommodiaties.category.list_subcategory', compact('subcategories'));
    }
    public function Listsubcategoryedit($id)
    {
       
        $subcatelist = Product::whereNull('table_type')->whereStatus(1)->get();
        $subcategories = Product::whereStatus(1)->findOrFail($id);
       
    
        return view('accommodiaties.category.subcateEdit', compact('subcategories', 'subcatelist'));
    }
    public function Listsubcategoryupdate(Request $request,$id)
    {
            
        $category = Product::findOrFail($id);
        $category->name = $request->input('name');
        $category->parent_id = $request->input('parent_id');
        $category->status = 1; 
        $category->date = date('Y-m-d'); 
        $category->username = Auth::user()->username; 
        $category->save();
            
        
        return redirect()->route('product.ListSubCategoryView')->with('success', 'SubCategory updated successfully.');
    
    }
    

    public function createProductView()
    {
        $products_drop = Product::where([['table_type', 2], ['status', 1]])->get();
        return view('accommodiaties.category.product_create', compact('products_drop'));
    }

    public function ListProductView()
    {
        $products = Product::where('table_type', 3)->whereStatus(1)->get();
        return view('accommodiaties.category.product_list', compact('products'));
    }
    public function subvarietyedit($id)
    {
        $products = Product::where([['table_type', 3], ['status', 1]])->findOrFail($id);

        $products_drop = Product::where([['table_type', 2], ['status', 1]])->get();

        
        return view('accommodiaties.category.product_update', compact('products','products_drop'));
    }
    public function ListSubVarietyupdate(Request $request,$id)
    {
       
        $category = Product::findOrFail($id);
        $category->name = $request->input('name');
        $category->parent_id = $request->input('parent_id');
        $category->status = 1; 
        $category->date = date('Y-m-d'); 
        $category->username = Auth::user()->username; 
        $category->save();
            
        
        return redirect()->route('product.ListProductView')->with('success', 'Sub variety updated successfully.');
    }

    public function createItemView()
    {
        $products_drop = Product::where([['table_type', 3], ['status', 1]])->get();
        return view('accommodiaties.category.item_create', compact('products_drop'));
    }

    // public function ListItemView()
    // {
    //     $products = Product::where('table_type', 4)->whereStatus(1)->get();
    //     return view('accommodiaties.category.item_list', compact('products'));
    // }

    public function ListItemView()
{
    $products = Product::with('sub_item')->where('table_type', 4)->whereStatus(1)->get();

    foreach ($products as $product) {
    
        $sub_item = $product->sub_item;

        if ($sub_item) {
            $variety = DB::connection('mysql2')->table('product')
                ->where('id', $sub_item->parent_id)
                ->where('table_type', 2)
                ->first();

            if ($variety) {
                $sub_category = DB::connection('mysql2')->table('product')
                    ->where('id', $variety->parent_id)
                    ->where('table_type', 1)
                    ->first();

                    if ($sub_category) {
                        $category = DB::connection('mysql2')->table('product')
                            ->where('id', $sub_category->parent_id)
                            ->whereNull('table_type') 
                            ->first();
                    }
            }

        
            $product->category = $category->name ?? '-';
            $product->sub_category = $sub_category->name ?? '-';
            $product->variety = $variety->name ?? '-';
        } else {
            $product->category = '-';
            $product->sub_category = '-';
            $product->variety = '-';
        }
    }

    return view('accommodiaties.category.item_list', compact('products'));
}

    public function ListItemedit($id)
    {



       
        $products = Product::where([['table_type', 4], ['status', 1]])->findOrFail($id);
        $SubVarietyParameter = SubVarietyParameter::where([['sub_variety_id', $id], ['status', 1]])->first();

        
        $products_drop = Product::where([['table_type', 3], ['status', 1]])->get();
       
      
        return view('accommodiaties.category.item_edit', compact('products','products_drop','SubVarietyParameter'));
    }
    
    public function importDataslab(Request $request)
    {
        // Set the status of all slabs to 0 before creating new ones (if needed)
        // Slab::query()->update(['status' => 0]);
    
        // Fetch all products with table_type = 4 and status = 1
        $products = Product::where([['table_type', 4], ['status', 1]])->get();
    
        // Fetch all active slabs (the slabs that act as templates)
        $slabs = Slab::where('status', 1)->get();
    
        // Check if there are any products and slabs
        if ($products->isNotEmpty() && $slabs->isNotEmpty()) {
            // Loop through each product
            foreach ($products as $product) {
                // Loop through each slab template
                foreach ($slabs as $slabTemplate) {
                    // Create a new slab entry for each product, using the slab template data
                    if($product->id != 82){
                    Slab::create([
                        'slab_type_id' => $slabTemplate->slab_type_id, // Slab type from the template
                        'product_id' => $product->id, // Product from the database
                        'from' => $slabTemplate->from, // From value from the template
                        'to' => $slabTemplate->to, // To value from the template
                        'amount' => $slabTemplate->amount, // Amount from the template
                        'remark' => $slabTemplate->remark, // Remark from the template
                        'status' => 1,
                        'date' => now()->toDateString(), // Current date
                        'username' => Auth::user()->name, // Authenticated user's name
                    ]);
                }
                }
            }
    
            // Flash success message
            Session::flash('dataInsert', 'Data Inserted successfully.');
    
            // Redirect back
            return redirect()->back();
        }
    
        // Flash error message if products or slabs are missing
        Session::flash('error', 'No products or slabs found.');
        return redirect()->back();
    }
    


    public function importDataItem(Request $request)
    {
      
        Product::where([['table_type', 4]])->update(['status' => 0]);


        $products_get = Product::where([['table_type', 3], ['status', 1]])->get();


      
        $item_names = ['RAW (22-23)', 'RAW (23-24)', 'RAW (24-25)'];
        
      
        if ($products_get->isNotEmpty()) {
            DB::beginTransaction(); 
    
            try {
                foreach ($products_get as $product) {
                    foreach ($item_names as $item) {
    
                     
                        $pro = Product::create([
                            'name' => $item,
                            'parent_id' => $product->id,
                            'table_type' => 4,
                            'status' => 1,
                            'date' => now()->toDateString(),
                            'username' => Auth::user()->username,
                        ]);
    
                    
                        SubVarietyParameter::create([
                            'sub_variety_id' => $pro->id,
                            'moisture' => 0,
                            'damage' => 0,
                            'chalky' => 0,
                            'broken' => 0,
                            'o_v' => 0,
                            'look' => 0,
                            'chobba' => 0,
                            'user_name' => Auth::user()->username,
                        ]);
                    }
                }
    
                DB::commit(); 
    
               
                return response()->json(['message' => 'Products have been imported successfully!'], 200);
    
            } catch (\Exception $e) {
                DB::rollBack(); 
    
           
                return response()->json(['message' => 'An error occurred during the import process.', 'error' => $e->getMessage()], 500);
            }
    
        } else {
            // Return failure message if no products found
            return response()->json(['message' => 'No products found for importing.'], 404);
        }
    }
    



    public function Listitemupdate(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'required|integer',
            'moisture' => 'nullable|numeric',
            'damage' => 'nullable|numeric',
            'chalky' => 'nullable|numeric',
            'broken' => 'nullable|numeric',
            'o_v' => 'nullable|numeric',
            'look' => 'nullable|string',
            'chobba' => 'nullable|string',
        ]);
    
        // Begin a database transaction
        DB::beginTransaction();
    
        try {
            // Update the Product record
            $category = Product::findOrFail($id);
            $category->name = $request->input('name');
            $category->parent_id = $request->input('parent_id');
            $category->status = 1;
            $category->date = now()->toDateString();
            $category->username = Auth::user()->username;
            $category->save();
    
            // Update the SubVarietyParameter record
            $subVarietyParameter = SubVarietyParameter::where('sub_variety_id', $id)->first();
    
            if ($subVarietyParameter) {
                $subVarietyParameter->moisture = $request->input('moisture');
                $subVarietyParameter->damage = $request->input('damage');
                $subVarietyParameter->chalky = $request->input('chalky');
                $subVarietyParameter->broken = $request->input('broken');
                $subVarietyParameter->o_v = $request->input('o_v');
                $subVarietyParameter->look = $request->input('look');
                $subVarietyParameter->chobba = $request->input('chobba');
                $subVarietyParameter->user_name = Auth::user()->username;
    
                $subVarietyParameter->save();
            } else {
                // Rollback the transaction if SubVarietyParameter is not found
                DB::rollback();
                return redirect()->back()->withErrors('SubVarietyParameter not found.');
            }
    
            // Commit the transaction
            DB::commit();
    
            return redirect()->route('product.ListItemView')->with('success', 'Item updated successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollback();
    
            // Log the error or handle it as needed
            Log::error('Error updating item: ' . $e->getMessage());
    
            return redirect()->back()->withErrors('An error occurred while updating the item.');
        }
    }
    

    public function ListProductEdit($id)
    {
        $products_drop = Product::where([['table_type', 2], ['status', 1]])->get();
        $types = SlabType::where('status',1)->get();
        $product = Product::find($id);
        $selectedParameters = $product->parameters->pluck('parameter_id')->toArray();
        return view('accommodiaties.category.product_edit', compact('products_drop','types','product','selectedParameters'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $uom = UOM::where('status','1')->get();
        $qualities = QualityChecker::where('status','1')->get();
        $categories = Product::where([['table_type', 1], ['status', 1]])->get();
        return view('accommodiaties.product.create', compact('uom', 'categories','qualities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
        if($request->table_type == 1){
            Product::create([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'table_type' => $request->table_type,
                'status' => 1,
                'date' => date('Y-m-d'),
                'username' => Auth::user()->username,
            ]);
        }elseif ($request->table_type == 2) {
            Product::create([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'product_type' => $request->product_type,
                'brand' => $request->brand,
                'sku_code' => $request->sku_code,
                'crop_based' => $request->crop_based,
                'uom_id' => $request->uom_id,
                'table_type' => $request->table_type,
                'type_id' => $request->type_id,
                'packing_type' => $request->packing_type,
                'packing_size' => $request->packing_size,
                'min_stock' => $request->min_stock,
                'max_stock' => $request->max_stock,
                'variety_type' => $request->variety_type,
                'qc_id' => $request->qc_id ? json_encode($request->qc_id) : $request->qc_id,
                'status' => 1,
                'date' => date('Y-m-d'),
                'username' => Auth::user()->username,
            ]);
        }elseif ($request->table_type == 3) {
            $product = Product::create([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'table_type' => $request->table_type,
                'status' => 1,
                'date' => date('Y-m-d'),
                'username' => Auth::user()->username,
            ]);
        }elseif ($request->table_type == 4) {
            $product = Product::create([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'table_type' => $request->table_type,
                'status' => 1,
                'date' => date('Y-m-d'),
                'username' => Auth::user()->username,
            ]);

                SubVarietyParameter::create([
                    'sub_variety_id' => $product->id,
                    'moisture' =>   $request->moisture,
                    'damage' =>   $request->damage,
                    'chalky' =>   $request->chalky,
                    'broken' =>   $request->broken,
                    'o_v' =>   $request->o_v,
                    'look' =>   $request->look,
                    'chobba' =>   $request->chobba,
                    'user_name' => Auth::user()->username,
                ]);
        }elseif ($request->table_type == 5) {
            Product::create([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'sku_code' => $request->sku_code,
                'uom_id' => $request->uom_id,
                'table_type' => $request->table_type,
                'min_stock' => $request->min_stock,
                'max_stock' => $request->max_stock,
                'status' => 1,
                'date' => date('Y-m-d'),
                'username' => Auth::user()->username,
            ]);
        }else {

          
            Product::create([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'status' => 1,
                'date' => date('Y-m-d'),
                'username' => Auth::user()->username,
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
        $uom = UOM::where('status','1')->get();
        $qualities = QualityChecker::where('status','1')->get();
        $categories = Product::where([['table_type', 1], ['status', 1]])->get();
        $product = Product::find($id);
        return view('accommodiaties.product.edit', compact('uom', 'categories','qualities','product'));

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
        Product::find($id)->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'product_type' => $request->product_type,
            'brand' => $request->brand,
            'sku_code' => $request->sku_code,
            'crop_based' => $request->crop_based,
            'uom_id' => $request->uom_id,
            'table_type' => $request->table_type,
            'type_id' => $request->type_id,
            'packing_type' => $request->packing_type,
            'packing_size' => $request->packing_size,
            'min_stock' => $request->min_stock,
            'max_stock' => $request->max_stock,
            'variety_type' => $request->variety_type,
            'qc_id' => $request->qc_id ? json_encode($request->qc_id) : $request->qc_id,
            'status' => 1,
            'date' => date('Y-m-d'),
            'username' => Auth::user()->username,
        ]);

        Session::flash('dataInsert', 'Data update successfully..');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_product(Request $request)
    {
        $Product = Product::find($request->id)->update(['status' => 0]);
        
        return 'Deleted';
    }
    public function delete_Slab(Request $request)
    {
        $Product = Slab::find($request->id)->update(['status' => 0]);
        
        return 'Deleted';
    }

    public function ShowVariety(Request $request)
    {
        $products = Product::where('table_type', 4)->whereStatus(1)->get();
        if ($request->ajax()) {
            $id = $request->subitem_id;
            $product = Product::find($id);
            return view('accommodiaties.category.product_parameterajax', compact('product'));
        }
        return view('accommodiaties.category.product_parameter', compact('products'));
    }

    public function UpdateVariety(Request $request)
    {
        SubVarietyParameter::find($request->id)->update(['status' => 0]);
        SubVarietyParameter::create([
            'sub_variety_id' => $request->id,
            'parameter_id' =>   $request->product_id,
            'user_name' => Auth::user()->username,
        ]);

        return response()->json(['message' => 'Status updated successfully']);
    }

    public function ListProductUpdate(Request $request)
    {  
        $product = Product::find($request->id);
        $product->parent_id =  $request->parent_id;
        $product->name =  $request->name;
        $product->save();

        $product->parameters()->delete();
        foreach ($request->parameter_id ?? [] as $key => $value) {
            SubVarietyParameter::create([
                'sub_variety_id' => $product->id,
                'parameter_id' =>   $value,
                'user_name' => Auth::user()->username,
            ]);
        }
        Session::flash('dataInsert', 'Data Updated successfully..');
        return redirect()->back();
    }

    public function SubmitVariety(Request $request)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'sub_variety_id' => 'required',
            'moisture' => 'required',
            'damage' => 'required',
            'chalky' => 'required',
            'broken' => 'required',
            'o_v' => 'required',
            'look' => 'required',
            'chobba' => 'required',
        ]);



        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        try {
            DB::beginTransaction();
            SubVarietyParameter::where('sub_variety_id',$request->sub_variety_id)->update(['status' => 0]);
            SubVarietyParameter::create([
                'sub_variety_id' => $request->sub_variety_id,
                'moisture' =>   $request->moisture,
                'damage' =>   $request->damage,
                'chalky' =>   $request->chalky,
                'broken' =>   $request->broken,
                'o_v' =>   $request->o_v,
                'look' =>   $request->look,
                'chobba' =>   $request->chobba,
                'user_name' => Auth::user()->username,
            ]);
           
            DB::commit();
            return response()->json([
                'success' => true,
                'url' => url('commodities/ShowVariety') . '?pageType=&parentCode=248&m=' . session('run_company') . '#Garibsons',
            ]);
            
            
            // Session::flash('dataInsert', "Data Successfully Added");
            // return Redirect::to('arrival/purchase_order?pageType=&&parentCode=232&&m='.session('run_company').'#Garibsons');
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
       

    }

    public function createFinishGood()
    {
        $products_drop = Product::where([['table_type', 2], ['status', 1]])->get();
        $uom = UOM::where('status','1')->get();
        return view('accommodiaties.finishgood.create', compact('products_drop','uom'));
    }

    public function ListFinisgGood(Request $request)
    {
        $categories = Product::where('table_type', 2)->where('status', 1)->get();
        if ($request->ajax()) {
            $category_id = $request->category_id;
            $products = Product::with('fg_parent')->where('table_type', 5)->where('status', 1)
            ->when($category_id, function($query) use($category_id){
                $query->where('parent_id', $category_id);
            })
            ->get()->toArray();
            return view('accommodiaties.finishgood.ajaxindex', compact('products'));
        }
        return view('accommodiaties.finishgood.index', compact('categories'));
    }

    public function ListFGedit($id)
    {
        $product = Product::where([['table_type', 5], ['status', 1]])->findOrFail($id);
        $products_drop = Product::where([['table_type', 2], ['status', 1]])->get();
        $uom = UOM::where('status','1')->get();
              
        return view('accommodiaties.finishgood.edit', compact('product','products_drop','uom'));
    }

    public function ListFGupdate(Request $request)
    {
        Product::find($request->id)->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'sku_code' => $request->sku_code,
            'uom_id' => $request->uom_id,
            'table_type' => $request->table_type,
            'min_stock' => $request->min_stock,
            'max_stock' => $request->max_stock,
            'status' => 1,
            'date' => date('Y-m-d'),
            'username' => Auth::user()->username,
        ]);

        Session::flash('dataInsert', 'Data Insert successfully..');
        return redirect()->back();
    }


    

    
}
