@extends('layouts.app')

@section('title', $recipe->name)

@section('content')
<div class="mb-6">
    <a href="{{ route('restaurants.recipes.index', $restaurant) }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left"></i> Back to Recipes
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $recipe->name }}</h1>
                    @if($recipe->category)
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">
                            {{ $recipe->category->name }}
                        </span>
                    @endif
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('restaurants.recipes.edit', [$restaurant, $recipe]) }}" 
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('restaurants.recipes.recalculate', [$restaurant, $recipe]) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            <i class="fas fa-calculator"></i> Recalculate
                        </button>
                    </form>
                </div>
            </div>
            
            @if($recipe->description)
                <p class="text-gray-600 mb-4">{{ $recipe->description }}</p>
            @endif
            
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-gray-50 p-3 rounded text-center">
                    <i class="fas fa-users text-blue-600 text-2xl mb-2"></i>
                    <p class="text-sm text-gray-600">Servings</p>
                    <p class="font-bold text-gray-800">{{ $recipe->serving_size }}</p>
                </div>
                @if($recipe->prep_time)
                    <div class="bg-gray-50 p-3 rounded text-center">
                        <i class="fas fa-clock text-green-600 text-2xl mb-2"></i>
                        <p class="text-sm text-gray-600">Prep</p>
                        <p class="font-bold text-gray-800">{{ $recipe->prep_time }} min</p>
                    </div>
                @endif
                @if($recipe->cook_time)
                    <div class="bg-gray-50 p-3 rounded text-center">
                        <i class="fas fa-fire text-red-600 text-2xl mb-2"></i>
                        <p class="text-sm text-gray-600">Cook</p>
                        <p class="font-bold text-gray-800">{{ $recipe->cook_time }} min</p>
                    </div>
                @endif
            </div>
            
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-3">Ingredients</h2>
                <div class="space-y-2">
                    @foreach($costBreakdown['ingredients'] as $ingredient)
                        <div class="flex justify-between items-center bg-gray-50 p-3 rounded">
                            <span class="text-gray-800">
                                {{ $ingredient['quantity'] }} {{ $ingredient['unit'] }} {{ $ingredient['name'] }}
                            </span>
                            <span class="font-semibold text-gray-700">
                                ${{ number_format($ingredient['cost_per_serving'], 2) }}
                                <span class="text-sm text-gray-500">({{ $ingredient['percentage'] }}%)</span>
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
            
            @if($recipe->instructions)
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">Instructions</h2>
                    <p class="text-gray-700 whitespace-pre-line">{{ $recipe->instructions }}</p>
                </div>
            @endif
        </div>
    </div>
    
    <div>
        <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Cost Analysis</h2>
            
            <div class="space-y-4">
                <div class="border-b pb-3">
                    <p class="text-sm text-gray-600">Ingredient Cost</p>
                    <p class="text-2xl font-bold text-gray-800">${{ number_format($costBreakdown['ingredient_cost'], 2) }}</p>
                </div>
                
                <div class="border-b pb-3">
                    <p class="text-sm text-gray-600">Overhead Cost</p>
                    <p class="text-2xl font-bold text-gray-800">${{ number_format($costBreakdown['overhead_cost'], 2) }}</p>
                </div>
                
                <div class="border-b pb-3">
                    <p class="text-sm text-gray-600">Total Cost per Serving</p>
                    <p class="text-3xl font-bold text-red-600">${{ number_format($costBreakdown['total_cost'], 2) }}</p>
                </div>
                
                <div class="border-b pb-3">
                    <p class="text-sm text-gray-600">Profit Margin</p>
                    <p class="text-2xl font-bold text-purple-600">{{ number_format($costBreakdown['profit_margin'], 1) }}%</p>
                </div>
                
                <div class="bg-green-50 p-4 rounded">
                    <p class="text-sm text-gray-600 mb-1">Suggested Price</p>
                    <p class="text-4xl font-bold text-green-600">${{ number_format($costBreakdown['suggested_price'], 2) }}</p>
                </div>
                
                <div class="bg-blue-50 p-4 rounded">
                    <p class="text-sm text-gray-600 mb-1">Potential Profit</p>
                    <p class="text-2xl font-bold text-blue-600">
                        ${{ number_format($costBreakdown['suggested_price'] - $costBreakdown['total_cost'], 2) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection