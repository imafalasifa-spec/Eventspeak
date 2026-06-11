<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Jenis_Event', 100);
            $table->string('Nama_Event', 225);
            $table->text('Deskripsi');
            $table->date('Tanggal');
            $table->string('Lokasi', 255);
            $table->integer('Harga');
            $table->string('Pemateri', 100);
            $table->string('Gambar', 255);
            $table->unsignedInteger('id_penyelenggara')->nullable();

            $table->foreign('id_penyelenggara')
                  ->references('id_penyelenggara')
                  ->on('penyelenggara')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event');
    }
};