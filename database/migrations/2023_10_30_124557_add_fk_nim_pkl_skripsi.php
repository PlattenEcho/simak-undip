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
            $table->foreign('nim')->references('nim')->on('mahasiswa');
        });

        Schema::table('skripsi', function (Blueprint $table) {
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->string('nilai')->change();
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
