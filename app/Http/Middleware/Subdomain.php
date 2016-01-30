<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Http\Requests\UrlParser;

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
		if (UrlParser::getSubdomain($request->fullUrl()) == get_environment()->subdomain) {
			// We can let them through
			return $next($request);
		}

		// We can't set it.
		return $this->setSubdomain($request->fullUrl());
    }

	/**
	 * Set the domain, redirect to that url after we are done
	 * At this moment we only support url's like this: subdomain.domain.com
	 *
	 * @param String $url
	 * @return Responsel
	 */
	public function setSubdomain (String $url = null)
	{
		$url = $url ?? url('');
		$subdomain = UrlParser::getSubdomain($url);
		$host = UrlParser::getHost($url, env('APP_DEBUG', false));
		$scheme = parse_url($url, PHP_URL_SCHEME) . '://';

		// Check if we already have a subdomain in the url
		if($subdomain) {
			// We do, replace it
			// Replace the subdomain with the subdomain from the logged in user
			$newUrl = str_replace($subdomain, get_environment()->subdomain, $host);

			// Redirect to our new url
			return redirect($scheme . $newUrl);
		}

		// We don't have a subdomain, set it
		return redirect($scheme . get_environment()->subdomain . '.' . $host);
	}

}
