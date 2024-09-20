<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\User;
use Illuminate\Support\Facades\Mail;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Common\AadharController;

use App\Http\Controllers\Common\EsignAadharController;
use App\Http\Controllers\Common\SmsController;

use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;



use Auth;

class AccountController extends Controller
{



    /*------------------------------ Login Logout Function -------------------------------------------------*/

    public function customer_login(Request $request)
    {

        // Validating the request data
        $validator = Validator::make($request->all(), [
            'phone' => 'required|regex:/^\d{10}$/',
            'password' => 'required',
        ]);

        // Checking if validation fails
        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            return response()->json([
                'status' => 'error',
                'message' => $errors
            ], 200);
        }



        $authenticated = Auth::guard('web')->attempt($request->only(['phone', 'password']));
        if ($authenticated) {
            session()->forget(['step', 'otp_timestamp', 'phone', 'temp_user_id', 'otp', 'aadhar_no', 'payment']);


            // $user = DB::table('users')->where('phone', $request->input('phone'))->first();

            $user = DB::table('users')
                ->join('userdetails', 'userdetails.user_id', '=', 'users.id')
                ->where('users.phone', $request->input('phone'))
                ->select('users.*', 'userdetails.esign')
                ->first();

            if ($user) {
                if (is_null($user->status)) {
                    Session::flush();

                    if($user->step == 8){
                        
                        $step = !is_null($user->esign) ? 12 : 8;

                    } else {
                        $step = $user->step + 1;
                    }
            
                    Session::put('temp_user_id', $user->id);
                    Session::put('step', $step);
            
                    return response()->json([
                        'status' => 'incomplete',
                        'message' => 'Please Fill ALL Forms'
                    ], 200);
                }
            }
    
            Session::put('user_id', auth()->user()->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully logged in'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 200);
        }
    }

    public function customer_logout()
    {
        Auth::guard('web')->logout();
        Session()->flush();
        return redirect()->route('index');
    }

/*------------------------------ Login Logout Function -------------------------------------------------*/


/*------------------------------ other inner Function -------------------------------------------------*/


    public function link_account()
    {
        return view('frontend.pages.admin.link_account.index');
    }

    public function cancel_ach_si()
    {
        return view('frontend.pages.admin.cancel_ach_si.index');
    }

    public function get_si_account_nos()
    {
        return view('frontend.pages.admin.get_si_account_nos.index');
    }

    public function my_accounts()
    {
        return view('frontend.pages.admin.my_accounts.index');
    }

    public function new_plan_purchase()
    {
        return view('frontend.pages.admin.new_plan_purchase.index');
    }

    public function pay_installments(){

        $info = DB::table('redemptions')
        ->select('redemptions.id','redemptions.plan_id','redemptions.created_at','redemptions.maturity_date_start','redemptions.status','plans.name as plan_name')
        ->leftJoin('plans', 'redemptions.plan_id', '=', 'plans.id')
        ->where('redemptions.user_id', Session::get('user_id'))
        ->orderBy('redemptions.id', 'desc')
        ->get();

        return view('frontend.pages.admin.pay_installments_list.index', compact('info'));
    }

    public function pay_installment($id)
    {

        $info = DB::table('users')
            ->select([
                'redemptions.id',
                'users.created_at',
                'redemptions.plan_id',
                'users.installment_amount',
                'plans.name',
                'plans.installment_period',
                'redemptions.maturity_date_start',
                'redemptions.maturity_date_end',
                'redemptions.plan_id as close_planid',

                'redemptions.status',
                'redemptions.closing_remark',
                'redemptions.closing_date',
                'redemptions.created_at as redemptions_created_at',
                'redemptions.id as redemptions_id',
            ])
            ->join('plans', 'users.plan_id', '=', 'plans.id')
            ->join('redemptions', 'users.id', '=', 'redemptions.user_id')
            // ->where('redemptions.status', 1)
            ->where('users.id', Session::get('user_id'))
            ->where('redemptions.id', $id)
            // ->orderBy('redemptions.id', 'desc')
            ->get()->first();

        $transactions = DB::table('transactions')->where('user_id', Session::get('user_id'))->get();

        $redemption_items = DB::table('redemption_items')->where('redemption_id', $info->id)->get();

        return view('frontend.pages.admin.pay_installment.index', compact('info', 'transactions', 'redemption_items'));
    }

    public function installments(Request $request)
    {

        $redemption_items_id = $request->input('id');

        $redemption_items = DB::table('redemption_items')->where('id', $redemption_items_id)->get()->first();

        if ($redemption_items->status == "pending") {

            $redemption = DB::table('redemptions')->where('id', $redemption_items->redemption_id)->where('status', 1)->get()->first();


            $user = DB::table('users')->where('id', $redemption->user_id)->first(['first_name', 'last_name', 'fullname',  'fullname', 'email', 'phone']);

            $ip = ip_info();
            $ip_data = json_decode($ip, true); 

            //insert in order
            $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
            $orderId = DB::table('temp_transactions')->insertGetId([
                'name'             => $user->fullname,
                'email'            => $user->email,
                'phone'            => $user->phone,
                'grand_total'      => $redemption_items->installment_amount,
                'payment_method'   => 'payu',
                'payment_status'   => 'created',
                'payment_id'       => $txnid,
                'ip_data'          => $ip,
                'location'         => $ip_data['city'],
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s')
            ]);

            if ($orderId) {

                $rsp_msg['response'] = 'success';
                $rsp_msg['message']  = "Please Proceed";
                $rsp_msg['orderId']  = $orderId;

                return $rsp_msg;

                return response()->json([
                    'status' => true,
                    'orderId' => $orderId,
                    'notification' => 'Please Proceed For ' . $redemption_items->installment_no . ' Installment'
                ]);
            } else {

                $rsp_msg['response'] = 'error';
                $rsp_msg['message']  = "Something Went Wrong!, Please try again";

                return $rsp_msg;
            }
        } else {

            return response()->json([
                'status' => false,
                'notification' => 'Somthing went wrong'
            ]);
        }
    }

    public function edit_user_profile()
    {

        $user = DB::table('users')->where('id', Session::get('user_id'))
            ->get(['plan_id', 'installment_amount', 'first_name', 'last_name', 'fullname', 'email', 'phone'])->first();

        $user_detail = DB::table('userdetails')->where('user_id', Session::get('user_id'))
            ->get(['nominee_name', 'nominee_phone', 'nominee_dob', 'nominee_address', 'nominee_relation', 'flat_no', 'street', 'locality', 'state', 'city', 'pincode', 'address', 'dob', 'marital_status', 'spouse_name', 'spouse_dob', 'marriage_date'])->first();

        return view('frontend.pages.admin.manage_user_profile.index', compact('user', 'user_detail'));
    }

    public function account_update_profile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // 'flat_no' => 'required|min:1',
            // 'street' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            // 'locality' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            // 'state' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            // 'city' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            // 'pincode' => 'required|regex:/^[\d\s-]+$/|min:3',
            'address' => ['required', 'string', 'regex:/^[A-Za-z0-9\s,.\/\'&]+$/i', 'min:3', 'max:350'],
            'dob' => ['required', 'date', function ($attribute, $value, $fail) {
                $dob = Carbon::parse($value);
                $age = $dob->diffInYears(Carbon::now());

                if ($age < 18) {
                    $fail('You must be at least 18 years old.');
                }
            }],
            'nominee_dob' => ['required', 'date', function ($attribute, $value, $fail) {
                $dob = Carbon::parse($value);
                $age = $dob->diffInYears(Carbon::now());

                if ($age < 18) {
                    $fail('Nominee must be at least 18 years old.');
                }
            }],
            'nominee_name' => ['nullable', 'string', 'regex:/^[A-Za-z\s,.\'\/&]+$/', 'min:3'],
            'nominee_phone' => 'nullable|regex:/^\d{10}$/',
            'nominee_address' => ['nullable', 'string', 'regex:/^[A-Za-z0-9\s,.\/\'&]+$/i', 'min:3'],
            'nominee_relation' => ['nullable', 'string', 'regex:/^[A-Za-z\s,.\'\/&]+$/', 'min:3'],

