<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('base_stock_transactions', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('base_stock_id')
                ->constrained('base_stocks')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
                
            $table->foreignId('paint_order_id')
                ->nullable()
                ->constrained('paint_orders')
                ->cascadeOnUpdate()
                ->nullOnDelete();
                
            $table->enum('transaction_type', ['reduction', 'adjustment', 'addition']);
            $table->decimal('quantity_before', 10, 2);
            $table->decimal('quantity_after', 10, 2);
            $table->decimal('quantity_changed', 10, 2);
            $table->text('notes')->nullable();
            $table->string('performed_by')->nullable(); // user name or system
            
            $table->timestamps();
            
            $table->index(['base_stock_id', 'created_at']);
            $table->index(['paint_order_id']);
            $table->index(['transaction_type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('base_stock_transactions');
    }
};
