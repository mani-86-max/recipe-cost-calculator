<?php

namespace App\Services;

use App\Models\Unit;

class UnitSeeder
{
    public static function seedDefaultUnits(): void
    {
        $units = [
            // Weight units (base: gram)
            ['name' => 'Milligram', 'abbreviation' => 'mg', 'type' => 'weight', 'base_unit_multiplier' => 0.001],
            ['name' => 'Gram', 'abbreviation' => 'g', 'type' => 'weight', 'base_unit_multiplier' => 1],
            ['name' => 'Kilogram', 'abbreviation' => 'kg', 'type' => 'weight', 'base_unit_multiplier' => 1000],
            ['name' => 'Ounce', 'abbreviation' => 'oz', 'type' => 'weight', 'base_unit_multiplier' => 28.35],
            ['name' => 'Pound', 'abbreviation' => 'lb', 'type' => 'weight', 'base_unit_multiplier' => 453.592],
            
            // Volume units (base: milliliter)
            ['name' => 'Milliliter', 'abbreviation' => 'ml', 'type' => 'volume', 'base_unit_multiplier' => 1],
            ['name' => 'Liter', 'abbreviation' => 'L', 'type' => 'volume', 'base_unit_multiplier' => 1000],
            ['name' => 'Teaspoon', 'abbreviation' => 'tsp', 'type' => 'volume', 'base_unit_multiplier' => 4.929],
            ['name' => 'Tablespoon', 'abbreviation' => 'tbsp', 'type' => 'volume', 'base_unit_multiplier' => 14.787],
            ['name' => 'Cup', 'abbreviation' => 'cup', 'type' => 'volume', 'base_unit_multiplier' => 236.588],
            ['name' => 'Fluid Ounce', 'abbreviation' => 'fl oz', 'type' => 'volume', 'base_unit_multiplier' => 29.574],
            ['name' => 'Pint', 'abbreviation' => 'pt', 'type' => 'volume', 'base_unit_multiplier' => 473.176],
            ['name' => 'Quart', 'abbreviation' => 'qt', 'type' => 'volume', 'base_unit_multiplier' => 946.353],
            ['name' => 'Gallon', 'abbreviation' => 'gal', 'type' => 'volume', 'base_unit_multiplier' => 3785.41],
            
            // Piece units
            ['name' => 'Piece', 'abbreviation' => 'pc', 'type' => 'piece', 'base_unit_multiplier' => 1],
            ['name' => 'Dozen', 'abbreviation' => 'doz', 'type' => 'piece', 'base_unit_multiplier' => 12],
        ];

        foreach ($units as $unit) {
            Unit::firstOrCreate(
                ['abbreviation' => $unit['abbreviation']],
                $unit
            );
        }
    }
}