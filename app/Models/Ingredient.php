<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ingredient extends Model
{
    protected $fillable = [
        'restaurant_id', 'name', 'unit_id', 'current_price', 
        'quantity_per_unit', 'wastage_percentage', 'supplier', 'last_price_update'
    ];

    protected $casts = [
        'current_price' => 'decimal:2',
        'quantity_per_unit' => 'decimal:2',
        'wastage_percentage' => 'decimal:2',
        'last_price_update' => 'date',
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function priceHistory(): HasMany
    {
        return $this->hasMany(PriceHistory::class);
    }
    public function suppliers(): BelongsToMany
   {
    return $this->belongsToMany(Supplier::class, 'ingredient_supplier')
        ->withPivot('price', 'quantity', 'unit_id', 'last_purchase_date', 'is_preferred', 'notes')
        ->withTimestamps();
    }
    
    public function getPricePerBaseUnit(): float
    {
        $wastageMultiplier = 1 + ($this->wastage_percentage / 100);
        return ($this->current_price / $this->quantity_per_unit) * $wastageMultiplier;
    }
}