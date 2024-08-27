<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use Illuminate\Support\Facades\Session;

class AuthenticateController extends Controller
{
    public function index(){
        return view('backend.auth.login');
    }

    public function login(request $request)
    {
        $validator = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
            

        $authenticated = Auth::guard('web')->attempt($request->only(['email', 'password']));
        if($authenticated)
        {
            // Check if the authenticated user's status is 1
            if (auth()->user()->status == 1) {
                return redirect()->route('backend.dashboard');
            } else {
                // Log the user out if their status is not 1
                Auth::guard('web')->logout();
                return redirect()->back()->withErrors(['invalid_credential' => 'Your account is inactive.']);
            }
        }
        else
        {
            return redirect()->back()->withErrors(['invalid_credential' => 'Credential is invalid!']);
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        Session()->flush();
        return redirect()->route('backend.login');
    }    
}
