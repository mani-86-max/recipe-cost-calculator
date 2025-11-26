@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="mb-6">
    <a href="{{ route('restaurants.show', $restaurant) }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left"></i> Back to Restaurant
    </a>
</div>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Categories</h1>
    <a href="{{ route('restaurants.categories.create', $restaurant) }}" 
        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
        <i class="fas fa-plus"></i> New Category
    </a>
</div>

@if($categories->isEmpty())
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <i class="fas fa-tags text-gray-400 text-6xl mb-4"></i>
        <h2 class="text-xl font-semibold text-gray-700 mb-2">No categories yet</h2>
        <p class="text-gray-600 mb-4">Create categories to organize your recipes</p>
        <a href="{{ route('restaurants.categories.create', $restaurant) }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            Create Category
        </a>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $category->name }}</h2>
                        @if($category->description)
                            <p class="text-gray-600 text-sm">{{ $category->description }}</p>
                        @endif
                    </div>
                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                        {{ $category->recipes_count }}
                    </span>
                </div>
                
                <div class="flex space-x-2 pt-4 border-t">
                    <a href="{{ route('restaurants.categories.edit', [$restaurant, $category]) }}" 
                        class="flex-1 text-center bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('restaurants.categories.destroy', [$restaurant, $category]) }}" 
                        method="POST" onsubmit="return confirm('Delete this category?')" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection