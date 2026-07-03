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
        Schema::create('pcb_scope_of_certification', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('application_for_labs')->cascadeOnDelete();
            $table->text('product')->nullable();
            $table->text('standard')->nullable();
            $table->text('countries')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pcb_scope_of_certification');
    }
};
