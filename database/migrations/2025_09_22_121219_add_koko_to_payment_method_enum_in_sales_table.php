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
        Schema::table('sales', function (Blueprint $table) {
            // Drop the existing enum column
            $table->dropColumn('payment_method');
        });

        Schema::table('sales', function (Blueprint $table) {
            // Recreate the enum column with the new value
            $table->enum('payment_method', ['Cash', 'Card', 'Online', 'Koko'])->after('total_cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // Drop the modified enum column
            $table->dropColumn('payment_method');
        });

        Schema::table('sales', function (Blueprint $table) {
            // Restore the original enum column
            $table->enum('payment_method', ['Cash', 'Card', 'Online'])->after('total_cost');
        });
    }
};
