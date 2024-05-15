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
            'name' => 'required|min:3',
            'email' => 'required|email',
            'flat_no' => 'required|min:1',
            'street' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            'locality' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            'state' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            'city' => 'required|string|regex:/^[A-Za-z\s,.\'\/&]+$/|min:3',
            'pincode' => 'required|regex:/^[\d\s-]+$/|min:6',
            'dob' => 'required',
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
                'name' => $request->input('name'),
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

        if(Session::has('temp_user_id') && !empty(Session::get('temp_user_id'))){

            DB::table('users')->where('id',Session::get('temp_user_id'))->update([
                'plan_id' => $request->input('plan_id'),
                'installment_amount' => $request->input('installment_amount'),
            ]);

            DB::table('userdetails')->where('user_id',Session::get('temp_user_id'))->update([
                'nominee_name' => $request->input('nominee_name'),
                'nominee_phone' => $request->input('nominee_phone'),
                'nominee_dob' => $request->input('nominee_dob'),
                'nominee_address' => $request->input('nominee_address'),
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
            $result = "true";
        } else {
            $result = "false";
        }

        return $result;
    }


    public function payment_gateway($request){


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


        session()->forget('otp_timestamp');
        session()->forget('phone');
        session()->forget('otp');
        session()->forget('aadhar_no');

        Session::put('step', 13);
        Session::put('payment', 1);

        $rsp_msg['response'] = 'success';
        $rsp_msg['message']  = "Account created successfully!";

        return $rsp_msg;

    }





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