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
            // $table->text('scop_technical_a')->nullable();
            // $table->text('scop_iaf_a')->nullable();
            // $table->text('scop_economic_a')->nullable();

            // // ISO 14001
            // $table->text('scop_technical_b')->nullable();
            // $table->text('scop_iaf_b')->nullable();
            // $table->text('scop_economic_b')->nullable();

            // // ISO 45001
            // $table->text('scop_technical_c')->nullable();
            // $table->text('scop_iaf_c')->nullable();
            // $table->text('scop_economic_c')->nullable();

            $table->unsignedBigInteger('technical_cluster_id');
            $table->string('iaf_code')->nullable();
            $table->text('description')->nullable();

            // ISO 13485
            $table->string('main_technical_id')->nullable();
            $table->string('technical_area')->nullable();
            $table->string('description')->nullable();

            // ISO 22000
            // $table->string('scop_cluster')->nullable();
            // $table->string('scop_category')->nullable();
            // $table->string('scop_subcategory')->nullable();
            // $table->string('scop_activity')->nullable();
            // $table->text('category')->nullable();
            // $table->string('scope_type')->nullable();
            $table->string('cluster_id')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('description')->nullable();

            $table->text('category')->nullable();
            $table->string('scope_type')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('certification_general_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('certification_general_id')->references('id')->on('certification_generals')->onDelete('cascade');
            $table->foreign('technical_cluster_id')->references('id')->on('technical_clusters')->onDelete('cascade');
            $table->foreign('main_technical_id')->references('id')->on('main_technical13485s')->onDelete('cascade');
            $table->foreign('cluster_id')->references('id')->on('cluster22000s')->onDelete('cascade');
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
