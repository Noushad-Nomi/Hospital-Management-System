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
        Schema::table('treatment_sessions', function (Blueprint $table) {
            // Change ENUM → String (varchar)
            $table->string('status')->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('treatment_sessions', function (Blueprint $table) {
            // Agar rollback karein to wapis enum bana de
            $table->enum('status', ['pending','completed'])->default('pending')->change();
        });
    }
};
