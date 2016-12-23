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
        $url = $request->fullUrl();
        $subdomain = UrlParser::getSubdomain($url);

        // Check if we can get a subdomain from the url
        // Also check if the subdomain is equal to your subdomain
        if ($subdomain == get_company()->subdomain) {
            // We can let them through
            return $next($request);
        }

        // Remove the old subdomain if it is set.
        if ($subdomain) {
            $url = str_replace("{$subdomain}.", '', $url);
        }

        // We can set it.
        return UrlParser::setSubdomain($url);
    }
}
