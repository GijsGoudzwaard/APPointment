<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (! Cookie::get('lang')) {
            Cookie::queue(Cookie::make('lang', 'nl', 1440));
        }

        if (Cookie::get('lang') != app()->getLocale()) {
            app()->setLocale(Cookie::get('lang'));
        }

        return $next($request);
    }
}