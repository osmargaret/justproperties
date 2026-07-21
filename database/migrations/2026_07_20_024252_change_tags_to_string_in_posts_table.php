<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Convert existing JSON tag arrays to comma-separated strings
        DB::table('posts')->whereNotNull('tags')->orderBy('id')->each(function ($post) {
            $tags = json_decode($post->tags, true);
            if (is_array($tags)) {
                DB::table('posts')->where('id', $post->id)->update([
                    'tags' => implode(', ', $tags),
                ]);
            }
        });

        // Change the column type from json to text
        Schema::table('posts', function (Blueprint $table) {
            $table->text('tags')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Best-effort reverse: convert comma strings back to JSON arrays
        DB::table('posts')->whereNotNull('tags')->orderBy('id')->each(function ($post) {
            $tags = array_values(array_filter(array_map('trim', explode(',', $post->tags))));
            DB::table('posts')->where('id', $post->id)->update([
                'tags' => json_encode($tags),
            ]);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->json('tags')->nullable()->change();
        });
    }
};
