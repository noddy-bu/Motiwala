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
        $routeName = $request->route()->getName() ?? '';

        // 1) If the user IS authenticated (and has an allowed role)
        if (isset(auth()->user()->id) && in_array(auth()->user()->role_id, [1, 2, 3, 4])) {
            // a) If they are trying to visit any of the login/OTP pages, send them to dashboard
            $loginRoutes = [
                'backend.login',
                'backend.login.phone.send',
                'backend.login.phone.verify.form',
                'backend.login.phone.verify',
                'backend.login.phone.resend',
            ];

            if (in_array($routeName, $loginRoutes)) {
                return redirect()->route('backend.dashboard');
            }

            // b) Otherwise (anything else), let them through
            return $next($request);
        }

        // 2) If the user is NOT authenticated, allow ONLY the login/OTP routes
        $publicRoutes = [
            'backend.login',
            'backend.login.phone.send',
            'backend.login.phone.verify.form',
            'backend.login.phone.verify',
            'backend.login.phone.resend',
        ];

        if (in_array($routeName, $publicRoutes)) {
            return $next($request);
        }

        // 3) Any other route: redirect to login
        return redirect()->route('backend.login');
    }


}