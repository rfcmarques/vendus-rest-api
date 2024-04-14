<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Partner;
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
        Customer::factory(10000)->recycle(Partner::factory(5000)->create())->create();
        Supplier::factory(500)->create();
    }
}
