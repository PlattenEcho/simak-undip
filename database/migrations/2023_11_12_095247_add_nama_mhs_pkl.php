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
        Schema::table('pkl', function (Blueprint $table) {
            $table->string('nama_mhs')->nullable();
        });

        Schema::table('skripsi', function (Blueprint $table) {
            $table->string('nama_mhs')->nullable();
            $table->string('nama_doswal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
