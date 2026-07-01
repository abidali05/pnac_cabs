<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function run(): void
    {
        Schema::create('application_forms', function (Blueprint $table) {
            $table->id();
            $table->string('application_name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('status')->default(1);
            $table->json('form_schema');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_forms');
    }
};
