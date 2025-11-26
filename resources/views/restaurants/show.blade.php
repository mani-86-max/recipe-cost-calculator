@extends('layouts.app')

@section('title', $restaurant->name)

@section('content')
<div class="mb-6">
    <a href="{{ route('restaurants.index') }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left"></i> Back to Restaurants
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $restaurant->name }}</h1>
            @if($restaurant->address)
                <p class="text-gray-600"><i class="fas fa-map-marker-alt"></i> {{ $restaurant->address }}</p>
            @endif
            @if($restaurant->phone)
                <p class="text-gray-600"><i class="fas fa-phone"></i> {{ $restaurant->phone }}</p>
            @endif
        </div>
        <a href="{{ route('restaurants.edit', $restaurant) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-edit"></i> Edit
        </a>
    </div>
    
    <div class="grid grid-cols-2 gap-4 mt-6">
        <div class="bg-gray-50 p-4 rounded">
            <p class="text-sm text-gray-600">Overhead</p>
            <p class="text-2xl font-bold text-gray-800">{{ $restaurant->overhead_percentage }}%</p>
        </div>
        <div class="bg-gray-50 p-4 rounded">
            <p class="text-sm text-gray-600">Default Profit Margin</p>
            <p class="text-2xl font-bold text-gray-800">{{ $restaurant->default_profit_margin }}%</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <a href="{{ route('restaurants.recipes.index', $restaurant) }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 mb-2">Recipes</p>
                <p class="text-3xl font-bold text-blue-600">{{ $restaurant->recipes->count() }}</p>
            </div>
            <i class="fas fa-book text-blue-600 text-4xl"></i>
        </div>
    </a>
    
    <a href="{{ route('restaurants.ingredients.index', $restaurant) }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 mb-2">Ingredients</p>
                <p class="text-3xl font-bold text-green-600">{{ $restaurant->ingredients->count() }}</p>
            </div>
            <i class="fas fa-carrot text-green-600 text-4xl"></i>
        </div>
    </a>
    
    <a href="{{ route('restaurants.categories.index', $restaurant) }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 mb-2">Categories</p>
                <p class="text-3xl font-bold text-purple-600">{{ $restaurant->categories->count() }}</p>
            </div>
            <i class="fas fa-tags text-purple-600 text-4xl"></i>
        </div>
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Recent Recipes</h2>
    @if($restaurant->recipes->isEmpty())
        <p class="text-gray-600 text-center py-8">No recipes yet. <a href="{{ route('restaurants.recipes.create', $restaurant) }}" class="text-blue-600 hover:underline">Create your first recipe</a></p>
    @else
        <div class="space-y-4">
            @foreach($restaurant->recipes->take(5) as $recipe)
                <div class="flex justify-between items-center border-b pb-3">
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $recipe->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $recipe->category->name ?? 'Uncategorized' }}</p>
                    </div>
                    <div class="text-right">
                        @if($recipe->latestCost)
                            <p class="text-sm text-gray-600">Cost: ₹{{ number_format($recipe->latestCost->total_cost, 2) }}</p>
                            <p class="text-sm text-green-600">Price: ₹{{ number_format($recipe->latestCost->suggested_price, 2) }}</p>
                        @endif
                        <a href="{{ route('restaurants.recipes.show', [$restaurant, $recipe]) }}" class="text-blue-600 hover:underline text-sm">View</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection