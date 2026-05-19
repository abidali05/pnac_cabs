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
        Schema::create('calibration_scopes', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->string('scope')->nullable();
            $table->string('type')->nullable();
            $table->string('measurement')->nullable();
            $table->string('range')->nullable();
            $table->string('expanded')->nullable();
            $table->string('technique')->nullable();

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
        Schema::dropIfExists('calibration_scopes');
    }
};
