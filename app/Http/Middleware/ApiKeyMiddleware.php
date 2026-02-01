<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY'); // or $request->get('api_key') for query param

        if ($apiKey== env('API_ACCESS_KEY')) {
           
             return $next($request);
        }
     return response()->json(['message' => 'Unauthorized. Invalid API key.'], 401);
       
    }
}
