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
        Schema::create('magzs', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('kategori', 100);
            $table->text('deskripsi')->nullable();
            $table->string('cover_gambar')->nullable();
            $table->string('file_pdf');
            $table->bigInteger('harga')->nullable()->default(0); // Tambahan harga untuk MAGZ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magzs');
    }
};
