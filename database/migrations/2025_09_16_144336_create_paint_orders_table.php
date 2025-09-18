// database/migrations/xxxx_xx_xx_xxxxxx_create_paint_orders_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('paint_orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('paint_product_id')
                ->constrained('paint_products')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('color_card_id')
                ->constrained('color_cards')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('base_type_id')
                ->constrained('base_types')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('can_size', 10);

            // NEW: order quantity
            $table->unsignedInteger('quantity')->default(1);

            $table->decimal('unit_price', 10, 2)->default(0);
            $table->enum('status', ['pending','completed'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paint_orders');
    }
};
