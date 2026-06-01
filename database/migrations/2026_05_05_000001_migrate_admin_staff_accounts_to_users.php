<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $staffTypes = [
            'staff_data_entry',
            'staff_accountant',
            'agent_travel',
            'agent_sales',
            'agent_booking',
        ];

        $admins = DB::table('admins')
            ->whereIn('admin_type', $staffTypes)
            ->get();

        foreach ($admins as $admin) {
            $exists = DB::table('users')->where('email', $admin->email)->exists();

            if ($exists) {
                continue;
            }

            DB::table('users')->insert([
                'name' => $admin->name,
                'email' => $admin->email,
                'password' => $admin->password,
                'status' => $admin->status,
                'is_banned' => 'no',
                'is_seller' => '0',
                'is_staff' => '1',
                'staff_role' => $admin->admin_type,
                'created_at' => $admin->created_at,
                'updated_at' => $admin->updated_at,
            ]);
        }
    }

    public function down(): void
    {
        $staffTypes = [
            'staff_data_entry',
            'staff_accountant',
            'agent_travel',
            'agent_sales',
            'agent_booking',
        ];

        $emails = DB::table('admins')
            ->whereIn('admin_type', $staffTypes)
            ->pluck('email');

        if ($emails->isNotEmpty()) {
            DB::table('users')->whereIn('email', $emails)->delete();
        }
    }
};