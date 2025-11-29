@extends('layouts.app')

@section('title', 'Edit Recipe')

@section('content')
<div class="animate-fade-in">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('restaurants.recipes.index', $restaurant) }}" class="text-purple-600 hover:text-purple-800 transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Recipes
        </a>
    </div>

    <!-- Edit Recipe Form -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-edit text-blue-600 mr-3"></i>
            Edit Recipe
        </h1>

        <form action="{{ route('restaurants.recipes.update', [$restaurant, $recipe]) }}" method="POST" id="recipeForm">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-3">Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-1 font-medium">Recipe Name *</label>
                        <input type="text" name="name" value="{{ old('name', $recipe->name) }}" required
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Category</label>
                        <select name="category_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $recipe->category_id)==$category->id?'selected':'' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Recipe Details -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-3">Recipe Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block mb-1 font-medium">Servings *</label>
                        <input type="number" name="serving_size" value="{{ old('serving_size', $recipe->serving_size) }}" min="1" required
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Prep Time (min)</label>
                        <input type="number" name="prep_time" value="{{ old('prep_time', $recipe->prep_time) }}" min="0"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Cook Time (min)</label>
                        <input type="number" name="cook_time" value="{{ old('cook_time', $recipe->cook_time) }}" min="0"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block mb-1 font-medium">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500">{{ old('description', $recipe->description) }}</textarea>
                </div>
            </div>

            <!-- Ingredients -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-xl font-semibold">Ingredients</h2>
                    <button type="button" onclick="addIngredient()" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                        <i class="fas fa-plus"></i> Add Ingredient
                    </button>
                </div>
                <div id="ingredientsList" class="space-y-2">
                    @foreach(old('ingredients', $recipe->ingredients) as $i => $ingredient)
                        <div class="flex gap-3 items-end bg-gray-50 p-3 rounded border" id="ingredient-{{ $i }}">
                            <div class="flex-1">
                                <label class="text-xs mb-1 block">Ingredient</label>
                                <select name="ingredients[{{ $i }}][ingredient_id]" required class="w-full px-2 py-1 border rounded">
                                    <option value="">Select Ingredient</option>
                                    @foreach($ingredients as $ing)
                                        <option value="{{ $ing->id }}" {{ $ing->id == $ingredient->id ? 'selected' : '' }}>
                                            {{ $ing->name }} ({{ $ing->unit->abbreviation }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-24">
                                <label class="text-xs mb-1 block">Qty</label>
                                <input type="number" step="0.01" min="0" name="ingredients[{{ $i }}][quantity]" value="{{ old("ingredients.$i.quantity", $ingredient->pivot->quantity ?? $ingredient->quantity) }}" required class="w-full px-2 py-1 border rounded">
                            </div>
                            <div class="w-24">
                                <label class="text-xs mb-1 block">Unit</label>
                                <select name="ingredients[{{ $i }}][unit_id]" required class="w-full px-2 py-1 border rounded">
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" {{ $unit->id == ($ingredient->pivot->unit_id ?? $ingredient->unit_id) ? 'selected' : '' }}>
                                            {{ $unit->abbreviation }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button type="button" onclick="removeIngredient({{ $i }})" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Cooking Instructions -->
            <div class="mb-6">
                <label class="block mb-1 font-medium">Instructions</label>
                <textarea name="instructions" id="instructions" rows="8" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500">{{ old('instructions', $recipe->instructions) }}</textarea>
            </div>

            <!-- Submit -->
            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 flex-1">Update Recipe</button>
                <a href="{{ route('restaurants.recipes.index', $restaurant) }}" class="bg-gray-300 px-6 py-3 rounded flex-1 text-center hover:bg-gray-400">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let ingredientCount = {{ count(old('ingredients', $recipe->ingredients)) }};

// CKEditor
ClassicEditor.create(document.querySelector('#instructions')).catch(err => console.error(err));

// Ingredients
const ingredientsData = @json($ingredients);
const unitsData = @json($units);

function addIngredient() {
    const container = document.getElementById('ingredientsList');
    const div = document.createElement('div');
    div.className = 'flex gap-3 items-end bg-gray-50 p-3 rounded border';
    div.id = `ingredient-${ingredientCount}`;
    div.innerHTML = `
        <div class="flex-1">
            <label class="text-xs mb-1 block">Ingredient</label>
            <select name="ingredients[${ingredientCount}][ingredient_id]" required class="w-full px-2 py-1 border rounded">
                <option value="">Select Ingredient</option>
                ${ingredientsData.map(i => `<option value="${i.id}">${i.name} (${i.unit.abbreviation})</option>`).join('')}
            </select>
        </div>
        <div class="w-24">
            <label class="text-xs mb-1 block">Qty</label>
            <input type="number" name="ingredients[${ingredientCount}][quantity]" step="0.01" min="0" required class="w-full px-2 py-1 border rounded">
        </div>
        <div class="w-24">
            <label class="text-xs mb-1 block">Unit</label>
            <select name="ingredients[${ingredientCount}][unit_id]" required class="w-full px-2 py-1 border rounded">
                ${unitsData.map(u => `<option value="${u.id}">${u.abbreviation}</option>`).join('')}
            </select>
        </div>
        <div>
            <button type="button" onclick="removeIngredient(${ingredientCount})" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    ingredientCount++;
}

function removeIngredient(id) {
    const el = document.getElementById(`ingredient-${id}`);
    if(el) el.remove();
}
</script>
@endpush

@endsection
