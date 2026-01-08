<?php

namespace App\Http\Controllers;

use App\Helpers\ReuseableCode;
use App\Helpers\CommonHelper;
use Illuminate\Http\Request;
use App\Models\DailyTask;
use App\Models\DailyTaskData;
use App\Models\Cluster;
use App\Models\DemandData;
use App\Models\GRNData;
use App\Models\PurchaseRequestData;
use App\Models\SubDepartment;
use App\Models\Subitem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ReportsController extends Controller
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
        return view('Reports.toDayActivity');
    }

    public function viewBankDepositSummary()
    {
        return view('Reports.Finance.BankingReport.viewBankDepositSummary');
    }

    public function viewBranchPerformanceReports()
    {
        return view('Reports.Finance.PerformanceReports.viewBranchPerformanceReports');
    }

    public function viewBranchExpenseSummaryReports()
    {
        return view('Reports.Finance.PerformanceReports.viewBranchExpenseSummaryReports');
    }

    public function viewBranchExpenseSummaryDetailReports()
    {
        return view('Reports.Finance.PerformanceReports.viewBranchExpenseSummaryDetailReports');
    }

    public function viewInventoryPerformanceDetailReports()
    {
        return view('Reports.Inventory.viewInventoryPerformanceDetailReports');
    }

    public function p_detail_report()
    {
        return view('Reports.p_detail_report');
    }

    public function create_daily_activity()
    {
        $Cluster = new Cluster();
        $Cluster = $Cluster->SetConnection('mysql2')->where('status', 1)->get();
        return view('Reports.create_daily_activity', compact('Cluster'));
    }

    public function insertDailyTask(Request $request)
    {
        // print_r($_POST);
        $DailyTask = new DailyTask;
        $DailyTask = $DailyTask->SetConnection('mysql2');
        $DailyTask->task_date = $request->task_date;
        $DailyTask->status    = 1;
        $DailyTask->username  = Auth::user()->name;
        $DailyTask->date      = date('Y-m-d');
        $DailyTask->save();
        $master_id = $DailyTask->id;

        $Rowcount = $request->Rowcount;
        foreach ($Rowcount as $key => $value) {
            $DailyTaskData = new DailyTaskData;
            $DailyTaskData = $DailyTaskData->SetConnection('mysql2');
            $DailyTaskData->client      = $request->input('account_id' . $value);
            $DailyTaskData->description = $request->input('desc' . $value);
            $DailyTaskData->acc_officer = $request->input('acc_officer' . $value);
            $DailyTaskData->vendor      = $request->input('vendor' . $value);
            $DailyTaskData->region      = $request->input('region_id' . $value);
            $DailyTaskData->status      = 1;
            $DailyTaskData->username    = Auth::user()->name;
            $DailyTaskData->date        = date('Y-m-d');
            $DailyTaskData->daily_task_id = $master_id;
            $DailyTaskData->action      = 1;
            $DailyTaskData->save();
        }
        return Redirect::to('reports/daily_activity_list?pageType=add&&parentCode=82&&m=1#SFR');
    }

    public function daily_activity_list()
    {
        $DailyTask = DB::Connection('mysql2')->table('daily_task')->where('status', 1)->get();
        return view('Reports.daily_activity_list', compact('DailyTask'));
    }

    public function get_daily_task(Request $request)
    {
        //print_r($_GET);
        $id = $request->input('id');
        $m = $request->input('m');
        $DailyTask = DB::Connection('mysql2')->table('daily_task')
            ->join('daily_task_data', 'daily_task.id', '=', 'daily_task_data.daily_task_id')
            ->where('daily_task.status', 1)
            ->where('daily_task.id', $id)
            ->select('daily_task.task_date', 'daily_task_data.*')
            ->get();

        return view('Reports.get_daily_task', compact('DailyTask'));
    }

    public function get_remarks(Request $request)
    {
        $id = $request->input('id');
        $m = $request->input('m');
        return view('Reports.get_remarks', compact('id'));
    }

    public function job_Done(Request $request)
    {
        $id = $request->input('id');
        if ($id != "") {
            DB::Connection('mysql2')->table('daily_task_data')
                ->where('id', $id)
                ->update(['action' => 2]);
        }
    }

    public function job_Delay(Request $request)
    {
        $id = $request->input('id');
        if ($id != "") {
            DB::Connection('mysql2')->table('daily_task_data')
                ->where('id', $id)
                ->update(['action' => 4]);
        }
    }

    public function job_Hold(Request $request)
    {
        $id = $request->input('id');
        if ($id != "") {
            DB::Connection('mysql2')->table('daily_task_data')
                ->where('id', $id)
                ->update(['action' => 3]);
        }
    }

    public function edit_daily_activity(Request $request)
    {
        $id = $request->input('id');
        $Cluster = new Cluster();
        $Cluster = $Cluster->SetConnection('mysql2')->where('status', 1)->get();
        $DailyTask = DB::Connection('mysql2')->table('daily_task')->where('status', 1)->where('id', $id)->first();
        $DailyTaskData = DB::Connection('mysql2')->table('daily_task_data')->where('status', 1)->where('daily_task_id', $id)->get();
        return view('Reports.edit_daily_activity', compact('DailyTask', 'DailyTaskData', 'Cluster'));
    }

    public function UpdateRemarks(Request $request)
    {
        //        echo "<pre>";
        //        print_r($_POST);
        //        die;
        $m = $request->input('m');
        $id = $request->input('id');
        $remarks = $request->input('remarks');
        if ($id != "") {
            DB::Connection('mysql2')->table('daily_task_data')
                ->where('id', $id)
                ->update(['remarks' => $remarks]);
        }
    }

    public function updateDailyTask(Request $request)
    {
        //        echo "<pre>";
        //        print_r($_POST);
        //        die;
        $id = $request->id;
        $DailyTask = new DailyTask;
        $DailyTask = $DailyTask->SetConnection('mysql2');
        $DailyTask = $DailyTask->find($id);
        $DailyTask->task_date = $request->task_date;
        $DailyTask->status    = 1;
        $DailyTask->username  = Auth::user()->name;
        $DailyTask->date      = date('Y-m-d');
        $DailyTask->save();
        //$master_id = $DailyTask->id;

        DB::Connection('mysql2')->table('daily_task_data')->where('status', '=', 1)->where('daily_task_id', '=', $id)->delete();

        $Rowcount = $request->Rowcount;
        foreach ($Rowcount as $key => $value) {
            $DailyTaskData = new DailyTaskData;
            $DailyTaskData = $DailyTaskData->SetConnection('mysql2');
            $DailyTaskData->client      = $request->input('account_id' . $value);
            $DailyTaskData->description = $request->input('desc' . $value);
            $DailyTaskData->acc_officer = $request->input('acc_officer' . $value);
            $DailyTaskData->vendor      = $request->input('vendor' . $value);
            $DailyTaskData->region      = $request->input('region_id' . $value);
            $DailyTaskData->status      = 1;
            $DailyTaskData->username    = Auth::user()->name;
            $DailyTaskData->date        = date('Y-m-d');
            $DailyTaskData->daily_task_id = $id;
            $DailyTaskData->action      = 1;
            $DailyTaskData->save();
        }
        return Redirect::to('reports/daily_activity_list?pageType=add&&parentCode=82&&m=1#SFR');
    }

    public function full_daily_activity_list()
    {
        return view('Reports.full_daily_activity_list');
    }

    public function full_daily_activity_list_ajax(Request $request)
    {
        //print_r($_GET);
        //$from   = $request->input('from_date');
        //$to     = $request->input('to_date');
        $task_date = ($request->input('from_date') != "" && $request->input('to_date') != "") ? 'AND daily_task.task_date BETWEEN "' . $request->input('from_date') . '" AND "' . $request->input('to_date') . '"' : '';
        $client = ($request->input('client') != "") ? 'AND daily_task_data.client=' . $request->input('client') : '';
        $region = ($request->input('region') != "") ? 'AND daily_task_data.region=' . $request->input('region') : '';

        $DailyTask = DB::Connection('mysql2')->select('SELECT daily_task.*, daily_task_data.* FROM daily_task
                              INNER JOIN daily_task_data ON daily_task.id = daily_task_data.daily_task_id
                              WHERE daily_task_data.status=1 ' . $task_date . ' ' . $client . ' ' . $region . '
                              ORDER BY daily_task.task_date');

        $pending = DB::Connection('mysql2')->select('SELECT count(daily_task_data.id) as pending FROM daily_task INNER JOIN daily_task_data ON daily_task.id = daily_task_data.daily_task_id
                              WHERE daily_task_data.status=1 ' . $task_date . ' ' . $client . ' ' . $region . ' AND daily_task_data.action=1');

        $jobdone = DB::Connection('mysql2')->select('SELECT count(daily_task_data.id) as jobdone FROM daily_task INNER JOIN daily_task_data ON daily_task.id = daily_task_data.daily_task_id
                              WHERE daily_task_data.status=1 ' . $task_date . ' ' . $client . ' ' . $region . ' AND daily_task_data.action=2');

        $hold    = DB::Connection('mysql2')->select('SELECT count(daily_task_data.id) as hold FROM daily_task INNER JOIN daily_task_data ON daily_task.id = daily_task_data.daily_task_id
                              WHERE daily_task_data.status=1 ' . $task_date . ' ' . $client . ' ' . $region . ' AND daily_task_data.action=3');

        $delay   = DB::Connection('mysql2')->select('SELECT count(daily_task_data.id) as delay FROM daily_task INNER JOIN daily_task_data ON daily_task.id = daily_task_data.daily_task_id
                              WHERE daily_task_data.status=1 ' . $task_date . ' ' . $client . ' ' . $region . ' AND daily_task_data.action=4');

        return view('Reports.full_daily_activity_list_ajax', compact('DailyTask', 'pending', 'jobdone', 'hold', 'delay'));
    }


    public function viewPurchaseReport(Request $request)
    {
        $FromDate = $request->FromDate;
        $ToDate = $request->ToDate;
        $supplier = $request->supplier;
        $depart = $request->depart;
        $item = $request->item;
        $grn_no = $request->grn_no;
        $grn_received_type = $request->received_type;
        $po_no = $request->po_no;
        $store_control_no = $request->store_control_no;
        $company_location_id = $request->company_location_id;
        $category = $request->category;
        if ($request->ajax == 1) {
           

            $grn = GRNData::join('goods_receipt_note', 'goods_receipt_note.id', 'grn_data.master_id')
                ->join('supplier', 'supplier.id', 'goods_receipt_note.supplier_id')
                ->join('purchase_request', 'purchase_request.purchase_request_no', 'goods_receipt_note.po_no')
                ->leftjoin('quotation_data', 'quotation_data.pr_id', 'purchase_request.id')
                ->leftjoin('demand_data', 'demand_data.id', 'quotation_data.pr_data_id')
                ->leftjoin('quotation', 'quotation.id', 'quotation_data.master_id')
                ->select(
                    'grn_data.id',
                    'grn_data.purchase_recived_qty',
                    'grn_data.net_amount',
                    'supplier.name',
                    'goods_receipt_note.grn_no',
                    'goods_receipt_note.grn_date as grn_date',
                    'goods_receipt_note.delivery_challan_no as challan_no',
                    'goods_receipt_note.company_location_id',
                    'goods_receipt_note.sub_department_id',
                    'grn_data.sub_item_id',
                    'grn_data.received_type',
                    'purchase_request.purchase_request_no',
                    'demand_data.demand_no as pr_no',
                    'quotation_data.voucher_no'
                )
                ->where([['grn_data.status', 1]])
                ->where([['grn_data.purchase_recived_qty', '>', 0]])
                ->where(function ($query) use ($supplier) {
                    if ($supplier != 0) {
                        $query->where('goods_receipt_note.supplier_id', $supplier);
                    }
                })
                ->where(function ($query) use ($company_location_id) {
                    if ($company_location_id != "") {
                        $query->where('goods_receipt_note.company_location_id', $company_location_id);
                    }
                })
                ->where(function ($query) use ($depart) {
                    if ($depart != 0) {
                        $query->where('goods_receipt_note.sub_department_id', $depart);
                    }
                })
                ->where(function ($query) use ($grn_no) {
                    if ($grn_no) {
                        $query->where('goods_receipt_note.grn_no', $grn_no);
                    }
                })
                ->where(function ($query) use ($grn_received_type) {
                    if ($grn_received_type) {
                        $query->where('grn_data.received_type', $grn_received_type);
                    }
                })
                ->where(function ($query) use ($po_no) {
                    if ($po_no) {
                        $query->where('purchase_request.purchase_request_no', $po_no);
                    }
                })
                ->where(function ($query) use ($store_control_no) {
                    if ($store_control_no) {
                        $query->where('grn_data.store_control_no', $store_control_no);
                    }
                })
                ->where(function ($query) use ($category, $item) {
                    if ($category != 0 && $item == 0) {
                        $subItem = Subitem::where([['main_ic_id', $category], ['status', 1]])->pluck('id')->toArray();
                        $query->whereIn('grn_data.sub_item_id', $subItem);
                    }
                    if ($item != 0) {
                        $query->where('grn_data.sub_item_id', $item);
                    }
                });
            if (!$grn_no && !$store_control_no && !$po_no) {
                $grn = $grn->whereBetween('goods_receipt_note.grn_date', [$FromDate, $ToDate]);
            }

            $grn = $grn->groupBy('grn_data.id')
                ->get();

            // dd($grn);
            return view('Reports.Inventory.viewPurchaseReportAjax', compact('grn'));
        }
        return view('Reports.Inventory.viewPurchaseReport');
    }
    public function viewPurchaseRequestReport(Request $request)
    {
        $company_locations = ReuseableCode::getUserWiseLocationRightsData();
        if ($request->ajax()) {
            $company_location_id = $request->company_location_id;
            $demandDatas = DemandData::join('demand', 'demand.id', 'demand_data.master_id')
                ->select('demand_data.*', 'demand.company_location_id')
                ->whereBetween('demand_data.demand_date', [$request->FromDate, $request->ToDate])
                ->where(function ($query) use ($company_location_id) {
                    if (!empty($company_location_id)) {
                        $query->where('demand.company_location_id', $company_location_id);
                    } else {
                        $query->whereIn('demand.company_location_id', ReuseableCode::getUserWiseLocationRights());
                    }
                })
                ->where('demand_data.status', 1)->where('demand_data.cancel_status', 1)->where('demand.status', 1)->where('demand.demand_status', 2)->where('demand_data.demand_status', 2)->where('demand_data.quotation_id', 0)->get();
            // echo "<pre>";
            // print_r($request->all());
            return view('Reports.Inventory.viewPurchaseRequestReportAjax', compact('demandDatas'));
        }
        return view('Reports.Inventory.viewPurchaseRequestReport', compact('company_locations'));
    }


    public function viewMaterialReport(Request $request)
    {
        $depart = $request->depart;
        $item = $request->item;
        $category = $request->category;
        $company_location_id = $request->company_location_id;

        if ($request->ajax == 1) {
            $query = DB::Connection('mysql2')->table('issuance')
                ->select(
                    'issuance.iss_date',
                    'issuance.iss_no',
                    'issuance.company_location_id',
                    'subitem.sub_ic',
                    'subitem.sku_code',
                    'subitem.id as item_id',
                    'subitem.main_ic_id',
                    'issuance_data.qty',
                    'issuance_data.warehouse_id',
                    'issuance.machine_id',
                    'issuance.department_id',
                    'issuance.line_id',
                    'warehouse.name as warehouse_name',
                    'machineries.name as machinery_name',
                    'lines.name as line_name'
                )
                ->join('issuance_data', 'issuance.iss_no', '=', 'issuance_data.iss_no')
                ->leftJoin(config('database.connections.mysql.database') . '.sub_department', 'sub_department.id', '=', 'issuance.department_id')
                ->leftJoin('machineries', 'machineries.id', '=', 'issuance.machine_id')
                ->leftJoin('lines', 'lines.id', '=', 'issuance.line_id')
                ->join('subitem', 'issuance_data.sub_item_id', '=', 'subitem.id')
                ->join('warehouse', 'issuance_data.warehouse_id', '=', 'warehouse.id');

            if (!empty($request->FromDate) && !empty($request->ToDate)) {
                $from  = date('Y-m-d', strtotime($request->FromDate));
                $to  = date('Y-m-d', strtotime($request->ToDate));
                $query->whereBetween('iss_date', [$from, $to]);
            }

            if (!empty($request->warehouse_id)) {
                $query->where('warehouse_id', $request->warehouse_id);
            }
            if (!empty($company_location_id)) {
                $query->where('company_location_id', $company_location_id);
            } else {
                $query->whereIn('company_location_id', ReuseableCode::getUserWiseLocationRights());
            }
            if ($request->depart) {
                $query->where(function ($q) use ($request) {
                    // No need to wrap $request->depart in an extra array
                    $q->whereIn('sub_department.id', $request->depart)
                      ->orWhereNull('issuance.department_id'); // In case the left join doesn't find a match
                });
            }

            if (!empty($request->line_id)) {
                $query->where('line_id', $request->line_id);
            }
            if (!empty($request->machinery_id)) {
                $query->where('machine_id', $request->machinery_id);
            }
            if (!empty($request->item)) {
                $query->where('subitem.id', $request->item);
            }
            if (!empty($request->category)) {
                $query->where('main_ic_id', $request->category);
            }

            $data =  $query->where('issuance.status', 1)->where('issuance_data.status', 1)->get();

            return view('Reports.Inventory.viewMaterialReportAjax', compact('data'));
        }
        return view('Reports.Inventory.viewMaterialReport');
    }

    public function viewItemWiseStatusReport(Request $request)
    {

        if ($request->ajax()) {
            // dd('TEst');
            $query =  DB::connection('mysql2')->table('demand_data')
                ->leftjoin('quotation_data', 'quotation_data.pr_data_id', 'demand_data.id')
                ->leftjoin('purchase_request_data', 'purchase_request_data.demand_data_id', 'demand_data.id')
                ->leftjoin('demand', 'demand.id', 'demand_data.master_id')
                ->leftjoin('purchase_request', 'purchase_request.id', 'purchase_request_data.master_id')
                ->leftJoin('grn_data', function ($join) {
                    $join->on('purchase_request_data.id', '=', 'grn_data.po_data_id')
                        ->where('grn_data.status', 1)
                        ->where('grn_data.purchase_recived_qty', '>', 0);
                })
                // ->leftjoin('grn_data', 'grn_data.po_data_id', 'purchase_request_data.id')
                ->join('subitem', 'subitem.id', 'demand_data.sub_item_id')
                ->select(
                    'demand.company_location_id',
                    'demand_data.demand_no',
                    'demand_data.qty',
                    'demand_data.demand_status',
                    'quotation_data.voucher_no',
                    'quotation_data.qty as qoutation_qty',
                    'subitem.sub_ic',
                    'subitem.uom',
                    'purchase_request_data.purchase_request_no',
                    'purchase_request_data.purchase_approve_qty',
                    'grn_data.grn_no',
                    'grn_data.purchase_recived_qty',
                );

            if (!empty($request->demand_no)) {
                $query = $query->where('demand_data.demand_no', $request->demand_no)->where('demand_data.status', 1)->where('purchase_request_data.status', 1)->where('grn_data.status', 1)->get();
                return view('Reports.Inventory.viewItemWiseStatusReportAjax', compact('query'));
            }
            if (!empty($request->company_location_id)) {
                $query->where('demand.company_location_id', $request->company_location_id);
            } else {
                $query->whereIn('demand.company_location_id', ReuseableCode::getUserWiseLocationRights());
            }
            if (!empty($request->item_id)) {
                $query = $query->where('demand_data.sub_item_id', $request->item_id);
            }
            if ($request->demand_status > 0) {
                if ($request->demand_status == 1) {
                    $query = $query->where('demand_data.demand_status', $request->demand_status);
                } else {
                    $query = $query->where('demand_data.demand_status', '!=', 1);
                }
            }
            $query  =   $query->whereBetween('demand_data.demand_date', [$request->FromDate, $request->ToDate])->where('demand_data.status', 1)->where('purchase_request_data.status', 1)->where('grn_data.status', 1)->orderBy('demand_data.id', 'desc')->get();
            return view('Reports.Inventory.viewItemWiseStatusReportAjax', compact('query'));
        }
        return view('Reports.Inventory.viewItemWiseStatusReport');
    }



    public function categoryWiseReport()
    {
        $SubItem = DB::Connection('mysql2')->select('select a.id,a.sub_ic from subitem a
            INNER JOIN stock b ON b.sub_item_id = a.id
            WHERE a.status = 1
            GROUP BY b.sub_item_id');

        $departments =  SubDepartment::where('status', 1)->get();
        return view('Reports.Inventory.categoryWiseReport', compact('SubItem', 'departments'));
    }
    public function categoryWiseReportAjax(Request $request)
    {

        if ($request->po_type == 2) {
            $query =  PurchaseRequestData::leftJoin('demand_data', function ($join) {
                $join->on('purchase_request_data.demand_data_id', '=', 'demand_data.id')
                    ->where('demand_data.status', 1)->where('demand_data.cancel_status', 1);
            })->leftJoin('purchase_request', function ($join) {
                $join->on('purchase_request.id', '=', 'purchase_request_data.master_id')
                    ->where('purchase_request.status', 1);
            })->leftJoin('grn_data', function ($join) {
                $join->on('grn_data.po_data_id', '=', 'purchase_request_data.id')
                    ->where('grn_data.status', 1)
                    ->where('grn_data.purchase_recived_qty', '>', 0);
            })->leftJoin('new_purchase_voucher_data', function ($join) {
                $join->on('new_purchase_voucher_data.grn_data_id', '=', 'grn_data.id')
                    ->where('new_purchase_voucher_data.staus', 1);
            })->leftJoin('new_purchase_voucher', function ($join) {
                $join->on('new_purchase_voucher.id', '=', 'new_purchase_voucher_data.master_id')
                    ->where('new_purchase_voucher.status', 1);
            })->leftJoin('supplier', function ($join) {
                $join->on('supplier.id', '=', 'purchase_request.supplier_id')
                    ->where('supplier.status', 1);
            })
            ->leftJoin('demand', function ($join) {
                $join->on('demand_data.master_id', '=', 'demand.id')
                    ->where('demand.status', 1);
            })
            // ->leftJoin('quotation_data', function ($join) {
            //     $join->on('demand_data.id', '=', 'quotation_data.pr_data_id');
            // })
            ->leftJoin('subitem', 'subitem.id', 'purchase_request_data.sub_item_id')
            ->leftJoin('category', 'category.id', 'subitem.main_ic_id')
            ->leftJoin('inno_garibsons_master.sub_department as db', 'db.id', 'purchase_request.sub_department_id')
            ->select(
                'demand_data.id as demand_id',
                'demand_data.qty as demand_qty',
                'demand_data.demand_date',
                'db.sub_department_name',
                'demand_data.demand_no',
                'subitem.sub_ic',
                'purchase_request_data.description as remarks',
                'purchase_request.sales_tax',
                'purchase_request_data.group_number',
                'subitem.uom',
                'subitem.item_code',
                'category.main_ic as category_name',
                'purchase_request_data.purchase_approve_qty',
                'supplier.name',
                'purchase_request_data.rate',
                'purchase_request_data.sub_total',
                'purchase_request_data.discount_amount',
                'purchase_request_data.purchase_request_no',
                'purchase_request_data.purchase_request_date',
                'demand_data.sub_ic_desc as description',
                'purchase_request.company_location_id',
                'grn_data.purchase_recived_qty',
                'grn_data.grn_no',
                'grn_data.grn_date',
                'new_purchase_voucher.pv_no',
                'new_purchase_voucher.pv_date',
            );
            if (!empty($request->purchase_no)) {
                $query->where('purchase_request_data.purchase_request_no', 'LIKE', '%' . $request->purchase_no . '%');
            }
            if (!empty($request->company_location_id)) {
                $query->where('purchase_request.company_location_id', $request->company_location_id);
            } else {
                $query->whereIn('purchase_request.company_location_id', ReuseableCode::getUserWiseLocationRights());
            }

            if (!empty($request->item_id)) {
                $query->where('purchase_request_data.sub_item_id', $request->item_id);
            }
            if (!empty($request->department_id)) {
                $query->whereIn('db.id', $request->department_id);
            }
            if (!empty($request->po_type)) {
                $query->where('purchase_request.type', $request->po_type);
            }
            $data  =   $query
                ->where('purchase_request.status',1)
                ->whereBetween('purchase_request.purchase_request_date', [$request->from_date, $request->last_date])
                ->where('purchase_request_data.status',1)
                ->orderby('purchase_request.id', 'desc')
                ->get();
        }else{
            $query =  DemandData::leftJoin('purchase_request_data', function ($join) {
                    $join->on('purchase_request_data.demand_data_id', '=', 'demand_data.id')
                        ->where('purchase_request_data.status', 1);
                })->leftJoin('purchase_request', function ($join) {
                    $join->on('purchase_request.id', '=', 'purchase_request_data.master_id')
                        ->where('purchase_request.status', 1);
                })->leftJoin('grn_data', function ($join) {
                    $join->on('grn_data.po_data_id', '=', 'purchase_request_data.id')
                        ->where('grn_data.status', 1)
                        ->where('grn_data.purchase_recived_qty', '>', 0);
                })->leftJoin('new_purchase_voucher_data', function ($join) {
                    $join->on('new_purchase_voucher_data.grn_data_id', '=', 'grn_data.id')
                        ->where('new_purchase_voucher_data.staus', 1);
                })->leftJoin('new_purchase_voucher', function ($join) {
                    $join->on('new_purchase_voucher.id', '=', 'new_purchase_voucher_data.master_id')
                        ->where('new_purchase_voucher.status', 1);
                })->leftJoin('supplier', function ($join) {
                    $join->on('supplier.id', '=', 'purchase_request.supplier_id')
                        ->where('supplier.status', 1);
                })
                // leftJoin('purchase_request_data','purchase_request_data.demand_data_id','demand_data.id')
                // ->leftJoin('demand_data','demand_data.id','purchase_request_data.demand_data_id')
                // ->leftJoin('purchase_request', 'purchase_request.id', 'purchase_request_data.master_id')
                // ->leftJoin('supplier', 'supplier.id', 'purchase_request.supplier_id')
                ->join('demand', 'demand.id', 'demand_data.master_id')
                // ->leftJoin('quotation_data', function ($join) {
                //     $join->on('quotation_data.pr_data_id', '=', 'demand_data.id');
                //     $join->on('demand_data.sub_item_id', '=', 'quotation_data.sub_item_id');
                //     $join->on('quotation_data.quotation_status','!=',DB::raw('0'));
                //     $join->on('quotation_data.vendor','!=',DB::raw('0'));
                // })
                ->join('subitem', 'subitem.id', 'demand_data.sub_item_id')
                ->leftJoin('category', 'category.id', 'subitem.main_ic_id')
                ->join('inno_garibsons_master.sub_department as db', 'db.id', 'demand.sub_department_id')
                ->select(
                    'demand_data.id as demand_id',
                    'demand_data.qty as demand_qty',
                    'demand_data.demand_date',
                    'db.sub_department_name',
                    'demand_data.demand_no',
                    'subitem.sub_ic',
                    'purchase_request_data.description as remarks',
                    'purchase_request.sales_tax',
                    'purchase_request_data.group_number',
                    'subitem.uom',
                    'subitem.item_code',
                    'category.main_ic as category_name',
                    'purchase_request_data.purchase_approve_qty',
                    'supplier.name',
                    'purchase_request_data.rate',
                    'purchase_request_data.sub_total',
                    'purchase_request_data.discount_amount',
                    'purchase_request_data.purchase_request_no',
                    'purchase_request_data.purchase_request_date',
                    'demand_data.sub_ic_desc as description',
                    'demand.company_location_id',
                    'grn_data.purchase_recived_qty',
                    'grn_data.grn_no',
                    'grn_data.grn_date',
                    'new_purchase_voucher.pv_no',
                    'new_purchase_voucher.pv_date',
                );
            if (!empty($request->purchase_no)) {
                $query->where('purchase_request_data.purchase_request_no', 'LIKE', '%' . $request->purchase_no . '%');
            }
            if (!empty($request->company_location_id)) {
                $query->where('demand.company_location_id', $request->company_location_id);
            } else {
                $query->whereIn('demand.company_location_id', ReuseableCode::getUserWiseLocationRights());
            }

            if (!empty($request->item_id)) {
                $query->where('demand_data.sub_item_id', $request->item_id);
            }
            if (!empty($request->department_id)) {
                $query->whereIn('db.id', $request->department_id);
            }

            $data  =   $query->where('demand_data.status', 1)
                ->where('demand_data.cancel_status', 1)
                ->where('demand.status', 1)
                ->whereBetween('demand.demand_date', [$request->from_date, $request->last_date])
                ->where('demand.demand_status', 2)
                ->where('subitem.status', 1)
                ->orderby('demand.id', 'desc')
                ->get();
        }
        return view('Reports.Inventory.categoryWiseReportAjax', compact('data'));
    }
    
    public function categoryWiseReportWithoutPOGrn()
    {
        $SubItem = DB::Connection('mysql2')->select('select a.id,a.sub_ic from subitem a
            INNER JOIN stock b ON b.sub_item_id = a.id
            WHERE a.status = 1
            GROUP BY b.sub_item_id');

        $departments =  SubDepartment::where('status', 1)->get();
        return view('Reports.Inventory.categoryWiseReportWithoutPOGrn', compact('SubItem', 'departments'));
    }
    public function categoryWiseReportWithoutPOGrnAjax(Request $request)
    {
        if ($request->po_type == 2) {
            $query =  PurchaseRequestData::
            leftJoin('demand_data', function ($join) {
            $join->on('purchase_request_data.demand_data_id', '=', 'demand_data.id')
                ->where('demand_data.status', 1)->where('demand_data.cancel_status', 1);
            })->leftJoin('purchase_request', function ($join) {
                $join->on('purchase_request.id', '=', 'purchase_request_data.master_id')
                    ->where('purchase_request.status', 1);
            })
            ->leftJoin('supplier', 'supplier.id', 'purchase_request.supplier_id')
            ->leftJoin('demand', function ($join) {
                $join->on('demand_data.master_id', '=', 'demand.id')
                    ->where('demand.status', 1);
            })
            ->join('subitem', 'subitem.id', 'purchase_request_data.sub_item_id')
            ->join('inno_garibsons_master.sub_department as db', 'db.id', 'purchase_request.sub_department_id')
            ->select(
                'demand_data.id as demand_id',
                'demand_data.qty as demand_qty',
                'demand_data.demand_date',
                'db.sub_department_name',
                'demand_data.demand_no',
                'subitem.sub_ic',
                'purchase_request_data.description as remarks',
                'purchase_request.sales_tax',
                'purchase_request_data.group_number',
                'subitem.uom',
                'subitem.item_code',
                'purchase_request_data.purchase_approve_qty',
                'supplier.name',
                'purchase_request_data.rate',
                'purchase_request_data.sub_total',
                'purchase_request_data.discount_amount',
                'purchase_request_data.purchase_request_no',
                'purchase_request_data.purchase_request_date',
                'demand_data.sub_ic_desc as description',
                'purchase_request.company_location_id',
            );
            if (!empty($request->purchase_no)) {
                $query->where('demand_data.demand_no', 'LIKE', '%' . $request->purchase_no . '%');
            }
            if (!empty($request->company_location_id)) {
                $query->where('purchase_request.company_location_id', $request->company_location_id);
            } else {
                $query->whereIn('purchase_request.company_location_id', ReuseableCode::getUserWiseLocationRights());
            }

            if (!empty($request->item_id)) {
                $query->where('demand_data.sub_item_id', $request->item_id);
            }
            if (!empty($request->department_id)) {
                $query->where('db.id', $request->department_id);
            }
            if (!empty($request->po_type)) {
                $query->where('purchase_request.type', $request->po_type);
            }

            $data  =   $query
                ->where('purchase_request_data.status', 1)
                ->where('purchase_request.status', 1)
                ->where('supplier.status',1)
                ->where('subitem.status', 1)
                ->orderby('purchase_request.id', 'desc')
                ->get();
        } else {
            $query =  DemandData::
            leftJoin('purchase_request_data', function ($join) {
                    $join->on('purchase_request_data.demand_data_id', '=', 'demand_data.id')
                        ->where('purchase_request_data.status', 1);
                })->leftJoin('purchase_request', function ($join) {
                    $join->on('purchase_request.id', '=', 'purchase_request_data.master_id')
                        ->where('purchase_request.status', 1);
                })
                ->leftJoin('supplier', 'supplier.id', 'purchase_request.supplier_id')
                ->join('demand', 'demand.id', 'demand_data.master_id')
                ->join('subitem', 'subitem.id', 'demand_data.sub_item_id')
                ->join('inno_garibsons_master.sub_department as db', 'db.id', 'demand.sub_department_id')
                ->select(
                    'demand_data.id as demand_id',
                    'demand_data.qty as demand_qty',
                    'demand_data.demand_date',
                    'db.sub_department_name',
                    'demand_data.demand_no',
                    'subitem.sub_ic',
                    'purchase_request_data.description as remarks',
                    'purchase_request.sales_tax',
                    'purchase_request_data.group_number',
                    'subitem.uom',
                    'subitem.item_code',
                    'purchase_request_data.purchase_approve_qty',
                    'supplier.name',
                    'purchase_request_data.rate',
                    'purchase_request_data.sub_total',
                    'purchase_request_data.discount_amount',
                    'purchase_request_data.purchase_request_no',
                    'purchase_request_data.purchase_request_date',
                    'demand_data.sub_ic_desc as description',
                    'demand.company_location_id',
                );
            if (!empty($request->purchase_no)) {
                $query->where('demand_data.demand_no', 'LIKE', '%' . $request->purchase_no . '%');
            }
            if (!empty($request->company_location_id)) {
                $query->where('demand.company_location_id', $request->company_location_id);
            } else {
                $query->whereIn('demand.company_location_id', ReuseableCode::getUserWiseLocationRights());
            }

            if (!empty($request->item_id)) {
                $query->where('demand_data.sub_item_id', $request->item_id);
            }
            if (!empty($request->department_id)) {
                $query->where('db.id', $request->department_id);
            }

            $data  =   $query->where('demand_data.status', 1)
                ->where('demand_data.cancel_status', 1)
                ->where('demand.status', 1)
                ->where('demand.demand_status', 2)
                ->where('supplier.status',1)
                ->where('subitem.status', 1)
                ->orderby('demand.id', 'desc')
                ->get();
        }
        return view('Reports.Inventory.categoryWiseReportWithoutPOGrnAjax', compact('data'));
    }

    public function viewStockAgeingReport()
    {
        return view('Reports.Inventory.viewStockAgeingReport');
    }

    public function viewStockAgeingReportDetail(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $category_id = $request->category;
        $location = $request->location;
        $demandType = $request->demandType;
        $category_name = CommonHelper::get_category_name($category_id);
        $sub_item = $request->sub_1;
        $item_des = $request->item_des;

        if ($sub_item) :
            $sub_item = $sub_item = explode('@', $sub_item);
            $sub_item = $sub_item[0];
            $sub_item_clause = "and a.sub_item_id=" . $sub_item;
            $generic = CommonHelper::generic('subitem', array('id' => $sub_item), array('sub_ic'))->first();
            $sub_item_heading = 'Item :' . $generic->sub_ic;
        endif;

        $lastRates = DB::connection('mysql2')->select("
            SELECT s1.sub_item_id, s1.rate, s1.voucher_date
            FROM stock s1
            INNER JOIN (
                SELECT sub_item_id, MAX(voucher_date) AS last_date
                FROM stock
                WHERE voucher_type = 1
                GROUP BY sub_item_id
            ) s2 ON s1.sub_item_id = s2.sub_item_id AND s1.voucher_date = s2.last_date
            WHERE s1.voucher_type = 1
        ");

        $ratesArray = [];
        foreach ($lastRates as $rate) {
            $ratesArray[$rate->sub_item_id] = $rate;
        }

        $data = DB::connection('mysql2')->table('stock as a')
    ->join('subitem as b', 'a.sub_item_id', '=', 'b.id')
    ->join('category as c', 'c.id', '=', 'b.main_ic_id')
    ->join('warehouse as d', 'd.id', '=', 'a.warehouse_id')
    ->join('demand_type as e', 'e.id', '=', 'b.type')
    ->join(env('DB_DATABASE').'.uom as f', 'f.id', '=', 'b.uom')
    ->when($category_id != null, function ($query) use ($category_id) {
        $query->where('c.id', $category_id);
    })
    ->when($sub_item != null, function ($query) use ($sub_item) {
        $query->where('b.id', $sub_item);
    })
    ->when($location != null, function ($query) use ($location) {
        $query->where('d.id', $location);
    })
    ->when($demandType != null, function ($query) use ($demandType) {
        $query->where('e.id', $demandType);
    })
    ->where('a.status', 1)
    ->select(
        'a.*',
        'b.sub_ic',
        'b.pack_size',
        'b.type',
        'b.uom',
        'b.sku_code',
        'c.main_ic',
        'd.name',
        'e.name as demand_name',
        'f.uom_name',

        // Closing stock calculation
        DB::raw('SUM(CASE
    WHEN voucher_type IN (1,10,12) THEN a.qty
    WHEN voucher_type IN (5,2,9,3,13) THEN -a.qty
    ELSE 0
END) AS current_stock'),

        // 1-30 days aging bucket
        DB::raw('LEAST(
            SUM(CASE
                WHEN voucher_type IN (1,10,12) AND voucher_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE() THEN a.qty
                WHEN voucher_type IN (5,2,9,3,13) AND voucher_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE() THEN -a.qty
                ELSE 0
            END),
            SUM(CASE
                WHEN voucher_type IN (1,10,12) THEN a.qty
                ELSE 0
            END)
        ) AS days_1_30'),

        // 31-60 days aging bucket
        DB::raw('LEAST(
            SUM(CASE
                WHEN voucher_type IN (1,10,12) AND voucher_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND DATE_SUB(CURDATE(), INTERVAL 31 DAY) THEN a.qty
                WHEN voucher_type IN (5,2,9,3,13) AND voucher_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND DATE_SUB(CURDATE(), INTERVAL 31 DAY) THEN -a.qty
                ELSE 0
            END),
            GREATEST(SUM(CASE
                WHEN voucher_type IN (1,10,12) THEN a.qty
                ELSE 0
            END) - 
            SUM(CASE
                WHEN voucher_type IN (1,10,12) AND voucher_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE() THEN a.qty
                ELSE 0
            END), 0)
        ) AS days_31_60'),

        // 61-90 days aging bucket
        DB::raw('LEAST(
            SUM(CASE
                WHEN voucher_type IN (1,10,12) AND voucher_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND DATE_SUB(CURDATE(), INTERVAL 61 DAY) THEN a.qty
                WHEN voucher_type IN (5,2,9,3,13) AND voucher_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND DATE_SUB(CURDATE(), INTERVAL 61 DAY) THEN -a.qty
                ELSE 0
            END),
            GREATEST(SUM(CASE
                WHEN voucher_type IN (1,10,12) THEN a.qty
                ELSE 0
            END) -
            SUM(CASE
                WHEN voucher_type IN (1,10,12) AND voucher_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND CURDATE() THEN a.qty
                ELSE 0
            END), 0)
        ) AS days_61_90'),

        // 91-120 days aging bucket
        DB::raw('LEAST(
            SUM(CASE
                WHEN voucher_type IN (1,10,12) AND voucher_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 120 DAY) AND DATE_SUB(CURDATE(), INTERVAL 91 DAY) THEN a.qty
                WHEN voucher_type IN (5,2,9,3,13) AND voucher_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 120 DAY) AND DATE_SUB(CURDATE(), INTERVAL 91 DAY) THEN -a.qty
                ELSE 0
            END),
            GREATEST(SUM(CASE
                WHEN voucher_type IN (1,10,12) THEN a.qty
                ELSE 0
            END) -
            SUM(CASE
                WHEN voucher_type IN (1,10,12) AND voucher_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND CURDATE() THEN a.qty
                ELSE 0
            END), 0)
        ) AS days_91_120'),

        // 121-150 days aging bucket
        DB::raw('LEAST(
            SUM(CASE
                WHEN voucher_type IN (1,10,12) AND voucher_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 150 DAY) AND DATE_SUB(CURDATE(), INTERVAL 121 DAY) THEN a.qty
                WHEN voucher_type IN (5,2,9,3,13) AND voucher_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 150 DAY) AND DATE_SUB(CURDATE(), INTERVAL 121 DAY) THEN -a.qty
                ELSE 0
            END),
            GREATEST(SUM(CASE
                WHEN voucher_type IN (1,10,12) THEN a.qty
                ELSE 0
            END) -
            SUM(CASE
                WHEN voucher_type IN (1,10,12) AND voucher_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 120 DAY) AND CURDATE() THEN a.qty
                ELSE 0
            END), 0)
        ) AS days_121_150'),

        // 151-180 days aging bucket
        DB::raw('LEAST(
            SUM(CASE
                WHEN voucher_type IN (1,10,12) AND voucher_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 180 DAY) AND DATE_SUB(CURDATE(), INTERVAL 151 DAY) THEN a.qty
                WHEN voucher_type IN (5,2,9,3,13) AND voucher_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 180 DAY) AND DATE_SUB(CURDATE(), INTERVAL 151 DAY) THEN -a.qty
                ELSE 0
            END),
            GREATEST(SUM(CASE
                WHEN voucher_type IN (1,10,12) THEN a.qty
                ELSE 0
            END) -
            SUM(CASE
                WHEN voucher_type IN (1,10,12) AND voucher_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 150 DAY) AND CURDATE() THEN a.qty
                ELSE 0
            END), 0)
        ) AS days_151_180'),

        // Above 180 days aging bucket
        DB::raw('GREATEST(SUM(CASE WHEN voucher_type IN (1,10,12) THEN a.qty ELSE 0 END) - (SUM(CASE WHEN voucher_type in (1) and voucher_date >= DATE_SUB(CURDATE(), INTERVAL 180 DAY) THEN a.qty ELSE 0 END)), 0) as above_180')

    )
    ->groupBy('a.sub_item_id', 'a.warehouse_id')
    ->get();
        return view('Reports.Inventory.viewStockAgeingReportDetail', compact('data', 'from_date', 'to_date','ratesArray'));
    }
}
