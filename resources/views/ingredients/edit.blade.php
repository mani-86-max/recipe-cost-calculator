@extends('layouts.app')

@section('title', 'Edit Ingredient')

@section('content')
<div class="animate-fade-in">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('restaurants.ingredients.index', $restaurant) }}" class="text-purple-600 hover:text-purple-800 flex items-center transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Ingredients
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-xl p-8 max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8 text-center">
            <div class="inline-block p-5 bg-gradient-to-r from-blue-100 to-purple-100 rounded-full mb-4 shadow">
                <i class="fas fa-edit text-blue-600 text-5xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Ingredient</h1>
            <p class="text-gray-600">Update details for <span class="font-semibold">{{ $ingredient->name }}</span></p>
        </div>
        
        <form action="{{ route('restaurants.ingredients.update', [$restaurant, $ingredient]) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Ingredient Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 flex items-center">
                        <i class="fas fa-leaf text-green-600 mr-2"></i>
                        Ingredient Name *
                    </label>
                    <input type="text" name="name" value="{{ old('name', $ingredient->name) }}" required
                        class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition shadow-sm">
                </div>
                
                <!-- Price and Quantity Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2 flex items-center">
                            <i class="fas fa-rupee-sign text-green-600 mr-2"></i>
                            Purchase Price *
                        </label>
                        <input type="number" name="current_price" value="{{ old('current_price', $ingredient->current_price) }}" 
                            required step="0.01" min="0"
                            class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition shadow-sm">
                        <p class="text-sm text-gray-500 mt-1">Current: ₹{{ number_format($ingredient->current_price, 2) }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2 flex items-center">
                            <i class="fas fa-balance-scale text-blue-600 mr-2"></i>
                            Quantity per Unit *
                        </label>
                        <input type="number" name="quantity_per_unit" value="{{ old('quantity_per_unit', $ingredient->quantity_per_unit) }}" 
                            required step="0.01" min="0"
                            class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition shadow-sm">
                        <p class="text-sm text-gray-500 mt-1">Current: {{ $ingredient->quantity_per_unit }}</p>
                    </div>
                </div>
                
                <!-- Unit and Wastage Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2 flex items-center">
                            <i class="fas fa-ruler text-purple-600 mr-2"></i>
                            Unit *
                        </label>
                        <select name="unit_id" required
                            class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition shadow-sm">
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
                        <label class="block text-gray-700 font-semibold mb-2 flex items-center">
                            <i class="fas fa-percentage text-orange-600 mr-2"></i>
                            Wastage %
                        </label>
                        <input type="number" name="wastage_percentage" value="{{ old('wastage_percentage', $ingredient->wastage_percentage) }}" 
                            step="0.01" min="0" max="100"
                            class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition shadow-sm">
                        <p class="text-sm text-gray-500 mt-1">Current: {{ $ingredient->wastage_percentage }}%</p>
                    </div>
                </div>
                
                <!-- Supplier -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 flex items-center">
                        <i class="fas fa-truck text-blue-600 mr-2"></i>
                        Supplier
                    </label>
                    <input type="text" name="supplier" value="{{ old('supplier', $ingredient->supplier) }}"
                        class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition shadow-sm">
                </div>
                
                <!-- Price History Info -->
                @if($ingredient->last_price_update)
                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-200 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        <p class="text-sm text-blue-800">Last updated: {{ $ingredient->last_price_update->format('F d, Y') }}</p>
                    </div>
                @endif
            </div>
            
            <!-- Submit Buttons -->
            <div class="flex flex-col md:flex-row gap-4 mt-8 pt-6 border-t">
                <button type="submit" class="flex-1 bg-purple-600 text-white px-6 py-3 rounded-xl shadow-lg hover:bg-purple-700 transition flex items-center justify-center space-x-2">
                    <i class="fas fa-save"></i>
                    <span>Update Ingredient</span>
                </button>
                <a href="{{ route('restaurants.ingredients.index', $restaurant) }}" class="flex-1 bg-gray-200 px-6 py-3 rounded-xl shadow hover:bg-gray-300 text-center flex items-center justify-center space-x-2">
                    <i class="fas fa-times"></i>
                    <span>Cancel</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
