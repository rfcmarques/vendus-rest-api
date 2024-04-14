<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partner>
 */
class PartnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'vat' => $this->faker->unique()->numberBetween(100000000, 999999999),
            'email' => $this->faker->unique()->companyEmail(),
            'address' => $this->faker->address(),
            'comission' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
