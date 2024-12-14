<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\Pizza;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IngredientControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_all_ingredients()
    {
        $user = User::factory()->create(); 
        $ingredient = Ingredient::factory()->create();

        $response = $this->actingAs($user)->getJson(route('ingredients.index'));

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['name' => $ingredient->name]);
    }

    public function test_show_returns_ingredient_details()
    {
        $user = User::factory()->create(); 
        $ingredient = Ingredient::factory()->create();

        $response = $this->actingAs($user)->getJson(route('ingredients.show', $ingredient->id));

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $ingredient->name]);
        $response->assertJsonFragment(['image' => asset('storage/' . $ingredient->image)]);
    }

    public function test_update_updates_ingredient_details()
    {
        $user = User::factory()->create(); 
        $ingredient = Ingredient::factory()->create();
        
        $data = [
            'name' => 'Updated Ingredient',
            'cost_price' => 5.99,
            'randomisation_percentage' => 50,
        ];

        $response = $this->actingAs($user)->putJson(route('ingredients.update', $ingredient->id), $data);

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Updated Ingredient']);
        $response->assertJsonFragment(['cost_price' => 5.99]);
    }

    public function test_destroy_deletes_ingredient()
    {
        $user = User::factory()->create(); 
        $ingredient = Ingredient::factory()->create();

        $response = $this->actingAs($user)->deleteJson(route('ingredients.destroy', $ingredient->id));

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Ingredient deleted successfully']);
    }
}
