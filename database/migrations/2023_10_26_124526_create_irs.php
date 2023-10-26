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
        Schema::create('irs', function (Blueprint $table) {
            $table->increments('id_irs');
            $table->string('nim', 14);
            $table->unsignedSmallInteger('semester');
            $table->unsignedSmallInteger('jml_sks');
            $table->string('scan_irs', 100);
            $table->string('nama_mhs', 255);
            $table->string('nama_doswal', 255);
            $table->string('status', 10)->default("Unverified");

            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('irs', function (Blueprint $table) {
            $table->dropForeign(['nim']);
        });

        Schema::dropIfExists('irs');
    }
};