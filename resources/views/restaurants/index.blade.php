@extends('layouts.app')

@section('title', 'My Restaurants')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">My Restaurants</h1>
    <a href="{{ route('restaurants.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
        <i class="fas fa-plus"></i> New Restaurant
    </a>
</div>

@if($restaurants->isEmpty())
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <i class="fas fa-store text-gray-400 text-6xl mb-4"></i>
        <h2 class="text-xl font-semibold text-gray-700 mb-2">No restaurants yet</h2>
        <p class="text-gray-600 mb-4">Create your first restaurant to start managing recipes</p>
        <a href="{{ route('restaurants.create') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            Create Restaurant
        </a>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($restaurants as $restaurant)
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-xl font-bold text-gray-800">{{ $restaurant->name }}</h2>
                    <div class="flex space-x-2">
                        <a href="{{ route('restaurants.edit', $restaurant) }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
                
                @if($restaurant->address)
                    <p class="text-gray-600 text-sm mb-2">
                        <i class="fas fa-map-marker-alt"></i> {{ $restaurant->address }}
                    </p>
                @endif
                
                <div class="border-t pt-4 mt-4">
                    <p class="text-gray-600 mb-2">
                        <i class="fas fa-book"></i> {{ $restaurant->recipes->count() }} Recipes
                    </p>
                    <p class="text-gray-600 mb-4">
                        <i class="fas fa-chart-line"></i> {{ $restaurant->default_profit_margin }}% Profit Margin
                    </p>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('restaurants.show', $restaurant) }}" class="flex-1 text-center bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection