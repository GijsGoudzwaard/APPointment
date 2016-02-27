<?php

namespace App\Http;

use Carbon\Carbon;
use Validator;

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
			$validator = Validator::make($request->all(), [
				$name => 'image'
			]);

			if ($validator->fails()) {
				return $validator->errors()->all();
			}

			$filename = str_replace(' ', '_', $logo->getClientOriginalName()) . '.' . $logo->getClientOriginalExtension();
			$url = 'uploads/' . Carbon::now()->format('m-d') . '/';

			$logo->move($url, $filename);

			// Return the url so we can save it in the db
			return $url . $filename;
		}

		return null;
	}
}
