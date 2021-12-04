<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if((Auth::user()->role->name != $role) && Auth::user()->role->name != 'Admintrator' && Auth::user()->role->name == 'Visitor')
            return redirect('/login');
        return $next($request);
    }
}
