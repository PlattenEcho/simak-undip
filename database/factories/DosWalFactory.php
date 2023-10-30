<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DosWal>
 */
class DosWalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nip = '';
        for ($i = 0; $i < 18; $i++) {
            $nip .= $this->faker->randomDigit;
        }

        $no_telp = '';
        for ($i = 0; $i < 12; $i++) {
            $no_telp .= $this->faker->randomDigit;
        }

        $name = $this->faker->name;
        $username = strtolower(str_replace(' ', '', $name));


        $user = User::factory()->create([
            'name' => $name,
            'username' => $username, 
            'password' => bcrypt('12345'),
            'idrole' => '3'
        ]);

        return [
            'nip' => $nip,
            'nama' => $name,
            'tahun_masuk' => $this->faker->numberBetween(2000, 2009),
            'gelar_depan' => $this->faker->randomElement(['Ir.', 'Dr.', 'Dr.Eng.']),
            'gelar_belakang' => $this->faker->randomElement(['M.T.', 'M.Kom.', 'M.Si.', 'S.T.']),
            'alamat' => $this->faker->address,
            'nomor_telepon' => $no_telp
        ];
    }
}