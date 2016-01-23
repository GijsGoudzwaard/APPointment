<?php

namespace App\Http\Requests;

class Parser
{
	/**
	 * Get the host of the given url
	 *
	 * @param String $url
	 * @param Boolean $getport
	 * @return String
	 */
	public static function getHost($url, $getport = false)
	{
		// Check if we need to get the port aswell
		if($getport) {
			$port = ':' . parse_url($url, PHP_URL_PORT);
		} else {
			$port = null;
		}

		// Retrieve the host of the url
		// Remove 'www.' if it is set
		return str_replace('www.', '', parse_url($url, PHP_URL_HOST)) . $port;
	}

	/**
	 * Set the domain, redirect to that url after we are done
	 *
	 * @param String $url
	 * @return Responsel
	 */
	public static function setSubdomain ($url)
	{
		$subdomain = get_environment()->subdomain;
		dd(self::getHost($url, env('APP_DEBUG', false)));
	    return redirect(parse_url($url, PHP_URL_SCHEME) . '://' . $subdomain . '.' . self::getHost($url, env('APP_DEBUG', false)));
	}

	/**
	 * Check if we can find a subdomain in the given url
	 *
	 * @param  String $url
	 * @return Boolean
	 */
	 public static function getSubdomain ($url)
	 {
		// Check if we we can find a subdomain
		if (count(explode('.', self::getHost($url))) > 2) {
			// We can, let them pass
			return explode('.', self::getHost($url))[0];
		}

		// We can't, don't let them pass
		return false;
	}
}
