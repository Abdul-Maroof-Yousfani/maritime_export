<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class PurchaseDeleteController extends Controller
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



    public function approveCompanyPurchaseTwoTableRecords()
    {

        $m = $_GET['m'];
        CommonHelper::companyDatabaseConnection($m);
        $voucherStatus = $_GET['voucherStatus'];
        $rowStatus = $_GET['rowStatus'];
        $columnValue = $_GET['columnValue'];
        $columnOne = $_GET['columnOne'];
        $columnTwo = $_GET['columnTwo'];
        $columnThree = $_GET['columnThree'];
        $tableOne = $_GET['tableOne'];
        $tableTwo = $_GET['tableTwo'];


        $updateDetails = array(
            $columnTwo => 2,
            'approve_username' => Auth::user()->name
        );

        DB::table($tableOne)
            ->where($columnOne, $columnValue)
            ->update($updateDetails);

        DB::table($tableTwo)
            ->where($columnOne, $columnValue)
            ->update($updateDetails);


        CommonHelper::reconnectMasterDatabase();
        Session::flash('dataApprove', 'successfully approve.');
    }

    public function deleteCompanyPurchaseTwoTableRecords()
    {

        $m = $_GET['m'];
        CommonHelper::companyDatabaseConnection($m);
        $voucherStatus = $_GET['voucherStatus'];
        $rowStatus = $_GET['rowStatus'];
        $columnValue = $_GET['columnValue'];
        $columnOne = $_GET['columnOne'];
        $columnTwo = $_GET['columnTwo'];
        $columnThree = $_GET['columnThree'];
        $tableOne = $_GET['tableOne'];
        $tableTwo = $_GET['tableTwo'];


        $updateDetails = array(
            $columnThree => 2,
            'delete_username' => Auth::user()->name
        );

        DB::table($tableOne)
            ->where($columnOne, $columnValue)
            ->update($updateDetails);

        DB::table($tableTwo)
            ->where($columnOne, $columnValue)
            ->update($updateDetails);


        CommonHelper::reconnectMasterDatabase();
        Session::flash('dataDelete', 'successfully delete.');
    }

    public function repostCompanyPurchaseTwoTableRecords()
    {
        $m = $_GET['m'];
        CommonHelper::companyDatabaseConnection($m);
        $voucherStatus = $_GET['voucherStatus'];
        $rowStatus = $_GET['rowStatus'];
        $columnValue = $_GET['columnValue'];
        $columnOne = $_GET['columnOne'];
        $columnTwo = $_GET['columnTwo'];
        $columnThree = $_GET['columnThree'];
        $tableOne = $_GET['tableOne'];
        $tableTwo = $_GET['tableTwo'];


        $updateDetails = array(
            $columnThree => 1,
            'delete_username' => ''
        );

        DB::table($tableOne)
            ->where($columnOne, $columnValue)
            ->update($updateDetails);

        DB::table($tableTwo)
            ->where($columnOne, $columnValue)
            ->update($updateDetails);

        Session::flash('dataRepost', 'successfully repost.');
        CommonHelper::reconnectMasterDatabase();
    }

    public function approveCompanyPurchaseGoodsReceiptNote()
    {
        $m = $_GET['m'];
        CommonHelper::companyDatabaseConnection($m);
        $voucherStatus = $_GET['voucherStatus'];
        $rowStatus = $_GET['rowStatus'];
        $columnValue = $_GET['columnValue'];
        $columnOne = $_GET['columnOne'];
        $columnTwo = $_GET['columnTwo'];
        $columnThree = $_GET['columnThree'];
        $tableOne = $_GET['tableOne'];
        $tableTwo = $_GET['tableTwo'];


        $updateDetails = array(
            $columnTwo => 2,
            'approve_username' => Auth::user()->name
        );

        DB::table($tableOne)
            ->where($columnOne, $columnValue)
            ->update($updateDetails);

        DB::table($tableTwo)
            ->where($columnOne, $columnValue)
            ->update($updateDetails);

        $firstTableRecord = DB::table($tableOne)->where($columnOne, $columnValue)->where('status', '=', '1')->first();
        $secondTableRecord = DB::table($tableTwo)->where($columnOne, $columnValue)->where('status', '=', '1')->get();
        //return print($secondTableRecord);
        foreach ($secondTableRecord as $row) {
            if ($columnOne == 'grn_no') {
                $action = '3';
                $qty = $row->receivedQty;
                $value = $row->subTotal;
                $data['grn_no'] = $row->grn_no;
                $data['grn_date'] = $row->grn_date;
                $data['pr_no'] = $firstTableRecord->pr_no;
                $data['pr_date'] = $firstTableRecord->pr_date;
                $data['supp_id'] = $firstTableRecord->supplier_id;
                $tableThree = 'fara';
            }
            $data['main_ic_id'] = $row->category_id;
            $data['sub_ic_id'] = $row->sub_item_id;
            $data['main_ic_id'] = $row->category_id;
            $data['sub_ic_id'] = $row->sub_item_id;
            $data['demand_type'] = $row->demand_type;
            $data['demand_send_type'] = $row->demand_send_type;
            $data['qty'] = $qty;
            $data['value'] = $value;
            $data['action'] = $action;
            $data['status'] = 1;
            $data['username'] = Auth::user()->name;
            $data['date'] = date("d-m-Y");
            $data['time'] = date("H:i:s");
            $data['company_id'] = $m;
            DB::table($tableThree)->insert($data);
        }

        CommonHelper::reconnectMasterDatabase();
        Session::flash('dataApprove', 'successfully approve.');
    }

    public function deleteSubItemRecord()
    {
        $m = $_GET['companyId'];
        $id = $_GET['id'];

        $checkStock = Stock::where([['sub_item_id', $id], ['qty', '>', 0], ['status', 1]])->count();
        if ($checkStock > 0) {
            Session::flash('dataDelete', "you can't delete those inventory exist.");
            return;
        }

        CommonHelper::companyDatabaseConnection($m);
        $tableName = $_GET['tableName'];

        $updateDetails = array(
            'status' => 0,
            'delete_username' => Auth::user()->name
        );

        DB::table('subitem')
            ->where('status', 1)
            ->where('id', $id)
            ->update($updateDetails);

        CommonHelper::reconnectMasterDatabase();
        Session::flash('dataDelete', 'successfully delete.');
    }

    public function repostSubItemRecord()
    {
        $m = $_GET['companyId'];
        CommonHelper::companyDatabaseConnection($m);
        $id = $_GET['id'];
        $tableName = $_GET['tableName'];
        $accId = $_GET['accId'];

        $updateDetails = array(
            'status' => 1,
            'delete_username' => Auth::user()->name
        );

        DB::table('subitem')
            ->where('status', 2)
            ->where('id', $id)
            ->update($updateDetails);

        DB::table('accounts')
            ->where('id', $accId)
            ->where('status', 2)
            ->update($updateDetails);

        CommonHelper::reconnectMasterDatabase();
        Session::flash('dataRepost', 'successfully repost.');
    }


    public function deleteCategoryRecord()
    {
        $m = $_GET['companyId'];
        CommonHelper::companyDatabaseConnection($m);
        $id = $_GET['id'];
        $tableName = $_GET['tableName'];
        $accId = $_GET['accId'];

        $updateDetails = array(
            'status' => 2,
            'delete_username' => Auth::user()->name
        );

        DB::table('category')
            ->where('status', 1)
            ->where('id', $id)
            ->update($updateDetails);

        DB::table('accounts')
            ->where('id', $accId)
            ->where('status', 1)
            ->update($updateDetails);

        CommonHelper::reconnectMasterDatabase();
        Session::flash('dataDelete', 'successfully delete.');
    }

    public function repostCategoryRecord()
    {
        $m = $_GET['companyId'];
        CommonHelper::companyDatabaseConnection($m);
        $id = $_GET['id'];
        $tableName = $_GET['tableName'];
        $accId = $_GET['accId'];

        $updateDetails = array(
            'status' => 1,
            'delete_username' => Auth::user()->name
        );

        DB::table('category')
            ->where('status', 2)
            ->where('id', $id)
            ->update($updateDetails);

        DB::table('accounts')
            ->where('id', $accId)
            ->where('status', 2)
            ->update($updateDetails);

        CommonHelper::reconnectMasterDatabase();
        Session::flash('dataRepost', 'successfully repost.');
    }

    public function delete_purchase_order(Request $request){
        $m = $request->m;
        $id = $request->id;

        $getPurchaseRequestData = DB::connection('mysql2')->table('purchase_request_data')->where('master_id',$id)->get();
        foreach($getPurchaseRequestData as $row){
            DB::connection('mysql2')->table('quotation_data')->where('id',$row->quotation_data_id)->update(['quotation_status' => 1]);
        }
    }


    public function delete_records(Request $request)
    {
        $id =  Input::get('id');
        $TableType =  Input::get('TableType');
        $Master = '';
        $Detail = '';
        $VoucherNo = '';
        $VoucherDate = '';
        $Amount = '';
        if ($TableType == 1) {
            $Master = 'demand';
            $Detail = 'demand_data';
            $Pr = DB::Connection('mysql2')->table('demand')->where('id', $id)->first();
            $VoucherNo = $Pr->demand_no;
            $VoucherDate = $Pr->demand_date;
            $Amount = 0;
        } elseif ($TableType == 2) {
            $Master = 'purchase_request';
            $Detail = 'purchase_request_data';
            $Po = DB::Connection('mysql2')->selectOne('select SUM(net_amount) net_amount,purchase_request_no,purchase_request_date from purchase_request_data where master_id = ' . $id . '');
            $VoucherNo = $Po->purchase_request_no;
            $VoucherDate = $Po->purchase_request_date;
            $Amount = $Po->net_amount;
        }

        $data['status'] = 0;
        $data['delete_username'] = Auth::user()->name;
        DB::Connection('mysql2')->table($Master)->where('id', $id)->update($data);
        DB::Connection('mysql2')->table($Detail)->where('master_id', $id)->update($data);

        CommonHelper::inventory_activity($VoucherNo, $VoucherDate, $Amount, $TableType, 'Delete');
    }

    public function DeleteAgainForPO()
    {
        $purchase_request_id = Input::get('id');

        $purchase_request_data = DB::Connection('mysql2')->table('purchase_request_data')->where('master_id', $purchase_request_id)->get();
        foreach ($purchase_request_data as $row) :
            $demand_data_id = $row->demand_data_id;
            $data1['demand_status'] = 2;
            DB::Connection('mysql2')->table('demand_data')->where('id', $demand_data_id)->update($data1);
        endforeach;

        $data['status'] = 0;
        $data['delete_username'] = Auth::user()->name;
        DB::Connection('mysql2')->table('purchase_request')->where('id', $purchase_request_id)->update($data);
        DB::Connection('mysql2')->table('purchase_request_data')->where('master_id', $purchase_request_id)->update($data);
    }

    public function reject_po()
    {

        $purchase_request_id = Input::get('Id');
        $PrNo = Input::get('PrNo');

        $count = DB::Connection('mysql2')->table('purchase_request as a')
            ->join('goods_receipt_note as b', 'a.purchase_request_no', '=', 'b.po_no')
            ->select('b.id')
            ->where('a.id', $purchase_request_id)
            ->where('b.status', 1)
            ->count();

        if ($count > 0) {
            echo "0";
        } else {
            $purchase_request_data = DB::Connection('mysql2')->table('purchase_request_data')->where('master_id', $purchase_request_id)->get();
            foreach ($purchase_request_data as $row) :
                $demand_data_id = $row->demand_data_id;
                $data1['demand_status'] = 2;
                DB::Connection('mysql2')->table('demand_data')->where('id', $demand_data_id)->update($data1);
            endforeach;
            $RejectUpdate['purchase_request_status'] = 4;
            DB::Connection('mysql2')->table('purchase_request')->where('id', $purchase_request_id)->update($RejectUpdate);
            DB::Connection('mysql2')->table('purchase_request_data')->where('master_id', $purchase_request_id)->update($RejectUpdate);
            echo "Rejected";
        }
    }
}
