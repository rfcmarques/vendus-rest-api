<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
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
            'vat' => $this->faker->unique()->randomNumber(9, true),
            'email' => $this->faker->unique()->companyEmail(),
            'address' => $this->faker->address(),
            'max_due_days' => $this->faker->randomNumber(2, false),
            'contract_file' => "/files/" . $this->faker->unique()->slug(2) . ".pdf",
        ];
    }
}
