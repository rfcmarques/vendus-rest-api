<?php

namespace Database\Factories;

use App\Models\Partner;
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
            'vat' => $this->faker->unique(true)->numberBetween(100000000, 999999999),
            'email' => $this->faker->unique(true)->companyEmail(),
            'address' => $this->faker->address(),
            'partner_id' => Partner::factory(),
            'discount' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
