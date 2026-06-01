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
        Schema::create('special_booking_feature_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_feature_id')
                ->constrained('special_booking_features')
                ->onDelete('cascade')
                ->name('sb_feature_trans_fk');
            $table->string('lang_code');
            $table->string('title');
            $table->text('short_description')->nullable();
            $table->timestamps();

            $table->unique(['booking_feature_id', 'lang_code'], 'sb_feature_trans_unique');
        });

        // Backfill existing records into the default language
        $defaultLang = function_exists('admin_lang') ? admin_lang() : 'en';
        $items = DB::table('special_booking_features')->get();
        foreach ($items as $item) {
            DB::table('special_booking_feature_translations')->updateOrInsert(
                [
                    'booking_feature_id' => $item->id,
                    'lang_code' => $defaultLang,
                ],
                [
                    'title' => $item->title,
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
        Schema::dropIfExists('special_booking_feature_translations');
    }
};
