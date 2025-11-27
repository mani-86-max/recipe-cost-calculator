@extends('layouts.app')

@section('title', 'Ingredients')

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
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Ingredients</h1>
                <p class="text-gray-600">{{ $restaurant->name }}</p>
            </div>
            <a href="{{ route('restaurants.ingredients.create', $restaurant) }}" class="btn-primary text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2">
                <i class="fas fa-plus-circle"></i>
                <span>New Ingredient</span>
            </a>
        </div>
    </div>

    @if($ingredients->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
            <div class="inline-block p-6 bg-green-100 rounded-full mb-6">
                <i class="fas fa-carrot text-green-600 text-6xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-3">No Ingredients Yet</h2>
            <p class="text-gray-600 mb-6 max-w-md mx-auto">
                Add ingredients to start calculating recipe costs
            </p>
            <a href="{{ route('restaurants.ingredients.create', $restaurant) }}" class="inline-block btn-primary text-white px-8 py-3 rounded-lg shadow-lg">
                <i class="fas fa-plus-circle mr-2"></i>
                Add Your First Ingredient
            </a>
        </div>
    @else
        <!-- Ingredients Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-purple-600 to-pink-600 text-white">
                            <th class="px-6 py-4 text-left font-semibold">
                                <i class="fas fa-leaf mr-2"></i>Ingredient
                            </th>
                            <th class="px-6 py-4 text-left font-semibold">
                                <i class="fas fa-rupee-sign mr-2"></i>Price
                            </th>
                            <th class="px-6 py-4 text-left font-semibold">
                                <i class="fas fa-balance-scale mr-2"></i>Quantity
                            </th>
                            <th class="px-6 py-4 text-left font-semibold">
                                <i class="fas fa-percentage mr-2"></i>Wastage
                            </th>
                            <th class="px-6 py-4 text-left font-semibold">
                                <i class="fas fa-truck mr-2"></i>Supplier
                            </th>
                            <th class="px-6 py-4 text-center font-semibold">
                                <i class="fas fa-cog mr-2"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($ingredients as $ingredient)
                            <tr class="hover:bg-purple-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($ingredient->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $ingredient->name }}</div>
                                            <div class="text-sm text-gray-500">
                                                <i class="fas fa-clock mr-1"></i>
                                                Updated {{ $ingredient->last_price_update?->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-lg font-bold text-green-600">
                                        ₹{{ number_format($ingredient->current_price, 2) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="badge bg-blue-100 text-blue-700">
                                        {{ $ingredient->quantity_per_unit }} {{ $ingredient->unit->abbreviation }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="badge bg-orange-100 text-orange-700">
                                        {{ $ingredient->wastage_percentage }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-700">
                                        {{ $ingredient->supplier ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('restaurants.ingredients.edit', [$restaurant, $ingredient]) }}" 
                                           class="w-9 h-9 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors flex items-center justify-center">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('restaurants.ingredients.destroy', [$restaurant, $ingredient]) }}" 
                                            method="POST" onsubmit="return confirm('Delete this ingredient?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-9 h-9 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors flex items-center justify-center">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $ingredients->links() }}
        </div>
    @endif
</div>
@endsection