<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('admins')->whereIn('admin_type', [
            'staff_data_entry',
            'staff_accountant',
            'agent_travel',
            'agent_sales',
            'agent_booking',
        ])->delete();
    }

    public function down(): void
    {
        // Legacy staff rows are intentionally not restored.
    }
};