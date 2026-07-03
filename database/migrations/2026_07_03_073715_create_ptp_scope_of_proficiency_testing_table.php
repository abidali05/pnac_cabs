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
        Schema::create('ptp_scope_of_proficiency_testing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('application_for_labs')->cascadeOnDelete();
            $table->text('item_material_matrix_product')->nullable();
            $table->text('scheme_test_properties')->nullable();
            $table->text('protocol_procedure_technique')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ptp_scope_of_proficiency_testing');
    }
};
