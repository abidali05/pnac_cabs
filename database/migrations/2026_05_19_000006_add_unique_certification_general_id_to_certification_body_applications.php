<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certification_body_applications', function (Blueprint $table) {
            $table->unique('certification_general_id', 'cba_certification_general_unique');
        });
    }

    public function down(): void
    {
        Schema::table('certification_body_applications', function (Blueprint $table) {
            $table->dropUnique('cba_certification_general_unique');
        });
    }
};

