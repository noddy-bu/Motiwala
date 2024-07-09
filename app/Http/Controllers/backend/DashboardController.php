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
        $user_reg_Count = User::where('status', 1)->count();
        $user_not_reg_Count = User::where('status', 0)->count(); 
        $transactions = Transaction::where('payment_status', 'paid')->sum('payment_amount');
        $contactCount = Contact::count();
        return view('backend.pages.dashboard.index', compact('user_reg_Count', 'user_not_reg_Count','contactCount','transactions'));
    }
}
