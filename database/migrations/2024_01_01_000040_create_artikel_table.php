<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artikel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('restrict');
            $table->foreignId('penulis_id')->constrained('penulis')->onDelete('restrict');
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('sinopsis')->nullable();
            $table->longText('konten');
            $table->date('tanggal_publikasi')->index();
            $table->string('sponsor')->nullable();
            $table->integer('jumlah_tayang')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artikel');
    }
};
