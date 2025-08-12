<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AadharController extends Controller
{
      
/*
     function requestOtpAadhar($aadhar_no) {
         
        $bearer_token = env('AADHAR_KYC_TOKEN');
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://kyc-api.aadhaarkyc.io/api/v1/aadhaar-v2/generate-otp',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
        	"id_number":  '.$aadhar_no.'
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$bearer_token.''
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    
    function validateOtpAadhar($otp, $clientId) {
        
        $bearer_token = env('AADHAR_KYC_TOKEN');
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://kyc-api.aadhaarkyc.io/api/v1/aadhaar-v2/submit-otp',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
        	"client_id": "'.$clientId.'",
        	"otp": "'.$otp.'"
          }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$bearer_token.''
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;        
    }    
*/

  // Step 1: initialize DigiLocker flow and return redirect_url to frontend
  public function initializeAadhaar(Request $request)
{
    // Check token
    $token = env('AADHAR_KYC_TOKEN');
    if (empty($token)) {
        Log::error('Surepass token missing from .env');
        return [
            'response' => 'error',
            'success'  => false,
            'message'  => 'Server misconfiguration: AADHAR_KYC_TOKEN missing'
        ];
    }

    // Build redirect URL for callback
    $redirectUrl = route('aadhaar.callback');

    // Build payload.
    // NOTE: use the payload format you want. Many examples use top-level keys,
    // but if your docs show a "data" wrapper, use that. Update as needed.
    $payloadArray = [
        // If your docs require "data" wrapper, uncomment the next line and use it.
        // 'data' => ['signup_flow' => true, 'redirect_url' => $redirectUrl],

        // Most examples expect top-level keys:
        'signup_flow'  => true,
        'redirect_url' => $redirectUrl,
    ];

    $payload = json_encode($payloadArray);

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://kyc-api.surepass.app/api/v1/digilocker/initialize',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token,
            'Accept: application/json'
        ],
        // Keep SSL verification ON in production. If your local environment has issues,
        // you can temporarily disable with the next two opts (NOT recommended for prod).
        // CURLOPT_SSL_VERIFYHOST => 0,
        // CURLOPT_SSL_VERIFYPEER => 0,
    ]);

    $response = curl_exec($curl);
    $curlErr  = curl_error($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    // try decode JSON (assoc)
    $body = null;
    if (!empty($response)) {
        $body = json_decode($response, true);
    }

    // Log everything (always pass an array as context)
    Log::info('Surepass initialize response', [
        'status'    => $httpCode,
        'raw'       => $response,
        'json'      => $body,
        'json_err'  => function_exists('json_last_error_msg') ? json_last_error_msg() : null,
        'curl_err'  => $curlErr,
        'payload'   => $payloadArray, // optional: remove in production if sensitive
    ]);

    // handle curl error
    if (!empty($curlErr)) {
        return [
            'response' => 'error',
            'success'  => false,
            'message'  => 'cURL error: ' . $curlErr
        ];
    }

    // handle non-2xx HTTP responses
    if ($httpCode < 200 || $httpCode >= 300) {
        return [
            'response' => 'error',
            'success'  => false,
            'message'  => 'Surepass API returned HTTP ' . $httpCode,
            'detail'   => $body ?? $response,
            'status'   => $httpCode
        ];
    }

    // success path (ensure body parsed & success flag)
    if (is_array($body) && !empty($body['success'])) {
        return [
            'response' => 'success',
            'success'  => true,
            'message'  => 'Please complete verification at DigiLocker',
            'data'     => $body['data'] ?? null
        ];
    }

    // fallback if JSON parsed but success not true
    return [
        'response' => 'error',
        'success'  => false,
        'message'  => $body['message'] ?? 'Failed to initialize digilocker flow',
        'detail'   => $body ?? $response
    ];
}



  // Step 2: callback route — Surepass redirects here with client_id
  public function aadhaarCallback(Request $request)
  {
      $clientId = $request->get('client_id');

      if (!$clientId) {
          // You can redirect back to your form with an error
          // return redirect()->route('register.form')->with('error', 'Missing client_id from Surepass callback.');
          return response()->json([
              'response' => 'error',
              'message' => 'Missing client_id from Surepass callback.',
          ]);
      }

      try {
          $resp = Http::withToken(env('AADHAR_KYC_TOKEN'))
                      ->withHeaders(['Content-Type' => 'application/json'])
                      ->get('https://kyc-api.surepass.app/api/v1/digilocker/download-aadhaar/' . $clientId);

          $body = $resp->json();

          if (!empty($body['success']) && $body['success'] === true) {
              // Save ekyc & aadhar number
              DB::table('userdetails')->where('user_id', Session::get('temp_user_id'))->update([
                  'ekyc' => json_encode($body),
                  'aadhar_number' => $body['data']['aadhaar_number'] ?? Session::get('aadhar_no'),
              ]);

              // prepare customer_detail in session like before
              $customer_detail = [
                  'profileImage' => $body['data']['profile_image'] ?? null,
                  'name' => $body['data']['full_name'] ?? null,
                  'address' => $body['data']['address'] ?? null,
                  'zip' => $body['data']['zip'] ?? null,
                  'dob' => $body['data']['dob'] ?? null,
                  'care_of' => $body['data']['care_of'] ?? null,
                  'mobile' => $body['data']['mobile_hash'] ?? null,
              ];
              Session::put('customer_detail', $customer_detail);
              Session::put('step', 5);

              // Redirect to your registration flow success page
              return redirect()->route('register.form')->with('success', 'Aadhaar verified successfully!');
          } else {
              Log::error('Surepass download failed', ['resp' => $body]);
              return redirect()->route('register.form')->with('error', 'Failed to fetch Aadhaar details.');
          }
      } catch (\Exception $e) {
          Log::error('Surepass download exception', ['err' => $e->getMessage()]);
          return redirect()->route('register.form')->with('error', 'Server error fetching Aadhaar details.');
      }
  }

  public function initializeAadhaarForResend($aadhar)
  {
      // This function should behave exactly like initializeAadhaar but without validating request input.
      // Ensure route('aadhaar.callback') is public HTTPS when testing.
      $request = new Request(['aadhar' => $aadhar]);
      return $this->initializeAadhaar($request);
  }

}