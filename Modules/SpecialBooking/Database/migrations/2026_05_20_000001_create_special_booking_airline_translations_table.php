<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('special_booking_airline_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('airline_id')->constrained('special_booking_airlines')->onDelete('cascade');
            $table->string('lang_code');
            $table->string('name');
            $table->text('short_description')->nullable();
            $table->timestamps();

            $table->unique(['airline_id', 'lang_code'], 'sb_airline_trans_unique');
        });

        // Backfill existing records into the default language
        $defaultLang = function_exists('admin_lang') ? admin_lang() : 'en';
        $items = DB::table('special_booking_airlines')->get();
        foreach ($items as $item) {
            DB::table('special_booking_airline_translations')->updateOrInsert(
                [
                    'airline_id' => $item->id,
                    'lang_code' => $defaultLang,
                ],
                [
                    'name' => $item->name,
                    'short_description' => $item->short_description,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_booking_airline_translations');
    }
};
