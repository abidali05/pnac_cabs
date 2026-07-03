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
        Schema::create('personnel_certification_scopes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('application_for_labs')->cascadeOnDelete();
            $table->string('technical_cluster')->nullable();
            $table->text('description_iaf')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnel_certification_scopes');
    }
};
