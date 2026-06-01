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
        Schema::create('spa_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique();
            $table->foreignId('spa_service_id')->constrained('spa_services');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->date('preferred_date');
            $table->time('preferred_time');
            $table->integer('guests_count');
            $table->string('gender_type')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // pending, contacted, confirmed, cancelled, completed
            $table->text('admin_notes')->nullable();
            $table->decimal('quoted_price', 10, 2)->nullable();
            $table->string('payment_status')->nullable();
            $table->timestamps();

            $table->index('spa_service_id');
            $table->index('user_id');
            $table->index('status');
            $table->index('preferred_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spa_bookings');
    }
};
