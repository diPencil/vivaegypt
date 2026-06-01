<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckStaffRoutePermission
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('web')->check()) {
            abort(403, __('translate.You do not have permission to access this section'));
        }

        $user = Auth::guard('web')->user();

        if (! $user || ! $user->isStaff()) {
            abort(403, __('translate.You do not have permission to access this section'));
        }

        $routeName = (string) $request->route()?->getName();
        if ($routeName !== '' && ! $user->canAccessStaffRoute($routeName)) {
            abort(403, __('translate.You do not have permission to access this section'));
        }

        $action = $this->detectAction($request, $routeName);
        if ($action !== null && ! $user->canStaffAction($action)) {
            abort(403, __('translate.You do not have permission to access this section'));
        }

        return $next($request);
    }

    private function detectAction(Request $request, string $routeName): ?string
    {
        if ($request->isMethod('DELETE')) {
            return 'delete';
        }

        $needle = strtolower($routeName);

        if (str_contains($needle, 'destroy') || str_contains($needle, 'delete') || str_contains($needle, 'trash')) {
            return 'delete';
        }

        if (str_contains($needle, 'approve')) {
            return 'approve';
        }

        if (str_contains($needle, 'reject')) {
            return 'reject';
        }

        if (str_contains($needle, 'export')) {
            return 'export';
        }

        if (str_contains($needle, 'import')) {
            return 'import';
        }

        if (str_contains($needle, 'status')) {
            return 'update_status';
        }

        if (str_contains($needle, '.create') || str_contains($needle, '.store')) {
            return 'create';
        }

        if (str_contains($needle, '.edit') || str_contains($needle, '.update')) {
            return 'edit';
        }

        if (str_contains($needle, '.index') || str_contains($needle, '.show') || str_contains($needle, '.by-type')) {
            return 'view';
        }

        return null;
    }
}
