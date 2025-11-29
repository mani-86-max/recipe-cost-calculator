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
        Schema::table('restaurants', function (Blueprint $table) {
            $table->decimal('hourly_labor_rate', 8, 2)->default(0)->after('default_profit_margin');
            $table->decimal('packaging_cost_per_item', 8, 2)->default(0)->after('hourly_labor_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         
            
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn(['hourly_labor_rate', 'packaging_cost_per_item']);
        });
    }
};
