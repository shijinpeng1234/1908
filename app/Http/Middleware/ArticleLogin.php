<?php

namespace App\Http\Middleware;

use Closure;

class ArticleLogin
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
            return redirect('/login');
        }
        return $next($request);
    }
}
