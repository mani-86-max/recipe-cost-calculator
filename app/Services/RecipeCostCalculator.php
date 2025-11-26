<?php

namespace App\Services;

use App\Models\Recipe;
use App\Models\RecipeCost;
use Illuminate\Support\Facades\DB;

class RecipeCostCalculator
{
    public function calculateRecipeCost(Recipe $recipe, ?float $profitMargin = null): RecipeCost
    {
        $recipe->load(['recipeIngredients.ingredient.unit', 'recipeIngredients.unit', 'restaurant']);
        
        $ingredientCost = $this->calculateIngredientCost($recipe);
        $overheadCost = $this->calculateOverheadCost($ingredientCost, $recipe->restaurant);
        $totalCost = $ingredientCost + $overheadCost;
        
        $margin = $profitMargin ?? $recipe->restaurant->default_profit_margin;
        $suggestedPrice = $this->calculateSuggestedPrice($totalCost, $margin);
        
        return RecipeCost::create([
            'recipe_id' => $recipe->id,
            'ingredient_cost' => $ingredientCost,
            'overhead_cost' => $overheadCost,
            'total_cost' => $totalCost,
            'suggested_price' => $suggestedPrice,
            'profit_margin' => $margin,
            'calculated_at' => now(),
        ]);
    }

    protected function calculateIngredientCost(Recipe $recipe): float
    {
        $totalCost = 0;

        foreach ($recipe->recipeIngredients as $recipeIngredient) {
            $ingredient = $recipeIngredient->ingredient;
            $recipeUnit = $recipeIngredient->unit;
            $ingredientBaseUnit = $ingredient->unit;
            
            // Convert quantity to ingredient's base unit
            $quantityInBaseUnit = $this->convertUnits(
                $recipeIngredient->quantity,
                $recipeUnit,
                $ingredientBaseUnit
            );
            
            // Calculate cost
            $pricePerBaseUnit = $ingredient->getPricePerBaseUnit();
            $ingredientCost = $quantityInBaseUnit * $pricePerBaseUnit;
            
            $totalCost += $ingredientCost;
        }

        return round($totalCost / $recipe->serving_size, 2);
    }

    protected function convertUnits(float $quantity, $fromUnit, $toUnit): float
    {
        if ($fromUnit->id === $toUnit->id) {
            return $quantity;
        }

        // Convert to base unit then to target unit
        $baseQuantity = $quantity * $fromUnit->base_unit_multiplier;
        return $baseQuantity / $toUnit->base_unit_multiplier;
    }

    protected function calculateOverheadCost(float $ingredientCost, $restaurant): float
    {
        return round($ingredientCost * ($restaurant->overhead_percentage / 100), 2);
    }

    protected function calculateSuggestedPrice(float $totalCost, float $profitMargin): float
    {
        return round($totalCost / (1 - ($profitMargin / 100)), 2);
    }

    public function recalculateAllRecipeCosts(int $restaurantId): void
    {
        $recipes = Recipe::where('restaurant_id', $restaurantId)
            ->where('is_active', true)
            ->get();

        foreach ($recipes as $recipe) {
            $this->calculateRecipeCost($recipe);
        }
    }

    public function getCostBreakdown(Recipe $recipe): array
    {
        $recipe->load(['recipeIngredients.ingredient.unit', 'recipeIngredients.unit', 'latestCost']);
        
        $ingredients = [];
        foreach ($recipe->recipeIngredients as $recipeIngredient) {
            $ingredient = $recipeIngredient->ingredient;
            $recipeUnit = $recipeIngredient->unit;
            $ingredientBaseUnit = $ingredient->unit;
            
            $quantityInBaseUnit = $this->convertUnits(
                $recipeIngredient->quantity,
                $recipeUnit,
                $ingredientBaseUnit
            );
            
            $pricePerBaseUnit = $ingredient->getPricePerBaseUnit();
            $cost = ($quantityInBaseUnit * $pricePerBaseUnit) / $recipe->serving_size;
            
            $ingredients[] = [
                'name' => $ingredient->name,
                'quantity' => $recipeIngredient->quantity,
                'unit' => $recipeUnit->abbreviation,
                'cost_per_serving' => round($cost, 2),
                'percentage' => 0, // Will calculate after total
            ];
        }

        $totalIngredientCost = array_sum(array_column($ingredients, 'cost_per_serving'));
        
        // Calculate percentages
        foreach ($ingredients as &$ingredient) {
            $ingredient['percentage'] = $totalIngredientCost > 0 
                ? round(($ingredient['cost_per_serving'] / $totalIngredientCost) * 100, 2)
                : 0;
        }

        $latestCost = $recipe->latestCost;

        return [
            'ingredients' => $ingredients,
            'ingredient_cost' => $latestCost->ingredient_cost ?? $totalIngredientCost,
            'overhead_cost' => $latestCost->overhead_cost ?? 0,
            'total_cost' => $latestCost->total_cost ?? 0,
            'suggested_price' => $latestCost->suggested_price ?? 0,
            'profit_margin' => $latestCost->profit_margin ?? 0,
        ];
    }
}