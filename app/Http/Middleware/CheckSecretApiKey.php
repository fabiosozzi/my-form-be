<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSecretApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->header('X-Signature'))
        {
            return response()->json(['error' => 'Missing signature'], 401);
        }
        
        $incomingSignature = $request->header('X-Signature');
        $calculatedSignature = hash_hmac('sha256', json_encode($request->all()), config('app.api_secret_key'));

        if (!hash_equals($incomingSignature, $calculatedSignature)) {
            return response()->json(['error' => 'Invalid signature'], 402);
        }
        
        return $next($request);
    }
}
