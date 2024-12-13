<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::all();

        $ingredients->each(function ($ingredient) {
            if ($ingredient->image) {
                $ingredient->image = asset('storage/' . $ingredient->image); // Generate the full URL for the image
            }
        });
        return response()->json($ingredients);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:30|unique:ingredients,name|regex:/^[^{}"\[\]\.!]+$/',
            'cost_price' => 'required|numeric|between:0,99999.99',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'randomisation_percentage' => 'integer|between:0,100',
        ]);
        
        $ingredient = new Ingredient();
        $ingredient->name = $validated['name'];
        $ingredient->image = $validated['image'];
        $image = $request->file('image');
        $imagePath = $image->store('images/ingredients', 'public');
        $ingredient->image = $imagePath;
        $ingredient->cost_price = $validated['cost_price'];
        $ingredient->randomisation_percentage = $validated['randomisation_percentage'];
        $ingredient->save();
        return response()->json($ingredient, 201);
    }

    public function show($id)
    {
        $ingredient = Ingredient::findOrFail($id);
        return response()->json($ingredient);
    }

    public function update(Request $request, $id)
    {
        $ingredient = Ingredient::findOrFail($id);
        $ingredient->name = $request->input('name', $ingredient->name);
        $ingredient->cost_price = $request->input('cost_price', $ingredient->cost_price);
        $ingredient->randomisation_percentage = $request->input('randomisation_percentage', $ingredient->randomisation_percentage);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
    
            if ($image->isValid() && in_array($image->extension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                if ($ingredient->image) {
                    Storage::disk('public')->delete($ingredient->image);
                }
    
                $path = $image->store('images/ingredients', 'public');
                $ingredient->image = $path;
            }
        }

        $ingredient->update();

        return response()->json($ingredient);
    }

    public function destroy($id)
    {
        $ingredient = Ingredient::findOrFail($id);
        $ingredient->delete();
        return response()->json(['message' => 'Ingredient deleted successfully']);
    }
}
