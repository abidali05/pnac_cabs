<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certification_body_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certification_general_id')->constrained('certification_generals')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('staff_type');
            $table->string('name')->nullable();
            $table->text('qualifications')->nullable();
            $table->text('relevant_experience')->nullable();
            $table->string('auditing_field')->nullable();
            $table->text('audit_experience')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certification_body_staff');
    }
};

