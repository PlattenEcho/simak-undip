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
        Schema::create('khs', function (Blueprint $table) {
            $table->increments('id_khs');
            $table->string('nim', 14);
            $table->unsignedSmallInteger('semester');
            $table->unsignedSmallInteger('sks_smt');
            $table->unsignedSmallInteger('sks_kum');
            $table->double('ips');
            $table->double('ipk');
            $table->string('scan_khs', 100);

            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khs');
    }
};
