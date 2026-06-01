<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Older installs may still have the legacy LMS column on support_tickets.
 * Fresh installs use reference_id from the SupportTicket module migration.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('support_tickets')) {
            return;
        }

        $legacyColumn = 'co' . 'urse_id';

        if (! Schema::hasColumn('support_tickets', $legacyColumn) || Schema::hasColumn('support_tickets', 'reference_id')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE `support_tickets` CHANGE `{$legacyColumn}` `reference_id` INT NOT NULL DEFAULT 0");
        } elseif ($driver === 'sqlite') {
            DB::statement("ALTER TABLE support_tickets RENAME COLUMN {$legacyColumn} TO reference_id");
        } else {
            Schema::table('support_tickets', function (Blueprint $table) use ($legacyColumn) {
                $table->renameColumn($legacyColumn, 'reference_id');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('support_tickets')) {
            return;
        }

        $legacyColumn = 'co' . 'urse_id';

        if (! Schema::hasColumn('support_tickets', 'reference_id') || Schema::hasColumn('support_tickets', $legacyColumn)) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE `support_tickets` CHANGE `reference_id` `{$legacyColumn}` INT NOT NULL DEFAULT 0");
        } elseif ($driver === 'sqlite') {
            DB::statement("ALTER TABLE support_tickets RENAME COLUMN reference_id TO {$legacyColumn}");
        } else {
            Schema::table('support_tickets', function (Blueprint $table) use ($legacyColumn) {
                $table->renameColumn('reference_id', $legacyColumn);
            });
        }
    }
};
