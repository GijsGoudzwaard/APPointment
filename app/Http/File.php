<?php

namespace App\Http;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;

class File
{
    /**
     * Upload a file
     *
     * @param  Request $request
     * @param  string $name
     * @return array|string|null
     */
    public static function upload(Request $request, String $name)
    {
        $file = $request->file($name);

        if (!$file->isValid()) {
            return null;
        }

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
}
