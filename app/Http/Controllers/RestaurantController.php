<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RestaurantController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $restaurants = auth()->user()->restaurants()->with('recipes')->get();
        return view('restaurants.index', compact('restaurants'));
    }

    public function create()
    {
        return view('restaurants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'overhead_percentage' => 'nullable|numeric|min:0|max:100',
            'default_profit_margin' => 'nullable|numeric|min:0|max:100',
        ]);

        $restaurant = auth()->user()->restaurants()->create($validated);

        return redirect()->route('restaurants.show', $restaurant)
            ->with('success', 'Restaurant created successfully!');
    }

    public function show(Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);
        $restaurant->load(['recipes.latestCost', 'categories', 'suppliers']);
        
        return view('restaurants.show', compact('restaurant'));
    }

    public function edit(Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);
        return view('restaurants.edit', compact('restaurant'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'overhead_percentage' => 'nullable|numeric|min:0|max:100',
            'default_profit_margin' => 'nullable|numeric|min:0|max:100',
        ]);

        $restaurant->update($validated);

        return redirect()->route('restaurants.show', $restaurant)
            ->with('success', 'Restaurant updated successfully!');
    }

    public function destroy(Restaurant $restaurant)
    {
        $this->authorize('delete', $restaurant);
        $restaurant->delete();

        return redirect()->route('restaurants.index')
            ->with('success', 'Restaurant deleted successfully!');
    }
}
