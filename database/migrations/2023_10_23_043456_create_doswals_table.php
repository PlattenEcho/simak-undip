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
        Schema::create('dosen_wali', function (Blueprint $table) {
            $table->string('nip', 20)->primary();
            $table->string('nama', 100);
            $table->integer('tahun_masuk');
            $table->string('gelar_depan', 10);
            $table->string('gelar_belakang', 10);
            $table->text('alamat');
            $table->string('email', 100);
            $table->string('nomor_telepon', 12);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dosen_wali');
    }
};