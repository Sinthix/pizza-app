<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;
use App\Models\Ingredient;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $pizza = new Pizza();
        $pizza->name = $validated['name'];
        $pizza->image = $validated['image'];
        $image = $request->file('image');
        $imagePath = $image->store('images/pizzas', 'public');
        $pizza->image = $imagePath;
        $pizza->selling_price = array_sum(
            array_map(fn($ingredientId) => \App\Models\Ingredient::find($ingredientId)->cost_price, $validated['ingredients'])
        ) * 1.5; 
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
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:50|regex:/^[^{}"\[\]\.!]+$/|unique:pizzas,name,' . $id,
            'ingredients' => 'required|array|max:8',
            'ingredients.*' => 'exists:ingredients,id',
            'image' => 'nullable|url',
        ]);

        $pizza = Pizza::findOrFail($id);
        $pizza->name = $validated['name'];
        $pizza->image = $validated['image'];
        $pizza->price = array_sum(
            array_map(fn($ingredientId) => \App\Models\Ingredient::find($ingredientId)->cost_price, $validated['ingredients'])
        ) * 1.5;
        $pizza->save();

        $pizza->ingredients()->sync($validated['ingredients']);
        return response()->json($pizza);
    }

    public function destroy($id)
    {
        $pizza = Pizza::findOrFail($id);
        $pizza->ingredients()->detach();
        $pizza->delete();
        return response()->json(['message' => 'Pizza deleted successfully']);
    }
}
