<?php

namespace App\Http\Middleware;

use Closure;

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

	public function setSubdomain ($url) {
	    return $url;
	}

	/**
	 * Check if we can find a subdomain in the given url
	 *
	 * @param  String $url
	 *
	 * @return Boolean
	 */
	public function getSubdomain ($url) {
		// Retrieve the host of the url
		// Remove 'www.' if it is set
		$host = str_replace('www.', '', parse_url($url, PHP_URL_HOST));

		// Check if we we can find a subdomain
		if (explode('.', $host)[0]) {
			// We can, let them pass
			return true;
		}

		// We can't, don't let them pass
		return false;
	}
}
