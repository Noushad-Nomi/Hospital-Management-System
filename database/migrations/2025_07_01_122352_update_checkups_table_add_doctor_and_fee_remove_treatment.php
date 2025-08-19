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
        Schema::table('checkups', function (Blueprint $table) {
            $table->dropColumn('treatment'); // Remove old column
            $table->string('doctor')->nullable(); // Add doctor column
            $table->decimal('fee', 10, 2)->nullable(); // Add fee column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkups', function (Blueprint $table) {
            $table->string('treatment')->nullable(); // Re-add treatment
            $table->dropColumn('doctor'); // Remove doctor
            $table->dropColumn('fee'); // Remove fee
        });
    }
};
