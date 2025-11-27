@extends('layouts.app')

@section('title', 'My Restaurants')

@section('content')
<div class="animate-fade-in">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2 text-center">My Restaurants</h1>
                <p class="text-gray-600">Manage your restaurant recipes and costs</p>
            </div>
            <a href="{{ route('restaurants.create') }}" class="btn-primary text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2">
                <i class="fas fa-plus-circle"></i>
                <span>New Restaurant</span>
            </a>
        </div>
    </div>

    @if($restaurants->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
            <div class="inline-block p-6 bg-purple-100 rounded-full mb-6">
                <i class="fas fa-store text-purple-600 text-6xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-3">No Restaurants Yet</h2>
            <p class="text-gray-600 mb-6 max-w-md mx-auto">
                Create your first restaurant to start managing recipes and calculating costs
            </p>
            <a href="{{ route('restaurants.create') }}" class="inline-block btn-primary text-white px-8 py-3 rounded-lg shadow-lg">
                <i class="fas fa-plus-circle mr-2"></i>
                Create Your First Restaurant
            </a>
        </div>
    @else
        <!-- Restaurant Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($restaurants as $restaurant)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                    <!-- Card Header with Gradient -->
                    <div class="h-32 bg-gradient-to-br from-purple-500 via-pink-500 to-red-500 relative">
                        <div class="absolute inset-0 bg-black opacity-20"></div>
                        <div class="absolute top-4 right-4">
                            <a href="{{ route('restaurants.edit', $restaurant) }}" 
                               class="bg-white text-purple-600 w-10 h-10 rounded-full flex items-center justify-center hover:bg-purple-50 transition-colors shadow-lg">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h2 class="text-2xl font-bold text-white drop-shadow-lg">{{ $restaurant->name }}</h2>
                        </div>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="p-6">
                        @if($restaurant->address)
                            <div class="flex items-start text-gray-600 text-sm mb-3">
                                <i class="fas fa-map-marker-alt mt-1 mr-2 text-red-500"></i>
                                <span>{{ $restaurant->address }}</span>
                            </div>
                        @endif
                        
                        @if($restaurant->phone)
                            <div class="flex items-center text-gray-600 text-sm mb-4">
                                <i class="fas fa-phone mt-1 mr-2 text-green-500"></i>
                                <span>{{ $restaurant->phone }}</span>
                            </div>
                        @endif
                        
                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="bg-blue-50 rounded-lg p-3 text-center">
                                <i class="fas fa-book text-blue-600 text-xl mb-1"></i>
                                <p class="text-2xl font-bold text-blue-600">{{ $restaurant->recipes->count() }}</p>
                                <p class="text-xs text-gray-600">Recipes</p>
                            </div>
                            <div class="bg-green-50 rounded-lg p-3 text-center">
                                <i class="fas fa-chart-line text-green-600 text-xl mb-1"></i>
                                <p class="text-2xl font-bold text-green-600">{{ $restaurant->default_profit_margin }}%</p>
                                <p class="text-xs text-gray-600">Profit Margin</p>
                            </div>
                        </div>
                        
                        <!-- Action Button -->
                        <a href="{{ route('restaurants.show', $restaurant) }}" 
                           class="block w-full text-center bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 rounded-lg hover:shadow-lg transition-all font-semibold">
                            <i class="fas fa-arrow-right mr-2"></i>
                            View Dashboard
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection