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
        DB::table('kategori')
            ->where('nama', 'Editor Choice')
            ->update([
                'nama' => 'Editor\'s Choice',
                'slug' => 'editors-choice',
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('kategori')
            ->where('nama', 'Editor\'s Choice')
            ->update([
                'nama' => 'Editor Choice',
                'slug' => 'editor-choice',
            ]);
    }
};
