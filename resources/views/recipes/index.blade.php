@extends('layouts.app')

@section('title', 'Recipes')

@section('content')
<div class="mb-6">
    <a href="{{ route('restaurants.show', $restaurant) }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left"></i> Back to Restaurant
    </a>
</div>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Recipes - {{ $restaurant->name }}</h1>
    <a href="{{ route('restaurants.recipes.create', $restaurant) }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
        <i class="fas fa-plus"></i> New Recipe
    </a>
</div>

@if($recipes->isEmpty())
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <i class="fas fa-book text-gray-400 text-6xl mb-4"></i>
        <h2 class="text-xl font-semibold text-gray-700 mb-2">No recipes yet</h2>
        <p class="text-gray-600 mb-4">Create your first recipe to start calculating costs</p>
        <a href="{{ route('restaurants.recipes.create', $restaurant) }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            Create Recipe
        </a>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($recipes as $recipe)
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <h2 class="text-xl font-bold text-gray-800">{{ $recipe->name }}</h2>
                        @if($recipe->category)
                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">
                                {{ $recipe->category->name }}
                            </span>
                        @endif
                    </div>
                    
                    @if($recipe->description)
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $recipe->description }}</p>
                    @endif
                    
                    <div class="flex items-center text-sm text-gray-600 mb-4">
                        <span class="mr-4"><i class="fas fa-users"></i> {{ $recipe->serving_size }}</span>
                        @if($recipe->prep_time)
                            <span class="mr-4"><i class="fas fa-clock"></i> {{ $recipe->prep_time }}m</span>
                        @endif
                    </div>
                    
                    @if($recipe->latestCost)
                        <div class="border-t pt-4">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Cost:</span>
                                <span class="font-semibold text-gray-800">${{ number_format($recipe->latestCost->total_cost, 2) }}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Suggested Price:</span>
                                <span class="font-semibold text-green-600">${{ number_format($recipe->latestCost->suggested_price, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Profit:</span>
                                <span class="font-semibold text-blue-600">${{ number_format($recipe->latestCost->suggested_price - $recipe->latestCost->total_cost, 2) }}</span>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="bg-gray-50 px-6 py-3 flex justify-between">
                    <a href="{{ route('restaurants.recipes.show', [$restaurant, $recipe]) }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-eye"></i> View
                    </a>
                    <a href="{{ route('restaurants.recipes.edit', [$restaurant, $recipe]) }}" class="text-green-600 hover:text-green-800">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('restaurants.recipes.destroy', [$restaurant, $recipe]) }}" method="POST" onsubmit="return confirm('Delete this recipe?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-6">
        {{ $recipes->links() }}
    </div>
@endif
@endsection