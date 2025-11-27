@extends('layouts.app')

@section('title', 'Create Recipe')

@section('content')
<div class="animate-fade-in">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('restaurants.recipes.index', $restaurant) }}" class="text-purple-600 hover:text-purple-800 transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Recipes
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center">
                <i class="fas fa-plus-circle text-purple-600 mr-3"></i>
                Create New Recipe
            </h1>
            <p class="text-gray-600">Add a new recipe to {{ $restaurant->name }}</p>
        </div>
        
        <form action="{{ route('restaurants.recipes.store', $restaurant) }}" method="POST" id="recipeForm">
            @csrf
            
            <!-- Basic Information Section -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    Basic Information
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Recipe Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Category</label>
                        <select name="category_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Recipe Details Section -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-list text-green-600 mr-2"></i>
                    Recipe Details
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-users text-blue-500 mr-1"></i>
                            Serving Size *
                        </label>
                        <input type="number" name="serving_size" value="{{ old('serving_size', 1) }}" required min="1"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-clock text-green-500 mr-1"></i>
                            Prep Time (min)
                        </label>
                        <input type="number" name="prep_time" value="{{ old('prep_time') }}" min="0"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-fire text-red-500 mr-1"></i>
                            Cook Time (min)
                        </label>
                        <input type="number" name="cook_time" value="{{ old('cook_time') }}" min="0"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                        placeholder="Brief description of your recipe...">{{ old('description') }}</textarea>
                </div>
            </div>
            
            <!-- Ingredients Section -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-carrot text-orange-600 mr-2"></i>
                        Ingredients *
                    </h3>
                    <button type="button" onclick="addIngredient()" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors shadow-md flex items-center space-x-2">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add Ingredient</span>
                    </button>
                </div>
                
                <div id="ingredientsList" class="space-y-3">
                    <!-- Ingredients will be added here -->
                </div>
            </div>
            
            <!-- Instructions Section -->
            <div class="mb-8">
                <label class="block text-gray-700 font-semibold mb-2 flex items-center">
                    <i class="fas fa-list-ol text-purple-600 mr-2"></i>
                    Cooking Instructions
                </label>
                <textarea name="instructions" id="instructions" rows="8"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">{{ old('instructions') }}</textarea>
                <p class="text-sm text-gray-500 mt-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    Use the editor toolbar to format your instructions with lists, bold text, etc.
                </p>
            </div>
            
            <!-- Submit Buttons -->
            <div class="flex space-x-4 pt-6 border-t">
                <button type="submit" class="flex-1 btn-primary text-white px-8 py-4 rounded-lg shadow-lg flex items-center justify-center space-x-2 text-lg font-semibold">
                    <i class="fas fa-save"></i>
                    <span>Create Recipe</span>
                </button>
                <a href="{{ route('restaurants.recipes.index', $restaurant) }}" class="px-8 py-4 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors flex items-center justify-center space-x-2 text-lg font-semibold">
                    <i class="fas fa-times"></i>
                    <span>Cancel</span>
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let ingredientCount = 0;
const ingredients = @json($ingredients);
const units = @json($units);

// Initialize CKEditor
ClassicEditor
    .create(document.querySelector('#instructions'), {
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'underline', '|',
                'bulletedList', 'numberedList', '|',
                'outdent', 'indent', '|',
                'link', '|',
                'undo', 'redo'
            ]
        },
        placeholder: 'Enter cooking instructions step by step...',
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading3', view: 'h3', title: 'Heading', class: 'ck-heading_heading3' }
            ]
        }
    })
    .catch(error => {
        console.error(error);
    });

function addIngredient() {
    const container = document.getElementById('ingredientsList');
    const div = document.createElement('div');
    div.className = 'flex gap-3 items-start bg-gradient-to-r from-purple-50 to-pink-50 p-4 rounded-lg border border-purple-200';
    div.id = `ingredient-${ingredientCount}`;
    
    div.innerHTML = `
        <div class="flex-1">
            <label class="text-xs text-gray-600 mb-1 block">Ingredient</label>
            <select name="ingredients[${ingredientCount}][ingredient_id]" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                <option value="">Select Ingredient</option>
                ${ingredients.map(ing => `<option value="${ing.id}">${ing.name} (${ing.unit.abbreviation})</option>`).join('')}
            </select>
        </div>
        <div class="w-32">
            <label class="text-xs text-gray-600 mb-1 block">Quantity</label>
            <input type="number" name="ingredients[${ingredientCount}][quantity]" 
                placeholder="0.00" required step="0.01" min="0"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
        </div>
        <div class="w-32">
            <label class="text-xs text-gray-600 mb-1 block">Unit</label>
            <select name="ingredients[${ingredientCount}][unit_id]" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                ${units.map(unit => `<option value="${unit.id}">${unit.abbreviation}</option>`).join('')}
            </select>
        </div>
        <div class="pt-5">
            <button type="button" onclick="removeIngredient(${ingredientCount})"
                class="w-10 h-10 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors shadow-md">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    
    container.appendChild(div);
    ingredientCount++;
}

function removeIngredient(id) {
    document.getElementById(`ingredient-${id}`).remove();
}

// Add first ingredient on load
addIngredient();
</script>
@endpush
@endsection