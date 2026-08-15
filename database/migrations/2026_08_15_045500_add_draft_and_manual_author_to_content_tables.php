<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Artikel
        Schema::table('artikel', function (Blueprint $table) {
            // Make penulis_id nullable. Since it's already a foreign key, changing it to nullable in MySQL requires modifying the column type.
            $table->unsignedBigInteger('penulis_id')->nullable()->change();
            
            if (!Schema::hasColumn('artikel', 'penulis_manual')) {
                $table->string('penulis_manual')->nullable()->after('penulis_id');
            }
            if (!Schema::hasColumn('artikel', 'status')) {
                $table->string('status')->default('publish')->after('jumlah_tayang');
            }
        });

        // 2. Pustaka
        Schema::table('pustaka', function (Blueprint $table) {
            // pustaka already has nullable penulis_id
            if (!Schema::hasColumn('pustaka', 'penulis_manual')) {
                $table->string('penulis_manual')->nullable()->after('penulis_id');
            }
            if (!Schema::hasColumn('pustaka', 'status')) {
                $table->string('status')->default('publish')->after('harga');
            }
        });

        // 3. Magz
        Schema::table('magzs', function (Blueprint $table) {
            if (!Schema::hasColumn('magzs', 'status')) {
                $table->string('status')->default('publish')->after('harga');
            }
        });

        // 4. Publikasi
        Schema::table('publikasi', function (Blueprint $table) {
            if (!Schema::hasColumn('publikasi', 'status')) {
                $table->string('status')->default('publish')->after('file_pdf');
            }
        });
    }

    public function down(): void
    {
        Schema::table('artikel', function (Blueprint $table) {
            // Cannot easily revert nullable change here without knowing previous state, but we can drop the columns
            if (Schema::hasColumn('artikel', 'penulis_manual')) {
                $table->dropColumn('penulis_manual');
            }
            if (Schema::hasColumn('artikel', 'status')) {
                $table->dropColumn('status');
            }
        });

        Schema::table('pustaka', function (Blueprint $table) {
            if (Schema::hasColumn('pustaka', 'penulis_manual')) {
                $table->dropColumn('penulis_manual');
            }
            if (Schema::hasColumn('pustaka', 'status')) {
                $table->dropColumn('status');
            }
        });

        Schema::table('magzs', function (Blueprint $table) {
            if (Schema::hasColumn('magzs', 'status')) {
                $table->dropColumn('status');
            }
        });

        Schema::table('publikasi', function (Blueprint $table) {
            if (Schema::hasColumn('publikasi', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
