<?php

namespace App\Http\Middleware\Domain\Shared;

use App\Supports\ApiReturnResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceEmailVerificationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ( ! $request->user()->hasVerifiedEmail() ) {
            return ApiReturnResponse::unAuthorized(message: 'Please verify your email first');
        }
        return $next($request);
    }
}
