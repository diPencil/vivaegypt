<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\TourBooking\App\Models\Booking;
use Modules\TourBooking\App\Models\Review as TourBookingReview;
use Modules\TourBooking\App\Models\Service;
use Modules\Wishlist\App\Models\Wishlist;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const STATUS_ACTIVE = 'enable';

    const STATUS_INACTIVE = 'disable';

    const BANNED_ACTIVE = 'yes';

    const BANNED_INACTIVE = 'no';

    public const TYPE_STAFF_DATA_ENTRY = 'staff_data_entry';
    public const TYPE_STAFF_ACCOUNTANT = 'staff_accountant';
    public const TYPE_AGENT_TRAVEL = 'agent_travel';
    public const TYPE_AGENT_SALES = 'agent_sales';
    public const TYPE_AGENT_BOOKING = 'agent_booking';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verification_token',
        'username',
        'user_id_number',
        'country',
        'gender',
        'phone',
        'address',
        'status',
        'is_banned',
        'is_seller',
        'is_staff',
        'staff_role',
        'password',
        'verification_token',
        'provider',
        'provider_id',
        'email_verified_at',
        'zoom_access_token',
        'zoom_refresh_token',
        'zoom_token_expiry',
        'agent_name',
        'agent_slug',
        'agent_logo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['avg_rating', 'total_rating', 'total_student', 'total_services'];

    public function isStaff(): bool
    {
        return (string) ($this->is_staff ?? '0') === '1';
    }

    public function isStaffDataEntry(): bool
    {
        return $this->isStaff() && ($this->staff_role ?? '') === self::TYPE_STAFF_DATA_ENTRY;
    }

    public function isStaffAccountant(): bool
    {
        return $this->isStaff() && ($this->staff_role ?? '') === self::TYPE_STAFF_ACCOUNTANT;
    }

    public function isTravelAgent(): bool
    {
        return $this->isStaff() && ($this->staff_role ?? '') === self::TYPE_AGENT_TRAVEL;
    }

    public function isSalesAgent(): bool
    {
        return $this->isStaff() && ($this->staff_role ?? '') === self::TYPE_AGENT_SALES;
    }

    public function isBookingAgent(): bool
    {
        return $this->isStaff() && ($this->staff_role ?? '') === self::TYPE_AGENT_BOOKING;
    }

    public function roleDisplayLabel(): string
    {
        return match ($this->normalizedStaffRole()) {
            self::TYPE_STAFF_DATA_ENTRY => __('translate.Data Entry'),
            self::TYPE_STAFF_ACCOUNTANT => __('translate.Accountant'),
            self::TYPE_AGENT_TRAVEL => __('translate.Travel Agent'),
            self::TYPE_AGENT_SALES => __('translate.Sales Agent'),
            self::TYPE_AGENT_BOOKING => __('translate.Booking Agent'),
            default => __('translate.User'),
        };
    }

    public function canSeeStaffSection(string $section): bool
    {
        if (! $this->isStaff()) {
            return false;
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
        return $this->canAccessStaffRoute($routeName);
    }

    public function canAccessStaffRoute(string $routeName): bool
    {
        if (! $this->isStaff()) {
            return false;
        }

        if (in_array($routeName, ['staff.dashboard', 'staff.logout'], true)) {
            return true;
        }

        $matchedRouteName = $routeName;
        if (str_starts_with($routeName, 'staff.')) {
            $matchedRouteName = 'admin.'.substr($routeName, 6);
        }

        $permissionGroups = config('admin_roles.staff_permission_groups', []);

        foreach ($this->selectedStaffPermissionKeys() as $permissionKey) {
            $routes = $permissionGroups[$permissionKey]['routes'] ?? [];

            foreach ($routes as $pattern) {
                if (Str::is($pattern, $matchedRouteName) || Str::is($pattern, $routeName)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function canStaffAction(string $action): bool
    {
        if (! $this->isStaff()) {
            return false;
        }

        if ($action === 'delete') {
            return false;
        }

        $allowed = config('admin_roles.staff_allowed_actions', [
            'view',
            'create',
            'edit',
            'update_status',
            'export',
            'import',
            'approve',
            'reject',
        ]);

        return in_array($action, $allowed, true);
    }

    public function selectedStaffPermissionKeys(): array
    {
        $defaults = config('admin_roles.staff_default_permissions', []);
        $defaultPermissions = $defaults[$this->normalizedStaffRole()] ?? $defaults[self::TYPE_STAFF_DATA_ENTRY] ?? [];

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

        $selected = $decoded[$this->normalizedStaffRole()] ?? null;

        if (! is_array($selected) || $selected === []) {
            return $defaultPermissions;
        }

        $merged = array_values(array_unique(array_merge($defaultPermissions, array_values($selected))));

        return $merged !== [] ? $merged : $defaultPermissions;
    }

    private function normalizedStaffRole(): string
    {
        $role = (string) ($this->staff_role ?? '');

        return $role !== '' ? $role : self::TYPE_STAFF_DATA_ENTRY;
    }

    public function getAvgRatingAttribute(): string
    {
        $avg = TourBookingReview::query()
            ->where('status', true)
            ->whereHas('service', function ($q) {
                $q->where('user_id', $this->id);
            })
            ->avg('rating');

        return $avg !== null ? sprintf('%.2f', (float) $avg) : '0.00';
    }

    public function getTotalRatingAttribute(): int
    {
        return (int) TourBookingReview::query()
            ->where('status', true)
            ->whereHas('service', function ($q) {
                $q->where('user_id', $this->id);
            })
            ->count();
    }

    public function getTotalStudentAttribute(): int
    {
        return (int) Booking::query()
            ->whereHas('service', function ($q) {
                $q->where('user_id', $this->id);
            })
            ->count();
    }

    public function getTotalServicesAttribute(): int
    {
        return (int) Service::query()
            ->where('user_id', $this->id)
            ->where('status', true)
            ->count();
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
