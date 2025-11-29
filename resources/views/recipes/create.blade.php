@extends('layouts.app')

@section('title', 'Create Recipe')

@section('content')
<div class="animate-fade-in">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('restaurants.recipes.index', $restaurant) }}" class="text-purple-600 hover:text-purple-800 flex items-center transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Recipes
        </a>
    </div>

    <!-- Recipe Form Card -->
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-plus-circle text-purple-600 mr-3"></i>
            Create New Recipe
        </h1>

        <form action="{{ route('restaurants.recipes.store', $restaurant) }}" method="POST" id="recipeForm">
            @csrf

            <!-- Basic Information -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    Basic Information
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-1 font-medium">Recipe Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Category</label>
                        <select name="category_id" class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id')==$category->id?'selected':'' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Recipe Details -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4 flex items-center">
                    <i class="fas fa-list text-green-600 mr-2"></i>
                    Recipe Details
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block mb-1 font-medium">Serving Size *</label>
                        <input type="number" name="serving_size" value="{{ old('serving_size',1) }}" min="1" required
                               class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Prep Time (min)</label>
                        <input type="number" name="prep_time" value="{{ old('prep_time',0) }}" min="0"
                               class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Cook Time (min)</label>
                        <input type="number" name="cook_time" value="{{ old('cook_time',0) }}" min="0"
                               class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block mb-1 font-medium">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Ingredients Section -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold flex items-center">
                        <i class="fas fa-carrot text-orange-600 mr-2"></i>
                        Ingredients *
                    </h2>
                    <button type="button" onclick="addIngredient()" class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition flex items-center space-x-2">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add Ingredient</span>
                    </button>
                </div>
                <div id="ingredientsList" class="space-y-3">
                    <!-- Ingredients will be added here -->
                </div>
            </div>

            <!-- Cooking Instructions -->
            <div class="mb-8">
                <label class="block mb-1 font-medium flex items-center">
                    <i class="fas fa-list-ol text-purple-600 mr-2"></i>
                    Cooking Instructions
                </label>
                <textarea name="instructions" id="instructions" rows="8" class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">{{ old('instructions') }}</textarea>
            </div>

            <!-- Submit -->
            <div class="flex flex-col md:flex-row gap-4 pt-4 border-t">
                <button type="submit" class="flex-1 bg-purple-600 text-white px-6 py-3 rounded-xl shadow-lg hover:bg-purple-700 transition flex items-center justify-center space-x-2">
                    <i class="fas fa-save"></i>
                    <span>Create Recipe</span>
                </button>
                <a href="{{ route('restaurants.recipes.index', $restaurant) }}" class="flex-1 bg-gray-200 px-6 py-3 rounded-xl shadow hover:bg-gray-300 text-center flex items-center justify-center space-x-2">
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
ClassicEditor.create(document.querySelector('#instructions')).catch(err => console.error(err));

function addIngredient() {
    const container = document.getElementById('ingredientsList');
    const div = document.createElement('div');
    div.className = 'flex flex-wrap md:flex-nowrap gap-3 items-end bg-gradient-to-r from-purple-50 to-pink-50 p-4 rounded-xl border border-purple-200 shadow-sm';
    div.id = `ingredient-${ingredientCount}`;

    div.innerHTML = `
        <div class="flex-1">
            <label class="text-xs mb-1 block">Ingredient</label>
            <select name="ingredients[${ingredientCount}][ingredient_id]" required class="w-full px-3 py-2 border rounded-xl focus:ring-2 focus:ring-purple-500">
                <option value="">Select Ingredient</option>
                ${ingredients.map(i => `<option value="${i.id}">${i.name} (${i.unit.abbreviation})</option>`).join('')}
            </select>
        </div>
        <div class="w-32">
            <label class="text-xs mb-1 block">Quantity</label>
            <input type="number" name="ingredients[${ingredientCount}][quantity]" step="0.01" min="0" required class="w-full px-3 py-2 border rounded-xl focus:ring-2 focus:ring-purple-500">
        </div>
        <div class="w-32">
            <label class="text-xs mb-1 block">Unit</label>
            <select name="ingredients[${ingredientCount}][unit_id]" required class="w-full px-3 py-2 border rounded-xl focus:ring-2 focus:ring-purple-500">
                ${units.map(u => `<option value="${u.id}">${u.abbreviation}</option>`).join('')}
            </select>
        </div>
        <div class="pt-5">
            <button type="button" onclick="removeIngredient(${ingredientCount})" class="w-10 h-10 bg-red-500 text-white rounded-xl hover:bg-red-600 flex items-center justify-center shadow">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;

    container.appendChild(div);
    ingredientCount++;
}

function removeIngredient(id) {
    const elem = document.getElementById(`ingredient-${id}`);
    if(elem) elem.remove();
}

// Add first ingredient on load
addIngredient();
</script>
@endpush
@endsection
