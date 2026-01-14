<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Imports\Imports\UploadChartOfAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::auth();

Route::get('logout', 'Auth\LoginController@logout', function () {
    return abort(404);
});
Route::get('login', function () {

    if (Auth::check()) {

        return Redirect::to('d');
    } else {
        return view('auth/login');
    }
});



Route::get('/abc', function () {
    $nexmo = app('Nexmo\Client');
    $nexmo->message()->send([
        'to'   => '923368980737',
        'from' => '923368980737',
        'text' => 'Using the instance to send a message.'
    ]);
});
Route::get('/', function () {

    if (Auth::check()) {


        return Redirect::to('d');
    } else {

        return view('Visitor.visitorDashboard');
    }
});
Route::get('login', array('as' => 'login', function () {
    return view('Visitor.visitorDashboard');
}));
Route::get('migrate', function () {
    Artisan::call('migrate');
    echo 'all migrations are successfully migrated.';
});
/* Visitor Module Starts Here*/
Route::get('/changeCompany', 'ClientController@changeCompany');
Route::group(['prefix' => 'visitor', 'before' => 'csrf'], function () {
    Route::get('/d', 'VisitorController@index');
    Route::get('/careers/{id?}', 'VisitorController@careers');
    Route::get('/ViewandApplyDetail/{id}/{company_id}', 'VisitorController@ViewandApplyDetail');
    Route::get('/ThankyouForApply', 'VisitorController@ThankyouForApply');
    Route::get('/quizTest', 'VisitorController@quizTest');

    Route::get('/viewQuizTestResult/{id}', 'VisitorController@viewQuizTestResult');
    Route::get('/viewEmployeeIQTestList', 'VisitorController@viewEmployeeIQTestList');
});


Route::group(['prefix' => 'vad', 'before' => 'csrf'], function () {
    Route::post('/addVisitorApplyDetail', 'VisitorAddDetailController@addVisitorApplyDetail');
});

/* Visitor Module Ends Here*/

Route::get('/dMaster', 'MasterController@index');
Route::get('/dClient', 'ClientController@index');
Route::get('/dCompany', 'CompanyController@index');
Route::get('/d', 'HomeController@index');



Route::get('/deleteMasterTableReceord', 'DeleteMasterTableRecordController@deleteMasterTableReceord');

//Start Company Database Record Delete

Route::group(['prefix' => 'fd', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::get('/deleteCompanyFinanceTwoTableRecords', 'FinanceDeleteController@deleteCompanyFinanceTwoTableRecords');

    Route::get('/repostCompanyFinanceTwoTableRecords', 'FinanceDeleteController@repostCompanyFinanceTwoTableRecords');

    Route::get('/approveCompanyFinanceTwoTableRecords', 'FinanceDeleteController@approveCompanyFinanceTwoTableRecords');
    //amir finance delete
    Route::get('/deletechartofaccount', 'FinanceDeleteController@deletechartofaccount');

    Route::get('/deleteCompanyFinanceThreeTableRecords', 'FinanceDeleteController@deleteCompanyFinanceThreeTableRecords');

    Route::get('/repostCompanyFinanceThreeTableRecords', 'FinanceDeleteController@repostCompanyFinanceThreeTableRecords');

    Route::get('/deleteEmployeeTax', 'FinanceDeleteController@deleteEmployeeTax');

    Route::get('/deleteEmployeeEOBI', 'FinanceDeleteController@deleteEmployeeEOBI');

    Route::get('/deletecostcenter', 'FinanceDeleteController@deletecostcenter');
});

Route::group(['prefix' => 'pd', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::get('/deleteCompanyPurchaseTwoTableRecords', 'PurchaseDeleteController@deleteCompanyPurchaseTwoTableRecords');

    Route::get('/repostCompanyPurchaseTwoTableRecords', 'PurchaseDeleteController@repostCompanyPurchaseTwoTableRecords');

    Route::get('/approveCompanyPurchaseTwoTableRecords', 'PurchaseDeleteController@approveCompanyPurchaseTwoTableRecords');



    Route::get('/deleteCompanyPurchaseThreeTableRecords', 'PurchaseDeleteController@deleteCompanyPurchaseThreeTableRecords');

    Route::get('/repostCompanyPurchaseThreeTableRecords', 'PurchaseDeleteController@repostCompanyPurchaseThreeTableRecords');

    Route::get('/approveCompanyPurchaseGoodsReceiptNote', 'PurchaseDeleteController@approveCompanyPurchaseGoodsReceiptNote');

    Route::get('/delete_records', 'PurchaseDeleteController@delete_records');
    Route::get('/delete_purchase_order', 'PurchaseDeleteController@delete_purchase_order');
    
    Route::get('/DeleteAgainForPO', 'PurchaseDeleteController@DeleteAgainForPO');
    Route::get('/reject_po', 'PurchaseDeleteController@reject_po');
});

Route::group(['prefix' => 'std', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::get('/deleteCompanyStoreThreeTableRecords', 'StoreDeleteController@deleteCompanyStoreThreeTableRecords');
    Route::get('/repostCompanyStoreThreeTableRecords', 'StoreDeleteController@repostCompanyStoreThreeTableRecords');
    Route::get('/approvePurchaseRequest', 'StoreDeleteController@approvePurchaseRequest');
    Route::get('/approvePurchaseRequestSale', 'StoreDeleteController@approvePurchaseRequestSale');
});
//End Company Database Record Delete


//Start Companies
Route::group(['prefix' => 'companies', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::get('/c', 'ClientCompaniesController@toDayActivity');
    Route::post('/addCompanyDetail', 'ClientCompaniesController@addCompanyDetail');
});
Route::get('/check_status', 'UserController@check_status');
Route::group(['prefix' => 'ccd', 'before' => 'csrf'], function () {
    $companiesList = DB::table('company')->select(['name', 'id', 'dbName'])->where('status', '=', '1')->get();
    foreach ($companiesList as $routeRow1) {
        Route::get('/' . $routeRow1->dbName . '', 'ClientController@clientCompanyMenu');
    }
});


Route::group(['prefix' => 'users', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::get('/add_notifications', 'UserController@add_notifications');
    Route::get('/get_behavior', 'UserController@get_behavior');
    Route::get('/get_notification_data', 'UserController@get_notification_data');
    Route::get('/notifications_list', 'UserController@notifications_list');
    Route::post('/insert_notifications', 'UserController@insert_notifications');
    Route::get('/warehouseRight', 'UserController@warehouseRight');
    Route::get('/UserLocation', 'UserController@UserLocation');
    Route::get('/UserCompanyLocation', 'UserController@UserCompanyLocation');
    Route::get('/UserDepartment', 'UserController@UserDepartment');
    Route::post('/warehouseRightPost', 'UserController@warehouseRightPost');

    Route::post('/addUserDetail', 'UserController@addUserDetail');
    Route::get('/updateCompactMode', 'UserController@updateCompactMode');
    Route::post('/delete-user', 'UserController@destroy');

});
//End Companies

//Start Finance
Route::group(['prefix' => 'finance', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::get('/paymentVoucherReturnList', 'FinanceController@paymentVoucherReturnList');
    Route::get('/flow_statement_page', 'FinanceController@flow_statement_page');
    Route::get('/f', 'FinanceController@toDayActivity');
    Route::get('/ccoa', 'FinanceController@ccoa');
    Route::get('/createAccountForm', 'FinanceController@createAccountForm');
    Route::get('/viewChartofAccountList', 'FinanceController@viewChartofAccountList');
    Route::get('/viewChartofAccountListTwo', 'FinanceController@viewChartofAccountListTwo');
    Route::get('/create_new_pv', 'FinanceController@create_new_pv');
    Route::get('/edit_new_pv/{id?}', 'FinanceController@edit_new_pv');
    Route::get('/new_pv_list', 'FinanceController@new_pv_list');
    Route::get('/view_new_pv_detail', 'FinanceController@view_new_pv_detail');
    Route::get('/usersList', 'FinanceController@usersList');
    Route::get('/createUserForm', 'FinanceController@createUserForm');
    Route::get('/filter_user_list', 'FinanceController@filter_user_list');
    Route::get('/update_user_password', 'FinanceController@update_user_password');
    Route::get('/commission', 'FinanceController@commission');
    Route::get('/get_commision_data', 'FinanceController@get_commision_data');
    Route::get('/set_opening', 'FinanceController@set_opening');
    Route::get('/set_opening_stock', 'FinanceController@set_opening_stock');
    Route::get('/set_remining_stp', 'FinanceController@set_remining_stp');
    Route::get('/add_pi', 'FinanceController@add_pi');

    Route::get('/sales_on_finance', 'FinanceController@sales_on_finance');
    Route::get('/trial_balance_other_format', 'FinanceController@trial_balance_other_format');

    Route::get('/activeInActiveUser', 'FinanceController@activeInActiveUser');



    Route::get('/viewTaxSectionList', 'FinanceController@viewTaxSectionList');
    Route::get('/viewJvsAllocation', 'FinanceController@viewJvsAllocation');
    Route::get('/viewTrialBalance', 'FinanceController@viewTrialBalance');
    Route::get('/viewBalanceSheet', 'FinanceController@viewBalanceSheet');
    Route::get('/viewBalanceSheetCopy', 'FinanceController@viewBalanceSheetCopy');
    Route::get('/trialBalanceReportPage', 'FinanceController@trialBalanceReportPage');


    Route::get('/viewIncomeStatement', 'FinanceController@viewIncomeStatement');
    Route::get('/supplierSummaryReport', 'FinanceController@supplierSummaryReport');
    Route::get('/receivableSummaryReport', 'FinanceController@receivableSummaryReport');
    Route::get('/employeeSummaryReport', 'FinanceController@employeeSummaryReport');
    Route::get('/general_general', 'FinanceController@general_general');




    Route::get('/addTaxSectionForm', 'FinanceController@addTaxSectionForm');
    Route::get('/pv_detail_show', 'FinanceController@pv_detail_show');

    //amir

    Route::get('/createDepartmentForm', 'FinanceController@createDepartmentForm');
    Route::get('/viewDepartmentList', 'FinanceController@viewDepartmentList');
    Route::get('/createCostCenterForm', 'FinanceController@createCostCenterForm');
    Route::get('/viewCostCenterList', 'FinanceController@viewCostCenterList');
    //end amir
    Route::post('/ccoa_detail', 'FinanceController@ccoa_detail');


    Route::get('/createJournalVoucherForm', 'FinanceController@createJournalVoucherForm');
    Route::get('/createJournalVoucherNew', 'FinanceController@createJournalVoucherNew');

    Route::get('/viewJournalVoucherList', 'FinanceController@viewJournalVoucherList');
    Route::get('/viewJournalVoucherNew', 'FinanceController@viewJournalVoucherNew');
    Route::get('/PurchaseVoucherList', 'FinanceController@PurchaseVoucherList');
    // Route::get('/PurchaseVoucherList','FinanceController@PurchaseVoucherList');

    Route::get('/purchaseVoucherListt', 'FinanceController@purchaseVoucherListt');

    Route::get('/editJournalVoucherForm', 'FinanceController@editJournalVoucherForm');

    Route::get('/createCashPaymentVoucherForm', 'FinanceController@createCashPaymentVoucherForm');
    Route::get('/viewCashPaymentVoucherList', 'FinanceController@viewCashPaymentVoucherList');
    Route::get('/PaymentVoucherList', 'FinanceController@PaymentVoucherList');
    Route::get('/paymentVoucherListImport', 'FinanceController@paymentVoucherListImport');

    Route::get('/editCashPaymentVoucherForm', 'FinanceController@editCashPaymentVoucherForm');


    Route::get('/createBankPaymentVoucherForm', 'FinanceController@createBankPaymentVoucherForm');
    Route::get('/createContraVoucher', 'FinanceController@createContraVoucher');

    //amir
    Route::post('/createPaymentForOutstanding/{id?}', 'FinanceController@createPaymentForOutstanding');
    Route::post('/CreatePayment_through_jvs/{id?}', 'FinanceController@CreatePayment_through_jvs');

    //end amir
    Route::get('/viewBankPaymentVoucherList', 'FinanceController@viewBankPaymentVoucherList');
    Route::get('/viewBankPaymentNewVoucherList', 'FinanceController@viewBankPaymentNewVoucherList');

    Route::get('/editBankPaymentVoucherForm', 'FinanceController@editBankPaymentVoucherForm');
    Route::get('/editContraVoucher/{id?}', 'FinanceController@editContraVoucher');
    Route::get('/viewContraVoucherList', 'FinanceController@viewContraVoucherList');

    Route::get('/createCashReceiptVoucherForm', 'FinanceController@createCashReceiptVoucherForm');
    Route::get('/viewCashReceiptVoucherList', 'FinanceController@viewCashReceiptVoucherList');
    Route::get('/editCashReceiptVoucherForm', 'FinanceController@editCashReceiptVoucherForm');
    //amir
    Route::get('/editCashPaymentVoucherForm/{id?}', 'FinanceController@editCashPaymentVoucherForm');
    Route::get('/editCashPVForm/{id?}', 'FinanceController@editCashPVForm');
    Route::get('/editBankPaymentNew/{id?}', 'FinanceController@editBankPaymentNew');
    Route::get('/editPurchaseVoucherFormNew/{id?}', 'FinanceController@editPurchaseVoucherFormNew');
    Route::get('/editJournalVoucherForm/{id?}', 'FinanceController@editJournalVoucherForm');
    Route::get('/editBankRv/{id?}', 'FinanceController@editBankRv');
    Route::get('/editCashRv/{id?}', 'FinanceController@editCashRv');
    Route::get('/editJv/{id?}', 'FinanceController@editJv');


    //ABDUL
    //Route::get('/editBankPaymentVoucherForm','FinanceController@editBankPaymentVoucherForm');
    Route::get('/editBankPaymentVoucherForm/{id?}', 'FinanceController@editBankPaymentVoucherForm');

    Route::get('/createBankReceiptVoucherForm', 'FinanceController@createBankReceiptVoucherForm');
    Route::get('/createBankRvNew', 'FinanceController@createBankRvNew');
    Route::get('/viewBankRvNew', 'FinanceController@viewBankRvNew');
    Route::get('/createCashRvNew', 'FinanceController@createCashRvNew');
    Route::get('/viewCashRvNew', 'FinanceController@viewCashRvNew');
    Route::get('/paidToExpenseReport', 'FinanceController@paidToExpenseReport');
    Route::get('/auditTrialReport', 'FinanceController@auditTrialReport');



    Route::get('/createBankPaymentNew', 'FinanceController@createBankPaymentNew');
    Route::get('/viewBankReceiptVoucherList', 'FinanceController@viewBankReceiptVoucherList');
    Route::get('/editBankReceiptVoucherForm/{id}', 'FinanceController@editBankReceiptVoucherForm');

    Route::get('/viewLedgerReport', 'FinanceController@viewLedgerReport');
    Route::get('/viewTrialBalanceReportAnotherPage', 'FinanceController@viewTrialBalanceReportAnotherPage');

    Route::get('/createPurchaseCashPaymentVoucherForm', 'FinanceController@createPurchaseCashPaymentVoucherForm');
    Route::get('/viewPurchaseCashPaymentVoucherList', 'FinanceController@viewPurchaseCashPaymentVoucherList');

    Route::get('/createPurchaseBankPaymentVoucherForm', 'FinanceController@createPurchaseBankPaymentVoucherForm');
    Route::get('/viewPurchaseBankPaymentVoucherList', 'FinanceController@viewPurchaseBankPaymentVoucherList');

    Route::get('/createSaleCashReceiptVoucherForm', 'FinanceController@createSaleCashReceiptVoucherForm');
    Route::get('/viewSaleCashReceiptVoucherList', 'FinanceController@viewSaleCashReceiptVoucherList');

    Route::get('/createSaleBankReceiptVoucherForm', 'FinanceController@createSaleBankReceiptVoucherForm');
    Route::get('/viewSaleBankReceiptVoucherList', 'FinanceController@viewSaleBankReceiptVoucherList');

    Route::get('/viewPurchaseJournalVoucherList', 'FinanceController@viewPurchaseJournalVoucherList');
    Route::get('/viewSaleJournalVoucherList', 'FinanceController@viewSaleJournalVoucherList');


    Route::get('/createEmployeeTaxForm', 'FinanceController@createEmployeeTaxForm');
    Route::get('/viewEmployeeTaxList', 'FinanceController@viewEmployeeTaxList');
    Route::get('/editEmployeeTaxDetailForm', 'FinanceController@editEmployeeTaxDetailForm');


    Route::get('/createEmployeeEOBIForm', 'FinanceController@createEmployeeEOBIForm');
    Route::get('/viewEmployeeEOBIList', 'FinanceController@viewEmployeeEOBIList');
    Route::get('/editEmployeeEOBIDetailForm', 'FinanceController@editEmployeeEOBIDetailForm');

    //amir
    Route::get('/viewPurchaseVoucherList', 'FinanceController@viewPurchaseVoucherList');
    Route::get('/payable_reports', 'FinanceController@payable_reports');

    Route::get('/viewOutstanding_bills_through_jvs', 'FinanceController@viewOutstanding_bills_through_jvs');
    //for sales receipt voucher
    Route::post('/CreateReceiptVoucherForSales/{id?}', 'FinanceController@CreateReceiptVoucherForSales');

    Route::get('/viewBookDay', 'FinanceController@viewBookDay');
    //end amir
    Route::get('/createPurchaseVoucherForm', 'FinanceController@createPurchaseVoucherForm');
    Route::get('/paidToCreateAndView', 'FinanceController@paidToCreateAndView');
    Route::get('/getDatabase', 'FinanceController@getDatabase');
    Route::get('/expenseVoucherForm', 'FinanceController@expenseVoucherForm');
    Route::get('/expenseVoucherList', 'FinanceController@expenseVoucherList');
    Route::get('/createOpeningPage', 'FinanceController@createOpeningPage');
});

Route::group(['prefix' => 'fad', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::post('/addAccountDetail', 'FinanceAddDetailControler@addAccountDetail');
    Route::post('/pos_payment', 'FinanceAddDetailControler@pos_payment');
    Route::post('/commision_form', 'FinanceAddDetailControler@commision_form');



    Route::post('/addTaxSectionDetail', 'FinanceAddDetailControler@addTaxSectionDetail');
    Route::post('/addPaidTo', 'FinanceAddDetailControler@addPaidTo');
    Route::post('/add_role', 'FinanceAddDetailControler@add_role');
    Route::post('/addSalesReceipt', 'FinanceAddDetailControler@addSalesReceipt');
    Route::post('/addJournalVoucherDetail', 'FinanceAddDetailControler@addJournalVoucherDetail');
    Route::post('/updateJournalVoucherDetail', 'FinanceEditDetailControler@updateJournalVoucherDetail');
    //amir
    Route::post('/addDepartmentForm', 'FinanceAddDetailControler@addDepartmentForm');
    Route::post('/addCostCenterForm', 'FinanceAddDetailControler@addCostCenterForm');
    Route::post('/editAccountDetail/{id?}', 'FinanceEditDetailControler@editAccountDetail');
    Route::post('/editCostCenterForm/{id?}', 'FinanceEditDetailControler@editCostCenterForm');

    //end amir


    Route::post('/editJournalPendingVoucherDetail', 'FinanceEditDetailControler@editJournalPendingVoucherDetail');
    Route::post('/editJournalApproveVoucherDetail', 'FinanceEditDetailControler@editJournalApproveVoucherDetail');

    Route::post('/addCashPaymentVoucherDetail', 'FinanceAddDetailControler@addCashPaymentVoucherDetail');
    Route::post('/editCashPaymentPendingVoucherDetail', 'FinanceEditDetailControler@editCashPaymentPendingVoucherDetail');
    Route::post('/editCashPaymentApproveVoucherDetail', 'FinanceEditDetailControler@editCashPaymentApproveVoucherDetail');
    Route::post('/editCashPaymentVoucherDetail', 'FinanceEditDetailControler@editCashPaymentVoucherDetail');

    Route::post('/addBankPaymentVoucherDetail', 'FinanceAddDetailControler@addBankPaymentVoucherDetail');
    Route::post('/updateBankPaymentVoucherDetail', 'FinanceEditDetailControler@updateBankPaymentVoucherDetail');
    Route::post('/addBankPaymentVoucherDetail_through_jvs', 'FinanceAddDetailControler@addBankPaymentVoucherDetail_through_jvs');
    Route::post('/editBankPaymentPendingVoucherDetail', 'FinanceEditDetailControler@editBankPaymentPendingVoucherDetail');
    Route::post('/editBankPaymentApproveVoucherDetail', 'FinanceEditDetailControler@editBankPaymentApproveVoucherDetail');


    Route::post('/addCashReceiptVoucherDetail', 'FinanceAddDetailControler@addCashReceiptVoucherDetail');
    Route::post('/editCashReceiptPendingVoucherDetail', 'FinanceEditDetailControler@editCashReceiptPendingVoucherDetail');
    Route::post('/editCashReceiptApproveVoucherDetail', 'FinanceEditDetailControler@editCashReceiptApproveVoucherDetail');

    Route::post('/addBankReceiptVoucherDetail', 'FinanceAddDetailControler@addBankReceiptVoucherDetail');
    Route::post('/addBankReceiptVoucherDetail_against_sales', 'FinanceAddDetailControler@addBankReceiptVoucherDetail_against_sales');
    Route::post('/updateBankReceiptVoucherDetail_against_sales', 'FinanceAddDetailControler@updateBankReceiptVoucherDetail_against_sales');
    Route::post('/addContraVoucherDetail', 'FinanceAddDetailControler@addContraVoucherDetail');
    Route::post('/updateContraVoucherDetail', 'FinanceEditDetailControler@updateContraVoucherDetail');

    Route::post('/editBankReceiptVoucherForm', 'FinanceEditDetailControler@editBankReceiptVoucherForm');
    Route::post('/editBankReceiptPendingVoucherDetail', 'FinanceEditDetailControler@editBankReceiptPendingVoucherDetail');
    Route::post('/editBankReceiptApproveVoucherDetail', 'FinanceEditDetailControler@editBankReceiptApproveVoucherDetail');

    Route::post('/addPurchaseCashPaymentVoucherDetail', 'FinanceAddDetailControler@addPurchaseCashPaymentVoucherDetail');
    Route::post('/addPurchaseBankPaymentVoucherDetail', 'FinanceAddDetailControler@addPurchaseBankPaymentVoucherDetail');

    Route::post('/addSaleCashReceiptVoucherDetail', 'FinanceAddDetailControler@addSaleCashReceiptVoucherDetail');
    Route::post('/addSaleBankReceiptVoucherDetail', 'FinanceAddDetailControler@addSaleBankReceiptVoucherDetail');

    Route::post('/addEmployeeTaxDetail', 'FinanceAddDetailControler@addEmployeeTaxDetail');

    Route::post('/addEmployeeEOBIDetail', 'FinanceAddDetailControler@addEmployeeEOBIDetail');
    Route::post('/addPaymentVoucherDetail', 'FinanceAddDetailControler@addPaymentVoucherDetail');
    Route::post('/updatePurchaseVoucher', 'FinanceAddDetailControler@updatePurchaseVoucher');
    Route::post('/addExpenseVoucherDetail', 'FinanceAddDetailControler@addExpenseVoucherDetail');
});


