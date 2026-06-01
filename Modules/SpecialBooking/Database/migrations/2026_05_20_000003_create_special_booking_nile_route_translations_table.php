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
        Schema::create('special_booking_nile_route_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nile_route_id')
                ->constrained('special_booking_nile_routes')
                ->onDelete('cascade')
                ->name('sb_nile_route_trans_fk');
            $table->string('lang_code');
            $table->string('title');
            $table->string('badge_text')->nullable();
            $table->text('short_description')->nullable();
            $table->timestamps();

            $table->unique(['nile_route_id', 'lang_code'], 'sb_nile_route_trans_unique');
        });

        // Backfill existing records into the default language
        $defaultLang = function_exists('admin_lang') ? admin_lang() : 'en';
        $items = DB::table('special_booking_nile_routes')->get();
        foreach ($items as $item) {
            DB::table('special_booking_nile_route_translations')->updateOrInsert(
                [
                    'nile_route_id' => $item->id,
                    'lang_code' => $defaultLang,
                ],
                [
                    'title' => $item->title,
                    'badge_text' => $item->badge_text,
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
        Schema::dropIfExists('special_booking_nile_route_translations');
    }
};
