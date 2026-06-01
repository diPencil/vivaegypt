<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RestrictStaffRoutes
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('admin')->check()) {
            return $next($request);
        }

        $admin = Auth::guard('admin')->user();

        if (! $admin || ! $admin->isStaff()) {
            return $next($request);
        }

        $routeName = (string) $request->route()?->getName();

        if ($routeName === '') {
            return $next($request);
        }

        if ($admin->canAccessAdminRoute($routeName)) {
            return $next($request);
        }

        abort(403, __('translate.You do not have permission to access this section'));
    }
}