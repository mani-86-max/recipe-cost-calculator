<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    protected $fillable = [
        'user_id', 'name', 'address', 'phone', 
        'overhead_percentage', 'default_profit_margin'
    ];

    protected $casts = [
        'overhead_percentage' => 'decimal:2',
        'default_profit_margin' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }

    public function ingredients(): HasMany
    {
        return $this->hasMany(Ingredient::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}