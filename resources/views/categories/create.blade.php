@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
<div class="animate-fade-in">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('restaurants.categories.index', $restaurant) }}" class="text-purple-600 hover:text-purple-800 transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Categories
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl mx-auto">
        <div class="mb-8 text-center">
            <div class="inline-block p-4 bg-purple-100 rounded-full mb-4">
                <i class="fas fa-tags text-purple-600 text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Create New Category</h1>
            <p class="text-gray-600">Organize your recipes with categories</p>
        </div>
        
        <form action="{{ route('restaurants.categories.store', $restaurant) }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Category Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-tag text-purple-600 mr-2"></i>
                        Category Name *
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition text-lg"
                        placeholder="e.g., Appetizers, Main Course, Desserts, Beverages">
                </div>
                
                <!-- Description -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-align-left text-blue-600 mr-2"></i>
                        Description (optional)
                    </label>
                    <textarea name="description" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                        placeholder="Brief description of this category...">{{ old('description') }}</textarea>
                </div>
                
                <!-- Category Suggestions -->
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-lg border border-purple-200">
                    <h4 class="font-bold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                        Popular Categories
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" onclick="document.querySelector('input[name=name]').value='Appetizers'" class="badge bg-white text-purple-700 hover:bg-purple-100 cursor-pointer transition">
                            <i class="fas fa-drumstick-bite mr-1"></i> Appetizers
                        </button>
                        <button type="button" onclick="document.querySelector('input[name=name]').value='Main Course'" class="badge bg-white text-purple-700 hover:bg-purple-100 cursor-pointer transition">
                            <i class="fas fa-utensils mr-1"></i> Main Course
                        </button>
                        <button type="button" onclick="document.querySelector('input[name=name]').value='Desserts'" class="badge bg-white text-purple-700 hover:bg-purple-100 cursor-pointer transition">
                            <i class="fas fa-ice-cream mr-1"></i> Desserts
                        </button>
                        <button type="button" onclick="document.querySelector('input[name=name]').value='Beverages'" class="badge bg-white text-purple-700 hover:bg-purple-100 cursor-pointer transition">
                            <i class="fas fa-coffee mr-1"></i> Beverages
                        </button>
                        <button type="button" onclick="document.querySelector('input[name=name]').value='Salads'" class="badge bg-white text-purple-700 hover:bg-purple-100 cursor-pointer transition">
                            <i class="fas fa-leaf mr-1"></i> Salads
                        </button>
                        <button type="button" onclick="document.querySelector('input[name=name]').value='Soups'" class="badge bg-white text-purple-700 hover:bg-purple-100 cursor-pointer transition">
                            <i class="fas fa-bowl-food mr-1"></i> Soups
                        </button>
                        <button type="button" onclick="document.querySelector('input[name=name]').value='Breads'" class="badge bg-white text-purple-700 hover:bg-purple-100 cursor-pointer transition">
                            <i class="fas fa-bread-slice mr-1"></i> Breads
                        </button>
                        <button type="button" onclick="document.querySelector('input[name=name]').value='Side Dishes'" class="badge bg-white text-purple-700 hover:bg-purple-100 cursor-pointer transition">
                            <i class="fas fa-plate-wheat mr-1"></i> Side Dishes
                        </button>
                    </div>
                    <p class="text-xs text-gray-600 mt-3">
                        <i class="fas fa-info-circle mr-1"></i>
                        Click on a suggestion to use it
                    </p>
                </div>
            </div>
            
            <!-- Submit Buttons -->
            <div class="flex space-x-4 mt-8 pt-6 border-t">
                <button type="submit" class="flex-1 btn-primary text-white px-8 py-4 rounded-lg shadow-lg flex items-center justify-center space-x-2 text-lg font-semibold">
                    <i class="fas fa-save"></i>
                    <span>Create Category</span>
                </button>
                <a href="{{ route('restaurants.categories.index', $restaurant) }}" class="px-8 py-4 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors flex items-center justify-center space-x-2 text-lg font-semibold">
                    <i class="fas fa-times"></i>
                    <span>Cancel</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection