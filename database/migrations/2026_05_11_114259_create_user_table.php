<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('user')) {
            Schema::create('user', function (Blueprint $table) {
                $table->increments('id_user');
                $table->string('nama_user', 100);
                $table->string('email_user', 100);
                $table->string('password_user', 255);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
