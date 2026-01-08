<?php

namespace App\Http\Controllers;

use App\CompanyLocation;
use App\Models\Issuance;
use App\Models\IssuanceData;
use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use App\Helpers\ReuseableCode;
use App\Models\Account;
use App\Models\PurchaseVoucher;
use App\Models\Countries;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Department;
use App\Models\PurchaseRequestData;
use App\Models\FinanceDepartment;
use App\Models\UOM;
use App\Models\PurchaseVoucherData;
use App\Models\DemandType;
use App\Models\Warehouse;
use App\Models\GoodsReceiptNote;
use App\Models\Subitem;
use App\Models\Demand;
use App\Models\DemandData;
use App\Models\GRNData;
use App\Models\JobOrder;
use App\Models\JobOrderData;
use App\Models\Product;
use App\Models\Type;
use App\Models\Conditions;
use App\Models\Survey;
use App\Models\SurveyData;
use App\Models\SurveyDocument;
use App\Models\Quotation;
use App\Models\JobOrderDocument;
use App\Models\Client;
use App\Models\Region;
use App\Models\ClientJob;
use App\Models\NewPurchaseVoucher;
use App\Models\Cluster;
use App\Models\SubDepartment;
use App\Models\TempGrn;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseController extends Controller
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
   	public function toDayActivity(){
   		return view('Purchase.toDayActivity');
    }
    public function testReportPage(){
        return view('Purchase.testReportPage');
    }
    public function add_another_data_page(){
        $Data = DB::Connection('mysql2')->select('SELECT a.* FROM `sales_tax_invoice_data` a
                                        INNER JOIN sales_tax_invoice b ON b.id = a.master_id
                                        WHERE b.status = 1
                                        and a.dn_data_ids != 0
                                        GROUP BY dn_data_ids');
        return view('Purchase.add_another_data_page',compact('Data'));
    }




    
//Dashboard
    public function inventory_page(){
        return view('dashboard.inventory_page');
    }
    public function purchase_page(){
        return view('dashboard.purchase_page');
    }
    public function sales_page(){
        return view('dashboard.sales_page');
    }


    //Dashboard
    public function purchaseDetailReportPage(){
        $company_locations = ReuseableCode::getUserWiseLocationRightsData();
        // dd($company_locations);
        // $company_locations = CompanyLocation::whereIn('id', $company_locations)->get()->toArray();
        return view('Purchase.purchaseDetailReportPage', compact('company_locations'));
    }
    public function vendor_balance_page(){
        return view('Purchase.vendor_balance_page');
    }

    public function viewAgingReportPage(){
        $Supplier = DB::Connection('mysql2')->table('supplier')->where('status',1)->get();
        return view('Purchase.viewAgingReportPage',compact('Supplier'));
    }

    public function purchaseInvoiceReportPage(){
        return view('Purchase.purchaseInvoiceReportPage');
    }

    public function aqmsStockReportPage(){

        return view('Purchase.aqmsStockReportPage');
    }

    public function in_stock_recon(){
        return view('Purchase.in_stock_recon');
    }
    public function detailReportPage(){
        return view('Purchase.detailReportPage');
    }

    public function poTrackingPage(){
        $PoNo = DB::Connection('mysql2')->table('purchase_request')->where('status',1)->select('purchase_request_no','id')->get();
        return view('Purchase.poTrackingPage',compact('PoNo'));
    }


    public function job_order_next_step(Request $request){

        $master_id=$request->session()->get('master_id');
        $region_id=$request->session()->get('region_id');
        $m=$request->session()->get('m');
        return view('Purchase.AjaxPages.job_order_next_step', compact('master_id','m','type','region_id'));
    }

    public function opening_stock_report(Request $request)
    {
        $Category = new Category();
        $Category = $Category->SetConnection('mysql2')->where('status',1)->get();
        $Region = new Region();
        $Region = $Region->SetConnection('mysql2')->where('status',1)->get();

        return view('Purchase.opening_stock_report',compact('Category','Region'));
    }

    public function ItemWiseReport(Request $request)
    {
        //echo ""; die;
        $data = new Subitem();
        $data = $data->SetConnection('mysql2')->where('status',1)->get();
        $Region = new Region();
        $Region = $Region->SetConnection('mysql2')->where('status',1)->get();

        return view('Purchase.ItemWiseReport',compact('data','Region'));
    }

    public function job_order_next_step_edit(Request $request)
    {
        $master_id=$request->session()->get('master_id');
        $region_id=$request->session()->get('region_id');
        $m=$request->session()->get('m');
        return view('Purchase.AjaxPages.job_order_next_step_edit', compact('master_id','m','type','region_id'));
    }
    public function poReportPage()
    {
        return view('Purchase.poReportPage');
    }

    public function createstockreturn(){
        return view('Purchase.createstockreturn');
    }

    public function addSurveyForm(){
        $product = new Product();
        $product = $product->SetConnection('mysql2');
        $product = $product->where('p_status',1)->select('*')->get();
        $type = new Type();
        $type = $type->SetConnection('mysql2');
        $type = $type->where('status',1)->get();
        $conditions = new Conditions();
        $conditions = $conditions->SetConnection('mysql2');
        $conditions = $conditions->where('status',1)->get();
        return view('Purchase.addSurveyForm',compact('product','type','conditions'));
    }


    public function  ShowAllImages($id)
    {
        $jobOrderDocs = new JobOrderDocument();
        $jobOrderDocs = $jobOrderDocs->SetConnection('mysql2');
        $jobOrderDocs = $jobOrderDocs->where('status',1)->where('job_order_id',$id)->get();

        return view('Purchase.ShowAllImages',compact('jobOrderDocs'));
    }


    public function createSupplierForm(){
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
            ->where('status',1)
            ->get();
        return view('Purchase.createSupplierForm',compact('accounts','countries'));
    }
    public function importSupplierForm(){
        return view('Purchase.importSupplierForm');
    }

    public function viewSupplierList(){
        return view('Purchase.viewSupplierList');
    }
    public function createPurchaseVoucherForm()

    {

        $supplier=new Supplier();
        $supplier=$supplier->SetConnection('mysql2');
        $supplier=$supplier->where('status',1)->select('id','name')->get();
        $department=[];
        // new FinanceDepartment();
        // $department=$department->SetConnection('mysql2');
        // $department=$department->where('status',1)->select('id','name','code')
        //         ->orderBy('level1', 'ASC')
        //         ->orderBy('level2', 'ASC')
        //         ->orderBy('level3', 'ASC')
        //         ->orderBy('level4', 'ASC')
        //         ->orderBy('level5', 'ASC')
        //         ->get();


        return view('Purchase.createPurchaseVoucherForm',compact('supplier','department'));
    }

    public function editSubItemForm(){

         $id=$_GET['id'];

        // get uom
        $uom = new UOM;
        $uom = $uom->where('status','=','1')->select('uom_name','id')->get();

        // get category
        $categories = new Category;
        $categories=$categories->SetConnection('mysql2');
        $categories = $categories->where('status','=','1')->select('main_ic','id')->get();


        // get demand type

        $demand_type=new DemandType();
        $demand_type=$demand_type->SetConnection('mysql2');
        $demand_type=$demand_type->where('status',1)->select('name','id')->get();


        // get sub item
        $sub_item=new Subitem();
        $sub_item=$sub_item->SetConnection('mysql2');
        $sub_item=$sub_item->where('status',1)->where('id',$id)->select('*')->first();

        return view('Purchase.AjaxPages.editSubItemForm',compact('categories','uom','sub_item','demand_type','id'));
    }
    public function editSupplierForm($id){

        $countries = new Countries;
        $countries = $countries::where('status', '=', 1)->get();
       // CommonHelper::companyDatabaseConnection($_GET['m']);
       // $accounts = new Account;
      //  $accounts = $accounts::orderBy('level1', 'ASC')
        //    ->orderBy('level2', 'ASC')
        //    ->orderBy('level3', 'ASC')
         //   ->orderBy('level4', 'ASC')
         //   ->orderBy('level5', 'ASC')
         //   ->orderBy('level6', 'ASC')
          //  ->orderBy('level7', 'ASC')
          //  ->where('parent_code','like','2-1%')
          //  ->get();
        return view('Purchase.AjaxPages.editSupplierForm',compact('countries','id'));
    }

    public function viewSupplierDetail(){
        return view('Purchase.AjaxPages.viewSupplierDetail');
    }

    public function exportexcel(){
       $records = DB::connection('mysql2')->table('supplier')
        ->leftJoin('supplier_info', 'supplier.id', '=', 'supplier_info.supp_id')
        ->select([
            'supplier.vendor_code',
            'supplier.name',
            'supplier.company_name',
            'supplier.address',
            'supplier.contact_person',
            'supplier.mobile_no',
            'supplier.work_phone',
            'supplier.ntn',
            'supplier.strn',
            'supplier.terms_of_payment',
            'supplier_info.contact_person',
            'supplier_info.contact_no',
            'supplier_info.fax',
            'supplier_info.address',
            'supplier_info.work_phone'
        ])
        ->get();
        

        // Prepare export data with header
        $data = [];

        if ($records->isNotEmpty()) {
            $data[] = array_keys((array) $records[0]); // header
            foreach ($records as $row) {
                $data[] = array_values((array) $row);
            }
        }

        return Excel::download(new class($data) implements FromArray {
            protected $data;
            public function __construct(array $data) { $this->data = $data; }
            public function array(): array { return $this->data; }
        }, 'all_suppliers.xlsx');
    }

    public function createCategoryForm(){
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
        return view('Purchase.createCategoryForm',compact('accounts'));
    }

    //Abdul
    public function createSubCategoryForm(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $categories = new Category;
        $categories = $categories::get();
        CommonHelper::reconnectMasterDatabase();
        return view('Purchase.createSubCategoryForm',compact('categories'));
    }
    //ABdul



    public function viewCategoryList(){
        return view('Purchase.viewCategoryList');
    }

    public function addRegionForm(){
        $Cluster=new Cluster();
        $Cluster=$Cluster->SetConnection('mysql2');
        $Cluster=$Cluster->where('status',1)->get();

        return view('Purchase.addRegionForm',compact('Cluster'));
    }

    public function regionList(){
        return view('Purchase.regionList');
    }

    public function addCluster(){
        return view('Purchase.addCluster');
    }

    public function clusterList(){
        $Cluster=new Cluster();
        $Cluster=$Cluster->SetConnection('mysql2');
        $Cluster=$Cluster->where('status',1)->get();
        return view('Purchase.clusterList',compact('Cluster'));
    }




    public function viewCategoryDetail(){
        return view('Purchase.AjaxPages.viewCategoryDetail');
    }

    public function editCategoryForm(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $accounts = new Account;
        $accounts = $accounts::orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')
            ->where('code','=','1-2')
            ->get();
        return view('Purchase.AjaxPages.editCategoryForm',compact('accounts'));
    }

    public function editPurchaseVoucherForm($id)
    {
        $supplier=new Supplier();
        $supplier=$supplier->SetConnection('mysql2');
        $supplier=$supplier->where('status',1)->select('id','name')->get();
        $department=new FinanceDepartment();
        $department=$department->SetConnection('mysql2');
        $department=$department->where('status',1)->select('id','name','code')
            ->orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->get();

        $purchase_voucher=new PurchaseVoucher();
        $purchase_voucher=$purchase_voucher->SetConnection('mysql2');
        $purchase_voucher=$purchase_voucher->where('id',$id)->select('pv_no','pv_date','slip_no','purchase_date','purchase_type'
            ,'due_date','supplier','description','currency','total_net_amount','amount_in_words')->first();


        $purchase_voucher_data=new PurchaseVoucherData();
        $purchase_voucher_data=$purchase_voucher_data->SetConnection('mysql2');
        $purchase_voucher_data=$purchase_voucher_data->where('master_id',$id)->select('id','pv_no','category_id','sub_item','uom','qty'
            ,'rate','amount','sales_tax_per','sales_tax_amount','net_amount','txt_nature','income_txt_nature')->orderBy('id','ASC')->get();

        $type=0;

        return view('Purchase.editPurchaseVoucherForm',compact('supplier','department','purchase_voucher','id','purchase_voucher_data','type'));
    }

    public function editJobOrder($id)
    {
        $JobOrder=new JobOrder();
        $JobOrder=$JobOrder->SetConnection('mysql2');
        $JobOrder=$JobOrder->where('status',1)->where('job_order_id',$id)->first();
        $uom = new UOM;
        $uom = $uom->where('status','=','1')->select('uom_name','id')->get();

        $JobOrderData=new JobOrderData();
        $JobOrderData=$JobOrderData->SetConnection('mysql2');
        $JobOrderData=$JobOrderData->where('status',1)->where('job_order_id',$id)->get();

        $JobOrderDocument = new JobOrderDocument();
        $JobOrderDocument = $JobOrderDocument->SetConnection('mysql2');
        $JobOrderDocument = $JobOrderDocument->where('status',1)->where('job_order_id',$id)->get();
        $EditId=$id;

        return view('Purchase.editJobOrder',compact('JobOrder','uom','JobOrderData','EditId','JobOrderDocument'));
    }

    public function editSurvey($id)

    {

        $Survey=new Survey();
        $Survey=$Survey->SetConnection('mysql2');
        $Survey=$Survey->where('status',1)->where('survey_id',$id)->first();

        $SurveyData=new SurveyData();
        $SurveyData=$SurveyData->SetConnection('mysql2');
        $SurveyData=$SurveyData->where('status',1)->where('survey_id',$id)->get();

        $SurveyDocument=new SurveyDocument();
        $SurveyDocument=$SurveyDocument->SetConnection('mysql2');
        $SurveyDocument=$SurveyDocument->where('status',1)->where('survey_id',$id)->get();

        $product = new Product();
        $product = $product->SetConnection('mysql2');
        $product = $product->where('p_status',1)->select('*')->get();
        $type = new Type();
        $type = $type->SetConnection('mysql2');
        $type = $type->where('status',1)->get();
        $conditions = new Conditions();
        $conditions = $conditions->SetConnection('mysql2');
        $conditions = $conditions->where('status',1)->get();


        return view('Purchase.editSurvey',compact('Survey','SurveyData','SurveyDocument','product','type','conditions','id'));
    }

    public function editGoodIssuance($id)
    {
        $Issuance=new Issuance();
        $Issuance=$Issuance->SetConnection('mysql2');
        $Issuance=$Issuance->where('status',1)->where('id',$id)->first();

        $IssuanceData=new IssuanceData();
        $IssuanceData=$IssuanceData->SetConnection('mysql2');
        $IssuanceData=$IssuanceData->where('status',1)->where('master_id',$id)->get();
        $JobOrder=new JobOrder();
        $JobOrder=$JobOrder->SetConnection('mysql2');
        $JobOrder=$JobOrder->where('status',1)->get();

        return view('Purchase.editGoodIssuance',compact('Issuance','IssuanceData','id','JobOrder'));
    }

    public function editStockReturn($id)
    {
        $stock_return = DB::Connection('mysql2')->table('stock_return')->where('status',1)->where('stock_return_id', $id)->first();
        $stock_return_data = DB::Connection('mysql2')->table('stock_return_data')->where('status',1)->where('stock_return_id', $id)->get();
        $JobOrder=new JobOrder();
        $JobOrder=$JobOrder->SetConnection('mysql2');
        $JobOrder=$JobOrder->where('status',1)->get();

        return view('Purchase.editStockReturn',compact('stock_return','stock_return_data','id','JobOrder'));
    }

    public function uploadSubItemForm(){
        $uom = new UOM;
        $uom = $uom::where('status','=','1')->get();


   	    CommonHelper::companyDatabaseConnection(Session::get('run_company'));
        $categories = new Category;
        $categories = $categories::where('status','=','1')->get();

        return view('Purchase.uploadSubItemForm',compact('categories','uom'));
    }
    public function createSubItemForm(){
        $uom = new UOM;
        $uom = $uom::where('status','=','1')->get();


   	    CommonHelper::companyDatabaseConnection(Session::get('run_company'));
        $categories = new Category;
        $categories = $categories::where('status','=','1')->get();

        return view('Purchase.createSubItemForm',compact('categories','uom'));
    }

    public function viewSubItemList(){
        return view('Purchase.viewSubItemList');
    }

    public function viewSubItemDetail(){
        $id=$_GET['id'];
        $sub_item=new Subitem();
        $sub_item=$sub_item->SetConnection('mysql2');
        $sub_item=$sub_item->where('status',1)->where('id',$id)->select('id','sub_ic','main_ic_id','rate','pack_size','description','uom','itemType',
            'open_qty','open_val')->first();

        return view('Purchase.AjaxPages.viewSubItemDetail',compact('sub_item'));
    }


    public function createUOMForm(){
        return view('Purchase.createUOMForm');
    }

    public function viewUOMList(){
        return view('Purchase.viewUOMList');
    }

    public function createDemandForm(){
        
        $company_locations = ReuseableCode::getUserWiseLocationRights();
        $company_locations = CompanyLocation::whereIn('id', $company_locations)->get()->toArray();
        // dd($company_locations);
        // $departments = new Department;
        // $departments = $departments::where([['status', '=', '1'], ])->select('id','department_name')->orderBy('id')->get();
        $department_id = ReuseableCode::getUserWiseDepartmentRights();
        $subDepartmentList = DB::table('sub_department')
                                // ->where('company_id', '=', $param1)
                                ->whereIn('id', $department_id)
                                ->select('id','sub_department_name')
                                ->get();
        return view('Purchase.createDemandForm',compact('company_locations','subDepartmentList'));
    }

    public function viewDemandList()
    {
        $department_id = ReuseableCode::getUserWiseDepartmentRights();
        return view('Purchase.viewDemandList');
    }

    public function purchaseReturnForm(){
        return view('Purchase.purchaseReturnForm');
    }

    public function purchaseReturnList(){
        $Supplier  = DB::Connection('mysql2')->table('supplier')->where('status',1)->get();
        return view('Purchase.purchaseReturnList',compact('Supplier'));
    }

    public function stockreturnlist(){
        return view('Purchase.stockreturnlist');
    }

    public function editDemandVoucherForm($id)
    {

        $demand=new Demand();
        $demand=$demand->SetCOnnection('mysql2');
        $demand=$demand->where('id',$id)->where('status',1)->first();

        $demand_data=new DemandData();
        $demand_data=$demand_data->SetConnection('mysql2');
        $demand_data=$demand_data->where('master_id',$id)->where('status',1)->orderBy('id','ASC')->get();
        $departments = new Department;
        $departments = $departments::where([['status', '=', '1'], ])->select('id','department_name')->orderBy('id')->get();
      
        return view('Purchase.editDemandVoucherForm',compact('demand','demand_data','id','departments'));
    }


    public function createGoodsReceiptNoteForm(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $PurchaseRequestData = new PurchaseRequestData;
        $PurchaseRequestDatas = $PurchaseRequestData::distinct()->where('grn_status','=','1')->where('purchase_request_status','=','2')->get(['purchase_request_no','purchase_request_date']);
        $accounts = new Account;
        $accounts = $accounts::orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')
            ->where('status',1)
            ->get();
        CommonHelper::reconnectMasterDatabase();

        return view('Purchase.createGoodsReceiptNoteForm',compact('PurchaseRequestDatas','accounts'));
    }

    public function viewGoodsReceiptNoteList(){
        return view('Purchase.viewGoodsReceiptNoteList');
    }

    public function AddGoodsquality()
    {
      return view('Purchase.addGoodQuality');
    }

    public function editGoodsReceiptNoteVoucherForm($id,$GrnNo)
    {
      $check= DB::Connection('mysql2')->table('purchase_return')->where('status',1)->where('grn_id',$id)->count();

        if ($check>0):
            echo '<h1>Purchase Return Booked Against This GRN</h1>';
            die;
            endif;

        $good_receipt_note=new GoodsReceiptNote();
        $good_receipt_note=$good_receipt_note->SetConnection('mysql2');
        $good_receipt_note=$good_receipt_note->where('id',$id)->first();

        if ($good_receipt_note->grn_status==2):
            echo 'GRN APPROVED CAN NOT EDIT';
            die;
        endif;

        $grn_data=new GRNData();
        $grn_data=$grn_data->SetConnection('mysql2');
        $detail_data=$grn_data->where('master_id',$id)->where('status',1)->get();
        $accounts=new Account();
        $accounts=$accounts->SetConnection('mysql2');
        $accounts=$accounts->where('status',1)->get();
        $Addional = DB::Connection('mysql2')->table('addional_expense')->where('status',1)->where('main_id',$id)->where('voucher_no',$GrnNo)->get();
        return view('Purchase.editGoodsReceiptNoteVoucherForm',compact('good_receipt_note','detail_data','accounts','Addional'));
    }

    public function editPurchaseReturnForm($id,$PrNo)
    {
        $Master = DB::Connection('mysql2')->table('purchase_return')->where('status',1)->where('id',$id)->first();
        $Detail = DB::Connection('mysql2')->table('purchase_return_data')->where('status',1)->where('master_id',$id)->get();
        return view('Purchase.editPurchaseReturnForm',compact('Master','Detail'));
    }


    public function editGoodsReceiptNoteWithoutPOForm($id)
    {
        $good_receipt_note=new GoodsReceiptNote();
        $good_receipt_note=$good_receipt_note->SetConnection('mysql2');
        $good_receipt_note=$good_receipt_note->where('id',$id)->first();

        $grn_data=new GRNData();
        $grn_data=$grn_data->SetConnection('mysql2');
        $grn_data=$grn_data->where('master_id',$id)->where('status',1)->get();
        return view('Purchase.editGoodsReceiptNoteWithoutPOForm',compact('good_receipt_note','grn_data'));
    }

    public function createGoodsForwardOrderForm(){
        return view('Purchase.createGoodsForwardOrderForm');
    }

    public function viewGoodsForwardOrderList(){
        return view('Purchase.viewGoodsForwardOrderList');
    }


    public function viewPurchaseVoucherList(){


        $purchase_voucher=new PurchaseVoucher();
        $purchase_voucher=$purchase_voucher->SetConnection('mysql2');
        $purchase_voucher=$purchase_voucher->where('status',1)->select('id','pv_no','pv_date','supplier','slip_no','bill_date','total_net_amount')->orderBy('pv_date','ASC')->get();

        return view('Purchase.viewPurchaseVoucherList',compact('purchase_voucher'));

    }

    public function viewJobOrder(){
        $joborder=new JobOrder();
        $joborder=$joborder->SetConnection('mysql2');
        $joborder=$joborder->where('status',1)->select('*')->get();
        $Client=new Client();
        $Client=$Client->SetConnection('mysql2');
        $Client=$Client->where('status',1)->select('*')->get();
        $Region=new Region();
        $Region=$Region->SetConnection('mysql2');
        $Region=$Region->where('status',1)->select('*')->get();

        $ClientJob=new ClientJob();
        $ClientJob=$ClientJob->SetConnection('mysql2');
        $ClientJob=$ClientJob->where('status',1)->select('*')->get();
        return view('Purchase.viewJobOrder',compact('joborder','Client','Region','ClientJob'));
    }

    public function viewJobOrderTwo(){
        $joborder=new JobOrder();
        $joborder=$joborder->SetConnection('mysql2');
        $joborder=$joborder->where('status',1)->select('*')->get();
        $Client=new Client();
        $Client=$Client->SetConnection('mysql2');
        $Client=$Client->where('status',1)->select('*')->get();
        $Region=new Region();
        $Region=$Region->SetConnection('mysql2');
        $Region=$Region->where('status',1)->select('*')->get();

        $ClientJob=new ClientJob();
        $ClientJob=$ClientJob->SetConnection('mysql2');
        $ClientJob=$ClientJob->where('status',1)->select('*')->get();
        return view('Purchase.viewJobOrderTwo',compact('joborder','Client','Region','ClientJob'));
    }




    public function viewProduct(){
        $product = new Product();
        $product = $product->SetConnection('mysql2');
        $product = $product->where('p_status',1)->select('*')->get();
        return view('Purchase.viewProduct',compact('product'));
    }

    public function viewPurchaseVoucherListThroughGrn(){

        $first_day_this_month = date('Y-m-01');
        $last_day_this_month  = date('Y-m-t');
        $company_locations = ReuseableCode::getUserWiseLocationRights();
        $purchase_voucher=new NewPurchaseVoucher();
        $purchase_voucher=$purchase_voucher->SetConnection('mysql2');
        $purchase_voucher=$purchase_voucher->where('status',1)->
        whereIn('company_location_id', $company_locations)->
        whereBetween('pv_date',[$first_day_this_month,$last_day_this_month])->
        orderBy('id','desc')->get();
        $Supplier  = DB::Connection('mysql2')->table('supplier')->where('status',1)->get();

        return view('Purchase.viewPurchaseVoucherListThroughGrn',compact('purchase_voucher','Supplier','first_day_this_month','last_day_this_month'));

    }

    public function createDemandTypeForm(){
        return view('Purchase.createDemandTypeForm');
    }


    public function createWarehouseForm(){
        return view('Purchase.createWarehouseForm');
    }
 public function viewDemandTypeList(){

        $demand_type=new DemandType();
        $demand_type=$demand_type->SetConnection('mysql2');
        $demand_type=$demand_type->where('status',1)->select('name')->get();

        return view('Purchase.viewDemandTypeList',compact('demand_type'));
    }
    public function viewWarehouseList(){

        $warehouse=new Warehouse();
        $warehouse=$warehouse->SetConnection('mysql2');
        $warehouse=$warehouse->where('status',1)->select('name')->get();

        return view('Purchase.viewWarehouseList',compact('warehouse'));
    }

    public function createGoodReceiptNoteForWithoutPO()
    {
        $supplier=new Supplier();
        $supplier=$supplier->SetConnection('mysql2');
        $supplier=$supplier->where('status',1)->select('id','name')->get();


        $departments = new Department;
        $departments = $departments::where([['company_id', '=', $_GET['m']], ['status', '=', '1'], ])->select('id','department_name')->orderBy('id')->get();
        return view('Purchase.createGoodReceiptNoteForWithoutPO',compact('departments','supplier'));
    }
    public function viewGrnListForPurchaseVoucher()

    {

        $Supplier= new Supplier();
        $Supplier=$Supplier->SetConnection('mysql2');
        $Supplier = $Supplier->where('status',1)->get();


        return view('Purchase.viewGrnListForPurchaseVoucher',compact('Supplier'));
    }

    public function createPurchaseVoucherFormThroughGrn(Request $request)
    {
        $ids = $request->checkbox;
        $master_id = $ids;
        // dd($master_id);
        $goodsReceipt = GoodsReceiptNote::
            whereIn('id',$request->checkbox)
            ->select('po_no')
            ->where('status',1)
            ->groupBy('po_no')->get();
            
        $ids = $goodsReceipt;

        $department=[];
        // new FinanceDepartment();
        // $department=$department->SetConnection('mysql2');
        // $department=$department->where('status',1)->select('id','name','code')
        //     ->orderBy('level1', 'ASC')
        //     ->orderBy('level2', 'ASC')
        //     ->orderBy('level3', 'ASC')
        //     ->orderBy('level4', 'ASC')
        //     ->orderBy('level5', 'ASC')
        //     ->get();

        return view('Purchase.createPurchaseVoucherFormThroughGrn',compact('department','ids','master_id'));
    }

    public function createJobOrder()

    {
        $survey= new Survey();
        $survey=$survey->SetConnection('mysql2');
        $survey=$survey->where('status',1)->select('tracking_no')->get();





        $quotation=new Quotation();
        $quotation=$quotation->SetConnection('mysql2');
        $quotation=$quotation->where('status',1)->where('quotation_status',2)->select('quotation_no','id')->get();
        $uom = new UOM;
        $uom = $uom->where('status','=','1')->select('uom_name','id')->get();

        return view('Purchase.createJobOrder',compact('survey','quotation','uom'));
    }


    public function createProduct(){
        return view('Purchase.createProduct');
    }

    public function add_item_master(){

        return view('Purchase.add_item_master');
    }
    public function editItemMaster($id)
    {
        $ItemMaster = DB::Connection('mysql2')->table('item_master')->where('status',1)->where('id',$id)->first();
        return view('Purchase.editItemMaster',compact('ItemMaster'));
    }

    public function viewSubCategoryList (){
        $SubCategory = DB::Connection('mysql2')->table('sub_category')->where('status',1)->get();
        return view('Purchase.viewSubCategoryList',compact('SubCategory'));
    }
    public function viewItemMasterList (){
        $ItemMaster = DB::Connection('mysql2')->table('item_master')->where('status',1)->get();
        return view('Purchase.viewItemMasterList',compact('ItemMaster'));
    }

    public function purchase_request_form()
    {
        return view('Purchase.purchase_request_form');
    }
    public function directPurchaseOrderForm()
    {
        $supplierList = DB::Connection('mysql2')->table('supplier')->where('status',1)->get();
        $departments = new Department;
        $departments = $departments::where('status', '=', '1')->select('id','department_name')->orderBy('id')->get();
        return view('Purchase.directPurchaseOrderForm',compact('supplierList','departments'));
    }

    public function purchase_order_status()
    {
        return view('Purchase.purchase_order_status');
    }
    public function vendor_opening_list()
    {

      $data=  DB::Connection('mysql2')->table('supplier as a')
          ->select('a.name','a.id','a.acc_id',DB::raw('sum(b.balance_amount) as bal'))
            ->join('vendor_opening_balance as b','a.id','=','b.vendor_id')
            ->where('a.status',1)
            ->groupBy('b.vendor_id')
            ->get();

        return view('Purchase.vendor_opening_list',compact('data'));
    }

    public function vendor_report()
    {

        $data=  DB::Connection('mysql2')->table('supplier as a')
            ->select('a.name','a.id','b.supplier')
            ->join('new_purchase_voucher as b','a.id','=','b.supplier')
            ->where('a.status',1)
            ->where('b.status',1)
            ->groupBy('b.supplier')
            ->get();

        return view('Purchase.vendor_report',compact('data'));
    }

    public function vendor_outstanding()
    {
        return view('Purchase.vendor_outstanding');
    }

    public static function getPoReportByPoNo(Request $request)
    {
        $PoId=$request->PoId;
        $m=$request->m;
        $PurchaseRequest = DB::Connection('mysql2')->table('purchase_request')->where('id',$PoId)->get();


        return view('Purchase.AjaxPages.getPoReportByPoNo',compact('PurchaseRequest','PoId','m'));


    }
    public static function deleteItemMaster(Request $request)
    {
        $DeleteId = $request->ItemMasterId;
        $UpdateData['status'] = 2;
        DB::Connection('mysql2')->table('item_master')->where('id',$DeleteId)->update($UpdateData);

    }

    public static function directPurchaseInvoice()
    {
        $supplierList = DB::Connection('mysql2')->table('supplier')->where('status',1)->get();
        $departments = new Department;
        $departments = $departments::where('status', '=', '1')->select('id','department_name')->orderBy('id')->get();
        return view('Purchase.directPurchaseInvoice',compact('supplierList','departments'));
    }

    public function tempGrn(Request $request)
    {
        if ($request->ajax()) {
            $tempGrns = TempGrn::where('status',1)->get();
            return view('Purchase.tempGrnAjax', compact('tempGrns'));
        }
        return view('Purchase.tempGrn');
    }

    public function companyIdForm()
    {
        $company_locations = CompanyLocation::get();
        return view('Purchase.companyrights.companyIdForm', compact('company_locations'));
    }

    public function locationRightsForm()
    {
        $company_locations = CompanyLocation::get();
        $users = User::where('status',1)->get();
        return view('Purchase.companyrights.locationRightsForm', compact('company_locations', 'users'));
    }

}
