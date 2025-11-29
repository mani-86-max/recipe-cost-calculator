@extends('layouts.app')

@section('title', 'Recipes')

@section('content')
<div class="animate-fade-in">

    <div class="mb-6">
        <a href="{{ route('restaurants.show', $restaurant) }}" 
           class="text-purple-600 hover:text-purple-800 transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to {{ $restaurant->name }}
        </a>
    </div>

    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Recipes</h1>
                <p class="text-gray-600">{{ $restaurant->name }}</p>
            </div>

            <a href="{{ route('restaurants.recipes.create', $restaurant) }}" 
               class="btn-primary text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2">
                <i class="fas fa-plus-circle"></i>
                <span>New Recipe</span>
            </a>
        </div>
    </div>

    @if($recipes->isEmpty())
    
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
            <div class="inline-block p-6 bg-blue-100 rounded-full mb-6">
                <i class="fas fa-book text-blue-600 text-6xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-3">No Recipes Yet</h2>
            <p class="text-gray-600 mb-6 max-w-md mx-auto">
                Create your first recipe to start calculating costs
            </p>
            <a href="{{ route('restaurants.recipes.create', $restaurant) }}" 
               class="inline-block btn-primary text-white px-8 py-3 rounded-lg shadow-lg">
                <i class="fas fa-plus-circle mr-2"></i>
                Create Your First Recipe
            </a>
        </div>

    @else

        <!-- ============================= -->
        <!--         Recipe Cards          -->
        <!-- ============================= -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($recipes as $recipe)
            
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover h-[550px] flex flex-col">

                    <!-- Image Header Section -->
                    <div class="h-48 bg-gradient-to-br from-orange-400 via-pink-500 to-purple-600 relative flex items-center justify-center">
                        <div class="text-white text-6xl">
                            <i class="fas fa-utensils drop-shadow-lg"></i>
                        </div>

                        @if($recipe->category)
                            <div class="absolute top-4 left-4">
                                <span class="badge bg-white text-purple-700 shadow-lg">
                                    <i class="fas fa-tag mr-1"></i>
                                    {{ $recipe->category->name }}
                                </span>
                            </div>
                        @endif

                        <div class="absolute top-4 right-4 flex space-x-2">
                            <a href="{{ route('restaurants.recipes.edit', [$restaurant, $recipe]) }}" 
                               class="w-10 h-10 bg-white text-blue-600 rounded-full flex items-center justify-center hover:bg-blue-50 transition-colors shadow-lg">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 flex flex-col flex-1 overflow-hidden">

                        <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-1">{{ $recipe->name }}</h3>

                        @if($recipe->description)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $recipe->description }}</p>
                        @endif

                        <!-- Stats -->
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-4 pb-4 border-b">
                            <div class="flex items-center">
                                <i class="fas fa-users text-blue-500 mr-2"></i>
                                <span>{{ $recipe->serving_size }} servings</span>
                            </div>

                            @if($recipe->prep_time || $recipe->cook_time)
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-green-500 mr-2"></i>
                                    <span>{{ ($recipe->prep_time ?? 0) + ($recipe->cook_time ?? 0) }}m</span>
                                </div>
                            @endif
                        </div>

                        <!-- Cost Section -->
                        @if($recipe->latestCost)
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Total Cost:</span>
                                    <span class="font-bold text-red-600 text-lg">₹{{ number_format($recipe->latestCost->total_cost, 2) }}</span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Suggested Price:</span>
                                    <span class="font-bold text-green-600 text-lg">₹{{ number_format($recipe->latestCost->suggested_price, 2) }}</span>
                                </div>

                                <div class="flex justify-between items-center pt-2 border-t">
                                    <span class="text-sm font-semibold text-gray-700">Profit:</span>
                                    <span class="font-bold text-blue-600 text-lg">
                                        ₹{{ number_format($recipe->latestCost->suggested_price - $recipe->latestCost->total_cost, 2) }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        <!-- Buttons -->
                        <div class="mt-auto flex gap-2">
                            <a href="{{ route('restaurants.recipes.show', [$restaurant, $recipe]) }}" 
                               class="flex-1 text-center bg-gradient-to-r from-purple-600 to-pink-600 text-white py-2 rounded-lg hover:shadow-lg transition-all font-semibold">
                                <i class="fas fa-eye mr-1"></i>
                                View
                            </a>

                            <form action="{{ route('restaurants.recipes.destroy', [$restaurant, $recipe]) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Delete this recipe?')" 
                                  class="flex-shrink-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            @endforeach
        </div>

        <div class="mt-8">
            {{ $recipes->links() }}
        </div>

    @endif

</div>
@endsection