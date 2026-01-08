<?php

namespace App\Http\Controllers;
//namespace App\Http\Controllers\Auth
//use Auth;
//use App\User;
use App\Http\Requests;
use App\Helpers\CommonHelper;
use Illuminate\Http\Request;
use DB;
use Config;
use Redirect;
use Session;

class DeleteMasterTableRecordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteMasterTableReceord()
    {
		$id = $_GET['id'];
        $value = $_GET['value'];
        $tableName = $_GET['tableName'];
        DB::update('update '.$tableName.' set status = ? where id = ?',['2',$id]);
        Session::flash('dataDelete','successfully delete.');
    }

   
}
