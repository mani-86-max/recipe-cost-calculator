@extends('layouts.app')

@section('title', 'Edit Category')

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
            <div class="inline-block p-4 bg-blue-100 rounded-full mb-4">
                <i class="fas fa-edit text-blue-600 text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Category</h1>
            <p class="text-gray-600">Update {{ $category->name }} details</p>
        </div>
        
        <form action="{{ route('restaurants.categories.update', [$restaurant, $category]) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Category Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-tag text-purple-600 mr-2"></i>
                        Category Name *
                    </label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition text-lg">
                </div>
                
                <!-- Description -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-align-left text-blue-600 mr-2"></i>
                        Description
                    </label>
                    <textarea name="description" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">{{ old('description', $category->description) }}</textarea>
                </div>
                
                <!-- Info Box -->
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                    <p class="text-sm text-blue-800 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Changes will apply to all recipes in this category
                    </p>
                </div>
            </div>
            
            <!-- Submit Buttons -->
            <div class="flex space-x-4 mt-8 pt-6 border-t">
                <button type="submit" class="flex-1 btn-primary text-white px-8 py-4 rounded-lg shadow-lg flex items-center justify-center space-x-2 text-lg font-semibold">
                    <i class="fas fa-save"></i>
                    <span>Update Category</span>
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