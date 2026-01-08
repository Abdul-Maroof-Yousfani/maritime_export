<?php

namespace App\Http\Controllers;

use App\ArrivalLocation;
use App\ConversionMaster;
use App\Models\Line;
use App\Models\Product;
use App\Models\Supplier;
use App\User;
use Illuminate\Http\Request;

class ConversionMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        $lines = Line::where('status', 1)->get();
        $users = User::get();
        $raw_m = Product::whereTableType(3)->get();
        $locations = ArrivalLocation::where('parent_id','!=',null)->get();
        return view('arrival.conversions.create' ,compact('lines','users','raw_m','locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConversionMaster  $conversionMaster
     * @return \Illuminate\Http\Response
     */
    public function show(ConversionMaster $conversionMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ConversionMaster  $conversionMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(ConversionMaster $conversionMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ConversionMaster  $conversionMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConversionMaster $conversionMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConversionMaster  $conversionMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConversionMaster $conversionMaster)
    {
        //
    }
}
