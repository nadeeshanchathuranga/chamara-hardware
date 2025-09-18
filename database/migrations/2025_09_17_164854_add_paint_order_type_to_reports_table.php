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
        Schema::table('reports', function (Blueprint $table) {
            // Modify the enum to include 'Paint Orders'
            $table->enum('type', ['Daily Sales', 'Inventory', 'Customer', 'Paint Orders'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Revert back to original enum values
            $table->enum('type', ['Daily Sales', 'Inventory', 'Customer'])->change();
        });
    }
};
