<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    private const ROLE_TYPE_MAP = [
        'data-entry' => User::TYPE_STAFF_DATA_ENTRY,
        'accountant' => User::TYPE_STAFF_ACCOUNTANT,
        'travel-agent' => User::TYPE_AGENT_TRAVEL,
        'sales-agent' => User::TYPE_AGENT_SALES,
        'booking-agent' => User::TYPE_AGENT_BOOKING,
    ];

    private const AGENT_TYPES = [
        'travel-agent',
        'sales-agent',
        'booking-agent',
    ];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $type = (string) $request->query('type', 'all');
        $isAgentView = in_array($type, self::AGENT_TYPES, true);
        $isStaffView = ! $isAgentView;

        $query = User::query()
            ->where('is_staff', '1')
            ->whereIn('staff_role', array_values(self::ROLE_TYPE_MAP))
            ->latest();

        if (isset(self::ROLE_TYPE_MAP[$type])) {
            $query->where('staff_role', self::ROLE_TYPE_MAP[$type]);
        }

        $staffMembers = $query->get();
        $title = $isAgentView ? trans('translate.Manage Agent') : trans('translate.Staff Management');

        return view('admin.staff.staff_list', [
            'title' => $title,
            'staffMembers' => $staffMembers,
            'activeType' => $type,
            'isAgentView' => $isAgentView,
            'isStaffView' => $isStaffView,
            'roleTypeMap' => self::ROLE_TYPE_MAP,
            'agentTypes' => self::AGENT_TYPES,
        ]);
    }

    public function create()
    {
        return view('admin.staff.staff_create', [
            'title' => trans('translate.Add Staff'),
        ]);
    }

    public function show(int $id)
    {
        $staff = User::findOrFail($id);

        return view('admin.staff.staff_show', [
            'title' => trans('translate.User Details'),
            'staff' => $staff,
        ]);
    }

    public function edit(int $id)
    {
        $staff = User::findOrFail($id);

        return view('admin.staff.staff_edit', [
            'title' => trans('translate.Edit User Basic Information'),
            'staff' => $staff,
            'selectedType' => array_search($staff->staff_role, self::ROLE_TYPE_MAP, true) ?: 'data-entry',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'type' => ['required', 'in:data-entry,accountant,travel-agent,sales-agent,booking-agent'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        $staffRole = self::ROLE_TYPE_MAP[$request->type] ?? User::TYPE_STAFF_DATA_ENTRY;

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'status' => $request->boolean('status') ? User::STATUS_ACTIVE : User::STATUS_INACTIVE,
            'is_staff' => '1',
            'staff_role' => $staffRole,
        ]);

        $notification = [
            'message' => trans('translate.Staff created successful'),
            'alert-type' => 'success',
        ];

        return redirect()->route('admin.staff-list')->with($notification);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $staff = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $staff->id],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $staff->id],
            'type' => ['required', 'in:data-entry,accountant,travel-agent,sales-agent,booking-agent'],
            'password' => ['nullable', 'string', 'min:4'],
            'status' => ['nullable'],
        ]);

        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->username = $request->username;
        $staff->staff_role = self::ROLE_TYPE_MAP[$request->type] ?? $staff->staff_role;
        $staff->status = $request->boolean('status') ? User::STATUS_ACTIVE : User::STATUS_INACTIVE;
        $staff->is_staff = '1';

        if ($request->filled('password')) {
            $staff->password = Hash::make($request->password);
        }

        $staff->save();

        return redirect()->route('admin.staff-list')->with([
            'message' => trans('translate.Updated successfully'),
            'alert-type' => 'success',
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        $staff = User::findOrFail($id);

        if (auth('admin')->id() === $staff->id) {
            return redirect()->back()->with([
                'message' => trans('translate.Error'),
                'alert-type' => 'error',
            ]);
        }

        $staff->delete();

        return redirect()->route('admin.staff-list')->with([
            'message' => trans('translate.Delete Successfully'),
            'alert-type' => 'success',
        ]);
    }

    public function loginAsStaff(int $id): RedirectResponse
    {
        $staff = User::findOrFail($id);

        if ($staff->status !== User::STATUS_ACTIVE) {
            return redirect()->back()->with([
                'message' => trans('translate.Error'),
                'alert-type' => 'error',
            ]);
        }

        Auth::guard('web')->login($staff);
        request()->session()->regenerate();

        return redirect()->route('staff.dashboard');
    }

    public function roleMatrix()
    {
        return view('admin.staff.role_matrix', [
            'title' => trans('translate.Staff Permissions'),
            'permissionGroups' => config('admin_roles.staff_permission_groups', []),
            'selectedPermissions' => $this->currentPermissionMatrix(),
            'roleLabels' => [
                'staff_data_entry' => __('translate.Data Entry'),
                'staff_accountant' => __('translate.Accountant'),
            ],
            'submitRoute' => route('admin.staff-role-matrix.update'),
            'backRoute' => route('admin.staff-list'),
        ]);
    }

    public function agentRoleMatrix()
    {
        return view('admin.staff.role_matrix', [
            'title' => trans('translate.Agent Permissions'),
            'permissionGroups' => config('admin_roles.staff_permission_groups', []),
            'selectedPermissions' => $this->currentPermissionMatrix(),
            'roleLabels' => [
                'agent_travel' => __('translate.Travel Agent'),
                'agent_sales' => __('translate.Sales Agent'),
                'agent_booking' => __('translate.Booking Agent'),
            ],
            'submitRoute' => route('admin.agent-role-matrix.update'),
            'backRoute' => route('admin.seller-list'),
        ]);
    }

    public function updateRoleMatrix(Request $request): RedirectResponse
    {
        $permissionGroups = config('admin_roles.staff_permission_groups', []);

        $validated = $request->validate([
            'permissions' => ['required', 'array'],
            'permissions.staff_data_entry' => ['nullable', 'array'],
            'permissions.staff_accountant' => ['nullable', 'array'],
        ]);

        $filtered = $this->currentPermissionMatrix();
        foreach (['staff_data_entry', 'staff_accountant'] as $role) {
            $selected = array_values(array_unique(array_filter($validated['permissions'][$role] ?? [], function ($permissionKey) use ($permissionGroups) {
                return is_string($permissionKey) && array_key_exists($permissionKey, $permissionGroups);
            })));
            $filtered[$role] = $selected;
        }

        DB::table('global_settings')->updateOrInsert(
            ['key' => 'staff_role_permissions'],
            ['value' => json_encode($filtered)]
        );

        return redirect()->route('admin.staff-role-matrix')->with([
            'message' => trans('translate.Updated successfully'),
            'alert-type' => 'success',
        ]);
    }

    public function updateAgentRoleMatrix(Request $request): RedirectResponse
    {
        $permissionGroups = config('admin_roles.staff_permission_groups', []);

        $validated = $request->validate([
            'permissions' => ['required', 'array'],
            'permissions.agent_travel' => ['nullable', 'array'],
            'permissions.agent_sales' => ['nullable', 'array'],
            'permissions.agent_booking' => ['nullable', 'array'],
        ]);

        $filtered = $this->currentPermissionMatrix();
        foreach (['agent_travel', 'agent_sales', 'agent_booking'] as $role) {
            $selected = array_values(array_unique(array_filter($validated['permissions'][$role] ?? [], function ($permissionKey) use ($permissionGroups) {
                return is_string($permissionKey) && array_key_exists($permissionKey, $permissionGroups);
            })));
            $filtered[$role] = $selected;
        }

        DB::table('global_settings')->updateOrInsert(
            ['key' => 'staff_role_permissions'],
            ['value' => json_encode($filtered)]
        );

        return redirect()->route('admin.agent-role-matrix')->with([
            'message' => trans('translate.Updated successfully'),
            'alert-type' => 'success',
        ]);
    }

    private function currentPermissionMatrix(): array
    {
        $defaults = config('admin_roles.staff_default_permissions', []);
        $storedValue = DB::table('global_settings')->where('key', 'staff_role_permissions')->value('value');

        if (! is_string($storedValue) || $storedValue === '') {
            return $defaults;
        }

        $decoded = json_decode($storedValue, true);

        if (! is_array($decoded)) {
            return $defaults;
        }

        return [
            'staff_data_entry' => array_values($decoded['staff_data_entry'] ?? $defaults['staff_data_entry'] ?? []),
            'staff_accountant' => array_values($decoded['staff_accountant'] ?? $defaults['staff_accountant'] ?? []),
            'agent_travel' => array_values($decoded['agent_travel'] ?? $defaults['agent_travel'] ?? []),
            'agent_sales' => array_values($decoded['agent_sales'] ?? $defaults['agent_sales'] ?? []),
            'agent_booking' => array_values($decoded['agent_booking'] ?? $defaults['agent_booking'] ?? []),
        ];
    }
}