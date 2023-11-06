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
        Schema::table('departemens', function (Blueprint $table) {
            $table->string('nip');
            $table->integer('tahun_masuk');
            $table->string('alamat');
            $table->string('no_telepon');
	        $table->string('foto')->nullable();
            $table->unsignedBigInteger('iduser');
            $table->foreign('iduser')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departemens', function (Blueprint $table) {
            //
        });
    }
};
