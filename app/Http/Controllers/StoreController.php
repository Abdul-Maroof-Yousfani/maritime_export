<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use App\Helpers\ProductionHelper;
use App\Helpers\ReuseableCode;
use App\MaterialRequest;
use App\MaterialRequestData;
use App\Models\Department;
use App\Models\Category;
use App\Models\Line;
use App\Models\Machinery;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestData;
use App\Models\Subitem;
use App\Models\Issuance;
use App\Models\IssuanceData;
use App\Models\ModeOfTerm;
use App\Models\ModeOfTransport;
use App\Models\IncoTerm;
use App\Models\Bank;
use App\Models\Currency;
use App\Models\GRNData;
use App\Models\Customer;
use App\Models\Demand;
use App\Models\DemandData;
use App\Models\IssuanceReturn;
use App\Models\IssuanceReturnData;
use App\Models\PrintingBags;
use App\Models\StockAdjustment;
use App\Models\StockMovement;
use App\Models\SubDepartment;
use App\Models\Port;
use App\Models\Origin;
use App\Models\Consignee;
use App\Models\Grade;
use App\Models\Size;
use App\Models\Packing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class StoreController extends Controller
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
    public function toDayActivity()
    {
        return view('Store.toDayActivity');
    }

    public  function viewDemandList()
    {
        return view('Store.viewDemandList');
    }
    public  function scReportPage()
    {
        return view('Store.scReportPage');
    }
    public  function getDataScReportAjax(Request $request)
    {
        $FromDate = $request->FromDate;
        $ToDate = $request->ToDate;
        $VoucherType = $request->VoucherType;
        return view('Store.getDataScReportAjax', compact('FromDate', 'ToDate', 'VoucherType'));
    }



    public  function inventoryActivityPage()
    {
        return view('Store.inventoryActivityPage');
    }
    public  function inventoryActivityAjax()
    {
        return view('Store.inventoryActivityAjax');
    }


    public  function stock_transfer_form()
    {
        return view('Store.stock_transfer_form');
    }
    public  function stock_transfer_list()
    {
        return view('Store.stock_transfer_list');
    }

    public  function stock_transfer_report()
    {
        return view('Store.stock_transfer_report');
    }

    public  function itemWiseOpening()
    {
        $OpeningItemWise = DB::Connection('mysql2')->table('stock')->where('opening', 1)->where('status', 1)->where('voucher_type', 1)->where('amount', '>', 0)->where('warehouse_id', '!=', 0)->get();
        return view('Store.itemWiseOpening', compact('OpeningItemWise'));
    }

    public function editStockTransferForm($id, $Trno)
    {

        $Master = DB::Connection('mysql2')->table('stock_transfer')->where('status', 1)->where('id', $id)->first();
        $Detail = DB::Connection('mysql2')->table('stock_transfer_data')->where('status', 1)->where('master_id', $id)->get();
        return view('Store.editStockTransferForm', compact('Master', 'Detail'));
    }

    public  function itemCostClassification()
    {
        $Subitem = new Subitem();
        $Subitem = $Subitem->SetConnection('mysql2');
        $Subitem = $Subitem->where('status', 1)->get();

        $item_cost_classification = DB::Connection('mysql2')->table('item_cost_classification')->get();

        return view('Store.itemCostClassification', compact('Subitem', 'item_cost_classification'));
    }

    public function createStoreChallanForm()
    {
        $departments = new Department;
        $departments = $departments::where([['company_id', '=', $_GET['m']], ['status', '=', '1'],])->orderBy('id')->get();
        return view('Store.createStoreChallanForm', compact('departments'));
    }
    public function createIssuanceReturnForm($id = null)
    {
        // $departments = Department::where([['status', '=', '1'], ])->select('id','department_name')->orderBy('id')->get();
        // $lines = Line::where('status',1)->get();
        // $machineries = Machinery::where('status',1)->get();
        $issuence = Issuance::find($id) ?? [];
        if (!$issuence) {
            $departments = Department::where('status', 1)->get();
            $machineries = Machinery::where('status', 1)->get();
            $lines = Line::where('status', 1)->get();
            return view('Store.createDirectIssuanceReturnForm', compact('issuence', 'departments', 'machineries', 'lines'));
        }
        return view('Store.createIssuanceReturnForm', compact('issuence'));
    }

    public function createIssuanceForm()
    {

        $material_requests = MaterialRequest::where('issuance_status',1)->whereStatus(1)->get();
        return view('Store.createIssuanceForm', compact('material_requests'));
    }

    public function pendingIssuance()
    {

        $material_requests = MaterialRequest::where('issuance_status',1)->whereStatus(1)->get();
        return view('Store.pendingIssuance', compact('material_requests'));
    }

    public function GetIssuanceForm(Request $request)
    {
        $material_request = MaterialRequest::find($request->id);
        $material_request_data = MaterialRequestData::where('material_request_id',$request->id)->get();
        $departments = Department::where([['status', '=', '1'],])->select('id', 'department_name')->orderBy('id')->get();
        $lines = Line::where('status', 1)->get();
        $machineries = Machinery::where('status', 1)->get();

        
        return view('Store.GetIssuanceForm', compact('machineries', 'lines', 'departments','material_request','material_request_data'));
    }
    public function editIssuanceForm(Request $request)
    {
        $Issuance =  Issuance::find($request->id);
        $IssuanceData = IssuanceData::where(['status' => '1', 'master_id' => $request->id])->get();
        $departments = Department::where([['status', '=', '1'],])->select('id', 'department_name')->orderBy('id')->get();
        $lines = Line::where('status', 1)->get();
        $machineries = Machinery::where('status', 1)->get();

        return view('Store.editIssuanceForm', compact('machineries', 'lines', 'departments', 'Issuance', 'IssuanceData'));
    }

    public function editIssuanceReturnForm(Request $request)
    {
        $IssuanceReturn =  IssuanceReturn::find($request->id);
        $IssuanceReturnData = IssuanceReturnData::where(['status' => '1', 'issuance_return_id' => $IssuanceReturn->id])->get();


        return view('Store.editIssuanceReturnForm', compact( 'IssuanceReturn','IssuanceReturnData'));
    }

    public function editIssuanceReturnFormDetail(Request $request)
    {
        $IssuanceReturn =  IssuanceReturn::find($request->id);


        return view('Store.editIssuanceReturnFormDetail', compact('IssuanceReturn'));
    }

    

    public function issuanceList()
    {
        $departments = Department::where([['status', '=', '1'],])->select('id', 'department_name')->orderBy('id')->get();
        return view('Store.issuanceList', compact('departments'));
    }

    public function issuanceReturnList()
    {
        return view('Store.issuanceReturnList');
    }


    public  function viewStoreChallanList()
    {
        return view('Store.viewStoreChallanList');
    }

    public  function editStoreChallanVoucherForm()
    {
        $departments = new Department;
        $departments = $departments::where([['company_id', '=', $_GET['m']], ['status', '=', '1'],])->orderBy('id')->get();
        return view('Store.AjaxPages.editStoreChallanVoucherForm', compact('departments'));
    }

    public function createPurchaseRequestForm()
    {
        $departments = new Department;
        $departments = $departments::where([['company_id', '=', $_GET['m']], ['status', '=', '1'],])->orderBy('id')->get();
        return view('Store.createPurchaseRequestForm', compact('departments'));
    }



    public  function viewPurchaseRequestList()
    {
        return view('Store.viewPurchaseRequestList');
    }

    public  function editPurchaseRequestVoucherForm($id)
    {
        // for department
        $departments = new Department;
        $departments = $departments::where([['company_id', '=', $_GET['m']], ['status', '=', '1'],])->orderBy('id')->get();

        // for purchase order
        $purchase_order = new PurchaseRequest();
        $purchase_order = $purchase_order->SetConnection('mysql2');
        $purchase_order = $purchase_order->where('id', $id)->first();

        // for purchase order
        $purchase_order_data = new PurchaseRequestData();
        $purchase_order_data = $purchase_order_data->SetConnection('mysql2');
        $purchase_order_data = $purchase_order_data->where('master_id', $id)->get();

        return view('Store.editPurchaseRequestVoucherForm', compact('departments', 'purchase_order', 'purchase_order_data', 'id'));
    }

    public  function editDirectPurchaseRequestVoucherForm($id)
    {
        // for department
        $departments = new Department;
        $departments = $departments::where('status', '=', '1')->select('id', 'department_name')->orderBy('id')->get();

        // for purchase order
        $purchase_order = new PurchaseRequest();
        $purchase_order = $purchase_order->SetConnection('mysql2');
        $purchase_order = $purchase_order->where('id', $id)->first();

        // for purchase order
        $purchase_order_data = new PurchaseRequestData();
        $purchase_order_data = $purchase_order_data->SetConnection('mysql2');
        $purchase_order_data = $purchase_order_data->where('master_id', $id)->get();
        $supplierList = DB::Connection('mysql2')->table('supplier')->where('status', 1)->get();

        return view('Store.editDirectPurchaseRequestVoucherForm', compact('departments', 'purchase_order', 'purchase_order_data', 'supplierList', 'id'));
    }


    public function createPurchaseRequestSaleForm()
    {
        $departments = new Department;
        $departments = $departments::where([['company_id', '=', $_GET['m']], ['status', '=', '1'],])->orderBy('id')->get();
        return view('Store.createPurchaseRequestSaleForm', compact('departments'));
    }

    public  function viewPurchaseRequestSaleList()
    {
        return view('Store.viewPurchaseRequestSaleList');
    }

    public  function editPurchaseRequestSaleVoucherForm()
    {
        $departments = new Department;
        $departments = $departments::where([['company_id', '=', $_GET['m']], ['status', '=', '1'],])->orderBy('id')->get();
        return view('Store.AjaxPages.editPurchaseRequestSaleVoucherForm', compact('departments'));
    }



    public function createStoreChallanReturnForm()
    {
        $departments = new Department;
        $departments = $departments::where([['company_id', '=', $_GET['m']], ['status', '=', '1'],])->orderBy('id')->get();
        return view('Store.createStoreChallanReturnForm', compact('departments'));
    }

    public  function viewStoreChallanReturnList()
    {
        return view('Store.viewStoreChallanReturnList');
    }

    public  function editStoreChallanReturnForm()
    {
        $departments = new Department;
        $departments = $departments::where([['company_id', '=', $_GET['m']], ['status', '=', '1'],])->orderBy('id')->get();
        return view('Store.AjaxPages.editStoreChallanReturnForm', compact('departments'));
    }

    public function viewDateWiseStockInventoryReport()
    {
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $categorys = new Category;
        $categorys = $categorys::where([['company_id', '=', $_GET['m']], ['status', '=', '1'],])->orderBy('id')->get();
        CommonHelper::reconnectMasterDatabase();
        return view('Store.viewDateWiseStockInventoryReport', compact('categorys'));
    }

    public function stockReportView()
    {

        $category = DB::Connection('mysql2')->table('stock as a')
            ->join('subitem as b', 'a.sub_item_id', '=', 'b.id')
            ->join('category as c', 'c.id', '=', 'b.main_ic_id')

            ->select('c.id', 'c.main_ic')
            ->where('a.status', 1)
            ->groupBy('c.id')

            ->get();



        return view('Store.stockReportView', compact('category'));
    }
    public function stockReportBatchWiseView()
    {

        $category = DB::Connection('mysql2')->table('stock as a')
            ->join('subitem as b', 'a.sub_item_id', '=', 'b.id')
            ->join('category as c', 'c.id', '=', 'b.main_ic_id')

            ->select('c.id', 'c.main_ic')
            ->where('a.status', 1)
            ->groupBy('c.id')

            ->get();

        $batch_code = DB::Connection('mysql2')->table('stock as a')
            ->select('a.batch_code')
            ->where('a.status', 1)
            ->groupBy('a.batch_code')
            ->get();

        return view('Store.stockReportBatchWiseView', compact('category', 'batch_code'));
    }


    public function fullstockReportView()
    {
        return view('Store.fullstockReportView');
    }
    public function fullstockReportViewBatch()
    {
        return view('Store.fullstockReportViewBatch');
    }


    public function StockOpeningValuesUpdate()
    {
        $Subitem = new Subitem();
        $Subitem = $Subitem->SetConnection('mysql2');
        $Subitem = $Subitem->where('status', 1)->get();
        return view('Store.StockOpeningValuesUpdate', compact('Subitem'));
    }

    public function stockDetailReport()
    {
        return view('Store.stockDetailReport');
    }

    public function InventoryStockReport()
    {
        return view('Store.InventoryStockReport');
    }
    public function checkPurchasingPage()
    {
        $SubItem = DB::Connection('mysql2')->select('select * from subitem where status = 1');
        return view('Store.checkPurchasingPage', compact('SubItem'));
    }
    public function getCheckPurchasingDataAjax()
    {
        $SubItemId = Input::get('SubItemId');
        $StockData = DB::Connection('mysql2')->select('select * from stock where status = 1 AND sub_item_id = ' . $SubItemId . ' and voucher_type in(1) and transfer = 0 ORDER BY voucher_date asc');
        return view('Store.AjaxPages.getCheckPurchasingDataAjax', compact('StockData'));
    }


    public function rateAndAmountupdate()
    {
        return view('Store.rateAndAmountupdate');
    }

    public function InventoryStockReportAjax()
    {
        $from_date  = $_GET['from_date'];
        $to_date    = $_GET['to_date'];
        //   $stock = DB::Connection('mysql2')->select('SELECT s.*, gd.po_data_id as po_id FROM stock s
        //   INNER JOIN grn_data gd ON gd.grn_no = s.voucher_no
        //  WHERE s.status=1 AND s.voucher_type=1 AND s.voucher_date BETWEEN "'.$from_date.'" AND "'.$to_date.'" ');

        $stock = DB::Connection('mysql2')->select('select b.sub_item_id,a.supplier_id,a.grn_no,a.grn_date,a.type,b.region,b.region_to,b.purchase_recived_qty,b.purchase_recived_qty,b.amount,b.rate
        from goods_receipt_note a
         inner join grn_data b
         ON
         a.id=b.master_id
         where a.grn_date BETWEEN  "' . $from_date . '" and "' . $to_date . '"
         and a.status=1
         and a.grn_status in (2,3)');


        $issuence = DB::Connection('mysql2')->select('select a.iss_no,a.issuance_type,a.iss_date,a.region,b.id,b.rate,b.amount,b.sub_item_id,b.qty,a.description from issuance a
        inner join
        issuance_data b
        ON
        a.id=b.master_id
        where a.iss_date BETWEEN "' . $from_date . '" and "' . $to_date . '"
        and a.status=1
        and a.issuance_status=2
        Order by b.sub_item_id
        ');



        $return = DB::Connection('mysql2')->select('select a.issuance_no as iss_no,a.issuance_type,a.issuance_date as iss_date,a.region,b.subitem as sub_item_id,b.rate,b.amount,b.stock_return_data_id,b.qty,a.description from stock_return a
        inner join
        stock_return_data b
        ON
        a.stock_return_id=b.stock_return_id
        where a.issuance_date BETWEEN "' . $from_date . '" and "' . $to_date . '"
        and a.status=1
        and a.return_status=2');

        return view('Store.AjaxPages.InventoryStockReportAjax', compact('stock', 'from_date', 'to_date', 'issuence', 'return'));
    }

    public function rateAndAmountupdateAjax()
    {
        $from_date  = $_GET['from_date'];
        //$to_date    = $_GET['to_date'];
        $dateArray = explode('-', $from_date);
        $d = cal_days_in_month(CAL_GREGORIAN, $dateArray[1], $dateArray[0]);
        $From = $from_date . '-01';
        $To = $from_date . '-' . $d;
        $to_date = $To;


        //   $stock = DB::Connection('mysql2')->select('SELECT s.*, gd.po_data_id as po_id FROM stock s
        //   INNER JOIN grn_data gd ON gd.grn_no = s.voucher_no
        //  WHERE s.status=1 AND s.voucher_type=1 AND s.voucher_date BETWEEN "'.$from_date.'" AND "'.$to_date.'" ');

        $stock = DB::Connection('mysql2')->select('select b.sub_item_id,a.supplier_id,a.grn_no,a.grn_date,a.type,b.region,b.region_to,b.purchase_recived_qty,b.id,b.rate,b.amount
        ,a.grn_date
        from goods_receipt_note a
         inner join grn_data b
         ON
         a.id=b.master_id
         
         where a.grn_date BETWEEN "' . $From . '" and "' . $To . '"
         and a.status=1
         and a.grn_status in (2,3)');


        $issuence = DB::Connection('mysql2')->select('select a.iss_no,a.issuance_type,a.iss_date,a.region,b.id,b.rate,b.amount,b.sub_item_id,b.qty,a.description,a.iss_date,a.region from issuance a
        inner join
        issuance_data b
        ON
        a.id=b.master_id
        where a.iss_date BETWEEN "' . $From . '" and "' . $To . '"
        and a.status=1
        and a.issuance_status=2
        Order by b.sub_item_id
        ');



        $return = DB::Connection('mysql2')->select('select a.issuance_no as iss_no,a.issuance_type,a.issuance_date as iss_date,a.region,b.subitem as sub_item_id,b.rate,b.amount,b.stock_return_data_id,b.qty,a.description,a.region from stock_return a
        inner join
        stock_return_data b
        ON
        a.stock_return_id=b.stock_return_id
        where a.issuance_date BETWEEN "' . $From . '" and "' . $To . '"
        and a.status=1
        and a.return_status=2');

        return view('Store.AjaxPages.rateAndAmountupdateAjax', compact('stock', 'from_date', 'to_date', 'issuence', 'return'));
    }



    function UpdateRateAmount()
    {
        $Id = Input::get('Id');
        $Rate = Input::get('Rate');
        $Amount = Input::get('Amount');
        $UpdateData['rate'] = $Rate;
        $UpdateData['amount'] = $Amount;
        //Grn Data And Stock update
        DB::connection('mysql2')->table('issuance_data')->where('id', $Id)->update($UpdateData);
        DB::connection('mysql2')->table('stock')->where('master_id', $Id)->where('voucher_type', 2)->update($UpdateData);
    }

    function UpdateRateAmountGrn()
    {
        $Id = Input::get('Id');
        $Rate = Input::get('Rate');
        $Amount = Input::get('Amount');
        $UpdateData['rate'] = $Rate;
        $UpdateData['amount'] = $Amount;
        //Issuance Data And Stock update
        DB::connection('mysql2')->table('grn_data')->where('id', $Id)->update($UpdateData);
        DB::connection('mysql2')->table('stock')->where('master_id', $Id)->where('voucher_type', 1)->update($UpdateData);
    }
    function UpdateRateAmountReturn()
    {
        $Id = Input::get('Id');
        $Rate = Input::get('Rate');
        $Amount = Input::get('Amount');
        $UpdateData['rate'] = $Rate;
        $UpdateData['amount'] = $Amount;
        //Return Stock Data And Stock update
        DB::connection('mysql2')->table('stock_return_data')->where('stock_return_data_id', $Id)->update($UpdateData);
        DB::connection('mysql2')->table('stock')->where('master_id', $Id)->where('voucher_type', 3)->update($UpdateData);
    }

    function stockReportItemWisePage()
    {
        return view('Store.stockReportItemWisePage');
    }


    function stockReportItemWiseAjax(Request $request)
    {
        $from = $request->from;
        $to = $request->to_date;

        $data = DB::Connection('mysql2')->select('SELECT a.qty,a.rate,a.amount,b.sub_ic,b.id,b.id as sub_ic_id from stock a
        INNER JOIN
        subitem b
        ON
        a.sub_item_id=b.id
        where a.status=1
        and qty>0
        

        and a.voucher_date BETWEEN "' . $from . '" and "' . $to . '"  group by a.sub_item_id');
        //        $data=DB::Connection('mysql2')->select('SELECT a.qty,a.rate,a.amount,b.sub_ic,c.region_name from stock
        //        where voucher_date BETWEEN  "2020-07-01" and "2020-07-31" and status=1
        //        group by sub_item_id,sub_item_id');
        return view('Store.AjaxPages.stockReportItemWiseAjax', compact('data'));
    }

    public function item_detaild_supplier_wise(Request $request)
    {
        $item = $request->sub_item_id;

        $data = DB::Connection('mysql2')->table('stock')->where('status', 1)
            ->where('sub_item_id', $item)->where('voucher_type', 1)->where('opening', 0)->get();
        return view('Store.AjaxPages.item_detaild_supplier_wise', compact('data', 'item'));
    }

    public function add_opening(Request $request)
    {

        return view('Store.add_opening');
    }

    public function add_opening_form(Request $request)
    {

        return view('Store.add_opening_form');
    }

    public function stockAdjustList(Request $request)
    {
        if ($request->ajax()) {
            // dd("hello");
            $fromDate = $request->fromDate . " 00:00:01";
            $toDate = $request->toDate . ' 23:59:59';
            $stockAdjusts = StockAdjustment::whereBetween('created_at', [$fromDate, $toDate])->where('status', 1)->get();
            // dd($fromDate);
            return view('Store.stockAdjustListAjax', compact('stockAdjusts'));
        }
        return view('Store.stockAdjustList');
    }

    public function stockAdjustEdit($id)
    {
        $stockAdjust = StockAdjustment::find($id);
        return view('Store.stockAdjustEdit', compact('stockAdjust'));
    }
    public function stockAdjustUodate(Request $request, $id)
    {

        $item_id = explode('%', $request->item_id);
        $item_id = $item_id[0];
        $stockAdjust = StockAdjustment::find($id)->update([
            'item_id' => $item_id,
            'warehouse_id' => $request->warehouse_id,
            'type' => $request->type,
            'qty' => $request->qty,
            'rate' => $request->rate,
            'remarks' => $request->remarks,
            'username' => Auth::user()->name,
        ]);
        Session::flash('dataInsert', "Stock Adjustment Successfully update");
        return redirect('store/stockAdjustList');
    }

    public function stockAdjustDelete($id)
    {
        $stockAdjust = StockAdjustment::find($id)->update(['status' => 0]);
        Session::flash('dataInsert', "Stock Adjustment Successfully Deleted");
        return redirect('store/stockAdjustList');
    }

    public function stockAdjustApprove($id)
    {
        $stockAdjust = StockAdjustment::find($id);

        $data = array(
            'voucher_type' => ($stockAdjust->type) ? 12 : 13,
            'master_id' => $stockAdjust->id,
            'sub_item_id' => $stockAdjust->item_id,
            'batch_code' => 0,
            'voucher_date' => date('Y-m-d'),
            'qty' => $stockAdjust->qty,
            'rate' => $stockAdjust->rate,
            'amount' => $stockAdjust->rate * $stockAdjust->qty,
            'warehouse_id' => $stockAdjust->warehouse_id,
            'created_date' => date('Y-m-d'),
            'username' => Auth::user()->name,
            'status' => 1
        );
        DB::Connection('mysql2')->table('stock')->insertGetId($data);
        $stockAdjust->update([
            'approve_status' => 1,
            'approve_username' => Auth::user()->name
        ]);
        Session::flash('dataInsert', "Stock Adjustment Successfully Approved");
        return redirect('store/stockAdjustList');
    }

    public function average_cost(Request $request)
    {
        $m = $request->m;
        return view('Store.average_cost', compact('m'));
    }

    public function inventory_movement()
    {


        // $SubItem = DB::Connection('mysql2')->select('select a.id,a.sub_ic from subitem a
        //                                   INNER JOIN stock b ON b.sub_item_id = a.id
        //                                   WHERE a.status = 1
        //                                   GROUP BY b.sub_item_id');
        $SubItem = DB::Connection('mysql2')->table('subitem as a')->select('a.id', 'a.sub_ic')->get();

        return view('Store.inventory_movement', compact('SubItem'));
    }

    public function inventory_movement_test()
    {


        $SubItem = DB::Connection('mysql2')->select('select a.id,a.sub_ic from subitem a
                                          INNER JOIN stock b ON b.sub_item_id = a.id
                                          WHERE a.status = 1
                                          GROUP BY b.sub_item_id');

        return view('Store.inventory_movement_test', compact('SubItem'));
    }


    public function stock_movemnet(Request $request)
    {
        ini_set('memory_limit', '-1');
        $ReportType = $request->ReportType;
        $from = $request->from_date;
        $to = $request->to_date;
        $accyeafrom = $request->accyearfrom;
        $ItemId = $request->ItemId;
        $purchase = $request->purchase;
        $sales = $request->sales;

        if ($ItemId == 'all') :

            $data = DB::Connection('mysql2')->table('stock as a')
                ->join('subitem as b', 'a.sub_item_id', '=', 'b.id')
                ->where('a.status', 1)
                ->where('amount', '>', 0)
                ->select('a.*', 'b.sub_ic')
                ->groupby('a.sub_item_id')

                ->get();

        else :
            $data = DB::Connection('mysql2')->table('stock as a')
                ->join('subitem as b', 'a.sub_item_id', '=', 'b.id')
                ->where('a.status', 1)
                ->where('a.sub_item_id', $ItemId)
                ->select('a.*', 'b.sub_ic')
                ->groupby('a.sub_item_id')
                ->get();
        endif;
        if ($ReportType == 1) :
            if ($purchase == 0 && $sales == 0) :

                return view('Store.AjaxPages.stock_movemnet', compact('from', 'to', 'accyeafrom', 'data'));
            elseif ($purchase == 1) :
                return view('Store.AjaxPages.stock_movement_in', compact('from', 'to', 'accyeafrom', 'data'));

            elseif ($sales == 1) :
                return view('Store.AjaxPages.stock_movement_out', compact('from', 'to', 'accyeafrom', 'data'));
            endif;

        else :

            if ($ItemId == 'all') :
                $data = DB::Connection('mysql2')->table('transaction_supply_chain as a')
                    ->join('subitem as b', 'a.item_id', '=', 'b.id')
                    ->where('a.status', 1)
                    ->select('a.*', 'b.sub_ic')
                    ->groupby('a.item_id')
                    ->get();
            else :
                $data = DB::Connection('mysql2')->table('transaction_supply_chain as a')
                    ->join('subitem as b', 'a.item_id', '=', 'b.id')
                    ->where('a.status', 1)
                    ->where('a.item_id', $ItemId)
                    ->select('a.*', 'b.sub_ic')
                    ->groupby('a.item_id')
                    ->get();
            endif;
            return view('Store.AjaxPages.stock_movemnet_finance', compact('from', 'to', 'accyeafrom', 'data'));
        endif;
    }


    public function stock_movemnet_test(Request $request)
    {
        ini_set('memory_limit', '-1');
        $ReportType = $request->ReportType;
        $from = $request->from_date;
        $to = $request->to_date;
        $accyeafrom = $request->accyearfrom;
        $ItemId = $request->ItemId;

        if ($ItemId == 'all') :
            $RecCount = DB::Connection('mysql2')->table('stock as a')
                ->join('subitem as b', 'a.sub_item_id', '=', 'b.id')
                ->where('a.status', 1)
                ->where('a.amount', '>', 0)
                ->select('a.*', 'b.sub_ic')
                ->groupby('a.sub_item_id')->get();

            $RecCount = $RecCount->count();

            $data = DB::Connection('mysql2')->select('select a.*,b.sub_ic from stock a
            INNER JOIN subitem b on b.id = a.sub_item_id
            WHERE a.status = 1
            and a.amount > 0
            group by a.sub_item_id limit 0,1000');


        else :
            $data = DB::Connection('mysql2')->table('stock as a')
                ->join('subitem as b', 'a.sub_item_id', '=', 'b.id')
                ->where('a.status', 1)
                ->where('a.sub_item_id', $ItemId)
                ->select('a.*', 'b.sub_ic')
                ->groupby('a.sub_item_id')->get();

        endif;

        return view('Store.AjaxPages.stock_movemnet_test', compact('from', 'to', 'accyeafrom', 'data', 'RecCount'));
    }
    public function stock_movemnetAjaxMoreData(Request $request)
    {

        $from = $request->from_date;
        $to = $request->to_date;
        $accyeafrom = $request->accyearfrom;
        $RCount = $request->RCount;
        $LmFrom = $request->QCounter;

        $data = DB::Connection('mysql2')->select('select a.*,b.sub_ic from stock a INNER JOIN subitem b on b.id = a.sub_item_id WHERE a.status = 1 and a.amount > 0 group by a.sub_item_id limit ' . $LmFrom . ',1000');

        return view('Store.AjaxPages.stock_movemnetAjaxMoreData', compact('from', 'to', 'accyeafrom', 'data', 'LmFrom'));
    }







    public function issuence_against_product(Request $request)
    {
        $id = $request->id;
        $data = DB::Connection('mysql2')->table('product_creation_data')->where('master_id', $id)->where('status', 1)->get();

        $check = DB::Connection('mysql2')->table('product_creation_data')->where('status', 1)->where('master_id', $id)->where('pi_no', '=', null)->count();

        if ($check == 0) :
            echo 'Access Denied';
            die;
        endif;
        return view('Store.issuence_against_product', compact('data'));
    }

    public function inventory_movement_fi()
    {


        $SubItem = DB::Connection('mysql2')->select('select a.id,a.sub_ic from subitem a
                                          INNER JOIN transaction_supply_chain b
                                          ON b.item_id = a.id
                                          WHERE a.status = 1
                                          GROUP BY b.item_id');

        return view('Store.inventory_movement_fi', compact('SubItem'));
    }

    public function add_internal_consumtion()
    {

        return view('Store.add_internal_consumtion');
    }

    public function internal_consumtion_list()
    {

        return view('Store.internal_consumtion_list');
    }

    public function add_finish(Request $request)
    {
        $data =  $request->item;
        foreach ($data as $row) :
            $item_data = explode(',', $row);
            $dataa['finish_good'] = $item_data[0];
            DB::Connection('mysql2')->table('subitem')->where('id', $item_data[1])->update($dataa);
        endforeach;
    }

    public function add_bom()
    {
        try {
            $data =  DB::Connection('mysql2')->table('bom_data')->get();

            foreach ($data as $row) :

                if ($row->finish_good_id != 'Finish Good') :
                    $finish_good = DB::Connection('mysql2')->table('subitem')->where('item_code', $row->finish_good_id)->first()->id;
                    $data1 = array(
                        'finish_goods' => $finish_good,
                        'description' => $row->finish_good_id,
                        'date' => date('Y-m-d'),
                        'status' => 1,
                        'username' => Auth::user()->name,
                    );

                    $id = DB::Connection('mysql2')->table('production_bom')->insertGetId($data1);


                    $finish_good = DB::Connection('mysql2')->table('subitem')->where('item_code', $row->direct_material)->first()->id;
                    $data2 = array(
                        'master_id' => $id,
                        'item_id' => $finish_good,
                        'qty_mm' => $row->d_qty,
                        'qty_ft' => $row->d_qty / 304.8,
                        'date' => date('Y-m-d'),
                        'status' => 1,
                        'username' => Auth::user()->name,
                    );

                    //  DB::Connection('mysql2')->table('production_bom_data_direct_material')->insertGetId($data2);

                    if ($row->indirect_material != '') :
                        $finish_good = DB::Connection('mysql2')->table('subitem')->where('item_code', $row->indirect_material)->first()->id;
                        $data3 = array(
                            'main_id' => $id,
                            'item_id' => $finish_good,
                            'qty' => $row->in_qty,
                            'status' => 1,
                            'username' => Auth::user()->name,
                        );

                    //   DB::Connection('mysql2')->table('production_bom_data_indirect_material')->insertGetId($data3);
                    endif;
                endif;
            endforeach;
            DB::Connection('mysql2')->commit();
        } catch (\Exception $e) {
            DB::Connection('mysql2')->rollback();
            dd($e->getMessage());
        }
    }


    function add_operation_data()
    {
        try {

            $data =  DB::Connection('mysql2')->table('production_bom')->where('status', 1)->get();

            foreach ($data as $row) :


                $production_work_order = array(
                    'finish_good_id' => $row->finish_goods,
                    'status' => 1,
                    'username' => Auth::user()->name,
                    'date' => date('Y-m-d'),
                );

                $id = DB::Connection('mysql2')->table('production_work_order')->insertGetId($production_work_order);

                $data1 =  DB::Connection('mysql2')->table('production_machine_data')->where('status', 1)->where('finish_good', $row->finish_goods)->get();


                foreach ($data1 as $row1) :

                    $production_work_order_data = array(
                        'master_id' => $id,
                        'machine_id' => $row1->master_id,
                        'capacity' => 70,
                        'labour_category_id' => '',
                        'wait_time' => '00:00:12',
                        'move_time' => '00:00:06',
                        'que_time' => 0,
                        'status' => 1,
                        'date' => date('Y-m-d'),
                        'username' => Auth::user()->name,
                    );
                    DB::Connection('mysql2')->table('production_work_order_data')->insert($production_work_order_data);
                endforeach;

            endforeach;


            DB::Connection('mysql2')->commit();
        } catch (\Exception $e) {
            DB::Connection('mysql2')->rollback();
            dd($e->getMessage());
        }
    }

    public function Create_routing()
    {
        $data = DB::Connection('mysql2')->table('production_work_order')->where('status', 1)->get();



        foreach ($data as $row) :

            $data1 = array(
                'finish_goods' => $row->finish_good_id,
                'voucher_no' => ProductionHelper::get_unique_code_for_routing(),
                'operation_id' => $row->id,
                'status' => 1,
                'username' => Auth::user()->name,
                'date' => date('Y-m-d'),

            );
            $id = DB::Connection('mysql2')->table('production_route')->insertGetId($data1);
            $data2 = DB::Connection('mysql2')->table('production_work_order_data')->where('status', 1)->where('master_id', $row->id)->get();

            $count = 1;
            foreach ($data2 as $row1) :
                $orderby = 0;
                if ($row1->machine_id == 28 || $row1->machine_id == 29) :
                    $orderby = 0;
                else :
                    $orderby = $count++;
                endif;

                $data2 = array(
                    'master_id' => $id,
                    'operation_data_id' => $row1->id,
                    'machine_id' => $row1->machine_id,
                    'orderby' => $orderby,
                    'status' => 1,

                );

                DB::Connection('mysql2')->table('production_route_data')->insert($data2);
            endforeach;
        endforeach;
    }
    public function createMachineryForm()
    {
        return view('machinery.createMachineryForm');
    }
    public function viewMachineryList()
    {
        $data = Machinery::all();
        return view('machinery.viewMachineryList')->with('machinery', $data);
    }

    public function machineryDelete(Request $request)
    {

        $id = $request->id;
        $data['status'] = 0;
        DB::Connection('mysql2')->table('machineries')->where('id', $id)->update($data);
        echo $id;
    }
    public function editMachineryForm(Request $request)
    {
        $id = $request->id;
        $data = Machinery::find($id);
        return view('machinery.editMachineryForm')->with('machinery', $data);
    }

    // Line Start From Here

    public function createLineForm()
    {
        return view('line.createLineForm');
    }
    public function viewLineList()
    {
        $data = Line::all();
        return view('line.viewLineList')->with('machinery', $data);
    }

    public function LineDelete(Request $request)
    {

        $id = $request->id;
        $data['status'] = 0;
        DB::Connection('mysql2')->table('lines')->where('id', $id)->update($data);
        echo $id;
    }
    public function editLineForm(Request $request)
    {
        $id = $request->id;
        $data = Line::find($id);
        return view('line.editLineForm')->with('lines', $data);
    }

    public function saleOrderCreate()
    {
        $incoterms =  IncoTerm::all();
        $modeofterms =  ModeOfTerm::all();
        $modeoftransports =  ModeOfTransport::all();
        $conversions = Currency::where('status', 1)->get();
        $banks = Bank::where('status', 1)->get();
        $customers = Customer::where(['status' => 1, 'purchaser_type' => 2])->get();
        $printingBags = PrintingBags::select('pack_type')->where('status', 1)->groupBy('pack_type')->get();
        $ports = Port::all();
        $origins = Origin::all();
        $consignees = Consignee::all();
        $grades = Grade::all();
        $sizes = Size::all();
        $packings = Packing::all();
        // dd($printingBags);
        return view('Sales.saleOrderCreate', compact('incoterms', 'printingBags', 'modeofterms', 'modeoftransports', 'conversions', 'banks', 'customers', 'ports', 'origins', 'consignees', 'grades', 'sizes', 'packings'));
    }

    public function getCustomerDetails(Request $request)
    {
        $customer = Customer::where('id', $request->id)->first();
        if ($customer) {
            return response()->json([
                'success' => true,
                'address' => $customer->address ?? '',
                'ntn' => $customer->cnic_ntn ?? ''
            ]);
        }
        return response()->json(['success' => false]);
    }

    public function getBankDetails(Request $request)
    {
        $bank = Bank::where('id', $request->id)->first();
        if ($bank) {
            return response()->json([
                'success' => true,
                'bank_name' => $bank->bank_name ?? '',
                'account_title' => $bank->account_title ?? '',
                'account_no' => $bank->account_no ?? '',
                'swift_code' => $bank->swift_code ?? '',
                'iban_no' => $bank->IBAN_no ?? '',
                'bank_address' => $bank->bank_address ?? ''
            ]);
        }
        return response()->json(['success' => false]);
    }

    public function getPackSize(Request $request)
    {
        if($request->type == 2){
            return PrintingBags::where('printing_bags', $request->bagType)->where('status', 1)->get();
        }else{
            return PrintingBags::select('printing_bags')->where('status', 1)->where('pack_type', $request->packType)->groupBy('printing_bags')->get();
        }
    }

    public function inventoryReport()
    {
        $SubItem = DB::Connection('mysql2')->select('select a.id,a.sub_ic from subitem a
            INNER JOIN stock b ON b.sub_item_id = a.id
            WHERE a.status = 1
            GROUP BY b.sub_item_id');

        $departments =  SubDepartment::where('status', 1)->get();
        return view('Reports.Inventory.inventoryReport', compact('SubItem', 'departments'));
    }
    public function inventoryReportAjax(Request $request)
    {
        $viewGrn = $request->view_grn;
        $viewPO = $request->view_PO;
        $viewPO = $request->view_PO;
        $query = DemandData::join('demand', 'demand.id', 'demand_data.master_id')
            ->leftjoin('purchase_request_data', function ($join) {
                $join->on('demand_data.id', '=', 'purchase_request_data.demand_data_id')
                    ->where('purchase_request_data.status', 1);
            })
            ->leftjoin('purchase_request', 'purchase_request.id', 'purchase_request_data.master_id')
            ->leftJoin('supplier', 'supplier.id', 'purchase_request.supplier_id')
            ->join('subitem', 'subitem.id', 'demand_data.sub_item_id')
            ->leftjoin(config('database.connections.mysql.database') . '.sub_department as db', 'db.id', 'demand.sub_department_id');
        if ($viewGrn) {
            $query = $query->leftJoin('grn_data', function ($join) {
                $join->on('purchase_request_data.id', '=', 'grn_data.po_data_id')
                    ->where('grn_data.status', 1)
                    ->where('grn_data.purchase_recived_qty', '>', 0);
            })
                ->leftjoin('new_purchase_voucher_data', 'new_purchase_voucher_data.grn_data_id', 'grn_data.id');
        }
        $query = $query->select(
            'demand.company_location_id',
            'demand.p_type',
            'demand_data.qty as demand_qty',
            'demand_data.demand_date',
            'db.sub_department_name',
            'demand_data.demand_no',
            'subitem.sub_ic',
            'purchase_request_data.description as remarks',
            'purchase_request.sales_tax',
            'purchase_request_data.group_number',
            'subitem.uom',
            'purchase_request_data.purchase_approve_qty',
            'supplier.name',
            'purchase_request_data.rate',
            'purchase_request_data.sub_total',
            'purchase_request_data.discount_amount',
            'purchase_request_data.purchase_request_no',
            'purchase_request_data.purchase_request_date',
            'demand_data.sub_ic_desc as description'
        );
        if ($viewGrn) {
            $query->addSelect(
                'grn_data.grn_no',
                'grn_data.grn_date',
                'new_purchase_voucher_data.pv_no',
                'new_purchase_voucher_data.date as pv_date',
            );
        }
        //   $query =  GRNData::join('purchase_request_data','purchase_request_data.id','grn_data.po_data_id')
        //     ->join('demand_data','demand_data.id','purchase_request_data.demand_data_id')
        //     ->join('demand','demand.id','demand_data.master_id')
        //     ->join('purchase_request','purchase_request.id','purchase_request_data.master_id')
        // ->join('supplier','supplier.id','purchase_request.supplier_id')
        //     ->join('subitem','subitem.id','grn_data.sub_item_id')
        //     ->leftjoin('new_purchase_voucher_data','new_purchase_voucher_data.grn_data_id','grn_data.id')
        //     ->join('inno_garibsons_master.sub_department as db','db.id','purchase_request.sub_department_id')
        if ($request->pr_status) {
            $query->where('demand.demand_status',  $request->pr_status);
        }
        if (!empty($request->pr_no)) {
            $query->where('demand.demand_no', 'LIKE', '%' . $request->pr_no . '%');
        }
        if (!empty($request->purchase_no)) {
            $query->where('purchase_request_data.purchase_request_no', 'LIKE', '%' . $request->purchase_no . '%');
        }
        if (!empty($request->gr_no)) {
            $query->where('grn_data.grn_no', 'LIKE', '%' . $request->gr_no . '%');
        }
        if (!empty($request->item_id)) {
            $query->where('demand_data.sub_item_id', $request->item_id);
        }
        if (!empty($request->company_location_id)) {
            $query->where('demand.company_location_id', $request->company_location_id);
        } else {
            $query->whereIn('demand.company_location_id', ReuseableCode::getUserWiseLocationRights());
        }
        if (!empty($request->department_id)) {
            $query->where('db.id', $request->department_id);
        }

        $data  =   $query->where('demand_data.status', 1)->where('demand.demand_status', '!=', 3)->where('demand_data.cancel_status', 1)
            // ->orWhere('purchase_request.status', 1)
            // ->orWhere('grn_data.status', 1)
            ->orderBy('demand_data.id', 'desc')->get();
        return view('Reports.Inventory.inventoryReportAjax', compact('data', 'viewGrn', 'viewPO'));
    }


    public function itemMovementForm()
    {
        return view('Store.itemMovement.itemMovementForm');
    }

    public function itemMovementList()
    {
        $itemMovements = StockMovement::where('status', 1)->orderBy('id', 'desc')->get();
        return view('Store.itemMovement.itemMovementList', compact('itemMovements'));
    }

    public function deleteItemMovement($id)
    {
        $itemMovement = StockMovement::find($id);
        $itemMovement->update(['status'=> 0]);
        Session::flash('dataDelete', "Record Successfully Delete");
        return redirect()->back();
    }

    public function barcodePrintingForm()
    {
        return view('Store.barcodePrintingForm');
    }


    public function printbarcode(Request $request)
    {
        $subItems = array();
        array_push($subItems, ['sub_ic' => Subitem::find($request->id)->sub_ic, 'sku_code' => Subitem::find($request->id)->sku_code, 'qty' => 1]);
        return view('Store.printbarcode', compact('subItems'));
    }
    public function barcodePrint(Request $request)
    {
        $subItems = array();
        foreach ($request->sub_ic as $key => $value) {
            array_push($subItems, ['sub_ic' => $value, 'sku_code' => $request->sku_code[$key], 'qty' => $request->qty[$key]]);
        }
        return view('Store.printbarcode', compact('subItems'));
    }

    public function printGrnItemBarcode($id)
    {
        $grnData = GRNData::where([['master_id', $id], ['status', 1]])->get();
        $subItems = [];
        foreach ($grnData as $key => $value) {
            if($value->purchase_recived_qty > 0){
                array_push($subItems, ['sub_ic' => Subitem::find($value->sub_item_id)->sub_ic, 'sku_code' => Subitem::find($value->sub_item_id)->sku_code, 'qty' => $value->purchase_recived_qty]);
            }
        }
        return view('Store.printbarcode', compact('subItems'));
    }
}
