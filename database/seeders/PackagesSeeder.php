<?php

namespace Database\Seeders;

use App\Models\Packages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seedData = [
            [
                "national_code" => "BSB",
                "title" => "Business Services Training Package",
                "tga_status" => "current",
            ],
            [
                "national_code" => "CUA",
                "title" => "Creative Arts and Culture Training Package",
                "tga_status" => "current",
            ],
            [
                "national_code" => "FNS",
                "title" => "Financial Services Training Package",
                "tga_status" => "current",
            ],
            [
                "national_code" => 'ICT',
                "title" => "Information and Communications Technology",
                "tga_status" => "current",
            ],
            ];

        $this->command->getOutput()->info("Shuffling Packages");
        shuffle($seedData);
        $this->command->getOutput()->info("Shuffling Complete");

        $numRecords = count($seedData);
        $this->command->getOutput()->progressStart($numRecords);

        foreach ($seedData as $newPackage) {
            Packages::create($newPackage);
            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();

    }
}
