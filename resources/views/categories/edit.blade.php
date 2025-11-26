@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="mb-6">
    <a href="{{ route('restaurants.categories.index', $restaurant) }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left"></i> Back to Categories
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Category</h1>
    
    <form action="{{ route('restaurants.categories.update', [$restaurant, $category]) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Category Name *</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" rows="3"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('description', $category->description) }}</textarea>
        </div>
        
        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-save"></i> Update Category
            </button>
            <a href="{{ route('restaurants.categories.index', $restaurant) }}" 
                class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection