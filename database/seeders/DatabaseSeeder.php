<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Supplier;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Customer::factory(100)->create();
        Supplier::factory(100)->create();
    }
}
