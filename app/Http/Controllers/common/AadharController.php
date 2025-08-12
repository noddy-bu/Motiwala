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
      $token = env('AADHAR_KYC_TOKEN');
      if (empty($token)) {
          Log::error('Surepass token missing from .env');
          return ['response'=>'error','success'=>false,'message'=>'Server misconfiguration: AADHAR_KYC_TOKEN missing'];
      }

      // Use a public HTTPS redirect URL (use ngrok in local dev)
      $redirectUrl = route('aadhaar.callback'); // ensure this is https public URL when testing

      // payload MUST include "data" wrapper per Surepass docs / examples
      $payloadArray = [
          'data' => [
              'signup_flow'  => true,
              'redirect_url' => $redirectUrl,
          ]
      ];
      $payload = json_encode($payloadArray);

      $curl = curl_init();
      curl_setopt_array($curl, [
          CURLOPT_URL => 'https://kyc-api.surepass.app/api/v1/digilocker/initialize',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_POST => true,
          CURLOPT_POSTFIELDS => $payload,
          CURLOPT_HTTPHEADER => [
              'Content-Type: application/json',
              'Authorization: Bearer ' . $token,
              'Accept: application/json'
          ],
          CURLOPT_TIMEOUT => 30,
      ]);

      $response = curl_exec($curl);
      $curlErr  = curl_error($curl);
      $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      curl_close($curl);

      $body = null;
      if (!empty($response)) {
          $body = json_decode($response, true);
      }

      Log::info('Surepass initialize response', [
          'status'   => $httpCode,
          'raw'      => $response,
          'json'     => $body,
          'curl_err' => $curlErr,
          // remove payload logging on production
          'payload'  => $payloadArray,
      ]);

      if (!empty($curlErr)) {
          return ['response'=>'error','success'=>false,'message'=>'cURL error: '.$curlErr];
      }

      if ($httpCode < 200 || $httpCode >= 300) {
          return [
              'response' => 'error',
              'success'  => false,
              'message'  => 'Surepass API returned HTTP '.$httpCode,
              'detail'   => $body ?? $response,
              'status'   => $httpCode
          ];
      }

      if (is_array($body) && !empty($body['success'])) {
          return [
              'response' => 'success',
              'success'  => true,
              'message'  => 'Please complete verification at DigiLocker',
              'data'     => $body['data'] ?? null
          ];
      }

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
              return response()->json([
                  'response' => 'success',
                  'message' => 'Aadhaar verified successfully!',
              ]);
              // return redirect()->route('register.form')->with('success', 'Aadhaar verified successfully!');
          } else {
              Log::error('Surepass download failed', ['resp' => $body]);
              return response()->json([
                  'response' => 'error',
                  'message' => 'Failed to fetch Aadhaar details.',
              ]);
              // return redirect()->route('register.form')->with('error', 'Failed to fetch Aadhaar details.');
          }
      } catch (\Exception $e) {
          Log::error('Surepass download exception', ['err' => $e->getMessage()]);
          return response()->json([
              'response' => 'error',
              'message' => 'Server error fetching Aadhaar details.',
          ]);
          // return redirect()->route('register.form')->with('error', 'Server error fetching Aadhaar details.');
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