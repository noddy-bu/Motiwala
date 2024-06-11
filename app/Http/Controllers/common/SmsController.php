<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;

use Illuminate\Http\Request;

class SmsController extends Controller
{

    public function smsgatewayhub_registration_otp($phone, $otp)
    {
        $msg = rawurlencode("OTP: $otp to Verify your mobile number for registration. Keep it secure and don't share it with anyone. KAAK DPIL");
        $phone = '91'.$phone;
        $result = $this->sms_trigger_smsgatewayhub2($phone, $msg);
        var_dump($result);
    }

    public function smsgatewayhub_reset_pwd_otp($phone, $otp) //reset password
    {
        $msg = rawurlencode("Reset your password using the OTP: $otp. Keep it confidential and secure. KAAK DPIL");
        $this->sms_trigger_smsgatewayhub2($phone, $msg);
    }  
    
    public function smsgatewayhub_customer_card_active($phone) //customer card active
    {
        $msg = rawurlencode("Your Maay card is activated. KAAK DPIL");
        $this->sms_trigger_smsgatewayhub2($phone, $msg);
    } 
    
    public function smsgatewayhub_customer_card_inactive($phone, $reason) //customer card inactive
    {
        $msg = rawurlencode("Your Maay card is Deactivated due to $reason. Please contact admin for Further clarification. KAAK DPIL");
        $this->sms_trigger_smsgatewayhub2($phone, $msg);
    }  
    
    
    public function sms_trigger_smsgatewayhub2($phone, $msg)
    {
        $api_key = env('SMSGHUB_API_KEY');
        $sender_id = env('SMSGHUB_SENDER2');
        
        
        $ch = curl_init('https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$api_key.'&senderid='.$sender_id.'&channel=2&DCS=0&flashsms=0&number='.$phone.'&text='.$msg.'&route=1');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,"");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
        $response = curl_exec($ch);
        return $response;
    }


}