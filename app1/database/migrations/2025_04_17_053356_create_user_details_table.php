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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('designation')->nullable();
            $table->string('home_address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('office_no')->nullable();
            $table->string('fax_no')->nullable();

            $table->string('full_name')->nullable();
            $table->string('relationship')->nullable();
            $table->string('e_address')->nullable();
            $table->string('e_number')->nullable();
            $table->string('e_office_no')->nullable();
            $table->string('e_fax_no')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
