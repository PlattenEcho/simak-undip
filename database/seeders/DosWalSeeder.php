<?php

namespace Database\Seeders;

use App\Models\Doswal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DosWalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Doswal::factory()->count(5)->create();
    }
}