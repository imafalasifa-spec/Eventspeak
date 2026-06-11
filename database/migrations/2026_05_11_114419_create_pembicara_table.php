<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('penyelenggara')) {
            Schema::create('penyelenggara', function (Blueprint $table) {
                $table->increments('id_penyelenggara');
                $table->string('instansi', 100);
                $table->string('peran', 100);
                $table->string('deskripsi_instansi', 100);
                $table->string('portofolio_instansi', 100);
                $table->unsignedInteger('id_user');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pembicara');
    }
};
