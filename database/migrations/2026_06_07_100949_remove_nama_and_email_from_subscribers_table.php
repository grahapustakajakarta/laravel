<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * FASE 2 Normalisasi 3NF: Cleanup
 * Menghapus kolom redundan `nama` dan `email` dari tabel `subscribers`.
 * Identitas kini sepenuhnya mengandalkan `pengguna_id`.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscribers', function (Blueprint $table) {
            $table->dropColumn(['nama', 'email']);
        });
    }

    public function down(): void
    {
        Schema::table('subscribers', function (Blueprint $table) {
            $table->string('nama')->nullable();
            $table->string('email')->nullable();
        });
    }
};
