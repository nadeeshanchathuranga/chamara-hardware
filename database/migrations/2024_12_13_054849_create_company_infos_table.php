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
        Schema::create('company_infos', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('name', 255); // Company name
            $table->text('address')->nullable(); // Company address
            $table->string('phone', 20)->nullable(); // Phone number
            $table->string('email', 255)->nullable(); // Email address
            $table->string('website', 255)->nullable(); // Website URL
            $table->string('registration_no', 50)->nullable(); // Registration number
            $table->string('logo', 255)->nullable(); // Path to logo
            $table->date('established_date')->nullable(); // Date of establishment
            $table->text('description')->nullable(); // Company description
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_infos');
    }
};
