<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests;

class RateLimitMiddleware extends ThrottleRequests
{
    protected function resolveRequestSignature($request)
    {
        return $request->ip();
    }
}
