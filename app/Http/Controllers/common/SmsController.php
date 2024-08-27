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
        $msg = rawurlencode("Congratulations! You have successfully registered. Your login credentials are: User ID: $phone. Password: $phone. Thank you for joining us. Motiwala Jewels Gold & Diamonds Pvt Ltd.");
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

//----------------------------------------------------------- Email ----------------------------------------------------------//

    public function email_registration_successful($phone, $email=""){

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

    public function email_registration_not_completed($name="", $email){

        $recipient = $email;
        $subject = 'Complete Your Registration to Access All Features at Motiwala Jewels';

        $body = '<p>Dear '.$name.',</p>

            <p>We noticed that your registration is still incomplete. To fully access all the features and benefits, please take a moment to complete the registration process.</p>

            <p>If you need any assistance or have any questions, feel free to contact us.</p>

            <p>Thank you for choosing us!</p>

            <p>Best regards,<br>
            Motiwala</p>
            <p>Mob: +91 9920077780</p>';

        sendEmail($recipient, $subject, $body);
    }


// ------------------------------------------------ WATI MSG ----------------------------------------------------//

    public function wati_due_reminder($phone=null, $name=null, $installment_no=null, $plan_name=null, $amount=null, $due_date=null){
        $phone = $phone;
        $template_name = 'reminder';
        $dynmice = [
            [
                'name' => 'name',
                'value' => $name
            ],
            [
                'name' => 'allowbroadcast',
                'value' => $installment_no
            ],
            [
                'name' => 'attribute_1',
                'value' => 'Rs '.$amount
            ],
            [
                'name' => 'attribute_2',
                'value' => date('d-m-y', strtotime($due_date))
            ]
        ];

        $result = send_Whatsapp_Notification($phone,$template_name,$dynmice);
    }


    public function wati_over_due($phone=null, $name=null, $installment_no=null, $plan_name=null, $amount=null, $due_date=null){
        $phone = $phone;
        $template_name = 'overdue';
        $dynmice = [
            [
                'name' => 'name',
                'value' => $name
            ],
            [
                'name' => 'allowbroadcast',
                'value' => $installment_no
            ],
            [
                'name' => 'attribute_1',
                'value' => 'Rs '.$amount
            ],
            [
                'name' => 'attribute_2',
                'value' => date('d-m-y', strtotime($due_date))
            ]
        ];

        $result = send_Whatsapp_Notification($phone,$template_name,$dynmice);
    }


    public function wati_payment_success($phone=null, $name=null, $installment_no=null, $amount=null){
        $phone = $phone;
        $template_name = 'payment_success';
        $dynmice = [
            [
                'name' => 'name',
                'value' => $name
            ],
            [
                'name' => 'attribute_1',
                'value' => $installment_no
            ],
            [
                'name' => 'attribute_2',
                'value' => 'Rs '.$amount
            ]
        ];

        $result = send_Whatsapp_Notification($phone,$template_name,$dynmice);
    }

    public function wati_registration_success($phone=null){
        $phone = $phone;
        $template_name = 'successful_registration';
        $dynmice = [
            [
                'name' => 'attribute_1',
                'value' => $phone
            ],
            [
                'name' => 'attribute_2',
                'value' => $phone
            ]
        ];

        $result = send_Whatsapp_Notification($phone,$template_name,$dynmice);
    }

    public function wati_incomplete_registration($phone=null, $name=""){
        $phone = $phone;
        $template_name = 'incomplete_registration';
        $dynmice = [
            [
                'name' => 'name',
                'value' => $name
            ]
        ];

        $result = send_Whatsapp_Notification($phone,$template_name,$dynmice);
    }

//----------------------------------------- incompleted registration config --------------------------------------//


public function incomplete_registration_msg()
{
    // Get the current date and time
    $currentDateTime = Carbon::now()->format('Y-m-d H');
    echo $currentDateTime;
    echo "<pre>";

    DB::table('users')
        ->select([
            'id',
            'fullname',
            'email',
            'phone',
            'updated_at'
        ])
        ->whereNull('status')
        ->whereNotNull('email')
        ->whereNotNull('phone')
        ->where('role_id', 0)
        ->orderBy('id', 'desc')
        ->chunk(5, function ($users) use ($currentDateTime) {
            foreach ($users as $user) {

                // 2 hours before the current time
                $after2Hr = Carbon::now()->subHours(2)->format('Y-m-d H');
                // echo $after2Hr;
                // echo "<pre>";
                // echo Carbon::parse($user->updated_at)->format('Y-m-d H');
                // echo "<pre>";
                // echo $user->id;
                // echo "<pre>";

                if ($after2Hr == Carbon::parse($user->updated_at)->addHours(2)->format('Y-m-d H')) {
                    echo "2 hours after: " . $user->email . ' ' . $user->id;
                    echo "<pre>";


                    $this->email_registration_not_completed($user->fullname, $user->email);
                    $this->wati_incomplete_registration($user->phone, $user->fullname);
                }

                // 1 day before the current time
                $after1Day = Carbon::now()->subDay(1)->format('Y-m-d H');

                if ($after1Day == Carbon::parse($user->updated_at)->format('Y-m-d H')) {
                    echo "After 1 day reminder: " . $user->email . ' ' . $user->id;
                    echo "<pre>";

                    $this->email_registration_not_completed($user->fullname, $user->email);
                    $this->wati_incomplete_registration($user->phone, $user->fullname);
                }
            }
        });
}


//---------------------------------------------- deu msg config -------------------------------------------------//


    public function due_msg(){

        $currentDate = Carbon::now()->format('Y-m-d');
        echo $currentDate;
        echo "<pre>";

        DB::table('redemption_items')
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
            ->orderBy('redemption_items.id')
            ->chunk(5, function ($info) use ($currentDate) {
                foreach ($info as $row) {
                    $dueStart = Carbon::parse($row->due_start);
                    $dueEnd = Carbon::parse($row->due_end);

                    // 7 days before due date start
                    $before7Days = $dueStart->copy()->subDays(7)->format('Y-m-d');
                    if ($currentDate == $before7Days) {
                        echo "7 days reminder: " . $row->email . ' ' . $row->id;
                        echo "<pre>";
                        $days = 7;
                        $this->email_before_Days($row->email, $row->installment_no, $row->plan_name, $row->fullname, $dueStart, $days, $row->installment_amount);

                        $this->wati_due_reminder($row->phone, $row->fullname, $row->installment_no, $row->plan_name, $row->installment_amount, $dueStart);
                    }

                    // 3 days before due date start
                    $before3Days = $dueStart->copy()->subDays(3)->format('Y-m-d');
                    if ($currentDate == $before3Days) {
                        echo "3 days reminder: " . $row->email . ' ' . $row->id;
                        echo "<pre>";
                        $days = 3;
                        $this->email_before_Days($row->email, $row->installment_no, $row->plan_name, $row->fullname, $dueStart, $days, $row->installment_amount);

                        $this->wati_due_reminder($row->phone, $row->fullname, $row->installment_no, $row->plan_name, $row->installment_amount, $dueStart);
                    }

                    // Between due date start and end
                    if (Carbon::parse($currentDate)->between($dueStart, $dueEnd)) {
                        echo "Due between start and end: " . $row->email . ' ' . $row->id;
                        echo "<pre>";
                        $days = 'same_day';
                        $due_date_end = $dueEnd;
                        $this->email_before_Days($row->email, $row->installment_no, $row->plan_name, $row->fullname, $dueStart, $days, $row->installment_amount, $due_date_end);

                        $this->wati_due_reminder($row->phone, $row->fullname, $row->installment_no, $row->plan_name, $row->installment_amount, $due_date_end);
                    }

                    // 1 day after due date end
                    $afterDueEnd = $dueEnd->copy()->addDay()->format('Y-m-d');
                    if ($currentDate == $afterDueEnd) {
                        echo "1 day after due end: " . $row->email . ' ' . $row->id;
                        echo "<pre>";
                        $days = 'passed';
                        $due_date_end = $dueEnd;

                        $this->email_before_Days($row->email, $row->installment_no, $row->plan_name, $row->fullname, $dueStart, $days, $row->installment_amount, $due_date_end);

                        $this->wati_over_due($row->phone, $row->fullname, $row->installment_no, $row->plan_name, $row->installment_amount, $due_date_end);
                    }
                }
            });
    }


    public function email_before_Days($email, $installment, $plan, $name, $due_date, $days="", $amount, $due_date_end=""){

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

        if($days != 'same_day' && $days !="" && $due_date_end == ""){
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
                Mob: '.env('COMPANY_NUMBER').'</p>
            ';
        } elseif($days == 'same_day' && $due_date_end != "" ){
            $body = '
                <p>Dear '.$name.',</p>
                <p>We hope this message finds you well.</p>

                <p>This is a friendly reminder that your payment for Installment Plan <strong>'.$plan.'</strong>, Installment No. <strong>'.$installment.'</strong>, is currently due and must be completed by <strong>'.$due_date_end.'</strong>.</p>

                <p>Please make your payment as soon as possible to avoid any late fees or interruptions.</p>
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
                Mob: '.env('COMPANY_NUMBER').'</p>
            ';
        } elseif ($days == 'passed' && $due_date_end != ""){
            $body = '
                <p>Dear '.$name.',</p>
                <p>We hope this message finds you well.</p>

                <p>This is a gentle reminder that your payment for Installment Plan <strong>'.$plan.'</strong>, Installment No. <strong>'.$installment.'</strong>, was due on <strong>'.$due_date_end.'</strong> and is now overdue.</p>

                <p>We kindly request that you make the payment as soon as possible to avoid any further penalties or interruptions to your service.</p>

                <p>Please make your payment as soon as possible to avoid any late fees or interruptions.</p>
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
                Mob: '.env('COMPANY_NUMBER').'</p>
            ';
        }


        sendEmail($recipient, $subject, $body);
    }
    
    

}