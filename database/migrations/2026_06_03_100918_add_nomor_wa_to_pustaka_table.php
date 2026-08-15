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
        Schema::table('pustaka', function (Blueprint $table) {
            $table->string('nomor_wa')->nullable()->after('link_lainnya');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pustaka', function (Blueprint $table) {
            $table->dropColumn('nomor_wa');
        });
    }
};
