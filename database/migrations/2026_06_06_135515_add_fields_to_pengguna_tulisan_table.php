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
            $table->text('sinopsis')->nullable()->after('judul');
            $table->string('gambar')->nullable()->after('sinopsis');
            $table->text('alasan_penolakan')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengguna_tulisan', function (Blueprint $table) {
            $table->dropColumn(['sinopsis', 'gambar', 'alasan_penolakan']);
        });
    }
};
