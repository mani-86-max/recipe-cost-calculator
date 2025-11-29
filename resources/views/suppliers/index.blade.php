@extends('layouts.app')

@section('title', 'Suppliers')

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
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Suppliers</h1>
            <p class="text-gray-600">{{ $restaurant->name }}</p>
        </div>
        <a href="{{ route('restaurants.suppliers.create', $restaurant) }}" class="btn-primary text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2">
            <i class="fas fa-plus-circle"></i>
            <span>New Supplier</span>
        </a>
    </div>

    @if($suppliers->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
            <div class="inline-block p-6 bg-blue-100 rounded-full mb-6">
                <i class="fas fa-truck text-blue-600 text-6xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-3">No Suppliers Yet</h2>
            <p class="text-gray-600 mb-6 max-w-md mx-auto">
                Add suppliers to track ingredient sources and prices
            </p>
            <a href="{{ route('restaurants.suppliers.create', $restaurant) }}" class="inline-block btn-primary text-white px-8 py-3 rounded-lg shadow-lg">
                <i class="fas fa-plus-circle mr-2"></i>
                Add Your First Supplier
            </a>
        </div>
    @else
        <!-- Suppliers Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($suppliers as $supplier)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                    <!-- Supplier Header -->
                    <div class="h-32 bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-600 relative flex items-center justify-center">
                        <div class="text-white text-6xl">
                            <i class="fas fa-truck drop-shadow-lg"></i>
                        </div>
                        @if($supplier->is_active)
                            <div class="absolute top-4 right-4">
                                <span class="badge bg-green-500 text-white shadow-lg">
                                    <i class="fas fa-check-circle mr-1"></i>Active
                                </span>
                            </div>
                        @else
                            <div class="absolute top-4 right-4">
                                <span class="badge bg-gray-500 text-white shadow-lg">
                                    <i class="fas fa-pause-circle mr-1"></i>Inactive
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Supplier Body -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $supplier->name }}</h3>

                        @if($supplier->company_name)
                            <p class="text-sm text-gray-600 mb-2">
                                <i class="fas fa-building text-blue-500 mr-2"></i>{{ $supplier->company_name }}
                            </p>
                        @endif

                        @if($supplier->contact_person)
                            <p class="text-sm text-gray-600 mb-2">
                                <i class="fas fa-user text-green-500 mr-2"></i>{{ $supplier->contact_person }}
                            </p>
                        @endif

                        @if($supplier->phone)
                            <p class="text-sm text-gray-600 mb-2">
                                <i class="fas fa-phone text-purple-500 mr-2"></i>{{ $supplier->phone }}
                            </p>
                        @endif

                        @if($supplier->email)
                            <p class="text-sm text-gray-600 mb-4">
                                <i class="fas fa-envelope text-orange-500 mr-2"></i>{{ $supplier->email }}
                            </p>
                        @endif

                        <!-- Stats: Ingredients Supplied -->
                        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-3 mb-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">Ingredients Supplied</span>
                                <span class="text-2xl font-bold text-blue-600">{{ $supplier->ingredients_count }}</span>
                            </div>
                            @if($supplier->ingredients_count > 0)
                                <div class="text-xs text-gray-500 mt-1">
                                    @foreach($supplier->ingredients as $ingredient)
                                        {{ $ingredient->name }}@if(!$loop->last), @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('restaurants.suppliers.edit', [$restaurant, $supplier]) }}" 
                               class="flex-1 text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            <form action="{{ route('restaurants.suppliers.destroy', [$restaurant, $supplier]) }}" 
                                  method="POST" onsubmit="return confirm('Delete this supplier?')" class="flex-shrink-0 flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors font-semibold">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $suppliers->links() }}
        </div>
    @endif
</div>
@endsection
