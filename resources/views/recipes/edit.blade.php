@extends('layouts.app')

@section('title', 'Edit Recipe')

@section('content')
<div class="max-w-5xl mx-auto p-6 animate-fade-in">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-2">Edit Recipe</h1>
        <p class="text-gray-600">Modify your recipe details, ingredients, and cost analysis</p>
    </div>

    <form action="{{ route('restaurants.recipes.update', [$restaurant, $recipe]) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Recipe Basic Info -->
        <div class="bg-white shadow-lg rounded-xl p-6 space-y-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Recipe Details</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Recipe Name *</label>
                    <input type="text" name="name" value="{{ old('name', $recipe->name) }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Category</label>
                    <select name="category_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ old('category_id', $recipe->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Servings *</label>
                    <input type="number" name="serving_size" value="{{ old('serving_size', $recipe->serving_size) }}" min="1"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Prep Time (min)</label>
                    <input type="number" name="prep_time" value="{{ old('prep_time', $recipe->prep_time) }}" min="0"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Cook Time (min)</label>
                    <input type="number" name="cook_time" value="{{ old('cook_time', $recipe->cook_time) }}" min="0"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-2">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">{{ old('description', $recipe->description) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-2">Instructions</label>
                    <textarea id="instructions" name="instructions" rows="6"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">{{ old('instructions', $recipe->instructions) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Ingredients -->
        <div class="bg-white shadow-lg rounded-xl p-6 space-y-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-carrot text-orange-500 mr-3"></i> Ingredients
            </h2>

            <div class="space-y-3">
                @foreach($recipe->recipeIngredients as $index => $recipeIngredient)
                    <div class="flex flex-col md:flex-row items-center md:space-x-4 p-4 bg-gray-50 rounded-lg border hover:border-purple-300 transition-colors">
                        <input type="hidden" name="ingredients[{{ $index }}][ingredient_id]" value="{{ $recipeIngredient->ingredient_id }}">

                        <div class="flex-1 font-medium text-gray-800">{{ $recipeIngredient->ingredient->name }}</div>

                        <input type="number" name="ingredients[{{ $index }}][quantity]"
                            value="{{ old("ingredients.$index.quantity", $recipeIngredient->quantity) }}" min="0" step="0.01"
                            class="w-full md:w-24 px-2 py-1 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">

                        <select name="ingredients[{{ $index }}][unit_id]"
                            class="w-full md:w-32 px-2 py-1 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" 
                                    {{ old("ingredients.$index.unit_id", $recipeIngredient->unit_id) == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>

                        @if(isset($costBreakdown['ingredients'][$index]))
                            <div class="text-right mt-2 md:mt-0 w-full md:w-32">
                                <p class="text-gray-800 font-bold">₹{{ number_format($costBreakdown['ingredients'][$index]['cost_per_serving'], 2) }}</p>
                                <p class="text-xs text-gray-500">{{ $costBreakdown['ingredients'][$index]['percentage'] }}%</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Cost Analysis -->
        @if(isset($costBreakdown))
        <div class="bg-white shadow-lg rounded-xl p-6 space-y-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-chart-pie text-purple-600 mr-3"></i> Cost Analysis
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-orange-50 p-4 rounded-lg border-l-4 border-orange-500 text-center">
                    <p class="text-sm text-orange-700 font-semibold mb-1">Ingredient Cost</p>
                    <p class="text-2xl font-bold text-orange-600">₹{{ number_format($costBreakdown['ingredient_cost'], 2) }}</p>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-500 text-center">
                    <p class="text-sm text-yellow-700 font-semibold mb-1">Overhead Cost</p>
                    <p class="text-2xl font-bold text-yellow-600">₹{{ number_format($costBreakdown['overhead_cost'], 2) }}</p>
                </div>
                <div class="bg-red-50 p-4 rounded-lg border-l-4 border-red-500 text-center">
                    <p class="text-sm text-red-700 font-semibold mb-1">Total Cost</p>
                    <p class="text-2xl font-bold text-red-600">₹{{ number_format($costBreakdown['total_cost'], 2) }}</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg border-l-4 border-purple-500 text-center">
                    <p class="text-sm text-purple-700 font-semibold mb-1">Profit Margin</p>
                    <p class="text-2xl font-bold text-purple-600">{{ number_format($costBreakdown['profit_margin'], 1) }}%</p>
                </div>
            </div>

            <div class="mt-4 p-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg text-center text-xl font-bold">
                Suggested Price: ₹{{ number_format($costBreakdown['suggested_price'], 2) }}
            </div>
        </div>
        @endif

        <!-- Buttons -->
        <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
            <button type="submit" class="flex-1 bg-purple-600 text-white px-6 py-3 rounded-xl hover:bg-purple-700 shadow-lg transition">
                <i class="fas fa-save mr-2"></i> Update Recipe
            </button>
            <a href="{{ route('restaurants.recipes.show', [$restaurant, $recipe]) }}" class="flex-1 bg-gray-200 text-gray-800 px-6 py-3 rounded-xl hover:bg-gray-300 transition text-center">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
    ClassicEditor.create(document.querySelector('#instructions'))
        .catch(error => { console.error(error); });
</script>
@endsection
