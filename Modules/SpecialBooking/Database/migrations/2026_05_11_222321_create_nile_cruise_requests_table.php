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
        Schema::create('nile_cruise_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_reference')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->string('route')->nullable();
            $table->date('checkin_date');
            $table->integer('nights_count');
            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);
            $table->integer('cabins_count')->default(1);
            $table->string('cabin_type')->nullable();
            $table->string('budget_range')->nullable();
            $table->boolean('need_airport_transfer')->default(false);
            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // pending, contacted, confirmed, cancelled, completed
            $table->text('admin_notes')->nullable();
            $table->decimal('quoted_price', 10, 2)->nullable();
            $table->string('payment_status')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('status');
            $table->index('checkin_date');
            $table->index('route');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nile_cruise_requests');
    }
};
