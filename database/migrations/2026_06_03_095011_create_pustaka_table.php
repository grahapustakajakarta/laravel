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
        Schema::create('pustaka', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('tipe_buku')->nullable(); // e.g. A Novel
            $table->unsignedBigInteger('penulis_id')->nullable(); // relasi ke tabel penulis
            $table->boolean('is_on_tour')->default(false);
            $table->string('harga')->nullable();
            
            // Detail Buku Accordion
            $table->string('penerbit')->nullable();
            $table->string('isbn')->nullable();
            $table->string('bahasa')->nullable();
            $table->string('tanggal_terbit')->nullable();
            $table->string('halaman')->nullable();
            $table->string('format_buku')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('berat')->nullable();
            
            // Accordion Text & Deskripsi
            $table->text('deskripsi')->nullable();
            $table->text('ulasan')->nullable();
            $table->text('tentang_pengarang')->nullable();
            
            // Tombol & Links
            $table->string('link_vidio_produk')->nullable();
            $table->string('link_read_sample')->nullable();
            $table->string('link_tokopedia')->nullable();
            $table->string('link_shopee')->nullable();
            $table->string('link_instagram')->nullable();
            $table->string('link_tiktok')->nullable();
            $table->string('link_coffeesophia')->nullable();
            $table->string('link_togamas')->nullable();
            $table->string('link_ebook')->nullable();
            $table->string('link_lainnya')->nullable();
            
            // Gambar Slide
            $table->string('gambar_1')->nullable();
            $table->string('gambar_2')->nullable();
            $table->string('gambar_3')->nullable();

            $table->timestamps();

            // Setup foreign key jika tabel penulis sudah ada. Kita biarkan soft link atau beri constraint jika pasti.
            // $table->foreign('penulis_id')->references('id')->on('penulis')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pustaka');
    }
};
