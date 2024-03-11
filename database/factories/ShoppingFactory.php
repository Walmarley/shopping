<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shopping>
 */
class ShoppingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $idUser = User::all()->random()->id;
        
        return [
            'user_id' => $idUser,
            'nome' => fake()->name(),
            'RazaoSocial' => fake()->company(),
            'CNPJ' => fake()->randomNumber(9, true),
            'endereco' => fake()->address(),
        ];
    }
}
