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
            $table->decimal('discount', 5, 2)->default(0)->after('selling_price')->comment('Discount percentage for the product');
            $table->decimal('discounted_price', 10, 2)->nullable()->after('discount')->comment('Final price after applying discount');
            $table->string('code', 50)->after('name')->comment('Unique code for the product')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'discount')) {
                $table->dropColumn('discount');
            }
            if (Schema::hasColumn('products', 'discounted_price')) {
                $table->dropColumn('discounted_price');
            }
            if (Schema::hasColumn('products', 'code')) {
                $table->dropColumn('code');
            }
        });
    }
};
