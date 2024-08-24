<?php

use Illuminate\Support\Facades\Cache;
use App\Models\BusinessSetting;

//use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;


    if (!function_exists('datetimeFormatter')) {
        function datetimeFormatter($value)
        {
            return date('d M Y H:iA', strtotime($value));
        }
    }

    //sensSMS function for OTP
    if (!function_exists('get_settings')) {
        function get_settings($type)
        {
            // $cacheKey = "business_setting_{$type}";
        
            // // Check if the value is already in the cache
            // if (Cache::has($cacheKey)) {
            //     return Cache::get($cacheKey);
            // }
        
            // If not in the cache, retrieve the value from the database
            $businessSetting = BusinessSetting::where('type', $type)->first();
            $value = $businessSetting->value;
        
            // if ($businessSetting) {
            //     $value = $businessSetting->value;
        
            //     // Store the value in the cache with a specific lifetime (e.g., 60 minutes)
            //     Cache::put($cacheKey, $value, now()->addMinutes(60));
        
            //     return $value;
            // }
        
            // Handle the case where no record is found
            // return null; // or any default value or error handling you prefer
            return $value;
        }
    }

    if (!function_exists('gold_amount')) {
        function gold_amount($amount)
        {

            $businessSetting = BusinessSetting::where('type', 'gold_rate_in_1gram_per_day')->first();
            $gold_1_gram_price = $businessSetting->value;


            $grams_of_gold = ($amount / $gold_1_gram_price);

            return $grams_of_gold;
        }
    }


    // if (!function_exists('get_contactpage')) {
    //     function get_contactpage($type)
    //     {
    //         $cacheKey = "contact_page_setting_{$type}";
        
    //         // Check if the value is already in the cache
    //         if (Cache::has($cacheKey)) {
    //             return Cache::get($cacheKey);
    //         }
        
    //         // If not in the cache, retrieve the value from the database
    //         $ContactSetting = ContactSetting::where('type', $type)->first();
        
    //         if ($ContactSetting) {
    //             $value = $ContactSetting->value;
        
    //             // Store the value in the cache with a specific lifetime (e.g., 60 minutes)
    //             Cache::put($cacheKey, $value, now()->addMinutes(60));
        
    //             return $value;
    //         }
        
    //         // Handle the case where no record is found
    //         return null; // or any default value or error handling you prefer
    //     }
    // }

    // if(!function_exists('sendEmail')){
    //     function sendEmail($to, $subject, $body, $attachments = [])
    //     {
    //         return \Illuminate\Support\Facades\Mail::raw($body, function ($message) use ($to, $subject, $attachments) {
    //             $message->to($to)
    //             //$message->to('khanfaisal.makent@gmail.com')
    //                     ->subject($subject);
        
    //             // Attachments
    //             foreach ($attachments as $attachment) {
    //                 $message->attach($attachment['path'], ['as' => $attachment['name']]);
    //             }
    //         });
    //     }  
    // }


    if(!function_exists('sendEmail')){
        function sendEmail($to, $subject, $body, $replyTo = null)
        {
            // API endpoint
            $url = 'https://api.brevo.com/v3/smtp/email';
            
            // API key
            $apiKey = env('SMTP_API');
            
            // Data to be sent
            $data = array(
                "sender" => array(
                    "name" => env('COMPANY_NAME'),
                    "email" => "info@motiwalajewels.in"
                ),
                "to" => array(
                    array(
                        "email" => $to,
                        "name" => env('COMPANY_NAME'),
                    )
                ),
                "subject" => $subject,
                "htmlContent" => $body
            );
            
            // Check if a reply-to address is provided
            if ($replyTo) {
                $data['replyTo'] = array(
                    "email" => $replyTo,
                );
            }
            
            // Convert data to JSON format
            $postData = json_encode($data);
            
            // Initialize cURL session
            $ch = curl_init($url);
            
            // Set cURL options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'accept: application/json',
                'api-key: ' . $apiKey,
                'content-type: application/json'
            ));
            
            // Execute cURL session
            $response = curl_exec($ch);
            
            // Close cURL session
            curl_close($ch);
        
        }  
    }

    if(!function_exists('ip_info')){
        function ip_info(){
            
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'] ?  $_SERVER['REMOTE_ADDR'] : '';
            }
            $ip = explode(',', $ip);
            $ip = $ip[0];
            //$ip = '103.175.61.38111';
            		
            //$info = file_get_contents("http://ipinfo.io/{$ip}/geo");
            
            $curl = curl_init();
            
            curl_setopt($curl, CURLOPT_URL, 'ipinfo.io/'.$ip.'?token='.env('IPINFO_API_TOKEN'));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_ENCODING, '');
            curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
            curl_setopt($curl, CURLOPT_TIMEOUT, 0);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
            
            $info = curl_exec($curl);
            curl_close($curl);
            
            if(!empty($info)){
                return $info; //return in json
            }else{
                $info = '{ "ip": "none", "city": "none", "region": "none", "country": "none", "loc": "none", "postal": "none", "timezone": "none", "readme": "none" }';
                return $info; //return in json
            }
        }
    }

    if(!function_exists('ulp_id')){
        function ulp_id($number){
            
            // Ensure the length of $ulp_id is exactly 12 digits
            if (strlen($number) < 7) {
                $padding_length = 7 - strlen($number);
                $ulp_number = str_pad($number, 7, '0', STR_PAD_LEFT); // Pad with leading zeros if necessary
            } elseif (strlen($number) > 7) {
                $ulp_number = substr($number, 0, 7); // Trim if longer than 12 digits
            }

            $ulp_number = 'U-'.$ulp_number;

            return $ulp_number;

        }
    }

    if(!function_exists('application_no')){
        function application_no($number){
            
            // Ensure the length of $ulp_id is exactly 12 digits
            if (strlen($number) < 7) {
                $padding_length = 7 - strlen($number);
                $application_no = str_pad($number, 7, '0', STR_PAD_LEFT); // Pad with leading zeros if necessary
            } elseif (strlen($number) > 7) {
                $application_no = substr($number, 0, 7); // Trim if longer than 12 digits
            }

            $application_no = 'A-'.$application_no;

            return $application_no;

        }
    }

    if(!function_exists('account_no')){
        function account_no($number,$enrollment_Date){
            
            // Ensure the length of $ulp_id is exactly 12 digits
            if (strlen($number) < 4) {
                $padding_length = 4 - strlen($number);
                $account_no = str_pad($number, 4, '0', STR_PAD_LEFT); // Pad with leading zeros if necessary
            } else {
                $account_no = $number;
            }
            // } elseif (strlen($number) > 12) {
            //     $account_no = substr($number, 0, 12); // Trim if longer than 12 digits
            // }

            $now = new \DateTime($enrollment_Date);
            $date = $now->format('d');
            $month = $now->format('m');
            $year = $now->format('Y');

            $account_no = 'AC-'.$year.''.$month.''.$date.''.$account_no;

            return $account_no;

        }
    }


    if(!function_exists('custom_date_change')){
        function custom_date_change($date){
            
            // Create a DateTime object
            $date = new DateTime($date);

            // Get the day, month, and year
            $day = $date->format('j'); // Day without leading zeros
            $month = $date->format('M'); // Short month name
            $year = $date->format('Y'); // Full year

            // Anonymous function to add ordinal suffix to the day
            $addOrdinalSuffix = function ($num) {
                $num = intval($num);
                if (!in_array(($num % 100), [11, 12, 13])) {
                    switch ($num % 10) {
                        case 1: return $num . 'st';
                        case 2: return $num . 'nd';
                        case 3: return $num . 'rd';
                    }
                }
                return $num . 'th';
            };

            // Format the date string
            $formattedDate = $addOrdinalSuffix($day) . ' ' . $month . ' ' . $year;

            return $formattedDate;

        }
    }


    if (!function_exists('check_localhost')) {
        function check_localhost() {
            $url = url()->current();
            return strpos($url, '127.0.') !== false ? 'local' : 'not';
        }
    }


    if (!function_exists('full_url')) {
        function full_url() {
            // Determine if the request is secure
            $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    
            $environment = check_localhost();

            if($environment == 'local'){
                // Get the HTTP or HTTPS part of the URL
                $protocol = $isSecure ? 'https://' : 'http://';
            } else {
                $protocol = $isSecure ? 'https://' : 'https://';
            }

    
            // Build the full URL
            $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    
            return $url;
        }
    }

    if(!function_exists('gold_prifix')){
        function gold_prifix($amount){
            if(!empty($amount)){
                $account_gold_prifix = $amount . ' gm';
            } else {
                $account_gold_prifix = '-';
            }

            return $account_gold_prifix;
        }
    }


    if(!function_exists('send_Whatsapp_Notification')){
        function send_Whatsapp_Notification($phoneNumber, $template_name, $dynmice = []) {

            $dynmice = json_encode($dynmice);

            $api_endpoin  = env('WATI_END_POINT');
            $access_token = env('WATI_TOKEN');

            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://live-mt-server.wati.io/$api_endpoin/api/v1/sendTemplateMessage?whatsappNumber=91$phoneNumber",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'
            {
                "broadcast_name": "'.$template_name.'",
                "template_name":  "'.$template_name.'",
                "parameters": '.$dynmice.'
            }
            ',
            CURLOPT_HTTPHEADER => array(
                'Authorization: '.$access_token.'',
                'Content-Type: text/json'
            ),
            ));
            $response = curl_exec($curl);
            curl_close($curl); 

            return $response;
        }
    }     