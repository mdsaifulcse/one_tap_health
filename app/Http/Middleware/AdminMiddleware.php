<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if(\Auth::check() && \Auth::user()->user_role==User::ADMIN || \Auth::user()->user_role==User::DEVELOPER)
        {
            redirect('/admin/dashboard');
        }else{

            \Auth::logout();
            return  redirect('/user/user-dashboard')->with('error','Please login here as a general user');
        }

        return $next($request);
    }
}
