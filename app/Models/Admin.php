<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Admin extends Authenticatable
{
    use HasFactory;

    const STATUS_ACTIVE = 'enable';

    const STATUS_INACTIVE = 'disable';

    /** Business owner / main administrator: full admin UI except dev-only tooling (themes, menus — hidden in sidebar + route guard). */
    public const TYPE_SUPER_ADMIN = 'super_admin';

    /** Developer: same admin login, full access to all admin areas; exclusive access to theme & menu tooling. */
    public const TYPE_DEV_ADMIN = 'dev_admin';

    /** Operational staff roles. */
    public const TYPE_STAFF_DATA_ENTRY = 'staff_data_entry';
    public const TYPE_STAFF_ACCOUNTANT = 'staff_accountant';
    public const TYPE_AGENT_TRAVEL = 'agent_travel';
    public const TYPE_AGENT_SALES = 'agent_sales';
    public const TYPE_AGENT_BOOKING = 'agent_booking';

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'admin_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isSuperAdmin(): bool
    {
        return ($this->admin_type ?? self::TYPE_SUPER_ADMIN) === self::TYPE_SUPER_ADMIN;
    }

    public function isDevAdmin(): bool
    {
        return ($this->admin_type ?? '') === self::TYPE_DEV_ADMIN;
    }

    public function isStaffDataEntry(): bool
    {
        return ($this->admin_type ?? '') === self::TYPE_STAFF_DATA_ENTRY;
    }

    public function isStaffAccountant(): bool
    {
        return ($this->admin_type ?? '') === self::TYPE_STAFF_ACCOUNTANT;
    }

    public function isTravelAgent(): bool
    {
        return ($this->admin_type ?? '') === self::TYPE_AGENT_TRAVEL;
    }

    public function isSalesAgent(): bool
    {
        return ($this->admin_type ?? '') === self::TYPE_AGENT_SALES;
    }

    public function isBookingAgent(): bool
    {
        return ($this->admin_type ?? '') === self::TYPE_AGENT_BOOKING;
    }

    public function isStaff(): bool
    {
        return in_array($this->admin_type ?? '', [
            self::TYPE_STAFF_DATA_ENTRY,
            self::TYPE_STAFF_ACCOUNTANT,
            self::TYPE_AGENT_TRAVEL,
            self::TYPE_AGENT_SALES,
            self::TYPE_AGENT_BOOKING,
        ], true);
    }

    public function roleDisplayLabel(): string
    {
        return match ($this->admin_type ?? self::TYPE_SUPER_ADMIN) {
            self::TYPE_STAFF_DATA_ENTRY => __('translate.Data Entry'),
            self::TYPE_STAFF_ACCOUNTANT => __('translate.Accountant'),
            self::TYPE_AGENT_TRAVEL => __('translate.Travel Agent'),
            self::TYPE_AGENT_SALES => __('translate.Sales Agent'),
            self::TYPE_AGENT_BOOKING => __('translate.Booking Agent'),
            self::TYPE_DEV_ADMIN => __('translate.Dev Admin'),
            default => __('translate.Super Admin'),
        };
    }

    public function canSeeStaffSection(string $section): bool
    {
        if ($this->isSuperAdmin() || $this->isDevAdmin()) {
            return true;
        }

        $selectedPermissions = $this->selectedStaffPermissionKeys();
        $permissionGroups = config('admin_roles.staff_permission_groups', []);

        foreach ($selectedPermissions as $permissionKey) {
            if (($permissionGroups[$permissionKey]['section'] ?? null) === $section) {
                return true;
            }
        }

        return false;
    }

    public function canAccessAdminRoute(string $routeName): bool
    {
        if ($this->isSuperAdmin() || $this->isDevAdmin()) {
            return true;
        }

        if ($this->isStaff() && in_array($routeName, ['admin.dashboard', 'admin.logout'], true)) {
            return true;
        }

        $permissionGroups = config('admin_roles.staff_permission_groups', []);

        foreach ($this->selectedStaffPermissionKeys() as $permissionKey) {
            $routes = $permissionGroups[$permissionKey]['routes'] ?? [];

            foreach ($routes as $pattern) {
                if (Str::is($pattern, $routeName)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function selectedStaffPermissionKeys(): array
    {
        $defaults = config('admin_roles.staff_default_permissions', []);
        $defaultPermissions = $defaults[$this->admin_type] ?? [];

        if (! $this->isStaff()) {
            return $defaultPermissions;
        }

        $storedValue = DB::table('global_settings')
            ->where('key', 'staff_role_permissions')
            ->value('value');

        if (! is_string($storedValue) || $storedValue === '') {
            return $defaultPermissions;
        }

        $decoded = json_decode($storedValue, true);

        if (! is_array($decoded)) {
            return $defaultPermissions;
        }

        $selected = $decoded[$this->admin_type] ?? null;

        return is_array($selected) && $selected !== [] ? array_values($selected) : $defaultPermissions;
    }
}
