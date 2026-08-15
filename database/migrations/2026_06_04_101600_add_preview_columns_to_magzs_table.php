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
        Schema::table('magzs', function (Blueprint $table) {
            $table->string('edisi')->nullable()->after('judul');
            $table->longText('isi_preview')->nullable()->after('deskripsi');
            $table->longText('table_of_contents')->nullable()->after('isi_preview');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('magzs', function (Blueprint $table) {
            $table->dropColumn(['edisi', 'isi_preview', 'table_of_contents']);
        });
    }
};
