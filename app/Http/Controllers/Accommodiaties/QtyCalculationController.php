<?php

namespace App\Http\Controllers\Accommodiaties;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\QtyCalculation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class QtyCalculationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $qtyCalculation = QtyCalculation::first();
        return view('accommodiaties.qtyCalculation.index', compact('qtyCalculation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $qtyCalculation = QtyCalculation::firstOrNew(['id'=> 1]);
        $qtyCalculation->traller = $request->traller??0;
        $qtyCalculation->traller_from = $request->traller_from??0;
        $qtyCalculation->traller_to = $request->traller_to??0;
        $qtyCalculation->truck = $request->truck??0;
        $qtyCalculation->truck_from = $request->truck_from??0;
        $qtyCalculation->truck_to = $request->truck_to??0;
        $qtyCalculation->bag = $request->bag??0;
        $qtyCalculation->bag_from = $request->bag_from??0;
        $qtyCalculation->bag_to = $request->bag_to??0;
        $qtyCalculation->kg = $request->kg??0;
        $qtyCalculation->kg_from = $request->kg_from??0;
        $qtyCalculation->kg_to = $request->kg_to??0;
        $qtyCalculation->katta = $request->katta??0;
        $qtyCalculation->katta_from = $request->katta_from??0;
        $qtyCalculation->katta_to = $request->katta_to??0;
        $qtyCalculation->username = Auth::user()->name;
        $qtyCalculation->save();
        Session::flash('dataInsert', 'Record save successfully..');
        return redirect()->back();
    }

    public function store_import(Request $request)
    {
        $csvFile = $request->file('file');

        if (($handle = fopen($csvFile, 'r')) !== FALSE) {
            // Skip the first row (headers)
            fgetcsv($handle);

            $categoryId = null;
            $subCategoryId = null;
            $varietyId = null;
            $subVarietyId = null;

            // Process CSV rows
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $category = $data[0];
                $subCategory = $data[1];
                $variety = $data[2];
                $type = $data[3];
                $subVariety = $data[4];

                // Insert or update the product records
                if (!empty($category)) {
                    $categoryId = $this->insertProduct($category, null, null, null,null);
                }

                if (!empty($subCategory)) {
                    $subCategoryId = $this->insertProduct($subCategory, $categoryId, 1, null, null);
                }

                if (!empty($variety)) {
                    $type = $type == "White" ? 1 : 2;
                    $varietyId = $this->insertProduct($variety, $subCategoryId, 2, $type,null);
                }

                if (!empty($subVariety)) {
                    $subVarietyId = $this->insertProduct($subVariety, $varietyId, 3, null, null);
                }
            }

            fclose($handle);

            return response()->json(['success' => true, 'message' => 'Products imported successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Failed to import products']);
    }

    // Helper function to insert or update the product
    private function insertProduct($name, $parentId, $tableType, $varietyType, $productType)
    {
        // Check if the product already exists
        $product = Product::where('name', $name)
                          ->where('parent_id', $parentId)
                          ->first();

        if ($product) {
            return $product->id;
        }

        // Create a new product record
        $newProduct = Product::create([
            'name' => $name,
            'parent_id' => $parentId,
            'table_type' => $tableType,
            'variety_type' => $varietyType,
            'product_type' => $productType,
            'status' => 1,
            'username' => 'system',
        ]);

        return $newProduct->id;
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
}
