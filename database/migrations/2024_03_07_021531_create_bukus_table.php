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
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('kategori');
            $table->string('nama_buku');
            $table->double('harga');
            $table->integer('stok');
            $table->unsignedBigInteger('penerbit_id');
            $table->timestamps();
            $table->foreign('penerbit_id')->references('id')->on('penerbit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};