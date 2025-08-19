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
      Schema::table('patients', function (Blueprint $table) {
            $table->string('guardian_name')->after('name');
            $table->integer('age')->nullable()->after('guardian_name');
            $table->dropColumn('medical_history');
              });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('guardian_name');
            $table->dropColumn('age');
            $table->text('medical_history')->nullable();
        });
    }
};
