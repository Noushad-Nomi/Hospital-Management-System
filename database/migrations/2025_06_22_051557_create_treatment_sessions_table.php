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
        Schema::create('treatment_sessions', function (Blueprint $table) {
             $table->id();
        $table->unsignedBigInteger('checkup_id');
        $table->unsignedBigInteger('doctor_id');
      
        $table->decimal('session_fee', 8, 2);
        $table->enum('status', ['scheduled', 'completed', 'missed'])->default('scheduled');
        $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
        $table->timestamps();

        $table->foreign('checkup_id')->references('id')->on('checkups')->onDelete('cascade');
        $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatment_sessions');
    }
};
