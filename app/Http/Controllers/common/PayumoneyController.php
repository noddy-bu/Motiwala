<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Common\SmsController;
use Auth;

use Illuminate\Http\Request;

class PayumoneyController extends Controller
{
    const TEST_URL = 'https://test.payu.in';
    //const TEST_URL = 'https://sandboxsecure.payu.in';
    const PRODUCTION_URL = 'https://secure.payu.in';

    public function create_payumoney_installment(request $request, $order_id)
    {
        if($order_id)
        {
            $order = DB::table('temp_transactions')->where('id', $order_id)->where('payment_status', 'created')->first();
            if($order)
            {
                $data = $request->all();
                $MERCHANT_KEY = env('PAYU_MERCHANT_KEY');
                $SALT = env('PAYU_SALT_KEY');
        
                $PAYU_BASE_URL = env('PAYU_TEST_MODE') ? self::TEST_URL : self::PRODUCTION_URL;
                $action = '';
        
                $posted = array();
                if (!empty($data)) {
                    foreach ($data as $key => $value) {
                        $posted[$key] = $value;
                    }
                }
        
                $formError = 0;

                $txnid = $order->payment_id;

                $hash = '';
                // Hash Sequence
                $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
                if (empty($posted['hash']) && sizeof($posted) > 0) {
                    if (
                        empty($posted['key'])
                        || empty($posted['txnid'])
                        || empty($posted['amount'])
                        || empty($posted['firstname'])
                        || empty($posted['email'])
                        || empty($posted['phone'])
                        || empty($posted['productinfo'])
                        || empty($posted['surl'])
                        || empty($posted['furl'])
                        || empty($posted['service_provider'])
                    ) {
                        $formError = 1;
                    } else {
                        $hashVarsSeq = explode('|', $hashSequence);
                        $hash_string = '';
                        foreach ($hashVarsSeq as $hash_var) {
                            $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
                            $hash_string .= '|';
                        }
        
                        $hash_string .= $SALT;
        
        
                        $hash = strtolower(hash('sha512', $hash_string));
                        $action = $PAYU_BASE_URL.'/_payment';
        
                    }
                } elseif (!empty($posted['hash'])) {
                    $hash = $posted['hash'];
                    $action = $PAYU_BASE_URL.'/_payment';
        
                }
                
                $updateOrder = DB::table('temp_transactions')->where('id', $order->id)->update([
                    'pum_hash' => $hash,
                    'temp_user_id' => auth()->user()->id
                ]);
        
                return view('frontend.payumoney.pay_installment', compact('hash', 'action', 'MERCHANT_KEY', 'formError', 'txnid', 'posted', 'SALT', 'order'));
            }
        }
    }


