<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::factory()->create(['idrole' => 1, 'nama' => 'operator']);
        Role::factory()->create(['idrole' => 2, 'nama' => 'departemen']);
        Role::factory()->create(['idrole' => 3, 'nama' => 'dosen wali']);
        Role::factory()->create(['idrole' => 4, 'nama' => 'mahasiswa']);
    }
}
