<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request)
    {
        if(!$request->expectsJson()){
            return url('/');
        }

        return ResponseHelper::onError('Unauthenticated', 401);
        // return $request->expectsJson() ? ResponseHelper::onError('Unauthenticated', 401) : route('login');
    }
}
