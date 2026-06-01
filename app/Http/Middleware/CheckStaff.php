<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckStaff
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('web')->check()) {
            return redirect()->route('user.login');
        }

        $user = Auth::guard('web')->user();

        if (! $user || ! $user->isStaff()) {
            abort(403, __('translate.You do not have permission to access this section'));
        }

        return $next($request);
    }
}