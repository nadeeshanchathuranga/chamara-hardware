<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('machine_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('colorance_stock_id')
                  ->constrained('colorance_stocks')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->unsignedInteger('units')->default(0);
            $table->timestamps();

       
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('machine_stocks');
    }
};
