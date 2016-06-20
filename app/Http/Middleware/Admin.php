<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
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
		if (Auth::user()->role != Auth::user()->role('admin')) {
			return redirect('/')->with('errors', 'You\'re not allowed there!');
		}

		return $next($request);
	}
}
