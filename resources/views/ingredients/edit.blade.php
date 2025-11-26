@extends('layouts.app')

@section('title', 'Edit Ingredient')

@section('content')
<div class="mb-6">
    <a href="{{ route('restaurants.ingredients.index', $restaurant) }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left"></i> Back to Ingredients
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Ingredient</h1>
    
    <form action="{{ route('restaurants.ingredients.update', [$restaurant, $ingredient]) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Ingredient Name *</label>
            <input type="text" name="name" value="{{ old('name', $ingredient->name) }}" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Purchase Price *</label>
                <input type="number" name="current_price" value="{{ old('current_price', $ingredient->current_price) }}" 
                    required step="0.01" min="0"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Quantity per Unit *</label>
                <input type="number" name="quantity_per_unit" value="{{ old('quantity_per_unit', $ingredient->quantity_per_unit) }}" 
                    required step="0.01" min="0"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Unit *</label>
                <select name="unit_id" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Unit</option>
                    @foreach($units->groupBy('type') as $type => $unitGroup)
                        <optgroup label="{{ ucfirst($type) }}">
                            @foreach($unitGroup as $unit)
                                <option value="{{ $unit->id }}" {{ $ingredient->unit_id == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->name }} ({{ $unit->abbreviation }})
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Wastage %</label>
                <input type="number" name="wastage_percentage" value="{{ old('wastage_percentage', $ingredient->wastage_percentage) }}" 
                    step="0.01" min="0" max="100"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Supplier</label>
            <input type="text" name="supplier" value="{{ old('supplier', $ingredient->supplier) }}"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-save"></i> Update Ingredient
            </button>
            <a href="{{ route('restaurants.ingredients.index', $restaurant) }}" 
                class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection