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
	 * At this moment we only support url's like this: subdomain.domain.com
	 *
	 * @param String $url
	 * @return Responsel
	 */
	public function setSubdomain (String $url = null)
	{
		$url = $url ?? url('');
		$subdomain = Parser::getSubdomain($url);
		$host = Parser::getHost($url, env('APP_DEBUG', false));

		// Check if we already have a subdomain in the url
		if($subdomain) {
			// We do, replace it
			// Replace the subdomain with the subdomain from the logged in user
			$newUrl = str_replace($subdomain, get_environment()->subdomain, $host);

			// Redirect to our new url
			return redirect(parse_url($url, PHP_URL_SCHEME) . '://' . $newUrl);
		}

		// We don't have a subdomain, set it
		return redirect(parse_url($url, PHP_URL_SCHEME) . '://' . get_environment()->subdomain . '.' . $host);
	}

}
