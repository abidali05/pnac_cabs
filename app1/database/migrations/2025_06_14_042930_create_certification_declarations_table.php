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
        Schema::create('certification_declarations', function (Blueprint $table) {
            $table->id();
            $table->string('application_fee')->nullable();
            $table->string('testing_select')->nullable();
            $table->string('medical_select')->nullable();
            $table->string('halal_select')->nullable();
            $table->string('product_select')->nullable();
            $table->string('proficiency_select')->nullable();
            $table->string('inspection_select')->nullable();
            $table->string('category')->nullable();
            $table->string('status')->default('submited');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('certification_general_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('certification_general_id')->references('id')->on('certification_generals')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certification_declarations');
    }
};
