<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Paths listed in config/admin_roles.php (dev_admin_exclusive_path_prefixes)
 * are only reachable by admin_type = dev_admin (e.g. Theme & Menu management for developers).
 */
class DevAdminExclusiveRoutes
{
    public function handle(Request $request, Closure $next): Response
    {
        $path = trim($request->path(), '/');

        if (! str_starts_with($path, 'admin')) {
            return $next($request);
        }

        $exclusive = config('admin_roles.dev_admin_exclusive_path_prefixes', []);
        $matchesExclusive = false;
        foreach ($exclusive as $prefix) {
            $prefix = trim($prefix, '/');
            if ($path === $prefix || str_starts_with($path, $prefix.'/')) {
                $matchesExclusive = true;
                break;
            }
        }

        if (! $matchesExclusive) {
            return $next($request);
        }

        if (! Auth::guard('admin')->check()) {
            return $next($request);
        }

        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();

        if (! $admin->isDevAdmin()) {
            abort(403, __('translate.Only dev admin can access this section'));
        }

        return $next($request);
    }
}
