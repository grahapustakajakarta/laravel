<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah ENUM role agar mencakup 'user' juga
        DB::statement("ALTER TABLE pengguna MODIFY COLUMN role ENUM('superadmin', 'admin', 'user') NOT NULL DEFAULT 'user'");
    }

    public function down(): void
    {
        // Kembalikan ke hanya superadmin & admin (hanya jika tidak ada data user)
        DB::statement("ALTER TABLE pengguna MODIFY COLUMN role ENUM('superadmin', 'admin') NOT NULL DEFAULT 'admin'");
    }
};
