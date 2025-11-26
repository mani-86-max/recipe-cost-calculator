<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['name', 'abbreviation', 'type', 'base_unit_multiplier'];

    protected $casts = [
        'base_unit_multiplier' => 'decimal:4',
    ];
}