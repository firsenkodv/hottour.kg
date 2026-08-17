<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {

        $user = auth()->user();
        if ($user) {

            foreach ($roles as $role) {
                $role = trim($role);

                if(isset($user->parent)) {
                    if(strtolower($user->parent->name)== $role) {
                        return $next($request);
                    }
                }

            }
        }

        return redirect('/login');

    }
}
