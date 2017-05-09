<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAccess
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
        if(!Auth::check()){
            return redirect('/');
        }
        $user = Auth::user();

        if($user->access_level != User::ACCESS_LEVEL_ADMIN){
            return redirect(route('connected_dashboard'));
        }

        return $next($request);
    }
}
