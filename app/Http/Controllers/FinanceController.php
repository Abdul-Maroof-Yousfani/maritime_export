<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\TaxSection;
use App\Models\Jvs;
use App\Models\Jvs_data;
use App\Models\NewJvs;
use App\Models\NewJvData;
use App\Models\NewRvs;
use App\Models\NewRvData;
use App\Models\Contra;
use App\Models\Contra_data;
use App\Models\Pvs;
use App\Models\Employee;
use App\Models\Pvs_data;
use App\Models\Supplier;
use App\Models\Rvs;
use App\Models\Rvs_data;
use App\Models\GRNData;
use App\Models\Invoice;
use App\Models\Department;
use App\Models\Tax;
use App\Models\Eobi;
use App\Models\PurchaseVoucher;
use App\Models\PurchaseVoucherThroughGrn;
use App\Models\FinanceDepartment;
use App\Models\CostCenter;
use App\Models\NewPv;
use App\Models\NewPvData;
use App\Models\NewPurchaseVoucher;
use App\Models\NewPurchaseVoucherData;
use App\Models\PaidTo;
use App\Models\SalesTaxInvoice;
use App\Models\SalesTaxInvoiceData;

use App\Helpers\CommonHelper;
use App\Helpers\SalesHelper;
use App\Helpers\ReuseableCode;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class FinanceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

      echo  Session::get('run_company');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

   	public function toDayActivity(){
   		return view('Finance.toDayActivity');
   	}

	public function commission()
	{
		return view('Finance.commission');
	}


	public function get_commision_data(Request $request)
	{
	 	$agent=$request->agent;
		$from=$request->from;
		$to=$request->to;

		 $agent_type=explode(',',$agent);
		if ($agent_type[1]==1):
			$clause='and e.sale_agent_id="'.$agent.'"';
			elseif($agent_type[1]==2):
			$clause='and e.purchase_agent_id="'.$agent.'"';
			endif;

		$data=DB::connection('mysql2')->select('select a.id,a.rv_no,d.gi_no,d.id as si_id,c.received_amount,d.model_terms_of_payment,d.gi_date,a.rv_date,e.name as customer_name,c.id as brigde_id from new_rvs a
		inner join
		brige_table_sales_receipt c
		on
		a.id=c.rv_id
		inner join
		sales_tax_invoice d
		on
		c.si_id=d.id
		inner join
		customers e
		on
		e.id=d.buyers_id
		where a.status=1
		'.$clause.'
		and a.rv_date between "'.$from.'" and "'.$to.'"
 		and a.sales=1
		and a.rv_status=2');

		return view('Finance.AjaxPages.get_commision_data',compact('data'));
	}
	public function viewBookDay()
	{
		return view('Finance.viewBookDay');
	}
	public function create_new_pv()
	{
		return view('Finance.create_new_pv');
	}
	public function usersList()
	{
		return view('Finance.usersList');
	}

	public function createUserForm()
	{
		$companies =  DB::table('company')->where('status', 1)->get();
		return view('Finance.createUserForm', compact('companies'));
	}

	public function filter_user_list()
	{
		$Users =  DB::table('users')->orderBy('id','desc')->get();
		return view('Finance.filter_user_list',compact('Users'));
	}


	public function update_user_password(Request $request)
	{
		$Password = $request->Password;
		$Id = $request->Id;
		$UpdateData['password'] = Hash::make($Password);
		$UpdateData['identity'] = $Password;
		$Users =  DB::table('users')->where('id',$Id)->update($UpdateData);
		echo "yes";

	}

	public function activeInActiveUser(Request $request)
	{
		$UserId = $request->UserId;
		$Status = $request->statusVal;
		$UpdateData['status'] = $Status;
		$Users =  DB::table('users')->where('id',$UserId)->update($UpdateData);
	}

	public function edit_new_pv($id)
	{
		$Master = DB::Connection('mysql2')->table('new_pvv')->where('status',1)->where('id',$id)->first();
		$Detail = DB::Connection('mysql2')->table('new_pvv_data')->where('master_id',$id)->get();
		return view('Finance.edit_new_pv',compact('Master','Detail','id'));
	}


	public function new_pv_list()
	{
		$currentMonthStartDate = date('Y-m-01');
		$currentMonthEndDate   = date('Y-m-t');
		$Data = DB::Connection('mysql2')->table('new_pvv')->where('status',1)->whereBetween('pv_date',[$currentMonthStartDate,$currentMonthEndDate])->orderBy('id', 'DESC')->get();
		return view('Finance.new_pv_list',compact('Data'));
	}

	public function view_new_pv_detail()
	{
		return view('Finance.view_new_pv_detail');
	}



	public function expenseVoucherForm()
	{

		$Accounts = DB::Connection('mysql2')->table('accounts')->where('status',1)->get();
		$SoNo = DB::Connection('mysql2')->table('sales_order')->where('status',1)->select('so_no')->get();
		return view('Finance.expenseVoucherForm',compact('Accounts','SoNo'));
	}

	public function createOpeningPage()
	{
		$AccountsData = DB::Connection('mysql2')->select('select * from accounts where status = 1 and parent_code LIKE "1%" OR code LIKE  "2%" OR code = 1 OR code = 2 order by `level1`,`level2`,`level3`,`level4`,`level5`,`level6`,`level7`');
		return view('Finance.createOpeningPage',compact('AccountsData'));
	}

	public function trialBalanceReportPage()
	{
		return view('Finance.trialBalanceReportPage');
	}



	public function expenseVoucherList()
	{
		$ExpenseVoucher = DB::Connection('mysql2')->table('expense_voucher')->where('status',1)->get();
		CommonHelper::reconnectMasterDatabase();
		return view('Finance.expenseVoucherList',compact('ExpenseVoucher'));
	}


	public function createDepartmentForm(){

		$department=new FinanceDepartment();
		$department=$department->SetConnection('mysql2');
		$department=$department->where('status',1)
			->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->get();
		return view('Finance.createDepartmentForm',compact('department'));
	}

	public function createCostCenterForm(){

		$cost_center=new CostCenter();
		$cost_center=$cost_center->where('status',1)
			->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->get();
		return view('Finance.createCostCenterForm',compact('cost_center'));
	}

	public function viewDepartmentList()
	{
		$department=new FinanceDepartment();
		$department=$department->SetConnection('mysql2');
		$department=$department->where('status',1)->select('name','code')
			->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->get();
		return view('Finance.viewDepartmentList',compact('department'));
	}

	public function viewCostCenterList()
	{
		
		return view('Finance.viewCostCenterList');
	}
	public function viewTaxSectionList(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
		$taxSection = new TaxSection;
		$taxSection = $taxSection->where('status',1)->get();

   		return view('Finance.viewTaxSectionList',compact('taxSection'));
        CommonHelper::reconnectMasterDatabase();
   	}


	public function addTaxSectionForm(){
		return view('Finance.addTaxSectionForm');
	}

	public function viewJvsAllocation()
	{
		$jv_data=new jvs_data();
		$jv_data=$jv_data->SetConnection('mysql2');
		$jv_data=$jv_data->where('status',1)->Orderby('id','ASC')->get();
		return view('Finance.viewJvsAllocation',compact('jv_data'));
	}

	public function editCashPaymentVoucherForm($id){


		$type=4;
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

		$department=new FinanceDepartment();
		$department=$department->SetConnection('mysql2');
		$department=$department->where('status',1)->select('id','name','code')
			->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->get();

		$cpvs=new Pvs();
		$cpvs=$cpvs->SetConnection('mysql2');
		$cpvs=$cpvs->where('id',$id)->first();

		$cpv_data=new Pvs_data();
		$cpv_data=$cpv_data->SetConnection('mysql2');
		$cpv_data=$cpv_data->where('master_id',$id)->Orderby('id','ASC')->get();

		CommonHelper::reconnectMasterDatabase();
		return view('Finance.editCashPaymentVoucherForm',compact('accounts','department','cpvs','cpv_data','id','type'));

	}

	public function getDatabase()
	{
		echo "<pre>";
		print_r($_ENV);
	}

	public function editCashPVForm($id)
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
			->get();

		$NewPv = new NewPv();
		$NewPv = $NewPv->SetConnection('mysql2');
		$NewPv = $NewPv->where('id',$id)->first();

		$NewPvData = new NewPvData();
		$NewPvData = $NewPvData->SetConnection('mysql2');
		$NewPvData = $NewPvData->where('master_id',$id)->Orderby('id','ASC')->get();

		$PaidTo = new PaidTo();
		$PaidTo = $PaidTo::where('status','=','1')->get();

		CommonHelper::reconnectMasterDatabase();
		return view('Finance.editCashPVForm',compact('accounts','NewPv','NewPvData','id','PaidTo'));
	}

	public function editBankRv($id)
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
			->get();

		$NewRvs = new NewRvs();
		$NewRvs = $NewRvs->SetConnection('mysql2');
		$NewRvs = $NewRvs->where('id',$id)->first();

		$NewRvData = new NewRvData();
		$NewRvData = $NewRvData->SetConnection('mysql2');
		$NewRvData = $NewRvData->where('master_id',$id)->Orderby('id','ASC')->get();

		$PaidTo = new PaidTo();
		$PaidTo = $PaidTo::where('status','=','1')->get();
		CommonHelper::reconnectMasterDatabase();
		return view('Finance.editBankRv',compact('accounts','NewRvs','NewRvData','id','PaidTo'));
	}

	public function editJv($id)
	{
		CommonHelper::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
			->select('id','name','type')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();

		$NewJv = new NewJvs();
		$NewJv = $NewJv->SetConnection('mysql2');
		$NewJv = $NewJv->where('id',$id)->first();

		$NewJvData = new NewJvData();
		$NewJvData = $NewJvData->SetConnection('mysql2');
		$NewJvData = $NewJvData->where('master_id',$id)->Orderby('id','ASC')->get();

		//$PaidTo = new PaidTo();
	//	$PaidTo = $PaidTo::where('status','=','1')->get();

		CommonHelper::reconnectMasterDatabase();
		return view('Finance.editJv',compact('accounts','NewJv','NewJvData','id'));
	}

	public function editCashRv($id)
	{
		CommonHelper::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts::where('status',1)->select('id','code','name','type')->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();

		$NewRvs = new NewRvs();
		$NewRvs = $NewRvs->SetConnection('mysql2');
		$NewRvs = $NewRvs->where('id',$id)->first();

		$NewRvData = new NewRvData();
		$NewRvData = $NewRvData->SetConnection('mysql2');
		$NewRvData = $NewRvData->where('master_id',$id)->Orderby('id','ASC')->get();

		$PaidTo = new PaidTo();
		$PaidTo = $PaidTo::where('status','=','1')->get();

		CommonHelper::reconnectMasterDatabase();
		return view('Finance.editCashRv',compact('accounts','NewRvs','NewRvData','id','PaidTo'));
	}



	public function editBankPaymentNew($id)
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
			->get();

		$NewPv = new NewPv();
		$NewPv = $NewPv->SetConnection('mysql2');
		$NewPv = $NewPv->where('id',$id)->first();

		$NewPvData = new NewPvData();
		$NewPvData = $NewPvData->SetConnection('mysql2');
		$NewPvData = $NewPvData->where('master_id',$id)->Orderby('id','ASC')->get();

		CommonHelper::reconnectMasterDatabase();
		return view('Finance.editBankPaymentNew',compact('accounts','NewPv','NewPvData','id'));
	}

	public function editJournalVoucherForm($id){

		$type=5;
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

		$department=new FinanceDepartment();
		$department=$department->SetConnection('mysql2');
		$department=$department->where('status',1)->select('id','name','code')
			->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->get();

		$jvs=new Jvs();
		$jvs=$jvs->SetConnection('mysql2');
		$jvs=$jvs->where('id',$id)->first();

		$jv_data=new jvs_data();
		$jv_data=$jv_data->SetConnection('mysql2');
		$jv_data=$jv_data->where('master_id',$id)->Orderby('id','ASC')->get();

		CommonHelper::reconnectMasterDatabase();
		return view('Finance.editJournalVoucherForm',compact('accounts','department','jvs','jv_data','id','type'));

	}

	public function createAccountForm(){

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
   		return view('Finance.createAccountForm',compact('accounts'));
        CommonHelper::reconnectMasterDatabase();
   	}

	public function ccoa(){
		return view('Finance.ccoa');
	}

	public function ccoa_detail(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
		$category = new Category();
		$category->name = Input::get('cName');
		$category->save();
		return view('Finance.ccoa');
        CommonHelper::reconnectMasterDatabase();
	}

    public function createJournalVoucherForm(){
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

		$department=new FinanceDepartment();
		$department=$department->SetConnection('mysql2');
		$department=$department->where('status',1)->select('id','name','code')
			->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->get();
		$supplier=new Supplier();
		$supplier=$supplier->SetConnection('mysql2');
		$supplier=$supplier->where('status',1)->select('id','name')->get();
        return view('Finance.createJournalVoucherForm',compact('accounts','department','supplier'));

    }

    public function viewJournalVoucherList(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $currentMonthStartDate = date('Y-m-01');
        $currentMonthEndDate   = date('Y-m-t');
        $accounts = new Account;
        $accounts = $accounts::orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')
            ->get();
        $jvs = new Jvs;
        $jvs = $jvs::whereBetween('jv_date',[$currentMonthStartDate,$currentMonthEndDate])
            ->where('voucherType','=','1')
            ->where('status','=','1')
            ->get();
        CommonHelper::reconnectMasterDatabase();
        return view('Finance.viewJournalVoucherList',compact('accounts','jvs'));
    }
	public function viewJournalVoucherNew(){

		$currentMonthStartDate = date('Y-m-01');
		$currentMonthEndDate   = date('Y-m-t');

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
		$Jvs = new NewJvs();
		$Jvs = $Jvs::where('status','=','1')->whereBetween('jv_date',[$currentMonthStartDate,$currentMonthEndDate])->orderBy('id', 'DESC')->get();
		CommonHelper::reconnectMasterDatabase();
		return view('Finance.viewJournalVoucherNew',compact('accounts','Jvs'));
	}

	public function viewBankRvNew(){
		$currentMonthStartDate = date('Y-m-01');
		$currentMonthEndDate   = date('Y-m-t');
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
		$Rvs = new NewRvs();
		$Rvs = $Rvs::where('status','=','1')->where('rv_type','=',1)->where('sales','!=',1)->whereBetween('rv_date',[$currentMonthStartDate,$currentMonthEndDate])->orderBy('id', 'DESC')->get();
		CommonHelper::reconnectMasterDatabase();
		return view('Finance.viewBankRvNew',compact('accounts','Rvs'));
	}

	public function viewCashRvNew(){
		$currentMonthStartDate = date('Y-m-01');
		$currentMonthEndDate   = date('Y-m-t');
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
		$Rvs = new NewRvs();
		$Rvs = $Rvs::where('status','=','1')->where('sales','!=',1)->where('rv_type','=',2)->whereBetween('rv_date',[$currentMonthStartDate,$currentMonthEndDate])
			->orderBy('id', 'DESC')->get();
		CommonHelper::reconnectMasterDatabase();
		return view('Finance.viewCashRvNew',compact('accounts','Rvs'));
	}

	public function paidToExpenseReport(){
		return view('Finance.paidToExpenseReport');
	}

	public function auditTrialReport(){
		return view('Finance.auditTrialReport');
	}

	public function PurchaseVoucherList()
	{

		$NewPurchaseVoucher = CommonHelper::PurchaseAmountAndPayment();
//		CommonHelper::companyDatabaseConnection($_GET['m']);
//
//		$NewPurchaseVoucher = new NewPurchaseVoucher();
//		$NewPurchaseVoucher = $NewPurchaseVoucher->where('status','=','1')->where('pv_status',2)->get();
//
//		CommonHelper::reconnectMasterDatabase();
		//return view('Finance.PurchaseVoucherList',compact('NewPurchaseVoucher'));


		$Supplier = new Supplier();
		$Supplier=$Supplier->SetConnection('mysql2');
		$Supplier=$Supplier
			->select('supplier.id','supplier.name','supplier.acc_id','transactions.acc_code')
			->join('transactions', 'transactions.acc_id', '=', 'supplier.acc_id')
			->where('supplier.status','=',1)
			->where('transactions.status','=',1)
			->groupBy('transactions.acc_id')
			->orderBy('supplier.name')
			->get();
		$m = $_GET['m'];
		return view('Finance.outstanding_ledger',compact('Supplier'));
	}

	public function payable_reports()
	{


		//$NewPurchaseVoucher = CommonHelper::PurchaseAmountAndPayment();

		return view('Finance.PurchaseVoucherList');
//		return view('Finance.PurchaseVoucherList');
	}



	public function createCashPaymentVoucherForm(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts::where('status',1)->orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();

		$department=new FinanceDepartment();
		$department=$department->SetConnection('mysql2');
		$department=$department->where('status',1)->select('id','name','code')
			->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->get();
		$PaidTo = new PaidTo();
		$PaidTo = $PaidTo::where('status','=','1')->get();
        CommonHelper::reconnectMasterDatabase();
   		return view('Finance.createCashPaymentVoucherForm',compact('accounts','department','PaidTo'));

   	}

	public function viewCashPaymentVoucherList(){
		CommonHelper::companyDatabaseConnection($_GET['m']);
		$currentMonthStartDate = date('Y-m-01');
		$currentMonthEndDate   = date('Y-m-t');
		$accounts = new Account;
		$accounts = $accounts::where('status',1)->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();
		$pvs = new NewPv();
		$pvs = $pvs::where('status','=','1')->where('payment_type','=','2')->where('type','=','1')->whereBetween('pv_date',[$currentMonthStartDate,$currentMonthEndDate])->orderBy('id', 'DESC')->get();
		CommonHelper::reconnectMasterDatabase();
		return view('Finance.viewCashPaymentVoucherList',compact('accounts','pvs'));
	}

	public function PaymentVoucherList()
	{
		CommonHelper::companyDatabaseConnection($_GET['m']);
		$currentMonthStartDate = date('Y-m-01');
		$currentMonthEndDate   = date('Y-m-t');
		$accounts = new Account;
		$accounts = $accounts::where('status',1)->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();
		$pvs = new NewPv();
		$pvs = $pvs::where('status','=','1')->where('type','=','2')->orderBy('id', 'DESC')->whereBetween('pv_date',[$currentMonthStartDate,$currentMonthEndDate])->get();
		CommonHelper::reconnectMasterDatabase();
		return view('Finance.viewOutstandingPaymentVoucherList',compact('accounts','pvs'));
	}

	public function paymentVoucherListImport()
	{
		CommonHelper::companyDatabaseConnection($_GET['m']);
		$currentMonthStartDate = date('Y-m-01');
		$currentMonthEndDate   = date('Y-m-t');
		$accounts = new Account;
		$accounts = $accounts::where('status',1)->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();
		$pvs = new NewPv();
		$pvs = $pvs::where('status','=','1')->whereIn('type',[3,4])->orderBy('id', 'DESC')->whereBetween('pv_date',[$currentMonthStartDate,$currentMonthEndDate])->get();
		CommonHelper::reconnectMasterDatabase();
		return view('Finance.paymentVoucherListImport',compact('accounts','pvs'));
	}


	public function paymentVoucherReturnList()
	{
		CommonHelper::companyDatabaseConnection($_GET['m']);
		$currentMonthStartDate = date('Y-m-01');
		$currentMonthEndDate   = date('Y-m-t');
		$accounts = new Account;
		$accounts = $accounts::where('status',1)->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();
		$pvs = new NewPv();
		$pvs = $pvs::where('status','=','1993')->where('type','=','2')->orderBy('id', 'DESC')->whereBetween('pv_date',[$currentMonthStartDate,$currentMonthEndDate])->get();
		CommonHelper::reconnectMasterDatabase();
		return view('Finance.paymentVoucherReturnList',compact('accounts','pvs'));
	}




	public function createBankPaymentVoucherForm(){
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
		$OtherPayables = new Account;
		$OtherPayables = $OtherPayables::where('parent_code', '3-2-3-6')->where('status', '1')->get();

		$Supplier = new Supplier();
		$Supplier = $Supplier::where('status', '1')->get();


		$taxSection=new TaxSection();
		$taxSection=$taxSection->SetConnection('mysql2');
		$taxSection = $taxSection->where('status',1)->get();

        CommonHelper::reconnectMasterDatabase();

		$department=new FinanceDepartment();
		$department=$department->SetConnection('mysql2');
		$department=$department->where('status',1)->select('id','name','code')
			->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->get();
   		return view('Finance.createBankPaymentVoucherForm',compact('accounts','department','taxSection','OtherPayables','Supplier'));

   	}

	public function createBankPaymentNew(){
		CommonHelper::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts::where('status',1)->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();
		$OtherPayables = new Account;
		$OtherPayables = $OtherPayables::where('parent_code', '3-2-3-6')->where('status', '1')->get();

		$Supplier = new Supplier();
		$Supplier = $Supplier::where('status', '1')->get();


		$taxSection=new TaxSection();
		$taxSection=$taxSection->SetConnection('mysql2');
		$taxSection = $taxSection->where('status',1)->get();

		$PaidTo = new PaidTo();
		$PaidTo = $PaidTo::where('status','=','1')->get();

		CommonHelper::reconnectMasterDatabase();

		$department=new FinanceDepartment();
		$department=$department->SetConnection('mysql2');
		$department=$department->where('status',1)->select('id','name','code')
			->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->get();
		return view('Finance.createBankPaymentNew',compact('accounts','department','taxSection','OtherPayables','Supplier','PaidTo'));

	}

	public function createContraVoucher(){
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
		return view('Finance.createContraVoucher',compact('accounts'));

	}

	public function viewBankPaymentVoucherList(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
		$currentMonthStartDate = date('Y-m-01');
    	$currentMonthEndDate   = date('Y-m-t');
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
		$pvs = new Pvs;
		$pvs = $pvs::whereBetween('pv_date',[$currentMonthStartDate,$currentMonthEndDate])
					 ->where('voucherType','=','2')
					 ->get();
        CommonHelper::reconnectMasterDatabase();
		return view('Finance.viewBankPaymentVoucherList',compact('accounts','pvs'));
	}

	public function viewBankPaymentNewVoucherList(){
		CommonHelper::companyDatabaseConnection($_GET['m']);
		$currentMonthStartDate = date('Y-m-01');
		$currentMonthEndDate   = date('Y-m-t');
		$accounts = new Account;
		$accounts = $accounts::where('status',1)->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();
		$pvs = new NewPv();
		$pvs = $pvs::where('status','=','1')->where('payment_type','=','1')->where('type','=','1')->whereBetween('pv_date',[$currentMonthStartDate,$currentMonthEndDate])->orderBy('id', 'DESC')->get();
		CommonHelper::reconnectMasterDatabase();
		return view('Finance.viewBankPaymentNewVoucherList',compact('accounts','pvs'));
	}


	public function viewContraVoucherList(){
		CommonHelper::companyDatabaseConnection($_GET['m']);
		$currentMonthStartDate = date('Y-m-01');
		$currentMonthEndDate   = date('Y-m-t');
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();

		$pvs = DB::Connection('mysql2')->table('contra_data')->whereBetween('cv_date',[$currentMonthStartDate,$currentMonthEndDate])
			->where('status','=',1)
			->get();
		CommonHelper::reconnectMasterDatabase();
		return view('Finance.viewContraVoucherList',compact('accounts','pvs'));
	}

	public function editBankPaymentVoucherForm($id){
		$type=3;
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

		$department=new FinanceDepartment();
		$department=$department->SetConnection('mysql2');
		$department=$department->where('status',1)->select('id','name','code')
			->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->get();

		$bpvs=new Pvs();
		$bpvs=$bpvs->SetConnection('mysql2');
		$bpvs=$bpvs->where('id',$id)->first();

		$bpv_data=new Pvs_data();
		$bpv_data=$bpv_data->SetConnection('mysql2');
		$bpv_data=$bpv_data->where('master_id',$id)->Orderby('id','ASC')->get();

		CommonHelper::reconnectMasterDatabase();
		return view('Finance.editBankPaymentVoucherForm',compact('accounts','department','bpvs','bpv_data','id','type'));
   	}

	public function editContraVoucher($id){

		$accounts = new Account;
		$accounts=$accounts->SetConnection('mysql2');
		$accounts = $accounts->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();

		$contra = new Contra();
		$contra = $contra->SetConnection('mysql2');
		$contra = $contra->where('id',$id)->first();

		$contra_data = new Contra_data();
		$contra_data = $contra_data->SetConnection('mysql2');
		$contra_data = $contra_data->where('master_id',$id)->orderBy('id', 'ASC')->get();
		return view('Finance.editContraVoucher',compact('accounts','contra','contra_data','id'));
	}

	public function createCashReceiptVoucherForm(){
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
   		return view('Finance.createCashReceiptVoucherForm',compact('accounts'));
	}

	public function viewCashReceiptVoucherList(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
		$currentMonthStartDate = date('Y-m-01');
    	$currentMonthEndDate   = date('Y-m-t');
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
		$rvs = new Rvs;
		$rvs = $rvs::whereBetween('rv_date',[$currentMonthStartDate,$currentMonthEndDate])
					 ->where('voucherType','=','1')
					 ->get();
        CommonHelper::reconnectMasterDatabase();
		return view('Finance.viewCashReceiptVoucherList',compact('accounts','rvs'));
	}

	public function editCashReceiptVoucherForm(){
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
   		return view('Finance.editCashReceiptVoucherForm',compact('accounts'));
	}

	public function createBankReceiptVoucherForm(){
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
   		return view('Finance.createBankReceiptVoucherForm',compact('accounts'));
	}

	public function createBankRvNew(){
		CommonHelper::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts::where('status',1)->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();
		$PaidTo = new PaidTo();
		$PaidTo = $PaidTo::where('status','=','1')->get();
		CommonHelper::reconnectMasterDatabase();
		return view('Finance.createBankRvNew',compact('accounts','PaidTo'));
	}

	public function createCashRvNew(){
		CommonHelper::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts::where('status',1)->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();
		$PaidTo = new PaidTo();
		$PaidTo = $PaidTo::where('status','=','1')->get();
		CommonHelper::reconnectMasterDatabase();
		return view('Finance.createCashRvNew',compact('accounts','PaidTo'));
	}



	public function viewBankReceiptVoucherList(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
		$currentMonthStartDate = date('Y-m-01');
    	$currentMonthEndDate   = date('Y-m-t');
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
		$rvs = new Rvs;
		$rvs = $rvs::whereBetween('rv_date',[$currentMonthStartDate,$currentMonthEndDate])
					 ->where('voucherType','=','2')
					 ->get();
        CommonHelper::reconnectMasterDatabase();
		return view('Finance.viewBankReceiptVoucherList',compact('accounts','rvs'));
	}

	public function editBankReceiptVoucherForm($id){
		$rvs = new Rvs();
		$rvs = $rvs->SetConnection('mysql2');
		$rvs = $rvs->where('id',$id)->first();

		$rvs_data = new Rvs_data();
		$rvs_data = $rvs_data->SetConnection('mysql2');
		$rvs_data = $rvs_data->where('master_id',$id)->orderBy('id', 'ASC')->get();

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
		return view('Finance.editBankReceiptVoucherForm',compact('rvs','rvs_data','accounts'));
	}

	public function viewLedgerReport(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts::where('status',1)->select('id','code','name','type')->orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
        CommonHelper::reconnectMasterDatabase();
   		return view('Finance.viewLedgerReport',compact('accounts'));
	}

	public function viewTrialBalanceReportAnotherPage(){
		return view('Finance.viewTrialBalanceReportAnotherPage');
	}


	function viewTrialBalance()
	{
		$m = $_GET['m'];
		$company_id = $m;
		return view('Finance.viewTrialBalance2',compact('company_id'));
	}

	function viewBalanceSheet()
	{
		$m = $_GET['m'];
		$company_id = $m;
		return view('Finance.viewBalanceSheet',compact('company_id'));
	}
	function viewBalanceSheetCopy()
	{
		$m = $_GET['m'];
		$company_id = $m;
		return view('Finance.viewBalanceSheetCopy',compact('company_id'));
	}


	function viewIncomeStatement()
	{
		$m = $_GET['m'];
		$company_id = $m;
		return view('Finance.viewIncomeStatement',compact('company_id'));
	}
	function flow_statement_page()
	{
		$m = $_GET['m'];
		$company_id = $m;
		return view('Finance.flow_statement_page',compact('company_id'));
	}

	function supplierSummaryReport()
	{
//		$Supplier = new Supplier();
//		$Supplier=$Supplier->SetConnection('mysql2');
//		$Supplier=$Supplier
//			->select('supplier.id','supplier.name','supplier.acc_id','transactions.acc_code')
//			->join('transactions', 'transactions.acc_id', '=', 'supplier.acc_id')
//			->where('supplier.status','=',1)
//			->where('transactions.status','=',1)
//			->groupBy('transactions.acc_id')
//			->get();
//		$m = $_GET['m'];
		return view('Finance.vendor_summery_filter_wise');
	}

	function receivableSummaryReport()
	{
//		$Supplier = new Supplier();
//		$Supplier=$Supplier->SetConnection('mysql2');
//		$Supplier=$Supplier
//			->select('supplier.id','supplier.name','supplier.acc_id','transactions.acc_code')
//			->join('transactions', 'transactions.acc_id', '=', 'supplier.acc_id')
//			->where('supplier.status','=',1)
//			->where('transactions.status','=',1)
//			->groupBy('transactions.acc_id')
//			->get();
//		$m = $_GET['m'];
		return view('Finance.receivableSummaryReport');
	}

	function employeeSummaryReport()
	{
		return view('Finance.employeeSummaryReport');
	}





	public function createPurchaseCashPaymentVoucherForm(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $GRNData = new GRNData;
        $GRNDatas = $GRNData::distinct()->where('grn_status','=','2')->get(['grn_no','grn_date']);
        CommonHelper::reconnectMasterDatabase();

        return view('Finance.createPurchaseCashPaymentVoucherForm',compact('GRNDatas'));
    }

    public function viewPurchaseCashPaymentVoucherList(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $currentMonthStartDate = date('Y-m-01');
        $currentMonthEndDate   = date('Y-m-t');
        $accounts = new Account;
        $accounts = $accounts::orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')
            ->get();
        $pvs = new Pvs;
        $pvs = $pvs::whereBetween('pv_date',[$currentMonthStartDate,$currentMonthEndDate])
            ->where('voucherType','=','3')
            ->where('status','=','1')
            ->get();
        CommonHelper::reconnectMasterDatabase();
        return view('Finance.viewPurchaseCashPaymentVoucherList',compact('accounts','pvs'));
    }


    public function createPurchaseBankPaymentVoucherForm(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $GRNData = new GRNData;
        $GRNDatas = $GRNData::distinct()->where('grn_status','=','2')->get(['grn_no','grn_date']);
        CommonHelper::reconnectMasterDatabase();

        return view('Finance.createPurchaseBankPaymentVoucherForm',compact('GRNDatas'));
    }

    public function viewPurchaseBankPaymentVoucherList(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $currentMonthStartDate = date('Y-m-01');
        $currentMonthEndDate   = date('Y-m-t');
        $accounts = new Account;
        $accounts = $accounts::orderBy('level1', 'ASC')
            ->orderBy('level2', 'ASC')
            ->orderBy('level3', 'ASC')
            ->orderBy('level4', 'ASC')
            ->orderBy('level5', 'ASC')
            ->orderBy('level6', 'ASC')
            ->orderBy('level7', 'ASC')
            ->get();
        $pvs = new Pvs;
        $pvs = $pvs::whereBetween('pv_date',[$currentMonthStartDate,$currentMonthEndDate])
            ->where('voucherType','=','4')
            ->where('status','=','1')
            ->get();
        CommonHelper::reconnectMasterDatabase();
        return view('Finance.viewPurchaseBankPaymentVoucherList',compact('accounts','pvs'));
    }

    public function viewSaleCashReceiptVoucherList(){
        return view('Finance.viewSaleCashReceiptVoucherList');
    }

    public function createSaleCashReceiptVoucherForm(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $Invoice = new Invoice;
        $Invoices = $Invoice::distinct()->where('inv_status','=','2')->where('invoiceType','=','3')->get(['inv_no','inv_date']);
        CommonHelper::reconnectMasterDatabase();

        return view('Finance.createSaleCashReceiptVoucherForm',compact('Invoices'));
    }

    public function viewSaleBankReceiptVoucherList(){
        return view('Finance.viewSaleBankReceiptVoucherList');
    }
	public function pv_detail_show(){
		return view('Finance.pv_detail_show');
	}
    public function createSaleBankReceiptVoucherForm(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $Invoice = new Invoice;
        $Invoices = $Invoice::distinct()->where('inv_status','=','2')->where('invoiceType','=','3')->get(['inv_no','inv_date']);
        CommonHelper::reconnectMasterDatabase();

        return view('Finance.createSaleBankReceiptVoucherForm',compact('Invoices'));
    }

    public function viewPurchaseJournalVoucherList(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $currentMonthStartDate = date('Y-m-01');
        $currentMonthEndDate   = date('Y-m-t');
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
        return view('Finance.viewPurchaseJournalVoucherList',compact('accounts'));
    }

    public function viewSaleJournalVoucherList(){
        CommonHelper::companyDatabaseConnection($_GET['m']);
        $currentMonthStartDate = date('Y-m-01');
        $currentMonthEndDate   = date('Y-m-t');
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
        return view('Finance.viewSaleJournalVoucherList',compact('accounts'));
    }



    public function createEmployeeTaxForm()
    {
        $taxesList = Tax::where([['company_id','=',Input::get('m')],['status','=',1]])->get();
        $departmentList = Department::where([['company_id','=',Input::get('m')],['status','=',1]])->get();

        return view('Finance.createEmployeeTaxForm',compact('taxesList','departmentList'));
    }

    public function viewEmployeeTaxList()
    {

        CommonHelper::companyDatabaseConnection(Input::get('m'));
        $employeeTax = Employee::select('id','emp_name','tax_id','emp_department_id')->where([['status','=',1]])->get();
        CommonHelper::reconnectMasterDatabase();

        return view('Finance.viewEmployeeTaxList',compact('employeeTax'));
    }
    public function editEmployeeTaxDetailForm()
    {

        $taxesList = Tax::where([['company_id','=',Input::get('m')],['status','=',1]])->get();
        $departmentList = Department::where([['company_id','=',Input::get('m')],['status','=',1]])->get();
        CommonHelper::companyDatabaseConnection(Input::get('m'));
        $employeeTax = Employee::select('id','tax_id','emp_department_id')->where([['id','=',Input::get('id')]])->first();
        $employeeList = Employee::select('emp_name','id')->where([['emp_department_id','=',$employeeTax->emp_department_id]])->get();
        CommonHelper::reconnectMasterDatabase();

        return view('Finance.editEmployeeTaxDetailForm',compact('taxesList','departmentList','employeeTax','employeeList'));
    }


    public function createEmployeeEOBIForm()
    {
        $eobiList = Eobi::where([['company_id','=',Input::get('m')],['status','=',1]])->get();

        $departmentList = Department::where([['company_id','=',Input::get('m')],['status','=',1]])->get();

        return view('Finance.createEmployeeEOBIForm',compact('eobiList','departmentList'));
    }

    public function viewEmployeeEOBIList()
    {
        CommonHelper::companyDatabaseConnection(Input::get('m'));
        $employeeTax = Employee::select('id','emp_name','eobi_id','emp_department_id')->where([['status','=',1]])->get();
        CommonHelper::reconnectMasterDatabase();

        return view('Finance.viewEmployeeEOBIList',compact('employeeTax'));
    }

    public function editEmployeeEOBIDetailForm()
    {

        $eobiList = Eobi::where([['company_id','=',Input::get('m')],['status','=',1]])->get();
        $departmentList = Department::where([['company_id','=',Input::get('m')],['status','=',1]])->get();
        CommonHelper::companyDatabaseConnection(Input::get('m'));
        $employeeEobi = Employee::select('id','eobi_id','emp_department_id')->where([['id','=',Input::get('id')]])->first();
        $employeeList = Employee::select('emp_name','id')->where([['emp_department_id','=',$employeeEobi->emp_department_id]])->get();
        CommonHelper::reconnectMasterDatabase();

        return view('Finance.editEmployeeEOBIDetailForm',compact('eobiList','departmentList','employeeEobi','employeeList'));
    }


	public function viewPurchaseVoucherList()
	{

		$purchase_voucher=new PurchaseVoucher();
		$purchase_voucher=$purchase_voucher->SetConnection('mysql2');
		$purchase_voucher=$purchase_voucher->where('status',1)->where('pv_status',1)->select('id','pv_no','purchase_date','due_date','supplier','total_qty','total_rate','total_salesTax','total_salesTax_amount','total_net_amount')->get();

		$purchase_vouchergrn=new PurchaseVoucherThroughGrn();
		$purchase_vouchergrn=$purchase_vouchergrn->SetConnection('mysql2');
		$purchase_vouchergrn=$purchase_vouchergrn->where('status',1)->where('pv_status',2)->select('id','pv_no','grn_no','purchase_date','due_date','supplier','total_qty','total_rate','total_salesTax','total_salesTax_amount','total_net_amount')->get();
		return view('Finance.viewPurchaseVoucherList',compact('purchase_voucher','purchase_vouchergrn'));
	}


	public function createPaymentForOutstanding(Request $request,$type)

	{

		$val=$request->checkbox;

		$accounts = new Account;
		$accounts=$accounts->SetConnection('mysql2');
		$accounts = $accounts->where('status',1)->select('id','name','code')->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();

		return view('Finance.createPaymentForOutstanding',compact('accounts','val','type'));

	}

	public function CreateReceiptVoucherForSales(Request $request)

	{



		$type=$request->type;
		$val=$request->checkbox;

		$accounts = new Account;
		$accounts=$accounts->SetConnection('mysql2');
		$accounts = $accounts->where('status',1)->select('id','name','code')->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();
		if ($type=='pos'):
			return view('Sales.create_pos_receipt',compact('accounts','val'));
		else:
		return view('Finance.CreateSalesReceipt',compact('accounts','val'));
		endif;

	}

	public function CreateReceiptVoucherForCommercialInvoice(Request $request)
	{
		$val=$request->checkbox;

		$accounts = new Account;
		$accounts=$accounts->SetConnection('mysql2');
		$accounts = $accounts->where('status',1)->select('id','name','code')->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();
		
		return view('Finance.CreateCommercialInvoiceReceipt',compact('accounts','val'));
	}

	public function viewOutstanding_bills_through_jvs()
	{
		$supplier= new Supplier();
		$supplier=$supplier->SetConnection('mysql2');
		$supplier=$supplier->where('status',1)->get();

		$jvs= new Jvs();
		$jvs=$jvs->SetConnection('mysql2');
		$jvs=$jvs->where('purchase',1)->where('paid',0)->where('status',1)->get();


		return view('Finance.viewOutstanding_bills_through_jvs',compact('supplier','jvs'));
	}
	public function CreatePayment_through_jvs(Request $request,$type)

	{

		$val=$request->checkbox;

		$accounts = new Account;
		$accounts=$accounts->SetConnection('mysql2');
		$accounts = $accounts->where('status',1)->select('id','name','code')->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();
	 	$vendor=$request->supplier;

		return view('Finance.CreatePayment_through_jvs',compact('accounts','val','vendor'));

	}
	public function viewChartofAccountList(){
		CommonHelper::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts->where('status',1)->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();

		return view('Finance.viewChartofAccountList',compact('accounts'));
		CommonHelper::reconnectMasterDatabase();
	}
	public function viewChartofAccountListTwo(){
		CommonHelper::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts->where('status',1)->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();

		return view('Finance.viewChartofAccountListTwo',compact('accounts'));
		CommonHelper::reconnectMasterDatabase();
	}


	public function createPurchaseVoucherForm()

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


		return view('Finance.createPurchaseVoucherForm',compact('supplier','department'));
	}
	public function editPurchaseVoucherFormNew($id)

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
		$NewPurchaseVoucher = new NewPurchaseVoucher();
		$NewPurchaseVoucher = $NewPurchaseVoucher->SetConnection('mysql2');
		$NewPurchaseVoucher = $NewPurchaseVoucher->where('id',$id)->first();

		$NewPurchaseVoucherData = new NewPurchaseVoucherData();
		$NewPurchaseVoucherData = $NewPurchaseVoucherData->SetConnection('mysql2');
		$NewPurchaseVoucherData = $NewPurchaseVoucherData->where('master_id',$id)->Orderby('id','ASC')->get();
		$CountId = $NewPurchaseVoucherData->where('master_id',$id)->where('sub_item','!=','')->count();

		return view('Finance.editPurchaseVoucherFormNew',compact('supplier','department','id','NewPurchaseVoucher','NewPurchaseVoucherData','CountId'));
	}



	public function paidToCreateAndView()
	{

		$PaidTo=new PaidTo();
		$PaidTo=$PaidTo->SetConnection('mysql2');
		$PaidTo=$PaidTo->where('status',1)->get();

		return view('Finance.paidToCreateAndView',compact('PaidTo'));
	}

	public function createJournalVoucherNew(){
		CommonHelper::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts::where('status',1)->select('id','code','name','type')->orderBy('level1', 'ASC')
			->orderBy('level2', 'ASC')
			->orderBy('level3', 'ASC')
			->orderBy('level4', 'ASC')
			->orderBy('level5', 'ASC')
			->orderBy('level6', 'ASC')
			->orderBy('level7', 'ASC')
			->get();

		$PaidTo = new PaidTo();
		$PaidTo = $PaidTo::where('status','=','1')->get();

		CommonHelper::reconnectMasterDatabase();
		return view('Finance.createJournalVoucherNew',compact('accounts','PaidTo'));
	}

	public function purchaseVoucherListt(){
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
		$PurchaseVoucher = new NewPurchaseVoucher();
		$PurchaseVoucher = $PurchaseVoucher::where('status','=','1')->where('grn_no',"")->orderBy('id', 'DESC')->get()->take(50);
		$Supplier = new Supplier();
		$Supplier = $Supplier::where('status','=','1')->get();
		CommonHelper::reconnectMasterDatabase();
		return view('Finance.purchaseVoucherListt',compact('accounts','PurchaseVoucher','Supplier'));
	}


	public function general_general(Request $requests)
	{
		if ($requests->type!=''):
		$data=DB::Connection('mysql2')->table('transactions')->where('opening_bal',0)->where('voucher_type',$requests->type)->where('status',1)->orderBy('voucher_no','debit_credit')->get();
			else:
				$data=DB::Connection('mysql2')->table('transactions')->where('status',1)->where('opening_bal',0)->orderBy('voucher_no','debit_credit')->get();
				endif;

		return view('Finance.general_general',compact('data'));
	}

	public function sales_on_finance(Request $requests)
	{
		return view('Finance.sales_on_finance');
	}

	public function trial_balance_other_format()
	{
		return view('Finance.trial_balance_other_format');
	}
    public  function set_opening()
    {

        $databaseName = DB::connection('mysql2')->getDatabaseName();
       if($databaseName!='trackes1_murtaza_corporation_2021_2022'):
           echo 'Select Correct Database';
            die;

           endif;


       $data= DB::Connection('mysql2')->table('accounts')->where('status',1)->whereIn('level1', ['1', '2','3'])
       ->orderBy('level1')
       ->orderBy('level2')
       ->orderBy('level3')
       ->orderBy('level4')
       ->orderBy('level5')
       ->orderBy('level6')
       ->orderBy('level7')
       ->get();

       $financial_year = ReuseableCode::get_account_year_from_to(Session::get('run_company'));
       $from=$financial_year[0];
       $to=$financial_year[1];

       foreach ($data as $row):
           echo $row->name.'<br>';
        $debit=DB::Connection('mysql2')->selectOne('select sum(amount)amount from
        transactions
        where status=1
        and debit_credit=1
        and v_date between "'.$from.'" and "'.$to.'"
        and acc_id="'.$row->id.'"')->amount;

        $credit=DB::Connection('mysql2')->selectOne('select sum(amount)amount from
        transactions
        where status=1
        and debit_credit=0
        and v_date between
        "'.$from.'" and "'.$to.'"
        and acc_id="'.$row->id.'"')->amount;


        $closing= $debit - $credit;

        $code=$row->code;
        $nature=explode('-',$code);
        $nature=$nature[0];

       $debit_credit=0;

        if($nature==1):
        if($closing>=0):
        $debit_credit=1;
        elseif($closing<0):
            $closing=$closing*-1;
        $debit_credit = 0;
        endif;

        elseif($nature==2 || $nature==3):

            if($closing>=0):
                $debit_credit=1;
            elseif($closing<0):
                $closing = $closing *-1;
                $debit_credit =0;
            endif;
        endif;


    $entry_type=    DB::Connection('mysql3')->table('transactions')->where('acc_id',$row->id)->where('opening_bal',1)->where('status',1)->count();

    if ($entry_type==0):

        if ($closing!=0):
        $data1=array
        (
            'acc_id'=>$row->id,
            'acc_code'=>CommonHelper::get_account_code($row->id),
            'opening_bal'=>1,
            'debit_credit'=>$debit_credit,
            'v_date'=>'2022-07-01',
            'date'=>date('Y-m-d'),
            'amount'=>$closing,
            'username'=>'Amir Yaqoob',
        );

    DB::Connection('mysql3')->table('transactions')->insert($data1);
    endif;

        elseif ($entry_type==1):


        $data1=array
        (
            'debit_credit'=>$debit_credit,
            'amount'=>$closing,
            'date'=>date('Y-m-d'),
            'username'=>'Amir Yaqoob Update',
        );
            DB::Connection('mysql3')->table('transactions')
                 ->where('acc_id',$row->id)
                 ->where('opening_bal',1)
                ->update($data1);
        endif;

       endforeach;
    }


    public  function set_opening_stock()
    {
        $databaseName = DB::connection('mysql2')->getDatabaseName();
        if($databaseName!='trackes1_murtaza_corporation_2021_2022'):
            echo 'Select Correct Database';
            die;

        endif;
        $data= DB::Connection('mysql2')->table('stock')->where('status',1)
            ->groupBy('sub_item_id')
            ->groupBy('warehouse_id')
            ->groupBy('batch_code')
            ->get();



        foreach ($data as $row):


            $average_cost=ReuseableCode::average_cost_sales(
            $row->sub_item_id,
            $row->warehouse_id,
            $row->batch_code);


            $entry_type=    DB::Connection('mysql3')->table('stock')
                ->where('sub_item_id',$row->sub_item_id)
                ->where('warehouse_id',$row->warehouse_id)
                ->where('batch_code',$row->batch_code)
                ->where('status',1)->count();


            $qty=ReuseableCode::get_stock(
                $row->sub_item_id,
                $row->warehouse_id,
                0,
                $row->batch_code);

            if ($entry_type==0):

                if ($qty!=0):
                    $stock=array
                    (
                        'main_id'=>0,
                        'master_id'=>0,
                        'voucher_no'=>'',
                        'voucher_date'=>'2022-07-01',
                        'supplier_id'=>0,
                        'customer_id'=>0,
                        'voucher_type'=>1,
                        'rate'=>$average_cost,
                        'sub_item_id'=>$row->sub_item_id,
                        'batch_code'=>$row->batch_code,
                        'qty'=>$qty,
                        'discount_percent'=>0,
                        'discount_amount'=>0,
                        'amount'=>$qty*$average_cost,
                        'status'=>1,
                        'warehouse_id'=>$row->warehouse_id,
                        'username'=>'Amir Yaqoob',
                        'created_date'=>date('Y-m-d'),
                        'opening'=>1,
                    );
                    DB::Connection('mysql3')->table('stock')->insert($stock);
                endif;

            elseif ($entry_type==1):


                $stock=array
                (
                    'main_id'=>0,
                    'master_id'=>0,
                    'voucher_no'=>'',
                    'voucher_date'=>'2022-07-01',
                    'supplier_id'=>0,
                    'customer_id'=>0,
                    'voucher_type'=>1,
                    'rate'=>$average_cost,
                    'sub_item_id'=>$row->sub_item_id,
                    'batch_code'=>$row->batch_code,
                    'qty'=>$qty,
                    'discount_percent'=>0,
                    'discount_amount'=>0,
                    'amount'=>$qty*$average_cost,
                    'status'=>1,
                    'warehouse_id'=>$row->warehouse_id,
                    'username'=>'Amir Yaqoob Update',
                    'created_date'=>date('Y-m-d'),
                    'opening'=>1,
                );



                DB::Connection('mysql3')->table('stock')
                    ->where('sub_item_id',$row->sub_item_id)
                    ->where('warehouse_id',$row->warehouse_id)
                    ->where('batch_code',$row->batch_code)
                    ->where('status',1)
                    ->update($stock);
            endif;

        endforeach;
    }

    public function set_remining_stp(Request  $request)
    {

        $databaseName = DB::connection('mysql2')->getDatabaseName();
        if($databaseName!='trackes1_murtaza_corporation_2021_2022'):
            echo 'Select Correct Database';
            die;
            endif;

        $financial_year = ReuseableCode::get_account_year_from_to(Session::get('run_company'));
        $from=$financial_year[0];
        $to=$financial_year[1];

        $CustomerData = DB::Connection('mysql2')->select('select a.* from customers a
                                                              INNER JOIN sales_tax_invoice b ON b.buyers_id = a.id
                                                              where a.status = 1
                                                              and b.status = 1
                                                              and (b.gi_date between "'.$from.'" and "'.$to.'" or b.so_type=1)
                                                              group by b.buyers_id');

        foreach($CustomerData as $CustFil):




        $Invoice =    DB::Connection('mysql2')->select('select * from sales_tax_invoice
        where status=1
        and buyers_id="'.$CustFil->id.'"
        and (gi_date between "'.$from.'" and "'.$to.'" or so_type=1)');

            if((!empty($Invoice))):

                foreach($Invoice as $row):


                    CommonHelper::companyDatabaseConnection(Session::get('run_company'));
                    $data=SalesHelper::getTotalAmountSalesTaxInvoice($row->id);
                    $get_freight=SalesHelper::get_freight($row->id);
                    $customer=CommonHelper::byers_name($row->buyers_id);
                    $return_amount=SalesHelper::get_sales_return_from_sales_tax_invoice_by_date($row->id,$from,$to);

                    $rece = CommonHelper::bearkup_receievd($row->id,$from,$to);
                    CommonHelper::reconnectMasterDatabase();
                    $rema=$data->total+$get_freight-$return_amount-$rece;

                    if($rema > 0.5):



            $InsertData['buyer_id'] = $CustFil->id;
            $InsertData['date'] = $row->gi_date;
            $InsertData['si_no'] = $row->gi_no;
            $InsertData['so_no'] = $row->so_no;
            $InsertData['invoice_amount'] = $data->total+$get_freight;
            $InsertData['balance_amount'] = $rema;
            $InsertData['username'] = 'Amir Yaqoob';

            $data_count= DB::Connection('mysql3')->table('customer_opening_balance')->where('si_no',$row->gi_no)->count();

            if ($data_count==0):
                DB::Connection('mysql3')->table('customer_opening_balance')->insert($InsertData);
                else:
               DB::Connection('mysql3')->table('customer_opening_balance')->where('si_no',$row->gi_no)->update($InsertData);
                endif;

            static::insert_si($row->gi_no);



        endif;
            endforeach;
            endif;
        endforeach;
    }

    public static function insert_si($si_no)
    {
        $data=DB::Connection('mysql3')->table('customer_opening_balance')->where('si_no',$si_no)->first();
        $count_data=DB::Connection('mysql3')->table('sales_tax_invoice')->where('other_refrence',$data->si_no);


        $sales_tax_invoice = new SalesTaxInvoice();
        $sales_tax_invoice = $sales_tax_invoice->SetConnection('mysql3');

        if ($count_data->count()>0):
            $sales_tax_invoice = $sales_tax_invoice->find($count_data->first()->id);
        endif;


        $gi_no= SalesHelper::get_unique_no_sales_tax_invoice(date('y'),date('m'));
        $sales_tax_invoice->gi_no = $gi_no;
        $sales_tax_invoice->gi_date = $data->date;

        $sales_tax_invoice->so_id = 0;

        $cutomer= DB::Connection('mysql3')->table('customers')->where('id',$data->buyer_id)->select('id','terms_of_payment');
        $sales_tax_invoice->model_terms_of_payment = $cutomer->first()->terms_of_payment;
        $sales_tax_invoice->order_date = $data->date;
        $sales_tax_invoice->other_refrence = $data->si_no;
        $sales_tax_invoice->despacth_document_no = $data->so_no;
        $sales_tax_invoice->despacth_document_date = $data->date;
        $sales_tax_invoice->despacth_through = '';
        $sales_tax_invoice->destination = '';
        $sales_tax_invoice->terms_of_delivery = 0;
        $sales_tax_invoice->due_date = date('d-m-Y', strtotime($data->date. ' + '.$cutomer->first()->terms_of_payment.' days'));
        $sales_tax_invoice->status = 1;
        $sales_tax_invoice->username = 'Amir Yaqoob';
        $sales_tax_invoice->amount_in_words = '';
        $sales_tax_invoice->order_no = $data->so_no;
        $sales_tax_invoice->date = date('Y-m-d');
        $sales_tax_invoice->buyers_id = $cutomer->first()->id;
        $sales_tax_invoice->description = $data->si_no.'||'.$data->so_no;
        $sales_tax_data =0;
        $sales_tax_invoice->sales_tax = 0;
        $sales_tax_invoice->sales_tax_further =0;
        $sales_tax_invoice->acc_id = 0;
        $sales_tax_invoice->so_type = 1;
        $sales_tax_invoice->save();
        $id = $sales_tax_invoice->id;

        $count_data=DB::Connection('mysql3')->table('sales_tax_invoice_data')->where('gd_no',$data->si_no);


        $sales_tax_invoice_data = new SalesTaxInvoiceData();
        $sales_tax_invoice_data = $sales_tax_invoice_data->SetConnection('mysql3');

        if ($count_data->count()>0):
            $sales_tax_invoice_data = $sales_tax_invoice_data->find($count_data->first()->id);
        endif;
        $sales_tax_invoice_data->master_id = $id;
        $sales_tax_invoice_data->so_id = 0;

        $sales_tax_invoice_data->dn_data_ids = 0;
        $sales_tax_invoice_data->so_data_id = 0;

        $sales_tax_invoice_data->groupby =  1;
        // $sales_tax_invoice_data->gd_id = $request->delivery_note_id;
        $sales_tax_invoice_data->gi_no = $si_no;
        $sales_tax_invoice_data->so_no = $data->so_no;
        $sales_tax_invoice_data->gd_no = $data->si_no;


        $sales_tax_invoice_data->item_id = 0;

        $sales_tax_invoice_data->description = '';

        $qty = 0;
        $rate = 0;
        $amount = $data->balance_amount;
        $sales_tax_invoice_data->qty = 1;

        $sales_tax_invoice_data->rate = 1;
        $sales_tax_invoice_data->discount = 0;
        $sales_tax_invoice_data->discount_amount = 0;
        $sales_tax_invoice_data->amount = $amount;
        $sales_tax_invoice_data->warehouse_id = 0;
        $sales_tax_invoice_data->bundles_id = 0;
        $sales_tax_invoice_data->status = 1;
        $sales_tax_invoice_data->date = date('Y-m-d');
        $sales_tax_invoice_data->username = 'Amir Yaqoob';
        $sales_tax_invoice_data->so_type = 1;
        $sales_tax_invoice_data->save();
    }


    // public function add_pi()
    // {
    //   //  ini_set('max_execution_time', 180);
    //     $this->financial_year = ReuseableCode::get_account_year_from_to(Session::get('run_company'));
    //     $from=$this->financial_year[0];
    //     $to=$this->financial_year[1];
    //     $data=DB::Connection('mysql2')->select('select a.id,a.name from supplier as  a
    //                              inner join
    //                              new_purchase_voucher as b
    //                              on
    //                              a.id=b.supplier
    //                              where b.status=1
    //                              and (b.pv_date between "'.$from.'" and "'.$to.'" or grn_id=0)');

    //     foreach ($data as $row):


    //         $data1=DB::Connection('mysql2')->select('select * from new_purchase_voucher
    //                             where supplier="'.$row->id.'"
    //                             and (pv_date between "'.$from.'" and "'.$to.'" or grn_id=0)
    //                             and status=1');


    //         foreach($data1 as $row1):


    //             $purchase_amount=ReuseableCode::get_purchase_net_amount($row1->id);
    //             $rerun_amount=ReuseableCode::return_amount_by_date($row1->grn_id,2,$from,$to);
    //             $paid_amount=CommonHelper::PaymentPurchaseAmountCheck_aging($row1->id,$from,$to);
    //             $remaining_data=  $purchase_amount-$rerun_amount-$paid_amount;
    //             if ($remaining_data>0):
    //             $InsertData['vendor_id'] = $row->id;
    //             $InsertData['date'] = $row1->pv_date;
    //             $InsertData['pi_no'] = $row1->pv_no;
    //             $InsertData['po_no'] = $row1->grn_no;
    //             $InsertData['invoice_amount'] = $purchase_amount;
    //             $InsertData['balance_amount'] = $remaining_data;
    //             $InsertData['username'] = 'Amir YaqoobQ';

    //             $data_count= DB::Connection('mysql3')->table('vendor_opening_balance')->where('pi_no',$row1->pv_no)->count();

    //             if ($data_count==0):
    //             DB::Connection('mysql3')->table('vendor_opening_balance')->insert($InsertData);
    //             else:
    //                 DB::Connection('mysql3')->table('vendor_opening_balance')->where('pi_no',$row1->pv_no)->update($InsertData);
    //                 endif;
    //          //   static::set_pv($row1->pv_no);
    //             endif;
    //             endforeach;

    //    endforeach;
    // }

    public static function set_pv($pv_no)
    {
        $data=DB::Connection('mysql3')->table('vendor_opening_balance')->where('pi_no',$pv_no)->first();


        $count_data=DB::Connection('mysql3')->table('new_purchase_voucher')->where('slip_no',$data->pi_no);

        $pv_no=CommonHelper::uniqe_no_for_purcahseVoucher(date('y'),date('m'));
        $NewPurchaseVoucher = new NewPurchaseVoucher();
        $NewPurchaseVoucher = $NewPurchaseVoucher->SetConnection('mysql3');

        if ($count_data->count()>0):
            $NewPurchaseVoucher = $NewPurchaseVoucher->find($count_data->first()->id);
        endif;

        $NewPurchaseVoucher->pv_no      = $pv_no;
        $NewPurchaseVoucher->pv_date    = $data->date;
        $NewPurchaseVoucher->grn_no     = '';
        $NewPurchaseVoucher->grn_id     = '';
        $NewPurchaseVoucher->slip_no    = $data->pi_no;
        $NewPurchaseVoucher->bill_date  = $data->date;
        $NewPurchaseVoucher->due_date   = date('d-m-Y', strtotime($data->date. ' + 60 days'));;
        $NewPurchaseVoucher->purchase_type  =1;
        $NewPurchaseVoucher->supplier    = $data->vendor_id;
        $NewPurchaseVoucher->description = $data->pi_no.'||'.$data->po_no;
        $NewPurchaseVoucher->username    = 'Amir Yaqoob';
        $NewPurchaseVoucher->status      = 1;
        $NewPurchaseVoucher->pv_status   = 2;
        $NewPurchaseVoucher->date        = date('Y-m-d');
        $NewPurchaseVoucher->save();
        $master_id=$NewPurchaseVoucher->id;

        $count_data=DB::Connection('mysql3')->table('new_purchase_voucher_data')->where('slip_no',$data->pi_no);
        $NewPurchaseVoucherData = new NewPurchaseVoucherData();
        $NewPurchaseVoucherData = $NewPurchaseVoucherData->SetConnection('mysql3');
        if ($count_data->count()>0):
            $NewPurchaseVoucherData = $NewPurchaseVoucherData->find($count_data->first()->id);
        endif;

        $NewPurchaseVoucherData->master_id      = $master_id;
        $NewPurchaseVoucherData->pv_no          = $pv_no;
        $NewPurchaseVoucherData->slip_no    = $data->pi_no;
        $NewPurchaseVoucherData->grn_data_id    = '';
        $NewPurchaseVoucherData->category_id    = 0;
        $NewPurchaseVoucherData->sub_item       = 0;
        $NewPurchaseVoucherData->uom            = 0;
        $NewPurchaseVoucherData->qty            = 0;
        $NewPurchaseVoucherData->rate           = 0;
        $NewPurchaseVoucherData->amount         = $data->balance_amount;
        $NewPurchaseVoucherData->discount_amount         = 0;
        $NewPurchaseVoucherData->net_amount         = $data->balance_amount;
        $NewPurchaseVoucherData->staus          = 1;
        $NewPurchaseVoucherData->pv_status      = 2;
        $NewPurchaseVoucherData->username       = 'Amir yaqoob';
        $NewPurchaseVoucherData->date           = date('Y-m-d');
        $NewPurchaseVoucherData->save();
    }

}
