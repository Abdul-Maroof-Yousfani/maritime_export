<?php

namespace App\Http\Controllers;

use App\QualityChecker;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QualityCheckerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $qualities = QualityChecker::whereStatus('1')->get();
        return view('arrival.qc.index', compact('qualities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('arrival.qc.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
    try {
         
       $QualityChecker = new QualityChecker();
       $QualityChecker->name = $request->name;
       $QualityChecker->status = 1;
       $QualityChecker->date = date('Y-m-d');
       $QualityChecker->time =  date("H:i:s");
       $QualityChecker->save();
        DB::commit();
        return redirect()->back();
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QualityChecker  $qualityChecker
     * @return \Illuminate\Http\Response
     */
    public function show(QualityChecker $qualityChecker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QualityChecker  $qualityChecker
     * @return \Illuminate\Http\Response
     */
    public function edit(QualityChecker $qualityChecker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QualityChecker  $qualityChecker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QualityChecker $qualityChecker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QualityChecker  $qualityChecker
     * @return \Illuminate\Http\Response
     */
    public function destroy(QualityChecker $qualityChecker)
    {
        //
    }
}
