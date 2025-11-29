@extends('layouts.app')

@section('title', $recipe->name)

@section('content')
<div class="animate-fade-in">

    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('restaurants.recipes.index', $restaurant) }}" 
           class="text-purple-600 hover:text-purple-800 transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Recipes
        </a>
    </div>

    <!-- RECIPE IMAGE TOPMOST -->
    @if($recipe->image)
        <div class="w-full h-64 lg:h-96 relative rounded-xl overflow-hidden shadow-lg mb-6">
            <img src="{{ asset('storage/' . $recipe->image) }}" 
                 alt="{{ $recipe->name }}" 
                 class="w-full h-full object-cover">

            <!-- GRADIENT HEADER OVERLAY -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent 
                        flex items-end p-6">
                <div class="text-white">
                    <h1 class="text-4xl lg:text-5xl font-bold drop-shadow-lg">{{ $recipe->name }}</h1>
                    @if($recipe->category)
                        <span class="badge bg-white text-purple-700 mt-2 px-4 py-2 shadow-lg inline-block">
                            <i class="fas fa-tag mr-2"></i>
                            {{ $recipe->category->name }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- LEFT SECTION -->
        <div class="lg:col-span-2 space-y-6">

            <!-- STATS CARD -->
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-blue-50 rounded-lg p-4 text-center shadow-sm">
                    <i class="fas fa-users text-blue-600 text-3xl mb-2"></i>
                    <p class="text-sm text-gray-600">Servings</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $recipe->serving_size }}</p>
                </div>

                <div class="bg-green-50 rounded-lg p-4 text-center shadow-sm">
                    <i class="fas fa-clock text-green-600 text-3xl mb-2"></i>
                    <p class="text-sm text-gray-600">Prep Time</p>
                    <p class="text-2xl font-bold text-green-600">{{ $recipe->prep_time }}m</p>
                </div>

                <div class="bg-red-50 rounded-lg p-4 text-center shadow-sm">
                    <i class="fas fa-fire text-red-600 text-3xl mb-2"></i>
                    <p class="text-sm text-gray-600">Cook Time</p>
                    <p class="text-2xl font-bold text-red-600">{{ $recipe->cook_time }}m</p>
                </div>
            </div>

            <!-- INGREDIENTS CARD -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-carrot text-orange-600 mr-3"></i>
                    Ingredients
                </h2>

                <div class="space-y-3">
                    @foreach($costBreakdown['ingredients'] as $ingredient)
                        <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg border 
                                    hover:border-purple-300 transition-colors">
                            <div class="flex items-center space-x-4 flex-1">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-leaf text-purple-600"></i>
                                </div>

                                <span class="text-gray-800 font-medium">
                                    <span class="font-bold text-purple-600">{{ $ingredient['quantity'] }}</span>
                                    {{ $ingredient['unit'] }}
                                    {{ $ingredient['name'] }}
                                </span>
                            </div>

                            <div class="text-right">
                                <p class="font-bold text-gray-800">₹{{ number_format($ingredient['cost_per_serving'], 2) }}</p>
                                <p class="text-xs text-gray-500">{{ $ingredient['percentage'] }}%</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- INSTRUCTIONS -->
            @if($recipe->instructions)
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-list-ol text-blue-600 mr-3"></i>
                        Instructions
                    </h2>

                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        {!! $recipe->instructions !!}
                    </div>
                </div>
            @endif

        </div>

        <!-- RIGHT SIDEBAR (COST ANALYSIS) -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg p-6 sticky top-6 space-y-4">

                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-chart-pie text-purple-600 mr-3"></i>
                    Cost Analysis
                </h2>

                <!-- Ingredient Cost -->
                <div class="p-4 bg-orange-50 rounded-lg border-l-4 border-orange-500">
                    <p class="text-sm text-orange-700 font-semibold mb-1">Ingredient Cost</p>
                    <p class="text-3xl font-bold text-orange-600">₹{{ number_format($costBreakdown['ingredient_cost'], 2) }}</p>
                </div>

                <!-- Overhead Cost -->
                <div class="p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                    <p class="text-sm text-yellow-700 font-semibold mb-1">Overhead Cost</p>
                    <p class="text-3xl font-bold text-yellow-600">₹{{ number_format($costBreakdown['overhead_cost'], 2) }}</p>
                </div>

                <!-- Total Cost -->
                <div class="p-4 bg-red-50 rounded-lg border-l-4 border-red-500">
                    <p class="text-sm text-red-700 font-semibold mb-1">Total Cost per Serving</p>
                    <p class="text-4xl font-bold text-red-600">₹{{ number_format($costBreakdown['total_cost'], 2) }}</p>
                </div>

                <!-- Margin -->
                <div class="p-4 bg-purple-50 rounded-lg border-l-4 border-purple-500">
                    <p class="text-sm text-purple-700 font-semibold mb-1">Profit Margin</p>
                    <p class="text-3xl font-bold text-purple-600">{{ number_format($costBreakdown['profit_margin'], 1) }}%</p>
                </div>

                <!-- Suggested Price -->
                <div class="p-6 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-lg">
                    <p class="text-sm text-white/90 font-semibold mb-2">Suggested Selling Price</p>
                    <p class="text-5xl font-bold text-white">₹{{ number_format($costBreakdown['suggested_price'], 2) }}</p>
                </div>

                <!-- Profit -->
                <div class="p-6 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl shadow-lg">
                    <p class="text-sm text-white/90 font-semibold mb-2">Potential Profit</p>
                    <p class="text-5xl font-bold text-white">
                        ₹{{ number_format($costBreakdown['suggested_price'] - $costBreakdown['total_cost'], 2) }}
                    </p>
                    <p class="text-white/80 text-xs mt-2">per serving</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
