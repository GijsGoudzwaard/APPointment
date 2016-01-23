<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Http\Requests\Parser;

class Subdomain
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
		// Check if we can get a subdomain from the url
		// Also check if the subdomain is equal to your subdomain
		if (Parser::getSubdomain($request->fullUrl()) == get_environment()->subdomain) {
			// We can let them through
			return $next($request);
		}

		// We can't set it.
		return Parser::setSubdomain($request->fullUrl());
    }

}
