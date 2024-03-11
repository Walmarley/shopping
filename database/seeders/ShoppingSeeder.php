<?php

namespace Database\Seeders;

use App\Models\Shopping;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShoppingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shopping::factory(10)->create();
    }
}