Route::group(['prefix' => 'fmfal', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {

    Route::get('/makeFormJournalVoucher', 'FinanceMakeFormAjaxLoadController@makeFormJournalVoucher');
    Route::get('/addMoreJournalDetailRows', 'FinanceMakeFormAjaxLoadController@addMoreJournalDetailRows');
    Route::get('/addJournalVoucherDetailRows_costing', 'FinanceMakeFormAjaxLoadController@addJournalVoucherDetailRows_costing');
    Route::get('/get_current_amount', 'FinanceMakeFormAjaxLoadController@get_current_amount');

    Route::get('/makeFormCashPaymentVoucher', 'FinanceMakeFormAjaxLoadController@makeFormCashPaymentVoucher');
    Route::get('/addMoreCashPvsDetailRows', 'FinanceMakeFormAjaxLoadController@addMoreCashPvsDetailRows');

    Route::get('/makeFormBankPaymentVoucher', 'FinanceMakeFormAjaxLoadController@makeFormBankPaymentVoucher');
    Route::get('/addMoreBankPvsDetailRows', 'FinanceMakeFormAjaxLoadController@addMoreBankPvsDetailRows');
    Route::get('/addMoreBankPvsDetailRows_costing', 'FinanceMakeFormAjaxLoadController@addMoreBankPvsDetailRows_costing');

    Route::get('/makeFormCashReceiptVoucher', 'FinanceMakeFormAjaxLoadController@makeFormCashReceiptVoucher');
    Route::get('/addMoreCashRvsDetailRows', 'FinanceMakeFormAjaxLoadController@addMoreCashRvsDetailRows');

    Route::get('/makeFormBankReceiptVoucher', 'FinanceMakeFormAjaxLoadController@makeFormBankReceiptVoucher');
    Route::get('/addMoreBankRvsDetailRows', 'FinanceMakeFormAjaxLoadController@addMoreBankRvsDetailRows');

    Route::get('/loadPurchaseCashPaymentVoucherDetailByGRNNo', 'FinanceMakeFormAjaxLoadController@loadPurchaseCashPaymentVoucherDetailByGRNNo');
    Route::get('/loadPurchaseBankPaymentVoucherDetailByGRNNo', 'FinanceMakeFormAjaxLoadController@loadPurchaseBankPaymentVoucherDetailByGRNNo');

    Route::get('/loadSaleCashReceiptVoucherDetailByInvoiceNo', 'FinanceMakeFormAjaxLoadController@loadSaleCashReceiptVoucherDetailByInvoiceNo');
    Route::get('/loadSaleBankReceiptVoucherDetailByInvoiceNo', 'FinanceMakeFormAjaxLoadController@loadSaleBankReceiptVoucherDetailByInvoiceNo');
    Route::get('/getBranchClientWise', 'FinanceMakeFormAjaxLoadController@getBranchClientWise');
    Route::get('/getRegionClusterWise', 'FinanceMakeFormAjaxLoadController@getRegionClusterWise');

    Route::get('/getBranchClientWiseSingle', 'FinanceMakeFormAjaxLoadController@getBranchClientWiseSingle');
    Route::get('/getBranchClientWiseLedger', 'FinanceMakeFormAjaxLoadController@getBranchClientWiseLedger');
    Route::get('/getAccount', 'FinanceMakeFormAjaxLoadController@getAccount');
    Route::get('/getEmpOrPaidToData', 'FinanceMakeFormAjaxLoadController@getEmpOrPaidToData');
});
Route::group(['prefix' => 'fdc', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::get('/viewJournalVoucherDetail', 'FinanceDataCallController@viewJournalVoucherDetail');
    Route::get('/viewJournalVoucherDetailPrint', 'FinanceDataCallController@viewJournalVoucherDetailPrint');
    Route::get('/viewBankRvDetailNew', 'FinanceDataCallController@viewBankRvDetailNew');
    Route::get('/viewBankRvDetailNewPrint', 'FinanceDataCallController@viewBankRvDetailNewPrint');

    Route::get('/viewCashRvDetailNew', 'FinanceDataCallController@viewCashRvDetailNew');
    Route::get('/viewCashRvDetailNewPrint', 'FinanceDataCallController@viewCashRvDetailNewPrint');

    Route::get('/vendor_summery', 'FinanceDataCallController@vendor_summery');
    Route::get('/vendor_summery_two', 'FinanceDataCallController@vendor_summery_two');
    Route::get('/getPayAble', 'FinanceDataCallController@getPayAble');
    Route::get('/get_rights', 'FinanceDataCallController@get_rights');
    Route::get('/com_delete', 'FinanceDataCallController@com_delete');
    Route::get('/trial_balance_other_format', 'FinanceDataCallController@trial_balance_other_format');

    Route::get('/receivablSummaryReport', 'FinanceDataCallController@receivablSummaryReport');
    Route::get('/employeeSummaryReport', 'FinanceDataCallController@employeeSummaryReport');


    Route::get('/viewPurchaseVoucherDetail', 'FinanceDataCallController@viewPurchaseVoucherDetail');
    Route::get('/viewCashPaymentVoucherDetail', 'FinanceDataCallController@viewCashPaymentVoucherDetail');
    Route::get('/viewBankPaymentVoucherDetail', 'FinanceDataCallController@viewBankPaymentVoucherDetail');
    Route::get('/viewBankPaymentVoucherDetailPrint', 'FinanceDataCallController@viewBankPaymentVoucherDetailPrint');

    Route::get('/viewExpenseVoucherDetail', 'FinanceDataCallController@viewExpenseVoucherDetail');
    Route::get('/viewBankPaymentVoucherDetailInDetail', 'FinanceDataCallController@viewBankPaymentVoucherDetailInDetail');
    Route::get('/viewBankPaymentVoucherDetailInDetailImport', 'FinanceDataCallController@viewBankPaymentVoucherDetailInDetailImport');

    Route::get('/viewBankPaymentVoucherDetailInDetailPrint', 'FinanceDataCallController@viewBankPaymentVoucherDetailInDetailPrint');

    Route::get('/viewBankPaymentVoucherDetailInDetailDirect', 'FinanceDataCallController@viewBankPaymentVoucherDetailInDetailDirect');

    Route::get('/viewCashReceiptVoucherDetail', 'FinanceDataCallController@viewCashReceiptVoucherDetail');
    Route::get('/viewBankReceiptVoucherDetail', 'FinanceDataCallController@viewBankReceiptVoucherDetail');
    Route::get('/viewContraVoucherDetail', 'FinanceDataCallController@viewContraVoucherDetail');
    Route::get('/get_new_pvs_list_ajax', 'FinanceDataCallController@get_new_pvs_list_ajax');

    //amir fdc
    Route::get('/createAccountFormAjax/{id?}/{PageName?}', 'FinanceDataCallController@createAccountFormAjax');
    Route::get('/editChartOfAccountForm/{id?}', 'FinanceDataCallController@editChartOfAccountForm');
    Route::post('/addChartOfAccount', 'FinanceDataCallController@addChartOfAccount');
    Route::get('/editCostCenterForm/{id?}', 'FinanceDataCallController@editCostCenterForm');

    Route::get('/filterJournalVoucherList', 'FinanceDataCallController@filterJournalVoucherList');
    Route::get('/tax_calculation', 'FinanceDataCallController@tax_calculation');
    Route::get('/fbr_tax_calculation', 'FinanceDataCallController@fbr_tax_calculation');
    Route::get('/pra_tax_calculation', 'FinanceDataCallController@pra_tax_calculation');
    Route::get('/srb_tax_calculation', 'FinanceDataCallController@srb_tax_calculation');
    Route::get('/income_tax_calculation', 'FinanceDataCallController@income_tax_calculation');

    //Show All Taxes Route
    Route::get('/showIncomeTaxWithholding', 'FinanceDataCallController@showIncomeTaxWithholding');
    Route::get('/showFbrSalesTaxWithholding', 'FinanceDataCallController@showFbrSalesTaxWithholding');
    Route::get('/showSrbSindhRevenue', 'FinanceDataCallController@showSrbSindhRevenue');
    Route::get('/showPunjabSalesTaxWithholding', 'FinanceDataCallController@showPunjabSalesTaxWithholding');
    Route::get('/showTaxesData', 'FinanceDataCallController@showTaxesData');
    Route::get('/ShowDetailData', 'FinanceDataCallController@ShowDetailData');


    Route::get('/filterCashPaymentVoucherList', 'FinanceDataCallController@filterCashPaymentVoucherList');
    Route::get('/filterBankPaymentVoucherList', 'FinanceDataCallController@filterBankPaymentVoucherList');
    Route::get('/filterCashReceiptVoucherList', 'FinanceDataCallController@filterCashReceiptVoucherList');
    Route::get('/filterBankReceiptVoucherList', 'FinanceDataCallController@filterBankReceiptVoucherList');
    Route::get('/loadFilterLedgerReport', 'FinanceDataCallController@loadFilterLedgerReport');
    Route::get('/paidToExpenseReport', 'FinanceDataCallController@paidToExpenseReport');
    Route::get('/AuditTrialReport', 'FinanceDataCallController@AuditTrialReport');


    Route::get('/filterContraVoucherList', 'FinanceDataCallController@filterContraVoucherList');
    Route::get('/filterPurchaseCashPaymentVoucherList', 'FinanceDataCallController@filterPurchaseCashPaymentVoucherList');
    Route::get('/filterPurchaseBankPaymentVoucherList', 'FinanceDataCallController@filterPurchaseBankPaymentVoucherList');
    Route::get('/filterBookDayList', 'FinanceDataCallController@filterBookDayList');


    Route::get('/filterSaleCashReceiptVoucherList', 'FinanceDataCallController@filterSaleCashReceiptVoucherList');
    Route::get('/filterSaleBankReceiptVoucherList', 'FinanceDataCallController@filterSaleBankReceiptVoucherList');

    Route::get('/filterPurchaseJournalVoucherList', 'FinanceDataCallController@filterPurchaseJournalVoucherList');
    Route::get('/filterSaleJournalVoucherList', 'FinanceDataCallController@filterSaleJournalVoucherList');
    Route::get('/getJvsDateAndAccontWise', 'FinanceDataCallController@getJvsDateAndAccontWise');
    //    For Sales Start
    Route::get('/getRvsDateAndAccontWiseForSales', 'FinanceDataCallController@getRvsDateAndAccontWiseForSales');
    //    For Sales End
    Route::get('/getBpvsDateAndAccontWise', 'FinanceDataCallController@getBpvsDateAndAccontWise');
    Route::get('/getCpvsDateAndAccontWise', 'FinanceDataCallController@getCpvsDateAndAccontWise');
    Route::get('/getCrvsDateAndAccontWise', 'FinanceDataCallController@getCrvsDateAndAccontWise');
    Route::get('/getBrvsDateAndAccontWise', 'FinanceDataCallController@getBrvsDateAndAccontWise');


    Route::get('/getOutstandingpvsDateAndAccontWise', 'FinanceDataCallController@getOutstandingpvsDateAndAccontWise');
    Route::get('/getOutstandingpvsDateAndAccontWiseImport', 'FinanceDataCallController@getOutstandingpvsDateAndAccontWiseImport');

    Route::get('/getprvsDateAndAccontWise', 'FinanceDataCallController@getprvsDateAndAccontWise');
    Route::get('/insertOpeningBalance', 'FinanceDataCallController@insertOpeningBalance');





    Route::get('/DeleteJvActivity', 'FinanceDataCallController@DeleteJvActivity');
    Route::get('/DeletePvActivity', 'FinanceDataCallController@DeletePvActivity');
    Route::get('/DeleteRvActivity', 'FinanceDataCallController@DeleteRvActivity');
    Route::get('/DeleteCvActivity', 'FinanceDataCallController@DeleteCvActivity');
    Route::get('/approvePurchaseVoucherDetail', 'FinanceDataCallController@approvePurchaseVoucherDetail');

    Route::get('/trialBalanceData', 'FinanceDataCallController@trialBalanceData');
    Route::get('/trialBalanceSheet', 'FinanceDataCallController@trialBalanceSheet');
    Route::get('/IncomeStatement', 'FinanceDataCallController@IncomeStatement');
    Route::get('/flow_statement_ajax', 'FinanceDataCallController@flow_statement_ajax');

    Route::get('/getDataSupplierWise', 'FinanceDataCallController@getDataSupplierWise');
    Route::get('/getSummaryLedgerDetail', 'FinanceDataCallController@getSummaryLedgerDetail');
    Route::get('/getTrialBalanceDataAjax', 'FinanceDataCallController@getTrialBalanceDataAjax');
    Route::get('/deleteNewPv', 'FinanceDataCallController@deleteNewPv');
});
Route::group(['middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::get('/bankList', 'BankController@bankList')->name('bankList');
    Route::get('/viewbankList', 'BankController@viewbankList')->name('viewbankList');
    Route::get('/createBankForm', 'BankController@createBankForm')->name('createBankForm');
    Route::post('/bankFormStore', 'BankController@bankFormStore')->name('bankFormStore');
    Route::get('/editBankForm/{id}', 'BankController@editBankForm')->name('editBankForm');
    Route::post('/updateBankForm/{id}', 'BankController@updateBankForm')->name('updateBankForm');
    Route::get('/deleteBank', 'BankController@deleteBank')->name('deleteBank');

    Route::get('/getCorrespondentBankDetail', 'BankController@getCorrespondentBankDetail')->name('getCorrespondentBankDetail');
});

//End Finance

Route::group(['prefix' => 'commodities', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::resource('/product', 'Accommodiaties\ProductController');
    Route::get('/createCategoryView', 'Accommodiaties\ProductController@createCategoryView')->name('product.createCategoryView');

    Route::get('/ListCategoryView', 'Accommodiaties\ProductController@ListCategoryView')->name('product.ListCategoryView');
    Route::get('/categories/{id}/edit', 'Accommodiaties\ProductController@ListCategoryedit')->name('category.edit');
    Route::post('/categories/{id}/update', 'Accommodiaties\ProductController@ListCategoryupdate')->name('category.update');



    Route::get('/createSubCategoryView', 'Accommodiaties\ProductController@createSubCategoryView')->name('product.createSubCategoryView');
    Route::get('/ListSubCategoryView', 'Accommodiaties\ProductController@ListSubCategoryView')->name('product.ListSubCategoryView');
    Route::get('/subcategories/{id}/edit', 'Accommodiaties\ProductController@Listsubcategoryedit')->name('subcategory.edit');
    Route::post('/subcategories/{id}/update', 'Accommodiaties\ProductController@Listsubcategoryupdate')->name('subcategories.update');



    Route::get('/createProductView', 'Accommodiaties\ProductController@createProductView')->name('product.createProductView');
    Route::get('/ListProductView', 'Accommodiaties\ProductController@ListProductView')->name('product.ListProductView');
    Route::get('/sub/variety/{id}/edit', 'Accommodiaties\ProductController@subvarietyedit')->name('product.sub.variety.edit');
    Route::post('/product/sub/variety/{id}/update', 'Accommodiaties\ProductController@ListSubVarietyupdate')->name('product.sub.variety.update');



    Route::get('/ListProductEdit/{id}', 'Accommodiaties\ProductController@ListProductEdit')->name('product.ListProductEdit');
    Route::post('/ListProductUpdate', 'Accommodiaties\ProductController@ListProductUpdate')->name('product.ListProductUpdate');
    Route::get('delete_product', 'Accommodiaties\ProductController@delete_product');
    Route::get('delete_Slab', 'Accommodiaties\ProductController@delete_Slab');
    Route::resource('/slab', 'Accommodiaties\SlabController');

    Route::get('/slab/{id}/edit', 'Accommodiaties\SlabController@edit')->name('slab.edit');
    Route::post('/slab/{id}/update', 'Accommodiaties\SlabController@update')->name('slab.update');


    Route::get('/createSlabTypeView', 'Accommodiaties\SlabController@createSlabTypeView')->name('slab.createSlabTypeView');
    Route::post('/addSlabType', 'Accommodiaties\SlabController@addSlabType')->name('slab.addSlabType');
    Route::get('/ShowVariety', 'Accommodiaties\ProductController@ShowVariety')->name('product.ShowVariety');
    Route::get('/UpdateVariety', 'Accommodiaties\ProductController@UpdateVariety')->name('product.UpdateVariety');
    Route::post('/SubmitVariety', 'Accommodiaties\ProductController@SubmitVariety')->name('product.SubmitVariety');
    Route::resource('/cropBased', 'Accommodiaties\CropBasedController');

    Route::get('/createItemView', 'Accommodiaties\ProductController@createItemView')->name('product.createItemView');
    Route::get('/ListItemView', 'Accommodiaties\ProductController@ListItemView')->name('product.ListItemView');
    Route::get('/ListItem/{id}/edit', 'Accommodiaties\ProductController@ListItemedit')->name('product.item.edit');
    Route::post('/ListItem/{id}/update', 'Accommodiaties\ProductController@Listitemupdate')->name('product.item.update');


    Route::get('/ImportDataItem', 'Accommodiaties\ProductController@importDataItem')->name('product.importDataItem');
    Route::get('/ImportDataslab', 'Accommodiaties\ProductController@importDataslab')->name('product.importDataslab');


    Route::get('/purchase-order/getProduct/{id}', 'Accommodiaties\PurchaseOrderController@getProduct')->name('purchase-order.getProduct');
    Route::get('/purchase-order/getVoucherNo', 'Accommodiaties\PurchaseOrderController@getVoucherNo')->name('purchase-order.getVoucherNo');
    Route::get('/purchase-order/getProductSlabsDetail', 'Accommodiaties\PurchaseOrderController@getProductSlabsDetail')->name('purchase-order.getProductSlabsDetail');
    Route::resource('/purchase-order', 'Accommodiaties\PurchaseOrderController');
    Route::resource('/qtyCalculation', 'Accommodiaties\QtyCalculationController');

    // Finish Good Crud

    Route::get('/createFinishGood', 'Accommodiaties\ProductController@createFinishGood')->name('product.createFinishGood');
    Route::get('/ListFinisgGood', 'Accommodiaties\ProductController@ListFinisgGood')->name('product.ListFinisgGood');
    Route::get('/ListFinisgGood/{id}/edit', 'Accommodiaties\ProductController@ListFGedit')->name('product.FG.edit');
    Route::post('/ListFinisgGood/{id}/update', 'Accommodiaties\ProductController@ListFGupdate')->name('product.FG.update');
});


Route::group(['prefix' => 'arrival', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::resource('/purchase_order', 'PurchaseOrderProductionController');
    Route::post('/update_slab',  'PurchaseOrderProductionController@update_slab');

    Route::get('/ViewPurchaseOrder', 'PurchaseOrderProductionController@ViewPurchaseOrder');
    Route::get('/delete_po', 'PurchaseOrderProductionController@delete_po');
    Route::post('/purchase/order/{id}/update', 'PurchaseOrderProductionController@purchase_order_update')->name('purchase_order.update');

    // inspection
    Route::resource('/inspection', 'InspectionController');
    Route::get('/ViewInspection', 'InspectionController@ViewInspection');
    Route::get('/getChecklist', 'InspectionController@getChecklist');
    Route::get('/getPOBalances', 'InspectionController@getPOBalances');
    Route::get('/getProductDescription/{id}', 'InspectionController@getProductDescription');
    Route::post('/approve/{id}', 'InspectionController@approveInspection');
    Route::post('/reject/{id}',  'InspectionController@rejectInspection');


    // final inspection
    Route::get('/final_inspection', 'InspectionController@final_inspection');
    Route::get('/final_inspection/create', 'InspectionController@create_final_inspection');
    Route::post('/final_inspection/store', 'InspectionController@store_final_inspection')->name('finalinspection.store');
    Route::get('/ViewFinalInspection', 'InspectionController@ViewFinalInspection');
    Route::get('/getChecklistFinal/{id}', 'InspectionController@getChecklistFinal');  
    Route::get('/getProductDescriptionForFinal/{id}', 'InspectionController@getProductDescriptionForFinal');
    Route::post('/rejectFinalInspection/{id}',  'InspectionController@rejectFinalInspection');
    Route::post('/approveFinalInspection/{id}', 'InspectionController@approveFinalInspection');
    Route::get('/get_final_insepction_no', 'InspectionController@get_final_insepction')->name('final_inspection');
    Route::get('/get_Po_Details', 'InspectionController@get_Po_Details')->name('get_Po_Details');


    Route::get('/po_bill_check', 'PurchaseOrderProductionController@po_bill_check');


    Route::get('/po_bill_check', 'PurchaseOrderProductionController@po_bill_check');
    Route::get('/po_bill_check_view', 'PurchaseOrderProductionController@po_bill_check_view');

    Route::get('/po_bill_check/create', 'PurchaseOrderProductionController@po_bill_check_create');
    Route::post('/po_bill_check_store', 'PurchaseOrderProductionController@po_bill_check_store')->name('billcheck.store');
    Route::get('/getPoDataForBillCheck', 'PurchaseOrderProductionController@po_bill_check_create');

    // second inspection 
    Route::get('/second_inspection', 'InspectionController@second_inspection');
    Route::get('/second_inspection/create', 'InspectionController@create_second_inspection');
    Route::post('/second_inspection/store', 'InspectionController@store_second_inspection')->name('secondinspection.store');
    Route::get('/ViewSecondInspection', 'InspectionController@ViewSecondInspection');
    Route::get('/getChecklistSecond/{id}', 'InspectionController@getChecklistSecond');  
    Route::get('/getProductDescriptionForSecond/{id}', 'InspectionController@getProductDescriptionForSecond');
    Route::post('/rejectSecondInspection/{id}',  'InspectionController@rejectSecondInspection');
    Route::post('/approveSecondInspection/{id}', 'InspectionController@approveSecondInspection');
    Route::get('/get_second_insepction_no', 'InspectionController@get_second_insepction')->name('second_inspection_no');
    // gate
    Route::resource('/getpass','GateController');
    Route::get('/Viewgatepass', 'GateController@Viewgatepassin');
    Route::get('/get_po_product/{id}', 'GateController@getproduct');
    Route::get('/get_inspection_no', 'GateController@get_inspection_no');
    
    // gate pass out 
    Route::get('/getpass_out','GateController@getpass_out');
    Route::get('/getpass_out/create','GateController@getpass_out_create');
    Route::post('/getpass_out/store','GateController@getpass_out_store')->name('getpassout.store');
    Route::get('/Viewgatepassout', 'GateController@Viewgatepassout');

    //  Weighbridge
    Route::resource('/weighbridge','WeighbridgeController');

    Route::get('/second_weighbridge', 'WeighbridgeController@second_weighbridge');
    Route::get('/second_weighbridge/create', 'WeighbridgeController@create_second_weighbridge');
    Route::post('/second_weighbridge/store', 'WeighbridgeController@store_second_weighbridge')->name('secondweighbridge.store');
    Route::get('/ViewSecondweighbridge', 'WeighbridgeController@ViewSecondweighbridge');
    Route::get('/get_webridge/{id}', 'WeighbridgeController@get_webridge');
    
    Route::get('/Viewweighbridge','WeighbridgeController@Viewweighbridge');
    // Route::get('/weighbridgeTranfer','WeighbridgeController@weighbridgeTranfer');
    // Route::post('/storeweighbridgeTranfer','WeighbridgeController@storeweighbridgeTranfer')->name('weighbridgeTranfer.store');

    
    //  arrivalslip
    Route::resource('/arrivalslip','ArrivalSlipController');
    Route::get('/get_arrival_inspection_no', 'ArrivalSlipController@get_arrival_inspection_no')->name('arrival_inspection_no');
    
    Route::get('/Viewarrivalslip', 'ArrivalSlipController@ViewArrivalSlip');


    // Route::get('/create_purchase_order', 'PurchaseOrderProductionController@create');


    // inspection
    // Route::get('/viewinspection', 'InspectionController@index');
    // Route::get('/Viewinspection/{id}', 'InspectionController@create');

    
    // Route::post('/store_purchase_order', 'PurchaseOrderProductionController@store')->name('prod_po.store');
    Route::get('/getsubcategory/{id}', 'PurchaseOrderProductionController@getsubcategory');
    Route::get('/getVoucherNo', 'PurchaseOrderProductionController@getVoucherNo');
    Route::get('/getVarietyParams', 'PurchaseOrderProductionController@getVarietyParams');
    Route::get('/getSubVarietyAgainstCategory', 'PurchaseOrderProductionController@getSubVarietyAgainstCategory');

    Route::get('/getproduct/{id}', 'PurchaseOrderProductionController@getproduct');
    Route::get('/get_subitem/{id}', 'PurchaseOrderProductionController@get_subitem');
    Route::get('/get_item/{id}', 'PurchaseOrderProductionController@get_item');
    Route::resource('/quality_checker', 'QualityCheckerController');
    Route::get('/add_qc', 'QualityCheckerController@create');
    Route::post('/submit_qc', 'QualityCheckerController@store');

    Route::resource('/conversions', 'ConversionMasterController');   
});

Route::group(['prefix' => 'jo', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
});



Route::group(['prefix' => 'export', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {

    Route::post('/importExcelData','ExportPakingListController@importExcelData')->name('importExcelData');
    Route::get('/saleOrderCreate', 'StoreController@saleOrderCreate')->name('saleOrderCreate');
    Route::get('/getCustomerDetails', 'StoreController@getCustomerDetails')->name('getCustomerDetails');
    Route::get('/getBankDetails', 'StoreController@getBankDetails')->name('getBankDetails');


    Route::get('/saleOrderEdit', 'SaleOrderExportController@saleOrderEdit')->name('saleOrderEdit');
    Route::post('/saleOrderUpdateDetail', 'SaleOrderExportController@saleOrderUpdateDetail')->name('saleOrderUpdateDetail');

    
    Route::get('/editExportInvoice/{id}', 'ExportInvoiceController@editExportInvoice')->name('editExportInvoice');
    Route::post('/exportInvoiceUpdateDetail', 'ExportInvoiceController@exportInvoiceUpdateDetail')->name('exportInvoiceUpdateDetail');
    

    Route::get('/getPackSize', 'StoreController@getPackSize')->name('getPackSize');
    

    Route::post('/saleOrderStore', 'SaleOrderExportController@saleOrderStore')->name('saleOrderStore');
    Route::get('/saleOrderList', 'SaleOrderExportController@saleOrderList')->name('saleOrderList');
    Route::get('/getSalesOrderfilter', 'SaleOrderExportController@getSalesOrderfilter')->name('getSalesOrderfilter');
    Route::get('/viewSalesOrderDetail/{id?}', 'SaleOrderExportController@viewSalesOrderDetail');
    Route::get('/viewSaleExportVoucher/{id?}', 'SaleOrderExportController@viewSaleExportVoucher');
    Route::get('/deleteSalesOrder', 'SaleOrderExportController@deleteSalesOrder');
    Route::get('/updateApprovedStatus', 'SaleOrderExportController@updateApprovedStatus');



    // Rate conversion
    Route::get('/viewRateList', 'CurrencyRateController@viewRateList')->name('viewRateList');
    Route::get('/viewRateListAjax', 'CurrencyRateController@viewRateListAjax')->name('viewRateListAjax');
    Route::get('/rateCreateForm', 'CurrencyRateController@rateCreateForm');
    Route::post('/rateStore', 'CurrencyRateController@rateStore')->name('rateStore');
    Route::get('/rateEditForm/{id}', 'CurrencyRateController@rateEditForm')->name('rateEditForm');
    Route::post('/rateUpdate/{id}', 'CurrencyRateController@rateUpdate')->name('rateUpdate');
    Route::get('/rateDelete', 'CurrencyRateController@rateDelete');

    //  IncoTerms

    Route::get('/viewIncotermList', 'IncoTermController@viewIncotermList')->name('viewIncotermList');
    Route::get('/viewIncotermListAjax', 'IncoTermController@viewIncotermListAjax')->name('viewIncotermListAjax');
    Route::get('/incotermCreateForm', 'IncoTermController@incotermCreateForm');
    Route::post('/incotermStore', 'IncoTermController@incotermStore')->name('incotermStore');
    Route::get('/incotermEditForm/{id}', 'IncoTermController@incotermEditForm')->name('incotermEditForm');
    Route::post('/incotermUpdate/{id}', 'IncoTermController@incotermUpdate')->name('incotermUpdate');
    Route::get('/incotermDelete', 'IncoTermController@incotermDelete');

    //  Port
    Route::get('/viewPortList', 'PortController@viewPortList')->name('viewPortList');
    Route::get('/viewPortListAjax', 'PortController@viewPortListAjax')->name('viewPortListAjax');
    Route::get('/portCreateForm', 'PortController@portCreateForm')->name('portCreateForm');
    Route::post('/portStore', 'PortController@portStore')->name('portStore');
    Route::get('/portEditForm/{id}', 'PortController@portEditForm')->name('portEditForm');
    Route::post('/portUpdate/{id}', 'PortController@portUpdate')->name('portUpdate');
    Route::get('/portDelete', 'PortController@portDelete');

    //  Origin
    Route::get('/viewOriginList', 'OriginController@viewOriginList')->name('viewOriginList');
    Route::get('/viewOriginListAjax', 'OriginController@viewOriginListAjax')->name('viewOriginListAjax');
    Route::get('/originCreateForm', 'OriginController@originCreateForm')->name('originCreateForm');
    Route::post('/originStore', 'OriginController@originStore')->name('originStore');
    Route::get('/originEditForm/{id}', 'OriginController@originEditForm')->name('originEditForm');
    Route::post('/originUpdate/{id}', 'OriginController@originUpdate')->name('originUpdate');
    Route::get('/originDelete', 'OriginController@originDelete');

    //  Consignee
    Route::get('/viewConsigneeList', 'ConsigneeController@viewConsigneeList')->name('viewConsigneeList');
    Route::get('/viewConsigneeListAjax', 'ConsigneeController@viewConsigneeListAjax')->name('viewConsigneeListAjax');
    Route::get('/consigneeCreateForm', 'ConsigneeController@consigneeCreateForm')->name('consigneeCreateForm');
    Route::post('/consigneeStore', 'ConsigneeController@consigneeStore')->name('consigneeStore');
    Route::get('/consigneeEditForm/{id}', 'ConsigneeController@consigneeEditForm')->name('consigneeEditForm');
    Route::post('/consigneeUpdate/{id}', 'ConsigneeController@consigneeUpdate')->name('consigneeUpdate');
    Route::get('/consigneeDelete', 'ConsigneeController@consigneeDelete');

    //  Grade
    Route::get('/viewGradeList', 'GradeController@viewGradeList')->name('viewGradeList');
    Route::get('/viewGradeListAjax', 'GradeController@viewGradeListAjax')->name('viewGradeListAjax');
    Route::get('/gradeCreateForm', 'GradeController@gradeCreateForm')->name('gradeCreateForm');
    Route::post('/gradeStore', 'GradeController@gradeStore')->name('gradeStore');
    Route::get('/gradeEditForm/{id}', 'GradeController@gradeEditForm')->name('gradeEditForm');
    Route::post('/gradeUpdate/{id}', 'GradeController@gradeUpdate')->name('gradeUpdate');
    Route::get('/gradeDelete', 'GradeController@gradeDelete');

    //  Size
    Route::get('/viewSizeList', 'SizeController@viewSizeList')->name('viewSizeList');
    Route::get('/viewSizeListAjax', 'SizeController@viewSizeListAjax')->name('viewSizeListAjax');
    Route::get('/sizeCreateForm', 'SizeController@sizeCreateForm')->name('sizeCreateForm');
    Route::post('/sizeStore', 'SizeController@sizeStore')->name('sizeStore');
    Route::get('/sizeEditForm/{id}', 'SizeController@sizeEditForm')->name('sizeEditForm');
    Route::post('/sizeUpdate/{id}', 'SizeController@sizeUpdate')->name('sizeUpdate');
    Route::get('/sizeDelete', 'SizeController@sizeDelete');

    //  Packing
    Route::get('/viewPackingList', 'PackingController@viewPackingList')->name('viewPackingList');
    Route::get('/viewPackingListAjax', 'PackingController@viewPackingListAjax')->name('viewPackingListAjax');
    Route::get('/packingCreateForm', 'PackingController@packingCreateForm')->name('packingCreateForm');
    Route::post('/packingStore', 'PackingController@packingStore')->name('packingStore');
    Route::get('/packingEditForm/{id}', 'PackingController@packingEditForm')->name('packingEditForm');
    Route::post('/packingUpdate/{id}', 'PackingController@packingUpdate')->name('packingUpdate');
    Route::get('/packingDelete', 'PackingController@packingDelete');

    //  Mode Of Term 
    Route::get('/modeoftermList', 'ModeOfTermController@modeoftermList')->name('modeoftermList');
    Route::get('/modeoftermListAjax', 'ModeOfTermController@modeoftermListAjax')->name('modeoftermListAjax');
    Route::get('/modeoftermCreateForm', 'ModeOfTermController@modeoftermCreateForm');
    Route::post('/modeoftermStore', 'ModeOfTermController@modeoftermStore')->name('modeoftermStore');
    Route::get('/modeoftermEditForm/{id}', 'ModeOfTermController@modeoftermEditForm')->name('modeoftermEditForm');
    Route::post('/modeoftermUpdate/{id}', 'ModeOfTermController@modeoftermUpdate')->name('modeoftermUpdate');
    Route::get('/modeoftermDelete', 'ModeOfTermController@modeoftermDelete');

    // Mode of transport
    Route::get('/modeOfTransportList', 'ModeOfTransportController@modeOfTransportList')->name('modeOfTransportList');
    Route::get('/modeOfTransportListAjax', 'ModeOfTransportController@modeOfTransportListAjax')->name('modeOfTransportListAjax');
    Route::get('/modeOfTransportCreateForm', 'ModeOfTransportController@modeOfTransportCreateForm');
    Route::post('/modeOfTransportStore', 'ModeOfTransportController@modeOfTransportStore')->name('modeOfTransportStore');
    Route::get('/modeOfTransportEditForm/{id}', 'ModeOfTransportController@modeOfTransportEditForm')->name('modeOfTransportEditForm');
    Route::post('/modeOfTransportUpdate/{id}', 'ModeOfTransportController@modeOfTransportUpdate')->name('modeOfTransportUpdate');
    Route::get('/modeOfTransportDelete', 'ModeOfTransportController@modeOfTransportDelete');

    //sale Order

    // Proforma  
    Route::get('/proformaList', 'ExportPerformaController@proformaList')->name('proformaList');
    Route::get('/proformaListListAjax', 'ExportPerformaController@proformaListListAjax')->name('proformaListListAjax');
    Route::get('/proformaViewDeatils', 'ExportPerformaController@proformaViewDeatils')->name('proformaViewDeatils');


    Route::get('/proformaCreateForm/{id}', 'ExportPerformaController@proformaCreateForm')->name('proformaCreateForm');
    Route::post('/proformaStore', 'ExportPerformaController@proformaStore')->name('proformaStore');
    Route::get('/createdProformaList', 'ExportPerformaController@createdProformaList')->name('createdProformaList');
    Route::get('/createdProformaAjax', 'ExportPerformaController@createdProformaAjax')->name('createdProformaAjax');
    Route::get('/proformaEditForm/{id}', 'ExportPerformaController@proformaEditForm')->name('proformaEditForm');
    Route::post('/proformaUpdate/{id}', 'ExportPerformaController@proformaUpdate')->name('proformaUpdate');
    Route::get('/proformaDelete', 'ExportPerformaController@proformaDelete');

    Route::get('/proformaInvoice', 'ExportPerformaController@proformaInvoice')->name('proformaInvoice');
    //  Invoice Start
    Route::get('/createExportInvoiceList', 'ExportInvoiceController@createExportInvoiceList')->name('createExportInvoiceList');
    Route::get('/createExportInvoiceListAjax', 'ExportInvoiceController@createExportInvoiceListAjax')->name('createExportInvoiceListAjax');
    Route::get('/createExportInvoice/{id}', 'ExportInvoiceController@createExportInvoice')->name('createExportInvoice');
    Route::post('/storeExportInvoice', 'ExportInvoiceController@storeExportInvoice')->name('storeExportInvoice');
    Route::get('/invoiceList', 'ExportInvoiceController@invoiceList')->name('invoiceList');
    Route::get('/invoiceListAjax', 'ExportInvoiceController@invoiceListAjax')->name('invoiceListAjax');
    Route::get('/viewInvoiceOrderDetail/{id?}', 'ExportInvoiceController@viewInvoiceOrderDetail');

    Route::get('/invoiceCertificate', 'ExportInvoiceController@invoiceCertificate')->name('invoiceCertificate');
    Route::get('/billOfLoading', 'ExportInvoiceController@billOfLoading')->name('billOfLoading');
    //  End Invoice

    Route::get('/createExportPaking/{id?}', 'ExportPakingListController@createExportPaking')->name('createExportPaking');
    Route::post('/createExportPakingImport', 'ExportPakingListController@createExportPakingImport')->name('createExportPakingImport');
    Route::post('pakingListStore', 'ExportPakingListController@pakingListStore')->name('pakingListStore');


    Route::get('/importPakingList', 'ExportPakingListController@importPakingList')->name('importPakingList');
    Route::get('/importPakingListAjax', 'ExportPakingListController@importPakingListAjax')->name('importPakingListAjax');

    Route::get('/viewPaking', 'ExportPakingListController@viewPaking');
    Route::get('/viewpakingListInvoice', 'ExportPakingListController@viewpakingListInvoice');


    Route::get('/pakingListInvoiceEdit', 'ExportPakingListController@pakingListInvoiceEdit');
    Route::post('/pakingListUpdate', 'ExportPakingListController@pakingListUpdate');

    //BillOfLading

    Route::get('/packagingListForCreateBillOfLading', 'ExportBillOfLadingController@packagingListForCreateBillOfLading')->name('packagingListForCreateBillOfLading');
    Route::get('/packagingListForCreateBillOfLadingAjax', 'ExportBillOfLadingController@packagingListForCreateBillOfLadingAjax')->name('packagingListForCreateBillOfLadingAjax');

    Route::get('/createBillOfLading/{id}', 'ExportBillOfLadingController@createBillOfLading')->name('createBillOfLading');
    Route::get('/editBillOfLading/{id}', 'ExportBillOfLadingController@editBillOfLading')->name('editBillOfLading');
    Route::post('storeBillOfLading', 'ExportBillOfLadingController@storeBillOfLading')->name('storeBillOfLading');
    Route::post('updateBillOfLading/{id}', 'ExportBillOfLadingController@updateBillOfLading')->name('updateBillOfLading');
    
    Route::get('/billOfLadingList', 'ExportBillOfLadingController@billOfLadingList')->name('billOfLadingList');
    Route::get('/billOfLadingListAjax', 'ExportBillOfLadingController@billOfLadingListAjax')->name('billOfLadingListAjax');
    
    Route::get('/viewBillOfLadingDetail', 'ExportBillOfLadingController@viewBillOfLadingDetail')->name('viewBillOfLadingDetail');
    
    
    //export duties
    Route::get('/createDutiesList', 'ExportDutiesClearingController@createDutiesList')->name('createDutiesList');
    Route::get('/createDutiesListAjax', 'ExportDutiesClearingController@createDutiesListAjax')->name('createDutiesListAjax');

    Route::get('/createDuties/{id}', 'ExportDutiesClearingController@createDuties')->name('createDuties');
    Route::post('dutiesClearingStore', 'ExportDutiesClearingController@dutiesClearingStore')->name('dutiesClearingStore');

    Route::get('/DutiesList', 'ExportDutiesClearingController@DutiesList')->name('DutiesList');
    Route::get('/DutiesListAjax', 'ExportDutiesClearingController@DutiesListAjax')->name('DutiesListAjax');

    Route::get('/createPakingList', 'ExportPakingListController@createPakingList')->name('createPakingList');
    Route::get('/createPakingListAjax', 'ExportPakingListController@createPakingListAjax')->name('createPakingListAjax');



    Route::get('/fumigationCertificate', 'ExportDutiesClearingController@fumigationCertificate')->name('fumigationCertificate');
    Route::get('/originertificate', 'ExportDutiesClearingController@originertificate')->name('originertificate');
    Route::get('/clearingCertificate', 'ExportDutiesClearingController@clearingCertificate')->name('clearingCertificate');
    Route::get('/qualityDeclaration', 'ExportDutiesClearingController@qualityDeclaration')->name('qualityDeclaration');

    Route::get('/qualityPacking', 'ExportDutiesClearingController@qualityPacking')->name('qualityPacking');
    Route::get('/packingListCertificate', 'ExportPakingListController@packingListCertificate')->name('packingListCertificate');

    // 
    Route::get('/createCertificate/{id}/{key}', 'ExportDutiesClearingController@createFumigation')->name('createCertificate');
    Route::post('/createFumigationStore', 'ExportDutiesClearingController@createFumigationStore')->name('createFumigationStore');
    Route::post('/OriginStore', 'ExportDutiesClearingController@OriginStore')->name('OriginStore');
    Route::post('/clearanceStore', 'ExportDutiesClearingController@clearanceStore')->name('clearanceStore');
    Route::post('/qualityDeclearationStore', 'ExportDutiesClearingController@qualityDeclearationStore')->name('qualityDeclearationStore');
    Route::post('/qualityPackingStore', 'ExportDutiesClearingController@qualityPackingStore')->name('qualityPackingStore');

    Route::get('/editCertificate/{id}/{key}', 'ExportDutiesClearingController@editCertificate')->name('editCertificate');
    Route::post('/updateFumigation', 'ExportDutiesClearingController@updateFumigation')->name('updateFumigation');
    Route::post('/updateOrigin', 'ExportDutiesClearingController@updateOrigin')->name('updateOrigin');
    Route::post('/updateclearance', 'ExportDutiesClearingController@updateclearance')->name('updateclearance');
    Route::post('/updatequalityDeclearation', 'ExportDutiesClearingController@updatequalityDeclearation')->name('updatequalityDeclearation');
    Route::post('/updatequalityPacking', 'ExportDutiesClearingController@updatequalityPacking')->name('updatequalityPacking');

    Route::get('/addAdvancePayment/{id}', 'ExportAdvancePaymentController@addAdvancePayment')->name('addAdvancePayment');
    // Advance Payment

    Route::post('/addvancePaymentStore', 'ExportAdvancePaymentController@addvancePaymentStore')->name('addvancePaymentStore');
    Route::get('/viewSettelment', 'ExportAdvancePaymentController@viewSettelment')->name('viewSettelment');

    Route::get('/advanceReconciliation', 'ExportAdvancePaymentController@advanceReconciliation')->name('advanceReconciliation');
    Route::get('/advanceReconciliationAjax', 'ExportAdvancePaymentController@advanceReconciliationAjax')->name('advanceReconciliationAjax');

    // PRC 

    Route::get('/createPrc', 'PrcController@createPrc')->name('createPrc');
    Route::post('/createPrcStore', 'PrcController@createPrcStore')->name('createPrcStore');
    Route::get('/prcList', 'PrcController@prcList')->name('prcList');
    Route::get('/prcListAjax', 'PrcController@prcListAjax')->name('prcListAjax');
    Route::get('/prcReconciliation/{id}', 'PrcController@prcReconciliation')->name('prcReconciliation');
    Route::get('/getInvoice', 'PrcController@getInvoice')->name('getInvoice');

    Route::post('/prcReconciliationStore', 'PrcController@prcReconciliationStore')->name('prcReconciliationStore');
});

//Start Purchase
Route::group(['prefix' => 'purchase', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {


    Route::get('/createMaterialRequestForm', 'PurchaseController@createMaterialRequestForm');
    Route::post('/addMaterialRequestDetail', 'PurchaseController@addMaterialRequestDetail');
    Route::get('/materialRequestList', 'PurchaseController@materialRequestList');
    Route::get('/materialRequestDetail', 'PurchaseController@materialRequestDetail');
    Route::get('/approvedmaterialRequest', 'PurchaseController@approvedmaterialRequest');
    Route::get('/materialRequestListForPurchaseRequest', 'PurchaseController@materialRequestListForPurchaseRequest');
    Route::post('/createPurchaseRequestThroughMaterialRequest', 'PurchaseController@createPurchaseRequestThroughMaterialRequest');


    Route::get('/createGatepassInForm', 'PurchaseController@createGatepassInForm');
    Route::get('/getPOForGatepassIn', 'PurchaseController@getPOForGatepassIn');
    Route::get('/dataFromPurchaseOrder', 'PurchaseController@dataFromPurchaseOrder');



    //  THIS IS MACHINERY START CRUD {Babar ALi}  
    Route::get('/createMachineryForm', 'StoreController@createMachineryForm')->name('createMachineryForm');
    Route::get('/viewMachineryList', 'StoreController@viewMachineryList')->name('viewMachineryList');
    Route::post('/storeMachineryForm', 'StoreAddDetailControler@storeMachineryForm')->name('storeMachineryForm');
    Route::post('/updateMachineryForm', 'StoreAddDetailControler@updateMachineryForm')->name('updateMachineryForm');
    Route::get('/editMachineryForm', 'StoreController@editMachineryForm')->name('editMachineryForm');
    Route::get('list/viewMachineryList', 'StoreAddDetailControler@viewMachineryList');
    Route::get('/machineryDelete', 'StoreController@machineryDelete')->name('machineryDelete');
    // THIS IS END MACHINERY CRUD  {Babar ALi}    


    // THIS IS LINE START DRUD 
    Route::get('/createLineForm', 'StoreController@createLineForm')->name('createLineForm');
    Route::get('/viewLineList', 'StoreController@viewLineList')->name('viewLineList');
    Route::post('/storeLineForm', 'StoreAddDetailControler@storeLineForm')->name('storeLineForm');
    Route::post('/updateLineForm', 'StoreAddDetailControler@updateLineForm')->name('updateLineForm');
    Route::get('/editLineForm', 'StoreController@editLineForm')->name('editLineForm');
    Route::get('list/viewLineList', 'StoreAddDetailControler@viewLineList');
    Route::get('/LineDelete', 'StoreController@LineDelete')->name('LineDelete');

    // END LINE CRUD 


    Route::get('companyIdForm', 'PurchaseController@companyIdForm');
    Route::get('locationRightsForm', 'PurchaseController@locationRightsForm');


    Route::get('/directPurchaseInvoice', 'PurchaseController@directPurchaseInvoice');
    //amirmurshad
    Route::get('/edit_sub_ca', 'PusherController@edit_sub_ca');
    Route::get('/inventory_page', 'PurchaseController@inventory_page');
    Route::get('/purchase_page', 'PurchaseController@purchase_page');
    Route::get('/testReportPage', 'PurchaseController@testReportPage');

    Route::get('/sales_page', 'PurchaseController@sales_page');
    Route::get('/item_master_list', 'PusherController@item_master_list');


    Route::get('/editItemMaster/{id?}', 'PurchaseController@editItemMaster');

    Route::get('/p', 'PurchaseController@toDayActivity');
    Route::get('/getPoReportByPoNo', 'PurchaseController@getPoReportByPoNo');
    Route::get('/purchase_request_form', 'PurchaseController@purchase_request_form');
    Route::get('/purchaseDetailReportPage', 'PurchaseController@purchaseDetailReportPage');
    Route::get('/detailReportPage', 'PurchaseController@detailReportPage');
    Route::get('/purchaseInvoiceReportPage', 'PurchaseController@purchaseInvoiceReportPage');
    Route::get('/aqmsStockReportPage', 'PurchaseController@aqmsStockReportPage');
    Route::get('/vendor_outstanding', 'PurchaseController@vendor_outstanding');
    Route::get('/poTrackingPage', 'PurchaseController@poTrackingPage');
    Route::get('/deleteItemMaster', 'PurchaseController@deleteItemMaster');
    Route::get('/vendor_balance_page', 'PurchaseController@vendor_balance_page');
    Route::get('/add_another_data_page', 'PurchaseController@add_another_data_page');







    Route::get('/viewAgingReportPage', 'PurchaseController@viewAgingReportPage');

    Route::get('/in_stock_recon', 'PurchaseController@in_stock_recon');



    Route::get('/vendor_opening_list', 'PurchaseController@vendor_opening_list');
    Route::get('/vendor_report', 'PurchaseController@vendor_report');
    Route::get('/createSupplierForm', 'PurchaseController@createSupplierForm');
    Route::get('/exportexcel', 'PurchaseController@exportexcel')->name('export-excel');
    Route::get('/importSupplierForm', 'PurchaseController@importSupplierForm');
    Route::get('/viewSupplierList', 'PurchaseController@viewSupplierList');
    Route::get('/viewSupplierDetail', 'PurchaseController@viewSupplierDetail');
    Route::get('/editSupplierForm/{id?}', 'PurchaseController@editSupplierForm');
    Route::get('/deleteSupplierRecord', 'PurchaseDeleteController@deleteSupplierRecord');
    Route::get('/repostSupplierRecord', 'PurchaseDeleteController@repostSupplierRecord');
    // amir
    Route::get('/createPurchaseVoucherForm', 'PurchaseController@createPurchaseVoucherForm');
    Route::get('/createJobOrder', 'PurchaseController@createJobOrder');
    Route::get('/editJobOrder/{id?}/{duplicate?}', 'PurchaseController@editJobOrder');
    Route::get('/createProduct', 'PurchaseController@createProduct');
    Route::get('/addSurveyForm', 'PurchaseController@addSurveyForm');

    Route::get('/editSurvey/{id?}', 'PurchaseController@editSurvey');
    Route::get('/editGoodIssuance/{id?}', 'PurchaseController@editGoodIssuance');
    Route::get('/editStockReturn/{id?}', 'PurchaseController@editStockReturn');


    // opening stock
    Route::get('/opening_stock_report', 'PurchaseController@opening_stock_report');
    Route::get('/ItemWiseReport', 'PurchaseController@ItemWiseReport');

    // opening stock eend

    Route::post('/createPurchaseVoucherFormThroughGrn', 'PurchaseController@createPurchaseVoucherFormThroughGrn');
    Route::get('/editPurchaseVoucherForm/{id?}', 'PurchaseController@editPurchaseVoucherForm');

    Route::get('/createCategoryForm', 'PurchaseController@createCategoryForm');
    Route::get('/viewCategoryList', 'PurchaseController@viewCategoryList');
    Route::get('/add_item_master', 'PurchaseController@add_item_master');
    Route::get('/editItemMaster', 'PurchaseController@editItemMaster');

    Route::get('/viewItemMasterList', 'PurchaseController@viewItemMasterList');


    //Abdul
    Route::get('/createSubCategoryForm', 'PurchaseController@createSubCategoryForm');
    Route::get('/viewSubCategoryList', 'PurchaseController@viewSubCategoryList');
    //Abdul
    Route::get('/addRegionForm', 'PurchaseController@addRegionForm');
    Route::get('/regionList', 'PurchaseController@regionList');
    Route::get('/addCluster', 'PurchaseController@addCluster');
    Route::get('/clusterList', 'PurchaseController@clusterList');


    Route::get('/viewCategoryDetail', 'PurchaseController@viewCategoryDetail');
    Route::get('/editCategoryForm', 'PurchaseController@editCategoryForm');
    Route::get('/deleteCategoryRecord', 'PurchaseDeleteController@deleteCategoryRecord');
    Route::get('/repostCategoryRecord', 'PurchaseDeleteController@repostCategoryRecord');

    Route::get('/uploadSubItemForm', 'PurchaseController@uploadSubItemForm');
    Route::get('/createSubItemForm', 'PurchaseController@createSubItemForm');
    Route::get('/viewSubItemList', 'PurchaseController@viewSubItemList');
    Route::get('/viewSubItemDetail', 'PurchaseController@viewSubItemDetail');
    Route::get('/editSubItemForm', 'PurchaseController@editSubItemForm');
    Route::get('/deleteSubItemRecord', 'PurchaseDeleteController@deleteSubItemRecord');
    Route::get('/repostSubItemRecord', 'PurchaseDeleteController@repostSubItemRecord');


    //amir
    Route::get('/createDemandTypeForm', 'PurchaseController@createDemandTypeForm');
    Route::get('/createWarehouseForm', 'PurchaseController@createWarehouseForm');
    //end

    Route::get('/createUOMForm', 'PurchaseController@createUOMForm');
    Route::get('/viewUOMList', 'PurchaseController@viewUOMList');

    Route::get('/createDemandForm', 'PurchaseController@createDemandForm');
    Route::get('/viewDemandList', 'PurchaseController@viewDemandList');
    Route::get('/stockreturnlist', 'PurchaseController@stockreturnlist');

    //amir
    Route::get('/viewPurchaseVoucherList', 'PurchaseController@viewPurchaseVoucherList');
    Route::get('/viewJobOrder', 'PurchaseController@viewJobOrder');
    Route::get('/viewJobOrderTwo', 'PurchaseController@viewJobOrderTwo');

    Route::get('/viewProduct', 'PurchaseController@viewProduct');

    Route::get('/viewPurchaseVoucherListThroughGrn', 'PurchaseController@viewPurchaseVoucherListThroughGrn');
    Route::get('/viewDemandTypeList', 'PurchaseController@viewDemandTypeList');
    Route::get('/viewWarehouseList', 'PurchaseController@viewWarehouseList');
    Route::get('/viewGrnListForPurchaseVoucher', 'PurchaseController@viewGrnListForPurchaseVoucher');

    //end amir
    Route::get('/editDemandVoucherForm/{id}', 'PurchaseController@editDemandVoucherForm');

    Route::get('/createGoodsReceiptNoteForm', 'PurchaseController@createGoodsReceiptNoteForm');
    Route::get('/viewGoodsReceiptNoteList', 'PurchaseController@viewGoodsReceiptNoteList');
    Route::get('/editGoodsReceiptNoteVoucherForm/{id}/{GrnNo}', 'PurchaseController@editGoodsReceiptNoteVoucherForm');
    Route::get('/editPurchaseReturnForm/{id}/{PrNo}', 'PurchaseController@editPurchaseReturnForm');



    Route::get('/editGoodsReceiptNoteWithoutPOForm/{id}', 'PurchaseController@editGoodsReceiptNoteWithoutPOForm');
    Route::get('/createGoodReceiptNoteForWithoutPO', 'PurchaseController@createGoodReceiptNoteForWithoutPO');


    Route::get('/tempGrn', 'PurchaseController@tempGrn');



    Route::get('/createGoodsForwardForm', 'PurchaseController@createGoodsForwardForm');
    Route::get('/viewGoodsForwardList', 'PurchaseController@viewGoodsForwardList');
    Route::get('/editGoodsForwardForm', 'PurchaseController@editGoodsForwardForm');

    Route::get('/createGoodsForwardOrderForm', 'PurchaseController@createGoodsForwardOrderForm');
    Route::get('/viewGoodsForwardOrderList', 'PurchaseController@viewGoodsForwardOrderList');
    Route::get('/editGoodsForwardOrderForm', 'PurchaseController@editGoodsForwardOrderForm');
    Route::get('/purchaseReturnForm', 'PurchaseController@purchaseReturnForm');
    Route::get('/purchaseReturnList', 'PurchaseController@purchaseReturnList');
    Route::get('/createstockreturn', 'PurchaseController@createstockreturn');

    // estimate
    Route::get('/job_order_next_step', 'PurchaseController@job_order_next_step');
    Route::get('/job_order_next_step_edit', 'PurchaseController@job_order_next_step_edit');
    Route::get('/ShowAllImages/{id}', 'PurchaseController@ShowAllImages');
    Route::get('/editJobOrder/{id?}/{duplicate?}', 'PurchaseController@editJobOrder');
    Route::get('/directPurchaseOrderForm', 'PurchaseController@directPurchaseOrderForm');
    Route::get('/purchase_order_status', 'PurchaseController@purchase_order_status');
    Route::get('/poReportPage', 'PurchaseController@poReportPage');


    // Gate Pass Returnable or None Returnable

    Route::resource('/gate_pass', 'GatePassReturnableController');
    Route::get('/ViewGatepass', 'GatePassReturnableController@ViewGatepass');
    Route::get('/editGatepassForm', 'GatePassReturnableController@editGatepassForm');
    Route::post('/update_gatepass', 'GatePassReturnableController@update')->name('gate_pass.update_gatepass');
    
    Route::get('delete_gatepass', 'GatePassReturnableController@delete_gatepass');
    Route::get('gatepass_received', 'GatePassReturnableController@gatepass_received');
    Route::get('gatepass_partial_received', 'GatePassReturnableController@gatepass_partial_received');

    Route::resource('/material_request', 'MaterialRequestController');
    Route::get('/ViewMaterialRequest', 'MaterialRequestController@ViewMaterialRequest');
    Route::get('/editMaterialForm', 'MaterialRequestController@editMaterialForm');
    Route::post('/update_material_request', 'MaterialRequestController@update')->name('material_request.update_material_request');
    Route::get('delete_material_request', 'MaterialRequestController@delete_material_request');
    Route::get('get-items', 'MaterialRequestController@get_items');


    Route::resource('/arrival_report', 'ArrivalReportController');
    Route::get('/get_itemwise_prpo', 'ArrivalReportController@get_itemwise_prpo');
    Route::get('/GetArrivalForm', 'ArrivalReportController@GetArrivalForm');
    Route::get('/ViewArrivalReport', 'ArrivalReportController@ViewArrivalReport');
    Route::get('/AcknowledgedArrival', 'ArrivalReportController@AcknowledgedArrival');
    Route::get('/AcknowledgedArrivalView', 'ArrivalReportController@AcknowledgedArrivalView');
    Route::get('delete_arrival_report', 'ArrivalReportController@delete_arrival_report');
    Route::get('approve_arrival_report', 'ArrivalReportController@approve_arrival_report');


    Route::resource('/scrap_declrations', 'ScrapDeclrationController');
    Route::get('/ViewScrapDeclration', 'ScrapDeclrationController@ViewScrapDeclration');
    Route::get('/approve_scrap_declration', 'ScrapDeclrationController@approve_scrap_declration');
    Route::get('/gmApproval', 'ScrapDeclrationController@gmApproval');
    Route::get('/audApproval', 'ScrapDeclrationController@audApproval');
    Route::get('delete_scrap_declration', 'ScrapDeclrationController@delete_scrap_declration');

    
    Route::resource('/scrap_sales', 'ScrapSaleController');
    Route::get('/GetScrapDeclration', 'ScrapSaleController@GetScrapDeclration');
    Route::get('/ViewScrapSale', 'ScrapSaleController@ViewScrapSale');
    Route::get('/approve_scrap_sale', 'ScrapSaleController@approve_scrap_sale');
    Route::get('/gmApprovalSale', 'ScrapSaleController@gmApprovalSale');
    Route::get('/audApprovalSale', 'ScrapSaleController@audApprovalSale');
    Route::get('delete_scrap_sale', 'ScrapSaleController@delete_scrap_sale');
});




Route::group(['prefix' => 'quotation', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {

    
    Route::post('/quotationApproval', 'QuotationController@quotationApproval');



    Route::post('update_quotation/{id}', 'QuotationController@update_quotation');
    Route::get('edit_quotation/{q_id}', 'QuotationController@edit_quotation');
    Route::get('delete_quotation', 'QuotationController@delete_quotation');
    // Route::get('create_quotation','QuotationController@create_quotation');
    Route::get('create_quotation', 'QuotationController@new_create_quotation');
    Route::get('new_create_quotation_form', 'QuotationController@new_create_quotation_form');
    Route::get('create_quotation_ajax', 'QuotationController@create_quotation_ajax');
    Route::get('quotation_form/{id}', 'QuotationController@quotation_form');

    // Route::post('insert_quotation','QuotationController@insert_quotation');
    Route::post('insert_quotation', 'QuotationController@new_insert_quotation');

    Route::get('quotation_list', 'QuotationController@quotation_list');
    Route::get('quotation_list_ajax', 'QuotationController@quotation_list_ajax');
    Route::get('view_quotation', 'QuotationController@view_quotation');
    Route::get('qutation_summary', 'QuotationController@qutation_summary');
    Route::get('approve', 'QuotationController@approve');
    Route::get('approved_quotation_summary', 'QuotationController@approved_quotation_summary');
    Route::get('reverseQuotation', 'QuotationController@reverseQuotation');
    Route::get('multipleReverse', 'QuotationController@multipleReverse');
    
    Route::get('generateGroupNumber', 'QuotationController@generateGroupNumber');

    Route::get('getPoNoList', 'QuotationController@getPoNoList');
});


Route::group(['prefix' => 'pad', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {


    Route::post('/addCompanyLocationDetail', 'PurchaseAddDetailControler@addCompanyLocationDetail');
    Route::post('/assignUserCompanyRights', 'PurchaseAddDetailControler@assignUserCompanyRights');


    Route::get('/addTempGrn', 'PurchaseAddDetailControler@addTempGrn');
    
    Route::get('/gmApproval', 'PurchaseAddDetailControler@gmApproval');
    Route::get('/audApproval', 'PurchaseAddDetailControler@audApproval');

    Route::post('/insertDirectPurchaseInvoice', 'PurchaseAddDetailControler@insertDirectPurchaseInvoice');


    Route::post('/addSupplierDetail', 'PurchaseAddDetailControler@addSupplierDetail');
    Route::post('/importSupplierDetail', 'PurchaseAddDetailControler@importSupplierDetail');

    Route::post('/edit_sub', 'PurchaseAddDetailControler@edit_sub');

    Route::post('/editSupplierDetail', 'PurchaseEditDetailControler@editSupplierDetail');
    Route::post('/inser_item_master', 'PurchaseAddDetailControler@inser_item_master');
    Route::post('/update_item_master', 'PurchaseAddDetailControler@update_item_master');



    Route::post('/addCategoryDetail', 'PurchaseAddDetailControler@addCategoryDetail');
    Route::post('/editCategoryDetail', 'PurchaseEditDetailControler@editCategoryDetail');

    //ABdul
    Route::post('/addSubCategoryDetail', 'PurchaseAddDetailControler@addSubCategoryDetail');
    //ABdul

    Route::post('/addRegionDetail', 'PurchaseAddDetailControler@addRegionDetail');
    Route::post('/insertCluster', 'PurchaseAddDetailControler@insertCluster');

    Route::post('/uploadSubItemDetail', 'PurchaseAddDetailControler@uploadSubItemDetail');
    Route::post('/addSubItemDetail', 'PurchaseAddDetailControler@addSubItemDetail');
    Route::post('/editSubItemDetail', 'PurchaseEditDetailControler@editSubItemDetail');

    Route::post('/addUOMDetail', 'PurchaseAddDetailControler@addUOMDetail');
    Route::post('/editUOMDetail', 'PurchaseEditDetailControler@editUOMDetail');

    Route::post('/addDemandDetail', 'PurchaseAddDetailControler@addDemandDetail');
    Route::post('/updateDemandDetail', 'PurchaseAddDetailControler@updateDemandDetail');

    Route::post('/addIssuanceDetail', 'PurchaseAddDetailControler@addIssuanceDetail');
    Route::post('/updateIssuanceDetail', 'PurchaseAddDetailControler@updateIssuanceDetail');
    Route::post('/updateRegionDetail', 'PurchaseAddDetailControler@updateRegionDetail');

    Route::post('/UpdateStockReturnDetail', 'PurchaseAddDetailControler@UpdateStockReturnDetail');
    Route::post('/addStockReturnDetail', 'PurchaseAddDetailControler@addStockReturnDetail');
    //amir


    Route::post('/addJobOrder', 'PurchaseAddDetailControler@addJobOrder');
    Route::post('/updateJobOrderDetail', 'PurchaseAddDetailControler@updateJobOrderDetail');



    Route::post('/addJobOrderNextStep', 'PurchaseAddDetailControler@addJobOrderNextStep');
    Route::post('/addJobOrderNextStepUpdate', 'PurchaseAddDetailControler@addJobOrderNextStepUpdate');

    Route::post('/addProduct', 'PurchaseAddDetailControler@addProduct');
    Route::post('/addSurveyDetail', 'PurchaseAddDetailControler@addSurveyDetail');
    Route::post('/updateSurveyDetail', 'PurchaseAddDetailControler@updateSurveyDetail');

    Route::post('/addJobTrackingDetails', 'PurchaseAddDetailControler@addJobTrackingDetails');

    Route::post('/createPurchaseVoucher', 'PurchaseAddDetailControler@createPurchaseVoucher');
    Route::post('/addPurchaseVoucherThorughGrn', 'PurchaseAddDetailControler@addPurchaseVoucherThorughGrn');
    Route::post('/editPurchaseVoucher/{id}', 'PurchaseEditDetailControler@editPurchaseVoucher');
    Route::post('/addDemandTypeDetail', 'PurchaseAddDetailControler@addDemandTypeDetail');
    Route::post('/addDirectGrnForm', 'PurchaseAddDetailControler@addDirectGrnForm');
    Route::post('/UpdateDirectGrnForm', 'PurchaseAddDetailControler@UpdateDirectGrnForm');
    Route::post('/addWareHouseDetail', 'PurchaseAddDetailControler@addWareHouseDetail');
    // end amir
    Route::post('/editDemandVoucherDetail', 'PurchaseEditDetailControler@editDemandVoucherDetail');
    Route::post('/updateDemandDetailandApprove', 'PurchaseEditDetailControler@updateDemandDetailandApprove');

    Route::post('/addGoodsReceiptNoteDetail', 'PurchaseAddDetailControler@addGoodsReceiptNoteDetail');
    Route::post('/addPurchaseReturnDetail', 'PurchaseAddDetailControler@addPurchaseReturnDetail');

    Route::post('/editGoodsReceiptNoteDetail', 'PurchaseEditDetailControler@editGoodsReceiptNoteDetail');
    Route::post('/createStoreChallanandApproveGoodsReceiptNote', 'PurchaseAddDetailControler@createStoreChallanandApproveGoodsReceiptNote');

    Route::post('/addGoodsForwardDetail', 'PurchaseAddDetailControler@addGoodsForwardDetail');

    Route::post('/addGoodsForwardOrderDetail', 'PurchaseAddDetailControler@addGoodsForwardOrderDetail');
    Route::post('/createGoodsForwardOrderDetailForm', 'PurchaseDataCallController@createGoodsForwardOrderDetailForm');




    Route::post('/editPurchaseRequestVoucherDetail', 'PurchaseEditDetailControler@editPurchaseRequestVoucherDetail');
    Route::post('/addStockTransfer', 'PurchaseAddDetailControler@addStockTransfer');
    Route::post('/updateStockTransfer', 'PurchaseAddDetailControler@updateStockTransfer');
    Route::post('/updatePurchaseReturnDetail', 'PurchaseAddDetailControler@updatePurchaseReturnDetail');


    Route::post('/add_internal_consum', 'PurchaseAddDetailControler@add_internal_consum');
});
Route::get('/set_user_db_id', 'PurchaseDataCallController@set_user_db_id');
Route::group(['prefix' => 'pdc', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {

    
    Route::get('/cancelPODataItems', 'PurchaseDataCallController@cancelPODataItems');
    Route::get('/cancelDemandData', 'PurchaseDataCallController@cancelDemandData');


    Route::get('/approved_stock_issuance', 'PurchaseDataCallController@approved_stock_issuance');
    Route::get('/approved_stock_return_issuance', 'PurchaseDataCallController@approved_stock_return_issuance');

    Route::get('/get_stock_location_wise', 'PurchaseDataCallController@get_stock_location_wise');

    Route::get('/delete_cate', 'PurchaseDataCallController@delete_cate');
    Route::get('/delete_sub_cate', 'PurchaseDataCallController@delete_sub_cate');


    Route::get('/closeGrn/{id}', 'PurchaseDataCallController@closeGrn');



    Route::get('/viewSupplierList', 'PurchaseDataCallController@viewSupplierList');
    Route::get('/getPurchaseDetailReportAjax', 'PurchaseDataCallController@getPurchaseDetailReportAjax');
    Route::get('/getAgingReportDataAjax', 'PurchaseDataCallController@getAgingReportDataAjax');
    Route::get('/get_dashboard_info', 'PurchaseDataCallController@get_dashboard_info');
    Route::get('/getOnlineUserAjax', 'PurchaseDataCallController@getOnlineUserAjax');

    Route::get('/getPendingApporvedMultiList', 'PurchaseDataCallController@getPendingApporvedMultiList');
    Route::get('/delete_attachment', 'PurchaseDataCallController@delete_attachment');
    Route::get('/getPendingApporvedMultiListForSales', 'PurchaseDataCallController@getPendingApporvedMultiListForSales');
    Route::get('/getPendingApporvedMultiListForFinance', 'PurchaseDataCallController@getPendingApporvedMultiListForFinance');
    Route::get('/vendor_outstanding_data', 'PurchaseDataCallController@vendor_outstanding_data');
    Route::get('/vendor_balance_ajax_data', 'PurchaseDataCallController@vendor_balance_ajax_data');

    Route::get('/getDetailReportAjax', 'PurchaseDataCallController@getDetailReportAjax');

    Route::get('/delete_supp', 'PurchaseDataCallController@delete_supp');



    Route::get('/createSupplierAccount', 'PurchaseDataCallController@createSupplierAccount');
    Route::get('/get_sub_category', 'PurchaseDataCallController@get_sub_category');


    Route::get('/getAllItems', 'PurchaseDataCallController@getAllItems');


    Route::get('/get_sub_item_code', 'PurchaseDataCallController@get_sub_item_code');
    Route::get('/get_data', 'PurchaseDataCallController@get_data');
    Route::get('/get_batch_code', 'PurchaseDataCallController@get_batch_code');
    Route::get('/get_grn_history', 'PurchaseDataCallController@get_grn_history');
    Route::get('/search/{categoryId?}/{subCategory_id?}', 'PurchaseDataCallController@search');

    Route::get('/viewCategoryList', 'PurchaseDataCallController@viewCategoryList');
    Route::get('/viewRegionList', 'PurchaseDataCallController@viewRegionList');
    Route::get('/viewSubItemList', 'PurchaseDataCallController@viewSubItemList');
    Route::get('/viewSubItemListAjax', 'PurchaseDataCallController@viewSubItemListAjax');

    Route::get('/viewUOMList', 'PurchaseDataCallController@viewUOMList');
    Route::get('/filterDemandVoucherList', 'PurchaseDataCallController@filterDemandVoucherList');
    Route::get('/viewDemandVoucherDetail', 'PurchaseDataCallController@viewDemandVoucherDetail');
    Route::get('/viewJobOrderDetail', 'PurchaseDataCallController@viewJobOrderDetail');
    Route::get('/viewEstimateDetail', 'PurchaseDataCallController@viewEstimateDetail');
    Route::get('/viewSurveyImage', 'PurchaseDataCallController@viewSurveyImage');

    Route::get('/viewPurchaseReturnDetail', 'PurchaseDataCallController@viewPurchaseReturnDetail');
    Route::get('/viewStockReturnDetail', 'PurchaseDataCallController@viewStockReturnDetail');

    Route::get('/get_stock_region_wise', 'PurchaseDataCallController@get_stock_region_wise');
    Route::get('/getReportMultiItems', 'PurchaseDataCallController@getReportMultiItems');

    Route::get('/get_stock_region_wise_batch_wise', 'PurchaseDataCallController@get_stock_region_wise_batch_wise');

    Route::get('/get_stock', 'PurchaseDataCallController@get_stock');
    Route::get('/get_uom', 'PurchaseDataCallController@get_uom');
    Route::get('/get_uom_name_by_item_id', 'PurchaseDataCallController@get_uom_name_by_item_id');

    //amir

    Route::get('/viewPurchaseVoucherDetail/{id?}', 'PurchaseDataCallController@viewPurchaseVoucherDetail');
    Route::get('/services', 'PurchaseDataCallController@services');
    Route::get('/viewPurchaseVoucherDetailThroughGrn/{id?}', 'PurchaseDataCallController@viewPurchaseVoucherDetailThroughGrn');
    Route::get('/viewPurchaseVoucherDetailAfterSubmit/{id?}', 'PurchaseDataCallController@viewPurchaseVoucherDetailAfterSubmit');
    Route::get('/purchase_voucher_list_ajax', 'PurchaseDataCallController@purchase_voucher_list_ajax');
    Route::get('/get_data_debit_note_ajax', 'PurchaseDataCallController@get_data_debit_note_ajax');
    Route::get('/filterByClientAndRegionJobOrder', 'PurchaseDataCallController@filterByClientAndRegionJobOrder');
    Route::get('/filterByClientAndRegionJobOrderTwo', 'PurchaseDataCallController@filterByClientAndRegionJobOrderTwo');
    Route::get('/filterByCategoryAndRegionWiseStockOpening', 'PurchaseDataCallController@filterByCategoryAndRegionWiseStockOpening');
    Route::get('/ItemWiseReportAjax', 'PurchaseDataCallController@ItemWiseReportAjax');

    Route::get('/issuanceDataFilter', 'PurchaseDataCallController@issuanceDataFilter');
    Route::get('/issuanceReturnDataFilter', 'PurchaseDataCallController@issuanceReturnDataFilter');


    Route::get('/stockReturnDataFilter', 'PurchaseDataCallController@stockReturnDataFilter');
    Route::get('/approve_grn', 'PurchaseDataCallController@approve_grn');
    Route::get('/getDataAjaxSupplierWise', 'PurchaseDataCallController@getDataAjaxSupplierWise');

    Route::get('/get_ledger_refrence_wise', 'PurchaseDataCallController@get_ledger_refrence_wise');
    Route::get('/deletePurchaseReturn', 'PurchaseDataCallController@deletePurchaseReturn');
    Route::get('/DeleteStockReturn', 'PurchaseDataCallController@DeleteStockReturn');
    Route::get('/deleteStockTransfer', 'PurchaseDataCallController@deleteStockTransfer');

    Route::get('/DeleteGrn', 'PurchaseDataCallController@DeleteGrn');
    Route::get('/MasterDeleteGrn', 'PurchaseDataCallController@MasterDeleteGrn');
    Route::get('/UpdateBranchId', 'PurchaseDataCallController@UpdateBranchId');
    Route::get('/getStockDataWithItemWise', 'PurchaseDataCallController@getStockDataWithItemWise');
    Route::get('/insertOrUpdateOpeningStock', 'PurchaseDataCallController@insertOrUpdateOpeningStock');
    Route::get('/editRegionDetail', 'PurchaseDataCallController@editRegionDetail');
    Route::get('/checkDuplicateSubCategory', 'PurchaseDataCallController@checkDuplicateSubCategory');






    Route::get('/get_job_order', 'PurchaseDataCallController@get_job_order');
    Route::get('/get_po_status_data', 'PurchaseDataCallController@get_po_status_data');
    Route::get('/getPoDetailDateWise', 'PurchaseDataCallController@getPoDetailDateWise');


    //end amir

    // for  supplier  ajax
    //  Route::get('/viewPurchaseVoucherDetail/{id?}','PurchaseDataCallController@viewPurchaseVoucherDetail');
    Route::get('/createSupplierFormAjax/{PageName?}', 'PurchaseDataCallController@createSupplierFormAjax');
    Route::post('/addSupplierDetail', 'PurchaseDataCallController@addSupplierDetail');


    // for  purchase Type ajax

    Route::get('/createPurchaseTypeForm', 'PurchaseDataCallController@createPurchaseTypeForm');
    Route::get('/approve_purchase', 'PurchaseDataCallController@approve_purchase');

    Route::post('/addPurchaseType', 'PurchaseDataCallController@addPurchaseType');


    // for opening
    Route::get('/get_data_opening', 'PurchaseDataCallController@get_data_opening');

    // for  currency ajax
    Route::get('/createCurrencyTypeForm', 'PurchaseDataCallController@createCurrencyTypeForm');
    Route::Get('/addCurrency', 'PurchaseDataCallController@addCurrency');
    Route::Post('/addCurrencyForm', 'PurchaseDataCallController@addCurrencyForm');


    // for sub item ajax
    Route::get('/createSubItemFormAjax/{id?}', 'PurchaseDataCallController@createSubItemFormAjax');
    Route::Post('/addSubItemDetailAjax', 'PurchaseDataCallController@addSubItemDetailAjax');
    Route::get('/viewHistoryOfItem', 'PurchaseDataCallController@viewHistoryOfItem');
    Route::get('/viewHistoryOfItem_directPo', 'PurchaseDataCallController@viewHistoryOfItem_directPo');
    Route::get('/viewPaymentDetail', 'PurchaseDataCallController@viewPaymentDetail');




    // for category
    Route::get('/createCategoryFormAjax/{id?}', 'PurchaseDataCallController@createCategoryFormAjax');
    Route::Post('/addCategoryDetailAjax', 'PurchaseDataCallController@addCategoryDetailAjax');

    //end

    // for Department ajax
    Route::get('/createDepartmentFormAjax/{id?}', 'PurchaseDataCallController@createDepartmentFormAjax');
    Route::Post('/addDepartmentFormAjax', 'PurchaseDataCallController@addDepartmentFormAjax');


    // for Cost Center ajax
    Route::get('/createCostCenterFormAjax/{id?}', 'PurchaseDataCallController@createCostCenterFormAjax');
    Route::Post('/addCostCenterFormajax', 'PurchaseDataCallController@addCostCenterFormajax');


    // for delete purchase voucher
    Route::get('/deletepurchasevoucher', 'PurchaseDataCallController@deletepurchasevoucher');
    Route::get('/UpdateDpdn', 'PurchaseDataCallController@UpdateDpdn');

    //end amir

    //sandeep
    Route::get('/deleteProductDetail', 'PurchaseDataCallController@deleteProductDetail');
    Route::get('/deleteCondition', 'PurchaseDataCallController@deleteCondition');
    Route::get('/deleteTypeList', 'PurchaseDataCallController@deleteTypeList');
    Route::get('/deleteClientList', 'PurchaseDataCallController@deleteClientList');
    Route::get('/deleteProductTypeList', 'PurchaseDataCallController@deleteProductTypeList');
    Route::get('/deleteResourceAssignedList', 'PurchaseDataCallController@deleteResourceAssignedList');

    // for ware house ajax
    Route::get('/createWarehouseFormAjax/{id?}', 'PurchaseDataCallController@createWarehouseFormAjax');
    Route::Post('/addWarehouseDetailAjax', 'PurchaseDataCallController@addWarehouseDetailAjax');

    Route::get('/filterGoodsReceiptNoteList', 'PurchaseDataCallController@filterGoodsReceiptNoteList');
    Route::get('/viewGoodsReceiptNoteDetail', 'PurchaseDataCallController@viewGoodsReceiptNoteDetail');
    Route::get('/qc', 'PurchaseDataCallController@qc');
    Route::post('/qc_submit', 'PurchaseDataCallController@qc_submit');

    Route::get('/viewGoodsReceiptNoteDetail', 'PurchaseDataCallController@viewGoodsReceiptNoteDetail');
    Route::get('/completeAndMakePR', 'PurchaseDataCallController@completeAndMakePR')->name('pdc.completeAndMakePR');


    Route::get('/viewGoodsReceiptNoteDetailNewTab', 'PurchaseDataCallController@viewGoodsReceiptNoteDetailNewTab');

    Route::get('/viewGoodsReceiptNoteWPODetail', 'PurchaseDataCallController@viewGoodsReceiptNoteWPODetail');

    Route::get('/filterGoodsForwardOrderVoucherList', 'PurchaseDataCallController@filterGoodsForwardOrderVoucherList');
    Route::get('/viewGoodsForwardOrderVoucherDetail', 'PurchaseDataCallController@viewGoodsForwardOrderVoucherDetail');
    Route::get('/filterApproveDemandListandCreateGoodsForwardOrder', 'PurchaseDataCallController@filterApproveDemandListandCreateGoodsForwardOrder');

    Route::get('/ApprovedGoodIssuance', 'PurchaseDataCallController@ApprovedGoodIssuance');
    Route::get('/ApprovedStockReturn', 'PurchaseDataCallController@ApprovedStockReturn');
    Route::get('/Recieved', 'PurchaseDataCallController@Recieved');
});


Route::group(['prefix' => 'pmfal', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::get('/subItemListLoadDepandentCategoryId', 'PurchaseMakeFormAjaxLoadController@subItemListLoadDepandentCategoryId');
    Route::get('/get_category_wise_sub_category', 'PurchaseMakeFormAjaxLoadController@get_category_wise_sub_category');
    Route::get('/get_sub_item_all_ajax', 'PurchaseMakeFormAjaxLoadController@get_sub_item_all_ajax');


    Route::get('/addMoreDemandsDetailRows', 'PurchaseMakeFormAjaxLoadController@addMoreDemandsDetailRows');
    Route::get('/addDirectgrn', 'PurchaseMakeFormAjaxLoadController@addDirectgrn');
    //amir
    Route::get('/addMorPurchaseVoucherRow', 'PurchaseMakeFormAjaxLoadController@addMorPurchaseVoucherRow');
    Route::get('/get_detail_purchase_voucher', 'PurchaseMakeFormAjaxLoadController@get_detail_purchase_voucher');
    Route::get('/get_po', 'PurchaseMakeFormAjaxLoadController@get_po');
    Route::get('/getGrnNoBySupplier', 'PurchaseMakeFormAjaxLoadController@getGrnNoBySupplier');

    Route::get('/get_refer', 'PurchaseMakeFormAjaxLoadController@get_refer');
    Route::get('/get_ledger_refrence_wise', 'PurchaseMakeFormAjaxLoadController@get_ledger_refrence_wise');
    Route::get('/new_refrence', 'PurchaseMakeFormAjaxLoadController@new_refrence');
    Route::get('/ClientInfo', 'PurchaseMakeFormAjaxLoadController@ClientInfo');
    Route::get('/GetBranch', 'PurchaseMakeFormAjaxLoadController@GetBranch');


    //amir end

    Route::get('/addMoreIssuanceDetailRows', 'PurchaseMakeFormAjaxLoadController@addMoreIssuanceDetailRows');
    Route::get('/makeFormDemandVoucher', 'PurchaseMakeFormAjaxLoadController@makeFormDemandVoucher');
    Route::get('/makeFormGoodsReceiptNoteDetailByPRNo', 'PurchaseMakeFormAjaxLoadController@makeFormGoodsReceiptNoteDetailByPRNo');
    Route::get('/makeFormGoodsReceiptNoteDetailByPRNoManual', 'PurchaseMakeFormAjaxLoadController@makeFormGoodsReceiptNoteDetailByPRNoManual');

    Route::get('/makeFormGoodsReceiptNoteDetailByGrnNo', 'PurchaseMakeFormAjaxLoadController@makeFormGoodsReceiptNoteDetailByGrnNo');

    Route::get('/addMorJobOrderRow', 'PurchaseMakeFormAjaxLoadController@addMorJobOrderRow');

    Route::get('/get_stock', 'PurchaseMakeFormAjaxLoadController@get_stock');

    Route::get('/deleteJobOrderData', 'PurchaseMakeFormAjaxLoadController@deleteJobOrderData');
    Route::get('/deleteJobOrderAndEstimate', 'PurchaseMakeFormAjaxLoadController@deleteJobOrderAndEstimate');
});

//End Purchase

//Start Store
Route::group(['prefix' => 'store', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {


    Route::get('/printGrnItemBarcode/{id}', 'StoreController@printGrnItemBarcode')->name('printGrnItemBarcode');


    Route::get('/barcodePrintingForm', 'StoreController@barcodePrintingForm')->name('barcodePrintingForm');
    Route::post('/barcodePrint', 'StoreController@barcodePrint')->name('barcodePrint');
    Route::get('/printbarcode', 'StoreController@printbarcode')->name('printbarcode');



    // Inventory Report 

    Route::get('/itemMovementForm', 'StoreController@itemMovementForm')->name('itemMovementForm');
    Route::get('/itemMovementList', 'StoreController@itemMovementList')->name('itemMovementList');
    Route::get('/deleteItemMovement/{id}', 'StoreController@deleteItemMovement')->name('deleteItemMovement');


    Route::get('/inventoryReport', 'StoreController@inventoryReport')->name('inventoryReport');
    Route::get('/inventoryReportAjax', 'StoreController@inventoryReportAjax')->name('inventoryReportAjax');


    Route::get('/st', 'StoreController@toDayActivity');
    Route::get('/average_cost', 'StoreController@average_cost');
    Route::get('/inventoryActivityPage', 'StoreController@inventoryActivityPage');
    Route::get('/inventoryActivityAjax', 'StoreController@inventoryActivityAjax');
    Route::get('/scReportPage', 'StoreController@scReportPage');
    Route::get('/getDataScReportAjax', 'StoreController@getDataScReportAjax');
    Route::get('/issuence_against_product', 'StoreController@issuence_against_product');
    Route::get('/add_internal_consumtion', 'StoreController@add_internal_consumtion');
    Route::get('/add_bom', 'StoreController@add_bom');
    Route::get('/add_operation_data', 'StoreController@add_operation_data');
    Route::get('/Create_routing', 'StoreController@Create_routing');
    Route::post('/add_finish', 'StoreController@add_finish');

    Route::get('/add_opening', 'StoreController@add_opening');
    Route::get('/add_opening_form', 'StoreController@add_opening_form');

    Route::get('/stockAdjustList', 'StoreController@stockAdjustList');
    Route::get('/stockAdjustEdit/{id}', 'StoreController@stockAdjustEdit');
    Route::post('/stockAdjustUodate/{id}', 'StoreController@stockAdjustUodate');
    Route::get('/stockAdjustDelete/{id}', 'StoreController@stockAdjustDelete');
    Route::get('/stockAdjustApprove/{id}', 'StoreController@stockAdjustApprove');

    Route::get('/createIssuanceReturnForm/{id?}', 'StoreController@createIssuanceReturnForm');
    Route::get('/createIssuanceForm', 'StoreController@createIssuanceForm');
    Route::get('/pendingIssuance', 'StoreController@pendingIssuance');
    Route::get('/GetIssuanceForm', 'StoreController@GetIssuanceForm');
    Route::get('/editIssuanceForm/{id}', 'StoreController@editIssuanceForm');

    Route::get('/editIssuanceReturnForm/{id}', 'StoreController@editIssuanceReturnForm');
    Route::get('/editIssuanceReturnFormDetail', 'StoreController@editIssuanceReturnFormDetail');

    Route::get('/issuanceList', 'StoreController@issuanceList');
    Route::get('/issuanceReturnList', 'StoreController@issuanceReturnList');


    Route::get('/viewDemandList', 'StoreController@viewDemandList');
    Route::get('/itemCostClassification', 'StoreController@itemCostClassification');

    Route::get('/item_detaild_supplier_wise', 'StoreController@item_detaild_supplier_wise');

    Route::get('/createStoreChallanForm', 'StoreController@createStoreChallanForm');
    Route::get('/viewStoreChallanList', 'StoreController@viewStoreChallanList');
    Route::get('/editStoreChallanVoucherForm', 'StoreController@editStoreChallanVoucherForm');


    Route::get('/createPurchaseRequestForm', 'StoreController@createPurchaseRequestForm');
    Route::get('/viewPurchaseRequestList', 'StoreController@viewPurchaseRequestList');
    Route::get('/editPurchaseRequestVoucherForm', 'StoreController@editPurchaseRequestVoucherForm');

    Route::get('/createPurchaseRequestSaleForm', 'StoreController@createPurchaseRequestSaleForm');
    Route::get('/viewPurchaseRequestSaleList', 'StoreController@viewPurchaseRequestSaleList');
    Route::get('/editPurchaseRequestSaleVoucherForm', 'StoreController@editPurchaseRequestSaleVoucherForm');

    Route::get('/createStoreChallanReturnForm', 'StoreController@createStoreChallanReturnForm');
    Route::get('/viewStoreChallanReturnList', 'StoreController@viewStoreChallanReturnList');
    Route::get('/editStoreChallanReturnForm', 'StoreController@editStoreChallanReturnForm');

    Route::get('/viewDateWiseStockInventoryReport', 'StoreController@viewDateWiseStockInventoryReport');

    Route::get('/editPurchaseRequestVoucherForm/{id}', 'StoreController@editPurchaseRequestVoucherForm');
    Route::get('/editDirectPurchaseRequestVoucherForm/{id}', 'StoreController@editDirectPurchaseRequestVoucherForm');
    Route::get('/stockReportView', 'StoreController@stockReportView');
    Route::get('/stockReportBatchWiseView', 'StoreController@stockReportBatchWiseView');

    Route::get('/fullstockReportView', 'StoreController@fullstockReportView');
    Route::get('/fullstockReportViewBatch', 'StoreController@fullstockReportViewBatch');
    Route::get('/stockDetailReport', 'StoreController@stockDetailReport');
    Route::get('/StockOpeningValuesUpdate', 'StoreController@StockOpeningValuesUpdate');


    Route::get('/InventoryStockReport', 'StoreController@InventoryStockReport');
    Route::get('/InventoryStockReportAjax', 'StoreController@InventoryStockReportAjax');
    Route::get('/rateAndAmountupdate', 'StoreController@rateAndAmountupdate');
    Route::get('/rateAndAmountupdateAjax', 'StoreController@rateAndAmountupdateAjax');
    Route::get('/UpdateRateAmount', 'StoreController@UpdateRateAmount');
    Route::get('/UpdateRateAmountGrn', 'StoreController@UpdateRateAmountGrn');
    Route::get('/UpdateRateAmountReturn', 'StoreController@UpdateRateAmountReturn');
    Route::get('/stockReportItemWisePage', 'StoreController@stockReportItemWisePage');
    Route::get('/stockReportItemWiseAjax', 'StoreController@stockReportItemWiseAjax');
    Route::get('/checkPurchasingPage', 'StoreController@checkPurchasingPage');
    Route::get('/getCheckPurchasingDataAjax', 'StoreController@getCheckPurchasingDataAjax');
    Route::get('/stock_transfer_form', 'StoreController@stock_transfer_form');
    Route::get('/stock_transfer_list', 'StoreController@stock_transfer_list');
    Route::get('/stock_transfer_report', 'StoreController@stock_transfer_report');
    Route::get('/editStockTransferForm/{id}/{TrNo}', 'StoreController@editStockTransferForm');
    Route::get('/itemWiseOpening', 'StoreController@itemWiseOpening');
    Route::get('/inventory_movement', 'StoreController@inventory_movement');
    Route::get('/inventory_movement_test', 'StoreController@inventory_movement_test');
    Route::get('/inventory_movement_fi', 'StoreController@inventory_movement_fi');
    Route::get('/stock_movemnet', 'StoreController@stock_movemnet');
    Route::get('/stock_movemnet_test', 'StoreController@stock_movemnet_test');
    Route::get('/stock_movemnetAjaxMoreData', 'StoreController@stock_movemnetAjaxMoreData');

    Route::get('/internal_consumtion_list', 'StoreController@internal_consumtion_list');
});

Route::group(['prefix' => 'stad', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::post('/createStoreChallanDetailForm', 'StoreDataCallController@createStoreChallanDetailForm');
    Route::post('/addStoreChallanDetail', 'StoreAddDetailControler@addStoreChallanDetail');
    Route::post('/add_issuence', 'StoreAddDetailControler@add_issuence');
    Route::post('/editStoreChallanVoucherDetail', 'StoreEditDetailControler@editStoreChallanVoucherDetail');

    Route::post('/addItemMovementForm', 'StoreAddDetailControler@addItemMovementForm');

    Route::post('/addIssuanceDetail', 'StoreAddDetailControler@addIssuanceDetail');
    Route::post('/addIssuanceReturnDetail', 'StoreAddDetailControler@addIssuanceReturnDetail');


    Route::post('/updateIssuanceDetail', 'StoreAddDetailControler@updateIssuanceDetail');
    Route::post('/updateIssuanceReturnDetail', 'StoreAddDetailControler@updateIssuanceReturnDetail');

    Route::post('/issuence_return', 'StoreAddDetailControler@issuence_return');
    Route::post('/add_production', 'StoreAddDetailControler@add_production');

    Route::post('/insertDirectPurchaseOrder', 'StoreAddDetailControler@insertDirectPurchaseOrder');


    Route::post('/stockAdjustment', 'StoreAddDetailControler@stockAdjustment');


    Route::post('/insert_opening_data', 'StoreAddDetailControler@insert_opening_data');
    Route::post('/createPurchaseRequestDetailForm', 'StoreDataCallController@createPurchaseRequestDetailForm');
    Route::post('/addPurchaseRequestDetail', 'StoreAddDetailControler@addPurchaseRequestDetail');
    Route::post('/editPurchaseRequestVoucherDetail', 'StoreEditDetailControler@editPurchaseRequestVoucherDetail');

    Route::post('/createPurchaseRequestSaleDetailForm', 'StoreDataCallController@createPurchaseRequestSaleDetailForm');
    Route::post('/addPurchaseRequestSaleDetail', 'StoreAddDetailControler@addPurchaseRequestSaleDetail');
    Route::post('/editPurchaseRequestSaleVoucherDetail', 'StoreEditDetailControler@editPurchaseRequestSaleVoucherDetail');

    Route::post('/createStoreChallanReturnDetailForm', 'StoreDataCallController@createStoreChallanReturnDetailForm');
    Route::post('/addStoreChallanReturnDetail', 'StoreAddDetailControler@addStoreChallanReturnDetail');
    Route::post('/editStoreChallanReturnDetail', 'StoreEditDetailControler@editStoreChallanReturnDetail');

    Route::get('/Email_Sent', 'StoreAddDetailControler@Email_Sent');
    Route::get('/p_detail_report', 'StoreDataCallController@p_detail_report');
    Route::get('/stockDetailReport', 'StoreDataCallController@stockDetailReport');
    Route::get('/UpdateTableDataSubitem', 'StoreAddDetailControler@UpdateTableDataSubitem');

    Route::post('/addConvertGrnData', 'StoreAddDetailControler@addConvertGrnData');
});

Route::group(['prefix' => 'stdc', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::get('/filterDemandVoucherList', 'StoreDataCallController@filterDemandVoucherList');
    Route::get('/get_work_order_data', 'StoreDataCallController@get_work_order_data');
    Route::get('/approve_transfer', 'StoreDataCallController@approve_transfer');
    Route::get('/approveIssuance', 'StoreDataCallController@approveIssuance');
    Route::get('/getStockTransferDataAjax', 'StoreDataCallController@getStockTransferDataAjax');
    Route::get('/getStockTransferReportDataAjax', 'StoreDataCallController@getStockTransferReportDataAjax');
    Route::get('/delete_issue', 'StoreDataCallController@delete_issue');
    Route::get('/delete_issue_return', 'StoreDataCallController@delete_issue_return');
    Route::get('/delete_internal_cons', 'StoreDataCallController@delete_internal_cons');
    Route::get('/cancelDemandVoucher', 'StoreDataCallController@cancelDemandVoucher');


    Route::get('/viewIssuanceDetail', 'StoreDataCallController@viewIssuanceDetail');
    Route::get('/viewIssuanceReturnDetail', 'StoreDataCallController@viewIssuanceReturnDetail');


    Route::get('/filterApproveDemandListandCreateStoreChallan', 'StoreDataCallController@filterApproveDemandListandCreateStoreChallan');
    Route::get('/filterStoreChallanVoucherList', 'StoreDataCallController@filterStoreChallanVoucherList');
    Route::get('/viewStoreChallanVoucherDetail', 'StoreDataCallController@viewStoreChallanVoucherDetail');

    Route::get('/filterApproveDemandListandCreatePurchaseRequest', 'StoreDataCallController@filterApproveDemandListandCreatePurchaseRequest');
    Route::get('/filterPurchaseRequestVoucherList', 'StoreDataCallController@filterPurchaseRequestVoucherList');
    Route::get('/viewPurchaseRequestVoucherDetail', 'StoreDataCallController@viewPurchaseRequestVoucherDetail');


    Route::get('/filterApproveDemandListandCreatePurchaseRequestSale', 'StoreDataCallController@filterApproveDemandListandCreatePurchaseRequestSale');
    Route::get('/filterPurchaseRequestSaleVoucherList', 'StoreDataCallController@filterPurchaseRequestSaleVoucherList');
    Route::get('/viewPurchaseRequestSaleVoucherDetail', 'StoreDataCallController@viewPurchaseRequestSaleVoucherDetail');

    Route::get('/filterApproveStoreChallanandCreateStoreChallanReturn', 'StoreDataCallController@filterApproveStoreChallanandCreateStoreChallanReturn');
    Route::get('/filterStoreChallanReturnList', 'StoreDataCallController@filterStoreChallanReturnList');
    Route::get('/viewStoreChallanReturnDetail', 'StoreDataCallController@viewStoreChallanReturnDetail');

    Route::get('/filterViewDateWiseStockInventoryReport', 'StoreDataCallController@filterViewDateWiseStockInventoryReport');
    Route::get('/viewStockInventorySummaryDetail', 'StoreDataCallController@viewStockInventorySummaryDetail');
    Route::get('/viewStockTransferDetail', 'StoreDataCallController@viewStockTransferDetail');
    Route::get('/getBuyerWiseOpeningData', 'StoreDataCallController@getBuyerWiseOpeningData');
    Route::get('/getVendorWiseOpeningData', 'StoreDataCallController@getVendorWiseOpeningData');
    Route::get('/UpdateBuyerOpening', 'StoreDataCallController@UpdateBuyerOpening');
    Route::get('/UpdateVendorOpening', 'StoreDataCallController@UpdateVendorOpening');
    Route::get('/getPoDataPoNoWise', 'StoreDataCallController@getPoDataPoNoWise');
    Route::get('/view_internal_consumtion_detail', 'StoreDataCallController@view_internal_consumtion_detail');
    Route::get('/internal_cosum', 'StoreDataCallController@internal_cosum');
});




//End Store

//Start Sales
Route::group(['prefix' => 'sales', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::get('/s', 'SalesController@toDayActivity');

    Route::get('/topFiveSalesReportPage', 'SalesController@topFiveSalesReportPage');

    Route::get('/debtor_payment_detail', 'SalesController@debtor_payment_detail');


    Route::get('/debtor_balance_page', 'SalesController@debtor_balance_page');
    Route::get('/commission_report_page', 'SalesController@commission_report_page');


    Route::get('/freight_collection_page', 'SalesController@freight_collection_page');

    Route::get('/soTrackingQtyPage', 'SalesController@soTrackingQtyPage');

    Route::get('/outstandingReportPage', 'SalesController@outstandingReportPage');
    Route::get('/salesTaxInvoiceReportPage', 'SalesController@salesTaxInvoiceReportPage');

    Route::get('/salesActivityPage', 'SalesController@salesActivityPage');
    Route::get('/salesAgingReport', 'SalesController@salesAgingReport');
    Route::get('/getAgingReportDataAjaxSales', 'SalesController@getAgingReportDataAjaxSales');

    Route::get('/createCustomerOpeningBalance', 'SalesController@createCustomerOpeningBalance');
    Route::get('/creatVendorOpeningBalance', 'SalesController@creatVendorOpeningBalance');
    Route::get('/logActivity', 'SalesController@logActivity');
    Route::get('/creditCustomerAddNView', 'SalesController@creditCustomerAddNView');
    Route::get('/cashCustomerAddNView', 'SalesController@cashCustomerAddNView');
    Route::get('/salesActivityAjax', 'SalesController@salesActivityAjax');

    Route::get('/createCashCustomerForm', 'SalesController@createCashCustomerForm');
    Route::get('/viewCashCustomerList', 'SalesController@viewCashCustomerList');

    Route::get('/createCreditCustomerForm', 'SalesController@createCreditCustomerForm');
    Route::get('/editCustomerForm/{id?}', 'SalesController@editCustomerForm');

    Route::get('/uploadCustomerDetail', 'SalesController@uploadCustomerDetail');
    Route::POST('/uploadCustomerDetailPost', 'SalesController@uploadCustomerDetailPost');


    Route::get('/viewCreditCustomerList', 'SalesController@viewCreditCustomerList');
    Route::get('/add_agent_list', 'SalesController@add_agent_list');


    Route::get('/createCreditSaleVoucherForm', 'SalesController@createCreditSaleVoucherForm');
    Route::get('/viewCreditSaleVouchersList', 'SalesController@viewCreditSaleVouchersList');

    Route::get('/createCashSaleVoucherForm', 'SalesController@createCashSaleVoucherForm');
    Route::get('/viewCashSaleVouchersList', 'SalesController@viewCashSaleVouchersList');
    Route::get('/CreateSalesOrder', 'SalesController@CreateSalesOrder');
    Route::get('/EditSalesOrder/{id}', 'SalesController@EditSalesOrder');


    Route::get('/viewSalesOrderList', 'SalesController@viewSalesOrderList');
    Route::get('/viewSalesOrderDetail/{id?}', 'SalesController@viewSalesOrderDetail');



    // gate pass in SalesOrder
    Route::get('/createGatepassIn', 'SalesController@createGatepassIn');
    Route::get('/listGatepassin', 'SalesController@listGatepassin');
    
    // weighbridge SalesOrder
    Route::get('/createWeighbridge', 'SalesController@createWeighbridge');
    Route::get('/listWeighbridge', 'SalesController@listWeighbridge');

    // second weighbridge SalesOrder
    Route::get('/createSecondWeighbridge', 'SalesController@createSecondWeighbridge');
    Route::get('/listSecondWeighbridge', 'SalesController@listSecondWeighbridge');

    // gatepass out SalesOrder
    Route::get('/createGatepassout', 'SalesController@createGatepassout');
    Route::get('/listGatepassout', 'SalesController@listGatepassout');







    // For Delivery Note
    Route::get('/CreateDeliveryNoteList', 'SalesController@CreateDeliveryNoteList');
    Route::get('/CreateDeliveryNote/{id?}', 'SalesController@CreateDeliveryNote');
    Route::get('/EditDeliveryNote/{id?}', 'SalesController@EditDeliveryNote');
    Route::get('/editSalesReturn/{id?}', 'SalesController@editSalesReturn');
    Route::get('/viewDeliveryNoteList', 'SalesController@viewDeliveryNoteList');
    Route::get('/viewDeliveryNoteListOther', 'SalesController@viewDeliveryNoteListOther');
    Route::get('/viewDeliveryNoteDetail/{id?}', 'SalesController@viewDeliveryNoteDetail');
    Route::get('/viewDeliveryNoteDetailTwo/{id?}', 'SalesController@viewDeliveryNoteDetailTwo');
    Route::get('/ViewMultipleDeliveryNotesDetail', 'SalesController@ViewMultipleDeliveryNotesDetail');
    Route::get('/ViewMultipleSalesTaxInvoices', 'SalesController@ViewMultipleSalesTaxInvoices');
    Route::get('/ViewMultipleCreditNoteDetail', 'SalesController@ViewMultipleCreditNoteDetail');
    Route::get('/editImportDocument/{id?}', 'SalesController@editImportDocument');


    Route::get('/approve_so', 'SalesController@approve_so');
    Route::get('/si_approve', 'SalesController@si_approve');



    Route::get('/CreateSalesTaxInvoiceBySO/{id?}', 'SalesController@CreateSalesTaxInvoiceBySO');

    // For Sales Tax Invoice

    Route::get('/undertaking/{id?}', 'SalesController@undertaking');
    // For Sales Receipt Voucher
    Route::get('/CreateReceiptVoucherList', 'SalesController@CreateReceiptVoucherList');
    Route::get('/receiptVoucherList', 'SalesController@receiptVoucherList');
    Route::get('/editVoucherList{id?}', 'SalesController@editVoucherList');
    Route::get('/CreateSalesTaxInvoiceList', 'SalesController@CreateSalesTaxInvoiceList');
    Route::post('/CreateSalesTaxInvoice', 'SalesController@CreateSalesTaxInvoice');
    Route::get('/EditSalesTaxInvoice/{id?}', 'SalesController@EditSalesTaxInvoice');
    Route::get('/viewSalesTaxInvoiceList', 'SalesController@viewSalesTaxInvoiceList');
    Route::get('/viewSalesTaxInvoiceDetail/{id?}', 'SalesController@viewSalesTaxInvoiceDetail');
    Route::get('/viewReceivedAllVoucher/{id?}', 'SalesController@viewReceivedAllVoucher');
    Route::get('/PrintSalesTaxInvoice/{id?}', 'SalesController@PrintSalesTaxInvoice');
    Route::get('/PrintSalesTaxInvoiceDirect/{id?}', 'SalesController@PrintSalesTaxInvoiceDirect');

    // for credit no
    //te
    Route::get('/CreateCustomerCreditNote', 'SalesController@CreateCustomerCreditNote');

    // credit Not form
    Route::post('/addCustomerCredit_no', 'SalesController@addCustomerCredit_no');


    // credit note list
    Route::get('/viewCustomerCreditNoteList', 'SalesController@viewCustomerCreditNoteList');

    // for credit note detail

    Route::get('/viewCreditNoteDetail/{id?}', 'SalesController@viewCreditNoteDetail');

    Route::get('/createType', 'SalesController@createType');
    Route::get('/createConditions', 'SalesController@createConditions');

    Route::get('/typeList', 'SalesController@typeList');
    Route::get('/conditionList', 'SalesController@conditionList');
    Route::get('/clientJobList', 'SalesController@clientJobList');

    Route::get('/createSurveyBy', 'SalesController@createSurveyBy');
    Route::get('/branchList', 'SalesController@branchList');

    Route::get('/jobTrackingSheet', 'SalesController@jobTrackingSheet');
    Route::get('/jobTrackingSheetCopy', 'SalesController@jobTrackingSheetCopy');
    Route::get('/surveylist', 'SalesController@surveylist');
    Route::get('/jobtrackinglist', 'SalesController@jobtrackinglist');

    Route::get('/ShowAllImages/{id}', 'SalesController@ShowAllImages');
    Route::get('/ShowAllImagesComplaint/{id}', 'SalesController@ShowAllImagesComplaint');

    Route::get('/addClient', 'SalesController@addClient');
    Route::get('/createBranch', 'SalesController@createBranch');

    Route::get('/addDesc', 'SalesController@addDesc');

    Route::get('/addClientJob', 'SalesController@addClientJob');
    Route::get('/addClientJobAjax', 'SalesController@addClientJobAjax');
    Route::get('/addBranchAjax', 'SalesController@addBranchAjax');
    Route::get('/clientList', 'SalesController@clientList');
    Route::get('/clientBranchList', 'SalesController@clientBranchList');

    Route::get('/invoiceDescList', 'SalesController@invoiceDescList');


    Route::get('/createProductType', 'SalesController@createProductType');
    Route::get('/createResourceAssigned', 'SalesController@createResourceAssigned');
    Route::get('/producttypeList', 'SalesController@producttypeList');
    Route::get('/resourceAssignedList', 'SalesController@resourceAssignedList');
    Route::get('/addquotationForm', 'SalesController@addquotationForm');
    Route::get('/quotationList', 'SalesController@quotationList');

    // Amir new modification 22-sep-2020
    Route::post('/createInvoiceForm', 'SalesController@createInvoiceForm');
    //end

    Route::get('/createInvoiceFormseprate{/id?}', 'SalesController@createInvoiceFormseprate');

    Route::get('/editInvoice/{id?}', 'SalesController@editInvoice');
    Route::get('/editQuotation/{id?}', 'SalesController@editQuotation');

    Route::get('/editClientBranchForm/{id?}', 'SalesController@editClientBranchForm');

    Route::get('/invoiceList', 'SalesController@invoiceList');
    Route::get('/createInvoice', 'SalesController@createInvoice');
    Route::get('/addComplaint', 'SalesController@addComplaint');
    Route::get('/complaintList', 'SalesController@complaintList');
    Route::get('/ViewMultipleDeliveryNotesDetail', 'SalesController@ViewMultipleDeliveryNotesDetail');
    Route::Post('/CreateMultipleSalesTaxInvoices', 'SalesController@CreateMultipleSalesTaxInvoices');
    Route::get('/createTestForm', 'SalesController@createTestForm');
    Route::get('/import_payment_process', 'SalesController@import_payment_process');

    Route::get('/importDocumentList', 'SalesController@importDocumentList');
    Route::get('/view_convert_grn', 'SalesController@view_convert_grn');
    Route::get('/soTrackingPage', 'SalesController@soTrackingPage');
    Route::get('/customer_opening_list', 'SalesController@customer_opening_list');
    Route::get('/soReportPage', 'SalesController@soReportPage');
    Route::get('/dnReportPage', 'SalesController@dnReportPage');
    Route::get('/dn_without_Sales', 'SalesController@dn_without_Sales');
    Route::get('/cogs_si', 'SalesController@cogs_si');
    Route::get('/add_point_of_sale', 'SalesController@add_point_of_sale');
    Route::get('/pos_list', 'SalesController@pos_list');
    Route::get('/po_detail', 'SalesController@po_detail');
});

Route::group(['prefix' => 'sad', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {

    Route::any('/createbuldles', 'SalesAddDetailControler@createbuldles');
    Route::post('/pos_return', 'SalesAddDetailControler@pos_return');
    Route::get('/update_cost', 'SalesAddDetailControler@update_cost');
    Route::get('/set_cost', 'SalesAddDetailControler@set_cost');


    Route::post('/addCashCustomerDetail', 'SalesAddDetailControler@addCashCustomerDetail');
    Route::post('/addCreditCustomerDetail', 'SalesAddDetailControler@addCreditCustomerDetail');
    Route::post('/updateCreditCustomerDetail', 'SalesAddDetailControler@updateCreditCustomerDetail');

    Route::post('/addCreditSaleVoucherDetail', 'SalesAddDetailControler@addCreditSaleVoucherDetail');
    Route::post('/addCashSaleVoucherDetail', 'SalesAddDetailControler@addCashSaleVoucherDetail');
    Route::post('/createSalesOrder', 'SalesAddDetailControler@createSalesOrder');
    Route::post('/updateSalesOrder', 'SalesAddDetailControler@updateSalesOrder');


    Route::post('/addeDeliveryNote', 'SalesAddDetailControler@addeDeliveryNote');
    Route::post('/updateDeliveryNote', 'SalesEditDetailController@updateDeliveryNote');

    Route::post('/addeSalesTaxInvoice', 'SalesAddDetailControler@addeSalesTaxInvoice');
    Route::post('/updateSalesTaxInvoice', 'SalesAddDetailControler@updateSalesTaxInvoice');
    Route::post('/addCreditNote', 'SalesAddDetailControler@addCreditNote');

    Route::get('/sales_tax_delete', 'SalesAddDetailControler@sales_tax_delete');
    Route::get('/delivery_note_delete', 'SalesAddDetailControler@delivery_note_delete');
    Route::get('/sale_order_delete', 'SalesAddDetailControler@sale_order_delete');
    Route::get('/delivery_not_delete', 'SalesAddDetailControler@delivery_not_delete');


    Route::post('/addType', 'SalesAddDetailControler@addType');
    Route::post('/addCondition', 'SalesAddDetailControler@addCondition');
    Route::post('/updateCondition', 'SalesAddDetailControler@updateCondition');
    Route::post('/updateProductForm', 'SalesAddDetailControler@updateProductForm');
    Route::post('/updateClientForm', 'SalesAddDetailControler@updateClientForm');
    Route::post('/updateClientBranchForm', 'SalesAddDetailControler@updateClientBranchForm');

    Route::post('/updateProductType', 'SalesAddDetailControler@updateProductType');
    Route::post('/updateResourceAssigned', 'SalesAddDetailControler@updateResourceAssigned');
    Route::post('/updateSurveyByForm', 'SalesAddDetailControler@updateSurveyByForm');
    Route::post('/updateTypeList', 'SalesAddDetailControler@updateTypeList');

    Route::post('/addBranch', 'SalesAddDetailControler@addBranch');
    Route::post('/addClientDetail', 'SalesAddDetailControler@addClientDetail');
    Route::post('/addBranchDetail', 'SalesAddDetailControler@addBranchDetail');

    Route::post('/insertInvoiceDesc', 'SalesAddDetailControler@insertInvoiceDesc');

    Route::post('/addClientJob', 'SalesAddDetailControler@addClientJob');
    Route::get('/addClientJobGET', 'SalesAddDetailControler@addClientJobGET');
    Route::get('/insertBranchAjax', 'SalesAddDetailControler@insertBranchAjax');

    Route::post('/addProductType', 'SalesAddDetailControler@addProductType');
    Route::post('/addResourceAssign', 'SalesAddDetailControler@addResourceAssign');
    Route::post('/addQuotation', 'SalesAddDetailControler@addQuotation');
    Route::post('/updateQuotation', 'SalesAddDetailControler@updateQuotation');
    Route::post('/addInvoiceDetail', 'SalesAddDetailControler@addInvoiceDetail');
    Route::post('/addComplaintDetail', 'SalesAddDetailControler@addComplaintDetail');
    Route::post('/updateInvoiceDetail', 'SalesAddDetailControler@updateInvoiceDetail');
    Route::post('/addTestForm', 'SalesAddDetailControler@addTestForm');
    Route::post('/addConvertGrnData', 'SalesAddDetailControler@addConvertGrnData');
    Route::post('/updateImportDocument', 'SalesAddDetailControler@updateImportDocument');


    Route::post('/add_import_po', 'SalesAddDetailControler@add_import_po');
    Route::post('/update_import_po', 'SalesAddDetailControler@update_import_po');
    Route::post('/update_import_exp', 'SalesAddDetailControler@update_import_exp');

    Route::post('/addCustomerOpeningBalance', 'SalesAddDetailControler@addCustomerOpeningBalance');
    Route::post('/addVendorOpeningBalance', 'SalesAddDetailControler@addVendorOpeningBalance');


    Route::get('/add_pos', 'SalesAddDetailControler@add_pos');
    Route::any('/pos_data', 'SalesAddDetailControler@pos_data');
});
Route::group(['prefix' => 'sdc', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::get('/getTopFiveSalesReport', 'SalesDataCallController@getTopFiveSalesReport');
    Route::get('/get_bundels_data', 'SalesDataCallController@get_bundels_data');
    Route::get('/getCommissionColumn', 'SalesDataCallController@getCommissionColumn');
    Route::get('/get_commission_data_ajax', 'SalesDataCallController@get_commission_data_ajax');

    Route::get('/getFreightCollectionReport', 'SalesDataCallController@getFreightCollectionReport');
    Route::get('/updateScNo', 'SalesDataCallController@updateScNo');
    Route::get('/update_agent_in_customer', 'SalesDataCallController@update_agent_in_customer');
    Route::get('/import_payment_delete', 'SalesDataCallController@import_payment_delete');
    Route::get('/import_delete', 'SalesDataCallController@import_delete');

    Route::get('/viewPaymentDetail', 'SalesDataCallController@viewPaymentDetail');
    Route::get('/getSoTrackingQtyAjax', 'SalesDataCallController@getSoTrackingQtyAjax');

    Route::get('/viewCashCustomerList', 'SalesDataCallController@viewCashCustomerList');
    Route::get('/getSalesTaxInvoiceReportData', 'SalesDataCallController@getSalesTaxInvoiceReportData');
    Route::get('/getDnWithoutSalesTax', 'SalesDataCallController@getDnWithoutSalesTax');
    Route::get('/update_cost', 'SalesDataCallController@update_cost');



    Route::get('/viewCreditCustomerList', 'SalesDataCallController@viewCreditCustomerList');
    Route::get('/filterCreditSaleVoucherList', 'SalesDataCallController@filterCreditSaleVoucherList');
    Route::get('/filterCashSaleVoucherList', 'SalesDataCallController@filterCashSaleVoucherList');
    Route::get('/viewCreditSaleVoucherDetail', 'SalesDataCallController@viewCreditSaleVoucherDetail');
    Route::get('/viewCashSaleVoucherDetail', 'SalesDataCallController@viewCashSaleVoucherDetail');
    Route::get('/viewQuotationDetail', 'SalesDataCallController@viewQuotationDetail');
    Route::get('/viewInvoiceDetail', 'SalesDataCallController@viewInvoiceDetail');
    Route::get('/viewComplaintDetail', 'SalesDataCallController@viewComplaintDetail');
    Route::get('/viewQuotationDetailTwo', 'SalesDataCallController@viewQuotationDetailTwo');
    Route::get('/filterByClientAndRegionSurvey', 'SalesDataCallController@filterByClientAndRegionSurvey');
    Route::get('/filterByClientAndRegionQuotation', 'SalesDataCallController@filterByClientAndRegionQuotation');
    Route::get('/filterByClientAndRegionComplaint', 'SalesDataCallController@filterByClientAndRegionComplaint');
    Route::get('/cogs_si', 'SalesDataCallController@cogs_si');

    Route::get('/addData', 'SalesDataCallController@addData');
    Route::get('/approve_invoice/{id?}', 'SalesDataCallController@approve_invoice');
    Route::get('/viewReceiptVoucher', 'SalesDataCallController@viewReceiptVoucher');
    Route::get('/viewReceiptVoucherPrint', 'SalesDataCallController@viewReceiptVoucherPrint');

    Route::get('/viewReceiptVoucherDirect', 'SalesDataCallController@viewReceiptVoucherDirect');

    Route::get('/check_item_master_code', 'SalesDataCallController@check_item_master_code');
    Route::get('/customer_delete', 'SalesDataCallController@customer_delete');


    Route::get('/get_import_data', 'SalesDataCallController@get_import_data');
    Route::get('/get_import_docs', 'SalesDataCallController@get_import_docs');

    Route::get('/get_pay_form', 'SalesDataCallController@get_pay_form');
    Route::get('/getSalesOrderDateWise', 'SalesDataCallController@getSalesOrderDateWise');
    Route::get('/getSalesOrderDateWiseForDeliveryNote', 'SalesDataCallController@getSalesOrderDateWiseForDeliveryNote');


    Route::get('/get_batch_details', 'SalesDataCallController@get_batch_details');
    Route::get('/addSalesOrder', 'SalesDataCallController@addSalesOrder');
    // for credit not
    Route::get('/getSalesTaxInvoice', 'SalesDataCallController@getSalesTaxInvoice');
    Route::get('/viewSurveyListDetail', 'SalesDataCallController@viewSurveyListDetail');


    Route::get('/viewJobTrackingListDetail', 'SalesDataCallController@viewJobTrackingListDetail');

    Route::post('/AddJobTrackingDetail', 'SalesDataCallController@AddJobTrackingDetail');
    Route::get('/getTrackingSheet', 'SalesDataCallController@getTrackingSheet');
    Route::get('/getQuatationForm', 'SalesDataCallController@getQuatationForm');
    Route::get('/editConditionForm', 'SalesDataCallController@editConditionForm');
    Route::get('/editProductForm', 'SalesDataCallController@editProductForm');
    Route::get('/editClientForm', 'SalesDataCallController@editClientForm');


    Route::get('/editSurveyByForm', 'SalesDataCallController@editSurveyByForm');
    Route::get('/editProductTypeForm', 'SalesDataCallController@editProductTypeForm');
    Route::get('/editResourceAssignedForm', 'SalesDataCallController@editResourceAssignedForm');
    Route::get('/editTypeList', 'SalesDataCallController@editTypeList');
    Route::get('/ApprovedSurvey', 'SalesDataCallController@ApprovedSurvey');
    Route::get('/ApprovedJobOrder', 'SalesDataCallController@ApprovedJobOrder');
    Route::get('/ApprovedQuotation', 'SalesDataCallController@ApprovedQuotation');
    Route::get('/Activity_log_list_ajax', 'SalesDataCallController@Activity_log_list_ajax');
    Route::get('/getDataClientWise', 'SalesDataCallController@getDataClientWise');
    Route::get('/getRecieptDataClientWise', 'SalesDataCallController@getRecieptDataClientWise');
    Route::get('/getOutstandingReportAjax', 'SalesDataCallController@getOutstandingReportAjax');
    Route::get('/get_debtor_balance_ajax', 'SalesDataCallController@get_debtor_balance_ajax');


    Route::get('/TrackingDelete', 'SalesDataCallController@TrackingDelete');

    Route::get('/invoice_list', 'SalesDataCallController@invoice_list');
    Route::get('/viewImportPoDetail', 'SalesDataCallController@viewImportPoDetail');

    Route::get('/sals_history', 'SalesDataCallController@sals_history');
    Route::get('/delete_sales_return', 'SalesDataCallController@delete_sales_return');
    Route::get('/createCustomerAccount', 'SalesDataCallController@createCustomerAccount');
    Route::get('/getSoReportBySoNo', 'SalesDataCallController@getSoReportBySoNo');
    Route::get('/getSoDetailDateWise', 'SalesDataCallController@getSoDetailDateWise');
    Route::get('/getDnDetailDateWise', 'SalesDataCallController@getDnDetailDateWise');
    Route::get('/getDeliveryNoteFilterWise', 'SalesDataCallController@getDeliveryNoteFilterWise');
    Route::get('/getSalesTaxInvoiceeFilterWise', 'SalesDataCallController@getSalesTaxInvoiceeFilterWise');
    Route::get('/getCustomerCreditNoteData', 'SalesDataCallController@getCustomerCreditNoteData');
    Route::get('/pos_delete', 'SalesDataCallController@pos_delete');


    //
    Route::get('/pos_list_flter_wise', 'SalesDataCallController@pos_list_flter_wise');
    Route::get('/delete_pos', 'SalesDataCallController@delete_pos');
});

Route::group(['prefix' => 'smfal', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::get('/subItemListLoadDepandentCategoryId', 'SaleMakeFormAjaxLoadController@subItemListLoadDepandentCategoryId');
    Route::get('/addMoreCreditSaleDetailRows', 'SaleMakeFormAjaxLoadController@addMoreCreditSaleDetailRows');
    Route::get('/addMoreCashSaleDetailRows', 'SaleMakeFormAjaxLoadController@addMoreCashSaleDetailRows');
    Route::get('/deleteSurvey', 'SaleMakeFormAjaxLoadController@deleteSurvey');
    Route::get('/jobOrderDelete', 'SaleMakeFormAjaxLoadController@jobOrderDelete');
    Route::get('/job_Order_Jvc_Submitted', 'SaleMakeFormAjaxLoadController@job_Order_Jvc_Submitted');
    Route::get('/QuotationDelete', 'SaleMakeFormAjaxLoadController@QuotationDelete');
    Route::get('/invoiceDelete', 'SaleMakeFormAjaxLoadController@invoiceDelete');
});

Route::group(['prefix' => 'sa', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::get('/creditSaleVoucherApprove', 'SaleApprovalDataCallController@creditSaleVoucherApprove');
    Route::get('/checkQuantityinStock', 'SaleApprovalDataCallController@checkQuantityinStock');
    Route::get('/cashSaleVoucherDelete', 'SaleApprovalDataCallController@cashSaleVoucherDelete');
    Route::get('/cashSaleVoucherRepost', 'SaleApprovalDataCallController@cashSaleVoucherRepost');
    Route::get('/get_batch_detail', 'SalesDataCallController@get_batch_detail');
});


//End Sales


//Start Report
Route::group(['prefix' => 'reports', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {

    
    Route::get('/viewStockAgeingReport', 'ReportsController@viewStockAgeingReport');
    Route::get('/viewStockAgeingReportDetail', 'ReportsController@viewStockAgeingReportDetail');


    Route::get('/viewItemWiseStatusReport', 'ReportsController@viewItemWiseStatusReport');

    Route::get('/categoryWiseReport', 'ReportsController@categoryWiseReport');
    Route::get('/categoryWiseReportAjax', 'ReportsController@categoryWiseReportAjax');



    Route::get('/categoryWiseReportWithoutPOGrn', 'ReportsController@categoryWiseReportWithoutPOGrn');
    Route::get('/categoryWiseReportWithoutPOGrnAjax', 'ReportsController@categoryWiseReportWithoutPOGrnAjax');



    Route::get('/viewBankDepositSummary', 'ReportsController@viewBankDepositSummary');
    Route::get('/viewBranchPerformanceReports', 'ReportsController@viewBranchPerformanceReports');
    Route::get('/viewBranchExpenseSummaryReports', 'ReportsController@viewBranchExpenseSummaryReports');
    Route::get('/viewBranchExpenseSummaryDetailReports', 'ReportsController@viewBranchExpenseSummaryDetailReports');

    Route::get('/viewInventoryPerformanceDetailReports', 'ReportsController@viewInventoryPerformanceDetailReports');
    Route::get('/p_detail_report', 'ReportsController@p_detail_report');
    Route::get('/create_daily_activity', 'ReportsController@create_daily_activity');
    Route::get('/edit_daily_activity', 'ReportsController@edit_daily_activity');
    Route::post('/insertDailyTask', 'ReportsController@insertDailyTask');
    Route::post('/updateDailyTask', 'ReportsController@updateDailyTask');
    Route::get('/UpdateRemarks', 'ReportsController@UpdateRemarks');
    Route::get('/daily_activity_list', 'ReportsController@daily_activity_list');
    Route::get('/full_daily_activity_list', 'ReportsController@full_daily_activity_list');
    Route::get('/full_daily_activity_list_ajax', 'ReportsController@full_daily_activity_list_ajax');
    Route::get('/get_daily_task', 'ReportsController@get_daily_task');
    Route::get('/get_remarks', 'ReportsController@get_remarks');
    Route::get('/job_Done', 'ReportsController@job_Done');
    Route::get('/job_Delay', 'ReportsController@job_Delay');
    Route::get('/job_Hold', 'ReportsController@job_Hold');
    Route::get('/viewPurchaseReport', 'ReportsController@viewPurchaseReport');
    Route::get('/viewPurchaseRequestReport', 'ReportsController@viewPurchaseRequestReport');


    Route::get('/viewMaterialReport', 'ReportsController@viewMaterialReport');
});

Route::group(['prefix' => 'production', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {

    Route::get('/get_machine_data_by_finish_good', 'ProductionController@get_machine_data_by_finish_good');
    Route::get('/get_machine_data_by_finish_good_for_operation', 'ProductionController@get_machine_data_by_finish_good_for_operation');
    Route::get('/production_dashboard', 'ProductionController@production_dashboard');
    Route::get('/create_factory_over_head', 'ProductionController@create_factory_over_head');
    Route::get('/edit_factory_over_head', 'ProductionController@edit_factory_over_head');
    Route::get('/create_labours_working', 'ProductionController@create_labours_working');
    Route::get('/edit_labours_working', 'ProductionController@edit_labours_working');
    Route::get('/labour_working_list', 'ProductionController@labour_working_list');
    Route::get('/create_production_plane', 'ProductionController@create_production_plane');
    Route::get('/edit_production_plane', 'ProductionController@edit_production_plane');
    Route::get('/ppc_issue_item', 'ProductionController@ppc_issue_item');
    Route::get('/production_plan_list', 'ProductionController@production_plan_list');
    Route::get('/get_production_plan_list', 'ProductionController@get_production_plan_list');
    Route::get('/get_route', 'ProductionController@get_route');
    Route::get('/save_issue_material', 'ProductionController@save_issue_material');
    Route::get('/view_plan', 'ProductionController@view_plan');
    Route::get('/material_return', 'ProductionController@material_return');
    Route::get('/return_material', 'ProductionController@return_material');
    Route::get('/conversion', 'ProductionController@conversion');
    Route::get('/get_ledger_data', 'ProductionController@get_ledger_data');
    Route::get('/consumption_edit', 'ProductionController@consumption_edit');

    Route::get('/conversion_cost', 'ProductionController@conversion_cost');
    Route::get('/get_cost_data', 'ProductionController@get_cost_data');
    Route::get('/view_issuence', 'ProductionController@view_issuence');


    Route::get('/view_cost', 'ProductionController@view_cost');
    Route::get('/production_activity_page', 'ProductionController@production_activity_page');
    Route::get('/production_activity_ajax', 'ProductionController@production_activity_ajax');


    Route::post('/cost_insert', 'ProductionController@cost_insert');



    Route::get('/createDaiForm', 'ProductionController@createDaiForm');
    Route::get('/editDaiForm', 'ProductionController@editDaiForm');

    Route::get('/getCheckingDuplicate', 'ProductionController@getCheckingDuplicate');

    Route::get('/getCharges', 'ProductionController@getCharges');

    Route::get('/get_machine_by_finish_good', 'ProductionController@get_machine_by_finish_good');
    Route::get('/create_die_detail', 'ProductionController@create_die_detail');
    Route::get('/factory_over_head_cateogory_list', 'ProductionController@factory_over_head_cateogory_list');

    Route::get('/create_bom_detail', 'ProductionController@create_bom_detail');

    Route::get('/createMoldForm', 'ProductionController@createMoldForm');
    Route::get('/editMoldForm', 'ProductionController@editMoldForm');
    Route::get('/createMachineForm', 'ProductionController@createMachineForm');
    Route::get('/editMachineForm', 'ProductionController@editMachineForm');
    Route::get('/insert_dai', 'ProductionController@insert_dai');
    Route::get('/update_dai', 'ProductionController@update_dai');

    Route::get('/insert_mold', 'ProductionController@insert_mold');
    Route::get('/update_mold', 'ProductionController@update_mold');

    Route::get('/moldList', 'ProductionController@moldList');
    Route::get('/daiList', 'ProductionController@daiList');
    Route::post('/insert_machine', 'ProductionController@insert_machine');
    Route::post('/update_machine', 'ProductionController@update_machine');
    Route::get('/machineCodeCheck', 'ProductionController@machineCodeCheck');
    Route::get('/machine_list', 'ProductionController@machine_list');
    Route::get('/create_routing', 'ProductionController@create_routing');
    Route::get('/edit_routing', 'ProductionController@edit_routing');
    Route::get('/viewMachineDetail', 'ProductionController@viewMachineDetail');
    Route::get('/viewDieDetail', 'ProductionController@viewDieDetail');
    Route::get('/viewMoldDetail', 'ProductionController@viewMoldDetail');

    Route::get('/create_bill_of_material', 'ProductionController@create_bill_of_material');
    Route::get('/edit_bill_of_material', 'ProductionController@edit_bill_of_material');
    Route::post('/insert_bom', 'ProductionController@insert_bom');
    Route::post('/update_bom', 'ProductionController@update_bom');
    Route::get('/bom_list', 'ProductionController@bom_list');
    Route::get('/viewBomDetail', 'ProductionController@viewBomDetail');
    Route::get('/viewLabourWorkingDetail', 'ProductionController@viewLabourWorkingDetail');

    Route::get('/viewRoutingDetail', 'ProductionController@viewRoutingDetail');

    Route::get('/create_operation', 'ProductionController@create_operation');
    Route::get('/edit_operation', 'ProductionController@edit_operation');
    Route::get('/operation_list', 'ProductionController@operation_list');
    Route::get('/insert_operation', 'ProductionController@insert_operation');
    Route::get('/add_mould_detail', 'ProductionController@add_mould_detail');
    Route::post('/insert_mould_detail', 'ProductionController@insert_mould_detail');
    Route::get('/create_labour_category', 'ProductionController@create_labour_category');
    Route::get('/labour_category_list', 'ProductionController@labour_category_list');
    Route::get('/viewOperationDetail', 'ProductionController@viewOperationDetail');
    Route::get('/get_operation_data', 'ProductionController@get_operation_data');
    Route::get('/factory_overhead_list', 'ProductionController@factory_overhead_list');
    Route::get('/view_factory_overhead_detail', 'ProductionController@view_factory_overhead_detail');
    Route::get('/decline_cost', 'ProductionController@decline_cost');
    Route::get('/approve_plan', 'ProductionController@approve_plan');
    Route::get('/production_detail_report', 'ProductionController@production_detail_report');
    Route::get('/get_production_detail_report', 'ProductionController@get_production_detail_report');



    Route::get('/routing_list', 'ProductionController@routing_list');
    Route::get('/delete_machine_data', 'ProductionController@delete_machine_data');


    Route::get('/costing_finish_goods', 'ProductionController@costing_finish_goods');
    Route::get('/get_finish_goods_data', 'ProductionController@get_finish_goods_data');


    Route::get('/scarp_report', 'ProductionController@scarp_report');
    Route::get('/get_scarp_report', 'ProductionController@get_scarp_report');


    Route::get('/die_usage_report', 'ProductionController@die_usage_report');
    Route::get('/die_mould_usage_report', 'ProductionController@die_mould_usage_report');
    Route::get('/die_usage', 'ProductionController@die_usage');


    Route::get('/mould_usage_report', 'ProductionController@mould_usage_report');
    Route::get('/get_mould_usage_report', 'ProductionController@get_mould_usage_report');
    Route::get('/die_usage', 'ProductionController@die_usage');

    Route::get('/machine_usage_report', 'ProductionController@machine_usage_report');
    Route::get('/get_machine_usage_data', 'ProductionController@get_machine_usage_data');


    Route::get('/costing_finish_goods_estimator', 'ProductionController@costing_finish_goods_estimator');
    Route::get('/get_data', 'ProductionController@get_data');


    Route::get('/finish_good_cost_history', 'ProductionController@finish_good_cost_history');
    Route::get('/get_finish_goods_history', 'ProductionController@get_finish_goods_history');
    Route::any('/add_estimatore', 'ProductionController@add_estimatore');

    Route::get('/mould_usage', 'ProductionController@mould_usage');
});

Route::group(['prefix' => 'prad', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::post('/inser_over_head_category', 'ProductionAddDetailController@inser_over_head_category');
    Route::post('/insert_dai_detail', 'ProductionAddDetailController@insert_dai_detail');
    Route::post('/insert_bom_detail', 'ProductionAddDetailController@insert_bom_detail');
    Route::get('/insert_labour_category', 'ProductionAddDetailController@insert_labour_category');
    Route::post('/insert_operation_detail', 'ProductionAddDetailController@insert_operation_detail');
    Route::post('/update_operation_detail', 'ProductionAddDetailController@update_operation_detail');
    Route::post('/add_route', 'ProductionAddDetailController@add_route');
    Route::post('/update_route', 'ProductionAddDetailController@update_route');
    Route::post('/add_factory_over_head', 'ProductionAddDetailController@add_factory_over_head');
    Route::post('/update_factory_over_head', 'ProductionAddDetailController@update_factory_over_head');
    Route::post('/insert_labours_working', 'ProductionAddDetailController@insert_labours_working');
    Route::post('/update_labours_working', 'ProductionAddDetailController@update_labours_working');
    Route::any('/insert_ppc', 'ProductionAddDetailController@insert_ppc');
    Route::post('/update_ppc', 'ProductionAddDetailController@update_ppc');
    Route::post('/update_internal_consum', 'ProductionAddDetailController@update_internal_consum');

    Route::any('/insert_conversion', 'ProductionAddDetailController@insert_conversion');
});

Route::group(['prefix' => 'prd', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {

    Route::get('/delete_die', 'ProductionDeleteController@delete_die');
    Route::get('/delete_mould', 'ProductionDeleteController@delete_mould');
    Route::get('/delete_machine', 'ProductionDeleteController@delete_machine');
    Route::get('/delete_bom', 'ProductionDeleteController@delete_bom');
    Route::get('/delete_operation', 'ProductionDeleteController@delete_operation');
    Route::get('/delete_route', 'ProductionDeleteController@delete_route');
    Route::get('/delete_factory_over_head', 'ProductionDeleteController@delete_factory_over_head');
    Route::get('/delete_production_plan', 'ProductionDeleteController@delete_production_plan');
});



Route::group(['prefix' => 'rdc', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::get('/inventorySelectList', 'ReportsDataCallController@showBranchInventoryList');
});

Route::get('/testcsvFrom', 'Test_controller@testcsvFrom');
Route::get('/orm_test', 'Test_controller@orm_test');
Route::post('/addcsvDetail', 'Test_controller@addcsvDetail');
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});


Route::group(['prefix' => '', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    
    Route::get('/fetchPO', 'PaymentVoucherDetails@fetchPO');
    Route::get('/fetchPI', 'PaymentVoucherDetails@fetchPI');
    
    
    Route::post('/insertBankPayment', 'PaymentVoucherDetails@insertBankPayment');
    Route::post('/insertCashPayment', 'PaymentVoucherDetails@insertCashPayment');
    Route::post('/insertJournalVoucher', 'PaymentVoucherDetails@insertJournalVoucher');
    Route::post('/insertBankRv', 'PaymentVoucherDetails@insertBankRv');
    Route::post('/insertCashRv', 'PaymentVoucherDetails@insertCashRv');
    Route::post('/insert_new_pv', 'PaymentVoucherDetails@insert_new_pv');
    Route::post('/update_new_pv', 'PaymentVoucherDetails@update_new_pv');



    Route::post('/approvedPaymentVoucher', 'PaymentVoucherDetails@approvedPaymentVoucher');
    Route::post('/updateCashPayment', 'PaymentVoucherDetails@updateCashPayment');
    Route::post('/updateBankRv', 'PaymentVoucherDetails@updateBankRv');
    Route::post('/updateCashRv', 'PaymentVoucherDetails@updateCashRv');
    Route::post('/UpdateJv', 'PaymentVoucherDetails@UpdateJv');

    Route::post('/updateBankPaymentNew', 'PaymentVoucherDetails@updateBankPaymentNew');
    Route::get('/approve_voucher', 'PaymentVoucherDetails@approve_voucher');

    Route::get('/DeletePVoucherActivity', 'PaymentVoucherDetails@DeletePVoucherActivity');
    Route::get('/payment_return', 'PaymentVoucherDetails@payment_return');

    Route::get('/DeletePurchaseVoucher', 'PaymentVoucherDetails@DeletePurchaseVoucher');
    Route::get('/DeleteJVoucherActivity', 'PaymentVoucherDetails@DeleteJVoucherActivity');
    Route::get('/DeleteRVoucherActivity', 'PaymentVoucherDetails@DeleteRVoucherActivity');


    Route::Post('/PaymentPurchaseVoucher', 'PaymentVoucherDetails@PaymentPurchaseVoucher');
    Route::Post('/AddPaymentPurchaseVoucher', 'PaymentVoucherDetails@AddPaymentPurchaseVoucher');
    Route::get('/editPaymentPurchaseVoucher/{id?}', 'PaymentVoucherDetails@editPaymentPurchaseVoucher');
    Route::Post('/updatePaymentPurchaseVoucher', 'PaymentVoucherDetails@updatePaymentPurchaseVoucher');
    Route::get('/DataSortBySupplier', 'PaymentVoucherDetails@DataSortBySupplier');
    Route::get('/DataSortBySupplierByPiOrPo', 'PaymentVoucherDetails@DataSortBySupplierByPiOrPo');
    Route::get('/getVoucherDetailDataByVoucherNo', 'PaymentVoucherDetails@getVoucherDetailDataByVoucherNo');

    Route::get('/get_advance_amount', 'PaymentVoucherDetails@get_advance_amount');
    Route::get('/adjust_amount/{id?}/{supplier_id}', 'PaymentVoucherDetails@adjust_amount');
    Route::post('/adjust_amount_entry', 'PaymentVoucherDetails@adjust_amount_entry');
    Route::get('/hit_vouchers', 'PaymentVoucherDetails@hit_vouchers');

    Route::get('/CreateInvoiceOpening', 'PaymentVoucherDetails@CreateInvoiceOpening');
    Route::get('/CreateInvoiceOpeningUpdate', 'PaymentVoucherDetails@CreateInvoiceOpeningUpdate');

    Route::post('/update_sales_order', 'PaymentVoucherDetails@update_sales_order');
    Route::get('/company', 'PaymentVoucherDetails@company');
    Route::get('/set_company/{id?}', 'PaymentVoucherDetails@set_company');
    Route::get('/abc', 'PaymentVoucherDetails@abc');
    Route::get('/approve_new_pv', 'PaymentVoucherDetails@approve_new_pv');
});

Route::group(['prefix' => 'gatepass', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::get('/viewGatePassList/{gatePassType?}', 'GatePassController@viewGatePassList');
    Route::get('/viewGatePassDetail', 'GatePassController@viewGatePassDetail')->name('gatepass.viewGatePassDetail');
    Route::get('/approvedGatePass', 'GatePassController@approvedGatePass')->name('gatepass.approvedGatePass');
    Route::get('/reverseGatePass', 'GatePassController@reverseGatePass')->name('gatepass.reverseGatePass');
    Route::get('/deleteGatePass', 'GatePassController@deleteGatePass')->name('gatepass.deleteGatePass');
    Route::get('/createGatePassForm', 'GatePassController@createGatePassForm')->name('gatepass.createGatePassForm');
    Route::get('/createGatePassOutForm', 'GatePassController@createGatePassOutForm')->name('gatepass.createGatePassOutForm');
    Route::post('/insertGatePassForm', 'GatePassController@insertGatePassForm')->name('gatepass.insertGatePassForm');
    Route::get('/getMaintenanceJobDataForGatePass', 'GatePassController@getMaintenanceJobDataForGatePass')->name('gatepass.getMaintenanceJobDataForGatePass');

    
    Route::get('/getGetPassIn', 'GatePassController@getGetPassIn')->name('gatepass.getGetPassIn');
    Route::get('/checkJobType', 'GatePassController@checkJobType')->name('gatepass.checkJobType');
    Route::get('/getMJOGatePassOut', 'GatePassController@getMJOGatePassOut')->name('gatepass.getMJOGatePassOut');
    
    
    Route::get('/editGatepassForm', 'GatePassController@editGatepassForm')->name('gatepass.editGatepassForm');
    Route::post('/updateGatePassForm', 'GatePassController@updateGatePassForm')->name('gatepass.updateGatePassForm');


});
Route::group(['prefix' => 'workshop', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {

    Route::get('/analyzingReportForm', 'WorkshopController@analyzingReportForm');
    Route::post('/addAnalyzingReportDetail', 'WorkshopController@addAnalyzingReportDetail');
    Route::get('/analyzingReportview', 'WorkshopController@analyzingReportView');
    Route::get('/viewAnalyzingReportDetail', 'WorkshopController@viewAnalyzingReportDetail');
    Route::get('/viewAnalyzingDetail', 'WorkshopController@viewAnalyzingDetail');
    Route::get('/deleteAnalyzingMr', 'WorkshopController@deleteAnalyzingMr');
    
    
    Route::get('/processTrackingSummaryReport','WorkshopController@processTrackingSummaryReport');
    Route::get('/createMaintenanceRequestForm', 'WorkshopController@createMaintenanceRequestForm');
    Route::post('/addMaintenanceRequestDetail', 'WorkshopController@addMaintenanceRequestDetail');
    Route::get('/MaintenanceRequestList', 'WorkshopController@MaintenanceRequestList');
    Route::get('/viewMaintenanceRequestDetail', 'WorkshopController@viewMaintenanceRequestDetail');
    Route::get('/approvedMaintenanceRequest', 'WorkshopController@approvedMaintenanceRequest');
    Route::get('/editMaintenanceRequest', 'WorkshopController@editMaintenanceRequest');
    Route::post('/maintenanceRequestUpdate', 'WorkshopController@maintenanceRequestUpdate');
    Route::get('/deleteMaintenanceRequest', 'WorkshopController@deleteMaintenanceRequest');

    Route::get('/createMaintenanceJobForm', 'WorkshopController@createMaintenanceJobForm');
    Route::get('/getMRItemsData', 'WorkshopController@getMRItemsData');
    Route::POST('/addMaintenanceJobDetail', 'WorkshopController@addMaintenanceJobDetail');
    Route::get('/MaintenanceJobList', 'WorkshopController@MaintenanceJobList');
    Route::get('/viewMaintenanceJobDetail', 'WorkshopController@viewMaintenanceJobDetail');
    Route::get('/approvedMaintenanceJob', 'WorkshopController@approvedMaintenanceJob');
    Route::get('/deleteMaintenanceJob', 'WorkshopController@deleteMaintenanceJob');
    
    Route::get('/editMaintenanceJob', 'WorkshopController@editMaintenanceJob');
    Route::post('/maintenanceJobUpdate', 'WorkshopController@maintenanceJobUpdate');

    // Route::get('/createMaintenanceJobOutsourceForm', 'WorkshopController@createMaintenanceJobOutsourceForm');
    // Route::get('/MaintenanceJobOutsourceList', 'WorkshopController@MaintenanceJobOutsourceList');

    Route::get('/createGoodsReturnForm', 'WorkshopController@createGoodsReturnForm');
    Route::get('/getMaintenanceJobDataForGoodsReturn', 'WorkshopController@getMaintenanceJobDataForGoodsReturn');
    Route::get('/getMaintenanceRequestDataForGoodsReturn', 'WorkshopController@getMaintenanceRequestDataForGoodsReturn');
    
    Route::post('/addGoodsReturnDetails', 'WorkshopController@addGoodsReturnDetails');
    Route::get('/GoodsReturnList', 'WorkshopController@GoodsReturnList');
    Route::get('/viewGoodsReturnDetail', 'WorkshopController@viewGoodsReturnDetail');
    Route::get('/approvedGoodsReturnDetails', 'WorkshopController@approvedGoodsReturnDetails');


    Route::get('/CreateMaintenanceInvoiceForm', 'WorkshopController@CreateMaintenanceInvoiceForm');
    Route::get('/EditMaintenanceInvoiceForm', 'WorkshopController@EditMaintenanceInvoiceForm');
    Route::get('/getMaintenanceJobDataForMaintenanceInvoice', 'WorkshopController@getMaintenanceJobDataForMaintenanceInvoice');
    Route::post('/addMaintenanceInvoiceDetail', 'WorkshopController@addMaintenanceInvoiceDetail');
    Route::post('/UpdateMaintenanceInvoiceDetail', 'WorkshopController@UpdateMaintenanceInvoiceDetail');
    Route::get('/viewMaintenanceInvoiceList', 'WorkshopController@viewMaintenanceInvoiceList');
    Route::get('/viewMaintenanceInvoiceDetail', 'WorkshopController@viewMaintenanceInvoiceDetail');
    Route::get('/viewMaintenanceInvoiceSummary', 'WorkshopController@viewMaintenanceInvoiceSummary');
    Route::get('/approvedMaintenanceInvoice', 'WorkshopController@approvedMaintenanceInvoice');
    
    
    Route::get('/createGRNForm', 'WorkshopController@createGRNForm');
    Route::get('/getMaintenanceJobDataForGRN', 'WorkshopController@getMaintenanceJobDataForGRN');
    Route::post('/addWorkshopGRNDetails', 'WorkshopController@addWorkshopGRNDetails');
    Route::get('/viewGRNList', 'WorkshopController@viewGRNList');
    Route::get('/viewGrnDetail', 'WorkshopController@viewGrnDetail');
    Route::get('/approvedGrn', 'WorkshopController@approvedGrn');
    Route::get('/reverseWorkShopGRN', 'WorkshopController@reverseWorkShopGRN');
    Route::get('/getMJOForGrn', 'WorkshopController@getMJOForGrn');
    Route::get('/editWorkshopGrnForm', 'WorkshopController@editWorkshopGrnForm');
    Route::post('/workshopGrnUpdate', 'WorkshopController@workshopGrnUpdate');
    Route::get('/deleteWorkshopGrn', 'WorkshopController@deleteWorkshopGrn');
    

    
    Route::get('/createMaterialForm', 'WorkshopController@createMaterialForm');
    Route::get('/createMaterialFormAjax', 'WorkshopController@createMaterialFormAjax');
    Route::post('/addMaterialIssuanceDetail', 'WorkshopController@addMaterialIssuanceDetail');
    Route::get('/viewMaterialIssuanceList', 'WorkshopController@viewMaterialIssuanceList');
    Route::get('/viewMaterialIssuanceListAjax', 'WorkshopController@viewMaterialIssuanceListAjax');
    Route::get('/viewMaterialIssuanceDetail', 'WorkshopController@viewMaterialIssuanceDetail');
    Route::get('/editMaterialIssuance', 'WorkshopController@editMaterialIssuance');
    Route::post('/updateMaterialIssuanceDetail', 'WorkshopController@updateMaterialIssuanceDetail');
    Route::get('/deleteMaterialIssuance', 'WorkshopController@deleteMaterialIssuance');


});

Route::get('/uploadChartsOfAccounts', function(){
    return view('Finance.uploadChartOfAccounts');
});
Route::post('/uploadCOADetail', function(Request $request){
    DB::Connection('mysql2')->beginTransaction();
    try {
        if ($request->file('dataFile')) {
            Excel::import(new UploadChartOfAccount, $request->file('dataFile'));

        }
        DB::Connection('mysql2')->commit();
    }catch(Exception $e){
        DB::Connection('mysql2')->rollback();
        dd($e->getLine(), $e->getMessage(), $e->getTrace());
    }
});


Route::group(['prefix' => 'ajax', 'middleware' => 'mysql2', 'before' => 'csrf'], function () {
    Route::get('get_data', 'AjaxController@get_data');
});

require('modules/hr.php');
require('modules/selectlist.php');
require('modules/users.php');
require('modules/shah.php');
