<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Recipe extends Model
{
    protected $fillable = [
        'restaurant_id', 'category_id', 'name', 'description',
        'serving_size', 'prep_time', 'cook_time', 'instructions', 
        'image', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredients')
            ->withPivot('quantity', 'unit_id', 'order')
            ->withTimestamps()
            ->orderBy('recipe_ingredients.order');
    }

    public function recipeIngredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    public function latestCost(): HasOne
    {
        return $this->hasOne(RecipeCost::class)->latestOfMany();
    }

    public function costHistory(): HasMany
    {
        return $this->hasMany(RecipeCost::class);
    }
}