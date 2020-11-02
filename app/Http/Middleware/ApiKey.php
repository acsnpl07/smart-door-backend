<?php

namespace App\Http\Middleware;

use App\ApiKey as AppApiKey;
use Closure;

class ApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $apiKey = $request->header('Api-Key');
        abort_unless($apiKey, 401, 'api key is required');

        $apiKey = AppApiKey::where('key', $apiKey)->first();
        abort_unless($apiKey, 401, 'invalid api key');

        $business = $apiKey->business;
        abort_unless($business, 401, 'invalid api key');

        $request->merge(['business' => $business]);
        return $next($request);
    }
}
