<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

// Root route - redirect to dashboard or login
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('restaurants.index');
    }
    return redirect()->route('login');
});

// Dashboard - redirect to restaurants
Route::get('/dashboard', function () {
    return redirect()->route('restaurants.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Restaurant routes
    Route::resource('restaurants', RestaurantController::class);

    // Nested routes for restaurant resources
    Route::prefix('restaurants/{restaurant}')->group(function () {
        // Recipes
        Route::resource('recipes', RecipeController::class)
            ->names([
                'index' => 'restaurants.recipes.index',
                'create' => 'restaurants.recipes.create',
                'store' => 'restaurants.recipes.store',
                'show' => 'restaurants.recipes.show',
                'edit' => 'restaurants.recipes.edit',
                'update' => 'restaurants.recipes.update',
                'destroy' => 'restaurants.recipes.destroy',
            ]);

        Route::post('recipes/{recipe}/recalculate', [RecipeController::class, 'recalculateCost'])
            ->name('restaurants.recipes.recalculate');

        // Ingredients
        Route::resource('ingredients', IngredientController::class)
            ->except(['show'])
            ->names([
                'index' => 'restaurants.ingredients.index',
                'create' => 'restaurants.ingredients.create',
                'store' => 'restaurants.ingredients.store',
                'edit' => 'restaurants.ingredients.edit',
                'update' => 'restaurants.ingredients.update',
                'destroy' => 'restaurants.ingredients.destroy',
            ]);

        // Categories
        Route::resource('categories', CategoryController::class)
            ->except(['show'])
            ->names([
                'index' => 'restaurants.categories.index',
                'create' => 'restaurants.categories.create',
                'store' => 'restaurants.categories.store',
                'edit' => 'restaurants.categories.edit',
                'update' => 'restaurants.categories.update',
                'destroy' => 'restaurants.categories.destroy',
            ]);

        // Suppliers
        Route::resource('suppliers', SupplierController::class)
            ->except(['show'])
            ->names([
                'index' => 'restaurants.suppliers.index',
                'create' => 'restaurants.suppliers.create',
                'store' => 'restaurants.suppliers.store',
                'edit' => 'restaurants.suppliers.edit',
                'update' => 'restaurants.suppliers.update',
                'destroy' => 'restaurants.suppliers.destroy',
            ]);

        // Attach ingredient to supplier pivot
        Route::post('suppliers/{supplier}/attach-ingredient', [SupplierController::class, 'attachIngredient'])
            ->name('restaurants.suppliers.attachIngredient');
    });
});

require __DIR__.'/auth.php';
