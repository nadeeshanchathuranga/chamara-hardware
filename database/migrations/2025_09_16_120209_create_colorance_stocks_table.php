<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('colorance_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('can_size', 20)->comment('1L');
            $table->unsignedInteger('unit')->default(0)->comment('stock quantity');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('colorance_stocks');
    }
};
