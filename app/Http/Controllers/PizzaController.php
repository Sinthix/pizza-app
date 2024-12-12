<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Log;


class PizzaController extends Controller
{
    public function index()
    {
        $pizzas = Pizza::with('ingredients')->get(); 

        $pizzas->each(function ($pizza) {
            $pizza->image = asset('storage/' . $pizza->image);
        });
        return response()->json($pizzas);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:50|unique:pizzas,name|regex:/^[^{}"\[\]\.!]+$/',
            'ingredients' => 'required|array|max:8', 
            'ingredients.*' => 'exists:ingredients,id',
            'selling_price' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $pizza = new Pizza();
        $pizza->name = $validated['name'];
        $pizza->selling_price = $validated['selling_price'];
        $pizza->image = $validated['image'];
        $image = $request->file('image');
        $imagePath = $image->store('images/pizzas', 'public');
        $pizza->image = $imagePath;
        
        $pizza->save();

        $pizza->ingredients()->sync($validated['ingredients']);
        return response()->json($pizza, 201);
    }

    public function show($id)
    {
        $pizza = Pizza::with('ingredients')->findOrFail($id);
        return response()->json($pizza);
    }

    public function update(Request $request, $id)
    {
       
        $pizza = Pizza::findOrFail($id);

        $pizza->name = $request->input('name', $pizza->name);
        $pizza->selling_price = $request->input('selling_price', $pizza->selling_price);
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
    
            if ($image->isValid() && in_array($image->extension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                if ($pizza->image) {
                    Storage::disk('public')->delete($pizza->image);
                }
    
                $path = $image->store('images/pizzas', 'public');
                $pizza->image = $path;
            }
        }

        $pizza->update();

        $ingredients = $request->input('ingredients');
        $pizza->ingredients()->sync($ingredients);
       

        return response()->json($pizza, 201);
    }

    public function generateRandomPizza()
    {
        $ingredients = Ingredient::whereNotNull('randomisation_percentage')->get();

        if ($ingredients->isEmpty()) {
            return response()->json(['error' => 'No ingredients available for randomization'], 400);
        }

        $selectedIngredients = collect();

        foreach ($ingredients as $ingredient) {
            $randomChance = mt_rand(1, 100);

            if ($randomChance <= $ingredient->randomisation_percentage) {
                $selectedIngredients->push($ingredient);
            }
        }

        $ingredientCount = $selectedIngredients->count();
        if ($ingredientCount < 1) {
            $selectedIngredients = $ingredients->random(1);
        } elseif ($ingredientCount > 5) {
            $selectedIngredients = $selectedIngredients->random(5);
        }

        $totalIngredientCost = $selectedIngredients->sum('cost_price');

        $sellingPrice = $totalIngredientCost + ($totalIngredientCost * 0.5);

        $pizza = Pizza::create([
            'name' => 'Random Pizza ' . uniqid(),
            'selling_price' => round($sellingPrice, 2),
        ]);

        $pizza->ingredients()->sync($selectedIngredients->pluck('id'));

        return response()->json($pizza->load('ingredients'), 201);
    }


    public function destroy($id)
    {
        $pizza = Pizza::findOrFail($id);
        $pizza->ingredients()->detach();
        $pizza->delete();
        return response()->json(['message' => 'Pizza deleted successfully']);
    }
}
