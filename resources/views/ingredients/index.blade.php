@extends('layouts.app')

@section('title', 'Ingredients')

@section('content')
<div class="mb-6">
    <a href="{{ route('restaurants.show', $restaurant) }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left"></i> Back to Restaurant
    </a>
</div>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Ingredients</h1>
    <a href="{{ route('restaurants.ingredients.create', $restaurant) }}" 
        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
        <i class="fas fa-plus"></i> New Ingredient
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Wastage</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Supplier</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($ingredients as $ingredient)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $ingredient->name }}</div>
                        <div class="text-sm text-gray-500">Updated {{ $ingredient->last_price_update?->format('M d, Y') }}</div>
                    </td>
                    <td class="px-6 py-4 text-gray-900">
                        ${{ number_format($ingredient->current_price, 2) }}
                    </td>
                    <td class="px-6 py-4 text-gray-900">
                        {{ $ingredient->quantity_per_unit }} {{ $ingredient->unit->abbreviation }}
                    </td>
                    <td class="px-6 py-4 text-gray-900">
                        {{ $ingredient->wastage_percentage }}%
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $ingredient->supplier ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('restaurants.ingredients.edit', [$restaurant, $ingredient]) }}" 
                                class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit"></i>
                                </a>
                        <form action="{{ route('restaurants.ingredients.destroy', [$restaurant, $ingredient]) }}" 
                            method="POST" onsubmit="return confirm('Delete this ingredient?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                    No ingredients yet. <a href="{{ route('restaurants.ingredients.create', $restaurant) }}" 
                        class="text-blue-600 hover:underline">Add your first ingredient</a>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>
<div class="mt-6">
    {{ $ingredients->links() }}
</div>
@endsection