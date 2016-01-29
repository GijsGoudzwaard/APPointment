<?php

namespace App\Http\Requests;

class Parser
{
	/**
	 * Get the host of the given url
	 *
	 * @param String $url
	 * @param Boolean $getPort
	 * @param Boolean $getUrlScheme
	 * @return String
	 */
	public static function getHost (String $url = null, Bool $getPort = false, Bool $getUrlScheme = false)
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
	 * @return Boolean
	 */
	 public static function getSubdomain (String $url = null)
	 {
		$arr = explode('.', self::getHost($url ?? url('')));

		// Check if we we can find a subdomain
		if (count($arr) > 2 && count($arr) < 4) {
			// We can, let them pass
			return $arr[0];
		}

		return false;
	}
}
