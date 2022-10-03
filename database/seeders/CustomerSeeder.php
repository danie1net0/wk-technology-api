<?php

namespace Database\Seeders;

use App\Models\{Address, Customer};
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::factory()
            ->count(20)
            ->has(Address::factory())
            ->create();
    }
}
