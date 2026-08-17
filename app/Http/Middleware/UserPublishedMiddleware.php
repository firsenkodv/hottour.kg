<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserPublishedMiddleware
{
    public function handle(Request $request, Closure $next): Response|string
    {

        $user = auth()->user();
        if ($user) {
            if ($user->published) {
                return $next($request);
            } else {
                return redirect('/cabinet-blocked');
            }

        }

        return redirect('/login');
    }
}
