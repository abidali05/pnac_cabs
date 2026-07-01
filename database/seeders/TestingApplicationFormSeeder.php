<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicationForm;

class TestingApplicationFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = [
            'sections' => [
                [
                    'title' => 'Basic Information',
                    'fields' => [
                        [
                            'label' => 'Organization',
                            'name' => 'organization',
                            'type' => 'text'
                        ]
                    ]
                ]
            ]
        ];

        ApplicationForm::updateOrCreate(
            [
                'slug' => 'testing'
            ],
            [
                'application_name' => 'Testing',
                'description' => 'Testing Application',
                'status' => 1,
                'form_schema' => $json
            ]
        );
    }
}
