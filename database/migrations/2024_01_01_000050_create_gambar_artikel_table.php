<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gambar_artikel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artikel_id')->constrained('artikel')->onDelete('cascade');
            $table->string('file_gambar');
            $table->string('deskripsi')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gambar_artikel');
    }
};
