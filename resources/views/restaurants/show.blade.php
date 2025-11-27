@extends('layouts.app')

@section('title', $restaurant->name)

@section('content')
<div class="animate-fade-in">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('restaurants.index') }}" class="text-purple-600 hover:text-purple-800 transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Restaurants
        </a>
    </div>

    <!-- Restaurant Header Card -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
        <div class="h-48 bg-gradient-to-br from-purple-600 via-pink-600 to-red-600 relative">
            <div class="absolute inset-0 bg-black opacity-20"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center text-white">
                    <h1 class="text-5xl font-bold mb-2 drop-shadow-lg">{{ $restaurant->name }}</h1>
                    @if($restaurant->address)
                        <p class="text-white/90 flex items-center justify-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ $restaurant->address }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="absolute top-4 right-4">
                <a href="{{ route('restaurants.edit', $restaurant) }}" 
                   class="bg-white text-purple-600 px-4 py-2 rounded-lg hover:bg-purple-50 transition-colors shadow-lg flex items-center space-x-2">
                    <i class="fas fa-edit"></i>
                    <span>Edit</span>
                </a>
            </div>
        </div>
        
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @if($restaurant->phone)
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-phone text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Phone</p>
                            <p class="font-semibold text-gray-800">{{ $restaurant->phone }}</p>
                        </div>
                    </div>
                @endif
                
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-percentage text-orange-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Overhead</p>
                        <p class="font-semibold text-gray-800">{{ $restaurant->overhead_percentage }}%</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Profit Margin</p>
                        <p class="font-semibold text-gray-800">{{ $restaurant->default_profit_margin }}%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('restaurants.recipes.index', $restaurant) }}" 
           class="group bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-book text-white text-2xl"></i>
                </div>
                <i class="fas fa-arrow-right text-gray-400 group-hover:text-blue-600 group-hover:translate-x-2 transition-all"></i>
            </div>
            <p class="text-gray-600 text-sm mb-1">Total Recipes</p>
            <p class="text-4xl font-bold text-gray-800">{{ $restaurant->recipes->count() }}</p>
        </a>
        
        <a href="{{ route('restaurants.ingredients.index', $restaurant) }}" 
           class="group bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-carrot text-white text-2xl"></i>
                </div>
                <i class="fas fa-arrow-right text-gray-400 group-hover:text-green-600 group-hover:translate-x-2 transition-all"></i>
            </div>
            <p class="text-gray-600 text-sm mb-1">Ingredients</p>
            <p class="text-4xl font-bold text-gray-800">{{ $restaurant->ingredients->count() }}</p>
        </a>
        
        <a href="{{ route('restaurants.categories.index', $restaurant) }}" 
           class="group bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-tags text-white text-2xl"></i>
                </div>
                <i class="fas fa-arrow-right text-gray-400 group-hover:text-purple-600 group-hover:translate-x-2 transition-all"></i>
            </div>
            <p class="text-gray-600 text-sm mb-1">Categories</p>
            <p class="text-4xl font-bold text-gray-800">{{ $restaurant->categories->count() }}</p>
        </a>
    </div>

    <!-- Recent Recipes Section -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-clock text-purple-600 mr-3"></i>
                Recent Recipes
            </h2>
            <a href="{{ route('restaurants.recipes.index', $restaurant) }}" 
               class="text-purple-600 hover:text-purple-800 transition-colors flex items-center space-x-2">
                <span>View All</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        @if($restaurant->recipes->isEmpty())
            <div class="text-center py-12">
                <div class="inline-block p-6 bg-gray-100 rounded-full mb-4">
                    <i class="fas fa-book text-gray-400 text-5xl"></i>
                </div>
                <p class="text-gray-600 mb-4">No recipes yet. Start by creating your first recipe!</p>
                <a href="{{ route('restaurants.recipes.create', $restaurant) }}" 
                   class="inline-block btn-primary text-white px-6 py-3 rounded-lg shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    Create First Recipe
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($restaurant->recipes->take(5) as $recipe)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-purple-300 hover:shadow-md transition-all group">
                        <div class="flex items-center space-x-4 flex-1">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                                {{ substr($recipe->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 group-hover:text-purple-600 transition-colors">
                                    {{ $recipe->name }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    <span class="badge bg-purple-100 text-purple-700">
                                        {{ $recipe->category->name ?? 'Uncategorized' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        
                        @if($recipe->latestCost)
                            <div class="flex items-center space-x-6 mr-4">
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">Cost</p>
                                    <p class="font-semibold text-red-600">₹{{ number_format($recipe->latestCost->total_cost, 2) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">Price</p>
                                    <p class="font-semibold text-green-600">₹{{ number_format($recipe->latestCost->suggested_price, 2) }}</p>
                                </div>
                            </div>
                        @endif
                        
                        <a href="{{ route('restaurants.recipes.show', [$restaurant, $recipe]) }}" 
                           class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors flex items-center space-x-2">
                            <span>View</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection