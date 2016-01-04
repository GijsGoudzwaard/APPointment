<?php
// Helper functions here

function get_environment() {
	// $subdomain = explode('.', str_replace('www.', '', parse_url(url(), PHP_URL_HOST)))[0];
	// $environment = App\Models\Environment::where('subdomain', '=', $subdomain)->get();

	return $environment[0];
}
