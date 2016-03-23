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
	 * @return Array|String|null
	 */
	public static function upload($request, String $name)
	{
		$file = $request->file($name);

		if ($file->isValid()) {
			$validator = Validator::make($request->all(), [
				$name => 'image'
			]);

			if ($validator->fails()) {
				return $validator->errors()->all();
			}

			$filename = str_replace(' ', '_', $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
			$url = 'uploads/' . Carbon::now()->format('m-d') . '/';

			$file->move($url, $filename);

			// Return the url so we can save it in the db
			return $url . $filename;
		}

		return null;
	}
}
