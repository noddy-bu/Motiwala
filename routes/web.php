<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\AccountController;

use App\Http\Controllers\common\EsignAadharController;

use App\Http\Controllers\common\PayumoneyController;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Common\SmsController;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

Route::get('/contact-us', [IndexController::class, 'contact_us'])->name('contact');
Route::get('/information', [IndexController::class, 'information'])->name('information');
Route::any('/instant-pay', [IndexController::class, 'instantpay'])->name('instantpay');
Route::get('/faq', [IndexController::class, 'faq'])->name('faq');
Route::get('/privacy-policy', [IndexController::class, 'privacy_policy'])->name('privacy-policy');

Route::get('/terms-conditions', [IndexController::class, 'terms_page'])->name('terms');
Route::get('/refund-policy', [IndexController::class, 'refund_policy'])->name('refund-policy');

Route::get('/termsofuse', [IndexController::class, 'terms_of_use'])->name('terms_use');

Route::get('/feedback', [IndexController::class, 'feedback'])->name('feedback');

Route::get('/about-us', [IndexController::class, 'about_us'])->name('about_us');

Route::get('/contact-us', [IndexController::class, 'contact_us'])->name('contact_us');

Route::get('/plans', [IndexController::class, 'plans'])->name('plans');



Route::get('/404', [IndexController::class, 'not_found'])->name('error_page');
Route::get('/thank-you', [IndexController::class, 'thank_you'])->name('thank_you');
Route::get('/cookie-policy', [IndexController::class, 'cookie_policy'])->name('cookie-policy');
Route::post('/contact-save', [IndexController::class, 'contact_save'])->name('contact.create');
Route::post('/comment-save', [IndexController::class, 'comment_save'])->name('comment.create');

Route::get('/search', [IndexController::class, 'search'])->name('search');
// Home END


Route::get('/account/onlineenrollment', [AccountController::class, 'online_enrollment'])->name('account.new.enrollment.page');

Route::any('/create-account/{param}', [AccountController::class, 'create_account'])->name('account.create');

//----------------------------- Payment PayU ----------------------------------------------------//

Route::any('/create_payumoney/{order_id}', [AccountController::class, 'create_payumoney'])->name('create.payumoney');
Route::any('/payment-success', [AccountController::class, 'payment_success'])->name('payumoney.success');
Route::any('/payment-cancel', [AccountController::class, 'payment_cancel'])->name('payumoney.fail');

Route::any('/webhook_pum_success', [AccountController::class, 'webhook_pum_success']);
Route::any('/webhook_pum_fail', [AccountController::class, 'webhook_pum_fail']);


Route::any('/create_payumoney_installment/{order_id}', [PayumoneyController::class, 'create_payumoney_installment'])->name('create.payumoney.installment');
Route::any('/payment-success-installment', [PayumoneyController::class, 'payment_success_installment'])->name('payumoney.success.installment');
Route::any('/payment-cancel-installment', [PayumoneyController::class, 'payment_cancel_installment'])->name('payumoney.fail.installment');


//----------------------------- Payment PayU ----------------------------------------------------//


Route::get('/linkaccount', [AccountController::class, 'link_account'])->name('link-account');


Route::middleware('auth.frontend')->group(function () {

    Route::get('/edituserprofile', [AccountController::class, 'edit_user_profile'])->name('edit-user-profile');

    Route::post('/customer-account-update-profile', [AccountController::class, 'account_update_profile'])->name('account.customer.update.profile');

    Route::get('/reset-passoword', [AccountController::class, 'reset_password'])->name('customer.reset_password');
    Route::post('/customer-password-update', [AccountController::class, 'reset_password_update'])->name('customer.password.update');

    Route::get('/cancel-ach-si', [AccountController::class, 'cancel_ach_si'])->name('customer.cancel-ach-si');
    Route::get('/get-si-account-nos', [AccountController::class, 'get_si_account_nos'])->name('customer.get-si-account-nos');
    Route::get('/myAccounts', [AccountController::class, 'my_accounts'])->name('customer.myaccounts');

    Route::get('/oldschemeclosure', [IndexController::class, 'old_scheme_closure'])->name('old-scheme-closure');

    Route::get('/pay-installments', [AccountController::class, 'pay_installments'])->name('pay-installments');
    Route::get('/pay-installment/{id}', [AccountController::class, 'pay_installment'])->name('pay-installment-details');

    Route::post('/installments', [AccountController::class, 'installments'])->name('installments.payment');

    Route::get('/account/new-plan-purchase', [AccountController::class, 'new_plan_purchase'])->name('account.new.plan.page');
    
});

Route::post('/login', [AccountController::class, 'customer_login'])->name('customer.login');

Route::any('/forgot-password/{param}', [AccountController::class, 'forgot_password'])->name('customer.forgot');

Route::get('/logout', [AccountController::class, 'customer_logout'])->name('customer.logout');

//----------------------------- cron job ------------------------

Route::get('/cron_due_msg', [SmsController::class, 'due_msg']);
Route::get('/cron_incomplete_registration_msg', [SmsController::class, 'incomplete_registration_msg']);

//----------------------------- cron job ------------------------


// Route::get('/esign', [EsignAadharController::class, 'esign_nsdl']);
// Route::get('/esign-plan1', [AccountController::class, 'dummy_esign']);
// Route::get('/esign-plan2', [AccountController::class, 'dummy_esign2']);


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

Route::any('/get-privious-page', function () {
    $step = Session()->get('step');
    if($step == 12){
        $step = 8;
    } else {
        $step = $step - 1;
    }
    
    Session()->put('step', $step);
})->name('get-privious-page');

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
    Session()->put('step', 6);
})->name('update-session');


// Route::get('/custom-session', function () {
//     Session()->put('step', 8);
//     // Session()->put('payment', 1);
//     // session()->put('temp_user_id', 4);
// });


Route::get('/resubmit-aadhar-otp', function () {
    Session()->put('step', 3);
})->name('resubmit-aadhar-otp');

Route::get('/redirect-login', function () {
    session()->forget('step');
    session()->forget('temp_user_id');

    $phone = request()->input('phone');

    // Perform auto-login if phone is provided
    if ($phone) {
        // Find the user by phone number
        $user = User::where('phone', $phone)->first();

        // Log in the user if found
        if ($user) {
            Auth::login($user);

            session()->forget(['step', 'otp_timestamp', 'phone', 'temp_user_id', 'otp', 'aadhar_no', 'payment']);

            Session()->put('user_id', auth()->user()->id);

            // Redirect to desired route after login
            return true;
        }
    }

    // Redirect to login page if phone is not provided or user not found
    return false;

})->name('redirect-login');

// Route::get('/session-setup', function () {
//     $email = "khanfaisal.makent@gmail.com";
//     $installment = "1st"; 
//     $amount = "5000";
//     $email_templet = (new SmsController)->email_installment_payment_successful($email, $installment, $amount);
// });

// Route::get('/template-design', [IndexController::class, 'pdf'])->name('pdf');

// Route::get('/testing-codeing', [AccountController::class, 'testing'])->name('testing');

Route::get('/custom-ksf-p', [IndexController::class, 'ip_get_per']);