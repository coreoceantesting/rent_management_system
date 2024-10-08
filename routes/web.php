<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
})->name('/');


// Guest Users
Route::middleware(['guest', 'PreventBackHistory', 'firewall.all'])->group(function () {
    Route::get('login', [App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('signin');
    Route::get('register', [App\Http\Controllers\Admin\AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [App\Http\Controllers\Admin\AuthController::class, 'storeRegistration'])->name('storeRegistration');
});




// Authenticated users
Route::middleware(['auth', 'PreventBackHistory', 'firewall.all'])->group(function () {

    // Auth Routes
    Route::get('home', fn () => redirect()->route('dashboard'))->name('home');
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [App\Http\Controllers\Admin\AuthController::class, 'Logout'])->name('logout');
    Route::get('change-theme-mode', [App\Http\Controllers\Admin\DashboardController::class, 'changeThemeMode'])->name('change-theme-mode');
    Route::get('show-change-password', [App\Http\Controllers\Admin\AuthController::class, 'showChangePassword'])->name('show-change-password');
    Route::post('change-password', [App\Http\Controllers\Admin\AuthController::class, 'changePassword'])->name('change-password');



    // Masters
    Route::resource('wards', App\Http\Controllers\Admin\Masters\WardController::class);
    Route::resource('regions', App\Http\Controllers\Admin\Masters\RegionController::class);
    

    // Scheme Details
    Route::resource('schemes', App\Http\Controllers\SchemeDetails\SchemeDetailsController::class);
    Route::get('/get-wards-by-region/{region_id}', [App\Http\Controllers\SchemeDetails\SchemeDetailsController::class, 'getWardsByRegion']);
    Route::put('scheme/{scheme_id}/upload-letter', [App\Http\Controllers\SchemeDetails\SchemeDetailsController::class, 'uploadLetter'])->name('upload.letter');
    Route::put('scheme/{scheme_id}/update-demand-amount', [App\Http\Controllers\SchemeDetails\SchemeDetailsController::class, 'updateDemandAmount'])->name('update.demandAmount');
    Route::get('/scheme-details/{id}', [App\Http\Controllers\SchemeDetails\SchemeDetailsController::class, 'getSchemeDetails'])->name('scheme.details');  
    Route::get('/demand-letter/{scheme_id}', [App\Http\Controllers\SchemeDetails\SchemeDetailsController::class, 'demandLetterPdf'])->name('pdf.demandLetter');
    Route::put('scheme/{scheme_id}/upload-payment-slip', [App\Http\Controllers\SchemeDetails\SchemeDetailsController::class, 'uploadPaymentSlip'])->name('upload.PaymentSlip');
    Route::get('/view-payment-slips-list/{schemeId}', [App\Http\Controllers\SchemeDetails\SchemeDetailsController::class, 'view_payment_slips_list'])->name('view_payment_slips_list');
    Route::put('scheme/{scheme_id}/update-final-amount', [App\Http\Controllers\SchemeDetails\SchemeDetailsController::class, 'updateFinalAmount'])->name('update.finalAmount');

    // Tenants Details
    Route::resource('tenants', App\Http\Controllers\TenantsDetails\TenantsDetailsController::class);
    Route::get('/get-tenants/{scheme_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'getTenants'])->name('getTenants');
    Route::get('/tenants-list', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'getTenantsList'])->name('getTenantsList');
    Route::get('/create-rent-details/{tenant_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'createRentHistory'])->name('createRentHistory');
    Route::post('/add-rent-details', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'addRentDetails'])->name('addRentDetails');
    Route::get('/rent-details/{tenant_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'getRentHistory'])->name('getRentHistory');
    Route::get('/rent-history-list', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'getRentHistorylist'])->name('getRentHistoryList');

    Route::get('/rent-list-for-finance', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'financeSectionList'])->name('financeSectionList');
    Route::get('/get-rent-list/{scheme_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'getRentList'])->name('getRentList');
    Route::get('/get-sbi-rent-list/{scheme_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'getSbiRentList'])->name('getSbiRentList');
    Route::get('/get-non-sbi-rent-list/{scheme_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'getNonSbiRentList'])->name('getNonSbiRentList');
    Route::get('/all-approved-list', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'getAllApprove'])->name('getAllApprove');
    Route::get('/get-final-sbi-approve-rent-list/{scheme_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'getFinalApproveSbiRentList'])->name('getFinalApproveSbiRentList');
    Route::get('/get-final-non-sbi-approve-rent-list/{scheme_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'getFinalApproveNonSbiRentList'])->name('getFinalApproveNonSbiRentList');

    Route::get('/view-cheque-list/{schemeId}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'view_cheque_list'])->name('view_cheque_list');

    // finance department Approval
    Route::post('/finance-clerk-approve-all', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'financeClerkApproveAll'])->name('financeClerkApproveAll');
    Route::post('/assistant-account-officer-two-approve-all', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'assistantAccountOfficerTwoApproveAll'])->name('assistantAccountOfficerTwoApproveAll');
    Route::post('/account-officer-two-approve-all', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'accountOfficerTwoApproveAll'])->name('accountOfficerTwoApproveAll');
    Route::post('/finance-controller-approve-all', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'financeControllerApproveAll'])->name('financeControllerApproveAll');
    Route::post('/account-officer-one-approve-all', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'accountOfficerOneApproveAll'])->name('accountOfficerOneApproveAll');
    Route::post('/dy-accountant-approve-all', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'dyAccountantApproveAll'])->name('dyAccountantApproveAll');
    Route::post('/final-approve-all', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'finalApproveAll'])->name('finalApproveAll');
    Route::post('/sbi-cheque-details', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'addSbiChequeDetails'])->name('addSbiChequeDetails');
    Route::post('/non-sbi-cheque-details', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'addNonSbiChequeDetails'])->name('addNonSbiChequeDetails');


    // check balance
    Route::get('/check-balance', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'checkBalance'])->name('check.balance');


    // tenant approval
    Route::post('/finance-approve-tenant/{tenant_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'approvedByFinance'])->name('approvedByFinance');
    Route::post('/collector-approve-tenant/{tenant_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'approvedByCollector'])->name('approvedByCollector');
    Route::post('/finance-reject-tenant/{tenant_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'rejectedByFinance'])->name('rejectedByFinance');
    Route::post('/collector-reject-tenant/{tenant_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'rejectedByCollector'])->name('rejectedByCollector');
    // tenant rent approval
    Route::post('/ar-approve-tenant-rent/{tenant_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'approvedRentByAr'])->name('approvedRentByAr');
    Route::post('/hod-approve-tenant-rent/{tenant_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'approvedRentByHod'])->name('approvedRentByHod');
    Route::post('/finance-approve-tenant-rent/{tenant_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'approvedRentByFinance'])->name('approvedRentByFinance');
    Route::post('/collector-approve-tenant-rent/{tenant_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'approvedRentByCollector'])->name('approvedRentByCollector');
    Route::post('/ar-reject-tenant-rent/{tenant_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'rejectedRentByAr'])->name('rejectedRentByAr');
    Route::post('/finance-reject-tenant-rent/{tenant_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'rejectedRentByFinance'])->name('rejectedRentByFinance');
    Route::post('/collector-reject-tenant-rent/{tenant_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'rejectedRentByCollector'])->name('rejectedRentByCollector');
    Route::post('/hod-reject-tenant-rent/{tenant_id}', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'rejectedRentByHod'])->name('rejectedRentByHod');
    Route::post('/hod-approve-all-tenant-rent', [App\Http\Controllers\TenantsDetails\TenantsDetailsController::class, 'approveAllRentRequest'])->name('approveAllRentRequest');
    




    // Users Roles n Permissions
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::get('users/{user}/toggle', [App\Http\Controllers\Admin\UserController::class, 'toggle'])->name('users.toggle');
    Route::get('users/{user}/retire', [App\Http\Controllers\Admin\UserController::class, 'retire'])->name('users.retire');
    Route::put('users/{user}/change-password', [App\Http\Controllers\Admin\UserController::class, 'changePassword'])->name('users.change-password');
    Route::get('users/{user}/get-role', [App\Http\Controllers\Admin\UserController::class, 'getRole'])->name('users.get-role');
    Route::put('users/{user}/assign-role', [App\Http\Controllers\Admin\UserController::class, 'assignRole'])->name('users.assign-role');
    Route::resource('roles', App\Http\Controllers\Admin\RoleController::class);
});




Route::get('/php', function (Request $request) {
    if (!auth()->check())
        return 'Unauthorized request';

    Artisan::call($request->artisan);
    return dd(Artisan::output());
});
