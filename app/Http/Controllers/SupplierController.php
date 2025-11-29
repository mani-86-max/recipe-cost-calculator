<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Restaurant;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SupplierController extends Controller
{   
    use AuthorizesRequests;

    public function index(Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);

        // Load suppliers
        $suppliers = $restaurant->suppliers()->paginate(20);

        // Manual ingredient count based on ingredients.supplier TEXT
        foreach ($suppliers as $supplier) {
            $supplier->ingredients_count = Ingredient::where('restaurant_id', $restaurant->id)
                ->where('supplier', $supplier->company_name)
                ->count();
        }

        return view('suppliers.index', compact('restaurant', 'suppliers'));
    }

    public function create(Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);
        return view('suppliers.create', compact('restaurant'));
    }

    public function store(Request $request, Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'company_name' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $restaurant->suppliers()->create($validated);

        return redirect()->route('restaurants.suppliers.index', $restaurant)
            ->with('success', 'Supplier created successfully!');
    }

    public function edit(Restaurant $restaurant, Supplier $supplier)
    {
        $this->authorize('view', $restaurant);
        return view('suppliers.edit', compact('restaurant', 'supplier'));
    }

    public function update(Request $request, Restaurant $restaurant, Supplier $supplier)
    {
        $this->authorize('view', $restaurant);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'company_name' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $supplier->update($validated);

        return redirect()->route('restaurants.suppliers.index', $restaurant)
            ->with('success', 'Supplier updated successfully!');
    }

    public function destroy(Restaurant $restaurant, Supplier $supplier)
    {
        $this->authorize('view', $restaurant);
        $supplier->delete();

        return redirect()->route('restaurants.suppliers.index', $restaurant)
            ->with('success', 'Supplier deleted successfully!');
    }
}
