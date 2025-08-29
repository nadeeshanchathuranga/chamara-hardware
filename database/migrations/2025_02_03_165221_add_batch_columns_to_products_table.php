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
        Schema::table('products', function (Blueprint $table) {
            $table->string('batch_no')->nullable()->after('barcode'); 
            $table->integer('total_quantity')->default(0)->after('stock_quantity'); 
            $table->date('purchase_date')->nullable()->after('total_quantity'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['batch_no', 'total_quantity', 'purchase_date']);
        });
    }
};
