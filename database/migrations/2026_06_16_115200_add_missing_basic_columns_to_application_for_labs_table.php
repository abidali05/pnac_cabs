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
        Schema::table('application_for_labs', function (Blueprint $table) {
            $columns = [
                'organisation' => 'string',
                'cab_name' => 'string',
                'address_laboratory' => 'string',
                'postcode' => 'string',
                'tel' => 'string',
                'fax' => 'string',
                'ntn_ftn' => 'string',
                'website' => 'string',
                'city' => 'string',
                'country' => 'string',
                'contact_name' => 'string',
                'designation' => 'string',
                'person_address' => 'string',
                'person_postcode' => 'string',
                'person_tel' => 'string',
                'person_fax' => 'string',
                'person_email' => 'string',
                'chack_calibration' => 'string',
                'chack_laboratory' => 'string',
                'chack_extension' => 'string',
                'chack_permanent' => 'string',
                'chack_mobile' => 'string',
                'chack_renewal' => 'string',
                'chack_quality' => 'string',
                'chack_participation' => 'string',
                'chack_plan' => 'string',
                'chack_agreement' => 'string',
                'chack_filled' => 'string',
                'chack_staff' => 'string',
                'chack_applicant' => 'string',
            ];

            foreach ($columns as $name => $type) {
                if (!Schema::hasColumn('application_for_labs', $name)) {
                    $table->{$type}($name)->nullable();
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_for_labs', function (Blueprint $table) {
            //
        });
    }
};
