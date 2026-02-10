<?php

namespace App\Http\Controllers;


use App\Models\Quotation_Data;
use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use App\Models\Account;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Countries;
use App\Models\Sales_Order;
use App\Models\Sales_Order_Data;
use App\Models\CreditNote;
use App\Models\CreditNoteData;
use App\Models\Region;
use App\Models\Cities;
use App\Models\Type;
use App\Models\Conditions;
use App\Models\SurveryBy;
use App\Models\Client;
use App\Models\Branch;
use App\Models\Survey;
use App\Models\SurveyDocument;
use App\Models\JobTracking;
use App\Models\ProductType;
use App\Models\ResourceAssigned;
use App\Models\Quotation;
use App\Models\Complaint;
use App\Models\InvDesc;
use App\Models\NewRvs;
use App\Models\Supplier;
use App\Helpers\NotificationHelper;
use App\Imports\UploadCustomerDetail;
use App\Models\DeliveryNote;

use App\Models\DeliveryNoteData;
use App\Models\SalesTaxInvoice;
use App\Models\SalesTaxInvoiceData;
use App\Models\JobOrder;
use App\Models\JobOrderData;
use App\Models\Invoice;
use App\Models\InvoiceData;
use App\Models\Product;
use App\Models\ClientJob;

use App\Models\ComplaintDocument;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class SalesController extends Controller
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
        return view('Sales.toDayActivity');
    }

    public function topFiveSalesReportPage()
    {
        $Customers = DB::Connection('mysql2')->table('customers')->where('status', 1)->get();
        return view('Sales.topFiveSalesReportPage', compact('Customers'));
    }


    public function debtor_balance_page()
    {
        $Customer = DB::Connection('mysql2')->table('customers')->where('status', 1)->get();
        return view('Sales.debtor_balance_page', compact('Customer'));
    }
    public function commission_report_page()
    {
        $Agent = DB::Connection('mysql2')->select('select a.id,a.agent_name from sales_agent a
                                                  INNER  JOIN commision b ON b.agent = a.id
                                                  WHERE b.status = 1');
        return view('Sales.commission_report_page', compact('Agent'));
    }



    public function add_point_of_sale()
    {
        $BatchCode = DB::Connection('mysql2')->table('stock')->where('status', 1)->where('opening', 0)->select('batch_code')->groupBy('batch_code')->get();
        return view('Sales.add_point_of_sale', compact('BatchCode'));
    }

    public function salesActivityPage()
    {
        return view('Sales.salesActivityPage');
    }

    public function freight_collection_page()
    {
        return view('Sales.freight_collection_page');
    }


    public function salesActivityAjax()
    {
        return view('Sales.salesActivityAjax');
    }
    public function debtor_payment_detail()
    {
        $data =  DB::Connection('mysql2')->table('customers as a')
            ->select('a.name', 'a.id')
            ->join('sales_tax_invoice as b', 'a.id', '=', 'b.buyers_id')
            ->where('a.status', 1)
            ->where('b.status', 1)
            ->groupBy('b.buyers_id')
            ->get();
        return view('Sales.debtor_payment_detail', compact('data'));
    }

    public function soTrackingQtyPage()
    {
        return view('Sales.soTrackingQtyPage');
    }

    public function salesAgingReport()
    {
        $Customer = DB::Connection('mysql2')->table('customers')->where('status', 1)->get();
        return view('Sales.salesAgingReport', compact('Customer'));
    }

    public function getAgingReportDataAjaxSales(Request $request)
    {
        if ($request->ReportType == 1) {
            return view('Sales.getAgingReportDataAjaxSalesSummary');
        } else {
            return view('Sales.getAgingReportDataAjaxSales');
        }
    }



    public function createCashCustomerForm()
    {
        $countries = new Countries;
        $countries = $countries::where('status', '=', 1)->get();
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $accounts = new Account;
        $accounts = $accounts::orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')
            ->get();
        CommonHelper::reconnectMasterDatabase();
        return view('Sales.createCashCustomerForm', compact('accounts', 'countries'));
    }

    public function viewCashCustomerList()
    {
        return view('Sales.viewCashCustomerList');
    }

    public function outstandingReportPage()
    {
        $Customer = DB::Connection('mysql2')->table('customers')->where('status', 1)->get();
        return view('Sales.outstandingReportPage', compact('Customer'));
    }

    public function soTrackingPage()
    {
        $SoNo = DB::Connection('mysql2')->table('sales_order')->where('status', 1)->select('so_no', 'id')->get();
        return view('Sales.soTrackingPage', compact('SoNo'));
    }


    public function ViewMultipleDeliveryNotesDetail()
    {
        return view('Sales.ViewMultipleDeliveryNotesDetail');
    }

    public function soReportPage()
    {
        return view('Sales.soReportPage');
    }
    public function dnReportPage()
    {
        return view('Sales.dnReportPage');
    }


    public function ViewMultipleSalesTaxInvoices()
    {
        return view('Sales.ViewMultipleSalesTaxInvoices');
    }
    public function ViewMultipleCreditNoteDetail()
    {
        return view('Sales.ViewMultipleCreditNoteDetail');
    }




    public function CreateMultipleSalesTaxInvoices()
    {
        return view('Sales.CreateMultipleSalesTaxInvoices');
    }



    public function createCreditCustomerForm()
    {
        $countries = new Countries;
        $countries = $countries::where('status', '=', 1)->get();
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $accounts = new Account;
        $accounts = $accounts::orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')

            ->get();
        CommonHelper::reconnectMasterDatabase();
        return view('Sales.createCreditCustomerForm', compact('accounts', 'countries'));
    }

    public function editCustomerForm($id)
    {
        $countries = new Countries;
        $countries = $countries::where('status', '=', 1)->get();
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $accounts = new Account;
        $accounts = $accounts::orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')

            ->get();
        CommonHelper::reconnectMasterDatabase();
        return view('Sales.editCustomerForm', compact('accounts', 'countries', 'id'));
    }



    public function viewCreditCustomerList()
    {
        return view('Sales.viewCreditCustomerList');
    }


    public function uploadCustomerDetail()
    {
        return view('Sales.uploadCustomerDetail');
    }


    public function uploadCustomerDetailPost(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
            if ($request->file('dataFile')) {
                Excel::import(new UploadCustomerDetail, $request->file('dataFile'));
            }
            DB::Connection('mysql2')->commit();
            Session::flash('dataInsert', 'Successfully Upload!');
            return Redirect::to('sales/viewCreditCustomerList?m=' . Session::get('run_company'));
        } catch (Exception $e) {
            DB::Connection('mysql2')->rollback();
            dd($e->getLine(), $e->getMessage());
        }
    }

    public function add_agent_list()
    {
        return view('Sales.add_agent_list');
    }


    public function jobTrackingSheet()
    {

        $customer = new Customer();
        $customer = $customer->SetConnection('mysql2');
        $customer = $customer->where('status', 1)->get();
        $region = new Region();
        $region = $region->SetConnection('mysql2');
        $region = $region->where('status', 1)->get();
        $survey = new Survey();
        $survey = $survey->SetConnection('mysql2');
        $survey = $survey->where('status', 1)->where('survey_status', 2)->get();
        $cities = new Cities();
        //$cities = $cities->SetConnection('mysql2');
        $cities = $cities->where('status', 1)->whereIn('state_id', array(2723, 2724, 2725, 2726, 2727, 2728, 2729))->get();
        return view('Sales.jobTrackingSheet', compact('customer', 'region', 'survey', 'cities'));
    }

    public function createCreditSaleVoucherForm()
    {
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $accounts = new Account;
        $accounts = $accounts::orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')
            ->where('code', 'like', '5%')
            ->get();
        $categories = new Category;
        $categories = $categories::where('status', '=', '1')->get();
        $Customers = new Customer;
        $Customers = $Customers::where('status', '=', '1')->where('customer_type', '=', '3')->get();
        CommonHelper::reconnectMasterDatabase();
        return view('Sales.createCreditSaleVoucherForm', compact('accounts', 'categories', 'Customers'));
    }

    public function createCashSaleVoucherForm()
    {
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $creditAccounts = new Account;
        $creditAccounts = $creditAccounts::orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')
            ->where('code', 'like', '5%')
            ->get();

        $debitAccounts = new Account;
        $debitAccounts = $debitAccounts::orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')
            ->where('code', 'like', '1-3')
            ->get();
        $categories = new Category;
        $categories = $categories::where('status', '=', '1')->get();
        $Customers = new Customer;
        $Customers = $Customers::where('status', '=', '1')->where('customer_type', '=', '2')->get();
        CommonHelper::reconnectMasterDatabase();
        return view('Sales.createCashSaleVoucherForm', compact('creditAccounts', 'debitAccounts', 'categories', 'Customers'));
    }

    public function viewCashSaleVouchersList()
    {
        return view('Sales.viewCashSaleVouchersList');
    }

    public function viewCreditSaleVouchersList()
    {
        return view('Sales.viewCreditSaleVouchersList');
    }
    public function CreateSalesOrder()
    {
        return view('Sales.CreateSalesOrder');
    }

    public function EditSalesOrder($id)
    {


        $sales_order = new Sales_Order();
        $sales_order = $sales_order->SetConnection('mysql2');
        $sales_order = $sales_order->where('id', $id)->first();
        $sales_order_id = $id;

        //        $sales_order_data=new Sales_Order_Data();
        //        $sales_order_data=$sales_order_data->SetConnection('mysql2');
        //        $sales_order_data=$sales_order_data->where('master_id',$id)->get();

        $sales_order_data = DB::Connection('mysql2')->select('select a.id,a.master_id,a.qty,a.rate,a.amount,a.bundles_id,a.desc,
        a.groupby,a.item_id,a.sub_total,a.discount,a.discount_amount,b.product_name,b.rate as bundle_rate,b.amount as bundle_amount
        ,b.discount_percent as b_percent,b.discount_amount as b_dis_amount,b.net_amount as b_net,b.qty as bqty,b.bundle_unit
         from sales_order_data a
        left join
        bundles b
        on
        a.bundles_id=b.id
        where a.master_id="' . $id . '"

        group by a.groupby');

        $BuyerData = CommonHelper::get_single_row('customers', 'id', $sales_order->buyers_id);
        $Addional = DB::Connection('mysql2')->table('addional_expense_sales_order')->where('status', 1)->where('main_id', $id)->get();
        $accounts = new Account();
        $accounts = $accounts->SetConnection('mysql2');
        $accounts = $accounts->where('status', 1)->get();
        return view('Sales.EditSalesOrder', compact('sales_order', 'sales_order_data', 'id', 'BuyerData', 'sales_order_id', 'Addional', 'accounts'));
    }

    public function  ShowAllImages($id)
    {
        $surveyDocs = new SurveyDocument();
        $surveyDocs = $surveyDocs->SetConnection('mysql2');
        $surveyDocs = $surveyDocs->where('status', 1)->where('survey_id', $id)->get();

        return view('Sales.ShowAllImages', compact('surveyDocs'));
    }
    public function  customer_opening_list()
    {
        $data =  DB::Connection('mysql2')->table('customers as a')
            ->select('a.name', 'a.id', 'a.acc_id', DB::raw('sum(b.balance_amount) as bal'))
            ->join('customer_opening_balance as b', 'a.id', '=', 'b.buyer_id')
            ->where('a.status', 1)
            ->groupBy('b.buyer_id')
            ->get();
        return view('Sales.customer_opening_list', compact('data'));
    }


    public function  ShowAllImagesComplaint($id)
    {
        $ComplaintDocs = new ComplaintDocument();
        $ComplaintDocs = $ComplaintDocs->SetConnection('mysql2');
        $ComplaintDocs = $ComplaintDocs->where('status', 1)->where('complaint_id', $id)->get();

        return view('Sales.ShowAllImagesComplaint', compact('ComplaintDocs'));
    }


    public function viewSalesOrderList()
    {
        $currentMonthStartDate = date('Y-m-01');
        $currentMonthEndDate   = date('Y-m-t');
        $sale_order = new Sales_Order();
        $sale_order = $sale_order->SetConnection('mysql2');
        $sale_order = $sale_order->where('status', 1)->whereBetween('so_date', [$currentMonthStartDate, $currentMonthEndDate])->orderBy('id', 'DESC')->get();
        $Customer = DB::Connection('mysql2')->table('customers')->where('status', 1)->get();
        return view('Sales.viewSalesOrderList', compact('sale_order', 'Customer'));
    }
    public  function viewSalesOrderDetail()
    {
        $id = Input::get('id');
        $sales_order = new Sales_Order();
        $sales_order = $sales_order->SetConnection('mysql2');
        $sales_order = $sales_order->where('id', $id)->first();


        $sales_order_data = new Sales_Order_Data();
        $sales_order_data = $sales_order_data->SetConnection('mysql2');
        $sales_order_data =  $sales_order_data->where('master_id', $id)->get();

        $AddionalExpense = DB::Connection('mysql2')->table('addional_expense_sales_order')->where('main_id', $id);

        return view('Sales.AjaxPages.viewSalesOrderDetailNew', compact('sales_order', 'sales_order_data', 'AddionalExpense'));
    }

    public function CreateDeliveryNoteList()
    {
        $currentMonthStartDate = date('Y-m-01');
        $currentMonthEndDate   = date('Y-m-t');
        $sale_order = new Sales_Order();
        $sale_order = $sale_order->SetConnection('mysql2');
        $sale_order = $sale_order->where('status', 1)->where('delivery_note_status', 0)
            ->where('so_status', 4)
            ->whereBetween('so_date', [$currentMonthStartDate, $currentMonthEndDate])->get();
        $Customer = DB::Connection('mysql2')->table('customers')->where('status', 1)->get();
        return view('Sales.CreateDeliveryNoteList', compact('sale_order', 'Customer'));
    }

    public function CreateDeliveryNote()
    {
        $id = Input::get('id');
        $sales_order = new Sales_Order();
        $sales_order = $sales_order->SetConnection('mysql2');
        $sales_order = $sales_order->where('id', $id)->where('delivery_note_status', 0)->first();




        $sale_order_data_other = new Sales_Order_Data();
        $sale_order_data_other = $sale_order_data_other->SetConnection('mysql2');
        $sale_order_data_other_indi = $sale_order_data_other->where('master_id', $id)->where('bundles_id', '=', 0)->get();

        $sale_order_data = DB::Connection('mysql2')->select('select a.id,a.master_id,a.qty,a.rate,a.amount,a.bundles_id,a.groupby,
        a.groupby,a.item_id,a.sub_total,a.tax,a.tax_amount,b.product_name,b.rate as bundle_rate,b.amount as bundle_amount
        ,b.discount_percent as b_percent,b.discount_amount as b_dis_amount,b.net_amount as b_net,b.qty as bqty,b.bundle_unit,a.desc
         from sales_order_data a
        left join
        bundles b
        on
        a.bundles_id=b.id
        where a.master_id="' . $id . '"

        group by a.groupby');

        return view('Sales.CreateDeliveryNote', compact('sales_order', 'sale_order_data', 'sale_order_data_other_indi'));
    }

    public function EditDeliveryNote()
    {
        $id = Input::get('id');

        $delivery_note = new DeliveryNote();
        $delivery_note = $delivery_note->SetConnection('mysql2');
        $delivery_note = $delivery_note->where('id', $id)->where('status', 1)->first();

        //        $delivery_note_data=new DeliveryNoteData();
        //        $delivery_note_data=$delivery_note_data->SetConnection('mysql2');
        //        $delivery_note_data=$delivery_note_data->where('master_id',$id)->get();

        $delivery_note_data = DB::Connection('mysql2')->select('select a.id,a.master_id,a.so_data_id,a.qty,a.rate,a.amount,a.bundles_id,a.warehouse_id,a.batch_code,
        a.item_id,a.discount_percent,a.discount_amount,a.groupby,b.product_name,b.rate as bundle_rate,b.amount as bundle_amount
        ,b.discount_percent as b_percent,b.discount_amount as b_dis_amount,b.net_amount as b_net,b.qty as bqty,b.bundle_unit
         from delivery_note_data a
        left join
        bundles b
        on
        a.bundles_id=b.id
        where a.master_id=' . $id . '
        group by a.groupby');
        //        echo "<pre>";
        //        print_r($delivery_note_data); die();

        $FinalTot = DB::Connection('mysql2')->selectOne('select sum(amount) as amount from delivery_note_data where master_id = ' . $id . '')->amount;


        return view('Sales.EditDeliveryNote', compact('delivery_note', 'delivery_note_data', 'FinalTot'));
    }

    public function editSalesReturn($id)
    {
        echo $id;

        $CreditNote = new CreditNote();
        $CreditNote = $CreditNote->SetConnection('mysql2');
        $CreditNote = $CreditNote->where('id', $id)->where('status', 1)->first();

        $CreditNoteData = new CreditNoteData();
        $CreditNoteData = $CreditNoteData->SetConnection('mysql2');
        $CreditNoteData = $CreditNoteData->where('master_id', $id)->get();

        return view('Sales.editSalesReturn', compact('CreditNote', 'CreditNoteData'));
    }


    public function editImportDocument($id)
    {
        $Master = DB::Connection('mysql2')->table('import_po')->where('status', 1)->where('id', $id)->first();
        $Detail = DB::Connection('mysql2')->table('import_po_data')->where('status', 1)->where('master_id', $id)->orderBy('id', 'ASC')->get();
        $supplier = new Supplier();
        $supplier = $supplier->SetConnection('mysql2');
        $supplier = $supplier->where('status', 1)->select('id', 'name')->get();

        return view('Sales.editImportDocument', compact('Master', 'Detail', 'id', 'supplier'));
    }



    public function viewDeliveryNoteList()
    {
        $currentMonthStartDate = date('Y-m-01');
        $currentMonthEndDate   = date('Y-m-t');
        $delivery_note = new DeliveryNote();
        $delivery_note = $delivery_note->SetConnection('mysql2');
        $delivery_note = $delivery_note->where('status', 1)->whereBetween('gd_date', [$currentMonthStartDate, $currentMonthEndDate])->orderBy('id', 'DESC')->get();
        $Customer = DB::Connection('mysql2')->table('customers')->where('status', 1)->get();

        return view('Sales.viewDeliveryNoteList', compact('delivery_note', 'Customer'));
    }
    public function viewDeliveryNoteListOther()
    {
        $delivery_note = new DeliveryNote();
        $delivery_note = $delivery_note->SetConnection('mysql2');
        $delivery_note = $delivery_note->where('status', 1)->get();

        return view('Sales.viewDeliveryNoteListOther', compact('delivery_note'));
    }


    public  function viewDeliveryNoteDetail($id)
    {

        $delivery_note = new DeliveryNote();
        $delivery_note = $delivery_note->SetConnection('mysql2');
        $delivery_note = $delivery_note->where('id', $id)->first();

        $delivery_note_data_other = new DeliveryNoteData();
        $delivery_note_data_other = $delivery_note_data_other->SetConnection('mysql2');
        $delivery_note_data = $delivery_note_data_other->where('master_id', $id)->get();

        return view('Sales.AjaxPages.viewDeliveryNoteDetail', compact('delivery_note', 'delivery_note_data', 'id'));
    }
    public  function viewDeliveryNoteDetailTwo($id)
    {

        $delivery_note = new DeliveryNote();
        $delivery_note = $delivery_note->SetConnection('mysql2');
        $delivery_note = $delivery_note->where('id', $id)->first();


        $delivery_note_data = DB::Connection('mysql2')->select('select a.id,a.master_id,a.qty,a.rate,a.amount,a.bundles_id,a.desc,
        a.item_id,a.discount_percent,a.discount_amount,b.product_name,b.rate as bundle_rate,b.amount as bundle_amount
        ,b.discount_percent as b_percent,b.discount_amount as b_dis_amount,b.net_amount as b_net,b.qty as bqty,b.bundle_unit
         from delivery_note_data a

        left join
        bundles b
        on
        a.bundles_id=b.id
        where a.master_id="' . $id . '"

        group by a.groupby');
        $delivery_note_data_other = new DeliveryNoteData();
        $delivery_note_data_other = $delivery_note_data_other->SetConnection('mysql2');
        $delivery_note_data_other = $delivery_note_data_other->where('master_id', $id)->get();

        return view('Sales.AjaxPages.viewDeliveryNoteDetailTwo', compact('delivery_note', 'delivery_note_data', 'delivery_note_data_other', 'id'));
    }


    public function CreateSalesTaxInvoiceList()
    {
        $delivery_note = new DeliveryNote();
        $delivery_note = $delivery_note->SetConnection('mysql2');
        $delivery_note = $delivery_note->where('status', 1)->where('sales_tax_invoice', 0)->orderBy('id', 'DESC')->get();
        return view('Sales.CreateSalesTaxInvoiceList', compact('delivery_note'));
    }

    public function createInvoiceForm(Request $request)
    {

        $data = $request->job_order_id;
        $Id = $data[0];
        $data_id = implode(',', $data);

        $joborder = new JobOrder();
        $joborder = $joborder->SetConnection('mysql2');
        $joborder = $joborder->where('status', 1)->where('jo_status', 2)->where('job_order_id', $Id)->select('*')->first();

        $joborderdata = new JobOrderData();
        $joborderdata = $joborderdata->SetConnection('mysql2');
        $joborderdata = $joborderdata->where('status', 1)->whereIn('job_order_id', $data)->select('*')->get();

        // echo '<pre>';
        // print_r($joborderdata);


        $client = new Client();
        $client = $client->SetConnection('mysql2');
        $client = $client->where('status', 1)->get();

        $InvDesc = new InvDesc();
        $InvDesc = $InvDesc->SetConnection('mysql2');
        $InvDesc = $InvDesc->where('status', 1)->get();

        $Account = new Account();
        $Account = $Account->SetConnection('mysql2');
        $Account = $Account->where('status', 1)->orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')
            ->get();


        return view('Sales.createInvoiceForm', compact('Id', 'joborder', 'joborderdata', 'client', 'InvDesc', 'Account', 'data_id'));
    }


    public function createInvoiceFormseprate($id)
    {



        echo 'sas';
    }
    public function editInvoice($Id)
    {
        $EditId = $Id;
        $Invoice = new Invoice();
        $Invoice = $Invoice->SetConnection('mysql2');
        $Invoice = $Invoice->where('status', 1)->where('id', $Id)->select('*')->first();
        $InvoiceData = new InvoiceData();
        $InvoiceData = $InvoiceData->SetConnection('mysql2');
        $InvoiceData = $InvoiceData->where('status', 1)->where('master_id', $Id)->select('*')->get();
        $client = new Client();
        $client = $client->SetConnection('mysql2');
        $client = $client->where('status', 1)->get();
        $InvDesc = new InvDesc();
        $InvDesc = $InvDesc->SetConnection('mysql2');
        $InvDesc = $InvDesc->where('status', 1)->get();
        $Account = new Account();
        $Account = $Account->SetConnection('mysql2');
        $Account = $Account->where('status', 1)->orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')
            ->get();
        return view('Sales.editInvoice', compact('EditId', 'Invoice', 'InvoiceData', 'client', 'InvDesc', 'Account'));
    }


    public function editQuotation($Id)
    {
        $EditId = $Id;
        $Quotation = new Quotation();
        $Quotation = $Quotation->SetConnection('mysql2');
        $Quotation = $Quotation->where('status', 1)->where('id', $Id)->select('*')->first();


        $QuotationData = new Quotation_Data();
        $QuotationData = $QuotationData->SetConnection('mysql2');
        $QuotationData = $QuotationData->where('status', 1)->where('master_id', $Id)->select('*')->get();
        return view('Sales.editQuotation', compact('EditId', 'Quotation', 'QuotationData'));
    }

    public function editClientBranchForm($BranchId)
    {


        $client = new Client();
        $client = $client->SetConnection('mysql2');
        $client = $client->where('status', 1)->get();
        $Branch = new Branch();
        $Branch = $Branch->SetConnection('mysql2');
        $Branch = $Branch->where('id', $BranchId)->where('status', 1)->select('id', 'acc_id', 'client_id', 'branch_name', 'ntn', 'strn', 'address')->first();


        return view('Sales.AjaxPages.editClientBranchForm', compact('Branch', 'client'));
    }



    public function addComplaint()
    {
        $client = new Client();
        $client = $client->SetConnection('mysql2');
        $client = $client->where('status', 1)->get();

        $product = new Product();
        $product = $product->SetConnection('mysql2');
        $product = $product->where('p_status', 1)->select('*')->get();

        return view('Sales.addComplaint', compact('client', 'product'));
    }

    public function createTestForm()
    {
        $supplier = new Supplier();
        $supplier = $supplier->SetConnection('mysql2');
        $supplier = $supplier->where('status', 1)->select('id', 'name')->get();
        return view('Sales.createTestForm', compact('supplier'));
    }

    public function import_payment_process()
    {
        $supplier = new Supplier();
        $supplier = $supplier->SetConnection('mysql2');
        $supplier = $supplier->where('status', 1)->select('id', 'name')->get();
        return view('Sales.import_payment_process', compact('supplier'));
    }

    public function importDocumentList()
    {
        $ImportPo = DB::Connection('mysql2')->table('import_po')->where('status', 1)->get();
        return view('Sales.importDocumentList', compact('ImportPo'));
    }

    public function createCustomerOpeningBalance()
    {
        $Customers = DB::Connection('mysql2')->table('customers')->where('status', 1)->get();
        return view('Sales.createCustomerOpeningBalance', compact('Customers'));
    }

    public function creatVendorOpeningBalance()
    {
        $Supplier = DB::Connection('mysql2')->table('supplier')->where('status', 1)->get();
        return view('Sales.creatVendorOpeningBalance', compact('Supplier'));
    }




    public function complaintList()
    {
        $Complaint = new Complaint();
        $Complaint = $Complaint->SetConnection('mysql2');
        $Complaint = $Complaint->where('status', 1)->get();
        $Client = new Client();
        $Client = $Client->SetConnection('mysql2');
        $Client = $Client->where('status', 1)->select('*')->get();
        $Region = new Region();
        $Region = $Region->SetConnection('mysql2');
        $Region = $Region->where('status', 1)->select('*')->get();

        return view('Sales.complaintList', compact('Complaint', 'Client', 'Region'));
    }

    public function CreateSalesTaxInvoice(Request $request)
    {






        $sale_order_data = new DeliveryNoteData();
        $sale_order_data = $sale_order_data->SetConnection('mysql2');
        $sale_order_data = $sale_order_data->whereIn('master_id', $request->checkbox)->orderBy('id', 'ASC')->get();

        $ids = implode(',', $request->checkbox);

        //        $sale_order_data=DB::Connection('mysql2')->select('select a.id,sum(a.qty)qty,a.rate,a.amount,a.discount_percent,a.master_id,a.so_id,a.so_data_id,
        //        a.gd_no,a.id,a.bundles_id,a.groupby,a.item_id,a.warehouse_id,a.discount_amount,a.batch_code,b.product_name,b.rate as bundle_rate,b.amount as bundle_amount
        //        ,b.discount_percent as b_percent,b.discount_amount as b_dis_amount,b.net_amount as b_net,b.qty as bqty,b.bundle_unit,b.id as bundl
        //        from delivery_note_data  a
        //        left join
        //        bundles b
        //        on
        //        a.bundles_id=b.id
        //        where a.status=1
        //        and a.master_id in ('.$ids.')
        //        group by  a.groupby,
        //        a.so_data_id
        //        ');


        $sale_order_data = DB::Connection('mysql2')->select('select a.item_id,a.groupby,a.id,b.master_id,b.bundles_id,a.id as so_data_id,a.desc,
        b.gd_no,sum(b.qty) as qty,a.master_id as so_id,b.warehouse_id,b.rate,b.tax,c.product_name,c.bundle_unit,c.qty as bqty,
        c.rate as bundle_rate,c.amount as bundle_amount ,c.discount_percent as b_percent,c.discount_amount as b_dis_amount,c.net_amount as b_net

        from sales_order_data  a
        inner join
        delivery_note_data b
        on
        a.id=b.so_data_id
        left join
        bundles c
        on
        a.bundles_id=c.id
        where a.status=1
        and b.status=1

        and b.master_id in (' . $ids . ')
        group by  a.groupby
        ');


        //    echo '<pre>';
        //   print_r($sale_order_data);die;




        //        $sale_order_data=DB::Connection('mysql2')->select('select a.id,a.master_id,a.qty,a.rate,a.amount,a.bundles_id,
        //        a.item_id,a.discount_percent,a.discount_amount,b.product_name,b.rate as bundle_rate,b.amount as bundle_amount
        //        ,b.discount_percent as b_percent,b.discount_amount as b_dis_amount,b.net_amount as b_net,b.qty as bqty,b.bundle_unit
        //         from delivery_note_data a
        //
        //        left join
        //        bundles b
        //        on
        //        a.bundles_id=b.id
        //        where a.master_id in ('.$ids.')
        //        group by a.groupby');
        //   echo '<pre>';
        //   print_r($sale_order_data);die;

        $delivery_note = new DeliveryNote();
        $delivery_note = $delivery_note->SetConnection('mysql2');
        $delivery_not = $delivery_note
            ->where('status', 1)
            ->whereIn('id', $request->checkbox)
            ->select('gd_no', 'gd_date', 'despacth_document_no', 'despacth_document_date', 'so_no', 'so_date', 'master_id')->first();


        $so_id = $delivery_not->master_id;




        $sales_order = new Sales_Order();
        $sales_order = $sales_order->SetConnection('mysql2');
        $sales_order = $sales_order
            ->where('id', $so_id)->first();


        $accounts = new Account();
        $accounts = $accounts->SetConnection('mysql2');
        $accounts = $accounts->where('status', 1)->get();

        return view('Sales.CreateSalesTaxInvoice', compact('sales_order', 'sale_order_data', 'delivery_not', 'accounts', 'ids'));
    }

    public function EditSalesTaxInvoice()
    {
        $id = Input::get('sales_order_id');
        $sales_tax_invoice = new SalesTaxInvoice();
        $sales_tax_invoice = $sales_tax_invoice->SetConnection('mysql2');
        $sales_tax_invoice = $sales_tax_invoice->where('id', $id)->first();

        $sales_tax_invoice_data = new SalesTaxInvoiceData();
        $sales_tax_invoice_data = $sales_tax_invoice_data->SetConnection('mysql2');
        $sales_tax_invoice_data = $sales_tax_invoice_data->where('master_id', $id)->get();

        return view('Sales.EditSalesTaxInvoice', compact('sales_tax_invoice', 'sales_tax_invoice_data'));
    }

    public function viewSalesTaxInvoiceList()
    {

        $currentMonthStartDate = date('Y-m-01');
        $currentMonthEndDate   = date('Y-m-t');

        $sales_tax_invoice = new SalesTaxInvoice();
        $sales_tax_invoice = $sales_tax_invoice->SetConnection('mysql2');
        $sales_tax_invoice = $sales_tax_invoice->where('status', 1)->whereBetween('gi_date', [$currentMonthStartDate, $currentMonthEndDate])->get();
        $Customer = DB::Connection('mysql2')->table('customers')->where('status', 1)->get();

        return view('Sales.viewSalesTaxInvoiceList', compact('sales_tax_invoice', 'Customer'));
    }

    public  function viewSalesTaxInvoiceDetail()
    {
        $ID = Input::get('id');
        $Checking = $ID;
        $Checking = explode(',', $Checking);
        if (count($Checking) > 1) {
            $si = DB::Connection('mysql2')->table('sales_tax_invoice')->where('gi_no', $Checking[1])->select('id')->first();
            $id = $si->id;
        } else {
            $id = $Checking[0];
        }
        $sales_tax_invoice = new SalesTaxInvoice();
        $sales_tax_invoice = $sales_tax_invoice->SetConnection('mysql2');
        $sales_tax_invoice = $sales_tax_invoice->where('id', $id)->first();



        $sales_tax_invoice_data = DB::Connection('mysql2')->select('select a.item_id,a.qty,a.rate,a.tax as tax ,a.tax_amount,a.amount,a.gd_no,a.bundles_id,a.so_data_id,
        a.description,b.rate as bundle_rate, b.amount as bundle_amount , b.discount_percent as b_percent, b.discount_amount as b_dis_amount, b.net_amount as b_net, b.product_name, b.qty as bqty
        ,b.bundle_unit,a.so_type,a.dn_data_ids
        from sales_tax_invoice_data  a
        left join
        bundles b
        on
        a.bundles_id=b.id
        where a.status=1
        and a.master_id  ="' . $id . '"
        group by  a.groupby
        ');



        $AddionalExpense = DB::Connection('mysql2')->table('addional_expense_sales_tax_invoice')->where('main_id', $id);
        $sales_tax_invoice_data_other = DB::Connection('mysql2')->table('sales_tax_invoice_data')->where('master_id', $id)->get();

        return view('Sales.AjaxPages.viewSalesTaxInvoiceDetail', compact('sales_tax_invoice', 'sales_tax_invoice_data', 'AddionalExpense', 'sales_tax_invoice_data_other'));
    }

    public  function viewReceivedAllVoucher()
    {
        $id = Input::get('id');
        $AllReceipt = DB::Connection('mysql2')->table('received_paymet')->where('status', 1)->where('sales_tax_invoice_id', $id)->get();
        return view('Sales.viewReceivedAllVoucher', compact('AllReceipt'));
    }

    public  function PrintSalesTaxInvoice()
    {
        $id = Input::get('id');
        $sales_tax_invoice = new SalesTaxInvoice();
        $sales_tax_invoice = $sales_tax_invoice->SetConnection('mysql2');
        $sales_tax_invoice = $sales_tax_invoice->where('id', $id)->first();

        //        $sales_tax_invoice_data=new SalesTaxInvoiceData();
        //        $sales_tax_invoice_data=$sales_tax_invoice_data->SetConnection('mysql2');
        //        $sales_tax_invoice_data=$sales_tax_invoice_data->where('master_id',$id)->get();


        $sales_tax_invoice_data = DB::Connection('mysql2')->select('select a.item_id,a.qty,a.rate,a.discount as discount_percent ,a.discount_amount,a.amount,a.gd_no,a.bundles_id,a.so_data_id,
        a.description,b.rate as bundle_rate, b.amount as bundle_amount , b.discount_percent as b_percent, b.discount_amount as b_dis_amount, b.net_amount as b_net, b.product_name, b.qty as bqty
        ,b.bundle_unit,a.so_type
        from sales_tax_invoice_data  a
        left join
        bundles b
        on
        a.bundles_id=b.id
        where a.status=1
        and a.master_id  ="' . $id . '"
        group by  a.groupby
        ');



        $AddionalExpense = DB::Connection('mysql2')->table('addional_expense_sales_tax_invoice')->where('main_id', $id);

        return view('Sales.AjaxPages.PrintSalesTaxInvoice', compact('sales_tax_invoice', 'sales_tax_invoice_data', 'AddionalExpense'));
    }


    public  function PrintSalesTaxInvoiceDirect()
    {
        $id = Input::get('id');
        $sales_tax_invoice = new SalesTaxInvoice();
        $sales_tax_invoice = $sales_tax_invoice->SetConnection('mysql2');
        $sales_tax_invoice = $sales_tax_invoice->where('id', $id)->first();

        //        $sales_tax_invoice_data=new SalesTaxInvoiceData();
        //        $sales_tax_invoice_data=$sales_tax_invoice_data->SetConnection('mysql2');
        //        $sales_tax_invoice_data=$sales_tax_invoice_data->where('master_id',$id)->get();


        $sales_tax_invoice_data = DB::Connection('mysql2')->select('select a.item_id,a.qty,a.rate,a.discount as discount_percent ,a.discount_amount,a.amount,a.gd_no,a.bundles_id,a.so_data_id,
        a.description,b.rate as bundle_rate, b.amount as bundle_amount , b.discount_percent as b_percent, b.discount_amount as b_dis_amount, b.net_amount as b_net, b.product_name, b.qty as bqty
        ,b.bundle_unit,a.so_type
        from sales_tax_invoice_data  a
        left join
        bundles b
        on
        a.bundles_id=b.id
        where a.status=1
        and a.master_id  ="' . $id . '"
        group by  a.groupby
        ');



        $AddionalExpense = DB::Connection('mysql2')->table('addional_expense_sales_tax_invoice')->where('main_id', $id);

        return view('Sales.AjaxPages.PrintSalesTaxInvoiceDirect', compact('sales_tax_invoice', 'sales_tax_invoice_data', 'AddionalExpense'));
    }

    public function CreateReceiptVoucherList()
    {
        $Customer = DB::Connection('mysql2')->table('customers')->where('status', 1)->get();
        // Changed from sales_tax_invoice to commercial_invoices
        $CommercialInvoices = DB::Connection('mysql2')->table('commercial_invoices')->where('status', 1)->get();

        return view('Sales.CreateReceiptVoucherList', compact('Customer', 'CommercialInvoices'));
    }
    public function receiptVoucherList()
    {
        $currentMonthStartDate = date('Y-m-01');
        $currentMonthEndDate   = date('Y-m-t');
        $accounts = new Account;
        $accounts = $accounts->SetConnection('mysql2');
        $accounts = $accounts->where('status', 1)->select('id', 'name', 'code')->orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')
            ->get();

        $NewRvs = new NewRvs();
        $NewRvs = $NewRvs->SetConnection('mysql2');
        $NewRvs = $NewRvs->where('status', 1)->where('sales', 1)->whereBetween('rv_date', [$currentMonthStartDate, $currentMonthEndDate])->orderBy('id', 'DESC')->get();
        CommonHelper::reconnectMasterDatabase();
        return view('Sales.receiptVoucherList', compact('NewRvs', 'accounts'));
    }

    public function editVoucherList()
    {
        $id = $_GET['id'];
        
        // Check if this is a commercial invoice receipt
        $brige_table_check = DB::Connection('mysql2')->table('brige_table_sales_receipt')
            ->where('status', 1)
            ->where('rv_id', '=', $id)
            ->first();
        
        // If it has commercial_invoice_id, redirect to commercial invoice receipt edit
        if ($brige_table_check && isset($brige_table_check->commercial_invoice_id) && $brige_table_check->commercial_invoice_id) {
            return redirect()->route('editCommercialInvoiceReceipt', ['id' => $id, 'm' => $_GET['m']]);
        }
        
        $accounts = new Account;
        $accounts = $accounts->SetConnection('mysql2');
        $accounts = $accounts->where('status', 1)->select('id', 'name', 'code')->orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')
            ->get();

        $NewRvs = new NewRvs();
        $NewRvs = $NewRvs->SetConnection('mysql2');
        $NewRvs = $NewRvs->where('status', 1)->where('sales', 1)->where('id', $id)->first();

        $NewRvsData = DB::Connection('mysql2')->table('new_rv_data')->where('status', 1)->where('master_id', '=', $id)->get();
        $brige_table = DB::Connection('mysql2')->table('brige_table_sales_receipt')->where('status', 1)->where('rv_id', '=', $id)->get();

        return view('Sales.editVoucherList', compact('NewRvs', 'NewRvsData', 'brige_table', 'accounts', 'id'));
    }

    public function undertaking()
    {

        $id = Input::get('id');
        $sales_tax_invoice = new SalesTaxInvoice();
        $sales_tax_invoice = $sales_tax_invoice->SetConnection('mysql2');
        $sales_tax_invoice = $sales_tax_invoice->where('id', $id)->first();

        return view('Sales.undertaking', compact('sales_tax_invoice'));
    }
    public function CreateCustomerCreditNote()
    {
        $sales_tax_invoice = new SalesTaxInvoice();
        $sales_tax_invoice = $sales_tax_invoice->SetConnection('mysql2');
        $sales_tax_invoice = $sales_tax_invoice->where('status', 1)->get();
        return view('Sales.CreateCustomerCreditNote', compact('sales_tax_invoice'));
    }

    public function addCustomerCredit_no(Request $request)
    {
        $values = $request->checkbox;
        $buyer_id = $request->buyer_id;
        $type = $request->type;
        return view('Sales.addCustomerCredit_no', compact('values', 'buyer_id', 'type'));
    }

    public function viewCustomerCreditNoteList()
    {
        $currentMonthStartDate = date('Y-m-01');
        $currentMonthEndDate   = date('Y-m-t');

        $credit_note = new CreditNote();
        $credit_note = $credit_note->SetConnection('mysql2');
        $credit_note = $credit_note->where('status', 1)->whereBetween('cr_date', [$currentMonthStartDate, $currentMonthEndDate])->orderBy('id', 'DESC')->get();
        return view('Sales.viewCustomerCreditNoteList', compact('credit_note'));
    }

    public  function viewCreditNoteDetail()
    {
        $id = Input::get('id');
        $creit_note = new CreditNote();
        $creit_note = $creit_note->SetConnection('mysql2');
        $creit_note = $creit_note->where('id', $id)->first();

        $credit_note_data = new CreditNoteData();
        $credit_note_data = $credit_note_data->SetConnection('mysql2');
        $credit_note_data = $credit_note_data->where('master_id', $id)->get();

        return view('Sales.AjaxPages.viewCreditNoteDetail', compact('creit_note', 'credit_note_data'));
    }

    public function createType()
    {
        return view('Sales.createType');
    }

    public function createConditions()
    {
        return view('Sales.createConditions');
    }

    public function createSurveyBy()
    {
        return view('Sales.createSurveyBy');
    }

    public function typeList()
    {
        $type = new Type();
        $type = $type->SetConnection('mysql2');
        $type = $type->where('status', 1)->get();

        return view('Sales.typeList', compact('type'));
    }

    public function conditionList()
    {
        $conditions = new Conditions();
        $conditions = $conditions->SetConnection('mysql2');
        $conditions = $conditions->where('status', 1)->get();

        return view('Sales.conditionList', compact('conditions'));
    }

    public function clientJobList()
    {
        $ClientJob = new ClientJob();
        $ClientJob = $ClientJob->SetConnection('mysql2');
        $ClientJob = $ClientJob->where('status', 1)->get();

        return view('Sales.clientJobList', compact('ClientJob'));
    }


    public function branchList()
    {
        $survery_by = new SurveryBy();
        $survery_by = $survery_by->SetConnection('mysql2');
        $survery_by = $survery_by->where('status', 1)->get();

        return view('Sales.branchList', compact('survery_by'));
    }

    public function surveylist()
    {
        $survey = new Survey();
        $survey = $survey->SetConnection('mysql2');
        $survey = $survey->where('status', 1)->get();
        $Client = new Client();
        $Client = $Client->SetConnection('mysql2');
        $Client = $Client->where('status', 1)->select('*')->get();
        $Region = new Region();
        $Region = $Region->SetConnection('mysql2');
        $Region = $Region->where('status', 1)->select('*')->get();

        return view('Sales.surveylist', compact('survey', 'Client', 'Region'));
    }

    public function jobtrackinglist()
    {
        $jobtracking = new JobTracking();
        $jobtracking = $jobtracking->SetConnection('mysql2');
        $jobtracking = $jobtracking->where('status', 1)->get();

        return view('Sales.jobtrackinglist', compact('jobtracking'));
    }

    public function addquotationForm()
    {
        $survey = new Survey();
        $survey = $survey->SetConnection('mysql2');
        $survey = $survey->where('status', 1)->where('survey_status', 2)->where('quotation_type', 0)->get();
        return view('Sales.addquotationForm', compact('survey'));
    }
    public function quotationList()
    {
        $quotation = new Quotation();
        $quotation = $quotation->SetConnection('mysql2');
        $quotation = $quotation->where('status', 1)->get();
        $Client = new Client();
        $Client = $Client->SetConnection('mysql2');
        $Client = $Client->where('status', 1)->select('*')->get();
        $Region = new Region();
        $Region = $Region->SetConnection('mysql2');
        $Region = $Region->where('status', 1)->select('*')->get();
        return view('Sales.quotationList', compact('quotation', 'Client', 'Region'));
    }

    public function invoiceList()
    {
        $invoice = new Invoice();
        $invoice = $invoice->SetConnection('mysql2');
        $invoice = $invoice->where('status', 1)->where('type', 0)->orderBy('id', 'DESC')->get()->take(50);

        $Client = new Client();
        $Client = $Client->SetConnection('mysql2');
        $Client = $Client->where('status', 1)->get();


        return view('Sales.invoiceList', compact('invoice', 'Client'));
    }




    public function addClient()
    {
        return view('Sales.addClient');
    }

    public function createBranch()
    {
        $Client = new Client();
        $Client = $Client->SetConnection('mysql2');
        $Client = $Client->where('status', 1)->get();
        return view('Sales.createBranch', compact('Client'));
    }

    public function addDesc()
    {
        return view('Sales.addDesc');
    }
    public function invoiceDescList()
    {

        $InvDesc = new InvDesc();
        $InvDesc = $InvDesc->SetConnection('mysql2');
        $InvDesc = $InvDesc->where('status', 1)->get();
        return view('Sales.invoiceDescList', compact('InvDesc'));
    }



    public function addClientJob()
    {
        return view('Sales.addClientJob');
    }

    public function addClientJobAjax()
    {
        return view('Sales.addClientJobAjax');
    }
    public function addBranchAjax()
    {
        $Client = new Client();
        $Client = $Client->SetConnection('mysql2');
        $Client = $Client->where('status', 1)->get();
        return view('Sales.addBranchAjax', compact('Client'));
    }


    public function clientList()
    {

        $client = new Client();
        $client = $client->SetConnection('mysql2');
        $client = $client->where('status', 1)->get();


        $Account = new Account();
        $Account = $Account->SetConnection('mysql2');
        $Account = $Account->orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')
            ->get();

        return view('Sales.clientList', compact('client', 'Account'));
    }

    public function clientBranchList()
    {

        $Branch = new Branch();
        $Branch = $Branch->SetConnection('mysql2');
        $Branch = $Branch->where('status', 1)->get();

        return view('Sales.clientBranchList', compact('Branch'));
    }


    public function jobTrackingSheetCopy()
    {
        $customer = new Customer();
        $customer = $customer->SetConnection('mysql2');
        $customer = $customer->where('status', 1)->get();
        $region = new Region();
        $region = $region->SetConnection('mysql2');
        $region = $region->where('status', 1)->get();
        $survey = new Survey();
        $survey = $survey->SetConnection('mysql2');
        $survey = $survey->where('status', 1)->get();
        $cities = new Cities();
        //$cities = $cities->SetConnection('mysql2');
        $cities = $cities->where('status', 1)->get();
        return view('Sales.jobTrackingSheetCopy', compact('customer', 'region', 'survey', 'cities'));
    }

    public function createProductType()
    {
        return view('Sales.createProductType');
    }

    public function createResourceAssigned()
    {
        return view('Sales.createResourceAssigned');
    }

    public function producttypeList()
    {
        $productType = new  ProductType();
        $productType = $productType->SetConnection('mysql2');
        $productType = $productType->where('status', 1)->get();
        return view('Sales.producttypeList', compact('productType'));
    }

    public function resourceAssignedList()
    {
        $resourceAssign = new  ResourceAssigned();
        $resourceAssign = $resourceAssign->SetConnection('mysql2');
        $resourceAssign = $resourceAssign->where('status', 1)->get();
        return view('Sales.resourceAssignedList', compact('resourceAssign'));
    }
    public function createInvoice()
    {
        $joborder = new JobOrder();
        $joborder = $joborder->SetConnection('mysql2');
        $joborder = $joborder->where('status', 1)->where('jo_status', 2)->where('invoice_created', 0)->select('*')->get();
        $client = new Client();
        $client = $client->SetConnection('mysql2');
        $client = $client->where('status', 1)->get();
        return view('Sales.createInvoice', compact('joborder', 'client'));
    }

    public function logActivity()
    {
        return view('Sales.logActivity');
    }
    public function CreateSalesTaxInvoiceBySO(Request $request)

    {
        $so_no = $request->so_no;
        $delivery_note = new DeliveryNote();
        $delivery_note = $delivery_note->SetConnection('mysql2');
        $delivery_note = $delivery_note->where('status', 1)->where('sales_tax_invoice', 0)->where('so_no', $so_no)->get();

        return view('Sales.AjaxPages.CreateSalesTaxInvoiceBySO', compact('delivery_note'));
    }

    public function dn_without_Sales(Request $request)

    {


        return view('Sales.dn_without_Sales');
    }
    public function salesTaxInvoiceReportPage()
    {
        return view('Sales.salesTaxInvoiceReportPage');
    }

    public function cogs_si(Request $request)
    {
        return view('Sales.cogs_si');
    }
    public function pos_list(Request $request)
    {

        return view('Sales.pos_list');
    }

    public function po_detail(Request $request)
    {
        $id = $request->id;
        return view('Sales.AjaxPages.po_detail', compact('id'));
    }
    public function view_convert_grn(Request $request)
    {
        $id = $request->id;
        return view('Sales.view_convert_grn', compact('id'));
    }


    public function approve_so(Request $request)
    {
        $id = $request->id;
        $so_status = 0;
        $approve_user = '';
        $approve = '';
        $send_behavior = '';
        $so_data =   DB::Connection('mysql2')->table('sales_order')->where('id', $id)->first();
        $so_no = $so_data->so_no;
        $dept_id = $so_data->department;
        $p_type = $so_data->p_type;

        if ($so_data->approve_user_1 == '') :
            $so_status = 2;
            $approve_user = 'approve_user_1';
            $approve = '1st Approved';
            $send_behavior = 'Approve 1';
        elseif ($so_data->approve_user_2 == '') :
            $so_status = 3;
            $approve_user = 'approve_user_2';
            $approve = '2nd Approved';
            $send_behavior = 'Approve 2';
        elseif ($so_data->approve_user_3 == '') :
            $so_status = 4;
            $approve_user = 'approve_user_3';
            $approve = 'Approved';
            $send_behavior = 'Approve 3';
        endif;

        DB::Connection('mysql2')->table('sales_order')
            ->where('id', $id)
            ->update([$approve_user => Auth::user()->name, 'so_status' =>  $so_status]);



        $voucher_no = $so_no;
        $subject = 'Sales Order Approve For ' . $so_no;
        // NotificationHelper::send_email('Sales Order',$send_behavior,$dept_id,$voucher_no,$subject,$p_type);

        echo $approve;
    }


    public static function si_approve(Request $request)
    {
        $id =  $request->id;
        $approve = '';
        $behavior = '';
        $si_data =   DB::Connection('mysql2')->table('sales_tax_invoice')->where('id', $id)->first();

        $so_type = $si_data->si_status;
        $gi_no = $si_data->gi_no;
        $so_id = $si_data->so_id;
        $so_no = $si_data->so_no;

        if ($so_type == 1) :
            DB::Connection('mysql2')->table('sales_tax_invoice')
                ->where('id', $id)
                ->update(['approve_user_1' => Auth::user()->name, 'si_status' =>  2]);
            $approve = '1st Approved';
            $behavior = 'Approve 1';
        else :
            DB::Connection('mysql2')->table('sales_tax_invoice')
                ->where('id', $id)
                ->update(['approve_user_2' => Auth::user()->name, 'si_status' =>  3]);


            DB::Connection('mysql2')->table('transactions')
                ->where('voucher_no', $gi_no)
                ->where('status', 100)
                ->update(['status' => 1]);
            $approve = 'Approved';
            $behavior = 'Approve 2';
        endif;

        $voucher_no = $gi_no;
        $dept_and_type = NotificationHelper::get_dept_id('sales_order', 'id', $so_id)->select('department', 'p_type')->first();
        $dept_id = $dept_and_type->department;
        $p_type = $dept_and_type->p_type;
        $subject = 'Sales Tax Invoice Approved For ' . $so_no;
        //  NotificationHelper::send_email('Sales tax Invoice',$behavior, $dept_id,$voucher_no,$subject,$p_type);

        return $approve;
    }

    // Sale order 



    // gate pass in / Sale order 
    public function createGatepassIn(Request $request)
    {

        return view('Sales/createGatepassIn');
    }

    public function listGatepassin(Request $request)
    {

        return view('Sales/listGatepassin');
    }


    // weighbridge / Sale order 
    public function createWeighbridge(Request $request)
    {

        return view('Sales/createWeighbridge');
    }

    public function listWeighbridge(Request $request)
    {

        return view('Sales/listWeighbridge');
    }

    // second weighbridge / Sale order  

    public function createSecondWeighbridge(Request $request)
    {
        return view('Sales/createSecondWeighbridge');
    }

    public function listSecondWeighbridge(Request $request)
    {
        return view('Sales/listSecondWeighbridge');
    }


    // gatepass out / Sale order 
    public function createGatepassout(Request $request)
    {
        return view('Sales/createGatepassout');
    }

    public function listGatepassout(Request $request)
    {
        return view('Sales/listGatepassout');
    }
}
