<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Departemen>
 */
class DepartemenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create([
            'name' => 'departemeninformatika',
            'username' => 'departemenif', 
            'password' => bcrypt('12345'),
            'idrole' => '2'
        ]);

        return [
            'nama' => 'departemeninformatika',
            'username' => 'departemenif', 
            'password' => bcrypt('12345'),
            'nip' => '987654321',
            'tahun_masuk' => '2017',
            'alamat' => 'Jl. Pemuda',
            'no_telepon' => '082208768843',
            'iduser' => $user->id,
        ];
    }
}
