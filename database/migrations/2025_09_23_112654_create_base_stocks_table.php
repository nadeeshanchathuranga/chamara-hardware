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
        Schema::create('base_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paint_product_id')->constrained('paint_products')->onDelete('cascade');
            $table->foreignId('base_type_id')->constrained('base_types')->onDelete('cascade');
            $table->enum('can_size', ['1L', '4L', '10L']);
            $table->decimal('quantity', 10, 2)->default(0);
            $table->timestamps();
            
            // Ensure unique combination
            $table->unique(['paint_product_id', 'base_type_id', 'can_size']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base_stocks');
    }
};
