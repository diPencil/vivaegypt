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
        Schema::create('spa_service_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spa_service_id')->constrained('spa_services')->onDelete('cascade');
            $table->string('lang_code');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('price_note')->nullable();
            $table->string('location')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->unique(['spa_service_id', 'lang_code'], 'sb_spa_service_trans_unique');
        });

        // Backfill existing records into the default language
        $defaultLang = function_exists('admin_lang') ? admin_lang() : 'en';
        $items = DB::table('spa_services')->get();
        foreach ($items as $item) {
            DB::table('spa_service_translations')->updateOrInsert(
                [
                    'spa_service_id' => $item->id,
                    'lang_code' => $defaultLang,
                ],
                [
                    'title' => $item->title,
                    'description' => $item->description,
                    'short_description' => $item->short_description,
                    'price_note' => $item->price_note,
                    'location' => $item->location,
                    'meta_title' => $item->meta_title,
                    'meta_description' => $item->meta_description,
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
        Schema::dropIfExists('spa_service_translations');
    }
};
