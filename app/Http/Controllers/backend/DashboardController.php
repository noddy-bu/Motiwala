<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Contact;

class DashboardController extends Controller
{
    public function index(){
        $user_reg_Count = User::where('status', 1)->where('role_id', 0)->count();
        $user_not_reg_Count = User::where('status', null)->count(); 

        $transactions = Transaction::where('payment_status', 'paid')
        ->when(in_array(auth()->user()->role_id, [2, 3]), function ($query) {
            return $query->where('user_behalf', auth()->user()->id);
        })
        ->sum('payment_amount');
        
        $contactCount = Contact::count();
        return view('backend.pages.dashboard.index', compact('user_reg_Count', 'user_not_reg_Count','contactCount','transactions'));
    }
}
