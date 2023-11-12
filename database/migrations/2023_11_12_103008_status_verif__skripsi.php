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
        Schema::table('skripsi', function (Blueprint $table) {
            $table->dropColumn('statusVerif');
        });

        Schema::table('skripsi', function (Blueprint $table) {
            $table->enum('statusVerif', [0, 1])->default(0);
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
