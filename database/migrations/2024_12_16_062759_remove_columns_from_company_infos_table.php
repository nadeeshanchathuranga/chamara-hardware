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
        Schema::table('company_infos', function (Blueprint $table) {

            $table->dropColumn(['registration_no', 'established_date', 'description']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_infos', function (Blueprint $table) {
            // Add back the columns in case of rollback
            $table->string('registration_no')->nullable();
            $table->date('established_date')->nullable();
            $table->text('description')->nullable();
        });
    }
};
