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
        // $draw = $request->get('draw');
        // $start = $request->get('start');
        // $rowperpage = $request->get('length');
        // $order = $request->get('order')[0]['column'];
        // $dir = $request->get('order')[0]['dir'];
    
        // // Columns
        // $columns = array(
        //     0 => 'id',
        //     1 => 'name',
        //     2 => 'email',
        //     3 => 'mobile no',
        //     // 4 => 'status',
        //     4 => 'created_at'
        // );
    
        // // Total records
        // $totalRecords = User::whereNotIn('users.role_id', ['1', '2', '3'])->count();
    
        // // Filtered records

        // // $query = User::select('users.*','r.status as plan_Status')
        // //     ->leftJoin(DB::raw('(SELECT * FROM redemptions WHERE id IN (SELECT MAX(id) FROM redemptions GROUP BY user_id)) as r'), 'r.user_id', '=', 'users.id')
        // //     ->whereNotIn('users.role_id', ['1', '2', '3']);

        // // $query = User::select('users.*','r.status as plan_Status')
        // //     ->leftJoin(DB::raw('(SELECT * FROM redemptions WHERE id IN (SELECT MAX(id) FROM redemptions GROUP BY user_id)) as r'), 'r.user_id', '=', 'users.id')
        // //     ->whereNotIn('users.role_id', ['1', '2', '3']);

        // $query = User::whereNotIn('users.role_id', ['1', '2', '3'])
        // ->leftJoin('redemptions', 'users.id', '=', 'redemptions.user_id')
        // ->leftJoin('plans', 'redemptions.plan_id', '=', 'plans.id')
        // ->select('users.id', 'users.fullname', 'users.email', 'users.phone', 'users.status', 'users.created_at',
        //     DB::raw("GROUP_CONCAT(plans.name ORDER BY redemptions.plan_id SEPARATOR ', ') as plan_names"),
        //     DB::raw("GROUP_CONCAT(redemptions.status SEPARATOR ', ') as plan_status")
        // )
        // ->groupBy('users.id', 'users.fullname', 'users.email', 'users.phone', 'users.status', 'users.created_at');


        // // Filtered records
        // $searchValue = $request->input('search.value');
        // if (!empty($searchValue)) {
        //     $query->where(function($q) use ($searchValue) {
        //         $q->where('users.fullname', 'like', "%$searchValue%")
        //             // ->orWhere('users.last_name', 'like', "%$searchValue%")
        //             ->orWhere('users.email', 'like', "%$searchValue%")
        //             ->orWhere('users.phone', 'like', "%$searchValue%");
        //     });
        // }
    
        // // Filter by additional form parameters
        // // $name = $request->input('name');
        // // if (!empty($name)) {
        // //     $query->where(function($q) use ($name) {
        // //         $q->where('users.first_name', 'like', "%$name%")
        // //             ->orWhere('users.last_name', 'like', "%$name%");
        // //     });
        // // }

        // $name = $request->input('name');
        // if (!empty($name)) {
        //     $query->where('users.fullname', 'like', "%$name%");
        // }

        // $email = $request->input('email');
        // if (!empty($email)) {
        //     $query->where('users.email', 'like', "%$email%");
        // }

        // $phone = $request->input('phone');
        // if (!empty($phone)) {
        //     $query->where('users.phone', 'like', "%$phone%");
        // }

        // $status = $request->input('status');
        // if ($status != '') {
        //     if ($status !== 'null') { // Check if $status is not the string 'null'
        //         $query->where('r.status', $status);
        //     } else {
        //         $query->whereNull('users.status'); // Use whereNull to check for NULL in the 'users.status' column
        //     }
        // }
    
        // // Get filtered count
        // $totalFiltered = $query->count();
    
        // // Order
        // $query->orderBy($columns[$order], $dir);
    
        // // Get records with pagination
        // $records = $query->offset($start)
        //                 ->limit($rowperpage)
        //                 ->get();
    

        // // Prepare data
        // $data = [];
        // $i = 1;
        // foreach ($records as $row) {

        //     // if($row->status == 1){
        //     //     $tran = '<a href="javascript:void(0);" class="action-icon" onclick="largeModal(\''.route('Customer.transaction', ['id' => $row->id]).'\', \'Customer Installment\')"> <i class="ri-wallet-line" title="Installment"></i></a>';
        //     // } else {
        //     //     $tran = null;
        //     // }


        //     if($row->status == 1){
        //         $tran = '<a href="javascript:void(0);" class="action-icon" onclick="largeModal(\''.route('Customer.transaction', ['id' => $row->id]).'\', \'Customer Installment\')"> <i class="ri-wallet-line" title="Installment"></i></a>';
        //     } else {
        //         $tran = null;
        //     }

        //     // if(!is_null($row->plan_id) && !empty($row->plan_id)){
        //     //     $plan_name = DB::table('plans')->where('id',$row->plan_id)->value('name');
        //     // } else {
        //     //     $plan_name = null;
        //     // }

        //     // if($row->plan_Status === 1){
        //     //     $plan_status = '<span class="badge bg-primary">In Progress</span>';
        //     // } elseif ($row->plan_Status === 0) {
        //     //     $plan_status = '<span class="badge bg-success">Completed</span>';
        //     // } else {
        //     //     $plan_status = '<span class="badge bg-danger">Inactive</span>';
        //     // }
            

        //     $planNames = explode(', ', $row->plan_names);
        //     $planStatuses = explode(', ', $row->plan_status);
            
        //     // Combine plan names and statuses
        //     $combinedPlans = [];

        //     if(!empty($row->plan_names)){
        //         foreach ($planNames as $index => $planName) {
        //             $status = isset($planStatuses[$index]) ? $planStatuses[$index] : 'null'; // Default to 'null' if no status is available
                
        //             // Conditional HTML based on status
        //             $statusHtml = $status == '1' ? '<span class="badge bg-primary">In Progress</span>' : '<span class="badge bg-success">Completed</span>';
                
        //             $combinedPlans[] = "$planName: $statusHtml";
        //         }
        //     }

        //     // Check if $combinedPlans is empty
        //     if (!empty($combinedPlans)) {
        //         $plan_details = implode(', ', $combinedPlans);
        //     } else {
        //         $plan_details = '<span class="badge bg-danger">Inactive</span>';
        //     }
            
        //     $nestedData = [
        //         'id' => $i++,
        //         // 'name' => $row->first_name.' '.$row->last_name,
        //         'name' => $row->fullname,
        //         'email' => $row->email,
        //         'phone' => $row->phone,
        //         'plan'  => $plan_details,
        //         // 'status' => $row->plan_status,
        //         'created_at' => $row->created_at->format('Y-m-d H:i:s'),
        //         'action' => //'<a href="'.route('Customer.status', ['id' => $row->id, 'status' => $row->status ? 0 : 1]).'" class="action-icon">'.
        //         //                 '<i class="'.($row->status ? 'ri-eye-off-fill' : 'ri-eye-fill').'" title="'.($row->status ? 'Inactive' : 'Active').'"></i>'.
        //         //             '</a>'.
        //                     '<a href="javascript:void(0);" class="action-icon" onclick="largeModal(\''.route('Customer.edit', ['id' => $row->id]).'\', \'Privew Customer\')"> <i class="ri-eye-fill" title="Privew"></i></a>'.
        //                     $tran
        //                     // '<!--<a href="javascript:void(0);" class="action-icon" onclick="confirmModal(\''.route('Customer.delete', $row->id).'\', responseHandler)"><i class="mdi mdi-delete" title="Delete"></i></a>-->'
        //     ];
    
        //     $data[] = $nestedData;
        // }
    
        // // JSON response
        // $response = array(
        //     "draw" => intval($draw),
        //     "recordsTotal" => intval($totalRecords),
        //     "recordsFiltered" => intval($totalFiltered),
        //     "data" => $data
        // );
    
        // return response()->json($response);
    
        // //return response()->json($json_data);


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
            3 => 'phone',
            4 => 'created_at'
        );
    
        // Total records
        $totalRecords = User::whereNotIn('users.role_id', ['1', '2', '3'])->count();
    
        $query = User::whereNotIn('users.role_id', ['1', '2', '3'])
            ->leftJoin('redemptions', 'users.id', '=', 'redemptions.user_id')
            ->leftJoin('plans', 'redemptions.plan_id', '=', 'plans.id')
            ->select('users.id', 'users.fullname', 'users.email', 'users.phone', 'users.status', 'users.created_at',
                DB::raw("GROUP_CONCAT(plans.name ORDER BY redemptions.plan_id SEPARATOR ', ') as plan_names"),
                DB::raw("GROUP_CONCAT(redemptions.status SEPARATOR ', ') as plan_status")
            )
            ->groupBy('users.id', 'users.fullname', 'users.email', 'users.phone', 'users.status', 'users.created_at');
    
        // Filtered records
        $searchValue = $request->input('search.value');
        if (!empty($searchValue)) {
            $query->where(function($q) use ($searchValue) {
                $q->where('users.fullname', 'like', "%$searchValue%")
                    ->orWhere('users.email', 'like', "%$searchValue%")
                    ->orWhere('users.phone', 'like', "%$searchValue%");
            });
        }
    
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
            if ($status !== 'null') { // Check if $status is not the string 'null'
                $query->where('redemptions.status', $status);
            } else {
                $query->whereNull('users.status'); // Use whereNull to check for NULL in the 'users.status' column
            }
        }
    
        // Order
        $query->orderBy($columns[$order], $dir);
    
        // Paginate results
        $records = $query->paginate($rowperpage, ['*'], 'page', $start / $rowperpage + 1);
        
        // Prepare data
        $data = [];
        // Calculate the starting serial number for the current page
        $startSerial = $records->firstItem();

        foreach ($records as $index => $row) {

            $serialNumber = $startSerial + $index;

            $tran = $row->status == 1
                ? '<a href="javascript:void(0);" class="action-icon" onclick="largeModal(\''.route('Customer.list_account', ['id' => $row->id, 'view' => 0]).'\', \'Customer Installment\')"> <i class="ri-wallet-line" title="Installment"></i></a>'
                : null;
    
            $planNames = explode(', ', $row->plan_names);
            $planStatuses = explode(', ', $row->plan_status);
            
            // Combine plan names and statuses
            $combinedPlans = [];
            if (!empty($row->plan_names)) {
                foreach ($planNames as $index => $planName) {
                    $status = isset($planStatuses[$index]) ? $planStatuses[$index] : 'null'; // Default to 'null' if no status is available
                
                    // Conditional HTML based on status
                    $statusHtml = $status == '1' ? '<span class="badge bg-primary">In Progress</span>' : '<span class="badge bg-success">Completed</span>';
                
                    $combinedPlans[] = "$planName: $statusHtml";
                }
            }


            if (!empty($row->plan_names)) {
                $list = '<a href="javascript:void(0);" class="action-icon" onclick="largeModal(\''.route('Customer.list_account', ['id' => $row->id, 'view' => 1]).'\', \'List Account\')"> <i class="ri-eye-fill" title="Preview"></i></a>';
            } else {
                $list = '<a href="javascript:void(0);" class="action-icon" onclick="largeModal(\''.route('Customer.edit', ['id' => $row->id]).'\', \'Preview Customer\')"> <i class="ri-eye-fill" title="Preview"></i></a>';
            }
    
            $plan_details = !empty($combinedPlans)
                ? implode(', ', $combinedPlans)
                : '<span class="badge bg-danger">Incomplete</span>';
            
            $nestedData = [
                'id' => $serialNumber,
                'name' => $row->fullname,
                'email' => $row->email,
                'phone' => $row->phone,
                'plan' => $plan_details,
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                'action' => $list . $tran
            ];
    
            $data[] = $nestedData;
        }
    
        // JSON response
        $response = [
            "draw" => intval($draw),
            "recordsTotal" => intval($totalRecords),
            "recordsFiltered" => intval($records->total()),
            "data" => $data
        ];
    
        return response()->json($response);

    }

    public function list_account($id, Request $request) {

        $view = $request->query('view');
        
        $info = DB::table('redemptions')
        ->select('redemptions.*', 'plans.name as plan_name')
        ->leftJoin('plans', 'redemptions.plan_id', '=', 'plans.id')
        ->where('redemptions.user_id', $id)
        ->orderBy('redemptions.id', 'desc')
        ->get();
        
        return view('backend.pages.customer.list_account', compact('info','view'));
    }

  
    public function edit($id, Request $request) {
        // Fetch user based on the given ID
        $user = User::find($id);
        $plan_id = $user->plan_id;

        $installment_amount = null;
        $esign = null;
    
        // Check if a transaction ID is passed in the request
        $transactionId = $request->query('transaction_id');
    
        if ($transactionId !== null) {
            // Fetch the plan_id associated with the given transaction ID
            $redemption = DB::table('redemptions')
                ->where('id', $transactionId)
                ->select('plan_id','esign')
                ->first();

            $redemption_items = DB::table('redemption_items')
                ->where('redemption_id', $transactionId)
                ->select('installment_amount')
                ->first();
    
            if ($redemption) {
                $plan_id = $redemption->plan_id;
                $installment_amount = $redemption_items->installment_amount;
                $esign = $redemption->esign;
            }
        }
    
        // Fetch user details and plan name
        $user_detail = DB::table('userdetails')->where('user_id', $id)->first();
        $plan_name = DB::table('plans')->where('id', $plan_id)->value('name');
    
        // Return the view with the fetched data
        return view('backend.pages.customer.edit', compact('user', 'user_detail', 'plan_name','installment_amount','esign'));
    }
    

    public function transaction($id, Request $request) {

        $transactionId = $request->query('transaction_id');
    
        if ($transactionId !== null) {
            // Fetch the plan_id associated with the given transaction ID
            $redemption = DB::table('redemptions')
                ->where('id', $transactionId)
                ->select('plan_id')
                ->first();
    
            if ($redemption) {
                $plan_id = $redemption->plan_id;
            }
        }
        
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
            'redemptions.plan_id as close_planid',
            'redemptions.status',
            'redemptions.closing_remark',
            'redemptions.closing_amount',
            'redemptions.closing_date',
            'redemptions.created_at as redemptions_created_at',
            'redemptions.id as redemptions_id',
        ])
        ->join('plans', 'users.plan_id', '=', 'plans.id')
        ->join('redemptions', 'users.id', '=', 'redemptions.user_id')
        ->where('users.id',$id)
        ->where('redemptions.plan_id', $plan_id)
        // ->orderBy('redemptions.id', 'desc')
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
    
    public function close_plan_form($id, Request $request) {

        $redemptionsId = $request->query('redemptions_id');
    

        $info = DB::table('users')
        ->select([
            'redemptions.id',
            'redemptions.user_id',
            'redemptions.plan_id',
            'redemptions.maturity_date_start',
            'redemptions.maturity_date_end',
            'redemptions.status',
            'redemptions.closing_remark',
            'redemptions.closing_date',
        ])
        ->join('plans', 'users.plan_id', '=', 'plans.id')
        ->join('redemptions', 'users.id', '=', 'redemptions.user_id')
        ->where('users.id',$id)
        ->where('redemptions.id', $redemptionsId)
        ->where('redemptions.status', 1)
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
        $redemptionsid = $request->input('redemptionsid');

        DB::table('redemptions')->where('user_id',$id)->where('id',$redemptionsid)->update([
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

        $ip = ip_info();
        $ip_data = json_decode($ip, true); 

        //update order
        $transactions_id = DB::table('transactions')->insertGetId([
            'user_id' => $request->user_id,
            'payment_id' => $request->transaction_id,
            'payment_amount' => $amount,
            'payment_response' => json_encode($data),
            'payment_type' => $request->payment_method,
            'payment_status' => 'paid',
            'ip_data'        => $ip,
            'location'       => $ip_data['city'] ?? '-',
            'user_behalf'    => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $redemption = DB::table('redemptions')
            ->where('user_id', $request->user_id)
            ->where('status', 1)
            ->first(['id','plan_id']);
    
        if ($redemption) {
            // Fetch the redemption item
            // $redemption_items = DB::table('redemption_items')
            //     ->where('redemption_id', $redemption->id)
            //     ->where('status', 'pending')
            //     ->first(['id', 'due_date_start', 'due_date_end', 'installment_no']);

            $redemption_items = DB::table('redemption_items')
                ->where('id', $request->redemption_items_id)
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
                        'status' => auth()->user()->id == 1 ? 'paid' : 'request_approval', // Use a ternary operator for condition
                        'receipt_date' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);
                } else {
                    // Update the redemption items table with penalty remarks
                    DB::table('redemption_items')->where('id', $redemption_items->id)->update([
                        'transaction_id' => $transactions_id,
                        'receivable_amount' => $amount,
                        'receivable_gold' => gold_amount($amount),
                        'status' => auth()->user()->id == 1 ? 'paid' : 'request_approval', // Use a ternary operator for condition
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

        $phone_email = DB::table('users')->where('id', $request->user_id)->select('phone', 'email', 'fullname')->first();
    
        $sms = (new SmsController)->smsgatewayhub_installment_payment_successful($phone_email->phone, $installment, $amount);

        $email_templet = (new SmsController)->email_installment_payment_successful($phone_email->email, $installment, $amount);

        $wati_payment_success = (new SmsController)->wati_payment_success($phone_email->phone, $phone_email->fullname, $installment, $amount);

        $response = [
            'status' => true,
            'notification' => 'Manual Payment Installment successfully!',
        ];

        return response()->json($response);

    }
    

}
