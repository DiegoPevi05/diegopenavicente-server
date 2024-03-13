<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsurePackageAccess
{
    public function handle(Request $request, Closure $next, ...$packages)
    {
        $user = $request->user();

        if ($user && in_array($user->package, $packages)) {
            return $next($request);
        }

        return response('Unauthorized.', 401);
    }
}
