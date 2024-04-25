<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\AccountController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

// Home START
Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/blog', [IndexController::class, 'blog'])->name('blog');
Route::get('/blogs-data', [IndexController::class, 'blog_data'])->name('blog-data');

$postCategories = DB::table('blog_categories')->pluck('slug')->toArray();
Route::get('/{category}/{slug}', [IndexController::class, 'blog_detail'])
    ->where('category', implode('|', $postCategories))
    ->name('blog.detail');


Route::get('/contact-us', [IndexController::class, 'contact_us'])->name('contact');
Route::get('/information', [IndexController::class, 'information'])->name('information');
Route::any('/instant-pay', [IndexController::class, 'instantpay'])->name('instantpay');
Route::get('/faq', [IndexController::class, 'faq'])->name('faq');
Route::get('/privacy-policy', [IndexController::class, 'privacy_policy'])->name('privacy-policy');

Route::get('/terms', [IndexController::class, 'terms_page'])->name('terms');
Route::get('/refund-policy', [IndexController::class, 'refund_policy'])->name('refund-policy');

Route::get('/oldschemeclosure', [IndexController::class, 'old_scheme_closure'])->name('old-scheme-closure');

Route::get('/404', [IndexController::class, 'not_found'])->name('error_page');
Route::get('/thank-you', [IndexController::class, 'thank_you'])->name('thank_you');
Route::get('/cookie-policy', [IndexController::class, 'cookie_policy'])->name('cookie-policy');
Route::post('/contact-save', [IndexController::class, 'contact_save'])->name('contact.create');
Route::post('/comment-save', [IndexController::class, 'comment_save'])->name('comment.create');

Route::get('/search', [IndexController::class, 'search'])->name('search');
// Home END


Route::get('/account/onlineenrollment', [AccountController::class, 'online_enrollment'])->name('account.new.enrollment.page');

Route::any('/create-account/{param}', [AccountController::class, 'create_account'])->name('account.create');

Route::get('/linkaccount', [AccountController::class, 'link_account'])->name('link-account');

Route::get('/edituserprofile', [AccountController::class, 'edit_user_profile'])->name('edit-user-profile');

Route::post('/customer-account-update-profile', [AccountController::class, 'account_update_profile'])->name('account.customer.update.profile');

Route::get('/reset-passoword', [AccountController::class, 'reset_password'])->name('customer.reset_password');
Route::post('/customer-password-update', [AccountController::class, 'reset_password_update'])->name('customer.password.update');

Route::post('/login', [AccountController::class, 'customer_login'])->name('customer.login');

Route::get('/logout', [AccountController::class, 'customer_logout'])->name('customer.logout');


Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('view:clear');
    //$exitCode = Artisan::call('route:cache');
    //$exitCode = Artisan::call('key:generate');
});

Route::get('/key-generate', function () {
    Artisan::call('key:generate', ['--show' => true]);
    return 'Application key generated successfully!';
});

Route::get('/create-storage-link', function () {
    $exitCode = Artisan::call('storage:link');
    
    if ($exitCode === 0) {
        return 'Storage link created successfully.';
    } else {
        return 'Error creating storage link.';
    }
});

Route::get('/send-test-email', function () {
    Mail::raw('Test email content', function ($message) {
        $message->to('khanfaisal.makent@gmail.com')
                ->subject('Test Email');
    });

    return 'Test email sent!';
});

Route::get('/test-otp', function () {
    $sessionData = Session()->all();

    // Print session data
    dd($sessionData);
});

Route::get('/clear-session', function () {
    Session()->flush();

    echo"clear";
});

Route::get('/clear-data', function () {
    session()->forget('step');
    session()->forget('otp_timestamp');
    session()->forget('phone');
    session()->forget('user_id');
    session()->forget('otp');
})->name('clear-data');

Route::get('/update-session', function () {
    Session()->put('step', 9);
})->name('update-session');


Route::get('/resubmit-aadhar-otp', function () {
    Session()->put('step', 5);
})->name('resubmit-aadhar-otp');