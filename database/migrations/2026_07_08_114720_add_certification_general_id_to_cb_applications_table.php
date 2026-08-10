<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cb_applications', function (Blueprint $table) {
            $table->foreignId('certification_general_id')->nullable()->constrained('certification_generals')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cb_applications', function (Blueprint $table) {
            $table->dropForeign(['certification_general_id']);
            $table->dropColumn('certification_general_id');
        });
    }
};
