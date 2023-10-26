<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->string('nim', 14)->primary();
            $table->string('nama', 255);
            $table->integer('angkatan');
            $table->string('status', 20)->nullable();
            $table->string('jalur_masuk', 10)->nullable();
            $table->text('alamat')->nullable();
            $table->string('kabupaten', 50)->nullable();
            $table->string('provinsi', 50)->nullable();
            $table->string('username', 100)->nullable();
            $table->string('nomor_telepon', 12)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
};
