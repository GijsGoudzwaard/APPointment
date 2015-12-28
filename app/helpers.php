<?php
// Helper functions here

function get_environment() {
	$subdomain = explode('.', parse_url(url())['host'])[0];
	$environment = App\Models\Environment::where('subdomain', '=', $subdomain)->get();

	return $environment[0];
}
