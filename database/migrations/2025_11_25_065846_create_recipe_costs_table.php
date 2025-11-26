<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recipe_costs', function (Blueprint $table) {
            $table->id();
             $table->foreignId('recipe_id')->constrained()->onDelete('cascade');
            $table->decimal('ingredient_cost', 10, 2);
            $table->decimal('overhead_cost', 10, 2);
            $table->decimal('total_cost', 10, 2);
            $table->decimal('suggested_price', 10, 2);
            $table->decimal('profit_margin', 5, 2);
            $table->timestamp('calculated_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_costs');
    }
};
