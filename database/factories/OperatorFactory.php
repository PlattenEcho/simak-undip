<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Operator>
 */
class OperatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create([
            'name' => 'operatorinformatika',
            'username' => 'operatorif', 
            'password' => bcrypt('12345'),
            'idrole' => '1'
        ]);

        return [
            'nama' => 'operatorinformatika',
            'username' => 'operatorif',
            'password' => '12345',
        ];
    }
}