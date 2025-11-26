@extends('layouts.app')

@section('title', 'Edit Recipe')

@section('content')
<div class="mb-6">
    <a href="{{ route('restaurants.recipes.show', [$restaurant, $recipe]) }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left"></i> Back to Recipe
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Recipe</h1>
    
    <form action="{{ route('restaurants.recipes.update', [$restaurant, $recipe]) }}" method="POST" id="recipeForm">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Recipe Name *</label>
                <input type="text" name="name" value="{{ old('name', $recipe->name) }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Category</label>
                <select name="category_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $recipe->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Serving Size *</label>
                <input type="number" name="serving_size" value="{{ old('serving_size', $recipe->serving_size) }}" required min="1"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Prep Time (min)</label>
                <input type="number" name="prep_time" value="{{ old('prep_time', $recipe->prep_time) }}" min="0"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Cook Time (min)</label>
                <input type="number" name="cook_time" value="{{ old('cook_time', $recipe->cook_time) }}" min="0"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" rows="3"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('description', $recipe->description) }}</textarea>
        </div>
        
        <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
                <label class="block text-gray-700 font-semibold">Ingredients *</label>
                <button type="button" onclick="addIngredient()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    <i class="fas fa-plus"></i> Add Ingredient
                </button>
            </div>
            
            <div id="ingredientsList" class="space-y-3">
                <!-- Existing ingredients will be loaded here -->
            </div>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Instructions</label>
            <textarea name="instructions" rows="6"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('instructions', $recipe->instructions) }}</textarea>
        </div>
        
        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-save"></i> Update Recipe
            </button>
            <a href="{{ route('restaurants.recipes.show', [$restaurant, $recipe]) }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                Cancel
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
let ingredientCount = 0;
const ingredients = @json($ingredients);
const units = @json($units);
const existingIngredients = @json($recipe->recipeIngredients);

function addIngredient(existingData = null) {
    const container = document.getElementById('ingredientsList');
    const div = document.createElement('div');
    div.className = 'flex gap-3 items-start bg-gray-50 p-3 rounded';
    div.id = `ingredient-${ingredientCount}`;
    
    const selectedIngredient = existingData?.ingredient_id || '';
    const quantity = existingData?.quantity || '';
    const selectedUnit = existingData?.unit_id || '';
    
    div.innerHTML = `
        <div class="flex-1">
            <select name="ingredients[${ingredientCount}][ingredient_id]" required
                class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-blue-500">
                <option value="">Select Ingredient</option>
                ${ingredients.map(ing => `<option value="${ing.id}" ${ing.id == selectedIngredient ? 'selected' : ''}>${ing.name} (${ing.unit.abbreviation})</option>`).join('')}
            </select>
        </div>
        <div class="w-32">
            <input type="number" name="ingredients[${ingredientCount}][quantity]" 
                placeholder="Quantity" required step="0.01" min="0" value="${quantity}"
                class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="w-32">
            <select name="ingredients[${ingredientCount}][unit_id]" required
                class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-blue-500">
                ${units.map(unit => `<option value="${unit.id}" ${unit.id == selectedUnit ? 'selected' : ''}>${unit.abbreviation}</option>`).join('')}
            </select>
        </div>
        <button type="button" onclick="removeIngredient(${ingredientCount})"
            class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600">
            <i class="fas fa-trash"></i>
        </button>
    `;
    
    container.appendChild(div);
    ingredientCount++;
}

function removeIngredient(id) {
    document.getElementById(`ingredient-${id}`).remove();
}

// Load existing ingredients
existingIngredients.forEach(ing => {
    addIngredient(ing);
});

// If no ingredients, add one empty row
if (existingIngredients.length === 0) {
    addIngredient();
}
</script>
@endpush
@endsection