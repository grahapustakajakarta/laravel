<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tambahkan kategori "Prosa" ke tabel kategori.
     */
    public function up(): void
    {
        // Cek dulu agar tidak duplikat
        $exists = DB::table('kategori')
            ->where('nama', 'Prosa')
            ->orWhere('slug', 'prosa')
            ->exists();

        if (!$exists) {
            DB::table('kategori')->insert([
                'nama'       => 'Prosa',
                'slug'       => 'prosa',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Hapus kategori "Prosa" jika rollback.
     */
    public function down(): void
    {
        DB::table('kategori')
            ->where('nama', 'Prosa')
            ->whereNull('deleted_at')
            ->delete();
    }
};
