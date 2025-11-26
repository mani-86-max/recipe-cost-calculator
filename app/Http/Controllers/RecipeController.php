<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Restaurant;
use App\Services\RecipeCostCalculator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RecipeController extends Controller
{   use AuthorizesRequests;
    protected $costCalculator;

    public function __construct(RecipeCostCalculator $costCalculator)
    {
        $this->costCalculator = $costCalculator;
    }

    public function index(Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);
        
        $recipes = $restaurant->recipes()
            ->with(['category', 'latestCost'])
            ->paginate(15);

        return view('recipes.index', compact('restaurant', 'recipes'));
    }

    public function create(Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);
        
        $categories = $restaurant->categories;
        $ingredients = $restaurant->ingredients()->with('unit')->get();
        $units = \App\Models\Unit::all();

        return view('recipes.create', compact('restaurant', 'categories', 'ingredients', 'units'));
    }

    public function store(Request $request, Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'serving_size' => 'required|integer|min:1',
            'prep_time' => 'nullable|integer|min:0',
            'cook_time' => 'nullable|integer|min:0',
            'instructions' => 'nullable|string',
            'ingredients' => 'required|array',
            'ingredients.*.ingredient_id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:0',
            'ingredients.*.unit_id' => 'required|exists:units,id',
        ]);

        $recipe = $restaurant->recipes()->create($validated);

        // Attach ingredients
        foreach ($validated['ingredients'] as $index => $ingredient) {
            $recipe->recipeIngredients()->create([
                'ingredient_id' => $ingredient['ingredient_id'],
                'quantity' => $ingredient['quantity'],
                'unit_id' => $ingredient['unit_id'],
                'order' => $index,
            ]);
        }

        // Calculate initial cost
        $this->costCalculator->calculateRecipeCost($recipe);

        return redirect()->route('restaurants.recipes.show', [$restaurant, $recipe])
            ->with('success', 'Recipe created successfully!');
    }

    public function show(Restaurant $restaurant, Recipe $recipe)
    {
        $this->authorize('view', $restaurant);
        
        $recipe->load([
            'recipeIngredients.ingredient.unit',
            'recipeIngredients.unit',
            'category',
            'latestCost'
        ]);

        $costBreakdown = $this->costCalculator->getCostBreakdown($recipe);

        return view('recipes.show', compact('restaurant', 'recipe', 'costBreakdown'));
    }

    public function edit(Restaurant $restaurant, Recipe $recipe)
    {
        $this->authorize('view', $restaurant);
        
        $recipe->load('recipeIngredients');
        $categories = $restaurant->categories;
        $ingredients = $restaurant->ingredients()->with('unit')->get();
        $units = \App\Models\Unit::all();

        return view('recipes.edit', compact('restaurant', 'recipe', 'categories', 'ingredients', 'units'));
    }

    public function update(Request $request, Restaurant $restaurant, Recipe $recipe)
    {
        $this->authorize('view', $restaurant);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'serving_size' => 'required|integer|min:1',
            'prep_time' => 'nullable|integer|min:0',
            'cook_time' => 'nullable|integer|min:0',
            'instructions' => 'nullable|string',
            'ingredients' => 'required|array',
            'ingredients.*.ingredient_id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:0',
            'ingredients.*.unit_id' => 'required|exists:units,id',
        ]);

        $recipe->update($validated);

        // Update ingredients
        $recipe->recipeIngredients()->delete();
        foreach ($validated['ingredients'] as $index => $ingredient) {
            $recipe->recipeIngredients()->create([
                'ingredient_id' => $ingredient['ingredient_id'],
                'quantity' => $ingredient['quantity'],
                'unit_id' => $ingredient['unit_id'],
                'order' => $index,
            ]);
        }

        // Recalculate cost
        $this->costCalculator->calculateRecipeCost($recipe);

        return redirect()->route('restaurants.recipes.show', [$restaurant, $recipe])
            ->with('success', 'Recipe updated successfully!');
    }

    public function destroy(Restaurant $restaurant, Recipe $recipe)
    {
        $this->authorize('view', $restaurant);
        $recipe->delete();

        return redirect()->route('restaurants.recipes.index', $restaurant)
            ->with('success', 'Recipe deleted successfully!');
    }

    public function recalculateCost(Restaurant $restaurant, Recipe $recipe)
    {
        $this->authorize('view', $restaurant);
        
        $this->costCalculator->calculateRecipeCost($recipe);

        return redirect()->back()
            ->with('success', 'Recipe cost recalculated successfully!');
    }
}