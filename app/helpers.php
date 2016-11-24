<?php

use Carbon\Carbon;
use App\Http\Language;
use App\Models\Company;
use App\Http\Requests\UrlParser;

if (! function_exists('get_company')) {
    /**
     * Get the company based on the user that is logged in
     *
     * @return Company
     */
    function get_company()
    {
        return (new Company)->get();
    }
}

if (! function_exists('get_day_name')) {
    /**
     * Get the full day name by the short day name
     *
     * @param  string $day
     * @return string
     */
    function get_day_name(String $day = '')
    {
        $days = (new Company)->days;

        return $days[$day] ?? Carbon::parse()->format('l');
    }
}

if (! function_exists('clean_string')) {
    /**
     * Remove all special characters so it'll be friendly to us in the subdomain
     *
     * @param  string $string
     * @return string
     */
    function clean_string($string)
    {
        $string = str_replace(' ', '-', $string);

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }
}

if (! function_exists('get_url')) {
    /**
     * Get the url without the current subdomain
     *
     * @return string
     */
    function get_url()
    {
        return UrlParser::getHost(null, false, false, false);
    }
}

if (! function_exists('get_locales')) {
    /**
     * Get the supported locales
     *
     * @return array
     */
    function get_locales()
    {
        return Language::$locales;
    }
}

if (! function_exists('get_protocol')) {
    /**
     * Get the http protocol
     *
     * @return string
     */
    function get_protocol()
    {
        if (isset($_SERVER['HTTPS'])) {
            return 'https://';
        }

        return 'http://';
    }
}
