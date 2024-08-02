<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Transaction;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Common\SmsController;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function index() {
        return view('backend.pages.customer.index');
    }

    public function getData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get('length');
        $order = $request->get('order')[0]['column'];
        $dir = $request->get('order')[0]['dir'];
    
        // Columns
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'mobile no',
            4 => 'status',
            5 => 'created_at'
        );
    
        // Total records
        $totalRecords = User::count();
    
        // Filtered records
        $query = User::select('users.*','r.status as plan_Status')
            ->leftJoin('redemptions as r', 'r.user_id', '=', 'users.id')
            ->where('users.role_id', '!=', 1);
    
        // Filtered records
        $searchValue = $request->input('search.value');
        if (!empty($searchValue)) {
            $query->where(function($q) use ($searchValue) {
                $q->where('users.fullname', 'like', "%$searchValue%")
                    // ->orWhere('users.last_name', 'like', "%$searchValue%")
                    ->orWhere('users.email', 'like', "%$searchValue%")
                    ->orWhere('users.phone', 'like', "%$searchValue%");
            });
        }
    
        // Filter by additional form parameters
        // $name = $request->input('name');
        // if (!empty($name)) {
        //     $query->where(function($q) use ($name) {
        //         $q->where('users.first_name', 'like', "%$name%")
        //             ->orWhere('users.last_name', 'like', "%$name%");
        //     });
        // }

        $name = $request->input('name');
        if (!empty($name)) {
            $query->where('users.fullname', 'like', "%$name%");
        }

        $email = $request->input('email');
        if (!empty($email)) {
            $query->where('users.email', 'like', "%$email%");
        }

        $phone = $request->input('phone');
        if (!empty($phone)) {
            $query->where('users.phone', 'like', "%$phone%");
        }

        $status = $request->input('status');
        if ($status != '') {
            $query->where('r.status', $status);
        }
    
        // Get filtered count
        $totalFiltered = $query->count();
    
        // Order
        $query->orderBy($columns[$order], $dir);
    
        // Get records with pagination
        $records = $query->offset($start)
                        ->limit($rowperpage)
                        ->get();
    

        // Prepare data
        $data = [];
        $i = 1;
        foreach ($records as $row) {

            if($row->status == 1){
                $tran = '<a href="javascript:void(0);" class="action-icon" onclick="largeModal(\''.route('Customer.transaction', ['id' => $row->id]).'\', \'Customer Installment\')"> <i class="ri-wallet-line" title="Installment"></i></a>';
            } else {
                $tran = null;
            }


            if($row->plan_Status === 1){
                $plan_status = '<span class="badge bg-success">In Progress</span>';
            } elseif ($row->plan_Status === 0) {
                $plan_status = '<span class="badge bg-primary">Completed</span>';
            } else {
                $plan_status = '<span class="badge bg-danger">Inactive</span>';
            }

            $nestedData = [
                'id' => $i++,
                // 'name' => $row->first_name.' '.$row->last_name,
                'name' => $row->fullname,
                'email' => $row->email,
                'phone' => $row->phone,
                'status' => $plan_status,
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                'action' => //'<a href="'.route('Customer.status', ['id' => $row->id, 'status' => $row->status ? 0 : 1]).'" class="action-icon">'.
                //                 '<i class="'.($row->status ? 'ri-eye-off-fill' : 'ri-eye-fill').'" title="'.($row->status ? 'Inactive' : 'Active').'"></i>'.
                //             '</a>'.
                            '<a href="javascript:void(0);" class="action-icon" onclick="largeModal(\''.route('Customer.edit', ['id' => $row->id]).'\', \'Privew Customer\')"> <i class="ri-eye-fill" title="Privew"></i></a>'.
                            $tran
                            // '<!--<a href="javascript:void(0);" class="action-icon" onclick="confirmModal(\''.route('Customer.delete', $row->id).'\', responseHandler)"><i class="mdi mdi-delete" title="Delete"></i></a>-->'
            ];
    
            $data[] = $nestedData;
        }
    
        // JSON response
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => intval($totalRecords),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
    
        return response()->json($response);
    
        //return response()->json($json_data);
    }

  
    public function edit($id) {
        $user = User::where('id',$id)->get()->first();
        $user_detail = DB::table('userdetails')->where('user_id', $id)->get()->first();
        $plan_name = DB::table('plans')->where('id', $user->plan_id)->value('name');
        return view('backend.pages.customer.edit', compact('user', 'user_detail', 'plan_name'));
    }

    public function transaction($id) {
        
        $info = DB::table('users')
        ->select([
            'redemptions.id',
            'users.created_at',
            'redemptions.user_id',
            'users.plan_id',
            'plans.name',
            'plans.installment_period',
            'redemptions.maturity_date_start',
            'redemptions.maturity_date_end',
            'redemptions.status',
            'redemptions.closing_remark',
            'redemptions.closing_date',
        ])
        ->join('plans', 'users.plan_id', '=', 'plans.id')
        ->join('redemptions', 'users.id', '=', 'redemptions.user_id')
        ->where('users.id',$id)
        ->get()->first();
        
        $transactions = DB::table('transactions')->where('user_id',$id)->where('payment_status','paid')->get();

        $redemption_items = DB::table('redemption_items')->where('redemption_id',$info->id)->get();

        //--closing amout
        $currentDate = Carbon::now()->format('Y-m-d');
        
        if (Carbon::parse($currentDate)->between(Carbon::parse($info->maturity_date_start), Carbon::parse($info->maturity_date_end))) {
            $total_amount_at_closing = $redemption_items->where('status', 'paid')->sum('receivable_amount');
        } else {
            $total_amount_at_closing = $redemption_items->where('status', 'paid')->sum('installment_amount');
        }
        //--closing amout

        return view('backend.pages.customer.transaction', compact('info','transactions','redemption_items','total_amount_at_closing'));
    }

    
    public function delete($id) {
        
        $User = User::find($id);
        $User->delete();

    
        $response = [
            'status' => true,
            'notification' => 'User deleted successfully!',
        ];

        return response()->json($response);
    }  
    
    public function status($id, $status) { 
        $User = User::find($id);
        $User->status = $status;
        $User->save();

        return redirect(route('Customer.index'))->with('success', 'Status changed successfully!');
    } 
    
    public function close_plan_form($id) {
        $info = DB::table('users')
        ->select([
            'redemptions.id',
            'redemptions.user_id',
            'users.plan_id',
            'redemptions.maturity_date_start',
            'redemptions.maturity_date_end',
            'redemptions.status',
            'redemptions.closing_remark',
            'redemptions.closing_date',
        ])
        ->join('plans', 'users.plan_id', '=', 'plans.id')
        ->join('redemptions', 'users.id', '=', 'redemptions.user_id')
        ->where('users.id',$id)
        ->get()->first();
        

        $redemption_items = DB::table('redemption_items')->where('redemption_id',$info->id)->get();

        //--closing amout
        $currentDate = Carbon::now()->format('Y-m-d');
        
        if (Carbon::parse($currentDate)->between(Carbon::parse($info->maturity_date_start), Carbon::parse($info->maturity_date_end))) {
            $total_amount_at_closing = $redemption_items->where('status', 'paid')->sum('receivable_amount');
        } else {
            $total_amount_at_closing = $redemption_items->where('status', 'paid')->sum('installment_amount');
        }
        //--closing amout
        return view('backend.pages.customer.closing_form', compact('info','redemption_items','total_amount_at_closing'));
    }

    public function close_plan(Request $request){
        $validator = Validator::make($request->all(), [
            'remark' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'notification' => $validator->errors()->all()
            ], 200);
        } 

        $id = $request->input('user_id');

        DB::table('redemptions')->where('user_id',$id)->update([
            'closing_date' => date('Y-m-d'),
            'closing_remark' => $request->input('remark'),
            'closing_amount' => $request->input('closing_amount'),
            'status' => 0,
        ]);

        $response = [
            'status' => true,
            'notification' => 'Plan Close successfully!',
        ];

        return response()->json($response);
    }


    public function manual_pay_form($id) {

        $redemption_items = DB::table('redemption_items')->where('id',$id)->get()->first();

        $user_id = DB::table('redemptions')->where('id',$redemption_items->redemption_id)->where('status',1)->value('user_id');

        //--closing amout
        $currentDate = Carbon::now()->format('Y-m-d');

        $dueDateStart = Carbon::parse($redemption_items->due_date_start);
        

        if ($currentDate < $dueDateStart->format('Y-m-d') || Carbon::parse($currentDate)->between(Carbon::parse($redemption_items->due_date_start), Carbon::parse($redemption_items->due_date_end))) {
            $pay_date = custom_date_change($redemption_items->due_date_start)." to ".custom_date_change($redemption_items->due_date_end);
        } else {
            $pay_date = custom_date_change($redemption_items->due_date_start)." to ".custom_date_change($redemption_items->due_date_end)." -- Penalty will be charged";
        }

        return view('backend.pages.customer.manual_pay_form', compact('redemption_items','pay_date','user_id'));
    }

    public function manual_payment(Request $request){
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required',
            'transaction_id' => [
                'nullable',
                Rule::unique('transactions', 'payment_id')
            ],
            'transaction_slip' => 'nullable|mimes:png,jpg,jpeg|max:2048', // 2048 KB = 2 MB
        ], [
            'payment_method.required' => 'The Payment Method is required.',
            'transaction_id.unique' => 'The Transaction ID has already been used.',
            'transaction_slip.mimes' => 'The Transaction Slip must be a file of type: png, jpg, jpeg.',
            'transaction_slip.max' => 'The Transaction Slip may not be greater than 2 MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'notification' => $validator->errors()->all()
            ], 200);
        }
        

        $amount = $request->amount;

        if($request->hasFile('transaction_slip')) {
            $file = $request->file('transaction_slip');
            // Remove spaces from the filename
            $filename = str_replace(' ', '_', $file->getClientOriginalName());
            // Store the file and get the path
            $path = $file->storeAs('transaction_Slip', $filename, 'public');
        } else {
            $path = null;
        }
        
        $data = [
            'user_id' => $request->user_id,
            'payment_id' => $request->transaction_id,
            'payment_amount' => $amount,
            'payment_type' => $request->payment_method,
            'transaction_Slip' => $path,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        //update order
        $transactions_id = DB::table('transactions')->insertGetId([
            'user_id' => $request->user_id,
            'payment_id' => $request->transaction_id,
            'payment_amount' => $amount,
            'payment_response' => json_encode($data),
            'payment_type' => $request->payment_method,
            'payment_status' => 'paid',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $redemption = DB::table('redemptions')
            ->where('user_id', $request->user_id)
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

                // $dueDateStart = Carbon::parse($redemption_items->due_date_start);
        
                // // Check if the current date lies between due_date_start and due_date_end
                // // if (Carbon::parse($currentDate)->between(Carbon::parse($redemption_items->due_date_start), Carbon::parse($redemption_items->due_date_end))) {

                // if ( $currentDate < $dueDateStart->format('Y-m-d') || Carbon::parse($currentDate)->between(Carbon::parse($redemption_items->due_date_start), Carbon::parse($redemption_items->due_date_end))) {

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
            'message' => 'Manual Installment Paid Successfully',
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

        $phone = DB::table('users')->where('id', $request->user_id)->value('phone');

        $email = DB::table('users')->where('id', $request->user_id)->value('email');

    
        $sms = (new SmsController)->smsgatewayhub_installment_payment_successful($phone, $installment, $amount);


        $email_templet = (new SmsController)->email_installment_payment_successful($email, $installment, $amount);

        $response = [
            'status' => true,
            'notification' => 'Manual Payment Installment successfully!',
        ];

        return response()->json($response);

    }
    

}
