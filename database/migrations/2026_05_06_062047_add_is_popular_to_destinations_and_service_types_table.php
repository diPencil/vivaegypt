<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('destinations')) {
            Schema::table('destinations', function (Blueprint $table) {
                if (!Schema::hasColumn('destinations', 'is_popular')) {
                    $table->boolean('is_popular')->default(false)->after('is_featured');
                }
            });
        }

        if (Schema::hasTable('service_types')) {
            Schema::table('service_types', function (Blueprint $table) {
                if (!Schema::hasColumn('service_types', 'is_popular')) {
                    $table->boolean('is_popular')->default(false)->after('is_featured');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('destinations')) {
            Schema::table('destinations', function (Blueprint $table) {
                if (Schema::hasColumn('destinations', 'is_popular')) {
                    $table->dropColumn('is_popular');
                }
            });
        }

        if (Schema::hasTable('service_types')) {
            Schema::table('service_types', function (Blueprint $table) {
                if (Schema::hasColumn('service_types', 'is_popular')) {
                    $table->dropColumn('is_popular');
                }
            });
        }
    }
};
