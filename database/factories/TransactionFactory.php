<?php

namespace Database\Factories;

use App\Models\Compte;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['DEPOT', 'RETRAIT', 'TRANSFERT']),
            'montant' => $this->faker->numberBetween(10000, 100000),
            'frais' => $this->faker->randomFloat(2, 1, 10),
            'is_immediate' => $this->faker->boolean,
            'code' => $this->faker->optional()->randomNumber(6),
            'compte_source_id' => Compte::factory()->create()->id,
            'compte_destinataire_id' => Compte::factory()->create()->id,
        ];
    }
}
