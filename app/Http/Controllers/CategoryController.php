<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class CategoryController extends Controller
{    use AuthorizesRequests;
    public function index(Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);
        $categories = $restaurant->categories()->withCount('recipes')->get();
        
        return view('categories.index', compact('restaurant', 'categories'));
    }

    public function create(Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);
        return view('categories.create', compact('restaurant'));
    }

    public function store(Request $request, Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $restaurant->categories()->create($validated);

        return redirect()->route('restaurants.categories.index', $restaurant)
            ->with('success', 'Category created successfully!');
    }

    public function edit(Restaurant $restaurant, Category $category)
    {
        $this->authorize('view', $restaurant);
        return view('categories.edit', compact('restaurant', 'category'));
    }

    public function update(Request $request, Restaurant $restaurant, Category $category)
    {
        $this->authorize('view', $restaurant);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()->route('restaurants.categories.index', $restaurant)
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Restaurant $restaurant, Category $category)
    {
        $this->authorize('view', $restaurant);
        $category->delete();

        return redirect()->route('restaurants.categories.index', $restaurant)
            ->with('success', 'Category deleted successfully!');
    }
}