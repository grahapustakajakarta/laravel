<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE subscribers MODIFY COLUMN paket VARCHAR(50) DEFAULT 'bulanan'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE subscribers MODIFY COLUMN paket ENUM('bulanan', 'tahunan') DEFAULT 'bulanan'");
    }
};
