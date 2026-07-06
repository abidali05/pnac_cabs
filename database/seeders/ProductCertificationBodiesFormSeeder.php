<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicationForm;

class ProductCertificationBodiesFormSeeder extends Seeder
{
    public function run(): void
    {
        $json = json_decode(
            file_get_contents(database_path('json/product_certification_bodies.json')),
            true
        );

        ApplicationForm::updateOrCreate(
            ['slug' => 'product-certification-bodies'],
            [
                'application_name' => 'Product Certification Bodies',
                'description'      => 'Product Certification Bodies Application',
                'status'           => 1,
                'form_schema'      => $json,
            ]
        );
    }
}
