<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TestingApplicationFormSeeder::class);
        $this->call(ProficiencyTestProviderFormSeeder::class);
        $this->call(ProductCertificationBodiesFormSeeder::class);
        $this->call(PersonnelCertificationBodiesFormSeeder::class);
    }
}
