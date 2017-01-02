<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

class ProfileApiResponse
{
    /**
     * Indicate if the Debugbar is enabled.
     *
     * @var bool
     */
    protected $debugbarEnabled;

    /**
     * Create a new middleware instance.
     */
    public function __construct()
    {
        $this->debugbarEnabled = function_exists('debugbar') && debugbar()->isEnabled();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($this->debugbarEnabled) {
            $response->setContent([
                debugbar()->getCollector('time')->collect()['duration_str'],
            ] + $response->getOriginalContent());
        }

        return $response;
    }
}
