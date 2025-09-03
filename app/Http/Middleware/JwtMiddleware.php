<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Helpers\ApiResponseHelper;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            // Try to parse and authenticate user from token
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return ApiResponseHelper::error('Token has expired', 401);

        } catch (TokenInvalidException $e) {
            return ApiResponseHelper::error('Token is invalid', 401);
        } catch (JWTException $e) {
            return ApiResponseHelper::error('Token is missing', 401);
        }

        return $next($request);
    }

    /* private function unauthorizedResponse($message)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'timestamp' => now()->toISOString()
        ], 401);
    } */
}
