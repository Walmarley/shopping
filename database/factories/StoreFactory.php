<?php

namespace Database\Factories;

use App\Models\Shopping;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $idShopping = Shopping::all()->random()->id;
        $classificacao = fake()->randomElement(['Roupas', 'calçados', 'peças de automotivas', 'eletrodomésticos', 'supermercados', 'restaurantes', 'beleza', 'instituição bancária', 'livrarias', 'farmácias']);

        return [
            'shopping_id' => $idShopping,
            'nome' => fake()->name(),
            'RazaoSocial' => fake()->company(),
            'CNPJ' => fake()->randomNumber(9, true),
            'endereco' => fake()->address(),
            'classificacao' => $classificacao,
            'responsavel' => fake()->name(),
            'numeroDaLoja' => fake()->randomNumber(4, true),
        ];
    }
}
