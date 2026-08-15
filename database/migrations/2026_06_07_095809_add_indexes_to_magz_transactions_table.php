<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * FASE 1 Normalisasi 3NF:
 * Tambah index pada kolom pengguna_id dan magz_id di magz_transactions
 * agar query JOIN dan WHERE lebih efisien.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('magz_transactions', function (Blueprint $table) {
            $table->index('pengguna_id', 'magz_transactions_pengguna_id_index');
            $table->index('magz_id', 'magz_transactions_magz_id_index');
            $table->index('status', 'magz_transactions_status_index');
        });
    }

    public function down(): void
    {
        Schema::table('magz_transactions', function (Blueprint $table) {
            // Hapus constraint foreign key sementara agar index bisa dihapus
            $table->dropForeign(['pengguna_id']);
            $table->dropForeign(['magz_id']);
            
            $table->dropIndex('magz_transactions_pengguna_id_index');
            $table->dropIndex('magz_transactions_magz_id_index');
            $table->dropIndex('magz_transactions_status_index');
            
            // Kembalikan constraint foreign key
            $table->foreign('pengguna_id')->references('id')->on('pengguna')->onDelete('cascade');
            $table->foreign('magz_id')->references('id')->on('magzs')->onDelete('cascade');
        });
    }
};
