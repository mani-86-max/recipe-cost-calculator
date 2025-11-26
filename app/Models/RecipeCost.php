<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class RecipeCost extends Model
{
    //
     protected $fillable = [
        'recipe_id', 'ingredient_cost', 'overhead_cost', 
        'total_cost', 'suggested_price', 'profit_margin', 'calculated_at'
    ];

    protected $casts = [
        'ingredient_cost' => 'decimal:2',
        'overhead_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'suggested_price' => 'decimal:2',
        'profit_margin' => 'decimal:2',
        'calculated_at' => 'datetime',
    ];

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }
}
