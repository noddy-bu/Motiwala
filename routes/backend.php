<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\AuthenticateController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\FaqController;

use App\Http\Controllers\backend\CustomerController;

use App\Http\Controllers\backend\TrumbowygController;

use App\Http\Controllers\backend\ContactController;
use App\Http\Controllers\backend\BusinessSettingController;

use App\Http\Controllers\backend\AuthorController;
use App\Http\Controllers\backend\UserController;

use App\Http\Controllers\backend\TransactionController;
use App\Http\Controllers\backend\TransactionApprovalController;

use App\Http\Controllers\backend\ContactSettingController;

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

//authentication
Route::get('/', function () { return redirect(route('backend.login')); });
Route::get('/login', [AuthenticateController::class, 'index'])->name('backend.login');
Route::post('/login', [AuthenticateController::class, 'login'])->name('backend.login');
Route::get('/logout', [AuthenticateController::class, 'logout'])->name('backend.logout');

//dashborad
Route::get('/dashboard', [DashboardController::class, 'index'])->name('backend.dashboard');


//Customer
Route::group(['prefix' => 'customer', 'middleware' => ['auth', 'role:1,2,3']], function () {
    Route::get('/index', [CustomerController::class, 'index'])->name('Customer.index');

    Route::get('Customer-data', [CustomerController::class, 'getData'])->name('Customer.data');

    Route::get('/list-account/{id}', [CustomerController::class, 'list_account'])->name('Customer.list_account');

    Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('Customer.edit');


    Route::get('/transaction/{id}', [CustomerController::class, 'transaction'])->name('Customer.transaction');

    Route::get('/manual-pay-form/{id}', [CustomerController::class, 'manual_pay_form'])->name('Customer.manual_pay.form');

    Route::post('/manual-payment', [CustomerController::class, 'manual_payment'])->name('Customer.manual.payment');

    Route::get('/close-plan-form/{id}', [CustomerController::class, 'close_plan_form'])->name('Customer.close.form');

    Route::post('/close-plan', [CustomerController::class, 'close_plan'])->name('Customer.close.plan');

    Route::post('/delete/{id}', [CustomerController::class, 'delete'])->name('Customer.delete');
    Route::get('/status/{id}/{status}', [CustomerController::class, 'status'])->name('Customer.status');
});

Route::group(['prefix' => 'transaction', 'middleware' => ['auth', 'role:1,2,3']], function () {
    Route::get('/index', [TransactionController::class, 'index'])->name('transaction.index');
    Route::get('Customer-data', [TransactionController::class, 'getData'])->name('transaction.data');
});

Route::group(['prefix' => 'approval-transaction', 'middleware' => ['auth', 'role:1,2']], function () {
    Route::get('/index', [TransactionApprovalController::class, 'index'])->name('approvaltransaction.index');
    Route::get('Customer-data', [TransactionApprovalController::class, 'getData'])->name('approvaltransaction.data');

    Route::post('/approved/{id}', [TransactionApprovalController::class, 'approved'])->name('approvaltransaction.conform');
});


// //faq
// Route::group(['prefix' => 'faq'], function () {
//     Route::get('/index', [FaqController::class, 'index'])->name('faq.index');
//     Route::get('/add', [FaqController::class, 'add'])->name('faq.add');
//     Route::get('/edit/{id}', [FaqController::class, 'edit'])->name('faq.edit');
//     Route::post('/create', [FaqController::class, 'create'])->name('faq.create');
//     Route::post('/update', [FaqController::class, 'update'])->name('faq.update');
//     Route::post('/delete/{id}', [FaqController::class, 'delete'])->name('faq.delete');
//     Route::get('/status/{id}/{status}', [FaqController::class, 'status'])->name('faq.status');
// });

//trumbowyg
Route::group(['prefix' => 'trumbowyg'], function () {
    Route::post('/upload', [TrumbowygController::class, 'upload'])->name('trumbowyg.upload');
});



//Contact
Route::group(['prefix' => 'contact', 'middleware' => ['auth', 'role:1,2']], function () {
    Route::get('/index', [ContactController::class, 'index'])->name('contact.index');
    Route::get('/view/{id}', [ContactController::class, 'view'])->name('contact.view');
    Route::post('/delete/{id}', [ContactController::class, 'delete'])->name('contact.delete');
});

//setting
Route::group(['prefix' => 'setting', 'middleware' => ['auth', 'role:1,2']], function () {
    // Route::get('/index', [BusinessSettingController::class, 'index'])->name('setting.index');

    Route::get('/set-receivable-gold-rate', [BusinessSettingController::class, 'set_receivable_gold_rate_page'])->name('setting.receivable_gold_page');
    
    // Route::get('/privacy-policy', [BusinessSettingController::class, 'privacy_policy'])->name('setting.privacy');
    // Route::get('/terms', [BusinessSettingController::class, 'terms'])->name('setting.terms');
    // Route::get('/refund-policy', [BusinessSettingController::class, 'refund_policy'])->name('setting.refund_policy');

    Route::post('/update', [BusinessSettingController::class, 'update'])->name('setting.update');
});

// //Contact Page setting
// Route::group(['prefix' => 'contact/page'], function () {
//     Route::get('/index', [ContactSettingController::class, 'index'])->name('contactpage.index');
//     Route::post('/update', [ContactSettingController::class, 'update'])->name('contactpage.update');
// });

//clear cache
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('view:clear');

    // Redirect back to the previous page
    return back()->with('status', 'Cache cleared successfully!');
})->name('clear-cache');


//Author
Route::group(['prefix' => 'manage-staff', 'middleware' => ['auth', 'role:1,2']], function () {
    Route::get('/index', [AuthorController::class, 'index'])->name('author.index');
    Route::get('/add', [AuthorController::class, 'add'])->name('author.add');
    Route::get('/edit/{id}', [AuthorController::class, 'edit'])->name('author.edit');
    Route::post('/create', [AuthorController::class, 'create'])->name('author.create');
    Route::post('/update', [AuthorController::class, 'update'])->name('author.update');
    Route::post('/delete/{id}', [AuthorController::class, 'delete'])->name('author.delete');
    Route::get('/status/{id}/{status}', [AuthorController::class, 'status'])->name('author.status');
});

//User
Route::group(['prefix' => 'profile', 'middleware' => ['auth', 'role:1,2,3']], function () {
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::get('/reset/{id}', [UserController::class, 'password'])->name('user.password');
    Route::post('/update', [UserController::class, 'update'])->name('user.update');
    Route::post('/reset', [UserController::class, 'reset'])->name('user.reset');    
});
