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
            $table->string('kode_mk', 10);
            $table->unsignedSmallInteger('semester');
            $table->unsignedSmallInteger('jml_sks');
            $table->string('scan_irs', 100);

            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('kode_mk')->references('kode_mk')->on('matkul')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('irs', function (Blueprint $table) {
            $table->dropForeign(['nim']);
            $table->dropForeign(['kode_mk']);
        });

        Schema::dropIfExists('irs');
    }
};