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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->string('job_name');
            $table->string('company_name');
            $table->text('description')->nullable();
            $table->date('date_from');
            $table->date('date_to');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate() ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
