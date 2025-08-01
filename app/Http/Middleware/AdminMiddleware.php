<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return \response("please log in first");
        }

        if (Auth::user()->role !== 'admin') {
            return \response()->json("you not have access");
        }

        return $next($request);
    }
}
