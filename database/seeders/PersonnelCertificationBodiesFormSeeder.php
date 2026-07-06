<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicationForm;

class PersonnelCertificationBodiesFormSeeder extends Seeder
{
    public function run(): void
    {
        $json = json_decode(
            file_get_contents(database_path('json/personnel_certification_bodies.json')),
            true
        );

        ApplicationForm::updateOrCreate(
            ['slug' => 'personnel-certification-bodies'],
            [
                'application_name' => 'Personnel Certification Bodies',
                'description'      => 'Personnel Certification Bodies Application',
                'status'           => 1,
                'form_schema'      => $json,
            ]
        );
    }
}
