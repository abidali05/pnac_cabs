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
        Schema::create('certification_scopes', function (Blueprint $table) {
            $table->id();

            // Common Fields
            $table->unsignedBigInteger('technical_cluster_id')->nullable();
            $table->string('iaf_code')->nullable();
            $table->text('description')->nullable();

            // ISO 13485
            $table->unsignedBigInteger('main_technical_id')->nullable();
            $table->string('technical_area')->nullable();

            // ISO 22000
            $table->unsignedBigInteger('cluster_id')->nullable();
            $table->text('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('scope_type')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('certification_general_id')->nullable();

            // Foreign Keys
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('certification_general_id')
                ->references('id')
                ->on('certification_generals')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certification_scopes');
    }
};
