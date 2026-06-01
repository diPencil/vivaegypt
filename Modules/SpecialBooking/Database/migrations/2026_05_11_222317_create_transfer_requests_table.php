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
        Schema::create('transfer_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_reference')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->string('vehicle_type'); // limousine, hiace, coaster, large_bus
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->date('pickup_date');
            $table->time('pickup_time');
            $table->integer('passengers_count');
            $table->integer('luggage_count')->nullable();
            $table->string('transfer_type'); // one_way, round_trip
            $table->boolean('is_airport_transfer')->default(false);
            $table->string('flight_number')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // pending, contacted, confirmed, cancelled, completed
            $table->text('admin_notes')->nullable();
            $table->decimal('quoted_price', 10, 2)->nullable();
            $table->string('payment_status')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('status');
            $table->index('pickup_date');
            $table->index('vehicle_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_requests');
    }
};