            'spouse_name' => ['nullable', 'string', 'regex:/^[A-Za-z\s,.\/\'&]+$/i', 'min:3'],
            'marital_status' => 'required',
        ]);

        if ($validator->fails()) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = $validator->errors()->all();

            return $rsp_msg;
        }


        DB::table('users')->where('id', $request->input('id'))->update([
            'email' => $request->input('email'),
        ]);

        DB::table('userdetails')->where('user_id', $request->input('id'))->update([
            // 'flat_no' => $request->input('flat_no'),
            // 'street' => $request->input('street'),
            // 'locality' => $request->input('locality'),
            // 'state' => $request->input('state'),
            // 'city' => $request->input('city'),
            // 'pincode' => $request->input('pincode'),
            'address' => $request->input('address'),
            'dob' => $request->input('dob'),

            'nominee_name' => $request->input('nominee_name'),
            'nominee_phone' => $request->input('nominee_phone'),
            'nominee_dob' => $request->input('nominee_dob'),
            'nominee_address' => $request->input('nominee_address'),
            'nominee_relation' => $request->input('nominee_relation'),

            'marital_status' => $request->input('marital_status'),

            'spouse_name' => $request->input('spouse_name'),
            'spouse_dob' => $request->input('spouse_dob'),
            'marriage_date' => $request->input('marriage_date'),
        ]);

        $rsp_msg['response'] = 'success';
        $rsp_msg['message']  = "Profile Detail Update successfully.";

        return $rsp_msg;
    }

    public function reset_password()
    {
        $user = DB::table('users')->where('id', Session::get('user_id'))->get(['phone', 'id'])->first();

        return view('frontend.pages.admin.manage_user_profile.reset_password', compact('user'));
    }

    public function reset_password_update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|min:8|same:password_conform',
            'password_conform' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = $validator->errors()->all();

            return $rsp_msg;
        }


        $old_password = DB::table('users')->where('id', $request->input('id'))->value('password');

        $rq_old_password = $request->input('old_password');



        if (password_verify($rq_old_password, $old_password)) {

            DB::table('users')->where('id', $request->input('id'))->update([
                'password' => bcrypt($request->input('password')),
            ]);

            $rsp_msg['response'] = 'success';
            $rsp_msg['message']  = "Password Update successfully.";
        } else {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = "Old Password Dosent Match";
        }

        return $rsp_msg;
    }




/*------------------------------ other inner Function -------------------------------------------------*/


/*------------------------------ Forgot password Function --------------------------------------------*/

    public function forgot_password($param, Request $request)
    {


        if ($param == "verify-number-send-otp") {

            $validator = Validator::make($request->all(), [
                'phone' => 'required|regex:/^\d{10}$/',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();

                return response()->json([
                    'status' => 'error',
                    'message' => $errors
                ], 200);
            }

            $user = DB::table('users')->where('phone', $request->phone)
                    ->where(function ($query) {
                        $query->where('status', '1')
                            ->orWhereNotNull('password');
                    })
                    ->select('id')
                    ->first();

            if ($user) {

                Session()->flush();

                $otp = mt_rand(100000, 999999);
                $timestamp = Carbon::now();
                Session::put('otp', $otp);
                Session::put('otp_timestamp', $timestamp);
                Session::put('user_forget_id', $user->id);

                $phone = $request->phone;

                $sms = (new SmsController)->smsgatewayhub_reset_pwd_otp($phone, $otp);

                return response()->json([
                    'status' => 'success',
                    'message' => 'OTP has been Share on this No : ' . $request->phone . ''
                ], 200);
            } else {

                return response()->json([
                    'status' => 'error',
                    'message' => 'User Not exist Please Provide Valid Number',
                ], 200);
            }
        } elseif ($param == "verify-forgot-otp") {

            $validator = Validator::make($request->all(), [
                'otp' => 'required|digits:6',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();

                return response()->json([
                    'status' => 'error',
                    'message' => $errors
                ], 200);
            }

            $otp = Session::get('otp');
            $timestamp = Session::get('otp_timestamp');

            // Check if OTP expired (2 minutes)
            if (Carbon::parse($timestamp)->diffInMinutes(Carbon::now()) > 2) {

                return response()->json([
                    'status' => 'error',
                    'message' => 'OTP has expired. Please request a new one',
                ], 200);
            }

            if ($request->otp == $otp) {

                return response()->json([
                    'status' => 'success',
                    'message' => 'OTP has been Verify successfully'
                ], 200);
            } else {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid OTP',
                ], 200);
            }
        } elseif ($param == "reset-password") {


            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8|same:password_conform',
                'password_conform' => 'required|min:8',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();

                return response()->json([
                    'status' => 'error',
                    'message' => $errors
                ], 200);
            }

            $user = DB::table('users')->where('id', Session::get('user_forget_id'))
                    ->where(function ($query) {
                        $query->where('status', '1')
                            ->orWhereNotNull('password');
                    })
                    ->get(['id'])->first();

            if ($user) {
                DB::table('users')->where('id', Session::get('user_forget_id'))->update([
                    'password' => bcrypt($request->input('password')),
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'New Password Update Successfully',
                ], 200);
            } else {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Something Went Wrong'
                ], 200);
            }
        } else {

            return response()->json([
                'status' => 'error',
                'message' => 'Something Went Wrong or Invalid parameter: ' . $param . ''
            ], 200);
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Successfully forgot Password'
        ], 200);
    }


