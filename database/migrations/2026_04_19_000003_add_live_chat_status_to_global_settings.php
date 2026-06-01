<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $keys = ['live_chat_status'];
        $defaults = ['live_chat_status' => '0'];

        foreach ($keys as $key) {
            $exists = DB::table('global_settings')->where('key', $key)->exists();
            if (!$exists) {
                DB::table('global_settings')->insert([
                    'key'        => $key,
                    'value'      => $defaults[$key],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('global_settings')->where('key', 'live_chat_status')->delete();
    }
};
