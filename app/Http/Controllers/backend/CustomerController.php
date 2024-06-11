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
        $query = User::select('*')->where('role_id', '!=', 1);
    
        // Filtered records
        $query = User::select('*');
        $query->where('role_id','!=',1);
        if (!empty($searchValue)) {
            $query->where(function($q) use ($searchValue) {
                $q->where('name', 'like', "%$searchValue%")
                    ->orWhere('email', 'like', "%$searchValue%")
                    ->orWhere('phone', 'like', "%$searchValue%");
            });
        }
    
        // Filter by additional form parameters
        $name = $request->input('name');
        if (!empty($name)) {
            $query->where('name', 'like', "%$name%");
        }

        $email  = $request->input('email');
        if (!empty($email)) {
            $query->where('email', 'like', "%$email%");
        }
    
        $phone = $request->input('phone');
        if (!empty($phone)) {
            $query->where('phone', 'like', "%$phone%");
        }
    
        $status = $request->input('status');
        if ($status != '') {
            $query->where('status', $status);
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
                $tran = '<a href="javascript:void(0);" class="action-icon" onclick="largeModal(\''.route('Customer.transaction', ['id' => $row->id]).'\', \'Customer Transaction\')"> <i class="ri-wallet-line" title="Transaction"></i></a>';
            } else {
                $tran = null;
            }

            $nestedData = [
                'id' => $i++,
                'name' => $row->name,
                'email' => $row->email,
                'phone' => $row->phone,
                'status' => $row->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>',
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
        $transaction = Transaction::where('user_id',$id)->where('payment_status','paid')->get();
        return view('backend.pages.customer.transaction', compact('transaction'));
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
    

}
