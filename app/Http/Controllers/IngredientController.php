<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::all();
        return response()->json($ingredients);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:30|unique:ingredients,name|regex:/^[^{}"\[\]\.!]+$/',
            'cost_price' => 'required|numeric|between:0,99999.99',
            'image' => 'nullable|url',
            'randomization_percentage' => 'required|integer|between:0,100',
        ]);

        $ingredient = Ingredient::create([
            'name' => $validated['name'],
            'cost_price' => $validated['cost_price'],
            'image' => $validated['image'],
            'randomization_percentage' => $validated['randomization_percentage'],
        ]);

        return response()->json($ingredient, 201);
    }

    public function show($id)
    {
        $ingredient = Ingredient::findOrFail($id);
        return response()->json($ingredient);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:30|regex:/^[^{}"\[\]\.!]+$/|unique:ingredients,name,' . $id,
            'cost_price' => 'required|numeric|between:0,99999.99',
            'image' => 'nullable|url',
            'randomization_percentage' => 'required|integer|between:0,100',
        ]);

        $ingredient = Ingredient::findOrFail($id);
        $ingredient->update($validated);

        return response()->json($ingredient);
    }

    public function destroy($id)
    {
        $ingredient = Ingredient::findOrFail($id);
        $ingredient->delete();
        return response()->json(['message' => 'Ingredient deleted successfully']);
    }
}