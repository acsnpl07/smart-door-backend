<?php

namespace App\Http\Middleware;

use App\Models\AppApiKey;
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

        $door = $apiKey->door;
        abort_unless($door, 401, 'invalid api key');

        $request->merge(['door' => $door]);
        return $next($request);
    }
}
