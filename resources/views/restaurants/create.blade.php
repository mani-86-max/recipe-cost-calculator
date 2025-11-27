@extends('layouts.app')

@section('title', 'Create Restaurant')

@section('content')
<div class="animate-fade-in">
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-3xl mx-auto">
        <div class="mb-8 text-center">
            <div class="inline-block p-4 bg-blue-100 rounded-full mb-4">
                <i class="fas fa-store text-blue-600 text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Create New Restaurant</h1>
            <p class="text-gray-600">Set up your restaurant profile</p>
        </div>
        
        <form action="{{ route('restaurants.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Restaurant Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-store text-blue-600 mr-2"></i>
                        Restaurant Name *
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition text-lg"
                        placeholder="e.g., The Golden Spoon, Mama's Kitchen">
                </div>
                
                <!-- Address -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-map-marker-alt text-red-600 mr-2"></i>
                        Address
                    </label>
                    <input type="text" name="address" value="{{ old('address') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                        placeholder="Street, City, State">
                </div>
                
                <!-- Phone -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-phone text-green-600 mr-2"></i>
                        Phone Number
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                        placeholder="+91 XXXXX XXXXX">
                </div>
                
                <!-- Overhead and Profit Margin -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-percentage text-orange-600 mr-2"></i>
                            Overhead %
                        </label>
                        <input type="number" name="overhead_percentage" value="{{ old('overhead_percentage', 0) }}" 
                            step="0.01" min="0" max="100"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        <p class="text-sm text-gray-500 mt-1">Labor, utilities, rent costs</p>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-chart-line text-purple-600 mr-2"></i>
                            Default Profit Margin %
                        </label>
                        <input type="number" name="default_profit_margin" value="{{ old('default_profit_margin', 30) }}" 
                            step="0.01" min="0" max="100"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        <p class="text-sm text-gray-500 mt-1">Target profit percentage</p>
                    </div>
                </div>
                
                <!-- Info Box -->
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-lg border border-purple-200">
                    <h4 class="font-bold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                        Tip
                    </h4>
                    <p class="text-sm text-gray-700">
                        Set your overhead and profit margin percentages now. You can always update them later. These values will be used to calculate suggested pricing for your recipes.
                    </p>
                </div>
            </div>
            
            <!-- Submit Buttons -->
            <div class="flex space-x-4 mt-8 pt-6 border-t">
                <button type="submit" class="flex-1 btn-primary text-white px-8 py-4 rounded-lg shadow-lg flex items-center justify-center space-x-2 text-lg font-semibold">
                    <i class="fas fa-save"></i>
                    <span>Create Restaurant</span>
                </button>
                <a href="{{ route('restaurants.index') }}" class="px-8 py-4 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors flex items-center justify-center space-x-2 text-lg font-semibold">
                    <i class="fas fa-times"></i>
                    <span>Cancel</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection