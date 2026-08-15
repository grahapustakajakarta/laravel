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
            $table->foreignId('artikel_id')->nullable()->constrained('artikel')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengguna_tulisan', function (Blueprint $table) {
            $table->dropForeign(['artikel_id']);
            $table->dropColumn('artikel_id');
        });
    }
};
