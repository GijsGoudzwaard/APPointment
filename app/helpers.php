<?php

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
