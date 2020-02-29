<?php

namespace App\Http\Middleware;

use Closure;

class UserLogin
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
        //执行动作
        $user=session('adminuser');
        // dd($adminuser);
        if(!$user){
            return redirect('/user/login');
        }
        return $next($request);
    }
}
