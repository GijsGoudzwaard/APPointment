<?php

namespace App\Http\Requests;

class UrlParser
{
	/**
	 * Get the host of the given url
	 *
	 * @param String $url
	 * @param Boolean $getPort
	 * @param Boolean $getUrlScheme
	 * @return String
	 */
	public static function getHost(String $url = null, Bool $getPort = false, Bool $getUrlScheme = false)
	{
		$url = $url ?? url('');
		// Retrieve the host of the url
		// Remove 'www.' if it is set
		$host = str_replace('www.', '', parse_url($url, PHP_URL_HOST));

		// Check if we need to get the port aswell
		if ($getPort) {
			// Append the port to $host
			$host .= ':' . parse_url($url, PHP_URL_PORT);
		}

		if ($getUrlScheme) {
			return parse_url($url, PHP_URL_SCHEME) . '://' . $host;
		}

		return $host;
	}

	/**
	 * Check if we can find a subdomain in the given url
	 *
	 * @param  String $url
	 * @param  Bool $getPort
	 * @return Boolean
	 */
	 public static function getSubdomain(String $url = null, Bool $getPort = false)
	 {
		$arr = explode('.', self::getHost($url ?? url(''), $getPort));

		// Check if we we can find a subdomain
		if (count($arr) > 2 && count($arr) < 4) {
			// We can, let them pass
			return $arr[0];
		}

		return false;
	}

	/**
	 * Set the domain, redirect to that url after we are done
	 * At this moment we only support url's like this: subdomain.domain.com
	 *
	 * @param String $url
	 * @return Response
	 */
	public static function setSubdomain (String $url = null)
	{
		$url = $url ?? url('');
		$subdomain = self::getSubdomain($url);
		$host = self::getHost($url, env('APP_DEBUG', false));
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
