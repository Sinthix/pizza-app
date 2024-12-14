<?php

namespace Database\Seeders;

use App\Models\Pizza;
use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class PizzaSeeder extends Seeder
{
    public function run()
    {
        Pizza::factory()
            ->count(10)  
            ->hasAttached(Ingredient::factory()->count(3)) 
            ->create();
    }
}
