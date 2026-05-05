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
        Schema::create('personnel_scopes', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->string('scope_type')->nullable();
            $table->string('technical_cluster')->nullable();
            $table->string('iaf_code')->nullable();
            $table->string('description_iaf')->nullable();
            $table->string('main_technical')->nullable();
            $table->string('technical_area')->nullable();
            $table->string('product_category')->nullable();

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
        Schema::dropIfExists('personnel_scopes');
    }
};
