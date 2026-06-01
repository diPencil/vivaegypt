<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('support_tickets')) {
            return;
        }

        DB::table('support_tickets')->where('admin_type', 'tour_guide')->update(['admin_type' => 'agent']);
    }

    public function down(): void
    {
        // Intentionally empty: reverting would corrupt rows that were always `agent`.
    }
};
