<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


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



    public function email_registration_successful($phone, $email){

        $recipient = $email;
        $subject = 'Congratulations! You have successfully registered at Motiwala Jewels';

        $body = "Congratulations! You have successfully registered. Your login credentials are: User ID: $phone. Password: $phone. Thank you for joining us. Motiwala Jewels";

        sendEmail($recipient, $subject, $body);
    }

    public function email_installment_payment_successful($email ,$installment, $amount){

        $recipient = $email;
        $subject = "Your $installment installment of $amount has been successfully completed";

        $body = "Your $installment installment of $amount has been successfully completed. Thank you for choosing Motiwala Jewels";

        sendEmail($recipient, $subject, $body);
    }




    //------------------------- deu msg config --------------------------//



    public function email_before_Days($email, $installment, $plan, $name, $due_date, $days, $amount){

        if ($installment == 1) {
            $installment .= 'st';
        } elseif ($installment == 2) {
            $installment .= 'nd';
        } elseif ($installment == 3) {
            $installment .= 'rd';
        } else {
            $installment .= 'th';
        }

        $recipient = $email;
        $subject = "Reminder: Upcoming Payment for Installment Plan $plan";

        $body = '
                    <p>Dear '.$name.',</p>
                    <p>We hope this message finds you well.</p>
                    <p>This is a friendly reminder that your payment for Installment Plan <strong>'.$plan.'</strong>, Installment No. <strong>'.$installment.'</strong>, is due on <strong>'.$due_date.'</strong>. To help you stay on track, we wanted to remind you '.$days.' days in advance.</p>
                    <p>Please ensure that your payment is completed on time to avoid any late fees or service interruptions.</p>
                    <p><strong>Payment Details:</strong></p>
                    <ul>
                        <li><strong>Plan Name:</strong> '.$plan.'</li>
                        <li><strong>Installment No.:</strong> '.$installment.'</li>
                        <li><strong>Due Date:</strong> '.$due_date.'</li>
                        <li><strong>Amount:</strong> '.$amount.'</li>
                    </ul>
                    <p>If you have any questions or need assistance, please feel free to contact our support team.</p>
                    <p>Thank you for your prompt attention to this matter.</p>
                    <p>Best regards,<br>
                    '.env('COMPANY_NAME').'<br>
                    Mob: +91 9920077780</p>
                ';

        sendEmail($recipient, $subject, $body);
    }



    public function due_msg()
    {
        $info = DB::table('redemption_items')
            ->select([
                'redemption_items.id',
                'redemption_items.due_date_start as due_start',
                'redemption_items.due_date_end as due_end',
                'redemption_items.status as due_status',
                'redemption_items.redemption_id as redem_id',
                'redemption_items.installment_amount as installment_amount',
                'redemption_items.installment_no as installment_no',
                'redemptions.user_id as user_id',
                'redemptions.status as status',
                'redemptions.plan_id as plan_id',
                'users.fullname',
                'users.email',
                'users.phone',
                'plans.name as plan_name'
            ])
            ->join('redemptions', 'redemption_items.redemption_id', '=', 'redemptions.id')
            ->join('users', 'redemptions.user_id', '=', 'users.id')
            ->join('plans', 'redemptions.plan_id', '=', 'plans.id')
            ->where('redemption_items.status', 'pending')
            ->where('redemptions.status', '!=', 0)
            ->get();
    
        $currentDate = Carbon::now()->format('Y-m-d');

        echo $currentDate;
        echo"<pre>";
    
        foreach ($info as $row) {
            $dueStart = Carbon::parse($row->due_start);
            $dueEnd = Carbon::parse($row->due_end);
    
            // 7 days before due date start
            $before7Days = $dueStart->copy()->subDays(7)->format('Y-m-d');
            if ($currentDate == $before7Days) {
                echo "7 days reminder: " . $row->email .' '.$row->id;
                echo"<pre>";
                // Share email, SMS, WhatsApp message
                $days = 7;
                $this->email_before_Days($row->email, $row->installment_no, $row->plan_name, $row->fullname, $dueStart, $days, $row->installment_amount);
            }

            // 3 days before due date start
            $before3Days = $dueStart->copy()->subDays(3)->format('Y-m-d'); // Add back 4 days (3 + 1 for previous subDays)
            if ($currentDate == $before3Days) {
                echo "3 days reminder: " . $row->email.' '.$row->id;
                echo"<pre>";
                // Share email, SMS, WhatsApp message

                $days = 3;
                $this->email_before_Days($row->email, $row->installment_no, $row->plan_name, $row->fullname, $dueStart, $days, $row->installment_amount);
            }

            // Between due date start and end
            if (Carbon::parse($currentDate)->between($dueStart, $dueEnd)) {
                echo "Due between start and end: " . $row->email.' '.$row->id;
                echo"<pre>";
                // Share email, SMS, WhatsApp message
            }

            // 1 day after due date end
            $afterDueEnd = $dueEnd->copy()->addDay()->format('Y-m-d');
            if ($currentDate == $afterDueEnd) {
                echo "1 day after due end: " . $row->email.' '.$row->id;
                echo"<pre>";
                // Share email, SMS, WhatsApp message
            }
        }
    } 
    
    

}