<?php

namespace App\Http;

use Cookie;
use App\Http\Controllers\Controller;

class Language extends Controller
{
    /**
     * The supported locales
     *
     * @var array
     */
    public static $locales = [
        'nl',
        'en'
    ];

    /**
     * Set a the locale
     *
     * @param  string $locale
     * @return mixed
     */
    public function set($locale)
    {
        if (! Cookie::get('lang')) {
            Cookie::queue('lang', 'nl');
        }

        if ($locale != Cookie::get('lang')) {
            Cookie::queue('lang', $locale);
        }

        return redirect()->back();
    }
}
