<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengguna_id');
            $table->string('order_id')->unique();
            $table->decimal('gross_amount', 15, 2);
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->json('items'); // [{type:'magz', id:1}, {type:'pustaka', id:2}]
            $table->timestamps();

            $table->foreign('pengguna_id')->references('id')->on('pengguna')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_transactions');
    }
};
