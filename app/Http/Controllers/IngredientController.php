<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Restaurant;
use App\Models\PriceHistory;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class IngredientController extends Controller
{   
    use AuthorizesRequests;
    public function index(Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);
        
        $ingredients = $restaurant->ingredients()
            ->with('unit')
            ->paginate(20);

        return view('ingredients.index', compact('restaurant', 'ingredients'));
    }

    public function create(Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);
        
        $units = \App\Models\Unit::all();
        return view('ingredients.create', compact('restaurant', 'units'));
    }

    public function store(Request $request, Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'current_price' => 'required|numeric|min:0',
            'quantity_per_unit' => 'required|numeric|min:0',
            'wastage_percentage' => 'nullable|numeric|min:0|max:100',
            'supplier' => 'nullable|string',
        ]);

        $validated['last_price_update'] = now();
        $ingredient = $restaurant->ingredients()->create($validated);

        // Record price history
        PriceHistory::create([
            'ingredient_id' => $ingredient->id,
            'price' => $ingredient->current_price,
            'effective_date' => now(),
        ]);

        return redirect()->route('restaurants.ingredients.index', $restaurant)
            ->with('success', 'Ingredient created successfully!');
    }

    public function edit(Restaurant $restaurant, Ingredient $ingredient)
    {
        $this->authorize('view', $restaurant);
        
        $units = \App\Models\Unit::all();
        return view('ingredients.edit', compact('restaurant', 'ingredient', 'units'));
    }

    public function update(Request $request, Restaurant $restaurant, Ingredient $ingredient)
    {
        $this->authorize('view', $restaurant);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'current_price' => 'required|numeric|min:0',
            'quantity_per_unit' => 'required|numeric|min:0',
            'wastage_percentage' => 'nullable|numeric|min:0|max:100',
            'supplier' => 'nullable|string',
        ]);

        // Check if price changed
        if ($ingredient->current_price != $validated['current_price']) {
            PriceHistory::create([
                'ingredient_id' => $ingredient->id,
                'price' => $validated['current_price'],
                'effective_date' => now(),
            ]);
            $validated['last_price_update'] = now();
        }

        $ingredient->update($validated);

        return redirect()->route('restaurants.ingredients.index', $restaurant)
            ->with('success', 'Ingredient updated successfully!');
    }

    public function destroy(Restaurant $restaurant, Ingredient $ingredient)
    {
        $this->authorize('view', $restaurant);
        $ingredient->delete();

        return redirect()->route('restaurants.ingredients.index', $restaurant)
            ->with('success', 'Ingredient deleted successfully!');
    }
}