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
        Schema::create('certification_generals', function (Blueprint $table) {
            $table->id();
            $table->string('scheme');
            $table->string('cab_name');
            $table->string('address');
            $table->string('telephone');
            $table->string('email');
            $table->string('ntn_ftn');
            $table->string('website');
            $table->string('city');
            $table->string('country');
            $table->string('postal_code');
            $table->text('category')->nullable();
            $table->string('assigned_role')->nullable();
            $table->string('status')->default('Pending')->comment('Pending', 'Approved', 'Not Approved');
            $table->string('accreditation_status')->default('Not Accredited')->comment('Accredited', 'Not Accredited');
            $table->string('reference_no')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certification_generals');
    }
};
