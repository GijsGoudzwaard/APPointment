<?php

/**
 * Get the environment based on the user that is logged in
 *
 * @return App\Models\Environment
 */
function get_environment() {
	return User::find(Auth::user()->id)->environment;
}

/**
 * Get the host of the given url
 *
 * @param String $url
 * @param Boolean $getport
 * @return String
 */
function get_host($url, $getport = false) {
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
