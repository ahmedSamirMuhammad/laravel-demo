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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name'); 
            $table->string('title')->nullable() ;
            $table->string('logo')->nullable() ;
            $table->string('location')->nullable();
            $table->text('about')->nullable() ;
            $table->string('email')->unique();
            $table->string('company_name')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            $table->string('mobile_number')->nullable();
            $table->string('nationality')->nullable();
            $table->boolean('verified')->default(false);
          
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
