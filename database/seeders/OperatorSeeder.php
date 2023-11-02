<?php

namespace Database\Seeders;

use App\Models\Operator;
use Database\Factories\OperatorFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Operator::factory()->count(1)->create();
    }
}
