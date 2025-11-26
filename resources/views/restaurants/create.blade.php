@extends('layouts.app')

@section('title', 'Create Restaurant')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Create New Restaurant</h1>
    
    <form action="{{ route('restaurants.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Restaurant Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Address</label>
            <input type="text" name="address" value="{{ old('address') }}"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Overhead %</label>
                <input type="number" name="overhead_percentage" value="{{ old('overhead_percentage', 0) }}" 
                    step="0.01" min="0" max="100"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                <p class="text-sm text-gray-600 mt-1">Labor, utilities, rent costs</p>
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Default Profit Margin %</label>
                <input type="number" name="default_profit_margin" value="{{ old('default_profit_margin', 30) }}" 
                    step="0.01" min="0" max="100"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        
        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-save"></i> Create Restaurant
            </button>
            <a href="{{ route('restaurants.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection