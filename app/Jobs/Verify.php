<?php

namespace App\Jobs;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

abstract class Verify extends Controller
{
    /**
     * Verify if the given request is valid according to the validator
     *
     * @param  array $request
     * @param  mixed $rules
     * @return mixed
     */
    public function verify($request, $rules = null)
    {
        $validator = $this->validator(array_map([$this, 'formatDate'], $request), $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors()->all())->withInput();
        }
    }

    /**
     * See if there are dates that need fromatting e.g. 16-06-2016 instead of 2016-06-16
     *
     * @param  string $element
     * @return string
     */
    public function formatDate($element)
    {
        if (is_array($element) || ! strtotime($element)) {
            return $element;
        }

        return Carbon::parse($element)->toDateTimeString();
    }

    abstract function validator($request, $rules);
}
