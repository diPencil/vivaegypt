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
        Schema::table('users', function (Blueprint $table) {
            $table->string('agent_name')->nullable();
            $table->string('agent_slug')->unique()->nullable();
            $table->string('agent_logo')->nullable();
            $table->string('website')->nullable();
            $table->string('location_map')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('agent_name');
            $table->dropColumn('agent_slug');
            $table->dropColumn('agent_logo');
            $table->dropColumn('website');
            $table->dropColumn('location_map');
        });
    }
};
