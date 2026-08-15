<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengguna_tulisan', function (Blueprint $table) {
            $table->string('layout')->default('artikel1')->after('kategori_id');
            $table->string('jenis_artikel')->default('free')->after('layout');
            $table->date('tanggal_publikasi')->nullable()->after('jenis_artikel');
            $table->string('sponsor')->nullable()->after('tanggal_publikasi');
            $table->json('gambar_array')->nullable()->after('gambar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengguna_tulisan', function (Blueprint $table) {
            $table->dropColumn(['layout', 'jenis_artikel', 'tanggal_publikasi', 'sponsor', 'gambar_array']);
        });
    }
};
