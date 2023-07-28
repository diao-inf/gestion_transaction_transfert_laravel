<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Compte>
 */
class CompteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numeroCompte' => $this->faker->unique()->randomNumber(6),
            'solde' => $this->faker->numberBetween(1000, 100000),
            'fournisseur' => $this->faker->randomElement(['ORANGE MONEY', 'WAVE', 'WARI', 'CB']),
            'client_id' => Client::factory()->create()->id,
        ];
    }
}
