<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class EsignAadharController extends Controller
{

    function esign_nsdl($name, $email, $phone){

        $local_url = url('');

        if (Str::contains($local_url, 'http://127')) {
            $redirect_url = "https://motiwala-website.webtesting.pw/create-account/esign-verify";
        } else {
            $redirect_url = url(route('account.create', ['param' =>'esign-verify']));

            echo"2-code";
        }
        

        var_dump($redirect_url);

        $bearer_token_dummy = env('AADHAR_ESIGN_TOKEN_DUMMY');

        $DUMMY_URL = "https://sandbox.surepass.io";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$DUMMY_URL.'/api/v1/esign/initialize',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "pdf_pre_uploaded": true,
                "callback_url": "'.$redirect_url.'",
                "config": {
                    "accept_selfie": true,
                    "allow_selfie_upload": true,
                    "accept_virtual_sign": true,
                    "track_location": true,
                    "auth_mode": "1",
                    "reason": "Contract",
                    "positions": {
                        "1": [
                            {
                                "x": 450,
                                "y": 40
                            }
                        ]
                        
                    }
                },
                "prefill_options": {
                    "full_name": "'.$name.'",
                    "mobile_number": "'.$phone.'",
                    "user_email": "'.$email.'"
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$bearer_token_dummy.''
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);


        $res_response = json_decode($response);

        $result = json_decode($response);

        if(isset($res_response->errors)){
            $error = 'error Generating link';
            return $error;
        } 

        if($res_response->status_code != 200){
            $error = 'error Generating link';
            return $error;
        }

        // echo"<pre>";
        // var_dump($result);
        // echo"</pre>";

        $client_id = $result->data->client_id;


        $get_link_upload = $this->get_upload_link($client_id);

        $result_link_upload = json_decode($get_link_upload);


        if(isset($result_link_upload->errors)){
            $error = 'error Generating upload link';
            return $error;
        } 

        if($result_link_upload->status_code != 200){
            $error = 'error Generating upload link';
            return $error;
        }

        // echo"<pre>";
        // var_dump($result_link_upload);
        // echo"</pre>";

        $fields = $result_link_upload->data->fields;

        $signature = $fields->{'x-amz-signature'};
        $date = $fields->{'x-amz-date'};
        $credentials = $fields->{'x-amz-credential'};
        $upload_key = $fields->{'key'};
        $policy = $fields->{'policy'};
        $algorithm = $fields->{'x-amz-algorithm'};

        $url = $result_link_upload->data->url;


        $upload_pdf = $this->upload_pdf($signature, $date, $credentials, $upload_key, $policy, $algorithm, $url);

        if($upload_pdf !== ""){

            if($upload_pdf === false){
                $error = 'error uploading pdf';
                return $error;
            }

        }

        // echo"<pre>";
        // var_dump($upload_pdf);
        // echo"</pre>";

        return $res_response;
    }



    function get_upload_link($client_id){

        $bearer_token_dummy = env('AADHAR_ESIGN_TOKEN_DUMMY');

        $DUMMY_URL = "https://sandbox.surepass.io";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$DUMMY_URL.'/api/v1/esign/get-upload-link',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "client_id": "'.$client_id.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$bearer_token_dummy.''
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }


    function upload_pdf($signature, $date, $credentials, $upload_key, $policy, $algorithm, $url){

        $file_path = public_path('assets/frontend/pre_upload/dummy.pdf');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url.'',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'x-amz-signature' => ''.$signature.'',
                'x-amz-date' => ''.$date.'',
                'x-amz-credential' => ''.$credentials.'',
                'key' => ''.$upload_key.'',
                'policy' => ''.$policy.'',
                'x-amz-algorithm' => ''.$algorithm.'',
                'file'=> new \CURLFILE($file_path)
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }

    function esign_code(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sandbox.surepass.io/api/v1/esign/initialize',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "pdf_pre_uploaded": false,
            "callback_url": "https://example.com?state=test",
            "config": {
                "accept_selfie": true,
                "allow_selfie_upload": true,
                "accept_virtual_sign": true,
                "track_location": true,
                "auth_mode": "1",
                "reason": "Contract",
                "positions": {
                    "1": [
                        {
                            "x": 10,
                            "y": 20
                        }
                    ]
                    
                }
            },
            "prefill_options": {
                "full_name": "Munna Bhaiya",
                "mobile_number": "9876543210",
                "user_email": "karankapoor229@gmail.com"
            }
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJmcmVzaCI6ZmFsc2UsImlhdCI6MTcxMzYwNjM2OCwianRpIjoiZTk3ZWI5OGYtMjI2NS00NThmLTk0MzgtZDlhOTIxZWMyMjI1IiwidHlwZSI6ImFjY2VzcyIsImlkZW50aXR5IjoiZGV2Lm1vdGl3YWxhamV3ZWxzQHN1cmVwYXNzLmlvIiwibmJmIjoxNzEzNjA2MzY4LCJleHAiOjE3MTYxOTgzNjgsInVzZXJfY2xhaW1zIjp7InNjb3BlcyI6WyJ1c2VyIl19fQ.MtH624R8r1ERW8if3SN5ehapKRTqUrmO_Bwi5fIMcW8'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

}