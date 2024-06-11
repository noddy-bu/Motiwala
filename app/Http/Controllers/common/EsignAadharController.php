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

class EsignAadharController extends Controller
{

    function esign_nsdl($name, $email, $phone){

        $local_url = url('');

        if (Str::contains($local_url, 'http://127')) {
            $redirect_url = "https://motiwala-website.webtesting.pw/create-account/esign-verify";
        } else {
            $redirect_url = url(route('account.create', ['param' =>'esign-verify']));
        }
        

        // var_dump($redirect_url);

        $bearer_token_dummy = env('AADHAR_ESIGN_TOKEN_DUMMY');

        // $DUMMY_URL = "https://sandbox.surepass.io";
        $DUMMY_URL ="https://kyc-api.surepass.io";

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

        $generate = $this->generate_pdf($client_id);


        $upload_pdf = $this->upload_pdf($signature, $date, $credentials, $upload_key, $policy, $algorithm, $client_id,  $url);

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

        // $DUMMY_URL = "https://sandbox.surepass.io";
        $DUMMY_URL ="https://kyc-api.surepass.io";

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

    function generate_pdf($client_id){

        $user = DB::table('users')->where('id', Session::get('temp_user_id'))
        ->get(['id','plan_id','installment_amount','name','email','phone','ulp_id'])->first();

        $user_detail = DB::table('userdetails')
        ->where('user_id', Session::get('temp_user_id'))
        ->get(['pan_number','flat_no','street','locality','state','city','pincode','nominee_name','nominee_phone','nominee_address','nominee_relation','aadhar_number'])
        ->first();

        $plan = DB::table('plans')->where('id', $user->plan_id)->get(['name','installment_period'])->first();

        // Get user details
        $data = [
            'user' => $user,
            'plan' => $plan,
            'user_detail' => $user_detail
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
        $filename = 'generated_pdf_' . $client_id . '.pdf';

        $output = $dompdf->output();
        $path = Storage::disk('public')->put('generate_pdf/' . $filename, $output);

        if($path === true){
            $res = "true";
        } else {
            $res = "false";
        }

        return $res;
    }


    function upload_pdf($signature, $date, $credentials, $upload_key, $policy, $algorithm, $client_id, $url){

        //$file_path = url('storage/generate_pdf/generated_pdf_'.$client_id.'.pdf');
        $file_path = './storage/generate_pdf/generated_pdf_'.$client_id.'.pdf';

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


    function esign_check_status($client_id){

        $bearer_token_dummy = env('AADHAR_ESIGN_TOKEN_DUMMY');

        // $DUMMY_URL = "https://sandbox.surepass.io";
        $DUMMY_URL ="https://kyc-api.surepass.io";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$DUMMY_URL.'/api/v1/esign/status/'.$client_id.'',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$bearer_token_dummy.''
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;

    }




    function download_esign($client_id){

        $bearer_token_dummy = env('AADHAR_ESIGN_TOKEN_DUMMY');

        // $DUMMY_URL = "https://sandbox.surepass.io";
        $DUMMY_URL ="https://kyc-api.surepass.io";

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => ''.$DUMMY_URL.'/api/v1/esign/get-signed-document/'.$client_id.'',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$bearer_token_dummy.''
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        $result = $response;

        $result = json_decode($result);

        if($result->success == true){

            $pdfUrl = $result->data->url;

            $temp_user_id = Session::get('temp_user_id');

            $PDFName = 'ESIGN-' . $temp_user_id . '.pdf';

            $user_detail = DB::table('userdetails')->where('user_id', $temp_user_id)->first(['esign']);


            if ($user_detail && !is_null($user_detail->esign) && !empty($user_detail->esign)) {
                // Delete the file using its filename
                Storage::disk('public')->delete('esign_pdf/' . $user_detail->esign);
            }

            // Download the PDF file and save it to the storage folder
            $fileContents = file_get_contents($pdfUrl);
            $path = Storage::disk('public')->put('esign_pdf/' . $PDFName, $fileContents);
            Storage::disk('public')->delete('generate_pdf/generated_pdf_' . $client_id . '.pdf');

            DB::table('userdetails')->where('user_id',$temp_user_id)->update([
                'esign' => $PDFName,
            ]);

            if($path === true){
                $res = "true";
            } else {
                $res = "false";
            }

        } else {
            $res = "false";
        }


        return $res;

    }


}