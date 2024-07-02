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
        $msg = rawurlencode("Your verification code is $otp. This code is valid for 2 minutes. Please do not share this code with anyone. Motiwala Jewels");
        $phone = '91'.$phone;
        $this->sms_trigger_smsgatewayhub2($phone, $msg);
    }

    public function smsgatewayhub_reset_pwd_otp($phone, $otp) //reset password
    {
        $msg = rawurlencode("To reset your password for User ID: $phone, please use the code $otp. This code is valid for 2 minutes. Do not share this code with anyone. Motiwala Jewels");
        $phone = '91'.$phone;
        $this->sms_trigger_smsgatewayhub2($phone, $msg);
    }  
    
    public function smsgatewayhub_registration_successful($phone) //customer card active
    {
        $msg = rawurlencode("Congratulations! You have successfully registered. Your login credentials are: User ID: $phone. Password: $phone. Thank you for joining us. Motiwala Jewels");
        $phone = '91'.$phone;
        $this->sms_trigger_smsgatewayhub2($phone, $msg);
    } 
    
    public function smsgatewayhub_installment_payment_successful($phone, $installment, $amount) //customer card inactive
    {
        $msg = rawurlencode("Your $installment installment of $amount has been successfully completed. Thank you for choosing Motiwala Jewels");
        $phone = '91'.$phone;
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