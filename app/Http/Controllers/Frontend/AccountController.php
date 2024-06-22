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

    public function customer_login(Request $request){

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
        if($authenticated)
        {
            session()->forget(['step', 'otp_timestamp', 'phone', 'temp_user_id', 'otp', 'aadhar_no', 'payment']);

            Session::put('user_id', auth()->user()->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully logged in'
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 200);
        }


    }

    public function customer_logout(){
        Auth::guard('web')->logout();
        Session()->flush();
        return redirect()->route('index');
    }

    /*------------------------------ Login Logout Function -------------------------------------------------*/


    /*------------------------------ other inner Function -------------------------------------------------*/

    
    public function link_account(){
        return view('frontend.pages.admin.link_account.index');
    }

    public function cancel_ach_si(){
        return view('frontend.pages.admin.cancel_ach_si.index');
    }

    public function get_si_account_nos(){
        return view('frontend.pages.admin.get_si_account_nos.index');
    }

    public function my_accounts(){
        return view('frontend.pages.admin.my_accounts.index');
    }

    public function pay_installments(){

        $info = DB::table('users')
        ->select([
            'users.account_number',
            'users.created_at',
            'users.plan_id',
            'plans.name',
            'plans.installment_period',
            'redeem.total_paid_amount',
            'redeem.installment_count'
        ])
        ->join('plans', 'users.plan_id', '=', 'plans.id')
        ->join('redeem', 'users.id', '=', 'redeem.user_id')
        ->where('redeem.status', 1)
        ->where('users.id',Session::get('user_id'))
        ->get()->first();
        
        $transactions = DB::table('transactions')->where('user_id',Session::get('user_id'))->get();

        return view('frontend.pages.admin.pay_installments.index', compact('info','transactions'));
    }

    public function edit_user_profile(){

        $user = DB::table('users')->where('id', Session::get('user_id'))
        ->get(['plan_id','installment_amount','name','email','phone','ulp_id'])->first();

        $user_detail = DB::table('userdetails')->where('user_id', Session::get('user_id'))
            ->get(['nominee_name','nominee_phone','nominee_dob','nominee_address','nominee_relation','flat_no','street','locality','state','city','pincode','dob','marital_status','spouse_name','spouse_dob','marriage_date'])->first();

        return view('frontend.pages.admin.manage_user_profile.index', compact('user', 'user_detail'));
    }

    public function account_update_profile(Request $request){

        $validator = Validator::make($request->all(), [
            'flat_no' => 'required|min:1',
            'street' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            'locality' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            'state' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            'city' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            'pincode' => 'required|regex:/^[\d\s-]+$/|min:3',
            'dob' => 'required',

            'nominee_name' => ['nullable', 'string', 'min:3'],
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
            'flat_no' => $request->input('flat_no'),
            'street' => $request->input('street'),
            'locality' => $request->input('locality'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'pincode' => $request->input('pincode'),
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

    public function reset_password(){
        $user = DB::table('users')->where('id', Session::get('user_id'))->get(['phone','id'])->first();

        return view('frontend.pages.admin.manage_user_profile.reset_password', compact('user'));
    }

    public function reset_password_update(Request $request){

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



        if(password_verify($rq_old_password, $old_password)){

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

    public function forgot_password($param, Request $request){


        if($param == "verify-number-send-otp"){

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
    
            $user = DB::table('users')->where('phone', $request->phone)->where('status','1')->get(['id'])->first();
    
            if($user){

                Session()->flush();

                $otp = mt_rand(100000, 999999);
                $timestamp = Carbon::now();
                Session::put('otp', $otp);
                Session::put('otp_timestamp', $timestamp);
                Session::put('user_forget_id', $user->id);
                

                return response()->json([
                    'status' => 'success',
                    'message' => 'OTP has been Share on this No : '.$request->phone.''
                ], 200);

            } else {

                return response()->json([
                    'status' => 'error',
                    'message' => 'User Not exist Please Provide Valid Number',
                ], 200);

            }
    

        }elseif($param == "verify-forgot-otp"){

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
    
        
        }elseif($param == "reset-password"){


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
    
            $user = DB::table('users')->where('id', Session::get('user_forget_id'))->where('status','1')->get(['id'])->first();

            if($user){
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
                'message' => 'Something Went Wrong or Invalid parameter: '.$param.''
            ], 200);

        }


        return response()->json([
            'status' => 'success',
            'message' => 'Successfully forgot Password'
        ], 200);

    }


    /*------------------------------ Forgot password Function -------------------------------------------*/



    /*------------------------------  Registration user -------------------------------------------------*/

    public function online_enrollment(){
        return view('frontend.pages.online_enrollment.index');
    }

    public function create_account($param, Request $request){

        if($param == "phone-verification"){

            $rsp_msg = $this->phone_verification($request);

        }elseif($param == "verify-otp"){

            $rsp_msg = $this->verify_otp($request);
        
        }elseif($param == "resend-otp"){

            $rsp_msg = $this->resendOtp($request);

        }elseif($param == "customer-info"){

            $rsp_msg = $this->create_customer_detail($request);

        }elseif($param == "plan-info"){

            $rsp_msg = $this->update_plan_detail($request);

        }elseif($param == "ekyc-varification"){

            $rsp_msg = $this->accept_ekyc_term($request);

        }elseif($param == "aadhar-verify-request-otp"){

            $rsp_msg = $this->aadhar_verify_request_otp($request);

        }elseif($param == "aadhar-otp-verify"){

            $rsp_msg = $this->aadhar_otp_verify($request);

        }elseif($param == "esign-varification"){

            $rsp_msg = $this->accept_esign_term($request);

        }elseif($param == "esign-aadhar-verify-request-otp"){

            $rsp_msg = $this->esign_aadhar_verify_request_otp($request);

        }elseif($param == "esign-verify"){
            
            $rsp_msg = $this->esign_verify();

            if($rsp_msg = "true"){
                Session::put('step', 12);
            } else {
                Session::put('step', 10);
            }

            return redirect()->route('account.new.enrollment.page');

        }elseif($param == "payment-gateway"){

            $rsp_msg = $this->payment_gateway($request);

        } else {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message'] = "Invalid parameter: $param";
        }
        

        return response()->json(array('response_message' => $rsp_msg));
    }



/*-------------------------------- function ---------------------------------------------*/


    public function phone_verification($request){
        
        $validator = Validator::make($request->all(), [
            'accept_term' => 'required',
            'phone' => 'required|regex:/^\d{10}$/',
        ]);

        if ($validator->fails()) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = $validator->errors()->all();

            return $rsp_msg; 
        } 

        $user = DB::table('users')->where('phone', $request->phone)->where('status','1')->get(['id'])->first();

        if($user){
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
        // $sms = (new SmsController)->smsgatewayhub_registration_otp($request->phone, $otp);

        Session::put('step', 2);
        
        $rsp_msg['response'] = 'success';
        $rsp_msg['message']  = "OTP has been Share on this No : $request->phone ";

        return $rsp_msg;
    }


    public function verify_otp($request){
        
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

            $user = DB::table('users')->where('phone', $phone)->get(['id'])->first();

            if(empty($user)){

                $userId = DB::table('users')->insertGetId([
                    'accept_term' => 1,
                    'phone' => $phone,
                    'role_id' => 2,
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
        
        $contact = Session::get('phone');

        //sms integration

        $rsp_msg['response'] = 'success';
        $rsp_msg['message']  = "OTP has been Resend no this No : $contact ";

        return $rsp_msg;
    }


    public function create_customer_detail($request){

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'first_name' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            'last_name' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:1',
            'email' => 'required|email',
            'flat_no' => 'required|min:1',
            'street' => 'required|string|regex:/^[A-Za-z0-9\s,.\'\/&]+$/|min:3',
            'locality' => 'required|string|regex:/^[A-Za-z0-9\s,.\'\/&]+$/|min:3',
            'state' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            'city' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            'pincode' => 'required|regex:/^[\d\s-]+$/|min:6',
            'pan_number' => 'required|string|regex:/^[A-Za-z0-9\s,.\'\/&]+$/|min:10|max:10',
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
        
        $users_email = DB::table('users')->where('email', $request->input('email'))->where('status', 1)->get();

        if(count($users_email) != 0){
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = 'Email Already Exists';

            return $rsp_msg;
        }



        if(Session::has('temp_user_id') && !empty(Session::get('temp_user_id'))){

            DB::table('users')->where('id',Session::get('temp_user_id'))->update([
                'salutation' => $request->input('title'),
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => strtolower($request->input('email')),
            ]);

            DB::table('userdetails')->where('user_id',Session::get('temp_user_id'))->update([
                'flat_no' => $request->input('flat_no'),
                'street' => $request->input('street'),
                'locality' => $request->input('locality'),
                'state' => $request->input('state'),
                'city' => $request->input('city'),
                'pincode' => $request->input('pincode'),
                'dob' => $request->input('dob'),
                'pan_number' => $request->input('pan_number'),
            ]);

            Session::put('step', 4);

            $rsp_msg['response'] = 'success';
            $rsp_msg['message']  = "Customer Detail Added successfully. Please Proceed";

        } else {

            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = "Something Went Wrong";

        }
        
        return $rsp_msg;

    }

    public function update_plan_detail($request){

        $validator = Validator::make($request->all(), [
            'plan_id' => 'required',
            'installment_amount' => 'required|numeric',
            'nominee_name' => ['nullable', 'string', 'min:3', 'max:250'],
            'nominee_phone' => 'nullable|regex:/^\d{10}$/',
            'nominee_address' => ['nullable', 'string', 'regex:/^[A-Za-z0-9\s,.\/\'&]+$/i', 'min:3', 'max:250'],
            'nominee_relation' => ['nullable', 'string', 'regex:/^[A-Za-z\s,.\'\/&]+$/', 'min:3', 'max:250'],
        ]);

        if ($validator->fails()) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = $validator->errors()->all();

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

        if($request->has('residence_address_check')){
            $address = $request->input('residence_nominee_address');
        } else {
            $address = $request->input('nominee_address');
        }

        if(Session::has('temp_user_id') && !empty(Session::get('temp_user_id'))){

            DB::table('users')->where('id',Session::get('temp_user_id'))->update([
                'plan_id' => $request->input('plan_id'),
                'installment_amount' => $request->input('installment_amount'),
            ]);

            DB::table('userdetails')->where('user_id',Session::get('temp_user_id'))->update([
                'nominee_name' => $request->input('nominee_name'),
                'nominee_phone' => $request->input('nominee_phone'),
                'nominee_dob' => $request->input('nominee_dob'),
                'nominee_address' => $address,
                'nominee_relation' => $request->input('nominee_relation'),
            ]);

            Session::put('step', 5);

            $rsp_msg['response'] = 'success';
            $rsp_msg['message']  = "Plan Detail Added successfully. Please Proceed";

        } else {

            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = "Something Went Wrong";

        }
        
        return $rsp_msg;

    }


    public function accept_ekyc_term($request){

        $validator = Validator::make($request->all(), [
            'accept_term' => 'required',
        ]);

        if ($validator->fails()) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = $validator->errors()->all();

            return $rsp_msg; 
        }

        Session::put('step', 6);

        $rsp_msg['response'] = 'success';
        $rsp_msg['message']  = "Please Proceed for ekyc";

        return $rsp_msg; 
        
    }

    public function aadhar_verify_request_otp($request){

        $validator = Validator::make($request->all(), [
            'aadhar' => 'required|digits:12|same:aadhar_conform',
            'aadhar_conform' => 'required|digits:12',
        ]);

        if ($validator->fails()) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = $validator->errors()->all();

            return $rsp_msg;
        }

        $user_detail = DB::table('userdetails')->where('aadhar_number', $request->aadhar)->get(['user_id'])->first();

        if($user_detail){

            $user = DB::table('users')->where('id', $user_detail->user_id)->where('status','1')->get(['id'])->first();

            if($user){
                $rsp_msg['response'] = 'error';
                $rsp_msg['message']  = "this No : $request->aadhar Already registered";
    
                return $rsp_msg; 
            }

        }



        $requestOtp = (new AadharController)->requestOtpAadhar($request->aadhar);
        $requestOtp = json_decode($requestOtp);

        if($requestOtp->success) {
            //do success stuff

            $rsp_msg['response'] = 'success';
            $rsp_msg['message']  = "OTP sent to linked Mobile number with ".$request->aadhar." Aadhar number.";
            
            //set session of aadhar client ID
            session(['customer_aadhar_clientId' => $requestOtp->data->client_id]); 

            session(['aadhar_no' => $request->aadhar]); 

            Session::put('step', 7);

        }else{
            //do failure stuff
            if($requestOtp->status_code == 429) {
     
                $rsp_msg['response'] = 'error';
                $rsp_msg['message']  = "Wait 60 seconds to generate OTP for same Aadhaar Number.";
                
            }else{
                
                $rsp_msg['response'] = 'error';
                $rsp_msg['message']  = "Invalid Aadhar number / No mobile number is linked with ".$request->aadhar." Aadhar number!";
                
            }
        }  

        return $rsp_msg;

    }


    public function aadhar_otp_verify($request){

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


        if($verify->success) {

            //update query here
            DB::table('userdetails')->where('user_id',Session::get('temp_user_id'))->update([
                'ekyc' => json_encode($verify),
                'aadhar_number' => Session::get('aadhar_no'),
            ]);

            $ulp_id = DB::table('users')->where('id', Session::get('temp_user_id'))->value('ulp_id');

            if(empty($ulp_id)){
            
                $random = Session::get('temp_user_id');
                $DateTime = time();
            
                $ulp_id = $random . '' . $DateTime;

                // Ensure the length of $ulp_id is exactly 12 digits
                if (strlen($ulp_id) < 12) {
                    $padding_length = 12 - strlen($ulp_id);
                    $ulp_id = str_pad($ulp_id, 12, '0', STR_PAD_LEFT); // Pad with leading zeros if necessary
                } elseif (strlen($ulp_id) > 12) {
                    $ulp_id = substr($ulp_id, 0, 12); // Trim if longer than 12 digits
                }
            
                DB::table('users')->where('id', Session::get('temp_user_id'))->update([
                    'ulp_id' => $ulp_id,
                ]);
            
            }


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

            Session::put('step', 8);
                        
            $rsp_msg['response'] = 'success';
            $rsp_msg['message']  = "Aadhar Number verified successfully!";
            
        }else{
            
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = "OTP verification failed!";
            
        }

        return $rsp_msg; 

    }




    /*------------- Esign ------------------------------*/

    public function accept_esign_term($request){

        $validator = Validator::make($request->all(), [
            'accept_term' => 'required',
        ]);

        if ($validator->fails()) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = $validator->errors()->all();

            return $rsp_msg; 
        }

        Session::put('step', 10);

        $rsp_msg['response'] = 'success';
        $rsp_msg['message']  = "Please Proceed for esign";

        return $rsp_msg; 
        
    }


    public function esign_aadhar_verify_request_otp($request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required|regex:/^\d{10}$/',
        ]);

        if ($validator->fails()) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = $validator->errors()->all();

            return $rsp_msg;
        }

        $esign = (new EsignAadharController)->esign_nsdl($request->name, $request->email, $request->phone);
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


    public function esign_verify() {

        $client_id = Session::get('client_id');

        $esign = (new EsignAadharController)->esign_check_status($client_id);
        $esign = json_decode($esign);

        if($esign->success == true){
            $download_pdf = (new EsignAadharController)->download_esign($client_id);

            // DB::table('userdetails')->where('user_id',Session::get('temp_user_id'))->update([
            //     'esign' => 1,
            // ]);

            $result = "true";
        } else {
            $result = "false";
        }

        return $result;
    }


    public function payment_gateway($request){

        $user = DB::table('users')->where('id', Session::get('temp_user_id'))->first(['name', 'email', 'phone', 'installment_amount']);

        //insert in order
        $txnid = substr(hash('sha256', mt_rand().microtime()), 0, 20);
        $orderId = DB::table('temp_transactions')->insertGetId([
            'name'             => $user->name,
            'email'            => $user->email,
            'phone'            => $user->phone,
            'grand_total'      => $user->installment_amount,
            'payment_method'   => 'payu',
            'payment_status'   => 'created',
            'payment_id'       => $txnid,
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s')
        ]);

        if($orderId){

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


/* ------------------------------- Payment gateway ------------------------------------------*/

    const TEST_URL = 'https://test.payu.in';
    //const TEST_URL = 'https://sandboxsecure.payu.in';
    const PRODUCTION_URL = 'https://secure.payu.in';

    public function create_payumoney(request $request, $order_id)
    {
        if($order_id)
        {
            $order = DB::table('temp_transactions')->where('id', $order_id)->where('payment_status', 'created')->first();
            if($order)
            {
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
                        $action = $PAYU_BASE_URL.'/_payment';
        
                    }
                } elseif (!empty($posted['hash'])) {
                    $hash = $posted['hash'];
                    $action = $PAYU_BASE_URL.'/_payment';
        
                }
                
                $updateOrder = DB::table('temp_transactions')->where('id', $order->id)->update([
                    'pum_hash' => $hash,
                    'temp_user_id' => Session::get('temp_user_id')
                ]);
        
                return view('frontend.payumoney.pay', compact('hash', 'action', 'MERCHANT_KEY', 'formError', 'txnid', 'posted', 'SALT', 'order'));
            }
        }
    }


    public function payment_success(Request $request){

        $input = $request->all();

        if(!$input) //redirect if no post
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
            if($order->payment_status == 'paid')
            {
                return redirect(url(''));
            }

            /* ------------ success stuff -----------*/

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

            Session::put('step', 13);
            Session::put('payment', 1);
            Session::put('temp_user_id', $order->temp_user_id);


            DB::table('users')->where('id', Session::get('temp_user_id'))->update([
                'account_number' => $account_number,
                'password' => bcrypt(Session::get('phone')),
                'status' => 1,
            ]);

            $amount = $order->grand_total;

            //update order
            DB::table('transactions')->insert([
                'user_id' => Session::get('temp_user_id'),
                'payment_id' => $txnid,
                'payment_amount' => $order->grand_total,
                'payment_response' => json_encode($input),
                'payment_status' => 'paid',
                'date_of_installment' => date('Y-m-d H:i:s'),
                'installment' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    
            
    
            session()->forget(['otp_timestamp', 'phone', 'otp', 'aadhar_no', 'customer_detail', 'client_id', 'customer_aadhar_clientId']);
    

            /*------------ success stuff --------------*/


            session()->flash('toastr', [
                'type' => 'success',
                'message' => 'Account Created Successfully',
                'title' => 'Success'
            ]);

            // delete temp recored
            DB::table('temp_transactions')->where('payment_id', $txnid)->delete();

            $this->auto_add_transactions(Session::get('temp_user_id'),$amount,$account_number);

            return redirect()->route('account.new.enrollment.page');
        // }
    }


    public function auto_add_transactions($temp_user_id, $amount, $account_number)
    {
        // Retrieve the user's plan ID from the session
        $user_plan_Details = DB::table('users')->where('id', $temp_user_id)->value('plan_id');

        // Retrieve the plan details
        $plan_details = DB::table('plans')->where('id', $user_plan_Details)->first(['minimum_installment_amount', 'installment_period']);

        $total_get_Amount = $amount / 1000 * 10750;

        $redeem_id = DB::table('redeem')->insertGetId([
            'user_id' => $temp_user_id,
            'plan_id' => $user_plan_Details,
            'installment_count' => 1,
            'total_paid_amount' => $amount,
            'total_get_amount' => $total_get_Amount,
            'account_number' => $account_number,
            'status' => '1',
        ]);

        // Calculate the number of installments
        $installments = $plan_details->installment_period;
        // $amount = $plan_details->minimum_installment_amount;

        for ($i = 1; $i <= $installments; $i++) {
            // Insert transaction records
            DB::table('transactions')->insert([
                'user_id' => $temp_user_id,
                'payment_amount' => $amount,
                'payment_response' => '[]',
                'payment_status' => 'unpaid',
                'date_of_installment' => date('Y-m-d H:i:s', strtotime("+$i month")),
                'redeem_id' => $redeem_id,
                'installment' => $i + 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    
    }

    //-------------- test controller -------------------------
    
    // public function testing()
    // {
    //     $this->auto_add_transactions(2, 2000);
    // }

    //-------------- test controller -------------------------

    public function payment_cancel(Request $request){

        $data = $request->all();

        if(!$data) //redirect if no post
        {
            return redirect(url(''));
        } 		
		
        $validHash = true;
		$txnid = $data["txnid"];
		
        if (!$validHash) {
            echo "Invalid Transaction. Please try again";
        } else {
            //fail
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

        return view('frontend.payumoney.fail', compact('errorMessage','data','temp_user_id'));

    }



    public function webhook_pum_success(Request $request) {
        
        $fileContent = [
            'headers' => $request->headers->all(),
            'postData' => $request->all(),
        ];        
        
        $filePath = time().'-success.txt';

        // Create the file
        Storage::disk('public')->put('webhook/' . $filePath, json_encode($fileContent));
        
        // Read the JSON data from the file
        $jsonData = file_get_contents($filePath); //file_get_contents(public_path('1690456548-success.txt'));
        
        // Decode the JSON data into an array
        $fileContent = json_decode($jsonData, true);  
        $postData = $fileContent['postData'];
        $txnid = $postData['merchantTransactionId'];
        
        //success
        //order info
        $order = DB::table('temp_transactions')->where('payment_id', $txnid)->first();
        
        //avoid update if payment is paid
        if($order->payment_status != 'paid')
        {
            
            /* ------------ success stuff -----------*/

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

            DB::table('users')->where('id', $order->temp_user_id)->update([
                'account_number' => $account_number,
                'password' => bcrypt(Session::get('phone')),
                'status' => 1,
            ]);

            //update order
            DB::table('transactions')->insert([
                'user_id' => $order->temp_user_id,
                'payment_id' => $txnid,
                'payment_amount' => $order->grand_total,
                'payment_response' => $jsonData,
                'payment_status' => 'paid',
                'comments' => 'webhook',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    
            /*------------ success stuff --------------*/

            // delete temp recored
            DB::table('temp_transactions')->where('payment_id', $txnid)->delete();

            // Create success
            // file_put_contents(public_path($txnid.'-success.txt'), $txnid);          
            Storage::disk('public')->put('webhook/' . $txnid.'-success.txt', $txnid);
        }else{
            return 'false';
        }          
    }
    
    public function webhook_pum_fail(Request $request){
        $fileContent = [
            'headers' => $request->headers->all(),
            'postData' => $request->all(),
        ];        
        
        $filePath = time().'-fail.txt';
        Storage::disk('public')->put('webhook/' . $filePath, json_encode($fileContent));

        // Create the file
        // file_put_contents($filePath, json_encode($fileContent));
    }



/* ----------------------------- testing controller -------------------------------------------- */    

    public function dummy_esign(){
        
        $user = DB::table('users')->where('id', Session::get('temp_user_id'))
        ->get(['plan_id','installment_amount','name','email','phone'])->first();

        $plan_name = DB::table('plans')->where('id', $user->plan_id)->value('name');

        // Get user details
        $data = [
            'user' => $user,
            'plan_name' => $plan_name
        ];

        // Render the HTML view with user details
        $html = View::make('frontend.component.template', compact('data'))->render();

        // Create a new DOMPDF instance
        $dompdf = new Dompdf();

        // Load HTML content
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Generate a unique filename
        $filename = 'generated_pdf_' . time() . '.pdf';

        $output = $dompdf->output();
        Storage::disk('public')->put('generate_pdf/' . $filename, $output);

        return true;

    }























}