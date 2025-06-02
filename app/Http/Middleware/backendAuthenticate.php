<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Closure;
class backendAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    /*public function handle(Request $request, Closure $next)
    {
        if (isset(auth()->user()->id) && in_array(auth()->user()->role_id, [1, 2, 3])):
                return $next($request);               
        else:
            if($request->route()->getName() == 'backend.login'):
                return $next($request);
            else:
                return  redirect(route('backend.login'));
            endif;
        endif;
    }*/

    public function handle(Request $request, Closure $next)
    {
        // 1) If user is logged in and has one of the allowed role_ids, continue.
        if (isset(auth()->user()->id) && in_array(auth()->user()->role_id, [1, 2, 3])) {
            return $next($request);
        }

        // 2) If not logged in, allow the "backend.login" page
        //    OR any of the OTP‐related routes (send, show‐verify, verify, resend):
        $allowed = [
            'backend.login',
            'backend.login.phone.send',
            'backend.login.phone.verify.form',
            'backend.login.phone.verify',
            'backend.login.phone.resend',
        ];

        if (in_array($request->route()->getName(), $allowed)) {
            return $next($request);
        }

        // 3) Otherwise, redirect to login
        return redirect(route('backend.login'));
    }

}