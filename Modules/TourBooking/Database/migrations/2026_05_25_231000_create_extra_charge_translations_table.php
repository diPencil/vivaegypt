<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('extra_charge_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('extra_charge_id')->constrained('extra_charges')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['extra_charge_id', 'locale'], 'extra_charge_locale_unique');
        });

        $now = now();

        DB::table('extra_charges')->orderBy('id')->get()->each(function ($charge) use ($now) {
            DB::table('extra_charge_translations')->updateOrInsert(
                [
                    'extra_charge_id' => $charge->id,
                    'locale' => 'en',
                ],
                [
                    'name' => $charge->name,
                    'description' => $charge->description,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extra_charge_translations');
    }
};
