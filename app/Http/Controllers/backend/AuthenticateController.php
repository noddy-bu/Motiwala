<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Carbon\Carbon;
use App\Http\Controllers\Common\SmsController;

class AuthenticateController extends Controller
{
    public function index(){
        return view('backend.auth.login');
    }

    public function login(request $request)
    {
        $validator = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
            

        $authenticated = Auth::guard('web')->attempt($request->only(['email', 'password']));
        if($authenticated)
        {
            // Check if the authenticated user's status is 1
            if (auth()->user()->status == 1) {
                return redirect()->route('backend.dashboard');
            } else {
                // Log the user out if their status is not 1
                Auth::guard('web')->logout();
                return redirect()->back()->withErrors(['invalid_credential' => 'Your account is inactive.']);
            }
        }
        else
        {
            return redirect()->back()->withErrors(['invalid_credential' => 'Credential is invalid!']);
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        Session()->flush();
        return redirect()->route('backend.login');
    }    

    
    // ------------------------------------------------------
    // STEP A: Send OTP to a given phone number
    // ------------------------------------------------------
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits_between:10,15', // adjust rules as per your country‐code format
        ]);

        // Normalize phone number if needed (e.g., ensure no leading +, etc.)
        $phone = preg_replace('/\D+/', '', $request->phone);

        // Find the user by phone (assuming there is a 'phone' column in users table)
        $user = User::where('phone', $phone)->first();
        if (! $user) {
            return redirect()
                ->back()
                ->withErrors(['phone' => 'No account found for this phone number.']);
        }
        
        // If otp_sent_time exists, enforce 2-minute wait
        if ($user->otp_sent_time) {
            $lastSent    = Carbon::parse($user->otp_sent_time);
            $nextAllowed = $lastSent->copy()->addMinutes(2);

            if (Carbon::now()->lessThan($nextAllowed)) {
                $secondsLeft = Carbon::now()->diffInSeconds($nextAllowed);
                return redirect()
                    ->back()
                    ->withErrors([
                        'phone' => "Please wait {$secondsLeft} second(s) before requesting a new OTP.",
                    ])
                    ->withInput();
            }
        }

        // Generate a random 6‐digit OTP
        $otp = random_int(100000, 999999);

        // Save OTP and timestamp to the user
        $user->otp_code = $otp;
        $user->otp_sent_time = Carbon::now();
        $user->save();

        // Send SMS via your SmsController (you already have it)
        $sms = new SmsController();
        $sms->smsgatewayhub_registration_otp($phone, $otp);

        // Store the phone in session so we know which user is verifying
        Session::put('otp_phone', $phone);

        // Redirect to OTP‐verify page
        return redirect()->route('backend.login.phone.verify.form')
                         ->with('success', 'OTP has been sent to your phone.');
    }

    // ------------------------------------------------------
    // STEP B: Show the “Enter OTP” form
    // ------------------------------------------------------
    public function showVerifyOtpForm()
    {
        if (! Session::has('otp_phone')) {
            return redirect()->route('backend.login')
                            ->withErrors(['phone' => 'Please enter your phone number first.']);
        }

        // Get the user and their otp_sent_time
        $phone = Session::get('otp_phone');
        $user = User::where('phone', $phone)->first();

        // Default: no wait if otp_sent_time is null
        $secondsRemaining = 0;

        if ($user && $user->otp_sent_time) {
            $sentAt = Carbon::parse($user->otp_sent_time);
            $expiresAt = $sentAt->copy()->addMinutes(2);

            if (Carbon::now()->lessThan($expiresAt)) {
                $secondsRemaining = Carbon::now()->diffInSeconds($expiresAt);
            }
        }

        return view('backend.auth.verify-otp', [
            'secondsRemaining' => $secondsRemaining,
            'phone'            => $phone,
        ]);
    }


    // ------------------------------------------------------
    // STEP C: Verify the OTP and log the user in
    // ------------------------------------------------------
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $phone = Session::get('otp_phone');
        if (! $phone) {
            return redirect()->route('backend.login')
                            ->withErrors(['phone' => 'Session expired. Please try again.']);
        }

        $user = User::where('phone', $phone)->first();
        if (! $user) {
            return redirect()->route('backend.login')
                            ->withErrors(['phone' => 'No account found.']);
        }

        // 1) If otp_sent_time is null, no OTP was generated
        if (! $user->otp_sent_time) {
            return redirect()
                ->back()
                ->withErrors(['otp' => 'No OTP was sent. Please request a new one.']);
        }

        // 2) Compare OTP (loose so that int 123456 matches string "123456")
        if (! $user->otp_code || $user->otp_code != $request->otp) {
            return redirect()
                ->back()
                ->withErrors(['otp' => 'Invalid OTP.'])
                ->withInput();
        }

        // 3) Check expiration: otp_sent_time + 2 minutes >= now
        $sentAt    = Carbon::parse($user->otp_sent_time);
        $expiresAt = $sentAt->copy()->addMinutes(2);
        if (Carbon::now()->greaterThan($expiresAt)) {
            return redirect()
                ->back()
                ->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        // 4) Check user status
        if ($user->status != 1) {
            return redirect()->route('backend.login')
                            ->withErrors(['invalid_credential' => 'Your account is inactive.']);
        }

        // 5) All good → log in, clear OTP fields
        Auth::guard('web')->login($user);

        $user->otp_code      = null;
        $user->otp_sent_time = null;
        $user->save();

        Session::forget('otp_phone');

        return redirect()->route('backend.dashboard');
    }


    // ------------------------------------------------------
    // (Optional) STEP D: Resend OTP
    // ------------------------------------------------------
    public function resendOtp(Request $request)
    {
        // 1) Get phone from session
        $phone = Session::get('otp_phone');
        if (! $phone) {
            return redirect()
                ->route('backend.login')
                ->withErrors(['phone' => 'Session expired. Please start over.']);
        }

        // 2) Find the user
        $user = User::where('phone', $phone)->first();
        if (! $user) {
            return redirect()
                ->route('backend.login')
                ->withErrors(['phone' => 'No account found.']);
        }

        // 3) Check the same 2-minute rule
        if ($user->otp_sent_time) {
            $lastSent    = Carbon::parse($user->otp_sent_time);
            $nextAllowed = $lastSent->copy()->addMinutes(2);

            if (Carbon::now()->lessThan($nextAllowed)) {
                $secondsLeft = Carbon::now()->diffInSeconds($nextAllowed);
                return redirect()
                    ->back()
                    ->withErrors([
                        'otp' => "Please wait {$secondsLeft} second(s) before resending OTP.",
                    ]);
            }
        }

        // 4) Generate a new OTP and update timestamp
        $otp = random_int(100000, 999999);
        $user->otp_code      = $otp;
        $user->otp_sent_time = Carbon::now();
        $user->save();

        // 5) Send SMS
        $sms = new SmsController();
        $sms->smsgatewayhub_registration_otp($phone, $otp);

        return redirect()
            ->back()
            ->with('success', 'A new OTP has been sent to your phone.');
    }

}
