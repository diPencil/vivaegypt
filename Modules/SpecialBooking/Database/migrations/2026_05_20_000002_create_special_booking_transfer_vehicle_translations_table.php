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
        Schema::create('special_booking_transfer_vehicle_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_vehicle_id')
                ->constrained('special_booking_transfer_vehicles')
                ->onDelete('cascade')
                ->name('sb_transfer_vehicle_trans_fk');
            $table->string('lang_code');
            $table->string('title');
            $table->text('short_description')->nullable();
            $table->string('capacity_text')->nullable();
            $table->timestamps();

            $table->unique(['transfer_vehicle_id', 'lang_code'], 'sb_transfer_trans_unique');
        });

        // Backfill existing records into the default language
        $defaultLang = function_exists('admin_lang') ? admin_lang() : 'en';
        $items = DB::table('special_booking_transfer_vehicles')->get();
        foreach ($items as $item) {
            DB::table('special_booking_transfer_vehicle_translations')->updateOrInsert(
                [
                    'transfer_vehicle_id' => $item->id,
                    'lang_code' => $defaultLang,
                ],
                [
                    'title' => $item->title,
                    'short_description' => $item->short_description,
                    'capacity_text' => $item->capacity_text,
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
        Schema::dropIfExists('special_booking_transfer_vehicle_translations');
    }
};
