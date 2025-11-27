@extends('layouts.app')

@section('title', 'Edit Restaurant')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg p-8 mt-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">Edit Restaurant</h1>
    
    <form action="{{ route('restaurants.update', $restaurant) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Restaurant Name -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Restaurant Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $restaurant->name) }}" required
                class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent shadow-sm">
        </div>
        
        <!-- Address -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Address</label>
            <input type="text" name="address" value="{{ old('address', $restaurant->address) }}"
                class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent shadow-sm">
        </div>
        
        <!-- Phone -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $restaurant->phone) }}"
                class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent shadow-sm">
        </div>
        
        <!-- Overhead % and Profit Margin % -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Overhead %</label>
                <input type="number" name="overhead_percentage" value="{{ old('overhead_percentage', $restaurant->overhead_percentage) }}" 
                    step="0.01" min="0" max="100"
                    class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent shadow-sm">
                <p class="text-sm text-gray-500 mt-1">Labor, utilities, rent costs</p>
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Default Profit Margin %</label>
                <input type="number" name="default_profit_margin" value="{{ old('default_profit_margin', $restaurant->default_profit_margin) }}" 
                    step="0.01" min="0" max="100"
                    class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent shadow-sm">
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-col md:flex-row justify-center md:justify-start gap-4 mt-4">
            <button type="submit" class="flex items-center justify-center bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-xl font-semibold shadow-md transition-all">
                <i class="fas fa-save mr-2"></i> Update Restaurant
            </button>
            <a href="{{ route('restaurants.show', $restaurant) }}" class="flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-medium transition-all">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
