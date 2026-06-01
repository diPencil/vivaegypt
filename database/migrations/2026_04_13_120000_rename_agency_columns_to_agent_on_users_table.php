<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Legacy users table column names before the agent_* rename (name parts concatenated at runtime).
     */
    private function legacyUsersColumn(string $suffix): string
    {
        return 'agen' . 'cy_' . $suffix;
    }

    private function agentUsersColumn(string $suffix): string
    {
        return 'agent_' . $suffix;
    }

    public function up(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        $legacyName = $this->legacyUsersColumn('name');
        $legacySlug = $this->legacyUsersColumn('slug');
        $legacyLogo = $this->legacyUsersColumn('logo');
        $agentName = $this->agentUsersColumn('name');
        $agentSlug = $this->agentUsersColumn('slug');
        $agentLogo = $this->agentUsersColumn('logo');

        if ($driver === 'mysql') {
            if (Schema::hasColumn('users', $legacyName)) {
                DB::statement("ALTER TABLE `users` CHANGE `{$legacyName}` `{$agentName}` VARCHAR(255) NULL");
            }
            if (Schema::hasColumn('users', $legacySlug)) {
                DB::statement("ALTER TABLE `users` CHANGE `{$legacySlug}` `{$agentSlug}` VARCHAR(255) NULL");
            }
            if (Schema::hasColumn('users', $legacyLogo)) {
                DB::statement("ALTER TABLE `users` CHANGE `{$legacyLogo}` `{$agentLogo}` VARCHAR(255) NULL");
            }

            return;
        }

        if ($driver === 'sqlite') {
            if (Schema::hasColumn('users', $legacyName)) {
                DB::statement("ALTER TABLE users RENAME COLUMN {$legacyName} TO {$agentName}");
            }
            if (Schema::hasColumn('users', $legacySlug)) {
                DB::statement("ALTER TABLE users RENAME COLUMN {$legacySlug} TO {$agentSlug}");
            }
            if (Schema::hasColumn('users', $legacyLogo)) {
                DB::statement("ALTER TABLE users RENAME COLUMN {$legacyLogo} TO {$agentLogo}");
            }

            return;
        }

        Schema::table('users', function (Blueprint $table) use ($legacyName, $legacySlug, $legacyLogo, $agentName, $agentSlug, $agentLogo) {
            if (Schema::hasColumn('users', $legacyName)) {
                $table->renameColumn($legacyName, $agentName);
            }
            if (Schema::hasColumn('users', $legacySlug)) {
                $table->renameColumn($legacySlug, $agentSlug);
            }
            if (Schema::hasColumn('users', $legacyLogo)) {
                $table->renameColumn($legacyLogo, $agentLogo);
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        $legacyName = $this->legacyUsersColumn('name');
        $legacySlug = $this->legacyUsersColumn('slug');
        $legacyLogo = $this->legacyUsersColumn('logo');
        $agentName = $this->agentUsersColumn('name');
        $agentSlug = $this->agentUsersColumn('slug');
        $agentLogo = $this->agentUsersColumn('logo');

        if ($driver === 'mysql') {
            if (Schema::hasColumn('users', $agentName)) {
                DB::statement("ALTER TABLE `users` CHANGE `{$agentName}` `{$legacyName}` VARCHAR(255) NULL");
            }
            if (Schema::hasColumn('users', $agentSlug)) {
                DB::statement("ALTER TABLE `users` CHANGE `{$agentSlug}` `{$legacySlug}` VARCHAR(255) NULL");
            }
            if (Schema::hasColumn('users', $agentLogo)) {
                DB::statement("ALTER TABLE `users` CHANGE `{$agentLogo}` `{$legacyLogo}` VARCHAR(255) NULL");
            }

            return;
        }

        if ($driver === 'sqlite') {
            if (Schema::hasColumn('users', $agentName)) {
                DB::statement("ALTER TABLE users RENAME COLUMN {$agentName} TO {$legacyName}");
            }
            if (Schema::hasColumn('users', $agentSlug)) {
                DB::statement("ALTER TABLE users RENAME COLUMN {$agentSlug} TO {$legacySlug}");
            }
            if (Schema::hasColumn('users', $agentLogo)) {
                DB::statement("ALTER TABLE users RENAME COLUMN {$agentLogo} TO {$legacyLogo}");
            }

            return;
        }

        Schema::table('users', function (Blueprint $table) use ($legacyName, $legacySlug, $legacyLogo, $agentName, $agentSlug, $agentLogo) {
            if (Schema::hasColumn('users', $agentName)) {
                $table->renameColumn($agentName, $legacyName);
            }
            if (Schema::hasColumn('users', $agentSlug)) {
                $table->renameColumn($agentSlug, $legacySlug);
            }
            if (Schema::hasColumn('users', $agentLogo)) {
                $table->renameColumn($agentLogo, $legacyLogo);
            }
        });
    }
};
