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
        Schema::create('spa_services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->string('image')->nullable();
            $table->integer('duration_minutes');
            $table->decimal('price', 10, 2)->nullable();
            $table->string('price_note')->nullable();
            $table->string('location')->nullable();
            $table->string('gender_type')->default('all'); // all, men, women, couples, family
            $table->json('available_days')->nullable();
            $table->time('available_time_from')->nullable();
            $table->time('available_time_to')->nullable();
            $table->integer('max_guests_per_slot')->default(1);
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('status');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spa_services');
    }
};
