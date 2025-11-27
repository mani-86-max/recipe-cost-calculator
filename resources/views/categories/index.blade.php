@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="animate-fade-in">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('restaurants.show', $restaurant) }}" class="text-purple-600 hover:text-purple-800 transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Restaurant
        </a>
    </div>

    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Recipe Categories</h1>
                <p class="text-gray-600">Organize your recipes - {{ $restaurant->name }}</p>
            </div>
            <a href="{{ route('restaurants.categories.create', $restaurant) }}" class="btn-primary text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2">
                <i class="fas fa-plus-circle"></i>
                <span>New Category</span>
            </a>
        </div>
    </div>

    @if($categories->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
            <div class="inline-block p-6 bg-purple-100 rounded-full mb-6">
                <i class="fas fa-tags text-purple-600 text-6xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-3">No Categories Yet</h2>
            <p class="text-gray-600 mb-6 max-w-md mx-auto">
                Create categories to organize your recipes like Appetizers, Main Course, Desserts, etc.
            </p>
            <a href="{{ route('restaurants.categories.create', $restaurant) }}" class="inline-block btn-primary text-white px-8 py-3 rounded-lg shadow-lg">
                <i class="fas fa-plus-circle mr-2"></i>
                Create Your First Category
            </a>
        </div>
    @else
        <!-- Category Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                    <!-- Category Header with Gradient -->
                    <div class="h-32 bg-gradient-to-br from-purple-500 via-pink-500 to-red-500 relative flex items-center justify-center">
                        <div class="absolute inset-0 bg-black opacity-20"></div>
                        <div class="relative z-10 text-center">
                            <i class="fas fa-tag text-white text-5xl drop-shadow-lg mb-2"></i>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="bg-white text-purple-700 px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                                {{ $category->recipes_count }} recipes
                            </span>
                        </div>
                    </div>
                    
                    <!-- Category Body -->
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $category->name }}</h3>
                        
                        @if($category->description)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $category->description }}</p>
                        @else
                            <p class="text-gray-400 text-sm italic mb-4">No description</p>
                        @endif
                        
                        <!-- Stats Bar -->
                        <div class="flex items-center justify-between mb-4 p-3 bg-purple-50 rounded-lg">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-book text-purple-600"></i>
                                <span class="text-sm text-gray-700">Total Recipes</span>
                            </div>
                            <span class="text-2xl font-bold text-purple-600">{{ $category->recipes_count }}</span>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('restaurants.categories.edit', [$restaurant, $category]) }}" 
                               class="flex-1 text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                            <form action="{{ route('restaurants.categories.destroy', [$restaurant, $category]) }}" 
                                  method="POST" onsubmit="return confirm('Delete this category?')" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition-colors font-semibold">
                                    <i class="fas fa-trash mr-1"></i>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection