<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * FASE 1 Normalisasi 3NF:
 * Tambah kolom pengguna_id ke tabel subscribers.
 * - Backfill data eksisting dari pengguna.email == subscribers.email
 * - Kolom nama & email di subscribers TETAP ADA (tidak dihapus) untuk backward compat.
 * - Relasi yang sebelumnya dilakukan via email kini dilengkapi via pengguna_id (FK).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscribers', function (Blueprint $table) {
            // Tambah kolom pengguna_id (nullable dulu untuk backward compat data lama)
            $table->unsignedBigInteger('pengguna_id')->nullable()->after('id');
            $table->index('pengguna_id');
        });

        // Backfill: cocokkan email subscribers dengan email di tabel pengguna
        DB::statement("
            UPDATE subscribers s
            INNER JOIN pengguna p ON p.email = s.email
            SET s.pengguna_id = p.id
        ");

        // Setelah backfill, tambah FK constraint
        Schema::table('subscribers', function (Blueprint $table) {
            $table->foreign('pengguna_id')
                  ->references('id')
                  ->on('pengguna')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('subscribers', function (Blueprint $table) {
            $table->dropForeign(['pengguna_id']);
            $table->dropIndex(['pengguna_id']);
            $table->dropColumn('pengguna_id');
        });
    }
};
