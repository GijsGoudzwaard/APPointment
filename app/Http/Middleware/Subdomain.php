<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

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
		if ($this->getSubdomain($request->fullUrl())) {
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
	public function setSubdomain ($url) {
		$subdomain = Auth::user()->environment->subdomain;

	    return redirect(parse_url($url, PHP_URL_SCHEME) . '://' . $subdomain . '.' . get_host($url, env('APP_DEBUG', false)));
	}

	/**
	 * Check if we can find a subdomain in the given url
	 *
	 * @param  String $url
	 * @return Boolean
	 */
	 public function getSubdomain ($url) {
		// Check if we we can find a subdomain
		if (count(explode('.', get_host($url))) > 2) {
			// We can, let them pass
			return true;
		}

		// We can't, don't let them pass
		return false;
	}
}
