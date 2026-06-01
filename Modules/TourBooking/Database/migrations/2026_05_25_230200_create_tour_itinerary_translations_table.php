<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_itinerary_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_itinerary_id')->constrained('tour_itineraries')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->string('meal_included')->nullable();
            $table->timestamps();

            $table->unique(['tour_itinerary_id', 'locale'], 'tour_itinerary_locale_unique');
        });

        $now = now();

        DB::table('tour_itineraries')->orderBy('id')->get()->each(function ($itinerary) use ($now) {
            DB::table('tour_itinerary_translations')->updateOrInsert(
                [
                    'tour_itinerary_id' => $itinerary->id,
                    'locale' => 'en',
                ],
                [
                    'title' => $itinerary->title,
                    'description' => $itinerary->description,
                    'location' => $itinerary->location,
                    'meal_included' => $itinerary->meal_included,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_itinerary_translations');
    }
};
