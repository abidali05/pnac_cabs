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
        Schema::create('client_satisfications', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('organization')->nullable();
            $table->string('accredited')->nullable();

            $table->json('government_req')->nullable();
            $table->json('customer_demand')->nullable();

            $table->string('purpose')->nullable();
            $table->string('business_purpose')->nullable();
            $table->string('accredited_general')->nullable();
            $table->text('other_reason')->nullable();

            $table->string('reports')->nullable();
            $table->string('excepted')->nullable();
            $table->string('outcome')->nullable();
            $table->string('system_improved')->nullable();
            $table->string('clientage')->nullable();

            $table->text('government_regarding')->nullable();
            $table->text('suggestion')->nullable();

            $table->text('date')->nullable();
            $table->text('extended_scope')->nullable();
            $table->text('aproximately')->nullable();
            $table->json('scope_reason')->nullable();
            $table->text('suspended')->nullable();
            $table->text('performance')->nullable();
            $table->text('status_pnac')->nullable();
            $table->text('disciplines')->nullable();

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
        Schema::dropIfExists('client_satisfications');
    }
};
