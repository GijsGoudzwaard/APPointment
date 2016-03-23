<?php
use Carbon\Carbon;
use App\Models\Company;

if (!function_exists('get_environment')) {
	/**
	* Get the environment based on the user that is logged in
	*
	* @return App\Models\Environment
	*/
	function get_environment()
	{
		return Auth::user()->environment;
	}
}

if (!function_exists('get_company')) {
	/**
	* Get the company based on the user that is logged in
	*
	* @return App\Models\Environment
	*/
	function get_company()
	{
		return Auth::user()->company;
	}
}

if (!function_exists('get_day_name')) {
	/**
	 * Get the full day name by the short day name
	 *
	 * @param  String $day
	 * @return String
	 */
	function get_day_name(String $day = '')
	{
		$days = (new Company)->days;

		return $days[$day] ?? Carbon::parse()->format('l');
	}
}
