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
        Schema::create('flight_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_reference')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->string('trip_type'); // one_way, round_trip, multi_city
            $table->string('from_city');
            $table->string('to_city');
            $table->date('departure_date');
            $table->date('return_date')->nullable();
            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);
            $table->integer('infants')->default(0);
            $table->string('travel_class'); // economy, premium_economy, business, first
            $table->string('preferred_airline')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // pending, contacted, confirmed, cancelled, completed
            $table->text('admin_notes')->nullable();
            $table->decimal('quoted_price', 10, 2)->nullable();
            $table->string('payment_status')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('status');
            $table->index('departure_date');
            $table->index('trip_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_requests');
    }
};
