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
		return $this->setSubdomain($request->fullUrl());
    }

	/**
	 * Set the domain, redirect to that url after we are done
	 *
	 * @param String $url
	 * @return Responsel
	 */
	public function setSubdomain ($url)
	{
		$subdomain = get_environment()->subdomain;

		return redirect(parse_url($url, PHP_URL_SCHEME) . '://' . $subdomain . '.' . Parser::getHost($url, env('APP_DEBUG', false)));
	}

}
