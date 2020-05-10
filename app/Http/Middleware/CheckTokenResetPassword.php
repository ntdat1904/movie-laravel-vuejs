<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\URL;

class CheckTokenResetPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $arr_url = explode('/',url()->current());
        $token = $arr_url[count($arr_url)-1];
        $user= User::where('remember_token', $token)->first();
        if($user) {
            return $next($request);
        }
        return redirect('/');
    }
}
