<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Supplier extends Model
{
    protected $fillable = [
        'restaurant_id',
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'company_name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function ingredients(): BelongsToMany
    {
    return $this->belongsToMany(Ingredient::class, 'ingredient_supplier')
        ->withPivot('price', 'quantity', 'unit_id', 'last_purchase_date', 'is_preferred', 'notes')
        ->withTimestamps();
    }

}