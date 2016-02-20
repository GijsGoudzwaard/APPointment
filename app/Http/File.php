<?php

namespace App\Http;

use Carbon\Carbon;

class File
{

	/**
	 * Upload a file
	 *
	 * @param  Request $request
	 * @param  String $name
	 * @return String|null
	 */
	public static function upload($request, String $name)
	{
		$logo = $request->file($name);

		if ($logo->isValid()) {
			$filename = $logo->getClientOriginalName() . '.' . $logo->getClientOriginalExtension();
			$url = 'uploads/' . Carbon::now()->format('m-d') . '/';

			$logo->move($url, $filename);

			// Return the url so we can save it in the db
			return $url . $filename;
		}

		return null;
	}
}
