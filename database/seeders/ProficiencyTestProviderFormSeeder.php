<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicationForm;

class ProficiencyTestProviderFormSeeder extends Seeder
{
    public function run(): void
    {
        $json = json_decode(
            file_get_contents(database_path('json/proficiency_test_provider.json')),
            true
        );

        ApplicationForm::updateOrCreate(
            ['slug' => 'proficiency-testing-provider'],
            [
                'application_name' => 'Proficiency Testing Provider',
                'description'      => 'Proficiency Testing Provider Application',
                'status'           => 1,
                'form_schema'      => $json,
            ]
        );
    }
}
