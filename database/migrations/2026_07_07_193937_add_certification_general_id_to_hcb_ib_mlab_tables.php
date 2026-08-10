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
        Schema::table('hcb_applications', function (Blueprint $table) {
            $table->foreignId('certification_general_id')->nullable()->constrained('certification_generals')->nullOnDelete();
        });

        Schema::table('inspection_body_applications', function (Blueprint $table) {
            $table->foreignId('certification_general_id')->nullable()->constrained('certification_generals')->nullOnDelete();
        });

        Schema::table('mlab_applications', function (Blueprint $table) {
            $table->foreignId('certification_general_id')->nullable()->constrained('certification_generals')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mlab_applications', function (Blueprint $table) {
            $table->dropForeign(['certification_general_id']);
            $table->dropColumn('certification_general_id');
        });

        Schema::table('inspection_body_applications', function (Blueprint $table) {
            $table->dropForeign(['certification_general_id']);
            $table->dropColumn('certification_general_id');
        });

        Schema::table('hcb_applications', function (Blueprint $table) {
            $table->dropForeign(['certification_general_id']);
            $table->dropColumn('certification_general_id');
        });
    }
};
