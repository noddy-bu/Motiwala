<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TransactionApprovalController extends Controller
{
    public function index() {
        return view('backend.pages.approval.index');
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
            1 => 'pay_id',
            2 => 'name',
            3 => 'email',
            3 => 'phone',
            3 => 'installment',
            4 => 'amount',
            4 => 'transactionSlip',
            4 => 'type',
            4 => 'status',
            4 => 'location',
            4 => 'user_behalf',
            4 => 'created_at',
            4 => 'amount'
        );
    
        // Total records
        $totalRecords = DB::table('redemption_items')->where('status', '=', 'request_approval')->count();
    
        $query = DB::table('redemption_items as rt')
        ->leftJoin('redemptions as r', 'rt.redemption_id', '=', 'r.id')
        ->leftJoin('transactions as t', 'rt.transaction_id', '=', 't.id')
        ->leftJoin('users as u', 'r.user_id', '=', 'u.id') // Changed 'user.id' to 'u.id'
        ->leftJoin('users as ub', 't.user_behalf', '=', 'ub.id') 
        ->select('rt.id', 'rt.installment_no','t.payment_amount', 'rt.status as payment_status', 't.payment_id', 't.payment_type', 't.payment_response', 't.location', 't.created_at', 't.user_behalf', 'ub.fullname as user_behalf_fullname', 'u.fullname', 'u.email', 'u.phone')
        ->where('rt.status', '=', 'request_approval');
    
    
        // Filtered records
        $searchValue = $request->input('search.value');
        if (!empty($searchValue)) {
            $query->where(function($q) use ($searchValue) {
                $q->where('u.fullname', 'like', "%$searchValue%")
                    ->orWhere('u.email', 'like', "%$searchValue%")
                    ->orWhere('u.phone', 'like', "%$searchValue%");
            });
        }
    
        $name = $request->input('name');
        if (!empty($name)) {
            $query->where('u.fullname', 'like', "%$name%");
        }
    
        $email = $request->input('email');
        if (!empty($email)) {
            $query->where('u.email', 'like', "%$email%");
        }
    
        $phone = $request->input('phone');
        if (!empty($phone)) {
            $query->where('u.phone', 'like', "%$phone%");
        }

        $pay_id  = $request->input('pay_id');
        if (!empty($pay_id)) {
            $query->where('t.payment_id', 'like', "%$pay_id%");
        }
    
        $pay_amount = $request->input('pay_amount');
        if (!empty($pay_amount)) {
            $query->where('t.payment_amount', 'like', "%$pay_amount%");
        }

        $location = $request->input('location');
        if (!empty($location)) {
            $query->where('t.location', 'like', "%$location%");
        }

        $user_behalf = $request->input('user_behalf');
        if (!empty($user_behalf)) {
            $query->where('t.user_behalf', $user_behalf);
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
            
            $paymentResponse = json_decode($row->payment_response, true); 

            if (isset($paymentResponse['transaction_Slip'])) {
                $transactionSlip = $paymentResponse['transaction_Slip']; // Extract the transaction_Slip value
            } else {
                $transactionSlip = null; // Handle the case where transaction_Slip is not set
            }


            if ($row->payment_type == "payu") {
                $type = 'PayU';
            } elseif ($row->payment_type == "upipay") {
                $type = 'UPI';
            } elseif ($row->payment_type == "cashpay") {
                $type = 'Cash Pay';
            } elseif ($row->payment_type == "checkpay") {
                $type = 'Check Pay';
            }

            $approval = '<a href="javascript:void(0);" class="action-icon" onclick="confirmModal(\''.route('approvaltransaction.conform', $row->id).'\', responseHandler)"><i class="ri-check-double-line" title="Approve"></i></a>';

            $nestedData = [
                'id' => $serialNumber,
                'pay_id' => $row->payment_id,
                'name' => $row->fullname,
                'email' => $row->email,
                'phone' => $row->phone,
                'installment' => $row->installment_no,
                'amount' => $row->payment_amount,
                'transactionSlip' => ($transactionSlip != null) ? '<a href="' . asset('storage/' .$transactionSlip) . '" target="_blank">view</a>' : '-',
                'type' => $type,
                'status' => ($row->payment_status == 'request_approval') ? '<span class="badge bg-primary">Request For Approval</span>' : '-',
                'location' => $row->location ?? '-',
                'user_behalf' => $row->user_behalf_fullname ?? '-',
                'created_at' => $row->created_at,
                'action' => $approval
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

  
    public function approved($id){

        DB::table('redemption_items')->where('id', $id)->update([
            'status' => 'paid',
        ]);

        $response = [
            'status' => true,
            'notification' => 'Payment Approved successfully!',
        ];

        return response()->json($response);
    }
    

}
