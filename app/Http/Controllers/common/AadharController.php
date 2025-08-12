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
      $redirectUrl = route('account.create', 'aadhar-otp-verify'); // ensure this is https public URL when testing
      // $redirectUrl = route('aadhaar.callback'); // ensure this is https public URL when testing

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
  public function aadhaarCallback($clientId)
  {
      try {
          $curl = curl_init();
          curl_setopt_array($curl, [
              CURLOPT_URL => 'https://kyc-api.surepass.app/api/v1/digilocker/download-aadhaar/' . $clientId,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_HTTPHEADER => [
                  'Authorization: Bearer ' . env('AADHAR_KYC_TOKEN'),
                  'Content-Type: application/json'
              ],
          ]);

          $response = curl_exec($curl);
          $error = curl_error($curl);
          curl_close($curl);
          // Debug log for raw API JSON
          Log::debug('Surepass Aadhaar API Raw Response', [
              'client_id' => $clientId,
              'raw_json'  => $response
          ]);
          if ($error) {
              Log::error('Surepass Aadhaar cURL Error', ['error' => $error]);
              return json_encode([
                  'success' => false,
                  'message' => 'API connection error: ' . $error
              ]);
          }

          return $response; // raw JSON from API
      } catch (\Exception $e) {
          Log::error('Surepass Aadhaar Exception', ['error' => $e->getMessage()]);
          return json_encode([
              'success' => false,
              'message' => 'Server error: ' . $e->getMessage()
          ]);
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