    public function payment_success_installment(Request $request){

        $input = $request->all();
        // $test = DB::table('transactions')->where('id', 1)->value('payment_response');
        // $input = json_decode($test, true);

        if(!$input) //redirect if no post
        {
            return redirect(url(''));
        }

        $status = $input["status"];
        $firstname = $input["firstname"];
        $amount = $input["amount"];
        $txnid = $input["txnid"];
        $posted_hash = $input["hash"];
        $key = $input["key"];
        $productinfo = $input["productinfo"];
        $email = $input["email"];
        $salt = config('payu.salt_key');


        $order = DB::table('temp_transactions')->where('payment_id', $txnid)->first();
        
        //avoid update if payment is paid
        if($order->payment_status == 'paid')
        {
            return redirect(url(''));
        }


        Auth::guard('web')->loginUsingId($order->temp_user_id);
    
        Session::put('user_id', $order->temp_user_id);
        
        $amount = $order->grand_total;

        //update order
        $transactions_id = DB::table('transactions')->insertGetId([
            'user_id' => $order->temp_user_id,
            'payment_id' => $txnid,
            'payment_amount' => $order->grand_total,
            'payment_response' => json_encode($input),
            'payment_type' => 'payu',
            'payment_status' => 'paid',
            'ip_data'        => $order->ip_data,
            'location'       => $order->location,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $redemption = DB::table('redemptions')
            ->where('user_id', $order->temp_user_id)
            ->where('status', 1)
            ->first(['id','plan_id']);
    
        if ($redemption) {
            // Fetch the redemption item
            $redemption_items = DB::table('redemption_items')
                ->where('redemption_id', $redemption->id)
                ->where('status', 'pending')
                ->first(['id', 'due_date_start', 'due_date_end', 'installment_no']);
        
            if ($redemption_items) {
                // $currentDate = Carbon::now()->format('Y-m-d');
        
                // // Check if the current date lies between due_date_start and due_date_end
                // if (Carbon::parse($currentDate)->between(Carbon::parse($redemption_items->due_date_start), Carbon::parse($redemption_items->due_date_end))) {

                //     $plan_receivable_percentage = DB::table('plans')->where('id', $redemption->plan_id)->value('receivable_percentage_on_time');

                //     $percentage = $plan_receivable_percentage;
                //     $additionalAmount = ($amount * $percentage) / 100;
                //     $totalAmount = $amount + $additionalAmount;

                //     DB::table('redemption_items')->where('id', $redemption_items->id)->update([
                //         'transaction_id' => $transactions_id,
                //         'receivable_amount' => $totalAmount,
                //         'status' => 'paid',
                //         'receipt_date' => Carbon::now()->format('Y-m-d H:i:s'),
                //     ]);

                // } else {

                //     DB::table('redemption_items')->where('id', $redemption_items->id)->update([
                //         'transaction_id' => $transactions_id,
                //         'receivable_amount' => $amount,
                //         'status' => 'paid',
                //         'remarks' => 'penalty for late payment of installment',
                //         'receipt_date' => Carbon::now()->format('Y-m-d H:i:s'),
                //     ]);

                // }

                // Get the current date
                $currentDate = Carbon::now()->format('Y-m-d');

                // Parse the due date start and end
                $dueDateStart = Carbon::parse($redemption_items->due_date_start);
                $dueDateEnd = Carbon::parse($redemption_items->due_date_end);

                // Check if the current date is less than the due date start or between the due date start and end
                if ($currentDate < $dueDateStart->format('Y-m-d') || Carbon::parse($currentDate)->between($dueDateStart, $dueDateEnd)) {
                    // Get the receivable percentage on time from the plans table
                    $planReceivablePercentage = DB::table('plans')->where('id', $redemption->plan_id)->value('receivable_percentage_on_time');
                    
                    // Calculate the additional amount
                    $additionalAmount = ($amount * $planReceivablePercentage) / 100;
                    $totalAmount = $amount + $additionalAmount;

        

                    // Update the redemption items table
                    DB::table('redemption_items')->where('id', $redemption_items->id)->update([
                        'transaction_id' => $transactions_id,
                        'receivable_amount' => $totalAmount,
                        'receivable_gold' => gold_amount($totalAmount),
                        'status' => 'paid',
                        'receipt_date' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);
                } else {
                    // Update the redemption items table with penalty remarks
                    DB::table('redemption_items')->where('id', $redemption_items->id)->update([
                        'transaction_id' => $transactions_id,
                        'receivable_amount' => $amount,
                        'receivable_gold' => gold_amount($amount),
                        'status' => 'paid',
                        'remarks' => 'penalty for late payment of installment',
                        'receipt_date' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);
                }

                $installment = $redemption_items->installment_no;

                $plan_period = DB::table('plans')->where('id', $redemption->plan_id)->value('installment_period');

                $plan_period = (int) $plan_period;

                if($installment != $plan_period){
                    // Update the next installment to pending
                    $next = $redemption_items->installment_no + 1;
                    DB::table('redemption_items')
                        ->where('redemption_id', $redemption->id)
                        ->where('installment_no', $next)
                        ->update(['status' => 'pending']);
                }
        



            } else {
                session()->flash('toastr', [
                    'type' => 'error',
                    'message' => 'Somthing went wrong',
                    'title' => 'error'
                ]);
            }

        } else{
            session()->flash('toastr', [
                'type' => 'error',
                'message' => 'Plan has been Expire',
                'title' => 'error'
            ]);
        }

        /*------------ success stuff --------------*/

        session()->flash('toastr', [
            'type' => 'success',
            'message' => 'Installment Paid Successfully',
            'title' => 'Success'
        ]);

        if ($installment == 1) {
            $installment .= 'st';
        } elseif ($installment == 2) {
            $installment .= 'nd';
        } elseif ($installment == 3) {
            $installment .= 'rd';
        } else {
            $installment .= 'th';
        }

        $phone = DB::table('users')->where('id', $order->temp_user_id)->value('phone');

    
        $sms = (new SmsController)->smsgatewayhub_installment_payment_successful($phone, $installment, $amount);

        $email_templet = (new SmsController)->email_installment_payment_successful($email, $installment, $amount);

        // delete temp recored
        DB::table('temp_transactions')->where('payment_id', $txnid)->delete();

        return redirect()->route('pay-installments');

    }


    public function payment_cancel_installment(Request $request){

        $data = $request->all();

        if(!$data) //redirect if no post
        {
            return redirect(url(''));
        } 		
		
        $validHash = true;
		$txnid = $data["txnid"];

        $order = DB::table('temp_transactions')->where('payment_id', $txnid)->first();

		
        if (!$validHash) {
            echo "Invalid Transaction. Please try again";
        } else {

            
    
            Auth::guard('web')->loginUsingId($order->temp_user_id);
    
            Session::put('user_id', $order->temp_user_id);

            $updateOrder = DB::table('temp_transactions')
            ->where('payment_id', $txnid)
            ->update([
                'payment_status' => 'unpaid',
                'payment_response' => json_encode($data),
                'updated_at' => date('Y-m-d H:i:s')
            ]);			
        }

        $temp_user = DB::table('temp_transactions')->where('payment_id', $txnid)->first(['temp_user_id']);

        //fresh order info
        $errorMessage = $data['error_Message'];   

        $temp_user_id = $temp_user ? $temp_user->temp_user_id : 0;

        return view('frontend.payumoney.fail_installment', compact('errorMessage','data','temp_user_id'));

        

    }

}