/*------------------------------ Forgot password Function -------------------------------------------*/



 /*--=================================  Registration user ==================================================---*/

    public function online_enrollment()
    {
        return view('frontend.pages.online_enrollment.index');
    }

    public function create_account($param, Request $request)
    {

        if ($param == "phone-verification") {

            $rsp_msg = $this->phone_verification($request);
        } elseif ($param == "verify-otp") {

            $rsp_msg = $this->verify_otp($request);
        } elseif ($param == "resend-otp") {

            $rsp_msg = $this->resendOtp($request);
        } elseif ($param == "customer-info") {

            $rsp_msg = $this->create_customer_detail($request);
        } elseif ($param == "plan-info") {

            $rsp_msg = $this->update_plan_detail($request);
        } elseif ($param == "ekyc-varification") {

            $rsp_msg = $this->accept_ekyc_term($request);
        } elseif ($param == "aadhar-verify-request-otp") {

            $rsp_msg = $this->aadhar_verify_request_otp($request);

        } elseif ($param == "resend-aadhar-otp") {

            $rsp_msg = $this->resendAadharOtp($request);

        } elseif ($param == "aadhar-otp-verify") {

            $rsp_msg = $this->aadhar_otp_verify($request);
        } elseif ($param == "esign-varification") {

            $rsp_msg = $this->accept_esign_term($request);
        } elseif ($param == "esign-aadhar-verify-request-otp") {

            $rsp_msg = $this->esign_aadhar_verify_request_otp($request);
        } elseif ($param == "esign-verify") {

            $rsp_msg = $this->esign_verify();

            if ($rsp_msg = "true") {

                $userId = Session::get('temp_user_id') ?? auth()->user()->id;

                $userdetails = DB::table('userdetails')->where('user_id', $userId)
                ->value('esign');
    
                if(is_null($userdetails)){

                    Session::put('step', 8);

                    if(Session::has('temp_user_id')){
                        return redirect()->route('account.new.enrollment.page');
                    } else {
                        return redirect()->route('account.new.plan.page');
                    }
                    
                }

                Session::put('step', 12);

            } else {
                Session::put('step', 8);
            }

            // return redirect()->route('account.new.enrollment.page');

            if(Session::has('temp_user_id')){
                return redirect()->route('account.new.enrollment.page');
            } else {
                return redirect()->route('account.new.plan.page');
            }

        } elseif ($param == "payment-gateway") {

            $rsp_msg = $this->payment_gateway($request);
        } else {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message'] = "Invalid parameter: $param";
        }


        return response()->json(array('response_message' => $rsp_msg));
    }



    /*-------------------------------- function ---------------------------------------------*/


    public function phone_verification($request)
    {

        $validator = Validator::make($request->all(), [
            'accept_term' => 'required',
            'phone' => 'required|regex:/^\d{10}$/',
        ]);

        if ($validator->fails()) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = $validator->errors()->all();

            return $rsp_msg;
        }

        // $user = DB::table('users')->where('phone', $request->phone)->where('status', '1')->get(['id'])->first();
        $user = DB::table('users')
            ->join('redemptions', 'users.id', '=', 'redemptions.user_id')
            ->where('users.phone', $request->phone)
            // ->where('users.status', '1')
            ->where('redemptions.status', '1')
            ->select('users.id')
            ->first();

        if ($user) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = "this No : $request->phone Already registered";

            return $rsp_msg;
        }


        $otp = mt_rand(100000, 999999);
        $timestamp = Carbon::now();
        Session::put('otp', $otp);
        Session::put('otp_timestamp', $timestamp);
        Session::put('phone', $request->phone);

        //sms integration
        $sms = (new SmsController)->smsgatewayhub_registration_otp($request->phone, $otp);

        Session::put('step', 2);

        $rsp_msg['response'] = 'success';
        $rsp_msg['message']  = "OTP has been Share on this No : $request->phone ";

        return $rsp_msg;
    }


    public function verify_otp($request)
    {

        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = $validator->errors()->all();

            return $rsp_msg;
        }

        $otp = Session::get('otp');
        $timestamp = Session::get('otp_timestamp');

        // Check if OTP expired (2 minutes)
        if (Carbon::parse($timestamp)->diffInMinutes(Carbon::now()) > 2) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = "OTP has expired. Please request a new one";

            return $rsp_msg;
        }

        if ($request->otp == $otp) {

            $phone = Session::get('phone');

            // $user_data = DB::table('users')->where('phone', $phone)->first();

            $user_data = DB::table('users')
                ->join('userdetails', 'userdetails.user_id', '=', 'users.id')
                ->where('users.phone', $phone)
                ->select('users.*', 'userdetails.esign')
                ->first();

            if ($user_data) {
                if (is_null($user_data->status) && !is_null($user_data->step)) {
                    Session::flush();

                    if($user_data->step == 8){

                        $step = !is_null($user_data->esign) ? 12 : 8;
                        
                    } else {
                        $step = $user_data->step + 1;
                    }
            
                    Session::put('temp_user_id', $user_data->id);
                    Session::put('step', $step);

                    $rsp_msg['response'] = 'success';
                    $rsp_msg['message']  = "OTP has been Verified";

                    return $rsp_msg;
                }
            }


            $user = DB::table('users')->where('phone', $phone)->get(['id'])->first();

            if (empty($user)) {

                $userId = DB::table('users')->insertGetId([
                    'accept_term' => 1,
                    'phone' => $phone,
                    'role_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('userdetails')->insert([
                    'user_id' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                Session::put('temp_user_id', $userId);
            } else {
                Session::put('temp_user_id', $user->id);
            }

            Session::put('step', 3);

            $rsp_msg['response'] = 'success';
            $rsp_msg['message']  = "OTP has been Verified";
        } else {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = "Invalid OTP";
        }


        return $rsp_msg;
    }


    public function resendOtp($request)
    {
        $otp = mt_rand(100000, 999999);
        Session::put('otp', $otp);

        $timestamp = Carbon::now();
        Session::put('otp_timestamp', $timestamp);

        $phone = Session::get('phone');

        //sms integration  
        $sms = (new SmsController)->smsgatewayhub_registration_otp($phone, $otp);

        $rsp_msg['response'] = 'success';
        $rsp_msg['message']  = "OTP has been Resend no this No : $phone ";

        return $rsp_msg;
    }



    public function aadhar_verify_request_otp($request)
    {

        $validator = Validator::make($request->all(), [
            //'aadhar' => 'required|digits:12|same:aadhar_conform',
            'aadhar' => 'required|digits:12',
            // 'aadhar_conform' => 'required|digits:12',
        ]);

        if ($validator->fails()) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = $validator->errors()->all();

            return $rsp_msg;
        }

        $user_detail = DB::table('userdetails')->where('aadhar_number', $request->aadhar)->get(['user_id'])->first();

        if ($user_detail) {

            // $user = DB::table('users')->where('id', $user_detail->user_id)->where('status', '1')->get(['id'])->first();

            $user = DB::table('users')
                ->join('redemptions', 'users.id', '=', 'redemptions.user_id')
                ->where('users.id', $user_detail->user_id)
                // ->where('users.status', '1')
                ->where('redemptions.status', '1')
                ->select('users.id')
                ->first();
            

            if ($user) {
                $rsp_msg['response'] = 'error';
                $rsp_msg['message']  = "this No : $request->aadhar Already registered";

                return $rsp_msg;
            }
        }



        $requestOtp = (new AadharController)->requestOtpAadhar($request->aadhar);
        $requestOtp = json_decode($requestOtp);

        if ($requestOtp->success) {
            //do success stuff

            $rsp_msg['response'] = 'success';
            $rsp_msg['message']  = "OTP sent to linked Mobile number with " . $request->aadhar . " Aadhar number.";

            //set session of aadhar client ID
            session(['customer_aadhar_clientId' => $requestOtp->data->client_id]);

            session(['aadhar_no' => $request->aadhar]);

            Session::put('step', 4);
        } else {
            //do failure stuff
            if ($requestOtp->status_code == 429) {

                $rsp_msg['response'] = 'error';
                $rsp_msg['message']  = "Wait 60 seconds to generate OTP for same Aadhaar Number.";
            } else {

                $rsp_msg['response'] = 'error';
                $rsp_msg['message']  = "Invalid Aadhar number / No mobile number is linked with " . $request->aadhar . " Aadhar number!";
            }
        }

        return $rsp_msg;
    }


    public function resendAadharOtp($request)
    {

        $aadhar = Session::get('aadhar_no');

        $requestOtp = (new AadharController)->requestOtpAadhar($aadhar);
        $requestOtp = json_decode($requestOtp);

        if ($requestOtp->success) {
            //do success stuff

            $rsp_msg['response'] = 'success';
            $rsp_msg['message']  = "OTP Resend to linked Mobile number with " . $aadhar . " Aadhar number.";

            //set session of aadhar client ID
            session(['customer_aadhar_clientId' => $requestOtp->data->client_id]);

            session(['aadhar_no' => $aadhar]);

            Session::put('step', 4);
        } else {
            //do failure stuff
            if ($requestOtp->status_code == 429) {

                $rsp_msg['response'] = 'error';
                $rsp_msg['message']  = "Wait 60 seconds to generate OTP for same Aadhaar Number.";
            } else {

                $rsp_msg['response'] = 'error';
                $rsp_msg['message']  = "Invalid Aadhar number / No mobile number is linked with " . $request->aadhar . " Aadhar number!";
            }
        }

        return $rsp_msg;
    }

    public function aadhar_otp_verify($request)
    {

        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = $validator->errors()->all();

            return $rsp_msg;
        }

        $verify = (new AadharController)->validateOtpAadhar($request->otp, session('customer_aadhar_clientId'));
        $verify = json_decode($verify);


        if ($verify->success) {

            //update query here
            DB::table('userdetails')->where('user_id', Session::get('temp_user_id'))->update([
                'ekyc' => json_encode($verify),
                'aadhar_number' => Session::get('aadhar_no'),
            ]);

            // $ulp_id = DB::table('users')->where('id', Session::get('temp_user_id'))->value('ulp_id');

            // if(empty($ulp_id)){

            //     $random = Session::get('temp_user_id');
            //     $DateTime = time();

            //     $ulp_id = $random . '' . $DateTime;

            //     // Ensure the length of $ulp_id is exactly 12 digits
            //     if (strlen($ulp_id) < 12) {
            //         $padding_length = 12 - strlen($ulp_id);
            //         $ulp_id = str_pad($ulp_id, 12, '0', STR_PAD_LEFT); // Pad with leading zeros if necessary
            //     } elseif (strlen($ulp_id) > 12) {
            //         $ulp_id = substr($ulp_id, 0, 12); // Trim if longer than 12 digits
            //     }

            //     DB::table('users')->where('id', Session::get('temp_user_id'))->update([
            //         'ulp_id' => $ulp_id,
            //     ]);

            // }


            $profileImage = $verify->data->profile_image;
            $fullName = $verify->data->full_name;
            $address = $verify->data->address;
            $zip = $verify->data->zip;
            $dob = $verify->data->dob;
            $care_of = $verify->data->care_of;
            $mobile = $verify->data->mobile_hash;

            $customer_detail = [
                'profileImage' => $profileImage,
                'name' => $fullName,
                'address' => $address,
                'zip' => $zip,
                'dob' => $dob,
                'care_of' => $care_of,
                'mobile' => $mobile,
            ];

            Session::put('customer_detail', $customer_detail);

            Session::put('step', 5);

            $rsp_msg['response'] = 'success';
            $rsp_msg['message']  = "Aadhar Number verified successfully!";
        } else {

            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = "OTP verification failed!";
        }

        return $rsp_msg;
    }




    public function create_customer_detail($request)
    {

        $validator = Validator::make($request->all(), [
            // 'title' => 'required',
            // 'first_name' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            // 'last_name' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:1',
            'fullname' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            'email' => 'required|email',
            // 'flat_no' => 'required|min:1',
            // 'street' => 'required|string|regex:/^[A-Za-z0-9\s,.\'\/&]+$/|min:3',
            // 'locality' => 'required|string|regex:/^[A-Za-z0-9\s,.\'\/&]+$/|min:3',
            // 'state' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            // 'city' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            'address' => ['required', 'string', 'regex:/^[A-Za-z0-9\s,.\/\'&]+$/i', 'min:3', 'max:350'],
            // 'pincode' => 'required|regex:/^[\d\s-]+$/|min:6',
            'pan_number' => 'nullable|string|regex:/^[A-Za-z0-9\s,.\'\/&]+$/|min:10|max:10',

            'nominee_name' => ['nullable', 'string', 'regex:/^[A-Za-z\s,.\'\/&]+$/', 'min:3', 'max:250'],
            'nominee_phone' => 'nullable|regex:/^\d{10}$/',
            'nominee_address' => ['nullable', 'string', 'regex:/^[A-Za-z0-9\s,.\/\'&]+$/i', 'min:3', 'max:250'],
            'nominee_relation' => ['nullable', 'string', 'regex:/^[A-Za-z\s,.\'\/&]+$/', 'min:3', 'max:350'],

            'dob' => ['required', 'date', function ($attribute, $value, $fail) {
                $dob = Carbon::parse($value);
                $age = $dob->diffInYears(Carbon::now());

                if ($age < 18) {
                    $fail('You must be at least 18 years old.');
                }
            }],
        ]);

        if ($validator->fails()) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = $validator->errors()->all();

            return $rsp_msg;
        }

        // $users_email = DB::table('users')->where('email', $request->input('email'))->where('status', 1)->get();
        $users_email = DB::table('users')
            ->join('redemptions', 'users.id', '=', 'redemptions.user_id')
            ->where('users.email',$request->input('email'))
            // ->where('users.status', '1')
            ->where('redemptions.status', '1')
            ->select('users.id')
            ->first();

        if ($users_email) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = 'Email Already Exists';

            return $rsp_msg;
        }

        if ($request->has('residence_address_check')) {
            $address = $request->input('residence_nominee_address');
        } else {
            $address = $request->input('nominee_address');
        }

        if (Session::has('temp_user_id') && !empty(Session::get('temp_user_id'))) {

            $phone = DB::table('users')->where('id', Session::get('temp_user_id'))->value('phone');

            DB::table('users')->where('id', Session::get('temp_user_id'))->update([
                // 'salutation' => $request->input('title'),
                // 'first_name' => $request->input('first_name'),
                // 'last_name' => $request->input('last_name'),
                'fullname' => $request->input('fullname'),
                'email' => strtolower($request->input('email')),
                'password' => bcrypt($phone),
                'step' => 6,
            ]);

            DB::table('userdetails')->where('user_id', Session::get('temp_user_id'))->update([
                // 'flat_no' => $request->input('flat_no'),
                // 'street' => $request->input('street'),
                // 'locality' => $request->input('locality'),
                // 'state' => $request->input('state'),
                // 'city' => $request->input('city'),
                // 'pincode' => $request->input('pincode'),
                'dob' => $request->input('dob'),
                'pan_number' => strtoupper($request->input('pan_number')),
                'address' => $request->input('address'),

                'nominee_name' => $request->input('nominee_name'),
                'nominee_phone' => $request->input('nominee_phone'),
                'nominee_dob' => $request->input('nominee_dob'),
                'nominee_address' => $address,
                'nominee_relation' => $request->input('nominee_relation'),
            ]);

            
            $email = strtolower($request->input('email'));

            if (!$users_email) {
                $sms = (new SmsController)->smsgatewayhub_registration_successful($phone);

                $email_templet1 = (new SmsController)->email_registration_successful($phone, $email);

                $wati_registration_success = (new SmsController)->wati_registration_success($phone);
            }


            Session::put('step', 7);

            $rsp_msg['response'] = 'success';
            $rsp_msg['message']  = "Customer Detail Added successfully. Please Proceed";
        } else {

            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = "Something Went Wrong";
        }

        return $rsp_msg;
    }

    public function update_plan_detail($request)
    {

        $validator = Validator::make($request->all(), [
            'plan_id' => 'required',
            'installment_amount' => 'required|numeric',
            // 'nominee_name' => ['nullable', 'string','regex:/^[A-Za-z\s,.\'\/&]+$/', 'min:3', 'max:250'],
            // 'nominee_phone' => 'nullable|regex:/^\d{10}$/',
            // 'nominee_address' => ['nullable', 'string', 'regex:/^[A-Za-z0-9\s,.\/\'&]+$/i', 'min:3', 'max:250'],
            // 'nominee_relation' => ['nullable', 'string', 'regex:/^[A-Za-z\s,.\'\/&]+$/', 'min:3', 'max:250'],
        ]);

        if ($validator->fails()) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = $validator->errors()->all();

            return $rsp_msg;
        }

        $userId = Session::get('temp_user_id') ?? auth()->user()->id;

        $exist_plan = DB::table('users')
            ->join('redemptions', 'users.id', '=', 'redemptions.user_id')
            ->where('users.id', $userId)
            ->where('redemptions.plan_id',$request->input('plan_id'))
            ->where('redemptions.status', '1')
            ->select('users.id')
            ->first();

        if ($exist_plan) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = 'Plan Already Active';

            return $rsp_msg;
        }


        $plan_amount = DB::table('plans')->where('id', $request->input('plan_id'))->value('minimum_installment_amount');

        if ($plan_amount > $request->input('installment_amount')) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message'] = "Minimum Installment Amount: $plan_amount";

            return $rsp_msg;
        }

        if ($request->input('installment_amount') % 1000 !== 0) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message'] = "Only Multiple of this Amount: 1000 will Accepted";

            return $rsp_msg;
        }





        // if($request->has('residence_address_check')){
        //     $address = $request->input('residence_nominee_address');
        // } else {
        //     $address = $request->input('nominee_address');
        // }

        // if (Session::has('temp_user_id') && !empty(Session::get('temp_user_id'))) {

        if (!empty($userId)) {

            DB::table('users')->where('id', $userId)->update([
                'plan_id' => $request->input('plan_id'),
                'installment_amount' => $request->input('installment_amount'),
                'step' => 7,
            ]);

            // DB::table('userdetails')->where('user_id',Session::get('temp_user_id'))->update([
            //     'nominee_name' => $request->input('nominee_name'),
            //     'nominee_phone' => $request->input('nominee_phone'),
            //     'nominee_dob' => $request->input('nominee_dob'),
            //     'nominee_address' => $address,
            //     'nominee_relation' => $request->input('nominee_relation'),
            // ]);

            Session::put('step', 8);

            $rsp_msg['response'] = 'success';
            $rsp_msg['message']  = "Plan Detail Added successfully. Please Proceed";
        } else {

            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = "Something Went Wrong";
        }

        return $rsp_msg;
    }


    // public function accept_ekyc_term($request){

    //     $validator = Validator::make($request->all(), [
    //         'accept_term' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         $rsp_msg['response'] = 'error';
    //         $rsp_msg['message']  = $validator->errors()->all();

    //         return $rsp_msg; 
    //     }

    //     Session::put('step', 8);

    //     $rsp_msg['response'] = 'success';
    //     $rsp_msg['message']  = "Please Proceed for ekyc";

    //     return $rsp_msg; 

    // }






    // /*------------- Esign ------------------------------*/

    // public function accept_esign_term($request){

    //     $validator = Validator::make($request->all(), [
    //         'accept_term' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         $rsp_msg['response'] = 'error';
    //         $rsp_msg['message']  = $validator->errors()->all();

    //         return $rsp_msg; 
    //     }

    //     $user = DB::table('users')->where('id', Session::get('temp_user_id'))
    //             ->get(['first_name','last_name', 'email', 'phone'])
    //             ->first();


    //     $name =   $user->first_name.' '.$user->last_name;

    //     $esign = (new EsignAadharController)->esign_nsdl($name, $user->email, $user->phone);
    //     //$esign = json_decode($esign);

    //     if (!$esign) {
    //         // Handle the error case
    //         $rsp_msg['response'] = 'error';
    //         $rsp_msg['message'] = 'Failed to Verify, please try Again'; 

    //         return $rsp_msg;
    //     }

    //     if ($esign == "error Generating link") {
    //         // Handle the error case
    //         $rsp_msg['response'] = 'error';
    //         $rsp_msg['message'] = 'Failed to Generating Verify link, Please Try Again';

    //         return $rsp_msg;
    //     }

    //     if ($esign == "error Generating upload link") {
    //         // Handle the error case
    //         $rsp_msg['response'] = 'error';
    //         $rsp_msg['message'] = 'Failed to Generating Upload Term PDF link, Please Try Again';

    //         return $rsp_msg;
    //     }

    //     if ($esign == "error uploading pdf") {
    //         // Handle the error case
    //         $rsp_msg['response'] = 'error';
    //         $rsp_msg['message'] = 'Failed to Upload PDF, Please Try Again';

    //         return $rsp_msg;
    //     }

    //     Session::put('client_id', $esign->data->client_id);

    //     $rsp_msg['response'] = 'success';
    //     $rsp_msg['message']  = "Verified link generated successfully. Please proceed to E-sign";
    //     $rsp_msg['url']  = $esign->data->url;

    //     // Session::put('step', 9);

    //     // $rsp_msg['response'] = 'success';
    //     // $rsp_msg['message']  = "Please Proceed for esign";

    //     return $rsp_msg; 

    // }


    public function esign_aadhar_verify_request_otp($request)
    {

        $validator = Validator::make($request->all(), [
            // 'name' => 'required|min:3',
            // 'email' => 'required|email',
            // 'phone' => 'required|regex:/^\d{10}$/',
            'accept_term' => 'required',
        ]);

        if ($validator->fails()) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = $validator->errors()->all();

            return $rsp_msg;
        }

        $userId = Session::get('temp_user_id') ?? auth()->user()->id;

        $user = DB::table('users')->where('id', $userId)
            ->get(['first_name', 'last_name', 'fullname', 'email', 'phone', 'plan_id'])
            ->first();

        // $name =   $user->first_name.' '.$user->last_name;
        $name =   $user->fullname;

        $esign = (new EsignAadharController)->esign_nsdl($name, $user->email, $user->phone, $user->plan_id);

        // $esign = (new EsignAadharController)->esign_nsdl($request->name, $request->email, $request->phone);
        //$esign = json_decode($esign);

        if (!$esign) {
            // Handle the error case
            $rsp_msg['response'] = 'error';
            $rsp_msg['message'] = 'Failed to Verify, please try Again';

            return $rsp_msg;
        }

        if ($esign == "error Generating link") {
            // Handle the error case
            $rsp_msg['response'] = 'error';
            $rsp_msg['message'] = 'Failed to Generating Verify link, Please Try Again';

            return $rsp_msg;
        }

        if ($esign == "error Generating upload link") {
            // Handle the error case
            $rsp_msg['response'] = 'error';
            $rsp_msg['message'] = 'Failed to Generating Upload Term PDF link, Please Try Again';

            return $rsp_msg;
        }

        if ($esign == "error uploading pdf") {
            // Handle the error case
            $rsp_msg['response'] = 'error';
            $rsp_msg['message'] = 'Failed to Upload PDF, Please Try Again';

            return $rsp_msg;
        }

        Session::put('client_id', $esign->data->client_id);

        $rsp_msg['response'] = 'success';
        $rsp_msg['message']  = "Verified link generated successfully. Please proceed to E-sign";
        $rsp_msg['url']  = $esign->data->url;


        return $rsp_msg;
    }


    public function esign_verify()
    {

        $client_id = Session::get('client_id');

        $esign = (new EsignAadharController)->esign_check_status($client_id);
        $esign = json_decode($esign);

        if ($esign->success == true) {
            $download_pdf = (new EsignAadharController)->download_esign($client_id);

            DB::table('users')->where('id', Session::get('temp_user_id'))->update([
                'step' => 8,
            ]);

            $result = "true";
        } else {
            $result = "false";
        }

        return $result;
    }


    public function payment_gateway($request)
    {

        $userId = Session::get('temp_user_id') ?? auth()->user()->id;

        $user = DB::table('users')->where('id', $userId)->first(['first_name', 'last_name', 'fullname', 'email', 'phone', 'installment_amount']);

        $ip = ip_info();
        $ip_data = json_decode($ip, true); 

        //insert in order
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $orderId = DB::table('temp_transactions')->insertGetId([
            // 'name'             => $user->first_name . ' ' . $user->last_name,
            'name'             => $user->fullname,
            'email'            => $user->email,
            'phone'            => $user->phone,
            'grand_total'      => $user->installment_amount,
            'payment_method'   => 'payu',
            'payment_status'   => 'created',
            'payment_id'       => $txnid,
            'ip_data'          => $ip,
            'location'         => $ip_data['city'] ?? '-',
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s')
        ]);

        if ($orderId) {

            $rsp_msg['response'] = 'success';
            $rsp_msg['message']  = "Please Proceed";
            $rsp_msg['orderId']  = $orderId;

            return $rsp_msg;

            //return redirect()->route('create.payumoney', ['orderId' => $orderId]);

        } else {

            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = "Something Went Wrong!, Please try again";

            return $rsp_msg;
        }


        /* 
        $user_id = Session::get('temp_user_id');
        $random = mt_rand(100000, 999999);
    
        $account_number = $user_id . '' . $random;

        // Ensure the length of $ulp_id is exactly 12 digits
        if (strlen($account_number) < 12) {
            $padding_length = 12 - strlen($account_number);
            $account_number = str_pad($account_number, 12, '0', STR_PAD_LEFT); // Pad with leading zeros if necessary
        } elseif (strlen($account_number) > 12) {
            $account_number = substr($account_number, 0, 12); // Trim if longer than 12 digits
        }

        DB::table('users')->where('id', Session::get('temp_user_id'))->update([
            'account_number' => $account_number,
            'password' => bcrypt(Session::get('phone')),
            'status' => 1,
        ]);


        session()->forget(['otp_timestamp', 'phone', 'otp', 'aadhar_no']);

        Session::put('step', 13);
        Session::put('payment', 1);

        $rsp_msg['response'] = 'success';
        $rsp_msg['message']  = "Account created successfully!";

        return $rsp_msg;

        */
    }
    /*--=================================  Registration user ==================================================---*/

    /* ------------------------------- Payment gateway -----------------------------------------------------------*/

    const TEST_URL = 'https://test.payu.in';
    //const TEST_URL = 'https://sandboxsecure.payu.in';
    const PRODUCTION_URL = 'https://secure.payu.in';

    public function create_payumoney(request $request, $order_id)
    {
        if ($order_id) {
            $order = DB::table('temp_transactions')->where('id', $order_id)->where('payment_status', 'created')->first();
            if ($order) {
                $data = $request->all();
                $MERCHANT_KEY = env('PAYU_MERCHANT_KEY');
                $SALT = env('PAYU_SALT_KEY');

                $PAYU_BASE_URL = env('PAYU_TEST_MODE') ? self::TEST_URL : self::PRODUCTION_URL;
                $action = '';

                $posted = array();
                if (!empty($data)) {
                    foreach ($data as $key => $value) {
                        $posted[$key] = $value;
                    }
                }

                $formError = 0;

                $txnid = $order->payment_id;

                $hash = '';
                // Hash Sequence
                $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
                if (empty($posted['hash']) && sizeof($posted) > 0) {
                    if (
                        empty($posted['key'])
                        || empty($posted['txnid'])
                        || empty($posted['amount'])
                        || empty($posted['firstname'])
                        || empty($posted['email'])
                        || empty($posted['phone'])
                        || empty($posted['productinfo'])
                        || empty($posted['surl'])
                        || empty($posted['furl'])
                        || empty($posted['service_provider'])
                    ) {
                        $formError = 1;
                    } else {
                        $hashVarsSeq = explode('|', $hashSequence);
                        $hash_string = '';
                        foreach ($hashVarsSeq as $hash_var) {
                            $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
                            $hash_string .= '|';
                        }

                        $hash_string .= $SALT;


                        $hash = strtolower(hash('sha512', $hash_string));
                        $action = $PAYU_BASE_URL . '/_payment';
                    }
                } elseif (!empty($posted['hash'])) {
                    $hash = $posted['hash'];
                    $action = $PAYU_BASE_URL . '/_payment';
                }

                $userId = Session::get('temp_user_id') ?? auth()->user()->id;

                $updateOrder = DB::table('temp_transactions')->where('id', $order->id)->update([
                    'pum_hash' => $hash,
                    'temp_user_id' => $userId
                ]);

                return view('frontend.payumoney.pay', compact('hash', 'action', 'MERCHANT_KEY', 'formError', 'txnid', 'posted', 'SALT', 'order'));
            }
        }
    }


    public function payment_success(Request $request)
    {

        $input = $request->all();

        if (!$input) //redirect if no post
        {
            return redirect(url(''));
        }

        $status = $input["status"];
        $firstname = $input["firstname"];
        $amount = $input["amount"];
        $txnid = $input["txnid"];
        $posted_hash = $input["hash"];
        $key = $input["key"];
        $productinfo = $input["productinfo"];
        $email = $input["email"];
        $salt = config('payu.salt_key');

        // echo"<pre>";
        // var_dump($posted_hash);
        // echo"</pre>";


        // if (isset($input["additionalCharges"])) {
        //     $additionalCharges = $input["additionalCharges"];
        //     $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        // } else {
        //     $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        // }

        // $hash = hash("sha512", $retHashSeq);

        // echo"<pre>";
        // var_dump($hash);
        // echo"</pre>";

        // if ($hash != $posted_hash) { //1 != 1
        //     //order info
        //     $order = DB::table('temp_transactions')->where('payment_id', $txnid)->first();        
        //     return "Invalid Transaction. Please try again";

        // } else {

        $order = DB::table('temp_transactions')->where('payment_id', $txnid)->first();

        //avoid update if payment is paid
        if ($order->payment_status == 'paid') {
            return redirect(url(''));
        }

        /* ------------ success stuff -----------*/

        // $user_id = Session::get('temp_user_id');
        // $random = mt_rand(100000, 999999);

        // $account_number = $user_id . '' . $random;

        // // Ensure the length of $ulp_id is exactly 12 digits
        // if (strlen($account_number) < 12) {
        //     $padding_length = 12 - strlen($account_number);
        //     $account_number = str_pad($account_number, 12, '0', STR_PAD_LEFT); // Pad with leading zeros if necessary
        // } elseif (strlen($account_number) > 12) {
        //     $account_number = substr($account_number, 0, 12); // Trim if longer than 12 digits
        // }

        Session::put('step', 13);
        Session::put('payment', 1);
        Session::put('temp_user_id', $order->temp_user_id);

        // $phone = DB::table('users')->where('id', $order->temp_user_id)->value('phone');

        // $email = DB::table('users')->where('id', $order->temp_user_id)->value('email');

        $phone_email = DB::table('users')->where('id', $order->temp_user_id)->select('phone', 'email', 'fullname')->first();


        DB::table('users')->where('id', $order->temp_user_id)->update([
            // 'account_number' => $account_number,
            // 'password' => bcrypt($phone),
            'status' => 1,
        ]);

        $amount = $order->grand_total;

        //update order
        $transactions_id = DB::table('transactions')->insertGetId([
            'user_id' => Session::get('temp_user_id'),
            'payment_id' => $txnid,
            'payment_amount' => $order->grand_total,
            'payment_response' => json_encode($input),
            'payment_type' => 'payu',
            'payment_status' => 'paid',
            'ip_data' => $order->ip_data,
            'location' => $order->location,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);



        session()->forget(['otp_timestamp', 'phone', 'otp', 'aadhar_no', 'customer_detail', 'client_id', 'customer_aadhar_clientId']);


        Session::put('transactions_id', $transactions_id);

        /*------------ success stuff --------------*/


        session()->flash('toastr', [
            'type' => 'success',
            'message' => 'Account Created Successfully',
            'title' => 'Success'
        ]);

        // delete temp recored
        DB::table('temp_transactions')->where('payment_id', $txnid)->delete();

        $this->auto_add_transactions(Session::get('temp_user_id'), $amount, $transactions_id);

        //sms integration

        // $sms = (new SmsController)->smsgatewayhub_registration_successful($phone);

        // $email_templet1 = (new SmsController)->email_registration_successful($phone, $email);

        $installment = '1st';

        $sms = (new SmsController)->smsgatewayhub_installment_payment_successful($phone_email->phone, $installment, $amount);

        $email_templet = (new SmsController)->email_installment_payment_successful($phone_email->email, $installment, $amount);

        $wati_payment_success = (new SmsController)->wati_payment_success($phone_email->phone, $phone_email->fullname, $installment, $amount);

        return redirect()->route('account.new.enrollment.page');
        // }
    }


    public function auto_add_transactions($temp_user_id, $amount, $transactions_id)
    {
        // Retrieve the user's plan ID from the session
        $user_plan_Details = DB::table('users')->where('id', $temp_user_id)->value('plan_id');

        // Retrieve the plan details
        $plan_details = DB::table('plans')->where('id', $user_plan_Details)->first(['minimum_installment_amount', 'installment_period', 'receivable_percentage_on_time']);

        // Calculate the number of installments
        $installments = (int) $plan_details->installment_period;

        $auto_installments = $installments;

        $installments = $installments + 1;
        $maturity_date_start = date('Y-m-d H:i:s', strtotime("+$installments month"));
        $maturity_date_end = date('Y-m-d H:i:s', strtotime($maturity_date_start . ' +1 month'));


        // $amount = $plan_details->minimum_installment_amount;

        $esign = DB::table('userdetails')->where('user_id', $temp_user_id)->value('esign');

        $redemption_id = DB::table('redemptions')->insertGetId([
            'user_id' => $temp_user_id,
            'plan_id' => $user_plan_Details,
            'maturity_date_start' => $maturity_date_start,
            'maturity_date_end' => $maturity_date_end,
            // 'total_receivable_amount' => $amount + ($amount * 0.075),
            'status' => '1',
            'esign' => $esign,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('userdetails')->where('user_id', $temp_user_id)->update(['esign' => null]);

        $percentage = $plan_details->receivable_percentage_on_time;
        $additionalAmount = ($amount * $percentage) / 100;
        $totalAmount = $amount + $additionalAmount;


        DB::table('redemption_items')->insert([
            'redemption_id' => $redemption_id,
            'transaction_id' => $transactions_id,
            'installment_no' => 1,
            'due_date_start' => date('Y-m-d H:i:s'),
            'due_date_end' => date('Y-m-d H:i:s'),
            'installment_amount' => $amount,
            'receivable_amount' => $totalAmount,
            'receivable_gold' => gold_amount($totalAmount),
            'status' => 'paid',
            'receipt_date' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        for ($i = 1; $i <= $auto_installments - 1; $i++) {
            $due_date_start = date('Y-m-d H:i:s', strtotime("+$i month"));
            $due_date_end = date('Y-m-d H:i:s', strtotime("$due_date_start +7 days"));

            // Determine status based on installment number
            $status = ($i == 1) ? 'pending' : 'unpaid';

            // Insert transaction record
            DB::table('redemption_items')->insert([
                'redemption_id' => $redemption_id,
                'installment_no' => $i + 1,
                'due_date_start' => $due_date_start,
                'due_date_end' => $due_date_end,
                'installment_amount' => $amount,
                'status' => $status,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    //-------------- test controller -------------------------

    // public function testing()
    // {
    //     $this->auto_add_transactions(2, 2000);
    // }

    //-------------- test controller -------------------------

    public function payment_cancel(Request $request)
    {

        $data = $request->all();

        if (!$data) //redirect if no post
        {
            return redirect(url(''));
        }

        $validHash = true;
        $txnid = $data["txnid"];

        if (!$validHash) {
            echo "Invalid Transaction. Please try again";
        } else {
            //fail

            $user_exist = DB::table('temp_transactions as tt')
                ->select('tt.temp_user_id','us.id')
                ->leftJoin('users as us', 'tt.temp_user_id', '=', 'us.id') // Assuming you want to join on user_id
                ->where('tt.payment_id', $txnid)
                ->where('us.status', 1)
                ->first();
            
            if($user_exist){
                Auth::guard('web')->loginUsingId($user_exist->id);
                Session::put('user_id', $user_exist->id);
                Session::put('step', 12);
            }

            //update order
            $updateOrder = DB::table('temp_transactions')
                ->where('payment_id', $txnid)
                ->update([
                    'payment_status' => 'unpaid',
                    'payment_response' => json_encode($data),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
        }

        $temp_user = DB::table('temp_transactions')->where('payment_id', $txnid)->first(['temp_user_id']);

        //fresh order info
        $errorMessage = $data['error_Message'];

        $temp_user_id = $temp_user ? $temp_user->temp_user_id : 0;

        if($user_exist){
            return view('frontend.payumoney.fail_installment', compact('errorMessage','data','temp_user_id'));
        } else {
            return view('frontend.payumoney.fail', compact('errorMessage', 'data', 'temp_user_id'));
        }
        
    }



    public function webhook_pum_success(Request $request)
    {

        $fileContent = [
            'headers' => $request->headers->all(),
            'postData' => $request->all(),
        ];

        $filePath = time() . '-success.txt';

        // Create the file
        Storage::disk('public')->put('webhook/' . $filePath, json_encode($fileContent));

        // Read the JSON data from the file
        //$jsonData = file_get_contents(public_path('storage/webhook/1720264141-success.txt'));

        $jsonData = file_get_contents($filePath); //file_get_contents(public_path('1690456548-success.txt'));

        // Decode the JSON data into an array
        $fileContent = json_decode($jsonData, true);
        $postData = $fileContent['postData'];
        $txnid = $postData['merchantTransactionId'];
        $udf1 = $postData['udf1'];

        //--success------
        //order info
        $order = DB::table('temp_transactions')->where('payment_id', $txnid)->first();

        //avoid update if payment is paid
        if ($order->payment_status != 'paid') {

            if ($udf1 != "installment") {

                // $phone = DB::table('users')->where('id', $order->temp_user_id)->value('phone');

                // $email = DB::table('users')->where('id', $order->temp_user_id)->value('email');

                $phone_email = DB::table('users')->where('id', $order->temp_user_id)->select('phone', 'email', 'fullname')->first();


                // DB::table('users')->where('id', $order->temp_user_id)->update([
                //     // 'account_number' => $account_number,
                //     'password' => bcrypt($phone),
                //     'status' => 1,
                // ]);

                $amount = $order->grand_total;

                //update order
                $transactions_id = DB::table('transactions')->insertGetId([
                    'user_id' => $order->temp_user_id,
                    'payment_id' => $txnid,
                    'payment_amount' => $order->grand_total,
                    'payment_response' => json_encode($fileContent),
                    'payment_type' => 'payu',
                    'payment_status' => 'paid',
                    'ip_data'        => $order->ip_data,
                    'location'       => $order->location,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                // delete temp recored
                DB::table('temp_transactions')->where('payment_id', $txnid)->delete();

                $this->auto_add_transactions(Session::get('temp_user_id'), $amount, $transactions_id);

                //sms integration

                // $sms = (new SmsController)->smsgatewayhub_registration_successful($phone);

                // $email_templet1 = (new SmsController)->email_registration_successful($phone, $email);

                $installment = '1st';

                $sms = (new SmsController)->smsgatewayhub_installment_payment_successful($phone_email->phone, $installment, $amount);

                $email_templet = (new SmsController)->email_installment_payment_successful($phone_email->email, $installment, $amount);

                $wati_payment_success = (new SmsController)->wati_payment_success($phone_email->phone, $phone_email->fullname, $installment, $amount);

                /*------------ success stuff --------------*/

                Storage::disk('public')->put('webhook/success/' . $txnid . '-success.txt', $txnid);
            } else {

                $amount = $order->grand_total;

                //update order
                $transactions_id = DB::table('transactions')->insertGetId([
                    'user_id' => $order->temp_user_id,
                    'payment_id' => $txnid,
                    'payment_amount' => $order->grand_total,
                    'payment_response' => json_encode($fileContent),
                    'payment_type' => 'payu',
                    'payment_status' => 'paid',
                    'ip_data'        => $order->ip_data,
                    'location'       => $order->location,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                $redemption = DB::table('redemptions')
                    ->where('user_id', $order->temp_user_id)
                    ->where('status', 1)
                    ->first(['id', 'plan_id']);

                if ($redemption) {
                    // Fetch the redemption item
                    $redemption_items = DB::table('redemption_items')
                        ->where('redemption_id', $redemption->id)
                        ->where('status', 'pending')
                        ->first(['id', 'due_date_start', 'due_date_end', 'installment_no']);

                    if ($redemption_items) {
                        // $currentDate = Carbon::now()->format('Y-m-d');

                        // // Check if the current date lies between due_date_start and due_date_end
                        // if (Carbon::parse($currentDate)->between(Carbon::parse($redemption_items->due_date_start), Carbon::parse($redemption_items->due_date_end))) {

                        //     $plan_receivable_percentage = DB::table('plans')->where('id', $redemption->plan_id)->value('receivable_percentage_on_time');

                        //     $percentage = $plan_receivable_percentage;
                        //     $additionalAmount = ($amount * $percentage) / 100;
                        //     $totalAmount = $amount + $additionalAmount;

                        //     DB::table('redemption_items')->where('id', $redemption_items->id)->update([
                        //         'transaction_id' => $transactions_id,
                        //         'receivable_amount' => $totalAmount,
                        //         'status' => 'paid',
                        //         'receipt_date' => Carbon::now()->format('Y-m-d H:i:s'),
                        //     ]);
                        // } else {

                        //     DB::table('redemption_items')->where('id', $redemption_items->id)->update([
                        //         'transaction_id' => $transactions_id,
                        //         'receivable_amount' => $amount,
                        //         'status' => 'paid',
                        //         'remarks' => 'penalty for late payment of installment',
                        //         'receipt_date' => Carbon::now()->format('Y-m-d H:i:s'),
                        //     ]);
                        // }

                        // Get the current date
                        $currentDate = Carbon::now()->format('Y-m-d');

                        // Parse the due date start and end
                        $dueDateStart = Carbon::parse($redemption_items->due_date_start);
                        $dueDateEnd = Carbon::parse($redemption_items->due_date_end);

                        // Check if the current date is less than the due date start or between the due date start and end
                        if ($currentDate < $dueDateStart->format('Y-m-d') || Carbon::parse($currentDate)->between($dueDateStart, $dueDateEnd)) {
                            // Get the receivable percentage on time from the plans table
                            $planReceivablePercentage = DB::table('plans')->where('id', $redemption->plan_id)->value('receivable_percentage_on_time');
                            
                            // Calculate the additional amount
                            $additionalAmount = ($amount * $planReceivablePercentage) / 100;
                            $totalAmount = $amount + $additionalAmount;

                            // Update the redemption items table
                            DB::table('redemption_items')->where('id', $redemption_items->id)->update([
                                'transaction_id' => $transactions_id,
                                'receivable_amount' => $totalAmount,
                                'receivable_gold' => gold_amount($totalAmount),
                                'status' => 'paid',
                                'receipt_date' => Carbon::now()->format('Y-m-d H:i:s'),
                            ]);
                        } else {
                            // Update the redemption items table with penalty remarks
                            DB::table('redemption_items')->where('id', $redemption_items->id)->update([
                                'transaction_id' => $transactions_id,
                                'receivable_amount' => $amount,
                                'receivable_gold' => gold_amount($amount),
                                'status' => 'paid',
                                'remarks' => 'penalty for late payment of installment',
                                'receipt_date' => Carbon::now()->format('Y-m-d H:i:s'),
                            ]);
                        }

                        $installment = $redemption_items->installment_no;

                        $plan_period = DB::table('plans')->where('id', $redemption->plan_id)->value('installment_period');

                        $plan_period = (int) $plan_period;

                        if ($installment != $plan_period) {
                            // Update the next installment to pending
                            $next = $redemption_items->installment_no + 1;
                            DB::table('redemption_items')
                                ->where('redemption_id', $redemption->id)
                                ->where('installment_no', $next)
                                ->update(['status' => 'pending']);
                        }
                    } else {
                        return 'false';
                    }
                } else {
                    return 'false';
                }

                if ($installment == 1) {
                    $installment .= 'st';
                } elseif ($installment == 2) {
                    $installment .= 'nd';
                } elseif ($installment == 3) {
                    $installment .= 'rd';
                } else {
                    $installment .= 'th';
                }

                $phone_email = DB::table('users')->where('id', $order->temp_user_id)->select('phone', 'email', 'fullname')->first();

                $sms = (new SmsController)->smsgatewayhub_installment_payment_successful($phone_email->phone, $installment, $amount);

                $email_templet = (new SmsController)->email_installment_payment_successful($phone_email->email, $installment, $amount);

                $wati_payment_success = (new SmsController)->wati_payment_success($phone_email->phone, $phone_email->fullname, $installment, $amount);

                // delete temp recored
                DB::table('temp_transactions')->where('payment_id', $txnid)->delete();

                Storage::disk('public')->put('webhook/success/' . $txnid . '-success.txt', $txnid);

                //-------------------------------- Installment ------------------------------------

            }
        } else {
            return 'false';
        }
    }




    public function webhook_pum_fail(Request $request)
    {
        $fileContent = [
            'headers' => $request->headers->all(),
            'postData' => $request->all(),
        ];

        $filePath = time() . '-fail.txt';
        Storage::disk('public')->put('webhook/fail/' . $filePath, json_encode($fileContent));

        // Create the file
        // file_put_contents($filePath, json_encode($fileContent));
    }



    /* ----------------------------- testing controller -------------------------------------------- */

    // public function dummy_esign()
    // {

    //     $user = DB::table('users')->where('id', 20)
    //     ->get(['id','plan_id','installment_amount','first_name','last_name', 'fullname', 'email','phone'])->first();

    //     $user_detail = DB::table('userdetails')
    //     ->where('user_id', 20)
    //     ->get(['pan_number','flat_no','street','locality','state','city','pincode','address','nominee_name','nominee_phone','nominee_address','nominee_relation','aadhar_number'])
    //     ->first();

    //     $plan = DB::table('plans')->where('id', $user->plan_id)->get(['name','installment_period'])->first();

    //     // Get user details
    //     $data = [
    //         'user' => $user,
    //         'plan' => $plan,
    //         'user_detail' => $user_detail
    //     ];

    //     // Render the HTML view with user details
    //     $html = View::make('frontend.component.template', compact('data'))->render();

    //     // Create a new DOMPDF instance
    //     $dompdf = new Dompdf();

    //     // Load HTML content
    //     $dompdf->loadHtml($html);

    //     // (Optional) Set paper size and orientation
    //     $dompdf->setPaper('A4', 'portrait');

    //     // Render the HTML as PDF
    //     $dompdf->render();

    //     // Generate a unique filename
    //     $filename = 'generated_pdf_' . time() . '.pdf';

    //     $output = $dompdf->output();
    //     $path = Storage::disk('public')->put('generate_pdf/' . $filename, $output);

    //     return $dompdf->stream($path, ['Attachment' => false]);
    // }

    // public function dummy_esign2()
    // {

    //     $user = DB::table('users')->where('id', 20)
    //     ->get(['id','plan_id','installment_amount','first_name','last_name', 'fullname', 'email','phone'])->first();

    //     $user_detail = DB::table('userdetails')
    //     ->where('user_id', 20)
    //     ->get(['pan_number','flat_no','street','locality','state','city','pincode','address','nominee_name','nominee_phone','nominee_address','nominee_relation','aadhar_number'])
    //     ->first();

    //     $plan = DB::table('plans')->where('id', $user->plan_id)->get(['name','installment_period'])->first();

    //     // Get user details
    //     $data = [
    //         'user' => $user,
    //         'plan' => $plan,
    //         'user_detail' => $user_detail
    //     ];

    //     // Render the HTML view with user details
    //     $html = View::make('frontend.component.template_plan2', compact('data'))->render();

    //     // Create a new DOMPDF instance
    //     $dompdf = new Dompdf();

    //     // Load HTML content
    //     $dompdf->loadHtml($html);

    //     // (Optional) Set paper size and orientation
    //     $dompdf->setPaper('A4', 'portrait');

    //     // Render the HTML as PDF
    //     $dompdf->render();

    //     // Generate a unique filename
    //     $filename = 'generated_pdf_' . time() . '.pdf';

    //     $output = $dompdf->output();
    //     $path = Storage::disk('public')->put('generate_pdf/' . $filename, $output);

    //     return $dompdf->stream($path, ['Attachment' => false]);
    // }


    // public function testing(){
    //     // $otp = '667788';
    //     // $phone = '8433625599';
    //     // $installment = '1st';
    //     // $amount = '16000 rs';


    //     // $sms = (new SmsController)->smsgatewayhub_registration_otp($phone, $otp);

    //     // $sms = (new SmsController)->smsgatewayhub_reset_pwd_otp($phone, $otp);
    //     // $sms = (new SmsController)->smsgatewayhub_registration_successful($phone, $otp);
    //     // $sms = (new SmsController)->smsgatewayhub_installment_payment_successful($phone, $installment, $amount);

        
    // }






















}
