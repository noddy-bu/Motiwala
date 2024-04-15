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


class AccountController extends Controller
{

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

        }elseif($param == "eSign-aadhar-otp-verify"){

            $rsp_msg = $this->esign_aadhar_otp_verify($request);

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

                Session::put('user_id', $userId);

            } else {
                Session::put('user_id', $user->id);
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
            'pincode' => 'required|regex:/^[\d\s-]+$/|min:3',
            'dob' => 'required',
        ]);

        if ($validator->fails()) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = $validator->errors()->all();

            return $rsp_msg;
        }
        

        if(Session::has('user_id') && !empty(Session::get('user_id'))){

            DB::table('users')->where('id',Session::get('user_id'))->update([
                'salutation' => $request->input('title'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ]);

            DB::table('userdetails')->where('user_id',Session::get('user_id'))->update([
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
            'installment_amount' => 'required',
            'nominee_name' => ['nullable', 'string', 'min:3'],
            'nominee_phone' => 'nullable|regex:/^\d{10}$/',
            'nominee_address' => ['nullable', 'string', 'regex:/^[A-Za-z0-9\s,.\/\'&]+$/i', 'min:3'],
            'nominee_relation' => ['nullable', 'string', 'regex:/^[A-Za-z\s,.\'\/&]+$/', 'min:3'],
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

        if(Session::has('user_id') && !empty(Session::get('user_id'))){

            DB::table('users')->where('id',Session::get('user_id'))->update([
                'plan_id' => $request->input('plan_id'),
                'installment_amount' => $request->input('installment_amount'),
            ]);

            DB::table('userdetails')->where('user_id',Session::get('user_id'))->update([
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


        $requestOtp = (new AadharController)->requestOtpAadhar($request->aadhar);
        $requestOtp = json_decode($requestOtp);

        if($requestOtp->success) {
            //do success stuff
            $response = [
                'status'       => true,
                'method'       => 'flash',
                'notification' => "OTP sent to linked Mobile number with ".$request->aadhar_no." Aadhar number."
            ];

            $rsp_msg['response'] = 'success';
            $rsp_msg['message']  = "OTP sent to linked Mobile number with ".$request->aadhar." Aadhar number.";
            
            //set session of aadhar client ID
            session(['customer_aadhar_clientId' => $requestOtp->data->client_id]); 

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
            DB::table('userdetails')->where('user_id',Session::get('user_id'))->update([
                'ekyc' => json_encode($verify),
            ]);

            $ulp_id = DB::table('users')->where('id', Session::get('user_id'))->value('ulp_id');

            if(empty($ulp_id)){
            
                $random = Session::get('user_id');
                $DateTime = time();
            
                $ulp_id = $random . '' . $DateTime;

                // Ensure the length of $ulp_id is exactly 12 digits
                if (strlen($ulp_id) < 12) {
                    $padding_length = 12 - strlen($ulp_id);
                    $ulp_id = str_pad($ulp_id, 12, '0', STR_PAD_LEFT); // Pad with leading zeros if necessary
                } elseif (strlen($ulp_id) > 12) {
                    $ulp_id = substr($ulp_id, 0, 12); // Trim if longer than 12 digits
                }
            
                DB::table('users')->where('id', Session::get('user_id'))->update([
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
            'aadhar' => 'required|digits:12',
        ]);

        if ($validator->fails()) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = $validator->errors()->all();

            return $rsp_msg;
        }

        $rsp_msg['response'] = 'success';
        $rsp_msg['message']  = "OTP sent to linked Mobile number with ".$request->aadhar." Aadhar number.";
        
        Session::put('step', 11);

        /*
        $requestOtp = (new AadharController)->requestOtpAadhar($request->aadhar);
        $requestOtp = json_decode($requestOtp);

        if($requestOtp->success) {
            //do success stuff
            $response = [
                'status'       => true,
                'method'       => 'flash',
                'notification' => "OTP sent to linked Mobile number with ".$request->aadhar_no." Aadhar number."
            ];

            $rsp_msg['response'] = 'success';
            $rsp_msg['message']  = "OTP sent to linked Mobile number with ".$request->aadhar." Aadhar number.";
            
            //set session of aadhar client ID
            session(['customer_aadhar_clientId' => $requestOtp->data->client_id]); 

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
        } */ 

        return $rsp_msg;

    }


    public function esign_aadhar_otp_verify($request){

        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            $rsp_msg['response'] = 'error';
            $rsp_msg['message']  = $validator->errors()->all();

            return $rsp_msg; 
        }

        Session::put('step', 12);
                        
        $rsp_msg['response'] = 'success';
        $rsp_msg['message']  = "eSign verified successfully!";

        /*
        $verify = (new AadharController)->validateOtpAadhar($request->otp, session('customer_aadhar_clientId'));
        $verify = json_decode($verify);


        if($verify->success) {

            //update query here
            DB::table('userdetails')->where('user_id',Session::get('user_id'))->update([
                'ekyc' => json_encode($verify),
            ]);

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
        */

        return $rsp_msg; 

    }



}