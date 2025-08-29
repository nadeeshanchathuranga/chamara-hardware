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
        Schema::table('stock_transactions', function (Blueprint $table) {
            $table->dropColumn('transaction_type'); // Drop the old enum column
        });

        Schema::table('stock_transactions', function (Blueprint $table) {
            $table->enum('transaction_type', ['Added', 'Deducted'])->after('product_id'); // Add the new enum column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_transactions', function (Blueprint $table) {
            // $table->dropColumn('transaction_type'); // Drop the updated column
        });

        // Schema::table('stock_transactions', function (Blueprint $table) {
        //     $table->enum('transaction_type', ['Purchase', 'Return', 'Adjustment'])->after('product_id'); // Revert to the old enum column
        // });
    }
};
