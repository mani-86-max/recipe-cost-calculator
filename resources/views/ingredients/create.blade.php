@extends('layouts.app')

@section('title', 'Add Ingredient')

@section('content')
<div class="animate-fade-in">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('restaurants.ingredients.index', $restaurant) }}" class="text-purple-600 hover:text-purple-800 transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Ingredients
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-8 max-w-3xl mx-auto">
        <div class="mb-8 text-center">
            <div class="inline-block p-4 bg-green-100 rounded-full mb-4">
                <i class="fas fa-carrot text-green-600 text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Add New Ingredient</h1>
            <p class="text-gray-600">Add ingredient details for cost calculations</p>
        </div>
        
        <form action="{{ route('restaurants.ingredients.store', $restaurant) }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Ingredient Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-leaf text-green-600 mr-2"></i>
                        Ingredient Name *
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                        placeholder="e.g., Chicken Breast, Olive Oil, Tomatoes">
                </div>
                
                <!-- Price and Quantity Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-rupee-sign text-green-600 mr-2"></i>
                            Purchase Price *
                        </label>
                        <input type="number" name="current_price" value="{{ old('current_price') }}" 
                            required step="0.01" min="0"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                            placeholder="0.00">
                        <p class="text-sm text-gray-500 mt-1">Total purchase price</p>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-balance-scale text-blue-600 mr-2"></i>
                            Quantity per Unit *
                        </label>
                        <input type="number" name="quantity_per_unit" value="{{ old('quantity_per_unit') }}" 
                            required step="0.01" min="0"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                            placeholder="1.00">
                        <p class="text-sm text-gray-500 mt-1">Quantity you purchased</p>
                    </div>
                </div>
                
                <!-- Unit and Wastage Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-ruler text-purple-600 mr-2"></i>
                            Unit *
                        </label>
                        <select name="unit_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                            <option value="">Select Unit</option>
                            @foreach($units->groupBy('type') as $type => $unitGroup)
                                <optgroup label="{{ ucfirst($type) }}">
                                    @foreach($unitGroup as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }} ({{ $unit->abbreviation }})</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-percentage text-orange-600 mr-2"></i>
                            Wastage % (optional)
                        </label>
                        <input type="number" name="wastage_percentage" value="{{ old('wastage_percentage', 0) }}" 
                            step="0.01" min="0" max="100"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                            placeholder="0.00">
                        <p class="text-sm text-gray-500 mt-1">Estimated waste during prep</p>
                    </div>
                </div>
                
                <!-- Supplier -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-truck text-blue-600 mr-2"></i>
                        Supplier (optional)
                    </label>
                    <input type="text" name="supplier" value="{{ old('supplier') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                        placeholder="e.g., Local Farms Co., ABC Suppliers">
                </div>
                
                <!-- Example Box -->
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 p-6 rounded-lg border border-blue-200">
                    <h4 class="font-bold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                        Example
                    </h4>
                    <p class="text-sm text-gray-700">
                        If you buy <strong>5 kg</strong> of chicken for <strong>₹500</strong>:
                    </p>
                    <ul class="text-sm text-gray-700 mt-2 space-y-1">
                        <li>• <strong>Price:</strong> ₹500</li>
                        <li>• <strong>Quantity:</strong> 5</li>
                        <li>• <strong>Unit:</strong> Kilogram (kg)</li>
                        <li>• <strong>Wastage:</strong> 10% (if applicable)</li>
                    </ul>
                </div>
            </div>
            
            <!-- Submit Buttons -->
            <div class="flex space-x-4 mt-8 pt-6 border-t">
                <button type="submit" class="flex-1 btn-primary text-white px-8 py-4 rounded-lg shadow-lg flex items-center justify-center space-x-2 text-lg font-semibold">
                    <i class="fas fa-save"></i>
                    <span>Save Ingredient</span>
                </button>
                <a href="{{ route('restaurants.ingredients.index', $restaurant) }}" class="px-8 py-4 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors flex items-center justify-center space-x-2 text-lg font-semibold">
                    <i class="fas fa-times"></i>
                    <span>Cancel</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection