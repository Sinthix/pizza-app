<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ingredients')->insert([
            ['name' => 'Mozzarella', 'cost_price' => 0.50, 'randomisation_percentage' => 30],
            ['name' => 'Pepperoni', 'cost_price' => 1.20, 'randomisation_percentage' => 25],
            ['name' => 'Mushrooms', 'cost_price' => 0.80, 'randomisation_percentage' => 15],
            ['name' => 'Green Peppers', 'cost_price' => 0.70, 'randomisation_percentage' => 10],
            ['name' => 'Black Olives', 'cost_price' => 0.90, 'randomisation_percentage' => 10],
            ['name' => 'Italian Sausage', 'cost_price' => 1.50, 'randomisation_percentage' => 20],
            ['name' => 'Pineapple', 'cost_price' => 0.85, 'randomisation_percentage' => 5],
            ['name' => 'Onions', 'cost_price' => 0.40, 'randomisation_percentage' => 5],
            ['name' => 'Garlic', 'cost_price' => 0.30, 'randomisation_percentage' => 5],
            ['name' => 'Basil Leaves', 'cost_price' => 0.25, 'randomisation_percentage' => 10],
        ]);
    }
}
